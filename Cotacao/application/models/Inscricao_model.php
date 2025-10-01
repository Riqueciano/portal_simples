<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inscricao_model extends CI_Model
{

    public $table = 'cotacao.inscricao';
    public $id = 'inscricao_id';
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
    function get_by_cnpj($cnpj)
    {
        $this->db->where('cnpj', trim($cnpj));
        return $this->db->get($this->table)->row();
    }
    function get_by_cpf($cpf)
    {
        $this->db->where('responsavel_cpf', trim($cpf));
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        $this->db->ilike('cotacao.inscricao.inscricao_id', $q);
        $this->db->or_ilike('inscricao.responsavel_nm', $q);
        $this->db->or_ilike('inscricao.responsavel_cpf', $q);
        $this->db->or_ilike('inscricao.responsavel_email', $q);
        $this->db->or_ilike('inscricao.mensagem', $q);
        $this->db->or_ilike('inscricao.dt_create', $q);
        $this->db->or_ilike('inscricao.cnpj', $q);
        $this->db->or_ilike('inscricao.inscricao_municipio_id', $q);
        $this->db->or_ilike('inscricao.pessoa_id', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    public function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $filtroBusca = "";
        if ($q != NULL) {
            $q = addslashes($q);
            $filtroBusca = "
            AND (
                upper(remove_acentuacao(inscricao.responsavel_nm)) ILIKE upper(remove_acentuacao('%{$q}%'))
                OR upper(remove_acentuacao(inscricao.responsavel_cpf)) ILIKE upper(remove_acentuacao('%{$q}%'))
                OR upper(remove_acentuacao(inscricao.responsavel_email)) ILIKE upper(remove_acentuacao('%{$q}%'))
                OR upper(remove_acentuacao(inscricao.mensagem)) ILIKE upper(remove_acentuacao('%{$q}%'))
                OR upper(remove_acentuacao(inscricao.cnpj)) ILIKE upper(remove_acentuacao('%{$q}%'))
                OR upper(remove_acentuacao(municipio.municipio_nm)) ILIKE upper(remove_acentuacao('%{$q}%'))
                OR upper(remove_acentuacao(pessoa.pessoa_nm)) ILIKE upper(remove_acentuacao('%{$q}%'))
            )
        ";
        }

        $sql = "
        SELECT 
            inscricao.*,
            pessoa.*,
            municipio.*,
            comprador_categoria.*,
            log_ultimo.dt_cadastro AS ultimo_login,
            cotacoes.numero_cotacoes
        FROM cotacao.inscricao AS inscricao
        LEFT JOIN dados_unico.pessoa ON inscricao.pessoa_id = pessoa.pessoa_id
        LEFT JOIN indice.municipio ON inscricao.inscricao_municipio_id = municipio.municipio_id
        LEFT JOIN cotacao.comprador_categoria ON comprador_categoria.comprador_categoria_id = inscricao.comprador_categoria_id
        LEFT JOIN (
            SELECT pessoa_id, MAX(dt_cadastro) AS dt_cadastro
            FROM seguranca.log
            WHERE dt_cadastro IS NOT NULL
            GROUP BY pessoa_id
        ) AS log_ultimo ON log_ultimo.pessoa_id = pessoa.pessoa_id
        LEFT JOIN (
            SELECT cotacao_pessoa_id AS pessoa_id, COUNT(*) AS numero_cotacoes
            FROM cotacao.cotacao
            GROUP BY cotacao_pessoa_id
        ) AS cotacoes ON cotacoes.pessoa_id = pessoa.pessoa_id
        WHERE 1=1
        {$filtroBusca}
        ORDER BY inscricao.{$this->id} {$this->order}
        LIMIT {$limit} OFFSET {$start}
    ";



        $query = $this->db->query($sql);

        // print_r($query->result());
        // die();

        return $query->result();
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
        $this->db->join('dados_unico.pessoa', 'inscricao.pessoa_id = pessoa.pessoa_id', 'left');
        $this->db->join('indice.municipio', 'inscricao.inscricao_municipio_id = municipio.municipio_id', 'left');
        $this->db->join('cotacao.comprador_categoria', 'comprador_categoria.comprador_categoria_id = inscricao.comprador_categoria_id', 'left');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data
    function get_all_data_param($param, $order = null)
    {

        $this->db->select('*');

        $this->db->join('dados_unico.pessoa', 'inscricao.pessoa_id = pessoa.pessoa_id', 'left');
        $this->db->join('indice.municipio', 'inscricao.inscricao_municipio_id = municipio.municipio_id', 'left');
        $this->db->join('cotacao.comprador_categoria', 'comprador_categoria.comprador_categoria_id = inscricao.comprador_categoria_id', 'left');
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

/* Final do arquivo Inscricao_model.php */
/* Local: ./application/models/Inscricao_model.php */
/* Data - 2024-01-23 20:43:13 */