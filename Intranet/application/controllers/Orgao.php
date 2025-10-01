<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orgao extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Orgao_model');
        $this->load->model('Segmento_model');
        $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'orgao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'orgao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'orgao/';
            $config['first_url'] = base_url() . 'orgao/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Orgao_model->total_rows($q);
        $orgao = $this->Orgao_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($orgao);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'orgao_data' => json($orgao),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('orgao/Orgao_list', $data);
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Orgao_model->get_by_id($id);
        $segmento = $this->Segmento_model->get_all_combobox();
        if ($row) {
            $data = array(
                'segmento' => json($segmento),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('orgao/create_action'),
                'orgao_id' => $row->orgao_id,
                'orgao_ds' => $row->orgao_ds,
                'orgao_st' => $row->orgao_st,
                'orgao_dt_criacao' => $row->orgao_dt_criacao,
                'orgao_dt_alteracao' => $row->orgao_dt_alteracao,
                'flag_maladireta' => $row->flag_maladireta,
                'maladireta_cd' => $row->maladireta_cd,
                'endereco' => $row->endereco,
                'segmento_id' => $row->segmento_id,
            );
            $this->load->view('orgao/Orgao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('orgao'));
        }
    }

    public function create()
    {
        $segmento = $this->Segmento_model->get_all_combobox();
        $data = array(
            'segmento' => json($segmento),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('orgao/create_action'),
            'orgao_id' => set_value('orgao_id'),
            'orgao_ds' => set_value('orgao_ds'),
            'orgao_st' => set_value('orgao_st'),
            'orgao_dt_criacao' => set_value('orgao_dt_criacao'),
            'orgao_dt_alteracao' => set_value('orgao_dt_alteracao'),
            'flag_maladireta' => set_value('flag_maladireta'),
            'maladireta_cd' => set_value('maladireta_cd'),
            'endereco' => set_value('endereco'),
            'segmento_id' => set_value('segmento_id'),
        );
        $this->load->view('orgao/Orgao_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('orgao_ds', NULL, 'trim|max_length[300]');
        $this->form_validation->set_rules('orgao_st', NULL, 'trim|numeric');
        $this->form_validation->set_rules('orgao_dt_criacao', NULL, 'trim');
        $this->form_validation->set_rules('orgao_dt_alteracao', NULL, 'trim');
        $this->form_validation->set_rules('flag_maladireta', NULL, 'trim|integer');
        $this->form_validation->set_rules('maladireta_cd', NULL, 'trim|max_length[20]');
        $this->form_validation->set_rules('endereco', NULL, 'trim|max_length[800]');
        $this->form_validation->set_rules('segmento_id', NULL, 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'orgao_ds' =>      empty($this->input->post('orgao_ds', TRUE)) ? NULL : $this->input->post('orgao_ds', TRUE),
                'orgao_st' =>      empty($this->input->post('orgao_st', TRUE)) ? NULL : $this->input->post('orgao_st', TRUE),
                'orgao_dt_criacao' =>      empty($this->input->post('orgao_dt_criacao', TRUE)) ? NULL : $this->input->post('orgao_dt_criacao', TRUE),
                'orgao_dt_alteracao' =>      empty($this->input->post('orgao_dt_alteracao', TRUE)) ? NULL : $this->input->post('orgao_dt_alteracao', TRUE),
                'flag_maladireta' =>      empty($this->input->post('flag_maladireta', TRUE)) ? NULL : $this->input->post('flag_maladireta', TRUE),
                'maladireta_cd' =>      empty($this->input->post('maladireta_cd', TRUE)) ? NULL : $this->input->post('maladireta_cd', TRUE),
                'endereco' =>      empty($this->input->post('endereco', TRUE)) ? NULL : $this->input->post('endereco', TRUE),
                'segmento_id' =>      empty($this->input->post('segmento_id', TRUE)) ? NULL : $this->input->post('segmento_id', TRUE),
            );

            $this->Orgao_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('orgao'));
        }
    }

    public function update($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Orgao_model->get_by_id($id);
        $segmento = $this->Segmento_model->get_all_combobox();
        if ($row) {
            $data = array(
                'segmento' => json($segmento),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('orgao/update_action'),
                'orgao_id' => set_value('orgao_id', $row->orgao_id),
                'orgao_ds' => set_value('orgao_ds', $row->orgao_ds),
                'orgao_st' => set_value('orgao_st', $row->orgao_st),
                'orgao_dt_criacao' => set_value('orgao_dt_criacao', $row->orgao_dt_criacao),
                'orgao_dt_alteracao' => set_value('orgao_dt_alteracao', $row->orgao_dt_alteracao),
                'flag_maladireta' => set_value('flag_maladireta', $row->flag_maladireta),
                'maladireta_cd' => set_value('maladireta_cd', $row->maladireta_cd),
                'endereco' => set_value('endereco', $row->endereco),
                'segmento_id' => set_value('segmento_id', $row->segmento_id),
            );
            $this->load->view('orgao/Orgao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('orgao'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('orgao_ds', 'orgao_ds', 'trim|max_length[300]');
        $this->form_validation->set_rules('orgao_st', 'orgao_st', 'trim|numeric');
        $this->form_validation->set_rules('orgao_dt_criacao', 'orgao_dt_criacao', 'trim');
        $this->form_validation->set_rules('orgao_dt_alteracao', 'orgao_dt_alteracao', 'trim');
        $this->form_validation->set_rules('flag_maladireta', 'flag_maladireta', 'trim|integer');
        $this->form_validation->set_rules('maladireta_cd', 'maladireta_cd', 'trim|max_length[20]');
        $this->form_validation->set_rules('endereco', 'endereco', 'trim|max_length[800]');
        $this->form_validation->set_rules('segmento_id', 'segmento_id', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('orgao_id', TRUE));
        } else {
            $data = array(
                'orgao_ds' => empty($this->input->post('orgao_ds', TRUE)) ? NULL : $this->input->post('orgao_ds', TRUE),
                'orgao_st' => empty($this->input->post('orgao_st', TRUE)) ? NULL : $this->input->post('orgao_st', TRUE),
                'orgao_dt_criacao' => empty($this->input->post('orgao_dt_criacao', TRUE)) ? NULL : $this->input->post('orgao_dt_criacao', TRUE),
                'orgao_dt_alteracao' => empty($this->input->post('orgao_dt_alteracao', TRUE)) ? NULL : $this->input->post('orgao_dt_alteracao', TRUE),
                'flag_maladireta' => empty($this->input->post('flag_maladireta', TRUE)) ? NULL : $this->input->post('flag_maladireta', TRUE),
                'maladireta_cd' => empty($this->input->post('maladireta_cd', TRUE)) ? NULL : $this->input->post('maladireta_cd', TRUE),
                'endereco' => empty($this->input->post('endereco', TRUE)) ? NULL : $this->input->post('endereco', TRUE),
                'segmento_id' => empty($this->input->post('segmento_id', TRUE)) ? NULL : $this->input->post('segmento_id', TRUE),
            );

            $this->Orgao_model->update($this->input->post('orgao_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('orgao'));
        }
    }

    public function delete($id)
    {
        $row = $this->Orgao_model->get_by_id($id);

        if ($row) {
            if (@$this->Orgao_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('orgao'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('orgao'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('orgao'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('orgao_ds', 'orgao ds', 'trim|required');
        $this->form_validation->set_rules('orgao_st', 'orgao st', 'trim|required');
        $this->form_validation->set_rules('orgao_dt_criacao', 'orgao dt criacao', 'trim|required');
        $this->form_validation->set_rules('orgao_dt_alteracao', 'orgao dt alteracao', 'trim|required');
        $this->form_validation->set_rules('flag_maladireta', 'flag maladireta', 'trim|required');
        $this->form_validation->set_rules('maladireta_cd', 'maladireta cd', 'trim|required');
        $this->form_validation->set_rules('endereco', 'endereco', 'trim|required');
        $this->form_validation->set_rules('segmento_id', 'segmento id', 'trim|required');

        $this->form_validation->set_rules('orgao_id', 'orgao_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {

        $param = array(

            array('orgao_ds', '=', $this->input->post('orgao_ds', TRUE)),
            array('orgao_st', '=', $this->input->post('orgao_st', TRUE)),
            array('orgao_dt_criacao', '=', $this->input->post('orgao_dt_criacao', TRUE)),
            array('orgao_dt_alteracao', '=', $this->input->post('orgao_dt_alteracao', TRUE)),
            array('flag_maladireta', '=', $this->input->post('flag_maladireta', TRUE)),
            array('maladireta_cd', '=', $this->input->post('maladireta_cd', TRUE)),
            array('endereco', '=', $this->input->post('endereco', TRUE)),
            array('segmento_id', '=', $this->input->post('segmento_id', TRUE)),
        ); //end array dos parametros

        $data = array(
            'orgao_data' => $this->Orgao_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('orgao/Orgao_pdf', $data, true);


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
            'action'        => site_url('orgao/open_pdf'),
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


        $this->load->view('orgao/Orgao_report', $data);
    }
}

/* End of file Orgao.php */
/* Local: ./application/controllers/Orgao.php */
/* Gerado por RGenerator - 2022-06-29 20:00:41 */