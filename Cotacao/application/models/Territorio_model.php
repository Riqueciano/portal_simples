<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Territorio_model extends CI_Model
{

    public $table = 'indice.territorio';
    public $id = 'territorio_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all($where = '1=1', $ordem = 'territorio.territorio_nm')
    {
        $this->db->select("*");

        $this->db->order_by($ordem);
        $this->db->where($where);
        return $this->db->get($this->table)->result();
    }
    function get_all_com_preco()
    {
        $sql = "
                    select 
                      t.territorio_id
                    , t.territorio_nm
                    , ppt.produto_preco_territorio_valor

                     from indice.territorio t  
                        left join cotacao.produto_preco_territorio ppt
                                on ppt.territorio_id = t.territorio_id
                        where ppt.produto_preco_territorio_ativo = 1 and t.territorio_id != 54                    
                    order by t.territorio_nm
        ";
        return $this->db->query($sql)->result();
    }

    // get all for combobox 
    function get_all_combobox($param = null, $order = null)
    {
        $this->db->select("$this->id as id, territorio_nm as text");
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
        $this->db->ilike('indice.territorio.territorio_id', $q);
        $this->db->or_ilike('territorio.territorio_nm', $q);
        $this->db->or_ilike('territorio.territorio_st', $q);
        $this->db->or_ilike('territorio.territorio_cd', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('territorio.territorio_id', $q);
        $this->db->or_ilike('territorio.territorio_nm', $q);
        $this->db->or_ilike('territorio.territorio_st', $q);
        $this->db->or_ilike('territorio.territorio_cd', $q);
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
    function get_all_data_param($param, $order = null)
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

/* Final do arquivo Territorio_model.php */
/* Local: ./application/models/Territorio_model.php */
/* Data - 2022-09-05 18:20:01 */