<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produto_preco_cotacao extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Produto_preco_cotacao_model');
        $this->load->model('Pessoa_model');

        $this->load->model('Cotacao_model');

        $this->load->model('Produto_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'produto_preco_cotacao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'produto_preco_cotacao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'produto_preco_cotacao/';
            $config['first_url'] = base_url() . 'produto_preco_cotacao/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Produto_preco_cotacao_model->total_rows($q);
        $produto_preco_cotacao = $this->Produto_preco_cotacao_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if ($format == 'json') {
            echo json($produto_preco_cotacao);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'produto_preco_cotacao_data' => json($produto_preco_cotacao),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('produto_preco_cotacao/Produto_preco_cotacao_list', forFrontVue($data));
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Produto_preco_cotacao_model->get_by_id($id);
        $pessoa = $this->Pessoa_model->get_all_combobox();
        $cotacao = $this->Cotacao_model->get_all_combobox();
        $produto = $this->Produto_model->get_all_combobox();
        if ($row) {
            $data = array(
                'pessoa' => json($pessoa),    'cotacao' => json($cotacao),    'produto' => json($produto),
                'button' => '',
                'controller' => 'read',
                'action' => site_url('produto_preco_cotacao/create_action'),
                'produto_preco_cotacao_id' => $row->produto_preco_cotacao_id,
                'entidade_pessoa_id' => $row->entidade_pessoa_id,
                'cotacao_id' => $row->cotacao_id,
                'produto_id' => $row->produto_id,
                'valor' => $row->valor,
                'produto_preco_dt' => $row->produto_preco_dt,
            );
            $this->load->view('produto_preco_cotacao/Produto_preco_cotacao_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produto_preco_cotacao'));
        }
    }

    public function create()
    {
        $pessoa = $this->Pessoa_model->get_all_combobox();
        $cotacao = $this->Cotacao_model->get_all_combobox();
        $produto = $this->Produto_model->get_all_combobox();
        $data = array(
            'pessoa' => json($pessoa),    'cotacao' => json($cotacao),    'produto' => json($produto),
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('produto_preco_cotacao/create_action'),
            'produto_preco_cotacao_id' => set_value('produto_preco_cotacao_id'),
            'entidade_pessoa_id' => set_value('entidade_pessoa_id'),
            'cotacao_id' => set_value('cotacao_id'),
            'produto_id' => set_value('produto_id'),
            'valor' => set_value('valor'),
            'produto_preco_dt' => set_value('produto_preco_dt'),
        );
        $this->load->view('produto_preco_cotacao/Produto_preco_cotacao_form', forFrontVue($data));
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('entidade_pessoa_id', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('cotacao_id', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('produto_id', NULL, 'trim|required|integer');
        $this->form_validation->set_rules('valor', NULL, 'trim|required|decimal');
        $this->form_validation->set_rules('produto_preco_dt', NULL, 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'entidade_pessoa_id' =>      empty($this->input->post('entidade_pessoa_id', TRUE)) ? NULL : $this->input->post('entidade_pessoa_id', TRUE),
                'cotacao_id' =>      empty($this->input->post('cotacao_id', TRUE)) ? NULL : $this->input->post('cotacao_id', TRUE),
                'produto_id' =>      empty($this->input->post('produto_id', TRUE)) ? NULL : $this->input->post('produto_id', TRUE),
                'valor' =>      empty($this->input->post('valor', TRUE)) ? NULL : $this->input->post('valor', TRUE),
                'produto_preco_dt' =>      empty($this->input->post('produto_preco_dt', TRUE)) ? NULL : $this->input->post('produto_preco_dt', TRUE),
            );

            $this->Produto_preco_cotacao_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('produto_preco_cotacao'));
        }
    }

    public function update($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Produto_preco_cotacao_model->get_by_id($id);
        $pessoa = $this->Pessoa_model->get_all_combobox();
        $cotacao = $this->Cotacao_model->get_all_combobox();
        $produto = $this->Produto_model->get_all_combobox();
        if ($row) {
            $data = array(
                'pessoa' => json($pessoa), 'cotacao' => json($cotacao), 'produto' => json($produto),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('produto_preco_cotacao/update_action'),
                'produto_preco_cotacao_id' => set_value('produto_preco_cotacao_id', $row->produto_preco_cotacao_id),
                'entidade_pessoa_id' => set_value('entidade_pessoa_id', $row->entidade_pessoa_id),
                'cotacao_id' => set_value('cotacao_id', $row->cotacao_id),
                'produto_id' => set_value('produto_id', $row->produto_id),
                'valor' => set_value('valor', $row->valor),
                'produto_preco_dt' => set_value('produto_preco_dt', $row->produto_preco_dt),
            );
            $this->load->view('produto_preco_cotacao/Produto_preco_cotacao_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('produto_preco_cotacao'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('entidade_pessoa_id', 'entidade_pessoa_id', 'trim|required|integer');
        $this->form_validation->set_rules('cotacao_id', 'cotacao_id', 'trim|required|integer');
        $this->form_validation->set_rules('produto_id', 'produto_id', 'trim|required|integer');
        $this->form_validation->set_rules('valor', 'valor', 'trim|required|decimal');
        $this->form_validation->set_rules('produto_preco_dt', 'produto_preco_dt', 'trim');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('produto_preco_cotacao_id', TRUE));
        } else {
            $data = array(
                'entidade_pessoa_id' => empty($this->input->post('entidade_pessoa_id', TRUE)) ? NULL : $this->input->post('entidade_pessoa_id', TRUE),
                'cotacao_id' => empty($this->input->post('cotacao_id', TRUE)) ? NULL : $this->input->post('cotacao_id', TRUE),
                'produto_id' => empty($this->input->post('produto_id', TRUE)) ? NULL : $this->input->post('produto_id', TRUE),
                'valor' => empty($this->input->post('valor', TRUE)) ? NULL : $this->input->post('valor', TRUE),
                'produto_preco_dt' => empty($this->input->post('produto_preco_dt', TRUE)) ? NULL : $this->input->post('produto_preco_dt', TRUE),
            );

            $this->Produto_preco_cotacao_model->update($this->input->post('produto_preco_cotacao_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('produto_preco_cotacao'));
        }
    }

    /*
    public function delete($id)
    {
        $row = $this->Produto_preco_cotacao_model->get_by_id($id);

        if ($row) {
            if (@$this->Produto_preco_cotacao_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('produto_preco_cotacao'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('produto_preco_cotacao'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('produto_preco_cotacao'));
        }
    }
        */

    public function _rules()
    {
        $this->form_validation->set_rules('entidade_pessoa_id', 'entidade pessoa id', 'trim|required');
        $this->form_validation->set_rules('cotacao_id', 'cotacao id', 'trim|required');
        $this->form_validation->set_rules('produto_id', 'produto id', 'trim|required');
        $this->form_validation->set_rules('valor', 'valor', 'trim|required');
        $this->form_validation->set_rules('produto_preco_dt', 'produto preco dt', 'trim|required');

        $this->form_validation->set_rules('produto_preco_cotacao_id', 'produto_preco_cotacao_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {

        $param = array(

            array('entidade_pessoa_id', '=', $this->input->post('entidade_pessoa_id', TRUE)),
            array('cotacao_id', '=', $this->input->post('cotacao_id', TRUE)),
            array('produto_id', '=', $this->input->post('produto_id', TRUE)),
            array('valor', '=', $this->input->post('valor', TRUE)),
            array('produto_preco_dt', '=', $this->input->post('produto_preco_dt', TRUE)),
        ); //end array dos parametros

        $data = array(
            'produto_preco_cotacao_data' => $this->Produto_preco_cotacao_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('produto_preco_cotacao/Produto_preco_cotacao_pdf', $data, true);


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
            'action'        => site_url('produto_preco_cotacao/open_pdf'),
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


        $this->load->view('produto_preco_cotacao/Produto_preco_cotacao_report', forFrontVue($data));
    }
}

/* End of file Produto_preco_cotacao.php */
/* Local: ./application/controllers/Produto_preco_cotacao.php */
/* Gerado por RGenerator - 2022-09-06 10:24:42 */