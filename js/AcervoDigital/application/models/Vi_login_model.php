<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vi_login_model extends CI_Model {

    public $table = 'public.vi_login';
    public $id = 'sistema_id';
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
        $this->db->ilike('public.vi_login.sistema_id', $q);
        $this->db->or_ilike('vi_login.sistema_nm', $q);
        $this->db->or_ilike('vi_login.tipo_usuario_id', $q);
        $this->db->or_ilike('vi_login.tipo_usuario_ds', $q);
        $this->db->or_ilike('vi_login.pessoa_id', $q);
        $this->db->or_ilike('vi_login.pessoa_nm', $q);
        $this->db->or_ilike('vi_login.funcionario_email', $q);
        $this->db->or_ilike('vi_login.setaf_id', $q);
        $this->db->or_ilike('vi_login.setaf_nm', $q);
        $this->db->or_ilike('vi_login.usuario_login', $q);
        $this->db->or_ilike('vi_login.usuario_senha', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('vi_login.sistema_id', $q);
        $this->db->or_ilike('vi_login.sistema_nm', $q);
        $this->db->or_ilike('vi_login.tipo_usuario_id', $q);
        $this->db->or_ilike('vi_login.tipo_usuario_ds', $q);
        $this->db->or_ilike('vi_login.pessoa_id', $q);
        $this->db->or_ilike('vi_login.pessoa_nm', $q);
        $this->db->or_ilike('vi_login.funcionario_email', $q);
        $this->db->or_ilike('vi_login.setaf_id', $q);
        $this->db->or_ilike('vi_login.setaf_nm', $q);
        $this->db->or_ilike('vi_login.usuario_login', $q);
        $this->db->or_ilike('vi_login.usuario_senha', $q);
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

/* Final do arquivo Vi_login_model.php */
/* Local: ./application/models/Vi_login_model.php */
/* Data - 2018-04-09 16:07:39 */