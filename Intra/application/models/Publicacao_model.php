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

    function get_all_data_param($param, $order = null, $limit = null)
    {

        $this->db->select('*');

        if ($limit != null) {
            $this->db->limit($limit);
        }

        $this->db->where($param);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
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
        $this->db->ilike('intranet.publicacao.publicacao_id', $q);
        $this->db->or_ilike('publicacao.publicacao_titulo', $q);
        $this->db->or_ilike('publicacao.publicacao_dt_publicacao', $q);
        $this->db->or_ilike('publicacao.publicacao_img', $q);
        $this->db->or_ilike('publicacao.publicacao_corpo', $q);
        $this->db->or_ilike('publicacao.publicacao_st', $q);
        $this->db->or_ilike('publicacao.publicacao_dt_criacao', $q);
        $this->db->or_ilike('publicacao.publicacao_dt_alteracao', $q);
        $this->db->or_ilike('publicacao.publicacao_tipo', $q);
        $this->db->or_ilike('publicacao.publicacao_link', $q);
        $this->db->or_ilike('publicacao.ativo', $q);
        $this->db->or_ilike('publicacao.flag_carrossel', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('publicacao.publicacao_id', $q);
        $this->db->or_ilike('publicacao.publicacao_titulo', $q);
        $this->db->or_ilike('publicacao.publicacao_dt_publicacao', $q);
        $this->db->or_ilike('publicacao.publicacao_img', $q);
        $this->db->or_ilike('publicacao.publicacao_corpo', $q);
        $this->db->or_ilike('publicacao.publicacao_st', $q);
        $this->db->or_ilike('publicacao.publicacao_dt_criacao', $q);
        $this->db->or_ilike('publicacao.publicacao_dt_alteracao', $q);
        $this->db->or_ilike('publicacao.publicacao_tipo', $q);
        $this->db->or_ilike('publicacao.publicacao_link', $q);
        $this->db->or_ilike('publicacao.ativo', $q);
        $this->db->or_ilike('publicacao.flag_carrossel', $q);
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

/* Final do arquivo Publicacao_model.php */
/* Local: ./application/models/Publicacao_model.php */
/* Data - 2024-05-15 16:05:49 */