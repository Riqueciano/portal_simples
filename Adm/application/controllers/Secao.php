<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Secao extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Secao_model');
        $this->load->library('form_validation');
    }

    public function index()  
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'ascom']);
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        $sistema_id_filtro = intval($this->input->get('sistema_id_filtro'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'secao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'secao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');   
        } else {
            $config['base_url']  = base_url() . 'secao/';
            $config['first_url'] = base_url() . 'secao/';
        }

        $config['per_page'] = 100000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Secao_model->total_rows($q);
        // $secao = $this->Secao_model->get_limit_data($config['per_page'], $start, $q);
        $secao = $this->Secao_model->get_limit_data_filtro_sistema($config['per_page'], $start, $sistema_id_filtro);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'secao_data' => $secao,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),

            'total_rows' => $config['total_rows'],
            'start' => $start,
            'sistema_id_filtro' => $sistema_id_filtro,
        );
        $this->load->view('secao/Secao_list', $data);
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Secao_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('secao/create_action'),
                'secao_id' => $row->secao_id,
                'sistema_id' => $row->sistema_id,
                'secao_ds' => $row->secao_ds,
                'secao_st' => $row->secao_st,
                'secao_indice' => $row->secao_indice,
                'class_icon_bootstrap' => $row->class_icon_bootstrap,
            );
            $this->load->view('secao/Secao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('secao'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('secao/create_action'),
            'secao_id' => set_value('secao_id'),
            'sistema_id_correto' => set_value('sistema_id'),
            'secao_ds' => set_value('secao_ds'),
            'secao_st' => set_value('secao_st'),
            'secao_indice' => set_value('secao_indice'),
            'class_icon_bootstrap' => set_value('class_icon_bootstrap'),
        );
        $this->load->view('secao/Secao_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
    

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'sistema_id' =>      empty($this->input->post('sistema_id_correto', TRUE)) ? NULL : $this->input->post('sistema_id_correto', TRUE),
                'secao_ds' =>      empty($this->input->post('secao_ds', TRUE)) ? NULL : $this->input->post('secao_ds', TRUE),
                'secao_st' =>      empty($this->input->post('secao_st', TRUE)) ? 0 : $this->input->post('secao_st', TRUE),
                'secao_indice' =>      empty($this->input->post('secao_indice', TRUE)) ? 0 : $this->input->post('secao_indice', TRUE),
                'class_icon_bootstrap' =>      empty($this->input->post('class_icon_bootstrap', TRUE)) ? NULL : $this->input->post('class_icon_bootstrap', TRUE),
            );

            $this->Secao_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('secao/?sistema_id_filtro=').$this->input->post('sistema_id', TRUE));
        }
    }

    public function update($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Secao_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('secao/update_action'),
                'secao_id' => set_value('secao_id', $row->secao_id),
                'sistema_id_correto' => $row->sistema_id,
                'sistema_id_filtro' => $row->sistema_id,
                'secao_ds' => set_value('secao_ds', $row->secao_ds),
                'secao_st' => set_value('secao_st', $row->secao_st),
                'secao_indice' => set_value('secao_indice', $row->secao_indice),
                'class_icon_bootstrap' => set_value('class_icon_bootstrap', $row->class_icon_bootstrap),
            );
            $this->load->view('secao/Secao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro N�o Encontrado');
            redirect(site_url('secao'));
        }
    }

    public function update_action()
    {
        $this->_rules();
     

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('secao_id', TRUE));
        } else {
            $data = array(
                'sistema_id' => empty($this->input->post('sistema_id_correto', TRUE)) ? NULL : $this->input->post('sistema_id_correto', TRUE),
                'secao_ds' => empty($this->input->post('secao_ds', TRUE)) ? NULL : $this->input->post('secao_ds', TRUE),
                'secao_st' => empty($this->input->post('secao_st', TRUE)) ? 0 : $this->input->post('secao_st', TRUE),
                'secao_indice' => empty($this->input->post('secao_indice', TRUE)) ? 0 : $this->input->post('secao_indice', TRUE),
                'class_icon_bootstrap' => empty($this->input->post('class_icon_bootstrap', TRUE)) ? NULL : $this->input->post('class_icon_bootstrap', TRUE),
            );

            $this->Secao_model->update($this->input->post('secao_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            // redirect(site_url('secao'));
            redirect(site_url('secao/?sistema_id_filtro=').$this->input->post('sistema_id_correto', TRUE));
        }
    }

    public function delete($id)
    {
        $row = $this->Secao_model->get_by_id($id);

        if ($row) {
            if (@$this->Secao_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro N�O pode ser deletado por estar sendo utilizado!');
                redirect(site_url('secao'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('secao'));
        } else {
            $this->session->set_flashdata('message', 'Registro N�o Encontrado');
            redirect(site_url('secao'));
        }
    }

    public function _rules()
    {
        // $this->form_validation->set_rules('sistema_id', 'sistema id', 'trim|required');
        // $this->form_validation->set_rules('secao_ds', 'secao ds', 'trim|required');
        // $this->form_validation->set_rules('secao_st', 'secao st', 'trim|required');
        // $this->form_validation->set_rules('secao_indice', 'secao indice', 'trim|required');
        // $this->form_validation->set_rules('class_icon_bootstrap', 'class icon bootstrap', 'trim|required');

        $this->form_validation->set_rules('secao_id', 'secao_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {

        $param = array(

            array('sistema_id', '=', $this->input->post('sistema_id', TRUE)),
            array('secao_ds', '=', $this->input->post('secao_ds', TRUE)),
            array('secao_st', '=', $this->input->post('secao_st', TRUE)),
            array('secao_indice', '=', $this->input->post('secao_indice', TRUE)),
            array('class_icon_bootstrap', '=', $this->input->post('class_icon_bootstrap', TRUE)),
        ); //end array dos parametros

        $data = array(
            'secao_data' => $this->Secao_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('secao/Secao_pdf', $data, true);


        $formato = $this->input->post('formato', TRUE);
        $nome_arquivo = 'arquivo';
        if (rupper($formato) == 'EXCEL') {
            $pdf = $this->pdf->excel($html, $nome_arquivo);
        }

        $this->load->library('pdf');
        $pdf = $this->pdf->RReport();

        $caminhoImg = CPATH . 'imagens/Topo/bg_logo_min.png';

        //cabe�alho
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
            'action'        => site_url('secao/open_pdf'),
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


        $this->load->view('secao/Secao_report', $data);
    }


    public function ajax_busca_secao_pelo_sistema(){
        $sistema_id = (int)$this->input->get('sistema_id_temp', TRUE);
        // echo $sistema_id;exit;
        $param = array(
                        array('secao.sistema_id','=',$sistema_id)
        );
        $secao = $this->Secao_model->get_all_data($param);

        $json = array();
        foreach ($secao as $s) {
            $json[] = array(
                'secao_id' => (int)$s->secao_id,
                'secao_ds' => rupper(utf8_encode($s->secao_ds)),
            );
            
        }

        echo json_encode($json);
    }
}

/* End of file Secao.php */
/* Local: ./application/controllers/Secao.php */
/* Gerado por RGenerator - 2020-01-13 11:14:12 */