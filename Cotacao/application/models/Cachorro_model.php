<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cachorro_model extends CI_Model
{

    public $table = 'cotacao.cachorro';
    public $id = 'cachorro_id';
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

    // get all for combobox 
    function get_all_combobox($param = null, $order = null)
    {
        $this->db->select("$this->id as id, $this->id as text");
        if(!empty($param)){
            $this->db->where($param);
        }
        if(!empty($order)){
            $this->db->order_by($order);
        }else{
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
    function total_rows($q = NULL) {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        $this->db->ilike('cotacao.cachorro.cachorro_id', $q);
	$this->db->or_ilike('cachorro.cachorro_nm', $q);
	$this->db->or_ilike('cachorro.cachorro_descricao', $q);
	$this->db->or_ilike('cachorro.nascimento', $q);
	$this->db->or_ilike('cachorro.raca_id', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('*');
        $this->db->order_by($this->table.'.'.$this->id, $this->order);
        $this->db->ilike('cachorro.cachorro_id', $q);
	$this->db->or_ilike('cachorro.cachorro_nm', $q);
	$this->db->or_ilike('cachorro.cachorro_descricao', $q);
	$this->db->or_ilike('cachorro.nascimento', $q);
	$this->db->or_ilike('cachorro.raca_id', $q);
	$this->db->join('cotacao.raca','cachorro.raca_id = raca.raca_id', 'INNER');
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
	$this->db->join('cotacao.raca as r2','cachorro.raca_id = r2.raca_id', 'INNER'); 
                 $this->db->where($where); 
                 $this->db->order_by($order);  
                 return $this->db->get($this->table)->result();
         }// end get_all_data
         

    
            function get_all_data_param($param = null,$order=null) {
        
                $this->db->select('*');
              
                
	$this->db->join('cotacao.raca as r3','cachorro.raca_id = r3.raca_id', 'INNER'); 
                 $this->db->where($param); 
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

/* Final do arquivo Cachorro_model.php */
/* Local: ./application/models/Cachorro_model.php */
/* Data - 2024-10-01 16:23:55 */