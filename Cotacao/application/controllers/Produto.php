<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Produto_model');
        $this->load->model('Pessoa_model');
        $this->load->model('Produto_tipo_model');
        $this->load->model('Unidade_medida_model');
        $this->load->model('Produto_preco_model');
        $this->load->model('Categoria_model');
        $this->load->model('Produto_preco_territorio_model');

        $this->load->model('Status_model');
        $this->load->library('form_validation');
    }



    public function atualiza_lista_produto_filtro()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Fornecedor', 'Tecnico/consultor', 'Nutricionista']);


        $flag_exibir_produtos = $this->input->get('flag_exibir_produtos[]');
        $filtro_categoria_id = (int)$this->input->get('filtro_categoria_id');
       
        // echo $flag_exibir_produtos;
        if ($flag_exibir_produtos == 'sem_preco') {
            if (!empty($filtro_categoria_id)) {
                $param = " produto.categoria_id = $filtro_categoria_id";
            }
            else{
                $param = "1=1";
            }

            $produto = $this->Produto_model->get_all_data_param($param, 'trim(upper(produto_nm)) asc');
            echo json($produto);
        }
      
        if ($flag_exibir_produtos == 'com_preco') {
            $produto = $this->Produto_model->get_produto_com_preco($_SESSION['pessoa_id'],  $q = null, $limit = 999999, $filtro_produto_id = NULL, $filtro_categoria_id = null);
            echo json($produto);
        }
    }



