<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pre_autor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pre_autor_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'pre_autor/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'pre_autor/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'pre_autor/';
            $config['first_url'] = base_url() . 'pre_autor/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Pre_autor_model->total_rows($q);
        $pre_autor = $this->Pre_autor_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pre_autor_data' => $pre_autor,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('pre_autor/Pre_autor_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Pre_autor_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('pre_autor/create_action'),
	    'autor_complemento_id' => $row->autor_complemento_id   ,
	    'pre_autor_nm' => $row->pre_autor_nm   ,
	    'cpf' => $row->cpf   ,
	    'email' => $row->email   ,
	    'instituicao' => $row->instituicao   ,
	    'telefone_ddd' => $row->telefone_ddd   ,
	    'telefone' => $row->telefone   ,
	    );
            $this->load->view('pre_autor/Pre_autor_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pre_autor'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('pre_autor/create_action'),
	    'autor_complemento_id' => set_value('autor_complemento_id'),
	    'pre_autor_nm' => set_value('pre_autor_nm'),
	    'cpf' => set_value('cpf'),
	    'email' => set_value('email'),
	    'instituicao' => set_value('instituicao'),
	    'telefone_ddd' => set_value('telefone_ddd'),
	    'telefone' => set_value('telefone'),
	);
        $this->load->view('pre_autor/Pre_autor_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('pre_autor_nm', NULL,'trim|required|max_length[200]');
		$this->form_validation->set_rules('cpf', NULL,'trim|required|max_length[20]');
		$this->form_validation->set_rules('email', NULL,'trim|required|max_length[200]');
		$this->form_validation->set_rules('instituicao', NULL,'trim|required|max_length[200]');
		$this->form_validation->set_rules('telefone_ddd', NULL,'trim|required|max_length[15]');
		$this->form_validation->set_rules('telefone', NULL,'trim|required|max_length[15]');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
		'pre_autor_nm' => 	 empty($this->input->post('pre_autor_nm',TRUE))? NULL : $this->input->post('pre_autor_nm',TRUE),
		'cpf' => 	 empty($this->input->post('cpf',TRUE))? NULL : $this->input->post('cpf',TRUE),
		'email' => 	 empty($this->input->post('email',TRUE))? NULL : $this->input->post('email',TRUE),
		'instituicao' => 	 empty($this->input->post('instituicao',TRUE))? NULL : $this->input->post('instituicao',TRUE),
		'telefone_ddd' => 	 empty($this->input->post('telefone_ddd',TRUE))? NULL : $this->input->post('telefone_ddd',TRUE),
		'telefone' => 	 empty($this->input->post('telefone',TRUE))? NULL : $this->input->post('telefone',TRUE),
	    );

            $this->Pre_autor_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('pre_autor'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Pre_autor_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('pre_autor/update_action'),
		'autor_complemento_id' => set_value('autor_complemento_id', $row->autor_complemento_id),
		'pre_autor_nm' => set_value('pre_autor_nm', $row->pre_autor_nm),
		'cpf' => set_value('cpf', $row->cpf),
		'email' => set_value('email', $row->email),
		'instituicao' => set_value('instituicao', $row->instituicao),
		'telefone_ddd' => set_value('telefone_ddd', $row->telefone_ddd),
		'telefone' => set_value('telefone', $row->telefone),
	    );
            $this->load->view('pre_autor/Pre_autor_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('pre_autor'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('pre_autor_nm','pre_autor_nm','trim|required|max_length[200]');
		$this->form_validation->set_rules('cpf','cpf','trim|required|max_length[20]');
		$this->form_validation->set_rules('email','email','trim|required|max_length[200]');
		$this->form_validation->set_rules('instituicao','instituicao','trim|required|max_length[200]');
		$this->form_validation->set_rules('telefone_ddd','telefone_ddd','trim|required|max_length[15]');
		$this->form_validation->set_rules('telefone','telefone','trim|required|max_length[15]');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('autor_complemento_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
		'pre_autor_nm' => empty($this->input->post('pre_autor_nm',TRUE))? NULL : $this->input->post('pre_autor_nm',TRUE), 
		'cpf' => empty($this->input->post('cpf',TRUE))? NULL : $this->input->post('cpf',TRUE), 
		'email' => empty($this->input->post('email',TRUE))? NULL : $this->input->post('email',TRUE), 
		'instituicao' => empty($this->input->post('instituicao',TRUE))? NULL : $this->input->post('instituicao',TRUE), 
		'telefone_ddd' => empty($this->input->post('telefone_ddd',TRUE))? NULL : $this->input->post('telefone_ddd',TRUE), 
		'telefone' => empty($this->input->post('telefone',TRUE))? NULL : $this->input->post('telefone',TRUE), 
	    );

            $this->Pre_autor_model->update($this->input->post('autor_complemento_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('pre_autor'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Pre_autor_model->get_by_id($id);

        if ($row) {
            if(@$this->Pre_autor_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('pre_autor'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('pre_autor'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('pre_autor'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('pre_autor_nm', 'pre autor nm', 'trim|required');
	$this->form_validation->set_rules('cpf', 'cpf', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('instituicao', 'instituicao', 'trim|required');
	$this->form_validation->set_rules('telefone_ddd', 'telefone ddd', 'trim|required');
	$this->form_validation->set_rules('telefone', 'telefone', 'trim|required');

	$this->form_validation->set_rules('autor_complemento_id', 'autor_complemento_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('pre_autor_nm', '=' , $this->input->post('pre_autor_nm',TRUE)),
		 array('cpf', '=' , $this->input->post('cpf',TRUE)),
		 array('email', '=' , $this->input->post('email',TRUE)),
		 array('instituicao', '=' , $this->input->post('instituicao',TRUE)),
		 array('telefone_ddd', '=' , $this->input->post('telefone_ddd',TRUE)),
		 array('telefone', '=' , $this->input->post('telefone',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'pre_autor_data' => $this->Pre_autor_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('pre_autor/Pre_autor_pdf', $data, true);
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
                'action'        => site_url('pre_autor/open_pdf'),
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
               
           
            $this->load->view('pre_autor/Pre_autor_report', $data);
        
    }
         

}

/* End of file Pre_autor.php */
/* Local: ./application/controllers/Pre_autor.php */
/* Gerado por RGenerator - 2018-04-19 09:34:13 */