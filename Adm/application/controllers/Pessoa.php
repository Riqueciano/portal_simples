<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pessoa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pessoa_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'pessoa/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'pessoa/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'pessoa/';
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

    public function read($id)
    {
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
                'empresa_id' => $row->empresa_id,
                'lotacao_id' => $row->lotacao_id,
                'ddd_telefone' => $row->ddd_telefone,
                'telefone' => $row->telefone,
                'ddd_celular' => $row->ddd_celular,
                'celular' => $row->celular,
            );
            $this->load->view('pessoa/Pessoa_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pessoa'));
        }
    }

    public function create()
    {
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
            'empresa_id' => set_value('empresa_id'),
            'lotacao_id' => set_value('lotacao_id'),
            'ddd_telefone' => set_value('ddd_telefone'),
            'telefone' => set_value('telefone'),
            'ddd_celular' => set_value('ddd_celular'),
            'celular' => set_value('celular'),
        );
        $this->load->view('pessoa/Pessoa_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('pessoa_nm', NULL, 'trim|max_length[200]');
        $this->form_validation->set_rules('pessoa_tipo', NULL, 'trim|required|max_length[1]');
        $this->form_validation->set_rules('pessoa_email', NULL, 'trim|max_length[200]');
        $this->form_validation->set_rules('pessoa_st', NULL, 'trim|numeric');
        $this->form_validation->set_rules('pessoa_dt_criacao', NULL, 'trim');
        $this->form_validation->set_rules('pessoa_dt_alteracao', NULL, 'trim');
        $this->form_validation->set_rules('pessoa_usuario_criador', NULL, 'trim|integer');
        $this->form_validation->set_rules('setaf_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('empresa_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('lotacao_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('ddd_telefone', NULL, 'trim|max_length[5]');
        $this->form_validation->set_rules('telefone', NULL, 'trim|max_length[20]');
        $this->form_validation->set_rules('ddd_celular', NULL, 'trim|max_length[5]');
        $this->form_validation->set_rules('celular', NULL, 'trim|max_length[20]');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'pessoa_nm' =>      empty($this->input->post('pessoa_nm', TRUE)) ? NULL : $this->input->post('pessoa_nm', TRUE),
                'pessoa_tipo' =>      empty($this->input->post('pessoa_tipo', TRUE)) ? NULL : $this->input->post('pessoa_tipo', TRUE),
                'pessoa_email' =>      empty($this->input->post('pessoa_email', TRUE)) ? NULL : $this->input->post('pessoa_email', TRUE),
                'pessoa_st' =>      empty($this->input->post('pessoa_st', TRUE)) ? NULL : $this->input->post('pessoa_st', TRUE),
                'pessoa_dt_criacao' =>      empty($this->input->post('pessoa_dt_criacao', TRUE)) ? NULL : $this->input->post('pessoa_dt_criacao', TRUE),
                'pessoa_dt_alteracao' =>      empty($this->input->post('pessoa_dt_alteracao', TRUE)) ? NULL : $this->input->post('pessoa_dt_alteracao', TRUE),
                'pessoa_usuario_criador' =>      empty($this->input->post('pessoa_usuario_criador', TRUE)) ? NULL : $this->input->post('pessoa_usuario_criador', TRUE),
                'setaf_id' =>      empty($this->input->post('setaf_id', TRUE)) ? NULL : $this->input->post('setaf_id', TRUE),
                'empresa_id' =>      empty($this->input->post('empresa_id', TRUE)) ? NULL : $this->input->post('empresa_id', TRUE),
                'lotacao_id' =>      empty($this->input->post('lotacao_id', TRUE)) ? NULL : $this->input->post('lotacao_id', TRUE),
                'ddd_telefone' =>      empty($this->input->post('ddd_telefone', TRUE)) ? NULL : $this->input->post('ddd_telefone', TRUE),
                'telefone' =>      empty($this->input->post('telefone', TRUE)) ? NULL : $this->input->post('telefone', TRUE),
                'ddd_celular' =>      empty($this->input->post('ddd_celular', TRUE)) ? NULL : $this->input->post('ddd_celular', TRUE),
                'celular' =>      empty($this->input->post('celular', TRUE)) ? NULL : $this->input->post('celular', TRUE),
            );

            $this->Pessoa_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('pessoa'));
        }
    }

    public function update($id)
    {
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
                'empresa_id' => set_value('empresa_id', $row->empresa_id),
                'lotacao_id' => set_value('lotacao_id', $row->lotacao_id),
                'ddd_telefone' => set_value('ddd_telefone', $row->ddd_telefone),
                'telefone' => set_value('telefone', $row->telefone),
                'ddd_celular' => set_value('ddd_celular', $row->ddd_celular),
                'celular' => set_value('celular', $row->celular),
            );
            $this->load->view('pessoa/Pessoa_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('pessoa'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('pessoa_nm', 'pessoa_nm', 'trim|max_length[200]');
        $this->form_validation->set_rules('pessoa_tipo', 'pessoa_tipo', 'trim|required|max_length[1]');
        $this->form_validation->set_rules('pessoa_email', 'pessoa_email', 'trim|max_length[200]');
        $this->form_validation->set_rules('pessoa_st', 'pessoa_st', 'trim|numeric');
        $this->form_validation->set_rules('pessoa_dt_criacao', 'pessoa_dt_criacao', 'trim');
        $this->form_validation->set_rules('pessoa_dt_alteracao', 'pessoa_dt_alteracao', 'trim');
        $this->form_validation->set_rules('pessoa_usuario_criador', 'pessoa_usuario_criador', 'trim|integer');
        $this->form_validation->set_rules('setaf_id', 'setaf_id', 'trim|integer');
        $this->form_validation->set_rules('empresa_id', 'empresa_id', 'trim|integer');
        $this->form_validation->set_rules('lotacao_id', 'lotacao_id', 'trim|integer');
        $this->form_validation->set_rules('ddd_telefone', 'ddd_telefone', 'trim|max_length[5]');
        $this->form_validation->set_rules('telefone', 'telefone', 'trim|max_length[20]');
        $this->form_validation->set_rules('ddd_celular', 'ddd_celular', 'trim|max_length[5]');
        $this->form_validation->set_rules('celular', 'celular', 'trim|max_length[20]');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('pessoa_id', TRUE));
        } else {
            $data = array(
                'pessoa_nm' => empty($this->input->post('pessoa_nm', TRUE)) ? NULL : $this->input->post('pessoa_nm', TRUE),
                'pessoa_tipo' => empty($this->input->post('pessoa_tipo', TRUE)) ? NULL : $this->input->post('pessoa_tipo', TRUE),
                'pessoa_email' => empty($this->input->post('pessoa_email', TRUE)) ? NULL : $this->input->post('pessoa_email', TRUE),
                'pessoa_st' => empty($this->input->post('pessoa_st', TRUE)) ? NULL : $this->input->post('pessoa_st', TRUE),
                'pessoa_dt_criacao' => empty($this->input->post('pessoa_dt_criacao', TRUE)) ? NULL : $this->input->post('pessoa_dt_criacao', TRUE),
                'pessoa_dt_alteracao' => empty($this->input->post('pessoa_dt_alteracao', TRUE)) ? NULL : $this->input->post('pessoa_dt_alteracao', TRUE),
                'pessoa_usuario_criador' => empty($this->input->post('pessoa_usuario_criador', TRUE)) ? NULL : $this->input->post('pessoa_usuario_criador', TRUE),
                'setaf_id' => empty($this->input->post('setaf_id', TRUE)) ? NULL : $this->input->post('setaf_id', TRUE),
                'empresa_id' => empty($this->input->post('empresa_id', TRUE)) ? NULL : $this->input->post('empresa_id', TRUE),
                'lotacao_id' => empty($this->input->post('lotacao_id', TRUE)) ? NULL : $this->input->post('lotacao_id', TRUE),
                'ddd_telefone' => empty($this->input->post('ddd_telefone', TRUE)) ? NULL : $this->input->post('ddd_telefone', TRUE),
                'telefone' => empty($this->input->post('telefone', TRUE)) ? NULL : $this->input->post('telefone', TRUE),
                'ddd_celular' => empty($this->input->post('ddd_celular', TRUE)) ? NULL : $this->input->post('ddd_celular', TRUE),
                'celular' => empty($this->input->post('celular', TRUE)) ? NULL : $this->input->post('celular', TRUE),
            );

            $this->Pessoa_model->update($this->input->post('pessoa_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('pessoa'));
        }
    }

    public function delete($id)
    {
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

    public function _rules()
    {
        $this->form_validation->set_rules('pessoa_nm', 'pessoa nm', 'trim|required');
        $this->form_validation->set_rules('pessoa_tipo', 'pessoa tipo', 'trim|required');
        $this->form_validation->set_rules('pessoa_email', 'pessoa email', 'trim|required');
        $this->form_validation->set_rules('pessoa_st', 'pessoa st', 'trim|required');
        $this->form_validation->set_rules('pessoa_dt_criacao', 'pessoa dt criacao', 'trim|required');
        $this->form_validation->set_rules('pessoa_dt_alteracao', 'pessoa dt alteracao', 'trim|required');
        $this->form_validation->set_rules('pessoa_usuario_criador', 'pessoa usuario criador', 'trim|required');
        $this->form_validation->set_rules('setaf_id', 'setaf id', 'trim|required');
        $this->form_validation->set_rules('empresa_id', 'empresa id', 'trim|required');
        $this->form_validation->set_rules('lotacao_id', 'lotacao id', 'trim|required');
        $this->form_validation->set_rules('ddd_telefone', 'ddd telefone', 'trim|required');
        $this->form_validation->set_rules('telefone', 'telefone', 'trim|required');
        $this->form_validation->set_rules('ddd_celular', 'ddd celular', 'trim|required');
        $this->form_validation->set_rules('celular', 'celular', 'trim|required');

        $this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {

        $param = array(

            array('pessoa_nm', '=', $this->input->post('pessoa_nm', TRUE)),
            array('pessoa_tipo', '=', $this->input->post('pessoa_tipo', TRUE)),
            array('pessoa_email', '=', $this->input->post('pessoa_email', TRUE)),
            array('pessoa_st', '=', $this->input->post('pessoa_st', TRUE)),
            array('pessoa_dt_criacao', '=', $this->input->post('pessoa_dt_criacao', TRUE)),
            array('pessoa_dt_alteracao', '=', $this->input->post('pessoa_dt_alteracao', TRUE)),
            array('pessoa_usuario_criador', '=', $this->input->post('pessoa_usuario_criador', TRUE)),
            array('setaf_id', '=', $this->input->post('setaf_id', TRUE)),
            array('empresa_id', '=', $this->input->post('empresa_id', TRUE)),
            array('lotacao_id', '=', $this->input->post('lotacao_id', TRUE)),
            array('ddd_telefone', '=', $this->input->post('ddd_telefone', TRUE)),
            array('telefone', '=', $this->input->post('telefone', TRUE)),
            array('ddd_celular', '=', $this->input->post('ddd_celular', TRUE)),
            array('celular', '=', $this->input->post('celular', TRUE)),
        ); //end array dos parametros

        $data = array(
            'pessoa_data' => $this->Pessoa_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('pessoa/Pessoa_pdf', $data, true);


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
            'action'        => site_url('pessoa/open_pdf'),
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


        $this->load->view('pessoa/Pessoa_report', $data);
    }

    function ajaxAlteraStatus()
    {
        $pessoa_id = $this->input->post('pessoa_id', TRUE);

        $pessoa = $this->Pessoa_model->get_by_id($pessoa_id);
        $status = 0;
        if ($pessoa->pessoa_st == 0) {
            $status = 1;
        }
        $data = array('pessoa_st' => $status);
        $this->Pessoa_model->update($pessoa_id, $data);

        echo $status == 1?'Inativo':'Ativo';
    }
}

/* End of file Pessoa.php */
/* Local: ./application/controllers/Pessoa.php */
/* Gerado por RGenerator - 2020-09-26 15:59:16 */