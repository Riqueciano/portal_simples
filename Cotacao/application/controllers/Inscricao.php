<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inscricao extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Inscricao_model');
        $this->load->model('Municipio_model');

        $this->load->model('Funcionario_model');
        $this->load->model('Usuario_model');
        $this->load->model('Usuario_tipo_usuario_model');
        $this->load->model('Pessoa_model');
        $this->load->model('Comprador_categoria_model');
        $this->load->model('Pessoa_fisica_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'inscricao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'inscricao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'inscricao/';
            $config['first_url'] = base_url() . 'inscricao/';
        }

        $config['per_page'] = 1000000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Inscricao_model->total_rows($q);
        $inscricao = $this->Inscricao_model->get_limit_data($config['per_page'], $start, $q);

        $territorio = $this->Territorio_model->get_all("territorio_uf='BA' and territorio_id!=54", "territorio_nm asc");
        foreach ($territorio as $key => $t) {
            $t->qtd_usuarios = 0;
            foreach ($inscricao as $key => $i) {
                if ($t->territorio_id == $i->territorio_id) {
                    $t->qtd_usuarios++;
                }
            }
        }

        ## para retorno json no front
        if ($format == 'json') {
            echo json($inscricao);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'inscricao_data' => json($inscricao),
            'territorio' => json($territorio),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('inscricao/Inscricao_list', forFrontVue($data));
    }



    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Inscricao_model->get_by_id($id);
        $municipio = $this->Municipio_model->get_all_combobox();
        $pessoa = $this->Pessoa_model->get_all_combobox();
        if ($row) {
            $data = array(
                'municipio' => json($municipio),
                'pessoa' => json($pessoa),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('inscricao/create_action'),
                'inscricao_id' => $row->inscricao_id,
                'comprador_categoria_id' => $row->comprador_categoria_id,
                'responsavel_nm' => trim(rupper($row->responsavel_nm)),
                'comprador_nm' => trim(rupper($row->comprador_nm)),
                'responsavel_cpf' => trim($row->responsavel_cpf),
                'responsavel_email' => rlower($row->responsavel_email),
                'mensagem' => $row->mensagem,
                'dt_create' => $row->dt_create,
                'cnpj' => $row->cnpj,
                'inscricao_municipio_id' => $row->inscricao_municipio_id,
                'pessoa_id' => $row->pessoa_id,
            );
            $this->load->view('inscricao/Inscricao_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('inscricao'));
        }
    }
    public function success($id)
    {
        if (empty($id)) {
            echo 'erro';
            exit;
        }

        $row = $this->Inscricao_model->get_by_id((int)$id);

        if ($row) {
            $data = array(

                'responsavel_email' => ($row->responsavel_email)
            );
            $this->load->view('inscricao/Inscricao_success', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('inscricao'));
        }
    }

    public function create()
    {
        $cadastrando_escola = (int)$this->input->get('cadastrando_escola');
        $capValidado = 'false';
        if ($cadastrando_escola == 1) {
            PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', "Nutricionista"]);
            $capValidado = 'true';
        }




        // PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $municipio = $this->Municipio_model->get_all_combobox("ativo=1 and estado_uf='BA'", 'municipio_nm asc');
        $pessoa = array(); //$this->Pessoa_model->get_all_combobox();

        $comprador_categoria = $this->Comprador_categoria_model->get_all_combobox(null, 'comprador_categoria_nm');
        $data = array(
            'municipio' => json($municipio),
            'pessoa' => json($pessoa),
            'comprador_categoria' => json($comprador_categoria),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('inscricao/create_action'),
            'inscricao_id' => set_value('inscricao_id'),
            'comprador_categoria_id' => set_value('comprador_categoria_id'),
            'responsavel_nm' => set_value('responsavel_nm'),
            'comprador_nm' => set_value('comprador_nm'),
            'responsavel_cpf' => set_value('responsavel_cpf'),
            'responsavel_email' => set_value('responsavel_email'),
            'mensagem' => set_value('mensagem'),
            'dt_create' => set_value('dt_create'),
            'cnpj' => set_value('cnpj'),
            'inscricao_municipio_id' => set_value('inscricao_municipio_id'),
            'pessoa_id' => set_value('pessoa_id'),
            'capValidado' => $capValidado,
        );
        $this->load->view('inscricao/Inscricao_form', forFrontVue($data));
    }

    public function create_action()
    {
        //PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('responsavel_nm', NULL, 'trim|required|max_length[200]');
        $this->form_validation->set_rules('comprador_nm', NULL, 'trim|required|max_length[200]');
        $this->form_validation->set_rules('responsavel_cpf', NULL, 'trim|required|max_length[20]');
        $this->form_validation->set_rules('responsavel_email', NULL, 'trim|required|max_length[200]');
        $this->form_validation->set_rules('mensagem', NULL, 'trim|max_length[800]');
        $this->form_validation->set_rules('dt_create', NULL, 'trim');
        $this->form_validation->set_rules('cnpj', NULL, 'trim|max_length[30]');
        $this->form_validation->set_rules('inscricao_municipio_id', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('pessoa_id', NULL, 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            try {

                //verifica se o cnpj ja esta sendo utilizado
                $ins = $this->Inscricao_model->get_by_cnpj($this->input->post('cnpj', TRUE));
                
                if ($ins and $ins->cnpj) {
                    include '../template/begin_1_2018rn_externo.php'; 
                    echo "<div class='alert alert-warning' role='alert'>
                            <b>Atenção! CNPJ já cadastrado para entidade " . strtoupper($ins->comprador_nm) . "</b>
                            </div>";
                    include '../template/end.php'; 
                    exit;
                }
                $ins = $this->Inscricao_model->get_by_cpf($this->input->post('responsavel_cpf', TRUE));
                if ($ins and $ins->responsavel_cpf) {
                    include '../template/begin_1_2018rn_externo.php'; 
                    echo "<div class='alert alert-warning' role='alert'>
                            <b>Atenção! CPF já cadastrado para entidade " . strtoupper($ins->comprador_nm) . "</b>
                            </div>";
                    include '../template/end.php'; 
                    exit;
                }

                
                $data = array(
                    'comprador_nm' =>      empty($this->input->post('comprador_nm', TRUE)) ? NULL : $this->input->post('comprador_nm', TRUE),
                    'responsavel_nm' =>      empty($this->input->post('responsavel_nm', TRUE)) ? NULL : $this->input->post('responsavel_nm', TRUE),
                    'responsavel_cpf' =>      empty($this->input->post('responsavel_cpf', TRUE)) ? NULL : $this->input->post('responsavel_cpf', TRUE),
                    'responsavel_email' =>      empty($this->input->post('responsavel_email', TRUE)) ? NULL : $this->input->post('responsavel_email', TRUE),
                    'mensagem' =>      empty($this->input->post('mensagem', TRUE)) ? NULL : $this->input->post('mensagem', TRUE),
                    // 'dt_create' =>      empty($this->input->post('dt_create', TRUE)) ? NULL : $this->input->post('dt_create', TRUE),
                    'cnpj' =>      empty($this->input->post('cnpj', TRUE)) ? NULL : $this->input->post('cnpj', TRUE),
                    'inscricao_municipio_id' =>      empty($this->input->post('inscricao_municipio_id', TRUE)) ? NULL : $this->input->post('inscricao_municipio_id', TRUE),
                    'comprador_categoria_id' =>      empty($this->input->post('comprador_categoria_id', TRUE)) ? NULL : $this->input->post('comprador_categoria_id', TRUE),
                    // 'pessoa_id' =>      empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
                );
               
                $this->Inscricao_model->insert($data);
                $inscricao_id = $this->db->insert_id();
            } catch (\Throwable $th) {
                //throw $th;
                include '../template/begin_1_2018rn_externo.php'; 
                echo "<b>Algo deu errado, tente novamente mais tarde</b>";
                include '../template/end_1_2018rn_externo.php'; 
            }
             
           

            $this->inscricao_action($inscricao_id);
            // $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            // echo 1;exit;

            $this->db->trans_complete();
            redirect(site_url('inscricao/success/' . $inscricao_id));
        }
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Inscricao_model->get_by_id($id);
        $municipio = $this->Municipio_model->get_all_combobox();
        $pessoa = $this->Pessoa_model->get_all_combobox();
        if ($row) {
            $data = array(
                'municipio' => json($municipio),
                'pessoa' => json($pessoa),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('inscricao/update_action'),
                'inscricao_id' => set_value('inscricao_id', $row->inscricao_id),
                'comprador_categoria_id' => set_value('comprador_categoria_id', $row->comprador_categoria_id),
                'responsavel_nm' => set_value('responsavel_nm', $row->responsavel_nm),
                'comprador_nm' => set_value('comprador_nm', $row->comprador_nm),
                'responsavel_cpf' => set_value('responsavel_cpf', $row->responsavel_cpf),
                'responsavel_email' => set_value('responsavel_email', $row->responsavel_email),
                'mensagem' => set_value('mensagem', $row->mensagem),
                'dt_create' => set_value('dt_create', $row->dt_create),
                'cnpj' => set_value('cnpj', $row->cnpj),
                'inscricao_municipio_id' => set_value('inscricao_municipio_id', $row->inscricao_municipio_id),
                'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
            );
            $this->load->view('inscricao/Inscricao_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('inscricao'));
        }
    }

    public function update_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('responsavel_nm', 'responsavel_nm', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('responsavel_cpf', 'responsavel_cpf', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('responsavel_email', 'responsavel_email', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('mensagem', 'mensagem', 'trim|max_length[800]');
        $this->form_validation->set_rules('dt_create', 'dt_create', 'trim');
        $this->form_validation->set_rules('cnpj', 'cnpj', 'trim|max_length[30]');
        $this->form_validation->set_rules('inscricao_municipio_id', 'inscricao_municipio_id', 'trim|required|integer');
        $this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('inscricao_id', TRUE));
        } else {
            $data = array(
                'responsavel_nm' => empty($this->input->post('responsavel_nm', TRUE)) ? NULL : $this->input->post('responsavel_nm', TRUE),
                'comprador_nm' => empty($this->input->post('comprador_nm', TRUE)) ? NULL : $this->input->post('comprador_nm', TRUE),
                'responsavel_cpf' => empty($this->input->post('responsavel_cpf', TRUE)) ? NULL : $this->input->post('responsavel_cpf', TRUE),
                'responsavel_email' => empty($this->input->post('responsavel_email', TRUE)) ? NULL : $this->input->post('responsavel_email', TRUE),
                'mensagem' => empty($this->input->post('mensagem', TRUE)) ? NULL : $this->input->post('mensagem', TRUE),
                'dt_create' => empty($this->input->post('dt_create', TRUE)) ? NULL : $this->input->post('dt_create', TRUE),
                'cnpj' => empty($this->input->post('cnpj', TRUE)) ? NULL : $this->input->post('cnpj', TRUE),
                'inscricao_municipio_id' => empty($this->input->post('inscricao_municipio_id', TRUE)) ? NULL : $this->input->post('inscricao_municipio_id', TRUE),
                'comprador_categoria_id' => empty($this->input->post('comprador_categoria_id', TRUE)) ? NULL : $this->input->post('comprador_categoria_id', TRUE),
                'pessoa_id' => empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
            );

            $this->Inscricao_model->update($this->input->post('inscricao_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('inscricao'));
        }
    }

    /*
    public function delete($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $row = $this->Inscricao_model->get_by_id($id);

        if ($row) {
            if (@$this->Inscricao_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('inscricao'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('inscricao'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('inscricao'));
        }
    }
*/
    public function _rules()
    {
        // PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->form_validation->set_rules('responsavel_nm', 'responsavel nm', 'trim|required');
        $this->form_validation->set_rules('responsavel_cpf', 'responsavel cpf', 'trim|required');
        $this->form_validation->set_rules('responsavel_email', 'responsavel email', 'trim|required');
        $this->form_validation->set_rules('mensagem', 'mensagem', 'trim|required');
        $this->form_validation->set_rules('dt_create', 'dt create', 'trim|required');
        $this->form_validation->set_rules('cnpj', 'cnpj', 'trim|required');
        $this->form_validation->set_rules('inscricao_municipio_id', 'inscricao municipio id', 'trim|required');
        $this->form_validation->set_rules('pessoa_id', 'pessoa id', 'trim|required');

        $this->form_validation->set_rules('inscricao_id', 'inscricao_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

        $param = array(

            array('responsavel_nm', '=', $this->input->post('responsavel_nm', TRUE)),
            array('responsavel_cpf', '=', $this->input->post('responsavel_cpf', TRUE)),
            array('responsavel_email', '=', $this->input->post('responsavel_email', TRUE)),
            array('mensagem', '=', $this->input->post('mensagem', TRUE)),
            array('dt_create', '=', $this->input->post('dt_create', TRUE)),
            array('cnpj', '=', $this->input->post('cnpj', TRUE)),
            array('inscricao_municipio_id', '=', $this->input->post('inscricao_municipio_id', TRUE)),
            array('pessoa_id', '=', $this->input->post('pessoa_id', TRUE)),
        ); //end array dos parametros

        $data = array(
            'inscricao_data' => $this->Inscricao_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('inscricao/Inscricao_pdf', $data, true);


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
            'action'        => site_url('inscricao/open_pdf'),
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


        $this->load->view('inscricao/Inscricao_report', forFrontVue($data));
    }


    public function ajax_valida_email_unico()
    {
        $responsavel_email = rupper(trim(urldecode($this->input->get('responsavel_email', TRUE))));
        $emails = $this->Inscricao_model->get_all_data_param("upper(responsavel_email) = '$responsavel_email'");

        if (count($emails) > 0) {
            echo json(array('situacao' => "email_ja_existe"));
            exit;
        }
        echo json(array('situacao' => "ok"));
    }

    public function ajax_verifica_duplicidade()
    {
        $responsavel_cpf = trim(urldecode($this->input->get('responsavel_cpf', TRUE)));
        $cnpj = trim(urldecode($this->input->get('cnpj', TRUE)));
        $responsavel_email = rupper(trim(urldecode($this->input->get('responsavel_email', TRUE))));

        $cpfs = $this->Inscricao_model->get_all_data_param("responsavel_cpf = '$responsavel_cpf'");
        // echo_pre($this->db->last_query());
        if (count($cpfs) > 0) {
            echo json(array('situacao' => "cpf_ja_existe"));
            exit;
        }

        $emails = $this->Inscricao_model->get_all_data_param("upper(responsavel_email) = '$responsavel_email'");
        $usuarios = $this->Usuario_model->get_all_data_param("upper(usuario_login) = '$responsavel_email'");
        //  echo_pre($this->db->last_query());
        if (count($emails) > 0 or count($usuarios) > 0) {
            echo json(array('situacao' => "email_ja_existe"));
            exit;
        }

        $cnpjs = $this->Inscricao_model->get_all_data_param("cnpj = '$cnpj'");
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

    private function inscricao_action($inscricao_id)
    {

        $is = $this->Inscricao_model->get_by_id($inscricao_id);

        $this->db->trans_start();


        try {
            // echo $this->input->post('inscricao_sipaf_status_id', TRUE);exit;

            $muni = $this->Municipio_model->get_by_id($is->inscricao_municipio_id);

            $data = array(
                'pessoa_nm' =>  trim(rupper($is->comprador_nm)),
                'pessoa_tipo' => 'F', // informação generica
                'pessoa_st' => 0,
                'flag_cadastro_externo' => 1,
                'cotacao_municipio_id' => $is->inscricao_municipio_id,
                'comprador_categoria_id' => $is->comprador_categoria_id,
                'pessoa_cnpj' => $is->cnpj,
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


            $data3 = array(
                'pessoa_id' => $pessoa_id,
                'funcionario_tipo_id' => 151, //COMPRADOR OU FORNECEDOR - COTACAO DE PRODUTOS
                'funcionario_email' => rupper(trim($is->responsavel_email))
            );
            $this->Funcionario_model->insert($data3);


            $senha = 'sdr' . rand(1000, 9999);
            $senhaMd5 = md5($senha);
            $data4 = array(
                'usuario_login' => rlower(trim($is->responsavel_email)),
                'usuario_senha' => $senhaMd5,
                'usuario_st' => 0,
                'pessoa_id' => $pessoa_id,
            );
            $this->Usuario_model->insert($data4);

            $data5 = array(
                'pessoa_id' => $pessoa_id,
                'tipo_usuario_id' => 443, //comprador
            );
            $this->Usuario_tipo_usuario_model->insert($data5);





            // $_SESSION['temp_login_sipaf_exibir'] = trim($is->responsavel_email);
            // $_SESSION['temp_senha_sipaf_exibir'] = md5('sdr');

           
           
            $msg = "<span style='text-align: justify; display: block;'>
                        Seja bem-vindo ao <b>Sistema de Cotações Rurais Bahia</b>, a plataforma desenvolvida para agilizar e dar mais transparência aos processos de cotação de preços dos produtos da agricultura familiar no Estado da Bahia.
                        <br><br>
                    </span>";
            $msg .= NOME_SISTEMA . ": <b>" . "<a href='https://www.portalsema.ba.gov.br/_portal/Intranet/usuario'> FAÇA SUA COTAÇÃO</a>" . "</b></br>";
            $msg .= "<br><br>";
            $msg .= "Login: <b>" . rlower(trim($is->responsavel_email)) . "</b><br>";
            $msg .= "Senha: <b>" . $senha . "</b><br>";
            $msg .= "<br>";
            $msg .= "<br>
            <br> 
                Boas cotações!
                <br>
                Equipe Cotações Rurais Bahia - SEMA";
            // $msg .= "Whatsapp para contato com a SUAF: (71) 9.8326-4604";
            // $this->manda_email($is->email = "riqueciano.macedo@sdr.ba.gov.br", $msg);
            $this->manda_email($is->responsavel_email, $msg);



            $data = array(
                'pessoa_id' => $pessoa_id
            );

            $this->Inscricao_model->update($inscricao_id, $data);
        } catch (Exception $e) {
            echo 'erro desconhecido, Favor solicitar <b class="red">POR E-MAIL</b> o cadastro manual para ser feito pela APG';
            $this->db->trans_rollback();
            exit;
        }

        $this->db->trans_complete();
    }

    private function manda_email($email, $msg)
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

        $this->email->to($email);

        $this->email->from("sistemas@sema.ba.gov.br", utf8_encode('SDR/COTAÇÃO'));
        $this->email->subject(utf8_encode("Cadastro realizado com Sucesso"));
        $this->email->message(utf8_encode($msg));

        //echo $msg;exit;


        $this->email->send();
    }
}

/* End of file Inscricao.php */
/* Local: ./application/controllers/Inscricao.php */
/* Gerado por RGenerator - 2024-01-23 20:43:13 */