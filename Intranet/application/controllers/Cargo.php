<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cargo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Cargo_model');
        $this->load->model('Funcionario_tipo_model');

        $this->load->model('Classe_model');

        $this->load->model('Classe_model');
        $this->load->library('form_validation');
    }

    public function index()
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'cargo/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'cargo/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'cargo/';
            $config['first_url'] = base_url() . 'cargo/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Cargo_model->total_rows($q);
        $cargo = $this->Cargo_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($cargo);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'cargo_data' => json($cargo),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('cargo/Cargo_list', $data);
    }

    public function read($id)
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->session->set_flashdata('message', '');
        $row = $this->Cargo_model->get_by_id($id);
        $funcionario_tipo = $this->Funcionario_tipo_model->get_all_combobox();
        $classe = $this->Classe_model->get_all_combobox();
        $classe = $this->Classe_model->get_all_combobox();
        if ($row) {
            $data = array(
                'funcionario_tipo' => json($funcionario_tipo),
                'classe' => json($classe),
                'classe' => json($classe),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('cargo/create_action'),
                'cargo_id' => $row->cargo_id,
                'cargo_ds' => $row->cargo_ds,
                'cargo_st' => $row->cargo_st,
                'cargo_dt_criacao' => $row->cargo_dt_criacao,
                'cargo_dt_alteracao' => $row->cargo_dt_alteracao,
                'funcionario_tipo_id' => $row->funcionario_tipo_id,
                'classe_id' => $row->classe_id,
                'cargo_qtde' => $row->cargo_qtde,
                'novo_classe_id' => $row->novo_classe_id,
            );
            $this->load->view('cargo/Cargo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cargo'));
        }
    }

    public function create()
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $funcionario_tipo = $this->Funcionario_tipo_model->get_all_combobox();
        $classe = $this->Classe_model->get_all_combobox();
        $classe = $this->Classe_model->get_all_combobox();
        $data = array(
            'funcionario_tipo' => json($funcionario_tipo),
            'classe' => json($classe),
            'classe' => json($classe),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('cargo/create_action'),
            'cargo_id' => set_value('cargo_id'),
            'cargo_ds' => set_value('cargo_ds'),
            'cargo_st' => set_value('cargo_st'),
            'cargo_dt_criacao' => set_value('cargo_dt_criacao'),
            'cargo_dt_alteracao' => set_value('cargo_dt_alteracao'),
            'funcionario_tipo_id' => set_value('funcionario_tipo_id'),
            'classe_id' => set_value('classe_id'),
            'cargo_qtde' => set_value('cargo_qtde'),
            'novo_classe_id' => set_value('novo_classe_id'),
        );
        $this->load->view('cargo/Cargo_form', $data);
    }

    public function create_action()
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->_rules();
        $this->form_validation->set_rules('cargo_ds', NULL, 'trim|required|max_length[100]');
        $this->form_validation->set_rules('cargo_st', NULL, 'trim|numeric');
        $this->form_validation->set_rules('cargo_dt_criacao', NULL, 'trim');
        $this->form_validation->set_rules('cargo_dt_alteracao', NULL, 'trim');
        $this->form_validation->set_rules('funcionario_tipo_id', NULL, 'trim');
        $this->form_validation->set_rules('classe_id', NULL, 'trim');
        $this->form_validation->set_rules('cargo_qtde', NULL, 'trim');
        $this->form_validation->set_rules('novo_classe_id', NULL, 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'cargo_ds' =>      empty($this->input->post('cargo_ds', TRUE)) ? NULL : $this->input->post('cargo_ds', TRUE),
                'cargo_st' =>      empty($this->input->post('cargo_st', TRUE)) ? NULL : $this->input->post('cargo_st', TRUE),
                'cargo_dt_criacao' =>      empty($this->input->post('cargo_dt_criacao', TRUE)) ? NULL : $this->input->post('cargo_dt_criacao', TRUE),
                'cargo_dt_alteracao' =>      empty($this->input->post('cargo_dt_alteracao', TRUE)) ? NULL : $this->input->post('cargo_dt_alteracao', TRUE),
                'funcionario_tipo_id' =>      empty($this->input->post('funcionario_tipo_id', TRUE)) ? NULL : $this->input->post('funcionario_tipo_id', TRUE),
                'classe_id' =>      empty($this->input->post('classe_id', TRUE)) ? NULL : $this->input->post('classe_id', TRUE),
                'cargo_qtde' =>      empty($this->input->post('cargo_qtde', TRUE)) ? NULL : $this->input->post('cargo_qtde', TRUE),
                'novo_classe_id' =>      empty($this->input->post('novo_classe_id', TRUE)) ? NULL : $this->input->post('novo_classe_id', TRUE),
            );

            $this->Cargo_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('cargo'));
        }
    }

    public function update($id)
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->session->set_flashdata('message', '');
        $row = $this->Cargo_model->get_by_id($id);
        $funcionario_tipo = $this->Funcionario_tipo_model->get_all_combobox();
        $classe = $this->Classe_model->get_all_combobox();
        $classe = $this->Classe_model->get_all_combobox();
        if ($row) {
            $data = array(
                'funcionario_tipo' => json($funcionario_tipo),
                'classe' => json($classe),
                'classe' => json($classe),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('cargo/update_action'),
                'cargo_id' => set_value('cargo_id', $row->cargo_id),
                'cargo_ds' => set_value('cargo_ds', $row->cargo_ds),
                'cargo_st' => set_value('cargo_st', $row->cargo_st),
                'cargo_dt_criacao' => set_value('cargo_dt_criacao', $row->cargo_dt_criacao),
                'cargo_dt_alteracao' => set_value('cargo_dt_alteracao', $row->cargo_dt_alteracao),
                'funcionario_tipo_id' => set_value('funcionario_tipo_id', $row->funcionario_tipo_id),
                'classe_id' => set_value('classe_id', $row->classe_id),
                'cargo_qtde' => set_value('cargo_qtde', $row->cargo_qtde),
                'novo_classe_id' => set_value('novo_classe_id', $row->novo_classe_id),
            );
            $this->load->view('cargo/Cargo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('cargo'));
        }
    }

    public function update_action()
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->_rules();
        $this->form_validation->set_rules('cargo_ds', 'cargo_ds', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('cargo_st', 'cargo_st', 'trim|numeric');
        $this->form_validation->set_rules('cargo_dt_criacao', 'cargo_dt_criacao', 'trim');
        $this->form_validation->set_rules('cargo_dt_alteracao', 'cargo_dt_alteracao', 'trim');
        $this->form_validation->set_rules('funcionario_tipo_id', 'funcionario_tipo_id', 'trim');
        $this->form_validation->set_rules('classe_id', 'classe_id', 'trim');
        $this->form_validation->set_rules('cargo_qtde', 'cargo_qtde', 'trim');
        $this->form_validation->set_rules('novo_classe_id', 'novo_classe_id', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('cargo_id', TRUE));
        } else {
            $data = array(
                'cargo_ds' => empty($this->input->post('cargo_ds', TRUE)) ? NULL : $this->input->post('cargo_ds', TRUE),
                'cargo_st' => empty($this->input->post('cargo_st', TRUE)) ? NULL : $this->input->post('cargo_st', TRUE),
                'cargo_dt_criacao' => empty($this->input->post('cargo_dt_criacao', TRUE)) ? NULL : $this->input->post('cargo_dt_criacao', TRUE),
                'cargo_dt_alteracao' => empty($this->input->post('cargo_dt_alteracao', TRUE)) ? NULL : $this->input->post('cargo_dt_alteracao', TRUE),
                'funcionario_tipo_id' => empty($this->input->post('funcionario_tipo_id', TRUE)) ? NULL : $this->input->post('funcionario_tipo_id', TRUE),
                'classe_id' => empty($this->input->post('classe_id', TRUE)) ? NULL : $this->input->post('classe_id', TRUE),
                'cargo_qtde' => empty($this->input->post('cargo_qtde', TRUE)) ? NULL : $this->input->post('cargo_qtde', TRUE),
                'novo_classe_id' => empty($this->input->post('novo_classe_id', TRUE)) ? NULL : $this->input->post('novo_classe_id', TRUE),
            );

            $this->Cargo_model->update($this->input->post('cargo_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('cargo'));
        }
    }

    public function delete($id)
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $row = $this->Cargo_model->get_by_id($id);

        if ($row) {
            if (@$this->Cargo_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('cargo'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('cargo'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('cargo'));
        }
    }

    public function _rules()
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
        $this->form_validation->set_rules('cargo_ds', 'cargo ds', 'trim|required');
        $this->form_validation->set_rules('cargo_st', 'cargo st', 'trim|required');
        $this->form_validation->set_rules('cargo_dt_criacao', 'cargo dt criacao', 'trim|required');
        $this->form_validation->set_rules('cargo_dt_alteracao', 'cargo dt alteracao', 'trim|required');
        $this->form_validation->set_rules('funcionario_tipo_id', 'funcionario tipo id', 'trim|required');
        $this->form_validation->set_rules('classe_id', 'classe id', 'trim|required');
        $this->form_validation->set_rules('cargo_qtde', 'cargo qtde', 'trim|required');
        $this->form_validation->set_rules('novo_classe_id', 'novo classe id', 'trim|required');

        $this->form_validation->set_rules('cargo_id', 'cargo_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);

        $param = array(

            array('cargo_ds', '=', $this->input->post('cargo_ds', TRUE)),
            array('cargo_st', '=', $this->input->post('cargo_st', TRUE)),
            array('cargo_dt_criacao', '=', $this->input->post('cargo_dt_criacao', TRUE)),
            array('cargo_dt_alteracao', '=', $this->input->post('cargo_dt_alteracao', TRUE)),
            array('funcionario_tipo_id', '=', $this->input->post('funcionario_tipo_id', TRUE)),
            array('classe_id', '=', $this->input->post('classe_id', TRUE)),
            array('cargo_qtde', '=', $this->input->post('cargo_qtde', TRUE)),
            array('novo_classe_id', '=', $this->input->post('novo_classe_id', TRUE)),
        ); //end array dos parametros

        $data = array(
            'cargo_data' => $this->Cargo_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('cargo/Cargo_pdf', $data, true);


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
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);

        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('cargo/open_pdf'),
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


        $this->load->view('cargo/Cargo_report', $data);
    }
}

/* End of file Cargo.php */
/* Local: ./application/controllers/Cargo.php */
/* Gerado por RGenerator - 2022-06-29 19:59:05 */