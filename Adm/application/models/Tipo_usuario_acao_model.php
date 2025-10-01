<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tipo_usuario_acao_model extends CI_Model
{

    public $table = 'seguranca.tipo_usuario_acao';
    public $id = 'tipo_usuario_acao_id';
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
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        // @$this->db->ilike('seguranca.tipo_usuario_acao.tipo_usuario_id', $q);
        // $this->db->or_ilike('tipo_usuario_acao.acao_id', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $param=null)
    {
        $this->db->select('
        
        *
        
        ');
        $this->db->order_by($this->table . '.' . $this->id, $this->order); 
        $this->db->join('seguranca.acao', 'acao.acao_id = tipo_usuario_acao.acao_id', 'INNER');
        $this->db->join('seguranca.secao', 'secao.secao_id = acao.secao_id', 'INNER');
        $this->db->join('seguranca.tipo_usuario', 'tipo_usuario.tipo_usuario_id = tipo_usuario_acao.tipo_usuario_id', 'INNER');
        $this->db->join('seguranca.sistema', 'sistema.sistema_id = tipo_usuario.sistema_id', 'INNER');
        $this->db->limit($limit, $start);
        $this->db->where("1=1 ". $param);
        return $this->db->get($this->table)->result();
        //  echo_pre($this->db->last_query());
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
        $this->db->join('seguranca.acao', 'acao.acao_id = tipo_usuario_acao.acao_id', 'INNER');
        $this->db->join('seguranca.secao', 'secao.secao_id = acao.secao_id', 'INNER');
        $this->db->join('seguranca.tipo_usuario', 'tipo_usuario.tipo_usuario_id = tipo_usuario_acao.tipo_usuario_id', 'INNER');
        $this->db->join('seguranca.sistema', 'sistema.sistema_id = tipo_usuario.sistema_id', 'INNER');
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

/* Final do arquivo Tipo_usuario_acao_model.php */
/* Local: ./application/models/Tipo_usuario_acao_model.php */
/* Data - 2020-01-14 13:38:14 */