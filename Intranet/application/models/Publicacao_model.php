<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Publicacao_model extends CI_Model
{

    public $table = 'intranet.publicacao';
    public $id = 'publicacao_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
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
        @$this->db->ilike('intranet.publicacao.publicacao_id', $q);
        $this->db->or_ilike('publicacao.publicacao_titulo', $q);
        $this->db->or_ilike('publicacao.publicacao_dt_publicacao', $q);
        $this->db->or_ilike('publicacao.publicacao_img', $q);
        $this->db->or_ilike('publicacao.publicacao_corpo', $q);
        $this->db->or_ilike('publicacao.publicacao_st', $q);
        $this->db->or_ilike('publicacao.publicacao_dt_criacao', $q);
        $this->db->or_ilike('publicacao.publicacao_dt_alteracao', $q);
        $this->db->or_ilike('publicacao.publicacao_tipo', $q);
        $this->db->or_ilike('publicacao.publicacao_link', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $ativo =0)
    {
        $this->db->select('*');
        
        $this->db->order_by($this->table . '.' . 'publicacao_id', 'desc'); 
        $where = '1=1';
        if(!empty($q)){ 
                    $where .= " and
                                 (publicacao.publicacao_titulo ilike '%$q%'
                                or 
                                publicacao.publicacao_corpo ilike '%$q%'

                                )         ";

                  
        }

        if($ativo != -1){
            $where .= " and publicacao.ativo = $ativo"; 
        }
       
        $this->db->where($where);
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
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data
    function get_publicacoes($param, $order = null)
    {

        $sql = "select  * from intranet.publicacao 

                        where publicacao_tipo = 1  and ativo =1
                        order by publicacao_dt_publicacao desc limit 7";

                        // echo_pre($sql);
        return $this->db->query($sql)->result();
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

/* Final do arquivo Publicacao_model.php */
/* Local: ./application/models/Publicacao_model.php */
/* Data - 2019-09-25 11:02:37 */