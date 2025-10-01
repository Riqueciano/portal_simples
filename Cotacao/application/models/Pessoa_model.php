<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pessoa_model extends CI_Model
{

    public $table = 'dados_unico.pessoa';
    public $id = 'pessoa_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }




    function get_solicitado_para($solicitado_para_pessoa_id_in = null, $territorio_id = null, $municipio_id = null)
    {

        $param_pessoa = "";
        if (!empty($solicitado_para_pessoa_id_in)) {
            $param_pessoa = " and p.pessoa_id in $solicitado_para_pessoa_id_in";
        }
        if (!empty($territorio_id)) {
            $param_pessoa .= " and p.cotacao_territorio_id = $territorio_id";
        }
        if (!empty($municipio_id)) {
            $param_pessoa .= " and p.cotacao_municipio_id = $municipio_id";
        }

        $sql = "select * from dados_unico.pessoa p
                            inner join vi_login v
                                on v.pessoa_id = p.pessoa_id
                            inner join indice.territorio t
                                on t.territorio_id = p.cotacao_territorio_id
                        where v.sistema_id = 104/*cotacao*/ 
                                and v.tipo_usuario_id = 443/*comprador*/
                                $param_pessoa 

                        order by remove_acentuacao(p.pessoa_nm) asc
                ";

        return $this->db->query($sql)->result();
    }


    function get_solicitado_para_so_escolas($solicitado_para_pessoa_id_in = null, $territorio_id = null, $municipio_id = null)
    {

        $param_pessoa = "";
        if (!empty($solicitado_para_pessoa_id_in)) {
            $param_pessoa = " and p.pessoa_id in $solicitado_para_pessoa_id_in";
        }
        if (!empty($territorio_id)) {
            $param_pessoa .= " and p.cotacao_territorio_id = $territorio_id";
        }
        if (!empty($municipio_id)) {
            $param_pessoa .= " and p.cotacao_municipio_id = $municipio_id";
        }

        $sql = "select * from dados_unico.pessoa p 
                    left join indice.territorio t
                        on t.territorio_id = p.cotacao_territorio_id
                        where p.flag_escola = 1 
                                $param_pessoa 
                        order by remove_acentuacao(p.pessoa_nm) asc
                ";

        return $this->db->query($sql)->result();
    }

    function verifica_pessoa_existe($email)
    {

        $sql = "select * from seguranca.usuario where usuario_login ilike '$email'
                            order by usuario_dt_criacao asc limit 1 ";

        return $this->db->query($sql)->row();
    }


    function get_entidade_territorio($territorio_id = 0, $param = null, $flag_exibir_produtos = null)
    {
        $DIAS_VALIDADE_PRECO = DIAS_VALIDADE_PRECO;
        $param_territorio = "";
        if (!empty($territorio_id)) {
            $param_territorio = " and t.territorio_id = $territorio_id";
        }

        if (!empty($param)) {
            $param_territorio .= $param;
        }

        if (!empty($flag_exibir_produtos)) {
            
            if($flag_exibir_produtos == 'com_produtos'){
                $param_territorio .= " and p.pessoa_id in (
                                                            SELECT ppt.produto_preco_territorio_pessoa_id
                                                            FROM cotacao.produto_preco_territorio ppt where ppt.produto_preco_territorio_valor >0 and ppt.produto_preco_territorio_ativo =1
                                                           )";
            }
            if($flag_exibir_produtos == 'sem_produtos'){
                $param_territorio .= " and p.pessoa_id not in (
                                                            SELECT ppt.produto_preco_territorio_pessoa_id
                                                            FROM cotacao.produto_preco_territorio ppt where ppt.produto_preco_territorio_valor >0 and ppt.produto_preco_territorio_ativo =1
                                                           )";
            }
 
        }


        $sql = "select 
                                    p.*
                                    , t.*
                                    , m.municipio_id
                                    , m.municipio_nm
                                    , (select if2.responsavel_telefone from cotacao.inscricao_fornecedor if2 where if2.fornecedor_pessoa_id = p.pessoa_id limit 1) as responsavel_telefone
                                    , (select if2.fornecedor_email from cotacao.inscricao_fornecedor if2 where if2.fornecedor_pessoa_id = p.pessoa_id limit 1) as fornecedor_email
                                    from dados_unico.pessoa p 
                                        left join indice.municipio m
                                            on m.municipio_id = p.cotacao_municipio_id
                                        left join indice.territorio t
                                            on t.territorio_id = p.cotacao_territorio_id
                                            where p.fornecedor_categoria_id is not null and p.pessoa_st = 0
        
                                    $param_territorio
                                    ";
  


        return $this->db->query($sql)->result();
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
        $this->db->where("pessoa.pessoa_id = $id");
        $this->db->join('dados_unico.pessoa_fisica', 'pessoa.pessoa_id = pessoa_fisica.pessoa_id', 'left');
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        $this->db->ilike('dados_unico.pessoa.pessoa_id', $q);
        $this->db->or_ilike('pessoa.pessoa_nm', $q);
        $this->db->or_ilike('pessoa.pessoa_tipo', $q);
        $this->db->or_ilike('pessoa.pessoa_email', $q);
        $this->db->or_ilike('pessoa.pessoa_st', $q);
        $this->db->or_ilike('pessoa.pessoa_dt_criacao', $q);
        $this->db->or_ilike('pessoa.pessoa_dt_alteracao', $q);
        $this->db->or_ilike('pessoa.pessoa_usuario_criador', $q);
        $this->db->or_ilike('pessoa.setaf_id', $q);
        $this->db->or_ilike('pessoa.ater_contrato_id', $q);
        $this->db->or_ilike('pessoa.lote_id', $q);
        $this->db->or_ilike('pessoa.flag_usuario_acervo_digital', $q);
        $this->db->or_ilike('pessoa.cpf_autor', $q);
        $this->db->or_ilike('pessoa.instituicao_autor', $q);
        $this->db->or_ilike('pessoa.semaf_municipio_id', $q);
        $this->db->or_ilike('pessoa.ppa_municipio_id', $q);
        $this->db->or_ilike('pessoa.empresa_id', $q);
        $this->db->or_ilike('pessoa.flag_cadastro_externo', $q);
        $this->db->or_ilike('pessoa.menipolicultor_territorio_id', $q);
        $this->db->or_ilike('pessoa.sipaf_municipio_id', $q);
        $this->db->or_ilike('pessoa.prefeito_municipio_id', $q);
        $this->db->or_ilike('pessoa.cartorio_municipio_id', $q);
        $this->db->or_ilike('pessoa.proposta_dupla_numero', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('pessoa.pessoa_id', $q);
        $this->db->or_ilike('pessoa.pessoa_nm', $q);
        $this->db->or_ilike('pessoa.pessoa_tipo', $q);
        $this->db->or_ilike('pessoa.pessoa_email', $q);
        $this->db->or_ilike('pessoa.pessoa_st', $q);
        $this->db->or_ilike('pessoa.pessoa_dt_criacao', $q);
        $this->db->or_ilike('pessoa.pessoa_dt_alteracao', $q);
        $this->db->or_ilike('pessoa.pessoa_usuario_criador', $q);
        $this->db->or_ilike('pessoa.setaf_id', $q);
        $this->db->or_ilike('pessoa.ater_contrato_id', $q);
        $this->db->or_ilike('pessoa.lote_id', $q);
        $this->db->or_ilike('pessoa.flag_usuario_acervo_digital', $q);
        $this->db->or_ilike('pessoa.cpf_autor', $q);
        $this->db->or_ilike('pessoa.instituicao_autor', $q);
        $this->db->or_ilike('pessoa.semaf_municipio_id', $q);
        $this->db->or_ilike('pessoa.ppa_municipio_id', $q);
        $this->db->or_ilike('pessoa.empresa_id', $q);
        $this->db->or_ilike('pessoa.flag_cadastro_externo', $q);
        $this->db->or_ilike('pessoa.menipolicultor_territorio_id', $q);
        $this->db->or_ilike('pessoa.sipaf_municipio_id', $q);
        $this->db->or_ilike('pessoa.prefeito_municipio_id', $q);
        $this->db->or_ilike('pessoa.cartorio_municipio_id', $q);
        $this->db->or_ilike('pessoa.proposta_dupla_numero', $q);
        $this->db->join('diaria.setaf', 'pessoa.setaf_id = setaf.setaf_id', 'INNER');
        $this->db->join('indice.municipio', 'pessoa.cartorio_municipio_id = municipio.municipio_id', 'INNER');
        $this->db->join('indice.municipio as m2', 'pessoa.ppa_municipio_id = m2.municipio_id', 'INNER');
        $this->db->join('indice.municipio as m3', 'pessoa.prefeito_municipio_id = m3.municipio_id', 'INNER');
        $this->db->join('indice.municipio as m4', 'pessoa.semaf_municipio_id = m4.municipio_id', 'INNER');
        $this->db->join('indice.territorio', 'pessoa.menipolicultor_territorio_id = territorio.territorio_id', 'INNER');
        $this->db->join('sigater_dados.empresa', 'pessoa.empresa_id = empresa.empresa_id', 'INNER');
        $this->db->join('sigater_indireta-old.lote', 'pessoa.lote_id = lote.lote_id', 'INNER');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }


    function get_usuarios_cotacao()
    {
        $sql = "select * from vi_login vl
                    inner join vi_pessoa_todos vp
                        on vl.pessoa_id = vp.pessoa_id
                                    where vl.sistema_id = 104 /*sistema de cotação*/
                    order by vl.tipo_usuario_ds, vp.pessoa_nm      ";

        return $this->db->query($sql)->result();
    }
    function get_fonecedores()
    {
        $sql = "select tipo_usuario_ds,* from vi_login vl
                    inner join vi_pessoa_todos vp
                        on vl.pessoa_id = vp.pessoa_id
                                    where vl.sistema_id = 104 and vl.tipo_usuario_id =442
                    order by vl.tipo_usuario_ds, vp.pessoa_nm      ";

        return $this->db->query($sql)->result();
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
        $this->db->join('diaria.setaf', 'pessoa.setaf_id = setaf.setaf_id', 'INNER');
        $this->db->join('indice.municipio', 'pessoa.cartorio_municipio_id = municipio.municipio_id', 'INNER');
        $this->db->join('indice.municipio as m2', 'pessoa.ppa_municipio_id = m2.municipio_id', 'INNER');
        $this->db->join('indice.municipio as m3', 'pessoa.prefeito_municipio_id = m3.municipio_id', 'INNER');
        $this->db->join('indice.municipio as m4', 'pessoa.semaf_municipio_id = m4.municipio_id', 'INNER');
        $this->db->join('indice.territorio', 'pessoa.menipolicultor_territorio_id = territorio.territorio_id', 'INNER');
        $this->db->join('sigater_dados.empresa', 'pessoa.empresa_id = empresa.empresa_id', 'INNER');
        $this->db->join('sigater_indireta-old.lote', 'pessoa.lote_id = lote.lote_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data
    function get_all_data_param($param, $order = null)
    {

        $this->db->select('*');



        $this->db->where($param);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    }  

    function get_all_fornecedores_param($param, $order = null)
    {

        $this->db->select('*');

        
        $this->db->join('cotacao.inscricao_fornecedor', 'pessoa.pessoa_id = inscricao_fornecedor.fornecedor_pessoa_id', 'left');
        $this->db->join('cotacao.fornecedor_categoria', 'pessoa.fornecedor_categoria_id = fornecedor_categoria.fornecedor_categoria_id', 'left');
        $this->db->join('indice.municipio', 'pessoa.cotacao_municipio_id = municipio.municipio_id', 'left');
        $this->db->join('indice.territorio', 'pessoa.cotacao_territorio_id = territorio.territorio_id', 'left');
        $this->db->join('dados_unico.funcionario', 'pessoa.pessoa_id = funcionario.pessoa_id', 'left');
        $this->db->join('dados_unico.pessoa_fisica', 'pessoa.pessoa_id = pessoa_fisica.pessoa_id', 'left');
        $this->db->where($param);
        $this->db->order_by($order);
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
}

/* Final do arquivo Pessoa_model.php */
/* Local: ./application/models/Pessoa_model.php */
/* Data - 2022-09-05 18:18:53 */