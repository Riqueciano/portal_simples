<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vi_login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Vi_login_model');
        $this->load->library('form_validation');
    }

    public function index() {echo 1;exit;
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
echo 1;exit;
        if ($q <> '') {
            $config['base_url'] = base_url() . 'vi_login/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'vi_login/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'vi_login/';
            $config['first_url'] = base_url() . 'vi_login/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Vi_login_model->total_rows($q);
        $vi_login = $this->Vi_login_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'vi_login_data' => $vi_login,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('vi_login/Vi_login_list', $data);
    }

    public function read($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Vi_login_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('vi_login/create_action'),
                'sistema_id' => $row->sistema_id,
                'sistema_nm' => $row->sistema_nm,
                'tipo_usuario_id' => $row->tipo_usuario_id,
                'tipo_usuario_ds' => $row->tipo_usuario_ds,
                'pessoa_id' => $row->pessoa_id,
                'pessoa_nm' => $row->pessoa_nm,
                'funcionario_email' => $row->funcionario_email,
                'setaf_id' => $row->setaf_id,
                'setaf_nm' => $row->setaf_nm,
                'usuario_login' => $row->usuario_login,
                'usuario_senha' => $row->usuario_senha,
            );
            $this->load->view('vi_login/Vi_login_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('vi_login'));
        }
    }

    public function create() {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('vi_login/create_action'),
            'sistema_id' => set_value('sistema_id'),
            'sistema_nm' => set_value('sistema_nm'),
            'tipo_usuario_id' => set_value('tipo_usuario_id'),
            'tipo_usuario_ds' => set_value('tipo_usuario_ds'),
            'pessoa_id' => set_value('pessoa_id'),
            'pessoa_nm' => set_value('pessoa_nm'),
            'funcionario_email' => set_value('funcionario_email'),
            'setaf_id' => set_value('setaf_id'),
            'setaf_nm' => set_value('setaf_nm'),
            'usuario_login' => set_value('usuario_login'),
            'usuario_senha' => set_value('usuario_senha'),
        );
        $this->load->view('vi_login/Vi_login_form', $data);
    }

    public function create_action() {
        $this->_rules();
        $this->form_validation->set_rules('sistema_nm', NULL, 'trim|max_length[50]');
        $this->form_validation->set_rules('tipo_usuario_id', NULL, 'trim');
        $this->form_validation->set_rules('tipo_usuario_ds', NULL, 'trim|max_length[50]');
        $this->form_validation->set_rules('pessoa_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('pessoa_nm', NULL, 'trim|max_length[200]');
        $this->form_validation->set_rules('funcionario_email', NULL, 'trim|max_length[200]');
        $this->form_validation->set_rules('setaf_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('setaf_nm', NULL, 'trim|max_length[100]');
        $this->form_validation->set_rules('usuario_login', NULL, 'trim|max_length[50]');
        $this->form_validation->set_rules('usuario_senha', NULL, 'trim|max_length[9999]');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
                'sistema_nm' => empty($this->input->post('sistema_nm', TRUE)) ? NULL : $this->input->post('sistema_nm', TRUE),
                'tipo_usuario_id' => empty($this->input->post('tipo_usuario_id', TRUE)) ? NULL : $this->input->post('tipo_usuario_id', TRUE),
                'tipo_usuario_ds' => empty($this->input->post('tipo_usuario_ds', TRUE)) ? NULL : $this->input->post('tipo_usuario_ds', TRUE),
                'pessoa_id' => empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
                'pessoa_nm' => empty($this->input->post('pessoa_nm', TRUE)) ? NULL : $this->input->post('pessoa_nm', TRUE),
                'funcionario_email' => empty($this->input->post('funcionario_email', TRUE)) ? NULL : $this->input->post('funcionario_email', TRUE),
                'setaf_id' => empty($this->input->post('setaf_id', TRUE)) ? NULL : $this->input->post('setaf_id', TRUE),
                'setaf_nm' => empty($this->input->post('setaf_nm', TRUE)) ? NULL : $this->input->post('setaf_nm', TRUE),
                'usuario_login' => empty($this->input->post('usuario_login', TRUE)) ? NULL : $this->input->post('usuario_login', TRUE),
                'usuario_senha' => empty($this->input->post('usuario_senha', TRUE)) ? NULL : $this->input->post('usuario_senha', TRUE),
            );

            $this->Vi_login_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('vi_login'));
        }
    }

    public function update($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Vi_login_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('vi_login/update_action'),
                'sistema_id' => set_value('sistema_id', $row->sistema_id),
                'sistema_nm' => set_value('sistema_nm', $row->sistema_nm),
                'tipo_usuario_id' => set_value('tipo_usuario_id', $row->tipo_usuario_id),
                'tipo_usuario_ds' => set_value('tipo_usuario_ds', $row->tipo_usuario_ds),
                'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
                'pessoa_nm' => set_value('pessoa_nm', $row->pessoa_nm),
                'funcionario_email' => set_value('funcionario_email', $row->funcionario_email),
                'setaf_id' => set_value('setaf_id', $row->setaf_id),
                'setaf_nm' => set_value('setaf_nm', $row->setaf_nm),
                'usuario_login' => set_value('usuario_login', $row->usuario_login),
                'usuario_senha' => set_value('usuario_senha', $row->usuario_senha),
            );
            $this->load->view('vi_login/Vi_login_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('vi_login'));
        }
    }

    public function update_action() {
        $this->_rules();
        $this->form_validation->set_rules('sistema_nm', 'sistema_nm', 'trim|max_length[50]');
        $this->form_validation->set_rules('tipo_usuario_id', 'tipo_usuario_id', 'trim');
        $this->form_validation->set_rules('tipo_usuario_ds', 'tipo_usuario_ds', 'trim|max_length[50]');
        $this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim|integer');
        $this->form_validation->set_rules('pessoa_nm', 'pessoa_nm', 'trim|max_length[200]');
        $this->form_validation->set_rules('funcionario_email', 'funcionario_email', 'trim|max_length[200]');
        $this->form_validation->set_rules('setaf_id', 'setaf_id', 'trim|integer');
        $this->form_validation->set_rules('setaf_nm', 'setaf_nm', 'trim|max_length[100]');
        $this->form_validation->set_rules('usuario_login', 'usuario_login', 'trim|max_length[50]');
        $this->form_validation->set_rules('usuario_senha', 'usuario_senha', 'trim|max_length[9999]');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('sistema_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
                'sistema_nm' => empty($this->input->post('sistema_nm', TRUE)) ? NULL : $this->input->post('sistema_nm', TRUE),
                'tipo_usuario_id' => empty($this->input->post('tipo_usuario_id', TRUE)) ? NULL : $this->input->post('tipo_usuario_id', TRUE),
                'tipo_usuario_ds' => empty($this->input->post('tipo_usuario_ds', TRUE)) ? NULL : $this->input->post('tipo_usuario_ds', TRUE),
                'pessoa_id' => empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
                'pessoa_nm' => empty($this->input->post('pessoa_nm', TRUE)) ? NULL : $this->input->post('pessoa_nm', TRUE),
                'funcionario_email' => empty($this->input->post('funcionario_email', TRUE)) ? NULL : $this->input->post('funcionario_email', TRUE),
                'setaf_id' => empty($this->input->post('setaf_id', TRUE)) ? NULL : $this->input->post('setaf_id', TRUE),
                'setaf_nm' => empty($this->input->post('setaf_nm', TRUE)) ? NULL : $this->input->post('setaf_nm', TRUE),
                'usuario_login' => empty($this->input->post('usuario_login', TRUE)) ? NULL : $this->input->post('usuario_login', TRUE),
                'usuario_senha' => empty($this->input->post('usuario_senha', TRUE)) ? NULL : $this->input->post('usuario_senha', TRUE),
            );

            $this->Vi_login_model->update($this->input->post('sistema_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('vi_login'));
        }
    }

    public function delete($id) {
        $row = $this->Vi_login_model->get_by_id($id);

        if ($row) {
            if (@$this->Vi_login_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('vi_login'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('vi_login'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('vi_login'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('sistema_nm', 'sistema nm', 'trim|required');
        $this->form_validation->set_rules('tipo_usuario_id', 'tipo usuario id', 'trim|required');
        $this->form_validation->set_rules('tipo_usuario_ds', 'tipo usuario ds', 'trim|required');
        $this->form_validation->set_rules('pessoa_id', 'pessoa id', 'trim|required');
        $this->form_validation->set_rules('pessoa_nm', 'pessoa nm', 'trim|required');
        $this->form_validation->set_rules('funcionario_email', 'funcionario email', 'trim|required');
        $this->form_validation->set_rules('setaf_id', 'setaf id', 'trim|required');
        $this->form_validation->set_rules('setaf_nm', 'setaf nm', 'trim|required');
        $this->form_validation->set_rules('usuario_login', 'usuario login', 'trim|required');
        $this->form_validation->set_rules('usuario_senha', 'usuario senha', 'trim|required');

        $this->form_validation->set_rules('sistema_id', 'sistema_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function open_pdf() {

        $param = array(
            array('sistema_nm', '=', $this->input->post('sistema_nm', TRUE)),
            array('tipo_usuario_id', '=', $this->input->post('tipo_usuario_id', TRUE)),
            array('tipo_usuario_ds', '=', $this->input->post('tipo_usuario_ds', TRUE)),
            array('pessoa_id', '=', $this->input->post('pessoa_id', TRUE)),
            array('pessoa_nm', '=', $this->input->post('pessoa_nm', TRUE)),
            array('funcionario_email', '=', $this->input->post('funcionario_email', TRUE)),
            array('setaf_id', '=', $this->input->post('setaf_id', TRUE)),
            array('setaf_nm', '=', $this->input->post('setaf_nm', TRUE)),
            array('usuario_login', '=', $this->input->post('usuario_login', TRUE)),
            array('usuario_senha', '=', $this->input->post('usuario_senha', TRUE)),); //end array dos parametros

        $data = array(
            'vi_login_data' => $this->Vi_login_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html = $this->load->view('vi_login/Vi_login_pdf', $data, true);
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
            'action' => site_url('vi_login/open_pdf'),
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


        $this->load->view('vi_login/Vi_login_report', $data);
    }

}

/* End of file Vi_login.php */
/* Local: ./application/controllers/Vi_login.php */
/* Gerado por RGenerator - 2018-04-09 16:07:39 */