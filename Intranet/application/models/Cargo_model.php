<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cargo_model extends CI_Model
{

    public $table = 'dados_unico.cargo';
    public $id = 'cargo_id';
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
        @$this->db->ilike('dados_unico.cargo.cargo_id', $q);
	$this->db->or_ilike('cargo.cargo_ds', $q);
	$this->db->or_ilike('cargo.cargo_st', $q);
	$this->db->or_ilike('cargo.cargo_dt_criacao', $q);
	$this->db->or_ilike('cargo.cargo_dt_alteracao', $q);
	$this->db->or_ilike('cargo.funcionario_tipo_id', $q);
	$this->db->or_ilike('cargo.classe_id', $q);
	$this->db->or_ilike('cargo.cargo_qtde', $q);
	$this->db->or_ilike('cargo.novo_classe_id', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('*');
        $this->db->order_by($this->table.'.'.$this->id, $this->order);
        @$this->db->ilike('cargo.cargo_id', $q);
	$this->db->or_ilike('cargo.cargo_ds', $q);
	$this->db->or_ilike('cargo.cargo_st', $q);
	$this->db->or_ilike('cargo.cargo_dt_criacao', $q);
	$this->db->or_ilike('cargo.cargo_dt_alteracao', $q);
	$this->db->or_ilike('cargo.funcionario_tipo_id', $q);
	$this->db->or_ilike('cargo.classe_id', $q);
	$this->db->or_ilike('cargo.cargo_qtde', $q);
	$this->db->or_ilike('cargo.novo_classe_id', $q);
	$this->db->join('dados_unico.funcionario_tipo','cargo.funcionario_tipo_id = funcionario_tipo.funcionario_tipo_id', 'INNER');
	$this->db->join('diaria.classe','cargo.classe_id = classe.classe_id', 'INNER');
	$this->db->join('diaria_tentativa_old.classe','cargo.novo_classe_id = classe.classe_id', 'INNER');
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
	$this->db->join('dados_unico.funcionario_tipo','cargo.funcionario_tipo_id = funcionario_tipo.funcionario_tipo_id', 'INNER');
	$this->db->join('diaria.classe','cargo.classe_id = classe.classe_id', 'INNER');
	$this->db->join('diaria_tentativa_old.classe','cargo.novo_classe_id = classe.classe_id', 'INNER'); 
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

/* Final do arquivo Cargo_model.php */
/* Local: ./application/models/Cargo_model.php */
/* Data - 2022-06-29 19:59:05 */