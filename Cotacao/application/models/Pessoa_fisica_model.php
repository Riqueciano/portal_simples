<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pessoa_fisica_model extends CI_Model
{

    public $table = 'dados_unico.pessoa_fisica';
    public $id = 'pessoa_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->table.'.'.$this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get all for combobox 
    function get_all_combobox($param = null, $order = null)
    {
        $this->db->select("$this->id as id, $this->id as text");
        if(!empty($param)){
            $this->db->where($param);
        }
        if(!empty($order)){
            $this->db->order_by($order);
        }else{
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
    function total_rows($q = NULL) {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        $this->db->ilike('dados_unico.pessoa_fisica.pessoa_id', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_sexo', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_cpf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_dt_nasc', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_rg', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_rg_orgao', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_rg_uf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_rg_dt', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_passaporte', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_nm_pai', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_nm_mae', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_grupo_sanguineo', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_nacionalidade', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_naturalidade', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_naturalidade_uf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_clt', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_clt_serie', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_clt_uf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_titulo', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_titulo_zona', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_titulo_secao', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_titulo_cidade', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_titulo_uf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_cnh', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_cnh_categoria', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_cnh_validade', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_reservista', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_reservista_ministerio', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_reservista_uf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_pis', $q);
	$this->db->or_ilike('pessoa_fisica.estado_civil_id', $q);
	$this->db->or_ilike('pessoa_fisica.nivel_escolar_id', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_funcionario', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_cnh_lente_corretiva', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_filho', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_filha', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_apelido', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_foto', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_st_site', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_represen', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_represen_desc', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_ano_ingresso', $q);
	$this->db->or_ilike('pessoa_fisica.area_profissional_id', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_id', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('*');
        $this->db->order_by($this->table.'.'.$this->id, $this->order);
        $this->db->ilike('pessoa_fisica.pessoa_id', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_sexo', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_cpf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_dt_nasc', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_rg', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_rg_orgao', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_rg_uf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_rg_dt', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_passaporte', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_nm_pai', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_nm_mae', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_grupo_sanguineo', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_nacionalidade', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_naturalidade', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_naturalidade_uf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_clt', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_clt_serie', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_clt_uf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_titulo', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_titulo_zona', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_titulo_secao', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_titulo_cidade', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_titulo_uf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_cnh', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_cnh_categoria', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_cnh_validade', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_reservista', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_reservista_ministerio', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_reservista_uf', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_pis', $q);
	$this->db->or_ilike('pessoa_fisica.estado_civil_id', $q);
	$this->db->or_ilike('pessoa_fisica.nivel_escolar_id', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_funcionario', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_cnh_lente_corretiva', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_filho', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_filha', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_apelido', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_foto', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_st_site', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_represen', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_represen_desc', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_ano_ingresso', $q);
	$this->db->or_ilike('pessoa_fisica.area_profissional_id', $q);
	$this->db->or_ilike('pessoa_fisica.pessoa_fisica_id', $q);
	$this->db->join('dados_unico.estado_civil','pessoa_fisica.estado_civil_id = estado_civil.estado_civil_id', 'INNER');
	$this->db->join('dados_unico.nivel_escolar','pessoa_fisica.nivel_escolar_id = nivel_escolar.nivel_escolar_id', 'INNER');
	$this->db->join('dados_unico.pessoa','pessoa_fisica.pessoa_id = pessoa.pessoa_id', 'INNER');
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    
            function get_all_data($param,$order=null) {
        
                $this->db->select('*');
              
                        $where = '1=1 ';
                    foreach ($param as $array) {
                        //se tiver parametro
                        if($array[2] != ''){
                                $where .=  " and ".$array[0]." ". $array[1] ." '".$array[2]."' ";
                            }
                    }
	$this->db->join('dados_unico.estado_civil','pessoa_fisica.estado_civil_id = estado_civil.estado_civil_id', 'INNER');
	$this->db->join('dados_unico.nivel_escolar','pessoa_fisica.nivel_escolar_id = nivel_escolar.nivel_escolar_id', 'INNER');
	$this->db->join('dados_unico.pessoa','pessoa_fisica.pessoa_id = pessoa.pessoa_id', 'INNER'); 
                 $this->db->where($where); 
                 $this->db->order_by($order);  
                 return $this->db->get($this->table)->result();
         }// end get_all_data
         

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
        
        if(!$this->db->delete($this->table)){
            return 'erro_dependencia';
        }
    }

}

/* Final do arquivo Pessoa_fisica_model.php */
/* Local: ./application/models/Pessoa_fisica_model.php */
/* Data - 2024-01-24 18:46:12 */