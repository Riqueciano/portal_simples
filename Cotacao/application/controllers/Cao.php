<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cao extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Cao_model');   $this->load->library('form_validation');
        exit;
    }
    

    public function index()
    {   
        
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = (int)$this->input->get('start');
        
         

        $config['per_page'] = 30;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Cao_model->total_rows($q);
        $cao = $this->Cao_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if($format == 'json'){
            echo json($cao);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'cao_data' => json($cao),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('cao/Cao_list', forFrontVue($data));
    }

    public function read($id) 
    {   
        $this->session->set_flashdata('message', '');
        $row = $this->Cao_model->get_by_id($id);   if ($row) {
                    $data = array(
                         
                        'button' => '',
                        'controller' => 'read',
                        'action' => site_url('cao/create_action'),
	    'cao_id' => $row->cao_id   ,
	    'cao_nm' => $row->cao_nm   ,
	    'cao' => $row->cao   ,
	    );
            $this->load->view('cao/Cao_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cao'));
        }
    }

    public function create() 
    {    $data = array(
            
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('cao/create_action'),
	    'cao_id' => set_value('cao_id'),
	    'cao_nm' => set_value('cao_nm'),
	    'cao' => set_value('cao'),
	);
        $this->load->view('cao/Cao_form', forFrontVue($data));
    }
    
    public function create_action() 
    {   
        $this->_rules();
		$this->form_validation->set_rules('cao_nm', NULL,'trim|max_length[333]');
		$this->form_validation->set_rules('cao', NULL,'trim');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'cao_nm' => 	 empty($this->input->post('cao_nm',TRUE))? NULL : $this->input->post('cao_nm',TRUE),
		'cao' => 	 empty($this->input->post('cao',TRUE))? NULL : $this->input->post('cao',TRUE),
	    );

            $this->Cao_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('cao'));
        }
    }
    
    public function update($id) 
    {   
        $this->session->set_flashdata('message', '');
        $row = $this->Cao_model->get_by_id($id);
    if ($row) {
            $data = array(
                
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('cao/update_action'),
		'cao_id' => set_value('cao_id', $row->cao_id),
		'cao_nm' => set_value('cao_nm', $row->cao_nm),
		'cao' => set_value('cao', $row->cao),
	    );
            $this->load->view('cao/Cao_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('cao'));
        }
    }
    
    public function update_action() 
    {   
        $this->_rules();
		$this->form_validation->set_rules('cao_nm','cao_nm','trim|max_length[333]');
		$this->form_validation->set_rules('cao','cao','trim');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('cao_id', TRUE));
        } else {
            $data = array(
		'cao_nm' => empty($this->input->post('cao_nm',TRUE))? NULL : $this->input->post('cao_nm',TRUE), 
		'cao' => empty($this->input->post('cao',TRUE))? NULL : $this->input->post('cao',TRUE), 
	    );

            $this->Cao_model->update($this->input->post('cao_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('cao'));
        }
    }
    
    public function delete($id) 
    {   
        $row = $this->Cao_model->get_by_id($id);

        if ($row) {
            if(@$this->Cao_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('cao'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('cao'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('cao'));
        }
    }

    public function _rules() 
    { 
	$this->form_validation->set_rules('cao_nm', 'cao nm', 'trim|required');
	$this->form_validation->set_rules('cao', 'cao', 'trim|required');

	$this->form_validation->set_rules('cao_id', 'cao_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){
                

                    $param = array(
         
		 array('cao_nm', '=' , $this->input->post('cao_nm',TRUE)),
		 array('cao', '=' , $this->input->post('cao',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'cao_data' => $this->Cao_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('cao/Cao_pdf', $data, true);
              

          $formato = $this->input->post('formato', TRUE); 
          $nome_arquivo = 'arquivo';
          if(rupper($formato) == 'EXCEL'){
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
                 ",'O',true);
        

                $pdf->WriteHTML(utf8_encode($html));    
                $pdf->SetFooter("{DATE j/m/Y H:i}|{PAGENO}/{nb}|" . utf8_encode('Nome do Sistema') . "|");
                
                $pdf->Output('recurso.recurso.pdf', 'I');

          } 
        
public function report() {
    
        
            $data = array(
                'button'        => 'Gerar',
                'controller'    => 'report',
                'action'        => site_url('cao/open_pdf'),
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
               
           
            $this->load->view('cao/Cao_report', forFrontVue($data));
        
    }
         

}

/* End of file Cao.php */
/* Local: ./application/controllers/Cao.php */
/* Gerado por RGenerator - 2025-03-27 19:50:00 */