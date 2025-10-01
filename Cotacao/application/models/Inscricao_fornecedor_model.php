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

        $this->load->model('Pessoa_model');
        $this->load->model('Municipio_model');
        $this->load->model('Territorio_model');
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
    function get_by_pessoa_id($id)
    {
        $this->db->where("fornecedor_pessoa_id = $id");
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        $this->db->ilike('cotacao.inscricao_fornecedor.inscricao_fornecedor_id', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_pessoa_id', $q);
        $this->db->or_ilike('inscricao_fornecedor.responsavel_nm', $q);
        $this->db->or_ilike('inscricao_fornecedor.responsavel_cpf', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_email', $q);
        $this->db->or_ilike('inscricao_fornecedor.responsavel_telefone', $q);
        $this->db->or_ilike('inscricao_fornecedor.dt_cadastro', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_nm', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_nm_fantasia', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_cnpj', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_municipio_id', $q);
        $this->db->or_ilike('inscricao_fornecedor.autorizador_cadastro_gestor_pessoa_id', $q);
        $this->db->or_ilike('inscricao_fornecedor.reprovado_motivo', $q);
        $this->db->or_ilike('inscricao_fornecedor.dap_caf', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_query_json_old($where = null, $q = null, $limit = 99999, $start = 0, $tabelas = array())
    {
        $this->db->select('*');
        if ($where != null) {
            $this->db->where($where);
        }

        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->limit($limit, $start);

        if ($q != null) {
            $this->db->ilike('cotacao.cachorro.cachorro_id', $q);
            $this->db->or_ilike('cachorro.cachorro_nm', $q);
            $this->db->or_ilike('cachorro.raca_id', $q);
        } //end if

        //realiza a consulta
        $retorno = $this->db->get($this->table)->result();
        //adiciona as tabelas referencia ao array para ser utilizado como json no front
        //montando os "joins"
        foreach ($retorno as $key => $ret) {
            foreach ($tabelas as $key => $tb) {
                // print_r($tb['id']); 
                // print_r($tb['tabela']); 
                $tabela_model = ucfirst($tb['tabela'] . '_model');
                $tabela_id = $tb['tabela'] . "_id";
                $tabela = $tb['tabela'];
                $cardinalidade = $tb['cardinalidade'];
                if ($cardinalidade == '1') {
                    $ret->$tabela = $this->$tabela_model->get_by_id($ret->$tabela_id);
                } else if ($cardinalidade == 'n') {
                    $ret->$tabela = $this->$tabela_model->get_all_data_param($tabela . '.' . $tabela_id . ' = ' . $ret->$tabela_id);
                }
            }
        }

        return $retorno;
    }
    // get data with limit and search
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
            $i->pessoa = $this->Pessoa_model->get_by_id($i->fornecedor_pessoa_id);
            $i->municipio = $this->Municipio_model->get_by_id($i->fornecedor_municipio_id);
        }


        return $retorno;
    }


    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);

        $this->db->ilike('inscricao_fornecedor.inscricao_fornecedor_id', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_pessoa_id', $q);
        $this->db->or_ilike('inscricao_fornecedor.responsavel_nm', $q);
        $this->db->or_ilike('inscricao_fornecedor.responsavel_cpf', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_email', $q);
        $this->db->or_ilike('inscricao_fornecedor.responsavel_telefone', $q);
        $this->db->or_ilike('inscricao_fornecedor.dt_cadastro', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_nm', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_nm_fantasia', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_cnpj', $q);
        $this->db->or_ilike('inscricao_fornecedor.fornecedor_municipio_id', $q);
        $this->db->or_ilike('inscricao_fornecedor.autorizador_cadastro_gestor_pessoa_id', $q);
        $this->db->or_ilike('inscricao_fornecedor.reprovado_motivo', $q);
        $this->db->or_ilike('inscricao_fornecedor.dap_caf', $q);


        // $this->db->join('dados_unico.pessoa', 'inscricao_fornecedor.autorizador_cadastro_gestor_pessoa_id = pessoa.pessoa_id', 'LEFT');
        $this->db->join('dados_unico.pessoa as p2', 'inscricao_fornecedor.fornecedor_pessoa_id = p2.pessoa_id', 'LEFT');
        $this->db->join('indice.municipio', 'inscricao_fornecedor.fornecedor_municipio_id = municipio.municipio_id', 'inner');
        $this->db->join('indice.territorio', 'municipio.territorio_id = territorio.territorio_id', 'inner');
        $this->db->join('cotacao.fornecedor_categoria', 'inscricao_fornecedor.fornecedor_categoria_id = fornecedor_categoria.fornecedor_categoria_id', 'LEFT');
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
        $this->db->join('dados_unico.pessoa', 'inscricao_fornecedor.autorizador_cadastro_gestor_pessoa_id = pessoa.pessoa_id', 'LEFT');
        $this->db->join('dados_unico.pessoa as p2', 'inscricao_fornecedor.fornecedor_pessoa_id = p2.pessoa_id', 'LEFT');
        $this->db->join('indice.municipio', 'inscricao_fornecedor.fornecedor_municipio_id = municipio.municipio_id', 'LEFT');
        $this->db->join('cotacao.fornecedor_categoria', 'inscricao_fornecedor.fornecedor_categoria_id = fornecedor_categoria.fornecedor_categoria_id', 'LEFT');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data


    function get_all_data_param($param= null)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
 


        // $this->db->join('dados_unico.pessoa', 'inscricao_fornecedor.autorizador_cadastro_gestor_pessoa_id = pessoa.pessoa_id', 'LEFT');
        $this->db->join('dados_unico.pessoa as p2', 'inscricao_fornecedor.fornecedor_pessoa_id = p2.pessoa_id', 'LEFT');
        $this->db->join('indice.municipio', 'inscricao_fornecedor.fornecedor_municipio_id = municipio.municipio_id', 'inner');
        $this->db->join('indice.territorio', 'municipio.territorio_id = territorio.territorio_id', 'inner');
        $this->db->join('cotacao.fornecedor_categoria', 'inscricao_fornecedor.fornecedor_categoria_id = fornecedor_categoria.fornecedor_categoria_id', 'LEFT');

        if(!empty($param)){
            $this->db->where($param);
        }


        return $this->db->get($this->table)->result();
    }

    function get_all_data_param_old($param, $order = null)
    {
        // Monta cláusula WHERE dinamicamente a partir de $param
        $where = "1=1";
        if (!empty($param) && is_array($param)) {
            foreach ($param as $key => $value) {
                $value = addslashes($value);
                $where .= " AND {$key} = '{$value}'";
            }
        }

        // Monta cláusula ORDER BY dinamicamente a partir de $order
        $orderBy = "";
        if (!empty($order)) {
            if (is_array($order)) {
                $orderParts = [];
                foreach ($order as $col => $dir) {
                    $orderParts[] = "{$col} {$dir}";
                }
                $orderBy = "ORDER BY " . implode(', ', $orderParts);
            } else {
                $orderBy = "ORDER BY {$order}";
            }
        }

        // SQL completo com joins e último login
        $sql = "
            SELECT 
                inscricao_fornecedor.*,
                p2.*,
                municipio.*,
                territorio.*,
                fornecedor_categoria.*,
                log_ultimo.dt_cadastro AS ultimo_login,
                quantidade_email_registrado.registros_email_login,
                quantidade_email_registrado_inscricao.registros_email_inscricao,
                produtos_por_pessoa.numero_produtos_ativos,
                produtos_por_pessoa.numero_produtos_inativos
            FROM cotacao.inscricao_fornecedor
            LEFT JOIN dados_unico.pessoa AS p2 
                ON inscricao_fornecedor.fornecedor_pessoa_id = p2.pessoa_id
            LEFT JOIN indice.municipio 
                ON inscricao_fornecedor.fornecedor_municipio_id = municipio.municipio_id
            INNER JOIN indice.territorio 
                ON municipio.territorio_id = territorio.territorio_id
            LEFT JOIN cotacao.fornecedor_categoria 
                ON inscricao_fornecedor.fornecedor_categoria_id = fornecedor_categoria.fornecedor_categoria_id
            LEFT JOIN (
                SELECT pessoa_id, MAX(dt_cadastro) AS dt_cadastro
                FROM seguranca.log
                WHERE dt_cadastro IS NOT NULL
                GROUP BY pessoa_id
            ) AS log_ultimo 
                ON log_ultimo.pessoa_id = p2.pessoa_id

            LEFT JOIN (
                SELECT 
                    usuario_login, 
                    COUNT(*) AS registros_email_login
                FROM seguranca.usuario
                GROUP BY usuario_login
            ) AS quantidade_email_registrado
                ON quantidade_email_registrado.usuario_login = inscricao_fornecedor.fornecedor_email
            
            LEFT JOIN (
                SELECT 
                    fornecedor_email,
                    COUNT(*) AS registros_email_inscricao
                FROM cotacao.inscricao_fornecedor
                WHERE fornecedor_email IS NOT NULL
                GROUP BY fornecedor_email
            ) AS quantidade_email_registrado_inscricao
                ON quantidade_email_registrado_inscricao.fornecedor_email = inscricao_fornecedor.fornecedor_email

            LEFT JOIN (
                SELECT 
                    produto_preco_territorio_pessoa_id AS pessoa_id,
                    COUNT(CASE WHEN produto_preco_territorio_ativo = 1 THEN 1 END) AS numero_produtos_ativos,
                    COUNT(CASE WHEN produto_preco_territorio_ativo = 0 THEN 1 END) AS numero_produtos_inativos
                FROM cotacao.produto_preco_territorio
                GROUP BY produto_preco_territorio_pessoa_id
            ) AS produtos_por_pessoa
                ON produtos_por_pessoa.pessoa_id = p2.pessoa_id

            WHERE {$where}
            {$orderBy};
        ";

        // print_r($this->db->query($sql)->result());
        // die();

        // Executa a consulta e retorna os resultados
        return $this->db->query($sql)->result();
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
   /*function delete($id)
    {
        $this->db->where($this->id, $id);

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }*/
}

/* Final do arquivo Inscricao_fornecedor_model.php */
/* Local: ./application/models/Inscricao_fornecedor_model.php */
/* Data - 2024-06-04 16:12:57 */