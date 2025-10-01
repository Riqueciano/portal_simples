<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
        $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'log/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'log/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'log/';
            $config['first_url'] = base_url() . 'log/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Log_model->total_rows($q);
        $log = $this->Log_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'log_data' => $log,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('log/Log_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Log_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('log/create_action'),
	    'log_id' => $row->log_id   ,
	    'acao' => $row->acao   ,
	    'pessoa_id' => $row->pessoa_id   ,
	    'dt_cadastro' => $row->dt_cadastro   ,
	    'log_tipo_id' => $row->log_tipo_id   ,
	    'sistema_id' => $row->sistema_id   ,
	    );
            $this->load->view('log/Log_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('log'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('log/create_action'),
	    'log_id' => set_value('log_id'),
	    'acao' => set_value('acao'),
	    'pessoa_id' => set_value('pessoa_id'),
	    'dt_cadastro' => set_value('dt_cadastro'),
	    'log_tipo_id' => set_value('log_tipo_id'),
	    'sistema_id' => set_value('sistema_id'),
	);
        $this->load->view('log/Log_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('acao', NULL,'trim|required|max_length[800]');
		$this->form_validation->set_rules('pessoa_id', NULL,'trim|required|integer');
		$this->form_validation->set_rules('dt_cadastro', NULL,'trim');
		$this->form_validation->set_rules('log_tipo_id', NULL,'trim|required|integer');
		$this->form_validation->set_rules('sistema_id', NULL,'trim|integer');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'acao' => 	 empty($this->input->post('acao',TRUE))? NULL : $this->input->post('acao',TRUE),
		'pessoa_id' => 	 empty($this->input->post('pessoa_id',TRUE))? NULL : $this->input->post('pessoa_id',TRUE),
		'dt_cadastro' => 	 empty($this->input->post('dt_cadastro',TRUE))? NULL : $this->input->post('dt_cadastro',TRUE),
		'log_tipo_id' => 	 empty($this->input->post('log_tipo_id',TRUE))? NULL : $this->input->post('log_tipo_id',TRUE),
		'sistema_id' => 	 empty($this->input->post('sistema_id',TRUE))? NULL : $this->input->post('sistema_id',TRUE),
	    );

            $this->Log_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('log'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Log_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('log/update_action'),
		'log_id' => set_value('log_id', $row->log_id),
		'acao' => set_value('acao', $row->acao),
		'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
		'dt_cadastro' => set_value('dt_cadastro', $row->dt_cadastro),
		'log_tipo_id' => set_value('log_tipo_id', $row->log_tipo_id),
		'sistema_id' => set_value('sistema_id', $row->sistema_id),
	    );
            $this->load->view('log/Log_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('log'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('acao','acao','trim|required|max_length[800]');
		$this->form_validation->set_rules('pessoa_id','pessoa_id','trim|required|integer');
		$this->form_validation->set_rules('dt_cadastro','dt_cadastro','trim');
		$this->form_validation->set_rules('log_tipo_id','log_tipo_id','trim|required|integer');
		$this->form_validation->set_rules('sistema_id','sistema_id','trim|integer');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('log_id', TRUE));
        } else {
            $data = array(
		'acao' => empty($this->input->post('acao',TRUE))? NULL : $this->input->post('acao',TRUE), 
		'pessoa_id' => empty($this->input->post('pessoa_id',TRUE))? NULL : $this->input->post('pessoa_id',TRUE), 
		'dt_cadastro' => empty($this->input->post('dt_cadastro',TRUE))? NULL : $this->input->post('dt_cadastro',TRUE), 
		'log_tipo_id' => empty($this->input->post('log_tipo_id',TRUE))? NULL : $this->input->post('log_tipo_id',TRUE), 
		'sistema_id' => empty($this->input->post('sistema_id',TRUE))? NULL : $this->input->post('sistema_id',TRUE), 
	    );

            $this->Log_model->update($this->input->post('log_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('log'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Log_model->get_by_id($id);

        if ($row) {
            if(@$this->Log_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('log'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('log'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('log'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('acao', 'acao', 'trim|required');
	$this->form_validation->set_rules('pessoa_id', 'pessoa id', 'trim|required');
	$this->form_validation->set_rules('dt_cadastro', 'dt cadastro', 'trim|required');
	$this->form_validation->set_rules('log_tipo_id', 'log tipo id', 'trim|required');
	$this->form_validation->set_rules('sistema_id', 'sistema id', 'trim|required');

	$this->form_validation->set_rules('log_id', 'log_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('acao', '=' , $this->input->post('acao',TRUE)),
		 array('pessoa_id', '=' , $this->input->post('pessoa_id',TRUE)),
		 array('dt_cadastro', '=' , $this->input->post('dt_cadastro',TRUE)),
		 array('log_tipo_id', '=' , $this->input->post('log_tipo_id',TRUE)),
		 array('sistema_id', '=' , $this->input->post('sistema_id',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'log_data' => $this->Log_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('log/Log_pdf', $data, true);
              

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
                'action'        => site_url('log/open_pdf'),
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
               
           
            $this->load->view('log/Log_report', $data);
        
    }
         

}

/* End of file Log.php */
/* Local: ./application/controllers/Log.php */
/* Gerado por RGenerator - 2019-09-26 09:41:40 */