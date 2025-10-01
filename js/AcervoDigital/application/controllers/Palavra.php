<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Palavra extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Palavra_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'palavra/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'palavra/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'palavra/';
            $config['first_url'] = base_url() . 'palavra/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Palavra_model->total_rows($q);
        $palavra = $this->Palavra_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'palavra_data' => $palavra,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('palavra/Palavra_list', $data);
    }

    public function read($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Palavra_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('palavra/create_action'),
                'palavra_id' => $row->palavra_id,
                'palavra' => $row->palavra,
                'flag_aprovado' => $row->flag_aprovado,
            );
            $this->load->view('palavra/Palavra_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('palavra'));
        }
    }

    public function create() {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('palavra/create_action'),
            'palavra_id' => set_value('palavra_id'),
            'palavra' => set_value('palavra'),
            'flag_aprovado' => set_value('flag_aprovado'),
        );
        $this->load->view('palavra/Palavra_form', $data);
    }

    public function create_action() {
        $this->_rules();
        $this->form_validation->set_rules('palavra', NULL, 'trim|required|max_length[50]');
        $this->form_validation->set_rules('flag_aprovado', NULL, 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
                'palavra' => empty($this->input->post('palavra', TRUE)) ? NULL : $this->input->post('palavra', TRUE),
                'flag_aprovado' => empty($this->input->post('flag_aprovado', TRUE)) ? NULL : $this->input->post('flag_aprovado', TRUE),
            );

            $this->Palavra_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('palavra'));
        }
    }

    public function update($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Palavra_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('palavra/update_action'),
                'palavra_id' => set_value('palavra_id', $row->palavra_id),
                'palavra' => set_value('palavra', $row->palavra),
                'flag_aprovado' => set_value('flag_aprovado', $row->flag_aprovado),
            );
            $this->load->view('palavra/Palavra_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('palavra'));
        }
    }

    public function update_action() {
        $this->_rules();
        $this->form_validation->set_rules('palavra', 'palavra', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('flag_aprovado', 'flag_aprovado', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('palavra_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
                'palavra' => empty($this->input->post('palavra', TRUE)) ? NULL : $this->input->post('palavra', TRUE),
                'flag_aprovado' => empty($this->input->post('flag_aprovado', TRUE)) ? NULL : $this->input->post('flag_aprovado', TRUE),
            );

            $this->Palavra_model->update($this->input->post('palavra_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('palavra'));
        }
    }

    public function delete($id) {
        $row = $this->Palavra_model->get_by_id($id);

        if ($row) {
            if (@$this->Palavra_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('palavra'));
            } 
            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('palavra'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('palavra'));
        }
    }
    public function aprovar() {
        $palavra_id = $this->input->get('palavra_id', TRUE);
        $palavra = $this->input->get('palavra', TRUE);
        $obra_id    = $this->input->get('obra_id', TRUE);
          
        $data = array(
                        'flag_aprovado'  => 1          
        );
        $this->Palavra_model->update($palavra_id, $data);
        redirect(site_url('obra/read_aprovacao/'.$obra_id));
        
    }
    public function reprovar() {
        $palavra_id = $this->input->get('palavra_id', TRUE);
        $palavra = $this->input->get('palavra', TRUE);
        $obra_id    = $this->input->get('obra_id', TRUE);
          
        $data = array(
                        'flag_aprovado'  => 0          
        );
        $this->Palavra_model->update($palavra_id, $data);
        redirect(site_url('obra/read_aprovacao/'.$obra_id));
        
    }

    public function _rules() {
        $this->form_validation->set_rules('palavra', 'palavra', 'trim|required');
        $this->form_validation->set_rules('flag_aprovado', 'flag aprovado', 'trim|required');

        $this->form_validation->set_rules('palavra_id', 'palavra_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function open_pdf() {

        $param = array(
            array('palavra', '=', $this->input->post('palavra', TRUE)),
            array('flag_aprovado', '=', $this->input->post('flag_aprovado', TRUE)),); //end array dos parametros

        $data = array(
            'palavra_data' => $this->Palavra_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html = $this->load->view('palavra/Palavra_pdf', $data, true);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $caminhoImg = CPATH . 'imagens/Topo/bg_logo_min.png';

        //cabeçalho
        $pdf->SetHTMLHeader(" 
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

    public function report() {

        $data = array(
            'button' => 'Gerar',
            'controller' => 'report',
            'action' => site_url('palavra/open_pdf'),
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


        $this->load->view('palavra/Palavra_report', $data);
    }
    
   

}

/* End of file Palavra.php */
/* Local: ./application/controllers/Palavra.php */
/* Gerado por RGenerator - 2018-03-27 17:04:55 */