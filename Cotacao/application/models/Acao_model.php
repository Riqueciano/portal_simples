<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acao_model extends CI_Model
{

    public $table = 'seguranca.acao';
    public $id = 'acao_id';
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
        /*ilike, or_ilike, or_not_ilike, not_ilike fun��es n�o s�o nativa do CI, adaptada para o Collate do PG utilizado*/

        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $param = null)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);

        $this->db->join('seguranca.secao', 'acao.secao_id = secao.secao_id', 'INNER');
        $this->db->join('seguranca.sistema', 'sistema.sistema_id = secao.sistema_id', 'INNER');
        $this->db->where('1=1 ' . $param);
        $this->db->limit($limit, $start);
        return  $this->db->get($this->table)->result();
        // echo_pre($this->db->last_query());
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
        $this->db->join('seguranca.secao', 'acao.secao_id = secao.secao_id', 'INNER');
        $this->db->join('seguranca.sistema', 'sistema.sistema_id = secao.sistema_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        $this->db->get($this->table)->result();
        echo_pre($this->db->last_query());
    } // end get_all_data
    function get_all_param($where, $order = null)
    {

        $this->db->select('*');


        $this->db->join('seguranca.secao', 'acao.secao_id = secao.secao_id', 'INNER');
        $this->db->join('seguranca.sistema', 'sistema.sistema_id = secao.sistema_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
        // echo_pre($this->db->last_query());
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
   /*function delete($id)
    {
        $this->db->where($this->id, $id);

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }*/
}

/* Final do arquivo Acao_model.php */
/* Local: ./application/models/Acao_model.php */
/* Data - 2020-01-13 15:19:44 */