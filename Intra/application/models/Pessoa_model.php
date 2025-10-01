<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Pessoa_model extends CI_Model
{

	public $table = 'dados_unico.pessoa';
	public $id = 'pessoa_id';
	public $order = 'DESC';

	function __construct()
	{
		parent::__construct();
	}

	function get_colaboradores($buscador)
	{
		$sql = "

select 
v.pessoa_id,
v.pessoa_nm,
v.est_organizacional_sigla,
v.telefone,
p.pessoa_ramal,
v.funcionario_email


from vi_pessoa v
	inner join dados_unico.funcionario f 
	   on f.pessoa_id = v.pessoa_id 
	   inner join dados_unico.pessoa p
		on p.pessoa_id = v.pessoa_id
	
	where f.funcionario_tipo_id in (11,1,7,2,12,3)
	and 
			(v.pessoa_nm ilike '%$buscador%'
				or est_organizacional_sigla  ilike '%$buscador%'
			)
	 
";

		return $this->db->query($sql)->result();
	}


	function get_colaboradores_old($buscador)
	{
		$sql = "

select * from vi_pessoa v
	inner join dados_unico.funcionario f 
	   on f.pessoa_id = v.pessoa_id 
	
	where f.funcionario_tipo_id in (11,1,7,2,12,3)
	and 
			(v.pessoa_nm ilike '%$buscador%'
				or est_organizacional_sigla  ilike '%$buscador%'
			)
	 
";

		return $this->db->query($sql)->result();
	}



	function get_aniversariantes_mes($dia, $mes, $complemento = null, $limit = 9999999)
	{
		// echo $mes;


		$dia_antes = $dia == 1 ? 1 : ($dia - 1);

		$sql = "
            select distinct UPPER(est_organizacional_sigla) as est_organizacional_sigla,
                            pf.pessoa_fisica_dt_nasc
                            ,p.pessoa_nm
                            , substring(pessoa_fisica_dt_nasc,1,2) as dia
                            , substring(pessoa_fisica_dt_nasc,4,2) as mes
                            , substring(pessoa_fisica_dt_nasc,7,4) as ano
                            ,pessoa_fisica_dt_nasc 
               from dados_unico.funcionario f
            inner join dados_unico.pessoa p 
                on p.pessoa_id = f.pessoa_id
            inner join dados_unico.pessoa_fisica pf 
                on p.pessoa_id = pf.pessoa_id
            inner join dados_unico.est_organizacional_funcionario eof 
                on eof.funcionario_id= f.funcionario_id and est_organizacional_funcionario_st =0
            inner join dados_unico.est_organizacional eo 
                on eo.est_organizacional_id = eof.est_organizacional_id
               
            where p.pessoa_st =0 and funcionario_st = 0
			   and funcionario_tipo_id in (11,1,7,2,3)
               and pessoa_fisica_dt_nasc is not null and pessoa_fisica_dt_nasc !=''
               and substring(pessoa_fisica_dt_nasc,4,2)::int >= " . ((int)$mes) . " 
               and substring(pessoa_fisica_dt_nasc,1,2)::int >= " . ((int)$mes - 1) . " 
               and length(pessoa_fisica_dt_nasc) = 10 
               
               and pessoa_fisica_dt_nasc not ilike '%-%'
              /* and substring(pessoa_fisica_dt_nasc,0,3)::int >= $dia_antes*/
               
               and substring(pessoa_fisica_dt_nasc,4,2)::int = $mes
               and substring(pessoa_fisica_dt_nasc,4,2)::int >= " . ($mes - 1) . " 
               order by dia, mes 
			   
			   limit $limit
                ";
		// echo_pre($sql);
		return @$this->db->query($sql)->result();
	}
	function get_aniversariantes_mes_lista($dia, $mes, $mes_fim = null, $complemento = null, $limit = 9999999)
	{
		// echo $mes;


		$dia_antes = $dia == 1 ? 1 : ($dia - 1);

		$mes_fim = empty($mes_fim) ? $mes : $mes_fim;

		$sql = "
       SELECT *
					FROM (
						SELECT 
							UPPER(est_organizacional_sigla) AS est_organizacional_sigla,
							TO_DATE(pessoa_fisica_dt_nasc, 'DD/MM/YYYY') AS dt_nasc,
							p.pessoa_nm,
							SUBSTRING(pessoa_fisica_dt_nasc,1,2) AS dia,
							SUBSTRING(pessoa_fisica_dt_nasc,4,2) AS mes,
							SUBSTRING(pessoa_fisica_dt_nasc,7,4) AS ano,
							f.funcionario_email
						FROM dados_unico.funcionario f
						INNER JOIN dados_unico.pessoa p 
							ON p.pessoa_id = f.pessoa_id
						INNER JOIN dados_unico.pessoa_fisica pf 
							ON p.pessoa_id = pf.pessoa_id
						INNER JOIN dados_unico.est_organizacional_funcionario eof 
							ON eof.funcionario_id = f.funcionario_id AND est_organizacional_funcionario_st = 0
						INNER JOIN dados_unico.est_organizacional eo 
							ON eo.est_organizacional_id = eof.est_organizacional_id
						WHERE 
							p.pessoa_st = 0 
							AND funcionario_tipo_id IN (11,1,7,2,3)
							AND funcionario_st = 0
							AND pessoa_fisica_dt_nasc IS NOT NULL 
							AND pessoa_fisica_dt_nasc != ''
							AND LENGTH(pessoa_fisica_dt_nasc) = 10
							AND pessoa_fisica_dt_nasc !~ '-' -- sem hífen
							AND pessoa_fisica_dt_nasc ~ '^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/([0-9]{4})$' -- formato DD/MM/YYYY válido
							AND CAST(SUBSTRING(pessoa_fisica_dt_nasc, 4, 2) AS INT) >= $mes
							AND CAST(SUBSTRING(pessoa_fisica_dt_nasc, 4, 2) AS INT) <= $mes_fim
							
					) AS dados
			ORDER BY mes::int, dia::int
			LIMIT $limit;
		";
	//   echo_pre($sql);exit;
	return @$this->db->query($sql)->result();
	}
	function get_aniversariantes_hoje()
	{
		// echo $mes;


		$dia_antes = $dia == 1 ? 1 : ($dia - 1);

		$mes_fim = empty($mes_fim) ? $mes : $mes_fim;

		$sql = "
           SELECT DISTINCT 
							UPPER(est_organizacional_sigla) AS est_organizacional_sigla,
							TO_DATE(pessoa_fisica_dt_nasc, 'DD/MM/YYYY') AS pessoa_fisica_dt_nasc,
							p.pessoa_nm,
							SUBSTRING(pessoa_fisica_dt_nasc,1,2) AS dia,
							SUBSTRING(pessoa_fisica_dt_nasc,4,2) AS mes,
							SUBSTRING(pessoa_fisica_dt_nasc,7,4) AS ano,
							f.funcionario_email
						FROM dados_unico.funcionario f
						INNER JOIN dados_unico.pessoa p 
							ON p.pessoa_id = f.pessoa_id
						INNER JOIN dados_unico.pessoa_fisica pf 
							ON p.pessoa_id = pf.pessoa_id
						INNER JOIN dados_unico.est_organizacional_funcionario eof 
							ON eof.funcionario_id = f.funcionario_id AND est_organizacional_funcionario_st = 0
						INNER JOIN dados_unico.est_organizacional eo 
							ON eo.est_organizacional_id = eof.est_organizacional_id
						WHERE 
							p.pessoa_st = 0 
							AND funcionario_st = 0
							AND pessoa_fisica_dt_nasc IS NOT NULL 
							AND pessoa_fisica_dt_nasc != ''
							AND LENGTH(pessoa_fisica_dt_nasc) = 10
							AND pessoa_fisica_dt_nasc !~ '-' -- sem hífen
							AND pessoa_fisica_dt_nasc ~ '^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/([0-9]{4})$' -- formato DD/MM/YYYY válido
							AND EXTRACT(MONTH FROM TO_DATE(pessoa_fisica_dt_nasc, 'DD/MM/YYYY')) = EXTRACT(MONTH FROM CURRENT_DATE)
							AND EXTRACT(DAY FROM TO_DATE(pessoa_fisica_dt_nasc, 'DD/MM/YYYY')) = EXTRACT(DAY FROM CURRENT_DATE)
							AND funcionario_tipo_id IN (11,1,7,2,3)
						ORDER BY pessoa_nm
						 ;



                ";
		//   echo_pre($sql);exit;
		return @$this->db->query($sql)->result();
	}


	// get all
	function get_all()
	{
		$this->db->order_by($this->table . '.' . $this->id, $this->order);
		return $this->db->get($this->table)->result();
	}

	// get all for combobox 
	function get_all_combobox($param = null, $order = null)
	{
		$this->db->select("$this->id as id, $this->id as text");
		if (!empty($param)) {
			$this->db->where($param);
		}
		if (!empty($order)) {
			$this->db->order_by($order);
		} else {
			$this->db->order_by($this->table . '.' . $this->id, 'asc');
		}

		return $this->db->get($this->table)->result();
	}

	// get data by id
	function get_by_id($id)
	{
		$this->db->where($this->id, $id);
		return $this->db->get($this->table)->row();
	}

	// get total rows
	function total_rows($q = NULL)
	{
		/*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
		$this->db->ilike('dados_unico.pessoa.pessoa_id', $q);
		$this->db->or_ilike('pessoa.pessoa_nm', $q);
		$this->db->or_ilike('pessoa.pessoa_tipo', $q);
		$this->db->or_ilike('pessoa.pessoa_email', $q);
		$this->db->or_ilike('pessoa.pessoa_st', $q);
		$this->db->or_ilike('pessoa.pessoa_dt_criacao', $q);
		$this->db->or_ilike('pessoa.pessoa_dt_alteracao', $q);
		$this->db->or_ilike('pessoa.pessoa_usuario_criador', $q);
		$this->db->or_ilike('pessoa.setaf_id', $q);
		$this->db->or_ilike('pessoa.ater_contrato_id', $q);
		$this->db->or_ilike('pessoa.lote_id', $q);
		$this->db->or_ilike('pessoa.flag_usuario_acervo_digital', $q);
		$this->db->or_ilike('pessoa.cpf_autor', $q);
		$this->db->or_ilike('pessoa.instituicao_autor', $q);
		$this->db->or_ilike('pessoa.semaf_municipio_id', $q);
		$this->db->or_ilike('pessoa.ppa_municipio_id', $q);
		$this->db->or_ilike('pessoa.empresa_id', $q);
		$this->db->or_ilike('pessoa.flag_cadastro_externo', $q);
		$this->db->or_ilike('pessoa.menipolicultor_territorio_id', $q);
		$this->db->or_ilike('pessoa.sipaf_municipio_id', $q);
		$this->db->or_ilike('pessoa.prefeito_municipio_id', $q);
		$this->db->or_ilike('pessoa.cartorio_municipio_id', $q);
		$this->db->or_ilike('pessoa.proposta_dupla_numero', $q);
		$this->db->or_ilike('pessoa.cotacao_territorio_id', $q);
		$this->db->or_ilike('pessoa.cotacao_municipio_id', $q);
		$this->db->or_ilike('pessoa.pessoa_cnpj', $q);
		$this->db->or_ilike('pessoa.pessoa_nm_fantasia', $q);
		$this->db->or_ilike('pessoa.pessoa_dap', $q);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	// get data with limit and search
	function get_limit_data($limit, $start = 0, $q = NULL)
	{
		$this->db->select('*');
		$this->db->order_by($this->table . '.' . $this->id, $this->order);
		$this->db->ilike('pessoa.pessoa_id', $q);
		$this->db->or_ilike('pessoa.pessoa_nm', $q);
		$this->db->or_ilike('pessoa.pessoa_tipo', $q);
		$this->db->or_ilike('pessoa.pessoa_email', $q);
		$this->db->or_ilike('pessoa.pessoa_st', $q);
		$this->db->or_ilike('pessoa.pessoa_dt_criacao', $q);
		$this->db->or_ilike('pessoa.pessoa_dt_alteracao', $q);
		$this->db->or_ilike('pessoa.pessoa_usuario_criador', $q);
		$this->db->or_ilike('pessoa.setaf_id', $q);
		$this->db->or_ilike('pessoa.ater_contrato_id', $q);
		$this->db->or_ilike('pessoa.lote_id', $q);
		$this->db->or_ilike('pessoa.flag_usuario_acervo_digital', $q);
		$this->db->or_ilike('pessoa.cpf_autor', $q);
		$this->db->or_ilike('pessoa.instituicao_autor', $q);
		$this->db->or_ilike('pessoa.semaf_municipio_id', $q);
		$this->db->or_ilike('pessoa.ppa_municipio_id', $q);
		$this->db->or_ilike('pessoa.empresa_id', $q);
		$this->db->or_ilike('pessoa.flag_cadastro_externo', $q);
		$this->db->or_ilike('pessoa.menipolicultor_territorio_id', $q);
		$this->db->or_ilike('pessoa.sipaf_municipio_id', $q);
		$this->db->or_ilike('pessoa.prefeito_municipio_id', $q);
		$this->db->or_ilike('pessoa.cartorio_municipio_id', $q);
		$this->db->or_ilike('pessoa.proposta_dupla_numero', $q);
		$this->db->or_ilike('pessoa.cotacao_territorio_id', $q);
		$this->db->or_ilike('pessoa.cotacao_municipio_id', $q);
		$this->db->or_ilike('pessoa.pessoa_cnpj', $q);
		$this->db->or_ilike('pessoa.pessoa_nm_fantasia', $q);
		$this->db->or_ilike('pessoa.pessoa_dap', $q);
		$this->db->join('diaria.setaf', 'pessoa.setaf_id = setaf.setaf_id', 'INNER');
		$this->db->join('indice.municipio', 'pessoa.cartorio_municipio_id = municipio.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m2', 'pessoa.cotacao_municipio_id = m2.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m3', 'pessoa.ppa_municipio_id = m3.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m4', 'pessoa.prefeito_municipio_id = m4.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m5', 'pessoa.semaf_municipio_id = m5.municipio_id', 'INNER');
		$this->db->join('indice.territorio', 'pessoa.cotacao_territorio_id = territorio.territorio_id', 'INNER');
		$this->db->join('indice.territorio as t2', 'pessoa.menipolicultor_territorio_id = t2.territorio_id', 'INNER');
		$this->db->join('sigater_dados.empresa', 'pessoa.empresa_id = empresa.empresa_id', 'INNER');
		$this->db->join('sigater_indireta-old.lote', 'pessoa.lote_id = lote.lote_id', 'INNER');
		$this->db->limit($limit, $start);
		return $this->db->get($this->table)->result();
	}

	function get_all_data($param, $order = null)
	{

		$this->db->select('*');

		$where = '1=1 ';
		foreach ($param as $array) {
			//se tiver parametro
			if ($array[2] != '') {
				$where .=  " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
			}
		}
		$this->db->join('diaria.setaf', 'pessoa.setaf_id = setaf.setaf_id', 'INNER');
		$this->db->join('indice.municipio', 'pessoa.cartorio_municipio_id = municipio.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m2', 'pessoa.cotacao_municipio_id = m2.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m3', 'pessoa.ppa_municipio_id = m3.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m4', 'pessoa.prefeito_municipio_id = m4.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m5', 'pessoa.semaf_municipio_id = m5.municipio_id', 'INNER');
		$this->db->join('indice.territorio', 'pessoa.cotacao_territorio_id = territorio.territorio_id', 'INNER');
		$this->db->join('indice.territorio as t2', 'pessoa.menipolicultor_territorio_id = t2.territorio_id', 'INNER');
		$this->db->join('sigater_dados.empresa', 'pessoa.empresa_id = empresa.empresa_id', 'INNER');
		$this->db->join('sigater_indireta-old.lote', 'pessoa.lote_id = lote.lote_id', 'INNER');
		$this->db->where($where);
		$this->db->order_by($order);
		return $this->db->get($this->table)->result();
	} // end get_all_data



	function get_all_data_param($param = null, $order = null)
	{

		$this->db->select('*');


		$this->db->join('diaria.setaf', 'pessoa.setaf_id = setaf.setaf_id', 'INNER');
		$this->db->join('indice.municipio', 'pessoa.cartorio_municipio_id = municipio.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m2', 'pessoa.cotacao_municipio_id = m2.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m3', 'pessoa.ppa_municipio_id = m3.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m4', 'pessoa.prefeito_municipio_id = m4.municipio_id', 'INNER');
		$this->db->join('indice.municipio as m5', 'pessoa.semaf_municipio_id = m5.municipio_id', 'INNER');
		$this->db->join('indice.territorio', 'pessoa.cotacao_territorio_id = territorio.territorio_id', 'INNER');
		$this->db->join('indice.territorio as t2', 'pessoa.menipolicultor_territorio_id = t2.territorio_id', 'INNER');
		$this->db->join('sigater_dados.empresa', 'pessoa.empresa_id = empresa.empresa_id', 'INNER');
		$this->db->join('sigater_indireta-old.lote', 'pessoa.lote_id = lote.lote_id', 'INNER');
		$this->db->where($param);
		$this->db->order_by($order);
		return $this->db->get($this->table)->result();
	} // end get_all_data


	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	// update data
	function update($id, $data)
	{
		$this->db->where($this->id, $id);
		$this->db->update($this->table, $data);
	}

	// delete data
	function delete($id)
	{
		$this->db->where($this->id, $id);

		if (!$this->db->delete($this->table)) {
			return 'erro_dependencia';
		}
	}
}

/* Final do arquivo Pessoa_model.php */
/* Local: ./application/models/Pessoa_model.php */
/* Data - 2024-05-20 21:05:03 */