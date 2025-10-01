<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orgao_model extends CI_Model
{

    public $table = 'dados_unico.orgao';
    public $id = 'orgao_id';
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
        @$this->db->ilike('dados_unico.orgao.orgao_id', $q);
	$this->db->or_ilike('orgao.orgao_ds', $q);
	$this->db->or_ilike('orgao.orgao_st', $q);
	$this->db->or_ilike('orgao.orgao_dt_criacao', $q);
	$this->db->or_ilike('orgao.orgao_dt_alteracao', $q);
	$this->db->or_ilike('orgao.flag_maladireta', $q);
	$this->db->or_ilike('orgao.maladireta_cd', $q);
	$this->db->or_ilike('orgao.endereco', $q);
	$this->db->or_ilike('orgao.segmento_id', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('*');
        $this->db->order_by($this->table.'.'.$this->id, $this->order);
        @$this->db->ilike('orgao.orgao_id', $q);
	$this->db->or_ilike('orgao.orgao_ds', $q);
	$this->db->or_ilike('orgao.orgao_st', $q);
	$this->db->or_ilike('orgao.orgao_dt_criacao', $q);
	$this->db->or_ilike('orgao.orgao_dt_alteracao', $q);
	$this->db->or_ilike('orgao.flag_maladireta', $q);
	$this->db->or_ilike('orgao.maladireta_cd', $q);
	$this->db->or_ilike('orgao.endereco', $q);
	$this->db->or_ilike('orgao.segmento_id', $q);
	$this->db->join('contato_maladireta_old.segmento','orgao.segmento_id = segmento.segmento_id', 'INNER');
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
	$this->db->join('contato_maladireta_old.segmento as s2','orgao.segmento_id = s2.segmento_id', 'INNER'); 
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

/* Final do arquivo Orgao_model.php */
/* Local: ./application/models/Orgao_model.php */
/* Data - 2022-06-29 20:00:41 */