<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sistema extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Sistema_model');
        $this->load->library('form_validation');
    }

    public function index()
    { //echo 1;exit;
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'sistema/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'sistema/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'sistema/';
            $config['first_url'] = base_url() . 'sistema/';
        }

        $config['per_page'] = 1000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Sistema_model->total_rows($q);
        $sistema = $this->Sistema_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'sistema_data' => $sistema,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('sistema/Sistema_list', $data);
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Sistema_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('sistema/create_action'),
                'sistema_id' => $row->sistema_id,
                'sistema_nm' => $row->sistema_nm,
                'sistema_ds' => $row->sistema_ds,
                'sistema_icone' => $row->sistema_icone,
                // 'bootstrap_icon' => $row->bootstrap_icon,
                'sistema_st' => $row->sistema_st,
                'sistema_dt_criacao' => $row->sistema_dt_criacao,
                'sistema_dt_alteracao' => $row->sistema_dt_alteracao,
                'sistema_url' => $row->sistema_url,
                // 'controller_principal' => $row->controller_principal,
            );
            $this->load->view('sistema/Sistema_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('sistema'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('sistema/create_action'),
            // 'sistema_id' => set_value('sistema_id'),
            'sistema_id_correto' => set_value('sistema_id_correto'),
            'sistema_nm' => set_value('sistema_nm'),
            'sistema_ds' => set_value('sistema_ds'),
            'sistema_icone' => set_value('sistema_icone'),
            // 'bootstrap_icon' => 'glyphicon glyphicon-asterisk',
            'sistema_st' => set_value('sistema_st'),
            'sistema_dt_criacao' => set_value('sistema_dt_criacao'),
            'sistema_dt_alteracao' => set_value('sistema_dt_alteracao'),
            'sistema_url' => set_value('sistema_url'),
            // 'controller_principal' => set_value('controller_principal'),
        );
        $this->load->view('sistema/Sistema_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('sistema_nm', NULL, 'trim|required|max_length[50]');
        $this->form_validation->set_rules('sistema_ds', NULL, 'trim|max_length[255]');
        $this->form_validation->set_rules('sistema_icone', NULL, 'trim|max_length[50]');
        $this->form_validation->set_rules('sistema_st', NULL, 'trim|numeric');
        $this->form_validation->set_rules('sistema_url', NULL, 'trim|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'sistema_nm' => empty($this->input->post('sistema_nm', TRUE)) ? NULL : $this->input->post('sistema_nm', TRUE),
                'sistema_ds' => empty($this->input->post('sistema_ds', TRUE)) ? NULL : $this->input->post('sistema_ds', TRUE),
                'sistema_icone' => empty($this->input->post('sistema_icone', TRUE)) ? NULL : $this->input->post('sistema_icone', TRUE),
                // 'bootstrap_icon' => empty($this->input->post('bootstrap_icon', TRUE)) ? NULL : $this->input->post('bootstrap_icon', TRUE),
                'sistema_st' => empty($this->input->post('sistema_st', TRUE)) ? 0 : $this->input->post('sistema_st', TRUE),
                // 'controller_principal' => empty($this->input->post('controller_principal', TRUE)) ? 0 : $this->input->post('controller_principal', TRUE),
                'sistema_dt_criacao' => date('Y-m-d'),
                'sistema_url' => "../" . $this->input->post('sistema_url', TRUE) . '/Index.php',
            );

            $this->Sistema_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('sistema'));
        }
    }

    public function update($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Sistema_model->get_by_id($id);

        // echo ($row->sistema_nm );
        if ($row) {
            $sistema_url = $row->sistema_url;
            $sistema_url = str_replace('../', '', $sistema_url);
            $sistema_url = str_replace('/Index.php', '', $sistema_url);
            $sistema_url = str_replace('/index.php', '', $sistema_url);

            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('sistema/update_action'),
                'sistema_id_correto' => $id,
                'sistema_nm' =>  $row->sistema_nm,
                'sistema_ds' =>  $row->sistema_ds,
                'sistema_icone' =>  $row->sistema_icone,
                // 'bootstrap_icon' => set_value('bootstrap_icon', $row->bootstrap_icon),
                'sistema_st' => $row->sistema_st,
                // 'controller_principal' => set_value('controller_principal', $row->controller_principal),
                'sistema_dt_criacao' =>  $row->sistema_dt_criacao,
                'sistema_dt_alteracao' => $row->sistema_dt_alteracao,
                'sistema_url' => $sistema_url,
            );
            $this->load->view('sistema/Sistema_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('sistema'));
        }
    }
    public function ativar_inativar($id)
    { //echo
        $row = $this->Sistema_model->get_by_id($id);
        if ($row->sistema_st == 1) {
            $sistema_st = 0;
        } else {
            $sistema_st = 1;
        }

        $data = array(
            'sistema_st' => $sistema_st
        );

        // print_r($data );exit;
        $this->Sistema_model->Update($id, $data);


        redirect(site_url('sistema'));
    }

    public function update_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('sistema_nm', 'sistema_nm', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('sistema_ds', 'sistema_ds', 'trim|max_length[255]');
        $this->form_validation->set_rules('sistema_icone', 'sistema_icone', 'trim|max_length[50]');
        $this->form_validation->set_rules('sistema_st', 'sistema_st', 'trim|numeric');
        $this->form_validation->set_rules('sistema_url', 'sistema_url', 'trim|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('sistema_id', TRUE));
        } else {
            $data = array(
                'sistema_nm' => empty($this->input->post('sistema_nm', TRUE)) ? NULL : $this->input->post('sistema_nm', TRUE),
                'sistema_ds' => empty($this->input->post('sistema_ds', TRUE)) ? NULL : $this->input->post('sistema_ds', TRUE),
                'sistema_icone' => empty($this->input->post('sistema_icone', TRUE)) ? NULL : $this->input->post('sistema_icone', TRUE),
                // 'bootstrap_icon' => empty($this->input->post('bootstrap_icon', TRUE)) ? NULL : $this->input->post('bootstrap_icon', TRUE),
                'sistema_st' => empty($this->input->post('sistema_st', TRUE)) ? 0 : $this->input->post('sistema_st', TRUE),
                // 'controller_principal' => empty($this->input->post('controller_principal', TRUE)) ? 0 : $this->input->post('controller_principal', TRUE),
                'sistema_dt_alteracao' => date('Y-m-d'),
                'sistema_url' => "../" . trim($this->input->post('sistema_url', TRUE)) . '/Index.php',
            );

            $this->Sistema_model->update($this->input->post('sistema_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('sistema'));
        }
    }

    /*
    public function delete($id)
    {
        $row = $this->Sistema_model->get_by_id($id);

        if ($row) {
            if (@$this->Sistema_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('sistema'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('sistema'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('sistema'));
        }
    }
        */

    public function _rules()
    {
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function open_pdf()
    {

        $param = array(
            array('sistema_nm', '=', $this->input->post('sistema_nm', TRUE)),
            array('sistema_ds', '=', $this->input->post('sistema_ds', TRUE)),
            array('sistema_icone', '=', $this->input->post('sistema_icone', TRUE)),
            array('sistema_st', '=', $this->input->post('sistema_st', TRUE)),
            array('sistema_dt_criacao', '=', $this->input->post('sistema_dt_criacao', TRUE)),
            array('sistema_dt_alteracao', '=', $this->input->post('sistema_dt_alteracao', TRUE)),
            array('sistema_url', '=', $this->input->post('sistema_url', TRUE)),
        ); //end array dos parametros

        $data = array(
            'sistema_data' => $this->Sistema_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html = $this->load->view('sistema/Sistema_pdf', $data, true);


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
            'button' => 'Gerar',
            'controller' => 'report',
            'action' => site_url('sistema/open_pdf'),
            'recurso_id' => null,
            'recurso_nm' => null,
            'recurso_tombo' => null,
            'conservacao_id' => null,
            'setaf_id' => null,
            'localizacao' => null,
            'municipio_id' => null,
            'caminho' => null,
            'documento_id' => null,
            'requerente_id' => null,
        );


        $this->load->view('sistema/Sistema_report', $data);
    }
}

/* End of file Sistema.php */
/* Local: ./application/controllers/Sistema.php */
/* Gerado por RGenerator - 2020-01-13 10:59:29 */