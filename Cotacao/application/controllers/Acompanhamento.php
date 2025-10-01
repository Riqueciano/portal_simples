<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acompanhamento extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Acompanhamento_model');
        $this->load->model('Acompanhamento_territorio_model');
        $this->load->model('Pessoa_model');
        $this->load->model('Territorio_model');
        $this->load->model('Produto_preco_model');
        $this->load->model('Solicitante_model');

        $this->load->model('Pessoa_model');
        $this->load->model('Municipio_model');
        $this->load->library('form_validation');
    }


     
    

    // public function index_()
    // {
    //     PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Nutricionista']);  
    //     $q = urldecode($this->input->get('q', TRUE));
    //     $format = urldecode($this->input->get('format', TRUE));
    //     $start = (int)$this->input->get('start');



    //     $config['per_page'] = 30;
    //     $config['page_query_string'] = TRUE;
    //     $config['total_rows'] = $this->Acompanhamento_model->total_rows($q);
    //     $acompanhamento = $this->Acompanhamento_model->get_limit_data($config['per_page'], $start, $q);

    //     ## para retorno json no front
    //     if ($format == 'json') {
    //         echo json($acompanhamento);
    //         exit;
    //     }

    //     $this->load->library('pagination');
    //     $this->pagination->initialize($config);

    //     $data = array(
    //         'acompanhamento_data' => json($acompanhamento),
    //         'q' => $q,
    //         'format' => $format,
    //         'pagination' => $this->pagination->create_links(),
    //         'total_rows' => $config['total_rows'],
    //         'start' => $start,
    //     );
    //     $this->load->view('acompanhamento/Acompanhamento_list', forFrontVue($data));
    // }


    public function ajax_verifica_se_tem_caf()
    {
        //so executa se estiver logado
        if (empty($_SESSION['pessoa_id'])) {
            echo "Tente novamente mais tarde";
            exit;
        }

        $pessoa = $this->Pessoa_model->get_by_id($_SESSION['pessoa_id']);


        $solicitante = $this->Solicitante_model->get_by_pessoa_id($_SESSION['pessoa_id']);

        $atualizou = 0;
        if (empty($pessoa->pessoa_dap)) {
            $data = array(
                'pessoa_dap' => $solicitante->dap_juridica_fisica,
            );
            $this->Pessoa_model->update($pessoa->pessoa_id, $data);
            $atualizou++;
        }
        if (empty($pessoa->fornecedor_categoria_id)) {
            $data = array(
                'fornecedor_categoria_id' => 18,    //"AGRICULTOR FAMILIAR",
            );
            $this->Pessoa_model->update($pessoa->pessoa_id, $data);
            $atualizou++;
        }

        if (empty($pessoa->pessoa_cnpj)) {
            $data = array(
                'pessoa_cnpj' => $solicitante->cnpj_cpf,
            );
            $this->Pessoa_model->update($pessoa->pessoa_id, $data);
            $atualizou++;
        }

        if (empty($pessoa->cotacao_municipio_id)) {
            $municipio = $this->Municipio_model->get_by_id($solicitante->municipio_id);
            $data = array(
                'cotacao_municipio_id' => $solicitante->municipio_id,
                'cotacao_territorio_id' => $municipio->territorio_id,
            );
            $this->Pessoa_model->update($pessoa->pessoa_id, $data);
            $atualizou++;
        }

        echo json(array(
            'situacao' => 'ok',
            'atualizou' => $atualizou,
            'message' => 'Dados atualizados com sucesso',
        ));
    }



    public function index()
    {

        //  echo phpinfo();   exit; 

        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = (int)$this->input->get('start');


        $flag_exibir_produtos = $this->input->get('flag_exibir_produtos', TRUE);
        $flag_exibir_produtos = empty($flag_exibir_produtos) ? 'todos' : $flag_exibir_produtos;



        $config['per_page'] = 900000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Acompanhamento_model->total_rows($q);
        $acompanhamento = array(); //$this->Acompanhamento_model->get_limit_data($config['per_page'], $start, $q, $param = null);




        //recebe o parametro dos territorios q sera utilizado no where in
        $acompanhamento_territorio_in = $this->Acompanhamento_territorio_model->get_all_data_param_retorno_in("pessoa.pessoa_id = " . $_SESSION['pessoa_id']);
        $territorio_where_in = "(0";
        foreach ($acompanhamento_territorio_in as $key => $r) {
            $territorio_where_in .= "," . $r->territorio_id;
        }
        $territorio_where_in .= ")";





        // echo $acompanhamento_territorio_in;
        $territorio_todos = $this->Territorio_model->get_all("territorio_uf= 'BA'");

        foreach ($territorio_todos as $key => $tt) {
            //verifica se o relatorio esta selecionado
            $at = $this->Acompanhamento_territorio_model->get_retorna_flag_territorio_selecionado($tt->territorio_id, $_SESSION['pessoa_id']);
            $tt->checked = false;
            if ($at->qtd > 0) {
                $tt->checked = true;
            }
        }


        $territorio = $this->Territorio_model->get_all("territorio_id in $territorio_where_in");

        foreach ($territorio as $key => $t) {
            //    echo $t->territorio_id;

            //apenas entidades do tipo FORNECEDOR
            $param = " and p.pessoa_id in (select v2.pessoa_id from vi_login v2 where v2.sistema_id = 104/*cotacao*/ and v2.tipo_usuario_id in (442/*fornecedor*/))";
            $t->entidades = $this->Pessoa_model->get_entidade_territorio($t->territorio_id, $param, $flag_exibir_produtos);
            //echo_pre($this->db->last_query());
            //var_dump($t->entidades);
            //echo count($t->entidades);

            foreach ($t->entidades as $key => $e) {
                //$param = " and pp.pessoa_id in (select v2.pessoa_id from vi_login v2 where v2.sistema_id = 104/*cotacao*/ and v2.tipo_usuario_id in (442/*fornecedor*/))";
                $e->produto_preco = $this->Produto_preco_model->get_produto_preco_por_pessoa_territorio($e->pessoa_id, $e->territorio_id, $param = null);
                // $e->sql = $this->db->last_query();
                // $produto_preco_dt_validade = empty($e->produto_preco->produto_preco_dt_validade)?null:$e->produto_preco->produto_preco_dt_validade;
            }
        }



        $this->load->library('pagination');
        $this->pagination->initialize($config);




        ## para retorno json no front
        if ($format == 'json') {
            echo json($territorio);
            exit;
        }


        // echo json($territorio);exit;
        $data = array(
            'acompanhamento_data' => json($acompanhamento),
            'territorio' => json($territorio),
            'acompanhamento_territorio_in' => json($acompanhamento_territorio_in),
            'territorio_todos' => json($territorio_todos),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('acompanhamento/Acompanhamento_list', forFrontVue($data));
    }

    function atualizar_seguindo_territorio()
    {
        $limpar_territorios = (int)$this->input->get('limpar_territorios', TRUE);

        if ($limpar_territorios == 1) {
            //deleta todos os acompanhamentos do territorio da pessoa logada antes de inserir
            $this->Acompanhamento_territorio_model->delete_todos_por_pessoa_id($_SESSION['pessoa_id']);
            foreach ($this->input->post('territorio_id[]', TRUE) as $key => $territorio_id) {
                $data = array(
                    'pessoa_id' => $_SESSION['pessoa_id'],
                    'territorio_id' => $territorio_id
                );
                $this->Acompanhamento_territorio_model->insert($data);
            }

            redirect(site_url('acompanhamento'));
        }



        $adicionar_todos_territorios = (int)$this->input->get('adicionar_todos_territorios', TRUE);
        if ($adicionar_todos_territorios == 1) {
            $this->Acompanhamento_territorio_model->delete_todos_por_pessoa_id($_SESSION['pessoa_id']);

            $territorio_todos = $this->Territorio_model->get_all("territorio_uf= 'BA'");

            foreach ($territorio_todos as $key => $territorio) {
                $data = array(
                    'pessoa_id' => $_SESSION['pessoa_id'],
                    'territorio_id' => $territorio->territorio_id
                );
                $this->Acompanhamento_territorio_model->insert($data);
            }

            redirect(site_url('acompanhamento'));
        }






        foreach ($this->input->post('territorio_id[]', TRUE) as $key => $territorio_id) {
            $data = array(
                'pessoa_id' => $_SESSION['pessoa_id'],
                'territorio_id' => $territorio_id
            );
            $this->Acompanhamento_territorio_model->insert($data);
        }

        redirect(site_url('acompanhamento'));
    }


    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Nutricionista']);
        $this->session->set_flashdata('message', '');
        $row = $this->Acompanhamento_model->get_by_id($id);
        $pessoa = $this->Pessoa_model->get_all_combobox();
        $pessoa = $this->Pessoa_model->get_all_combobox();
        if ($row) {
            $data = array(
                'pessoa' => json($pessoa),
                'pessoa' => json($pessoa),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('acompanhamento/create_action'),
                'acompanhamento_id' => $row->acompanhamento_id,
                'pessoa_id' => $row->pessoa_id,
                'seguindo_pessoa_id' => $row->seguindo_pessoa_id,
            );
            $this->load->view('acompanhamento/Acompanhamento_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('acompanhamento'));
        }
    }

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Nutricionista']);
        $pessoa = $this->Pessoa_model->get_all_combobox();
        $pessoa = $this->Pessoa_model->get_all_combobox();
        $data = array(
            'pessoa' => json($pessoa),
            'pessoa' => json($pessoa),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('acompanhamento/create_action'),
            'acompanhamento_id' => set_value('acompanhamento_id'),
            'pessoa_id' => set_value('pessoa_id'),
            'seguindo_pessoa_id' => set_value('seguindo_pessoa_id'),
        );
        $this->load->view('acompanhamento/Acompanhamento_form', forFrontVue($data));
    }

    public function create_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Nutricionista']);
        $this->_rules();
        $this->form_validation->set_rules('pessoa_id', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('seguindo_pessoa_id', NULL, 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'pessoa_id' =>      empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
                'seguindo_pessoa_id' =>      empty($this->input->post('seguindo_pessoa_id', TRUE)) ? NULL : $this->input->post('seguindo_pessoa_id', TRUE),
            );

            $this->Acompanhamento_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('acompanhamento'));
        }
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Nutricionista']);
        $this->session->set_flashdata('message', '');
        $row = $this->Acompanhamento_model->get_by_id($id);
        $pessoa = $this->Pessoa_model->get_all_combobox();
        $pessoa = $this->Pessoa_model->get_all_combobox();
        if ($row) {
            $data = array(
                'pessoa' => json($pessoa),
                'pessoa' => json($pessoa),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('acompanhamento/update_action'),
                'acompanhamento_id' => set_value('acompanhamento_id', $row->acompanhamento_id),
                'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
                'seguindo_pessoa_id' => set_value('seguindo_pessoa_id', $row->seguindo_pessoa_id),
            );
            $this->load->view('acompanhamento/Acompanhamento_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('acompanhamento'));
        }
    }

    public function update_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Nutricionista']);
        $this->_rules();
        $this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim|required|integer');
        $this->form_validation->set_rules('seguindo_pessoa_id', 'seguindo_pessoa_id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('acompanhamento_id', TRUE));
        } else {
            $data = array(
                'pessoa_id' => empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
                'seguindo_pessoa_id' => empty($this->input->post('seguindo_pessoa_id', TRUE)) ? NULL : $this->input->post('seguindo_pessoa_id', TRUE),
            );

            $this->Acompanhamento_model->update($this->input->post('acompanhamento_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('acompanhamento'));
        }
    }

    public function delete($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Nutricionista']);
        $row = $this->Acompanhamento_model->get_by_id($id);

        if ($row) {
            if (@$this->Acompanhamento_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('acompanhamento'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('acompanhamento'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('acompanhamento'));
        }
    }

    public function _rules()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Nutricionista']);
        $this->form_validation->set_rules('pessoa_id', 'pessoa id', 'trim|required');
        $this->form_validation->set_rules('seguindo_pessoa_id', 'seguindo pessoa id', 'trim|required');

        $this->form_validation->set_rules('acompanhamento_id', 'acompanhamento_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Nutricionista']);

        $param = array(

            array('pessoa_id', '=', $this->input->post('pessoa_id', TRUE)),
            array('seguindo_pessoa_id', '=', $this->input->post('seguindo_pessoa_id', TRUE)),
        ); //end array dos parametros

        $data = array(
            'acompanhamento_data' => $this->Acompanhamento_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('acompanhamento/Acompanhamento_pdf', $data, true);


        $formato = $this->input->post('formato', TRUE);
        $nome_arquivo = 'arquivo';
        if (rupper($formato) == 'EXCEL') {
            $pdf = $this->pdf->excel($html, $nome_arquivo);
        }

        $this->load->library('pdf');
        $pdf = $this->pdf->RReport();

        $caminhoImg = CPATH . 'imagens/Topo/bg_logo_min.png';

        //cabeçalho
        $pdf->SetHeader(" 
                <table border=0 class=table style='font-size:12px'>
                    <tr>
                        <td rowspan=2><img src='$caminhoImg'></td> 
                        <td>Governo do Estado da Bahia<br>
                            Secretaria do Meio Ambiente - SEMA</td> 
                    </tr>     
                </table>    
                 ", 'O', true);


        $pdf->WriteHTML(utf8_encode($html));
        $pdf->SetFooter("{DATE j/m/Y H:i}|{PAGENO}/{nb}|" . utf8_encode('Nome do Sistema') . "|");

        $pdf->Output('recurso.recurso.pdf', 'I');
    }

    public function report()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Nutricionista']);

        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('acompanhamento/open_pdf'),
            'recurso_id'    => null,
            'recurso_nm'    => null,
            'recurso_tombo' => null,
            'conservacao_id' => null,
            'setaf_id'      => null,
            'localizacao'   => null,
            'municipio_id'  => null,
            'caminho'       => null,
            'documento_id'  => null,
            'requerente_id' => null,
        );


        $this->load->view('acompanhamento/Acompanhamento_report', forFrontVue($data));
    }
}

/* End of file Acompanhamento.php */
/* Local: ./application/controllers/Acompanhamento.php */
/* Gerado por RGenerator - 2024-10-31 13:13:11 */