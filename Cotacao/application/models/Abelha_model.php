<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Abelha_model extends CI_Model
{

    public $table = 'abelha.abelha';
    public $id = 'abelha_id';
    public $order = 'DESC';



    private $campos = ['abelha.abelha_id', 'abelha.abelha_nm', 'abelha.referencia', 'abelha.abelha_genero_id', 'abelha.abelha_genero_id', 'abelha.abelha_genero_id'];


    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->select(arrayToString($this->campos));
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
        $this->db->select(arrayToString($this->campos));
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/

        /*$this->db->ilike('abelha.abelha.abelha_id', $q); */
        $this->db->or_ilike('abelha.abelha_nm', $q);
        $this->db->or_ilike('abelha.referencia', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select(arrayToString($this->campos));

        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        /*$this->db->ilike('abelha.abelha_id', $q); */
        $this->db->or_ilike('abelha.abelha_nm', $q);
        $this->db->or_ilike('abelha.referencia', $q);
        $this->db->join('abelha.abelha_genero', 'abelha.abelha_genero_id = abelha_genero.abelha_genero_id', 'INNER');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function get_all_data($param, $order = null)
    {

        $this->db->select(arrayToString($this->campos));


        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .=  " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->join('abelha.abelha_genero as a2', 'abelha.abelha_genero_id = a2.abelha_genero_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data



    function get_all_data_param($param = null, $order = null)
    {

        $this->db->select(arrayToString($this->campos));


        $this->db->join('abelha.abelha_genero as a3', 'abelha.abelha_genero_id = a3.abelha_genero_id', 'INNER');
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

/* Final do arquivo Abelha_model.php */
/* Local: ./application/models/Abelha_model.php */
/* Data - 2025-04-02 20:48:11 */