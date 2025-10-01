<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Publicacao extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Publicacao_model');
        $this->load->model('Menu_model');
        $this->load->model('Menu_item_model');
        $this->load->model('Pessoa_model');
        $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        $ativo = ($this->input->get('ativo'));
        if($ativo == ''){
            $ativo = 1;
        }

        if ($q <> '') {
            $config['base_url'] = base_url() . 'publicacao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'publicacao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'publicacao/';
            $config['first_url'] = base_url() . 'publicacao/';
        }

        $config['per_page'] = 2000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Publicacao_model->total_rows($q);
        $publicacao = $this->Publicacao_model->get_limit_data($config['per_page'], $start, $q, $ativo);

        $this->load->library('pagination');
        $this->pagination->initialize($config);


        //carrega menus laterais
        $param = array(
            array('1', '=', '1')
        );
        $menu = $this->Menu_model->get_all_data($param);
        $menu_item = $this->Menu_item_model->get_all_data($param);

        //aniversariantes
        //$aniversariante_mes = $this->Publicacao_model->get_aniversariantes_mes((int)date('m'));


        $data = array(
            'publicacao_data' => $publicacao,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'menu' => $menu,
            'menu_item' => $menu_item,
            'ativo' => $ativo,
            //'aniversariante_mes' => $aniversariante_mes,
        );
        $this->load->view('publicacao/Publicacao_list', $data);
    }
    public function intranet()
    {

        //nova intranet
        redirect(iPATH . "Intra/intranet");
        exit;

        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'publicacao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'publicacao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'publicacao/';
            $config['first_url'] = base_url() . 'publicacao/';
        }


        $param = array( //publicacao_tipo = esta no carrossel
            array('publicacao_tipo', '=', '1'),
            array('publicacao_tipo', '=', '1')

        );

        $publicacao = $this->Publicacao_model->get_publicacoes($param);

        // print_r($publicacao);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        //carrega menus laterais
        $param = array(
            array('1', '=', '1')
        );
        $menu = $this->Menu_model->get_all_data($param);
        $menu_item = $this->Menu_item_model->get_all_data($param);

        //aniversariantes
        $aniversariante_mes = $this->Pessoa_model->get_aniversariantes_mes((int)date('d'), (int)date('m'));
        $aniversariante_mes_15 = $this->Pessoa_model->get_aniversariantes_mes_15((int)date('d'), (int)date('m'));

        $data = array(
            'publicacao' => $publicacao,
            'q' => $q,
            'menu' => $menu,
            'menu_item' => $menu_item,
            'aniversariante_mes' => $aniversariante_mes,
            'aniversariante_mes_15' => $aniversariante_mes_15,
        );
        $this->load->view('publicacao/Publicacao_intranet', $data);
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Publicacao_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('publicacao/create_action'),
                'publicacao_id' => $row->publicacao_id,
                'publicacao_titulo' => $row->publicacao_titulo,
                'flag_carrossel' => $row->flag_carrossel,
                'publicacao_dt_publicacao' => $row->publicacao_dt_publicacao,
                'publicacao_img' => $row->publicacao_img,
                'publicacao_corpo' => $row->publicacao_corpo,
                'publicacao_st' => $row->publicacao_st,
                'publicacao_dt_criacao' => $row->publicacao_dt_criacao,
                'publicacao_dt_alteracao' => $row->publicacao_dt_alteracao,
                'publicacao_tipo' => $row->publicacao_tipo,
                'publicacao_link' => $row->publicacao_link,
            );
            $this->load->view('publicacao/Publicacao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('publicacao'));
        }
    }
    public function exibir_externo($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Publicacao_model->get_by_id($id);


        $param = array(
            array('1', '=', '1')
        );
        $menu = $this->Menu_model->get_all_data($param);
        $menu_item = $this->Menu_item_model->get_all_data($param);


        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('publicacao/create_action'),
                'publicacao_id' => $row->publicacao_id,
                'publicacao_titulo' => $row->publicacao_titulo,
                'flag_carrossel' => $row->flag_carrossel,
                'publicacao_dt_publicacao' => $row->publicacao_dt_publicacao,
                'publicacao_img' => $row->publicacao_img,
                'publicacao_corpo' => $row->publicacao_corpo,
                'publicacao_st' => $row->publicacao_st,
                'publicacao_dt_criacao' => $row->publicacao_dt_criacao,
                'publicacao_dt_alteracao' => $row->publicacao_dt_alteracao,
                'publicacao_tipo' => $row->publicacao_tipo,
                'publicacao_link' => $row->publicacao_link,
                'menu' => $menu,
                'menu_item' => $menu_item
            );
            $this->load->view('publicacao/Publicacao_form_externo', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('publicacao'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('publicacao/create_action'),
            'publicacao_id' => set_value('publicacao_id'),
            'publicacao_titulo' => set_value('publicacao_titulo'),
            'flag_carrossel' => set_value('flag_carrossel'),
            // 'publicacao_dt_publicacao' => set_value('publicacao_dt_publicacao'),
            'publicacao_dt_publicacao' =>date('Y-m-d') ,
            'publicacao_img' => set_value('publicacao_img'),
            'publicacao_corpo' => set_value('publicacao_corpo'),
            'publicacao_st' => set_value('publicacao_st'),
            'publicacao_dt_criacao' => set_value('publicacao_dt_criacao'),
            'publicacao_dt_alteracao' => set_value('publicacao_dt_alteracao'),
            'publicacao_tipo' => set_value('publicacao_tipo'),
            'publicacao_link' => set_value('publicacao_link'),
        );
        $this->load->view('publicacao/Publicacao_form', $data);
    }

    public function create_action()
    {
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

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
                'publicacao_titulo' => empty($this->input->post('publicacao_titulo', TRUE)) ? NULL : $this->input->post('publicacao_titulo', TRUE),
                'flag_carrossel' => empty($this->input->post('flag_carrossel', TRUE)) ? 0 : $this->input->post('flag_carrossel', TRUE),
                'publicacao_dt_publicacao' => empty($this->input->post('publicacao_dt_publicacao', TRUE)) ? NULL : $this->input->post('publicacao_dt_publicacao', TRUE),
                //'publicacao_img' => empty($this->input->post('publicacao_img', TRUE)) ? NULL : $this->input->post('publicacao_img', TRUE),
                'publicacao_corpo' => empty($this->input->post('publicacao_corpo', TRUE)) ? NULL : $this->input->post('publicacao_corpo', TRUE),
                'publicacao_st' => 1,
                'publicacao_dt_criacao' => date('Y-m-d'),
                'publicacao_dt_alteracao' => empty($this->input->post('publicacao_dt_alteracao', TRUE)) ? NULL : $this->input->post('publicacao_dt_alteracao', TRUE),
                'publicacao_tipo' => 1, //empty($this->input->post('publicacao_tipo', TRUE)) ? NULL : $this->input->post('publicacao_tipo', TRUE),
                'publicacao_link' => empty($this->input->post('publicacao_link', TRUE)) ? NULL : $this->input->post('publicacao_link', TRUE),
            );

            $this->Publicacao_model->insert($data);
            $publicacao_id = $this->db->insert_id();

            unset($config);
            $file_nm = 'publicacao_img';
            if (!empty($_FILES[$file_nm])) {
                $file['name'] = $_FILES[$file_nm]['name'];
                $file['type'] = $_FILES[$file_nm]['type'];
                $file['tmp_name'] = $_FILES[$file_nm]['tmp_name'];
                $file['error'] = $_FILES[$file_nm]['error'];
                $file['size'] = $_FILES[$file_nm]['size'];

                // $config['upload_path'] = 'E:\\xampp8\\htdocs\\_portal\\anexos\\anexo_intranet\\publicacao\\';
                $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/_portal/anexos/anexo_intranet/publicacao/';
                $config['allowed_types'] = '*';
                $config['max_size'] = (700 * 1); //600kb

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // if ($this->upload->do_upload($file, $multiple = true)) {
                //     $fileData = $this->upload->data();
                //     $uploadData['file_name'] = $fileData['file_name'];
                //     $uploadData['created'] = date("Y-m-d H:i:s");
                //     $uploadData['modified'] = date("Y-m-d H:i:s");

                //     $data = array(
                //         'publicacao_img' => $uploadData['file_name']
                //     );
                //     // print_r($data);exit;
                //     $this->Publicacao_model->update($publicacao_id, $data);
                // } else {
                //     echo $this->upload->display_errors();
                //     echo "Arquivo não pode ser enviado";
                //     exit;
                // }
                if ($this->upload->do_upload($file, $multiple = true)) {
                    $fileData = $this->upload->data();
                    $uploadData['file_name'] = $fileData['file_name'];
                    $uploadData['created'] = date("Y-m-d H:i:s");
                    $uploadData['modified'] = date("Y-m-d H:i:s");

                    // Salvando o upload original
                    $data = array(
                        'publicacao_img' => $uploadData['file_name']
                    );
                    $this->Publicacao_model->update($publicacao_id, $data);

                    // Caminho para o arquivo original
                    $originalFilePath = $fileData['full_path'];

                    // Caminho para a imagem redimensionada
                    $resizedFilePath = $fileData['file_path'] . 'min_' . $fileData['file_name'];

                    // Redimensionando a imagem em 10%
                    list($originalWidth, $originalHeight) = getimagesize($originalFilePath);
                    $newWidth = $originalWidth * 0.1;
                    $newHeight = $originalHeight * 0.1;

                    $sourceImage = imagecreatefromstring(file_get_contents($originalFilePath));
                    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

                    // Salvando a imagem redimensionada
                    switch ($fileData['file_ext']) {
                        case '.jpg':
                        case '.jpeg':
                            imagejpeg($resizedImage, $resizedFilePath, 90);
                            break;
                        case '.png':
                            imagepng($resizedImage, $resizedFilePath);
                            break;
                        case '.gif':
                            imagegif($resizedImage, $resizedFilePath);
                            break;
                    }

                    imagedestroy($sourceImage);
                    imagedestroy($resizedImage);

                    // Salvando a informação da imagem redimensionada no banco de dados
                    $resizedUploadData = array(
                        // 'publicacao_img_min' =>  $uploadData['file_name']
                        'publicacao_img_min' =>  'min_' . $fileData['file_name']
                    );
                    $this->Publicacao_model->update($publicacao_id, $resizedUploadData);
                } else {
                    echo $this->upload->display_errors();
                    echo "Arquivo não pode ser enviado";
                    exit;
                }
            }

            $this->db->trans_complete();
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            // exit;
            redirect(site_url('publicacao'));
        }
    }

    public function update($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Publicacao_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('publicacao/update_action'),
                'publicacao_id' => set_value('publicacao_id', $row->publicacao_id),
                'publicacao_titulo' => set_value('publicacao_titulo', $row->publicacao_titulo),
                'flag_carrossel' => set_value('flag_carrossel', $row->flag_carrossel),
                'publicacao_dt_publicacao' => empty($row->publicacao_dt_publicacao) ? date('Y-m-d') : $row->publicacao_dt_publicacao,
                'publicacao_img' => set_value('publicacao_img', $row->publicacao_img),
                'publicacao_corpo' => set_value('publicacao_corpo', $row->publicacao_corpo),
                'publicacao_st' => set_value('publicacao_st', $row->publicacao_st),
                'publicacao_dt_criacao' => set_value('publicacao_dt_criacao', $row->publicacao_dt_criacao),
                'publicacao_dt_alteracao' => set_value('publicacao_dt_alteracao', $row->publicacao_dt_alteracao),
                'publicacao_tipo' => set_value('publicacao_tipo', $row->publicacao_tipo),
                'publicacao_link' => set_value('publicacao_link', $row->publicacao_link),
            );

            $this->load->view('publicacao/Publicacao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('publicacao'));
        }
    }

    public function update_action()
    {
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

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('publicacao_id', TRUE));
        } else {
            $this->db->trans_start();

            $data = array(
                'publicacao_titulo' => empty($this->input->post('publicacao_titulo', TRUE)) ? NULL : $this->input->post('publicacao_titulo', TRUE),
                'flag_carrossel' => empty($this->input->post('flag_carrossel', TRUE)) ? 0 : $this->input->post('flag_carrossel', TRUE),
                'publicacao_dt_publicacao' => empty($this->input->post('publicacao_dt_publicacao', TRUE)) ? NULL : $this->input->post('publicacao_dt_publicacao', TRUE),
                'publicacao_corpo' => empty($this->input->post('publicacao_corpo', TRUE)) ? NULL : $this->input->post('publicacao_corpo', TRUE),
                'publicacao_st' => 1,
                'publicacao_dt_criacao' => date('Y-m-d'),
                'publicacao_dt_alteracao' => empty($this->input->post('publicacao_dt_alteracao', TRUE)) ? NULL : $this->input->post('publicacao_dt_alteracao', TRUE),
                'publicacao_tipo' => 1, //empty($this->input->post('publicacao_tipo', TRUE)) ? NULL : $this->input->post('publicacao_tipo', TRUE),
                'publicacao_link' => empty($this->input->post('publicacao_link', TRUE)) ? NULL : $this->input->post('publicacao_link', TRUE),
            );

            $this->Publicacao_model->update($this->input->post('publicacao_id', TRUE), $data);
            $publicacao_id = $this->input->post('publicacao_id', TRUE);

            unset($config);
            $file_nm = 'publicacao_img';
            if (!empty($_FILES[$file_nm])) {
                $file['name'] = $_FILES[$file_nm]['name'];
                $file['type'] = $_FILES[$file_nm]['type'];
                $file['tmp_name'] = $_FILES[$file_nm]['tmp_name'];
                $file['error'] = $_FILES[$file_nm]['error'];
                $file['size'] = $_FILES[$file_nm]['size'];

                $config['upload_path'] = 'E:\\xampp8\\htdocs\\_portal\\anexos\\anexo_intranet\\publicacao\\';
                $config['allowed_types'] = '*';
                $config['max_size'] = (1024 * 25);

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload($file, $multiple = true)) {
                    $fileData = $this->upload->data();
                    $uploadData['file_name'] = $fileData['file_name'];
                    $uploadData['created'] = date("Y-m-d H:i:s");
                    $uploadData['modified'] = date("Y-m-d H:i:s");

                    $data = array(
                        'publicacao_img' => $uploadData['file_name']
                    );
                    // print_r($data);exit;
                    $this->Publicacao_model->update($publicacao_id, $data);
                } else {
                    $this->Publicacao_model->update($this->input->post('publicacao_id', TRUE), $data);
                    $this->db->trans_complete();
                    redirect(site_url('publicacao'));
                }
            }

            $this->db->trans_complete();
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('publicacao'));
        }
    }

    public function delete($id)
    {
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
        $this->form_validation->set_rules('publicacao_titulo', 'publicacao titulo', 'trim|required');
        $this->form_validation->set_rules('publicacao_dt_publicacao', 'publicacao dt publicacao', 'trim|required');
        $this->form_validation->set_rules('publicacao_img', 'publicacao img', 'trim|required');
        $this->form_validation->set_rules('publicacao_corpo', 'publicacao corpo', 'trim|required');
        $this->form_validation->set_rules('publicacao_st', 'publicacao st', 'trim|required');
        $this->form_validation->set_rules('publicacao_dt_criacao', 'publicacao dt criacao', 'trim|required');
        $this->form_validation->set_rules('publicacao_dt_alteracao', 'publicacao dt alteracao', 'trim|required');
        $this->form_validation->set_rules('publicacao_tipo', 'publicacao tipo', 'trim|required');
        $this->form_validation->set_rules('publicacao_link', 'publicacao link', 'trim|required');

        $this->form_validation->set_rules('publicacao_id', 'publicacao_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function open_pdf()
    {

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
        ); //end array dos parametros

        $data = array(
            'publicacao_data' => $this->Publicacao_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html = $this->load->view('publicacao/Publicacao_pdf', $data, true);


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
            'button' => 'Gerar',
            'controller' => 'report',
            'action' => site_url('publicacao/open_pdf'),
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


        $this->load->view('publicacao/Publicacao_report', $data);
    }


    public function altera_status($publicacao_id)
    {
        $publicacao = $this->Publicacao_model->get_by_id($publicacao_id);
        $data = array(
            'ativo' => 1
        );
        if ($publicacao->ativo == 1) {
            $data = array(
                'ativo' => 0
            );
        }
        $this->Publicacao_model->update($publicacao_id, $data);

        redirect(site_url('publicacao'));
    }
}

/* End of file Publicacao.php */
/* Local: ./application/controllers/Publicacao.php */
/* Gerado por RGenerator - 2019-09-26 18:20:19 */