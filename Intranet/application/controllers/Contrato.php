<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contrato extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Contrato_model');
        $this->load->model('Pessoa_juridica_model');

        $this->load->model('Contrato_tipo_model');
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
            $config['base_url']  = base_url() . 'contrato/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'contrato/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'contrato/';
            $config['first_url'] = base_url() . 'contrato/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Contrato_model->total_rows($q);
        $contrato = $this->Contrato_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($contrato);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'contrato_data' => json($contrato),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('contrato/Contrato_list', $data);
    }

    public function read($id)
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->session->set_flashdata('message', '');
        $row = $this->Contrato_model->get_by_id($id);
        $pessoa_juridica = $this->Pessoa_juridica_model->get_all_combobox();
        $contrato_tipo = $this->Contrato_tipo_model->get_all_combobox();
        if ($row) {
            $data = array(
                'pessoa_juridica' => json($pessoa_juridica),
                'contrato_tipo' => json($contrato_tipo),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('contrato/create_action'),
                'contrato_id' => $row->contrato_id,
                'pessoa_id' => $row->pessoa_id,
                'contrato_num' => $row->contrato_num,
                'contrato_ds' => $row->contrato_ds,
                'contrato_dt_inicio' => $row->contrato_dt_inicio,
                'contrato_dt_termino' => $row->contrato_dt_termino,
                'contrato_valor' => $row->contrato_valor,
                'contrato_st' => $row->contrato_st,
                'contrato_dt_criacao' => $row->contrato_dt_criacao,
                'contrato_dt_alteracao' => $row->contrato_dt_alteracao,
                'contrato_num_max' => $row->contrato_num_max,
                'contrato_tipo_id' => $row->contrato_tipo_id,
            );
            $this->load->view('contrato/Contrato_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('contrato'));
        }
    }

    public function create()
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $pessoa_juridica = $this->Pessoa_juridica_model->get_all_combobox();
        $contrato_tipo = $this->Contrato_tipo_model->get_all_combobox();
        $data = array(
            'pessoa_juridica' => json($pessoa_juridica),
            'contrato_tipo' => json($contrato_tipo),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('contrato/create_action'),
            'contrato_id' => set_value('contrato_id'),
            'pessoa_id' => set_value('pessoa_id'),
            'contrato_num' => set_value('contrato_num'),
            'contrato_ds' => set_value('contrato_ds'),
            'contrato_dt_inicio' => set_value('contrato_dt_inicio'),
            'contrato_dt_termino' => set_value('contrato_dt_termino'),
            'contrato_valor' => set_value('contrato_valor'),
            'contrato_st' => set_value('contrato_st'),
            'contrato_dt_criacao' => set_value('contrato_dt_criacao'),
            'contrato_dt_alteracao' => set_value('contrato_dt_alteracao'),
            'contrato_num_max' => set_value('contrato_num_max'),
            'contrato_tipo_id' => set_value('contrato_tipo_id'),
        );
        $this->load->view('contrato/Contrato_form', $data);
    }

    public function create_action()
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->_rules();
        $this->form_validation->set_rules('pessoa_id', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('contrato_num', NULL, 'trim|max_length[10]');
        $this->form_validation->set_rules('contrato_ds', NULL, 'trim|max_length[200]');
        $this->form_validation->set_rules('contrato_dt_inicio', NULL, 'trim|max_length[10]');
        $this->form_validation->set_rules('contrato_dt_termino', NULL, 'trim|max_length[10]');
        $this->form_validation->set_rules('contrato_valor', NULL, 'trim|max_length[15]');
        $this->form_validation->set_rules('contrato_st', NULL, 'trim|numeric');
        $this->form_validation->set_rules('contrato_dt_criacao', NULL, 'trim');
        $this->form_validation->set_rules('contrato_dt_alteracao', NULL, 'trim');
        $this->form_validation->set_rules('contrato_num_max', NULL, 'trim');
        $this->form_validation->set_rules('contrato_tipo_id', NULL, 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'pessoa_id' =>      empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
                'contrato_num' =>      empty($this->input->post('contrato_num', TRUE)) ? NULL : $this->input->post('contrato_num', TRUE),
                'contrato_ds' =>      empty($this->input->post('contrato_ds', TRUE)) ? NULL : $this->input->post('contrato_ds', TRUE),
                'contrato_dt_inicio' =>      empty($this->input->post('contrato_dt_inicio', TRUE)) ? NULL : $this->input->post('contrato_dt_inicio', TRUE),
                'contrato_dt_termino' =>      empty($this->input->post('contrato_dt_termino', TRUE)) ? NULL : $this->input->post('contrato_dt_termino', TRUE),
                'contrato_valor' =>      empty($this->input->post('contrato_valor', TRUE)) ? NULL : $this->input->post('contrato_valor', TRUE),
                'contrato_st' =>      empty($this->input->post('contrato_st', TRUE)) ? NULL : $this->input->post('contrato_st', TRUE),
                'contrato_dt_criacao' =>      empty($this->input->post('contrato_dt_criacao', TRUE)) ? NULL : $this->input->post('contrato_dt_criacao', TRUE),
                'contrato_dt_alteracao' =>      empty($this->input->post('contrato_dt_alteracao', TRUE)) ? NULL : $this->input->post('contrato_dt_alteracao', TRUE),
                'contrato_num_max' =>      empty($this->input->post('contrato_num_max', TRUE)) ? NULL : $this->input->post('contrato_num_max', TRUE),
                'contrato_tipo_id' =>      empty($this->input->post('contrato_tipo_id', TRUE)) ? NULL : $this->input->post('contrato_tipo_id', TRUE),
            );

            $this->Contrato_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('contrato'));
        }
    }

    public function update($id)
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->session->set_flashdata('message', '');
        $row = $this->Contrato_model->get_by_id($id);
        $pessoa_juridica = $this->Pessoa_juridica_model->get_all_combobox();
        $contrato_tipo = $this->Contrato_tipo_model->get_all_combobox();
        if ($row) {
            $data = array(
                'pessoa_juridica' => json($pessoa_juridica),
                'contrato_tipo' => json($contrato_tipo),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('contrato/update_action'),
                'contrato_id' => set_value('contrato_id', $row->contrato_id),
                'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
                'contrato_num' => set_value('contrato_num', $row->contrato_num),
                'contrato_ds' => set_value('contrato_ds', $row->contrato_ds),
                'contrato_dt_inicio' => set_value('contrato_dt_inicio', $row->contrato_dt_inicio),
                'contrato_dt_termino' => set_value('contrato_dt_termino', $row->contrato_dt_termino),
                'contrato_valor' => set_value('contrato_valor', $row->contrato_valor),
                'contrato_st' => set_value('contrato_st', $row->contrato_st),
                'contrato_dt_criacao' => set_value('contrato_dt_criacao', $row->contrato_dt_criacao),
                'contrato_dt_alteracao' => set_value('contrato_dt_alteracao', $row->contrato_dt_alteracao),
                'contrato_num_max' => set_value('contrato_num_max', $row->contrato_num_max),
                'contrato_tipo_id' => set_value('contrato_tipo_id', $row->contrato_tipo_id),
            );
            $this->load->view('contrato/Contrato_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('contrato'));
        }
    }

    public function update_action()
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->_rules();
        $this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim|required|integer');
        $this->form_validation->set_rules('contrato_num', 'contrato_num', 'trim|max_length[10]');
        $this->form_validation->set_rules('contrato_ds', 'contrato_ds', 'trim|max_length[200]');
        $this->form_validation->set_rules('contrato_dt_inicio', 'contrato_dt_inicio', 'trim|max_length[10]');
        $this->form_validation->set_rules('contrato_dt_termino', 'contrato_dt_termino', 'trim|max_length[10]');
        $this->form_validation->set_rules('contrato_valor', 'contrato_valor', 'trim|max_length[15]');
        $this->form_validation->set_rules('contrato_st', 'contrato_st', 'trim|numeric');
        $this->form_validation->set_rules('contrato_dt_criacao', 'contrato_dt_criacao', 'trim');
        $this->form_validation->set_rules('contrato_dt_alteracao', 'contrato_dt_alteracao', 'trim');
        $this->form_validation->set_rules('contrato_num_max', 'contrato_num_max', 'trim');
        $this->form_validation->set_rules('contrato_tipo_id', 'contrato_tipo_id', 'trim');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('contrato_id', TRUE));
        } else {
            $data = array(
                'pessoa_id' => empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
                'contrato_num' => empty($this->input->post('contrato_num', TRUE)) ? NULL : $this->input->post('contrato_num', TRUE),
                'contrato_ds' => empty($this->input->post('contrato_ds', TRUE)) ? NULL : $this->input->post('contrato_ds', TRUE),
                'contrato_dt_inicio' => empty($this->input->post('contrato_dt_inicio', TRUE)) ? NULL : $this->input->post('contrato_dt_inicio', TRUE),
                'contrato_dt_termino' => empty($this->input->post('contrato_dt_termino', TRUE)) ? NULL : $this->input->post('contrato_dt_termino', TRUE),
                'contrato_valor' => empty($this->input->post('contrato_valor', TRUE)) ? NULL : $this->input->post('contrato_valor', TRUE),
                'contrato_st' => empty($this->input->post('contrato_st', TRUE)) ? NULL : $this->input->post('contrato_st', TRUE),
                'contrato_dt_criacao' => empty($this->input->post('contrato_dt_criacao', TRUE)) ? NULL : $this->input->post('contrato_dt_criacao', TRUE),
                'contrato_dt_alteracao' => empty($this->input->post('contrato_dt_alteracao', TRUE)) ? NULL : $this->input->post('contrato_dt_alteracao', TRUE),
                'contrato_num_max' => empty($this->input->post('contrato_num_max', TRUE)) ? NULL : $this->input->post('contrato_num_max', TRUE),
                'contrato_tipo_id' => empty($this->input->post('contrato_tipo_id', TRUE)) ? NULL : $this->input->post('contrato_tipo_id', TRUE),
            );

            $this->Contrato_model->update($this->input->post('contrato_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('contrato'));
        }
    }

    public function delete($id)
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $row = $this->Contrato_model->get_by_id($id);

        if ($row) {
            if (@$this->Contrato_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('contrato'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('contrato'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('contrato'));
        }
    }

    public function _rules()
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->form_validation->set_rules('pessoa_id', 'pessoa id', 'trim|required');
        $this->form_validation->set_rules('contrato_num', 'contrato num', 'trim|required');
        $this->form_validation->set_rules('contrato_ds', 'contrato ds', 'trim|required');
        $this->form_validation->set_rules('contrato_dt_inicio', 'contrato dt inicio', 'trim|required');
        $this->form_validation->set_rules('contrato_dt_termino', 'contrato dt termino', 'trim|required');
        $this->form_validation->set_rules('contrato_valor', 'contrato valor', 'trim|required');
        $this->form_validation->set_rules('contrato_st', 'contrato st', 'trim|required');
        $this->form_validation->set_rules('contrato_dt_criacao', 'contrato dt criacao', 'trim|required');
        $this->form_validation->set_rules('contrato_dt_alteracao', 'contrato dt alteracao', 'trim|required');
        $this->form_validation->set_rules('contrato_num_max', 'contrato num max', 'trim|required');
        $this->form_validation->set_rules('contrato_tipo_id', 'contrato tipo id', 'trim|required');

        $this->form_validation->set_rules('contrato_id', 'contrato_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $param = array(

            array('pessoa_id', '=', $this->input->post('pessoa_id', TRUE)),
            array('contrato_num', '=', $this->input->post('contrato_num', TRUE)),
            array('contrato_ds', '=', $this->input->post('contrato_ds', TRUE)),
            array('contrato_dt_inicio', '=', $this->input->post('contrato_dt_inicio', TRUE)),
            array('contrato_dt_termino', '=', $this->input->post('contrato_dt_termino', TRUE)),
            array('contrato_valor', '=', $this->input->post('contrato_valor', TRUE)),
            array('contrato_st', '=', $this->input->post('contrato_st', TRUE)),
            array('contrato_dt_criacao', '=', $this->input->post('contrato_dt_criacao', TRUE)),
            array('contrato_dt_alteracao', '=', $this->input->post('contrato_dt_alteracao', TRUE)),
            array('contrato_num_max', '=', $this->input->post('contrato_num_max', TRUE)),
            array('contrato_tipo_id', '=', $this->input->post('contrato_tipo_id', TRUE)),
        ); //end array dos parametros

        $data = array(
            'contrato_data' => $this->Contrato_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('contrato/Contrato_pdf', $data, true);


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
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('contrato/open_pdf'),
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


        $this->load->view('contrato/Contrato_report', $data);
    }
}

/* End of file Contrato.php */
/* Local: ./application/controllers/Contrato.php */
/* Gerado por RGenerator - 2022-06-29 20:06:57 */