<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comprador_categoria_model extends CI_Model
{

    public $table = 'cotacao.comprador_categoria';
    public $id = 'comprador_categoria_id';
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
        $this->db->select("$this->id as id, comprador_categoria_nm as text");
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


    function get_query_json($where = null, $q = null, $limit = 99999, $start = 0, $tabelas = array())
    {
        $this->db->select('*');
        if ($where != null) {
            $this->db->where($where);
        }

        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->limit($limit, $start);

        if ($q != null) {
            $this->db->ilike('cotacao.comprador_categoria.comprador_categoria_id', $q);
            $this->db->or_ilike('comprador_categoria.comprador_categoria_nm', $q);
        } //end if

        //realiza a consulta
        $retorno = $this->db->get($this->table)->result();


        // $tabelas = array(
        //     (object)array('id' => 'raca_id', 'tabela' => 'raca'), 
        // );

        //adiciona as tabelas referencia ao array para ser utilizado como json no front
        //montando os "joins"
        foreach ($retorno as $key => $ret) {
            foreach ($tabelas as $key => $tb) {
                // print_r($tb['id']); 
                // print_r($tb['tabela']); 
                $tabela_model = ucfirst($tb['tabela'] . '_model');
                $tabela_id = $tb['tabela'] . '_id';
                $tabela = $tb['tabela'];
                $cardinalidade = $tb['cardinalidade'];
                if ($cardinalidade == '1' or empty($cardinalidade)) {
                    $ret->$tabela = $this->$tabela_model->get_by_id($ret->$tabela_id);
                } else if ($cardinalidade == 'n') {
                    $ret->$tabela = $this->Cachorro_model->get_all_data_param(' raca.raca_id= ' . $ret->raca_id);
                }
            }
        }

        return $retorno;
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
        $this->db->ilike('cotacao.comprador_categoria.comprador_categoria_id', $q);
        $this->db->or_ilike('comprador_categoria.comprador_categoria_nm', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('comprador_categoria.comprador_categoria_id', $q);
        $this->db->or_ilike('comprador_categoria.comprador_categoria_nm', $q);
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
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data



    function get_all_data_param($param = null, $order = null)
    {

        $this->db->select('*');


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
   /*function delete($id)
    {
        $this->db->where($this->id, $id);

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }*/
}

/* Final do arquivo Comprador_categoria_model.php */
/* Local: ./application/models/Comprador_categoria_model.php */
/* Data - 2024-06-19 15:41:01 */