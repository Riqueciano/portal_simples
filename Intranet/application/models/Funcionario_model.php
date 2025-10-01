<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Funcionario_model extends CI_Model
{

    public $table = 'dados_unico.funcionario';
    public $id = 'funcionario_id';
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

    function get($param )
    {
       
        $sql = "

                     select v.*,p.pessoa_st,ft.funcionario_tipo_id from vi_pessoa_todos v
                            inner join dados_unico.pessoa p
                                on p.pessoa_id = v.pessoa_id
                            inner join dados_unico.est_organizacional eo
                                on v.est_organizacional_id = eo.est_organizacional_id
                            inner join dados_unico.funcionario f
                                on f.pessoa_id = v.pessoa_id
                            inner join dados_unico.funcionario_tipo ft
                                on ft.funcionario_tipo_id = f.funcionario_tipo_id
                        where 1=1 $param and p.pessoa_st =0 and eo.est_organizacional_st =0
                            and eo.est_organizacional_sigla not ilike '%apagar%'
                        order by trim(upper(v.pessoa_nm))		
                        
                                ";

        return $this->db->query($sql)->result();
    }


    // get total rows
    function total_rows($q = NULL)
    {
        
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
  
       
        $this->db->or_ilike('funcionario.funcionario_email', $q); 

        $this->db->join('dados_unico.cargo', 'funcionario.cargo_permanente = cargo.cargo_id', 'INNER');
        $this->db->join('dados_unico.cargo as c2', 'funcionario.cargo_temporario = c2.cargo_id', 'INNER');
        $this->db->join('dados_unico.contrato', 'funcionario.contrato_id = contrato.contrato_id', 'INNER');
        $this->db->join('dados_unico.est_organizacional_lotacao', 'funcionario.est_organizacional_lotacao_id = est_organizacional_lotacao.est_organizacional_lotacao_id', 'INNER');
        $this->db->join('dados_unico.funcao', 'funcionario.funcao_id = funcao.funcao_id', 'INNER');
        $this->db->join('dados_unico.funcionario_tipo', 'funcionario.funcionario_tipo_id = funcionario_tipo.funcionario_tipo_id', 'INNER');
        $this->db->join('dados_unico.orgao', 'funcionario.funcionario_orgao_destino = orgao.orgao_id', 'INNER');
        $this->db->join('dados_unico.orgao as o2', 'funcionario.funcionario_orgao_origem = o2.orgao_id', 'INNER');
        $this->db->join('dados_unico.pessoa_fisica', 'funcionario.pessoa_id = pessoa_fisica.pessoa_id', 'INNER');
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
        $this->db->join('dados_unico.cargo', 'funcionario.cargo_permanente = cargo.cargo_id', 'INNER');
        $this->db->join('dados_unico.cargo as c2', 'funcionario.cargo_temporario = c2.cargo_id', 'INNER');
        $this->db->join('dados_unico.contrato', 'funcionario.contrato_id = contrato.contrato_id', 'INNER');
        $this->db->join('dados_unico.est_organizacional_lotacao', 'funcionario.est_organizacional_lotacao_id = est_organizacional_lotacao.est_organizacional_lotacao_id', 'INNER');
        $this->db->join('dados_unico.funcao', 'funcionario.funcao_id = funcao.funcao_id', 'INNER');
        $this->db->join('dados_unico.funcionario_tipo', 'funcionario.funcionario_tipo_id = funcionario_tipo.funcionario_tipo_id', 'INNER');
        $this->db->join('dados_unico.orgao', 'funcionario.funcionario_orgao_destino = orgao.orgao_id', 'INNER');
        $this->db->join('dados_unico.orgao as o2', 'funcionario.funcionario_orgao_origem = o2.orgao_id', 'INNER');
        $this->db->join('dados_unico.pessoa_fisica', 'funcionario.pessoa_id = pessoa_fisica.pessoa_id', 'INNER');
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
    function delete($id)
    {
        $this->db->where($this->id, $id);

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }
}

/* Final do arquivo Funcionario_model.php */
/* Local: ./application/models/Funcionario_model.php */
/* Data - 2024-01-23 21:14:10 */