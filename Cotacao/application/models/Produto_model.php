<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto_model extends CI_Model
{

    public $table = 'cotacao.produto';
    public $id = 'produto_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }





    function get_all_com_media_bahia($territorio_id = null)
    {
        $territorio_id = (int)$territorio_id;
        $where = "where ppt.territorio_id = $territorio_id";
        if (empty($territorio_id)) {
            $where = "where 1=1 ";
        }
        $sql = "
                    select * from (
                                        select 
                                        
                                        p.produto_id,
                                        p.produto_nm,
                                        avg(cast(produto_preco_territorio_valor as float)) as media_bahia
                                        
                                        from cotacao.produto p
                                        inner join cotacao.produto_preco pp
                                            on pp.produto_id = p.produto_id 
                                        inner join cotacao.produto_preco_territorio ppt 
                                            on ppt.produto_preco_id = pp.produto_preco_id 
                                        $where and (ppt.produto_preco_territorio_valor is not null and ppt.produto_preco_territorio_valor >0)
                                        and ppt.produto_preco_territorio_ativo = 1
                                        and pp.pessoa_id in (select p2.pessoa_id from dados_unico.pessoa p2 where p2.pessoa_st = 0)
                                        and pp.pessoa_id in (select v.pessoa_id from vi_login v where v.sistema_id = 104 and v.tipo_usuario_id = 442)
                                        group by p.produto_id,
                                        p.produto_nm
                                        
                    ) as consulta
                    order by consulta.produto_nm";
        return $this->db->query($sql)->result();
    }


    function get_all_com_media_bahia_valores_por_produto($produto_id = null, $territorio_id = null)
    {
        $produto_id  = (int)$produto_id;
        $territorio_id = (int)$territorio_id;
        $where = " where p.produto_id = $produto_id";

        if (!empty($territorio_id)) {
            $where .= " and ppt.territorio_id = $territorio_id";
        }




        $sql = "
                    select * from (
                                        select 
                                        
                                                p.produto_id,
                                                p.produto_nm,
                                                cast(produto_preco_territorio_valor as float) as produto_preco_territorio_valor,
                                                pes.pessoa_nm,
                                                t.territorio_nm
                                        
                                        from cotacao.produto p
                                        inner join cotacao.produto_preco pp
                                            on pp.produto_id = p.produto_id 
                                        inner join cotacao.produto_preco_territorio ppt 
                                            on ppt.produto_preco_id = pp.produto_preco_id 
                                        inner join dados_unico.pessoa pes
                                            on pes.pessoa_id = pp.pessoa_id   
                                        inner join indice.territorio t
                                            on t.territorio_id = ppt.territorio_id     
                                        $where and (ppt.produto_preco_territorio_valor is not null and ppt.produto_preco_territorio_valor >0)
                                        and ppt.produto_preco_territorio_ativo = 1
                                        and pp.pessoa_id in (select v.pessoa_id from vi_login v where v.sistema_id = 104 and v.tipo_usuario_id = 442)

                                        and pp.pessoa_id in (select p2.pessoa_id from dados_unico.pessoa p2 where p2.pessoa_st = 0)
                                        

                    ) as consulta
                    order by consulta.produto_nm";
        return $this->db->query($sql)->result();
    }



    function get_qtd_produtos($territorio_id = null, $param = "")
    {
        $territorio_id = (int)$territorio_id;
        $where_territorio = "where ppt.territorio_id = $territorio_id";
        if (empty($territorio_id)) {
            $where_territorio = "where 1=1 ";
        }

        
        $sql = " select count(1) as qtd from cotacao.produto where 1=1 $param $where_territorio";
        return $this->db->query($sql)->row()->qtd;
    }



    function get_produtos_cotacoes($cotacao_id_in)
    {
        $sql = "

        select * from (
                select distinct upper(p.produto_nm) as produto_nm, p.produto_id

                from cotacao.produto p
                    inner join cotacao.produto_preco_cotacao ppc
                        on ppc.produto_id = p.produto_id
                    inner join cotacao.cotacao c
                        on c.cotacao_id = ppc.cotacao_id
                   where c.cotacao_id in $cotacao_id_in   
                  and ppc.entidade_pessoa_id in (select v.pessoa_id from vi_login v where v.sistema_id = 104 and v.tipo_usuario_id = 442)
                  and ppc.entidade_pessoa_id in (select p2.pessoa_id from dados_unico.pessoa p2 where p2.pessoa_st = 0)
            ) as consulta 
           order by remove_acentuacao(trim(upper(consulta.produto_nm))) asc
                  

                    

";
        return $this->db->query($sql)->result();
    }


    function get_produtos_por_municipio_para_o_combo($municipio_id)
    {
        $municipio_id = (int)$municipio_id;
        $where = "where pes.cotacao_municipio_id = $municipio_id	";
        if (empty($municipio_id)) {
            $where = "";
        }
        $sql = " 
    select 0 as id, 'Selecione' as text

    union all

    select * from (

                    select DISTINCT p.produto_id as id, p.produto_nm as text
                     from cotacao.produto_preco pp
                            inner join cotacao.produto p
                                on p.produto_id = pp.produto_id
                            inner join dados_unico.pessoa pes
                                on pp.pessoa_id = pes.pessoa_id
                            $where
                            order by p.produto_nm
                     ) as con       
    ";

        return $this->db->query($sql)->result();
    }

    // get all
    function get_all($param = null)
    {

        $this->db->select("
                        produto_id as id,         
                        produto_id,
                        produto_nm,
                        produto_nm as text, *
       ");
        
        if (!empty($param)) {
            $this->db->where($param);
        }

        $this->db->order_by("produto_nm asc");
        return $this->db->get($this->table)->result();
    }




    function get_produtos_validos_por_terriitorio($territorio_id = null, $order = "consulta.produto_nm")
    {

        $dias_validade_preco = DIAS_VALIDADE_PRECO;

        $param_territorio = "";
        if (!empty($territorio_id)) {
            $param_territorio = " and ppt.territorio_id = $territorio_id";
        }


        $sql = "
        
        
        select * from (

        select 
        
                    distinct 
                     p.produto_id
                    , p.produto_nm 
                    , p.produto_id as id
                    , p.produto_nm as text
        
        from cotacao.produto p
                    inner join cotacao.produto_preco pp
                        on p.produto_id = pp.produto_id
                    inner join 	cotacao.produto_preco_territorio ppt
                        on pp.produto_preco_id = ppt.produto_preco_id

                where ppt.produto_preco_territorio_valor > 0 and ppt.produto_preco_territorio_ativo = 1
                and pp.produto_preco_dt::date >= now()::date - $dias_validade_preco 
                $param_territorio
        ) as consulta     
            order by remove_acentuacao(trim(upper($order))) asc
            ";


        // echo_pre($sql);
        return $this->db->query($sql)->result();
    }



    // get all for combobox 
    function get_all_combobox($param = null, $order = null)
    {
        $this->db->select("$this->id as id,         
                            produto_id,
                            produto_nm,
                            produto_nm as text,
                            produto_qtd,
                            unidade_medida_nm,
                            upper(produto_nm) || ' (' ||  
                            
                            case when produto_qtd = 1 then '' else produto_qtd::varchar end
                            
                            || ' ' || unidade_medida_nm || ')' as text2");
        if (!empty($param)) {
            $this->db->where($param);
        }
        if (!empty($order)) {
            $this->db->order_by($order);
        } else {
            $this->db->order_by($this->table . '.' . $this->id, 'asc');
        }
        $this->db->join('selo.unidade_medida', 'produto.unidade_medida_id = unidade_medida.unidade_medida_id', 'inner');
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
        $this->db->ilike('cotacao.produto.produto_id', $q);
        $this->db->or_ilike('produto.produto_nm', $q);
        $this->db->or_ilike('produto.produto_ds', $q);
        $this->db->or_ilike('produto.produto_tipo_id', $q);
        $this->db->or_ilike('produto.status_id', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('produto.produto_id', $q);
        $this->db->or_ilike('produto.produto_nm', $q);
        $this->db->or_ilike('produto.produto_ds', $q);
        $this->db->or_ilike('produto.produto_tipo_id', $q);
        $this->db->or_ilike('produto.status_id', $q);
        $this->db->join('selo.produto_tipo', 'produto.produto_tipo_id = produto_tipo.produto_tipo_id', 'left');
        $this->db->join('cotacao.categoria', 'produto.categoria_id = categoria.categoriaid', 'left');
        $this->db->join('selo.unidade_medida', 'produto.unidade_medida_id = unidade_medida.unidade_medida_id', 'inner');
        $this->db->join('cotacao.status', 'produto.status_id = status.status_id', 'left');
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
        $this->db->join('selo.produto_tipo', 'produto.produto_tipo_id = produto_tipo.produto_tipo_id', 'left');
        $this->db->join('cotacao.categoria', 'produto.categoria_id = categoria.categoriaid', 'left');
        $this->db->join('selo.unidade_medida', 'produto.unidade_medida_id = unidade_medida.unidade_medida_id', 'inner');
        $this->db->join('cotacao.status', 'produto.status_id = status.status_id', 'left');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data


    function get_all_data_param($param, $order = null)
    {

        $this->db->select('
        *
        , produto.produto_id as id
        , produto.produto_nm as text
        ');

        $this->db->join('selo.produto_tipo', 'produto.produto_tipo_id = produto_tipo.produto_tipo_id', 'left');
        $this->db->join('cotacao.categoria', 'produto.categoria_id = categoria.categoria_id', 'left');
        $this->db->join('selo.unidade_medida', 'produto.unidade_medida_id = unidade_medida.unidade_medida_id', 'inner');
        $this->db->join('cotacao.status', 'produto.status_id = status.status_id', 'left');
        $this->db->where($param);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    }



    //revisar consulta a fim de otimizar
    function get_produto_com_preco($pessoa_id,  $q = null, $limit = 999999, $filtro_produto_id = NULL, $filtro_categoria_id = null)
    {
        $where = '';
        if (!empty($q)) {
            $where .= " and p.produto_nm ilike '%$q%'";
        }
        if (!empty($filtro_produto_id)) {
            $where .= " and p.produto_id = $filtro_produto_id";
        }
        if (!empty($filtro_categoria_id)) {
            $where .= " and p.categoria_id = $filtro_categoria_id";
        }


        $sql = "
        select 
         p.produto_id as id
        ,p.produto_nm as text
        , *
        ,(select pp2.valor from cotacao.produto_preco pp2 
                where pp2.pessoa_id = $pessoa_id 
                        and pp2.produto_id = p.produto_id
            order by pp2.produto_preco_dt desc limit 1) as ultimo_preco
        ,(select max(pp2.produto_preco_dt)  from cotacao.produto_preco pp2 
                    where pp2.pessoa_id = $pessoa_id 
                        and pp2.produto_id = p.produto_id) as ultimo_dt_preco
        ,(
            select count(1) as tem_preco from cotacao.produto_preco_territorio ppt 
                        where ppt.produto_preco_territorio_pessoa_id = $pessoa_id
                                and ppt.produto_preco_territorio_produto_id = p.produto_id
                                and ppt.produto_preco_territorio_ativo = 1
                                 
                        )  as tem_preco              
        
        from cotacao.produto p
                left join selo.produto_tipo pt
                    on p.produto_tipo_id = pt.produto_tipo_id
                left join cotacao.categoria c
                    on c.categoria_id = p.categoria_id
                left join cotacao.status s
                    on    s.status_id = p.status_id 
                inner join selo.unidade_medida um
                    on um.unidade_medida_id = p.unidade_medida_id    
            where p.produto_id in (select pp.produto_id from cotacao.produto_preco pp where pp.pessoa_id = $pessoa_id and pp.ativo = 1)
            $where
            order by p.produto_nm
            limit $limit
        ";
        return $this->db->query($sql)->result();
    }
    //revisar consulta a fim de otimizar
    function get_produto_sem_preco($pessoa_id, $q = null, $limit = 999999, $start = 0, $filtro_categoria_id = null, $filtro_produto_id = null)
    {
        $where = '';
        if (!empty($q)) {
            $where .= " and p.produto_nm ilike '%$q%'";
        }
        if (!empty($filtro_categoria_id)) {
            $where .= " and p.categoria_id = $filtro_categoria_id";
        }
        if (!empty($filtro_produto_id)) {
            $where .= " and p.produto_id = $filtro_produto_id";
        }
        $sql = "
                    select *  
                    ,p.produto_id as id
                    ,p.produto_nm as text 
                    from cotacao.produto p

                    left join selo.produto_tipo pt
                                on p.produto_tipo_id = pt.produto_tipo_id
                    left join cotacao.categoria c
                                on c.categoria_id = p.categoria_id
                            left join cotacao.status s
                                on    s.status_id = p.status_id 
                            inner join selo.unidade_medida um
                                on um.unidade_medida_id = p.unidade_medida_id    
                        where p.produto_id NOT in (select pp.produto_id from cotacao.produto_preco pp where pp.pessoa_id = $pessoa_id)
                            $where
                        order by p.produto_nm
                            limit $limit  OFFSET $start
        ";
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

/* Final do arquivo Produto_model.php */
/* Local: ./application/models/Produto_model.php */
/* Data - 2022-09-05 18:16:27 */