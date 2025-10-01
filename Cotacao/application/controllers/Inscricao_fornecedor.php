<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inscricao_fornecedor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Inscricao_fornecedor_model');
        $this->load->model('Pessoa_model');

        $this->load->model('Municipio_model');
        $this->load->model('Usuario_model');
        $this->load->model('Usuario_tipo_usuario_model');
        $this->load->model('Pessoa_fisica_model');
        $this->load->model('Funcionario_model');
        $this->load->model('Fornecedor_categoria_model');
        $this->load->model('Inscricao_fornecedor_historico_model');


        $this->load->library('form_validation');
    }


    public function ajax_verifica_duplicidade()
    {
        $responsavel_cpf = trim(urldecode($this->input->get('responsavel_cpf', TRUE)));
        $fornecedor_cnpj = trim(urldecode($this->input->get('fornecedor_cnpj', TRUE)));
        $fornecedor_email = rupper(trim(urldecode($this->input->get('fornecedor_email', TRUE))));
        // and reprovado_motivo IS NULL 
        // significa q pode ser um cadastro aprovado ou um pendente
        // reprovado é considerado lixo e nao conta
        if (empty($responsavel_cpf)) {
            $cpfs = array();
        } else {
            $cpfs = $this->Inscricao_fornecedor_model->get_all_data_param("responsavel_cpf = '$responsavel_cpf' and reprovado_motivo IS NULL");
        }

        //echo_pre($this->db->last_query());
        if (count($cpfs) > 0) {
            echo json(array('situacao' => "cpf_ja_existe"));
            exit;
        }

        $emails = $this->Inscricao_fornecedor_model->get_all_data_param("upper(fornecedor_email) = '$fornecedor_email'  and reprovado_motivo IS NULL");
        $usuarios = $this->Usuario_model->get_all_data_param("upper(usuario_login) = '$fornecedor_email'");
        //  echo_pre($this->db->last_query());
        if (count($emails) > 0 or count($usuarios) > 0) {
            echo json(array('situacao' => "email_ja_existe"));
            exit;
        }

        $cnpjs = $this->Inscricao_fornecedor_model->get_all_data_param("fornecedor_cnpj = '$fornecedor_cnpj'  and reprovado_motivo IS NULL");
        // echo_pre($this->db->last_query());
        if (count($cnpjs) > 0) {
            echo json(array('situacao' => "cnpj_ja_existe"));
            exit;
        }
        // else {
        //     echo json(array('situacao' => "cnpj_ok"));
        //     exit;
        // }

        echo json(array('situacao' => "ok"));
    }

    public function ajax_reprovar_inscricao_fornecedor($inscricao_fornecedor_id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $motivo = urldecode($this->input->get('motivo', TRUE));

        $data = array(
            'reprovado_motivo' => $motivo,
            'dt_aprovacao' => date('Y-m-d H:m:s')
        );
        $this->Inscricao_fornecedor_model->update($inscricao_fornecedor_id, $data);


        $msg = "<br><br>Prezado(a), Infelizmente seu cadastro de Fornecedor foi REPROVADO, para mais informações entre em contado com a SDR/SUAF<br><br>";

        $msg .= "<br>MOTIVO: \"" . $motivo . "\"";
        $msg .= "<br>";
        $msg .= "<br>";
        $msg .= "Whatsapp para contato com a SUAF: (71) 9.8326-4604";
        // echo $msg;
        // $this->manda_email($is->email = "riqueciano.macedo@sdr.ba.gov.br", $msg);
        $if = $this->Inscricao_fornecedor_model->get_by_id($inscricao_fornecedor_id);
        $this->manda_email($if->fornecedor_email, $msg, 'Reprovado');

        echo json(array('situacao' => "ok"));
        exit;
    }


    public function index()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $q =  ($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = (int)$this->input->get('start');
        $filtro_territorio_id = (int)$this->input->get('filtro_territorio_id', TRUE);
        $filtro_municipio_id = (int)$this->input->get('filtro_municipio_id', TRUE);



        $config['per_page'] = 300000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = 0;
        //        $inscricao_fornecedor = $this->Inscricao_fornecedor_model->get_limit_data($config['per_page'], $start, $q);
        $param = "";
        $param_usuarios = "1=1";

        if (!empty($q)) {
            $q = utf8_decode($q);
            $param .= " and (
                                upper(remove_acentuacao(p2.pessoa_nm)) ilike upper(remove_acentuacao('%$q%'))
                                or upper(remove_acentuacao(fornecedor_categoria_nm)) ilike upper(remove_acentuacao('%$q%'))
                                or upper(remove_acentuacao(municipio_nm)) ilike upper(remove_acentuacao('%$q%'))
                                or upper(remove_acentuacao(responsavel_nm)) ilike upper(remove_acentuacao('%$q%'))
                                or upper(remove_acentuacao(fornecedor_email)) ilike upper(remove_acentuacao('%$q%'))
                                or upper(remove_acentuacao(fornecedor_nm_fantasia)) ilike upper(remove_acentuacao('%$q%'))
                                or upper(remove_acentuacao(fornecedor_cnpj)) ilike upper(remove_acentuacao('%$q%'))
                                or  upper(remove_acentuacao(dap_caf)) ilike upper(remove_acentuacao('%$q%'))
                                or  upper(remove_acentuacao(fornecedor_endereco)) ilike upper(remove_acentuacao('%$q%'))
                                or upper(remove_acentuacao(fornecedor_bairro)) ilike upper(remove_acentuacao('%$q%'))
                            ) ";


            $param_usuarios .= " and (
                                            upper(remove_acentuacao(p.pessoa_nm)) ilike upper(remove_acentuacao('%$q%'))
                                            or upper(remove_acentuacao(v.usuario_login)) ilike upper(remove_acentuacao('%$q%'))
                                            or upper(remove_acentuacao(p.pessoa_cnpj)) ilike upper(remove_acentuacao('%$q%'))
                                        ) ";
        }
        if (!empty($filtro_territorio_id)) {
            $param .= " and territorio.territorio_id = $filtro_territorio_id";
        }
        if (!empty($filtro_municipio_id)) {
            $param .= " and fornecedor_municipio_id = $filtro_municipio_id";
        }

        $inscricao_fornecedor = $this->Inscricao_fornecedor_model->get_all_data_param("1=1 " . $param,  "dt_aprovacao desc ");
        //  echo_pre($this->db->last_query());

        $usuarios_fornecedor = $this->Usuario_model->get_usuarios(104, 442, $param_usuarios);
        // echo_pre($this->db->last_query());
        //remove todos os $inscricao_fornecedor (pessoa_id) do array $usuarios_fornecedor quando estiverem presentes
        foreach ($usuarios_fornecedor as $key => $u) {
            $pessoa_id = $u->pessoa_id;
            foreach ($inscricao_fornecedor as $key => $i) {
                if ($i->pessoa_id == $pessoa_id) {
                    // unset($usuarios_fornecedor[$key]);
                }
            }
        }

        


        foreach ($inscricao_fornecedor as $key => $i) {
            $i->inscricao_fornecedor_historico = $this->Inscricao_fornecedor_historico_model->get_all_data_param("inscricao_fornecedor.inscricao_fornecedor_id = " . $i->inscricao_fornecedor_id);
        }


        ## para retorno json no front
        if ($format == 'json') {
            echo json($inscricao_fornecedor);
            exit;
        }
        if ($format == 'json_usuarios') {
            echo json($usuarios_fornecedor);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $territorio = $this->Territorio_model->get_all_data_param("territorio_uf='BA' and territorio_id!=54 ", "remove_acentuacao(territorio_nm)");
        $municipio  = $this->Municipio_model->get_all_data_param("estado_uf='BA' and ativo=1", "remove_acentuacao(municipio_nm)");






        $data = array(
            'inscricao_fornecedor_data' => json($inscricao_fornecedor),
            'usuarios_fornecedor' => json($usuarios_fornecedor),
            'territorio' => json($territorio),
            'municipio' => json($municipio),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('inscricao_fornecedor/Inscricao_fornecedor_list', forFrontVue($data));
    }



    //aprovar fornecedor
    public function aprovacao_fornecedor_action($inscricao_fornecedor_id)
    {

        $is = $this->Inscricao_fornecedor_model->get_by_id($inscricao_fornecedor_id);

        $this->db->trans_start();


        try {
            $senha = 'sdr' . rand(1000, 9999);
            $senhaMd5 = md5($senha);
            // echo $this->input->post('inscricao_sipaf_status_id', TRUE);exit;

            $muni = $this->Municipio_model->get_by_id($is->fornecedor_municipio_id);
            //verifica se usuario já existe, se tiver so faz conceder mais acesso
            $pessoa = $this->Pessoa_model->verifica_pessoa_existe(($is->fornecedor_email));
            //  echo_pre($this->db->last_query());
            // exit;
            ########################################################################################################################################
            ########################################################################################################################################


            //usuario NÃO existe, ENTAO CRIA
            if (empty($pessoa->usuario_login)) {
                $data = array(
                    'pessoa_nm' =>  trim(rupper($is->fornecedor_nm)),
                    'pessoa_nm_fantasia' =>  trim(rupper($is->fornecedor_nm)),
                    'pessoa_dap' =>  trim(rupper($is->dap_caf)),
                    'pessoa_tipo' => 'F', // informação generica
                    'pessoa_st' => 0,
                    'flag_cadastro_externo' => 1,
                    'cotacao_municipio_id' => $is->fornecedor_municipio_id,
                    'fornecedor_categoria_id' => $is->fornecedor_categoria_id,
                    'pessoa_cnpj' => $is->fornecedor_cnpj,
                    'cotacao_territorio_id' => $muni->territorio_id,
                );
                $this->Pessoa_model->insert($data);
                $pessoa_id = $this->db->insert_id();

                // print_r($is);exit;
                $data2 = array(
                    'pessoa_fisica_cpf' => $is->responsavel_cpf,
                    'pessoa_id' => $pessoa_id,

                );
                $this->Pessoa_fisica_model->insert($data2);

                // cria registro da tabela funcionario como "COMPRADOR OU FORNECEDOR"
                $data3 = array(
                    'pessoa_id' => $pessoa_id,
                    'funcionario_tipo_id' => 151, //COMPRADOR OU FORNECEDOR - COTACAO DE PRODUTOS
                    'funcionario_email' => rupper(trim($is->fornecedor_email))
                );
                $this->Funcionario_model->insert($data3);


                //cria login e senha
                $data4 = array(
                    'usuario_login' => rlower(trim($is->fornecedor_email)),
                    'usuario_senha' => $senhaMd5,
                    'usuario_st' => 0,
                    'pessoa_id' => $pessoa_id,
                );
                $this->Usuario_model->insert($data4);

                //ADD PERFIL
                $data5 = array(
                    'pessoa_id' => $pessoa_id,
                    'tipo_usuario_id' => 442, //fornecedor 
                );
                $this->Usuario_tipo_usuario_model->insert($data5);


                ///atualiza o cadastro do fornecedor
                $data = array(
                    'fornecedor_pessoa_id' => $pessoa_id,
                    'dt_aprovacao' => date('Y-m-d H:m:s'),
                    'autorizador_cadastro_gestor_pessoa_id' => $_SESSION['pessoa_id'],
                );
                $this->Inscricao_fornecedor_model->update($inscricao_fornecedor_id, $data);


                $data_historico = array(
                    'inscricao_fornecedor_id' => $inscricao_fornecedor_id,
                    'inscricao_fornecedor_historico_acao' => 'Autorização do fornecedor - email enviado',
                    'inscricao_fornecedor_historico_pessoa_id' => empty($pessoa_id) ? $_SESSION['pessoa_id'] : $pessoa_id, 
                );
                $this->Inscricao_fornecedor_historico_model->insert($data_historico);
                $this->monta_email_e_envia($is, $senha, $inscricao_fornecedor_id);
            } else {
                ################################################
                ##Usuario existe##############################################
                $pessoa_id = $pessoa->pessoa_id;
                $data = array(
                    'pessoa_nm' =>  trim(rupper($is->fornecedor_nm)),
                    'pessoa_nm_fantasia' =>  trim(rupper($is->fornecedor_nm)),
                    'pessoa_dap' =>  trim(rupper($is->dap_caf)),
                    'pessoa_tipo' => 'F', // informação generica
                    'pessoa_st' => 0,
                    'flag_cadastro_externo' => 1,
                    'cotacao_municipio_id' => $is->fornecedor_municipio_id,
                    'fornecedor_categoria_id' => $is->fornecedor_categoria_id,
                    'pessoa_cnpj' => $is->fornecedor_cnpj,
                    'cotacao_territorio_id' => $muni->territorio_id,
                );
                $this->Pessoa_model->update($pessoa_id, $data);

                //verifica se ja tem o perfil, se tiver insere, senao tiver ignora e segue
                $usuario_tipo_usuario = $this->Usuario_tipo_usuario_model->tem_esse_perfil($pessoa_id);
                // echo_pre($this->db->last_query());

                #######################################################################
                if (count($usuario_tipo_usuario) == 0) {
                    //ADD PERFIL
                    $data5 = array(
                        'pessoa_id' => $pessoa_id,
                        'tipo_usuario_id' => 442, //fornecedor 
                    );
                    $this->Usuario_tipo_usuario_model->insert($data5);
                }

                #######################################################################
                ///atualiza o cadastro do fornecedor
                $data = array(
                    'fornecedor_pessoa_id' => $pessoa_id,
                    'dt_aprovacao' => date('Y-m-d H:m:s'),
                    'autorizador_cadastro_gestor_pessoa_id' => $_SESSION['pessoa_id'],
                );
                $this->Inscricao_fornecedor_model->update($inscricao_fornecedor_id, $data);

                #######################################################################
                $data4 = array(
                    'usuario_login' => rlower(trim($is->fornecedor_email)),
                    'usuario_senha' => $senhaMd5,
                    'usuario_st' => 0,
                    'pessoa_id' => $pessoa_id,
                );
                $this->Usuario_model->update($pessoa->usuario_id, $data4);

                $data_historico = array(
                    'inscricao_fornecedor_id' => $inscricao_fornecedor_id,
                    'inscricao_fornecedor_historico_acao' => 'Atualização cadastro - email enviado',
                    'inscricao_fornecedor_historico_pessoa_id' => empty($pessoa_id) ? null : $pessoa_id, 
                );
                $this->Inscricao_fornecedor_historico_model->insert($data_historico);

                $this->monta_email_e_envia($is, $senha, $inscricao_fornecedor_id);
            }








            $this->db->trans_complete();
        } catch (Exception $e) {
            echo 'erro desconhecido, Favor solicitar <b class="red">POR E-MAIL</b> o cadastro manual para ser feito pela APG';
            $this->db->trans_rollback();
            exit;
        }

        
        redirect(site_url('inscricao_fornecedor'));
    }


    public function registra_email_aberto($inscricao_fornecedor_id = null)
    {
        if (!empty($inscricao_fornecedor_id)) {
            $data_historico = array(
                'inscricao_fornecedor_id' => $inscricao_fornecedor_id,
                'inscricao_fornecedor_historico_acao' => 'Email aberto',
                'flag_email_aberto' => 1,
                'email_aberto_dt' => date('Y-m-d H:m:s'),
            );
            $this->Inscricao_fornecedor_historico_model->insert($data_historico);


            $data_historico = array( 
                'inscricao_fornecedor_email_aberto' => 1, 
                'inscricao_fornecedor_email_dt_aberto' => date('Y-m-d H:m:s'),
            );
            $this->Inscricao_fornecedor_model->update($inscricao_fornecedor_id, $data_historico);
        }
    }


public function ajax_verifica_email_sipaf(){
    $fornecedor_email = $this->input->get('fornecedor_email', TRUE);
    

    //verifica se o usuario ja possui sipaf
    $usuario = $this->Usuario_model->get_usuario_sipaf($fornecedor_email);

    if (!empty($usuario->sistema_id)) {
        echo json(array('situacao' => 'email_sipaf_existe'));
        exit;
    }


    echo json(array('situacao' => 'ok'));
    exit;
}


    private function monta_email_e_envia($is, $senha = null, $inscricao_fornecedor_id = null)
    {
        // $_SESSION['temp_login_sipaf_exibir'] = trim($is->fornecedor_email);
        // $_SESSION['temp_senha_sipaf_exibir'] = md5('sdr');
        $msg = $is->fornecedor_nm . ',';
 

        $msg .= '
        <div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto;">
            <p><br>Seu cadastro de <strong>Fornecedor</strong> foi <span style="color: green;">APROVADO</span> para participar do programa de Cotação de Produtos da Agricultura Familiar da SDR.<br><br></p>
            
            <p style="text-align: center;">
                <a href="https://www.portalsema.ba.gov.br/_portal/Intranet/usuario/?inscricao_fornecedor_id=' . $inscricao_fornecedor_id . '" 
                   style="display: inline-block; background-color: #2e7d32; color: white; padding: 14px 24px; text-decoration: none; border-radius: 6px; font-size: 16px;">
                  CLIQUE AQUI - Cadastre os preços dos produtos ofertados
                </a>
            </p>
            
        ';
    
    if (!empty($senha)) {
        $msg .= '
            <p><br><strong>Login:</strong> ' . rlower(trim($is->fornecedor_email)) . '<br>
            <strong>Senha:</strong> ' . $senha . '</p>';
    }
    
    $msg .= '
            <br>
            <p style="font-size: 14px; color: #555;">Whatsapp para contato com a SUAF: <strong>(71) 9.8326-4604</strong></p>
        </div>
    ';
    
    $this->manda_email($is->fornecedor_email, $msg);
    
    }


    private function manda_email($email, $msg, $acao = 'Aprovado')
    {

        $config['smtp_host'] = 'envio.ba.gov.br';
        $config['smtp_port'] = 25;
        $config['protocol'] = 'smtp';
        $config['validate'] = TRUE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";


        $this->load->library('email');
        $this->load->email->initialize($config);
        // Adicionando um endereço de resposta
        // $this->email->reply_to("nao-responda@sdr.ba.gov.br", 'Não Responda');

        // Definindo cabeçalhos adicionais
        // $this->email->set_header('MIME-Version', '1.0');
        // $this->email->set_header('Content-type', 'text/html; charset=utf-8');
        $this->email->to($email);

        $this->email->from("sistemas@sema.ba.gov.br", utf8_encode('SDR/COTAÇÃO'));
        $this->email->subject(utf8_encode("Cadastro $acao!"));
        $this->email->message(utf8_encode($msg));

        //echo $msg;exit;
        $this->email->send();
    }


    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Inscricao_fornecedor_model->get_by_id($id);
        $pessoa = $this->Pessoa_model->get_all_combobox();
        $municipio = $this->Municipio_model->get_all_combobox();
        $pessoa = $this->Pessoa_model->get_all_combobox();
        if ($row) {
            $data = array(
                'pessoa' => json($pessoa),
                'municipio' => json($municipio),
                'pessoa' => json($pessoa),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('inscricao_fornecedor/create_action'),
                'inscricao_fornecedor_id' => $row->inscricao_fornecedor_id,
                'fornecedor_pessoa_id' => $row->fornecedor_pessoa_id,
                'responsavel_nm' => $row->responsavel_nm,
                'responsavel_cpf' => $row->responsavel_cpf,
                'fornecedor_email' => $row->fornecedor_email,
                'responsavel_telefone' => $row->responsavel_telefone,
                'dt_cadastro' => $row->dt_cadastro,
                'fornecedor_nm' => $row->fornecedor_nm,
                'fornecedor_nm_fantasia' => $row->fornecedor_nm_fantasia,
                'inscricao_fornecedor_tipo' => $row->inscricao_fornecedor_tipo,
                'fornecedor_cnpj' => $row->fornecedor_cnpj,
                'fornecedor_municipio_id' => $row->fornecedor_municipio_id,
                'autorizador_cadastro_gestor_pessoa_id' => $row->autorizador_cadastro_gestor_pessoa_id,
                'reprovado_motivo' => $row->reprovado_motivo,
                'dap_caf' => $row->dap_caf,
                'fornecedor_cep' => $row->fornecedor_cep,
                'fornecedor_categoria_id' => $row->fornecedor_categoria_id,
                'fornecedor_bairro' => $row->fornecedor_bairro,
                'fornecedor_endereco' => $row->fornecedor_endereco,
            );
            $this->load->view('inscricao_fornecedor/Inscricao_fornecedor_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('inscricao_fornecedor'));
        }
    }

    public function create()
    {
        // PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        // $pessoa = $this->Pessoa_model->get_all_combobox();
        $municipio = $this->Municipio_model->get_all_combobox("ativo=1 and estado_uf='BA' ", "municipio_nm asc");
        $pessoa = array(); //$this->Pessoa_model->get_all_combobox();
        $fornecedor_categoria = $this->Fornecedor_categoria_model->get_all_combobox(null, 'fornecedor_categoria_nm');
        $data = array(
            'pessoa' => json($pessoa),
            'fornecedor_categoria' => json($fornecedor_categoria),
            'municipio' => json($municipio),
            'pessoa' => json($pessoa),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('inscricao_fornecedor/create_action'),
            'inscricao_fornecedor_id' => set_value('inscricao_fornecedor_id'),
            'fornecedor_pessoa_id' => set_value('fornecedor_pessoa_id'),
            'responsavel_nm' => set_value('responsavel_nm'),
            'responsavel_cpf' => set_value('responsavel_cpf'),
            'fornecedor_email' => set_value('fornecedor_email'),
            'responsavel_telefone' => set_value('responsavel_telefone'),
            'dt_cadastro' => set_value('dt_cadastro'),
            'fornecedor_nm' => set_value('fornecedor_nm'),
            'fornecedor_nm_fantasia' => set_value('fornecedor_nm_fantasia'),
            'inscricao_fornecedor_tipo' => set_value('inscricao_fornecedor_tipo'),
            'fornecedor_cnpj' => set_value('fornecedor_cnpj'),
            'fornecedor_municipio_id' => set_value('fornecedor_municipio_id'),
            'autorizador_cadastro_gestor_pessoa_id' => set_value('autorizador_cadastro_gestor_pessoa_id'),
            'reprovado_motivo' => set_value('reprovado_motivo'),
            'dap_caf' => set_value('dap_caf'),
            'fornecedor_cep' => set_value('fornecedor_cep'),
            'fornecedor_categoria_id' => set_value('fornecedor_categoria_id'),
            'fornecedor_bairro' => set_value('fornecedor_bairro'),
            'fornecedor_endereco' => set_value('fornecedor_endereco'),
        );
        $this->load->view('inscricao_fornecedor/Inscricao_fornecedor_form', forFrontVue($data));
    }

    public function create_action()
    {
        // echo 1;exit;
        // PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

        $data = array(
            'fornecedor_pessoa_id' =>      empty($this->input->post('fornecedor_pessoa_id', TRUE)) ? NULL : $this->input->post('fornecedor_pessoa_id', TRUE),
            'responsavel_nm' =>      empty($this->input->post('responsavel_nm', TRUE)) ? NULL : $this->input->post('responsavel_nm', TRUE),
            'responsavel_cpf' =>      empty($this->input->post('responsavel_cpf', TRUE)) ? NULL : $this->input->post('responsavel_cpf', TRUE),
            'fornecedor_email' =>      empty($this->input->post('fornecedor_email', TRUE)) ? NULL : $this->input->post('fornecedor_email', TRUE),
            'responsavel_telefone' =>      empty($this->input->post('responsavel_telefone', TRUE)) ? NULL : $this->input->post('responsavel_telefone', TRUE),
            // 'dt_cadastro' =>      empty($this->input->post('dt_cadastro', TRUE)) ? NULL : $this->input->post('dt_cadastro', TRUE),
            'fornecedor_nm' =>      empty($this->input->post('fornecedor_nm', TRUE)) ? NULL : $this->input->post('fornecedor_nm', TRUE),
            'fornecedor_nm_fantasia' =>      empty($this->input->post('fornecedor_nm_fantasia', TRUE)) ? NULL : $this->input->post('fornecedor_nm_fantasia', TRUE),
            'inscricao_fornecedor_tipo' =>      empty($this->input->post('inscricao_fornecedor_tipo', TRUE)) ? NULL : $this->input->post('inscricao_fornecedor_tipo', TRUE),
            'fornecedor_cnpj' =>      empty($this->input->post('fornecedor_cnpj', TRUE)) ? NULL : $this->input->post('fornecedor_cnpj', TRUE),
            'fornecedor_municipio_id' =>      empty($this->input->post('fornecedor_municipio_id', TRUE)) ? NULL : $this->input->post('fornecedor_municipio_id', TRUE),
            'autorizador_cadastro_gestor_pessoa_id' =>      empty($this->input->post('autorizador_cadastro_gestor_pessoa_id', TRUE)) ? NULL : $this->input->post('autorizador_cadastro_gestor_pessoa_id', TRUE),
            'reprovado_motivo' =>      empty($this->input->post('reprovado_motivo', TRUE)) ? NULL : $this->input->post('reprovado_motivo', TRUE),
            'dap_caf' =>      empty($this->input->post('dap_caf', TRUE)) ? NULL : $this->input->post('dap_caf', TRUE),
            'fornecedor_cep' =>      empty($this->input->post('fornecedor_cep', TRUE)) ? NULL : $this->input->post('fornecedor_cep', TRUE),
            'fornecedor_categoria_id' =>      empty($this->input->post('fornecedor_categoria_id', TRUE)) ? NULL : $this->input->post('fornecedor_categoria_id', TRUE),
            'fornecedor_bairro' =>      empty($this->input->post('fornecedor_bairro', TRUE)) ? NULL : $this->input->post('fornecedor_bairro', TRUE),
            'fornecedor_endereco' =>      empty($this->input->post('fornecedor_endereco', TRUE)) ? NULL : $this->input->post('fornecedor_endereco', TRUE),
        );
        // var_dump($data);
        $this->Inscricao_fornecedor_model->insert($data);
        // exit;

        $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
        redirect(site_url('inscricao_fornecedor/sucesso'));
    }

    public function sucesso()
    {
        $data = array(
            'um' => 1,
        );
        $this->load->view('inscricao_fornecedor/Inscricao_fornecedor_aviso_conclusao.php', forFrontVue($data));
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Inscricao_fornecedor_model->get_by_id($id);
        $pessoa = $this->Pessoa_model->get_all_combobox();
        $municipio = $this->Municipio_model->get_all_combobox();

        $pessoa = $this->Pessoa_model->get_all_combobox();

        $fornecedor_categoria = $this->Fornecedor_categoria_model->get_all_combobox(null, 'fornecedor_categoria_nm');



        if ($row) {
            $data = array(
                'pessoa' => json($pessoa),
                'municipio' => json($municipio),
                'pessoa' => json($pessoa),
                'fornecedor_categoria' => json($fornecedor_categoria),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('inscricao_fornecedor/update_action'),
                'inscricao_fornecedor_id' => set_value('inscricao_fornecedor_id', $row->inscricao_fornecedor_id),
                'fornecedor_pessoa_id' => set_value('fornecedor_pessoa_id', $row->fornecedor_pessoa_id),
                'responsavel_nm' => set_value('responsavel_nm', $row->responsavel_nm),
                'responsavel_cpf' => set_value('responsavel_cpf', $row->responsavel_cpf),
                'fornecedor_email' => set_value('fornecedor_email', $row->fornecedor_email),
                'responsavel_telefone' => set_value('responsavel_telefone', $row->responsavel_telefone),
                'dt_cadastro' => set_value('dt_cadastro', $row->dt_cadastro),
                'fornecedor_nm' => set_value('fornecedor_nm', $row->fornecedor_nm),
                'fornecedor_nm_fantasia' => set_value('fornecedor_nm_fantasia', $row->fornecedor_nm_fantasia),
                'inscricao_fornecedor_tipo' => set_value('inscricao_fornecedor_tipo', $row->inscricao_fornecedor_tipo),
                'fornecedor_cnpj' => set_value('fornecedor_cnpj', $row->fornecedor_cnpj),
                'fornecedor_municipio_id' => set_value('fornecedor_municipio_id', $row->fornecedor_municipio_id),
                'autorizador_cadastro_gestor_pessoa_id' => set_value('autorizador_cadastro_gestor_pessoa_id', $row->autorizador_cadastro_gestor_pessoa_id),
                'reprovado_motivo' => set_value('reprovado_motivo', $row->reprovado_motivo),
                'dap_caf' => set_value('dap_caf', $row->dap_caf),
                'fornecedor_cep' => set_value('fornecedor_cep', $row->fornecedor_cep),
                'fornecedor_categoria_id' => set_value('fornecedor_categoria_id', $row->fornecedor_categoria_id),
                'fornecedor_bairro' => set_value('fornecedor_bairro', $row->fornecedor_bairro),
                'fornecedor_endereco' => set_value('fornecedor_endereco', $row->fornecedor_endereco),
            );
            $this->load->view('inscricao_fornecedor/Inscricao_fornecedor_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('inscricao_fornecedor'));
        }
    }

    public function update_action()
    {
        // PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('fornecedor_pessoa_id', 'fornecedor_pessoa_id', 'trim|integer');
        $this->form_validation->set_rules('responsavel_nm', 'responsavel_nm', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('responsavel_cpf', 'responsavel_cpf', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('fornecedor_email', 'fornecedor_email', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('responsavel_telefone', 'responsavel_telefone', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('dt_cadastro', 'dt_cadastro', 'trim');
        $this->form_validation->set_rules('fornecedor_nm', 'fornecedor_nm', 'trim|required|max_length[200]');
        // $this->form_validation->set_rules('fornecedor_nm_fantasia', 'fornecedor_nm_fantasia', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('fornecedor_cnpj', 'fornecedor_cnpj', 'trim|max_length[100]');
        $this->form_validation->set_rules('fornecedor_municipio_id', 'fornecedor_municipio_id', 'trim|required|integer');
        $this->form_validation->set_rules('autorizador_cadastro_gestor_pessoa_id', 'autorizador_cadastro_gestor_pessoa_id', 'trim|integer');
        $this->form_validation->set_rules('reprovado_motivo', 'reprovado_motivo', 'trim|max_length[300]');
        $this->form_validation->set_rules('dap_caf', 'dap_caf', 'trim|required|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('inscricao_fornecedor_id', TRUE));
        } else {
            $data = array(
                'fornecedor_pessoa_id' => empty($this->input->post('fornecedor_pessoa_id', TRUE)) ? NULL : $this->input->post('fornecedor_pessoa_id', TRUE),
                'responsavel_nm' => empty($this->input->post('responsavel_nm', TRUE)) ? NULL : $this->input->post('responsavel_nm', TRUE),
                'responsavel_cpf' => empty($this->input->post('responsavel_cpf', TRUE)) ? NULL : $this->input->post('responsavel_cpf', TRUE),
                'fornecedor_email' => empty($this->input->post('fornecedor_email', TRUE)) ? NULL : $this->input->post('fornecedor_email', TRUE),
                'responsavel_telefone' => empty($this->input->post('responsavel_telefone', TRUE)) ? NULL : $this->input->post('responsavel_telefone', TRUE),
                // 'dt_cadastro' => empty($this->input->post('dt_cadastro', TRUE)) ? NULL : $this->input->post('dt_cadastro', TRUE),
                'fornecedor_nm' => empty($this->input->post('fornecedor_nm', TRUE)) ? NULL : $this->input->post('fornecedor_nm', TRUE),
                'fornecedor_nm_fantasia' => empty($this->input->post('fornecedor_nm_fantasia', TRUE)) ? NULL : $this->input->post('fornecedor_nm_fantasia', TRUE),
                'inscricao_fornecedor_tipo' => empty($this->input->post('inscricao_fornecedor_tipo', TRUE)) ? NULL : $this->input->post('inscricao_fornecedor_tipo', TRUE),
                'fornecedor_cnpj' => empty($this->input->post('fornecedor_cnpj', TRUE)) ? NULL : $this->input->post('fornecedor_cnpj', TRUE),
                'fornecedor_municipio_id' => empty($this->input->post('fornecedor_municipio_id', TRUE)) ? NULL : $this->input->post('fornecedor_municipio_id', TRUE),
                'autorizador_cadastro_gestor_pessoa_id' => empty($this->input->post('autorizador_cadastro_gestor_pessoa_id', TRUE)) ? NULL : $this->input->post('autorizador_cadastro_gestor_pessoa_id', TRUE),
                'reprovado_motivo' => empty($this->input->post('reprovado_motivo', TRUE)) ? NULL : $this->input->post('reprovado_motivo', TRUE),
                'dap_caf' => empty($this->input->post('dap_caf', TRUE)) ? NULL : $this->input->post('dap_caf', TRUE),
                'fornecedor_cep' => empty($this->input->post('fornecedor_cep', TRUE)) ? NULL : $this->input->post('fornecedor_cep', TRUE),
                'fornecedor_categoria_id' => empty($this->input->post('fornecedor_categoria_id', TRUE)) ? NULL : $this->input->post('fornecedor_categoria_id', TRUE),
                'fornecedor_bairro' => empty($this->input->post('fornecedor_bairro', TRUE)) ? NULL : $this->input->post('fornecedor_bairro', TRUE),
                'fornecedor_endereco' => empty($this->input->post('fornecedor_endereco', TRUE)) ? NULL : $this->input->post('fornecedor_endereco', TRUE),
            );

            $this->Inscricao_fornecedor_model->update($this->input->post('inscricao_fornecedor_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('inscricao_fornecedor'));
        }
    }

    /*
    public function delete($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $row = $this->Inscricao_fornecedor_model->get_by_id($id);

        if ($row) {
            if (@$this->Inscricao_fornecedor_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('inscricao_fornecedor'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('inscricao_fornecedor'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('inscricao_fornecedor'));
        }
    }*/

    public function _rules()
    {
        // PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->form_validation->set_rules('fornecedor_pessoa_id', 'fornecedor pessoa id', 'trim|required');
        $this->form_validation->set_rules('responsavel_nm', 'responsavel nm', 'trim|required');
        $this->form_validation->set_rules('responsavel_cpf', 'responsavel cpf', 'trim|required');
        $this->form_validation->set_rules('fornecedor_email', 'responsavel email', 'trim|required');
        $this->form_validation->set_rules('responsavel_telefone', 'responsavel telefone', 'trim|required');
        $this->form_validation->set_rules('dt_cadastro', 'dt cadastro', 'trim|required');
        $this->form_validation->set_rules('fornecedor_nm', 'fornecedor nm', 'trim|required');
        // $this->form_validation->set_rules('fornecedor_nm_fantasia', 'fornecedor nm fantasia', 'trim|required');
        $this->form_validation->set_rules('fornecedor_cnpj', 'fornecedor cnpj', 'trim');
        $this->form_validation->set_rules('fornecedor_municipio_id', 'fornecedor municipio id', 'trim|required');
        $this->form_validation->set_rules('autorizador_cadastro_gestor_pessoa_id', 'autorizador cadastro gestor pessoa id', 'trim|required');
        $this->form_validation->set_rules('reprovado_motivo', 'reprovado motivo', 'trim|required');
        $this->form_validation->set_rules('dap_caf', 'dap caf', 'trim|required');

        $this->form_validation->set_rules('inscricao_fornecedor_id', 'inscricao_fornecedor_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

        $param = array(

            array('fornecedor_pessoa_id', '=', $this->input->post('fornecedor_pessoa_id', TRUE)),
            array('responsavel_nm', '=', $this->input->post('responsavel_nm', TRUE)),
            array('responsavel_cpf', '=', $this->input->post('responsavel_cpf', TRUE)),
            array('fornecedor_email', '=', $this->input->post('fornecedor_email', TRUE)),
            array('responsavel_telefone', '=', $this->input->post('responsavel_telefone', TRUE)),
            array('dt_cadastro', '=', $this->input->post('dt_cadastro', TRUE)),
            array('fornecedor_nm', '=', $this->input->post('fornecedor_nm', TRUE)),
            array('fornecedor_nm_fantasia', '=', $this->input->post('fornecedor_nm_fantasia', TRUE)),
            array('inscricao_fornecedor_tipo', '=', $this->input->post('inscricao_fornecedor_tipo', TRUE)),
            array('fornecedor_cnpj', '=', $this->input->post('fornecedor_cnpj', TRUE)),
            array('fornecedor_municipio_id', '=', $this->input->post('fornecedor_municipio_id', TRUE)),
            array('autorizador_cadastro_gestor_pessoa_id', '=', $this->input->post('autorizador_cadastro_gestor_pessoa_id', TRUE)),
            array('reprovado_motivo', '=', $this->input->post('reprovado_motivo', TRUE)),
            array('dap_caf', '=', $this->input->post('dap_caf', TRUE)),
        ); //end array dos parametros

        $data = array(
            'inscricao_fornecedor_data' => $this->Inscricao_fornecedor_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('inscricao_fornecedor/Inscricao_fornecedor_pdf', $data, true);


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
            'action'        => site_url('inscricao_fornecedor/open_pdf'),
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


        $this->load->view('inscricao_fornecedor/Inscricao_fornecedor_report', forFrontVue($data));
    }
}

/* End of file Inscricao_fornecedor.php */
/* Local: ./application/controllers/Inscricao_fornecedor.php */
/* Gerado por RGenerator - 2024-06-04 16:12:57 */