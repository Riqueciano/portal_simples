<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Entidade_tecnico_model extends CI_Model {

    public $table = 'sigater_indireta.entidade_tecnico';
    public $id = 'entidade_tecnico_id';
    public $order = 'DESC';

    function __construct() {
        parent::__construct();
    }

    // get all
    function get_all() {
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id) {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL) {
        /* ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado */
        $this->db->ilike('sigater_indireta.entidade_tecnico.entidade_tecnico_id', $q);
        $this->db->or_ilike('entidade_tecnico.entidade_id', $q);
        $this->db->or_ilike('entidade_tecnico.tecnico_cpf', $q);
        $this->db->or_ilike('entidade_tecnico.tecnico_email', $q);
        $this->db->or_ilike('entidade_tecnico.pessoa_id', $q);
        $this->db->or_ilike('entidade_tecnico.flag_ativo', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $param) {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);

        
        if ($param != null) {
            $this->db->where($param);
        }

        $this->db->join('dados_unico.pessoa', 'entidade_tecnico.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('sigater_indireta.entidade', 'entidade_tecnico.entidade_id = entidade.entidade_id', 'INNER');
        $this->db->join('sigater_indireta.lote', 'entidade_tecnico.lote_id = lote.lote_id', 'INNER');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
        echo_pre($this->db->last_query());
    }

    function get_all_data($param, $order = null) {

        $this->db->select('*');

        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .= " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->join('dados_unico.pessoa', 'entidade_tecnico.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('sigater_indireta.entidade', 'entidade_tecnico.entidade_id = entidade.entidade_id', 'INNER');
        $this->db->join('sigater_indireta.lote', 'entidade_tecnico.lote_id = lote.lote_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
        echo $this->db->last_query();
    }
    function get_all_data_row($param, $order = null) {

        $this->db->select('*');

        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .= " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->join('dados_unico.pessoa', 'entidade_tecnico.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('sigater_indireta.entidade', 'entidade_tecnico.entidade_id = entidade.entidade_id', 'INNER');
        $this->db->join('sigater_indireta.lote', 'entidade_tecnico.lote_id = lote.lote_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->row();
        echo $this->db->last_query();
    }

// end get_all_data

    function insert($data) {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data) {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id) {
        $this->db->where($this->id, $id);

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }

    function INATIVA($id) {
        $this->db->where($this->id, $id);

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }

}

/* Final do arquivo Entidade_tecnico_model.php */
/* Local: ./application/models/Entidade_tecnico_model.php */
/* Data - 2017-02-16 14:54:40 */