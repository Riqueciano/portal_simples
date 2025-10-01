<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fornecedor_categoria extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Fornecedor_categoria_model');
        $this->load->library('form_validation');
    }


    public function index()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = (int)$this->input->get('start');



        $config['per_page'] = 30;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Fornecedor_categoria_model->total_rows($q);
        // $fornecedor_categoria = $this->Fornecedor_categoria_model->get_limit_data($config['per_page'], $start, $q); 


        $tabelas = array(
            array(
                'cardinalidade' => '1',/*1 ou n*/
                'tabela' => 'TABELA_NM'
            ),
        );

        $fornecedor_categoria = $this->Fornecedor_categoria_model->get_query_json($where = null, $q, $limit = $config['per_page'], $start, $tabelas = array());

        ## para retorno json no front
        if ($format == 'json') {
            echo json($fornecedor_categoria);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'fornecedor_categoria_data' => json($fornecedor_categoria),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('fornecedor_categoria/Fornecedor_categoria_list', forFrontVue($data));
    }

    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Fornecedor_categoria_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => '',
                'controller' => 'read',
                'action' => site_url('fornecedor_categoria/create_action'),
                'fornecedor_categoria_id' => $row->fornecedor_categoria_id,
                'fornecedor_categoria_nm' => $row->fornecedor_categoria_nm,
            );
            $this->load->view('fornecedor_categoria/Fornecedor_categoria_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('fornecedor_categoria'));
        }
    }

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $data = array(

            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('fornecedor_categoria/create_action'),
            'fornecedor_categoria_id' => set_value('fornecedor_categoria_id'),
            'fornecedor_categoria_nm' => set_value('fornecedor_categoria_nm'),
        );
        $this->load->view('fornecedor_categoria/Fornecedor_categoria_form', forFrontVue($data));
    }

    public function create_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('fornecedor_categoria_nm', NULL, 'trim|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'fornecedor_categoria_nm' =>      empty($this->input->post('fornecedor_categoria_nm', TRUE)) ? NULL : $this->input->post('fornecedor_categoria_nm', TRUE),
            );

            $this->Fornecedor_categoria_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('fornecedor_categoria'));
        }
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Fornecedor_categoria_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('fornecedor_categoria/update_action'),
                'fornecedor_categoria_id' => set_value('fornecedor_categoria_id', $row->fornecedor_categoria_id),
                'fornecedor_categoria_nm' => set_value('fornecedor_categoria_nm', $row->fornecedor_categoria_nm),
            );
            $this->load->view('fornecedor_categoria/Fornecedor_categoria_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('fornecedor_categoria'));
        }
    }

    public function update_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('fornecedor_categoria_nm', 'fornecedor_categoria_nm', 'trim|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('fornecedor_categoria_id', TRUE));
        } else {
            $data = array(
                'fornecedor_categoria_nm' => empty($this->input->post('fornecedor_categoria_nm', TRUE)) ? NULL : $this->input->post('fornecedor_categoria_nm', TRUE),
            );

            $this->Fornecedor_categoria_model->update($this->input->post('fornecedor_categoria_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('fornecedor_categoria'));
        }
    }

    public function delete($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $row = $this->Fornecedor_categoria_model->get_by_id($id);

        if ($row) {
            if (@$this->Fornecedor_categoria_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('fornecedor_categoria'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('fornecedor_categoria'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('fornecedor_categoria'));
        }
    }

    public function _rules()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->form_validation->set_rules('fornecedor_categoria_nm', 'fornecedor categoria nm', 'trim|required');

        $this->form_validation->set_rules('fornecedor_categoria_id', 'fornecedor_categoria_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

        $param = array(

            array('fornecedor_categoria_nm', '=', $this->input->post('fornecedor_categoria_nm', TRUE)),
        ); //end array dos parametros

        $data = array(
            'fornecedor_categoria_data' => $this->Fornecedor_categoria_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('fornecedor_categoria/Fornecedor_categoria_pdf', $data, true);


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
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('fornecedor_categoria/open_pdf'),
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


        $this->load->view('fornecedor_categoria/Fornecedor_categoria_report', forFrontVue($data));
    }
}

/* End of file Fornecedor_categoria.php */
/* Local: ./application/controllers/Fornecedor_categoria.php */
/* Gerado por RGenerator - 2024-06-17 20:13:42 */