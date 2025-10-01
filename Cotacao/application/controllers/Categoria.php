<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categoria extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Categoria_model');
        $this->load->model('Produto_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url']  = base_url() . 'categoria/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'categoria/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'categoria/';
            $config['first_url'] = base_url() . 'categoria/';
        }

        $config['per_page'] = null;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Categoria_model->total_rows($q);
        $categoria = $this->Categoria_model->get_limit_data($config['per_page'], $start, $q);

        foreach ($categoria as $key => $c) {
            $c->produtos = $this->Produto_model->get_all_data_param("categoria.categoria_id = $c->categoria_id",'produto_nm');
        }

        ## para retorno json no front
        if ($format == 'json') {
            echo json($categoria);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);


        $data = array(
            'categoria_data' => json($categoria),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('categoria/Categoria_list', forFrontVue($data));
    }

    public function read($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Categoria_model->get_by_id($id);
        if ($row) {
            $data = array(

                'button' => '',
                'controller' => 'read',
                'action' => site_url('categoria/create_action'),
                'categoria_id' => $row->categoria_id,
                'categoria_nm' => $row->categoria_nm,
            );
            $this->load->view('categoria/Categoria_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('categoria'));
        }
    }

    public function create()
    {
        $data = array(

            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('categoria/create_action'),
            'categoria_id' => set_value('categoria_id'),
            'categoria_nm' => set_value('categoria_nm'),
        );
        $this->load->view('categoria/Categoria_form', forFrontVue($data));
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('categoria_nm', NULL, 'trim|required|max_length[200]');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'categoria_nm' =>      empty($this->input->post('categoria_nm', TRUE)) ? NULL : $this->input->post('categoria_nm', TRUE),
            );

            $this->Categoria_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('categoria'));
        }
    }

    public function update($id)
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Categoria_model->get_by_id($id);
        // echo $this->db->last_query();
        // var_dump($row);exit;
        if ($row) {
            $data = array(

                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('categoria/update_action'),
                'categoria_id' => set_value('categoria_id', $row->categoria_id),
                'categoria_nm' => set_value('categoria_nm', $row->categoria_nm),
            );
            $this->load->view('categoria/Categoria_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('categoria'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('categoria_nm', 'categoria_nm', 'trim|required|max_length[200]');

        if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('categoria_id', TRUE));
        } else {
            $data = array(
                'categoria_nm' => empty($this->input->post('categoria_nm', TRUE)) ? NULL : $this->input->post('categoria_nm', TRUE),
            );

            $this->Categoria_model->update($this->input->post('categoria_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('categoria'));
        }
    }

    public function delete($id)
    {
        $row = $this->Categoria_model->get_by_id($id);

        if ($row) {
            if (@$this->Categoria_model->delete($id) == 'erro_dependencia') {
                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
                redirect(site_url('categoria'));
            }


            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('categoria'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('categoria'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('categoria_nm', 'categoria nm', 'trim|required');

        $this->form_validation->set_rules('categoria_id', 'categoria_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function open_pdf()
    {

        $param = array(

            array('categoria_nm', '=', $this->input->post('categoria_nm', TRUE)),
        ); //end array dos parametros

        $data = array(
            'categoria_data' => $this->Categoria_model->get_all_data($param),
            'start' => 0
        );
        //limite de memoria do pdf atual
        ini_set('memory_limit', '64M');


        $html =  $this->load->view('categoria/Categoria_pdf', $data, true);


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
            'action'        => site_url('categoria/open_pdf'),
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


        $this->load->view('categoria/Categoria_report', forFrontVue($data));
    }
}

/* End of file Categoria.php */
/* Local: ./application/controllers/Categoria.php */
/* Gerado por RGenerator - 2022-09-20 20:43:37 */