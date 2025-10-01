<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pessoa extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Pessoa_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'pessoa/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'pessoa/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'pessoa/';
            $config['first_url'] = base_url() . 'pessoa/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Pessoa_model->total_rows($q);
        $pessoa = $this->Pessoa_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pessoa_data' => $pessoa,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('pessoa/Pessoa_list', $data);
    }

    public function read($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Pessoa_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('pessoa/create_action'),
                'pessoa_id' => $row->pessoa_id,
                'pessoa_nm' => $row->pessoa_nm,
                'pessoa_tipo' => $row->pessoa_tipo,
                'pessoa_email' => $row->pessoa_email,
                'pessoa_st' => $row->pessoa_st,
                'pessoa_dt_criacao' => $row->pessoa_dt_criacao,
                'pessoa_dt_alteracao' => $row->pessoa_dt_alteracao,
                'pessoa_usuario_criador' => $row->pessoa_usuario_criador,
                'setaf_id' => $row->setaf_id,
                'ater_contrato_id' => $row->ater_contrato_id,
                'lote_id' => $row->lote_id,
            );
            $this->load->view('pessoa/Pessoa_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pessoa'));
        }
    }

    public function create() {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('pessoa/create_action'),
            'pessoa_id' => set_value('pessoa_id'),
            'pessoa_nm' => set_value('pessoa_nm'),
            'pessoa_tipo' => set_value('pessoa_tipo'),
            'pessoa_email' => set_value('pessoa_email'),
            'pessoa_st' => set_value('pessoa_st'),
            'pessoa_dt_criacao' => set_value('pessoa_dt_criacao'),
            'pessoa_dt_alteracao' => set_value('pessoa_dt_alteracao'),
            'pessoa_usuario_criador' => set_value('pessoa_usuario_criador'),
            'setaf_id' => set_value('setaf_id'),
            'ater_contrato_id' => set_value('ater_contrato_id'),
            'lote_id' => set_value('lote_id'),
        );
        $this->load->view('pessoa/Pessoa_form', $data);
    }

    public function create_action() {
        $this->_rules();
        $this->form_validation->set_rules('pessoa_nm', NULL, 'trim|max_length[200]');
        $this->form_validation->set_rules('pessoa_tipo', NULL, 'trim|required|max_length[1]');
        $this->form_validation->set_rules('pessoa_email', NULL, 'trim|max_length[200]');
        $this->form_validation->set_rules('pessoa_st', NULL, 'trim|numeric');
        $this->form_validation->set_rules('pessoa_dt_criacao', NULL, 'trim');
        $this->form_validation->set_rules('pessoa_dt_alteracao', NULL, 'trim');
        $this->form_validation->set_rules('pessoa_usuario_criador', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('setaf_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('ater_contrato_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('lote_id', NULL, 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
                'pessoa_nm' => empty($this->input->post('pessoa_nm', TRUE)) ? NULL : $this->input->post('pessoa_nm', TRUE),
                'pessoa_tipo' => empty($this->input->post('pessoa_tipo', TRUE)) ? NULL : $this->input->post('pessoa_tipo', TRUE),
                'pessoa_email' => empty($this->input->post('pessoa_email', TRUE)) ? NULL : $this->input->post('pessoa_email', TRUE),
                'pessoa_st' => empty($this->input->post('pessoa_st', TRUE)) ? NULL : $this->input->post('pessoa_st', TRUE),
                'pessoa_dt_criacao' => empty($this->input->post('pessoa_dt_criacao', TRUE)) ? NULL : $this->input->post('pessoa_dt_criacao', TRUE),
                'pessoa_dt_alteracao' => empty($this->input->post('pessoa_dt_alteracao', TRUE)) ? NULL : $this->input->post('pessoa_dt_alteracao', TRUE),
                'pessoa_usuario_criador' => empty($this->input->post('pessoa_usuario_criador', TRUE)) ? NULL : $this->input->post('pessoa_usuario_criador', TRUE),
                'setaf_id' => empty($this->input->post('setaf_id', TRUE)) ? NULL : $this->input->post('setaf_id', TRUE),
                'ater_contrato_id' => empty($this->input->post('ater_contrato_id', TRUE)) ? NULL : $this->input->post('ater_contrato_id', TRUE),
                'lote_id' => empty($this->input->post('lote_id', TRUE)) ? NULL : $this->input->post('lote_id', TRUE),
            );

            $this->Pessoa_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('pessoa'));
        }
    }

    public function update($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Pessoa_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('pessoa/update_action'),
                'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
                'pessoa_nm' => set_value('pessoa_nm', $row->pessoa_nm),
                'pessoa_tipo' => set_value('pessoa_tipo', $row->pessoa_tipo),
                'pessoa_email' => set_value('pessoa_email', $row->pessoa_email),
                'pessoa_st' => set_value('pessoa_st', $row->pessoa_st),
                'pessoa_dt_criacao' => set_value('pessoa_dt_criacao', $row->pessoa_dt_criacao),
                'pessoa_dt_alteracao' => set_value('pessoa_dt_alteracao', $row->pessoa_dt_alteracao),
                'pessoa_usuario_criador' => set_value('pessoa_usuario_criador', $row->pessoa_usuario_criador),
                'setaf_id' => set_value('setaf_id', $row->setaf_id),
                'ater_contrato_id' => set_value('ater_contrato_id', $row->ater_contrato_id),
                'lote_id' => set_value('lote_id', $row->lote_id),
            );
            $this->load->view('pessoa/Pessoa_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('pessoa'));
        }
    }

    public function update_action() {
        $this->_rules();
        $this->form_validation->set_rules('pessoa_nm', 'pessoa_nm', 'trim|max_length[200]');
        $this->form_validation->set_rules('pessoa_tipo', 'pessoa_tipo', 'trim|required|max_length[1]');
        $this->form_validation->set_rules('pessoa_email', 'pessoa_email', 'trim|max_length[200]');
        $this->form_validation->set_rules('pessoa_st', 'pessoa_st', 'trim|numeric');
        $this->form_validation->set_rules('pessoa_dt_criacao', 'pessoa_dt_criacao', 'trim');
        $this->form_validation->set_rules('pessoa_dt_alteracao', 'pessoa_dt_alteracao', 'trim');
        $this->form_validation->set_rules('pessoa_usuario_criador', 'pessoa_usuario_criador', 'trim|required|integer');
        $this->form_validation->set_rules('setaf_id', 'setaf_id', 'trim|integer');
        $this->form_validation->set_rules('ater_contrato_id', 'ater_contrato_id', 'trim|integer');
        $this->form_validation->set_rules('lote_id', 'lote_id', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('pessoa_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
                'pessoa_nm' => empty($this->input->post('pessoa_nm', TRUE)) ? NULL : $this->input->post('pessoa_nm', TRUE),
                'pessoa_tipo' => empty($this->input->post('pessoa_tipo', TRUE)) ? NULL : $this->input->post('pessoa_tipo', TRUE),
                'pessoa_email' => empty($this->input->post('pessoa_email', TRUE)) ? NULL : $this->input->post('pessoa_email', TRUE),
                'pessoa_st' => empty($this->input->post('pessoa_st', TRUE)) ? NULL : $this->input->post('pessoa_st', TRUE),
                'pessoa_dt_criacao' => empty($this->input->post('pessoa_dt_criacao', TRUE)) ? NULL : $this->input->post('pessoa_dt_criacao', TRUE),
                'pessoa_dt_alteracao' => empty($this->input->post('pessoa_dt_alteracao', TRUE)) ? NULL : $this->input->post('pessoa_dt_alteracao', TRUE),
                'pessoa_usuario_criador' => empty($this->input->post('pessoa_usuario_criador', TRUE)) ? NULL : $this->input->post('pessoa_usuario_criador', TRUE),
                'setaf_id' => empty($this->input->post('setaf_id', TRUE)) ? NULL : $this->input->post('setaf_id', TRUE),
                'ater_contrato_id' => empty($this->input->post('ater_contrato_id', TRUE)) ? NULL : $this->input->post('ater_contrato_id', TRUE),
                'lote_id' => empty($this->input->post('lote_id', TRUE)) ? NULL : $this->input->post('lote_id', TRUE),
            );

            $this->Pessoa_model->update($this->input->post('pessoa_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('pessoa'));
        }
    }

    public function delete($id) {
        $row = $this->Pessoa_model->get_by_id($id);

        if ($row) {
            if (@$this->Pessoa_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('pessoa'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('pessoa'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('pessoa'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('pessoa_nm', 'pessoa nm', 'trim|required');
        $this->form_validation->set_rules('pessoa_tipo', 'pessoa tipo', 'trim|required');
        $this->form_validation->set_rules('pessoa_email', 'pessoa email', 'trim|required');
        $this->form_validation->set_rules('pessoa_st', 'pessoa st', 'trim|required');
        $this->form_validation->set_rules('pessoa_dt_criacao', 'pessoa dt criacao', 'trim|required');
        $this->form_validation->set_rules('pessoa_dt_alteracao', 'pessoa dt alteracao', 'trim|required');
        $this->form_validation->set_rules('pessoa_usuario_criador', 'pessoa usuario criador', 'trim|required');
        $this->form_validation->set_rules('setaf_id', 'setaf id', 'trim|required');
        $this->form_validation->set_rules('ater_contrato_id', 'ater contrato id', 'trim|required');
        $this->form_validation->set_rules('lote_id', 'lote id', 'trim|required');

        $this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function open_pdf() {

        $param = array(
            array('pessoa_nm', '=', $this->input->post('pessoa_nm', TRUE)),
            array('pessoa_tipo', '=', $this->input->post('pessoa_tipo', TRUE)),
            array('pessoa_email', '=', $this->input->post('pessoa_email', TRUE)),
            array('pessoa_st', '=', $this->input->post('pessoa_st', TRUE)),
            array('pessoa_dt_criacao', '=', $this->input->post('pessoa_dt_criacao', TRUE)),
            array('pessoa_dt_alteracao', '=', $this->input->post('pessoa_dt_alteracao', TRUE)),
            array('pessoa_usuario_criador', '=', $this->input->post('pessoa_usuario_criador', TRUE)),
            array('setaf_id', '=', $this->input->post('setaf_id', TRUE)),
            array('ater_contrato_id', '=', $this->input->post('ater_contrato_id', TRUE)),
            array('lote_id', '=', $this->input->post('lote_id', TRUE)),); //end array dos parametros

        $data = array(
            'pessoa_data' => $this->Pessoa_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html = $this->load->view('pessoa/Pessoa_pdf', $data, true);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $caminhoImg = CPATH . 'imagens/Topo/bg_logo_min.png';

        //cabeçalho
        $pdf->SetHTMLHeader(" 
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

    public function report() {

        $data = array(
            'button' => 'Gerar',
            'controller' => 'report',
            'action' => site_url('pessoa/open_pdf'),
            'recurso_id' => null,
            'recurso_nm' => null,
            'recurso_tombo' => null,
            'conservacao_id' => null,
            'setaf_id' => null,
            'localizacao' => null,
            'municipio_id' => null,
            'caminho' => null,
            'documento_id' => null,
            'requerente_id' => null,
        );


        $this->load->view('pessoa/Pessoa_report', $data);
    }

     public function muda_status(){
        $pessoa_id = (int)$this->input->get('pessoa_id', TRUE);
        $pessoa_st = $this->input->get('pessoa_st', TRUE);
        
        
        if($pessoa_st==0){
            $pessoa_st_novo = 1;
        }else if($pessoa_st==1){
            $pessoa_st_novo = 0;
        }
        
        //echo $pessoa_st;exit;
        $data = array(
                        'pessoa_st'=>$pessoa_st_novo,
        );
        
        $this->Pessoa_model->update($pessoa_id,$data);
        redirect(site_url('usuario'));
        
    }
}

/* End of file Pessoa.php */
/* Local: ./application/controllers/Pessoa.php */
/* Gerado por RGenerator - 2018-04-09 17:15:50 */