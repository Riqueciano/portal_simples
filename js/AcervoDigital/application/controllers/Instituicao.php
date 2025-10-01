<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Instituicao extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Instituicao_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'instituicao/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'instituicao/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'instituicao/';
            $config['first_url'] = base_url() . 'instituicao/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Instituicao_model->total_rows($q);
        $instituicao = $this->Instituicao_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'instituicao_data' => $instituicao,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('instituicao/Instituicao_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Instituicao_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('instituicao/create_action'),
	    'instituicao_id' => $row->instituicao_id   ,
	    'instituicao_nm' => $row->instituicao_nm   ,
	    'instituicao_sigla' => $row->instituicao_sigla   ,
	    'instituicao_endereco' => $row->instituicao_endereco   ,
	    'instituicao_endereco_cep' => $row->instituicao_endereco_cep   ,
	    'municipio_id' => $row->municipio_id   ,
	    );
            $this->load->view('instituicao/Instituicao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('instituicao'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('instituicao/create_action'),
	    'instituicao_id' => set_value('instituicao_id'),
	    'instituicao_nm' => set_value('instituicao_nm'),
	    'instituicao_sigla' => set_value('instituicao_sigla'),
	    'instituicao_endereco' => set_value('instituicao_endereco'),
	    'instituicao_endereco_cep' => set_value('instituicao_endereco_cep'),
	    'municipio_id' => set_value('municipio_id'),
	);
        $this->load->view('instituicao/Instituicao_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('instituicao_nm', NULL,'trim|required|max_length[200]');
		$this->form_validation->set_rules('instituicao_sigla', NULL,'trim|max_length[20]');
		$this->form_validation->set_rules('instituicao_endereco', NULL,'trim|required|max_length[500]');
		$this->form_validation->set_rules('instituicao_endereco_cep', NULL,'trim|max_length[20]');
		$this->form_validation->set_rules('municipio_id', NULL,'trim|required|integer');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
		'instituicao_nm' => 	 empty($this->input->post('instituicao_nm',TRUE))? NULL : $this->input->post('instituicao_nm',TRUE),
		'instituicao_sigla' => 	 empty($this->input->post('instituicao_sigla',TRUE))? NULL : $this->input->post('instituicao_sigla',TRUE),
		'instituicao_endereco' => 	 empty($this->input->post('instituicao_endereco',TRUE))? NULL : $this->input->post('instituicao_endereco',TRUE),
		'instituicao_endereco_cep' => 	 empty($this->input->post('instituicao_endereco_cep',TRUE))? NULL : $this->input->post('instituicao_endereco_cep',TRUE),
		'municipio_id' => 	 empty($this->input->post('municipio_id',TRUE))? NULL : $this->input->post('municipio_id',TRUE),
	    );

            $this->Instituicao_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('instituicao'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Instituicao_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('instituicao/update_action'),
		'instituicao_id' => set_value('instituicao_id', $row->instituicao_id),
		'instituicao_nm' => set_value('instituicao_nm', $row->instituicao_nm),
		'instituicao_sigla' => set_value('instituicao_sigla', $row->instituicao_sigla),
		'instituicao_endereco' => set_value('instituicao_endereco', $row->instituicao_endereco),
		'instituicao_endereco_cep' => set_value('instituicao_endereco_cep', $row->instituicao_endereco_cep),
		'municipio_id' => set_value('municipio_id', $row->municipio_id),
	    );
            $this->load->view('instituicao/Instituicao_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('instituicao'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('instituicao_nm','instituicao_nm','trim|required|max_length[200]');
		$this->form_validation->set_rules('instituicao_sigla','instituicao_sigla','trim|max_length[20]');
		$this->form_validation->set_rules('instituicao_endereco','instituicao_endereco','trim|required|max_length[500]');
		$this->form_validation->set_rules('instituicao_endereco_cep','instituicao_endereco_cep','trim|max_length[20]');
		$this->form_validation->set_rules('municipio_id','municipio_id','trim|required|integer');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('instituicao_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
		'instituicao_nm' => empty($this->input->post('instituicao_nm',TRUE))? NULL : $this->input->post('instituicao_nm',TRUE), 
		'instituicao_sigla' => empty($this->input->post('instituicao_sigla',TRUE))? NULL : $this->input->post('instituicao_sigla',TRUE), 
		'instituicao_endereco' => empty($this->input->post('instituicao_endereco',TRUE))? NULL : $this->input->post('instituicao_endereco',TRUE), 
		'instituicao_endereco_cep' => empty($this->input->post('instituicao_endereco_cep',TRUE))? NULL : $this->input->post('instituicao_endereco_cep',TRUE), 
		'municipio_id' => empty($this->input->post('municipio_id',TRUE))? NULL : $this->input->post('municipio_id',TRUE), 
	    );

            $this->Instituicao_model->update($this->input->post('instituicao_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('instituicao'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Instituicao_model->get_by_id($id);

        if ($row) {
            if(@$this->Instituicao_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('instituicao'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('instituicao'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('instituicao'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('instituicao_nm', 'instituicao nm', 'trim|required');
	$this->form_validation->set_rules('instituicao_sigla', 'instituicao sigla', 'trim|required');
	$this->form_validation->set_rules('instituicao_endereco', 'instituicao endereco', 'trim|required');
	$this->form_validation->set_rules('instituicao_endereco_cep', 'instituicao endereco cep', 'trim|required');
	$this->form_validation->set_rules('municipio_id', 'municipio id', 'trim|required');

	$this->form_validation->set_rules('instituicao_id', 'instituicao_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('instituicao_nm', '=' , $this->input->post('instituicao_nm',TRUE)),
		 array('instituicao_sigla', '=' , $this->input->post('instituicao_sigla',TRUE)),
		 array('instituicao_endereco', '=' , $this->input->post('instituicao_endereco',TRUE)),
		 array('instituicao_endereco_cep', '=' , $this->input->post('instituicao_endereco_cep',TRUE)),
		 array('municipio_id', '=' , $this->input->post('municipio_id',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'instituicao_data' => $this->Instituicao_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('instituicao/Instituicao_pdf', $data, true);
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
                 ",'O',true);
        

                $pdf->WriteHTML(utf8_encode($html));    
                $pdf->SetFooter("{DATE j/m/Y H:i}|{PAGENO}/{nb}|" . utf8_encode('Nome do Sistema') . "|");
                
                $pdf->Output('recurso.recurso.pdf', 'I');

          } 
        
public function report() {
        
            $data = array(
                'button'        => 'Gerar',
                'controller'    => 'report',
                'action'        => site_url('instituicao/open_pdf'),
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
               
           
            $this->load->view('instituicao/Instituicao_report', $data);
        
    }
         

}

/* End of file Instituicao.php */
/* Local: ./application/controllers/Instituicao.php */
/* Gerado por RGenerator - 2018-03-27 16:27:07 */