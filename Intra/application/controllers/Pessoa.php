<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Pessoa extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Pessoa_model');
		$this->load->model('Setaf_model');

		$this->load->model('Lote_model');

		$this->load->model('Municipio_model');

		$this->load->model('Municipio_model');

		$this->load->model('Empresa_model');

		$this->load->model('Territorio_model');

		$this->load->model('Municipio_model');

		$this->load->model('Municipio_model');

		$this->load->model('Territorio_model');

		$this->load->model('Municipio_model');
		$this->load->library('form_validation');
	}


	public function index()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$q = urldecode($this->input->get('q', TRUE));
		$format = urldecode($this->input->get('format', TRUE));
		$start = (int)$this->input->get('start');



		$config['per_page'] = 30;
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $this->Pessoa_model->total_rows($q);
		$pessoa = $this->Pessoa_model->get_limit_data($config['per_page'], $start, $q);

		## para retorno json no front
		if ($format == 'json') {
			echo json($pessoa);
			exit;
		}

		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$data = array(
			'pessoa_data' => json($pessoa),
			'q' => $q,
			'format' => $format,
			'pagination' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'start' => $start,
		);
		$this->load->view('pessoa/Pessoa_list', forFrontVue($data));
	}

	public function read($id)
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$this->session->set_flashdata('message', '');
		$row = $this->Pessoa_model->get_by_id($id);
		$setaf = $this->Setaf_model->get_all_combobox();
		$lote = $this->Lote_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$empresa = $this->Empresa_model->get_all_combobox();
		$territorio = $this->Territorio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$territorio = $this->Territorio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		if ($row) {
			$data = array(
				'setaf' => json($setaf),	'lote' => json($lote),	'municipio' => json($municipio),	'municipio' => json($municipio),	'empresa' => json($empresa),	'territorio' => json($territorio),	'municipio' => json($municipio),	'municipio' => json($municipio),	'territorio' => json($territorio),	'municipio' => json($municipio),
				'button' => '',
				'controller' => 'read',
				'action' => site_url('pessoa/create_action'),
				'pessoa_id' => $row->pessoa_id,
				'pessoa_nm' => $row->pessoa_nm,
				'pessoa_tipo' => $row->pessoa_tipo,
				'pessoa_email' => $row->pessoa_email,
				'pessoa_st' => $row->pessoa_st,
				'pessoa_dt_criacao' => $row->pessoa_dt_criacao,
				'pessoa_dt_alteracao' => $row->pessoa_dt_alteracao,
				'pessoa_usuario_criador' => $row->pessoa_usuario_criador,
				'setaf_id' => $row->setaf_id,
				'ater_contrato_id' => $row->ater_contrato_id,
				'lote_id' => $row->lote_id,
				'flag_usuario_acervo_digital' => $row->flag_usuario_acervo_digital,
				'cpf_autor' => $row->cpf_autor,
				'instituicao_autor' => $row->instituicao_autor,
				'semaf_municipio_id' => $row->semaf_municipio_id,
				'ppa_municipio_id' => $row->ppa_municipio_id,
				'empresa_id' => $row->empresa_id,
				'flag_cadastro_externo' => $row->flag_cadastro_externo,
				'menipolicultor_territorio_id' => $row->menipolicultor_territorio_id,
				'sipaf_municipio_id' => $row->sipaf_municipio_id,
				'prefeito_municipio_id' => $row->prefeito_municipio_id,
				'cartorio_municipio_id' => $row->cartorio_municipio_id,
				'proposta_dupla_numero' => $row->proposta_dupla_numero,
				'cotacao_territorio_id' => $row->cotacao_territorio_id,
				'cotacao_municipio_id' => $row->cotacao_municipio_id,
				'pessoa_cnpj' => $row->pessoa_cnpj,
				'pessoa_nm_fantasia' => $row->pessoa_nm_fantasia,
				'pessoa_dap' => $row->pessoa_dap,
			);
			$this->load->view('pessoa/Pessoa_form', forFrontVue($data));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('pessoa'));
		}
	}

	public function create()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$setaf = $this->Setaf_model->get_all_combobox();
		$lote = $this->Lote_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$empresa = $this->Empresa_model->get_all_combobox();
		$territorio = $this->Territorio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$territorio = $this->Territorio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$data = array(
			'setaf' => json($setaf),	'lote' => json($lote),	'municipio' => json($municipio),	'municipio' => json($municipio),	'empresa' => json($empresa),	'territorio' => json($territorio),	'municipio' => json($municipio),	'municipio' => json($municipio),	'territorio' => json($territorio),	'municipio' => json($municipio),
			'button' => 'Gravar',
			'controller' => 'create',
			'action' => site_url('pessoa/create_action'),
			'pessoa_id' => set_value('pessoa_id'),
			'pessoa_nm' => set_value('pessoa_nm'),
			'pessoa_tipo' => set_value('pessoa_tipo'),
			'pessoa_email' => set_value('pessoa_email'),
			'pessoa_st' => set_value('pessoa_st'),
			'pessoa_dt_criacao' => set_value('pessoa_dt_criacao'),
			'pessoa_dt_alteracao' => set_value('pessoa_dt_alteracao'),
			'pessoa_usuario_criador' => set_value('pessoa_usuario_criador'),
			'setaf_id' => set_value('setaf_id'),
			'ater_contrato_id' => set_value('ater_contrato_id'),
			'lote_id' => set_value('lote_id'),
			'flag_usuario_acervo_digital' => set_value('flag_usuario_acervo_digital'),
			'cpf_autor' => set_value('cpf_autor'),
			'instituicao_autor' => set_value('instituicao_autor'),
			'semaf_municipio_id' => set_value('semaf_municipio_id'),
			'ppa_municipio_id' => set_value('ppa_municipio_id'),
			'empresa_id' => set_value('empresa_id'),
			'flag_cadastro_externo' => set_value('flag_cadastro_externo'),
			'menipolicultor_territorio_id' => set_value('menipolicultor_territorio_id'),
			'sipaf_municipio_id' => set_value('sipaf_municipio_id'),
			'prefeito_municipio_id' => set_value('prefeito_municipio_id'),
			'cartorio_municipio_id' => set_value('cartorio_municipio_id'),
			'proposta_dupla_numero' => set_value('proposta_dupla_numero'),
			'cotacao_territorio_id' => set_value('cotacao_territorio_id'),
			'cotacao_municipio_id' => set_value('cotacao_municipio_id'),
			'pessoa_cnpj' => set_value('pessoa_cnpj'),
			'pessoa_nm_fantasia' => set_value('pessoa_nm_fantasia'),
			'pessoa_dap' => set_value('pessoa_dap'),
		);
		$this->load->view('pessoa/Pessoa_form', forFrontVue($data));
	}

	public function create_action()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$this->_rules();
		$this->form_validation->set_rules('pessoa_nm', NULL, 'trim|max_length[200]');
		$this->form_validation->set_rules('pessoa_tipo', NULL, 'trim|required|max_length[1]');
		$this->form_validation->set_rules('pessoa_email', NULL, 'trim|max_length[200]');
		$this->form_validation->set_rules('pessoa_st', NULL, 'trim|numeric');
		$this->form_validation->set_rules('pessoa_dt_criacao', NULL, 'trim');
		$this->form_validation->set_rules('pessoa_dt_alteracao', NULL, 'trim');
		$this->form_validation->set_rules('pessoa_usuario_criador', NULL, 'trim|required|integer');
		$this->form_validation->set_rules('setaf_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('ater_contrato_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('lote_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('flag_usuario_acervo_digital', NULL, 'trim|integer');
		$this->form_validation->set_rules('cpf_autor', NULL, 'trim|max_length[100]');
		$this->form_validation->set_rules('instituicao_autor', NULL, 'trim|max_length[100]');
		$this->form_validation->set_rules('semaf_municipio_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('ppa_municipio_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('empresa_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('flag_cadastro_externo', NULL, 'trim|integer');
		$this->form_validation->set_rules('menipolicultor_territorio_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('sipaf_municipio_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('prefeito_municipio_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('cartorio_municipio_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('proposta_dupla_numero', NULL, 'trim|integer');
		$this->form_validation->set_rules('cotacao_territorio_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('cotacao_municipio_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('pessoa_cnpj', NULL, 'trim|max_length[50]');
		$this->form_validation->set_rules('pessoa_nm_fantasia', NULL, 'trim|max_length[500]');
		$this->form_validation->set_rules('pessoa_dap', NULL, 'trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$data = array(
				'pessoa_nm' => 	 empty($this->input->post('pessoa_nm', TRUE)) ? NULL : $this->input->post('pessoa_nm', TRUE),
				'pessoa_tipo' => 	 empty($this->input->post('pessoa_tipo', TRUE)) ? NULL : $this->input->post('pessoa_tipo', TRUE),
				'pessoa_email' => 	 empty($this->input->post('pessoa_email', TRUE)) ? NULL : $this->input->post('pessoa_email', TRUE),
				'pessoa_st' => 	 empty($this->input->post('pessoa_st', TRUE)) ? NULL : $this->input->post('pessoa_st', TRUE),
				'pessoa_dt_criacao' => 	 empty($this->input->post('pessoa_dt_criacao', TRUE)) ? NULL : $this->input->post('pessoa_dt_criacao', TRUE),
				'pessoa_dt_alteracao' => 	 empty($this->input->post('pessoa_dt_alteracao', TRUE)) ? NULL : $this->input->post('pessoa_dt_alteracao', TRUE),
				'pessoa_usuario_criador' => 	 empty($this->input->post('pessoa_usuario_criador', TRUE)) ? NULL : $this->input->post('pessoa_usuario_criador', TRUE),
				'setaf_id' => 	 empty($this->input->post('setaf_id', TRUE)) ? NULL : $this->input->post('setaf_id', TRUE),
				'ater_contrato_id' => 	 empty($this->input->post('ater_contrato_id', TRUE)) ? NULL : $this->input->post('ater_contrato_id', TRUE),
				'lote_id' => 	 empty($this->input->post('lote_id', TRUE)) ? NULL : $this->input->post('lote_id', TRUE),
				'flag_usuario_acervo_digital' => 	 empty($this->input->post('flag_usuario_acervo_digital', TRUE)) ? NULL : $this->input->post('flag_usuario_acervo_digital', TRUE),
				'cpf_autor' => 	 empty($this->input->post('cpf_autor', TRUE)) ? NULL : $this->input->post('cpf_autor', TRUE),
				'instituicao_autor' => 	 empty($this->input->post('instituicao_autor', TRUE)) ? NULL : $this->input->post('instituicao_autor', TRUE),
				'semaf_municipio_id' => 	 empty($this->input->post('semaf_municipio_id', TRUE)) ? NULL : $this->input->post('semaf_municipio_id', TRUE),
				'ppa_municipio_id' => 	 empty($this->input->post('ppa_municipio_id', TRUE)) ? NULL : $this->input->post('ppa_municipio_id', TRUE),
				'empresa_id' => 	 empty($this->input->post('empresa_id', TRUE)) ? NULL : $this->input->post('empresa_id', TRUE),
				'flag_cadastro_externo' => 	 empty($this->input->post('flag_cadastro_externo', TRUE)) ? NULL : $this->input->post('flag_cadastro_externo', TRUE),
				'menipolicultor_territorio_id' => 	 empty($this->input->post('menipolicultor_territorio_id', TRUE)) ? NULL : $this->input->post('menipolicultor_territorio_id', TRUE),
				'sipaf_municipio_id' => 	 empty($this->input->post('sipaf_municipio_id', TRUE)) ? NULL : $this->input->post('sipaf_municipio_id', TRUE),
				'prefeito_municipio_id' => 	 empty($this->input->post('prefeito_municipio_id', TRUE)) ? NULL : $this->input->post('prefeito_municipio_id', TRUE),
				'cartorio_municipio_id' => 	 empty($this->input->post('cartorio_municipio_id', TRUE)) ? NULL : $this->input->post('cartorio_municipio_id', TRUE),
				'proposta_dupla_numero' => 	 empty($this->input->post('proposta_dupla_numero', TRUE)) ? NULL : $this->input->post('proposta_dupla_numero', TRUE),
				'cotacao_territorio_id' => 	 empty($this->input->post('cotacao_territorio_id', TRUE)) ? NULL : $this->input->post('cotacao_territorio_id', TRUE),
				'cotacao_municipio_id' => 	 empty($this->input->post('cotacao_municipio_id', TRUE)) ? NULL : $this->input->post('cotacao_municipio_id', TRUE),
				'pessoa_cnpj' => 	 empty($this->input->post('pessoa_cnpj', TRUE)) ? NULL : $this->input->post('pessoa_cnpj', TRUE),
				'pessoa_nm_fantasia' => 	 empty($this->input->post('pessoa_nm_fantasia', TRUE)) ? NULL : $this->input->post('pessoa_nm_fantasia', TRUE),
				'pessoa_dap' => 	 empty($this->input->post('pessoa_dap', TRUE)) ? NULL : $this->input->post('pessoa_dap', TRUE),
			);

			$this->Pessoa_model->insert($data);
			$this->session->set_flashdata('message', 'Registro Criado com Sucesso');
			redirect(site_url('pessoa'));
		}
	}

	public function update($id)
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$this->session->set_flashdata('message', '');
		$row = $this->Pessoa_model->get_by_id($id);
		$setaf = $this->Setaf_model->get_all_combobox();
		$lote = $this->Lote_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$empresa = $this->Empresa_model->get_all_combobox();
		$territorio = $this->Territorio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		$territorio = $this->Territorio_model->get_all_combobox();
		$municipio = $this->Municipio_model->get_all_combobox();
		if ($row) {
			$data = array(
				'setaf' => json($setaf), 'lote' => json($lote), 'municipio' => json($municipio), 'municipio' => json($municipio), 'empresa' => json($empresa), 'territorio' => json($territorio), 'municipio' => json($municipio), 'municipio' => json($municipio), 'territorio' => json($territorio), 'municipio' => json($municipio),
				'button' => 'Atualizar',
				'controller' => 'update',
				'action' => site_url('pessoa/update_action'),
				'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
				'pessoa_nm' => set_value('pessoa_nm', $row->pessoa_nm),
				'pessoa_tipo' => set_value('pessoa_tipo', $row->pessoa_tipo),
				'pessoa_email' => set_value('pessoa_email', $row->pessoa_email),
				'pessoa_st' => set_value('pessoa_st', $row->pessoa_st),
				'pessoa_dt_criacao' => set_value('pessoa_dt_criacao', $row->pessoa_dt_criacao),
				'pessoa_dt_alteracao' => set_value('pessoa_dt_alteracao', $row->pessoa_dt_alteracao),
				'pessoa_usuario_criador' => set_value('pessoa_usuario_criador', $row->pessoa_usuario_criador),
				'setaf_id' => set_value('setaf_id', $row->setaf_id),
				'ater_contrato_id' => set_value('ater_contrato_id', $row->ater_contrato_id),
				'lote_id' => set_value('lote_id', $row->lote_id),
				'flag_usuario_acervo_digital' => set_value('flag_usuario_acervo_digital', $row->flag_usuario_acervo_digital),
				'cpf_autor' => set_value('cpf_autor', $row->cpf_autor),
				'instituicao_autor' => set_value('instituicao_autor', $row->instituicao_autor),
				'semaf_municipio_id' => set_value('semaf_municipio_id', $row->semaf_municipio_id),
				'ppa_municipio_id' => set_value('ppa_municipio_id', $row->ppa_municipio_id),
				'empresa_id' => set_value('empresa_id', $row->empresa_id),
				'flag_cadastro_externo' => set_value('flag_cadastro_externo', $row->flag_cadastro_externo),
				'menipolicultor_territorio_id' => set_value('menipolicultor_territorio_id', $row->menipolicultor_territorio_id),
				'sipaf_municipio_id' => set_value('sipaf_municipio_id', $row->sipaf_municipio_id),
				'prefeito_municipio_id' => set_value('prefeito_municipio_id', $row->prefeito_municipio_id),
				'cartorio_municipio_id' => set_value('cartorio_municipio_id', $row->cartorio_municipio_id),
				'proposta_dupla_numero' => set_value('proposta_dupla_numero', $row->proposta_dupla_numero),
				'cotacao_territorio_id' => set_value('cotacao_territorio_id', $row->cotacao_territorio_id),
				'cotacao_municipio_id' => set_value('cotacao_municipio_id', $row->cotacao_municipio_id),
				'pessoa_cnpj' => set_value('pessoa_cnpj', $row->pessoa_cnpj),
				'pessoa_nm_fantasia' => set_value('pessoa_nm_fantasia', $row->pessoa_nm_fantasia),
				'pessoa_dap' => set_value('pessoa_dap', $row->pessoa_dap),
			);
			$this->load->view('pessoa/Pessoa_form', forFrontVue($data));
		} else {
			$this->session->set_flashdata('message', 'Registro Não Encontrado');
			redirect(site_url('pessoa'));
		}
	}

	public function update_action()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$this->_rules();
		$this->form_validation->set_rules('pessoa_nm', 'pessoa_nm', 'trim|max_length[200]');
		$this->form_validation->set_rules('pessoa_tipo', 'pessoa_tipo', 'trim|required|max_length[1]');
		$this->form_validation->set_rules('pessoa_email', 'pessoa_email', 'trim|max_length[200]');
		$this->form_validation->set_rules('pessoa_st', 'pessoa_st', 'trim|numeric');
		$this->form_validation->set_rules('pessoa_dt_criacao', 'pessoa_dt_criacao', 'trim');
		$this->form_validation->set_rules('pessoa_dt_alteracao', 'pessoa_dt_alteracao', 'trim');
		$this->form_validation->set_rules('pessoa_usuario_criador', 'pessoa_usuario_criador', 'trim|required|integer');
		$this->form_validation->set_rules('setaf_id', 'setaf_id', 'trim|integer');
		$this->form_validation->set_rules('ater_contrato_id', 'ater_contrato_id', 'trim|integer');
		$this->form_validation->set_rules('lote_id', 'lote_id', 'trim|integer');
		$this->form_validation->set_rules('flag_usuario_acervo_digital', 'flag_usuario_acervo_digital', 'trim|integer');
		$this->form_validation->set_rules('cpf_autor', 'cpf_autor', 'trim|max_length[100]');
		$this->form_validation->set_rules('instituicao_autor', 'instituicao_autor', 'trim|max_length[100]');
		$this->form_validation->set_rules('semaf_municipio_id', 'semaf_municipio_id', 'trim|integer');
		$this->form_validation->set_rules('ppa_municipio_id', 'ppa_municipio_id', 'trim|integer');
		$this->form_validation->set_rules('empresa_id', 'empresa_id', 'trim|integer');
		$this->form_validation->set_rules('flag_cadastro_externo', 'flag_cadastro_externo', 'trim|integer');
		$this->form_validation->set_rules('menipolicultor_territorio_id', 'menipolicultor_territorio_id', 'trim|integer');
		$this->form_validation->set_rules('sipaf_municipio_id', 'sipaf_municipio_id', 'trim|integer');
		$this->form_validation->set_rules('prefeito_municipio_id', 'prefeito_municipio_id', 'trim|integer');
		$this->form_validation->set_rules('cartorio_municipio_id', 'cartorio_municipio_id', 'trim|integer');
		$this->form_validation->set_rules('proposta_dupla_numero', 'proposta_dupla_numero', 'trim|integer');
		$this->form_validation->set_rules('cotacao_territorio_id', 'cotacao_territorio_id', 'trim|integer');
		$this->form_validation->set_rules('cotacao_municipio_id', 'cotacao_municipio_id', 'trim|integer');
		$this->form_validation->set_rules('pessoa_cnpj', 'pessoa_cnpj', 'trim|max_length[50]');
		$this->form_validation->set_rules('pessoa_nm_fantasia', 'pessoa_nm_fantasia', 'trim|max_length[500]');
		$this->form_validation->set_rules('pessoa_dap', 'pessoa_dap', 'trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			#echo validation_errors();
			$this->update($this->input->post('pessoa_id', TRUE));
		} else {
			$data = array(
				'pessoa_nm' => empty($this->input->post('pessoa_nm', TRUE)) ? NULL : $this->input->post('pessoa_nm', TRUE),
				'pessoa_tipo' => empty($this->input->post('pessoa_tipo', TRUE)) ? NULL : $this->input->post('pessoa_tipo', TRUE),
				'pessoa_email' => empty($this->input->post('pessoa_email', TRUE)) ? NULL : $this->input->post('pessoa_email', TRUE),
				'pessoa_st' => empty($this->input->post('pessoa_st', TRUE)) ? NULL : $this->input->post('pessoa_st', TRUE),
				'pessoa_dt_criacao' => empty($this->input->post('pessoa_dt_criacao', TRUE)) ? NULL : $this->input->post('pessoa_dt_criacao', TRUE),
				'pessoa_dt_alteracao' => empty($this->input->post('pessoa_dt_alteracao', TRUE)) ? NULL : $this->input->post('pessoa_dt_alteracao', TRUE),
				'pessoa_usuario_criador' => empty($this->input->post('pessoa_usuario_criador', TRUE)) ? NULL : $this->input->post('pessoa_usuario_criador', TRUE),
				'setaf_id' => empty($this->input->post('setaf_id', TRUE)) ? NULL : $this->input->post('setaf_id', TRUE),
				'ater_contrato_id' => empty($this->input->post('ater_contrato_id', TRUE)) ? NULL : $this->input->post('ater_contrato_id', TRUE),
				'lote_id' => empty($this->input->post('lote_id', TRUE)) ? NULL : $this->input->post('lote_id', TRUE),
				'flag_usuario_acervo_digital' => empty($this->input->post('flag_usuario_acervo_digital', TRUE)) ? NULL : $this->input->post('flag_usuario_acervo_digital', TRUE),
				'cpf_autor' => empty($this->input->post('cpf_autor', TRUE)) ? NULL : $this->input->post('cpf_autor', TRUE),
				'instituicao_autor' => empty($this->input->post('instituicao_autor', TRUE)) ? NULL : $this->input->post('instituicao_autor', TRUE),
				'semaf_municipio_id' => empty($this->input->post('semaf_municipio_id', TRUE)) ? NULL : $this->input->post('semaf_municipio_id', TRUE),
				'ppa_municipio_id' => empty($this->input->post('ppa_municipio_id', TRUE)) ? NULL : $this->input->post('ppa_municipio_id', TRUE),
				'empresa_id' => empty($this->input->post('empresa_id', TRUE)) ? NULL : $this->input->post('empresa_id', TRUE),
				'flag_cadastro_externo' => empty($this->input->post('flag_cadastro_externo', TRUE)) ? NULL : $this->input->post('flag_cadastro_externo', TRUE),
				'menipolicultor_territorio_id' => empty($this->input->post('menipolicultor_territorio_id', TRUE)) ? NULL : $this->input->post('menipolicultor_territorio_id', TRUE),
				'sipaf_municipio_id' => empty($this->input->post('sipaf_municipio_id', TRUE)) ? NULL : $this->input->post('sipaf_municipio_id', TRUE),
				'prefeito_municipio_id' => empty($this->input->post('prefeito_municipio_id', TRUE)) ? NULL : $this->input->post('prefeito_municipio_id', TRUE),
				'cartorio_municipio_id' => empty($this->input->post('cartorio_municipio_id', TRUE)) ? NULL : $this->input->post('cartorio_municipio_id', TRUE),
				'proposta_dupla_numero' => empty($this->input->post('proposta_dupla_numero', TRUE)) ? NULL : $this->input->post('proposta_dupla_numero', TRUE),
				'cotacao_territorio_id' => empty($this->input->post('cotacao_territorio_id', TRUE)) ? NULL : $this->input->post('cotacao_territorio_id', TRUE),
				'cotacao_municipio_id' => empty($this->input->post('cotacao_municipio_id', TRUE)) ? NULL : $this->input->post('cotacao_municipio_id', TRUE),
				'pessoa_cnpj' => empty($this->input->post('pessoa_cnpj', TRUE)) ? NULL : $this->input->post('pessoa_cnpj', TRUE),
				'pessoa_nm_fantasia' => empty($this->input->post('pessoa_nm_fantasia', TRUE)) ? NULL : $this->input->post('pessoa_nm_fantasia', TRUE),
				'pessoa_dap' => empty($this->input->post('pessoa_dap', TRUE)) ? NULL : $this->input->post('pessoa_dap', TRUE),
			);

			$this->Pessoa_model->update($this->input->post('pessoa_id', TRUE), $data);
			$this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
			redirect(site_url('pessoa'));
		}
	}

	public function delete($id)
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$row = $this->Pessoa_model->get_by_id($id);

		if ($row) {
			if (@$this->Pessoa_model->delete($id) == 'erro_dependencia') {
				$this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
				redirect(site_url('pessoa'));
			}


			$this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
			redirect(site_url('pessoa'));
		} else {
			$this->session->set_flashdata('message', 'Registro Não Encontrado');
			redirect(site_url('pessoa'));
		}
	}

	public function _rules()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$this->form_validation->set_rules('pessoa_nm', 'pessoa nm', 'trim|required');
		$this->form_validation->set_rules('pessoa_tipo', 'pessoa tipo', 'trim|required');
		$this->form_validation->set_rules('pessoa_email', 'pessoa email', 'trim|required');
		$this->form_validation->set_rules('pessoa_st', 'pessoa st', 'trim|required');
		$this->form_validation->set_rules('pessoa_dt_criacao', 'pessoa dt criacao', 'trim|required');
		$this->form_validation->set_rules('pessoa_dt_alteracao', 'pessoa dt alteracao', 'trim|required');
		$this->form_validation->set_rules('pessoa_usuario_criador', 'pessoa usuario criador', 'trim|required');
		$this->form_validation->set_rules('setaf_id', 'setaf id', 'trim|required');
		$this->form_validation->set_rules('ater_contrato_id', 'ater contrato id', 'trim|required');
		$this->form_validation->set_rules('lote_id', 'lote id', 'trim|required');
		$this->form_validation->set_rules('flag_usuario_acervo_digital', 'flag usuario acervo digital', 'trim|required');
		$this->form_validation->set_rules('cpf_autor', 'cpf autor', 'trim|required');
		$this->form_validation->set_rules('instituicao_autor', 'instituicao autor', 'trim|required');
		$this->form_validation->set_rules('semaf_municipio_id', 'semaf municipio id', 'trim|required');
		$this->form_validation->set_rules('ppa_municipio_id', 'ppa municipio id', 'trim|required');
		$this->form_validation->set_rules('empresa_id', 'empresa id', 'trim|required');
		$this->form_validation->set_rules('flag_cadastro_externo', 'flag cadastro externo', 'trim|required');
		$this->form_validation->set_rules('menipolicultor_territorio_id', 'menipolicultor territorio id', 'trim|required');
		$this->form_validation->set_rules('sipaf_municipio_id', 'sipaf municipio id', 'trim|required');
		$this->form_validation->set_rules('prefeito_municipio_id', 'prefeito municipio id', 'trim|required');
		$this->form_validation->set_rules('cartorio_municipio_id', 'cartorio municipio id', 'trim|required');
		$this->form_validation->set_rules('proposta_dupla_numero', 'proposta dupla numero', 'trim|required');
		$this->form_validation->set_rules('cotacao_territorio_id', 'cotacao territorio id', 'trim|required');
		$this->form_validation->set_rules('cotacao_municipio_id', 'cotacao municipio id', 'trim|required');
		$this->form_validation->set_rules('pessoa_cnpj', 'pessoa cnpj', 'trim|required');
		$this->form_validation->set_rules('pessoa_nm_fantasia', 'pessoa nm fantasia', 'trim|required');
		$this->form_validation->set_rules('pessoa_dap', 'pessoa dap', 'trim|required');

		$this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}
	public function open_pdf()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

		$param = array(

			array('pessoa_nm', '=', $this->input->post('pessoa_nm', TRUE)),
			array('pessoa_tipo', '=', $this->input->post('pessoa_tipo', TRUE)),
			array('pessoa_email', '=', $this->input->post('pessoa_email', TRUE)),
			array('pessoa_st', '=', $this->input->post('pessoa_st', TRUE)),
			array('pessoa_dt_criacao', '=', $this->input->post('pessoa_dt_criacao', TRUE)),
			array('pessoa_dt_alteracao', '=', $this->input->post('pessoa_dt_alteracao', TRUE)),
			array('pessoa_usuario_criador', '=', $this->input->post('pessoa_usuario_criador', TRUE)),
			array('setaf_id', '=', $this->input->post('setaf_id', TRUE)),
			array('ater_contrato_id', '=', $this->input->post('ater_contrato_id', TRUE)),
			array('lote_id', '=', $this->input->post('lote_id', TRUE)),
			array('flag_usuario_acervo_digital', '=', $this->input->post('flag_usuario_acervo_digital', TRUE)),
			array('cpf_autor', '=', $this->input->post('cpf_autor', TRUE)),
			array('instituicao_autor', '=', $this->input->post('instituicao_autor', TRUE)),
			array('semaf_municipio_id', '=', $this->input->post('semaf_municipio_id', TRUE)),
			array('ppa_municipio_id', '=', $this->input->post('ppa_municipio_id', TRUE)),
			array('empresa_id', '=', $this->input->post('empresa_id', TRUE)),
			array('flag_cadastro_externo', '=', $this->input->post('flag_cadastro_externo', TRUE)),
			array('menipolicultor_territorio_id', '=', $this->input->post('menipolicultor_territorio_id', TRUE)),
			array('sipaf_municipio_id', '=', $this->input->post('sipaf_municipio_id', TRUE)),
			array('prefeito_municipio_id', '=', $this->input->post('prefeito_municipio_id', TRUE)),
			array('cartorio_municipio_id', '=', $this->input->post('cartorio_municipio_id', TRUE)),
			array('proposta_dupla_numero', '=', $this->input->post('proposta_dupla_numero', TRUE)),
			array('cotacao_territorio_id', '=', $this->input->post('cotacao_territorio_id', TRUE)),
			array('cotacao_municipio_id', '=', $this->input->post('cotacao_municipio_id', TRUE)),
			array('pessoa_cnpj', '=', $this->input->post('pessoa_cnpj', TRUE)),
			array('pessoa_nm_fantasia', '=', $this->input->post('pessoa_nm_fantasia', TRUE)),
			array('pessoa_dap', '=', $this->input->post('pessoa_dap', TRUE)),
		); //end array dos parametros

		$data = array(
			'pessoa_data' => $this->Pessoa_model->get_all_data($param),
			'start' => 0
		);
		//limite de memoria do pdf atual
		ini_set('memory_limit', '64M');


		$html =  $this->load->view('pessoa/Pessoa_pdf', $data, true);


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
			'action'        => site_url('pessoa/open_pdf'),
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


		$this->load->view('pessoa/Pessoa_report', forFrontVue($data));
	}
}

/* End of file Pessoa.php */
/* Local: ./application/controllers/Pessoa.php */
/* Gerado por RGenerator - 2024-05-20 21:05:03 */