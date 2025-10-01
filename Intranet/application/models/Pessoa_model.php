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



    function get_by_email($email)
    {
        $sql = "select * from vi_login where funcionario_email ilike '$email'  limit 1";
        return $this->db->query($sql)->row();
    }


    function get_perfil_nome($pessoa_id, $sistema_id)
    {
        $sql = "select * from vi_login where pessoa_id = $pessoa_id and sistema_id = $sistema_id";
        // echo_pre($sql);
        return $this->db->query($sql)->row();
    }
    function get_perfil_nome_simples($pessoa_id, $sistema_id)
    {
        $sql = "

            select * from seguranca.usuario_tipo_usuario utu
                inner join  seguranca.tipo_usuario tu
                on tu.tipo_usuario_id = utu.tipo_usuario_id
	            where utu.pessoa_id = $pessoa_id and tu.sistema_id = $sistema_id limit 1";
        //echo_pre($sql);
        return $this->db->query($sql)->row();
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
        echo_pre($this->db->last_query());
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where('pessoa.pessoa_id', $id);
        $this->db->join('dados_unico.funcionario as f', 'f.pessoa_id = pessoa.pessoa_id', 'inner');
        return $this->db->get($this->table)->row();
    }


    function get_usuario_pessoa($pessoa_id = null)
    {
        $param = "";
        if (!empty($pessoa_id)) {
            $param = " where p.pessoa_id = $pessoa_id";
        }
        $sql = "
                    select 
                            l.pessoa_id, usuario_login, usuario_senha, v.pessoa_nm
                    from vi_login l
                    inner join vi_pessoa_unidade_orcamentaria2 p
                        on p.pessoa_id = l.pessoa_id
                        
                        $param 
                    order by p.pessoa_id	";

        return $this->db->query($sql)->result();
    }
    /*

SELECT
        *, p.pessoa_id as pes_id
        , e.municipio_id as empresa_municipio_id
        , (select grupo_entrevistador_id from questionario.grupo_entrevistador_pessoa gep
                                where gep.pessoa_id = p.pessoa_id limit 1) as grupo_entrevistador_id
                                
       ,( select '('||trim(telefone_ddd)||') '||trim(telefone_num) as tel from dados_unico.telefone t2
			where t2.telefone_tipo = 'C' and t2.pessoa_id = p.pessoa_id limit 1) as telefone_num
                        
,(select me2.municipio_id from monitoramento_semaf.municipio_executor me2 where me2.pessoa_id = p.pessoa_id limit 1)  as executa_municipio_id              
,f.est_organizacional_lotacao_id   
,(SELECT eol.est_organizacional_lotacao_sigla from dados_unico.est_organizacional_lotacao eol
                    where eol.est_organizacional_lotacao_id = f.est_organizacional_lotacao_id limit 1) as est_organizacional_lotacao_sigla
FROM
        dados_unico.pessoa p
            LEFT OUTER JOIN seguranca.usuario u 
                    ON (p.pessoa_id = u.pessoa_id)
            left join diaria.setaf s 
                    on s.setaf_id = p.setaf_id
            
            left join  f 
                    on 
            left join  t
                    on 
            left join  
                    on 
                

     */
    function get_by_id_super($id)
    {

        $this->db->select(" 
                                *   , pessoa.pessoa_id as pes_id
                                    , pessoa.pessoa_id  
                                    , e.municipio_id as empresa_municipio_id
                                     

                                    , ( select '('||trim(telefone_ddd)||') '||trim(telefone_num) as tel from dados_unico.telefone t2
                                                    where t2.telefone_tipo = 'C' and t2.pessoa_id = pessoa.pessoa_id limit 1) as telefone_num

                                    , f.est_organizacional_lotacao_id   
                                    , (SELECT eol.est_organizacional_lotacao_sigla from dados_unico.est_organizacional_lotacao eol
                                                where eol.est_organizacional_lotacao_id = f.est_organizacional_lotacao_id limit 1) as est_organizacional_lotacao_sigla
                        
                                   , (select v2.est_organizacional_id from vi_pessoa_unidade_orcamentaria2 v2 where v2.pessoa_id = pessoa.pessoa_id limit 1) as est_organizacional_id            
                                   , (select v2.est_organizacional_sigla from vi_pessoa_unidade_orcamentaria2 v2 where v2.pessoa_id = pessoa.pessoa_id limit 1) as est_organizacional_sigla            
                                   , (select v2.unidade_orcamentaria_id from vi_pessoa_unidade_orcamentaria2 v2 where v2.pessoa_id = pessoa.pessoa_id limit 1) as unidade_orcamentaria_id            
                                   , (select v2.unidade_orcamentaria_nm from vi_pessoa_unidade_orcamentaria2 v2 where v2.pessoa_id = pessoa.pessoa_id limit 1) as unidade_orcamentaria_nm            
               
               
               ,(SELECT l.lote_nm FROM sigater_indireta.lote_tecnico lt
                        inner join sigater_indireta.lote l
                            on l.lote_id = lt.lote_id
               where lt.tecnico_pessoa_id = pessoa.pessoa_id  and lt.flag_ativo = 1 
               order by lt.lote_tecnico_id desc
               limit 1) as tecnico_lote_nm
 

               ,(SELECT e.entidade_sigla FROM sigater_indireta.lote_tecnico lt
                        inner join sigater_indireta.lote l
                            on l.lote_id = lt.lote_id
                        inner join sigater_indireta.entidade e
                            on e.entidade_id = l.entidade_id    
               where lt.tecnico_pessoa_id = pessoa.pessoa_id  and lt.flag_ativo = 1 
               order by lt.lote_tecnico_id desc
               limit 1) as entidade_sigla
               
                                   ");



        $this->db->join('seguranca.usuario as u', 'u.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('diaria.setaf as s', 's.setaf_id = pessoa.setaf_id', 'LEFT');
        $this->db->join('dados_unico.funcionario f', 'pessoa.pessoa_id = f.pessoa_id and f.funcionario_st=0', 'LEFT');
        $this->db->join('sigater_indireta.entidade_tecnico et', 'et.pessoa_id = pessoa.pessoa_id', 'LEFT');
        $this->db->join('sigater_dados.empresa e', 'e.empresa_id = pessoa.empresa_id', 'LEFT');
        $this->db->where("pessoa.pessoa_id = $id and pessoa.pessoa_st = 0"); //apenas pessoas ativas 
        return $this->db->get($this->table)->row();
        echo_pre($this->db->last_query());
        exit;
    }

    // get total rows
    function total_rows($q = NULL)
    {
        /* ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado */
        @$this->db->ilike('dados_unico.pessoa.pessoa_id', $q);
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        @$this->db->ilike('pessoa.pessoa_id', $q);
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
                $where .= " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    }

    // end get_all_data

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


    function get_perfil($pessoa_id)
    {

        $this->db->select('*');

        $this->db->where("pessoa_id = $pessoa_id");

        return $this->db->get("vi_login")->result();
        echo_pre($this->db->last_query());
    }

    function get_aniversariantes_mes_15($dia, $mes, $complemento = null)
    {
        // echo $mes;


        $dia_antes = $dia == 1 ? 1 : ($dia - 1);

        $sql = "
            select distinct  UPPER(est_organizacional_sigla),
                            pf.pessoa_fisica_dt_nasc
                            ,p.pessoa_nm
                            , substring(pessoa_fisica_dt_nasc,1,2) as dia
                            , substring(pessoa_fisica_dt_nasc,4,2) as mes
                            , substring(pessoa_fisica_dt_nasc,7,4) as ano
                            ,pessoa_fisica_dt_nasc 
                            ,funcionario_email
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
               and pessoa_fisica_dt_nasc is not null and pessoa_fisica_dt_nasc !=''
               and substring(pessoa_fisica_dt_nasc,4,2)::int >= " . ((int)$mes) . " 
               and substring(pessoa_fisica_dt_nasc,1,2)::int >= " . ((int)$mes - 1) . " 
               and length(pessoa_fisica_dt_nasc) = 10 
             
               and pessoa_fisica_dt_nasc not ilike '%-%'
               and substring(pessoa_fisica_dt_nasc,0,3)::int >= $dia_antes    
               and funcionario_tipo_id in (11,1,7,2,3)
               and substring(pessoa_fisica_dt_nasc,4,2)::int = $mes
               and substring(pessoa_fisica_dt_nasc,4,2)::int >= " . ($mes - 1) . " 
            order by substring(pessoa_fisica_dt_nasc,1,2) 
            limit 15 
                                
                 
                ";
        //echo_pre($sql);exit;
        return $this->db->query($sql)->result();
    }

    function get_aniversariantes_mes($dia, $mes, $complemento = null)
    {
        // echo $mes;


        $dia_antes = $dia == 1 ? 1 : ($dia - 1);

        $sql = "
            select distinct UPPER(est_organizacional_sigla),
                            pf.pessoa_fisica_dt_nasc
                            ,p.pessoa_nm
                            , substring(pessoa_fisica_dt_nasc,1,2) as dia
                            , substring(pessoa_fisica_dt_nasc,4,2) as mes
                            , substring(pessoa_fisica_dt_nasc,7,4) as ano
                            ,pessoa_fisica_dt_nasc 
                            ,funcionario_email
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
               and pessoa_fisica_dt_nasc is not null and pessoa_fisica_dt_nasc !=''
               and substring(pessoa_fisica_dt_nasc,4,2)::int >= " . ((int)$mes) . " 
               and substring(pessoa_fisica_dt_nasc,1,2)::int >= " . ((int)$mes - 1) . " 
               and length(pessoa_fisica_dt_nasc) = 10 
               
               and pessoa_fisica_dt_nasc not ilike '%-%'
              /* and substring(pessoa_fisica_dt_nasc,0,3)::int >= $dia_antes*/
               and funcionario_tipo_id in (11,1,7,2,3)
               and substring(pessoa_fisica_dt_nasc,4,2)::int = $mes
               and substring(pessoa_fisica_dt_nasc,4,2)::int >= " . ($mes - 1) . " 
               order by substring(pessoa_fisica_dt_nasc,1,2)                             
                ";
        //echo_pre($sql);
        return $this->db->query($sql)->result();
    }
}

/* Final do arquivo Pessoa_model.php */
/* Local: ./application/models/Pessoa_model.php */
/* Data - 2019-09-20 14:44:56 */