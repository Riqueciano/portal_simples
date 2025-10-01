<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_tipo_usuario_model extends CI_Model {

    public $table = 'seguranca.usuario_tipo_usuario';
    public $id = 'pessoa_id';
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
        $this->db->ilike('seguranca.usuario_tipo_usuario.pessoa_id', $q);
        $this->db->or_ilike('usuario_tipo_usuario.tipo_usuario_id', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('usuario_tipo_usuario.pessoa_id', $q);
        $this->db->or_ilike('usuario_tipo_usuario.tipo_usuario_id', $q);
        $this->db->join('seguranca.tipo_usuario', 'usuario_tipo_usuario.tipo_usuario_id = tipo_usuario.tipo_usuario_id', 'INNER');
        $this->db->join('seguranca_old.tipo_usuario', 'usuario_tipo_usuario.tipo_usuario_id = tipo_usuario.tipo_usuario_id', 'INNER');
        $this->db->join('seguranca_vei.tipo_usuario', 'usuario_tipo_usuario.tipo_usuario_id = tipo_usuario.tipo_usuario_id', 'INNER');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function get_all_data($param, $order = null) {

        $this->db->distinct();
        $this->db->select('*');

        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .= " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->join('seguranca.tipo_usuario', 'usuario_tipo_usuario.tipo_usuario_id = tipo_usuario.tipo_usuario_id', 'INNER');
        $this->db->join('dados_unico.pessoa', 'usuario_tipo_usuario.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('seguranca.usuario', 'usuario.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->where($where); 
        return $this->db->get($this->table)->result();
        echo_pre($this->db->last_query());
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

}

/* Final do arquivo Usuario_tipo_usuario_model.php */
/* Local: ./application/models/Usuario_tipo_usuario_model.php */
/* Data - 2018-04-09 18:03:07 */