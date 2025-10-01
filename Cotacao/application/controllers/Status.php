<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Status extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Status_model');   $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'status/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'status/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'status/';
            $config['first_url'] = base_url() . 'status/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Status_model->total_rows($q);
        $status = $this->Status_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if($format == 'json'){
            echo json($status);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'status_data' => json($status),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('status/Status_list', forFrontVue($data));
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Status_model->get_by_id($id);   if ($row) {
                    $data = array(
                         
                        'button' => '',
                        'controller' => 'read',
                        'action' => site_url('status/create_action'),
	    'status_id' => $row->status_id   ,
	    'status_nm' => $row->status_nm   ,
	    );
            $this->load->view('status/Status_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('status'));
        }
    }

    public function create() 
    {$data = array(
            
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('status/create_action'),
	    'status_id' => set_value('status_id'),
	    'status_nm' => set_value('status_nm'),
	);
        $this->load->view('status/Status_form', forFrontVue($data));
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('status_nm', NULL,'trim|required|max_length[200]');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'status_nm' => 	 empty($this->input->post('status_nm',TRUE))? NULL : $this->input->post('status_nm',TRUE),
	    );

            $this->Status_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('status'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Status_model->get_by_id($id);
    if ($row) {
            $data = array(
                
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('status/update_action'),
		'status_id' => set_value('status_id', $row->status_id),
		'status_nm' => set_value('status_nm', $row->status_nm),
	    );
            $this->load->view('status/Status_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('status'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('status_nm','status_nm','trim|required|max_length[200]');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('status_id', TRUE));
        } else {
            $data = array(
		'status_nm' => empty($this->input->post('status_nm',TRUE))? NULL : $this->input->post('status_nm',TRUE), 
	    );

            $this->Status_model->update($this->input->post('status_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('status'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Status_model->get_by_id($id);

        if ($row) {
            if(@$this->Status_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('status'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('status'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('status'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('status_nm', 'status nm', 'trim|required');

	$this->form_validation->set_rules('status_id', 'status_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('status_nm', '=' , $this->input->post('status_nm',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'status_data' => $this->Status_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('status/Status_pdf', $data, true);
              

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
                'action'        => site_url('status/open_pdf'),
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
               
           
            $this->load->view('status/Status_report', forFrontVue($data));
        
    }
         

}

/* End of file Status.php */
/* Local: ./application/controllers/Status.php */
/* Gerado por RGenerator - 2022-09-05 18:17:33 */