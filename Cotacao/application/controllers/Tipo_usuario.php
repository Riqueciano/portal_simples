<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tipo_usuario extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tipo_usuario_model');
        $this->load->library('form_validation');
    }

    public function index()
    {   PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        $filtro_sistema_id = intval($this->input->get('filtro_sistema_id'));

        //filtro obrigatorio devido a demora da consulta
        $filtro_sistema_id = empty($filtro_sistema_id) ? 9999999999999 : $filtro_sistema_id;

        if ($q <> '') {
            $config['base_url']  = base_url() . 'tipo_usuario/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'tipo_usuario/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'tipo_usuario/';
            $config['first_url'] = base_url() . 'tipo_usuario/';
        }

        $config['per_page'] = 1000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tipo_usuario_model->total_rows($q);
        $tipo_usuario = $this->Tipo_usuario_model->get_limit_data($config['per_page'], $start, $q, $filtro_sistema_id);

        foreach ($tipo_usuario as $key => $tu) {
            $tu->usuarios = $this->Tipo_usuario_model->get_pessoa_perfil($tu->tipo_usuario_id);
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tipo_usuario_data' => $tipo_usuario,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'filtro_sistema_id' => $filtro_sistema_id,
        );
        $this->load->view('tipo_usuario/Tipo_usuario_list', $data);
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Tipo_usuario_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('tipo_usuario/create_action'),
                'tipo_usuario_id' => $row->tipo_usuario_id,
                'tipo_usuario_ds' => $row->tipo_usuario_ds,
                'tipo_usuario_st' => $row->tipo_usuario_st,
                'sistema_id_correto' => $row->sistema_id,
            );
            $this->load->view('tipo_usuario/Tipo_usuario_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tipo_usuario'));
        }
    }

    public function create()
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('tipo_usuario/create_action'),
            'tipo_usuario_id' => set_value('tipo_usuario_id'),
            'tipo_usuario_ds' => set_value('tipo_usuario_ds'),
            'tipo_usuario_st' => set_value('tipo_usuario_st'),
            'sistema_id_correto' => set_value('sistema_id_correto'),
        );
        $this->load->view('tipo_usuario/Tipo_usuario_form', $data);
    }

    public function create_action()
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'tipo_usuario_ds' =>      empty($this->input->post('tipo_usuario_ds', TRUE)) ? NULL : trim($this->input->post('tipo_usuario_ds', TRUE)),
                'tipo_usuario_st' =>      empty($this->input->post('tipo_usuario_st', TRUE)) ? NULL : $this->input->post('tipo_usuario_st', TRUE),
                'sistema_id' =>      empty($this->input->post('sistema_id_correto', TRUE)) ? NULL : $this->input->post('sistema_id_correto', TRUE),
            );

            $this->Tipo_usuario_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('tipo_usuario'));
        }
    }

    public function update($id)
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->session->set_flashdata('message', '');
        $row = $this->Tipo_usuario_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('tipo_usuario/update_action'),
                'tipo_usuario_id' => set_value('tipo_usuario_id', $row->tipo_usuario_id),
                'tipo_usuario_ds' => set_value('tipo_usuario_ds', $row->tipo_usuario_ds),
                'tipo_usuario_st' => set_value('tipo_usuario_st', $row->tipo_usuario_st),
                'sistema_id_correto' => $row->sistema_id,
            );
            $this->load->view('tipo_usuario/Tipo_usuario_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('tipo_usuario'));
        }
    }

    public function update_action()
    {   PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->_rules();


        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('tipo_usuario_id', TRUE));
        } else {
            $data = array(
                'tipo_usuario_ds' => empty($this->input->post('tipo_usuario_ds', TRUE)) ? NULL : trim($this->input->post('tipo_usuario_ds', TRUE)),
                'tipo_usuario_st' => empty($this->input->post('tipo_usuario_st', TRUE)) ? NULL : $this->input->post('tipo_usuario_st', TRUE),
                'sistema_id' => empty($this->input->post('sistema_id_correto', TRUE)) ? NULL : $this->input->post('sistema_id_correto', TRUE),
            );

            $this->Tipo_usuario_model->update($this->input->post('tipo_usuario_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('tipo_usuario'));
        }
    }

    /*
    public function delete($id)
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $row = $this->Tipo_usuario_model->get_by_id($id);

        if ($row) {
            if (@$this->Tipo_usuario_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('tipo_usuario'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('tipo_usuario'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('tipo_usuario'));
        }
    }
        */

    public function _rules()
    {
        // $this->form_validation->set_rules('tipo_usuario_ds', 'tipo usuario ds', 'trim|required');
        // $this->form_validation->set_rules('tipo_usuario_st', 'tipo usuario st', 'trim|required');
        // $this->form_validation->set_rules('sistema_id', 'sistema id', 'trim|required');

        $this->form_validation->set_rules('tipo_usuario_id', 'tipo_usuario_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $param = array(

            array('tipo_usuario_ds', '=', $this->input->post('tipo_usuario_ds', TRUE)),
            array('tipo_usuario_st', '=', $this->input->post('tipo_usuario_st', TRUE)),
            array('sistema_id_correto', '=', $this->input->post('sistema_id_correto', TRUE)),
        ); //end array dos parametros

        $data = array(
            'tipo_usuario_data' => $this->Tipo_usuario_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('tipo_usuario/Tipo_usuario_pdf', $data, true);


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
            'action'        => site_url('tipo_usuario/open_pdf'),
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


        $this->load->view('tipo_usuario/Tipo_usuario_report', $data);
    }

    public function ajax_carrega_perfil_por_sistema()
    {   PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $sistema_id_correto = (int)$this->input->get('sistema_id_correto', TRUE);
        $param = array(
            array('sistema.sistema_id', '=', $sistema_id_correto)
        );
        $tipo_usuario = $this->Tipo_usuario_model->get_all_data($param);

        $json = array();
        foreach ($tipo_usuario as $s) {
            $json[] = array(
                'tipo_usuario_id' => (int)$s->tipo_usuario_id,
                'tipo_usuario_ds' => strtoupper(rupper(($s->tipo_usuario_ds))),
            );
        }
        echo json_encode($json);
    }
}

/* End of file Tipo_usuario.php */
/* Local: ./application/controllers/Tipo_usuario.php */
/* Gerado por RGenerator - 2020-01-14 13:36:34 */