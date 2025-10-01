<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Instituicao_model extends CI_Model
{

    public $table = 'acervo.instituicao';
    public $id = 'instituicao_id';
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
        $this->db->ilike('acervo.instituicao.instituicao_id', $q);
	$this->db->or_ilike('instituicao.instituicao_nm', $q);
	$this->db->or_ilike('instituicao.instituicao_sigla', $q);
	$this->db->or_ilike('instituicao.instituicao_endereco', $q);
	$this->db->or_ilike('instituicao.instituicao_endereco_cep', $q);
	$this->db->or_ilike('instituicao.municipio_id', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('*');
        $this->db->order_by($this->table.'.'.$this->id, $this->order);
        $this->db->ilike('instituicao.instituicao_id', $q);
	$this->db->or_ilike('instituicao.instituicao_nm', $q);
	$this->db->or_ilike('instituicao.instituicao_sigla', $q);
	$this->db->or_ilike('instituicao.instituicao_endereco', $q);
	$this->db->or_ilike('instituicao.instituicao_endereco_cep', $q);
	$this->db->or_ilike('instituicao.municipio_id', $q);
	$this->db->join('indice.municipio','instituicao.municipio_id = municipio.municipio_id', 'INNER');
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
	$this->db->join('indice.municipio as m2','instituicao.municipio_id = m2.municipio_id', 'INNER'); 
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

/* Final do arquivo Instituicao_model.php */
/* Local: ./application/models/Instituicao_model.php */
/* Data - 2018-03-27 16:27:08 */