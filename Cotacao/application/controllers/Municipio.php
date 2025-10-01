<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Municipio extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Municipio_model');
        $this->load->model('Territorio_model');

        // $this->load->model('Setaf_model');

        // $this->load->model('Instrumento_model');
        $this->load->library('form_validation');
    }

    public function ajax_carrega_municipios_por_territorio($cotacao_territorio_id = 0)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);
        $cotacao_territorio_id = (int)$cotacao_territorio_id;
        if ($cotacao_territorio_id == null) {
            $cotacao_territorio_id = (int)$this->input->get('territorio_id');
        }

        $param = "municipio.ativo =1 and municipio.territorio_id = $cotacao_territorio_id";
        $mun = $this->Municipio_model->get_all_combobox($param, 'upper(remove_acentuacao(municipio.municipio_nm))');
        //   echo_pre($this->db->last_query());
        echo json($mun);
    }
    public function ajax_carrega_municipios_por_territorio_result_completo($cotacao_territorio_id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);
        $cotacao_territorio_id = (int)$cotacao_territorio_id;

        $param = "municipio.ativo =1 and municipio.territorio_id = $cotacao_territorio_id";
        $mun = $this->Municipio_model->get_all_data_param($param, 'upper(remove_acentuacao(municipio.municipio_nm))');
        // echo_pre($this->db->last_query());
        echo json($mun);
    }

    public function index()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'municipio/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'municipio/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'municipio/';
            $config['first_url'] = base_url() . 'municipio/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Municipio_model->total_rows($q);
        $municipio = $this->Municipio_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($municipio);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'municipio_data' => json($municipio),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('municipio/Municipio_list', forFrontVue($data));
    }

    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->session->set_flashdata('message', '');
        $row = $this->Municipio_model->get_by_id($id);
        $territorio = $this->Territorio_model->get_all_combobox();
        $setaf = $this->Setaf_model->get_all_combobox();
        $instrumento = $this->Instrumento_model->get_all_combobox();
        if ($row) {
            $data = array(
                'territorio' => json($territorio),
                'setaf' => json($setaf),
                'instrumento' => json($instrumento),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('municipio/create_action'),
                'municipio_id' => $row->municipio_id,
                'municipio_nm' => $row->municipio_nm,
                'municipio_st' => $row->municipio_st,
                'territorio_id' => $row->territorio_id,
                'estado_uf' => $row->estado_uf,
                'flag_capital' => $row->flag_capital,
                'incremento' => $row->incremento,
                'setaf_id' => $row->setaf_id,
                'adesao_semaf' => $row->adesao_semaf,
                'dt_adesao_semaf' => $row->dt_adesao_semaf,
                'adesao_instrumento_id' => $row->adesao_instrumento_id,
                'adesao_instrumento_num' => $row->adesao_instrumento_num,
                'cod_ibge' => $row->cod_ibge,
                'cod_veri_ibge' => $row->cod_veri_ibge,
                'ativo' => $row->ativo,
                'flag_litoral' => $row->flag_litoral,
                'geom' => $row->geom,
            );
            $this->load->view('municipio/Municipio_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('municipio'));
        }
    }

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $territorio = $this->Territorio_model->get_all_combobox();
        $setaf = $this->Setaf_model->get_all_combobox();
        $instrumento = $this->Instrumento_model->get_all_combobox();
        $data = array(
            'territorio' => json($territorio),
            'setaf' => json($setaf),
            'instrumento' => json($instrumento),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('municipio/create_action'),
            'municipio_id' => set_value('municipio_id'),
            'municipio_nm' => set_value('municipio_nm'),
            'municipio_st' => set_value('municipio_st'),
            'territorio_id' => set_value('territorio_id'),
            'estado_uf' => set_value('estado_uf'),
            'flag_capital' => set_value('flag_capital'),
            'incremento' => set_value('incremento'),
            'setaf_id' => set_value('setaf_id'),
            'adesao_semaf' => set_value('adesao_semaf'),
            'dt_adesao_semaf' => set_value('dt_adesao_semaf'),
            'adesao_instrumento_id' => set_value('adesao_instrumento_id'),
            'adesao_instrumento_num' => set_value('adesao_instrumento_num'),
            'cod_ibge' => set_value('cod_ibge'),
            'cod_veri_ibge' => set_value('cod_veri_ibge'),
            'ativo' => set_value('ativo'),
            'flag_litoral' => set_value('flag_litoral'),
            'geom' => set_value('geom'),
        );
        $this->load->view('municipio/Municipio_form', forFrontVue($data));
    }

    public function create_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->_rules();
        $this->form_validation->set_rules('municipio_nm', NULL, 'trim|max_length[150]');
        $this->form_validation->set_rules('municipio_st', NULL, 'trim|integer');
        $this->form_validation->set_rules('territorio_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('estado_uf', NULL, 'trim|max_length[2]');
        $this->form_validation->set_rules('flag_capital', NULL, 'trim|integer');
        $this->form_validation->set_rules('incremento', NULL, 'trim|decimal');
        $this->form_validation->set_rules('setaf_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('adesao_semaf', NULL, 'trim|integer');
        $this->form_validation->set_rules('dt_adesao_semaf', NULL, 'trim');
        $this->form_validation->set_rules('adesao_instrumento_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('adesao_instrumento_num', NULL, 'trim|max_length[40]');
        $this->form_validation->set_rules('cod_ibge', NULL, 'trim|max_length[20]');
        $this->form_validation->set_rules('cod_veri_ibge', NULL, 'trim|max_length[20]');
        $this->form_validation->set_rules('ativo', NULL, 'trim|integer');
        $this->form_validation->set_rules('flag_litoral', NULL, 'trim|integer');
        $this->form_validation->set_rules('geom', NULL, 'trim|max_length[9999999]');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'municipio_nm' =>      empty($this->input->post('municipio_nm', TRUE)) ? NULL : $this->input->post('municipio_nm', TRUE),
                'municipio_st' =>      empty($this->input->post('municipio_st', TRUE)) ? NULL : $this->input->post('municipio_st', TRUE),
                'territorio_id' =>      empty($this->input->post('territorio_id', TRUE)) ? NULL : $this->input->post('territorio_id', TRUE),
                'estado_uf' =>      empty($this->input->post('estado_uf', TRUE)) ? NULL : $this->input->post('estado_uf', TRUE),
                'flag_capital' =>      empty($this->input->post('flag_capital', TRUE)) ? NULL : $this->input->post('flag_capital', TRUE),
                'incremento' =>      empty($this->input->post('incremento', TRUE)) ? NULL : $this->input->post('incremento', TRUE),
                'setaf_id' =>      empty($this->input->post('setaf_id', TRUE)) ? NULL : $this->input->post('setaf_id', TRUE),
                'adesao_semaf' =>      empty($this->input->post('adesao_semaf', TRUE)) ? NULL : $this->input->post('adesao_semaf', TRUE),
                'dt_adesao_semaf' =>      empty($this->input->post('dt_adesao_semaf', TRUE)) ? NULL : $this->input->post('dt_adesao_semaf', TRUE),
                'adesao_instrumento_id' =>      empty($this->input->post('adesao_instrumento_id', TRUE)) ? NULL : $this->input->post('adesao_instrumento_id', TRUE),
                'adesao_instrumento_num' =>      empty($this->input->post('adesao_instrumento_num', TRUE)) ? NULL : $this->input->post('adesao_instrumento_num', TRUE),
                'cod_ibge' =>      empty($this->input->post('cod_ibge', TRUE)) ? NULL : $this->input->post('cod_ibge', TRUE),
                'cod_veri_ibge' =>      empty($this->input->post('cod_veri_ibge', TRUE)) ? NULL : $this->input->post('cod_veri_ibge', TRUE),
                'ativo' =>      empty($this->input->post('ativo', TRUE)) ? NULL : $this->input->post('ativo', TRUE),
                'flag_litoral' =>      empty($this->input->post('flag_litoral', TRUE)) ? NULL : $this->input->post('flag_litoral', TRUE),
                'geom' =>      empty($this->input->post('geom', TRUE)) ? NULL : $this->input->post('geom', TRUE),
            );

            $this->Municipio_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('municipio'));
        }
    }

    public function update($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->session->set_flashdata('message', '');
        $row = $this->Municipio_model->get_by_id($id);
        $territorio = $this->Territorio_model->get_all_combobox();
        $setaf = $this->Setaf_model->get_all_combobox();
        $instrumento = $this->Instrumento_model->get_all_combobox();
        if ($row) {
            $data = array(
                'territorio' => json($territorio),
                'setaf' => json($setaf),
                'instrumento' => json($instrumento),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('municipio/update_action'),
                'municipio_id' => set_value('municipio_id', $row->municipio_id),
                'municipio_nm' => set_value('municipio_nm', $row->municipio_nm),
                'municipio_st' => set_value('municipio_st', $row->municipio_st),
                'territorio_id' => set_value('territorio_id', $row->territorio_id),
                'estado_uf' => set_value('estado_uf', $row->estado_uf),
                'flag_capital' => set_value('flag_capital', $row->flag_capital),
                'incremento' => set_value('incremento', $row->incremento),
                'setaf_id' => set_value('setaf_id', $row->setaf_id),
                'adesao_semaf' => set_value('adesao_semaf', $row->adesao_semaf),
                'dt_adesao_semaf' => set_value('dt_adesao_semaf', $row->dt_adesao_semaf),
                'adesao_instrumento_id' => set_value('adesao_instrumento_id', $row->adesao_instrumento_id),
                'adesao_instrumento_num' => set_value('adesao_instrumento_num', $row->adesao_instrumento_num),
                'cod_ibge' => set_value('cod_ibge', $row->cod_ibge),
                'cod_veri_ibge' => set_value('cod_veri_ibge', $row->cod_veri_ibge),
                'ativo' => set_value('ativo', $row->ativo),
                'flag_litoral' => set_value('flag_litoral', $row->flag_litoral),
                'geom' => set_value('geom', $row->geom),
            );
            $this->load->view('municipio/Municipio_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('municipio'));
        }
    }

    public function update_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->_rules();
        $this->form_validation->set_rules('municipio_nm', 'municipio_nm', 'trim|max_length[150]');
        $this->form_validation->set_rules('municipio_st', 'municipio_st', 'trim|integer');
        $this->form_validation->set_rules('territorio_id', 'territorio_id', 'trim|integer');
        $this->form_validation->set_rules('estado_uf', 'estado_uf', 'trim|max_length[2]');
        $this->form_validation->set_rules('flag_capital', 'flag_capital', 'trim|integer');
        $this->form_validation->set_rules('incremento', 'incremento', 'trim|decimal');
        $this->form_validation->set_rules('setaf_id', 'setaf_id', 'trim|integer');
        $this->form_validation->set_rules('adesao_semaf', 'adesao_semaf', 'trim|integer');
        $this->form_validation->set_rules('dt_adesao_semaf', 'dt_adesao_semaf', 'trim');
        $this->form_validation->set_rules('adesao_instrumento_id', 'adesao_instrumento_id', 'trim|integer');
        $this->form_validation->set_rules('adesao_instrumento_num', 'adesao_instrumento_num', 'trim|max_length[40]');
        $this->form_validation->set_rules('cod_ibge', 'cod_ibge', 'trim|max_length[20]');
        $this->form_validation->set_rules('cod_veri_ibge', 'cod_veri_ibge', 'trim|max_length[20]');
        $this->form_validation->set_rules('ativo', 'ativo', 'trim|integer');
        $this->form_validation->set_rules('flag_litoral', 'flag_litoral', 'trim|integer');
        $this->form_validation->set_rules('geom', 'geom', 'trim|max_length[9999999]');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('municipio_id', TRUE));
        } else {
            $data = array(
                'municipio_nm' => empty($this->input->post('municipio_nm', TRUE)) ? NULL : $this->input->post('municipio_nm', TRUE),
                'municipio_st' => empty($this->input->post('municipio_st', TRUE)) ? NULL : $this->input->post('municipio_st', TRUE),
                'territorio_id' => empty($this->input->post('territorio_id', TRUE)) ? NULL : $this->input->post('territorio_id', TRUE),
                'estado_uf' => empty($this->input->post('estado_uf', TRUE)) ? NULL : $this->input->post('estado_uf', TRUE),
                'flag_capital' => empty($this->input->post('flag_capital', TRUE)) ? NULL : $this->input->post('flag_capital', TRUE),
                'incremento' => empty($this->input->post('incremento', TRUE)) ? NULL : $this->input->post('incremento', TRUE),
                'setaf_id' => empty($this->input->post('setaf_id', TRUE)) ? NULL : $this->input->post('setaf_id', TRUE),
                'adesao_semaf' => empty($this->input->post('adesao_semaf', TRUE)) ? NULL : $this->input->post('adesao_semaf', TRUE),
                'dt_adesao_semaf' => empty($this->input->post('dt_adesao_semaf', TRUE)) ? NULL : $this->input->post('dt_adesao_semaf', TRUE),
                'adesao_instrumento_id' => empty($this->input->post('adesao_instrumento_id', TRUE)) ? NULL : $this->input->post('adesao_instrumento_id', TRUE),
                'adesao_instrumento_num' => empty($this->input->post('adesao_instrumento_num', TRUE)) ? NULL : $this->input->post('adesao_instrumento_num', TRUE),
                'cod_ibge' => empty($this->input->post('cod_ibge', TRUE)) ? NULL : $this->input->post('cod_ibge', TRUE),
                'cod_veri_ibge' => empty($this->input->post('cod_veri_ibge', TRUE)) ? NULL : $this->input->post('cod_veri_ibge', TRUE),
                'ativo' => empty($this->input->post('ativo', TRUE)) ? NULL : $this->input->post('ativo', TRUE),
                'flag_litoral' => empty($this->input->post('flag_litoral', TRUE)) ? NULL : $this->input->post('flag_litoral', TRUE),
                'geom' => empty($this->input->post('geom', TRUE)) ? NULL : $this->input->post('geom', TRUE),
            );

            $this->Municipio_model->update($this->input->post('municipio_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('municipio'));
        }
    }

    /*
    public function delete($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $row = $this->Municipio_model->get_by_id($id);

        if ($row) {
            if (@$this->Municipio_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('municipio'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('municipio'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('municipio'));
        }
    }
        */

    public function _rules()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $this->form_validation->set_rules('municipio_nm', 'municipio nm', 'trim|required');
        $this->form_validation->set_rules('municipio_st', 'municipio st', 'trim|required');
        $this->form_validation->set_rules('territorio_id', 'territorio id', 'trim|required');
        $this->form_validation->set_rules('estado_uf', 'estado uf', 'trim|required');
        $this->form_validation->set_rules('flag_capital', 'flag capital', 'trim|required');
        $this->form_validation->set_rules('incremento', 'incremento', 'trim|required');
        $this->form_validation->set_rules('setaf_id', 'setaf id', 'trim|required');
        $this->form_validation->set_rules('adesao_semaf', 'adesao semaf', 'trim|required');
        $this->form_validation->set_rules('dt_adesao_semaf', 'dt adesao semaf', 'trim|required');
        $this->form_validation->set_rules('adesao_instrumento_id', 'adesao instrumento id', 'trim|required');
        $this->form_validation->set_rules('adesao_instrumento_num', 'adesao instrumento num', 'trim|required');
        $this->form_validation->set_rules('cod_ibge', 'cod ibge', 'trim|required');
        $this->form_validation->set_rules('cod_veri_ibge', 'cod veri ibge', 'trim|required');
        $this->form_validation->set_rules('ativo', 'ativo', 'trim|required');
        $this->form_validation->set_rules('flag_litoral', 'flag litoral', 'trim|required');
        $this->form_validation->set_rules('geom', 'geom', 'trim|required');

        $this->form_validation->set_rules('municipio_id', 'municipio_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);

        $param = array(

            array('municipio_nm', '=', $this->input->post('municipio_nm', TRUE)),
            array('municipio_st', '=', $this->input->post('municipio_st', TRUE)),
            array('territorio_id', '=', $this->input->post('territorio_id', TRUE)),
            array('estado_uf', '=', $this->input->post('estado_uf', TRUE)),
            array('flag_capital', '=', $this->input->post('flag_capital', TRUE)),
            array('incremento', '=', $this->input->post('incremento', TRUE)),
            array('setaf_id', '=', $this->input->post('setaf_id', TRUE)),
            array('adesao_semaf', '=', $this->input->post('adesao_semaf', TRUE)),
            array('dt_adesao_semaf', '=', $this->input->post('dt_adesao_semaf', TRUE)),
            array('adesao_instrumento_id', '=', $this->input->post('adesao_instrumento_id', TRUE)),
            array('adesao_instrumento_num', '=', $this->input->post('adesao_instrumento_num', TRUE)),
            array('cod_ibge', '=', $this->input->post('cod_ibge', TRUE)),
            array('cod_veri_ibge', '=', $this->input->post('cod_veri_ibge', TRUE)),
            array('ativo', '=', $this->input->post('ativo', TRUE)),
            array('flag_litoral', '=', $this->input->post('flag_litoral', TRUE)),
            array('geom', '=', $this->input->post('geom', TRUE)),
        ); //end array dos parametros

        $data = array(
            'municipio_data' => $this->Municipio_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('municipio/Municipio_pdf', $data, true);


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
        PROTECAO_PERFIL(['Administrador', 'Gestor']);

        $data = array(
            'button'        => 'Gerar',
            'controller'    => 'report',
            'action'        => site_url('municipio/open_pdf'),
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


        $this->load->view('municipio/Municipio_report', forFrontVue($data));
    }
}

/* End of file Municipio.php */
/* Local: ./application/controllers/Municipio.php */
/* Gerado por RGenerator - 2022-09-05 18:19:52 */