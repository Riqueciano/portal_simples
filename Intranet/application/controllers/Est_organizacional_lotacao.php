<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Est_organizacional_lotacao extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Est_organizacional_lotacao_model');
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
            $config['base_url']  = base_url() . 'est_organizacional_lotacao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'est_organizacional_lotacao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'est_organizacional_lotacao/';
            $config['first_url'] = base_url() . 'est_organizacional_lotacao/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Est_organizacional_lotacao_model->total_rows($q);
        $est_organizacional_lotacao = $this->Est_organizacional_lotacao_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($est_organizacional_lotacao);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'est_organizacional_lotacao_data' => json($est_organizacional_lotacao),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('est_organizacional_lotacao/Est_organizacional_lotacao_list', $data);
    }

    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Est_organizacional_lotacao_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => '',
                'controller' => 'read',
                'action' => site_url('est_organizacional_lotacao/create_action'),
                'est_organizacional_lotacao_id' => $row->est_organizacional_lotacao_id,
                'est_organizacional_lotacao_sup_cd' => $row->est_organizacional_lotacao_sup_cd,
                'est_organizacional_lotacao_ds' => $row->est_organizacional_lotacao_ds,
                'est_organizacional_lotacao_sigla' => $row->est_organizacional_lotacao_sigla,
                'est_organizacional_lotacao_st' => $row->est_organizacional_lotacao_st,
                'est_organizacional_lotacao_dt_criacao' => $row->est_organizacional_lotacao_dt_criacao,
                'est_organizacional_lotacao_dt_alteracao' => $row->est_organizacional_lotacao_dt_alteracao,
            );
            $this->load->view('est_organizacional_lotacao/Est_organizacional_lotacao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('est_organizacional_lotacao'));
        }
    }

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $data = array(

            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('est_organizacional_lotacao/create_action'),
            'est_organizacional_lotacao_id' => set_value('est_organizacional_lotacao_id'),
            'est_organizacional_lotacao_sup_cd' => set_value('est_organizacional_lotacao_sup_cd'),
            'est_organizacional_lotacao_ds' => set_value('est_organizacional_lotacao_ds'),
            'est_organizacional_lotacao_sigla' => set_value('est_organizacional_lotacao_sigla'),
            'est_organizacional_lotacao_st' => set_value('est_organizacional_lotacao_st'),
            'est_organizacional_lotacao_dt_criacao' => set_value('est_organizacional_lotacao_dt_criacao'),
            'est_organizacional_lotacao_dt_alteracao' => set_value('est_organizacional_lotacao_dt_alteracao'),
        );
        $this->load->view('est_organizacional_lotacao/Est_organizacional_lotacao_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('est_organizacional_lotacao_sup_cd', NULL, 'trim');
        $this->form_validation->set_rules('est_organizacional_lotacao_ds', NULL, 'trim|required|max_length[255]');
        $this->form_validation->set_rules('est_organizacional_lotacao_sigla', NULL, 'trim|required|max_length[80]');
        $this->form_validation->set_rules('est_organizacional_lotacao_st', NULL, 'trim|required|numeric');
        $this->form_validation->set_rules('est_organizacional_lotacao_dt_criacao', NULL, 'trim');
        $this->form_validation->set_rules('est_organizacional_lotacao_dt_alteracao', NULL, 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'est_organizacional_lotacao_sup_cd' =>      empty($this->input->post('est_organizacional_lotacao_sup_cd', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_sup_cd', TRUE),
                'est_organizacional_lotacao_ds' =>      empty($this->input->post('est_organizacional_lotacao_ds', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_ds', TRUE),
                'est_organizacional_lotacao_sigla' =>      empty($this->input->post('est_organizacional_lotacao_sigla', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_sigla', TRUE),
                'est_organizacional_lotacao_st' =>      empty($this->input->post('est_organizacional_lotacao_st', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_st', TRUE),
                'est_organizacional_lotacao_dt_criacao' =>      empty($this->input->post('est_organizacional_lotacao_dt_criacao', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_dt_criacao', TRUE),
                'est_organizacional_lotacao_dt_alteracao' =>      empty($this->input->post('est_organizacional_lotacao_dt_alteracao', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_dt_alteracao', TRUE),
            );

            $this->Est_organizacional_lotacao_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('est_organizacional_lotacao'));
        }
    }

    public function update($id)
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->session->set_flashdata('message', '');
        $row = $this->Est_organizacional_lotacao_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('est_organizacional_lotacao/update_action'),
                'est_organizacional_lotacao_id' => set_value('est_organizacional_lotacao_id', $row->est_organizacional_lotacao_id),
                'est_organizacional_lotacao_sup_cd' => set_value('est_organizacional_lotacao_sup_cd', $row->est_organizacional_lotacao_sup_cd),
                'est_organizacional_lotacao_ds' => set_value('est_organizacional_lotacao_ds', $row->est_organizacional_lotacao_ds),
                'est_organizacional_lotacao_sigla' => set_value('est_organizacional_lotacao_sigla', $row->est_organizacional_lotacao_sigla),
                'est_organizacional_lotacao_st' => set_value('est_organizacional_lotacao_st', $row->est_organizacional_lotacao_st),
                'est_organizacional_lotacao_dt_criacao' => set_value('est_organizacional_lotacao_dt_criacao', $row->est_organizacional_lotacao_dt_criacao),
                'est_organizacional_lotacao_dt_alteracao' => set_value('est_organizacional_lotacao_dt_alteracao', $row->est_organizacional_lotacao_dt_alteracao),
            );
            $this->load->view('est_organizacional_lotacao/Est_organizacional_lotacao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('est_organizacional_lotacao'));
        }
    }

    public function update_action()
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->_rules();
        $this->form_validation->set_rules('est_organizacional_lotacao_sup_cd', 'est_organizacional_lotacao_sup_cd', 'trim');
        $this->form_validation->set_rules('est_organizacional_lotacao_ds', 'est_organizacional_lotacao_ds', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('est_organizacional_lotacao_sigla', 'est_organizacional_lotacao_sigla', 'trim|required|max_length[80]');
        $this->form_validation->set_rules('est_organizacional_lotacao_st', 'est_organizacional_lotacao_st', 'trim|required|numeric');
        $this->form_validation->set_rules('est_organizacional_lotacao_dt_criacao', 'est_organizacional_lotacao_dt_criacao', 'trim');
        $this->form_validation->set_rules('est_organizacional_lotacao_dt_alteracao', 'est_organizacional_lotacao_dt_alteracao', 'trim');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('est_organizacional_lotacao_id', TRUE));
        } else {
            $data = array(
                'est_organizacional_lotacao_sup_cd' => empty($this->input->post('est_organizacional_lotacao_sup_cd', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_sup_cd', TRUE),
                'est_organizacional_lotacao_ds' => empty($this->input->post('est_organizacional_lotacao_ds', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_ds', TRUE),
                'est_organizacional_lotacao_sigla' => empty($this->input->post('est_organizacional_lotacao_sigla', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_sigla', TRUE),
                'est_organizacional_lotacao_st' => empty($this->input->post('est_organizacional_lotacao_st', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_st', TRUE),
                'est_organizacional_lotacao_dt_criacao' => empty($this->input->post('est_organizacional_lotacao_dt_criacao', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_dt_criacao', TRUE),
                'est_organizacional_lotacao_dt_alteracao' => empty($this->input->post('est_organizacional_lotacao_dt_alteracao', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_dt_alteracao', TRUE),
            );

            $this->Est_organizacional_lotacao_model->update($this->input->post('est_organizacional_lotacao_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('est_organizacional_lotacao'));
        }
    }

    public function delete($id)
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $row = $this->Est_organizacional_lotacao_model->get_by_id($id);

        if ($row) {
            if (@$this->Est_organizacional_lotacao_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('est_organizacional_lotacao'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('est_organizacional_lotacao'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('est_organizacional_lotacao'));
        }
    }

    public function _rules()
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->form_validation->set_rules('est_organizacional_lotacao_sup_cd', 'est organizacional lotacao sup cd', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_lotacao_ds', 'est organizacional lotacao ds', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_lotacao_sigla', 'est organizacional lotacao sigla', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_lotacao_st', 'est organizacional lotacao st', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_lotacao_dt_criacao', 'est organizacional lotacao dt criacao', 'trim|required');
        $this->form_validation->set_rules('est_organizacional_lotacao_dt_alteracao', 'est organizacional lotacao dt alteracao', 'trim|required');

        $this->form_validation->set_rules('est_organizacional_lotacao_id', 'est_organizacional_lotacao_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);

        $param = array(

            array('est_organizacional_lotacao_sup_cd', '=', $this->input->post('est_organizacional_lotacao_sup_cd', TRUE)),
            array('est_organizacional_lotacao_ds', '=', $this->input->post('est_organizacional_lotacao_ds', TRUE)),
            array('est_organizacional_lotacao_sigla', '=', $this->input->post('est_organizacional_lotacao_sigla', TRUE)),
            array('est_organizacional_lotacao_st', '=', $this->input->post('est_organizacional_lotacao_st', TRUE)),
            array('est_organizacional_lotacao_dt_criacao', '=', $this->input->post('est_organizacional_lotacao_dt_criacao', TRUE)),
            array('est_organizacional_lotacao_dt_alteracao', '=', $this->input->post('est_organizacional_lotacao_dt_alteracao', TRUE)),
        ); //end array dos parametros

        $data = array(
            'est_organizacional_lotacao_data' => $this->Est_organizacional_lotacao_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('est_organizacional_lotacao/Est_organizacional_lotacao_pdf', $data, true);


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
    {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);

        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('est_organizacional_lotacao/open_pdf'),
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


        $this->load->view('est_organizacional_lotacao/Est_organizacional_lotacao_report', $data);
    }
}

/* End of file Est_organizacional_lotacao.php */
/* Local: ./application/controllers/Est_organizacional_lotacao.php */
/* Gerado por RGenerator - 2022-06-29 20:08:06 */