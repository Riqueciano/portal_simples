<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto_preco extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Produto_preco_model');
        $this->load->model('Produto_model');

        $this->load->model('Pessoa_model');
        $this->load->model('Produto_tipo_model');
        $this->load->model('Unidade_medida_model');
        $this->load->model('Territorio_model');
        $this->load->model('Municipio_model');
        $this->load->model('Produto_preco_territorio_model');
        $this->load->model('Categoria_model');

        $this->load->service('Produto_preco_service');

        $this->load->library('form_validation');
    }

    public function index()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'produto_preco/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'produto_preco/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'produto_preco/';
            $config['first_url'] = base_url() . 'produto_preco/';
        }

        $config['per_page'] = 99000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Produto_preco_model->total_rows($q);
        $produto_preco = $this->Produto_preco_model->get_limit_data($config['per_page'], $start, $q);
        $config['total_rows'] = count($produto_preco);
        ## para retorno json no front
        if ($format == 'json') {
            echo json($produto_preco);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'produto_preco_data' => json($produto_preco),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('produto_preco/Produto_preco_list', forFrontVue($data));
    }


    public function qualidade_preco()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));

        $start = intval($this->input->get('start'));




        if ($q <> '') {
            $config['base_url']  = base_url() . 'produto_preco/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'produto_preco/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'produto_preco/';
            $config['first_url'] = base_url() . 'produto_preco/';
        }

        $config['per_page'] = 999999;
        $config['page_query_string'] = TRUE;

        $param_produto_id = (int)$this->input->get('param_produto_id', TRUE);
        $param_territorio_id = (int)$this->input->get('param_territorio_id', TRUE);


        //se carrega se tiver pelo menos um parametro
        if (!empty($param_produto_id) or !empty($param_territorio_id)) {
            $param = "";
            if (!empty($param_territorio_id)) {
                $param .= " and t.territorio_id = $param_territorio_id";
            }
            if (!empty($param_produto_id)) {
                $param .= " and pp.produto_id = $param_produto_id";
            }
            $produto_preco = $this->Produto_preco_service->get_produto_preco(null, "consulta.produto_nm asc", $param);
        } else {
            $produto_preco = array();
        }
        $config['total_rows'] = count($produto_preco);
        // echo_pre($this->db->last_query());

        ## para retorno json no front
        if ($format == 'json') {
            echo json($produto_preco);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);


        $territorio = $this->Territorio_model->get_all_data_param("territorio_uf='BA'", "territorio_nm asc");
        $produto = $this->Produto_model->get_all_data_param("1=1", "produto_nm asc");

        $data = array(
            'produto_preco_data' => json($produto_preco),
            'territorio' => json($territorio),
            'produto' => json($produto),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('produto_preco/Produto_preco_qualidade', forFrontVue($data));
    }

    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $this->session->set_flashdata('message', '');
        $row = $this->Produto_preco_model->get_by_id($id);
        $produto = $this->Produto_model->get_all_combobox();
        $pessoa = $this->Pessoa_model->get_all_combobox();
        if ($row) {
            $data = array(
                'produto' => json($produto),
                'pessoa' => json($pessoa),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('produto_preco/create_action'),
                'produto_preco_id' => $row->produto_preco_id,
                'produto_id' => $row->produto_id,
                'pessoa_id' => $row->pessoa_id,
                'valor' => $row->valor,
                'produto_preco_dt' => $row->produto_preco_dt,
                'ativo' => $row->ativo,
            );
            $this->load->view('produto_preco/Produto_preco_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produto_preco'));
        }
    }











    public function ajax_carrega_cotacao()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $produto_id = (int)$this->input->get('produto_id', TRUE);
        $territorio_id = (int)$this->input->get('param_territorio_id', TRUE);
        $municipio_id = (int)$this->input->get('param_municipio_id', TRUE);
        $flag_exibir_todos_produtos_territorio = (int)$this->input->get('flag_exibir_todos_produtos_territorio', TRUE);


        $cotacao_pessoa_id = (int)$this->input->get('cotacao_pessoa_id', TRUE);

        if (empty($produto_id)) {
            echo json(array());
            exit;
        }




        $produto_preco = $this->Produto_preco_service->get_produto_preco($produto_id, $flag_exibir_todos_produtos_territorio, $parametro = null,  $cotacao_pessoa_id);



        echo json($produto_preco);
    }
    public function ajax_carrega_produto_preco()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $temp_produto_id = (int)$this->input->get('temp_produto_id', TRUE);
        if (empty($temp_produto_id)) {
            echo json(array());
            exit;
        }

        $param = array(
            array('produto.produto_id', '=', $temp_produto_id),
            array('produto_preco.ativo', '=', 1),
        );
        $produto_preco = $this->Produto_preco_model->get_all_data($param);

        echo json($produto_preco);
    }

    public function create($produto_id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $produto_selecionado = $this->Produto_model->get_by_id($produto_id);
        // var_dump($produto_selecionado);
        $produto_tipo = $this->Produto_tipo_model->get_by_id($produto_selecionado->produto_tipo_id);
        $unidade_medida = $this->Unidade_medida_model->get_by_id($produto_selecionado->unidade_medida_id);
        $categoria = $this->Categoria_model->get_by_id($produto_selecionado->categoria_id);

        $produto = $this->Produto_model->get_all_combobox();
        $pessoa = $this->Pessoa_model->get_all_combobox();
 
        
        //historico
        $produto_preco_territorio_historico = $this->Produto_preco_territorio_model->get_historico($produto_id, $_SESSION['pessoa_id']);
        // $territorio = $this->Territorio_model->get_all_com_preco('territorio.territorio_nm asc');

        $territorio = $this->Territorio_model->get_all("territorio_id !=54 and territorio_uf = 'BA'");
        foreach ($territorio as $key => $t) {
            $t->produto_preco_territorio_valor = $this->Produto_preco_territorio_model->get_valor_por_fornecedor_produto(
                $t->territorio_id,
                $_SESSION['pessoa_id'],
                $produto_id
            );
            $param = array(
                array('municipio.territorio_id', '=', $t->territorio_id)
            );
            //objeto montado na view pois estava muito lento
            $t->municipios =  $this->Municipio_model->get_all_data_simples($param, 'municipio.municipio_nm');
        }

        // var_dump($territorio);

        $data = array(
            'produto' => json($produto),
            'territorio' => json($territorio),
            'pessoa' => json($pessoa),
            'produto_preco_territorio_historico' => json($produto_preco_territorio_historico),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('produto_preco/create_action'),
            'produto_preco_id' => set_value('produto_preco_id'),
            'produto_id' => $produto_id,
            'produto_nm' => $produto_selecionado->produto_nm,
            'categoria_nm' => $categoria->categoria_nm,
            'produto_qtd' => $produto_selecionado->produto_qtd,
            'unidade_medida_nm' => $unidade_medida->unidade_medida_nm,
            'produto_tipo_nm' => @$produto_tipo->produto_tipo_nm,
            'pessoa_id' => set_value('pessoa_id'),
            'valor' => set_value('valor'),
            'produto_preco_dt' => set_value('produto_preco_dt'),
            'ativo' => set_value('ativo'),
        );
        $this->load->view('produto_preco/Produto_preco_form', forFrontVue($data));
    }

    public function create_action()
    {


        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $this->_rules();
        $this->form_validation->set_rules('produto_id', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('valor', NULL, 'trim');
        $this->form_validation->set_rules('produto_preco_dt', NULL, 'trim');
        $this->form_validation->set_rules('ativo', NULL, 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
                'produto_id' =>      empty($this->input->post('produto_id', TRUE)) ? NULL : $this->input->post('produto_id', TRUE),
                'pessoa_id' =>     $_SESSION['pessoa_id'],
                'valor' =>   0, //   empty($this->input->post('valor', TRUE)) ? NULL : $this->input->post('valor', TRUE),
                // 'produto_preco_dt' =>      empty($this->input->post('produto_preco_dt', TRUE)) ? NULL : $this->input->post('produto_preco_dt', TRUE),
                'ativo' =>      1,
            );

            //inativa todos antes de inserir o novo
            $this->Produto_preco_model->inativaTodos($this->input->post('produto_id', TRUE), $_SESSION['pessoa_id']);


            $this->Produto_preco_model->insert($data);
            $produto_preco_id = $this->db->insert_id();


            $this->Produto_preco_territorio_model->inativa_todos($this->input->post('produto_id', TRUE), $_SESSION['pessoa_id']);

            foreach ($this->input->post('territorio_id[]', TRUE) as $key => $territorio_id) {
                $produto_preco_territorio_valor = (float)$this->input->post("produto_preco_territorio_valor[$key]", TRUE);
                // if ($produto_preco_territorio_valor > 0) {
                $data = array(
                    'produto_preco_territorio_valor' => (float)$produto_preco_territorio_valor,
                    'territorio_id' => $territorio_id,
                    'produto_preco_id' => $produto_preco_id,
                    'produto_preco_territorio_pessoa_id' => $_SESSION['pessoa_id'],
                    'produto_preco_territorio_produto_id' => $this->input->post('produto_id', TRUE),
                );
                $this->Produto_preco_territorio_model->insert($data);
                // }
            }


            $this->db->trans_complete();
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            // redirect(site_url('produto/?filtro_produto_id=' . $this->input->post('produto_id', TRUE)));
            redirect(site_url('produto/'));
        }
    }


    public function renovar_todos_produtos_fornecedor_mesmo_preco()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Fornecedor']);

        $pessoa_id = (int)($_SESSION['pessoa_id'] ?? 0);
        if (empty($pessoa_id)) {
            $this->session->set_flashdata('message', 'Você não tem permissão para realizar esta ação');
            redirect("https://www.portalsema.ba.gov.br");
            exit;
        }

        // Inicia transação
        $this->db->trans_start();

        $produto_preco = $this->Produto_preco_model->get_all_data_param("pessoa.pessoa_id = $pessoa_id AND produto_preco.ativo = 1", "produto_preco.produto_preco_dt desc");


        foreach ($produto_preco as $pp) {

            // 1) INATIVA os antigos antes de inserir o novo ? evita inativar o registro que vamos inserir
            $this->Produto_preco_model->inativaTodos($pp->produto_id, $pessoa_id);

            // 2) Inserir novo registro
            $data = array(
                'produto_id' => $pp->produto_id,
                'pessoa_id'  => $pessoa_id,
                'valor'      => 0,
                'ativo'      => 1,
            );
            $this->Produto_preco_model->insert($data);
            $novo_produto_preco_id = $this->db->insert_id();

            if (empty($novo_produto_preco_id)) {
                echo json(['acao' => 'erro', 'mensagem' => 'Falha ao inserir produto_preco']);
                exit;
            }

            // 3) Pega territórios ativos do preço antigo 
            $produto_preco_territorio = $this->Produto_preco_territorio_model->get_produto_preco_territorio_ativos($pp->produto_preco_id, $pessoa_id);

            // Inativa territórios antigos (opcional, dependendo da sua lógica)
            $this->Produto_preco_territorio_model->inativa_todos($pp->produto_id, $pessoa_id);

            // 4) Replica territórios para o novo produto_preco
            foreach ($produto_preco_territorio as $ppt) {

                $dados_terr = array(
                    'produto_preco_territorio_valor'       => (float)$ppt->produto_preco_territorio_valor,
                    'territorio_id'                        => $ppt->territorio_id,
                    'produto_preco_id'                     => $novo_produto_preco_id,
                    'produto_preco_territorio_pessoa_id'   => $pessoa_id,
                    'produto_preco_territorio_produto_id'  => $pp->produto_id,
                );
                $this->Produto_preco_territorio_model->insert($dados_terr);
            }
        }

        // Finaliza transação
        $this->db->trans_complete();

        // sucesso
        echo json(array('acao' => 'sucesso'));
    }



    public function renovar_todos_produtos_fornecedor_mesmo_preco_old()
    {


        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Fornecedor']);


        $pessoa_id = (int)$_SESSION['pessoa_id'];
        if (empty($pessoa_id)) {
            $this->session->set_flashdata('message', 'Você não tem permissão para realizar esta ação');
            redirect("https://www.portalsema.ba.gov.br");
        }



        $this->db->trans_start();

        $produto_preco = $this->Produto_preco_model->get_all_data_param("pessoa.pessoa_id = " . $pessoa_id . " and produto_preco.ativo = 1", "produto_preco.produto_preco_dt desc");


        foreach ($produto_preco as $key => $pp) {
            $data = array(
                'produto_id' =>      $pp->produto_id,
                'pessoa_id' =>     $pessoa_id,
                'valor' =>   0,
                'ativo' =>   1,
            );
            $this->Produto_preco_model->insert($data);
            $novo_produto_preco_id = $this->db->insert_id();


            //salva os ativos q serão replicados
            $param = "      produto_preco_territorio.produto_preco_id =   $pp->produto_preco_id  
                        and produto_preco_territorio.produto_preco_territorio_pessoa_id = $pessoa_id
                        and produto_preco_territorio.produto_preco_territorio_ativo = 1 ";
            $produto_preco_territorio = $this->Produto_preco_territorio_model->get_all_data_param($param);

            //inativa todos, porem ja salvei na consulta acima os ativos
            $this->Produto_preco_model->inativaTodos($pp->produto_id, $pessoa_id);



            foreach ($produto_preco_territorio as $key => $ppt) {
                $territorio_id = $ppt->territorio_id;
                $produto_preco_territorio_valor = (float)$ppt->produto_preco_territorio_valor;
                $data = array(
                    'produto_preco_territorio_valor' => $produto_preco_territorio_valor,
                    'territorio_id' => $territorio_id,
                    'produto_preco_id' => $novo_produto_preco_id,
                    'produto_preco_territorio_pessoa_id' => $pessoa_id,
                    'produto_preco_territorio_produto_id' => $pp->produto_id,
                    'produto_preco_territorio_ativo' => 1,
                );
                $this->Produto_preco_territorio_model->insert($data);
            }
        }


        $this->db->trans_complete();


        echo json(array('acao' => 'sucesso'));
        exit;
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $this->session->set_flashdata('message', '');
        $row = $this->Produto_preco_model->get_by_id($id);
        $produto = $this->Produto_model->get_all_combobox();
        $pessoa = $this->Pessoa_model->get_all_combobox();
        if ($row) {
            $data = array(
                'produto' => json($produto),
                'pessoa' => json($pessoa),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('produto_preco/update_action'),
                'produto_preco_id' => set_value('produto_preco_id', $row->produto_preco_id),
                'produto_id' => set_value('produto_id', $row->produto_id),
                'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
                'valor' => set_value('valor', $row->valor),
                'produto_preco_dt' => set_value('produto_preco_dt', $row->produto_preco_dt),
                'ativo' => set_value('ativo', $row->ativo),
            );
            $this->load->view('produto_preco/Produto_preco_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('produto_preco'));
        }
    }

    public function update_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $this->_rules();
        $this->form_validation->set_rules('produto_id', 'produto_id', 'trim|required|integer');
        $this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim|required|integer');
        // $this->form_validation->set_rules('valor', 'valor', 'trim|required|decimal');
        $this->form_validation->set_rules('produto_preco_dt', 'produto_preco_dt', 'trim');
        $this->form_validation->set_rules('ativo', 'ativo', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('produto_preco_id', TRUE));
        } else {
            $data = array(
                'produto_id' => empty($this->input->post('produto_id', TRUE)) ? NULL : $this->input->post('produto_id', TRUE),
                'pessoa_id' => empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
                'valor' => empty($this->input->post('valor', TRUE)) ? NULL : $this->input->post('valor', TRUE),
                'produto_preco_dt' => empty($this->input->post('produto_preco_dt', TRUE)) ? NULL : $this->input->post('produto_preco_dt', TRUE),
                'ativo' => empty($this->input->post('ativo', TRUE)) ? NULL : $this->input->post('ativo', TRUE),
            );

            $this->Produto_preco_model->update($this->input->post('produto_preco_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('produto_preco'));
        }
    }

    /*
    public function delete($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $row = $this->Produto_preco_model->get_by_id($id);

        if ($row) {
            if (@$this->Produto_preco_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('produto_preco'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('produto_preco'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('produto_preco'));
        }
    }*/

    public function _rules()
    {

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $param = array(

            array('produto_id', '=', $this->input->post('produto_id', TRUE)),
            array('pessoa_id', '=', $this->input->post('pessoa_id', TRUE)),
            array('valor', '=', $this->input->post('valor', TRUE)),
            array('produto_preco_dt', '=', $this->input->post('produto_preco_dt', TRUE)),
            array('ativo', '=', $this->input->post('ativo', TRUE)),
        ); //end array dos parametros

        $data = array(
            'produto_preco_data' => $this->Produto_preco_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('produto_preco/Produto_preco_pdf', $data, true);


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
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Tecnico/Consultor', 'Nutricionista', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador']);
        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('produto_preco/open_pdf'),
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


        $this->load->view('produto_preco/Produto_preco_report', forFrontVue($data));
    }
}

/* End of file Produto_preco.php */
/* Local: ./application/controllers/Produto_preco.php */
/* Gerado por RGenerator - 2022-09-05 18:17:03 */