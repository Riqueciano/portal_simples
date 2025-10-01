<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Funcionario_tipo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Funcionario_tipo_model');
        $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'funcionario_tipo/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'funcionario_tipo/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'funcionario_tipo/';
            $config['first_url'] = base_url() . 'funcionario_tipo/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Funcionario_tipo_model->total_rows($q);
        $funcionario_tipo = $this->Funcionario_tipo_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($funcionario_tipo);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'funcionario_tipo_data' => json($funcionario_tipo),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('funcionario_tipo/Funcionario_tipo_list', $data);
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Funcionario_tipo_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => '',
                'controller' => 'read',
                'action' => site_url('funcionario_tipo/create_action'),
                'funcionario_tipo_id' => $row->funcionario_tipo_id,
                'funcionario_tipo_ds' => $row->funcionario_tipo_ds,
                'funcionario_tipo_terceirizado' => $row->funcionario_tipo_terceirizado,
                'flag_ativo' => $row->flag_ativo,
            );
            $this->load->view('funcionario_tipo/Funcionario_tipo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('funcionario_tipo'));
        }
    }

    public function create()
    {
        $data = array(

            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('funcionario_tipo/create_action'),
            'funcionario_tipo_id' => set_value('funcionario_tipo_id'),
            'funcionario_tipo_ds' => set_value('funcionario_tipo_ds'),
            'funcionario_tipo_terceirizado' => set_value('funcionario_tipo_terceirizado'),
            'flag_ativo' => set_value('flag_ativo'),
        );
        $this->load->view('funcionario_tipo/Funcionario_tipo_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('funcionario_tipo_ds', NULL, 'trim|required|max_length[50]');
        $this->form_validation->set_rules('funcionario_tipo_terceirizado', NULL, 'trim|numeric');
        $this->form_validation->set_rules('flag_ativo', NULL, 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'funcionario_tipo_ds' =>      empty($this->input->post('funcionario_tipo_ds', TRUE)) ? NULL : $this->input->post('funcionario_tipo_ds', TRUE),
                'funcionario_tipo_terceirizado' =>      empty($this->input->post('funcionario_tipo_terceirizado', TRUE)) ? NULL : $this->input->post('funcionario_tipo_terceirizado', TRUE),
                'flag_ativo' =>      empty($this->input->post('flag_ativo', TRUE)) ? NULL : $this->input->post('flag_ativo', TRUE),
            );

            $this->Funcionario_tipo_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('funcionario_tipo'));
        }
    }

    public function update($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Funcionario_tipo_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('funcionario_tipo/update_action'),
                'funcionario_tipo_id' => set_value('funcionario_tipo_id', $row->funcionario_tipo_id),
                'funcionario_tipo_ds' => set_value('funcionario_tipo_ds', $row->funcionario_tipo_ds),
                'funcionario_tipo_terceirizado' => set_value('funcionario_tipo_terceirizado', $row->funcionario_tipo_terceirizado),
                'flag_ativo' => set_value('flag_ativo', $row->flag_ativo),
            );
            $this->load->view('funcionario_tipo/Funcionario_tipo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('funcionario_tipo'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('funcionario_tipo_ds', 'funcionario_tipo_ds', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('funcionario_tipo_terceirizado', 'funcionario_tipo_terceirizado', 'trim|numeric');
        $this->form_validation->set_rules('flag_ativo', 'flag_ativo', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('funcionario_tipo_id', TRUE));
        } else {
            $data = array(
                'funcionario_tipo_ds' => empty($this->input->post('funcionario_tipo_ds', TRUE)) ? NULL : $this->input->post('funcionario_tipo_ds', TRUE),
                'funcionario_tipo_terceirizado' => empty($this->input->post('funcionario_tipo_terceirizado', TRUE)) ? NULL : $this->input->post('funcionario_tipo_terceirizado', TRUE),
                'flag_ativo' => empty($this->input->post('flag_ativo', TRUE)) ? NULL : $this->input->post('flag_ativo', TRUE),
            );

            $this->Funcionario_tipo_model->update($this->input->post('funcionario_tipo_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('funcionario_tipo'));
        }
    }

    public function delete($id)
    {
        $row = $this->Funcionario_tipo_model->get_by_id($id);

        if ($row) {
            if (@$this->Funcionario_tipo_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('funcionario_tipo'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('funcionario_tipo'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('funcionario_tipo'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('funcionario_tipo_ds', 'funcionario tipo ds', 'trim|required');
        $this->form_validation->set_rules('funcionario_tipo_terceirizado', 'funcionario tipo terceirizado', 'trim|required');
        $this->form_validation->set_rules('flag_ativo', 'flag ativo', 'trim|required');

        $this->form_validation->set_rules('funcionario_tipo_id', 'funcionario_tipo_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {

        $param = array(

            array('funcionario_tipo_ds', '=', $this->input->post('funcionario_tipo_ds', TRUE)),
            array('funcionario_tipo_terceirizado', '=', $this->input->post('funcionario_tipo_terceirizado', TRUE)),
            array('flag_ativo', '=', $this->input->post('flag_ativo', TRUE)),
        ); //end array dos parametros

        $data = array(
            'funcionario_tipo_data' => $this->Funcionario_tipo_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('funcionario_tipo/Funcionario_tipo_pdf', $data, true);


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
            'action'        => site_url('funcionario_tipo/open_pdf'),
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


        $this->load->view('funcionario_tipo/Funcionario_tipo_report', $data);
    }
}

/* End of file Funcionario_tipo.php */
/* Local: ./application/controllers/Funcionario_tipo.php */
/* Gerado por RGenerator - 2022-06-29 19:55:37 */