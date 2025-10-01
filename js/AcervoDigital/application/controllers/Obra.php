<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Obra extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Obra_model');
        $this->load->model('Palavra_model');
        $this->load->model('Obra_palavra_model');
        $this->load->model('Obra_historico_model');
        $this->load->model('Pessoa_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $q = trim(urldecode($this->input->get('q', TRUE)));
        $start = intval($this->input->get('start'));
        
        
        $pessoa = $this->Pessoa_model->get_by_id($_SESSION['pessoa_id']);

        if ($q <> '') {
            $config['base_url'] = base_url() . 'obra/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'obra/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url'] = base_url() . 'obra/';
            $config['first_url'] = base_url() . 'obra/';
        }

        if ($_SESSION['Sistemas'][$_SESSION['sistema']] == 'Usuário') {
            $param = ' obra.pessoa_id = ' . $_SESSION['pessoa_id'];
            if (!empty($q)) {
                $param .= " and obra.obra_titulo ilike '%$q%'";
            }
        } else {
            $param = "  obra.obra_titulo ilike '%$q%'";
        }

        $config['per_page'] = 9999999;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Obra_model->total_rows($q);
        
        $param_comp = ' and (obra.flag_aprovacao_autor =1 and obra.status_id in(2) ) ';//1;aprovado
        $obra_ok            = $this->Obra_model->get_limit_data($config['per_page'], $start, $q, $param . $param_comp);
        //exit;
        $param_comp = ' and (obra.flag_aprovacao_autor =0 or obra.status_id in(1,3) )';//1;"Aguardando Aprovação" 3;"Reprovado"
        $obra_data_pendencia = $this->Obra_model->get_limit_data($config['per_page'], $start, $q, $param . $param_comp);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'obra_data_ok' => $obra_ok,
            'obra_data_pendencia' => $obra_data_pendencia,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'pessoa' => $pessoa,
        );
        $this->load->view('obra/Obra_list', $data);
    }

    public function obra_buscador() {
        $param = array(
            array('flag_aprovado', '=', '1')
        );
        $palavra = $this->Palavra_model->get_all_data($param, 'palavra');

        $data = array(
            'action' => site_url('obra/obra_buscador_action'),
            'palavra' => $palavra
        );
        $this->load->view('obra/Obra_buscador', $data);
    }

    public function obra_buscador_action() {
        $palavra_id     = $this->input->post('palavra_id[]', TRUE);
        if(count($palavra_id)==0){
            $palavra_id = array();
        }
        //print_r($palavra_id);
        $pessoa_id      = (int) $this->input->post('pessoa_id', TRUE);
        $acao_busca     = $this->input->post('acao_busca', TRUE);
        $ano            = $this->input->post('ano', TRUE);
        $autores        = $this->input->post('autores', TRUE);
        $instituicao    = $this->input->post('instituicao', TRUE);
 
    //echo $ano;
        $in = '(0';
        if (count($palavra_id) > 0) {  
            foreach ($palavra_id as $id) {
                $in .= ',' . $id;
            }
        }
        $in .= ')';

        
       // echo $in;exit;
        $param  = "status_id = 2"; //publicado
        $param .= " and flag_aprovacao_autor = 1"; //publicado
        if(!empty($ano)){
            $param .= " and ano = $ano"; 
        }
        $pessoa_nm = '';
        if ($acao_busca == 'palavra') {
            $param .= ' and palavra.palavra_id in ' . $in;
            $pessoa_nm = '';
        } else if ($acao_busca == 'autor') {
            
            
            $pessoa = $this->Pessoa_model->get_by_id($pessoa_id);
            $pessoa_nm ='';
            if(!empty($pessoa->pessoa_nm)){
             $param .= ' and pessoa.pessoa_id =' . $pessoa_id;
             $pessoa_nm = $pessoa->pessoa_nm;
            }
        } 
 
        if(!empty($autores)){
            $param .= " and ( 
                             pessoa.pessoa_nm ilike '%$autores%'
                             or obra.coautor1 ilike '%$autores%' 
                             or obra.coautor2 ilike '%$autores%' 
                             or obra.coautor3 ilike '%$autores%' 
                             or obra.coautor4 ilike '%$autores%' 
                    )";
        }
        
        if(!empty($instituicao)){
            $param .= " and ( 
                             pessoa.instituicao_autor ilike '%$instituicao%'
                                 
                    )";
        }
        
        
            $paramPalavra = '  palavra.palavra_id in ' . $in;
        
        if (count($palavra_id)>0) {
            $param_obra = $param.' and '.$paramPalavra;
        }else{
            $param_obra = $param;
        }
        
        // echo $param; 
        $obra = $this->Obra_palavra_model->get_all_param_distinct($param_obra);
        
       
        
        $palavra = $this->Palavra_model->get_all_param($paramPalavra);


   
        $data = array(
            'ano' => $ano,
            'obra' => $obra,
            'acao_busca' => $acao_busca,
            'autores' => $autores,
            'action' => site_url('obra/obra_buscador_action'),
            'palavra_id' => $palavra_id,
            'palavra' => $palavra,
            'pessoa_nm' => rupper($pessoa_nm),
        );
        $this->load->view('obra/Obra_result', $data);
    }

    public function pesquisa_result() {
        $data = array(
            'action' => site_url('obra/obra_buscador_action'),
            'palavra' => '$palavra'
        );
        $this->load->view('obra/Obra_result', $data);
    }

    public function read($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Obra_model->get_by_id($id);
        $param = array(
            array('obra.obra_id', '=', $id),
        );
        $obra_palavra = $this->Obra_palavra_model->get_all_data($param);
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('obra/create_action'),
                'obra_id' => $row->obra_id,
                'obra_titulo' => $row->obra_titulo,
                'autor_ds' => $row->autor_ds,
                'instituicao_id' => $row->instituicao_id,
                'obra_tipo_id' => $row->obra_tipo_id,
                'qtd_pag' => $row->qtd_pag,
                'resumo' => $row->resumo,
                'coautor1' => $row->coautor1,
                'coautor2' => $row->coautor2,
                'coautor3' => $row->coautor3,
                'coautor4' => $row->coautor4,
                'referencia' => $row->referencia,
                'obra_anexo' => $row->obra_anexo,
                'status_id' => $row->status_id,
                'ano' => $row->ano,
                'obra_palavra' => $obra_palavra,
            );
            $this->load->view('obra/Obra_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('obra'));
        }
    }
    public function link($id) {
       
        $this->session->set_flashdata('message', '');
        $row = $this->Obra_model->get_by_id($id);
        $param = array(
            array('obra.obra_id', '=', $id),
        );
        $obra_palavra = $this->Obra_palavra_model->get_all_data($param);
        
        $autores = $row->pessoa_nm;
        $autores .= empty($row->coautor1)?'':', '.$row->coautor1;
        $autores .= empty($row->coautor2)?'':', '.$row->coautor2;
        $autores .= empty($row->coautor3)?'':', '.$row->coautor3;
        $autores .= empty($row->coautor4)?'':', '.$row->coautor4;
        $autores = rupper($autores);
        
        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read',
                'action' => site_url('obra/create_action'),
                'autores' => $autores,
                'obra_id' => $row->obra_id,
                'obra_titulo' => rupper($row->obra_titulo),
                'autor_ds' => $row->autor_ds,
                'instituicao_id' => $row->instituicao_id,
                'obra_tipo_id' => $row->obra_tipo_id,
                'qtd_pag' => $row->qtd_pag,
                'resumo' => $row->resumo,
                'coautor1' => $row->coautor1,
                'coautor2' => $row->coautor2,
                'coautor3' => $row->coautor3,
                'coautor4' => $row->coautor4,
                'referencia' => $row->referencia,
                'pessoa_id' => $row->pessoa_id,
                'obra_anexo' => $row->obra_anexo,
                'status_id' => $row->status_id,
                'ano' => $row->ano,
                'referencia' => $row->referencia,
                'obra_palavra' => $obra_palavra,
            );
            $this->load->view('obra/Obra_form_externo', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('obra'));
        }
    }

    public function autor_reprova($obra_id) { //echo $obra_id;exit;
        $data = array(
            'flag_aprovacao_autor' => 0,
        );
        $this->Obra_model->update($obra_id, $data);
        redirect(site_url('obra'));
    }

    public function autor_aprova($obra_id) {//echo 1;exit;
        $pessoa = $this->Pessoa_model->get_by_id($_SESSION['pessoa_id']);
        if(empty($pessoa->instituicao_autor) and $_SESSION['Sistemas'][$_SESSION['sistema']] == 'Usuário'){
            //se o autor estiver com dados incompletos
            redirect(site_url('Usuario/update_complemento/' . $_SESSION['pessoa_id']));
        }
        //echo $pessoa->instituicao_autor;exit;
        
        $data = array(
            'flag_aprovacao_autor' => 1,
        );
        $this->Obra_model->update($obra_id, $data);
        redirect(site_url('obra'));
    }

    public function read_aprovacao($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Obra_model->get_by_id($id);
        $param = array(
            array('obra.obra_id', '=', $id),
        );
        $obra_palavra = $this->Obra_palavra_model->get_all_data($param);

        $obra_historico = $this->Obra_historico_model->get_all_data($param);

        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read_aprovacao',
                'action' => site_url('obra/create_action'),
                'obra_id' => $row->obra_id,
                'obra_titulo' => $row->obra_titulo,
                'instituicao_id' => $row->instituicao_id,
                'instituicao_nm' => $row->instituicao_nm,
                'obra_tipo_id' => $row->obra_tipo_id,
                'obra_tipo_nm' => $row->obra_tipo_nm,
                'qtd_pag' => $row->qtd_pag,
                'resumo' => $row->resumo,
                'coautor1' => $row->coautor1,
                'coautor2' => $row->coautor2,
                'coautor3' => $row->coautor3,
                'coautor4' => $row->coautor4,
                'referencia' => $row->referencia,
                'obra_anexo' => $row->obra_anexo,
                'status_id' => $row->status_id,
                'ano' => $row->ano,
                'status_nm' => $row->status_nm,
                'obra_palavra' => $obra_palavra,
                'obra_historico' => $obra_historico,
            );
            $this->load->view('obra/Obra_aprovacao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('obra'));
        }
    }

    public function read_result($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Obra_model->get_by_id($id);
        $param = array(
            array('obra.obra_id', '=', $id),
            array('palavra.flag_aprovado', '=', 1),
        );
        $obra_palavra = $this->Obra_palavra_model->get_all_data($param);

        $param = array(
            array('obra.obra_id', '=', $id),
        );
        $obra_historico = $this->Obra_historico_model->get_all_data($param);

        if ($row) {
            $data = array(
                'button' => '',
                'controller' => 'read_aprovacao',
                'action' => site_url('obra/create_action'),
                'obra_id' => $row->obra_id,
                'obra_titulo' => $row->obra_titulo,
                'instituicao_id' => $row->instituicao_id,
                'instituicao_nm' => $row->instituicao_nm,
                'obra_tipo_id' => $row->obra_tipo_id,
                'obra_tipo_nm' => $row->obra_tipo_nm,
                'qtd_pag' => $row->qtd_pag,
                'resumo' => $row->resumo,
                'coautor1' => $row->coautor1,
                'coautor2' => $row->coautor2,
                'coautor3' => $row->coautor3,
                'coautor4' => $row->coautor4,
                'referencia' => $row->referencia,
                'obra_anexo' => $row->obra_anexo,
                'status_id' => $row->status_id,
                'ano' => $row->ano,
                'status_nm' => $row->status_nm,
                'obra_palavra' => $obra_palavra,
                'obra_historico' => $obra_historico,
            );
            $this->load->view('obra/Obra_result_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('obra'));
        }
    }

    public function create() {
 
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('obra/create_action'),
            'obra_id' => set_value('obra_id'),
            'obra_titulo' => set_value('obra_titulo'),
            'instituicao_id' => set_value('instituicao_id'),
            'obra_tipo_id' => set_value('obra_tipo_id'),
            'qtd_pag' => set_value('qtd_pag'),
            'resumo' => set_value('resumo'),
            'coautor1' => set_value('coautor1'),
            'coautor2' => set_value('coautor2'),
            'coautor3' => set_value('coautor3'),
            'coautor4' => set_value('coautor4'),
            'referencia' => set_value('referencia'),
            'obra_anexo' => set_value('obra_anexo'),
            'status_id' => set_value('status_id'),
            'ano' => set_value('ano'),
            'autor_ds' => set_value('autor_ds'),
            'pessoa_id' => set_value('pessoa_id'),
            'obra_palavra' => array(),
        );
        $this->load->view('obra/Obra_form', $data);
    }

    public function create_action() {
        $this->_rules();
        $this->form_validation->set_rules('obra_titulo', NULL, 'trim|required|max_length[300]');
        $this->form_validation->set_rules('instituicao_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('obra_tipo_id', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('qtd_pag', NULL, 'trim');
        $this->form_validation->set_rules('resumo', NULL, 'trim|required|max_length[99999]');
        $this->form_validation->set_rules('coautor1', NULL, 'trim');
        $this->form_validation->set_rules('coautor2', NULL, 'trim');
        $this->form_validation->set_rules('coautor3', NULL, 'trim');
        $this->form_validation->set_rules('coautor4', NULL, 'trim');
        $this->form_validation->set_rules('referencia', NULL, 'trim');
        $this->form_validation->set_rules('obra_anexo', NULL, 'trim|max_length[200]');
        $this->form_validation->set_rules('status_id', NULL, 'trim|integer');
        $this->form_validation->set_rules('ano', NULL, 'trim|integer');


        $perfil = $_SESSION['Sistemas'][$_SESSION['sistema']];
        if ($perfil == 'Administrador' or $perfil == 'Moderador' or $perfil == 'Gestor') {
            $status_id = 2;
            $flag_aprovado = 1;
            $flag_aprovacao_autor = 0;
        } else {
            //se for o usuario
            $status_id = 1;
            $flag_aprovado = 0;
            $flag_aprovacao_autor = 1;
        }


        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
                'obra_titulo' => empty($this->input->post('obra_titulo', TRUE)) ? NULL : $this->input->post('obra_titulo', TRUE),
                'instituicao_id' => empty($this->input->post('instituicao_id', TRUE)) ? NULL : $this->input->post('instituicao_id', TRUE),
                'obra_tipo_id' => empty($this->input->post('obra_tipo_id', TRUE)) ? NULL : $this->input->post('obra_tipo_id', TRUE),
                'qtd_pag' => 1,//empty($this->input->post('qtd_pag', TRUE)) ? NULL : $this->input->post('qtd_pag', TRUE),
                'resumo' => empty($this->input->post('resumo', TRUE)) ? NULL : $this->input->post('resumo', TRUE),
                'coautor1' => empty($this->input->post('coautor1', TRUE)) ? NULL : $this->input->post('coautor1', TRUE),
                'coautor2' => empty($this->input->post('coautor2', TRUE)) ? NULL : $this->input->post('coautor2', TRUE),
                'coautor3' => empty($this->input->post('coautor3', TRUE)) ? NULL : $this->input->post('coautor3', TRUE),
                'coautor4' => empty($this->input->post('coautor4', TRUE)) ? NULL : $this->input->post('coautor4', TRUE),
                'referencia' => empty($this->input->post('referencia', TRUE)) ? NULL : $this->input->post('referencia', TRUE),
                'obra_anexo' => empty($this->input->post('obra_anexo', TRUE)) ? NULL : $this->input->post('obra_anexo', TRUE),
                'pessoa_id' => empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
                'autor_ds' => empty($this->input->post('autor_ds', TRUE)) ? NULL : $this->input->post('autor_ds', TRUE),
                'ano' => empty($this->input->post('ano', TRUE)) ? NULL : $this->input->post('ano', TRUE),
                'status_id' => $status_id,
                'flag_aprovacao_autor' => $flag_aprovacao_autor,
            );

            //print_r($data);exit;
            
            $this->Obra_model->insert($data);
            $obra_id = $this->db->insert_id();
            foreach ($this->input->post("palavra[]", TRUE) as $key => $palavra) {
                $palavra = rupper(trim($palavra));
                //verifica se a palavra já existe
                $param = "palavra ilike '$palavra'";
                $objPalavra = $this->Palavra_model->get_all_param($param);
                //echo count($objPalavra);exit;
                //se não tiver a palavra, salva no banco
                if (count($objPalavra) == 0) {//echo '1';
                    $data = array(
                        'palavra' => rupper($palavra)
                        , 'flag_aprovado' => $flag_aprovado
                    );
                    $this->Palavra_model->insert($data);
                    $palava_id = $this->db->insert_id();
                } else if (count($objPalavra) > 1) {//echo '2';
                    echo 'erro, favor entrar em contato com a SDR';
                    exit;
                } else if (count($objPalavra) == 1) {// echo '3';
                    //tudo ok
                    foreach ($objPalavra as $p) {
                        $palava_id = $p->palavra_id;
                    }
                }

                //insere de-para entre palavra e obra
                $data = array(
                    'palavra_id' => $palava_id,
                    'obra_id' => $obra_id,
                );
                $this->Obra_palavra_model->insert($data); //exit;
            }

            $data = array(
                'acao' => 'Cadastro',
                'obra_id' => $obra_id,
                'pessoa_id' => $_SESSION['pessoa_id'],
            );
            $this->Obra_historico_model->insert($data);



            ##############################################################################################################
            $config['upload_path'] = 'E:\\xampp8\\htdocs\\gestorsdr\\anexos\\anexo_acervo_digital\\';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = (1024 * 6); //6mb
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $arquivo = "obra_anexo";
            if (!empty($_FILES[$arquivo]['name'])) {
                $file['name'] = $_FILES[$arquivo]['name'] . '_' . date('d-m-Y h-i-s');
                $file['type'] = $_FILES[$arquivo]['type'];
                $file['tmp_name'] = $_FILES[$arquivo]['tmp_name'];
                $file['error'] = $_FILES[$arquivo]['error'];
                $file['size'] = $_FILES[$arquivo]['size'];

                if ($this->upload->do_upload($arquivo, $multiple = false)) {
                    $fileData = $this->upload->data();
                    $uploadData['file_name'] = $fileData['file_name'];
                    $uploadData['created'] = date("Y-m-d H:i:s");
                    $uploadData['modified'] = date("Y-m-d H:i:s");
                } else {
                    echo utf8_decode($this->upload->display_errors());
                    exit;
                }

                //atualiza nome do arquivo
                $data = array($arquivo => $uploadData['file_name']);
                $this->Obra_model->update($obra_id, $data);
            }


            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('obra'));
        }
    }

    public function update($id) {
        $this->session->set_flashdata('message', '');
        $row = $this->Obra_model->get_by_id($id);

        $param = array(
            array('obra.obra_id', '=', $id),
        );
        $obra_palavra = $this->Obra_palavra_model->get_all_data($param);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('obra/update_action'),
                'obra_id' => set_value('obra_id', $row->obra_id),
                'obra_titulo' => set_value('obra_titulo', $row->obra_titulo),
                'instituicao_id' => set_value('instituicao_id', $row->instituicao_id),
                'obra_tipo_id' => set_value('obra_tipo_id', $row->obra_tipo_id),
                'qtd_pag' => set_value('qtd_pag', $row->qtd_pag),
                'resumo' => set_value('resumo', $row->resumo),
                'coautor1' => set_value('coautor1', $row->coautor1),
                'coautor2' => set_value('coautor2', $row->coautor2),
                'coautor3' => set_value('coautor3', $row->coautor3),
                'coautor4' => set_value('coautor4', $row->coautor4),
                'referencia' => set_value('referencia', $row->referencia),
                'obra_anexo' => set_value('obra_anexo', $row->obra_anexo),
                'status_id' => set_value('status_id', $row->status_id),
                'ano' => set_value('ano', $row->ano),
                'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
                'autor_ds' => set_value('autor_ds', $row->autor_ds),
                'obra_palavra' => $obra_palavra,
            );
            $this->load->view('obra/Obra_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('obra'));
        }
    }

    public function update_action() {
        $this->_rules();
        $this->form_validation->set_rules('obra_titulo', 'obra_titulo', 'trim|required|max_length[300]');
        $this->form_validation->set_rules('instituicao_id', 'instituicao_id', 'trim|integer');
        $this->form_validation->set_rules('obra_tipo_id', 'obra_tipo_id', 'trim|required|integer');
        $this->form_validation->set_rules('qtd_pag', 'qtd_pag', 'trim|integer');
        $this->form_validation->set_rules('resumo', 'resumo', 'trim|required|max_length[99999]');
        $this->form_validation->set_rules('coautor1', 'coautor1', 'trim');
        $this->form_validation->set_rules('coautor2', 'coautor2', 'trim');
        $this->form_validation->set_rules('coautor3', 'coautor3', 'trim');
        $this->form_validation->set_rules('coautor4', 'coautor4', 'trim');
        $this->form_validation->set_rules('referencia', 'referencia', 'trim|required|max_length[99999]');
        $this->form_validation->set_rules('obra_anexo', 'obra_anexo', 'trim|max_length[200]');
        $this->form_validation->set_rules('status_id', 'status_id', 'trim|integer');
        $this->form_validation->set_rules('ano', 'ano', 'trim|integer');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('obra_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
                'obra_titulo' => empty($this->input->post('obra_titulo', TRUE)) ? NULL : $this->input->post('obra_titulo', TRUE),
                'instituicao_id' => empty($this->input->post('instituicao_id', TRUE)) ? NULL : $this->input->post('instituicao_id', TRUE),
                'obra_tipo_id' => empty($this->input->post('obra_tipo_id', TRUE)) ? NULL : $this->input->post('obra_tipo_id', TRUE),
                'qtd_pag' => 1,//empty($this->input->post('qtd_pag', TRUE)) ? NULL : $this->input->post('qtd_pag', TRUE),
                'resumo' => empty($this->input->post('resumo', TRUE)) ? NULL : $this->input->post('resumo', TRUE),
                'coautor1' => empty($this->input->post('coautor1', TRUE)) ? NULL : $this->input->post('coautor1', TRUE),
                'coautor2' => empty($this->input->post('coautor2', TRUE)) ? NULL : $this->input->post('coautor2', TRUE),
                'coautor3' => empty($this->input->post('coautor3', TRUE)) ? NULL : $this->input->post('coautor3', TRUE),
                'coautor4' => empty($this->input->post('coautor4', TRUE)) ? NULL : $this->input->post('coautor4', TRUE),
                'referencia' => empty($this->input->post('referencia', TRUE)) ? NULL : $this->input->post('referencia', TRUE),
                'obra_anexo' => empty($this->input->post('obra_anexo', TRUE)) ? NULL : $this->input->post('obra_anexo', TRUE),
                'pessoa_id' => empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
                'autor_ds' => empty($this->input->post('autor_ds', TRUE)) ? NULL : $this->input->post('autor_ds', TRUE),
                'ano' => empty($this->input->post('ano', TRUE)) ? NULL : $this->input->post('amp', TRUE),
                'status_id' => 1,
            );

            $this->Obra_model->update($this->input->post('obra_id', TRUE), $data);


            //deleta todos os obra palavra antes de inserir novamente
            $this->Obra_palavra_model->delete_por_obra($this->input->post('obra_id', TRUE));

            foreach ($this->input->post("palavra[]", TRUE) as $key => $palavra) {
                $palavra = trim($palavra);
                //verifica se a palavra já existe
                $param = "palavra ilike '$palavra'";
                $objPalavra = $this->Palavra_model->get_all_param($param);
                //se não tiver a palavra, salva no banco
                if (count($objPalavra) == 0) {
                    $data = array(
                        'palavra' => rupper($palavra)
                        , 'flag_aprovado' => 0
                    );
                    $this->Palavra_model->insert($data);
                    $palava_id = $this->db->insert_id();
                } else if (count($objPalavra) > 1) {
                    echo 'erro, favor entrar em contato com a SDR';
                    exit;
                } else if (count($objPalavra) == 1) {
                    //tudo ok
                    foreach ($objPalavra as $p) {
                        $palava_id = $p->palavra_id;
                    }
                }

                //insere de-para entre palavra e obra
                $data = array(
                    'palavra_id' => $palava_id,
                    'obra_id' => $this->input->post('obra_id', TRUE),
                );
                $this->Obra_palavra_model->insert($data);


                $data = array(
                    'acao' => 'Edição ',
                    'obra_id' => $this->input->post('obra_id', TRUE),
                    'pessoa_id' => $_SESSION['pessoa_id']
                );
                $this->Obra_historico_model->insert($data);
            }
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('obra'));
        }
    }

    public function delete($id) {
        $row = $this->Obra_model->get_by_id($id);

        if ($row) {
            if (@$this->Obra_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('obra'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('obra'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('obra'));
        }
    }

    public function _rules() {
      

        $this->form_validation->set_rules('obra_id', 'obra_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function open_pdf() {

        $param = array(
            array('obra_titulo', '=', $this->input->post('obra_titulo', TRUE)),
            array('instituicao_id', '=', $this->input->post('instituicao_id', TRUE)),
            array('obra_tipo_id', '=', $this->input->post('obra_tipo_id', TRUE)),
            array('qtd_pag', '=', $this->input->post('qtd_pag', TRUE)),
            array('resumo', '=', $this->input->post('resumo', TRUE)),
            array('obra_anexo', '=', $this->input->post('obra_anexo', TRUE)),
            array('ano', '=', $this->input->post('ano', TRUE)),
            array('status_id', '=', $this->input->post('status_id', TRUE)),); //end array dos parametros

        $data = array(
            'obra_data' => $this->Obra_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html = $this->load->view('obra/Obra_pdf', $data, true);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $caminhoImg = CPATH . 'imagens/Topo/bg_logo_min.png';

        //cabeçalho
        $pdf->SetHTMLHeader(" 
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
            'action' => site_url('obra/open_pdf'),
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


        $this->load->view('obra/Obra_report', $data);
    }

    public function reprovar_obra() {
        $obra_id = $this->input->post('obra_id', TRUE); //echo $obra_id ;exit;
        $motivo_reprovacao = $this->input->post('motivo_reprovacao', TRUE);
        $data = array(
            'status_id' => 3
        );
        $this->Obra_model->update($obra_id, $data);

        //historico
        $data = array(
            'acao' => 'Reprovação: ' . $motivo_reprovacao,
            'obra_id' => $obra_id,
            'pessoa_id' => $_SESSION['pessoa_id']
        );
        $this->Obra_historico_model->insert($data);
        redirect(site_url('obra'));
    }

    public function publicar_obra() {
        $obra_id = $this->input->post('obra_id', TRUE);
        //echo $obra_id ;exit;
        $motivo_reprovacao = $this->input->post('motivo_reprovacao', TRUE);
        $data = array(
            'status_id' => 2
        );
        $this->Obra_model->update($obra_id, $data);

        //historico
        $data = array(
            'acao' => 'Publicação',
            'obra_id' => $obra_id,
            'pessoa_id' => $_SESSION['pessoa_id']
        );
        $this->Obra_historico_model->insert($data);
        redirect(site_url('obra'));
    }

    public function AjaxObraResumo() {

        $obra_id = $this->input->post('obra_id', TRUE);

        $o = $this->Obra_model->get_by_id($obra_id);

        $param = array(
            array('obra.obra_id', '=', $obra_id),
            array('palavra.flag_aprovado', '=', 1),
        );
        $obra_palavra = $this->Obra_palavra_model->get_all_data($param);

        $palavras_chave = '';
        foreach ($obra_palavra as $op) {
            $palavras_chave .= "<span class='badge badge-default' style='background-color:silver'>$op->palavra</span>";
        }


        
        
        $autores = $o->pessoa_nm;
        $autores .= empty($o->coautor1)?'':', '.$o->coautor1;
        $autores .= empty($o->coautor2)?'':', '.$o->coautor2;
        $autores .= empty($o->coautor3)?'':', '.$o->coautor3;
        $autores .= empty($o->coautor4)?'':', '.$o->coautor4;
        $autores .= "<br>";
        $autores = rupper($autores);
        
        
        $json = array(
            'obra_id' => $o->obra_id,
            'pessoa_nm' => utf8_encode(rupper($o->pessoa_nm)),
            'obra_titulo' => utf8_encode(rupper($o->obra_titulo)),
            'instituicao_nm' => utf8_encode(rupper($o->instituicao_autor)),
            'referencia' => utf8_encode(rupper($o->referencia)),
            'coautor1' => utf8_encode(rupper($o->coautor1)),
            'coautor2' => utf8_encode(rupper($o->coautor2)),
            'coautor3' => utf8_encode(rupper($o->coautor3)),
            'coautor4' => utf8_encode(rupper($o->coautor4)),
            'autores' => utf8_encode(rupper($autores)),
            'obra_tipo_nm' => utf8_encode(rupper($o->obra_tipo_nm)),
            'resumo' => utf8_encode(rupper($o->resumo)),
            'obra_anexo' => utf8_encode(rupper($o->obra_anexo)),
            'link_obra_anexo' => utf8_encode("https://" . $_SERVER['HTTP_HOST'] . "/_portal/anexos/anexo_acervo_digital//" . $o->obra_anexo),
            'autor_ds' => utf8_encode(rupper($o->autor_ds)),
            'status_nm' => utf8_encode(rupper($o->status_nm)),
            'palavras_chave' => utf8_encode(rupper($palavras_chave)),
            'link_obra' => utf8_encode((site_url('obra/link/'.$o->obra_id))),
        );

        echo json_encode($json);
    }

}

/* End of file Obra.php */
/* Local: ./application/controllers/Obra.php */
/* Gerado por RGenerator - 2018-03-27 17:17:12 */