<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_item_anexo_model extends CI_Model
{

    public $table = 'intranet.menu_item_anexo';
    public $id = 'menu_item_anexo_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->table.'.'.$this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        @$this->db->ilike('intranet.menu_item_anexo.menu_item_anexo_id', $q);
	$this->db->or_ilike('menu_item_anexo.menu_item_anexo', $q);
	$this->db->or_ilike('menu_item_anexo.menu_item_id', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('*');
        $this->db->order_by($this->table.'.'.$this->id, $this->order);
        @$this->db->ilike('menu_item_anexo.menu_item_anexo_id', $q);
	$this->db->or_ilike('menu_item_anexo.menu_item_anexo', $q);
	$this->db->or_ilike('menu_item_anexo.menu_item_id', $q);
	$this->db->join('intranet.menu_item','menu_item_anexo.menu_item_id = menu_item.menu_item_id', 'INNER');
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    
            function get_all_data($param,$order=null) {
        
                $this->db->select('*');
              
                        $where = '1=1 ';
                    foreach ($param as $array) {
                        //se tiver parametro
                        if($array[2] != ''){
                                $where .=  " and ".$array[0]." ". $array[1] ." '".$array[2]."' ";
                            }
                    }
	$this->db->join('intranet.menu_item as m2','menu_item_anexo.menu_item_id = m2.menu_item_id', 'INNER'); 
                 $this->db->where($where); 
                 $this->db->order_by($order);  
                 return $this->db->get($this->table)->result();
         }// end get_all_data
         

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
        
        if(!$this->db->delete($this->table)){
            return 'erro_dependencia';
        }
    }

}

/* Final do arquivo Menu_item_anexo_model.php */
/* Local: ./application/models/Menu_item_anexo_model.php */
/* Data - 2019-09-25 15:25:49 */