<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto_preco_territorio_model extends CI_Model
{

    public $table = 'cotacao.produto_preco_territorio';
    public $id = 'produto_preco_territorio_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }



function get_historico($produto_id, $pessoa_id){

    $sql = "
                select * from cotacao.produto_preco_territorio ppt
                    inner join indice.territorio t
                        on t.territorio_id = ppt. territorio_id
                where ppt.produto_preco_territorio_valor > 0
                and ppt.produto_preco_territorio_produto_id = $produto_id
                and ppt.produto_preco_territorio_pessoa_id = $pessoa_id
                order by ppt.produto_preco_territorio_dt_cadastro desc

";
        return $this->db->query($sql)->result();
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


    function get_produto_preco_territorio_ativos($produto_preco_id, $produto_preco_territorio_pessoa_id)
    {

        $produto_preco_id = (int)$produto_preco_id;
        $produto_preco_territorio_pessoa_id = (int)$produto_preco_territorio_pessoa_id;
        $query = "select *
                    FROM cotacao.produto_preco_territorio
                         left JOIN cotacao.produto_preco ON produto_preco_territorio.produto_preco_id = produto_preco.produto_preco_id
                         left JOIN indice.territorio ON produto_preco_territorio.territorio_id = territorio.territorio_id
                    WHERE produto_preco_territorio.produto_preco_id = $produto_preco_id  
                        and produto_preco_territorio.produto_preco_territorio_pessoa_id = $produto_preco_territorio_pessoa_id 
                          ";

        return $this->db->query($query)->result();
    }

    function get_tudo()
    {
        $sql = "SELECT *
                    FROM cotacao.produto_preco_territorio
                    INNER JOIN cotacao.produto_preco ON produto_preco_territorio.produto_preco_id = produto_preco.produto_preco_id
                    INNER JOIN indice.territorio ON produto_preco_territorio.territorio_id = territorio.territorio_id
                ";

        return $this->db->query($sql)->result();
    }



    function get_produtos_preco($pessoa_id)
    {
        $sql = "  select distinct p.*, pp.* from cotacao.produto_preco pp
	            inner join cotacao.produto_preco_territorio ppt
			        on ppt.produto_preco_id = pp.produto_preco_id
							inner join cotacao.produto p
							 on p.produto_id = pp.produto_id
                where pp.ativo =1 
                        and ppt.produto_preco_territorio_valor > 0
                        and ppt.produto_preco_territorio_ativo = 1 
                        and pp.pessoa_id = $pessoa_id

        ";
        return $this->db->query($sql)->result();
    }
    function get_produtos_preco_por_produto($produto_id)
    {
        $sql = "  select distinct p.*
        
                , pp.*
                , ppt.produto_preco_territorio_valor
                , pes.pessoa_nm 
                
            from cotacao.produto_preco pp
	            inner join cotacao.produto_preco_territorio ppt
			        on ppt.produto_preco_id = pp.produto_preco_id
							inner join cotacao.produto p
							 on p.produto_id = pp.produto_id
                 inner join dados_unico.pessoa pes
                    on pes.pessoa_id = pp.pessoa_id            
                where pp.ativo =1 
                        and ppt.produto_preco_territorio_valor > 0
                        and ppt.produto_preco_territorio_ativo = 1 
                        and pp.produto_id = $produto_id and pes.pessoa_st =0

        ";
        return $this->db->query($sql)->result();
    }

    function inativa_todos($produto_id, $pessoa_id)
    {
        $sql = "update cotacao.produto_preco_territorio
                    set produto_preco_territorio_ativo = 0
                where produto_preco_territorio_pessoa_id = $pessoa_id
                and produto_preco_territorio_produto_id = $produto_id   

        ";
        $this->db->query($sql);
    }
    function get_valor_por_fornecedor_produto($territorio_id, $pessoa_id, $produto_id)
    {
        $sql = "
        
                    select ppt.produto_preco_territorio_valor,* from cotacao.produto_preco_territorio ppt
                        inner join cotacao.produto_preco pp
                                on pp.produto_preco_id = ppt.produto_preco_id
                    where ppt.territorio_id = $territorio_id 
                            and ppt.produto_preco_territorio_ativo=1 
                            and ppt.produto_preco_territorio_pessoa_id = $pessoa_id  
                            and pp.produto_id = $produto_id
                             

        ";
        $ret = $this->db->query($sql)->row();

        return empty($ret->produto_preco_territorio_valor) ? 0 : $ret->produto_preco_territorio_valor;
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
        $this->db->ilike('cotacao.produto_preco_territorio.produto_preco_territorio_id', $q);
        $this->db->or_ilike('produto_preco_territorio.produto_preco_id', $q);
        $this->db->or_ilike('produto_preco_territorio.territorio_id', $q);
        $this->db->or_ilike('produto_preco_territorio.produto_preco_territorio_valor', $q);
        $this->db->or_ilike('produto_preco_territorio.produto_preco_territorio_ativo', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('produto_preco_territorio.produto_preco_territorio_id', $q);
        $this->db->or_ilike('produto_preco_territorio.produto_preco_id', $q);
        $this->db->or_ilike('produto_preco_territorio.territorio_id', $q);
        $this->db->or_ilike('produto_preco_territorio.produto_preco_territorio_valor', $q);
        $this->db->or_ilike('produto_preco_territorio.produto_preco_territorio_ativo', $q);
        $this->db->join('cotacao.produto_preco', 'produto_preco_territorio.produto_preco_id = produto_preco.produto_preco_id', 'INNER');
        $this->db->join('indice.territorio', 'produto_preco_territorio.territorio_id = territorio.territorio_id', 'INNER');
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
        $this->db->join('cotacao.produto_preco', 'produto_preco_territorio.produto_preco_id = produto_preco.produto_preco_id', 'INNER');
        $this->db->join('indice.territorio', 'produto_preco_territorio.territorio_id = territorio.territorio_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data
    function get_all_data_param($param, $order = null)
    {

        $this->db->select('*');


        $this->db->join('cotacao.produto_preco', 'produto_preco_territorio.produto_preco_id = produto_preco.produto_preco_id', 'INNER');
        $this->db->join('indice.territorio', 'produto_preco_territorio.territorio_id = territorio.territorio_id', 'INNER');
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

/* Final do arquivo Produto_preco_territorio_model.php */
/* Local: ./application/models/Produto_preco_territorio_model.php */
/* Data - 2024-02-20 20:42:06 */