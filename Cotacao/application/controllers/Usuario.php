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
        $this->load->model('Usuario_tipo_usuario_model');
        $this->load->model('Pessoa_model');
        $this->load->library('form_validation');
    }

    public function index()
    {   
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $q = trim(urldecode($this->input->get('q', TRUE)));
        $start = intval($this->input->get('start'));
        $empresa_id = intval($this->input->get('empresa_id'));
        $lotacao_id = intval($this->input->get('lotacao_id'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'usuario/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'usuario/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'usuario/';
            $config['first_url'] = base_url() . 'usuario/';
        }

        $config['per_page'] = 10000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Usuario_model->total_rows($q);
        $param = '1=1';
        if (!empty($empresa_id)) {
            $param .= ' and pessoa.empresa_id = ' . $empresa_id;
        }
        if (!empty($lotacao_id)) {
            $param .= ' and pessoa.lotacao_id = ' . $lotacao_id;
        }
        if (!empty($q)) {
            $param .= " and (pessoa.pessoa_nm ilike '$q'";
            $param .= "       or empresa.empresa_nm  ilike '$q'";
            $param .= "       or lotacao.lotacao_nm  ilike '$q'";
            $param .= "       or usuario.usuario_login  ilike '$q'";
            $param .= " )";
        }
        // $usuario = $this->Usuario_model->get_limit_data($config['per_page'], $start, $q);
        $usuario = $this->Usuario_model->get_limit_data_param($param);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'usuario_data' => $usuario,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'empresa_id' => empty($empresa_id) ? 0 : $empresa_id,
            'lotacao_id' => empty($lotacao_id) ? 0 : $lotacao_id,
        );
        $this->load->view('usuario/Usuario_list', $data);
    }

    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
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

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('usuario/create_action'),
            'pessoa_id' => 0,
            'usuario_login' => set_value('usuario_login'),
            'usuario_senha' => set_value('usuario_senha'),
            'usuario_st' => set_value('usuario_st'),
            'usuario_dt_criacao' => set_value('usuario_dt_criacao'),
            'usuario_dt_alteracao' => set_value('usuario_dt_alteracao'),
            'usuario_primeiro_logon' => set_value('usuario_primeiro_logon'),
            'usuario_diaria' => set_value('usuario_diaria'),
            'usuario_login_st' => set_value('usuario_login_st'),
            'usuario_login_dt_alteracao' => set_value('usuario_login_dt_alteracao'),
            'usuario_login_alterador' => set_value('usuario_login_alterador'),
            'validade' => set_value('validade'),
            'flag_senha_nova' => set_value('flag_senha_nova'),
            'usuario_id' => set_value('usuario_id'),
            'sistema' => array(),
        );
        $this->load->view('usuario/Usuario_form', $data);
    }

    public function create_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->_rules();
        $this->form_validation->set_rules('usuario_login', 'NULL1', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('usuario_senha', 'NULL2', 'trim|required|max_length[9999]');
        $this->form_validation->set_rules('usuario_st', 'NULL3', 'trim|numeric');
        $this->form_validation->set_rules('usuario_primeiro_logon', 'NULL6', 'trim|numeric');
        $this->form_validation->set_rules('usuario_diaria', 'NULL7', 'trim|integer');
        $this->form_validation->set_rules('usuario_login_st', 'NULL8', 'trim|integer');
        $this->form_validation->set_rules('usuario_login_alterador', 'NUL10L', 'trim|integer');
        $this->form_validation->set_rules('validade', 'NULL11', 'trim');
        $this->form_validation->set_rules('flag_senha_nova', 'NULL12', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            // echo validation_errors();
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
                'usuario_login' =>      empty($this->input->post('usuario_login', TRUE)) ? NULL : $this->input->post('usuario_login', TRUE),
                'usuario_senha' =>     md5($this->input->post('usuario_senha', TRUE)),
                'usuario_st' =>      empty($this->input->post('usuario_st', TRUE)) ? NULL : $this->input->post('usuario_st', TRUE),
                'usuario_dt_criacao' =>      empty($this->input->post('usuario_dt_criacao', TRUE)) ? NULL : $this->input->post('usuario_dt_criacao', TRUE),
                'usuario_dt_alteracao' =>      empty($this->input->post('usuario_dt_alteracao', TRUE)) ? NULL : $this->input->post('usuario_dt_alteracao', TRUE),
                'usuario_primeiro_logon' =>      empty($this->input->post('usuario_primeiro_logon', TRUE)) ? NULL : $this->input->post('usuario_primeiro_logon', TRUE),
                'usuario_diaria' =>      empty($this->input->post('usuario_diaria', TRUE)) ? NULL : $this->input->post('usuario_diaria', TRUE),
                'usuario_login_st' =>      empty($this->input->post('usuario_login_st', TRUE)) ? NULL : $this->input->post('usuario_login_st', TRUE),
                // 'usuario_login_dt_alteracao' =>      date('Y-m-d'),
                'usuario_login_alterador' =>      empty($this->input->post('usuario_login_alterador', TRUE)) ? NULL : $this->input->post('usuario_login_alterador', TRUE),
                'validade' =>      empty($this->input->post('validade', TRUE)) ? NULL : $this->input->post('validade', TRUE),
                'flag_senha_nova' =>      empty($this->input->post('flag_senha_nova', TRUE)) ? NULL : $this->input->post('flag_senha_nova', TRUE),
                'pessoa_id' =>      $this->input->post('pessoa_id', TRUE),
                // 'usuario_id' =>      empty($this->input->post('usuario_id', TRUE)) ? NULL : $this->input->post('usuario_id', TRUE),
            );

            // print_r($data);exit;
            $this->Usuario_model->insert($data);
            $usuario_id = $this->Usuario_model->ultimo_id();

            $this->db->trans_complete();
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('usuario/update/' . $usuario_id));
        }
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);   
        $this->session->set_flashdata('message', '');
        $row = $this->Usuario_model->get_by_id($id);

        if ($row) {
            $sistema = $this->Sistema_model->get_all($row->pessoa_id);

            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'sistema' => $sistema,
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
                'usuario_id' => set_value('usuario_id', $row->usuario_id),
            );
            $this->load->view('usuario/Usuario_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('usuario'));
        }
    }



    public function adm_reseta_senha($usuario_id)
    {   
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);
        $this->session->set_flashdata('message', '');

        $usuario = $this->Usuario_model->get_by_id($usuario_id);
        $pessoa = $this->Pessoa_model->get_by_id($usuario->pessoa_id);
        if ($usuario) {
            $data = array(
                'button' => '',
                'controller' => 'adm_reseta_senha',
                'action' => site_url('usuario/adm_reseta_senha_action'),
                'pessoa_nm' => $pessoa->pessoa_nm,
                'usuario_login' => $usuario->usuario_login,
                'usuario_senha' => $usuario->usuario_senha,
                'usuario_st' => $usuario->usuario_st,
                'usuario_dt_criacao' => $usuario->usuario_dt_criacao,
                'usuario_dt_alteracao' => $usuario->usuario_dt_alteracao,
                'usuario_primeiro_logon' => $usuario->usuario_primeiro_logon,
                'usuario_diaria' => $usuario->usuario_diaria,
                'usuario_login_st' => $usuario->usuario_login_st,
                'usuario_login_dt_alteracao' => $usuario->usuario_login_dt_alteracao,
                'usuario_login_alterador' => $usuario->usuario_login_alterador,
                'validade' => $usuario->validade,
                'flag_senha_nova' => $usuario->flag_senha_nova,
                'usuario_id' => $usuario->usuario_id,
                'lotacao_nm' => rupper($pessoa->lotacao_nm),
                'empresa_nm' => rupper($pessoa->empresa_nm),
            );
            $this->load->view('usuario/Usuario_reseta_senha_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('usuario'));
        }
    }


    public function adm_reseta_senha_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);
        if (!empty($this->input->post('usuario_senha', TRUE))) {
            $data = array(
                'usuario_senha' => md5($this->input->post('usuario_senha', TRUE)),
            );
            $this->Usuario_model->update($this->input->post('usuario_id', TRUE), $data);
        }


        $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
        redirect(site_url('usuario'));
    }
    public function update_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->_rules();

        $data = array(
            'usuario_login' => empty($this->input->post('usuario_login', TRUE)) ? NULL : $this->input->post('usuario_login', TRUE),
            // 'usuario_senha' => empty($this->input->post('usuario_senha', TRUE)) ? NULL : $this->input->post('usuario_senha', TRUE),
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
            'pessoa_id' => empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
        );
        $this->Usuario_model->update($this->input->post('usuario_id', TRUE), $data);
        ################################################
        //se usuario informar senha no cadastro, substituir pela antiga
        // if(!empty($this->input->post('usuario_senha', TRUE))){
        //     $data = array(
        //         'usuario_senha' => md5($this->input->post('usuario_senha', TRUE)),
        //     );
        //     $this->Usuario_model->update($this->input->post('usuario_id', TRUE), $data); 
        // }
        ################################################
        $this->Usuario_tipo_usuario_model->delete_por_pessoa($this->input->post('pessoa_id', TRUE));
        foreach ($this->input->post('sistema_id[]', TRUE) as $key => $value) {
            $tipo_usuario_id = $this->input->post("tipo_usuario_id[$key]", TRUE);
            $usuario_super_secretaria = $this->input->post("usuario_super_secretaria[$key]", TRUE);
            if (!empty($tipo_usuario_id)) {
                $data = array(
                    'pessoa_id' => $this->input->post('pessoa_id', TRUE),
                    'tipo_usuario_id' => $tipo_usuario_id,
                    'usuario_super_secretaria' => $usuario_super_secretaria
                );
                $this->Usuario_tipo_usuario_model->insert($data);
            }
        }

        $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
        redirect(site_url('usuario'));
    }

    /*
    public function delete($id)
    {   
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $row = $this->Usuario_model->get_by_id($id);

        if ($row) {
            $this->db->trans_start();
            if (@$this->Usuario_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('usuario'));
            }
           
            $this->db->trans_complete();
            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('usuario'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('usuario'));
        }
    }
        */

    public function _rules()
    {   PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);

        $this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {   PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);

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
            array('flag_senha_nova', '=', $this->input->post('flag_senha_nova', TRUE)),
            array('usuario_id', '=', $this->input->post('usuario_id', TRUE)),
        ); //end array dos parametros

        $data = array(
            'usuario_data' => $this->Usuario_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('usuario/Usuario_pdf', $data, true);


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
    {   PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);

        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('usuario/open_pdf'),
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


        $this->load->view('usuario/Usuario_report', $data);
    }


    public function ativar_inativar($usuario_id)
    {   PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);
        $u = $this->Usuario_model->get_by_id($usuario_id);

        $situacao = $u->ativo;
        if ($u->ativo == 1) {
            $nova_situacao = 0;
        } else {
            $nova_situacao = 1;
        }
        $data = array(
            'ativo' => $nova_situacao
        );
        $this->Usuario_model->update($usuario_id, $data);
        redirect(site_url('usuario'));
    }
}

/* End of file Usuario.php */
/* Local: ./application/controllers/Usuario.php */
/* Gerado por RGenerator - 2020-01-14 13:40:42 */