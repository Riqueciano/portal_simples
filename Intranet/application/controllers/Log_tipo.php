<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log_tipo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Log_tipo_model');
        $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'log_tipo/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'log_tipo/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'log_tipo/';
            $config['first_url'] = base_url() . 'log_tipo/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Log_tipo_model->total_rows($q);
        $log_tipo = $this->Log_tipo_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'log_tipo_data' => $log_tipo,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('log_tipo/Log_tipo_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Log_tipo_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('log_tipo/create_action'),
	    'log_tipo_id' => $row->log_tipo_id   ,
	    'log_tipo_nm' => $row->log_tipo_nm   ,
	    );
            $this->load->view('log_tipo/Log_tipo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('log_tipo'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('log_tipo/create_action'),
	    'log_tipo_id' => set_value('log_tipo_id'),
	    'log_tipo_nm' => set_value('log_tipo_nm'),
	);
        $this->load->view('log_tipo/Log_tipo_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('log_tipo_nm', NULL,'trim|required|max_length[200]');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'log_tipo_nm' => 	 empty($this->input->post('log_tipo_nm',TRUE))? NULL : $this->input->post('log_tipo_nm',TRUE),
	    );

            $this->Log_tipo_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('log_tipo'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Log_tipo_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('log_tipo/update_action'),
		'log_tipo_id' => set_value('log_tipo_id', $row->log_tipo_id),
		'log_tipo_nm' => set_value('log_tipo_nm', $row->log_tipo_nm),
	    );
            $this->load->view('log_tipo/Log_tipo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('log_tipo'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('log_tipo_nm','log_tipo_nm','trim|required|max_length[200]');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('log_tipo_id', TRUE));
        } else {
            $data = array(
		'log_tipo_nm' => empty($this->input->post('log_tipo_nm',TRUE))? NULL : $this->input->post('log_tipo_nm',TRUE), 
	    );

            $this->Log_tipo_model->update($this->input->post('log_tipo_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('log_tipo'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Log_tipo_model->get_by_id($id);

        if ($row) {
            if(@$this->Log_tipo_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('log_tipo'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('log_tipo'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('log_tipo'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('log_tipo_nm', 'log tipo nm', 'trim|required');

	$this->form_validation->set_rules('log_tipo_id', 'log_tipo_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('log_tipo_nm', '=' , $this->input->post('log_tipo_nm',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'log_tipo_data' => $this->Log_tipo_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('log_tipo/Log_tipo_pdf', $data, true);
              

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
                'action'        => site_url('log_tipo/open_pdf'),
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
               
           
            $this->load->view('log_tipo/Log_tipo_report', $data);
        
    }
         

}

/* End of file Log_tipo.php */
/* Local: ./application/controllers/Log_tipo.php */
/* Gerado por RGenerator - 2019-09-19 17:23:47 */