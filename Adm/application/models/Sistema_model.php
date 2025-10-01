<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sistema_model extends CI_Model
{

    public $table = 'seguranca.sistema';
    public $id = 'sistema_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all($pessoa_id = 0)
    {

        $this->db->select("
                            *,
                            ( 
                                select tu.tipo_usuario_id from seguranca.tipo_usuario tu
                                    inner join seguranca.usuario_tipo_usuario utu
                                            on tu.tipo_usuario_id = utu.tipo_usuario_id 
                                     where tu.sistema_id = sistema.sistema_id
                                       and pessoa_id = $pessoa_id       
                                ) as acesso_tipo_usuario_id
                            ,( 
                                select usuario_super_secretaria from seguranca.tipo_usuario tu
                                    inner join seguranca.usuario_tipo_usuario utu
                                            on tu.tipo_usuario_id = utu.tipo_usuario_id 
                                     where tu.sistema_id = sistema.sistema_id
                                       and pessoa_id = $pessoa_id       
                                ) as usuario_super_secretaria
                        ");



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
        // @$this->db->ilike('seguranca.sistema.sistema_id', $q);
        @$this->db->ilike('sistema.sistema_nm', $q);
        $this->db->or_ilike('sistema.sistema_ds', $q);
        // $this->db->or_ilike('sistema.sistema_icone', $q);
        // $this->db->or_ilike('sistema.sistema_st', $q);
        // $this->db->or_ilike('sistema.sistema_dt_criacao', $q);
        // $this->db->or_ilike('sistema.sistema_dt_alteracao', $q);
        // $this->db->or_ilike('sistema.sistema_url', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $param = null)
    {
        // echo  $param;
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        // @$this->db->ilike('sistema.sistema_id', $q);
        // $this->db->ilike('sistema.sistema_nm', $q);
        // $this->db->or_ilike('sistema.sistema_ds', $q);
        // $this->db->or_ilike('sistema.sistema_icone', $q);
        // $this->db->or_ilike('sistema.sistema_st', $q);
        // $this->db->or_ilike('sistema.sistema_dt_criacao', $q);
        // $this->db->or_ilike('sistema.sistema_dt_alteracao', $q);
        // $this->db->or_ilike('sistema.sistema_url', $q);
        if (!empty($param)) {
            $this->db->where($param);
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

/* Final do arquivo Sistema_model.php */
/* Local: ./application/models/Sistema_model.php */
/* Data - 2020-01-13 10:59:29 */