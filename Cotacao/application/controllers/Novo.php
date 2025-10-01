<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Novo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Novo_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'novo/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'novo/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'novo/';
            $config['first_url'] = base_url() . 'novo/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Novo_model->total_rows($q);
        $novo = $this->Novo_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($novo);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'novo_data' => json($novo),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('novo/Novo_list', forFrontVue($data));
    }

    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Novo_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => '',
                'controller' => 'read',
                'action' => site_url('novo/create_action'),
                'novo_id' => $row->novo_id,
                'novo' => $row->novo,
                'dataa' => $row->dataa,
            );
            $this->load->view('novo/Novo_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('novo'));
        }
    }

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $data = array(

            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('novo/create_action'),
            'novo_id' => set_value('novo_id'),
            'novo' => set_value('novo'),
            'dataa' => set_value('dataa'),
        );
        $this->load->view('novo/Novo_form', forFrontVue($data));
    }

    public function create_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('novo', NULL, 'trim|max_length[300]');
        $this->form_validation->set_rules('dataa', NULL, 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'novo' =>      empty($this->input->post('novo', TRUE)) ? NULL : $this->input->post('novo', TRUE),
                // 'dataa' =>      empty($this->input->post('dataa', TRUE)) ? NULL : $this->input->post('dataa', TRUE),
            );

            $this->Novo_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('novo'));
        }
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Novo_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('novo/update_action'),
                'novo_id' => set_value('novo_id', $row->novo_id),
                'novo' => set_value('novo', $row->novo),
                'dataa' => set_value('dataa', $row->dataa),
            );
            $this->load->view('novo/Novo_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('novo'));
        }
    }

    public function update_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('novo', 'novo', 'trim|max_length[300]');
        $this->form_validation->set_rules('dataa', 'dataa', 'trim');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('novo_id', TRUE));
        } else {
            $data = array(
                'novo' => empty($this->input->post('novo', TRUE)) ? NULL : $this->input->post('novo', TRUE),
                'dataa' => empty($this->input->post('dataa', TRUE)) ? NULL : $this->input->post('dataa', TRUE),
            );

            $this->Novo_model->update($this->input->post('novo_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('novo'));
        }
    }

    /*
    public function delete($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $row = $this->Novo_model->get_by_id($id);

        if ($row) {
            if (@$this->Novo_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('novo'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('novo'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('novo'));
        }
    }
        */

    public function _rules()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->form_validation->set_rules('novo', 'novo', 'trim|required');
        $this->form_validation->set_rules('dataa', 'dataa', 'trim|required');

        $this->form_validation->set_rules('novo_id', 'novo_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

        $param = array(

            array('novo', '=', $this->input->post('novo', TRUE)),
            array('dataa', '=', $this->input->post('dataa', TRUE)),
        ); //end array dos parametros

        $data = array(
            'novo_data' => $this->Novo_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('novo/Novo_pdf', $data, true);


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
            'action'        => site_url('novo/open_pdf'),
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


        $this->load->view('novo/Novo_report', forFrontVue($data));
    }
}

/* End of file Novo.php */
/* Local: ./application/controllers/Novo.php */
/* Gerado por RGenerator - 2024-01-19 14:31:29 */