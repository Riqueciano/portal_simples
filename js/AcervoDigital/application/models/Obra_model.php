<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Obra_model extends CI_Model {

    public $table = 'acervo.obra';
    public $id = 'obra_id';
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
        $this->db->join('acervo.obra_tipo', 'obra.obra_tipo_id = obra_tipo.obra_tipo_id', 'INNER');
        $this->db->join('acervo.instituicao', 'obra.instituicao_id = instituicao.instituicao_id', 'left');
        $this->db->join('acervo.status', 'status.status_id = obra.status_id', 'left');
        $this->db->join('dados_unico.pessoa', 'pessoa.pessoa_id = obra.pessoa_id', 'left');
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL) {
        /* ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado */
        $this->db->ilike('acervo.obra.obra_id', $q);
        $this->db->or_ilike('obra.obra_titulo', $q);
        $this->db->or_ilike('obra.instituicao_id', $q);
        $this->db->or_ilike('obra.obra_tipo_id', $q);
        $this->db->or_ilike('obra.qtd_pag', $q);
        $this->db->or_ilike('obra.resumo', $q);
        $this->db->or_ilike('obra.obra_anexo', $q);
        $this->db->or_ilike('obra.status_id', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $param='1=1') {
        //echo $param;exit;
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->where($param);
        $this->db->join('acervo.instituicao', 'obra.instituicao_id = instituicao.instituicao_id', 'left');
        $this->db->join('acervo.obra_tipo', 'obra.obra_tipo_id = obra_tipo.obra_tipo_id', 'INNER');
        $this->db->join('acervo.status', 'obra.status_id = status.status_id', 'left'); 
        $this->db->join('dados_unico.pessoa', 'pessoa.pessoa_id = obra.pessoa_id', 'left'); 
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
        $this->db->join('acervo.instituicao', 'obra.instituicao_id = instituicao.instituicao_id', 'INNER');
        $this->db->join('acervo.obra_tipo', 'obra.obra_tipo_id = obra_tipo.obra_tipo_id', 'INNER');
        $this->db->join('acervo.status', 'obra.status_id = status.status_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by('palavra');
        return $this->db->get($this->table)->result();
    }
    function get_all_param($param, $order = null) {
        $this->db->select('*');
        $where = '1=1 ';
        
        
        $this->db->join('acervo.instituicao', 'obra.instituicao_id = instituicao.instituicao_id', 'INNER');
        $this->db->join('acervo.obra_tipo', 'obra.obra_tipo_id = obra_tipo.obra_tipo_id', 'INNER');
        $this->db->join('acervo.status', 'obra.status_id = status.status_id', 'INNER');
        $this->db->where($param);
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

/* Final do arquivo Obra_model.php */
/* Local: ./application/models/Obra_model.php */
/* Data - 2018-03-27 17:17:12 */