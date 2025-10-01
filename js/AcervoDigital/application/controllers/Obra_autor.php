<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Obra_autor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Obra_autor_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'obra_autor/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'obra_autor/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'obra_autor/';
            $config['first_url'] = base_url() . 'obra_autor/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Obra_autor_model->total_rows($q);
        $obra_autor = $this->Obra_autor_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'obra_autor_data' => $obra_autor,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('obra_autor/Obra_autor_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Obra_autor_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('obra_autor/create_action'),
	    'obra_autor_id' => $row->obra_autor_id   ,
	    'obra_id' => $row->obra_id   ,
	    'autor_pessoa_id' => $row->autor_pessoa_id   ,
	    'flag_aprovado' => $row->flag_aprovado   ,
	    );
            $this->load->view('obra_autor/Obra_autor_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('obra_autor'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('obra_autor/create_action'),
	    'obra_autor_id' => set_value('obra_autor_id'),
	    'obra_id' => set_value('obra_id'),
	    'autor_pessoa_id' => set_value('autor_pessoa_id'),
	    'flag_aprovado' => set_value('flag_aprovado'),
	);
        $this->load->view('obra_autor/Obra_autor_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('obra_id', NULL,'trim|required|integer');
		$this->form_validation->set_rules('autor_pessoa_id', NULL,'trim|required|integer');
		$this->form_validation->set_rules('flag_aprovado', NULL,'trim|integer');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
		'obra_id' => 	 empty($this->input->post('obra_id',TRUE))? NULL : $this->input->post('obra_id',TRUE),
		'autor_pessoa_id' => 	 empty($this->input->post('autor_pessoa_id',TRUE))? NULL : $this->input->post('autor_pessoa_id',TRUE),
		'flag_aprovado' => 	 empty($this->input->post('flag_aprovado',TRUE))? NULL : $this->input->post('flag_aprovado',TRUE),
	    );

            $this->Obra_autor_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('obra_autor'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Obra_autor_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('obra_autor/update_action'),
		'obra_autor_id' => set_value('obra_autor_id', $row->obra_autor_id),
		'obra_id' => set_value('obra_id', $row->obra_id),
		'autor_pessoa_id' => set_value('autor_pessoa_id', $row->autor_pessoa_id),
		'flag_aprovado' => set_value('flag_aprovado', $row->flag_aprovado),
	    );
            $this->load->view('obra_autor/Obra_autor_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('obra_autor'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('obra_id','obra_id','trim|required|integer');
		$this->form_validation->set_rules('autor_pessoa_id','autor_pessoa_id','trim|required|integer');
		$this->form_validation->set_rules('flag_aprovado','flag_aprovado','trim|integer');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('obra_autor_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
		'obra_id' => empty($this->input->post('obra_id',TRUE))? NULL : $this->input->post('obra_id',TRUE), 
		'autor_pessoa_id' => empty($this->input->post('autor_pessoa_id',TRUE))? NULL : $this->input->post('autor_pessoa_id',TRUE), 
		'flag_aprovado' => empty($this->input->post('flag_aprovado',TRUE))? NULL : $this->input->post('flag_aprovado',TRUE), 
	    );

            $this->Obra_autor_model->update($this->input->post('obra_autor_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('obra_autor'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Obra_autor_model->get_by_id($id);

        if ($row) {
            if(@$this->Obra_autor_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('obra_autor'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('obra_autor'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('obra_autor'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('obra_id', 'obra id', 'trim|required');
	$this->form_validation->set_rules('autor_pessoa_id', 'autor pessoa id', 'trim|required');
	$this->form_validation->set_rules('flag_aprovado', 'flag aprovado', 'trim|required');

	$this->form_validation->set_rules('obra_autor_id', 'obra_autor_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('obra_id', '=' , $this->input->post('obra_id',TRUE)),
		 array('autor_pessoa_id', '=' , $this->input->post('autor_pessoa_id',TRUE)),
		 array('flag_aprovado', '=' , $this->input->post('flag_aprovado',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'obra_autor_data' => $this->Obra_autor_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('obra_autor/Obra_autor_pdf', $data, true);
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
                'action'        => site_url('obra_autor/open_pdf'),
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
               
           
            $this->load->view('obra_autor/Obra_autor_report', $data);
        
    }
         

}

/* End of file Obra_autor.php */
/* Local: ./application/controllers/Obra_autor.php */
/* Gerado por RGenerator - 2018-03-27 17:01:47 */