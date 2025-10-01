<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sistema extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Sistema_model');
        $this->load->model('Menu_model');
        $this->load->model('Menu_item_model');
        $this->load->model('Pessoa_model');
        $this->load->library('form_validation');
    }


    private function limpa_session_sistema()
    {
        unset($_SESSION['tipo_usuario_id']);
        unset($_SESSION['TipoUsuario']);
        unset($_SESSION['tipo_usuario_ds']);
    }


    // private function getPapelParedeSemanaDoMes($data)
    // {
    //     // Converte a data para um objeto DateTime
    //     $data = new DateTime($data);
    
    //     // Obter o número do dia do mês
    //     $diaDoMes = (int)$data->format('d');
    
    //     // Calcula a semana do mês (1 a 4)
    //     if ($diaDoMes <= 7) {
    //         return PAPEL_PAREDE[1];
    //     } elseif ($diaDoMes <= 14) {
    //         return PAPEL_PAREDE[2];
    //     } elseif ($diaDoMes <= 21) {
    //         return PAPEL_PAREDE[3];
    //     } elseif ($diaDoMes <= 28) {
    //         return PAPEL_PAREDE[4];
    //     } else {
    //         // Se for 29, 30 ou 31, pode retornar o PAPEL_PAREDE[2], ou qualquer outra lógica
    //         return PAPEL_PAREDE[2];
    //     }
    // }

    public function index()
    {

        PROTECAO_LOGIN(true);
        //   ECHO $_SESSION['pessoa_id'];exit;

        $this->limpa_session_sistema();
        if (empty($_SESSION['pessoa_id'])) {
            exit;
        }

        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'sistema/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'sistema/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'sistema/';
            $config['first_url'] = base_url() . 'sistema/';
        }

        $config['per_page'] = 1000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Sistema_model->total_rows($q);

        //echo $_SESSION['pessoa_id'];EXIT;
        //$sistema = $this->Sistema_model->get_limit_data($config['per_page'], $start, $q);
        //não exibir os sistemas q rodam exclusivamente no php 5, ambo vão para a porta 85 (solução temporaria)
        //diarias, passagem, adiantamento
        $param = " and sistema.sistema_id not in (24,30,106,2)";
        // $param = " ";
        $sistema = $this->Sistema_model->get_sistema_usuario($_SESSION['pessoa_id'], $q, $param);

        // $sistema_externo = array(
        //     array(
        //         'sistema_id' => 1,
        //         'sistema_nm' => 'Sair',
        //         'sistema_ds' => 'Sair',
        //         'sistema_icone' => 'sair.png',
        //         'sistema_st' => 1,
        //         'sistema_dt_criacao' => date('Y-m-d H:i: s'),
        //         'sistema_dt_alteracao' => date('Y-m-d H:i:s'),
        //         'sistema_url' => 'https://outlook.office.com/owa/'
        //     ),
        //     array(
        //         'sistema_id' => 2,
        //         'sistema_nm' => 'Outlook',
        //         'sistema_ds' => 'Outlook',
        //         'sistema_icone' => 'outlook.png',
        //         'sistema_st' => 1,
        //         'sistema_dt_criacao' => date('Y-m-d H:i:s'),
        //         'sistema_dt_alteracao' => date('Y-m-d H:i:s'),
        //         'sistema_url' => 'https://outlook.office.com/owa/'
        //     ),
        // );


        // $sistema = array_merge($sistema, $sistema_externo);


        $this->load->library('pagination');
        $this->pagination->initialize($config);


        $pessoa = $this->Pessoa_model->get_by_id($_SESSION['pessoa_id']);

        $param = array(
            array('1', '=', '1')
        );
        $menu = $this->Menu_model->get_all_data($param);
        $menu_item = $this->Menu_item_model->get_all_data($param);

        $pessoa_nm_temp = explode(' ', $_SESSION['pessoa_nm']);

        $data = array(
            'sistema_data' => json($sistema),
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'menu' => $menu,
            'menu_item' => $menu_item,
            'pessoa_nm_temp' => $pessoa_nm_temp[0],
            'usuario_login' => $_SESSION['usuario_login'],
            // 'papel_parede' => $this->getPapelParedeSemanaDoMes(date('Y-m-d')),
        );
        $this->load->view('sistema/Sistema_list', forFrontVue($data));
    }


    public function index_json($pessoa_id = 249)
    {
        PROTECAO_LOGIN(true);
        $this->limpa_session_sistema();
        //  print_r($_SESSION);

        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'sistema/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'sistema/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'sistema/';
            $config['first_url'] = base_url() . 'sistema/';
        }

        $config['per_page'] = 1000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Sistema_model->total_rows($q);

        //echo $_SESSION['pessoa_id'];EXIT;
        //$sistema = $this->Sistema_model->get_limit_data($config['per_page'], $start, $q);
        $sistema = $this->Sistema_model->get_sistema_usuario($pessoa_id, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);


        $pessoa = $this->Pessoa_model->get_by_id($pessoa_id);

        $param = array(
            array('1', '=', '1')
        );
        $menu = $this->Menu_model->get_all_data($param);
        $menu_item = $this->Menu_item_model->get_all_data($param);

        $pessoa_nm_temp = explode(' ', $pessoa->pessoa_nm);

        $data = array(
            'sistema_data' => ($sistema),
            'q' => $q,
            // 'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'menu' => ($menu),
            'menu_item' => ($menu_item),
            'pessoa_nm_temp' => ($pessoa_nm_temp[0]),
            // 'usuario_login' =>  ($_SESSION['usuario_login']) 
        );


        $data = anything_to_utf8($data);
        // echo ($data);exit;
        // echo_pre(var_dump($sistema));
        echo json_encode($data['sistema_data']);
    }

    public function read($id)
    {
        PROTECAO_LOGIN(true);
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'ascom']);
        $this->session->set_flashdata('message', '');
        $row = $this->Sistema_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('sistema/create_action'),
                'sistema_id' => $row->sistema_id,
                'sistema_nm' => $row->sistema_nm,
                'sistema_ds' => $row->sistema_ds,
                'sistema_icone' => $row->sistema_icone,
                'sistema_st' => $row->sistema_st,
                'sistema_dt_criacao' => $row->sistema_dt_criacao,
                'sistema_dt_alteracao' => $row->sistema_dt_alteracao,
                'sistema_url' => $row->sistema_url,
            );
            $this->load->view('sistema/Sistema_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('sistema'));
        }
    }

    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'ascom']);
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('sistema/create_action'),
            'sistema_id' => set_value('sistema_id'),
            'sistema_nm' => set_value('sistema_nm'),
            'sistema_ds' => set_value('sistema_ds'),
            'sistema_icone' => set_value('sistema_icone'),
            'sistema_st' => set_value('sistema_st'),
            'sistema_dt_criacao' => set_value('sistema_dt_criacao'),
            'sistema_dt_alteracao' => set_value('sistema_dt_alteracao'),
            'sistema_url' => set_value('sistema_url'),
        );
        $this->load->view('sistema/Sistema_form', $data);
    }

    // public function create_action()
    // {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    //     $this->_rules();
    //     $this->form_validation->set_rules('sistema_nm', NULL, 'trim|required|max_length[50]');
    //     $this->form_validation->set_rules('sistema_ds', NULL, 'trim|max_length[255]');
    //     $this->form_validation->set_rules('sistema_icone', NULL, 'trim|max_length[50]');
    //     $this->form_validation->set_rules('sistema_st', NULL, 'trim|numeric');
    //     $this->form_validation->set_rules('sistema_dt_criacao', NULL, 'trim|required');
    //     $this->form_validation->set_rules('sistema_dt_alteracao', NULL, 'trim');
    //     $this->form_validation->set_rules('sistema_url', NULL, 'trim|max_length[100]');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->create();
    //     } else {
    //         $data = array(
    //             'sistema_nm' => empty($this->input->post('sistema_nm', TRUE)) ? NULL : $this->input->post('sistema_nm', TRUE),
    //             'sistema_ds' => empty($this->input->post('sistema_ds', TRUE)) ? NULL : $this->input->post('sistema_ds', TRUE),
    //             'sistema_icone' => empty($this->input->post('sistema_icone', TRUE)) ? NULL : $this->input->post('sistema_icone', TRUE),
    //             'sistema_st' => empty($this->input->post('sistema_st', TRUE)) ? NULL : $this->input->post('sistema_st', TRUE),
    //             'sistema_dt_criacao' => empty($this->input->post('sistema_dt_criacao', TRUE)) ? NULL : $this->input->post('sistema_dt_criacao', TRUE),
    //             'sistema_dt_alteracao' => empty($this->input->post('sistema_dt_alteracao', TRUE)) ? NULL : $this->input->post('sistema_dt_alteracao', TRUE),
    //             'sistema_url' => empty($this->input->post('sistema_url', TRUE)) ? NULL : $this->input->post('sistema_url', TRUE),
    //         );

    //         $this->Sistema_model->insert($data);
    //         $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
    //         redirect(site_url('sistema'));
    //     }
    // }

    // public function update($id)
    // {PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    //     $this->session->set_flashdata('message', '');
    //     $row = $this->Sistema_model->get_by_id($id);

    //     if ($row) {
    //         $data = array(
    //             'button' => 'Atualizar',
    //             'controller' => 'update',
    //             'action' => site_url('sistema/update_action'),
    //             'sistema_id' => set_value('sistema_id', $row->sistema_id),
    //             'sistema_nm' => set_value('sistema_nm', $row->sistema_nm),
    //             'sistema_ds' => set_value('sistema_ds', $row->sistema_ds),
    //             'sistema_icone' => set_value('sistema_icone', $row->sistema_icone),
    //             'sistema_st' => set_value('sistema_st', $row->sistema_st),
    //             'sistema_dt_criacao' => set_value('sistema_dt_criacao', $row->sistema_dt_criacao),
    //             'sistema_dt_alteracao' => set_value('sistema_dt_alteracao', $row->sistema_dt_alteracao),
    //             'sistema_url' => set_value('sistema_url', $row->sistema_url),
    //         );
    //         $this->load->view('sistema/Sistema_form', $data);
    //     } else {
    //         $this->session->set_flashdata('message', 'Registro não Encontrado');
    //         redirect(site_url('sistema'));
    //     }
    // }

    // public function update_action()
    // {
    //     $this->_rules();
    //     $this->form_validation->set_rules('sistema_nm', 'sistema_nm', 'trim|required|max_length[50]');
    //     $this->form_validation->set_rules('sistema_ds', 'sistema_ds', 'trim|max_length[255]');
    //     $this->form_validation->set_rules('sistema_icone', 'sistema_icone', 'trim|max_length[50]');
    //     $this->form_validation->set_rules('sistema_st', 'sistema_st', 'trim|numeric');
    //     $this->form_validation->set_rules('sistema_dt_criacao', 'sistema_dt_criacao', 'trim|required');
    //     $this->form_validation->set_rules('sistema_dt_alteracao', 'sistema_dt_alteracao', 'trim');
    //     $this->form_validation->set_rules('sistema_url', 'sistema_url', 'trim|max_length[100]');

    //     if ($this->form_validation->run() == FALSE) {
    //         #echo validation_errors();
    //         $this->update($this->input->post('sistema_id', TRUE));
    //     } else {
    //         $data = array(
    //             'sistema_nm' => empty($this->input->post('sistema_nm', TRUE)) ? NULL : $this->input->post('sistema_nm', TRUE),
    //             'sistema_ds' => empty($this->input->post('sistema_ds', TRUE)) ? NULL : $this->input->post('sistema_ds', TRUE),
    //             'sistema_icone' => empty($this->input->post('sistema_icone', TRUE)) ? NULL : $this->input->post('sistema_icone', TRUE),
    //             'sistema_st' => empty($this->input->post('sistema_st', TRUE)) ? NULL : $this->input->post('sistema_st', TRUE),
    //             'sistema_dt_criacao' => empty($this->input->post('sistema_dt_criacao', TRUE)) ? NULL : $this->input->post('sistema_dt_criacao', TRUE),
    //             'sistema_dt_alteracao' => empty($this->input->post('sistema_dt_alteracao', TRUE)) ? NULL : $this->input->post('sistema_dt_alteracao', TRUE),
    //             'sistema_url' => empty($this->input->post('sistema_url', TRUE)) ? NULL : $this->input->post('sistema_url', TRUE),
    //         );

    //         $this->Sistema_model->update($this->input->post('sistema_id', TRUE), $data);
    //         $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
    //         redirect(site_url('sistema'));
    //     }
    // }

    // public function delete($id)
    // {
    //     $row = $this->Sistema_model->get_by_id($id);

    //     if ($row) {
    //         if (@$this->Sistema_model->delete($id) == 'erro_dependencia') {
    //             $this->session->set_flashdata('message', 'Registro não pode ser deletado por estar sendo utilizado!');
    //             redirect(site_url('sistema'));
    //         }


    //         $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
    //         redirect(site_url('sistema'));
    //     } else {
    //         $this->session->set_flashdata('message', 'Registro não Encontrado');
    //         redirect(site_url('sistema'));
    //     }
    // }

    // public function _rules()
    // {
    //     $this->form_validation->set_rules('sistema_nm', 'sistema nm', 'trim|required');
    //     $this->form_validation->set_rules('sistema_ds', 'sistema ds', 'trim|required');
    //     $this->form_validation->set_rules('sistema_icone', 'sistema icone', 'trim|required');
    //     $this->form_validation->set_rules('sistema_st', 'sistema st', 'trim|required');
    //     $this->form_validation->set_rules('sistema_dt_criacao', 'sistema dt criacao', 'trim|required');
    //     $this->form_validation->set_rules('sistema_dt_alteracao', 'sistema dt alteracao', 'trim|required');
    //     $this->form_validation->set_rules('sistema_url', 'sistema url', 'trim|required');

    //     $this->form_validation->set_rules('sistema_id', 'sistema_id', 'trim');
    //     $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    // }

    // public function open_pdf()
    // {

    //     $param = array(
    //         array('sistema_nm', '=', $this->input->post('sistema_nm', TRUE)),
    //         array('sistema_ds', '=', $this->input->post('sistema_ds', TRUE)),
    //         array('sistema_icone', '=', $this->input->post('sistema_icone', TRUE)),
    //         array('sistema_st', '=', $this->input->post('sistema_st', TRUE)),
    //         array('sistema_dt_criacao', '=', $this->input->post('sistema_dt_criacao', TRUE)),
    //         array('sistema_dt_alteracao', '=', $this->input->post('sistema_dt_alteracao', TRUE)),
    //         array('sistema_url', '=', $this->input->post('sistema_url', TRUE)),
    //     ); //end array dos parametros

    //     $data = array(
    //         'sistema_data' => $this->Sistema_model->get_all_data($param),
    //         'start' => 0
    //     );
    //     //limite de memoria do pdf atual
    //     ini_set('memory_limit', '64M');


    //     $html = $this->load->view('sistema/Sistema_pdf', $data, true);


    //     $formato = $this->input->post('formato', TRUE);
    //     $nome_arquivo = 'arquivo';
    //     if (rupper($formato) == 'EXCEL') {
    //         $pdf = $this->pdf->excel($html, $nome_arquivo);
    //     }

    //     $this->load->library('pdf');
    //     $pdf = $this->pdf->RReport();

    //     $caminhoImg = CPATH . 'imagens/Topo/bg_logo_min.png';

    //     //cabeçalho
    //     $pdf->SetHeader(" 
    //             <table border=0 class=table style='font-size:12px'>
    //                 <tr>
    //                     <td rowspan=2><img src='$caminhoImg'></td> 
    //                     <td>Governo do Estado da Bahia<br>
    //                         Secretaria do Meio Ambiente - SEMA</td> 
    //                 </tr>     
    //             </table>    
    //              ", 'O', true);


    //     $pdf->WriteHTML(utf8_encode($html));
    //     $pdf->SetFooter("{DATE j/m/Y H:i}|{PAGENO}/{nb}|" . utf8_encode('Nome do Sistema') . "|");

    //     $pdf->Output('recurso.recurso.pdf', 'I');
    // }

    // public function report()
    // {

    //     $data = array(
    //         'button' => 'Gerar',
    //         'controller' => 'report',
    //         'action' => site_url('sistema/open_pdf'),
    //         'recurso_id' => null,
    //         'recurso_nm' => null,
    //         'recurso_tombo' => null,
    //         'conservacao_id' => null,
    //         'setaf_id' => null,
    //         'localizacao' => null,
    //         'municipio_id' => null,
    //         'caminho' => null,
    //         'documento_id' => null,
    //         'requerente_id' => null,
    //     );


    //     $this->load->view('sistema/Sistema_report', $data);
    // }
}

/* End of file Sistema.php */
/* Local: ./application/controllers/Sistema.php */
/* Gerado por RGenerator - 2019-09-19 11:32:31 */