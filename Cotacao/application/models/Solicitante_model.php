<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Solicitante_model extends CI_Model
{

    public $table = 'selo.solicitante';
    public $id = 'solicitante_id';
    public $order = 'DESC';





    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->select('*');
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
        $this->db->select('*');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_by_pessoa_id($pessoa_id)
    {
        $this->db->select('*');
        $this->db->where('pessoa_id', $pessoa_id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/

        /*$this->db->ilike('selo.solicitante.solicitante_id', $q); */
        $this->db->or_ilike('solicitante.nome_da_entidade', $q);
        $this->db->or_ilike('solicitante.endereco', $q);
        $this->db->or_ilike('solicitante.telefone', $q);
        $this->db->or_ilike('solicitante.email', $q);
        $this->db->or_ilike('solicitante.cnpj_cpf', $q);
        $this->db->or_ilike('solicitante.dap_juridica_fisica', $q);
        $this->db->or_ilike('solicitante.qtd_associados', $q);
        $this->db->or_ilike('solicitante.qtd_mulheres', $q);
        $this->db->or_ilike('solicitante.qtd_jovens', $q);
        $this->db->or_ilike('solicitante.comunidades_envolvidas', $q);
        $this->db->or_ilike('solicitante.numero_cadsol', $q);
        $this->db->or_ilike('solicitante.responsavel', $q);
        $this->db->or_ilike('solicitante.responsavel_endereco', $q);
        $this->db->or_ilike('solicitante.responsavel_telefone', $q);
        $this->db->or_ilike('solicitante.responsavel_email', $q);
        $this->db->or_ilike('solicitante.responsavel_cpf', $q);
        $this->db->or_ilike('solicitante.responsavel_rg', $q);
        $this->db->or_ilike('solicitante.local_beneficiada_producao', $q);
        $this->db->or_ilike('solicitante.entidade_ater', $q);
        $this->db->or_ilike('solicitante.tecnico_ater_nm', $q);
        $this->db->or_ilike('solicitante.tecnico_ater_tel', $q);
        $this->db->or_ilike('solicitante.materia_prima', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');

        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        /*$this->db->ilike('solicitante.solicitante_id', $q); */
        $this->db->or_ilike('solicitante.nome_da_entidade', $q);
        $this->db->or_ilike('solicitante.endereco', $q);
        $this->db->or_ilike('solicitante.telefone', $q);
        $this->db->or_ilike('solicitante.email', $q);
        $this->db->or_ilike('solicitante.cnpj_cpf', $q);
        $this->db->or_ilike('solicitante.dap_juridica_fisica', $q);
        $this->db->or_ilike('solicitante.qtd_associados', $q);
        $this->db->or_ilike('solicitante.qtd_mulheres', $q);
        $this->db->or_ilike('solicitante.qtd_jovens', $q);
        $this->db->or_ilike('solicitante.comunidades_envolvidas', $q);
        $this->db->or_ilike('solicitante.numero_cadsol', $q);
        $this->db->or_ilike('solicitante.responsavel', $q);
        $this->db->or_ilike('solicitante.responsavel_endereco', $q);
        $this->db->or_ilike('solicitante.responsavel_telefone', $q);
        $this->db->or_ilike('solicitante.responsavel_email', $q);
        $this->db->or_ilike('solicitante.responsavel_cpf', $q);
        $this->db->or_ilike('solicitante.responsavel_rg', $q);
        $this->db->or_ilike('solicitante.local_beneficiada_producao', $q);
        $this->db->or_ilike('solicitante.entidade_ater', $q);
        $this->db->or_ilike('solicitante.tecnico_ater_nm', $q);
        $this->db->or_ilike('solicitante.tecnico_ater_tel', $q);
        $this->db->or_ilike('solicitante.materia_prima', $q);
        $this->db->join('dados_unico.pessoa', 'solicitante.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.municipio', 'solicitante.municipio_id = municipio.municipio_id', 'INNER');
        $this->db->join('selo.solicitante_tipo', 'solicitante.solicitante_tipo_id = solicitante_tipo.solicitante_tipo_id', 'INNER');
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
        $this->db->join('dados_unico.pessoa', 'solicitante.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.municipio', 'solicitante.municipio_id = municipio.municipio_id', 'INNER');
        $this->db->join('selo.solicitante_tipo', 'solicitante.solicitante_tipo_id = solicitante_tipo.solicitante_tipo_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data



    function get_all_data_param($param = null, $order = null)
    {

        $this->db->select('*');


        $this->db->join('dados_unico.pessoa', 'solicitante.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.municipio', 'solicitante.municipio_id = municipio.municipio_id', 'INNER');
        $this->db->join('selo.solicitante_tipo', 'solicitante.solicitante_tipo_id = solicitante_tipo.solicitante_tipo_id', 'INNER');
        $this->db->where($param);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data



    function get_all_1xN($param = null, $order = null)
    {


        // Tabelas relacionadas  
        $joins =  [
            [
                'schema' => 'dados_unico',
                'table' => 'pessoa',
                'local_key' => 'pessoa_id',
                'foreign_key' => 'pessoa_id',
            ],
            [
                'schema' => 'indice',
                'table' => 'municipio',
                'local_key' => 'municipio_id',
                'foreign_key' => 'municipio_id',
            ],
            [
                'schema' => 'selo',
                'table' => 'solicitante_tipo',
                'local_key' => 'solicitante_tipo_id',
                'foreign_key' => 'solicitante_tipo_id',
            ],
        ];
        $this->db->select('*');

        if (!empty($order)) {
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

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }
}

/* Final do arquivo Solicitante_model.php */
/* Local: ./application/models/Solicitante_model.php */
/* Data - 2025-08-21 20:57:26 */