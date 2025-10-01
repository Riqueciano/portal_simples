<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cotacao_model extends CI_Model
{

    public $table = 'cotacao.cotacao';
    public $id = 'cotacao_id';
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




    function get_fornecedores($territorio_id = null, $parametro = ""){
       
        $param_territorio = "";
       if(!empty($territorio_id)){
           $param_territorio = " and p.cotacao_territorio_id = $territorio_id";
       }
       
        $sql = "
            select if1.*
                    from COTACAO.inscricao_fornecedor if1
                        inner join dados_unico.pessoa p
                            on p.pessoa_id = if1.fornecedor_pessoa_id
                    where if1.dt_cadastro = (
                                                select max(if2.dt_cadastro)
                                                from COTACAO.inscricao_fornecedor if2
                                                where if2.fornecedor_pessoa_id = if1.fornecedor_pessoa_id
                                            )
                    $parametro      $param_territorio          
                      
        ";
        //echo_pre($sql);
        return $this->db->query($sql)->result();
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
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        $this->db->ilike('cotacao.cotacao.cotacao_id', $q);
        $this->db->or_ilike('cotacao.cotacao_pessoa_id', $q);
        $this->db->or_ilike('cotacao.cotacao_dt', $q);
        $this->db->or_ilike('cotacao.cotacao_ds', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $pessoa_id = null, $where_comp = null)
    {

        // echo $where_comp ;exit;
        $this->db->select('*
        
            , (select p2.pessoa_nm from dados_unico.pessoa p2 where p2.pessoa_id = cotacao.solicitado_para_pessoa_id ) as solicitado_para_pessoa_nm
        ');
        // $this->db->order_by("cotacao.cotacao_dt desc");
        // $this->db->ilike('cotacao.cotacao_id', $q);
        // $this->db->or_ilike('cotacao.cotacao_pessoa_id', $q);
        // $this->db->or_ilike('cotacao.cotacao_dt', $q);
        // $this->db->or_ilike('cotacao.cotacao_ds', $q);
        $where = " 1=1 ";
        if (!empty($pessoa_id)) {
            $where .= ' and cotacao.cotacao_pessoa_id = ' . $pessoa_id;
        }

        // echo $where_comp;exit;
        if(!empty($where_comp)){
            $where .=  $where_comp;
        }

        //  echo $where ;
        $this->db->where($where);
        $this->db->join('dados_unico.pessoa', 'cotacao.cotacao_pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.municipio m', 'm.municipio_id = pessoa.cotacao_municipio_id', 'left');
        $this->db->join('indice.territorio t', 't.territorio_id = m.territorio_id', 'left');
        // $this->db->limit($limit, $start);
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
        $this->db->join('dados_unico.pessoa as p2', 'cotacao.cotacao_pessoa_id = p2.pessoa_id', 'INNER');
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
    function deleteFull($id)
    {
        $sql = "delete from cotacao.produto_preco_cotacao where cotacao_id = $id; ";
        $sql .= "delete from cotacao.cotacao where cotacao_id = $id";

        // echo $sql;exit;
        if (!$this->db->query($sql)) {
            return 'erro_dependencia';
        }
    }
}

/* Final do arquivo Cotacao_model.php */
/* Local: ./application/models/Cotacao_model.php */
/* Data - 2022-09-06 10:24:28 */