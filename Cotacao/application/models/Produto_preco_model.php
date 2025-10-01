<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto_preco_model extends CI_Model
{

    public $table = 'cotacao.produto_preco';
    public $id = 'produto_preco_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }


    function get_produto_preco_por_pessoa_territorio($pessoa_id = NULL, $territorio_id = NULL, $param_complemento = null)
    {

        if (!empty($territorio_id)) {
            $param_territorio_id = " and ppt.territorio_id = $territorio_id";
        } else {
            $param_territorio_id = "";
        }
        if (!empty($pessoa_id)) {
            $param_pessoa_id = " and pp.pessoa_id = $pessoa_id";
        } else {
            $param_pessoa_id = "";
        }


        $sql = "
               SELECT 
                    p.produto_nm,
                    ppt.produto_preco_territorio_valor,
                    ppt.produto_preco_territorio_dt_cadastro,
                    ppt.produto_preco_territorio_dt_cadastro::DATE + INTERVAL '" . DIAS_VALIDADE_PRECO . " days' AS produto_preco_dt_validade,
                    CASE
                        WHEN ppt.produto_preco_territorio_dt_cadastro::DATE + INTERVAL '" . DIAS_VALIDADE_PRECO . " days' < CURRENT_DATE THEN 'Fora do Prazo'
                        ELSE 'Dentro do Prazo'
                    END AS status_validade
                FROM cotacao.produto_preco_territorio ppt
                INNER JOIN cotacao.produto_preco pp
                    ON pp.produto_preco_id = ppt.produto_preco_id
                INNER JOIN cotacao.produto p
                    ON p.produto_id = pp.produto_id
                INNER JOIN dados_unico.pessoa pes
                    on pes.pessoa_id = pp.pessoa_id    
                WHERE ppt.produto_preco_territorio_ativo = 1 
                    $param_territorio_id
                    $param_pessoa_id
                    $param_complemento
                    and ppt.produto_preco_territorio_valor > 0 and pes.pessoa_st =0 /*ativo*/
                ORDER BY p.produto_nm;

                 ";

      
        //    return ($sql);
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
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        $this->db->ilike('cotacao.produto_preco.produto_preco_id', $q);
        $this->db->or_ilike('produto_preco.produto_id', $q);
        $this->db->or_ilike('produto_preco.pessoa_id', $q);
        $this->db->or_ilike('produto_preco.valor', $q);
        $this->db->or_ilike('produto_preco.produto_preco_dt', $q);
        $this->db->or_ilike('produto_preco.ativo', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('produto_preco.produto_preco_id', $q);
        $this->db->or_ilike('produto_preco.produto_id', $q);
        $this->db->or_ilike('produto_preco.pessoa_id', $q);
        $this->db->or_ilike('produto_preco.valor', $q);
        $this->db->or_ilike('produto_preco.produto_preco_dt', $q);
        $this->db->or_ilike('produto_preco.ativo', $q);
        $this->db->join('cotacao.produto', 'produto_preco.produto_id = produto.produto_id', 'INNER');
        $this->db->join('dados_unico.pessoa', 'produto_preco.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }


    function inativaTodos($produto_id, $pessoa_id)
    {

        //proteção
        if (empty($produto_id) or empty($pessoa_id)) {
            echo "Produto ou Pessoa não informado";
            exit;
        }


        $sql = "update cotacao.produto_preco
                set ativo = 0
                where produto_id = $produto_id 
                    and pessoa_id = $pessoa_id
                    
                    ;
 
                update cotacao.produto_preco_territorio
                set produto_preco_territorio_ativo = 0
                where produto_preco_territorio_produto_id = $produto_id 
                    and produto_preco_territorio_pessoa_id = $pessoa_id;   
                    
  
        ";
        $this->db->query($sql);
    }

    function get_all_data($param, $order = null, $limit = null, $flag_territorio = 0)
    {

        $this->db->select("*, '$flag_territorio' as flag_territorio");

        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .=  " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->join('cotacao.produto', 'produto_preco.produto_id = produto.produto_id', 'INNER');
        $this->db->join('selo.unidade_medida', 'unidade_medida.unidade_medida_id = produto.unidade_medida_id', 'INNER');
        $this->db->join('dados_unico.pessoa', 'produto_preco.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.territorio', 'territorio.territorio_id = pessoa.cotacao_territorio_id', 'left');
        $this->db->join('indice.municipio', 'municipio.municipio_id = pessoa.cotacao_municipio_id', 'left');
        $this->db->where($where);
        $this->db->order_by($order);

        if (!empty($limit)) {
            $this->db->limit($limit, 0);
        }

        return $this->db->get($this->table)->result();
    }

    function get_all_historico_preco_simples($param, $order = null, $limit = null, $flag_territorio = 0)
    {

        $this->db->select("*, '$flag_territorio' as flag_territorio");

        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .=  " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->join('cotacao.produto_preco_territorio', 'produto_preco.produto_preco_id = produto_preco_territorio.produto_preco_id', 'inner');
        $this->db->join('cotacao.produto', 'produto_preco.produto_id = produto.produto_id', 'INNER');
        $this->db->join('selo.unidade_medida', 'unidade_medida.unidade_medida_id = produto.unidade_medida_id', 'INNER');
        $this->db->join('dados_unico.pessoa', 'produto_preco.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.territorio', 'territorio.territorio_id = produto_preco_territorio.territorio_id', 'left');
        $this->db->where($where);
        $this->db->order_by($order);

        if (!empty($limit)) {
            $this->db->limit($limit, 0);
        }

        return $this->db->get($this->table)->result();
    }


    function get_all_data_param($param, $order = null, $limit = null)
    {

        $this->db->select("*");


        $this->db->join('cotacao.produto', 'produto_preco.produto_id = produto.produto_id', 'INNER');
        $this->db->join('selo.unidade_medida', 'unidade_medida.unidade_medida_id = produto.unidade_medida_id', 'INNER');
        $this->db->join('dados_unico.pessoa', 'produto_preco.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.territorio', 'territorio.territorio_id = pessoa.cotacao_territorio_id', 'left');
        $this->db->join('indice.municipio', 'municipio.municipio_id = pessoa.cotacao_municipio_id', 'left');
        $this->db->where($param);
        $this->db->order_by($order);

        if (!empty($limit)) {
            $this->db->limit($limit, 0);
        }

        return $this->db->get($this->table)->result();
    }

    function get_all_data_param_territorio($param, $order = null, $limit = null)
    {

        $this->db->select("*");


        $this->db->join('cotacao.produto', 'produto_preco.produto_id = produto.produto_id', 'INNER');
        $this->db->join('selo.unidade_medida', 'unidade_medida.unidade_medida_id = produto.unidade_medida_id', 'INNER');
        $this->db->join('dados_unico.pessoa', 'produto_preco.pessoa_id = pessoa.pessoa_id', 'INNER');
        $this->db->join('indice.territorio', 'territorio.territorio_id = pessoa.cotacao_territorio_id', 'left');
        $this->db->join('indice.municipio', 'municipio.municipio_id = pessoa.cotacao_municipio_id', 'left');
        $this->db->join('cotacao.produto_preco_territorio', 'produto_preco.produto_preco_id = produto_preco_territorio.produto_preco_id', 'inner');
        $this->db->join('indice.territorio t', 'produto_preco_territorio.territorio_id = t.territorio_id', 'inner');
        $this->db->where($param);
        $this->db->order_by($order);

        if (!empty($limit)) {
            $this->db->limit($limit, 0);
        }

        return $this->db->get($this->table)->result();
    }


    function get_all_data_com_territorio($param, $order = '')
    {



        $sql = "
                 

                                    select distinct * 
                                    ,ppt.produto_preco_territorio_valor as valor
                                    
                                    from cotacao.produto_preco pp
                                            inner join cotacao.produto_preco_territorio ppt
                                                on ppt.produto_preco_id = pp.produto_preco_id
                                            inner join dados_unico.pessoa pes
                                                on pes.pessoa_id = pp.pessoa_id
                                            left join indice.municipio m
                                                on m.municipio_id = pes.cotacao_municipio_id        
                                            inner join cotacao.produto p
                                                on p.produto_id = pp.produto_id   
                                            inner join indice.territorio t
                                                on t.territorio_id = ppt.territorio_id
                                            inner join selo.unidade_medida um
                                                on um.unidade_medida_id = p.unidade_medida_id    
                                    where ppt.produto_preco_territorio_ativo = 1 
                                            and ppt.produto_preco_territorio_valor > 0 	
                                            $param
                           
                            ";


        return $this->db->query($sql)->result();
    }
    function get_all_data_com_territorio_simples($param, $order = 'order by consulta.produto_nm')
    {



        $sql = "
                 
                        select * from (
                                                        select distinct * 
                                                            ,ppt.produto_preco_territorio_valor as valor
                                                          

                                                            from cotacao.produto_preco pp
                                                                    inner join cotacao.produto_preco_territorio ppt
                                                                        on ppt.produto_preco_id = pp.produto_preco_id
                                                                    inner join dados_unico.pessoa pes
                                                                        on pes.pessoa_id = pp.pessoa_id
                                                                        
                                                                    inner join cotacao.produto p
                                                                        on p.produto_id = pp.produto_id   
                                                                    inner join indice.territorio t
                                                                        on t.territorio_id = ppt.territorio_id
                                                                    inner join selo.unidade_medida um
                                                                        on um.unidade_medida_id = p.unidade_medida_id    
                                                            where ppt.produto_preco_territorio_ativo = 1 
                                                                    and ppt.produto_preco_territorio_valor > 0 	
                                                                    $param
                                                ) as consulta
                           $order 
                            ";


        //echo_pre($sql);exit;
        return $this->db->query($sql)->result();
    }



    // end get_all_data
    // function get_all_data_simples($param, $order = null, $limit = null, $flag_territorio)
    // {

    //     $this->db->select("
    //                   produto.* 
    //                 , unidade_medida.*
    //                 , territorio.*
    //                 , municipio.municipio_id
    //                 , municipio.municipio_nm

    //                 , '$flag_territorio' as flag_territorio");

    //     $where = '1=1 ';
    //     foreach ($param as $array) {
    //         //se tiver parametro
    //         if ($array[2] != '') {
    //             $where .=  " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
    //         }
    //     }
    //     $this->db->join('cotacao.produto', 'produto_preco.produto_id = produto.produto_id', 'INNER'); 
    //     $this->db->join('selo.unidade_medida', 'unidade_medida.unidade_medida_id = produto.unidade_medida_id', 'INNER'); 
    //     $this->db->join('dados_unico.pessoa', 'produto_preco.pessoa_id = pessoa.pessoa_id', 'INNER');
    //     $this->db->join('indice.territorio', 'territorio.territorio_id = pessoa.cotacao_territorio_id', 'left');
    //     $this->db->join('indice.municipio', 'municipio.municipio_id = pessoa.cotacao_municipio_id', 'left');
    //     $this->db->where($where);
    //     $this->db->order_by($order);

    //     if (!empty($limit)) {
    //         $this->db->limit($limit, 0);
    //     }

    //     return $this->db->get($this->table)->result();
    // } // end get_all_data


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

/* Final do arquivo Produto_preco_model.php */
/* Local: ./application/models/Produto_preco_model.php */
/* Data - 2022-09-05 18:17:03 */