public function buscar_filtro_produto_por_categoria()
{
    $produto = $this->Produto_model->get_all_data_param("produto.categoria_id = " . (int)$this->input->get('filtro_categoria_id'), 'produto_nm asc');
    echo json($produto);
}
    
    public function duplicar_produtos_marcados_para_organico()
    {
        $duplicar_produto = $this->input->post('duplicar_produto_id[]');
        $filtro_categoria_id = (int)$this->input->post('filtro_categoria_id');

        foreach ($duplicar_produto as $key => $duplicar_produto_id) {
            if ((int)$duplicar_produto_id > 0) {
                $produto = $this->Produto_model->get_by_id($duplicar_produto_id);

                $data = array(
                    'produto_nm' => rupper($produto->produto_nm) . " - ORGÂNICO",
                    'produto_ds' => '[ORGÂNICO] ' . rupper($produto->produto_ds),
                    'produto_tipo_id' => $produto->produto_tipo_id,
                    'status_id' => $produto->status_id,
                    'unidade_medida_id' => $produto->unidade_medida_id,
                    'produto_qtd' => $produto->produto_qtd,
                    'categoria_id' => $produto->categoria_id,
                    'flag_organico' => 1,
                );

                $this->Produto_model->insert($data);
            }
        }

        redirect(site_url("produto/?flag_exibir_produtos=sem_preco&filtro_categoria_id=" . $filtro_categoria_id));

        // var_dump($duplicar_produto_id);
    }
    public function duplicar_produtos_marcados_para_organico_unico($duplicar_produto_id)
    {
        $produto = $this->Produto_model->get_by_id((int)$duplicar_produto_id);



        function altera_descricao_produto($produto)
        {

            $nome = $produto->produto_nm;
            $descricao = $produto->produto_ds;

            $nova_descricao = str_replace("$nome,", "$nome - ORGÂNICO,", $descricao);
            return $nova_descricao;
        }

        $nova_descricao = altera_descricao_produto($produto);
        if ((int)$duplicar_produto_id > 0) {

            $data = array(
                'produto_nm' => rupper($produto->produto_nm) . " - ORGÂNICO",
                'produto_ds' =>  rupper($nova_descricao),
                'produto_tipo_id' => $produto->produto_tipo_id,
                'status_id' => $produto->status_id,
                'unidade_medida_id' => $produto->unidade_medida_id,
                'produto_qtd' => $produto->produto_qtd,
                'categoria_id' => $produto->categoria_id,
                'flag_organico' => 1,
            );

            $this->Produto_model->insert($data);
        }

        echo json(
            array('status' => 'success')
        );
    }



    public function ajax_carrega_produtos_por_municipio($municipio_id = null)
    {

        $produto = $this->Produto_model->get_produtos_por_municipio_para_o_combo($municipio_id);
        $select = array('' => 'id', '' => 'text');

        echo_pre($this->db->last_query());
        // $produto = array_merge($select, $produto);

        echo json($produto);
    }

    private function valida_perfil()
    {
        $perfil = $_SESSION['perfil'];
        if (rlower($perfil) == 'scolicitante' || rlower($perfil == 'comprador')) {
            $pes = $this->Pessoa_model->get_by_id($_SESSION['pessoa_id']);
            if (empty($pes->pessoa_cnpj)) {
                echo "Prezado, favor entrar em contato com a SUAF/SDR. Seu cadastro está incompleto";
                exit;
            }
        }
    }

    public function atualizaListaTodosProdutos()
    {
        $filtro_categoria_id = intval($this->input->get('filtro_categoria_id'));

        if (!empty($filtro_categoria_id)) {
            $listagem_todos_produtos = $this->Produto_model->get_all_data_param("produto.categoria_id = $filtro_categoria_id ", 'produto_nm asc');
        } else {
            $listagem_todos_produtos = $this->Produto_model->get_all_combobox(null, 'produto_nm asc');
        }

        echo json($listagem_todos_produtos);
    }

    public function index()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Fornecedor', 'Tecnico/consultor', 'Nutricionista']);

        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));
        $filtro_produto_id = intval($this->input->get('filtro_produto_id'));
        $filtro_categoria_id = intval($this->input->get('filtro_categoria_id'));
        $flag_exibir_produtos = urldecode($this->input->get('flag_exibir_produtos'));
        $flag_exibir_produtos = empty($flag_exibir_produtos) ? 'com_preco' : $flag_exibir_produtos;



        if ($q <> '') {
            $config['base_url']  = base_url() . 'produto/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'produto/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'produto/';
            $config['first_url'] = base_url() . 'produto/';
        }

        $config['per_page'] = 100000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Produto_model->total_rows($q);
        $produto_sem_preco = array();
        $produto_com_preco = array();
        //referente ao usuario logado

        if ($flag_exibir_produtos == 'com_preco') {
            $produto_com_preco = $this->Produto_model->get_produto_com_preco($_SESSION['pessoa_id'], $q, $limit = 10000);
            $produto_com_preco_todos = $produto_com_preco;
            $produto_sem_preco = array();
        }
        if ($flag_exibir_produtos == 'sem_preco') {
            $produto_com_preco = array();
            $produto_com_preco_todos = array();
            $produto_sem_preco = $this->Produto_model->get_produto_sem_preco($_SESSION['pessoa_id'], $q, $limit = $config['per_page'], $start);
        }

        // var_dump($produto_com_preco );
        foreach ($produto_com_preco as $key => $pp) {
            $param = array(
                // array('territorio.territorio_id','=',$pp->territorio_id),
                array('produto_preco.produto_id', '=', $pp->produto_id),
                array('produto_preco.pessoa_id', '=', $_SESSION['pessoa_id']),
                array('produto_preco_territorio.produto_preco_territorio_ativo', '=', 1),
            );
            //$pp->territorio_precos = $this->Produto_preco_territorio_model->get_all_data($param,'territorio_nm asc');
        }
        // foreach ($produto_sem_preco as $key => $pp) {            
        //     $param = array(
        //         // array('territorio.territorio_id','=',$pp->territorio_id),
        //         array('produto_preco.produto_id','=',$pp->produto_id),
        //         array('produto_preco.pessoa_id','=',$_SESSION['pessoa_id']),
        //     );
        //     $pp->territorio_precos = $this->Produto_preco_territorio_model->get_all_data($param);
        // }


        ## para retorno json no front
        if ($format == 'json/produto_com_preco') {
            echo json($produto_com_preco);
            exit;
        }
        if ($format == 'json/produto_sem_preco') {
            echo json($produto_sem_preco);
            exit;
        }


        $this->load->library('pagination');
        $this->pagination->initialize($config);


        $param = "categoria_id in (select categoria_id from cotacao.produto)";
        $categoria = $this->Categoria_model->get_all_combobox($param, 'trim(upper(categoria_nm)) asc');

        $listagem_todos_produtos = $this->Produto_model->get_all_combobox(null, 'trim(upper(produto_nm)) asc');

        $data = array(
            'produto_com_preco' => json($produto_com_preco),
            'produto_com_preco_todos' => json($produto_com_preco_todos),
            'produto_sem_preco' => json($produto_sem_preco),
            'categoria' => json($categoria),
            'listagem_todos_produtos' => json($listagem_todos_produtos),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'flag_exibir_produtos' => $flag_exibir_produtos,
            'filtro_produto_id' => $filtro_produto_id,
            'filtro_categoria_id' => $filtro_categoria_id,
            'perfil' => $_SESSION['perfil'],
        );
        $this->load->view('produto/Produto_list', forFrontVue($data));
    }
    public function busca_produtos()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $filtro_produto_id = (int)($this->input->get('filtro_produto_id', TRUE));
        $filtro_categoria_id = (int)($this->input->get('filtro_categoria_id', TRUE));
        $config['per_page'] = 100000;

        //    echo $filtro_produto_id ;exit;


        ## para retorno json no front
        if ($format == 'json/produto_com_preco') {
            $produto_com_preco = $this->Produto_model->get_produto_com_preco($_SESSION['pessoa_id'], $q, $limit = 10000, $filtro_produto_id, $filtro_categoria_id);
            foreach ($produto_com_preco as $key => $pp) {
                $param = array(
                    // array('territorio.territorio_id','=',$pp->territorio_id),
                    array('produto_preco.produto_id', '=', $pp->produto_id),
                    array('produto_preco.pessoa_id', '=', $_SESSION['pessoa_id']),
                    array('produto_preco_territorio.produto_preco_territorio_ativo', '=', 1),
                );
                $pp->territorio_precos = $this->Produto_preco_territorio_model->get_all_data($param, 'produto_preco_territorio_valor desc, territorio_nm');
                $pp->sql = $this->db->last_query();
            }
            echo json($produto_com_preco);
            exit;
        }
        if ($format == 'json/produto_sem_preco') {
            $produto_sem_preco = $this->Produto_model->get_produto_sem_preco($_SESSION['pessoa_id'], $q, $limit = $config['per_page'], $start = 0, $filtro_categoria_id, $filtro_produto_id);
            //  echo_pre($this->db->last_query());
            foreach ($produto_sem_preco as $key => $pp) {
                // $param = array(
                //     // array('territorio.territorio_id','=',$pp->territorio_id),
                //     array('produto_preco.produto_id', '=', $pp->produto_id),
                //     array('produto_preco.pessoa_id', '=', $_SESSION['pessoa_id']),
                //     array('produto_preco_territorio.produto_preco_territorio_ativo', '=', 1),
                // );
                $pp->territorio_precos = array();
                //$this->Produto_preco_territorio_model->get_all_data($param);
            }
            echo json($produto_sem_preco);
            exit;
        }
    }

    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Fornecedor', 'Tecnico/consultor', 'Nutricionista']);
        $this->session->set_flashdata('message', '');
        $row = $this->Produto_model->get_by_id($id);
        $produto_tipo = $this->Produto_tipo_model->get_all_combobox();
        $unidade_medida = $this->Unidade_medida_model->get_all_combobox();
        $status = $this->Status_model->get_all_combobox();
        if ($row) {
            $data = array(
                'produto_tipo' => json($produto_tipo),
                'status' => json($status),
                'unidade_medida' => json($unidade_medida),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('produto/create_action'),
                'produto_id' => $row->produto_id,
                'produto_nm' => $row->produto_nm,
                'produto_qtd' => $row->produto_qtd,
                'produto_ds' => $row->produto_ds,
                'unidade_medida_id' => $row->unidade_medida_id,
                'produto_tipo_id' => $row->produto_tipo_id,
                'categoria_id' => $row->categoria_id,
                'status_id' => $row->status_id,
                'flag_organico' => $row->flag_organico,
            );
            $this->load->view('produto/Produto_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produto'));
        }
    }

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Fornecedor', 'Tecnico/consultor', 'Nutricionista']);
        $produto_tipo = $this->Produto_tipo_model->get_all_combobox();
        $status = $this->Status_model->get_all_combobox();
        $unidade_medida = $this->Unidade_medida_model->get_all_combobox();
        $categoria = $this->Categoria_model->get_all_combobox();
        $data = array(
            'produto_tipo' => json($produto_tipo),
            'unidade_medida' => json($unidade_medida),
            'status' => json($status),
            'categoria' => json($categoria),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('produto/create_action'),
            'produto_id' => set_value('produto_id'),
            'produto_nm' => set_value('produto_nm'),
            'produto_qtd' => set_value('produto_qtd'),
            'produto_ds' => set_value('produto_ds'),
            'unidade_medida_id' => set_value('unidade_medida_id'),
            'produto_tipo_id' => set_value('produto_tipo_id'),
            'categoria_id' => set_value('categoria_id'),
            'status_id' => set_value('status_id'),
            'flag_organico' => set_value('flag_organico'),
        );
        $this->load->view('produto/Produto_form', forFrontVue($data));
    }

    public function create_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Fornecedor', 'Tecnico/consultor', 'Nutricionista']);
        $this->_rules();
        $this->form_validation->set_rules('produto_nm', NULL, 'trim|required|max_length[300]');
        $this->form_validation->set_rules('produto_ds', NULL, 'trim|max_length[800]');
        $this->form_validation->set_rules('produto_tipo_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('status_id', NULL, 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'produto_nm' =>      rupper((($this->input->post('produto_nm', TRUE)))),
                'produto_qtd' =>      empty($this->input->post('produto_qtd', TRUE)) ? 1 : $this->input->post('produto_qtd', TRUE),
                'produto_ds' =>      rupper(urldecode($this->input->post('produto_ds', TRUE))),
                'unidade_medida_id' =>      empty($this->input->post('unidade_medida_id', TRUE)) ? NULL : $this->input->post('unidade_medida_id', TRUE),
                'produto_tipo_id' =>      empty($this->input->post('produto_tipo_id', TRUE)) ? NULL : $this->input->post('produto_tipo_id', TRUE),
                'categoria_id' =>      empty($this->input->post('categoria_id', TRUE)) ? NULL : $this->input->post('categoria_id', TRUE),
                'status_id' =>      empty($this->input->post('status_id', TRUE)) ? NULL : $this->input->post('status_id', TRUE),
                'flag_organico' =>      empty($this->input->post('flag_organico', TRUE)) ? 0 : $this->input->post('flag_organico', TRUE),
            );

            $this->Produto_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('produto/?flag_exibir_produtos='));
        }
    }

    public function update($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Produto_model->get_by_id($id);
        $produto_tipo = $this->Produto_tipo_model->get_all_combobox();
        $status = $this->Status_model->get_all_combobox();
        $categoria = $this->Categoria_model->get_all_combobox();

        $unidade_medida = $this->Unidade_medida_model->get_all_combobox();
        if ($row) {
            $data = array(
                'produto_tipo' => json($produto_tipo),
                'status' => json($status),
                'categoria' => json($categoria),
                'unidade_medida' => json($unidade_medida),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('produto/update_action'),
                'produto_id' => set_value('produto_id', $row->produto_id),
                'produto_nm' => set_value('produto_nm', $row->produto_nm),
                'produto_qtd' => set_value('produto_qtd', $row->produto_qtd),
                'produto_ds' => set_value('produto_ds', $row->produto_ds),
                'unidade_medida_id' => set_value('unidade_medida_id', $row->unidade_medida_id),
                'produto_tipo_id' => set_value('produto_tipo_id', $row->produto_tipo_id),
                'categoria_id' => set_value('categoria_id', $row->categoria_id),
                'status_id' => set_value('status_id', $row->status_id),
                'flag_organico' => set_value('flag_organico', $row->flag_organico),
            );
            $this->load->view('produto/Produto_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('produto'));
        }
    }



    public function ajax_carrega_produtos_com_preco_valido_territorio()
    {
        $flag_exibir_todos_produtos_territorio = (int)$this->input->get('flag_exibir_todos_produtos_territorio', TRUE);

        $cotacao_pessoa_id = (int)$this->input->get('cotacao_pessoa_id', TRUE);
        $cotacao_pessoa_id = empty($cotacao_pessoa_id) ? $_SESSION['pessoa_id'] : $cotacao_pessoa_id;



        if ($flag_exibir_todos_produtos_territorio == 1) {
            $comprador = $this->Pessoa_model->get_by_id($cotacao_pessoa_id);
            // echo($comprador->cotacao_territorio_id);
            $produto = $this->Produto_model->get_produtos_validos_por_terriitorio($comprador->cotacao_territorio_id);
        } else {
            $produto = $this->Produto_model->get_produtos_validos_por_terriitorio();
        }

        // echo_pre($this->db->last_query());

        echo json($produto);
    }



    public function update_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('produto_nm', 'produto_nm', 'trim|required|max_length[300]');
        $this->form_validation->set_rules('produto_ds', 'produto_ds', 'trim|max_length[800]');
        $this->form_validation->set_rules('produto_tipo_id', 'produto_tipo_id', 'trim|integer');
        $this->form_validation->set_rules('status_id', 'status_id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('produto_id', TRUE));
        } else {
            $data = array(
                'produto_nm' => rupper($this->input->post('produto_nm', TRUE)),
                'produto_qtd' => empty($this->input->post('produto_qtd', TRUE)) ? NULL : $this->input->post('produto_qtd', TRUE),
                'produto_ds' => rupper(urldecode($this->input->post('produto_ds', TRUE))),
                'unidade_medida_id' => empty($this->input->post('unidade_medida_id', TRUE)) ? NULL : $this->input->post('unidade_medida_id', TRUE),
                'produto_tipo_id' => empty($this->input->post('produto_tipo_id', TRUE)) ? NULL : $this->input->post('produto_tipo_id', TRUE),
                'categoria_id' => empty($this->input->post('categoria_id', TRUE)) ? NULL : $this->input->post('categoria_id', TRUE),
                'status_id' => empty($this->input->post('status_id', TRUE)) ? NULL : $this->input->post('status_id', TRUE),
                'flag_organico' => empty($this->input->post('flag_organico', TRUE)) ? 0 : $this->input->post('flag_organico', TRUE),
            );


            $this->Produto_model->update($this->input->post('produto_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');


            //verifica se o produto tem algum preço lançado
            $param = array(
                array('produto.produto_id', '=', $this->input->post('produto_id', TRUE))
            );

            $produto_preco = $this->Produto_preco_model->get_all_data($param);
            if (count($produto_preco) == 0) {
                redirect(site_url('produto?flag_exibir_produtos=sem_preco'));
            } else {
                redirect(site_url('produto/?flag_exibir_produtos=com_preco'));
            }
        }
    }

    /*
    public function delete($id)
    {
        $row = $this->Produto_model->get_by_id($id);


        //verifica se o produto tem algum preço lançado
        $param = array(
            array('produto.produto_id', '=', $this->input->post('produto_id', TRUE))
        );
        $produto_preco = $this->Produto_preco_model->get_all_data($param);
        if (count($produto_preco) == 0) {
            $redirect = (site_url('produto?flag_exibir_produtos=sem_preco'));
        } else {
            $redirect = (site_url('produto/?flag_exibir_produtos=com_preco'));
        }
        if ($row) {
            if (@$this->Produto_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect($redirect);
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('produto'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('produto'));
        }
    }
        */

    public function _rules()
    {
        $this->form_validation->set_rules('produto_nm', 'produto nm', 'trim|required');
        $this->form_validation->set_rules('produto_ds', 'produto ds', 'trim|required');
        $this->form_validation->set_rules('produto_tipo_id', 'produto tipo id', 'trim|required');
        $this->form_validation->set_rules('status_id', 'status id', 'trim|required');

        $this->form_validation->set_rules('produto_id', 'produto_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {

        $param = array(

            array('produto_nm', '=', $this->input->post('produto_nm', TRUE)),
            array('produto_ds', '=', $this->input->post('produto_ds', TRUE)),
            array('produto_tipo_id', '=', $this->input->post('produto_tipo_id', TRUE)),
            array('status_id', '=', $this->input->post('status_id', TRUE)),
        ); //end array dos parametros

        $data = array(
            'produto_data' => $this->Produto_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('produto/Produto_pdf', $data, true);


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

        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('produto/open_pdf'),
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


        $this->load->view('produto/Produto_report', forFrontVue($data));
    }
}

/* End of file Produto.php */
/* Local: ./application/controllers/Produto.php */
/* Gerado por RGenerator - 2022-09-05 18:16:27 */