<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inscricao_fornecedor_model extends CI_Model
{

    public $table = 'cotacao.inscricao_fornecedor';
    public $id = 'inscricao_fornecedor_id';
    public $order = 'DESC';
    
    
    
 

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->select('*');
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
        $this->db->select('*');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        
        /*$this->db->ilike('cotacao.inscricao_fornecedor.inscricao_fornecedor_id', $q); */
	$this->db->or_ilike('inscricao_fornecedor.responsavel_nm', $q);
	$this->db->or_ilike('inscricao_fornecedor.responsavel_cpf', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_email', $q);
	$this->db->or_ilike('inscricao_fornecedor.responsavel_telefone', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_nm', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_nm_fantasia', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_cnpj', $q);
	$this->db->or_ilike('inscricao_fornecedor.reprovado_motivo', $q);
	$this->db->or_ilike('inscricao_fornecedor.dap_caf', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_endereco', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_bairro', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_cep', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('*');
        
        $this->db->order_by($this->table.'.'.$this->id, $this->order);
        /*$this->db->ilike('inscricao_fornecedor.inscricao_fornecedor_id', $q); */
	$this->db->or_ilike('inscricao_fornecedor.responsavel_nm', $q);
	$this->db->or_ilike('inscricao_fornecedor.responsavel_cpf', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_email', $q);
	$this->db->or_ilike('inscricao_fornecedor.responsavel_telefone', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_nm', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_nm_fantasia', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_cnpj', $q);
	$this->db->or_ilike('inscricao_fornecedor.reprovado_motivo', $q);
	$this->db->or_ilike('inscricao_fornecedor.dap_caf', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_endereco', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_bairro', $q);
	$this->db->or_ilike('inscricao_fornecedor.fornecedor_cep', $q);
	$this->db->join('cotacao.fornecedor_categoria','inscricao_fornecedor.fornecedor_categoria_id = fornecedor_categoria.fornecedor_categoria_id', 'INNER');
	$this->db->join('dados_unico.pessoa','inscricao_fornecedor.autorizador_cadastro_gestor_pessoa_id = pessoa.pessoa_id', 'INNER');
	$this->db->join('dados_unico.pessoa as p2','inscricao_fornecedor.fornecedor_pessoa_id = p2.pessoa_id', 'INNER');
	$this->db->join('indice.municipio','inscricao_fornecedor.fornecedor_municipio_id = municipio.municipio_id', 'INNER');
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
	$this->db->join('cotacao.fornecedor_categoria','inscricao_fornecedor.fornecedor_categoria_id = fornecedor_categoria.fornecedor_categoria_id', 'INNER');
	$this->db->join('dados_unico.pessoa','inscricao_fornecedor.autorizador_cadastro_gestor_pessoa_id = pessoa.pessoa_id', 'INNER');
	$this->db->join('dados_unico.pessoa as p2','inscricao_fornecedor.fornecedor_pessoa_id = p2.pessoa_id', 'INNER');
	$this->db->join('indice.municipio','inscricao_fornecedor.fornecedor_municipio_id = municipio.municipio_id', 'INNER'); 
                 $this->db->where($where); 
                 $this->db->order_by($order);  
                 return $this->db->get($this->table)->result();
         }// end get_all_data
         

    
            function get_all_data_param($param = null,$order=null) {
        
               $this->db->select('*');
              
                
	$this->db->join('cotacao.fornecedor_categoria','inscricao_fornecedor.fornecedor_categoria_id = fornecedor_categoria.fornecedor_categoria_id', 'INNER');
	$this->db->join('dados_unico.pessoa','inscricao_fornecedor.autorizador_cadastro_gestor_pessoa_id = pessoa.pessoa_id', 'INNER');
	$this->db->join('dados_unico.pessoa as p2','inscricao_fornecedor.fornecedor_pessoa_id = p2.pessoa_id', 'INNER');
	$this->db->join('indice.municipio','inscricao_fornecedor.fornecedor_municipio_id = municipio.municipio_id', 'INNER'); 
                 $this->db->where($param); 
                 $this->db->order_by($order);  
                 return $this->db->get($this->table)->result();
         }// end get_all_data
         

    
            function get_all_1xN($param = null,$order=null) {
    
 
        // Tabelas relacionadas  
                        $joins =  [
  [
                                            'schema' => 'cotacao',
                                            'table' => 'fornecedor_categoria',
                                            'local_key' => 'fornecedor_categoria_id',
                                            'foreign_key' => 'fornecedor_categoria_id',
                                        ], 
  [
                                            'schema' => 'dados_unico',
                                            'table' => 'pessoa',
                                            'local_key' => 'autorizador_cadastro_gestor_pessoa_id',
                                            'foreign_key' => 'autorizador_cadastro_gestor_pessoa_id',
                                        ], 
  [
                                            'schema' => 'dados_unico',
                                            'table' => 'pessoa',
                                            'local_key' => 'fornecedor_pessoa_id',
                                            'foreign_key' => 'fornecedor_pessoa_id',
                                        ], 
  [
                                            'schema' => 'indice',
                                            'table' => 'municipio',
                                            'local_key' => 'fornecedor_municipio_id',
                                            'foreign_key' => 'fornecedor_municipio_id',
                                        ], 
   ];     
               $this->db->select('*');
                
               if(!empty($order)){
                    $this->db->order_by($order);  
                }
                $result = $this->db->get($this->table)->result();
                if (!empty($param)) {
                    $this->db->where($param);
                }


                foreach ($result as $key => $r) {
                    foreach ($joins as $jKey => $j) {
                        $fk = $j['table'];
                        $local_key = $j['local_key'];
                        $this->db->where($j['table'] . '.' . $j['foreign_key'], $r->$local_key);
                        $this->db->select('*');
                        $r->$fk =  $this->db->get($j['schema'] . '.' . $j['table'])->result();;
                    }
                }
                 
                 

                 return $result;
         } 
         

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

/* Final do arquivo Inscricao_fornecedor_model.php */
/* Local: ./application/models/Inscricao_fornecedor_model.php */
/* Data - 2025-08-01 15:36:43 */