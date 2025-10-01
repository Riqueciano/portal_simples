<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cachorro extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Cachorro_model');
        $this->load->model('Raca_model');
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
        $config['total_rows'] = $this->Cachorro_model->total_rows($q);
        $cachorro = $this->Cachorro_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($cachorro);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'cachorro_data' => json($cachorro),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('cachorro/Cachorro_list', forFrontVue($data));
    }

    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Cachorro_model->get_by_id($id);
        $raca = $this->Raca_model->get_all_combobox();
        if ($row) {
            $data = array(
                'raca' => json($raca),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('cachorro/create_action'),
                'cachorro_id' => $row->cachorro_id,
                'cachorro_nm' => $row->cachorro_nm,
                'cachorro_descricao' => $row->cachorro_descricao,
                'nascimento' => $row->nascimento,
                'raca_id' => $row->raca_id,
            );
            $this->load->view('cachorro/Cachorro_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cachorro'));
        }
    }

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $raca = $this->Raca_model->get_all_combobox();
        $data = array(
            'raca' => json($raca),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('cachorro/create_action'),
            'cachorro_id' => set_value('cachorro_id'),
            'cachorro_nm' => set_value('cachorro_nm'),
            'cachorro_descricao' => set_value('cachorro_descricao'),
            'nascimento' => set_value('nascimento'),
            'raca_id' => set_value('raca_id'),
        );
        $this->load->view('cachorro/Cachorro_form', forFrontVue($data));
    }

    public function create_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('cachorro_nm', NULL, 'trim|required|max_length[20]');
        $this->form_validation->set_rules('cachorro_descricao', NULL, 'trim|max_length[600]');
        $this->form_validation->set_rules('nascimento', NULL, 'trim|required');
        $this->form_validation->set_rules('raca_id', NULL, 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'cachorro_nm' =>      empty($this->input->post('cachorro_nm', TRUE)) ? NULL : $this->input->post('cachorro_nm', TRUE),
                'cachorro_descricao' =>      empty($this->input->post('cachorro_descricao', TRUE)) ? NULL : $this->input->post('cachorro_descricao', TRUE),
                'nascimento' =>      empty($this->input->post('nascimento', TRUE)) ? NULL : $this->input->post('nascimento', TRUE),
                'raca_id' =>      empty($this->input->post('raca_id', TRUE)) ? NULL : $this->input->post('raca_id', TRUE),
            );

            $this->Cachorro_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('cachorro'));
        }
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Cachorro_model->get_by_id($id);
        $raca = $this->Raca_model->get_all_combobox();
        if ($row) {
            $data = array(
                'raca' => json($raca),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('cachorro/update_action'),
                'cachorro_id' => set_value('cachorro_id', $row->cachorro_id),
                'cachorro_nm' => set_value('cachorro_nm', $row->cachorro_nm),
                'cachorro_descricao' => set_value('cachorro_descricao', $row->cachorro_descricao),
                'nascimento' => set_value('nascimento', $row->nascimento),
                'raca_id' => set_value('raca_id', $row->raca_id),
            );
            $this->load->view('cachorro/Cachorro_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('cachorro'));
        }
    }

    public function update_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('cachorro_nm', 'cachorro_nm', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('cachorro_descricao', 'cachorro_descricao', 'trim|max_length[600]');
        $this->form_validation->set_rules('nascimento', 'nascimento', 'trim|required');
        $this->form_validation->set_rules('raca_id', 'raca_id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('cachorro_id', TRUE));
        } else {
            $data = array(
                'cachorro_nm' => empty($this->input->post('cachorro_nm', TRUE)) ? NULL : $this->input->post('cachorro_nm', TRUE),
                'cachorro_descricao' => empty($this->input->post('cachorro_descricao', TRUE)) ? NULL : $this->input->post('cachorro_descricao', TRUE),
                'nascimento' => empty($this->input->post('nascimento', TRUE)) ? NULL : $this->input->post('nascimento', TRUE),
                'raca_id' => empty($this->input->post('raca_id', TRUE)) ? NULL : $this->input->post('raca_id', TRUE),
            );

            $this->Cachorro_model->update($this->input->post('cachorro_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('cachorro'));
        }
    }

    public function delete($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $row = $this->Cachorro_model->get_by_id($id);

        if ($row) {
            if (@$this->Cachorro_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('cachorro'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('cachorro'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('cachorro'));
        }
    }

    public function _rules()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->form_validation->set_rules('cachorro_nm', 'cachorro nm', 'trim|required');
        $this->form_validation->set_rules('cachorro_descricao', 'cachorro descricao', 'trim|required');
        $this->form_validation->set_rules('nascimento', 'nascimento', 'trim|required');
        $this->form_validation->set_rules('raca_id', 'raca id', 'trim|required');

        $this->form_validation->set_rules('cachorro_id', 'cachorro_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

        $param = array(

            array('cachorro_nm', '=', $this->input->post('cachorro_nm', TRUE)),
            array('cachorro_descricao', '=', $this->input->post('cachorro_descricao', TRUE)),
            array('nascimento', '=', $this->input->post('nascimento', TRUE)),
            array('raca_id', '=', $this->input->post('raca_id', TRUE)),
        ); //end array dos parametros

        $data = array(
            'cachorro_data' => $this->Cachorro_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('cachorro/Cachorro_pdf', $data, true);


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
            'action'        => site_url('cachorro/open_pdf'),
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


        $this->load->view('cachorro/Cachorro_report', forFrontVue($data));
    }
}

/* End of file Cachorro.php */
/* Local: ./application/controllers/Cachorro.php */
/* Gerado por RGenerator - 2024-10-01 16:23:55 */