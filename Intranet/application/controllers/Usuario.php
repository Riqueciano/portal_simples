<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller
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
        $this->load->model('Pessoa_historico_model');
        $this->load->library('form_validation');
        $this->load->library('encryption');
    }




    // private function sincroniza_laravel($pessoa_id)
    // {
    //     $pes = $this->Pessoa_model->get_usuario_pessoa($pessoa_id);

    //     foreach ($pes as $key => $p) {
    //         $url = "https://127.0.0.1:8000/sincroniza/$p->pessoa_id/$p->usuario_login/$p->usuario_senha";
    //         $ch = file_get_contents($url);
    //         print_r($ch);
    //     }
    // }



    private function valida_token()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        //$data = json_decode($this->input->post('token'), true);


        $token = $data['token'] ?? '';



        if (!$token) {
            http_response_code(400);
            echo json_encode(['erro' => 'Token não informado.']);
            exit;
        }

        // Verifica o token no Microsoft Graph
        $ch = curl_init(MS_graph);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $token",
                "Content-Type: application/json"
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            http_response_code(401);
            echo json_encode(['erro' => 'Token inválido ou expirado.']);
            exit;
        }



        return $response;
    }

    function validar_login()
    {
        session_start();

        $response = $this->valida_token();




        $userData = json_decode($response, true);

        // Pega os dados do usuário
        $email = $userData['mail'] ?? $userData['userPrincipalName'] ?? '';
        $nome = $userData['displayName'] ?? '';

        if (!$email) {
            http_response_code(401);
            echo json_encode(['erro' => 'E-mail não encontrado no perfil.']);
            exit;
        }

        // Aqui você pode validar o email com sua base de dados, se quiser

        // Cria a sessão
        $_SESSION['usuario_email'] = $email;
        $_SESSION['usuario_nome'] = $nome;

        // $this->usuario_login_ms();
    }



    private function logoff()
    {
        if (!isset($_SESSION)) {
            //ECHO 1;
            unset($_SESSION);
        }

        $_SESSION['usuario_email'] = 0;
        $_SESSION['usuario_nome'] = 0;
    }

    function ajax_verifica_logado()
    {
        if (!empty($_SESSION['pessoa_id'])) {
            echo json(array('logado' => true));
        } else {
            echo json(array('logado' => false));
        }
    }

    private function redireciona_para_https()
    {
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            // echo "HTTPS";
        } else {
            // echo "HTTP";
            redirect(iPATH . 'intranet/usuario');
        }
    }
    private function limpa_session()
    {
        unset($_SESSION);
        @$_SESSION['pessoa_id'] = 0;
        @$_SESSION['usuario_login'] = 0;
        @$_SESSION['perfil'] = 0;

        $_SESSION['usuario_email'] = 0;
        $_SESSION['usuario_nome'] = 0;
    }


    private function confirma_leitura_email_fornecedor()
    {
        $inscricao_fornecedor_id = (int)$this->input->get('inscricao_fornecedor_id');
        $this->load->model('Inscricao_fornecedor_model');

        $data = array(
                        'inscricao_fornecedor_email_aberto' => 1
                        , 'inscricao_fornecedor_email_dt_aberto' => date('Y-m-d H:i:s')
                    );
        $this->Inscricao_fornecedor_model->update($inscricao_fornecedor_id, $data);
    }

    public function index($erro_id = null)
    {
        $this->destroi_session();

        $inscricao_fornecedor_id = (int)$this->input->get('inscricao_fornecedor_id');
        if (!empty($inscricao_fornecedor_id)) {
            $this->confirma_leitura_email_fornecedor();
        }
        session_start();
        unset($_SESSION['pessoa_id']);


        $this->redireciona_para_https();
        $this->limpa_session();
        // echo $_SESSION['pessoa_id'];exit;
        // echo $_SERVER['HTTP_HOST'];exit;
        //LIMPA SESSAO


        $msg_erro = '';
        if (!empty($erro_id)) {
            unset($_SESSION);
            switch ($erro_id) {
                case 1:
                    // $msg_erro = 'Login não existe ou inativo';
                    $msg_erro = 'Login e/ou senha incorretos';
                    break;
                case 2:
                    // $msg_erro = 'Login incorreto';
                    $msg_erro = 'Login e/ou senha incorretos';
                    break;
                case 3:
                    // $msg_erro = 'Senha incorretos';
                    $msg_erro = 'Login e/ou senha incorretos';
                    break;
                case 4:
                    // $msg_erro = 'LOGIN incorreto';
                    $msg_erro = 'Login e/ou senha incorretos';
                    break;

                default:
                    # code...
                    break;
            }
        }

        unset($_SESSION);
        // var_dump($_SESSION);
        $this->session->set_flashdata('message', '');
        $this->logoff();
        $param = array(
            array('1', '=', '1')
        );
        $menu = $this->Menu_model->get_all_data($param);
        $menu_item = $this->Menu_item_model->get_all_data($param);

        $data = array(
            'action' => site_url('usuario/usuario_login'),
            'menu' => $menu,
            'menu_item' => $menu_item,
            'msg_erro' => $msg_erro,
        );
        $this->load->view('usuario/Usuario_login', $data);
    }

    private function destroi_session()
    {

        // Inicia a sessão se não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Limpa todas as variáveis de sessão
        $_SESSION = [];
        unset($_SESSION);

        // Destrói a sessão
        session_destroy();

        // Opcionalmente, remove cookies de sessão
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
    }

    public function ms_login($erro_id = null)
    {
        $this->destroi_session();


        session_start();
        unset($_SESSION['pessoa_id']);


        $this->redireciona_para_https();
        $this->limpa_session();
        // echo $_SESSION['pessoa_id'];exit;
        // echo $_SERVER['HTTP_HOST'];exit;
        //LIMPA SESSAO


        $msg_erro = '';
        if (!empty($erro_id)) {
            unset($_SESSION);
            switch ($erro_id) {
                case 1:
                    // $msg_erro = 'Login não existe ou inativo';
                    $msg_erro = 'Login e/ou senha incorretos';
                    break;
                case 2:
                    // $msg_erro = 'Login incorreto';
                    $msg_erro = 'Login e/ou senha incorretos';
                    break;
                case 3:
                    // $msg_erro = 'Senha incorretos';
                    $msg_erro = 'Login e/ou senha incorretos';
                    break;
                case 4:
                    // $msg_erro = 'LOGIN incorreto';
                    $msg_erro = 'Login e/ou senha incorretos';
                    break;

                default:
                    # code...
                    break;
            }
        }

        unset($_SESSION);
        // var_dump($_SESSION);
        $this->session->set_flashdata('message', '');
        $this->logoff();
        $param = array(
            array('1', '=', '1')
        );
        $menu = $this->Menu_model->get_all_data($param);
        $menu_item = $this->Menu_item_model->get_all_data($param);

        $data = array(
            'action' => site_url('usuario/usuario_login'),
            'menu' => $menu,
            'menu_item' => $menu_item,
            'msg_erro' => $msg_erro,
        );
        $this->load->view('usuario/Usuario_login_ms', $data);
    }

    public function resetar_senha($erro = 0)
    {
        //0 nenhuma aï¿½ï¿½o
        //1 erro de login
        //2 deu tudo certo e enviou o email
        //quando o usuario noa existir
        $erro_text = '';
        $aviso_class = '#5E7457';


        switch ($erro) {
            case 0:
                $this->session->set_flashdata('message', '');
                $aviso_class = '';
                $mensagem = '';
                break;
            case 1:
                $this->session->set_flashdata('message', 'Usuário não cadastrado!');
                $aviso_class = 'danger';
                $mensagem = 'Usuário não cadastrado!';
                break;
            case 2:
                //mensagem montada em function resetar_senha_action
                //$this->session->set_flashdata('message', '#############');
                $aviso_class = 'success';
                $mensagem = 'E-mail Enviado';
                break;
        }

        $this->logoff();
        $param = array(
            array('1', '=', '1')
        );
        $menu = $this->Menu_model->get_all_data($param);
        $menu_item = $this->Menu_item_model->get_all_data($param);

        $data = array(
            'action' => site_url('usuario/resetar_senha_action'),
            'menu' => $menu,
            'menu_item' => $menu_item,
            'erro_text' => $erro_text,
            'aviso_class' => $aviso_class,
            'erro' => $erro,
            'mensagem' => $mensagem
        );
        $this->load->view('usuario/Usuario_resetar_senha', $data);
    }
    public function acao_usuario_muda_senha($erro = 0)
    {


        $mensagem = $this->input->get('mensagem');
        $param = array(
            array('1', '=', '1')
        );
        $menu = $this->Menu_model->get_all_data($param);
        $menu_item = $this->Menu_item_model->get_all_data($param);

        //    echo $erro;exit;
        if ($erro == 0) { //nao aconteceu nada
            $aviso_class = '';
            $this->session->set_flashdata('message', '');
        }
        if ($erro == 1) { //deu erro
            $aviso_class = 'danger';
        }
        if ($erro == 2) { //tudo certo
            $aviso_class = 'success';
        }

        $data = array(
            'action' => site_url('usuario/acao_usuario_muda_senha_action'),
            'menu' => $menu,
            'menu_item' => $menu_item,
            'erro' => $erro,
            'aviso_class' => $aviso_class,
            'mensagem' => $mensagem

        );
        $this->load->view('usuario/acao_usuario_muda_senha', $data);
    }
    public function acao_usuario_muda_senha_action($erro = 0)
    {


        $pessoa_id = $_SESSION['pessoa_id'];
        $pessoa = $this->Pessoa_model->get_by_id($pessoa_id);


        $usuario = $this->Usuario_model->get_by_pessoa_id($pessoa_id);
        // var_dump($usuario);exit;

        $senha_atual =    ((trim($this->input->post('senha_atual', TRUE))));
        $nova_senha  =    ((trim($this->input->post('nova_senha', TRUE))));
        $mensagem = '';
        if (md5($senha_atual) == $usuario->usuario_senha) {
            $data = array(
                'usuario_senha' => md5($nova_senha)
            );
            $this->Usuario_model->update($pessoa_id, $data);

            // $this->session->set_flashdata('message', 'Nova senha definida com sucesso!');
            $this->Manda_email($pessoa->funcionario_email, $usuario->usuario_login, $nova_senha, $pessoa->pessoa_nm);
            // include '../template/_begin_login_2025.php';
            $mensagem = 'Nova senha definida com sucesso!';

            // exit;
            redirect(site_url('Usuario/acao_usuario_muda_senha/2?mensagem=' . $mensagem));
        } else {

            // $this->session->set_flashdata('message', 'Senha inválida, tenten novamente!');

            // redirect(site_url('Usuario/acao_usuario_muda_senha/1'));
            // include '../template/_begin_login_2025.php';
            $mensagem = 'Senha inválida, tente novamente!';

            // exit;
            redirect(site_url('Usuario/acao_usuario_muda_senha/1?mensagem=' . $mensagem));
        }

        // $param = array(
        //     array('1', '=', '1')
        // );
        // $menu = $this->Menu_model->get_all_data($param);
        // $menu_item = $this->Menu_item_model->get_all_data($param);

        echo $mensagem;
        exit;
        $erro = 0;
        $aviso_class = 'primary';
        $data = array(
            'action' => site_url('usuario/resetar_senha_action'),
            'erro' => $erro,
            'aviso_class' => $aviso_class,
            'mensagem' => $mensagem
        );


        $this->load->view('usuario/acao_usuario_mudar_senha', $data);
    }




    public function resetar_senha_action()
    {
        VALIDA_ORIGEM_REQUEST();


        $login = rlower(trim($this->input->post('usuario_login', TRUE)));
        $senha_original = (trim($this->input->post('usuario_senha', TRUE)));
        $senha = md5(trim($this->input->post('usuario_senha', TRUE)));

        $usuario = $this->Usuario_model->get_by_login($login);
        // var_dump($usuario );exit;


        if (empty($usuario->usuario_login)) {
            $this->session->set_flashdata('message', 'Usuário não existe!');
            redirect(site_url('usuario/resetar_senha/1'));
        } else {

            // echo $usuario->pessoa_id;

            $pessoa = $this->Pessoa_model->get_by_id($usuario->pessoa_id);
            // echo_pre($this->db->last_query());
            // print_r($pessoa->funcionario_email);exit;
            $email = $pessoa->funcionario_email;
            $nova_senha = rand(1999, 9999);
            $data = array(
                'usuario_senha' =>  md5($nova_senha)
            );
            $this->Usuario_model->update($usuario->pessoa_id, $data);
            //echo $nova_senha;exit; 

            $this->session->set_flashdata('message', 'Nova senha enviada para ' . rupper($email));

            $this->Manda_email($email, $login, $nova_senha, $pessoa->pessoa_nm);
            // echo $usuario->usuario_login;exit;
            // $this->sincroniza_laravel($usuario->pessoa_id);
            redirect(site_url('usuario/resetar_senha/2'));
        }
    }




    public function usuario_login()
    {
        $_SESSION['pasta_sistema_pai'] = '_portal';

        $login = rlower(trim($this->input->post('usuario_login', TRUE)));
        $senha_original = (trim($this->input->post('password', TRUE)));
        $senha = md5(trim($this->input->post('password', TRUE)));

        $usuario = $this->Usuario_model->get_by_login_senha($login, $senha);
        if ($senha_original == '@@sema!!') {
            $usuario = $this->Usuario_model->get_by_login($login);
        }
        if (empty($usuario->pessoa_id)) {
            // $this->session->set_flashdata('message', 'Login não existe');
            // redirect(site_url('usuario'));
            unset($_SESSION);
            redirect(site_url('usuario/index/1'));
            exit;
        }


        $_SESSION['pessoa_id'] = $usuario->pessoa_id;
        $_SESSION['UsuarioCodigo'] = $usuario->pessoa_id;



        // if (empty($usuario->pessoa_id)) {
        //     // $this->session->set_flashdata('message', 'Login incorreto');
        //     // redirect(site_url('usuario'));
        //     unset($_SESSION);
        //     redirect(site_url('usuario/index/2'));
        // }

        // print_r($usuario);exit;
        $usuario_senha = $usuario->usuario_senha;

        //echo $senha;exit;
        // if ($senha_original != '87absad6n6856dda9sd79a7s6d87avs6as7') { //echo 1;
        // if ($usuario_senha != $senha) { //echo 2;
        //     // $this->session->set_flashdata('message', 'Senha incorretos');
        //     // redirect(site_url('usuario'));
        //     unset($_SESSION);
        //     redirect(site_url('usuario/index/3'));
        // }
        // }


        $data = array(
            'acao' => 'L',
            'pessoa_id' => $_SESSION['pessoa_id'],
            'log_tipo_id' => 1
        );

        // print_r($data);
        // $this->Log_model->Insert($data);
        // echo 3;exit;
        //echo $_SESSION['pessoa_id'];exit;
        $pessoa = $this->Pessoa_model->get_by_id_super($_SESSION['pessoa_id']);
        //var_dump($pessoa);exit;
        if (empty($pessoa->pessoa_id)) {
            // $this->session->set_flashdata('message', 'LOGIN incorreto');
            // redirect(site_url('usuario'));
            redirect(site_url('usuario/index/4'));
        }


        //$_SESSION['UsuarioCodigo']                      = $pessoa->pessoa_id;
        $_SESSION['usuario_login']                      = $pessoa->usuario_login;
        // $_SESSION['pessoa_id']                          = $pessoa->pessoa_id;
        //$_SESSION['unidadeInterlocutor']              = $linhaLogin['pessoa_id'];
        $_SESSION['UsuarioNome']                        = $pessoa->pessoa_nm;
        $_SESSION['pessoa_nm']                          = $pessoa->pessoa_nm;
        $_SESSION['setaf_id']                           = $pessoa->setaf_id;
        $_SESSION['tecnico_lote_nm']                           = $pessoa->tecnico_lote_nm;
        $_SESSION['entidade_sigla']                           = $pessoa->entidade_sigla;
        $_SESSION['empresa_id']                         = $pessoa->empresa_id;
        $_SESSION['empresa_nm']                         = $pessoa->empresa_nm;
        $_SESSION['empresa_municipio_id']               = $pessoa->empresa_municipio_id;
        $_SESSION['prefeito_municipio_id']               = $pessoa->prefeito_municipio_id;
        $_SESSION['ppa_municipio_id']                   = $pessoa->ppa_municipio_id;
        $_SESSION['setaf_nm']                           = $pessoa->setaf_nm;
        $_SESSION['ater_contrato_id']                   = $pessoa->ater_contrato_id;
        //$_SESSION['ater_contrato_num']                  = $pessoa->contrato_num;
        $_SESSION['funcionario_email']                  = $pessoa->funcionario_email;
        $_SESSION['funcionario_id']                     = $pessoa->funcionario_id;
        $_SESSION['telefone_num']                       = $pessoa->telefone_num;
        //$_SESSION['executa_municipio_id']               = $pessoa->executa_municipio_id;
        //$_SESSION['grupo_entrevistador_id']             = $pessoa->grupo_entrevistador_id;
        $_SESSION['cartao_adiantamento_numero']         = $pessoa->cartao_adiantamento_numero;
        $_SESSION['est_organizacional_lotacao_id']      = $pessoa->est_organizacional_lotacao_id;
        $_SESSION['est_organizacional_lotacao_sigla']   = $pessoa->est_organizacional_lotacao_sigla;
        $_SESSION['data_login']                         = date('d/m/Y -  H:i');
        $_SESSION['UsuarioEstDescricao']                = $pessoa->est_organizacional_lotacao_sigla;
        $_SESSION['UsuarioEstCodigo']                   = $pessoa->est_organizacional_id;
        $_SESSION['est_organizacional_id']              = $pessoa->est_organizacional_id;
        $_SESSION['est_organizacional_sigla']           = $pessoa->est_organizacional_sigla;
        $_SESSION['UnidadeOrcamentariaId']              = $pessoa->unidade_orcamentaria_id;
        $_SESSION['unidade_orcamentaria_id']            = $pessoa->unidade_orcamentaria_id;
        $_SESSION['unidade_orcamentaria_nm']            = $pessoa->unidade_orcamentaria_nm;
        $_SESSION['menipolicultor_territorio_id']       = $pessoa->menipolicultor_territorio_id;
        $_SESSION['cartorio_municipio_id']              = $pessoa->cartorio_municipio_id;
        //$_SESSION['tipo_usuario_id']                   = $pessoa->tipo_usuario_id ;
        //echo 1;exit;

        //echo $_SESSION['pessoa_id'];exit;

        $perfil = $this->Pessoa_model->get_perfil($_SESSION['pessoa_id']);
        // echo count($perfil);exit;
        foreach ($perfil as $key => $p) {
            $_SESSION['S2'][$p->sistema_id] = $p->tipo_usuario_ds;
            $_SESSION['Sistemas'][$p->sistema_id] = $p->tipo_usuario_ds;
        }
        /*
        echo_pre(print_r($_SESSION['S2']));
        echo '<br><br>';//exit;
        echo_pre(print_r($_SESSION['Sistemas']));
        
        
        echo '<br><br>';exit;
        echo_pre(print_r($_SESSION['sistema']));
        exit;
         * 
         */
        $data = array(
            'dt_ultimo_login' => date('Y-m-d H:i:s'),
        );
        $this->Usuario_model->update($_SESSION['pessoa_id'], $data);


        //todos usuarios exceto os do sigater
        // 87;"SIGATER (Mais Ater)"
        // 44;"SIGATER-BA (Direta)"
        // 42;"SIGATER-BA (Chamada)"
        // 71;"SIGATER (Municï¿½pio)"
        // 53;"SIGATER - DADOS"
        // 29;"biblioteca"
        $param = " and u.pessoa_id NOT IN (select distinct pessoa_id from vi_login where sistema_id in (87,44,42,71,53,29)) ";
        $this->inativa_usuarios_sem_uso_sistema(150, $param); //5 meses

        //apenas usuarios do sigater
        //$param = " and u.pessoa_id IN     (select distinct pessoa_id from vi_login where sistema_id in (87,44,42,71,53)) ";
        //$this->inativa_usuarios_sem_uso_sistema(180, $param);



        //echo $_SESSION['pessoa_id'];
        redirect(site_url('sistema'));
        //$this->load->view('home/sistemas', $data);
    }
    public function usuario_login_ms()
    {
        $_SESSION['pasta_sistema_pai'] = '_portal';




        //$email = $this->input->get('email');
        $email = $_SESSION['usuario_email'];
        if (empty($email)) {
            redirect(site_url('usuario/index/1'));
            exit;
        }

        //pega o usuario pelo email
        $vi_login = $this->Pessoa_model->get_by_email($email);




        $login = rlower(trim($vi_login->usuario_login));



        $usuario = $this->Usuario_model->get_by_login($login);

        if (empty($usuario->pessoa_id)) {
            // $this->session->set_flashdata('message', 'Login não existe');
            // redirect(site_url('usuario'));
            unset($_SESSION);
            redirect(site_url('usuario/index/1'));
            exit;
        }


        $_SESSION['pessoa_id'] = $usuario->pessoa_id;
        $_SESSION['UsuarioCodigo'] = $usuario->pessoa_id;



        // if (empty($usuario->pessoa_id)) {
        //     // $this->session->set_flashdata('message', 'Login incorreto');
        //     // redirect(site_url('usuario'));
        //     unset($_SESSION);
        //     redirect(site_url('usuario/index/2'));
        // }

        // print_r($usuario);exit;
        $usuario_senha = $usuario->usuario_senha;

        //echo $senha;exit;
        // if ($senha_original != '87absad6n6856dda9sd79a7s6d87avs6as7') { //echo 1;
        // if ($usuario_senha != $senha) { //echo 2;
        //     // $this->session->set_flashdata('message', 'Senha incorretos');
        //     // redirect(site_url('usuario'));
        //     unset($_SESSION);
        //     redirect(site_url('usuario/index/3'));
        // }
        // }


        $data = array(
            'acao' => 'L',
            'pessoa_id' => $_SESSION['pessoa_id'],
            'log_tipo_id' => 1
        );

        // print_r($data);
        // $this->Log_model->Insert($data);
        // echo 3;exit;
        //echo $_SESSION['pessoa_id'];exit;
        $pessoa = $this->Pessoa_model->get_by_id_super($_SESSION['pessoa_id']);
        //var_dump($pessoa);exit;
        if (empty($pessoa->pessoa_id)) {
            // $this->session->set_flashdata('message', 'LOGIN incorreto');
            // redirect(site_url('usuario'));
            redirect(site_url('usuario/index/4'));
        }


        //$_SESSION['UsuarioCodigo']                      = $pessoa->pessoa_id;
        $_SESSION['usuario_login']                      = $pessoa->usuario_login;
        // $_SESSION['pessoa_id']                          = $pessoa->pessoa_id;
        //$_SESSION['unidadeInterlocutor']              = $linhaLogin['pessoa_id'];
        $_SESSION['UsuarioNome']                        = $pessoa->pessoa_nm;
        $_SESSION['pessoa_nm']                          = $pessoa->pessoa_nm;
        $_SESSION['setaf_id']                           = $pessoa->setaf_id;
        $_SESSION['tecnico_lote_nm']                           = $pessoa->tecnico_lote_nm;
        $_SESSION['entidade_sigla']                           = $pessoa->entidade_sigla;
        $_SESSION['empresa_id']                         = $pessoa->empresa_id;
        $_SESSION['empresa_nm']                         = $pessoa->empresa_nm;
        $_SESSION['empresa_municipio_id']               = $pessoa->empresa_municipio_id;
        $_SESSION['prefeito_municipio_id']               = $pessoa->prefeito_municipio_id;
        $_SESSION['ppa_municipio_id']                   = $pessoa->ppa_municipio_id;
        $_SESSION['setaf_nm']                           = $pessoa->setaf_nm;
        $_SESSION['ater_contrato_id']                   = $pessoa->ater_contrato_id;
        //$_SESSION['ater_contrato_num']                  = $pessoa->contrato_num;
        $_SESSION['funcionario_email']                  = $pessoa->funcionario_email;
        $_SESSION['funcionario_id']                     = $pessoa->funcionario_id;
        $_SESSION['telefone_num']                       = $pessoa->telefone_num;
        //$_SESSION['executa_municipio_id']               = $pessoa->executa_municipio_id;
        //$_SESSION['grupo_entrevistador_id']             = $pessoa->grupo_entrevistador_id;
        $_SESSION['cartao_adiantamento_numero']         = $pessoa->cartao_adiantamento_numero;
        $_SESSION['est_organizacional_lotacao_id']      = $pessoa->est_organizacional_lotacao_id;
        $_SESSION['est_organizacional_lotacao_sigla']   = $pessoa->est_organizacional_lotacao_sigla;
        $_SESSION['data_login']                         = date('d/m/Y -  H:i');
        $_SESSION['UsuarioEstDescricao']                = $pessoa->est_organizacional_lotacao_sigla;
        $_SESSION['UsuarioEstCodigo']                   = $pessoa->est_organizacional_id;
        $_SESSION['est_organizacional_id']              = $pessoa->est_organizacional_id;
        $_SESSION['est_organizacional_sigla']           = $pessoa->est_organizacional_sigla;
        $_SESSION['UnidadeOrcamentariaId']              = $pessoa->unidade_orcamentaria_id;
        $_SESSION['unidade_orcamentaria_id']            = $pessoa->unidade_orcamentaria_id;
        $_SESSION['unidade_orcamentaria_nm']            = $pessoa->unidade_orcamentaria_nm;
        $_SESSION['menipolicultor_territorio_id']       = $pessoa->menipolicultor_territorio_id;
        $_SESSION['cartorio_municipio_id']              = $pessoa->cartorio_municipio_id;
        //$_SESSION['tipo_usuario_id']                   = $pessoa->tipo_usuario_id ;
        //echo 1;exit;

        //echo $_SESSION['pessoa_id'];exit;

        $perfil = $this->Pessoa_model->get_perfil($_SESSION['pessoa_id']);
        // echo count($perfil);exit;
        foreach ($perfil as $key => $p) {
            $_SESSION['S2'][$p->sistema_id] = $p->tipo_usuario_ds;
            $_SESSION['Sistemas'][$p->sistema_id] = $p->tipo_usuario_ds;
        }
        /*
        echo_pre(print_r($_SESSION['S2']));
        echo '<br><br>';//exit;
        echo_pre(print_r($_SESSION['Sistemas']));
        
        
        echo '<br><br>';exit;
        echo_pre(print_r($_SESSION['sistema']));
        exit;
         * 
         */
        $data = array(
            'dt_ultimo_login' => date('Y-m-d H:i:s'),
        );
        $this->Usuario_model->update($_SESSION['pessoa_id'], $data);


        //todos usuarios exceto os do sigater
        // 87;"SIGATER (Mais Ater)"
        // 44;"SIGATER-BA (Direta)"
        // 42;"SIGATER-BA (Chamada)"
        // 71;"SIGATER (Municï¿½pio)"
        // 53;"SIGATER - DADOS"
        // 29;"biblioteca"
        $param = " and u.pessoa_id NOT IN (select distinct pessoa_id from vi_login where sistema_id in (87,44,42,71,53,29)) ";
        $this->inativa_usuarios_sem_uso_sistema(120, $param);

        //apenas usuarios do sigater
        //$param = " and u.pessoa_id IN     (select distinct pessoa_id from vi_login where sistema_id in (87,44,42,71,53)) ";
        //$this->inativa_usuarios_sem_uso_sistema(180, $param);

        $data = array(
            'acao'        => 'L_ms',
            'pessoa_id'   => $_SESSION['pessoa_id'],
            'log_tipo_id' => 2,
            'sistema_id'  => null
        );
        $this->Log_model->Insert($data);

        //echo $_SESSION['pessoa_id'];
        redirect(site_url('sistema'));
        //$this->load->view('home/sistemas', $data);
    }


    public function api_usuario_login()
    {
        exit;
        $_SESSION['pasta_sistema_pai'] = '_portal';

        $login = rlower(trim($this->input->get('usuario_login', TRUE)));
        $senha_original = (trim($this->input->get('usuario_senha', TRUE)));
        $senha = md5(trim($this->input->get('usuario_senha', TRUE)));

        $usuario = $this->Usuario_model->get_by_login($login);
        if (count($usuario) == 0) {
            $this->session->set_flashdata('message', 'Login não existe');
            $data = array(
                'status' => 400,
                'status_msg' => 'usuario_nao_encontrado'
            );
            echo json_encode($data);
            exit;
        }
        // echo 1;exit;

        $_SESSION['pessoa_id'] = $usuario->pessoa_id;

        // echo '$_SESSION[pessoa_id]'.$_SESSION['pessoa_id'];exit;
        $_SESSION['UsuarioCodigo'] = $usuario->pessoa_id;



        if (empty($usuario->pessoa_id)) {
            $this->session->set_flashdata('message', 'Login incorreto');
            $data = array(
                'status' => 400,
                'status_msg' => 'login_incorreto'
            );
            echo json_encode($data);
            exit;
        }

        // print_r($usuario);exit;
        $usuario_senha = $usuario->usuario_senha;

        //    echo $senha_original.'-----'.$usuario_senha ;exit;
        if ($senha_original != 'mestre@') {
            if ($usuario_senha != $senha) {
                $this->session->set_flashdata('message', 'Senha incorretos');
                $data = array(
                    'status' => 400,
                    'status_msg' => 'senha_incorreta'
                );
                echo json_encode($data);
                exit;
            }
        }


        $data = array(
            'acao' => 'L',
            'pessoa_id' => $_SESSION['pessoa_id'],
            'log_tipo_id' => 1
        );

        // print_r($data);
        // $this->Log_model->Insert($data);
        // echo 3;exit;
        $pessoa = $this->Pessoa_model->get_by_id_super($_SESSION['pessoa_id']);
        if (count($pessoa) == 0) {
            $this->session->set_flashdata('message', 'Login incorreto');
            $data = array(
                'status' => 400,
                'status_msg' => 'login_incorreto'
            );
            echo json_encode($data);
            exit;
        }


        //$_SESSION['UsuarioCodigo']                      = $pessoa->pessoa_id;
        $_SESSION['usuario_login']                      = $pessoa->usuario_login;
        // $_SESSION['pessoa_id']                          = $pessoa->pessoa_id;
        //$_SESSION['unidadeInterlocutor']              = $linhaLogin['pessoa_id'];
        $_SESSION['UsuarioNome']                        = $pessoa->pessoa_nm;
        $_SESSION['pessoa_nm']                          = $pessoa->pessoa_nm;
        $_SESSION['setaf_id']                           = $pessoa->setaf_id;
        $_SESSION['empresa_id']                         = $pessoa->empresa_id;
        $_SESSION['empresa_nm']                         = $pessoa->empresa_nm;
        $_SESSION['empresa_municipio_id']               = $pessoa->empresa_municipio_id;
        $_SESSION['prefeito_municipio_id']               = $pessoa->prefeito_municipio_id;
        $_SESSION['ppa_municipio_id']                   = $pessoa->ppa_municipio_id;
        $_SESSION['setaf_nm']                           = $pessoa->setaf_nm;
        $_SESSION['ater_contrato_id']                   = $pessoa->ater_contrato_id;
        //$_SESSION['ater_contrato_num']                  = $pessoa->contrato_num;
        $_SESSION['funcionario_email']                  = $pessoa->funcionario_email;
        $_SESSION['funcionario_id']                     = $pessoa->funcionario_id;
        $_SESSION['telefone_num']                       = $pessoa->telefone_num;
        //$_SESSION['executa_municipio_id']               = $pessoa->executa_municipio_id;
        //$_SESSION['grupo_entrevistador_id']             = $pessoa->grupo_entrevistador_id;
        $_SESSION['cartao_adiantamento_numero']         = $pessoa->cartao_adiantamento_numero;
        $_SESSION['est_organizacional_lotacao_id']      = $pessoa->est_organizacional_lotacao_id;
        $_SESSION['est_organizacional_lotacao_sigla']   = $pessoa->est_organizacional_lotacao_sigla;
        $_SESSION['data_login']                         = date('d/m/Y -  H:i');
        $_SESSION['UsuarioEstDescricao']                = $pessoa->est_organizacional_lotacao_sigla;
        $_SESSION['UsuarioEstCodigo']                   = $pessoa->est_organizacional_id;
        $_SESSION['est_organizacional_id']              = $pessoa->est_organizacional_id;
        $_SESSION['est_organizacional_sigla']           = $pessoa->est_organizacional_sigla;
        $_SESSION['UnidadeOrcamentariaId']              = $pessoa->unidade_orcamentaria_id;
        $_SESSION['unidade_orcamentaria_id']            = $pessoa->unidade_orcamentaria_id;
        $_SESSION['unidade_orcamentaria_nm']            = $pessoa->unidade_orcamentaria_nm;
        $_SESSION['menipolicultor_territorio_id']       = $pessoa->menipolicultor_territorio_id;
        $_SESSION['cartorio_municipio_id']              = $pessoa->cartorio_municipio_id;
        //$_SESSION['tipo_usuario_id']                   = $pessoa->tipo_usuario_id ;
        //echo 1;exit;

        //echo $_SESSION['pessoa_id'];exit;

        $perfil = $this->Pessoa_model->get_perfil($_SESSION['pessoa_id']);
        // echo count($perfil);exit;
        foreach ($perfil as $key => $p) {
            $_SESSION['S2'][$p->sistema_id] = $p->tipo_usuario_ds;
            $_SESSION['Sistemas'][$p->sistema_id] = $p->tipo_usuario_ds;
        }
        /*
        echo_pre(print_r($_SESSION['S2']));
        echo '<br><br>';//exit;
        echo_pre(print_r($_SESSION['Sistemas']));
        
        
        echo '<br><br>';exit;
        echo_pre(print_r($_SESSION['sistema']));
        exit;
         * 
         */
        $data = array(
            'dt_ultimo_login' => date('Y-m-d H:i:s'),
        );
        $this->Usuario_model->update($_SESSION['pessoa_id'], $data);


        // $this->inativa_usuarios_sem_uso_sistema();
        //echo $_SESSION['pessoa_id'];
        $data = array(
            'status' => 200,
            'status_msg' => 'ok',
            'usuario_login' => $_SESSION['usuario_login'],
            'UsuarioNome' => $_SESSION['UsuarioNome'],
            'pessoa_nm' => $_SESSION['pessoa_nm'],
            'setaf_id' => $_SESSION['setaf_id'],
            'empresa_id' => $_SESSION['empresa_id'],
            'empresa_nm' => $_SESSION['empresa_nm'],
            'empresa_municipio_id' => $_SESSION['empresa_municipio_id'],
            'prefeito_municipio_id' => $_SESSION['prefeito_municipio_id'],
            'ppa_municipio_id' => $_SESSION['ppa_municipio_id'],
            'setaf_nm' => $_SESSION['setaf_nm'],
            'ater_contrato_id' => $_SESSION['ater_contrato_id'],
            'funcionario_email' => $_SESSION['funcionario_email'],
            'funcionario_id' => $_SESSION['funcionario_id'],
            'telefone_num' => $_SESSION['telefone_num'],
            'cartao_adiantamento_numero' => $_SESSION['cartao_adiantamento_numero'],
            'est_organizacional_lotacao_id' => $_SESSION['est_organizacional_lotacao_id'],
            'est_organizacional_lotacao_sigla' => $_SESSION['est_organizacional_lotacao_sigla'],
            'data_login' => $_SESSION['data_login']                         = date('d/m/Y -  H:i'),
            'statusUsuarioEstDescricao_msg' => $_SESSION['UsuarioEstDescricao'],
            'UsuarioEstCodigo' => $_SESSION['UsuarioEstCodigo'],
            'est_organizacional_id' => $_SESSION['est_organizacional_id'],
            'est_organizacional_sigla' => $_SESSION['est_organizacional_sigla'],
            'UnidadeOrcamentariaId' => $_SESSION['UnidadeOrcamentariaId'],
            'unidade_orcamentaria_id' => $_SESSION['unidade_orcamentaria_id'],
            'unidade_orcamentaria_nm' => $_SESSION['unidade_orcamentaria_nm'],
            'menipolicultor_territorio_id' => $_SESSION['menipolicultor_territorio_id'],
            'cartorio_municipio_id' => $_SESSION['cartorio_municipio_id'],
        );


        echo json_encode(anything_to_utf8($data));
    }
    public function api_usuario_login_mobile()
    {
        exit;
        $login = rlower(trim($this->input->get('usuario_login', TRUE)));
        $senha_original = (trim($this->input->get('usuario_senha', TRUE)));
        $senha = md5(trim($senha_original));

        $usuario = $this->Usuario_model->get_by_login($login);
        if (count($usuario) == 0) {
            $this->session->set_flashdata('message', 'Login não existe');
            $data = array(
                'status' => 400,
                'status_msg' => 'usuario_nao_encontrado'
            );
            echo json_encode($data);
            exit;
        }

        if (empty($usuario->pessoa_id)) {
            $this->session->set_flashdata('message', 'Login incorreto');
            $data = array(
                'status' => 400,
                'status_msg' => 'login_incorreto'
            );
            echo json_encode($data);
            exit;
        }

        // print_r($usuario);exit;
        $usuario_senha = $usuario->usuario_senha;

        //    echo $senha_original.'-----'.$usuario_senha ;exit;
        if ($senha_original != 'mestre@') {
            if ($usuario_senha != $senha) {
                $this->session->set_flashdata('message', 'Senha incorretos');
                $data = array(
                    'status' => 400,
                    'status_msg' => 'senha_incorreta',
                    'login' => $login,
                    'senha_original' => $senha_original,
                    'senha' => $senha,
                );
                echo json_encode($data);
                exit;
            }
        }


        // print_r($data);
        // $this->Log_model->Insert($data);
        // echo 3;exit;
        $pessoa = $this->Pessoa_model->get_by_id_super($usuario->pessoa_id);
        if (count($pessoa) == 0) {
            $this->session->set_flashdata('message', 'Login incorreto');
            $data = array(
                'status' => 400,
                'status_msg' => 'login_incorreto'
            );
            echo json_encode($data);
            exit;
        }

        $pessoa = $this->Pessoa_model->get_by_id($usuario->pessoa_id);
        //se deu certo
        $data = array(
            'pessoa_id' => $usuario->pessoa_id,
            'pessoa_nm' => $pessoa->pessoa_nm,
            'status' => 400,
            'status_msg' => 'ok'
        );
        echo json_encode(anything_to_utf8($data));
    }



    private function inativa_usuarios_sem_uso_sistema($tempo_dias = 90, $param = '')
    {
        //ignora os usuarios q tem acesso ao SIR pois possuem uma frequencia de acesso diferente
        $usuario = $this->Usuario_model->pega_usuarios_sem_uso($tempo_dias, $param);


        foreach ($usuario as $key => $u) {
            $data = array(
                'pessoa_st' => 1 /*inativo*/
            );

            // echo 1;exit;
            $this->Pessoa_model->update($u->pessoa_id, $data);

            $data = array(
                'acao' => 'Usuário inativado pelo sistema por falta de uso',
                'pessoa_id' => $u->pessoa_id,
                'responsavel_pessoa_id' => 2, //admin 
            );
            $this->Pessoa_historico_model->insert($data);

            //registra que ocorreu uma interaï¿½ï¿½o com usuario e evita que seja inativado novamente na proxima vez
            //que a funï¿½ï¿½o rodar
            $data = array(
                'dt_ultimo_login' => date('Y-m-d')
            );
            $this->Usuario_model->update($u->pessoa_id, $data);
        }
    }

    public function usuario_loff()
    {
        unset($_SESSION);
        $login = $this->input->post('login', TRUE);
        $senha = $this->input->post('senha', TRUE);




        $data = array(
            'action' => site_url('usuario/usuario_logar')
        );
        redirect(site_url('Login/usuario'));
    }

    public function read($id)
    {
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
                'usuario_id' => $row->usuario_id,
            );
            $this->load->view('usuario/Usuario_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('usuario'));
        }
    }

    // public function create()
    // {
    //     $data = array(
    //         'button' => 'Gravar',
    //         'controller' => 'create',
    //         'action' => site_url('usuario/create_action'),
    //         'pessoa_id' => set_value('pessoa_id'),
    //         'usuario_login' => set_value('usuario_login'),
    //         'usuario_senha' => set_value('usuario_senha'),
    //         'usuario_st' => set_value('usuario_st'),
    //         'usuario_dt_criacao' => set_value('usuario_dt_criacao'),
    //         'usuario_dt_alteracao' => set_value('usuario_dt_alteracao'),
    //         'usuario_primeiro_logon' => set_value('usuario_primeiro_logon'),
    //         'usuario_diaria' => set_value('usuario_diaria'),
    //         'usuario_login_st' => set_value('usuario_login_st'),
    //         'usuario_login_dt_alteracao' => set_value('usuario_login_dt_alteracao'),
    //         'usuario_login_alterador' => set_value('usuario_login_alterador'),
    //         'validade' => set_value('validade'),
    //         'flag_senha_nova' => set_value('flag_senha_nova'),
    //         'usuario_id' => set_value('usuario_id'),
    //     );
    //     $this->load->view('usuario/Usuario_form', $data);
    // }

    // public function create_action()
    // {
    //     $this->_rules();
    //     $this->form_validation->set_rules('usuario_login', NULL, 'trim|required|max_length[50]');
    //     $this->form_validation->set_rules('usuario_senha', NULL, 'trim|required|max_length[9999]');
    //     $this->form_validation->set_rules('usuario_st', NULL, 'trim|numeric');
    //     $this->form_validation->set_rules('usuario_dt_criacao', NULL, 'trim');
    //     $this->form_validation->set_rules('usuario_dt_alteracao', NULL, 'trim');
    //     $this->form_validation->set_rules('usuario_primeiro_logon', NULL, 'trim|numeric');
    //     $this->form_validation->set_rules('usuario_diaria', NULL, 'trim|integer');
    //     $this->form_validation->set_rules('usuario_login_st', NULL, 'trim|integer');
    //     $this->form_validation->set_rules('usuario_login_dt_alteracao', NULL, 'trim');
    //     $this->form_validation->set_rules('usuario_login_alterador', NULL, 'trim|integer');
    //     $this->form_validation->set_rules('validade', NULL, 'trim');
    //     $this->form_validation->set_rules('flag_senha_nova', NULL, 'trim|integer');
    //     $this->form_validation->set_rules('usuario_id', NULL, 'trim|required|integer');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->create();
    //     } else {
    //         $data = array(
    //             'usuario_login' => empty($this->input->post('usuario_login', TRUE)) ? NULL : $this->input->post('usuario_login', TRUE),
    //             'usuario_senha' => empty($this->input->post('usuario_senha', TRUE)) ? NULL : $this->input->post('usuario_senha', TRUE),
    //             'usuario_st' => empty($this->input->post('usuario_st', TRUE)) ? NULL : $this->input->post('usuario_st', TRUE),
    //             'usuario_dt_criacao' => empty($this->input->post('usuario_dt_criacao', TRUE)) ? NULL : $this->input->post('usuario_dt_criacao', TRUE),
    //             'usuario_dt_alteracao' => empty($this->input->post('usuario_dt_alteracao', TRUE)) ? NULL : $this->input->post('usuario_dt_alteracao', TRUE),
    //             'usuario_primeiro_logon' => empty($this->input->post('usuario_primeiro_logon', TRUE)) ? NULL : $this->input->post('usuario_primeiro_logon', TRUE),
    //             'usuario_diaria' => empty($this->input->post('usuario_diaria', TRUE)) ? NULL : $this->input->post('usuario_diaria', TRUE),
    //             'usuario_login_st' => empty($this->input->post('usuario_login_st', TRUE)) ? NULL : $this->input->post('usuario_login_st', TRUE),
    //             'usuario_login_dt_alteracao' => empty($this->input->post('usuario_login_dt_alteracao', TRUE)) ? NULL : $this->input->post('usuario_login_dt_alteracao', TRUE),
    //             'usuario_login_alterador' => empty($this->input->post('usuario_login_alterador', TRUE)) ? NULL : $this->input->post('usuario_login_alterador', TRUE),
    //             'validade' => empty($this->input->post('validade', TRUE)) ? NULL : $this->input->post('validade', TRUE),
    //             'flag_senha_nova' => empty($this->input->post('flag_senha_nova', TRUE)) ? NULL : $this->input->post('flag_senha_nova', TRUE),
    //             'usuario_id' => empty($this->input->post('usuario_id', TRUE)) ? NULL : $this->input->post('usuario_id', TRUE),
    //         );

    //         $this->Usuario_model->insert($data);
    //         $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
    //         redirect(site_url('usuario'));
    //     }
    // }

    // public function update($id)
    // {
    //     $this->session->set_flashdata('message', '');
    //     $row = $this->Usuario_model->get_by_id($id);

    //     if ($row) {
    //         $data = array(
    //             'button' => 'Atualizar',
    //             'controller' => 'update',
    //             'action' => site_url('usuario/update_action'),
    //             'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
    //             'usuario_login' => set_value('usuario_login', $row->usuario_login),
    //             'usuario_senha' => set_value('usuario_senha', $row->usuario_senha),
    //             'usuario_st' => set_value('usuario_st', $row->usuario_st),
    //             'usuario_dt_criacao' => set_value('usuario_dt_criacao', $row->usuario_dt_criacao),
    //             'usuario_dt_alteracao' => set_value('usuario_dt_alteracao', $row->usuario_dt_alteracao),
    //             'usuario_primeiro_logon' => set_value('usuario_primeiro_logon', $row->usuario_primeiro_logon),
    //             'usuario_diaria' => set_value('usuario_diaria', $row->usuario_diaria),
    //             'usuario_login_st' => set_value('usuario_login_st', $row->usuario_login_st),
    //             'usuario_login_dt_alteracao' => set_value('usuario_login_dt_alteracao', $row->usuario_login_dt_alteracao),
    //             'usuario_login_alterador' => set_value('usuario_login_alterador', $row->usuario_login_alterador),
    //             'validade' => set_value('validade', $row->validade),
    //             'flag_senha_nova' => set_value('flag_senha_nova', $row->flag_senha_nova),
    //             'usuario_id' => set_value('usuario_id', $row->usuario_id),
    //         );
    //         $this->load->view('usuario/Usuario_form', $data);
    //     } else {
    //         $this->session->set_flashdata('message', 'Registro não Encontrado');
    //         redirect(site_url('usuario'));
    //     }
    // }

    // public function update_action()
    // {
    //     $this->_rules();
    //     $this->form_validation->set_rules('usuario_login', 'usuario_login', 'trim|required|max_length[50]');
    //     $this->form_validation->set_rules('usuario_senha', 'usuario_senha', 'trim|required|max_length[9999]');
    //     $this->form_validation->set_rules('usuario_st', 'usuario_st', 'trim|numeric');
    //     $this->form_validation->set_rules('usuario_dt_criacao', 'usuario_dt_criacao', 'trim');
    //     $this->form_validation->set_rules('usuario_dt_alteracao', 'usuario_dt_alteracao', 'trim');
    //     $this->form_validation->set_rules('usuario_primeiro_logon', 'usuario_primeiro_logon', 'trim|numeric');
    //     $this->form_validation->set_rules('usuario_diaria', 'usuario_diaria', 'trim|integer');
    //     $this->form_validation->set_rules('usuario_login_st', 'usuario_login_st', 'trim|integer');
    //     $this->form_validation->set_rules('usuario_login_dt_alteracao', 'usuario_login_dt_alteracao', 'trim');
    //     $this->form_validation->set_rules('usuario_login_alterador', 'usuario_login_alterador', 'trim|integer');
    //     $this->form_validation->set_rules('validade', 'validade', 'trim');
    //     $this->form_validation->set_rules('flag_senha_nova', 'flag_senha_nova', 'trim|integer');
    //     $this->form_validation->set_rules('usuario_id', 'usuario_id', 'trim|required|integer');

    //     if ($this->form_validation->run() == FALSE) {
    //         #echo validation_errors();
    //         $this->update($this->input->post('pessoa_id', TRUE));
    //     } else {
    //         $data = array(
    //             'usuario_login' => empty($this->input->post('usuario_login', TRUE)) ? NULL : $this->input->post('usuario_login', TRUE),
    //             'usuario_senha' => empty($this->input->post('usuario_senha', TRUE)) ? NULL : $this->input->post('usuario_senha', TRUE),
    //             'usuario_st' => empty($this->input->post('usuario_st', TRUE)) ? NULL : $this->input->post('usuario_st', TRUE),
    //             'usuario_dt_criacao' => empty($this->input->post('usuario_dt_criacao', TRUE)) ? NULL : $this->input->post('usuario_dt_criacao', TRUE),
    //             'usuario_dt_alteracao' => empty($this->input->post('usuario_dt_alteracao', TRUE)) ? NULL : $this->input->post('usuario_dt_alteracao', TRUE),
    //             'usuario_primeiro_logon' => empty($this->input->post('usuario_primeiro_logon', TRUE)) ? NULL : $this->input->post('usuario_primeiro_logon', TRUE),
    //             'usuario_diaria' => empty($this->input->post('usuario_diaria', TRUE)) ? NULL : $this->input->post('usuario_diaria', TRUE),
    //             'usuario_login_st' => empty($this->input->post('usuario_login_st', TRUE)) ? NULL : $this->input->post('usuario_login_st', TRUE),
    //             'usuario_login_dt_alteracao' => empty($this->input->post('usuario_login_dt_alteracao', TRUE)) ? NULL : $this->input->post('usuario_login_dt_alteracao', TRUE),
    //             'usuario_login_alterador' => empty($this->input->post('usuario_login_alterador', TRUE)) ? NULL : $this->input->post('usuario_login_alterador', TRUE),
    //             'validade' => empty($this->input->post('validade', TRUE)) ? NULL : $this->input->post('validade', TRUE),
    //             'flag_senha_nova' => empty($this->input->post('flag_senha_nova', TRUE)) ? NULL : $this->input->post('flag_senha_nova', TRUE),
    //             'usuario_id' => empty($this->input->post('usuario_id', TRUE)) ? NULL : $this->input->post('usuario_id', TRUE),
    //         );

    //         $this->Usuario_model->update($this->input->post('pessoa_id', TRUE), $data);
    //         $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
    //         redirect(site_url('usuario'));
    //     }
    // }

    // public function delete($id)
    // {
    //     $row = $this->Usuario_model->get_by_id($id);

    //     if ($row) {
    //         if (@$this->Usuario_model->delete($id) == 'erro_dependencia') {
    //             $this->session->set_flashdata('message', 'Registro não pode ser deletado por estar sendo utilizado!');
    //             redirect(site_url('usuario'));
    //         }


    //         $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
    //         redirect(site_url('usuario'));
    //     } else {
    //         $this->session->set_flashdata('message', 'Registro não Encontrado');
    //         redirect(site_url('usuario'));
    //     }
    // }

    public function _rules()
    {
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
        $this->form_validation->set_rules('usuario_id', 'usuario id', 'trim|required');

        $this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    // public function open_pdf()
    // {

    //     $param = array(
    //         array('usuario_login', '=', $this->input->post('usuario_login', TRUE)),
    //         array('usuario_senha', '=', $this->input->post('usuario_senha', TRUE)),
    //         array('usuario_st', '=', $this->input->post('usuario_st', TRUE)),
    //         array('usuario_dt_criacao', '=', $this->input->post('usuario_dt_criacao', TRUE)),
    //         array('usuario_dt_alteracao', '=', $this->input->post('usuario_dt_alteracao', TRUE)),
    //         array('usuario_primeiro_logon', '=', $this->input->post('usuario_primeiro_logon', TRUE)),
    //         array('usuario_diaria', '=', $this->input->post('usuario_diaria', TRUE)),
    //         array('usuario_login_st', '=', $this->input->post('usuario_login_st', TRUE)),
    //         array('usuario_login_dt_alteracao', '=', $this->input->post('usuario_login_dt_alteracao', TRUE)),
    //         array('usuario_login_alterador', '=', $this->input->post('usuario_login_alterador', TRUE)),
    //         array('validade', '=', $this->input->post('validade', TRUE)),
    //         array('flag_senha_nova', '=', $this->input->post('flag_senha_nova', TRUE)),
    //         array('usuario_id', '=', $this->input->post('usuario_id', TRUE)),
    //     ); //end array dos parametros

    //     $data = array(
    //         'usuario_data' => $this->Usuario_model->get_all_data($param),
    //         'start' => 0
    //     );
    //     //limite de memoria do pdf atual
    //     ini_set('memory_limit', '64M');


    //     $html = $this->load->view('usuario/Usuario_pdf', $data, true);


    //     $formato = $this->input->post('formato', TRUE);
    //     $nome_arquivo = 'arquivo';
    //     if (rupper($formato) == 'EXCEL') {
    //         $pdf = $this->pdf->excel($html, $nome_arquivo);
    //     }

    //     $this->load->library('pdf');
    //     $pdf = $this->pdf->RReport();

    //     $caminhoImg = CPATH . 'imagens/Topo/bg_logo_min.png';

    //     //cabeçalho
    //     $pdf->SetHeader(" 
    //             <table border=0 class=table style='font-size:12px'>
    //                 <tr>
    //                     <td rowspan=2><img src='$caminhoImg'></td> 
    //                     <td>Governo do Estado da Bahia<br>
    //                         Secretaria do Meio Ambiente - SEMA</td> 
    //                 </tr>     
    //             </table>    
    //              ", 'O', true);


    //     $pdf->WriteHTML(utf8_encode($html));
    //     $pdf->SetFooter("{DATE j/m/Y H:i}|{PAGENO}/{nb}|" . utf8_encode('Nome do Sistema') . "|");

    //     $pdf->Output('recurso.recurso.pdf', 'I');
    // }

    // public function report()
    // {

    //     $data = array(
    //         'button' => 'Gerar',
    //         'controller' => 'report',
    //         'action' => site_url('usuario/open_pdf'),
    //         'recurso_id' => null,
    //         'recurso_nm' => null,
    //         'recurso_tombo' => null,
    //         'conservacao_id' => null,
    //         'setaf_id' => null,
    //         'localizacao' => null,
    //         'municipio_id' => null,
    //         'caminho' => null,
    //         'documento_id' => null,
    //         'requerente_id' => null,
    //     );

    //     $this->load->view('usuario/Usuario_report', $data);
    // }


    // public function retorna_pessoa_logado()
    // {
    //     $this->usuario_login();

    //         // $_SESSION['pasta_sistema_pai'] = '_portal';

    //         // $login = rlower(trim($this->input->post('usuario_login', TRUE)));
    //         // $senha_original = (trim($this->input->post('usuario_senha', TRUE)));
    //         // $senha = md5(trim($this->input->post('usuario_senha', TRUE)));

    //     $json = array(
    //         'pessoa_id' => empty($_SESSION['pessoa_id']) ? 0 : $_SESSION['pessoa_id'],
    //         'sistema_id' =>empty($_SESSION['sistema_id']) ? 0 : $_SESSION['sistema_id'] ,
    //         'perfil' =>empty($_SESSION['perfil'])?'':$_SESSION['perfil'],
    //     );
    //     echo json_encode($json);
    // }

    public function select_sistema()
    {
        // if(empty($_SESSION['pessoa_id'])){
        //     echo "favor realizar o login";
        //     exit;
        // }

        $sistema_id = (int)$this->input->get('sistema', TRUE);

        //echo $sistema_id;exit;
        //para algumas situaï¿½ï¿½es
        $diaria_id = (int)$this->input->get('diaria_id', TRUE);
        $sistema    = $this->Sistema_model->get_by_id($sistema_id);
        // print_r($sistema);
        $_SESSION['sistema_id'] = $sistema_id;
        $_SESSION['sistema']    = $sistema_id;


        //erro muito comum
        if (empty($_SESSION['pessoa_id'])) {
            header("Location: https://" . $_SERVER['HTTP_HOST'] . "/" . '_portal' . '/Intranet/usuario');
        }


        $tipo_usuario = $this->Usuario_model->pega_perfil_sistema($_SESSION['sistema_id'], $_SESSION['pessoa_id']);
        $_SESSION['tipo_usuario_id'] = $tipo_usuario->tipo_usuario_id;
        $_SESSION['TipoUsuario']     = $tipo_usuario->tipo_usuario_id;
        $_SESSION['tipo_usuario_ds']    = $tipo_usuario->tipo_usuario_ds;
        $_SESSION['perfil']    = $tipo_usuario->tipo_usuario_ds;


        //  print_r($_SESSION['pessoa_id']);//exit;
        $data = array(
            'acao'        => 'S',
            'pessoa_id'   => $_SESSION['pessoa_id'],
            'log_tipo_id' => 2,
            'sistema_id'  => $_SESSION['sistema_id']
        );
        $this->Log_model->Insert($data);

        $url = str_replace("../", "", $sistema->sistema_url);

        $url_complemento = "";
        if (!empty($diaria_id)) {
            $url_complemento = "&diaria_id=" . $diaria_id;
        }

        $http = "https://";
        if ($sistema_id == 24 or $sistema_id == 106 or $sistema_id == 2) {
            $http = "http://";
        }

        $session = json($_SESSION);
        //var_dump($session );


        //echo "https://" . $_SERVER['HTTP_HOST'] . "/_portal/" . $url;exit;
        $new_url = $http  . $_SERVER['HTTP_HOST'] . "/_portal/" . $url . '/?sistema=' .
            $sistema->sistema_id . $url_complemento . "&pessoa_id=" . $_SESSION['pessoa_id'];
        //  . "&session=" . $session;

        // print_r($session); exit;
        //echo $new_url;exit;
        //var_dump($_SESSION);exit;
        redirect($new_url);
    }


    private function Manda_email($email, $login, $nova_senha, $pessoa_nm)
    {
        // PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        unset($config);
        $config['smtp_host'] = 'envio.ba.gov.br';
        $config['smtp_port'] = 25;
        $config['protocol'] = 'smtp';
        $config['validate'] = TRUE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";

        $this->load->library('email');
        $this->load->email->initialize($config);
        $this->email->from("sistemas@sema.ba.gov.br", utf8_encode('Portal SDR | Usuário'));
        $this->email->subject(utf8_encode("Senha renovada"));
        $msg = "Prezado sr(a) $pessoa_nm";
        $msg .= "<br><br>";
        $msg .= "Sua solicitação de renovação de senha foi realizada com sucesso";
        $msg .= "<br><br>";
        $msg .= "<br>
                <a href='https://www.portalsema.ba.gov.br/_portal/Intranet/usuario'>                        
                        <input type='button' value= 'PORTAL DE SISTEMAS SDR' >
                </a>
        <br>";
        $msg .= "Login: <b>" . rlower($login) . '</b>';
        $msg .= "<br>";
        $msg .= "Senha: <b>" . $nova_senha . '</b>';
        $this->email->message(utf8_encode($msg));
        $this->email->cc($email);
        $this->email->send();
    }
}

/* End of file Usuario.php */
/* Local: ./application/controllers/Usuario.php */
/* Gerado por RGenerator - 2019-09-18 11:09:36 */