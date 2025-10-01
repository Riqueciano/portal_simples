<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acompanhamento_model extends CI_Model
{

    public $table = 'cotacao.acompanhamento';
    public $id = 'acompanhamento_id';
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
        $this->db->ilike('cotacao.acompanhamento.acompanhamento_id', $q);
        $this->db->or_ilike('acompanhamento.pessoa_id', $q);
        $this->db->or_ilike('acompanhamento.seguindo_pessoa_id', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $param = null)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        
        if($q != null){
            $this->db->ilike('acompanhamento.acompanhamento_id', $q);
            $this->db->or_ilike('acompanhamento.pessoa_id', $q);
            $this->db->or_ilike('acompanhamento.seguindo_pessoa_id', $q);
        }

        $this->db->join('dados_unico.pessoa', 'acompanhamento.pessoa_id = pessoa.pessoa_id', 'LEFT');
        $this->db->join('dados_unico.pessoa as p2', 'acompanhamento.seguindo_pessoa_id = p2.pessoa_id', 'LEFT');

        if ($param != null) {
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
        $this->db->join('dados_unico.pessoa as p3', 'acompanhamento.pessoa_id = p3.pessoa_id', 'INNER');
        $this->db->join('dados_unico.pessoa as p4', 'acompanhamento.seguindo_pessoa_id = p4.pessoa_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data



    function get_all_data_param($param = null, $order = null)
    {

        $this->db->select('*');


        $this->db->join('dados_unico.pessoa as p5', 'acompanhamento.pessoa_id = p5.pessoa_id', 'INNER');
        $this->db->join('dados_unico.pessoa as p6', 'acompanhamento.seguindo_pessoa_id = p6.pessoa_id', 'INNER');
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

/* Final do arquivo Acompanhamento_model.php */
/* Local: ./application/models/Acompanhamento_model.php */
/* Data - 2024-10-31 13:13:11 */