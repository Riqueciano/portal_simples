<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Publicacao extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Publicacao_model');
        $this->load->library('form_validation');
    }


    public function ajax_consulta_publicacoes()
    {

        // $format = urldecode($this->input->get('format', TRUE));
        $limit = intval($this->input->get('limit'));
        $flag_carrossel = intval($this->input->get('flag_carrossel'));
        $param = "flag_carrossel = $flag_carrossel";
        $publicacao = $this->Publicacao_model->get_all_data_param($param, null, $limit);

        // echo $this->db->last_query();exit;
        echo json($publicacao);
    }


    public function index()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = (int)$this->input->get('start');



        $config['per_page'] = 30;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Publicacao_model->total_rows($q);
        $publicacao = $this->Publicacao_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($publicacao);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'publicacao_data' => json($publicacao),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('publicacao/Publicacao_list', forFrontVue($data));
    }

    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Publicacao_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => '',
                'controller' => 'read',
                'action' => site_url('publicacao/create_action'),
                'publicacao_id' => $row->publicacao_id,
                'publicacao_titulo' => $row->publicacao_titulo,
                'publicacao_dt_publicacao' => $row->publicacao_dt_publicacao,
                'publicacao_img' => $row->publicacao_img,
                'publicacao_corpo' => $row->publicacao_corpo,
                'publicacao_st' => $row->publicacao_st,
                'publicacao_dt_criacao' => $row->publicacao_dt_criacao,
                'publicacao_dt_alteracao' => $row->publicacao_dt_alteracao,
                'publicacao_tipo' => $row->publicacao_tipo,
                'publicacao_link' => $row->publicacao_link,
                'ativo' => $row->ativo,
                'flag_carrossel' => $row->flag_carrossel,
            );
            $this->load->view('publicacao/Publicacao_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('publicacao'));
        }
    }

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $data = array(

            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('publicacao/create_action'),
            'publicacao_id' => set_value('publicacao_id'),
            'publicacao_titulo' => set_value('publicacao_titulo'),
            'publicacao_dt_publicacao' => set_value('publicacao_dt_publicacao'),
            'publicacao_img' => set_value('publicacao_img'),
            'publicacao_corpo' => set_value('publicacao_corpo'),
            'publicacao_st' => set_value('publicacao_st'),
            'publicacao_dt_criacao' => set_value('publicacao_dt_criacao'),
            'publicacao_dt_alteracao' => set_value('publicacao_dt_alteracao'),
            'publicacao_tipo' => set_value('publicacao_tipo'),
            'publicacao_link' => set_value('publicacao_link'),
            'ativo' => set_value('ativo'),
            'flag_carrossel' => set_value('flag_carrossel'),
        );
        $this->load->view('publicacao/Publicacao_form', forFrontVue($data));
    }

    public function create_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('publicacao_titulo', NULL, 'trim|max_length[100]');
        $this->form_validation->set_rules('publicacao_dt_publicacao', NULL, 'trim');
        $this->form_validation->set_rules('publicacao_img', NULL, 'trim|max_length[100]');
        $this->form_validation->set_rules('publicacao_corpo', NULL, 'trim|max_length[80000]');
        $this->form_validation->set_rules('publicacao_st', NULL, 'trim|integer');
        $this->form_validation->set_rules('publicacao_dt_criacao', NULL, 'trim');
        $this->form_validation->set_rules('publicacao_dt_alteracao', NULL, 'trim');
        $this->form_validation->set_rules('publicacao_tipo', NULL, 'trim|integer');
        $this->form_validation->set_rules('publicacao_link', NULL, 'trim|max_length[1000]');
        $this->form_validation->set_rules('ativo', NULL, 'trim|integer');
        $this->form_validation->set_rules('flag_carrossel', NULL, 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'publicacao_titulo' =>      empty($this->input->post('publicacao_titulo', TRUE)) ? NULL : $this->input->post('publicacao_titulo', TRUE),
                'publicacao_dt_publicacao' =>      empty($this->input->post('publicacao_dt_publicacao', TRUE)) ? NULL : $this->input->post('publicacao_dt_publicacao', TRUE),
                'publicacao_img' =>      empty($this->input->post('publicacao_img', TRUE)) ? NULL : $this->input->post('publicacao_img', TRUE),
                'publicacao_corpo' =>      empty($this->input->post('publicacao_corpo', TRUE)) ? NULL : $this->input->post('publicacao_corpo', TRUE),
                'publicacao_st' =>      empty($this->input->post('publicacao_st', TRUE)) ? NULL : $this->input->post('publicacao_st', TRUE),
                'publicacao_dt_criacao' =>      empty($this->input->post('publicacao_dt_criacao', TRUE)) ? NULL : $this->input->post('publicacao_dt_criacao', TRUE),
                'publicacao_dt_alteracao' =>      empty($this->input->post('publicacao_dt_alteracao', TRUE)) ? NULL : $this->input->post('publicacao_dt_alteracao', TRUE),
                'publicacao_tipo' =>      empty($this->input->post('publicacao_tipo', TRUE)) ? NULL : $this->input->post('publicacao_tipo', TRUE),
                'publicacao_link' =>      empty($this->input->post('publicacao_link', TRUE)) ? NULL : $this->input->post('publicacao_link', TRUE),
                'ativo' =>      empty($this->input->post('ativo', TRUE)) ? NULL : $this->input->post('ativo', TRUE),
                'flag_carrossel' =>      empty($this->input->post('flag_carrossel', TRUE)) ? NULL : $this->input->post('flag_carrossel', TRUE),
            );

            $this->Publicacao_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('publicacao'));
        }
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Publicacao_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('publicacao/update_action'),
                'publicacao_id' => set_value('publicacao_id', $row->publicacao_id),
                'publicacao_titulo' => set_value('publicacao_titulo', $row->publicacao_titulo),
                'publicacao_dt_publicacao' => set_value('publicacao_dt_publicacao', $row->publicacao_dt_publicacao),
                'publicacao_img' => set_value('publicacao_img', $row->publicacao_img),
                'publicacao_corpo' => set_value('publicacao_corpo', $row->publicacao_corpo),
                'publicacao_st' => set_value('publicacao_st', $row->publicacao_st),
                'publicacao_dt_criacao' => set_value('publicacao_dt_criacao', $row->publicacao_dt_criacao),
                'publicacao_dt_alteracao' => set_value('publicacao_dt_alteracao', $row->publicacao_dt_alteracao),
                'publicacao_tipo' => set_value('publicacao_tipo', $row->publicacao_tipo),
                'publicacao_link' => set_value('publicacao_link', $row->publicacao_link),
                'ativo' => set_value('ativo', $row->ativo),
                'flag_carrossel' => set_value('flag_carrossel', $row->flag_carrossel),
            );
            $this->load->view('publicacao/Publicacao_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('publicacao'));
        }
    }

    public function update_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->_rules();
        $this->form_validation->set_rules('publicacao_titulo', 'publicacao_titulo', 'trim|max_length[100]');
        $this->form_validation->set_rules('publicacao_dt_publicacao', 'publicacao_dt_publicacao', 'trim');
        $this->form_validation->set_rules('publicacao_img', 'publicacao_img', 'trim|max_length[100]');
        $this->form_validation->set_rules('publicacao_corpo', 'publicacao_corpo', 'trim|max_length[80000]');
        $this->form_validation->set_rules('publicacao_st', 'publicacao_st', 'trim|integer');
        $this->form_validation->set_rules('publicacao_dt_criacao', 'publicacao_dt_criacao', 'trim');
        $this->form_validation->set_rules('publicacao_dt_alteracao', 'publicacao_dt_alteracao', 'trim');
        $this->form_validation->set_rules('publicacao_tipo', 'publicacao_tipo', 'trim|integer');
        $this->form_validation->set_rules('publicacao_link', 'publicacao_link', 'trim|max_length[1000]');
        $this->form_validation->set_rules('ativo', 'ativo', 'trim|integer');
        $this->form_validation->set_rules('flag_carrossel', 'flag_carrossel', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('publicacao_id', TRUE));
        } else {
            $data = array(
                'publicacao_titulo' => empty($this->input->post('publicacao_titulo', TRUE)) ? NULL : $this->input->post('publicacao_titulo', TRUE),
                'publicacao_dt_publicacao' => empty($this->input->post('publicacao_dt_publicacao', TRUE)) ? NULL : $this->input->post('publicacao_dt_publicacao', TRUE),
                'publicacao_img' => empty($this->input->post('publicacao_img', TRUE)) ? NULL : $this->input->post('publicacao_img', TRUE),
                'publicacao_corpo' => empty($this->input->post('publicacao_corpo', TRUE)) ? NULL : $this->input->post('publicacao_corpo', TRUE),
                'publicacao_st' => empty($this->input->post('publicacao_st', TRUE)) ? NULL : $this->input->post('publicacao_st', TRUE),
                'publicacao_dt_criacao' => empty($this->input->post('publicacao_dt_criacao', TRUE)) ? NULL : $this->input->post('publicacao_dt_criacao', TRUE),
                'publicacao_dt_alteracao' => empty($this->input->post('publicacao_dt_alteracao', TRUE)) ? NULL : $this->input->post('publicacao_dt_alteracao', TRUE),
                'publicacao_tipo' => empty($this->input->post('publicacao_tipo', TRUE)) ? NULL : $this->input->post('publicacao_tipo', TRUE),
                'publicacao_link' => empty($this->input->post('publicacao_link', TRUE)) ? NULL : $this->input->post('publicacao_link', TRUE),
                'ativo' => empty($this->input->post('ativo', TRUE)) ? NULL : $this->input->post('ativo', TRUE),
                'flag_carrossel' => empty($this->input->post('flag_carrossel', TRUE)) ? NULL : $this->input->post('flag_carrossel', TRUE),
            );

            $this->Publicacao_model->update($this->input->post('publicacao_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('publicacao'));
        }
    }

    public function delete($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $row = $this->Publicacao_model->get_by_id($id);

        if ($row) {
            if (@$this->Publicacao_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('publicacao'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('publicacao'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('publicacao'));
        }
    }

    public function _rules()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
        $this->form_validation->set_rules('publicacao_titulo', 'publicacao titulo', 'trim|required');
        $this->form_validation->set_rules('publicacao_dt_publicacao', 'publicacao dt publicacao', 'trim|required');
        $this->form_validation->set_rules('publicacao_img', 'publicacao img', 'trim|required');
        $this->form_validation->set_rules('publicacao_corpo', 'publicacao corpo', 'trim|required');
        $this->form_validation->set_rules('publicacao_st', 'publicacao st', 'trim|required');
        $this->form_validation->set_rules('publicacao_dt_criacao', 'publicacao dt criacao', 'trim|required');
        $this->form_validation->set_rules('publicacao_dt_alteracao', 'publicacao dt alteracao', 'trim|required');
        $this->form_validation->set_rules('publicacao_tipo', 'publicacao tipo', 'trim|required');
        $this->form_validation->set_rules('publicacao_link', 'publicacao link', 'trim|required');
        $this->form_validation->set_rules('ativo', 'ativo', 'trim|required');
        $this->form_validation->set_rules('flag_carrossel', 'flag carrossel', 'trim|required');

        $this->form_validation->set_rules('publicacao_id', 'publicacao_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

        $param = array(

            array('publicacao_titulo', '=', $this->input->post('publicacao_titulo', TRUE)),
            array('publicacao_dt_publicacao', '=', $this->input->post('publicacao_dt_publicacao', TRUE)),
            array('publicacao_img', '=', $this->input->post('publicacao_img', TRUE)),
            array('publicacao_corpo', '=', $this->input->post('publicacao_corpo', TRUE)),
            array('publicacao_st', '=', $this->input->post('publicacao_st', TRUE)),
            array('publicacao_dt_criacao', '=', $this->input->post('publicacao_dt_criacao', TRUE)),
            array('publicacao_dt_alteracao', '=', $this->input->post('publicacao_dt_alteracao', TRUE)),
            array('publicacao_tipo', '=', $this->input->post('publicacao_tipo', TRUE)),
            array('publicacao_link', '=', $this->input->post('publicacao_link', TRUE)),
            array('ativo', '=', $this->input->post('ativo', TRUE)),
            array('flag_carrossel', '=', $this->input->post('flag_carrossel', TRUE)),
        ); //end array dos parametros

        $data = array(
            'publicacao_data' => $this->Publicacao_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('publicacao/Publicacao_pdf', $data, true);


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
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('publicacao/open_pdf'),
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


        $this->load->view('publicacao/Publicacao_report', forFrontVue($data));
    }
}

/* End of file Publicacao.php */
/* Local: ./application/controllers/Publicacao.php */
/* Gerado por RGenerator - 2024-05-15 16:05:49 */