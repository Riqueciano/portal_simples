<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acao extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Acao_model');
        $this->load->model('Secao_model');
        $this->load->model('Sistema_model');
        $this->load->library('form_validation');
    }

    public function index()
    {


        $q = urldecode($this->input->get('q', TRUE));
        $secao_id = intval($this->input->get('secao_id'));
        $filtro_sistema_id = intval($this->input->get('filtro_sistema_id'));
        $start = intval($this->input->get('start'));


        if ($q <> '') {
            $config['base_url'] = base_url() . 'acao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'acao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'acao/';
            $config['first_url'] = base_url() . 'acao/';
        }

        $config['per_page'] = 1000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Acao_model->total_rows($q);
        $param = ' and 1=1';
        $tem_filtro =0;
        if (!empty($filtro_sistema_id)) {
            $param .= " and sistema.sistema_id = " . $filtro_sistema_id;
            $tem_filtro =1;
        }
        if (!empty($secao_id)) {
            $param .= " and secao.secao_id = " . $secao_id;
            $tem_filtro =1;
        }
        if (!empty($q)) {
            $param .= " and acao.acao_ds ilike '%$q%' ";
            $tem_filtro =1;
        }
        if($tem_filtro ==0){
            $param = " and 1=2";
        }
        $acao = $this->Acao_model->get_limit_data($config['per_page'], $start, $q, $param); //echo 1;exit;

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'acao_data' => $acao,
            //'action' => site_url('Acao'),
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'filtro_sistema_id' => empty($filtro_sistema_id) ? 0 : $filtro_sistema_id,
            'secao_id' => $secao_id,
        );
        $this->load->view('acao/Acao_list', $data);
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Acao_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('acao/create_action'),
                'acao_id' => $row->acao_id,
                'secao_id' => $row->secao_id,
                'sistema_id_temp' => $row->sistema_id,
                'acao_ds' => $row->acao_ds,
                'acao_url' => $row->acao_url,
                'acao_st' => $row->acao_st,
                'acao_indice' => $row->acao_indice,
            );
            $this->load->view('acao/Acao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('acao'));
        }
    }

    public function create()
    {
        $sistema_id = $this->input->get('sistema_id', TRUE);
        $sistema = $this->Sistema_model->get_by_id($sistema_id);
        $action = site_url('acao/create_action');
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => $action,
            'acao_id' => set_value('acao_id'),
            'secao_id' => set_value('secao_id'),
            'sistema_id_temp' => $sistema_id,
            'sistema_nm' => $sistema->sistema_nm,
            'acao_ds' => set_value('acao_ds'),
            'acao_url' => set_value('acao_url'),
            'acao_st' => 0, //set_value('acao_st'),
            'acao_indice' => set_value('acao_indice'),
        );
        $this->load->view('acao/Acao_form', $data);
    }


    public function muda_status($acao_id)
    {
        $acao = $this->Acao_model->get_by_id($acao_id);
        $secao = $this->Secao_model->get_by_id($acao->secao_id);


        if ($acao->acao_st == 0) {
            $novo_status = 1;
        } else {
            $novo_status = 0;
        }
        $data = array(
            'acao_st' => $novo_status
        );

        $this->Acao_model->update($acao_id, $data);
        redirect(site_url('acao/?filtro_sistema_id=' . $secao->sistema_id . "&secao_id=" . $acao->secao_id));
    }

    public function create_action()
    {
        // echo 1;
        // exit;
        $this->_rules();
        $this->form_validation->set_rules('secao_id', NULL, 'trim|required');
        $this->form_validation->set_rules('acao_descricao', NULL, 'trim|required|max_length[50]');
        $this->form_validation->set_rules('acao_url', NULL, 'trim|required|max_length[50]');
        $this->form_validation->set_rules('acao_st', NULL, 'trim|numeric');
        $this->form_validation->set_rules('acao_indice', NULL, 'trim');

        if ($this->form_validation->run() == FALSE) {
            // echo 1;
            // exit;
            $this->create();
        } else {
            $data = array(
                'secao_id' => empty($this->input->post('secao_id', TRUE)) ? NULL : $this->input->post('secao_id', TRUE),
                // 'sistema_id' => empty($this->input->post('sistema_id_temp', TRUE)) ? NULL : $this->input->post('sistema_id_temp', TRUE),
                'acao_ds' => empty($this->input->post('acao_descricao', TRUE)) ? NULL : ($this->input->post('acao_descricao', TRUE)),
                'acao_url' => empty($this->input->post('acao_url', TRUE)) ? NULL : $this->input->post('acao_url', TRUE),
                'acao_st' => 0,
                'acao_indice' => empty($this->input->post('acao_indice', TRUE)) ? NULL : $this->input->post('acao_indice', TRUE),
            );
            // print_r($data);//exit;
            $this->Acao_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('acao/?filtro_sistema_id=') . $this->input->post('sistema_id_temp', TRUE));
        }
    }

    public function update($id)
    {
        // echo 'AÇÃO';
        // exit;
        $this->session->set_flashdata('message', '');
        $row = $this->Acao_model->get_by_id($id);

        $secao = $this->Secao_model->get_by_id($row->secao_id);

        $sistema_id = $secao->sistema_id;
        $sistema = $this->Sistema_model->get_by_id($sistema_id);
        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('acao/update_action'),
                'acao_id' => set_value('acao_id', $row->acao_id),
                'secao_id' => set_value('secao_id', $row->secao_id),
                'acao_ds' => set_value('acao_ds', $row->acao_ds),
                'acao_url' => set_value('acao_url', $row->acao_url),
                'acao_st' => set_value('acao_st', $row->acao_st),
                'acao_indice' => set_value('acao_indice', $row->acao_indice),
                'sistema_id_temp' => $sistema_id,
                'sistema_nm' => $sistema->sistema_nm,
            );
            $this->load->view('acao/Acao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro N?o Encontrado');
            redirect(site_url('acao'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('secao_id', 'secao_id', 'trim|required');
        $this->form_validation->set_rules('sistema_id_temp', 'sistema_id', 'trim|required');
        $this->form_validation->set_rules('acao_descricao', 'acao_descricao', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('acao_url', 'acao_url', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('acao_st', 'acao_st', 'trim|numeric');
        $this->form_validation->set_rules('acao_indice', 'acao_indice', 'trim');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('acao_id', TRUE));
        } else {
            $secao = $this->Secao_model->get_by_id($this->input->post('secao_id', TRUE));
            $data = array(
                'secao_id' => empty($this->input->post('secao_id', TRUE)) ? NULL : $this->input->post('secao_id', TRUE),
                // 'sistema_id' => empty($this->input->post('sistema_id_temp', TRUE)) ? NULL : $this->input->post('sistema_id_temp', TRUE),
                'acao_ds' => empty($this->input->post('acao_descricao', TRUE)) ? NULL :  ($this->input->post('acao_descricao', TRUE)),
                'acao_url' => empty($this->input->post('acao_url', TRUE)) ? NULL : $this->input->post('acao_url', TRUE),
                'acao_st' => 0, // empty($this->input->post('acao_st', TRUE)) ? 0 : $this->input->post('acao_st', TRUE),
                'acao_indice' => empty($this->input->post('acao_indice', TRUE)) ? NULL : $this->input->post('acao_indice', TRUE),
            );
            // var_dump($data );exit;
            $this->Acao_model->update($this->input->post('acao_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('acao/?filtro_sistema_id=' . $secao->sistema_id . '&secao_id=' . $this->input->post('secao_id', TRUE)));
        }
    }

    public function delete($id)
    {
        $row = $this->Acao_model->get_by_id($id);

        if ($row) {
            if (@$this->Acao_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro N?O pode ser deletado por estar sendo utilizado!');
                redirect(site_url('acao'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('acao'));
        } else {
            $this->session->set_flashdata('message', 'Registro N?o Encontrado');
            redirect(site_url('acao'));
        }
    }

    public function _rules()
    {
        // $this->form_validation->set_rules('secao_id', 'secao id', 'trim|required');
        // $this->form_validation->set_rules('acao_ds', 'acao ds', 'trim|required');
        // $this->form_validation->set_rules('acao_url', 'acao url', 'trim|required');
        // $this->form_validation->set_rules('acao_st', 'acao st', 'trim|required');
        // $this->form_validation->set_rules('acao_indice', 'acao indice', 'trim|required');

        $this->form_validation->set_rules('acao_id', 'acao_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function open_pdf()
    {

        $param = array(
            array('secao_id', '=', $this->input->post('secao_id', TRUE)),
            array('acao_ds', '=', $this->input->post('acao_ds', TRUE)),
            array('acao_url', '=', $this->input->post('acao_url', TRUE)),
            array('acao_st', '=', $this->input->post('acao_st', TRUE)),
            array('acao_indice', '=', $this->input->post('acao_indice', TRUE)),
        ); //end array dos parametros

        $data = array(
            'acao_data' => $this->Acao_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html = $this->load->view('acao/Acao_pdf', $data, true);


        $formato = $this->input->post('formato', TRUE);
        $nome_arquivo = 'arquivo';
        if (rupper($formato) == 'EXCEL') {
            $pdf = $this->pdf->excel($html, $nome_arquivo);
        }

        $this->load->library('pdf');
        $pdf = $this->pdf->RReport();

        $caminhoImg = CPATH . 'imagens/Topo/bg_logo_min.png';

        //cabe?alho
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
            'button' => 'Gerar',
            'controller' => 'report',
            'action' => site_url('acao/open_pdf'),
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


        $this->load->view('acao/Acao_report', $data);
    }

    public function ajax_busca_secao_pelo_sistema()
    {
        $sistema_id = (int)$this->input->get('sistema_id_temp', TRUE);
        //    echo $sistema_id;exit; 
        $param = array(
            array('sistema.sistema_id', '=', $sistema_id),
            array('secao.secao_st', '=', 0),
        );
        $acao = $this->Secao_model->get_limit_data_filtro_sistema(99999, 0, $sistema_id);

        $json = array();
        foreach ($acao as $s) {
            $json[] = array(
                'secao_id' => (int)$s->secao_id,
                'secao_ds' => strtoupper(rupper(($s->secao_ds))),
            );
        }
        echo json_encode($json);
    }


    public function ajax_carrega_acao_por_sistema()
    {
        $sistema_id = (int)$this->input->post('sistema_id_correto', TRUE);
        //   echo $sistema_id;exit; 
        // $param = array(
        //     array('sistema.sistema_id', '=', $sistema_id),
        //     array('secao.secao_st', '=', 0),
        // );
        //    var_dump($param);exit;
        $param = "sistema.sistema_id =  " . $sistema_id;
        $acao = $this->Acao_model->get_all_param($param);

        $json = array();
        foreach ($acao as $s) {
            $json[] = array(
                'acao_id' => (int)$s->acao_id,
                'acao_ds' => utf8_decode($s->acao_ds),
            );
        }
        print_r( $acao);exit;
        echo json_encode($json);
    }
}

/* End of file Acao.php */
/* Local: ./application/controllers/Acao.php */
/* Gerado por RGenerator - 2020-01-13 15:19:44 */