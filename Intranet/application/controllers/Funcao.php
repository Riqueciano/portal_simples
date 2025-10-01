<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Funcao extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Funcao_model');
        $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'funcao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'funcao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'funcao/';
            $config['first_url'] = base_url() . 'funcao/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Funcao_model->total_rows($q);
        $funcao = $this->Funcao_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($funcao);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'funcao_data' => json($funcao),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('funcao/Funcao_list', $data);
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Funcao_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => '',
                'controller' => 'read',
                'action' => site_url('funcao/create_action'),
                'funcao_id' => $row->funcao_id,
                'funcao_ds' => $row->funcao_ds,
                'funcao_st' => $row->funcao_st,
                'funcao_dt_criacao' => $row->funcao_dt_criacao,
                'funcao_dt_alteracao' => $row->funcao_dt_alteracao,
            );
            $this->load->view('funcao/Funcao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('funcao'));
        }
    }

    public function create()
    {
        $data = array(

            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('funcao/create_action'),
            'funcao_id' => set_value('funcao_id'),
            'funcao_ds' => set_value('funcao_ds'),
            'funcao_st' => set_value('funcao_st'),
            'funcao_dt_criacao' => set_value('funcao_dt_criacao'),
            'funcao_dt_alteracao' => set_value('funcao_dt_alteracao'),
        );
        $this->load->view('funcao/Funcao_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('funcao_ds', NULL, 'trim|required|max_length[50]');
        $this->form_validation->set_rules('funcao_st', NULL, 'trim|numeric');
        $this->form_validation->set_rules('funcao_dt_criacao', NULL, 'trim');
        $this->form_validation->set_rules('funcao_dt_alteracao', NULL, 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'funcao_ds' =>      empty($this->input->post('funcao_ds', TRUE)) ? NULL : $this->input->post('funcao_ds', TRUE),
                'funcao_st' =>      empty($this->input->post('funcao_st', TRUE)) ? NULL : $this->input->post('funcao_st', TRUE),
                'funcao_dt_criacao' =>      empty($this->input->post('funcao_dt_criacao', TRUE)) ? NULL : $this->input->post('funcao_dt_criacao', TRUE),
                'funcao_dt_alteracao' =>      empty($this->input->post('funcao_dt_alteracao', TRUE)) ? NULL : $this->input->post('funcao_dt_alteracao', TRUE),
            );

            $this->Funcao_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('funcao'));
        }
    }

    public function update($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Funcao_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('funcao/update_action'),
                'funcao_id' => set_value('funcao_id', $row->funcao_id),
                'funcao_ds' => set_value('funcao_ds', $row->funcao_ds),
                'funcao_st' => set_value('funcao_st', $row->funcao_st),
                'funcao_dt_criacao' => set_value('funcao_dt_criacao', $row->funcao_dt_criacao),
                'funcao_dt_alteracao' => set_value('funcao_dt_alteracao', $row->funcao_dt_alteracao),
            );
            $this->load->view('funcao/Funcao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('funcao'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('funcao_ds', 'funcao_ds', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('funcao_st', 'funcao_st', 'trim|numeric');
        $this->form_validation->set_rules('funcao_dt_criacao', 'funcao_dt_criacao', 'trim');
        $this->form_validation->set_rules('funcao_dt_alteracao', 'funcao_dt_alteracao', 'trim');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('funcao_id', TRUE));
        } else {
            $data = array(
                'funcao_ds' => empty($this->input->post('funcao_ds', TRUE)) ? NULL : $this->input->post('funcao_ds', TRUE),
                'funcao_st' => empty($this->input->post('funcao_st', TRUE)) ? NULL : $this->input->post('funcao_st', TRUE),
                'funcao_dt_criacao' => empty($this->input->post('funcao_dt_criacao', TRUE)) ? NULL : $this->input->post('funcao_dt_criacao', TRUE),
                'funcao_dt_alteracao' => empty($this->input->post('funcao_dt_alteracao', TRUE)) ? NULL : $this->input->post('funcao_dt_alteracao', TRUE),
            );

            $this->Funcao_model->update($this->input->post('funcao_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('funcao'));
        }
    }

    public function delete($id)
    {
        $row = $this->Funcao_model->get_by_id($id);

        if ($row) {
            if (@$this->Funcao_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('funcao'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('funcao'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('funcao'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('funcao_ds', 'funcao ds', 'trim|required');
        $this->form_validation->set_rules('funcao_st', 'funcao st', 'trim|required');
        $this->form_validation->set_rules('funcao_dt_criacao', 'funcao dt criacao', 'trim|required');
        $this->form_validation->set_rules('funcao_dt_alteracao', 'funcao dt alteracao', 'trim|required');

        $this->form_validation->set_rules('funcao_id', 'funcao_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {

        $param = array(

            array('funcao_ds', '=', $this->input->post('funcao_ds', TRUE)),
            array('funcao_st', '=', $this->input->post('funcao_st', TRUE)),
            array('funcao_dt_criacao', '=', $this->input->post('funcao_dt_criacao', TRUE)),
            array('funcao_dt_alteracao', '=', $this->input->post('funcao_dt_alteracao', TRUE)),
        ); //end array dos parametros

        $data = array(
            'funcao_data' => $this->Funcao_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('funcao/Funcao_pdf', $data, true);


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

        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('funcao/open_pdf'),
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


        $this->load->view('funcao/Funcao_report', $data);
    }
}

/* End of file Funcao.php */
/* Local: ./application/controllers/Funcao.php */
/* Gerado por RGenerator - 2022-06-29 19:57:28 */