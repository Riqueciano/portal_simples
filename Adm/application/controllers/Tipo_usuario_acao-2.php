<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tipo_usuario_acao extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tipo_usuario_acao_model');
        $this->load->model('Acao_model');
        $this->load->model('Secao_model');
        $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'ascom']);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        $filtro_sistema_id = intval($this->input->get('filtro_sistema_id'));
        $secao_id = intval($this->input->get('secao_id'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'tipo_usuario_acao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'tipo_usuario_acao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'tipo_usuario_acao/';
            $config['first_url'] = base_url() . 'tipo_usuario_acao/';
        }

        $config['per_page'] = 10000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tipo_usuario_acao_model->total_rows($q);
        $param = '';
        if (!empty($filtro_sistema_id)) {
            $param .= " and sistema.sistema_id = " . $filtro_sistema_id;
        }
        if (!empty($secao_id)) {
            $param .= " and secao.secao_id = " . $secao_id;
        }
        // echo $param;
        $tipo_usuario_acao = $this->Tipo_usuario_acao_model->get_limit_data($config['per_page'], $start, $q, $param);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tipo_usuario_acao_data' => $tipo_usuario_acao,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'filtro_sistema_id' => $filtro_sistema_id,
            'secao_id' => $secao_id,
        );
        $this->load->view('tipo_usuario_acao/Tipo_usuario_acao_list', $data);
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Tipo_usuario_acao_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('tipo_usuario_acao/create_action'),
                'tipo_usuario_id' => $row->tipo_usuario_id,
                'tipo_usuario_acao_id' => $row->tipo_usuario_acao_id,
                'acao_id' => $row->acao_id,
            );
            $this->load->view('tipo_usuario_acao/Tipo_usuario_acao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tipo_usuario_acao'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('tipo_usuario_acao/create_action'),
            'tipo_usuario_id' => set_value('tipo_usuario_id'),
            'tipo_usuario_acao_id' => set_value('tipo_usuario_acao_id'),
            'acao_id' => set_value('acao_id'),
            'sistema_id_correto' => null,
        );
        $this->load->view('tipo_usuario_acao/Tipo_usuario_acao_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('acao_id', NULL, 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $sistema_id = $this->input->post('sistema_id_correto', TRUE);
            $data = array(
                'acao_id' => empty($this->input->post('acao_id', TRUE)) ? NULL : $this->input->post('acao_id', TRUE),
                'tipo_usuario_id' => empty($this->input->post('tipo_usuario_id', TRUE)) ? NULL : $this->input->post('tipo_usuario_id', TRUE),
            );

            $this->Tipo_usuario_acao_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('tipo_usuario_acao/?filtro_sistema_id='.$sistema_id));
        }
    }

    public function update($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Tipo_usuario_acao_model->get_by_id($id);
        $acao = $this->Acao_model->get_by_id($row->acao_id);
        $secao = $this->Secao_model->get_by_id($acao->secao_id);

        $sistema_id = $secao->sistema_id;

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('tipo_usuario_acao/update_action'),
                'tipo_usuario_id' => set_value('tipo_usuario_id', $row->tipo_usuario_id),
                'tipo_usuario_acao_id' => set_value('tipo_usuario_acao_id', $row->tipo_usuario_acao_id),
                'acao_id' => set_value('acao_id', $row->acao_id),
                // 'sistema_id_correto' => set_value('sistema_id', $row->sistema_id),
                'sistema_id_correto' => $sistema_id,
            );
            $this->load->view('tipo_usuario_acao/Tipo_usuario_acao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('tipo_usuario_acao'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('acao_id', 'acao_id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('tipo_usuario_id', TRUE));
        } else {
            $data = array(
                'acao_id' => empty($this->input->post('acao_id', TRUE)) ? NULL : $this->input->post('acao_id', TRUE),
                'tipo_usuario_id' => empty($this->input->post('tipo_usuario_id', TRUE)) ? NULL : $this->input->post('tipo_usuario_id', TRUE),
            );

            $this->Tipo_usuario_acao_model->update($this->input->post('tipo_usuario_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('tipo_usuario_acao'));
        }
    }

    public function delete($id)
    {
        $row = $this->Tipo_usuario_acao_model->get_by_id($id);

        if ($row) {
            if (@$this->Tipo_usuario_acao_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('tipo_usuario_acao'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('tipo_usuario_acao'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('tipo_usuario_acao'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('acao_id', 'acao id', 'trim|required');

        $this->form_validation->set_rules('tipo_usuario_id', 'tipo_usuario_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {

        $param = array(

            array('acao_id', '=', $this->input->post('acao_id', TRUE)),
        ); //end array dos parametros

        $data = array(
            'tipo_usuario_acao_data' => $this->Tipo_usuario_acao_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('tipo_usuario_acao/Tipo_usuario_acao_pdf', $data, true);


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
            'action'        => site_url('tipo_usuario_acao/open_pdf'),
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


        $this->load->view('tipo_usuario_acao/Tipo_usuario_acao_report', $data);
    }
}

/* End of file Tipo_usuario_acao.php */
/* Local: ./application/controllers/Tipo_usuario_acao.php */
/* Gerado por RGenerator - 2020-01-14 13:38:14 */