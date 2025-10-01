<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto_preco_service extends CI_Model
{



    function __construct()
    {
        parent::__construct();
        $this->load->model('Municipio_model');
        $this->load->model('Produto_preco_territorio_model');
        $this->load->model('Pessoa_model');
    }
    private function cria_produto_nm_completo_by_list($produto)
    {

        foreach ($produto as $key => $p) {
            if ($p->produto_qtd == 1) {
                $p->produto_nm_completo = $p->produto_nm . " (" . removePlural($p->unidade_medida_nm) . ")";
            } else {
                $p->produto_nm_completo = $p->produto_nm . " (" . $p->produto_qtd . " " . $p->unidade_medida_nm . ")";
            }
        }

        return $produto;
    }

    public function get_produto_preco($produto_id = null, $flag_exibir_todos_produtos_territorio = 1, $parametro = null, $cotacao_pessoa_id = null)
    {

        $pessoa_id = empty($cotacao_pessoa_id) ? $_SESSION['pessoa_id'] : $cotacao_pessoa_id;

        $pessoa_logada = $this->Pessoa_model->get_by_id($pessoa_id);


        $param_territorio = "";
        if ($flag_exibir_todos_produtos_territorio == 1) {
            if (!empty($pessoa_logada->cotacao_territorio_id)) {
                $param_territorio = " and ppt.territorio_id = $pessoa_logada->cotacao_territorio_id ";
            }
        }


        $param = " and 1=1 ";
        if (!empty($produto_id)) {
            $param .= " and p.produto_id = $produto_id ";
        }

        $param .= " and pp.ativo = 1 
                        $param_territorio 
                        $parametro
                        and ppt.produto_preco_territorio_valor > 0 
                        and ppt.produto_preco_territorio_dt_cadastro::date BETWEEN (CURRENT_DATE::date - " . DIAS_VALIDADE_PRECO . ") and CURRENT_DATE::date  
                        and pp.pessoa_id in (select v2.pessoa_id from vi_login v2 
                                                    inner join dados_unico.pessoa p2
                                                        on p2.pessoa_id = v2.pessoa_id
                                                where v2.sistema_id = 104 and v2.tipo_usuario_id = 442 and p2.pessoa_st =0)
                        and ppt.produto_preco_territorio_ativo = 1 ";


        $produto_preco = $this->Produto_preco_model->get_all_data_com_territorio_simples($param, "order by consulta.produto_nm");


        foreach ($produto_preco as $key => $pp) {
            $pp->municipios = $this->Municipio_model->get_all_by_territorio_simples($pp->territorio_id);
        }

        $produto_preco = $this->cria_produto_nm_completo_by_list($produto_preco);

        return $produto_preco;
    }
}
