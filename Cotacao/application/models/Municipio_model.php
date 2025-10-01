<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Municipio_model extends CI_Model
{

    public $table = 'indice.municipio';
    public $id = 'municipio_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->model('Territorio_model');
    }


    function get_all_by_territorio_simples($territorio_id)
    {
        $this->db->select('municipio_id, municipio_nm');
        $this->db->where('territorio_id', $territorio_id);
        $this->db->order_by($this->table . '.' . 'municipio_nm', 'asc');
        return $this->db->get($this->table)->result();
    }


    function get_query_json($where = null, $limit = 99999, $start = 0)
    {
        $this->db->select('*');
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->limit($limit, $start);

        $retorno = $this->db->get($this->table)->result();

        //monta os filhos
        foreach ($retorno as $key => $i) {
            $i->territorio = $this->Territorio_model->get_by_id($i->territorio_id);
        }


        return $retorno;
    }


    // get all
    function get_all($param = null)
    {
        if (!empty($param)) {
            $this->db->where($param);
        }


        $this->db->order_by($this->table . '.' . 'municipio_nm', 'asc');
        return $this->db->get($this->table)->result();
    }

    // get all for combobox 
    function get_all_combobox($param = null, $order = null)
    {
        $this->db->select("$this->id as id, municipio_nm as text, municipio_id, municipio_nm");
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
        $this->db->ilike('indice.municipio.municipio_id', $q);
        $this->db->or_ilike('municipio.municipio_nm', $q);
        $this->db->or_ilike('municipio.municipio_st', $q);
        $this->db->or_ilike('municipio.territorio_id', $q);
        $this->db->or_ilike('municipio.estado_uf', $q);
        $this->db->or_ilike('municipio.flag_capital', $q);
        $this->db->or_ilike('municipio.incremento', $q);
        $this->db->or_ilike('municipio.setaf_id', $q);
        $this->db->or_ilike('municipio.adesao_semaf', $q);
        $this->db->or_ilike('municipio.dt_adesao_semaf', $q);
        $this->db->or_ilike('municipio.adesao_instrumento_id', $q);
        $this->db->or_ilike('municipio.adesao_instrumento_num', $q);
        $this->db->or_ilike('municipio.cod_ibge', $q);
        $this->db->or_ilike('municipio.cod_veri_ibge', $q);
        $this->db->or_ilike('municipio.ativo', $q);
        $this->db->or_ilike('municipio.flag_litoral', $q);
        $this->db->or_ilike('municipio.geom', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('municipio.municipio_id', $q);
        $this->db->or_ilike('municipio.municipio_nm', $q);
        $this->db->or_ilike('municipio.municipio_st', $q);
        $this->db->or_ilike('municipio.territorio_id', $q);
        $this->db->or_ilike('municipio.estado_uf', $q);
        $this->db->or_ilike('municipio.flag_capital', $q);
        $this->db->or_ilike('municipio.incremento', $q);
        $this->db->or_ilike('municipio.setaf_id', $q);
        $this->db->or_ilike('municipio.adesao_semaf', $q);
        $this->db->or_ilike('municipio.dt_adesao_semaf', $q);
        $this->db->or_ilike('municipio.adesao_instrumento_id', $q);
        $this->db->or_ilike('municipio.adesao_instrumento_num', $q);
        $this->db->or_ilike('municipio.cod_ibge', $q);
        $this->db->or_ilike('municipio.cod_veri_ibge', $q);
        $this->db->or_ilike('municipio.ativo', $q);
        $this->db->or_ilike('municipio.flag_litoral', $q);
        $this->db->or_ilike('municipio.geom', $q);
        $this->db->join('diaria.setaf', 'municipio.setaf_id = setaf.setaf_id', 'INNER');
        $this->db->join('indice.territorio', 'municipio.territorio_id = territorio.territorio_id', 'INNER');
        $this->db->join('monitoramento_semaf_old.instrumento', 'municipio.adesao_instrumento_id = instrumento.instrumento_id', 'INNER');
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
        // $this->db->join('diaria.setaf', 'municipio.setaf_id = setaf.setaf_id', 'INNER');
        $this->db->join('indice.territorio', 'municipio.territorio_id = territorio.territorio_id', 'INNER');
        // $this->db->join('monitoramento_semaf_old.instrumento', 'municipio.adesao_instrumento_id = instrumento.instrumento_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data
    function get_all_data_simples($param, $order = null)
    {

        $this->db->select('
                              municipio.municipio_id
                            , municipio.municipio_nm
                            , municipio.cod_veri_ibge
                            , territorio.territorio_id 
                            , territorio.territorio_nm 
        ');

        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .=  " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        // $this->db->join('diaria.setaf', 'municipio.setaf_id = setaf.setaf_id', 'INNER');
        $this->db->join('indice.territorio', 'municipio.territorio_id = territorio.territorio_id', 'INNER');
        // $this->db->join('monitoramento_semaf_old.instrumento', 'municipio.adesao_instrumento_id = instrumento.instrumento_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data

    function get_all_data_param($param, $order = null)
    {

        $this->db->select('*');


        // $this->db->join('diaria.setaf', 'municipio.setaf_id = setaf.setaf_id', 'INNER');
        $this->db->join('indice.territorio', 'municipio.territorio_id = territorio.territorio_id', 'INNER');
        // $this->db->join('monitoramento_semaf_old.instrumento', 'municipio.adesao_instrumento_id = instrumento.instrumento_id', 'INNER');
        $this->db->where($param);
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
}

/* Final do arquivo Municipio_model.php */
/* Local: ./application/models/Municipio_model.php */
/* Data - 2022-09-05 18:19:52 */