<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acompanhamento_territorio_model extends CI_Model
{

    public $table = 'cotacao.acompanhamento_territorio';
    public $id = 'acompanhamento_territorio_id';
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
        $this->db->ilike('cotacao.acompanhamento_territorio.acompanhamento_territorio_id', $q);
        $this->db->or_ilike('acompanhamento_territorio.pessoa_id', $q);
        $this->db->or_ilike('acompanhamento_territorio.territorio_id', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('acompanhamento_territorio.acompanhamento_territorio_id', $q);
        $this->db->or_ilike('acompanhamento_territorio.pessoa_id', $q);
        $this->db->or_ilike('acompanhamento_territorio.territorio_id', $q);
        $this->db->join('dados_unico.pessoa', 'acompanhamento_territorio.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.territorio', 'acompanhamento_territorio.territorio_id = territorio.territorio_id', 'INNER');
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
        $this->db->join('dados_unico.pessoa', 'acompanhamento_territorio.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.territorio', 'acompanhamento_territorio.territorio_id = territorio.territorio_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data



    function get_all_data_param($param = null, $order = null)
    {

        $this->db->select('*');


        $this->db->join('dados_unico.pessoa', 'acompanhamento_territorio.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.territorio', 'acompanhamento_territorio.territorio_id = territorio.territorio_id', 'INNER');
        $this->db->where($param);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data


    function get_all_data_param_retorno_in($param = null, $order = null)
    {

        $retorno_in = "(0";
        $this->db->select('*');


        $this->db->join('dados_unico.pessoa', 'acompanhamento_territorio.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.territorio', 'acompanhamento_territorio.territorio_id = territorio.territorio_id', 'INNER');
        $this->db->where($param);
        $this->db->order_by($order);
        return  $this->db->get($this->table)->result();
      
        // return $retorno_in;
    } // end get_all_data


function get_retorna_flag_territorio_selecionado($territorio_id, $pessoa_id){
    $sql = "select count(1) as qtd from cotacao.acompanhamento_territorio where pessoa_id = $pessoa_id and territorio_id = $territorio_id";

    return $this->db->query($sql)->row(); 
}


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
    function delete_todos_por_pessoa_id($pessoa_id)
    {
        $this->db->where('pessoa_id', $pessoa_id);

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }
}

/* Final do arquivo Acompanhamento_territorio_model.php */
/* Local: ./application/models/Acompanhamento_territorio_model.php */
/* Data - 2024-10-31 19:01:54 */