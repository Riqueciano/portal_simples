<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cotacao extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Cotacao_model');
        $this->load->model('Pessoa_model');
        $this->load->model('Produto_model');
        $this->load->model('Produto_preco_model');
        $this->load->model('Produto_preco_cotacao_model');
        $this->load->model('Produto_preco_territorio_model');
        $this->load->model('Territorio_model');
        $this->load->model('Municipio_model');
        // $this->load->model('QRCode');
        $this->load->model('Categoria_model');
        $this->load->model('Inscricao_fornecedor_model');
        $this->load->model('Fornecedor_categoria_model');
        $this->load->model('Comprador_categoria_model');
        $this->load->library('form_validation');
    }



    private function cria_produto_nm_completo_by_list($produto)
    {

        foreach ($produto as $key => $p) {
            if ($p->produto_qtd == 1) {
                $p->produto_nm_completo = $p->produto_nm . " - " . rlower(removePlural($p->unidade_medida_nm)) . "";
            } else {
                $p->produto_nm_completo = $p->produto_nm . " - " . (int)$p->produto_qtd . " " . rlower($p->unidade_medida_nm) . "";
            }
        }

        return $produto;
    }
    public function index()
    {
        ##################################################################################################



        ##################################################################################################

        // echo phpinfo(); exit;
        // echo $_SESSION['perfil'];
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));
        $fornecedor_pessoa_id = intval($this->input->get('fornecedor_pessoa_id'));

        $produto_id = intval($this->input->get('produto_id'));
        $cotacao_ds = urldecode($this->input->get('cotacao_ds', TRUE));
        $data_inicio = urldecode($this->input->get('data_inicio', TRUE));
        $data_fim = urldecode($this->input->get('data_fim', TRUE));
        $comparacao = urldecode($this->input->get('comparacao', TRUE));
        $valor = (float)($this->input->get('valor', TRUE));
        $solicitado_para_pessoa_id = intval($this->input->get('solicitado_para_pessoa_id'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'cotacao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'cotacao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'cotacao/';
            $config['first_url'] = base_url() . 'cotacao/';
        }

        $config['per_page'] = 10000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Cotacao_model->total_rows($q);
        $param_pessoa_id = $_SESSION['pessoa_id'];
        if ($_SESSION['perfil'] == 'Gestor' or $_SESSION['perfil'] == 'Administrador') {
            $param_pessoa_id = NULL;
        }

        $where_comp = "";
        if (!empty($fornecedor_pessoa_id)) {
            $where_comp .= " and cotacao.cotacao_id in (select cotacao_id from cotacao.produto_preco_cotacao where entidade_pessoa_id = $fornecedor_pessoa_id ) ";
        }

        if (!empty($produto_id)) {
            $where_comp .= " and cotacao.cotacao_id in (select cotacao_id from cotacao.produto_preco_cotacao where produto_id = $produto_id ) ";
        }

        if (!empty($cotacao_ds)) {
            $where_comp .= " and cotacao.cotacao_ds like '%$cotacao_ds%' ";
        }

        if (!empty($data_inicio)) {
            $where_comp .= " and cotacao.cotacao_dt >= '$data_inicio' ";
        }

        if (!empty($data_fim)) {
            $where_comp .= " and cotacao.cotacao_dt <= '$data_fim' ";
        }
        if (!empty($solicitado_para_pessoa_id)) {
            $where_comp .= " and cotacao.solicitado_para_pessoa_id = $solicitado_para_pessoa_id ";
        }




        // $fornecedor_id
        $cotacao = $this->Cotacao_model->get_limit_data($config['per_page'], $start, null, $param_pessoa_id, $where_comp);

        // echo 1;exit;
        $fornecedor_pessoa_id_in = "(0";
        $cotacao_id_in = "(0";
        $solicitado_para_pessoa_id_in = "(0";

        foreach ($cotacao as $key => $c) {
            $cotacao_id_in .= "," . $c->cotacao_id;

            if (!empty($c->solicitado_para_pessoa_id)) {
                $solicitado_para_pessoa_id_in .= "," . $c->solicitado_para_pessoa_id;
            }

            $param = array(array('cotacao.cotacao_id', '=', $c->cotacao_id));
            $c->precos = $this->Produto_preco_cotacao_model->get_all_precos($param);

            $c->indicadores = $this->Produto_preco_cotacao_model->get_indicadores($param);
            foreach ($c->precos as $key => $p) {
                $fornecedor_pessoa_id_in .= "," . $p->pessoa_id;
            }
        }


        $fornecedor_pessoa_id_in .= ")";
        $cotacao_id_in .= ")";
        $solicitado_para_pessoa_id_in .= ")";

        $produtos_cotados = $this->Produto_model->get_produtos_cotacoes($cotacao_id_in);


        // echo $fornecedor_pessoa_id_in ;
        $fornecedores = $this->Pessoa_model->get_all_data_param("pessoa.pessoa_id in $fornecedor_pessoa_id_in  ", "remove_acentuacao(trim(upper(pessoa.pessoa_nm))) asc");
        // LAST_QUERY(false);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($cotacao);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);


        $solicitado_para  = array();
        //apenas nutricionistas podem solicitar para outra pessoa
        if ($_SESSION['perfil'] == 'Nutricionista') {
            $solicitado_para = $this->Pessoa_model->get_solicitado_para($solicitado_para_pessoa_id_in);
        }

        $data = array(
            'cotacao_data' => json($cotacao),
            'fornecedores' => json($fornecedores),
            'produtos_cotados' => json($produtos_cotados),
            'solicitado_para' => json($solicitado_para),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('cotacao/Cotacao_list', forFrontVue($data));
    }






    public function calcula_indicadores($territorio_id = null)
    {

        PROTECAO_PERFIL(['Administrador', 'Gestor']);

        $format = $this->input->get('format', TRUE);
        $territorio_id = $this->input->get('territorio_id', TRUE);


        $fornecedores_cadastrados = count($this->Cotacao_model->get_fornecedores($territorio_id, ""));

        $fornecedores_cadastrados_pf_total = count($this->Cotacao_model->get_fornecedores($territorio_id, " and if1.inscricao_fornecedor_tipo='PF'"));

        $param = " and p.pessoa_id IN (select pp2.pessoa_id from cotacao.produto_preco pp2 where pp2.ativo=1)";
        $fornecedores_cadastrados_pf_com_preco = count($this->Cotacao_model->get_fornecedores($territorio_id, " and if1.inscricao_fornecedor_tipo='PF' " . $param));
        $param = " and p.pessoa_id NOT IN (select pp2.pessoa_id from cotacao.produto_preco pp2 where pp2.ativo=1)";
        $fornecedores_cadastrados_pf_sem_preco = count($this->Cotacao_model->get_fornecedores($territorio_id, " and if1.inscricao_fornecedor_tipo='PF' " . $param));




        $fornecedores_cadastrados_pj_total = count($this->Cotacao_model->get_fornecedores($territorio_id, " and if1.inscricao_fornecedor_tipo='PJ'"));
        $param = " and p.pessoa_id IN (select pp2.pessoa_id from cotacao.produto_preco pp2 where pp2.ativo=1)";
        $fornecedores_cadastrados_pj_com_preco = count($this->Cotacao_model->get_fornecedores($territorio_id, " and if1.inscricao_fornecedor_tipo='PJ' " . $param));
        $param = " and p.pessoa_id NOT IN (select pp2.pessoa_id from cotacao.produto_preco pp2 where pp2.ativo=1)";
        $fornecedores_cadastrados_pj_sem_preco = count($this->Cotacao_model->get_fornecedores($territorio_id, " and if1.inscricao_fornecedor_tipo='PJ' " . $param));


        if (!empty($territorio_id)) {
            $param = " produto_id in (select pp.produto_id from cotacao.produto_preco pp 
                                            inner join cotacao.produto_preco_territorio ppt
                                                    on ppt.produto_preco_id = pp.produto_preco_id
                                                    where pp.ativo = 1 and ppt.territorio_id = $territorio_id
                                                    and ppt.produto_preco_territorio_ativo =1 and ppt.produto_preco_territorio_valor > 0)";
        } else {
            $param = "";
        }
        $produtos_qtd =  count($this->Produto_model->get_all($param));
        //echo $this->db->last_query();exit;

        if (!empty($territorio_id)) {
            $param = " and pp.produto_preco_id in (select ppt.produto_preco_id from cotacao.produto_preco_territorio ppt where ppt.produto_preco_territorio_ativo = 1 and ppt.produto_preco_territorio_valor > 0)";
        } else {
            $param = "";
        }
        $precos_qtd = count($this->Produto_preco_model->get_produto_preco_por_pessoa_territorio(null, $territorio_id, $param));
        if (!empty($territorio_id)) {
            $param = " and pp.produto_preco_id in (select ppt.produto_preco_id from cotacao.produto_preco_territorio ppt where ppt.produto_preco_territorio_ativo = 0 and ppt.produto_preco_territorio_valor > 0)";
        } else {
            $param = "";
        }
        $precos_qtd_inativos = count($this->Produto_preco_model->get_produto_preco_por_pessoa_territorio(null, $territorio_id, $param));



        $fornecedor_categoria = $this->Fornecedor_categoria_model->get_all();
        $param_terr = "";
        foreach ($fornecedor_categoria as $key => $fc) {
            $param_terr = empty($territorio_id) ? "" : " and pessoa.cotacao_territorio_id = $territorio_id";
            $fc->fornecedores = $this->Pessoa_model->get_all_data_param("pessoa.fornecedor_categoria_id = $fc->fornecedor_categoria_id" . $param_terr);
        }

        $comprador_categoria = $this->Comprador_categoria_model->get_all();
        $param_terr = "";
        foreach ($comprador_categoria as $key => $cc) {
            $param_terr = empty($territorio_id) ? "" : " and pessoa.cotacao_territorio_id = $territorio_id";
            $cc->compradores = $this->Pessoa_model->get_all_data_param("pessoa.comprador_categoria_id = $cc->comprador_categoria_id" . $param_terr);
        }


        $array = array(
            'fornecedores_cadastrados' => $fornecedores_cadastrados,
            'fornecedores_cadastrados_pf_total' => $fornecedores_cadastrados_pf_total,
            'fornecedores_cadastrados_pf_com_preco' => $fornecedores_cadastrados_pf_com_preco,
            'fornecedores_cadastrados_pf_sem_preco' => $fornecedores_cadastrados_pf_sem_preco,
            'fornecedores_cadastrados_pj_total' => $fornecedores_cadastrados_pj_total,
            'fornecedores_cadastrados_pj_com_preco' => $fornecedores_cadastrados_pj_com_preco,
            'fornecedores_cadastrados_pj_sem_preco' => $fornecedores_cadastrados_pj_sem_preco,
            'produtos_qtd' => $produtos_qtd,
            'precos_qtd' => $precos_qtd,
            'precos_qtd_inativos' => $precos_qtd_inativos,
            'territorio' => $territorio_id,
            'fornecedor_categoria' => $fornecedor_categoria,
            'comprador_categoria' => $comprador_categoria,
        );

        if ($format == 'json') {
            echo json($array);
            exit;
        } else {
            return (object)$array;
        }
    }


    public function indicadores()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);

        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));





        if ($q <> '') {
            $config['base_url']  = base_url() . 'cotacao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'cotacao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'cotacao/';
            $config['first_url'] = base_url() . 'cotacao/';
        }

        $config['per_page'] = 10000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Cotacao_model->total_rows($q);
        $param_pessoa_id = $_SESSION['pessoa_id'];
        if ($_SESSION['perfil'] == 'Gestor' or $_SESSION['perfil'] == 'Administrador') {
            $param_pessoa_id = NULL;
        }

        $cotacao_qtd_total = count($this->Cotacao_model->get_all());


        $usuarios_cotacao = $this->Pessoa_model->get_usuarios_cotacao();


        $cotacao = $this->Cotacao_model->get_limit_data($config['per_page'], $start, $q, $param_pessoa_id);

        foreach ($cotacao as $key => $c) {
            $param = array(array('cotacao.cotacao_id', '=', $c->cotacao_id));
            $c->precos = $this->Produto_preco_cotacao_model->get_indicadores($param);
        }

        ## para retorno json no front
        if ($format == 'json') {
            echo json($cotacao);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);





        $param = "produto.produto_id in (
                        select pp.produto_id from cotacao.produto_preco_territorio ppt
                            inner join cotacao.produto_preco pp
                                on ppt.produto_preco_id = pp.produto_preco_id
                                    where  ppt.produto_preco_territorio_dt_cadastro::date BETWEEN (CURRENT_DATE::date - " . DIAS_VALIDADE_PRECO . ") and CURRENT_DATE::date  
                                    and ppt.produto_preco_territorio_ativo = 1 
                                    and ppt.produto_preco_territorio_valor > 0 
                                    and pp.ativo = 1 
                         )   ";


        //  echo_pre($param);
        $produtos = $this->Produto_model->get_all();
        foreach ($produtos as $key => $p) {
            $p->qtd_cotacoes = count($this->Produto_preco_cotacao_model->get_produto_media(" and p.produto_id =  $p->produto_id"));
        }
        $produtos = ordenarPorColuna($produtos, 'qtd_cotacoes');

        $categorias = $this->Categoria_model->get_all_qtd_cotacoes();
        foreach ($categorias as $key => $c) {
            $c->qtd_cotacoes = count($this->Produto_preco_cotacao_model->get_produto_media(" and p.categoria_id =  $c->categoria_id"));
        }

        $fornecedores = $this->Pessoa_model->get_fonecedores();
        foreach ($fornecedores as $key => $f) {
            $f->lista_produtos = $this->Produto_preco_territorio_model->get_produtos_preco($f->pessoa_id);

            foreach ($f->lista_produtos as $key => $lp) {
                $timestampDataFornecida = $lp->produto_preco_dt;
                // Converter a data fornecida para um objeto DateTime
                $dataFornecidaObj = new DateTime($timestampDataFornecida);

                // Criar um objeto DateTime para a data e hora atuais
                $dataAtualObj = new DateTime();

                // Calcular a data de validade adicionando 30 dias (30 dias * 24 horas * 60 minutos * 60 segundos)
                $dataValidade = clone $dataAtualObj;
                $dataValidade->modify('+' . DIAS_VALIDADE_PRECO . ' days');

                // Verificar se a data fornecida está dentro do intervalo de validade
                if ($dataFornecidaObj <= $dataValidade && $dataFornecidaObj >= $dataAtualObj) {
                    // echo "A data está dentro do prazo de 30 dias.";
                    $lp->flag_preco_dentro_do_prazo = 1;
                } else {
                    // echo "A data não está dentro do prazo de 30 dias.";
                    $lp->flag_preco_dentro_do_prazo = 0;
                }
            }
        }

        // echo_pre($this->db->last_query());


        //calcula os totais de indicadores solicitados por sandra 21/07/2025
        $totais = $this->calcula_indicadores();


        $territorio = $this->Territorio_model->get_all_data_param("territorio_uf = 'BA'", "territorio_nm asc");

        $data = array(
            'totais' => json($totais),

            'cotacao_data' => json($cotacao),
            'territorio' => json($territorio),
            'produtos' => json($produtos),
            'categorias' => json($categorias),
            'usuarios_cotacao' => json($usuarios_cotacao),
            'fornecedores' => json($fornecedores),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'cotacao_qtd_total' => $cotacao_qtd_total,
        );
        $this->load->view('cotacao/Cotacao_indicadores', forFrontVue($data));
    }
    public function totalizadores()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);


        //calcula os totais de indicadores solicitados por sandra 21/07/2025
        $totais = $this->calcula_indicadores();


        $territorio = $this->Territorio_model->get_all_data_param("territorio_uf = 'BA'", "territorio_nm asc");

        $data = array(
            'totais' => json($totais),

            'territorio' => json($territorio),

        );
        $this->load->view('cotacao/Cotacao_indicadores_totalizadores', forFrontVue($data));
    }


    public function indicadores_media()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);

        $format = $this->input->get('format', TRUE);
        $territorio_id = (int)$this->input->get('parametro_territorio_id', TRUE);



        $territorio = $this->Territorio_model->get_all("territorio_uf = 'BA' ", "territorio_nm asc");

        if (!empty($territorio_id)) {
            $produtos = $this->Produto_model->get_all_com_media_bahia($territorio_id);
        } else {
            $produtos = array();
        }

        foreach ($produtos as $key => $p) {
            $p->fornecedores_preco = $this->Produto_model->get_all_com_media_bahia_valores_por_produto($p->produto_id, $territorio_id);
        }



        if ($format == 'json') {
            echo json($produtos);
            exit;
        }



        $data = array(
            'produtos' => json(array()),
            'territorio' => json($territorio),

        );
        $this->load->view('cotacao/Cotacao_indicadores_media', forFrontVue($data));
    }



    public function create_action()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);
        $this->_rules();
        $this->form_validation->set_rules('cotacao_dt', NULL, 'trim');
        $this->form_validation->set_rules('cotacao_ds', NULL, 'trim|max_length[800]');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'cotacao_pessoa_id' =>      $_SESSION['pessoa_id'],
                'cotacao_ds' =>      empty($this->input->post('cotacao_ds', TRUE)) ? NULL : $this->input->post('cotacao_ds', TRUE),
                'solicitado_para_pessoa_id' =>      empty($this->input->post('solicitado_para_pessoa_id', TRUE)) ? NULL : $this->input->post('solicitado_para_pessoa_id', TRUE),
            );

            $this->Cotacao_model->insert($data);
            $cotacao_id = $this->db->insert_id();
            foreach ($this->input->post('produto_preco_id[]', TRUE) as $key => $produto_preco_id) {
                $produto_preco = $this->Produto_preco_model->get_by_id($produto_preco_id);
                $data = array(
                    'cotacao_id' => $cotacao_id,
                    'entidade_pessoa_id' => $produto_preco->pessoa_id,
                    'produto_id' => $this->input->post("produto_id[$key]", TRUE),
                    'valor' => $this->input->post("valor[$key]", TRUE),
                    'produto_preco_dt' => $this->input->post("produto_preco_dt[$key]", TRUE),
                );

                $this->Produto_preco_cotacao_model->insert($data);
            }

            $num = (int)(date('Y') . $cotacao_id);

            $data = array(
                'cotacao_numero' => $num
            );
            $this->Cotacao_model->update($cotacao_id, $data);


            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            //redirect(site_url('cotacao'));

            redirect(site_url('cotacao/read/' . $cotacao_id));
        }
    }



    public function create()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);

        $pessoa_logada = $this->Pessoa_model->get_by_id($_SESSION['pessoa_id']);
        $pessoa = array();

        // $where = "produto.produto_id in (select produto_id from cotacao.produto_preco where ativo =1)";
        // $produto = $this->Produto_model->get_all_combobox($where, "produto_nm asc");
        // $produto = $this->mascara_produto_combo($produto);

        $produto = array();
        $territorio = $this->Territorio_model->get_all_combobox(null, "territorio_nm asc");
        //exit;

        //echo $pessoa_logada->cotacao_territorio_id;exit;
        $fornecedor_territorio = $this->Territorio_model->get_by_id((int)$pessoa_logada->cotacao_territorio_id);

        // $mun = $this->Municipio_model->get_by_id($pessoa_logada->cotacao_municipio_id);

        // $municipio = $this->Municipio_model->get_all_combobox("ativo=1 and estado_uf='BA' and territorio_id = $mun->territorio_id",'municipio_nm');
        // $municipio = $this->Municipio_model->get_all_combobox("ativo=1 and estado_uf='BA'", 'municipio_nm');
        $municipio = array();


        $solicitado_para  = array();
        //apenas nutricionistas podem solicitar para outra pessoa
        if ($_SESSION['perfil'] == 'Nutricionista') {
            $solicitado_para = $this->Pessoa_model->get_solicitado_para();
        }

        $solicitado_para_territorio = $this->Territorio_model->get_all_data_param("territorio_uf='BA'", "territorio_nm asc");


        $data = array(
            'municipio' => json($municipio),
            'pessoa' => json($pessoa),
            'produto' => json($produto),
            'territorio' => json($territorio),
            'solicitado_para_territorio' => json($solicitado_para_territorio),
            'solicitado_para' => json($solicitado_para),
            'cotacao_territorio_id' => $pessoa_logada->cotacao_territorio_id,
            'fornecedor_territorio_nm' => $fornecedor_territorio->territorio_nm,
            'fornecedor_territorio_id' => $fornecedor_territorio->territorio_id,
            'button' => 'Salvar',
            'controller' => 'create',
            'produto_preco_cotacao' => json(array()),
            'action' => site_url('cotacao/create_action'),
            'cotacao_id' => set_value('cotacao_id'),
            'cotacao_pessoa_id' => $_SESSION['pessoa_id'],
            'pessoa_nm' => $pessoa_logada->pessoa_nm,
            'cotacao_dt' => set_value('cotacao_dt'),
            'cotacao_ds' => set_value('cotacao_ds'),
            'solicitado_para_pessoa_id' => set_value('solicitado_para_pessoa_id'),
            'flag_autorizado' => 0,
        );
        $this->load->view('cotacao/Cotacao_form', forFrontVue($data));
    }


    private function mascara_produto_combo($produto)
    {

        foreach ($produto as $key => $p) {
            if ($p->produto_qtd == 1) {
                $p->text = $p->produto_nm . ' - ' . rlower(removePlural($p->unidade_medida_nm)) . '';
            } else {
                $p->text = $p->produto_nm . ' - ' . $p->produto_qtd . ' ' . rlower($p->unidade_medida_nm) . '';
            }
        }

        return $produto;
    }


    public function update($id)
    {
        exit;
        $this->session->set_flashdata('message', '');
        $row = $this->Cotacao_model->get_by_id($id);
        $pessoa_cotacao = $this->Pessoa_model->get_by_id($row->cotacao_pessoa_id);
        $pessoa = array();

        $where = "produto.produto_id in (select produto_id from cotacao.produto_preco where ativo =1)";
        $produto = $this->Produto_model->get_all_combobox($where, "produto_nm asc");
        $produto = $this->mascara_produto_combo($produto);

        $param = array(
            array('cotacao.cotacao_id', '=', $id)
        );
        $produto_preco_cotacao = $this->Produto_preco_cotacao_model->get_all_data($param);

        $territorio = $this->Territorio_model->get_all_combobox(null, "territorio_nm asc");
        if ($row) {
            $data = array(
                'pessoa' => json($pessoa),
                'produto' => json($produto),
                'territorio' => json($territorio),
                'produto_preco_cotacao' => json($produto_preco_cotacao),
                'button' => 'Atualizar',
                'controller' => 'update',
                'pessoa_nm' => $pessoa_cotacao->pessoa_nm,
                'temp_territorio_id' => $pessoa_cotacao->cotacao_territorio_id,
                'action' => site_url('cotacao/update_action'),
                'cotacao_id' => set_value('cotacao_id', $row->cotacao_id),
                'cotacao_pessoa_id' => set_value('cotacao_pessoa_id', $row->cotacao_pessoa_id),
                'cotacao_dt' => set_value('cotacao_dt', $row->cotacao_dt),
                'cotacao_ds' => set_value('cotacao_ds', $row->cotacao_ds),
                'solicitado_para_pessoa_id' => set_value('solicitado_para_pessoa_id', $row->solicitado_para_pessoa_id),
            );
            $this->load->view('cotacao/Cotacao_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('cotacao'));
        }
    }


    private function verifica_sua_cotacao($pessoa_id, $cotacao_id)
    {
        $cotacao = $this->Cotacao_model->get_by_id($cotacao_id);
        if ($_SESSION['perfil'] != 'Gestor' and $_SESSION['perfil'] != 'Administrador') {
            if ($cotacao->cotacao_pessoa_id != $pessoa_id) {
                echo "Está cotação não é sua!";
                exit;
            }
        }
    }


    public function read($id)
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);
        $this->verifica_sua_cotacao($_SESSION['pessoa_id'], $id);

        $this->session->set_flashdata('message', '');
        $row = $this->Cotacao_model->get_by_id($id);
        $pessoa_cotacao = $this->Pessoa_model->get_by_id($row->cotacao_pessoa_id);
        $pessoa = array();

        $where = "produto.produto_id in (select produto_id from cotacao.produto_preco where ativo =1)";
        $produto = $this->Produto_model->get_all_combobox($where, "produto_nm asc");

        $param = array(
            array('cotacao.cotacao_id', '=', $id)
        );
        $produto_preco_cotacao = $this->Produto_preco_cotacao_model->get_all_data($param);
        // LAST_QUERY(false);
        $produto_preco_cotacao = $this->cria_produto_nm_completo_by_list($produto_preco_cotacao);
        $territorio = $this->Territorio_model->get_all_combobox(null, "territorio_nm asc");

        $pessoa_cotacao = $this->Pessoa_model->get_by_id($row->cotacao_pessoa_id);
        // echo $pessoa_cotacao->cotacao_territorio_id;exit;
        $fornecedor_territorio = $this->Territorio_model->get_by_id((int)$pessoa_cotacao->cotacao_territorio_id);

        $solicitado_para  = array();
        //apenas nutricionistas podem solicitar para outra pessoa
        if ($_SESSION['perfil'] == 'Nutricionista') {
            $solicitado_para = $this->Pessoa_model->get_solicitado_para();
        }

        //   $row->solicitado_para_pessoa_id;exit;
        $solicitado_para_territorio = $this->Territorio_model->get_all_data_param("territorio_uf='BA'", "territorio_nm asc");
        if ($row) {
            $data = array(
                'pessoa' => json($pessoa),
                'produto' => json($produto),
                'solicitado_para_territorio' => json($solicitado_para_territorio),
                'territorio' => json($territorio),
                'solicitado_para' => json($solicitado_para),
                'municipio' => json(array()),
                'produto_preco_cotacao' => json($produto_preco_cotacao),
                'button' => 'Atualizar',
                'controller' => 'read',
                'pessoa_nm' => $pessoa_cotacao->pessoa_nm,
                'fornecedor_territorio_nm' => $fornecedor_territorio->territorio_nm,
                'fornecedor_territorio_id' => $fornecedor_territorio->territorio_id,
                'cotacao_territorio_id' => (int)$pessoa_cotacao->cotacao_territorio_id,
                'action' => site_url('cotacao/update_action'),
                'cotacao_id' => set_value('cotacao_id', $row->cotacao_id),
                'flag_autorizado' => set_value('flag_autorizado', $row->flag_autorizado),
                'cotacao_pessoa_id' => set_value('cotacao_pessoa_id', $row->cotacao_pessoa_id),
                'cotacao_dt' => set_value('cotacao_dt', $row->cotacao_dt),
                'cotacao_ds' => set_value('cotacao_ds', $row->cotacao_ds),
                'solicitado_para_pessoa_id' => set_value('solicitado_para_pessoa_id', $row->solicitado_para_pessoa_id),
            );
            $this->load->view('cotacao/Cotacao_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('cotacao'));
        }
    }
    public function cotacao_validador($id)
    {

        //PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor','Comprador']);
        $this->session->set_flashdata('message', '');
        $row = $this->Cotacao_model->get_by_id($id);
        $pessoa_cotacao = $this->Pessoa_model->get_by_id($row->cotacao_pessoa_id);
        $pessoa = array();

        $where = "produto.produto_id in (select produto_id from cotacao.produto_preco where ativo =1)";
        $produto = $this->Produto_model->get_all_combobox($where, "produto_nm asc");

        $param = array(
            array('cotacao.cotacao_id', '=', $id)
        );
        $produto_preco_cotacao = $this->Produto_preco_cotacao_model->get_all_data($param);
        $produto_preco_cotacao = $this->cria_produto_nm_completo_by_list($produto_preco_cotacao);
        $territorio = $this->Territorio_model->get_all_combobox(null, "territorio_nm asc");

        $pessoa_cotacao = $this->Pessoa_model->get_by_id($row->cotacao_pessoa_id);
        // echo $pessoa_cotacao->cotacao_territorio_id;exit;
        $fornecedor_territorio = $this->Territorio_model->get_by_id((int)$pessoa_cotacao->cotacao_territorio_id);
        if ($row) {
            $data = array(
                'cotacao' => json($row),
                'pessoa' => json($pessoa),
                'produto' => json($produto),
                'territorio' => json($territorio),
                'municipio' => json(array()),
                'produto_preco_cotacao' => json($produto_preco_cotacao),
                'button' => 'Atualizar',
                'controller' => 'read',
                'pessoa_nm' => $pessoa_cotacao->pessoa_nm,
                'fornecedor_territorio_nm' => $fornecedor_territorio->territorio_nm,
                'fornecedor_territorio_id' => $fornecedor_territorio->territorio_id,
                'cotacao_territorio_id' => (int)$pessoa_cotacao->cotacao_territorio_id,
                'action' => site_url('cotacao/update_action'),
                'cotacao_id' => set_value('cotacao_id', $row->cotacao_id),
                'flag_autorizado' => set_value('flag_autorizado', $row->flag_autorizado),
                'cotacao_pessoa_id' => set_value('cotacao_pessoa_id', $row->cotacao_pessoa_id),
                'cotacao_dt' => set_value('cotacao_dt', $row->cotacao_dt),
                'cotacao_ds' => set_value('cotacao_ds', utf8_decode($row->cotacao_ds)),
                'solicitado_para_pessoa_id' => set_value('solicitado_para_pessoa_id', $row->solicitado_para_pessoa_id),
            );
            $this->load->view('cotacao/Validador_cotacao', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('cotacao'));
        }
    }

    public function update_action()
    {
        exit;
        $this->_rules();
        $this->form_validation->set_rules('cotacao_dt', 'cotacao_dt', 'trim');
        $this->form_validation->set_rules('cotacao_ds', 'cotacao_ds', 'trim|max_length[800]');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('cotacao_id', TRUE));
        } else {
            $data = array(
                'cotacao_pessoa_id' => $_SESSION['pessoa_id'],
                'cotacao_dt' => empty($this->input->post('cotacao_dt', TRUE)) ? NULL : $this->input->post('cotacao_dt', TRUE),
                'cotacao_ds' => empty($this->input->post('cotacao_ds', TRUE)) ? NULL : $this->input->post('cotacao_ds', TRUE),
                'solicitado_para_pessoa_id' => empty($this->input->post('solicitado_para_pessoa_id', TRUE)) ? NULL : $this->input->post('solicitado_para_pessoa_id', TRUE),
            );

            $this->Cotacao_model->update($this->input->post('cotacao_id', TRUE), $data);


            $this->Produto_preco_cotacao_model->delete_por_cotacao($this->input->post('cotacao_id', TRUE));

            foreach ($this->input->post('produto_preco_id[]', TRUE) as $key => $produto_preco_id) {
                $produto_preco = $this->Produto_preco_model->get_by_id($produto_preco_id);

                $data = array(
                    'cotacao_id' => $this->input->post('cotacao_id', TRUE),
                    'entidade_pessoa_id' => $produto_preco->pessoa_id,
                    'produto_id' => $this->input->post("produto_id[$key]", TRUE),
                    'valor' => $this->input->post("valor[$key]", TRUE),
                    'produto_preco_dt' => $this->input->post("produto_preco_dt[$key]", TRUE),
                );

                $this->Produto_preco_cotacao_model->insert($data);
            }
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('cotacao'));
        }
    }

    // public function delete($id)
    // {
    //     PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor','Comprador']);
    //     $row = $this->Cotacao_model->get_by_id($id);

    //     if ($row) {
    //         if (@$this->Cotacao_model->deleteFull($id) == 'erro_dependencia') {
    //             $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
    //             redirect(site_url('cotacao'));
    //         }
    //         $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
    //         redirect(site_url('cotacao'));
    //     } else {
    //         $this->session->set_flashdata('message', 'Registro Não Encontrado');
    //         redirect(site_url('cotacao'));
    //     }
    // }

    public function _rules()
    {
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    public function open_pdf()
    {
        // PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor','Comprador']);
        $input_todo_html = $this->input->get('input_todo_html', TRUE);
        $id = $this->input->get('cotacao_id', TRUE);
        // echo $id;
        //echo $id;exit;
        ini_set('memory_limit', '128M');

        $cotacao = $this->Cotacao_model->get_by_id($id);
        $pessoa_cotacao = $this->Pessoa_model->get_by_id($cotacao->cotacao_pessoa_id);
        // echo $cotacao->cotacao_pessoa_id;exit;
        $pessoa = array();

        $where = "produto.produto_id in (select produto_id from cotacao.produto_preco where ativo =1) ";
        $produto = $this->Produto_model->get_all_combobox($where, "produto_nm asc");

        $param = array(
            array('cotacao.cotacao_id', '=', $id)
        );

        $produto_preco_cotacao = $this->Produto_preco_cotacao_model->get_all_data($param);
        $produto_preco_cotacao = $this->cria_produto_nm_completo_by_list($produto_preco_cotacao);


        $fornecedor_pessoa_id = "(0";
        foreach ($produto_preco_cotacao as $key => $ppc) {
            $fornecedor_pessoa_id .= "," . $ppc->entidade_pessoa_id;
        }
        $fornecedor_pessoa_id .= ")";

        
        $fornecedores_desta_cotacao = $this->Pessoa_model->get_all_fornecedores_param("pessoa.pessoa_id in " . $fornecedor_pessoa_id, "pessoa.pessoa_nm asc");
       //echo_pre($this->db->last_query());


        $territorio = $this->Territorio_model->get_all_combobox(null, "territorio_nm asc");

        $cotacao_media = $this->Produto_preco_cotacao_model->get_produto_media(" and ppc.cotacao_id =  $id");
        $cotacao_media = $this->cria_produto_nm_completo_by_list($cotacao_media);


        $fornecedor_territorio = $this->Territorio_model->get_by_id((int)$pessoa_cotacao->cotacao_territorio_id);

        // $inscricao_fornecedor = $this->Inscricao_fornecedor_model->get_by_pessoa_id($cotacao->cotacao_pessoa_id);
        // var_dump($inscricao_fornecedor);

        $solicitado_para_pessoa = $this->Pessoa_model->get_by_id($cotacao->solicitado_para_pessoa_id);
        // var_dump($solicitado_para_pessoa->pessoa_nm);
        // exit;
        $data = array(
            'fornecedores_desta_cotacao' => ($fornecedores_desta_cotacao),
            'cotacao' => ($cotacao),
            'pessoa' => ($pessoa),
            'produto' => ($produto),
            'cotacao_media' => ($cotacao_media),
            'territorio' => ($territorio),
            'solicitado_para_pessoa' => ($solicitado_para_pessoa),
            'produto_preco_cotacao' => ($produto_preco_cotacao),
            'button' => 'Atualizar',
            'controller' => 'read',
            'pessoa_nm' => $pessoa_cotacao->pessoa_nm,
            'pessoa_fisica_cpf' => $pessoa_cotacao->pessoa_fisica_cpf,
            'pessoa_cnpj' => $pessoa_cotacao->pessoa_cnpj,
            'fornecedor_territorio_nm' => $fornecedor_territorio->territorio_nm,
            // 'inscricao_fornecedor_tipo' => $inscricao_fornecedor->inscricao_fornecedor_tipo,
            'cotacao_territorio_id' => (int)$pessoa_cotacao->cotacao_territorio_id,
            'action' => site_url('cotacao/update_action'),
            'cotacao_id' => set_value('cotacao_id', $cotacao->cotacao_id),
            'cotacao_pessoa_id' => set_value('cotacao_pessoa_id', $cotacao->cotacao_pessoa_id),
            'cotacao_dt' => set_value('cotacao_dt', $cotacao->cotacao_dt),
            'cotacao_ds' => set_value('cotacao_ds', $cotacao->cotacao_ds),
            'solicitado_para_pessoa_id' => set_value('solicitado_para_pessoa_id', $cotacao->solicitado_para_pessoa_id),
        );
        $html =  $this->load->view('cotacao/Cotacao_pdf', $data, true);

        echo $html;
        exit;
        //esta dando erro devido a mudança da versão do php

        //echo $html;exit;
        $formato = $this->input->post('formato', TRUE);
        $nome_arquivo = 'arquivo';
        if (rupper($formato) == 'EXCEL') {
            $pdf = $this->pdf->excel($html, $nome_arquivo);
        }

        $this->load->library('pdf');
        $pdf = $this->pdf->RReport();

        $caminhoImg =  'https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/bg_logo_min.png';

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
        $pdf->SetFooter("{DATE j/m/Y H:i}|{PAGENO}/{nb}|" . utf8_encode(NOME_SISTEMA . ' | SUAF/SDR') . "|");

        $pdf->Output('recurso.recurso.pdf', 'I');
    }


    public function Cotacao_produtos_aptos_cotacao()
    {
        PROTECAO_PERFIL(['Administrador', 'Gestor']);
        $territorio_id = (int)$this->input->get('territorio_id', TRUE);
        
        $format = $this->input->get('format', TRUE);


        $produto = array();
        
        if($format == 'json'){
            $produto = $this->Produto_model->get_all();
            foreach ($produto as $key => $p) {
                $param = "produto_preco.produto_id = " . $p->produto_id . " and produto_preco_territorio.produto_preco_territorio_ativo = 1
                     and produto_preco_territorio.produto_preco_territorio_valor > 0";
    
                $param = empty($territorio_id) ? $param : $param . " and produto_preco_territorio.territorio_id = " . $territorio_id;
    
    
                $p->qtd_precos = count($this->Produto_preco_territorio_model->get_all_data_param($param, ""));
               
            }
            //remove todos q nao tem 3 cotações
            $produto = array_values(array_filter($produto, function($item) {
                return $item->qtd_precos >= 3;
            }));
            echo json($produto);
            exit;
        }

 


        $territorio = $this->Territorio_model->get_all_data_param("territorio_uf = 'BA'", "territorio_nm asc");

        $data = array(
            
            'produto' => json($produto),
            'territorio' => json($territorio),

        );
        $this->load->view('cotacao/Cotacao_produtos_aptos_cotacao', forFrontVue($data));
    }


    // public function report()
    // {

    //     $data = array(
    //         'button'        => 'Gerar',
    //         'controller'    => 'report',
    //         'action'        => site_url('cotacao/open_pdf'),
    //         'recurso_id'    => null,
    //         'recurso_nm'    => null,
    //         'recurso_tombo' => null,
    //         'conservacao_id' => null,
    //         'setaf_id'      => null,
    //         'localizacao'   => null,
    //         'municipio_id'  => null,
    //         'caminho'       => null,
    //         'documento_id'  => null,
    //         'requerente_id' => null,
    //     );


    //     $this->load->view('cotacao/Cotacao_report', forFrontVue($data));
    // }
}

/* End of file Cotacao.php */
/* Local: ./application/controllers/Cotacao.php */
/* Gerado por RGenerator - 2022-09-06 10:24:28 */
