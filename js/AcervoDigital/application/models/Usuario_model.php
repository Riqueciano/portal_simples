<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public $table = 'seguranca.usuario';
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
        $this->db->ilike('seguranca.usuario.pessoa_id', $q);
        $this->db->or_ilike('usuario.usuario_login', $q);
        $this->db->or_ilike('usuario.usuario_senha', $q);
        $this->db->or_ilike('usuario.usuario_st', $q);
        $this->db->or_ilike('usuario.usuario_dt_criacao', $q);
        $this->db->or_ilike('usuario.usuario_dt_alteracao', $q);
        $this->db->or_ilike('usuario.usuario_primeiro_logon', $q);
        $this->db->or_ilike('usuario.usuario_diaria', $q);
        $this->db->or_ilike('usuario.usuario_login_st', $q);
        $this->db->or_ilike('usuario.usuario_login_dt_alteracao', $q);
        $this->db->or_ilike('usuario.usuario_login_alterador', $q);
        $this->db->or_ilike('usuario.validade', $q);
        $this->db->or_ilike('usuario.flag_senha_nova', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('usuario.pessoa_id', $q);
        $this->db->or_ilike('usuario.usuario_login', $q);
        $this->db->or_ilike('usuario.usuario_senha', $q);
        $this->db->or_ilike('usuario.usuario_st', $q);
        $this->db->or_ilike('usuario.usuario_dt_criacao', $q);
        $this->db->or_ilike('usuario.usuario_dt_alteracao', $q);
        $this->db->or_ilike('usuario.usuario_primeiro_logon', $q);
        $this->db->or_ilike('usuario.usuario_diaria', $q);
        $this->db->or_ilike('usuario.usuario_login_st', $q);
        $this->db->or_ilike('usuario.usuario_login_dt_alteracao', $q);
        $this->db->or_ilike('usuario.usuario_login_alterador', $q);
        $this->db->or_ilike('usuario.validade', $q);
        $this->db->or_ilike('usuario.flag_senha_nova', $q);
        $this->db->join('dados_unico.pessoa', 'usuario.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
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
        $this->db->join('dados_unico.pessoa as p2', 'usuario.pessoa_id = p2.pessoa_id', 'left');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
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

/* Final do arquivo Usuario_model.php */
/* Local: ./application/models/Usuario_model.php */
/* Data - 2018-04-09 17:19:15 */