<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Est_organizacional extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Est_organizacional_model');
        $this->load->model('Unidade_orcamentaria_model');
        $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    }

    public function index()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'est_organizacional/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'est_organizacional/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'est_organizacional/';
            $config['first_url'] = base_url() . 'est_organizacional/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Est_organizacional_model->total_rows($q);
        $est_organizacional = $this->Est_organizacional_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($est_organizacional);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'est_organizacional_data' => json($est_organizacional),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('est_organizacional/Est_organizacional_list', forFrontVue($data));
    }

    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Est_organizacional_model->get_by_id($id);
        $unidade_orcamentaria = $this->Unidade_orcamentaria_model->get_all_combobox();
        if ($row) {
            $data = array(
                'unidade_orcamentaria' => json($unidade_orcamentaria),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('est_organizacional/create_action'),
                'est_organizacional_id' => $row->est_organizacional_id,
                'est_organizacional_sup_cd' => $row->est_organizacional_sup_cd,
                'est_organizacional_ds' => $row->est_organizacional_ds,
                'est_organizacional_sigla' => $row->est_organizacional_sigla,
                'est_organizacional_st' => $row->est_organizacional_st,
                'est_organizacional_dt_criacao' => $row->est_organizacional_dt_criacao,
                'est_organizacional_dt_alteracao' => $row->est_organizacional_dt_alteracao,
                'est_organizacional_centro_custo' => $row->est_organizacional_centro_custo,
                'est_organizacional_centro_custo_num' => $row->est_organizacional_centro_custo_num,
                'est_organizacional_centro_custo_transporte' => $row->est_organizacional_centro_custo_transporte,
                'est_organizacional_centro_custo_acompanhamento' => $row->est_organizacional_centro_custo_acompanhamento,
                'est_organizacional_unidade_executora' => $row->est_organizacional_unidade_executora,
                'est_organizacional_centro_custo_material' => $row->est_organizacional_centro_custo_material,
                'est_organizacional_codigo_centro_custo_material' => $row->est_organizacional_codigo_centro_custo_material,
                'unidade_orcamentaria_id' => $row->unidade_orcamentaria_id,
                'grupo_diaria' => $row->grupo_diaria,
            );
            $this->load->view('est_organizacional/Est_organizacional_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('est_organizacional'));
        }
    }

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $unidade_orcamentaria = $this->Unidade_orcamentaria_model->get_all_combobox();
        $data = array(
            'unidade_orcamentaria' => json($unidade_orcamentaria),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('est_organizacional/create_action'),
            'est_organizacional_id' => set_value('est_organizacional_id'),
            'est_organizacional_sup_cd' => set_value('est_organizacional_sup_cd'),
            'est_organizacional_ds' => set_value('est_organizacional_ds'),
            'est_organizacional_sigla' => set_value('est_organizacional_sigla'),
            'est_organizacional_st' => set_value('est_organizacional_st'),
            'est_organizacional_dt_criacao' => set_value('est_organizacional_dt_criacao'),
            'est_organizacional_dt_alteracao' => set_value('est_organizacional_dt_alteracao'),
            'est_organizacional_centro_custo' => set_value('est_organizacional_centro_custo'),
            'est_organizacional_centro_custo_num' => set_value('est_organizacional_centro_custo_num'),
            'est_organizacional_centro_custo_transporte' => set_value('est_organizacional_centro_custo_transporte'),
            'est_organizacional_centro_custo_acompanhamento' => set_value('est_organizacional_centro_custo_acompanhamento'),
            'est_organizacional_unidade_executora' => set_value('est_organizacional_unidade_executora'),
            'est_organizacional_centro_custo_material' => set_value('est_organizacional_centro_custo_material'),
            'est_organizacional_codigo_centro_custo_material' => set_value('est_organizacional_codigo_centro_custo_material'),
            'unidade_orcamentaria_id' => set_value('unidade_orcamentaria_id'),
            'grupo_diaria' => set_value('grupo_diaria'),
        );
        $this->load->view('est_organizacional/Est_organizacional_form', forFrontVue($data));
    }

    public function create_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('est_organizacional_sup_cd', NULL, 'trim');
        $this->form_validation->set_rules('est_organizacional_ds', NULL, 'trim|required|max_length[255]');
        $this->form_validation->set_rules('est_organizacional_sigla', NULL, 'trim|required|max_length[50]');
        $this->form_validation->set_rules('est_organizacional_st', NULL, 'trim|required|numeric');
        $this->form_validation->set_rules('est_organizacional_dt_criacao', NULL, 'trim');
        $this->form_validation->set_rules('est_organizacional_dt_alteracao', NULL, 'trim');
        $this->form_validation->set_rules('est_organizacional_centro_custo', NULL, 'trim|numeric');
        $this->form_validation->set_rules('est_organizacional_centro_custo_num', NULL, 'trim|max_length[10]');
        $this->form_validation->set_rules('est_organizacional_centro_custo_transporte', NULL, 'trim|integer');
        $this->form_validation->set_rules('est_organizacional_centro_custo_acompanhamento', NULL, 'trim|integer');
        $this->form_validation->set_rules('est_organizacional_unidade_executora', NULL, 'trim|max_length[6]');
        $this->form_validation->set_rules('est_organizacional_centro_custo_material', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('est_organizacional_codigo_centro_custo_material', NULL, 'trim|required|max_length[11]');
        $this->form_validation->set_rules('unidade_orcamentaria_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('grupo_diaria', NULL, 'trim|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'est_organizacional_sup_cd' =>      empty($this->input->post('est_organizacional_sup_cd', TRUE)) ? NULL : $this->input->post('est_organizacional_sup_cd', TRUE),
                'est_organizacional_ds' =>      empty($this->input->post('est_organizacional_ds', TRUE)) ? NULL : $this->input->post('est_organizacional_ds', TRUE),
                'est_organizacional_sigla' =>      empty($this->input->post('est_organizacional_sigla', TRUE)) ? NULL : $this->input->post('est_organizacional_sigla', TRUE),
                'est_organizacional_st' =>      empty($this->input->post('est_organizacional_st', TRUE)) ? NULL : $this->input->post('est_organizacional_st', TRUE),
                'est_organizacional_dt_criacao' =>      empty($this->input->post('est_organizacional_dt_criacao', TRUE)) ? NULL : $this->input->post('est_organizacional_dt_criacao', TRUE),
                'est_organizacional_dt_alteracao' =>      empty($this->input->post('est_organizacional_dt_alteracao', TRUE)) ? NULL : $this->input->post('est_organizacional_dt_alteracao', TRUE),
                'est_organizacional_centro_custo' =>      empty($this->input->post('est_organizacional_centro_custo', TRUE)) ? NULL : $this->input->post('est_organizacional_centro_custo', TRUE),
                'est_organizacional_centro_custo_num' =>      empty($this->input->post('est_organizacional_centro_custo_num', TRUE)) ? NULL : $this->input->post('est_organizacional_centro_custo_num', TRUE),
                'est_organizacional_centro_custo_transporte' =>      empty($this->input->post('est_organizacional_centro_custo_transporte', TRUE)) ? NULL : $this->input->post('est_organizacional_centro_custo_transporte', TRUE),
                'est_organizacional_centro_custo_acompanhamento' =>      empty($this->input->post('est_organizacional_centro_custo_acompanhamento', TRUE)) ? NULL : $this->input->post('est_organizacional_centro_custo_acompanhamento', TRUE),
                'est_organizacional_unidade_executora' =>      empty($this->input->post('est_organizacional_unidade_executora', TRUE)) ? NULL : $this->input->post('est_organizacional_unidade_executora', TRUE),
                'est_organizacional_centro_custo_material' =>      empty($this->input->post('est_organizacional_centro_custo_material', TRUE)) ? NULL : $this->input->post('est_organizacional_centro_custo_material', TRUE),
                'est_organizacional_codigo_centro_custo_material' =>      empty($this->input->post('est_organizacional_codigo_centro_custo_material', TRUE)) ? NULL : $this->input->post('est_organizacional_codigo_centro_custo_material', TRUE),
                'unidade_orcamentaria_id' =>      empty($this->input->post('unidade_orcamentaria_id', TRUE)) ? NULL : $this->input->post('unidade_orcamentaria_id', TRUE),
                'grupo_diaria' =>      empty($this->input->post('grupo_diaria', TRUE)) ? NULL : $this->input->post('grupo_diaria', TRUE),
            );

            $this->Est_organizacional_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('est_organizacional'));
        }
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Est_organizacional_model->get_by_id($id);
        $unidade_orcamentaria = $this->Unidade_orcamentaria_model->get_all_combobox();
        if ($row) {
            $data = array(
                'unidade_orcamentaria' => json($unidade_orcamentaria),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('est_organizacional/update_action'),
                'est_organizacional_id' => set_value('est_organizacional_id', $row->est_organizacional_id),
                'est_organizacional_sup_cd' => set_value('est_organizacional_sup_cd', $row->est_organizacional_sup_cd),
                'est_organizacional_ds' => set_value('est_organizacional_ds', $row->est_organizacional_ds),
                'est_organizacional_sigla' => set_value('est_organizacional_sigla', $row->est_organizacional_sigla),
                'est_organizacional_st' => set_value('est_organizacional_st', $row->est_organizacional_st),
                'est_organizacional_dt_criacao' => set_value('est_organizacional_dt_criacao', $row->est_organizacional_dt_criacao),
                'est_organizacional_dt_alteracao' => set_value('est_organizacional_dt_alteracao', $row->est_organizacional_dt_alteracao),
                'est_organizacional_centro_custo' => set_value('est_organizacional_centro_custo', $row->est_organizacional_centro_custo),
                'est_organizacional_centro_custo_num' => set_value('est_organizacional_centro_custo_num', $row->est_organizacional_centro_custo_num),
                'est_organizacional_centro_custo_transporte' => set_value('est_organizacional_centro_custo_transporte', $row->est_organizacional_centro_custo_transporte),
                'est_organizacional_centro_custo_acompanhamento' => set_value('est_organizacional_centro_custo_acompanhamento', $row->est_organizacional_centro_custo_acompanhamento),
                'est_organizacional_unidade_executora' => set_value('est_organizacional_unidade_executora', $row->est_organizacional_unidade_executora),
                'est_organizacional_centro_custo_material' => set_value('est_organizacional_centro_custo_material', $row->est_organizacional_centro_custo_material),
                'est_organizacional_codigo_centro_custo_material' => set_value('est_organizacional_codigo_centro_custo_material', $row->est_organizacional_codigo_centro_custo_material),
                'unidade_orcamentaria_id' => set_value('unidade_orcamentaria_id', $row->unidade_orcamentaria_id),
                'grupo_diaria' => set_value('grupo_diaria', $row->grupo_diaria),
            );
            $this->load->view('est_organizacional/Est_organizacional_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('est_organizacional'));
        }
    }

    public function update_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('est_organizacional_sup_cd', 'est_organizacional_sup_cd', 'trim');
        $this->form_validation->set_rules('est_organizacional_ds', 'est_organizacional_ds', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('est_organizacional_sigla', 'est_organizacional_sigla', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('est_organizacional_st', 'est_organizacional_st', 'trim|required|numeric');
        $this->form_validation->set_rules('est_organizacional_dt_criacao', 'est_organizacional_dt_criacao', 'trim');
        $this->form_validation->set_rules('est_organizacional_dt_alteracao', 'est_organizacional_dt_alteracao', 'trim');
        $this->form_validation->set_rules('est_organizacional_centro_custo', 'est_organizacional_centro_custo', 'trim|numeric');
        $this->form_validation->set_rules('est_organizacional_centro_custo_num', 'est_organizacional_centro_custo_num', 'trim|max_length[10]');
        $this->form_validation->set_rules('est_organizacional_centro_custo_transporte', 'est_organizacional_centro_custo_transporte', 'trim|integer');
        $this->form_validation->set_rules('est_organizacional_centro_custo_acompanhamento', 'est_organizacional_centro_custo_acompanhamento', 'trim|integer');
        $this->form_validation->set_rules('est_organizacional_unidade_executora', 'est_organizacional_unidade_executora', 'trim|max_length[6]');
        $this->form_validation->set_rules('est_organizacional_centro_custo_material', 'est_organizacional_centro_custo_material', 'trim|required|integer');
        $this->form_validation->set_rules('est_organizacional_codigo_centro_custo_material', 'est_organizacional_codigo_centro_custo_material', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('unidade_orcamentaria_id', 'unidade_orcamentaria_id', 'trim|integer');
        $this->form_validation->set_rules('grupo_diaria', 'grupo_diaria', 'trim|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('est_organizacional_id', TRUE));
        } else {
            $data = array(
                'est_organizacional_sup_cd' => empty($this->input->post('est_organizacional_sup_cd', TRUE)) ? NULL : $this->input->post('est_organizacional_sup_cd', TRUE),
                'est_organizacional_ds' => empty($this->input->post('est_organizacional_ds', TRUE)) ? NULL : $this->input->post('est_organizacional_ds', TRUE),
                'est_organizacional_sigla' => empty($this->input->post('est_organizacional_sigla', TRUE)) ? NULL : $this->input->post('est_organizacional_sigla', TRUE),
                'est_organizacional_st' => empty($this->input->post('est_organizacional_st', TRUE)) ? NULL : $this->input->post('est_organizacional_st', TRUE),
                'est_organizacional_dt_criacao' => empty($this->input->post('est_organizacional_dt_criacao', TRUE)) ? NULL : $this->input->post('est_organizacional_dt_criacao', TRUE),
                'est_organizacional_dt_alteracao' => empty($this->input->post('est_organizacional_dt_alteracao', TRUE)) ? NULL : $this->input->post('est_organizacional_dt_alteracao', TRUE),
                'est_organizacional_centro_custo' => empty($this->input->post('est_organizacional_centro_custo', TRUE)) ? NULL : $this->input->post('est_organizacional_centro_custo', TRUE),
                'est_organizacional_centro_custo_num' => empty($this->input->post('est_organizacional_centro_custo_num', TRUE)) ? NULL : $this->input->post('est_organizacional_centro_custo_num', TRUE),
                'est_organizacional_centro_custo_transporte' => empty($this->input->post('est_organizacional_centro_custo_transporte', TRUE)) ? NULL : $this->input->post('est_organizacional_centro_custo_transporte', TRUE),
                'est_organizacional_centro_custo_acompanhamento' => empty($this->input->post('est_organizacional_centro_custo_acompanhamento', TRUE)) ? NULL : $this->input->post('est_organizacional_centro_custo_acompanhamento', TRUE),
                'est_organizacional_unidade_executora' => empty($this->input->post('est_organizacional_unidade_executora', TRUE)) ? NULL : $this->input->post('est_organizacional_unidade_executora', TRUE),
                'est_organizacional_centro_custo_material' => empty($this->input->post('est_organizacional_centro_custo_material', TRUE)) ? NULL : $this->input->post('est_organizacional_centro_custo_material', TRUE),
                'est_organizacional_codigo_centro_custo_material' => empty($this->input->post('est_organizacional_codigo_centro_custo_material', TRUE)) ? NULL : $this->input->post('est_organizacional_codigo_centro_custo_material', TRUE),
                'unidade_orcamentaria_id' => empty($this->input->post('unidade_orcamentaria_id', TRUE)) ? NULL : $this->input->post('unidade_orcamentaria_id', TRUE),
                'grupo_diaria' => empty($this->input->post('grupo_diaria', TRUE)) ? NULL : $this->input->post('grupo_diaria', TRUE),
            );

            $this->Est_organizacional_model->update($this->input->post('est_organizacional_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('est_organizacional'));
        }
    }

    public function delete($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $row = $this->Est_organizacional_model->get_by_id($id);

        if ($row) {
            if (@$this->Est_organizacional_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('est_organizacional'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('est_organizacional'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('est_organizacional'));
        }
    }

    public function _rules()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->form_validation->set_rules('est_organizacional_sup_cd', 'est organizacional sup cd', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_ds', 'est organizacional ds', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_sigla', 'est organizacional sigla', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_st', 'est organizacional st', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_dt_criacao', 'est organizacional dt criacao', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_dt_alteracao', 'est organizacional dt alteracao', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_centro_custo', 'est organizacional centro custo', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_centro_custo_num', 'est organizacional centro custo num', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_centro_custo_transporte', 'est organizacional centro custo transporte', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_centro_custo_acompanhamento', 'est organizacional centro custo acompanhamento', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_unidade_executora', 'est organizacional unidade executora', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_centro_custo_material', 'est organizacional centro custo material', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_codigo_centro_custo_material', 'est organizacional codigo centro custo material', 'trim|required');
        $this->form_validation->set_rules('unidade_orcamentaria_id', 'unidade orcamentaria id', 'trim|required');
        $this->form_validation->set_rules('grupo_diaria', 'grupo diaria', 'trim|required');

        $this->form_validation->set_rules('est_organizacional_id', 'est_organizacional_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

        $param = array(

            array('est_organizacional_sup_cd', '=', $this->input->post('est_organizacional_sup_cd', TRUE)),
            array('est_organizacional_ds', '=', $this->input->post('est_organizacional_ds', TRUE)),
            array('est_organizacional_sigla', '=', $this->input->post('est_organizacional_sigla', TRUE)),
            array('est_organizacional_st', '=', $this->input->post('est_organizacional_st', TRUE)),
            array('est_organizacional_dt_criacao', '=', $this->input->post('est_organizacional_dt_criacao', TRUE)),
            array('est_organizacional_dt_alteracao', '=', $this->input->post('est_organizacional_dt_alteracao', TRUE)),
            array('est_organizacional_centro_custo', '=', $this->input->post('est_organizacional_centro_custo', TRUE)),
            array('est_organizacional_centro_custo_num', '=', $this->input->post('est_organizacional_centro_custo_num', TRUE)),
            array('est_organizacional_centro_custo_transporte', '=', $this->input->post('est_organizacional_centro_custo_transporte', TRUE)),
            array('est_organizacional_centro_custo_acompanhamento', '=', $this->input->post('est_organizacional_centro_custo_acompanhamento', TRUE)),
            array('est_organizacional_unidade_executora', '=', $this->input->post('est_organizacional_unidade_executora', TRUE)),
            array('est_organizacional_centro_custo_material', '=', $this->input->post('est_organizacional_centro_custo_material', TRUE)),
            array('est_organizacional_codigo_centro_custo_material', '=', $this->input->post('est_organizacional_codigo_centro_custo_material', TRUE)),
            array('unidade_orcamentaria_id', '=', $this->input->post('unidade_orcamentaria_id', TRUE)),
            array('grupo_diaria', '=', $this->input->post('grupo_diaria', TRUE)),
        ); //end array dos parametros

        $data = array(
            'est_organizacional_data' => $this->Est_organizacional_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('est_organizacional/Est_organizacional_pdf', $data, true);


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
            'action'        => site_url('est_organizacional/open_pdf'),
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


        $this->load->view('est_organizacional/Est_organizacional_report', forFrontVue($data));
    }
}

/* End of file Est_organizacional.php */
/* Local: ./application/controllers/Est_organizacional.php */
/* Gerado por RGenerator - 2024-01-24 13:26:04 */