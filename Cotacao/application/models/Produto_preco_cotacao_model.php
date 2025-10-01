<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto_preco_cotacao_model extends CI_Model
{

    public $table = 'cotacao.produto_preco_cotacao';
    public $id = 'produto_preco_cotacao_id';
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

    // get total rows
    function total_rows($q = NULL)
    {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        $this->db->ilike('cotacao.produto_preco_cotacao.produto_preco_cotacao_id', $q);
        $this->db->or_ilike('produto_preco_cotacao.entidade_pessoa_id', $q);
        $this->db->or_ilike('produto_preco_cotacao.cotacao_id', $q);
        $this->db->or_ilike('produto_preco_cotacao.produto_id', $q);
        $this->db->or_ilike('produto_preco_cotacao.valor', $q);
        $this->db->or_ilike('produto_preco_cotacao.produto_preco_dt', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('produto_preco_cotacao.produto_preco_cotacao_id', $q);
        $this->db->or_ilike('produto_preco_cotacao.entidade_pessoa_id', $q);
        $this->db->or_ilike('produto_preco_cotacao.cotacao_id', $q);
        $this->db->or_ilike('produto_preco_cotacao.produto_id', $q);
        $this->db->or_ilike('produto_preco_cotacao.valor', $q);
        $this->db->or_ilike('produto_preco_cotacao.produto_preco_dt', $q);
        $this->db->join('cotacao.cotacao', 'produto_preco_cotacao.cotacao_id = cotacao.cotacao_id', 'INNER');
        $this->db->join('cotacao.produto', 'produto_preco_cotacao.produto_id = produto.produto_id', 'INNER');
        $this->db->join('selo.unidade_medida', 'produto.unidade_medida_id = unidade_medida.unidade_medida_id', 'inner');
        $this->db->join('dados_unico.pessoa', 'produto_preco_cotacao.entidade_pessoa_id = pessoa.pessoa_id', 'INNER');
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
        $this->db->join('cotacao.cotacao', 'produto_preco_cotacao.cotacao_id = cotacao.cotacao_id', 'INNER');
        $this->db->join('cotacao.produto', 'produto_preco_cotacao.produto_id = produto.produto_id', 'INNER');
        $this->db->join('selo.unidade_medida', 'produto.unidade_medida_id = unidade_medida.unidade_medida_id', 'inner');
        $this->db->join('dados_unico.pessoa', 'produto_preco_cotacao.entidade_pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('dados_unico.pessoa_fisica', 'pessoa_fisica.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.territorio', 'pessoa.cotacao_territorio_id = territorio.territorio_id', 'left');
        $this->db->join('indice.municipio', 'pessoa.cotacao_municipio_id = municipio.municipio_id', 'left');

        $this->db->join('cotacao.inscricao_fornecedor', 'pessoa.pessoa_id = inscricao_fornecedor.fornecedor_pessoa_id', 'inner');
        $this->db->join('dados_unico.funcionario f', 'pessoa.pessoa_id = f.pessoa_id', 'left');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data
    function get_all_precos($param, $order = null)
    {

        $this->db->select('
                            produto.produto_id,
                            produto.produto_nm, 
                            avg(valor) as valor, 
                            pessoa.pessoa_id,
                            pessoa.pessoa_nm, 
                            cast(produto_preco_dt as date) as produto_preco_dt,
                            inscricao_fornecedor.fornecedor_endereco,
                            f.funcionario_email
            ');

        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .=  " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->join('cotacao.cotacao', 'produto_preco_cotacao.cotacao_id = cotacao.cotacao_id', 'INNER');
        $this->db->join('cotacao.produto', 'produto_preco_cotacao.produto_id = produto.produto_id', 'INNER');
        $this->db->join('selo.unidade_medida', 'produto.unidade_medida_id = unidade_medida.unidade_medida_id', 'inner');
        $this->db->join('dados_unico.pessoa', 'produto_preco_cotacao.entidade_pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.territorio', 'pessoa.cotacao_territorio_id = territorio.territorio_id', 'left');
        $this->db->join('indice.municipio', 'pessoa.cotacao_municipio_id = municipio.municipio_id', 'left');
        $this->db->join('cotacao.inscricao_fornecedor', 'pessoa.pessoa_id = inscricao_fornecedor.fornecedor_pessoa_id', 'inner');
        $this->db->join('dados_unico.funcionario f', 'pessoa.pessoa_id = f.pessoa_id', 'left');
        $this->db->where($where);
        $this->db->order_by($order);
        $this->db->group_by('produto.produto_id, produto.produto_nm, pessoa.pessoa_id,pessoa.pessoa_nm, cast(produto_preco_dt as date),inscricao_fornecedor.fornecedor_endereco, f.funcionario_email ');
        return $this->db->get($this->table)->result();
    }  
    function get_indicadores($param, $order = null)
    {

        $this->db->select('avg(valor) as media, sum(valor) as soma');

        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .=  " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->join('cotacao.cotacao', 'produto_preco_cotacao.cotacao_id = cotacao.cotacao_id', 'INNER');
        $this->db->join('cotacao.produto', 'produto_preco_cotacao.produto_id = produto.produto_id', 'INNER');
        $this->db->join('selo.unidade_medida', 'produto.unidade_medida_id = unidade_medida.unidade_medida_id', 'inner');
        $this->db->join('dados_unico.pessoa', 'produto_preco_cotacao.entidade_pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.territorio', 'pessoa.cotacao_territorio_id = territorio.territorio_id', 'left');
        $this->db->join('indice.municipio', 'pessoa.cotacao_municipio_id = municipio.municipio_id', 'left');
        $this->db->where($where);
        $this->db->order_by($order);
        $this->db->group_by('cotacao.cotacao_id');
        return $this->db->get($this->table)->result();
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
    function delete_por_cotacao($cotacao_id)
    {
        $this->db->where('cotacao_id', $cotacao_id);

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }

    function get_produto_media($param)
    {

        $sql = "select 
                          p.produto_id
                        , p.produto_nm
                        , p.produto_ds
                        , p.produto_qtd
                        , md.unidade_medida_nm
                        , avg(ppc.valor) as valor_medio
                 from cotacao.produto_preco_cotacao ppc
                    inner join cotacao.produto p
                        on p.produto_id = ppc.produto_id
                    left join selo.unidade_medida md   
                        on md.unidade_medida_id = p.unidade_medida_id    
                        where 1=1 $param
                    group by p.produto_id
                            , p.produto_nm
                            , p.produto_ds
                            , p.produto_qtd
                            , md.unidade_medida_nm
                      
                    ";
         //echo_pre($sql);
        return $this->db->query($sql)->result();
    }
    function get_produto_cotacao($param)
    {

        $sql = "select distinct
                          p.produto_id
                        , p.produto_nm
                        , p.produto_qtd
                        , md.unidade_medida_nm 
                        , c.cotacao_id

                        , case exists (select pp.produto_id from cotacao.produto_preco_territorio ppt
                            inner join cotacao.produto_preco pp
                                on ppt.produto_preco_id = pp.produto_preco_id
                                    where  ppt.produto_preco_territorio_dt_cadastro::date BETWEEN (CURRENT_DATE::date - " . DIAS_VALIDADE_PRECO . ") and CURRENT_DATE::date  
                                    and ppt.produto_preco_territorio_ativo = 1 
                                    and ppt.produto_preco_territorio_valor > 0 
                                    and pp.ativo = 1
                                    and pp.produto_id = p.produto_id
                                    )    then 'ativo' else 'inativo' end as flag_ativo_inativo


                 from cotacao.produto_preco_cotacao ppc
                    inner join cotacao.produto p
                        on p.produto_id = ppc.produto_id
                    left join selo.unidade_medida md   
                        on md.unidade_medida_id = p.unidade_medida_id    

                    inner join cotacao.cotacao c
                        on c.cotacao_id = ppc.cotacao_id    
                        where 1=1 $param
                     
                      
                    ";
         //echo_pre($sql);
        return $this->db->query($sql)->result();
    }
}

/* Final do arquivo Produto_preco_cotacao_model.php */
/* Local: ./application/models/Produto_preco_cotacao_model.php */
/* Data - 2022-09-06 10:24:42 */