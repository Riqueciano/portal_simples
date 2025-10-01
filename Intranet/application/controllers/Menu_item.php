<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_item extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Menu_item_model');
        $this->load->model('Usuario_model');
        $this->load->model('Sistema_model');
        $this->load->model('Log_model');
        $this->load->model('Pessoa_model');
        $this->load->model('Publicacao_model');
        $this->load->model('Menu_model');
        $this->load->model('Menu_item_model');
        $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'menu_item/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'menu_item/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'menu_item/';
            $config['first_url'] = base_url() . 'menu_item/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Menu_item_model->total_rows($q);
        $menu_item = $this->Menu_item_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'menu_item_data' => $menu_item,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        // var_dump($data);
        // die();
        $this->load->view('menu_item/Menu_item_list', $data);
    }

    public function read($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Menu_item_model->get_by_id($id);


        $param = array(
            array('1', '=', '1')
        );
        $menu = $this->Menu_model->get_all_data($param);
        $menu_item = $this->Menu_item_model->get_all_data($param);

        $data = array(
            'action' => site_url('usuario/usuario_login')
            , 'menu' => $menu
            , 'menu_item' => $menu_item
        );




        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('menu_item/create_action'),
                'menu_item_id' => $row->menu_item_id,
                'menu_id' => $row->menu_id,
                'menu_item_titulo' => $row->menu_item_titulo,
                'menu_item_img' => $row->menu_item_img,
                'menu_item_texto' => $row->menu_item_texto,
                'menu_item_link' => $row->menu_item_link,
                'menu_item_tipo_id' => $row->menu_item_tipo_id,
                'menu_item_ordem' => $row->menu_item_ordem,
                'menu' => $menu,
                'menu_item' => $menu_item
            );
            $this->load->view('menu_item/Menu_item_form_externo', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu_item'));
        }
    }

    public function read_old($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Menu_item_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('menu_item/create_action'),
                'menu_item_id' => $row->menu_item_id,
                'menu_id' => $row->menu_id,
                'menu_item_titulo' => $row->menu_item_titulo,
                'menu_item_img' => $row->menu_item_img,
                'menu_item_texto' => $row->menu_item_texto,
                'menu_item_link' => $row->menu_item_link,
                'menu_item_tipo_id' => $row->menu_item_tipo_id,
                'menu_item_ordem' => $row->menu_item_ordem,
            );
            $this->load->view('menu_item/Menu_item_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu_item'));
        }
    }

    public function create() {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('menu_item/create_action'),
            'menu_item_id' => set_value('menu_item_id'),
            'menu_id' => set_value('menu_id'),
            'menu_item_titulo' => set_value('menu_item_titulo'),
            'menu_item_img' => set_value('menu_item_img'),
            'menu_item_texto' => set_value('menu_item_texto'),
            'menu_item_link' => set_value('menu_item_link'),
            'menu_item_tipo_id' => set_value('menu_item_tipo_id'),
            'menu_item_ordem' => set_value('menu_item_ordem'),
        );
        $this->load->view('menu_item/Menu_item_form', $data);
    }

    public function create_action() {
        $this->_rules();
        $this->form_validation->set_rules('menu_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('menu_item_titulo', NULL, 'trim|required|max_length[300]');
        $this->form_validation->set_rules('menu_item_img', NULL, 'trim|max_length[800]');
        $this->form_validation->set_rules('menu_item_texto', NULL, 'trim|max_length[8000]');
        $this->form_validation->set_rules('menu_item_link', NULL, 'trim|max_length[500]');
        $this->form_validation->set_rules('menu_item_tipo_id', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('menu_item_ordem', NULL, 'trim|integer');





        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'menu_id' => empty($this->input->post('menu_id', TRUE)) ? NULL : $this->input->post('menu_id', TRUE),
                'menu_item_titulo' => empty($this->input->post('menu_item_titulo', TRUE)) ? NULL : $this->input->post('menu_item_titulo', TRUE),
                'menu_item_img' => empty($this->input->post('menu_item_img', TRUE)) ? NULL : $this->input->post('menu_item_img', TRUE),
                'menu_item_texto' => empty($this->input->post('menu_item_texto', TRUE)) ? NULL : $this->input->post('menu_item_texto', TRUE),
                'menu_item_link' => empty($this->input->post('menu_item_link', TRUE)) ? NULL : $this->input->post('menu_item_link', TRUE),
                'menu_item_tipo_id' => empty($this->input->post('menu_item_tipo_id', TRUE)) ? NULL : $this->input->post('menu_item_tipo_id', TRUE),
                'menu_item_ordem' => empty($this->input->post('menu_item_ordem', TRUE)) ? NULL : $this->input->post('menu_item_ordem', TRUE),
            );

            $this->Menu_item_model->insert($data);
            $menu_item_id = $this->db->insert_id();

            $pasta = 'anexo_intranet\\menu_item\\'; 
            $config['upload_path'] = 'E:\\xampp8\\htdocs\\_portal\\anexos\\' . $pasta . '\\';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = (1024 * 30); //6mb
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            
            if(!empty($this->input->post('menu_item_img', TRUE))){
            unset($config);
            $file_nm = 'menu_item_img';
                if (!empty($_FILES[$file_nm])) {
                    $file['name'] = $_FILES[$file_nm]['name'];
                    $file['type'] = $_FILES[$file_nm]['type'];
                    $file['tmp_name'] = $_FILES[$file_nm]['tmp_name'];
                    $file['error'] = $_FILES[$file_nm]['error'];
                    $file['size'] = $_FILES[$file_nm]['size'];

                    $config['upload_path'] = 'E:\\xampp8\\htdocs\\_portal\\anexos\\anexo_intranet\\menu_item\\';
                    $config['allowed_types'] = 'jpeg|jpg|png|gif';
                    $config['max_size'] = (1024 * 15);

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload($file, $multiple = true)) {
                        $fileData = $this->upload->data();
                        $uploadData['file_name'] = $fileData['file_name'];
                        $uploadData['created'] = date("Y-m-d H:i:s");
                        $uploadData['modified'] = date("Y-m-d H:i:s");

                        $data = array(
                            'menu_item_img' => $uploadData['file_name']
                        );
                        $this->Menu_item_model->update($menu_item_id, $data);
                    } else {
                        echo $this->upload->display_errors();
                        echo "Arquivo não pode ser enviado";
                        exit;
                    } 
                }
            }


            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('menu_item'));
        }
    }

    public function update($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Menu_item_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('menu_item/update_action'),
                'menu_item_id' => set_value('menu_item_id', $row->menu_item_id),
                'menu_id' => set_value('menu_id', $row->menu_id),
                'menu_item_titulo' => set_value('menu_item_titulo', $row->menu_item_titulo),
                'menu_item_img' => set_value('menu_item_img', $row->menu_item_img),
                'menu_item_texto' => set_value('menu_item_texto', $row->menu_item_texto),
                'menu_item_link' => set_value('menu_item_link', $row->menu_item_link),
                'menu_item_tipo_id' => set_value('menu_item_tipo_id', $row->menu_item_tipo_id),
                'menu_item_ordem' => set_value('menu_item_ordem', $row->menu_item_ordem),
            );
            $this->load->view('menu_item/Menu_item_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro não Encontrado');
            redirect(site_url('menu_item'));
        }
    }

    public function update_action() {
        $this->_rules();
        $this->form_validation->set_rules('menu_id', 'menu_id', 'trim|integer');
        $this->form_validation->set_rules('menu_item_titulo', 'menu_item_titulo', 'trim|required|max_length[300]');
        $this->form_validation->set_rules('menu_item_img', 'menu_item_img', 'trim|max_length[800]');
        $this->form_validation->set_rules('menu_item_texto', 'menu_item_texto', 'trim|max_length[8000]');
        $this->form_validation->set_rules('menu_item_link', 'menu_item_link', 'trim|max_length[500]');
        $this->form_validation->set_rules('menu_item_tipo_id', 'menu_item_tipo_id', 'trim|required|integer');
        $this->form_validation->set_rules('menu_item_ordem', 'menu_item_ordem', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('menu_item_id', TRUE));
        } else {
            $data = array(
                'menu_id' => empty($this->input->post('menu_id', TRUE)) ? NULL : $this->input->post('menu_id', TRUE),
                'menu_item_titulo' => empty($this->input->post('menu_item_titulo', TRUE)) ? NULL : $this->input->post('menu_item_titulo', TRUE),
                'menu_item_img' => empty($this->input->post('menu_item_img', TRUE)) ? NULL : $this->input->post('menu_item_img', TRUE),
                'menu_item_texto' => empty($this->input->post('menu_item_texto', TRUE)) ? NULL : $this->input->post('menu_item_texto', TRUE),
                'menu_item_link' => empty($this->input->post('menu_item_link', TRUE)) ? NULL : $this->input->post('menu_item_link', TRUE),
                'menu_item_tipo_id' => empty($this->input->post('menu_item_tipo_id', TRUE)) ? NULL : $this->input->post('menu_item_tipo_id', TRUE),
                'menu_item_ordem' => empty($this->input->post('menu_item_ordem', TRUE)) ? NULL : $this->input->post('menu_item_ordem', TRUE),
            );

            $this->Menu_item_model->update($this->input->post('menu_item_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('menu_item'));
        }
    }

    public function delete($id) {
        $row = $this->Menu_item_model->get_by_id($id);

        if ($row) {
            if (@$this->Menu_item_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro não pode ser deletado por estar sendo utilizado!');
                redirect(site_url('menu_item'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('menu_item'));
        } else {
            $this->session->set_flashdata('message', 'Registro não Encontrado');
            redirect(site_url('menu_item'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('menu_id', 'menu id', 'trim|required');
        $this->form_validation->set_rules('menu_item_titulo', 'menu item titulo', 'trim|required');
        $this->form_validation->set_rules('menu_item_img', 'menu item img', 'trim|required');
        $this->form_validation->set_rules('menu_item_texto', 'menu item texto', 'trim|required');
        $this->form_validation->set_rules('menu_item_link', 'menu item link', 'trim|required');
        $this->form_validation->set_rules('menu_item_tipo_id', 'menu item tipo id', 'trim|required');
        $this->form_validation->set_rules('menu_item_ordem', 'menu item ordem', 'trim|required');

        $this->form_validation->set_rules('menu_item_id', 'menu_item_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function open_pdf() {

        $param = array(
            array('menu_id', '=', $this->input->post('menu_id', TRUE)),
            array('menu_item_titulo', '=', $this->input->post('menu_item_titulo', TRUE)),
            array('menu_item_img', '=', $this->input->post('menu_item_img', TRUE)),
            array('menu_item_texto', '=', $this->input->post('menu_item_texto', TRUE)),
            array('menu_item_link', '=', $this->input->post('menu_item_link', TRUE)),
            array('menu_item_tipo_id', '=', $this->input->post('menu_item_tipo_id', TRUE)),
            array('menu_item_ordem', '=', $this->input->post('menu_item_ordem', TRUE)),); //end array dos parametros

        $data = array(
            'menu_item_data' => $this->Menu_item_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html = $this->load->view('menu_item/Menu_item_pdf', $data, true);


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

    public function report() {

        $data = array(
            'button' => 'Gerar',
            'controller' => 'report',
            'action' => site_url('menu_item/open_pdf'),
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


        $this->load->view('menu_item/Menu_item_report', $data);
    }

}

/* End of file Menu_item.php */
/* Local: ./application/controllers/Menu_item.php */
/* Gerado por RGenerator - 2019-11-19 11:33:22 */