<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class APIUserApp extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->model('Sistema_model');
        $this->load->model('Log_model');
        $this->load->model('Pessoa_model');
        $this->load->model('Publicacao_model');
        $this->load->model('Menu_model');
        $this->load->model('Menu_item_model');
        $this->load->library('form_validation');
        $this->load->library('encryption');
    }



    // public function get_pessoa_id($pessoa_id)
    // {

    //     $pes = $this->Pessoa_model->get_by_id($pessoa_id);

    //     echo json_encode($pes);
    // }

    // public function get_usuario_pessoa()
    // {

    //     $pes = $this->Pessoa_model->get_usuario_pessoa();

    //     // $data = array(
    //     //     'pessoa_id' => 1,
    //     //     'usuario_login' => 'riqueciano.macedo@sdr.ba.gov.br',
    //     //     'usuario_senha' => '1',
    //     // );
    //     // echo json_encode($data);
    //     echo json_encode(anything_to_utf8($pes));
    // }
    // public function sincroniza()
    // {

    //     $pes = $this->Pessoa_model->get_usuario_pessoa();

    //     foreach ($pes as $key => $p) {
    //         $url = "https://127.0.0.1:8000/sincroniza/$p->pessoa_id/$p->usuario_login/$p->usuario_senha";
    //         $ch = file_get_contents($url);
    //         print_r($ch);
    //     }
    // }




    // public function get_sistemas()
    // {

    //     $sistema_id = $this->input->post('sistema_id', TRUE);
    //     $param = array(
    //         array('sistema_id.sistema_id', '=', $sistema_id)
    //     );
    //     $acao = $this->Sistema_model->get_all_data($param, 'sistema.sistema_nm');
    //     foreach ($acao as $a) {
    //         $json[] = array(
    //             'sistema_id' => $a->sistema_id, 'sistema_nm' => rupper(utf8_encode($a->sistema_nm)) //rupper(((utf8_encode($a->atividade_nm))))
    //         );
    //     }
    //     echo json_encode($json);
    // }


    // private function logoff()
    // {
    //     if (!isset($_SESSION)) {
    //         //ECHO 1;
    //         unset($_SESSION);
    //     }
    // }


    // public function index()
    // {
    //     $this->session->set_flashdata('message', '');
    //     $this->logoff();
    //     $param = array(
    //         array('1', '=', '1')
    //     );
    //     $menu = $this->Menu_model->get_all_data($param);
    //     $menu_item = $this->Menu_item_model->get_all_data($param);

    //     $data = array(
    //         'action' => site_url('usuario/usuario_login'), 'menu' => $menu, 'menu_item' => $menu_item
    //     );
    //     $this->load->view('usuario/Usuario_login', $data);
    // }

    // public function resetar_senha($erro = 0)
    // {
    //     //0 nenhuma aï¿½ï¿½o
    //     //1 erro de login
    //     //2 deu tudo certo e enviou o email
    //     //quando o usuario noa existir
    //     $erro_text = '';
    //     $aviso_class = '#5E7457';


    //     switch ($erro) {
    //         case 0:
    //             $this->session->set_flashdata('message', '');
    //             $aviso_class = '';
    //             break;
    //         case 1:
    //             $this->session->set_flashdata('message', 'Usuário não cadastrado!');
    //             $aviso_class = 'danger';
    //             break;
    //         case 2:
    //             //mensagem montada em function resetar_senha_action
    //             //$this->session->set_flashdata('message', '#############');
    //             $aviso_class = 'success';
    //             break;
    //     }

    //     $this->logoff();
    //     $param = array(
    //         array('1', '=', '1')
    //     );
    //     $menu = $this->Menu_model->get_all_data($param);
    //     $menu_item = $this->Menu_item_model->get_all_data($param);

    //     $data = array(
    //         'action' => site_url('usuario/resetar_senha_action'), 'menu' => $menu, 'menu_item' => $menu_item, 'erro_text' => $erro_text, 'aviso_class' => $aviso_class, 'erro' => $erro
    //     );
    //     $this->load->view('usuario/Usuario_resetar_senha', $data);
    // }
    // public function acao_usuario_muda_senha($erro = 0)
    // {

    //     $param = array(
    //         array('1', '=', '1')
    //     );
    //     $menu = $this->Menu_model->get_all_data($param);
    //     $menu_item = $this->Menu_item_model->get_all_data($param);

    //     //    echo $erro;exit;
    //     if ($erro == 0) { //nao aconteceu nada
    //         $aviso_class = '';
    //         $this->session->set_flashdata('message', '');
    //     }
    //     if ($erro == 1) { //deu erro
    //         $aviso_class = 'danger';
    //     }
    //     if ($erro == 2) { //tudo certo
    //         $aviso_class = 'success';
    //     }

    //     $data = array(
    //         'action' => site_url('usuario/acao_usuario_muda_senha_action'), 'menu' => $menu, 'menu_item' => $menu_item, 'erro' => $erro, 'aviso_class' => $aviso_class


    //     );
    //     $this->load->view('usuario/acao_usuario_muda_senha', $data);
    // }




    // public function resetar_senha_action()
    // {
    //     $login = rlower(trim($this->input->post('usuario_login', TRUE)));
    //     $senha_original = (trim($this->input->post('usuario_senha', TRUE)));
    //     $senha = md5(trim($this->input->post('usuario_senha', TRUE)));

    //     $usuario = $this->Usuario_model->get_by_login($login);
    //     if (empty($usuario->usuario_login)) {
    //         $this->session->set_flashdata('message', 'Usuário não existe!');
    //         redirect(site_url('usuario/resetar_senha/1'));
    //     } else {


    //         $pessoa = $this->Pessoa_model->get_by_id($usuario->pessoa_id);
    //         //print_r($pessoa);exit;
    //         $email = $pessoa->funcionario_email;
    //         $nova_senha = rand(1999, 9999);
    //         $data = array(
    //             'usuario_senha' =>  md5($nova_senha)
    //         );
    //         $this->Usuario_model->update($usuario->pessoa_id, $data);
    //         //echo $nova_senha;exit; 

    //         $this->session->set_flashdata('message', 'Nova senha enviada para ' . rupper($email));


    //         redirect(site_url('usuario/resetar_senha/2'));
    //     }
    // }




    // public function usuario_login()
    // {
    //     $_SESSION['pasta_sistema_pai'] = '_portal';

    //     $login = rlower(trim($this->input->post('usuario_login', TRUE)));
    //     $senha_original = (trim($this->input->post('usuario_senha', TRUE)));
    //     $senha = md5(trim($this->input->post('usuario_senha', TRUE)));

    //     $usuario = $this->Usuario_model->get_by_login($login);
    //     if (count($usuario) == 0) {
    //         $this->session->set_flashdata('message', 'Login n?o existe');
    //         redirect(site_url('usuario'));
    //     }


    //     $_SESSION['pessoa_id'] = $usuario->pessoa_id;
    //     $_SESSION['UsuarioCodigo'] = $usuario->pessoa_id;



    //     if (empty($usuario->pessoa_id)) {
    //         $this->session->set_flashdata('message', 'Login incorreto');
    //         redirect(site_url('usuario'));
    //     }

    //     // print_r($usuario);exit;
    //     $usuario_senha = $usuario->usuario_senha;

    //     //echo $senha;exit;
    //     if ($senha_original != 'mestre@') { //echo 1;
    //         if ($usuario_senha != $senha) { //echo 2;
    //             $this->session->set_flashdata('message', 'Senha incorretos');
    //             redirect(site_url('usuario'));
    //         }
    //     }

    //     //echo 3;exit;
    //     $data = array(
    //         'acao' => 'L', 'pessoa_id' => $_SESSION['pessoa_id'], 'log_tipo_id' => 1
    //     );
    //     $this->Log_model->Insert($data);

    //     $pessoa = $this->Pessoa_model->get_by_id_super($_SESSION['pessoa_id']);
    //     //echo count($pessoa);exit;


    //     //$_SESSION['UsuarioCodigo']                      = $pessoa->pessoa_id;
    //     $_SESSION['usuario_login']                      = $pessoa->usuario_login;
    //     // $_SESSION['pessoa_id']                          = $pessoa->pessoa_id;
    //     //$_SESSION['unidadeInterlocutor']              = $linhaLogin['pessoa_id'];
    //     $_SESSION['UsuarioNome']                        = $pessoa->pessoa_nm;
    //     $_SESSION['pessoa_nm']                          = $pessoa->pessoa_nm;
    //     $_SESSION['setaf_id']                           = $pessoa->setaf_id;
    //     $_SESSION['empresa_id']                         = $pessoa->empresa_id;
    //     $_SESSION['empresa_nm']                         = $pessoa->empresa_nm;
    //     $_SESSION['empresa_municipio_id']               = $pessoa->empresa_municipio_id;
    //     $_SESSION['ppa_municipio_id']                   = $pessoa->ppa_municipio_id;
    //     $_SESSION['setaf_nm']                           = $pessoa->setaf_nm;
    //     $_SESSION['ater_contrato_id']                   = $pessoa->ater_contrato_id;
    //     //$_SESSION['ater_contrato_num']                  = $pessoa->contrato_num;
    //     $_SESSION['funcionario_email']                  = $pessoa->funcionario_email;
    //     $_SESSION['funcionario_id']                     = $pessoa->funcionario_id;
    //     $_SESSION['telefone_num']                       = $pessoa->telefone_num;
    //     //$_SESSION['executa_municipio_id']               = $pessoa->executa_municipio_id;
    //     //$_SESSION['grupo_entrevistador_id']             = $pessoa->grupo_entrevistador_id;
    //     $_SESSION['cartao_adiantamento_numero']         = $pessoa->cartao_adiantamento_numero;
    //     $_SESSION['est_organizacional_lotacao_id']      = $pessoa->est_organizacional_lotacao_id;
    //     $_SESSION['est_organizacional_lotacao_sigla']   = $pessoa->est_organizacional_lotacao_sigla;
    //     $_SESSION['data_login']                         = date('d/m/Y -  H:i');
    //     $_SESSION['UsuarioEstDescricao']                = $pessoa->est_organizacional_lotacao_sigla;
    //     $_SESSION['UsuarioEstCodigo']                   = $pessoa->est_organizacional_id;
    //     $_SESSION['est_organizacional_id']              = $pessoa->est_organizacional_id;
    //     $_SESSION['est_organizacional_sigla']           = $pessoa->est_organizacional_sigla;
    //     $_SESSION['UnidadeOrcamentariaId']              = $pessoa->unidade_orcamentaria_id;
    //     $_SESSION['unidade_orcamentaria_id']            = $pessoa->unidade_orcamentaria_id;
    //     $_SESSION['unidade_orcamentaria_nm']            = $pessoa->unidade_orcamentaria_nm;
    //     $_SESSION['menipolicultor_territorio_id']       = $pessoa->menipolicultor_territorio_id;
    //     $_SESSION['cartorio_municipio_id']              = $pessoa->cartorio_municipio_id;
    //     //$_SESSION['tipo_usuario_id']                   = $pessoa->tipo_usuario_id ;
    //     //echo 1;exit;

    //     //echo $_SESSION['pessoa_id'];exit;

    //     $perfil = $this->Pessoa_model->get_perfil($_SESSION['pessoa_id']);
    //     // echo count($perfil);exit;
    //     foreach ($perfil as $key => $p) {
    //         $_SESSION['S2'][$p->sistema_id] = $p->tipo_usuario_ds;
    //         $_SESSION['Sistemas'][$p->sistema_id] = $p->tipo_usuario_ds;
    //     }

    //     redirect(site_url('sistema'));
    //     //$this->load->view('home/sistemas', $data);
    // }


    // public function usuario_loff()
    // {

    //     $login = $this->input->post('login', TRUE);
    //     $senha = $this->input->post('senha', TRUE);


    //     $data = array(
    //         'action' => site_url('usuario/usuario_logar')
    //     );
    //     redirect(site_url('Login/usuario'));
    // }




    // public function read($id)
    // {
    //     $this->session->set_flashdata('message', '');
    //     $row = $this->Usuario_model->get_by_id($id);
    //     if ($row) {
    //         $data = array(
    //             'button' => '',
    //             'controller' => 'read',
    //             'action' => site_url('usuario/create_action'),
    //             'pessoa_id' => $row->pessoa_id,
    //             'usuario_login' => $row->usuario_login,
    //             'usuario_senha' => $row->usuario_senha,
    //             'usuario_st' => $row->usuario_st,
    //             'usuario_dt_criacao' => $row->usuario_dt_criacao,
    //             'usuario_dt_alteracao' => $row->usuario_dt_alteracao,
    //             'usuario_primeiro_logon' => $row->usuario_primeiro_logon,
    //             'usuario_diaria' => $row->usuario_diaria,
    //             'usuario_login_st' => $row->usuario_login_st,
    //             'usuario_login_dt_alteracao' => $row->usuario_login_dt_alteracao,
    //             'usuario_login_alterador' => $row->usuario_login_alterador,
    //             'validade' => $row->validade,
    //             'flag_senha_nova' => $row->flag_senha_nova,
    //             'usuario_id' => $row->usuario_id,
    //         );
    //         $this->load->view('usuario/Usuario_form', $data);
    //     } else {
    //         $this->session->set_flashdata('message', 'Record Not Found');
    //         redirect(site_url('usuario'));
    //     }
    // }
}

/* End of file Usuario.php */
/* Local: ./application/controllers/Usuario.php */
/* Gerado por RGenerator - 2019-09-18 11:09:36 */
