<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Funcionario extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Funcionario_model');
		$this->load->model('Pessoa_fisica_model');

		$this->load->model('Funcionario_tipo_model');

		$this->load->model('Funcao_model');

		$this->load->model('Cargo_model');

		$this->load->model('Orgao_model');

		$this->load->model('Contrato_model');

		$this->load->model('Cargo_model');

		$this->load->model('Orgao_model');

		$this->load->model('Est_organizacional_lotacao_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$q = urldecode($this->input->get('q', TRUE));
		$format = urldecode($this->input->get('format', TRUE));
		$start = intval($this->input->get('start'));

		if ($q <> '') {
			$config['base_url']  = base_url() . 'funcionario/?q=' . urlencode($q);
			$config['first_url'] = base_url() . 'funcionario/?q=' . urlencode($q);
			$this->session->set_flashdata('message', '');
		} else {
			$config['base_url']  = base_url() . 'funcionario/';
			$config['first_url'] = base_url() . 'funcionario/';
		}

		$config['per_page'] = 10;
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $this->Funcionario_model->total_rows($q);
		$funcionario = $this->Funcionario_model->get_limit_data($config['per_page'], $start, $q);

		## para retorno json no front
		if ($format == 'json') {
			echo json($funcionario);
			exit;
		}

		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$data = array(
			'funcionario_data' => json($funcionario),
			'q' => $q,
			'format' => $format,
			'pagination' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'start' => $start,
		);
		$this->load->view('funcionario/Funcionario_list', forFrontVue($data));
	}

	public function read($id)
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$this->session->set_flashdata('message', '');
		$row = $this->Funcionario_model->get_by_id($id);
		$pessoa_fisica = $this->Pessoa_fisica_model->get_all_combobox();
		$funcionario_tipo = $this->Funcionario_tipo_model->get_all_combobox();
		$funcao = $this->Funcao_model->get_all_combobox();
		$cargo = $this->Cargo_model->get_all_combobox();
		$orgao = $this->Orgao_model->get_all_combobox();
		$contrato = $this->Contrato_model->get_all_combobox();
		$cargo = $this->Cargo_model->get_all_combobox();
		$orgao = $this->Orgao_model->get_all_combobox();
		$est_organizacional_lotacao = $this->Est_organizacional_lotacao_model->get_all_combobox();
		if ($row) {
			$data = array(
				'pessoa_fisica' => json($pessoa_fisica),
				'funcionario_tipo' => json($funcionario_tipo),
				'funcao' => json($funcao),
				'cargo' => json($cargo),
				'orgao' => json($orgao),
				'contrato' => json($contrato),
				'cargo' => json($cargo),
				'orgao' => json($orgao),
				'est_organizacional_lotacao' => json($est_organizacional_lotacao),
				'button' => '',
				'controller' => 'read',
				'action' => site_url('funcionario/create_action'),
				'funcionario_id' => $row->funcionario_id,
				'pessoa_id' => $row->pessoa_id,
				'funcionario_tipo_id' => $row->funcionario_tipo_id,
				'funcao_id' => $row->funcao_id,
				'cargo_permanente' => $row->cargo_permanente,
				'funcionario_matricula' => $row->funcionario_matricula,
				'funcionario_ramal' => $row->funcionario_ramal,
				'funcionario_email' => $row->funcionario_email,
				'funcionario_dt_admissao' => $row->funcionario_dt_admissao,
				'funcionario_dt_demissao' => $row->funcionario_dt_demissao,
				'funcionario_orgao_origem' => $row->funcionario_orgao_origem,
				'funcionario_conta_fgts' => $row->funcionario_conta_fgts,
				'contrato_id' => $row->contrato_id,
				'funcionario_salario' => $row->funcionario_salario,
				'cargo_temporario' => $row->cargo_temporario,
				'funcionario_orgao_destino' => $row->funcionario_orgao_destino,
				'est_organizacional_lotacao_id' => $row->est_organizacional_lotacao_id,
				'funcionario_validacao_propria' => $row->funcionario_validacao_propria,
				'funcionario_validacao_rh' => $row->funcionario_validacao_rh,
				'funcionario_envio_email' => $row->funcionario_envio_email,
				'funcionario_tipo_id_old' => $row->funcionario_tipo_id_old,
				'motorista' => $row->motorista,
				'funcionario_onus' => $row->funcionario_onus,
				'funcionario_funcao_id' => $row->funcionario_funcao_id,
				'funcionario_localizacao' => $row->funcionario_localizacao,
				'funcionario_st' => $row->funcionario_st,
				'funcionario_dt_alteracao' => $row->funcionario_dt_alteracao,
				'funcionario_diaria_bloqueio' => $row->funcionario_diaria_bloqueio,
				'cartao_adiantamento_numero' => $row->cartao_adiantamento_numero,
			);
			$this->load->view('funcionario/Funcionario_form', forFrontVue($data));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('funcionario'));
		}
	}

	public function create()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$pessoa_fisica = $this->Pessoa_fisica_model->get_all_combobox();
		$funcionario_tipo = $this->Funcionario_tipo_model->get_all_combobox();
		$funcao = $this->Funcao_model->get_all_combobox();
		$cargo = $this->Cargo_model->get_all_combobox();
		$orgao = $this->Orgao_model->get_all_combobox();
		$contrato = $this->Contrato_model->get_all_combobox();
		$cargo = $this->Cargo_model->get_all_combobox();
		$orgao = $this->Orgao_model->get_all_combobox();
		$est_organizacional_lotacao = $this->Est_organizacional_lotacao_model->get_all_combobox();
		$data = array(
			'pessoa_fisica' => json($pessoa_fisica),
			'funcionario_tipo' => json($funcionario_tipo),
			'funcao' => json($funcao),
			'cargo' => json($cargo),
			'orgao' => json($orgao),
			'contrato' => json($contrato),
			'cargo' => json($cargo),
			'orgao' => json($orgao),
			'est_organizacional_lotacao' => json($est_organizacional_lotacao),
			'button' => 'Gravar',
			'controller' => 'create',
			'action' => site_url('funcionario/create_action'),
			'funcionario_id' => set_value('funcionario_id'),
			'pessoa_id' => set_value('pessoa_id'),
			'funcionario_tipo_id' => set_value('funcionario_tipo_id'),
			'funcao_id' => set_value('funcao_id'),
			'cargo_permanente' => set_value('cargo_permanente'),
			'funcionario_matricula' => set_value('funcionario_matricula'),
			'funcionario_ramal' => set_value('funcionario_ramal'),
			'funcionario_email' => set_value('funcionario_email'),
			'funcionario_dt_admissao' => set_value('funcionario_dt_admissao'),
			'funcionario_dt_demissao' => set_value('funcionario_dt_demissao'),
			'funcionario_orgao_origem' => set_value('funcionario_orgao_origem'),
			'funcionario_conta_fgts' => set_value('funcionario_conta_fgts'),
			'contrato_id' => set_value('contrato_id'),
			'funcionario_salario' => set_value('funcionario_salario'),
			'cargo_temporario' => set_value('cargo_temporario'),
			'funcionario_orgao_destino' => set_value('funcionario_orgao_destino'),
			'est_organizacional_lotacao_id' => set_value('est_organizacional_lotacao_id'),
			'funcionario_validacao_propria' => set_value('funcionario_validacao_propria'),
			'funcionario_validacao_rh' => set_value('funcionario_validacao_rh'),
			'funcionario_envio_email' => set_value('funcionario_envio_email'),
			'funcionario_tipo_id_old' => set_value('funcionario_tipo_id_old'),
			'motorista' => set_value('motorista'),
			'funcionario_onus' => set_value('funcionario_onus'),
			'funcionario_funcao_id' => set_value('funcionario_funcao_id'),
			'funcionario_localizacao' => set_value('funcionario_localizacao'),
			'funcionario_st' => set_value('funcionario_st'),
			'funcionario_dt_alteracao' => set_value('funcionario_dt_alteracao'),
			'funcionario_diaria_bloqueio' => set_value('funcionario_diaria_bloqueio'),
			'cartao_adiantamento_numero' => set_value('cartao_adiantamento_numero'),
		);
		$this->load->view('funcionario/Funcionario_form', forFrontVue($data));
	}

	public function create_action()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$this->_rules();
		$this->form_validation->set_rules('pessoa_id', NULL, 'trim|required|integer');
		$this->form_validation->set_rules('funcionario_tipo_id', NULL, 'trim|required');
		$this->form_validation->set_rules('funcao_id', NULL, 'trim');
		$this->form_validation->set_rules('cargo_permanente', NULL, 'trim');
		$this->form_validation->set_rules('funcionario_matricula', NULL, 'trim|max_length[20]');
		$this->form_validation->set_rules('funcionario_ramal', NULL, 'trim|max_length[5]');
		$this->form_validation->set_rules('funcionario_email', NULL, 'trim|max_length[200]');
		$this->form_validation->set_rules('funcionario_dt_admissao', NULL, 'trim|max_length[10]');
		$this->form_validation->set_rules('funcionario_dt_demissao', NULL, 'trim|max_length[10]');
		$this->form_validation->set_rules('funcionario_orgao_origem', NULL, 'trim');
		$this->form_validation->set_rules('funcionario_conta_fgts', NULL, 'trim|max_length[20]');
		$this->form_validation->set_rules('contrato_id', NULL, 'trim');
		$this->form_validation->set_rules('funcionario_salario', NULL, 'trim|max_length[20]');
		$this->form_validation->set_rules('cargo_temporario', NULL, 'trim');
		$this->form_validation->set_rules('funcionario_orgao_destino', NULL, 'trim');
		$this->form_validation->set_rules('est_organizacional_lotacao_id', NULL, 'trim');
		$this->form_validation->set_rules('funcionario_validacao_propria', NULL, 'trim|numeric');
		$this->form_validation->set_rules('funcionario_validacao_rh', NULL, 'trim|numeric');
		$this->form_validation->set_rules('funcionario_envio_email', NULL, 'trim|numeric');
		$this->form_validation->set_rules('funcionario_tipo_id_old', NULL, 'trim');
		$this->form_validation->set_rules('motorista', NULL, 'trim|integer');
		$this->form_validation->set_rules('funcionario_onus', NULL, 'trim|max_length[1]');
		$this->form_validation->set_rules('funcionario_funcao_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('funcionario_localizacao', NULL, 'trim|required');
		$this->form_validation->set_rules('funcionario_st', NULL, 'trim|integer');
		$this->form_validation->set_rules('funcionario_dt_alteracao', NULL, 'trim');
		$this->form_validation->set_rules('funcionario_diaria_bloqueio', NULL, 'trim|numeric');
		$this->form_validation->set_rules('cartao_adiantamento_numero', NULL, 'trim|max_length[50]');

		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$data = array(
				'pessoa_id' => 	 empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
				'funcionario_tipo_id' => 	 empty($this->input->post('funcionario_tipo_id', TRUE)) ? NULL : $this->input->post('funcionario_tipo_id', TRUE),
				'funcao_id' => 	 empty($this->input->post('funcao_id', TRUE)) ? NULL : $this->input->post('funcao_id', TRUE),
				'cargo_permanente' => 	 empty($this->input->post('cargo_permanente', TRUE)) ? NULL : $this->input->post('cargo_permanente', TRUE),
				'funcionario_matricula' => 	 empty($this->input->post('funcionario_matricula', TRUE)) ? NULL : $this->input->post('funcionario_matricula', TRUE),
				'funcionario_ramal' => 	 empty($this->input->post('funcionario_ramal', TRUE)) ? NULL : $this->input->post('funcionario_ramal', TRUE),
				'funcionario_email' => 	 empty($this->input->post('funcionario_email', TRUE)) ? NULL : $this->input->post('funcionario_email', TRUE),
				'funcionario_dt_admissao' => 	 empty($this->input->post('funcionario_dt_admissao', TRUE)) ? NULL : $this->input->post('funcionario_dt_admissao', TRUE),
				'funcionario_dt_demissao' => 	 empty($this->input->post('funcionario_dt_demissao', TRUE)) ? NULL : $this->input->post('funcionario_dt_demissao', TRUE),
				'funcionario_orgao_origem' => 	 empty($this->input->post('funcionario_orgao_origem', TRUE)) ? NULL : $this->input->post('funcionario_orgao_origem', TRUE),
				'funcionario_conta_fgts' => 	 empty($this->input->post('funcionario_conta_fgts', TRUE)) ? NULL : $this->input->post('funcionario_conta_fgts', TRUE),
				'contrato_id' => 	 empty($this->input->post('contrato_id', TRUE)) ? NULL : $this->input->post('contrato_id', TRUE),
				'funcionario_salario' => 	 empty($this->input->post('funcionario_salario', TRUE)) ? NULL : $this->input->post('funcionario_salario', TRUE),
				'cargo_temporario' => 	 empty($this->input->post('cargo_temporario', TRUE)) ? NULL : $this->input->post('cargo_temporario', TRUE),
				'funcionario_orgao_destino' => 	 empty($this->input->post('funcionario_orgao_destino', TRUE)) ? NULL : $this->input->post('funcionario_orgao_destino', TRUE),
				'est_organizacional_lotacao_id' => 	 empty($this->input->post('est_organizacional_lotacao_id', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_id', TRUE),
				'funcionario_validacao_propria' => 	 empty($this->input->post('funcionario_validacao_propria', TRUE)) ? NULL : $this->input->post('funcionario_validacao_propria', TRUE),
				'funcionario_validacao_rh' => 	 empty($this->input->post('funcionario_validacao_rh', TRUE)) ? NULL : $this->input->post('funcionario_validacao_rh', TRUE),
				'funcionario_envio_email' => 	 empty($this->input->post('funcionario_envio_email', TRUE)) ? NULL : $this->input->post('funcionario_envio_email', TRUE),
				'funcionario_tipo_id_old' => 	 empty($this->input->post('funcionario_tipo_id_old', TRUE)) ? NULL : $this->input->post('funcionario_tipo_id_old', TRUE),
				'motorista' => 	 empty($this->input->post('motorista', TRUE)) ? NULL : $this->input->post('motorista', TRUE),
				'funcionario_onus' => 	 empty($this->input->post('funcionario_onus', TRUE)) ? NULL : $this->input->post('funcionario_onus', TRUE),
				'funcionario_funcao_id' => 	 empty($this->input->post('funcionario_funcao_id', TRUE)) ? NULL : $this->input->post('funcionario_funcao_id', TRUE),
				'funcionario_localizacao' => 	 empty($this->input->post('funcionario_localizacao', TRUE)) ? NULL : $this->input->post('funcionario_localizacao', TRUE),
				'funcionario_st' => 	 empty($this->input->post('funcionario_st', TRUE)) ? NULL : $this->input->post('funcionario_st', TRUE),
				'funcionario_dt_alteracao' => 	 empty($this->input->post('funcionario_dt_alteracao', TRUE)) ? NULL : $this->input->post('funcionario_dt_alteracao', TRUE),
				'funcionario_diaria_bloqueio' => 	 empty($this->input->post('funcionario_diaria_bloqueio', TRUE)) ? NULL : $this->input->post('funcionario_diaria_bloqueio', TRUE),
				'cartao_adiantamento_numero' => 	 empty($this->input->post('cartao_adiantamento_numero', TRUE)) ? NULL : $this->input->post('cartao_adiantamento_numero', TRUE),
			);

			$this->Funcionario_model->insert($data);
			$this->session->set_flashdata('message', 'Registro Criado com Sucesso');
			redirect(site_url('funcionario'));
		}
	}

	public function update($id)
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$this->session->set_flashdata('message', '');
		$row = $this->Funcionario_model->get_by_id($id);
		$pessoa_fisica = $this->Pessoa_fisica_model->get_all_combobox();
		$funcionario_tipo = $this->Funcionario_tipo_model->get_all_combobox();
		$funcao = $this->Funcao_model->get_all_combobox();
		$cargo = $this->Cargo_model->get_all_combobox();
		$orgao = $this->Orgao_model->get_all_combobox();
		$contrato = $this->Contrato_model->get_all_combobox();
		$cargo = $this->Cargo_model->get_all_combobox();
		$orgao = $this->Orgao_model->get_all_combobox();
		$est_organizacional_lotacao = $this->Est_organizacional_lotacao_model->get_all_combobox();
		if ($row) {
			$data = array(
				'pessoa_fisica' => json($pessoa_fisica),
				'funcionario_tipo' => json($funcionario_tipo),
				'funcao' => json($funcao),
				'cargo' => json($cargo),
				'orgao' => json($orgao),
				'contrato' => json($contrato),
				'cargo' => json($cargo),
				'orgao' => json($orgao),
				'est_organizacional_lotacao' => json($est_organizacional_lotacao),
				'button' => 'Atualizar',
				'controller' => 'update',
				'action' => site_url('funcionario/update_action'),
				'funcionario_id' => set_value('funcionario_id', $row->funcionario_id),
				'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
				'funcionario_tipo_id' => set_value('funcionario_tipo_id', $row->funcionario_tipo_id),
				'funcao_id' => set_value('funcao_id', $row->funcao_id),
				'cargo_permanente' => set_value('cargo_permanente', $row->cargo_permanente),
				'funcionario_matricula' => set_value('funcionario_matricula', $row->funcionario_matricula),
				'funcionario_ramal' => set_value('funcionario_ramal', $row->funcionario_ramal),
				'funcionario_email' => set_value('funcionario_email', $row->funcionario_email),
				'funcionario_dt_admissao' => set_value('funcionario_dt_admissao', $row->funcionario_dt_admissao),
				'funcionario_dt_demissao' => set_value('funcionario_dt_demissao', $row->funcionario_dt_demissao),
				'funcionario_orgao_origem' => set_value('funcionario_orgao_origem', $row->funcionario_orgao_origem),
				'funcionario_conta_fgts' => set_value('funcionario_conta_fgts', $row->funcionario_conta_fgts),
				'contrato_id' => set_value('contrato_id', $row->contrato_id),
				'funcionario_salario' => set_value('funcionario_salario', $row->funcionario_salario),
				'cargo_temporario' => set_value('cargo_temporario', $row->cargo_temporario),
				'funcionario_orgao_destino' => set_value('funcionario_orgao_destino', $row->funcionario_orgao_destino),
				'est_organizacional_lotacao_id' => set_value('est_organizacional_lotacao_id', $row->est_organizacional_lotacao_id),
				'funcionario_validacao_propria' => set_value('funcionario_validacao_propria', $row->funcionario_validacao_propria),
				'funcionario_validacao_rh' => set_value('funcionario_validacao_rh', $row->funcionario_validacao_rh),
				'funcionario_envio_email' => set_value('funcionario_envio_email', $row->funcionario_envio_email),
				'funcionario_tipo_id_old' => set_value('funcionario_tipo_id_old', $row->funcionario_tipo_id_old),
				'motorista' => set_value('motorista', $row->motorista),
				'funcionario_onus' => set_value('funcionario_onus', $row->funcionario_onus),
				'funcionario_funcao_id' => set_value('funcionario_funcao_id', $row->funcionario_funcao_id),
				'funcionario_localizacao' => set_value('funcionario_localizacao', $row->funcionario_localizacao),
				'funcionario_st' => set_value('funcionario_st', $row->funcionario_st),
				'funcionario_dt_alteracao' => set_value('funcionario_dt_alteracao', $row->funcionario_dt_alteracao),
				'funcionario_diaria_bloqueio' => set_value('funcionario_diaria_bloqueio', $row->funcionario_diaria_bloqueio),
				'cartao_adiantamento_numero' => set_value('cartao_adiantamento_numero', $row->cartao_adiantamento_numero),
			);
			$this->load->view('funcionario/Funcionario_form', forFrontVue($data));
		} else {
			$this->session->set_flashdata('message', 'Registro Não Encontrado');
			redirect(site_url('funcionario'));
		}
	}

	public function update_action()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$this->_rules();
		$this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim|required|integer');
		$this->form_validation->set_rules('funcionario_tipo_id', 'funcionario_tipo_id', 'trim|required');
		$this->form_validation->set_rules('funcao_id', 'funcao_id', 'trim');
		$this->form_validation->set_rules('cargo_permanente', 'cargo_permanente', 'trim');
		$this->form_validation->set_rules('funcionario_matricula', 'funcionario_matricula', 'trim|max_length[20]');
		$this->form_validation->set_rules('funcionario_ramal', 'funcionario_ramal', 'trim|max_length[5]');
		$this->form_validation->set_rules('funcionario_email', 'funcionario_email', 'trim|max_length[200]');
		$this->form_validation->set_rules('funcionario_dt_admissao', 'funcionario_dt_admissao', 'trim|max_length[10]');
		$this->form_validation->set_rules('funcionario_dt_demissao', 'funcionario_dt_demissao', 'trim|max_length[10]');
		$this->form_validation->set_rules('funcionario_orgao_origem', 'funcionario_orgao_origem', 'trim');
		$this->form_validation->set_rules('funcionario_conta_fgts', 'funcionario_conta_fgts', 'trim|max_length[20]');
		$this->form_validation->set_rules('contrato_id', 'contrato_id', 'trim');
		$this->form_validation->set_rules('funcionario_salario', 'funcionario_salario', 'trim|max_length[20]');
		$this->form_validation->set_rules('cargo_temporario', 'cargo_temporario', 'trim');
		$this->form_validation->set_rules('funcionario_orgao_destino', 'funcionario_orgao_destino', 'trim');
		$this->form_validation->set_rules('est_organizacional_lotacao_id', 'est_organizacional_lotacao_id', 'trim');
		$this->form_validation->set_rules('funcionario_validacao_propria', 'funcionario_validacao_propria', 'trim|numeric');
		$this->form_validation->set_rules('funcionario_validacao_rh', 'funcionario_validacao_rh', 'trim|numeric');
		$this->form_validation->set_rules('funcionario_envio_email', 'funcionario_envio_email', 'trim|numeric');
		$this->form_validation->set_rules('funcionario_tipo_id_old', 'funcionario_tipo_id_old', 'trim');
		$this->form_validation->set_rules('motorista', 'motorista', 'trim|integer');
		$this->form_validation->set_rules('funcionario_onus', 'funcionario_onus', 'trim|max_length[1]');
		$this->form_validation->set_rules('funcionario_funcao_id', 'funcionario_funcao_id', 'trim|integer');
		$this->form_validation->set_rules('funcionario_localizacao', 'funcionario_localizacao', 'trim|required');
		$this->form_validation->set_rules('funcionario_st', 'funcionario_st', 'trim|integer');
		$this->form_validation->set_rules('funcionario_dt_alteracao', 'funcionario_dt_alteracao', 'trim');
		$this->form_validation->set_rules('funcionario_diaria_bloqueio', 'funcionario_diaria_bloqueio', 'trim|numeric');
		$this->form_validation->set_rules('cartao_adiantamento_numero', 'cartao_adiantamento_numero', 'trim|max_length[50]');

		if ($this->form_validation->run() == FALSE) {
			#echo validation_errors();
			$this->update($this->input->post('funcionario_id', TRUE));
		} else {
			$data = array(
				'pessoa_id' => empty($this->input->post('pessoa_id', TRUE)) ? NULL : $this->input->post('pessoa_id', TRUE),
				'funcionario_tipo_id' => empty($this->input->post('funcionario_tipo_id', TRUE)) ? NULL : $this->input->post('funcionario_tipo_id', TRUE),
				'funcao_id' => empty($this->input->post('funcao_id', TRUE)) ? NULL : $this->input->post('funcao_id', TRUE),
				'cargo_permanente' => empty($this->input->post('cargo_permanente', TRUE)) ? NULL : $this->input->post('cargo_permanente', TRUE),
				'funcionario_matricula' => empty($this->input->post('funcionario_matricula', TRUE)) ? NULL : $this->input->post('funcionario_matricula', TRUE),
				'funcionario_ramal' => empty($this->input->post('funcionario_ramal', TRUE)) ? NULL : $this->input->post('funcionario_ramal', TRUE),
				'funcionario_email' => empty($this->input->post('funcionario_email', TRUE)) ? NULL : $this->input->post('funcionario_email', TRUE),
				'funcionario_dt_admissao' => empty($this->input->post('funcionario_dt_admissao', TRUE)) ? NULL : $this->input->post('funcionario_dt_admissao', TRUE),
				'funcionario_dt_demissao' => empty($this->input->post('funcionario_dt_demissao', TRUE)) ? NULL : $this->input->post('funcionario_dt_demissao', TRUE),
				'funcionario_orgao_origem' => empty($this->input->post('funcionario_orgao_origem', TRUE)) ? NULL : $this->input->post('funcionario_orgao_origem', TRUE),
				'funcionario_conta_fgts' => empty($this->input->post('funcionario_conta_fgts', TRUE)) ? NULL : $this->input->post('funcionario_conta_fgts', TRUE),
				'contrato_id' => empty($this->input->post('contrato_id', TRUE)) ? NULL : $this->input->post('contrato_id', TRUE),
				'funcionario_salario' => empty($this->input->post('funcionario_salario', TRUE)) ? NULL : $this->input->post('funcionario_salario', TRUE),
				'cargo_temporario' => empty($this->input->post('cargo_temporario', TRUE)) ? NULL : $this->input->post('cargo_temporario', TRUE),
				'funcionario_orgao_destino' => empty($this->input->post('funcionario_orgao_destino', TRUE)) ? NULL : $this->input->post('funcionario_orgao_destino', TRUE),
				'est_organizacional_lotacao_id' => empty($this->input->post('est_organizacional_lotacao_id', TRUE)) ? NULL : $this->input->post('est_organizacional_lotacao_id', TRUE),
				'funcionario_validacao_propria' => empty($this->input->post('funcionario_validacao_propria', TRUE)) ? NULL : $this->input->post('funcionario_validacao_propria', TRUE),
				'funcionario_validacao_rh' => empty($this->input->post('funcionario_validacao_rh', TRUE)) ? NULL : $this->input->post('funcionario_validacao_rh', TRUE),
				'funcionario_envio_email' => empty($this->input->post('funcionario_envio_email', TRUE)) ? NULL : $this->input->post('funcionario_envio_email', TRUE),
				'funcionario_tipo_id_old' => empty($this->input->post('funcionario_tipo_id_old', TRUE)) ? NULL : $this->input->post('funcionario_tipo_id_old', TRUE),
				'motorista' => empty($this->input->post('motorista', TRUE)) ? NULL : $this->input->post('motorista', TRUE),
				'funcionario_onus' => empty($this->input->post('funcionario_onus', TRUE)) ? NULL : $this->input->post('funcionario_onus', TRUE),
				'funcionario_funcao_id' => empty($this->input->post('funcionario_funcao_id', TRUE)) ? NULL : $this->input->post('funcionario_funcao_id', TRUE),
				'funcionario_localizacao' => empty($this->input->post('funcionario_localizacao', TRUE)) ? NULL : $this->input->post('funcionario_localizacao', TRUE),
				'funcionario_st' => empty($this->input->post('funcionario_st', TRUE)) ? NULL : $this->input->post('funcionario_st', TRUE),
				'funcionario_dt_alteracao' => empty($this->input->post('funcionario_dt_alteracao', TRUE)) ? NULL : $this->input->post('funcionario_dt_alteracao', TRUE),
				'funcionario_diaria_bloqueio' => empty($this->input->post('funcionario_diaria_bloqueio', TRUE)) ? NULL : $this->input->post('funcionario_diaria_bloqueio', TRUE),
				'cartao_adiantamento_numero' => empty($this->input->post('cartao_adiantamento_numero', TRUE)) ? NULL : $this->input->post('cartao_adiantamento_numero', TRUE),
			);

			$this->Funcionario_model->update($this->input->post('funcionario_id', TRUE), $data);
			$this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
			redirect(site_url('funcionario'));
		}
	}

	/*
	public function delete($id)
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$row = $this->Funcionario_model->get_by_id($id);

		if ($row) {
			if (@$this->Funcionario_model->delete($id) == 'erro_dependencia') {
				$this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
				redirect(site_url('funcionario'));
			}


			$this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
			redirect(site_url('funcionario'));
		} else {
			$this->session->set_flashdata('message', 'Registro Não Encontrado');
			redirect(site_url('funcionario'));
		}
	}
		*/

	public function _rules()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);
		$this->form_validation->set_rules('pessoa_id', 'pessoa id', 'trim|required');
		$this->form_validation->set_rules('funcionario_tipo_id', 'funcionario tipo id', 'trim|required');
		$this->form_validation->set_rules('funcao_id', 'funcao id', 'trim|required');
		$this->form_validation->set_rules('cargo_permanente', 'cargo permanente', 'trim|required');
		$this->form_validation->set_rules('funcionario_matricula', 'funcionario matricula', 'trim|required');
		$this->form_validation->set_rules('funcionario_ramal', 'funcionario ramal', 'trim|required');
		$this->form_validation->set_rules('funcionario_email', 'funcionario email', 'trim|required');
		$this->form_validation->set_rules('funcionario_dt_admissao', 'funcionario dt admissao', 'trim|required');
		$this->form_validation->set_rules('funcionario_dt_demissao', 'funcionario dt demissao', 'trim|required');
		$this->form_validation->set_rules('funcionario_orgao_origem', 'funcionario orgao origem', 'trim|required');
		$this->form_validation->set_rules('funcionario_conta_fgts', 'funcionario conta fgts', 'trim|required');
		$this->form_validation->set_rules('contrato_id', 'contrato id', 'trim|required');
		$this->form_validation->set_rules('funcionario_salario', 'funcionario salario', 'trim|required');
		$this->form_validation->set_rules('cargo_temporario', 'cargo temporario', 'trim|required');
		$this->form_validation->set_rules('funcionario_orgao_destino', 'funcionario orgao destino', 'trim|required');
		$this->form_validation->set_rules('est_organizacional_lotacao_id', 'est organizacional lotacao id', 'trim|required');
		$this->form_validation->set_rules('funcionario_validacao_propria', 'funcionario validacao propria', 'trim|required');
		$this->form_validation->set_rules('funcionario_validacao_rh', 'funcionario validacao rh', 'trim|required');
		$this->form_validation->set_rules('funcionario_envio_email', 'funcionario envio email', 'trim|required');
		$this->form_validation->set_rules('funcionario_tipo_id_old', 'funcionario tipo id old', 'trim|required');
		$this->form_validation->set_rules('motorista', 'motorista', 'trim|required');
		$this->form_validation->set_rules('funcionario_onus', 'funcionario onus', 'trim|required');
		$this->form_validation->set_rules('funcionario_funcao_id', 'funcionario funcao id', 'trim|required');
		$this->form_validation->set_rules('funcionario_localizacao', 'funcionario localizacao', 'trim|required');
		$this->form_validation->set_rules('funcionario_st', 'funcionario st', 'trim|required');
		$this->form_validation->set_rules('funcionario_dt_alteracao', 'funcionario dt alteracao', 'trim|required');
		$this->form_validation->set_rules('funcionario_diaria_bloqueio', 'funcionario diaria bloqueio', 'trim|required');
		$this->form_validation->set_rules('cartao_adiantamento_numero', 'cartao adiantamento numero', 'trim|required');

		$this->form_validation->set_rules('funcionario_id', 'funcionario_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}
	public function open_pdf()
	{
		PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario']);

		$param = array(

			array('pessoa_id', '=', $this->input->post('pessoa_id', TRUE)),
			array('funcionario_tipo_id', '=', $this->input->post('funcionario_tipo_id', TRUE)),
			array('funcao_id', '=', $this->input->post('funcao_id', TRUE)),
			array('cargo_permanente', '=', $this->input->post('cargo_permanente', TRUE)),
			array('funcionario_matricula', '=', $this->input->post('funcionario_matricula', TRUE)),
			array('funcionario_ramal', '=', $this->input->post('funcionario_ramal', TRUE)),
			array('funcionario_email', '=', $this->input->post('funcionario_email', TRUE)),
			array('funcionario_dt_admissao', '=', $this->input->post('funcionario_dt_admissao', TRUE)),
			array('funcionario_dt_demissao', '=', $this->input->post('funcionario_dt_demissao', TRUE)),
			array('funcionario_orgao_origem', '=', $this->input->post('funcionario_orgao_origem', TRUE)),
			array('funcionario_conta_fgts', '=', $this->input->post('funcionario_conta_fgts', TRUE)),
			array('contrato_id', '=', $this->input->post('contrato_id', TRUE)),
			array('funcionario_salario', '=', $this->input->post('funcionario_salario', TRUE)),
			array('cargo_temporario', '=', $this->input->post('cargo_temporario', TRUE)),
			array('funcionario_orgao_destino', '=', $this->input->post('funcionario_orgao_destino', TRUE)),
			array('est_organizacional_lotacao_id', '=', $this->input->post('est_organizacional_lotacao_id', TRUE)),
			array('funcionario_validacao_propria', '=', $this->input->post('funcionario_validacao_propria', TRUE)),
			array('funcionario_validacao_rh', '=', $this->input->post('funcionario_validacao_rh', TRUE)),
			array('funcionario_envio_email', '=', $this->input->post('funcionario_envio_email', TRUE)),
			array('funcionario_tipo_id_old', '=', $this->input->post('funcionario_tipo_id_old', TRUE)),
			array('motorista', '=', $this->input->post('motorista', TRUE)),
			array('funcionario_onus', '=', $this->input->post('funcionario_onus', TRUE)),
			array('funcionario_funcao_id', '=', $this->input->post('funcionario_funcao_id', TRUE)),
			array('funcionario_localizacao', '=', $this->input->post('funcionario_localizacao', TRUE)),
			array('funcionario_st', '=', $this->input->post('funcionario_st', TRUE)),
			array('funcionario_dt_alteracao', '=', $this->input->post('funcionario_dt_alteracao', TRUE)),
			array('funcionario_diaria_bloqueio', '=', $this->input->post('funcionario_diaria_bloqueio', TRUE)),
			array('cartao_adiantamento_numero', '=', $this->input->post('cartao_adiantamento_numero', TRUE)),
		); //end array dos parametros

		$data = array(
			'funcionario_data' => $this->Funcionario_model->get_all_data($param),
			'start' => 0
		);
		//limite de memoria do pdf atual
		ini_set('memory_limit', '64M');


		$html =  $this->load->view('funcionario/Funcionario_pdf', $data, true);


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
			'action'        => site_url('funcionario/open_pdf'),
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


		$this->load->view('funcionario/Funcionario_report', forFrontVue($data));
	}
}

/* End of file Funcionario.php */
/* Local: ./application/controllers/Funcionario.php */
/* Gerado por RGenerator - 2024-01-24 18:36:08 */