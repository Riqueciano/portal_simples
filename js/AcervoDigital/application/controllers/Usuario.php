<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Vi_login_model');
        $this->load->model('Pessoa_model');
        $this->load->model('Usuario_model');
        $this->load->model('Usuario_tipo_usuario_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $param = array(
            array('tipo_usuario.sistema_id', '=', 29), //acervo     
            array('tipo_usuario.tipo_usuario_id', '=', 117), //usuario     
        );
        $vi_login = $this->Usuario_tipo_usuario_model->get_all_data($param);


        $data = array(
            'controller' => 'index',
            'vi_login' => $vi_login,
        );
        $this->load->view('usuario/Usuario_list', $data);
    }

    public function read($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Usuario_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('usuario/create_action'),
                'pessoa_id' => $row->pessoa_id,
                'usuario_login' => $row->usuario_login,
                'usuario_senha' => $row->usuario_senha,
                'usuario_st' => $row->usuario_st,
                'usuario_dt_criacao' => $row->usuario_dt_criacao,
                'usuario_dt_alteracao' => $row->usuario_dt_alteracao,
                'usuario_primeiro_logon' => $row->usuario_primeiro_logon,
                'usuario_diaria' => $row->usuario_diaria,
                'usuario_login_st' => $row->usuario_login_st,
                'usuario_login_dt_alteracao' => $row->usuario_login_dt_alteracao,
                'usuario_login_alterador' => $row->usuario_login_alterador,
                'validade' => $row->validade,
                'flag_senha_nova' => $row->flag_senha_nova,
            );
            $this->load->view('usuario/Usuario_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('usuario'));
        }
    }

    public function create() { //echo 1;exit;
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('usuario/create_action'),
            'pessoa_nm' => '',
            'instituicao_id' => null,
            'usuario_login' => '',
            'instituicao_nm' => '',
            'pessoa_email' => '',
            'cpf' => '',
        );
        $this->load->view('usuario/Usuario_form', $data);
    }
    
    
    

    public function create_action() {

        $this->db->trans_start();

        ##inserindo pessoa
        $data = array(
            'pessoa_nm' => $this->input->post('pessoa_nm', TRUE),
            'pessoa_tipo' => 'F',
            'pessoa_st' => '0',
            'pessoa_usuario_criador' => (int) $_SESSION['pessoa_id'],
            'pessoa_dt_criacao' => date('Y-m-d'),
            'pessoa_email' => $this->input->post('pessoa_email', TRUE),
            'flag_usuario_acervo_digital' => 1,
        );
        $this->Pessoa_model->insert($data);
        $pessoa_id = $this->db->insert_id();

        $pessoa = $this->Pessoa_model->get_by_id($pessoa_id);

        $senha = rand(1000, 9999);

        ##inserindo usuario
        $data = array(
            'pessoa_id' => $pessoa_id,
            'usuario_login' => rlower(trim($this->input->post('pessoa_email', TRUE))),
            'usuario_senha' => md5($senha),
            'usuario_st' => '0',
            'usuario_dt_criacao' => date('Y-m-d'),
            'usuario_primeiro_logon' => '0',
            'usuario_diaria' => '0',
        );
        $this->Usuario_model->insert($data);
        #insere o perfil do usuario
        $data = array(
            'pessoa_id' => $pessoa_id,
            'tipo_usuario_id' => 117/* usuario de acervo digital */,
        );
        $this->Usuario_tipo_usuario_model->insert($data);

        $this->mandar_email($pessoa, $senha);

        $this->db->trans_complete();
        $this->session->set_flashdata('message', 'Cadastrado com Sucesso, e-mail enviado para ' . $this->input->post('pessoa_email', TRUE));
        redirect(site_url('usuario/create'));
    }

    public function ajax_create_action() {

        $this->db->trans_start();

        $email = trim($this->input->post('email', TRUE));
        $pessoa_nm = trim($this->input->post('pessoa_nm', TRUE));
        //antes de inserir, verifica se ja existe
        $param = array(
            array('usuario_login', '=', $email),
        );
        $usuario = $this->Usuario_model->get_all_data($param);
        if (count($usuario) > 0) {
            echo 'ja_cadastrado';
            exit;
        }

        ##inserindo pessoa
        $data = array(
            'pessoa_nm' =>  rupper($pessoa_nm),
            'pessoa_tipo' => 'F',
            'pessoa_st' => '0',
            'pessoa_usuario_criador' => (int) $_SESSION['pessoa_id'],
            'pessoa_dt_criacao' => date('Y-m-d'),
            'pessoa_email' => $this->input->post('email', TRUE),
            'flag_usuario_acervo_digital' => 1,
        );
        $this->Pessoa_model->insert($data);
        $pessoa_id = $this->db->insert_id();

        $pessoa = $this->Pessoa_model->get_by_id($pessoa_id);

        $senha = rand(1000, 9999);

        ##inserindo usuario
        $data = array(
            'pessoa_id' => $pessoa_id,
            'usuario_login' => rlower(trim($this->input->post('email', TRUE))),
            'usuario_senha' => md5($senha),
            'usuario_st' => '0',
            'usuario_dt_criacao' => date('Y-m-d'),
            'usuario_primeiro_logon' => '0',
            'usuario_diaria' => '0',
        );
        $this->Usuario_model->insert($data);
        #insere o perfil do usuario
        $data = array(
            'pessoa_id' => $pessoa_id,
            'tipo_usuario_id' => 117/* usuario de acervo digital */,
        );
        $this->Usuario_tipo_usuario_model->insert($data);

        $this->mandar_email($pessoa, $senha, 2);//fluxo 2, onde o cepx cadastra o usuario

        $param = array(
            array('flag_usuario_acervo_digital', '=', '1'),
        );
        $usuario = $this->Usuario_model->get_all_data($param);

        foreach ($usuario as $a) {
            $json[] = array(
                'pessoa_id' => $a->pessoa_id
                , 'pessoa_nm' => rupper(utf8_encode($a->pessoa_nm))
            );
        }
        echo json_encode($json);

        $this->db->trans_complete();
    }

    private function mandar_email($pessoa, $senha, $num_mensagem = 0) {

        
       
        $config['smtp_host'] = 'envio.ba.gov.br';
        $config['smtp_port'] = 25;
        $config['protocol'] = 'smtp';
        $config['validate'] = TRUE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";

        $this->load->library('email');
        $this->load->email->initialize($config);

        $this->email->from("sistemas@sema.ba.gov.br", utf8_encode('Secretaria de Desenvolvimento Rural'));
        $this->email->subject(utf8_encode("Acervo Digital Secretaria de Desenvolvimento Rural"));
        //$this->email->reply_to("email_de_resposta@dominio.com");
        //$this->email->to(utf8_encode(trim(rlower($preponente->preponente_email))));
        //$this->email->to('riqueciano.macedo@sdr.ba.gov.br');
        //echo $comprador->comprador_email;exit;
        $this->email->to(trim(rlower(utf8_encode($pessoa->pessoa_email))));
        //$this->email->cc('riqueciano.macedo@sdr.ba.gov.br');
        //$this->email->bcc('email_copia_oculta@dominio.com');


        if ($num_mensagem == 0) {
            $msg = " 
                            <style>
                                    table {
                                        border-collapse: collapse;
                                    } 
                            </style>

                           <table style='width:100%'>
                               <tr><td align='' ><h4>Acervo Digital Secretaria de Desenvolvimento Rural" . '' . " </h4></td></tr>
                           </table> 
                           <table class='table' border='0'>
                                <tr>
                                   <td align='left' style='width:10%'><b>Login:</b></td>
                                   <td align='left' >" . $pessoa->pessoa_email . "</td>
                                </tr>        
                                <tr>        
                                   <td align='left'><b>Senha:</b></td>
                                   <td align='left'>" . $senha . "</td>
                                </tr>
                            </table>
                            <br>
                            


                           <table class='table' border='1'>
                                
                                <tr>
                                    <td><b>Nome:</b></td> <td>" . $pessoa->pessoa_nm . "</td>
                                </tr> 
                                <tr>
                                    <td><b>E-mail</b></td> <td>" . $pessoa->pessoa_email . "</td>
                                </tr>  
                            </table>   
                               ";
        } else {
             ;
        
            $msg = " 
                            <style>
                                    table {
                                        border-collapse: collapse;
                                    } 
                            </style>

                           <table style='width:100%'>
                               <tr><td align='' ><h4>Acervo Digital Secretaria de Desenvolvimento Rural" . '' . " </h4></td></tr>
                           </table>
                           <br>
                           <p>Prezado(a) senhor(a),
                                    O acervo digital da agricultura familiar é uma ferramenta pública que visa aproximar as pesquisas na area de agricultura familiar 
                                        com os proprios Identificamos um trabalho de vossa altoria e realizamos um pre-cadastro. Para autorizar e complementar as informações o(a) senhor(a) precisa entrar no sistema, clicando no link abaixo e ingressando
                           </p>             
                           <table class='table' border='0'>
                                <tr>
                                   <td align='left' style='width:10%'><b>Acervo:</b></td>
                                   <td align='left' >" .' https://www.portalsema.ba.gov.br/_portal'. "</td>
                                </tr>        
                                <tr>
                                   <td align='left' style='width:10%'><b>Login:</b></td>
                                   <td align='left' >" . $pessoa->pessoa_email . "</td>
                                </tr>        
                                <tr>        
                                   <td align='left'><b>Senha:</b></td>
                                   <td align='left'>" . $senha . "</td>
                                </tr>
                            </table>
                              
                               ";
        }

        //echo_pre($msg);

        $this->email->message(utf8_encode($msg));

        $this->email->send();
    }

    private function remove_pontos($cpf) {
        $cpf = str_replace(' ', '', $cpf);
        $cpf = str_replace('-', '', $cpf);
        $cpf = str_replace('.', '', $cpf);

        return $cpf;
    }

    public function update($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Usuario_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('usuario/update_action'),
                'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
                'usuario_login' => set_value('usuario_login', $row->usuario_login),
                'usuario_senha' => set_value('usuario_senha', $row->usuario_senha),
                'usuario_st' => set_value('usuario_st', $row->usuario_st),
                'usuario_dt_criacao' => set_value('usuario_dt_criacao', $row->usuario_dt_criacao),
                'usuario_dt_alteracao' => set_value('usuario_dt_alteracao', $row->usuario_dt_alteracao),
                'usuario_primeiro_logon' => set_value('usuario_primeiro_logon', $row->usuario_primeiro_logon),
                'usuario_diaria' => set_value('usuario_diaria', $row->usuario_diaria),
                'usuario_login_st' => set_value('usuario_login_st', $row->usuario_login_st),
                'usuario_login_dt_alteracao' => set_value('usuario_login_dt_alteracao', $row->usuario_login_dt_alteracao),
                'usuario_login_alterador' => set_value('usuario_login_alterador', $row->usuario_login_alterador),
                'validade' => set_value('validade', $row->validade),
                'flag_senha_nova' => set_value('flag_senha_nova', $row->flag_senha_nova),
            );
            $this->load->view('usuario/Usuario_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('usuario'));
        }
    }
    
    
   
        
    public function update_complemento($id){
        $this->session->set_flashdata('message', '');
        //$row = $this->Usuario_model->get_by_id($id);
        $pessoa = $this->Pessoa_model->get_by_id($id);
        //print_r($pessoa);   
        //echo 1;exit;
        if ($pessoa) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('usuario/update_action_complemento'),
                'pessoa_id' => set_value('pessoa_id', $pessoa->pessoa_id),
                'button' => 'Gravar',
                'pessoa_nm' => $pessoa->pessoa_nm,
                'instituicao_id' => null,
                'instituicao_nm' => '',
                'pessoa_email' => $pessoa->pessoa_email,
                'cpf' => '',
            );
            $this->load->view('usuario/Usuario_form_complemento', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('usuario'));
        }
    }

    public function update_action() {
        $this->_rules();
        $this->form_validation->set_rules('usuario_login', 'usuario_login', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('usuario_senha', 'usuario_senha', 'trim|required|max_length[9999]');
        $this->form_validation->set_rules('usuario_st', 'usuario_st', 'trim|numeric');
        $this->form_validation->set_rules('usuario_dt_criacao', 'usuario_dt_criacao', 'trim');
        $this->form_validation->set_rules('usuario_dt_alteracao', 'usuario_dt_alteracao', 'trim');
        $this->form_validation->set_rules('usuario_primeiro_logon', 'usuario_primeiro_logon', 'trim|numeric');
        $this->form_validation->set_rules('usuario_diaria', 'usuario_diaria', 'trim|integer');
        $this->form_validation->set_rules('usuario_login_st', 'usuario_login_st', 'trim|integer');
        $this->form_validation->set_rules('usuario_login_dt_alteracao', 'usuario_login_dt_alteracao', 'trim');
        $this->form_validation->set_rules('usuario_login_alterador', 'usuario_login_alterador', 'trim|integer');
        $this->form_validation->set_rules('validade', 'validade', 'trim');
        $this->form_validation->set_rules('flag_senha_nova', 'flag_senha_nova', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('pessoa_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
                'usuario_login' => empty($this->input->post('usuario_login', TRUE)) ? NULL : $this->input->post('usuario_login', TRUE),
                'usuario_senha' => empty($this->input->post('usuario_senha', TRUE)) ? NULL : $this->input->post('usuario_senha', TRUE),
                'usuario_st' => empty($this->input->post('usuario_st', TRUE)) ? NULL : $this->input->post('usuario_st', TRUE),
                'usuario_dt_criacao' => empty($this->input->post('usuario_dt_criacao', TRUE)) ? NULL : $this->input->post('usuario_dt_criacao', TRUE),
                'usuario_dt_alteracao' => empty($this->input->post('usuario_dt_alteracao', TRUE)) ? NULL : $this->input->post('usuario_dt_alteracao', TRUE),
                'usuario_primeiro_logon' => empty($this->input->post('usuario_primeiro_logon', TRUE)) ? NULL : $this->input->post('usuario_primeiro_logon', TRUE),
                'usuario_diaria' => empty($this->input->post('usuario_diaria', TRUE)) ? NULL : $this->input->post('usuario_diaria', TRUE),
                'usuario_login_st' => empty($this->input->post('usuario_login_st', TRUE)) ? NULL : $this->input->post('usuario_login_st', TRUE),
                'usuario_login_dt_alteracao' => empty($this->input->post('usuario_login_dt_alteracao', TRUE)) ? NULL : $this->input->post('usuario_login_dt_alteracao', TRUE),
                'usuario_login_alterador' => empty($this->input->post('usuario_login_alterador', TRUE)) ? NULL : $this->input->post('usuario_login_alterador', TRUE),
                'validade' => empty($this->input->post('validade', TRUE)) ? NULL : $this->input->post('validade', TRUE),
                'flag_senha_nova' => empty($this->input->post('flag_senha_nova', TRUE)) ? NULL : $this->input->post('flag_senha_nova', TRUE),
            );

            $this->Usuario_model->update($this->input->post('pessoa_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('usuario'));
        }
    }
    public function update_action_complemento() {
        
            $this->db->trans_start();
            $data = array(
                'pessoa_nm' => empty($this->input->post('pessoa_nm', TRUE)) ? NULL : $this->input->post('pessoa_nm', TRUE),
                'cpf_autor' => empty($this->input->post('cpf_autor', TRUE)) ? NULL : $this->input->post('cpf_autor', TRUE),
                'instituicao_autor' => empty($this->input->post('instituicao_nm', TRUE)) ? NULL : $this->input->post('instituicao_nm', TRUE), 
            );

            $_SESSION['pessoa_nm'] = $this->input->post('pessoa_nm', TRUE);
            $this->Pessoa_model->update($_SESSION['pessoa_id'], $data);
            $this->session->set_flashdata('message', 'Atualização realizada com Sucesso!');
            $this->db->trans_complete();
            redirect(site_url('obra'));
        }    

    public function delete($id) {
        $row = $this->Usuario_model->get_by_id($id);

        if ($row) {
            if (@$this->Usuario_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('usuario'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('usuario'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('usuario'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('usuario_login', 'usuario login', 'trim|required');
        $this->form_validation->set_rules('usuario_senha', 'usuario senha', 'trim|required');
        $this->form_validation->set_rules('usuario_st', 'usuario st', 'trim|required');
        $this->form_validation->set_rules('usuario_dt_criacao', 'usuario dt criacao', 'trim|required');
        $this->form_validation->set_rules('usuario_dt_alteracao', 'usuario dt alteracao', 'trim|required');
        $this->form_validation->set_rules('usuario_primeiro_logon', 'usuario primeiro logon', 'trim|required');
        $this->form_validation->set_rules('usuario_diaria', 'usuario diaria', 'trim|required');
        $this->form_validation->set_rules('usuario_login_st', 'usuario login st', 'trim|required');
        $this->form_validation->set_rules('usuario_login_dt_alteracao', 'usuario login dt alteracao', 'trim|required');
        $this->form_validation->set_rules('usuario_login_alterador', 'usuario login alterador', 'trim|required');
        $this->form_validation->set_rules('validade', 'validade', 'trim|required');
        $this->form_validation->set_rules('flag_senha_nova', 'flag senha nova', 'trim|required');

        $this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function open_pdf() {

        $param = array(
            array('usuario_login', '=', $this->input->post('usuario_login', TRUE)),
            array('usuario_senha', '=', $this->input->post('usuario_senha', TRUE)),
            array('usuario_st', '=', $this->input->post('usuario_st', TRUE)),
            array('usuario_dt_criacao', '=', $this->input->post('usuario_dt_criacao', TRUE)),
            array('usuario_dt_alteracao', '=', $this->input->post('usuario_dt_alteracao', TRUE)),
            array('usuario_primeiro_logon', '=', $this->input->post('usuario_primeiro_logon', TRUE)),
            array('usuario_diaria', '=', $this->input->post('usuario_diaria', TRUE)),
            array('usuario_login_st', '=', $this->input->post('usuario_login_st', TRUE)),
            array('usuario_login_dt_alteracao', '=', $this->input->post('usuario_login_dt_alteracao', TRUE)),
            array('usuario_login_alterador', '=', $this->input->post('usuario_login_alterador', TRUE)),
            array('validade', '=', $this->input->post('validade', TRUE)),
            array('flag_senha_nova', '=', $this->input->post('flag_senha_nova', TRUE)),); //end array dos parametros

        $data = array(
            'usuario_data' => $this->Usuario_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html = $this->load->view('usuario/Usuario_pdf', $data, true);
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
            'action' => site_url('usuario/open_pdf'),
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


        $this->load->view('usuario/Usuario_report', $data);
    }

}

/* End of file Usuario.php */
/* Local: ./application/controllers/Usuario.php */
/* Gerado por RGenerator - 2018-04-09 17:19:15 */