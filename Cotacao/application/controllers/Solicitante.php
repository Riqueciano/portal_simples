<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Solicitante extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Solicitante_model'); 
        
        $this->load->service('Solicitante_service'); 
        
$this->load->model('Municipio_model'); 

$this->load->model('Solicitante_tipo_model'); 

$this->load->model('Pessoa_model'); 
  $this->load->library('form_validation');
    }
    

    public function index()
    {   
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = (int)$this->input->get('start');
        
         

        $config['per_page'] = 30;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Solicitante_model->total_rows($q);
        $solicitante = $this->Solicitante_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if($format == 'json'){
            echo json($solicitante);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'solicitante_data' => json($solicitante),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('solicitante/Solicitante_list', forFrontVue($data));
    }

    public function read($id) 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Solicitante_model->get_by_id($id); $municipio = $this->Municipio_model->get_all_combobox(); $solicitante_tipo = $this->Solicitante_tipo_model->get_all_combobox(); $pessoa = $this->Pessoa_model->get_all_combobox();   if ($row) {
                    $data = array(
                        'municipio' => json($municipio),	'solicitante_tipo' => json($solicitante_tipo),	'pessoa' => json($pessoa),	 
                        'button' => '',
                        'controller' => 'read',
                        'action' => site_url('solicitante/create_action'),
	    'solicitante_id' => $row->solicitante_id   ,
	    'nome_da_entidade' => $row->nome_da_entidade   ,
	    'endereco' => $row->endereco   ,
	    'municipio_id' => $row->municipio_id   ,
	    'telefone' => $row->telefone   ,
	    'email' => $row->email   ,
	    'cnpj_cpf' => $row->cnpj_cpf   ,
	    'dap_juridica_fisica' => $row->dap_juridica_fisica   ,
	    'qtd_associados' => $row->qtd_associados   ,
	    'qtd_mulheres' => $row->qtd_mulheres   ,
	    'qtd_jovens' => $row->qtd_jovens   ,
	    'comunidades_envolvidas' => $row->comunidades_envolvidas   ,
	    'qual_tipo' => $row->qual_tipo   ,
	    'numero_cadsol' => $row->numero_cadsol   ,
	    'responsavel' => $row->responsavel   ,
	    'responsavel_endereco' => $row->responsavel_endereco   ,
	    'responsavel_telefone' => $row->responsavel_telefone   ,
	    'responsavel_email' => $row->responsavel_email   ,
	    'responsavel_cpf' => $row->responsavel_cpf   ,
	    'responsavel_rg' => $row->responsavel_rg   ,
	    'solicitante_tipo_id' => $row->solicitante_tipo_id   ,
	    'pessoa_id' => $row->pessoa_id   ,
	    'local_beneficiada_producao' => $row->local_beneficiada_producao   ,
	    'flag_ater' => $row->flag_ater   ,
	    'entidade_ater' => $row->entidade_ater   ,
	    'tecnico_ater_nm' => $row->tecnico_ater_nm   ,
	    'tecnico_ater_tel' => $row->tecnico_ater_tel   ,
	    'materia_prima' => $row->materia_prima   ,
	    );
            $this->load->view('solicitante/Solicitante_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('solicitante'));
        }
    }

    public function create() 
    {    PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);$municipio = $this->Municipio_model->get_all_combobox(); $solicitante_tipo = $this->Solicitante_tipo_model->get_all_combobox(); $pessoa = $this->Pessoa_model->get_all_combobox(); $data = array(
            'municipio' => json($municipio),	'solicitante_tipo' => json($solicitante_tipo),	'pessoa' => json($pessoa),	
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('solicitante/create_action'),
	    'solicitante_id' => set_value('solicitante_id'),
	    'nome_da_entidade' => set_value('nome_da_entidade'),
	    'endereco' => set_value('endereco'),
	    'municipio_id' => set_value('municipio_id'),
	    'telefone' => set_value('telefone'),
	    'email' => set_value('email'),
	    'cnpj_cpf' => set_value('cnpj_cpf'),
	    'dap_juridica_fisica' => set_value('dap_juridica_fisica'),
	    'qtd_associados' => set_value('qtd_associados'),
	    'qtd_mulheres' => set_value('qtd_mulheres'),
	    'qtd_jovens' => set_value('qtd_jovens'),
	    'comunidades_envolvidas' => set_value('comunidades_envolvidas'),
	    'qual_tipo' => set_value('qual_tipo'),
	    'numero_cadsol' => set_value('numero_cadsol'),
	    'responsavel' => set_value('responsavel'),
	    'responsavel_endereco' => set_value('responsavel_endereco'),
	    'responsavel_telefone' => set_value('responsavel_telefone'),
	    'responsavel_email' => set_value('responsavel_email'),
	    'responsavel_cpf' => set_value('responsavel_cpf'),
	    'responsavel_rg' => set_value('responsavel_rg'),
	    'solicitante_tipo_id' => set_value('solicitante_tipo_id'),
	    'pessoa_id' => set_value('pessoa_id'),
	    'local_beneficiada_producao' => set_value('local_beneficiada_producao'),
	    'flag_ater' => set_value('flag_ater'),
	    'entidade_ater' => set_value('entidade_ater'),
	    'tecnico_ater_nm' => set_value('tecnico_ater_nm'),
	    'tecnico_ater_tel' => set_value('tecnico_ater_tel'),
	    'materia_prima' => set_value('materia_prima'),
	);
        $this->load->view('solicitante/Solicitante_form', forFrontVue($data));
    }
    
    public function create_action() 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->_rules();
		$this->form_validation->set_rules('nome_da_entidade', NULL,'trim|max_length[800]');
		$this->form_validation->set_rules('endereco', NULL,'trim|required|max_length[150]');
		$this->form_validation->set_rules('municipio_id', NULL,'trim|required|integer');
		$this->form_validation->set_rules('telefone', NULL,'trim|required|max_length[20]');
		$this->form_validation->set_rules('email', NULL,'trim|required|max_length[50]');
		$this->form_validation->set_rules('cnpj_cpf', NULL,'trim|required|max_length[20]');
		$this->form_validation->set_rules('dap_juridica_fisica', NULL,'trim|max_length[150]');
		$this->form_validation->set_rules('qtd_associados', NULL,'trim|max_length[50]');
		$this->form_validation->set_rules('qtd_mulheres', NULL,'trim|max_length[50]');
		$this->form_validation->set_rules('qtd_jovens', NULL,'trim|max_length[50]');
		$this->form_validation->set_rules('comunidades_envolvidas', NULL,'trim|max_length[300]');
		$this->form_validation->set_rules('qual_tipo', NULL,'trim|max_length[150]');
		$this->form_validation->set_rules('numero_cadsol', NULL,'trim|max_length[200]');
		$this->form_validation->set_rules('responsavel', NULL,'trim|max_length[300]');
		$this->form_validation->set_rules('responsavel_endereco', NULL,'trim|max_length[300]');
		$this->form_validation->set_rules('responsavel_telefone', NULL,'trim|max_length[20]');
		$this->form_validation->set_rules('responsavel_email', NULL,'trim|max_length[300]');
		$this->form_validation->set_rules('responsavel_cpf', NULL,'trim|max_length[30]');
		$this->form_validation->set_rules('responsavel_rg', NULL,'trim|max_length[20]');
		$this->form_validation->set_rules('solicitante_tipo_id', NULL,'trim|required|integer');
		$this->form_validation->set_rules('pessoa_id', NULL,'trim|required|integer');
		$this->form_validation->set_rules('local_beneficiada_producao', NULL,'trim|max_length[500]');
		$this->form_validation->set_rules('flag_ater', NULL,'trim|integer');
		$this->form_validation->set_rules('entidade_ater', NULL,'trim|max_length[500]');
		$this->form_validation->set_rules('tecnico_ater_nm', NULL,'trim|max_length[500]');
		$this->form_validation->set_rules('tecnico_ater_tel', NULL,'trim|max_length[25]');
		$this->form_validation->set_rules('materia_prima', NULL,'trim|max_length[500]');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nome_da_entidade' => 	 empty($this->input->post('nome_da_entidade',TRUE))? NULL : $this->input->post('nome_da_entidade',TRUE),
		'endereco' => 	 empty($this->input->post('endereco',TRUE))? NULL : $this->input->post('endereco',TRUE),
		'municipio_id' => 	 empty($this->input->post('municipio_id',TRUE))? NULL : $this->input->post('municipio_id',TRUE),
		'telefone' => 	 empty($this->input->post('telefone',TRUE))? NULL : $this->input->post('telefone',TRUE),
		'email' => 	 empty($this->input->post('email',TRUE))? NULL : $this->input->post('email',TRUE),
		'cnpj_cpf' => 	 empty($this->input->post('cnpj_cpf',TRUE))? NULL : $this->input->post('cnpj_cpf',TRUE),
		'dap_juridica_fisica' => 	 empty($this->input->post('dap_juridica_fisica',TRUE))? NULL : $this->input->post('dap_juridica_fisica',TRUE),
		'qtd_associados' => 	 empty($this->input->post('qtd_associados',TRUE))? NULL : $this->input->post('qtd_associados',TRUE),
		'qtd_mulheres' => 	 empty($this->input->post('qtd_mulheres',TRUE))? NULL : $this->input->post('qtd_mulheres',TRUE),
		'qtd_jovens' => 	 empty($this->input->post('qtd_jovens',TRUE))? NULL : $this->input->post('qtd_jovens',TRUE),
		'comunidades_envolvidas' => 	 empty($this->input->post('comunidades_envolvidas',TRUE))? NULL : $this->input->post('comunidades_envolvidas',TRUE),
		'qual_tipo' => 	 empty($this->input->post('qual_tipo',TRUE))? NULL : $this->input->post('qual_tipo',TRUE),
		'numero_cadsol' => 	 empty($this->input->post('numero_cadsol',TRUE))? NULL : $this->input->post('numero_cadsol',TRUE),
		'responsavel' => 	 empty($this->input->post('responsavel',TRUE))? NULL : $this->input->post('responsavel',TRUE),
		'responsavel_endereco' => 	 empty($this->input->post('responsavel_endereco',TRUE))? NULL : $this->input->post('responsavel_endereco',TRUE),
		'responsavel_telefone' => 	 empty($this->input->post('responsavel_telefone',TRUE))? NULL : $this->input->post('responsavel_telefone',TRUE),
		'responsavel_email' => 	 empty($this->input->post('responsavel_email',TRUE))? NULL : $this->input->post('responsavel_email',TRUE),
		'responsavel_cpf' => 	 empty($this->input->post('responsavel_cpf',TRUE))? NULL : $this->input->post('responsavel_cpf',TRUE),
		'responsavel_rg' => 	 empty($this->input->post('responsavel_rg',TRUE))? NULL : $this->input->post('responsavel_rg',TRUE),
		'solicitante_tipo_id' => 	 empty($this->input->post('solicitante_tipo_id',TRUE))? NULL : $this->input->post('solicitante_tipo_id',TRUE),
		'pessoa_id' => 	 empty($this->input->post('pessoa_id',TRUE))? NULL : $this->input->post('pessoa_id',TRUE),
		'local_beneficiada_producao' => 	 empty($this->input->post('local_beneficiada_producao',TRUE))? NULL : $this->input->post('local_beneficiada_producao',TRUE),
		'flag_ater' => 	 empty($this->input->post('flag_ater',TRUE))? NULL : $this->input->post('flag_ater',TRUE),
		'entidade_ater' => 	 empty($this->input->post('entidade_ater',TRUE))? NULL : $this->input->post('entidade_ater',TRUE),
		'tecnico_ater_nm' => 	 empty($this->input->post('tecnico_ater_nm',TRUE))? NULL : $this->input->post('tecnico_ater_nm',TRUE),
		'tecnico_ater_tel' => 	 empty($this->input->post('tecnico_ater_tel',TRUE))? NULL : $this->input->post('tecnico_ater_tel',TRUE),
		'materia_prima' => 	 empty($this->input->post('materia_prima',TRUE))? NULL : $this->input->post('materia_prima',TRUE),
	    );

            $this->Solicitante_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('solicitante'));
        }
    }
    
    public function update($id) 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Solicitante_model->get_by_id($id);
  $municipio = $this->Municipio_model->get_all_combobox(); $solicitante_tipo = $this->Solicitante_tipo_model->get_all_combobox(); $pessoa = $this->Pessoa_model->get_all_combobox();   if ($row) {
            $data = array(
                'municipio' => json($municipio),'solicitante_tipo' => json($solicitante_tipo),'pessoa' => json($pessoa),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('solicitante/update_action'),
		'solicitante_id' => set_value('solicitante_id', $row->solicitante_id),
		'nome_da_entidade' => set_value('nome_da_entidade', $row->nome_da_entidade),
		'endereco' => set_value('endereco', $row->endereco),
		'municipio_id' => set_value('municipio_id', $row->municipio_id),
		'telefone' => set_value('telefone', $row->telefone),
		'email' => set_value('email', $row->email),
		'cnpj_cpf' => set_value('cnpj_cpf', $row->cnpj_cpf),
		'dap_juridica_fisica' => set_value('dap_juridica_fisica', $row->dap_juridica_fisica),
		'qtd_associados' => set_value('qtd_associados', $row->qtd_associados),
		'qtd_mulheres' => set_value('qtd_mulheres', $row->qtd_mulheres),
		'qtd_jovens' => set_value('qtd_jovens', $row->qtd_jovens),
		'comunidades_envolvidas' => set_value('comunidades_envolvidas', $row->comunidades_envolvidas),
		'qual_tipo' => set_value('qual_tipo', $row->qual_tipo),
		'numero_cadsol' => set_value('numero_cadsol', $row->numero_cadsol),
		'responsavel' => set_value('responsavel', $row->responsavel),
		'responsavel_endereco' => set_value('responsavel_endereco', $row->responsavel_endereco),
		'responsavel_telefone' => set_value('responsavel_telefone', $row->responsavel_telefone),
		'responsavel_email' => set_value('responsavel_email', $row->responsavel_email),
		'responsavel_cpf' => set_value('responsavel_cpf', $row->responsavel_cpf),
		'responsavel_rg' => set_value('responsavel_rg', $row->responsavel_rg),
		'solicitante_tipo_id' => set_value('solicitante_tipo_id', $row->solicitante_tipo_id),
		'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
		'local_beneficiada_producao' => set_value('local_beneficiada_producao', $row->local_beneficiada_producao),
		'flag_ater' => set_value('flag_ater', $row->flag_ater),
		'entidade_ater' => set_value('entidade_ater', $row->entidade_ater),
		'tecnico_ater_nm' => set_value('tecnico_ater_nm', $row->tecnico_ater_nm),
		'tecnico_ater_tel' => set_value('tecnico_ater_tel', $row->tecnico_ater_tel),
		'materia_prima' => set_value('materia_prima', $row->materia_prima),
	    );
            $this->load->view('solicitante/Solicitante_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('solicitante'));
        }
    }
    
    public function update_action() 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->_rules();
		$this->form_validation->set_rules('nome_da_entidade','nome_da_entidade','trim|max_length[800]');
		$this->form_validation->set_rules('endereco','endereco','trim|required|max_length[150]');
		$this->form_validation->set_rules('municipio_id','municipio_id','trim|required|integer');
		$this->form_validation->set_rules('telefone','telefone','trim|required|max_length[20]');
		$this->form_validation->set_rules('email','email','trim|required|max_length[50]');
		$this->form_validation->set_rules('cnpj_cpf','cnpj_cpf','trim|required|max_length[20]');
		$this->form_validation->set_rules('dap_juridica_fisica','dap_juridica_fisica','trim|max_length[150]');
		$this->form_validation->set_rules('qtd_associados','qtd_associados','trim|max_length[50]');
		$this->form_validation->set_rules('qtd_mulheres','qtd_mulheres','trim|max_length[50]');
		$this->form_validation->set_rules('qtd_jovens','qtd_jovens','trim|max_length[50]');
		$this->form_validation->set_rules('comunidades_envolvidas','comunidades_envolvidas','trim|max_length[300]');
		$this->form_validation->set_rules('qual_tipo','qual_tipo','trim|max_length[150]');
		$this->form_validation->set_rules('numero_cadsol','numero_cadsol','trim|max_length[200]');
		$this->form_validation->set_rules('responsavel','responsavel','trim|max_length[300]');
		$this->form_validation->set_rules('responsavel_endereco','responsavel_endereco','trim|max_length[300]');
		$this->form_validation->set_rules('responsavel_telefone','responsavel_telefone','trim|max_length[20]');
		$this->form_validation->set_rules('responsavel_email','responsavel_email','trim|max_length[300]');
		$this->form_validation->set_rules('responsavel_cpf','responsavel_cpf','trim|max_length[30]');
		$this->form_validation->set_rules('responsavel_rg','responsavel_rg','trim|max_length[20]');
		$this->form_validation->set_rules('solicitante_tipo_id','solicitante_tipo_id','trim|required|integer');
		$this->form_validation->set_rules('pessoa_id','pessoa_id','trim|required|integer');
		$this->form_validation->set_rules('local_beneficiada_producao','local_beneficiada_producao','trim|max_length[500]');
		$this->form_validation->set_rules('flag_ater','flag_ater','trim|integer');
		$this->form_validation->set_rules('entidade_ater','entidade_ater','trim|max_length[500]');
		$this->form_validation->set_rules('tecnico_ater_nm','tecnico_ater_nm','trim|max_length[500]');
		$this->form_validation->set_rules('tecnico_ater_tel','tecnico_ater_tel','trim|max_length[25]');
		$this->form_validation->set_rules('materia_prima','materia_prima','trim|max_length[500]');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('solicitante_id', TRUE));
        } else {
            $data = array(
		'nome_da_entidade' => empty($this->input->post('nome_da_entidade',TRUE))? NULL : $this->input->post('nome_da_entidade',TRUE), 
		'endereco' => empty($this->input->post('endereco',TRUE))? NULL : $this->input->post('endereco',TRUE), 
		'municipio_id' => empty($this->input->post('municipio_id',TRUE))? NULL : $this->input->post('municipio_id',TRUE), 
		'telefone' => empty($this->input->post('telefone',TRUE))? NULL : $this->input->post('telefone',TRUE), 
		'email' => empty($this->input->post('email',TRUE))? NULL : $this->input->post('email',TRUE), 
		'cnpj_cpf' => empty($this->input->post('cnpj_cpf',TRUE))? NULL : $this->input->post('cnpj_cpf',TRUE), 
		'dap_juridica_fisica' => empty($this->input->post('dap_juridica_fisica',TRUE))? NULL : $this->input->post('dap_juridica_fisica',TRUE), 
		'qtd_associados' => empty($this->input->post('qtd_associados',TRUE))? NULL : $this->input->post('qtd_associados',TRUE), 
		'qtd_mulheres' => empty($this->input->post('qtd_mulheres',TRUE))? NULL : $this->input->post('qtd_mulheres',TRUE), 
		'qtd_jovens' => empty($this->input->post('qtd_jovens',TRUE))? NULL : $this->input->post('qtd_jovens',TRUE), 
		'comunidades_envolvidas' => empty($this->input->post('comunidades_envolvidas',TRUE))? NULL : $this->input->post('comunidades_envolvidas',TRUE), 
		'qual_tipo' => empty($this->input->post('qual_tipo',TRUE))? NULL : $this->input->post('qual_tipo',TRUE), 
		'numero_cadsol' => empty($this->input->post('numero_cadsol',TRUE))? NULL : $this->input->post('numero_cadsol',TRUE), 
		'responsavel' => empty($this->input->post('responsavel',TRUE))? NULL : $this->input->post('responsavel',TRUE), 
		'responsavel_endereco' => empty($this->input->post('responsavel_endereco',TRUE))? NULL : $this->input->post('responsavel_endereco',TRUE), 
		'responsavel_telefone' => empty($this->input->post('responsavel_telefone',TRUE))? NULL : $this->input->post('responsavel_telefone',TRUE), 
		'responsavel_email' => empty($this->input->post('responsavel_email',TRUE))? NULL : $this->input->post('responsavel_email',TRUE), 
		'responsavel_cpf' => empty($this->input->post('responsavel_cpf',TRUE))? NULL : $this->input->post('responsavel_cpf',TRUE), 
		'responsavel_rg' => empty($this->input->post('responsavel_rg',TRUE))? NULL : $this->input->post('responsavel_rg',TRUE), 
		'solicitante_tipo_id' => empty($this->input->post('solicitante_tipo_id',TRUE))? NULL : $this->input->post('solicitante_tipo_id',TRUE), 
		'pessoa_id' => empty($this->input->post('pessoa_id',TRUE))? NULL : $this->input->post('pessoa_id',TRUE), 
		'local_beneficiada_producao' => empty($this->input->post('local_beneficiada_producao',TRUE))? NULL : $this->input->post('local_beneficiada_producao',TRUE), 
		'flag_ater' => empty($this->input->post('flag_ater',TRUE))? NULL : $this->input->post('flag_ater',TRUE), 
		'entidade_ater' => empty($this->input->post('entidade_ater',TRUE))? NULL : $this->input->post('entidade_ater',TRUE), 
		'tecnico_ater_nm' => empty($this->input->post('tecnico_ater_nm',TRUE))? NULL : $this->input->post('tecnico_ater_nm',TRUE), 
		'tecnico_ater_tel' => empty($this->input->post('tecnico_ater_tel',TRUE))? NULL : $this->input->post('tecnico_ater_tel',TRUE), 
		'materia_prima' => empty($this->input->post('materia_prima',TRUE))? NULL : $this->input->post('materia_prima',TRUE), 
	    );

            $this->Solicitante_model->update($this->input->post('solicitante_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('solicitante'));
        }
    }
    
    public function delete($id) 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $row = $this->Solicitante_model->get_by_id($id);

        if ($row) {
            if(@$this->Solicitante_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('solicitante'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('solicitante'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('solicitante'));
        }
    }

    public function _rules() 
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
	$this->form_validation->set_rules('nome_da_entidade', 'nome da entidade', 'trim|required');
	$this->form_validation->set_rules('endereco', 'endereco', 'trim|required');
	$this->form_validation->set_rules('municipio_id', 'municipio id', 'trim|required');
	$this->form_validation->set_rules('telefone', 'telefone', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('cnpj_cpf', 'cnpj cpf', 'trim|required');
	$this->form_validation->set_rules('dap_juridica_fisica', 'dap juridica fisica', 'trim|required');
	$this->form_validation->set_rules('qtd_associados', 'qtd associados', 'trim|required');
	$this->form_validation->set_rules('qtd_mulheres', 'qtd mulheres', 'trim|required');
	$this->form_validation->set_rules('qtd_jovens', 'qtd jovens', 'trim|required');
	$this->form_validation->set_rules('comunidades_envolvidas', 'comunidades envolvidas', 'trim|required');
	$this->form_validation->set_rules('qual_tipo', 'qual tipo', 'trim|required');
	$this->form_validation->set_rules('numero_cadsol', 'numero cadsol', 'trim|required');
	$this->form_validation->set_rules('responsavel', 'responsavel', 'trim|required');
	$this->form_validation->set_rules('responsavel_endereco', 'responsavel endereco', 'trim|required');
	$this->form_validation->set_rules('responsavel_telefone', 'responsavel telefone', 'trim|required');
	$this->form_validation->set_rules('responsavel_email', 'responsavel email', 'trim|required');
	$this->form_validation->set_rules('responsavel_cpf', 'responsavel cpf', 'trim|required');
	$this->form_validation->set_rules('responsavel_rg', 'responsavel rg', 'trim|required');
	$this->form_validation->set_rules('solicitante_tipo_id', 'solicitante tipo id', 'trim|required');
	$this->form_validation->set_rules('pessoa_id', 'pessoa id', 'trim|required');
	$this->form_validation->set_rules('local_beneficiada_producao', 'local beneficiada producao', 'trim|required');
	$this->form_validation->set_rules('flag_ater', 'flag ater', 'trim|required');
	$this->form_validation->set_rules('entidade_ater', 'entidade ater', 'trim|required');
	$this->form_validation->set_rules('tecnico_ater_nm', 'tecnico ater nm', 'trim|required');
	$this->form_validation->set_rules('tecnico_ater_tel', 'tecnico ater tel', 'trim|required');
	$this->form_validation->set_rules('materia_prima', 'materia prima', 'trim|required');

	$this->form_validation->set_rules('solicitante_id', 'solicitante_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){
                PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);

                    $param = array(
         
		 array('nome_da_entidade', '=' , $this->input->post('nome_da_entidade',TRUE)),
		 array('endereco', '=' , $this->input->post('endereco',TRUE)),
		 array('municipio_id', '=' , $this->input->post('municipio_id',TRUE)),
		 array('telefone', '=' , $this->input->post('telefone',TRUE)),
		 array('email', '=' , $this->input->post('email',TRUE)),
		 array('cnpj_cpf', '=' , $this->input->post('cnpj_cpf',TRUE)),
		 array('dap_juridica_fisica', '=' , $this->input->post('dap_juridica_fisica',TRUE)),
		 array('qtd_associados', '=' , $this->input->post('qtd_associados',TRUE)),
		 array('qtd_mulheres', '=' , $this->input->post('qtd_mulheres',TRUE)),
		 array('qtd_jovens', '=' , $this->input->post('qtd_jovens',TRUE)),
		 array('comunidades_envolvidas', '=' , $this->input->post('comunidades_envolvidas',TRUE)),
		 array('qual_tipo', '=' , $this->input->post('qual_tipo',TRUE)),
		 array('numero_cadsol', '=' , $this->input->post('numero_cadsol',TRUE)),
		 array('responsavel', '=' , $this->input->post('responsavel',TRUE)),
		 array('responsavel_endereco', '=' , $this->input->post('responsavel_endereco',TRUE)),
		 array('responsavel_telefone', '=' , $this->input->post('responsavel_telefone',TRUE)),
		 array('responsavel_email', '=' , $this->input->post('responsavel_email',TRUE)),
		 array('responsavel_cpf', '=' , $this->input->post('responsavel_cpf',TRUE)),
		 array('responsavel_rg', '=' , $this->input->post('responsavel_rg',TRUE)),
		 array('solicitante_tipo_id', '=' , $this->input->post('solicitante_tipo_id',TRUE)),
		 array('pessoa_id', '=' , $this->input->post('pessoa_id',TRUE)),
		 array('local_beneficiada_producao', '=' , $this->input->post('local_beneficiada_producao',TRUE)),
		 array('flag_ater', '=' , $this->input->post('flag_ater',TRUE)),
		 array('entidade_ater', '=' , $this->input->post('entidade_ater',TRUE)),
		 array('tecnico_ater_nm', '=' , $this->input->post('tecnico_ater_nm',TRUE)),
		 array('tecnico_ater_tel', '=' , $this->input->post('tecnico_ater_tel',TRUE)),
		 array('materia_prima', '=' , $this->input->post('materia_prima',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'solicitante_data' => $this->Solicitante_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('solicitante/Solicitante_pdf', $data, true);
              

          $formato = $this->input->post('formato', TRUE); 
          $nome_arquivo = 'arquivo';
          if(rupper($formato) == 'EXCEL'){
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
                 ",'O',true);
        

                $pdf->WriteHTML(utf8_encode($html));    
                $pdf->SetFooter("{DATE j/m/Y H:i}|{PAGENO}/{nb}|" . utf8_encode('Nome do Sistema') . "|");
                
                $pdf->Output('recurso.recurso.pdf', 'I');

          } 
        
public function report() {
    PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        
            $data = array(
                'button'        => 'Gerar',
                'controller'    => 'report',
                'action'        => site_url('solicitante/open_pdf'),
                'recurso_id'    => null,
                'recurso_nm'    => null,
                'recurso_tombo' => null,
                'conservacao_id'=> null,
                'setaf_id'      => null,
                'localizacao'   => null,
                'municipio_id'  => null,
                'caminho'       => null,
                'documento_id'  => null,
                'requerente_id' => null,
                );
               
           
            $this->load->view('solicitante/Solicitante_report', forFrontVue($data));
        
    }
         

}

/* End of file Solicitante.php */
/* Local: ./application/controllers/Solicitante.php */
/* Gerado por RGenerator - 2025-08-21 20:57:26 */