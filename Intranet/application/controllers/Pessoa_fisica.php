<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Pessoa_fisica extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Pessoa_fisica_model');
		$this->load->model('Estado_civil_model');

		$this->load->model('Nivel_escolar_model');
		$this->load->library('form_validation');
		PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
	}

	public function index()
	{
		$q = urldecode($this->input->get('q', TRUE));
		$format = urldecode($this->input->get('format', TRUE));
		$start = intval($this->input->get('start'));

		if ($q <> '') {
			$config['base_url']  = base_url() . 'pessoa_fisica/?q=' . urlencode($q);
			$config['first_url'] = base_url() . 'pessoa_fisica/?q=' . urlencode($q);
			$this->session->set_flashdata('message', '');
		} else {
			$config['base_url']  = base_url() . 'pessoa_fisica/';
			$config['first_url'] = base_url() . 'pessoa_fisica/';
		}

		$config['per_page'] = 10;
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $this->Pessoa_fisica_model->total_rows($q);
		$pessoa_fisica = $this->Pessoa_fisica_model->get_limit_data($config['per_page'], $start, $q);

		## para retorno json no front
		if ($format == 'json') {
			echo json($pessoa_fisica);
			exit;
		}

		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$data = array(
			'pessoa_fisica_data' => json($pessoa_fisica),
			'q' => $q,
			'format' => $format,
			'pagination' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'start' => $start,
		);
		$this->load->view('pessoa_fisica/Pessoa_fisica_list', $data);
	}

	public function read($id)
	{
		$this->session->set_flashdata('message', '');
		$row = $this->Pessoa_fisica_model->get_by_id($id);
		$estado_civil = $this->Estado_civil_model->get_all_combobox();
		$nivel_escolar = $this->Nivel_escolar_model->get_all_combobox();
		if ($row) {
			$data = array(
				'estado_civil' => json($estado_civil),
				'nivel_escolar' => json($nivel_escolar),
				'button' => '',
				'controller' => 'read',
				'action' => site_url('pessoa_fisica/create_action'),
				'pessoa_id' => $row->pessoa_id,
				'pessoa_fisica_sexo' => $row->pessoa_fisica_sexo,
				'pessoa_fisica_cpf' => $row->pessoa_fisica_cpf,
				'pessoa_fisica_dt_nasc' => $row->pessoa_fisica_dt_nasc,
				'pessoa_fisica_rg' => $row->pessoa_fisica_rg,
				'pessoa_fisica_rg_orgao' => $row->pessoa_fisica_rg_orgao,
				'pessoa_fisica_rg_uf' => $row->pessoa_fisica_rg_uf,
				'pessoa_fisica_rg_dt' => $row->pessoa_fisica_rg_dt,
				'pessoa_fisica_passaporte' => $row->pessoa_fisica_passaporte,
				'pessoa_fisica_nm_pai' => $row->pessoa_fisica_nm_pai,
				'pessoa_fisica_nm_mae' => $row->pessoa_fisica_nm_mae,
				'pessoa_fisica_grupo_sanguineo' => $row->pessoa_fisica_grupo_sanguineo,
				'pessoa_fisica_nacionalidade' => $row->pessoa_fisica_nacionalidade,
				'pessoa_fisica_naturalidade' => $row->pessoa_fisica_naturalidade,
				'pessoa_fisica_naturalidade_uf' => $row->pessoa_fisica_naturalidade_uf,
				'pessoa_fisica_clt' => $row->pessoa_fisica_clt,
				'pessoa_fisica_clt_serie' => $row->pessoa_fisica_clt_serie,
				'pessoa_fisica_clt_uf' => $row->pessoa_fisica_clt_uf,
				'pessoa_fisica_titulo' => $row->pessoa_fisica_titulo,
				'pessoa_fisica_titulo_zona' => $row->pessoa_fisica_titulo_zona,
				'pessoa_fisica_titulo_secao' => $row->pessoa_fisica_titulo_secao,
				'pessoa_fisica_titulo_cidade' => $row->pessoa_fisica_titulo_cidade,
				'pessoa_fisica_titulo_uf' => $row->pessoa_fisica_titulo_uf,
				'pessoa_fisica_cnh' => $row->pessoa_fisica_cnh,
				'pessoa_fisica_cnh_categoria' => $row->pessoa_fisica_cnh_categoria,
				'pessoa_fisica_cnh_validade' => $row->pessoa_fisica_cnh_validade,
				'pessoa_fisica_reservista' => $row->pessoa_fisica_reservista,
				'pessoa_fisica_reservista_ministerio' => $row->pessoa_fisica_reservista_ministerio,
				'pessoa_fisica_reservista_uf' => $row->pessoa_fisica_reservista_uf,
				'pessoa_fisica_pis' => $row->pessoa_fisica_pis,
				'estado_civil_id' => $row->estado_civil_id,
				'nivel_escolar_id' => $row->nivel_escolar_id,
				'pessoa_fisica_funcionario' => $row->pessoa_fisica_funcionario,
				'pessoa_fisica_cnh_lente_corretiva' => $row->pessoa_fisica_cnh_lente_corretiva,
				'pessoa_fisica_filho' => $row->pessoa_fisica_filho,
				'pessoa_fisica_filha' => $row->pessoa_fisica_filha,
				'pessoa_apelido' => $row->pessoa_apelido,
				'pessoa_fisica_foto' => $row->pessoa_fisica_foto,
				'pessoa_fisica_st_site' => $row->pessoa_fisica_st_site,
				'pessoa_fisica_represen' => $row->pessoa_fisica_represen,
				'pessoa_fisica_represen_desc' => $row->pessoa_fisica_represen_desc,
				'pessoa_fisica_ano_ingresso' => $row->pessoa_fisica_ano_ingresso,
				'area_profissional_id' => $row->area_profissional_id,
				'pessoa_fisica_id' => $row->pessoa_fisica_id,
			);
			$this->load->view('pessoa_fisica/Pessoa_fisica_form', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('pessoa_fisica'));
		}
	}

	public function create()
	{
		$estado_civil = $this->Estado_civil_model->get_all_combobox();
		$nivel_escolar = $this->Nivel_escolar_model->get_all_combobox();
		$data = array(
			'estado_civil' => json($estado_civil),
			'nivel_escolar' => json($nivel_escolar),
			'button' => 'Gravar',
			'controller' => 'create',
			'action' => site_url('pessoa_fisica/create_action'),
			'pessoa_id' => set_value('pessoa_id'),
			'pessoa_fisica_sexo' => set_value('pessoa_fisica_sexo'),
			'pessoa_fisica_cpf' => set_value('pessoa_fisica_cpf'),
			'pessoa_fisica_dt_nasc' => set_value('pessoa_fisica_dt_nasc'),
			'pessoa_fisica_rg' => set_value('pessoa_fisica_rg'),
			'pessoa_fisica_rg_orgao' => set_value('pessoa_fisica_rg_orgao'),
			'pessoa_fisica_rg_uf' => set_value('pessoa_fisica_rg_uf'),
			'pessoa_fisica_rg_dt' => set_value('pessoa_fisica_rg_dt'),
			'pessoa_fisica_passaporte' => set_value('pessoa_fisica_passaporte'),
			'pessoa_fisica_nm_pai' => set_value('pessoa_fisica_nm_pai'),
			'pessoa_fisica_nm_mae' => set_value('pessoa_fisica_nm_mae'),
			'pessoa_fisica_grupo_sanguineo' => set_value('pessoa_fisica_grupo_sanguineo'),
			'pessoa_fisica_nacionalidade' => set_value('pessoa_fisica_nacionalidade'),
			'pessoa_fisica_naturalidade' => set_value('pessoa_fisica_naturalidade'),
			'pessoa_fisica_naturalidade_uf' => set_value('pessoa_fisica_naturalidade_uf'),
			'pessoa_fisica_clt' => set_value('pessoa_fisica_clt'),
			'pessoa_fisica_clt_serie' => set_value('pessoa_fisica_clt_serie'),
			'pessoa_fisica_clt_uf' => set_value('pessoa_fisica_clt_uf'),
			'pessoa_fisica_titulo' => set_value('pessoa_fisica_titulo'),
			'pessoa_fisica_titulo_zona' => set_value('pessoa_fisica_titulo_zona'),
			'pessoa_fisica_titulo_secao' => set_value('pessoa_fisica_titulo_secao'),
			'pessoa_fisica_titulo_cidade' => set_value('pessoa_fisica_titulo_cidade'),
			'pessoa_fisica_titulo_uf' => set_value('pessoa_fisica_titulo_uf'),
			'pessoa_fisica_cnh' => set_value('pessoa_fisica_cnh'),
			'pessoa_fisica_cnh_categoria' => set_value('pessoa_fisica_cnh_categoria'),
			'pessoa_fisica_cnh_validade' => set_value('pessoa_fisica_cnh_validade'),
			'pessoa_fisica_reservista' => set_value('pessoa_fisica_reservista'),
			'pessoa_fisica_reservista_ministerio' => set_value('pessoa_fisica_reservista_ministerio'),
			'pessoa_fisica_reservista_uf' => set_value('pessoa_fisica_reservista_uf'),
			'pessoa_fisica_pis' => set_value('pessoa_fisica_pis'),
			'estado_civil_id' => set_value('estado_civil_id'),
			'nivel_escolar_id' => set_value('nivel_escolar_id'),
			'pessoa_fisica_funcionario' => set_value('pessoa_fisica_funcionario'),
			'pessoa_fisica_cnh_lente_corretiva' => set_value('pessoa_fisica_cnh_lente_corretiva'),
			'pessoa_fisica_filho' => set_value('pessoa_fisica_filho'),
			'pessoa_fisica_filha' => set_value('pessoa_fisica_filha'),
			'pessoa_apelido' => set_value('pessoa_apelido'),
			'pessoa_fisica_foto' => set_value('pessoa_fisica_foto'),
			'pessoa_fisica_st_site' => set_value('pessoa_fisica_st_site'),
			'pessoa_fisica_represen' => set_value('pessoa_fisica_represen'),
			'pessoa_fisica_represen_desc' => set_value('pessoa_fisica_represen_desc'),
			'pessoa_fisica_ano_ingresso' => set_value('pessoa_fisica_ano_ingresso'),
			'area_profissional_id' => set_value('area_profissional_id'),
			'pessoa_fisica_id' => set_value('pessoa_fisica_id'),
		);
		$this->load->view('pessoa_fisica/Pessoa_fisica_form', $data);
	}

	public function create_action()
	{
		$this->_rules();
		$this->form_validation->set_rules('pessoa_fisica_sexo', NULL, 'trim|max_length[1]');
		$this->form_validation->set_rules('pessoa_fisica_cpf', NULL, 'trim|required|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_dt_nasc', NULL, 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_rg', NULL, 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_rg_orgao', NULL, 'trim|max_length[50]');
		$this->form_validation->set_rules('pessoa_fisica_rg_uf', NULL, 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_rg_dt', NULL, 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_passaporte', NULL, 'trim|max_length[50]');
		$this->form_validation->set_rules('pessoa_fisica_nm_pai', NULL, 'trim|max_length[255]');
		$this->form_validation->set_rules('pessoa_fisica_nm_mae', NULL, 'trim|max_length[255]');
		$this->form_validation->set_rules('pessoa_fisica_grupo_sanguineo', NULL, 'trim|max_length[3]');
		$this->form_validation->set_rules('pessoa_fisica_nacionalidade', NULL, 'trim|max_length[50]');
		$this->form_validation->set_rules('pessoa_fisica_naturalidade', NULL, 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_naturalidade_uf', NULL, 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_clt', NULL, 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_clt_serie', NULL, 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_clt_uf', NULL, 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_titulo', NULL, 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_titulo_zona', NULL, 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_titulo_secao', NULL, 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_titulo_cidade', NULL, 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_titulo_uf', NULL, 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_cnh', NULL, 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_cnh_categoria', NULL, 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_cnh_validade', NULL, 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_reservista', NULL, 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_reservista_ministerio', NULL, 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_reservista_uf', NULL, 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_pis', NULL, 'trim|max_length[50]');
		$this->form_validation->set_rules('estado_civil_id', NULL, 'trim');
		$this->form_validation->set_rules('nivel_escolar_id', NULL, 'trim');
		$this->form_validation->set_rules('pessoa_fisica_funcionario', NULL, 'trim|numeric');
		$this->form_validation->set_rules('pessoa_fisica_cnh_lente_corretiva', NULL, 'trim|max_length[1]');
		$this->form_validation->set_rules('pessoa_fisica_filho', NULL, 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_filha', NULL, 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_apelido', NULL, 'trim|max_length[70]');
		$this->form_validation->set_rules('pessoa_fisica_foto', NULL, 'trim|integer');
		$this->form_validation->set_rules('pessoa_fisica_st_site', NULL, 'trim|integer');
		$this->form_validation->set_rules('pessoa_fisica_represen', NULL, 'trim|max_length[100]');
		$this->form_validation->set_rules('pessoa_fisica_represen_desc', NULL, 'trim|max_length[100]');
		$this->form_validation->set_rules('pessoa_fisica_ano_ingresso', NULL, 'trim|max_length[10]');
		$this->form_validation->set_rules('area_profissional_id', NULL, 'trim|integer');
		$this->form_validation->set_rules('pessoa_fisica_id', NULL, 'trim|required|integer');

		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$data = array(
				'pessoa_fisica_sexo' => 	 empty($this->input->post('pessoa_fisica_sexo', TRUE)) ? NULL : $this->input->post('pessoa_fisica_sexo', TRUE),
				'pessoa_fisica_cpf' => 	 empty($this->input->post('pessoa_fisica_cpf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_cpf', TRUE),
				'pessoa_fisica_dt_nasc' => 	 empty($this->input->post('pessoa_fisica_dt_nasc', TRUE)) ? NULL : $this->input->post('pessoa_fisica_dt_nasc', TRUE),
				'pessoa_fisica_rg' => 	 empty($this->input->post('pessoa_fisica_rg', TRUE)) ? NULL : $this->input->post('pessoa_fisica_rg', TRUE),
				'pessoa_fisica_rg_orgao' => 	 empty($this->input->post('pessoa_fisica_rg_orgao', TRUE)) ? NULL : $this->input->post('pessoa_fisica_rg_orgao', TRUE),
				'pessoa_fisica_rg_uf' => 	 empty($this->input->post('pessoa_fisica_rg_uf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_rg_uf', TRUE),
				'pessoa_fisica_rg_dt' => 	 empty($this->input->post('pessoa_fisica_rg_dt', TRUE)) ? NULL : $this->input->post('pessoa_fisica_rg_dt', TRUE),
				'pessoa_fisica_passaporte' => 	 empty($this->input->post('pessoa_fisica_passaporte', TRUE)) ? NULL : $this->input->post('pessoa_fisica_passaporte', TRUE),
				'pessoa_fisica_nm_pai' => 	 empty($this->input->post('pessoa_fisica_nm_pai', TRUE)) ? NULL : $this->input->post('pessoa_fisica_nm_pai', TRUE),
				'pessoa_fisica_nm_mae' => 	 empty($this->input->post('pessoa_fisica_nm_mae', TRUE)) ? NULL : $this->input->post('pessoa_fisica_nm_mae', TRUE),
				'pessoa_fisica_grupo_sanguineo' => 	 empty($this->input->post('pessoa_fisica_grupo_sanguineo', TRUE)) ? NULL : $this->input->post('pessoa_fisica_grupo_sanguineo', TRUE),
				'pessoa_fisica_nacionalidade' => 	 empty($this->input->post('pessoa_fisica_nacionalidade', TRUE)) ? NULL : $this->input->post('pessoa_fisica_nacionalidade', TRUE),
				'pessoa_fisica_naturalidade' => 	 empty($this->input->post('pessoa_fisica_naturalidade', TRUE)) ? NULL : $this->input->post('pessoa_fisica_naturalidade', TRUE),
				'pessoa_fisica_naturalidade_uf' => 	 empty($this->input->post('pessoa_fisica_naturalidade_uf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_naturalidade_uf', TRUE),
				'pessoa_fisica_clt' => 	 empty($this->input->post('pessoa_fisica_clt', TRUE)) ? NULL : $this->input->post('pessoa_fisica_clt', TRUE),
				'pessoa_fisica_clt_serie' => 	 empty($this->input->post('pessoa_fisica_clt_serie', TRUE)) ? NULL : $this->input->post('pessoa_fisica_clt_serie', TRUE),
				'pessoa_fisica_clt_uf' => 	 empty($this->input->post('pessoa_fisica_clt_uf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_clt_uf', TRUE),
				'pessoa_fisica_titulo' => 	 empty($this->input->post('pessoa_fisica_titulo', TRUE)) ? NULL : $this->input->post('pessoa_fisica_titulo', TRUE),
				'pessoa_fisica_titulo_zona' => 	 empty($this->input->post('pessoa_fisica_titulo_zona', TRUE)) ? NULL : $this->input->post('pessoa_fisica_titulo_zona', TRUE),
				'pessoa_fisica_titulo_secao' => 	 empty($this->input->post('pessoa_fisica_titulo_secao', TRUE)) ? NULL : $this->input->post('pessoa_fisica_titulo_secao', TRUE),
				'pessoa_fisica_titulo_cidade' => 	 empty($this->input->post('pessoa_fisica_titulo_cidade', TRUE)) ? NULL : $this->input->post('pessoa_fisica_titulo_cidade', TRUE),
				'pessoa_fisica_titulo_uf' => 	 empty($this->input->post('pessoa_fisica_titulo_uf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_titulo_uf', TRUE),
				'pessoa_fisica_cnh' => 	 empty($this->input->post('pessoa_fisica_cnh', TRUE)) ? NULL : $this->input->post('pessoa_fisica_cnh', TRUE),
				'pessoa_fisica_cnh_categoria' => 	 empty($this->input->post('pessoa_fisica_cnh_categoria', TRUE)) ? NULL : $this->input->post('pessoa_fisica_cnh_categoria', TRUE),
				'pessoa_fisica_cnh_validade' => 	 empty($this->input->post('pessoa_fisica_cnh_validade', TRUE)) ? NULL : $this->input->post('pessoa_fisica_cnh_validade', TRUE),
				'pessoa_fisica_reservista' => 	 empty($this->input->post('pessoa_fisica_reservista', TRUE)) ? NULL : $this->input->post('pessoa_fisica_reservista', TRUE),
				'pessoa_fisica_reservista_ministerio' => 	 empty($this->input->post('pessoa_fisica_reservista_ministerio', TRUE)) ? NULL : $this->input->post('pessoa_fisica_reservista_ministerio', TRUE),
				'pessoa_fisica_reservista_uf' => 	 empty($this->input->post('pessoa_fisica_reservista_uf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_reservista_uf', TRUE),
				'pessoa_fisica_pis' => 	 empty($this->input->post('pessoa_fisica_pis', TRUE)) ? NULL : $this->input->post('pessoa_fisica_pis', TRUE),
				'estado_civil_id' => 	 empty($this->input->post('estado_civil_id', TRUE)) ? NULL : $this->input->post('estado_civil_id', TRUE),
				'nivel_escolar_id' => 	 empty($this->input->post('nivel_escolar_id', TRUE)) ? NULL : $this->input->post('nivel_escolar_id', TRUE),
				'pessoa_fisica_funcionario' => 	 empty($this->input->post('pessoa_fisica_funcionario', TRUE)) ? NULL : $this->input->post('pessoa_fisica_funcionario', TRUE),
				'pessoa_fisica_cnh_lente_corretiva' => 	 empty($this->input->post('pessoa_fisica_cnh_lente_corretiva', TRUE)) ? NULL : $this->input->post('pessoa_fisica_cnh_lente_corretiva', TRUE),
				'pessoa_fisica_filho' => 	 empty($this->input->post('pessoa_fisica_filho', TRUE)) ? NULL : $this->input->post('pessoa_fisica_filho', TRUE),
				'pessoa_fisica_filha' => 	 empty($this->input->post('pessoa_fisica_filha', TRUE)) ? NULL : $this->input->post('pessoa_fisica_filha', TRUE),
				'pessoa_apelido' => 	 empty($this->input->post('pessoa_apelido', TRUE)) ? NULL : $this->input->post('pessoa_apelido', TRUE),
				'pessoa_fisica_foto' => 	 empty($this->input->post('pessoa_fisica_foto', TRUE)) ? NULL : $this->input->post('pessoa_fisica_foto', TRUE),
				'pessoa_fisica_st_site' => 	 empty($this->input->post('pessoa_fisica_st_site', TRUE)) ? NULL : $this->input->post('pessoa_fisica_st_site', TRUE),
				'pessoa_fisica_represen' => 	 empty($this->input->post('pessoa_fisica_represen', TRUE)) ? NULL : $this->input->post('pessoa_fisica_represen', TRUE),
				'pessoa_fisica_represen_desc' => 	 empty($this->input->post('pessoa_fisica_represen_desc', TRUE)) ? NULL : $this->input->post('pessoa_fisica_represen_desc', TRUE),
				'pessoa_fisica_ano_ingresso' => 	 empty($this->input->post('pessoa_fisica_ano_ingresso', TRUE)) ? NULL : $this->input->post('pessoa_fisica_ano_ingresso', TRUE),
				'area_profissional_id' => 	 empty($this->input->post('area_profissional_id', TRUE)) ? NULL : $this->input->post('area_profissional_id', TRUE),
				'pessoa_fisica_id' => 	 empty($this->input->post('pessoa_fisica_id', TRUE)) ? NULL : $this->input->post('pessoa_fisica_id', TRUE),
			);

			$this->Pessoa_fisica_model->insert($data);
			$this->session->set_flashdata('message', 'Registro Criado com Sucesso');
			redirect(site_url('pessoa_fisica'));
		}
	}

	public function update($id)
	{
		$this->session->set_flashdata('message', '');
		$row = $this->Pessoa_fisica_model->get_by_id($id);
		$estado_civil = $this->Estado_civil_model->get_all_combobox();
		$nivel_escolar = $this->Nivel_escolar_model->get_all_combobox();
		if ($row) {
			$data = array(
				'estado_civil' => json($estado_civil),
				'nivel_escolar' => json($nivel_escolar),
				'button' => 'Atualizar',
				'controller' => 'update',
				'action' => site_url('pessoa_fisica/update_action'),
				'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
				'pessoa_fisica_sexo' => set_value('pessoa_fisica_sexo', $row->pessoa_fisica_sexo),
				'pessoa_fisica_cpf' => set_value('pessoa_fisica_cpf', $row->pessoa_fisica_cpf),
				'pessoa_fisica_dt_nasc' => set_value('pessoa_fisica_dt_nasc', $row->pessoa_fisica_dt_nasc),
				'pessoa_fisica_rg' => set_value('pessoa_fisica_rg', $row->pessoa_fisica_rg),
				'pessoa_fisica_rg_orgao' => set_value('pessoa_fisica_rg_orgao', $row->pessoa_fisica_rg_orgao),
				'pessoa_fisica_rg_uf' => set_value('pessoa_fisica_rg_uf', $row->pessoa_fisica_rg_uf),
				'pessoa_fisica_rg_dt' => set_value('pessoa_fisica_rg_dt', $row->pessoa_fisica_rg_dt),
				'pessoa_fisica_passaporte' => set_value('pessoa_fisica_passaporte', $row->pessoa_fisica_passaporte),
				'pessoa_fisica_nm_pai' => set_value('pessoa_fisica_nm_pai', $row->pessoa_fisica_nm_pai),
				'pessoa_fisica_nm_mae' => set_value('pessoa_fisica_nm_mae', $row->pessoa_fisica_nm_mae),
				'pessoa_fisica_grupo_sanguineo' => set_value('pessoa_fisica_grupo_sanguineo', $row->pessoa_fisica_grupo_sanguineo),
				'pessoa_fisica_nacionalidade' => set_value('pessoa_fisica_nacionalidade', $row->pessoa_fisica_nacionalidade),
				'pessoa_fisica_naturalidade' => set_value('pessoa_fisica_naturalidade', $row->pessoa_fisica_naturalidade),
				'pessoa_fisica_naturalidade_uf' => set_value('pessoa_fisica_naturalidade_uf', $row->pessoa_fisica_naturalidade_uf),
				'pessoa_fisica_clt' => set_value('pessoa_fisica_clt', $row->pessoa_fisica_clt),
				'pessoa_fisica_clt_serie' => set_value('pessoa_fisica_clt_serie', $row->pessoa_fisica_clt_serie),
				'pessoa_fisica_clt_uf' => set_value('pessoa_fisica_clt_uf', $row->pessoa_fisica_clt_uf),
				'pessoa_fisica_titulo' => set_value('pessoa_fisica_titulo', $row->pessoa_fisica_titulo),
				'pessoa_fisica_titulo_zona' => set_value('pessoa_fisica_titulo_zona', $row->pessoa_fisica_titulo_zona),
				'pessoa_fisica_titulo_secao' => set_value('pessoa_fisica_titulo_secao', $row->pessoa_fisica_titulo_secao),
				'pessoa_fisica_titulo_cidade' => set_value('pessoa_fisica_titulo_cidade', $row->pessoa_fisica_titulo_cidade),
				'pessoa_fisica_titulo_uf' => set_value('pessoa_fisica_titulo_uf', $row->pessoa_fisica_titulo_uf),
				'pessoa_fisica_cnh' => set_value('pessoa_fisica_cnh', $row->pessoa_fisica_cnh),
				'pessoa_fisica_cnh_categoria' => set_value('pessoa_fisica_cnh_categoria', $row->pessoa_fisica_cnh_categoria),
				'pessoa_fisica_cnh_validade' => set_value('pessoa_fisica_cnh_validade', $row->pessoa_fisica_cnh_validade),
				'pessoa_fisica_reservista' => set_value('pessoa_fisica_reservista', $row->pessoa_fisica_reservista),
				'pessoa_fisica_reservista_ministerio' => set_value('pessoa_fisica_reservista_ministerio', $row->pessoa_fisica_reservista_ministerio),
				'pessoa_fisica_reservista_uf' => set_value('pessoa_fisica_reservista_uf', $row->pessoa_fisica_reservista_uf),
				'pessoa_fisica_pis' => set_value('pessoa_fisica_pis', $row->pessoa_fisica_pis),
				'estado_civil_id' => set_value('estado_civil_id', $row->estado_civil_id),
				'nivel_escolar_id' => set_value('nivel_escolar_id', $row->nivel_escolar_id),
				'pessoa_fisica_funcionario' => set_value('pessoa_fisica_funcionario', $row->pessoa_fisica_funcionario),
				'pessoa_fisica_cnh_lente_corretiva' => set_value('pessoa_fisica_cnh_lente_corretiva', $row->pessoa_fisica_cnh_lente_corretiva),
				'pessoa_fisica_filho' => set_value('pessoa_fisica_filho', $row->pessoa_fisica_filho),
				'pessoa_fisica_filha' => set_value('pessoa_fisica_filha', $row->pessoa_fisica_filha),
				'pessoa_apelido' => set_value('pessoa_apelido', $row->pessoa_apelido),
				'pessoa_fisica_foto' => set_value('pessoa_fisica_foto', $row->pessoa_fisica_foto),
				'pessoa_fisica_st_site' => set_value('pessoa_fisica_st_site', $row->pessoa_fisica_st_site),
				'pessoa_fisica_represen' => set_value('pessoa_fisica_represen', $row->pessoa_fisica_represen),
				'pessoa_fisica_represen_desc' => set_value('pessoa_fisica_represen_desc', $row->pessoa_fisica_represen_desc),
				'pessoa_fisica_ano_ingresso' => set_value('pessoa_fisica_ano_ingresso', $row->pessoa_fisica_ano_ingresso),
				'area_profissional_id' => set_value('area_profissional_id', $row->area_profissional_id),
				'pessoa_fisica_id' => set_value('pessoa_fisica_id', $row->pessoa_fisica_id),
			);
			$this->load->view('pessoa_fisica/Pessoa_fisica_form', $data);
		} else {
			$this->session->set_flashdata('message', 'Registro Não Encontrado');
			redirect(site_url('pessoa_fisica'));
		}
	}

	public function update_action()
	{
		$this->_rules();
		$this->form_validation->set_rules('pessoa_fisica_sexo', 'pessoa_fisica_sexo', 'trim|max_length[1]');
		$this->form_validation->set_rules('pessoa_fisica_cpf', 'pessoa_fisica_cpf', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_dt_nasc', 'pessoa_fisica_dt_nasc', 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_rg', 'pessoa_fisica_rg', 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_rg_orgao', 'pessoa_fisica_rg_orgao', 'trim|max_length[50]');
		$this->form_validation->set_rules('pessoa_fisica_rg_uf', 'pessoa_fisica_rg_uf', 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_rg_dt', 'pessoa_fisica_rg_dt', 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_passaporte', 'pessoa_fisica_passaporte', 'trim|max_length[50]');
		$this->form_validation->set_rules('pessoa_fisica_nm_pai', 'pessoa_fisica_nm_pai', 'trim|max_length[255]');
		$this->form_validation->set_rules('pessoa_fisica_nm_mae', 'pessoa_fisica_nm_mae', 'trim|max_length[255]');
		$this->form_validation->set_rules('pessoa_fisica_grupo_sanguineo', 'pessoa_fisica_grupo_sanguineo', 'trim|max_length[3]');
		$this->form_validation->set_rules('pessoa_fisica_nacionalidade', 'pessoa_fisica_nacionalidade', 'trim|max_length[50]');
		$this->form_validation->set_rules('pessoa_fisica_naturalidade', 'pessoa_fisica_naturalidade', 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_naturalidade_uf', 'pessoa_fisica_naturalidade_uf', 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_clt', 'pessoa_fisica_clt', 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_clt_serie', 'pessoa_fisica_clt_serie', 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_clt_uf', 'pessoa_fisica_clt_uf', 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_titulo', 'pessoa_fisica_titulo', 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_titulo_zona', 'pessoa_fisica_titulo_zona', 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_titulo_secao', 'pessoa_fisica_titulo_secao', 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_titulo_cidade', 'pessoa_fisica_titulo_cidade', 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_titulo_uf', 'pessoa_fisica_titulo_uf', 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_cnh', 'pessoa_fisica_cnh', 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_cnh_categoria', 'pessoa_fisica_cnh_categoria', 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_cnh_validade', 'pessoa_fisica_cnh_validade', 'trim|max_length[10]');
		$this->form_validation->set_rules('pessoa_fisica_reservista', 'pessoa_fisica_reservista', 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_reservista_ministerio', 'pessoa_fisica_reservista_ministerio', 'trim|max_length[20]');
		$this->form_validation->set_rules('pessoa_fisica_reservista_uf', 'pessoa_fisica_reservista_uf', 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_pis', 'pessoa_fisica_pis', 'trim|max_length[50]');
		$this->form_validation->set_rules('estado_civil_id', 'estado_civil_id', 'trim');
		$this->form_validation->set_rules('nivel_escolar_id', 'nivel_escolar_id', 'trim');
		$this->form_validation->set_rules('pessoa_fisica_funcionario', 'pessoa_fisica_funcionario', 'trim|numeric');
		$this->form_validation->set_rules('pessoa_fisica_cnh_lente_corretiva', 'pessoa_fisica_cnh_lente_corretiva', 'trim|max_length[1]');
		$this->form_validation->set_rules('pessoa_fisica_filho', 'pessoa_fisica_filho', 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_fisica_filha', 'pessoa_fisica_filha', 'trim|max_length[2]');
		$this->form_validation->set_rules('pessoa_apelido', 'pessoa_apelido', 'trim|max_length[70]');
		$this->form_validation->set_rules('pessoa_fisica_foto', 'pessoa_fisica_foto', 'trim|integer');
		$this->form_validation->set_rules('pessoa_fisica_st_site', 'pessoa_fisica_st_site', 'trim|integer');
		$this->form_validation->set_rules('pessoa_fisica_represen', 'pessoa_fisica_represen', 'trim|max_length[100]');
		$this->form_validation->set_rules('pessoa_fisica_represen_desc', 'pessoa_fisica_represen_desc', 'trim|max_length[100]');
		$this->form_validation->set_rules('pessoa_fisica_ano_ingresso', 'pessoa_fisica_ano_ingresso', 'trim|max_length[10]');
		$this->form_validation->set_rules('area_profissional_id', 'area_profissional_id', 'trim|integer');
		$this->form_validation->set_rules('pessoa_fisica_id', 'pessoa_fisica_id', 'trim|required|integer');

		if ($this->form_validation->run() == FALSE) {
			#echo validation_errors();
			$this->update($this->input->post('pessoa_id', TRUE));
		} else {
			$data = array(
				'pessoa_fisica_sexo' => empty($this->input->post('pessoa_fisica_sexo', TRUE)) ? NULL : $this->input->post('pessoa_fisica_sexo', TRUE),
				'pessoa_fisica_cpf' => empty($this->input->post('pessoa_fisica_cpf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_cpf', TRUE),
				'pessoa_fisica_dt_nasc' => empty($this->input->post('pessoa_fisica_dt_nasc', TRUE)) ? NULL : $this->input->post('pessoa_fisica_dt_nasc', TRUE),
				'pessoa_fisica_rg' => empty($this->input->post('pessoa_fisica_rg', TRUE)) ? NULL : $this->input->post('pessoa_fisica_rg', TRUE),
				'pessoa_fisica_rg_orgao' => empty($this->input->post('pessoa_fisica_rg_orgao', TRUE)) ? NULL : $this->input->post('pessoa_fisica_rg_orgao', TRUE),
				'pessoa_fisica_rg_uf' => empty($this->input->post('pessoa_fisica_rg_uf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_rg_uf', TRUE),
				'pessoa_fisica_rg_dt' => empty($this->input->post('pessoa_fisica_rg_dt', TRUE)) ? NULL : $this->input->post('pessoa_fisica_rg_dt', TRUE),
				'pessoa_fisica_passaporte' => empty($this->input->post('pessoa_fisica_passaporte', TRUE)) ? NULL : $this->input->post('pessoa_fisica_passaporte', TRUE),
				'pessoa_fisica_nm_pai' => empty($this->input->post('pessoa_fisica_nm_pai', TRUE)) ? NULL : $this->input->post('pessoa_fisica_nm_pai', TRUE),
				'pessoa_fisica_nm_mae' => empty($this->input->post('pessoa_fisica_nm_mae', TRUE)) ? NULL : $this->input->post('pessoa_fisica_nm_mae', TRUE),
				'pessoa_fisica_grupo_sanguineo' => empty($this->input->post('pessoa_fisica_grupo_sanguineo', TRUE)) ? NULL : $this->input->post('pessoa_fisica_grupo_sanguineo', TRUE),
				'pessoa_fisica_nacionalidade' => empty($this->input->post('pessoa_fisica_nacionalidade', TRUE)) ? NULL : $this->input->post('pessoa_fisica_nacionalidade', TRUE),
				'pessoa_fisica_naturalidade' => empty($this->input->post('pessoa_fisica_naturalidade', TRUE)) ? NULL : $this->input->post('pessoa_fisica_naturalidade', TRUE),
				'pessoa_fisica_naturalidade_uf' => empty($this->input->post('pessoa_fisica_naturalidade_uf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_naturalidade_uf', TRUE),
				'pessoa_fisica_clt' => empty($this->input->post('pessoa_fisica_clt', TRUE)) ? NULL : $this->input->post('pessoa_fisica_clt', TRUE),
				'pessoa_fisica_clt_serie' => empty($this->input->post('pessoa_fisica_clt_serie', TRUE)) ? NULL : $this->input->post('pessoa_fisica_clt_serie', TRUE),
				'pessoa_fisica_clt_uf' => empty($this->input->post('pessoa_fisica_clt_uf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_clt_uf', TRUE),
				'pessoa_fisica_titulo' => empty($this->input->post('pessoa_fisica_titulo', TRUE)) ? NULL : $this->input->post('pessoa_fisica_titulo', TRUE),
				'pessoa_fisica_titulo_zona' => empty($this->input->post('pessoa_fisica_titulo_zona', TRUE)) ? NULL : $this->input->post('pessoa_fisica_titulo_zona', TRUE),
				'pessoa_fisica_titulo_secao' => empty($this->input->post('pessoa_fisica_titulo_secao', TRUE)) ? NULL : $this->input->post('pessoa_fisica_titulo_secao', TRUE),
				'pessoa_fisica_titulo_cidade' => empty($this->input->post('pessoa_fisica_titulo_cidade', TRUE)) ? NULL : $this->input->post('pessoa_fisica_titulo_cidade', TRUE),
				'pessoa_fisica_titulo_uf' => empty($this->input->post('pessoa_fisica_titulo_uf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_titulo_uf', TRUE),
				'pessoa_fisica_cnh' => empty($this->input->post('pessoa_fisica_cnh', TRUE)) ? NULL : $this->input->post('pessoa_fisica_cnh', TRUE),
				'pessoa_fisica_cnh_categoria' => empty($this->input->post('pessoa_fisica_cnh_categoria', TRUE)) ? NULL : $this->input->post('pessoa_fisica_cnh_categoria', TRUE),
				'pessoa_fisica_cnh_validade' => empty($this->input->post('pessoa_fisica_cnh_validade', TRUE)) ? NULL : $this->input->post('pessoa_fisica_cnh_validade', TRUE),
				'pessoa_fisica_reservista' => empty($this->input->post('pessoa_fisica_reservista', TRUE)) ? NULL : $this->input->post('pessoa_fisica_reservista', TRUE),
				'pessoa_fisica_reservista_ministerio' => empty($this->input->post('pessoa_fisica_reservista_ministerio', TRUE)) ? NULL : $this->input->post('pessoa_fisica_reservista_ministerio', TRUE),
				'pessoa_fisica_reservista_uf' => empty($this->input->post('pessoa_fisica_reservista_uf', TRUE)) ? NULL : $this->input->post('pessoa_fisica_reservista_uf', TRUE),
				'pessoa_fisica_pis' => empty($this->input->post('pessoa_fisica_pis', TRUE)) ? NULL : $this->input->post('pessoa_fisica_pis', TRUE),
				'estado_civil_id' => empty($this->input->post('estado_civil_id', TRUE)) ? NULL : $this->input->post('estado_civil_id', TRUE),
				'nivel_escolar_id' => empty($this->input->post('nivel_escolar_id', TRUE)) ? NULL : $this->input->post('nivel_escolar_id', TRUE),
				'pessoa_fisica_funcionario' => empty($this->input->post('pessoa_fisica_funcionario', TRUE)) ? NULL : $this->input->post('pessoa_fisica_funcionario', TRUE),
				'pessoa_fisica_cnh_lente_corretiva' => empty($this->input->post('pessoa_fisica_cnh_lente_corretiva', TRUE)) ? NULL : $this->input->post('pessoa_fisica_cnh_lente_corretiva', TRUE),
				'pessoa_fisica_filho' => empty($this->input->post('pessoa_fisica_filho', TRUE)) ? NULL : $this->input->post('pessoa_fisica_filho', TRUE),
				'pessoa_fisica_filha' => empty($this->input->post('pessoa_fisica_filha', TRUE)) ? NULL : $this->input->post('pessoa_fisica_filha', TRUE),
				'pessoa_apelido' => empty($this->input->post('pessoa_apelido', TRUE)) ? NULL : $this->input->post('pessoa_apelido', TRUE),
				'pessoa_fisica_foto' => empty($this->input->post('pessoa_fisica_foto', TRUE)) ? NULL : $this->input->post('pessoa_fisica_foto', TRUE),
				'pessoa_fisica_st_site' => empty($this->input->post('pessoa_fisica_st_site', TRUE)) ? NULL : $this->input->post('pessoa_fisica_st_site', TRUE),
				'pessoa_fisica_represen' => empty($this->input->post('pessoa_fisica_represen', TRUE)) ? NULL : $this->input->post('pessoa_fisica_represen', TRUE),
				'pessoa_fisica_represen_desc' => empty($this->input->post('pessoa_fisica_represen_desc', TRUE)) ? NULL : $this->input->post('pessoa_fisica_represen_desc', TRUE),
				'pessoa_fisica_ano_ingresso' => empty($this->input->post('pessoa_fisica_ano_ingresso', TRUE)) ? NULL : $this->input->post('pessoa_fisica_ano_ingresso', TRUE),
				'area_profissional_id' => empty($this->input->post('area_profissional_id', TRUE)) ? NULL : $this->input->post('area_profissional_id', TRUE),
				'pessoa_fisica_id' => empty($this->input->post('pessoa_fisica_id', TRUE)) ? NULL : $this->input->post('pessoa_fisica_id', TRUE),
			);

			$this->Pessoa_fisica_model->update($this->input->post('pessoa_id', TRUE), $data);
			$this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
			redirect(site_url('pessoa_fisica'));
		}
	}

	public function delete($id)
	{
		$row = $this->Pessoa_fisica_model->get_by_id($id);

		if ($row) {
			if (@$this->Pessoa_fisica_model->delete($id) == 'erro_dependencia') {
				$this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
				redirect(site_url('pessoa_fisica'));
			}


			$this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
			redirect(site_url('pessoa_fisica'));
		} else {
			$this->session->set_flashdata('message', 'Registro Não Encontrado');
			redirect(site_url('pessoa_fisica'));
		}
	}

	public function _rules()
	{
		$this->form_validation->set_rules('pessoa_fisica_sexo', 'pessoa fisica sexo', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_cpf', 'pessoa fisica cpf', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_dt_nasc', 'pessoa fisica dt nasc', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_rg', 'pessoa fisica rg', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_rg_orgao', 'pessoa fisica rg orgao', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_rg_uf', 'pessoa fisica rg uf', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_rg_dt', 'pessoa fisica rg dt', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_passaporte', 'pessoa fisica passaporte', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_nm_pai', 'pessoa fisica nm pai', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_nm_mae', 'pessoa fisica nm mae', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_grupo_sanguineo', 'pessoa fisica grupo sanguineo', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_nacionalidade', 'pessoa fisica nacionalidade', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_naturalidade', 'pessoa fisica naturalidade', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_naturalidade_uf', 'pessoa fisica naturalidade uf', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_clt', 'pessoa fisica clt', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_clt_serie', 'pessoa fisica clt serie', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_clt_uf', 'pessoa fisica clt uf', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_titulo', 'pessoa fisica titulo', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_titulo_zona', 'pessoa fisica titulo zona', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_titulo_secao', 'pessoa fisica titulo secao', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_titulo_cidade', 'pessoa fisica titulo cidade', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_titulo_uf', 'pessoa fisica titulo uf', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_cnh', 'pessoa fisica cnh', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_cnh_categoria', 'pessoa fisica cnh categoria', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_cnh_validade', 'pessoa fisica cnh validade', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_reservista', 'pessoa fisica reservista', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_reservista_ministerio', 'pessoa fisica reservista ministerio', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_reservista_uf', 'pessoa fisica reservista uf', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_pis', 'pessoa fisica pis', 'trim|required');
		$this->form_validation->set_rules('estado_civil_id', 'estado civil id', 'trim|required');
		$this->form_validation->set_rules('nivel_escolar_id', 'nivel escolar id', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_funcionario', 'pessoa fisica funcionario', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_cnh_lente_corretiva', 'pessoa fisica cnh lente corretiva', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_filho', 'pessoa fisica filho', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_filha', 'pessoa fisica filha', 'trim|required');
		$this->form_validation->set_rules('pessoa_apelido', 'pessoa apelido', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_foto', 'pessoa fisica foto', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_st_site', 'pessoa fisica st site', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_represen', 'pessoa fisica represen', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_represen_desc', 'pessoa fisica represen desc', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_ano_ingresso', 'pessoa fisica ano ingresso', 'trim|required');
		$this->form_validation->set_rules('area_profissional_id', 'area profissional id', 'trim|required');
		$this->form_validation->set_rules('pessoa_fisica_id', 'pessoa fisica id', 'trim|required');

		$this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}
	public function open_pdf()
	{

		$param = array(

			array('pessoa_fisica_sexo', '=', $this->input->post('pessoa_fisica_sexo', TRUE)),
			array('pessoa_fisica_cpf', '=', $this->input->post('pessoa_fisica_cpf', TRUE)),
			array('pessoa_fisica_dt_nasc', '=', $this->input->post('pessoa_fisica_dt_nasc', TRUE)),
			array('pessoa_fisica_rg', '=', $this->input->post('pessoa_fisica_rg', TRUE)),
			array('pessoa_fisica_rg_orgao', '=', $this->input->post('pessoa_fisica_rg_orgao', TRUE)),
			array('pessoa_fisica_rg_uf', '=', $this->input->post('pessoa_fisica_rg_uf', TRUE)),
			array('pessoa_fisica_rg_dt', '=', $this->input->post('pessoa_fisica_rg_dt', TRUE)),
			array('pessoa_fisica_passaporte', '=', $this->input->post('pessoa_fisica_passaporte', TRUE)),
			array('pessoa_fisica_nm_pai', '=', $this->input->post('pessoa_fisica_nm_pai', TRUE)),
			array('pessoa_fisica_nm_mae', '=', $this->input->post('pessoa_fisica_nm_mae', TRUE)),
			array('pessoa_fisica_grupo_sanguineo', '=', $this->input->post('pessoa_fisica_grupo_sanguineo', TRUE)),
			array('pessoa_fisica_nacionalidade', '=', $this->input->post('pessoa_fisica_nacionalidade', TRUE)),
			array('pessoa_fisica_naturalidade', '=', $this->input->post('pessoa_fisica_naturalidade', TRUE)),
			array('pessoa_fisica_naturalidade_uf', '=', $this->input->post('pessoa_fisica_naturalidade_uf', TRUE)),
			array('pessoa_fisica_clt', '=', $this->input->post('pessoa_fisica_clt', TRUE)),
			array('pessoa_fisica_clt_serie', '=', $this->input->post('pessoa_fisica_clt_serie', TRUE)),
			array('pessoa_fisica_clt_uf', '=', $this->input->post('pessoa_fisica_clt_uf', TRUE)),
			array('pessoa_fisica_titulo', '=', $this->input->post('pessoa_fisica_titulo', TRUE)),
			array('pessoa_fisica_titulo_zona', '=', $this->input->post('pessoa_fisica_titulo_zona', TRUE)),
			array('pessoa_fisica_titulo_secao', '=', $this->input->post('pessoa_fisica_titulo_secao', TRUE)),
			array('pessoa_fisica_titulo_cidade', '=', $this->input->post('pessoa_fisica_titulo_cidade', TRUE)),
			array('pessoa_fisica_titulo_uf', '=', $this->input->post('pessoa_fisica_titulo_uf', TRUE)),
			array('pessoa_fisica_cnh', '=', $this->input->post('pessoa_fisica_cnh', TRUE)),
			array('pessoa_fisica_cnh_categoria', '=', $this->input->post('pessoa_fisica_cnh_categoria', TRUE)),
			array('pessoa_fisica_cnh_validade', '=', $this->input->post('pessoa_fisica_cnh_validade', TRUE)),
			array('pessoa_fisica_reservista', '=', $this->input->post('pessoa_fisica_reservista', TRUE)),
			array('pessoa_fisica_reservista_ministerio', '=', $this->input->post('pessoa_fisica_reservista_ministerio', TRUE)),
			array('pessoa_fisica_reservista_uf', '=', $this->input->post('pessoa_fisica_reservista_uf', TRUE)),
			array('pessoa_fisica_pis', '=', $this->input->post('pessoa_fisica_pis', TRUE)),
			array('estado_civil_id', '=', $this->input->post('estado_civil_id', TRUE)),
			array('nivel_escolar_id', '=', $this->input->post('nivel_escolar_id', TRUE)),
			array('pessoa_fisica_funcionario', '=', $this->input->post('pessoa_fisica_funcionario', TRUE)),
			array('pessoa_fisica_cnh_lente_corretiva', '=', $this->input->post('pessoa_fisica_cnh_lente_corretiva', TRUE)),
			array('pessoa_fisica_filho', '=', $this->input->post('pessoa_fisica_filho', TRUE)),
			array('pessoa_fisica_filha', '=', $this->input->post('pessoa_fisica_filha', TRUE)),
			array('pessoa_apelido', '=', $this->input->post('pessoa_apelido', TRUE)),
			array('pessoa_fisica_foto', '=', $this->input->post('pessoa_fisica_foto', TRUE)),
			array('pessoa_fisica_st_site', '=', $this->input->post('pessoa_fisica_st_site', TRUE)),
			array('pessoa_fisica_represen', '=', $this->input->post('pessoa_fisica_represen', TRUE)),
			array('pessoa_fisica_represen_desc', '=', $this->input->post('pessoa_fisica_represen_desc', TRUE)),
			array('pessoa_fisica_ano_ingresso', '=', $this->input->post('pessoa_fisica_ano_ingresso', TRUE)),
			array('area_profissional_id', '=', $this->input->post('area_profissional_id', TRUE)),
			array('pessoa_fisica_id', '=', $this->input->post('pessoa_fisica_id', TRUE)),
		); //end array dos parametros

		$data = array(
			'pessoa_fisica_data' => $this->Pessoa_fisica_model->get_all_data($param),
			'start' => 0
		);
		//limite de memoria do pdf atual
		ini_set('memory_limit', '64M');


		$html =  $this->load->view('pessoa_fisica/Pessoa_fisica_pdf', $data, true);


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
			'button'        => 'Gerar',
			'controller'    => 'report',
			'action'        => site_url('pessoa_fisica/open_pdf'),
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


		$this->load->view('pessoa_fisica/Pessoa_fisica_report', $data);
	}
}

/* End of file Pessoa_fisica.php */
/* Local: ./application/controllers/Pessoa_fisica.php */
/* Gerado por RGenerator - 2022-06-29 19:52:39 */