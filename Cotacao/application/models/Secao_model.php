<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Secao_model extends CI_Model
{

    public $table = 'seguranca.secao';
    public $id = 'secao_id';
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
        /* ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado */

        $this->db->ilike('secao.secao_ds', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);

        $this->db->ilike('sistema.sistema_nm', $q);
        $this->db->or_ilike('secao.secao_ds', $q);
        $this->db->join('seguranca.sistema', 'secao.sistema_id = sistema.sistema_id', 'INNER');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function get_limit_data_filtro_sistema($limit, $start = 0, $sistema_id_filtro = null)
    {
       
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);

        if (!empty($sistema_id_filtro)) {
            $this->db->where('sistema_st = 0 ' . ' and sistema.sistema_id = ', $sistema_id_filtro);
        }
        $this->db->join('seguranca.sistema', 'secao.sistema_id = sistema.sistema_id', 'INNER');
        $this->db->limit($limit, $start);
        $this->db->order_by('sistema.sistema_nm');
        return $this->db->get($this->table)->result();
        // echo_pre($this->db->last_query());
        // exit;
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
        $this->db->join('seguranca.sistema', 'secao.sistema_id = sistema.sistema_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return  $this->db->get($this->table)->result();
        // echo_pre($this->db->last_query());exit;
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
   /*function delete($id)
    {
        $this->db->where($this->id, $id);

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }*/
}

/* Final do arquivo Secao_model.php */
/* Local: ./application/models/Secao_model.php */
/* Data - 2020-01-13 11:14:12 */