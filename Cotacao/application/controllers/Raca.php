<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Raca extends CI_Controller
{
    function __construct()
    {
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        parent::__construct();
        exit;
        $this->load->model('Raca_model');
        $this->load->library('form_validation');
    }


    public function index()
    {

        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = (int)$this->input->get('start');



        $config['per_page'] = 30;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Raca_model->total_rows($q);
        $raca = $this->Raca_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($raca);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'raca_data' => json($raca),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('raca/Raca_list', forFrontVue($data));
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Raca_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => '',
                'controller' => 'read',
                'action' => site_url('raca/create_action'),
                'raca_id' => $row->raca_id,
                'raca_nm' => $row->raca_nm,
                'raca_nota' => $row->raca_nota,
            );
            $this->load->view('raca/Raca_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('raca'));
        }
    }

    public function create()
    {
        $data = array(

            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('raca/create_action'),
            'raca_id' => set_value('raca_id'),
            'raca_nm' => set_value('raca_nm'),
            'raca_nota' => set_value('raca_nota'),
        );
        $this->load->view('raca/Raca_form', forFrontVue($data));
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('raca_nm', NULL, 'trim|max_length[200]');
        $this->form_validation->set_rules('raca_nota', NULL, 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'raca_nm' =>      empty($this->input->post('raca_nm', TRUE)) ? NULL : $this->input->post('raca_nm', TRUE),
                'raca_nota' =>      empty($this->input->post('raca_nota', TRUE)) ? NULL : $this->input->post('raca_nota', TRUE),
            );

            $this->Raca_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('raca'));
        }
    }

    public function update($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Raca_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('raca/update_action'),
                'raca_id' => set_value('raca_id', $row->raca_id),
                'raca_nm' => set_value('raca_nm', $row->raca_nm),
                'raca_nota' => set_value('raca_nota', $row->raca_nota),
            );
            $this->load->view('raca/Raca_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('raca'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('raca_nm', 'raca_nm', 'trim|max_length[200]');
        $this->form_validation->set_rules('raca_nota', 'raca_nota', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('raca_id', TRUE));
        } else {
            $data = array(
                'raca_nm' => empty($this->input->post('raca_nm', TRUE)) ? NULL : $this->input->post('raca_nm', TRUE),
                'raca_nota' => empty($this->input->post('raca_nota', TRUE)) ? NULL : $this->input->post('raca_nota', TRUE),
            );

            $this->Raca_model->update($this->input->post('raca_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('raca'));
        }
    }

    public function delete($id)
    {
        $row = $this->Raca_model->get_by_id($id);

        if ($row) {
            if (@$this->Raca_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('raca'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('raca'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('raca'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('raca_nm', 'raca nm', 'trim|required');
        $this->form_validation->set_rules('raca_nota', 'raca nota', 'trim|required');

        $this->form_validation->set_rules('raca_id', 'raca_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {


        $param = array(

            array('raca_nm', '=', $this->input->post('raca_nm', TRUE)),
            array('raca_nota', '=', $this->input->post('raca_nota', TRUE)),
        ); //end array dos parametros

        $data = array(
            'raca_data' => $this->Raca_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('raca/Raca_pdf', $data, true);


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
            'action'        => site_url('raca/open_pdf'),
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


        $this->load->view('raca/Raca_report', forFrontVue($data));
    }
}

/* End of file Raca.php */
/* Local: ./application/controllers/Raca.php */
/* Gerado por RGenerator - 2025-03-24 20:09:02 */