<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Entidade_tecnico extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Entidade_tecnico_model');
        $this->load->model('Pessoa_model');
        $this->load->model('Usuario_model');
        $this->load->model('Tecnico_log_model');
        $this->load->model('Usuario_tipo_usuario_model');

        $this->load->library('form_validation');
    }

    public function index() {
        $q = trim(urldecode($this->input->get('q', TRUE)));
        $start = intval($this->input->get('start'));
        $lote_id = ($this->input->get('lote_id'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'entidade_tecnico/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'entidade_tecnico/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'entidade_tecnico/';
            $config['first_url'] = base_url() . 'entidade_tecnico/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        
        $param = $lote_id == ''?' 1=1 ':'lote.lote_id = '.$lote_id;
        
        if(!empty($q)){
            $param .= " and ( 
                             pessoa.pessoa_nm ilike '%$q%'";
            $param .= "      or pessoa.pessoa_nm ilike '%$q%'";
            $param .= "      or tecnico_cpf ilike '%$q%'";
            $param .= "      )";
        }
        
        $entidade_tecnico = $this->Entidade_tecnico_model->get_limit_data($config['per_page'], $start, $q, $param);
        $config['total_rows'] = count($entidade_tecnico);
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'entidade_tecnico_data' => $entidade_tecnico,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'lote_id' => $lote_id,
        );
        $this->load->view('entidade_tecnico/Entidade_tecnico_list', $data);
    }

    public function read($id) {
        
        
        $this->session->set_flashdata('message', '');

        $param = array(
            array('entidade_tecnico.entidade_tecnico_id', '=', $id),
           // array('entidade_tecnico.pessoa_id', '=', $_SESSION['pessoa_id']),
        );
        $row = $this->Entidade_tecnico_model->get_all_data($param);

        $param = array(
            array('entidade_tecnico.entidade_tecnico_id', '=', $id)
        );
        $tecnico_log_model = $this->Tecnico_log_model->get_all_data($param);

        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('entidade_tecnico/create_action'),
                'entidade_tecnico_id' => $row->entidade_tecnico_id,
                'entidade_id' => $row->entidade_id,
                'tecnico_cpf' => $row->tecnico_cpf,
                'tecnico_email' => $row->tecnico_email,
                'pessoa_id' => $row->pessoa_id,
                'tecnico_ddd_1' => $row->tecnico_ddd_1,
                'tecnico_tel_1' => $row->tecnico_tel_1,
                'tecnico_ddd_2' => $row->tecnico_ddd_2,
                'tecnico_tel_2' => $row->tecnico_tel_2,
                'tecnico_email_2' => $row->tecnico_email_2,
                'flag_preposto' => $row->flag_preposto,
                'lote_id' => $row->lote_id,
                'tecnico_log_model' => $tecnico_log_model,
            );
            $this->load->view('entidade_tecnico/Entidade_tecnico_form', $data);
        } else { //echo 12;
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('entidade_tecnico'));
        }
    }

    public function AjaxValidaCPFUnico() {
        $this->session->set_flashdata('message', '');

        $tecnico_cpf = $this->input->post('tecnico_cpf', TRUE);
        $controller = $this->input->post('controller', TRUE);
        $entidade_tecnico_id = $this->input->post('entidade_tecnico_id', TRUE);

        $param = array(
            array('entidade_tecnico.tecnico_cpf', '=', $tecnico_cpf),
            array('entidade_tecnico.tecnico_id', '!=', $entidade_tecnico_id),
        );
        $row = $this->Entidade_tecnico_model->get_all_data($param);


        if ($row) {
            echo 'existe';
        }
    }

    public function AjaxValidaPreposto() {
        $this->session->set_flashdata('message', '');

        $entidade_id = $this->input->post('entidade_id', TRUE);
        $controller = $this->input->post('controller', TRUE);
        $entidade_tecnico_id = $this->input->post('entidade_tecnico_id', TRUE);

        $param = array(
            array('entidade_tecnico.entidade_id', '=', $entidade_id),
            array('entidade_tecnico.tecnico_id', '!=', $entidade_tecnico_id),
            array('entidade_tecnico.flag_preposto', '=', 1),
        );
        $row = $this->Entidade_tecnico_model->get_all_data($param);


        if ($row) {
            echo 'existe';
        }
    }

    public function AjaxListagemTecnicos() {
        $this->session->set_flashdata('message', '');

        $entidade_id = $this->input->post('entidade_id', TRUE);


        $param = array(
            array('entidade_tecnico.entidade_id', '=', $entidade_id),
            //array('entidade_tecnico.flag_preposto', '=', '1'),
        );
        $entidade_tecnico_preposto = $this->Entidade_tecnico_model->get_all_data($param);
        //paga os outros
        
        $table = "<table class='table'>";
        $table .= "<tr><th>Técnico</th><th>Telefone</th></tr>";
        foreach ($entidade_tecnico_preposto as $ep) {
            if (!empty($ep->pessoa_nm)) {
                $preposto = ($ep->flag_preposto==1)?'[Preposto]':'';
                $b1 = ($ep->flag_preposto==1)?'<b>':'';
                $b2 = ($ep->flag_preposto==1)?'</b>':'';
                $table .= "<tr> 
                                <td>$b1 $ep->pessoa_nm  <a>$preposto</a>$b2</td>     
                                <td>($ep->tecnico_ddd_1) $ep->tecnico_tel_1</td>     
                           </tr>";
            }
        }
        
        
        $table .= "</table>";
        echo $table;
    }

    public function create() {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('entidade_tecnico/create_action'),
            'entidade_tecnico_id' => set_value('entidade_tecnico_id'),
            'entidade_id' => set_value('entidade_id'),
            'tecnico_cpf' => set_value('tecnico_cpf'),
            'tecnico_email' => set_value('tecnico_email'),
            'pessoa_id' => set_value('pessoa_id'),
            'tecnico_ddd_1' => set_value('tecnico_ddd_1'),
            'tecnico_tel_1' => set_value('tecnico_tel_1'),
            'tecnico_ddd_2' => set_value('tecnico_ddd_2'),
            'tecnico_tel_2' => set_value('tecnico_tel_2'),
            'tecnico_email_2' => set_value('tecnico_email_2'),
            'flag_preposto' => set_value('flag_preposto'),
            'lote_id' => set_value('lote_id'),
            'tecnico_log_model' => array(),
        );
        $this->load->view('entidade_tecnico/Entidade_tecnico_form', $data);
    }

    public function create_action() {
        $this->_rules();
        $this->form_validation->set_rules('entidade_id', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('tecnico_cpf', NULL, 'trim|required|max_length[25]');
        $this->form_validation->set_rules('tecnico_email', NULL, 'trim|required|max_length[80]');
        $this->form_validation->set_rules('pessoa_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('pessoa_nm', NULL, 'trim');
        $this->form_validation->set_rules('tecnico_ddd_1', NULL, 'trim|required|max_length[3]');
        $this->form_validation->set_rules('tecnico_tel_1', NULL, 'trim|required|max_length[15]');
        $this->form_validation->set_rules('tecnico_ddd_2', NULL, 'trim|max_length[3]');
        $this->form_validation->set_rules('tecnico_tel_2', NULL, 'trim|max_length[15]');
        $this->form_validation->set_rules('tecnico_email_2', NULL, 'trim|max_length[80]');
        $this->form_validation->set_rules('flag_preposto', NULL, 'trim|required');
        $this->form_validation->set_rules('lote_id', NULL, 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

            ##inserindo pessoa
            $data = array(
                'pessoa_nm' => $this->input->post('pessoa_nm', TRUE),
                'pessoa_tipo' => 'F',
                'pessoa_st' => '0',
                'pessoa_usuario_criador' => (int) $_SESSION['pessoa_id'],
                'pessoa_dt_criacao' => date('Y-m-d'),
                'pessoa_email' => $this->input->post('tecnico_email', TRUE),
            );
            $this->Pessoa_model->insert($data);
            $pessoa_id = $this->db->insert_id();


            ##inserindo usuario
            $data = array(
                'pessoa_id' => $pessoa_id,
                'usuario_login' => $this->input->post('tecnico_cpf', TRUE),
                'usuario_senha' => md5('sdr'),
                'usuario_st' => '0',
                'usuario_dt_criacao' => date('Y-m-d'),
                'usuario_primeiro_logon' => '0',
                'usuario_diaria' => '0',
            );
            $this->Usuario_model->insert($data);


            ############################
            #inserindo dados do tecnico
            $data = array(
                'entidade_id' => empty($this->input->post('entidade_id', TRUE)) ? NULL : $this->input->post('entidade_id', TRUE),
                'tecnico_cpf' => empty($this->input->post('tecnico_cpf', TRUE)) ? NULL : $this->input->post('tecnico_cpf', TRUE),
                'tecnico_email' => empty($this->input->post('tecnico_email', TRUE)) ? NULL : $this->input->post('tecnico_email', TRUE),
                'pessoa_id' => $pessoa_id,
                'tecnico_ddd_1' => empty($this->input->post('tecnico_ddd_1', TRUE)) ? NULL : $this->input->post('tecnico_ddd_1', TRUE),
                'tecnico_tel_1' => empty($this->input->post('tecnico_tel_1', TRUE)) ? NULL : $this->input->post('tecnico_tel_1', TRUE),
                'tecnico_ddd_2' => empty($this->input->post('tecnico_ddd_2', TRUE)) ? NULL : $this->input->post('tecnico_ddd_2', TRUE),
                'tecnico_tel_2' => empty($this->input->post('tecnico_tel_2', TRUE)) ? NULL : $this->input->post('tecnico_tel_2', TRUE),
                'tecnico_email_2' => empty($this->input->post('tecnico_email_2', TRUE)) ? NULL : $this->input->post('tecnico_email_2', TRUE),
                'flag_preposto' => empty($this->input->post('flag_preposto', TRUE)) ? NULL : $this->input->post('flag_preposto', TRUE),
                'lote_id' => empty($this->input->post('lote_id', TRUE)) ? NULL : $this->input->post('lote_id', TRUE),
            );

            $this->Entidade_tecnico_model->insert($data);
            $entidade_tecnico_id = $this->db->insert_id();


            ######################
            #insere logo da criação do usuario
            unset($date);
            $data = array(
                'log_ds' => 'Cadastro do Usuário',
                'pessoa_id' => $_SESSION['pessoa_id'],
                'entidade_tecnico_id' => $entidade_tecnico_id,
            );
            $this->Tecnico_log_model->insert($data);
            //exit;
            ################################
            #insere o perfil do usuario
            $data = array(
                'pessoa_id' => $pessoa_id,
                'tipo_usuario_id' => 167/* Execução entidade */,
            );
            $this->Usuario_tipo_usuario_model->insert($data);

            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('entidade_tecnico'));
        }
    }

    public function update($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Entidade_tecnico_model->get_by_id($id);
        $param = array(
            array('entidade_tecnico.entidade_tecnico_id', '=', $id)
        );
        $tecnico_log_model = $this->Tecnico_log_model->get_all_data($param);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('entidade_tecnico/update_action'),
                'entidade_tecnico_id' => set_value('entidade_tecnico_id', $row->entidade_tecnico_id),
                'entidade_id' => set_value('entidade_id', $row->entidade_id),
                'tecnico_cpf' => set_value('tecnico_cpf', $row->tecnico_cpf),
                'tecnico_email' => set_value('tecnico_email', $row->tecnico_email),
                'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
                'tecnico_ddd_1' => set_value('tecnico_ddd_1', $row->tecnico_ddd_1),
                'tecnico_tel_1' => set_value('tecnico_tel_1', $row->tecnico_tel_1),
                'tecnico_ddd_2' => set_value('tecnico_ddd_2', $row->tecnico_ddd_2),
                'tecnico_tel_2' => set_value('tecnico_tel_2', $row->tecnico_tel_2),
                'tecnico_email_2' => set_value('tecnico_email_2', $row->tecnico_email_2),
                'flag_preposto' => set_value('flag_preposto', $row->flag_preposto),
                'lote_id' => set_value('lote_id', $row->lote_id),
                'tecnico_log_model' => $tecnico_log_model,
            );
            $this->load->view('entidade_tecnico/Entidade_tecnico_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('entidade_tecnico'));
        }
    }

    public function update_action() {
        $this->_rules();
        $this->form_validation->set_rules('entidade_id', ' ', 'trim|required|integer');
        $this->form_validation->set_rules('tecnico_cpf', ' ', 'trim|required|max_length[25]');
        $this->form_validation->set_rules('tecnico_email', ' ', 'trim|required|max_length[80]');
        $this->form_validation->set_rules('pessoa_id', ' ', 'trim|integer');
        $this->form_validation->set_rules('tecnico_ddd_1', NULL, 'trim|required|max_length[3]');
        $this->form_validation->set_rules('tecnico_tel_1', NULL, 'trim|required|max_length[15]');
        $this->form_validation->set_rules('tecnico_ddd_2', NULL, 'trim|max_length[3]');
        $this->form_validation->set_rules('tecnico_tel_2', NULL, 'trim|max_length[15]');
        $this->form_validation->set_rules('tecnico_email_2', NULL, 'trim|max_length[80]');
        $this->form_validation->set_rules('flag_preposto', NULL, 'trim|required');
        $this->form_validation->set_rules('lote_id', NULL, 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('entidade_tecnico_id', TRUE));
        } else {
            $data = array(
                'entidade_id' => empty($this->input->post('entidade_id', TRUE)) ? NULL : $this->input->post('entidade_id', TRUE),
                'tecnico_cpf' => empty($this->input->post('tecnico_cpf', TRUE)) ? NULL : $this->input->post('tecnico_cpf', TRUE),
                'tecnico_email' => empty($this->input->post('tecnico_email', TRUE)) ? NULL : $this->input->post('tecnico_email', TRUE),
                'pessoa_id' => empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
                'tecnico_ddd_1' => empty($this->input->post('tecnico_ddd_1', TRUE)) ? NULL : $this->input->post('tecnico_ddd_1', TRUE),
                'tecnico_tel_1' => empty($this->input->post('tecnico_tel_1', TRUE)) ? NULL : $this->input->post('tecnico_tel_1', TRUE),
                'tecnico_ddd_2' => empty($this->input->post('tecnico_ddd_2', TRUE)) ? NULL : $this->input->post('tecnico_ddd_2', TRUE),
                'tecnico_tel_2' => empty($this->input->post('tecnico_tel_2', TRUE)) ? NULL : $this->input->post('tecnico_tel_2', TRUE),
                'tecnico_email_2' => empty($this->input->post('tecnico_email_2', TRUE)) ? NULL : $this->input->post('tecnico_email_2', TRUE),
                'flag_preposto' => empty($this->input->post('flag_preposto', TRUE)) ? NULL : $this->input->post('flag_preposto', TRUE),
                'lote_id' => empty($this->input->post('lote_id', TRUE)) ? NULL : $this->input->post('lote_id', TRUE),
            );

            $this->Entidade_tecnico_model->update($this->input->post('entidade_tecnico_id', TRUE), $data);


            #######################
            #ativa o usuario
            $data = array(
                'pessoa_st' => 1//inativo no gestor 
            );
            $this->Pessoa_model->update($this->input->post('pessoa_id', TRUE), $data);

            $data = array(
                'usuario_st' => 1//inativo no gestor 
            );

            ##############################################################################################################################################
            ##inserindo pessoa
            $data = array(
                'pessoa_nm' => $this->input->post('pessoa_nm', TRUE),
                'pessoa_tipo' => 'F',
                'pessoa_st' => '0',
                'pessoa_dt_criacao' => date('Y-m-d'),
                'pessoa_email' => $this->input->post('tecnico_email', TRUE),
            );
            $this->Pessoa_model->update($this->input->post('pessoa_id', TRUE), $data);



            ##inserindo usuario
            $data = array(
                'pessoa_id' => $this->input->post('pessoa_id', TRUE),
                'usuario_login' => $this->input->post('tecnico_cpf', TRUE),
                'usuario_st' => '0',
                'usuario_diaria' => '0',
                'validade' => $this->input->post('validade', TRUE)
            );
            $this->Usuario_model->update($this->input->post('pessoa_id', TRUE), $data);




            ######################
            #insere logo da criação do usuario
            unset($date);
            $data = array(
                'log_ds' => 'Atualização do Usuário',
                'pessoa_id' => $_SESSION['pessoa_id'],
                'entidade_tecnico_id' => $this->input->post('entidade_tecnico_id', TRUE),
            );
            $this->Tecnico_log_model->insert($data);






            ##############################################################################################################################################
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('entidade_tecnico'));
        }
    }

    public function delete($id) {

        $row = $this->Entidade_tecnico_model->get_by_id($id);

        if ($row) {


            if (@$this->Entidade_tecnico_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('entidade_tecnico'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('entidade_tecnico'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('entidade_tecnico'));
        }
    }

    public function inativa($id) {

        $flag_ativo = $this->input->get('flag_ativo', TRUE);

        $row = $this->Entidade_tecnico_model->get_by_id($id);

        //se tiver ativo, inativa
        if ($row->flag_ativo == 1) {
            $data = array(
                'flag_ativo' => 0, //inativo
            );
            $this->Entidade_tecnico_model->update($id, $data);

            $data = array(
                'pessoa_st' => 1//inativo no gestor 
            );
            $this->Pessoa_model->update($row->pessoa_id, $data);

            $data = array(
                'usuario_st' => 1//inativo no gestor 
            );
            $this->Usuario_model->update($row->pessoa_id, $data);
            $log_ds = 'Usuário Inativado';
        } else {//se tiver inativo, ativa
            $data = array(
                'flag_ativo' => 1, //ativo
            );
            $this->Entidade_tecnico_model->update($id, $data);

            $data = array(
                'pessoa_st' => 0//ativo no gestor 
            );
            $this->Pessoa_model->update($row->pessoa_id, $data);

            $data = array(
                'usuario_st' => 0//ativo no gestor 
            );
            $this->Usuario_model->update($row->pessoa_id, $data);
            $log_ds = 'Usuário Ativado';
        }




        ######################
        #insere logo da criação do usuario
        unset($date);
        $data = array(
            'log_ds' => $log_ds,
            'pessoa_id' => $_SESSION['pessoa_id'],
            'entidade_tecnico_id' => $id,
        );
        $this->Tecnico_log_model->insert($data);

        //echo 2; exit;
        $this->session->set_flashdata('message', 'Registro Inativado com Sucesso');
        redirect(site_url('entidade_tecnico'));
    }

    public function _rules() {

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function open_pdf() {

        $param = array(
            array('entidade_id', '=', $this->input->post('entidade_id', TRUE)),
            array('tecnico_cpf', '=', $this->input->post('tecnico_cpf', TRUE)),
            array('tecnico_email', '=', $this->input->post('tecnico_email', TRUE)),
            array('pessoa_id', '=', $this->input->post('pessoa_id', TRUE)),
            array('validade', '=', $this->input->post('validade', TRUE)),); //end array dos parametros

        $data = array(
            'entidade_tecnico_data' => $this->Entidade_tecnico_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html = $this->load->view('entidade_tecnico/Entidade_tecnico_pdf', $data, true);
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
            'action' => site_url('entidade_tecnico/open_pdf'),
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


        $this->load->view('entidade_tecnico/Entidade_tecnico_report', $data);
    }

}

/* End of file Entidade_tecnico.php */
/* Local: ./application/controllers/Entidade_tecnico.php */
/* Gerado por RGenerator - 2017-02-16 14:54:40 */