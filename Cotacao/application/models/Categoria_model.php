<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categoria_model extends CI_Model
{

    public $table = 'cotacao.categoria';
    public $id = 'categoria_id';
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
    function get_all_qtd_cotacoes()
    {

        $this->db->select("*, 
                (select count(distinct ppc.produto_preco_cotacao_id) from cotacao.produto_preco_cotacao ppc 
                                    inner join cotacao.produto p
                                        on p.produto_id = ppc.produto_id

                                    where p.categoria_id = categoria.categoria_id
                            
                            )as qtd_cotacoes
        ");

        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get all for combobox 
    function get_all_combobox($param = null, $order = null)
    {
        $this->db->select("categoria_id as id, categoria_nm as text");
        if (!empty($param)) {
            $this->db->where($param);
        }
        if (!empty($order)) {
            $this->db->order_by($order);
        } else {
            $this->db->order_by($this->table . '.' . 'categoria_nm', 'asc');
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
        /*ilike, or_ilike, or_not_ilike, not_ilike fun��es n�o s�o nativa do CI, adaptada para o Collate do PG utilizado*/
        $this->db->ilike('cotacao.categoria.categoria_id', $q);
        $this->db->or_ilike('categoria.categoria_nm', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by("categoria.categoria_nm asc");
        $this->db->ilike('categoria.categoria_id', $q);
        $this->db->or_ilike('categoria.categoria_nm', $q);
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

/* Final do arquivo Categoria_model.php */
/* Local: ./application/models/Categoria_model.php */
/* Data - 2022-09-20 20:43:37 */