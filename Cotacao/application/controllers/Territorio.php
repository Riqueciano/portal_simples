<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Territorio extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Territorio_model');
        $this->load->library('form_validation');
    }







    public function ajax_carrega_nome_territorio()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor','Nutricionista']);
        $territorio_id = $this->input->get('territorio_id', TRUE);
        $territorio = $this->Territorio_model->get_by_id($territorio_id);
        if ($territorio) {
            $data = array(
                'territorio_nm' => $territorio->territorio_nm,
            );
            echo json($data);
        } else {
            echo json(array());
        }
    }

    
    public function index()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'territorio/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'territorio/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'territorio/';
            $config['first_url'] = base_url() . 'territorio/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Territorio_model->total_rows($q);
        $territorio = $this->Territorio_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($territorio);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'territorio_data' => json($territorio),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('territorio/Territorio_list', forFrontVue($data));
    }

    public function read($id)
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->session->set_flashdata('message', '');
        $row = $this->Territorio_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => '',
                'controller' => 'read',
                'action' => site_url('territorio/create_action'),
                'territorio_id' => $row->territorio_id,
                'territorio_nm' => $row->territorio_nm,
                'territorio_st' => $row->territorio_st,
                'territorio_cd' => $row->territorio_cd,
            );
            $this->load->view('territorio/Territorio_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('territorio'));
        }
    }

    public function create()
    {   PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $data = array(

            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('territorio/create_action'),
            'territorio_id' => set_value('territorio_id'),
            'territorio_nm' => set_value('territorio_nm'),
            'territorio_st' => set_value('territorio_st'),
            'territorio_cd' => set_value('territorio_cd'),
        );
        $this->load->view('territorio/Territorio_form', forFrontVue($data));
    }

    public function create_action()
    {   PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->_rules();
        $this->form_validation->set_rules('territorio_nm', NULL, 'trim|max_length[150]');
        $this->form_validation->set_rules('territorio_st', NULL, 'trim|integer');
        $this->form_validation->set_rules('territorio_cd', NULL, 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'territorio_nm' =>      empty($this->input->post('territorio_nm', TRUE)) ? NULL : $this->input->post('territorio_nm', TRUE),
                'territorio_st' =>      empty($this->input->post('territorio_st', TRUE)) ? NULL : $this->input->post('territorio_st', TRUE),
                'territorio_cd' =>      empty($this->input->post('territorio_cd', TRUE)) ? NULL : $this->input->post('territorio_cd', TRUE),
            );

            $this->Territorio_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('territorio'));
        }
    }

    public function update($id)
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->session->set_flashdata('message', '');
        $row = $this->Territorio_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('territorio/update_action'),
                'territorio_id' => set_value('territorio_id', $row->territorio_id),
                'territorio_nm' => set_value('territorio_nm', $row->territorio_nm),
                'territorio_st' => set_value('territorio_st', $row->territorio_st),
                'territorio_cd' => set_value('territorio_cd', $row->territorio_cd),
            );
            $this->load->view('territorio/Territorio_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('territorio'));
        }
    }

    public function update_action()
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->_rules();
        $this->form_validation->set_rules('territorio_nm', 'territorio_nm', 'trim|max_length[150]');
        $this->form_validation->set_rules('territorio_st', 'territorio_st', 'trim|integer');
        $this->form_validation->set_rules('territorio_cd', 'territorio_cd', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('territorio_id', TRUE));
        } else {
            $data = array(
                'territorio_nm' => empty($this->input->post('territorio_nm', TRUE)) ? NULL : $this->input->post('territorio_nm', TRUE),
                'territorio_st' => empty($this->input->post('territorio_st', TRUE)) ? NULL : $this->input->post('territorio_st', TRUE),
                'territorio_cd' => empty($this->input->post('territorio_cd', TRUE)) ? NULL : $this->input->post('territorio_cd', TRUE),
            );

            $this->Territorio_model->update($this->input->post('territorio_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('territorio'));
        }
    }

    /*
    public function delete($id)
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);  
        $row = $this->Territorio_model->get_by_id($id);

        if ($row) {
            if (@$this->Territorio_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('territorio'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('territorio'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('territorio'));
        }
    }]
    */

    public function _rules()
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->form_validation->set_rules('territorio_nm', 'territorio nm', 'trim|required');
        $this->form_validation->set_rules('territorio_st', 'territorio st', 'trim|required');
        $this->form_validation->set_rules('territorio_cd', 'territorio cd', 'trim|required');

        $this->form_validation->set_rules('territorio_id', 'territorio_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $param = array(

            array('territorio_nm', '=', $this->input->post('territorio_nm', TRUE)),
            array('territorio_st', '=', $this->input->post('territorio_st', TRUE)),
            array('territorio_cd', '=', $this->input->post('territorio_cd', TRUE)),
        ); //end array dos parametros

        $data = array(
            'territorio_data' => $this->Territorio_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('territorio/Territorio_pdf', $data, true);


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
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);

        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('territorio/open_pdf'),
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


        $this->load->view('territorio/Territorio_report', forFrontVue($data));
    }
}

/* End of file Territorio.php */
/* Local: ./application/controllers/Territorio.php */
/* Gerado por RGenerator - 2022-09-05 18:20:01 */