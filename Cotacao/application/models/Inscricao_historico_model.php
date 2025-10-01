<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inscricao_historico_model extends CI_Model
{

    public $table = 'sigater_proposta.inscricao_historico';
    public $id = 'inscricao_historico_id';
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
        $this->db->ilike('sigater_proposta.inscricao_historico.inscricao_historico_id', $q);
        $this->db->or_ilike('inscricao_historico.inscricao_historico_ds', $q);
        $this->db->or_ilike('inscricao_historico.pessoa_id', $q);
        $this->db->or_ilike('inscricao_historico.dt_cadastro', $q);
        $this->db->or_ilike('inscricao_historico.inscricao_id', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('inscricao_historico.inscricao_historico_id', $q);
        $this->db->or_ilike('inscricao_historico.inscricao_historico_ds', $q);
        $this->db->or_ilike('inscricao_historico.pessoa_id', $q);
        $this->db->or_ilike('inscricao_historico.dt_cadastro', $q);
        $this->db->or_ilike('inscricao_historico.inscricao_id', $q);
        $this->db->join('dados_unico.pessoa', 'inscricao_historico.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('sigater_proposta.inscricao', 'inscricao_historico.inscricao_id = inscricao.inscricao_id', 'INNER');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function get_all_data($param, $order = null)
    {

        $this->db->select('*, inscricao_historico.dt_cadastro as dt_historico');

        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .=  " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->join('dados_unico.pessoa', 'inscricao_historico.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('sigater_proposta.inscricao', 'inscricao_historico.inscricao_id = inscricao.inscricao_id', 'INNER');
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
   /*function delete($id)
    {
        $this->db->where($this->id, $id);

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }*/
}

/* Final do arquivo Inscricao_historico_model.php */
/* Local: ./application/models/Inscricao_historico_model.php */
/* Data - 2020-02-05 17:40:36 */