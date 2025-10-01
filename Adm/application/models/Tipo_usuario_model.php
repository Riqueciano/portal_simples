<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tipo_usuario_model extends CI_Model
{

    public $table = 'seguranca.tipo_usuario';
    public $id = 'tipo_usuario_id';
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

        @$this->db->ilike('tipo_usuario.tipo_usuario_ds', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }



    function get_pessoa_perfil($tipo_usuario_id)
    {
        $sql = "
     
     select distinct * from (
                                    select 
                                                    vp.pessoa_nm
                                                    , vp.pessoa_id
                                                    , vp.funcionario_email
                                                    , est_organizacional_sigla
                                                    , usuario_login
                                                    , p.pessoa_st
                                                    , telefone 
                                                from vi_login vl
                                                left join vi_pessoa_todos vp 
                                                    on vp.pessoa_id = vl.pessoa_id
                                                inner join dados_unico.pessoa p
                                                    on p.pessoa_id = vp.pessoa_id    
                                            where vl.tipo_usuario_id = $tipo_usuario_id 
                                                    and vp.pessoa_nm is not null 
                                                order by unidade_orcamentaria_id asc,  p.pessoa_st,vl.pessoa_nm asc
                             ) as con                  
    ";

    // echo_pre($sql);

        return $this->db->query($sql)->result();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $filtro_sistema_id=null)
    {



        $this->db->select('*
        
        ,
        , (select count(distinct pessoa_id) from vi_login v 
                        where v.sistema_id = sistema.sistema_id 
                                and v.tipo_usuario_id = tipo_usuario.tipo_usuario_id
                                ) as qtd_pessoas_perfil
        
        ');


        $this->db->order_by($this->table . '.' . $this->id, $this->order);

        @$this->db->ilike('tipo_usuario.tipo_usuario_ds', $q);
        $this->db->join('seguranca.sistema', 'tipo_usuario.sistema_id = sistema.sistema_id', 'INNER');

        if (!empty($filtro_sistema_id)) {
            $this->db->where('sistema.sistema_id = ' . $filtro_sistema_id);
        }

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
        $this->db->join('seguranca.sistema', 'tipo_usuario.sistema_id = sistema.sistema_id', 'INNER');
        $this->db->where($where);
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

/* Final do arquivo Tipo_usuario_model.php */
/* Local: ./application/models/Tipo_usuario_model.php */
/* Data - 2020-01-14 13:36:34 */