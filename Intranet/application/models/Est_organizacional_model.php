<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Est_organizacional_model extends CI_Model
{

    public $table = 'dados_unico.est_organizacional';
    public $id = 'est_organizacional_id';
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
        $this->db->select("$this->id as id, est_organizacional_sigla as text");
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
        @$this->db->ilike('dados_unico.est_organizacional.est_organizacional_id', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_sup_cd', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_ds', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_sigla', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_st', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_dt_criacao', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_dt_alteracao', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_centro_custo', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_centro_custo_num', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_centro_custo_transporte', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_centro_custo_acompanhamento', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_unidade_executora', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_centro_custo_material', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_codigo_centro_custo_material', $q);
	$this->db->or_ilike('est_organizacional.unidade_orcamentaria_id', $q);
	$this->db->or_ilike('est_organizacional.grupo_diaria', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('*');
        $this->db->order_by($this->table.'.'.$this->id, $this->order);
        @$this->db->ilike('est_organizacional.est_organizacional_id', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_sup_cd', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_ds', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_sigla', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_st', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_dt_criacao', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_dt_alteracao', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_centro_custo', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_centro_custo_num', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_centro_custo_transporte', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_centro_custo_acompanhamento', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_unidade_executora', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_centro_custo_material', $q);
	$this->db->or_ilike('est_organizacional.est_organizacional_codigo_centro_custo_material', $q);
	$this->db->or_ilike('est_organizacional.unidade_orcamentaria_id', $q);
	$this->db->or_ilike('est_organizacional.grupo_diaria', $q);
	$this->db->join('adiantamento.unidade_orcamentaria','est_organizacional.unidade_orcamentaria_id = unidade_orcamentaria.unidade_orcamentaria_id', 'INNER');
	$this->db->join('adiantamento_old_novo.unidade_orcamentaria','est_organizacional.unidade_orcamentaria_id = unidade_orcamentaria.unidade_orcamentaria_id', 'INNER');
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
	$this->db->join('adiantamento.unidade_orcamentaria','est_organizacional.unidade_orcamentaria_id = unidade_orcamentaria.unidade_orcamentaria_id', 'INNER');
	$this->db->join('adiantamento_old_novo.unidade_orcamentaria','est_organizacional.unidade_orcamentaria_id = unidade_orcamentaria.unidade_orcamentaria_id', 'INNER'); 
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

/* Final do arquivo Est_organizacional_model.php */
/* Local: ./application/models/Est_organizacional_model.php */
/* Data - 2024-01-24 13:26:04 */