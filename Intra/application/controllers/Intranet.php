<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Intranet extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Publicacao_model');
        $this->load->model('Pessoa_model');
        $this->load->library('form_validation');
    }


    public function ajax_consulta_publicacoes()
    {

        // $format = urldecode($this->input->get('format', TRUE));
        $limit = intval($this->input->get('limit'));
        $flag_carrossel = intval($this->input->get('flag_carrossel'));
        $param = "flag_carrossel = $flag_carrossel";
        $publicacao = $this->Publicacao_model->get_all_data_param($param, null, $limit);

        // echo $this->db->last_query();exit;
        echo json($publicacao);
    }


    public function ajax_buscar_colaboradores()
    {
        $buscador = urldecode($this->input->get('buscador', TRUE));
        $pessoa = $this->Pessoa_model->get_colaboradores($buscador);


        echo json($pessoa);
    }


    public function noticia($publicacao_id)
    {
        $publicacao = $this->Publicacao_model->get_by_id($publicacao_id);

        // $publicacao->publicacao_corpo = nl2br(htmlspecialchars($publicacao->publicacao_corpo ));
        $data = array(
            'publicacao' => json($publicacao),


        );
        // echo 1;exit;
        $this->load->view('intranet/noticia_view', ($data));
    }
    public function aniversariantes()
    {


        // $aniversariante_mes = $this->Pessoa_model->get_aniversariantes_mes((int)date('d'), (int)date('m'));
        $aniversariantes_hoje = $this->Pessoa_model->get_aniversariantes_hoje();

        $aniversariante_mes = $this->Pessoa_model->get_aniversariantes_mes_lista((int)date('d'), (int)date('m'));


        $data = array(
            'publicacao' => '',
            'aniversariante_mes' => json($aniversariante_mes),
            'aniversariantes_hoje' => json($aniversariantes_hoje),
            'mes_nm' => MES[(int)date('m')],
            'mes_ini' => (int)date('m'),
            'mes_fim' => (int)date('m'),

        );
        // echo 1;exit;
        $this->load->view('intranet/aniversariantes_view', ($data));
    }
    public function aniversariantes_todos()
    {

        $months = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];

        // $aniversariante_mes = $this->Pessoa_model->get_aniversariantes_mes((int)date('d'), (int)date('m'));
        $aniversariante_mes = $this->Pessoa_model->get_aniversariantes_mes_lista(null, 1, 12);
        $aniversariantes_hoje = array();
        $data = array(
            'publicacao' => '',
            'aniversariantes_hoje' => json($aniversariantes_hoje),
            'aniversariante_mes' => json($aniversariante_mes),
            'mes_nm' => $months[(int)date('m')],
            'mes_ini' => 1,
            'mes_fim' => 12,

        );
        // echo 1;exit;
        $this->load->view('intranet/aniversariantes_view', ($data));
    }



    public function cotacao_cadastro()
    {

     
        $data = array(
            'publicacao' => '',  

        );
        // echo 1;exit;
        $this->load->view('intranet/cotacao_cadastro_view', ($data));
    }
    public function mudas_sementes_cadastro()
    {


        $data = array(
            'publicacao' => '',

        );
        // echo 1;exit;
        $this->load->view('intranet/mudas_sementes_cadastro', ($data));
    }


    public function todas_noticias()
    {
        $param = "flag_carrossel = 0 and ativo =1";
        $noticias = $this->Publicacao_model->get_all_data_param($param, 'publicacao_dt_publicacao desc', 100);


        $data = array(
            'noticias' => json($noticias),

        );
        // echo 1;exit;
        $this->load->view('intranet/noticias_todas_view', ($data));
    }

    public function index()
    {

        $param = "flag_carrossel = 1 and ativo=1 ";
        $carrossel = $this->Publicacao_model->get_all_data_param($param, 'publicacao_dt_publicacao desc', 4);
        // echo "<br><br><br><br><br><br><br><br><br><br>";
        // echo_pre($this->db->last_query());
        // $param = "flag_carrossel = 0";
        // $noticias = array();//;$this->Publicacao_model->get_all_data_param($param, 'publicacao_dt_publicacao desc', 10);
        $param = "flag_carrossel = 0 and ativo=1 ";
        $noticias_top = $this->Publicacao_model->get_all_data_param($param, 'publicacao_dt_publicacao desc', 5);
        // echo_pre($this->db->last_query());


        //aniversariantes
        $aniversariante_mes = array(); //$this->Pessoa_model->get_aniversariantes_mes((int)date('d'), (int)date('m'));
        $aniversariante_mes_menor =  array(); //$this->Pessoa_model->get_aniversariantes_mes((int)date('d'), (int)date('m'), 10);


        $aniversariantes_hoje = $this->Pessoa_model->get_aniversariantes_hoje();

        $data = array(
            'carrossel' => json($carrossel),
            'noticias' => json(array()),
            'noticias_top' => json($noticias_top),
            'aniversariante_mes' => json($aniversariante_mes),
            'aniversariante_mes_menor' => json($aniversariante_mes_menor),
            'aniversariantes_hoje' => json($aniversariantes_hoje),
            'mes_nm' => MES[(int)date('m')],


        );
        // echo 1;exit;
        $this->load->view('intranet/intranet_view', ($data));
    }
}
