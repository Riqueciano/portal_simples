<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Unidade_medida extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Unidade_medida_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'unidade_medida/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'unidade_medida/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'unidade_medida/';
            $config['first_url'] = base_url() . 'unidade_medida/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Unidade_medida_model->total_rows($q);
        $unidade_medida = $this->Unidade_medida_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($unidade_medida);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'unidade_medida_data' => json($unidade_medida),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('unidade_medida/Unidade_medida_list', forFrontVue($data));
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Unidade_medida_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => '',
                'controller' => 'read',
                'action' => site_url('unidade_medida/create_action'),
                'unidade_medida_id' => $row->unidade_medida_id,
                'unidade_medida_nm' => $row->unidade_medida_nm,
                'ativo' => $row->ativo,
                'unidade_medida_sigla' => $row->unidade_medida_sigla,
            );
            $this->load->view('unidade_medida/Unidade_medida_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('unidade_medida'));
        }
    }

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $data = array(

            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('unidade_medida/create_action'),
            'unidade_medida_id' => set_value('unidade_medida_id'),
            'unidade_medida_nm' => set_value('unidade_medida_nm'),
            'ativo' => set_value('ativo'),
            'unidade_medida_sigla' => set_value('unidade_medida_sigla'),
        );
        $this->load->view('unidade_medida/Unidade_medida_form', forFrontVue($data));
    }

    public function create_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->_rules();
        $this->form_validation->set_rules('unidade_medida_nm', NULL, 'trim|max_length[250]');
        $this->form_validation->set_rules('ativo', NULL, 'trim|integer');
        $this->form_validation->set_rules('unidade_medida_sigla', NULL, 'trim|required|max_length[10]');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'unidade_medida_nm' =>      empty($this->input->post('unidade_medida_nm', TRUE)) ? NULL : $this->input->post('unidade_medida_nm', TRUE),
                'ativo' =>      empty($this->input->post('ativo', TRUE)) ? NULL : $this->input->post('ativo', TRUE),
                'unidade_medida_sigla' =>      empty($this->input->post('unidade_medida_sigla', TRUE)) ? NULL : $this->input->post('unidade_medida_sigla', TRUE),
            );

            $this->Unidade_medida_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('unidade_medida'));
        }
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->session->set_flashdata('message', '');
        $row = $this->Unidade_medida_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('unidade_medida/update_action'),
                'unidade_medida_id' => set_value('unidade_medida_id', $row->unidade_medida_id),
                'unidade_medida_nm' => set_value('unidade_medida_nm', $row->unidade_medida_nm),
                'ativo' => set_value('ativo', $row->ativo),
                'unidade_medida_sigla' => set_value('unidade_medida_sigla', $row->unidade_medida_sigla),
            );
            $this->load->view('unidade_medida/Unidade_medida_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('unidade_medida'));
        }
    }

    public function update_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->_rules();
        $this->form_validation->set_rules('unidade_medida_nm', 'unidade_medida_nm', 'trim|max_length[250]');
        $this->form_validation->set_rules('ativo', 'ativo', 'trim|integer');
        $this->form_validation->set_rules('unidade_medida_sigla', 'unidade_medida_sigla', 'trim|required|max_length[10]');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('unidade_medida_id', TRUE));
        } else {
            $data = array(
                'unidade_medida_nm' => empty($this->input->post('unidade_medida_nm', TRUE)) ? NULL : $this->input->post('unidade_medida_nm', TRUE),
                'ativo' => empty($this->input->post('ativo', TRUE)) ? NULL : $this->input->post('ativo', TRUE),
                'unidade_medida_sigla' => empty($this->input->post('unidade_medida_sigla', TRUE)) ? NULL : $this->input->post('unidade_medida_sigla', TRUE),
            );

            $this->Unidade_medida_model->update($this->input->post('unidade_medida_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('unidade_medida'));
        }
    }

    /*
    public function delete($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $row = $this->Unidade_medida_model->get_by_id($id);

        if ($row) {
            if (@$this->Unidade_medida_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('unidade_medida'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('unidade_medida'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('unidade_medida'));
        }
    }
        */

    public function _rules()
    {   PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->form_validation->set_rules('unidade_medida_nm', 'unidade medida nm', 'trim|required');
        $this->form_validation->set_rules('ativo', 'ativo', 'trim|required');
        $this->form_validation->set_rules('unidade_medida_sigla', 'unidade medida sigla', 'trim|required');

        $this->form_validation->set_rules('unidade_medida_id', 'unidade_medida_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $param = array(

            array('unidade_medida_nm', '=', $this->input->post('unidade_medida_nm', TRUE)),
            array('ativo', '=', $this->input->post('ativo', TRUE)),
            array('unidade_medida_sigla', '=', $this->input->post('unidade_medida_sigla', TRUE)),
        ); //end array dos parametros

        $data = array(
            'unidade_medida_data' => $this->Unidade_medida_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('unidade_medida/Unidade_medida_pdf', $data, true);


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
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);  

        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('unidade_medida/open_pdf'),
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


        $this->load->view('unidade_medida/Unidade_medida_report', forFrontVue($data));
    }
}

/* End of file Unidade_medida.php */
/* Local: ./application/controllers/Unidade_medida.php */
/* Gerado por RGenerator - 2022-09-14 14:31:32 */