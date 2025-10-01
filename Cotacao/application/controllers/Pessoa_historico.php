<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pessoa_historico extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pessoa_historico_model'); 
        
        $this->load->service(''); 
          $this->load->library('form_validation');
    }
    

    public function index()
    {   
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = (int)$this->input->get('start');
        
         

        $config['per_page'] = 30;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Pessoa_historico_model->total_rows($q);
        $pessoa_historico = $this->Pessoa_historico_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if($format == 'json'){
            echo json($pessoa_historico);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pessoa_historico_data' => json($pessoa_historico),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('pessoa_historico/Pessoa_historico_list', forFrontVue($data));
    }

    public function read($id) 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Pessoa_historico_model->get_by_id($id);   if ($row) {
                    $data = array(
                         
                        'button' => '',
                        'controller' => 'read',
                        'action' => site_url('pessoa_historico/create_action'),
	    'pessoa_historico_id' => $row->pessoa_historico_id   ,
	    'acao' => $row->acao   ,
	    'pessoa_id' => $row->pessoa_id   ,
	    'responsavel_pessoa_id' => $row->responsavel_pessoa_id   ,
	    'dt_cadastro' => $row->dt_cadastro   ,
	    );
            $this->load->view('pessoa_historico/Pessoa_historico_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pessoa_historico'));
        }
    }

    public function create() 
    {    PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);$data = array(
            
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('pessoa_historico/create_action'),
	    'pessoa_historico_id' => set_value('pessoa_historico_id'),
	    'acao' => set_value('acao'),
	    'pessoa_id' => set_value('pessoa_id'),
	    'responsavel_pessoa_id' => set_value('responsavel_pessoa_id'),
	    'dt_cadastro' => set_value('dt_cadastro'),
	);
        $this->load->view('pessoa_historico/Pessoa_historico_form', forFrontVue($data));
    }
    
    public function create_action() 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->_rules();
		$this->form_validation->set_rules('acao', NULL,'trim|required|max_length[8000]');
		$this->form_validation->set_rules('pessoa_id', NULL,'trim|required|integer');
		$this->form_validation->set_rules('responsavel_pessoa_id', NULL,'trim|integer');
		$this->form_validation->set_rules('dt_cadastro', NULL,'trim');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'acao' => 	 empty($this->input->post('acao',TRUE))? NULL : $this->input->post('acao',TRUE),
		'pessoa_id' => 	 empty($this->input->post('pessoa_id',TRUE))? NULL : $this->input->post('pessoa_id',TRUE),
		'responsavel_pessoa_id' => 	 empty($this->input->post('responsavel_pessoa_id',TRUE))? NULL : $this->input->post('responsavel_pessoa_id',TRUE),
		'dt_cadastro' => 	 empty($this->input->post('dt_cadastro',TRUE))? NULL : $this->input->post('dt_cadastro',TRUE),
	    );

            $this->Pessoa_historico_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('pessoa_historico'));
        }
    }
    
    public function update($id) 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Pessoa_historico_model->get_by_id($id);
    if ($row) {
            $data = array(
                
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('pessoa_historico/update_action'),
		'pessoa_historico_id' => set_value('pessoa_historico_id', $row->pessoa_historico_id),
		'acao' => set_value('acao', $row->acao),
		'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
		'responsavel_pessoa_id' => set_value('responsavel_pessoa_id', $row->responsavel_pessoa_id),
		'dt_cadastro' => set_value('dt_cadastro', $row->dt_cadastro),
	    );
            $this->load->view('pessoa_historico/Pessoa_historico_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('pessoa_historico'));
        }
    }
    
    public function update_action() 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->_rules();
		$this->form_validation->set_rules('acao','acao','trim|required|max_length[8000]');
		$this->form_validation->set_rules('pessoa_id','pessoa_id','trim|required|integer');
		$this->form_validation->set_rules('responsavel_pessoa_id','responsavel_pessoa_id','trim|integer');
		$this->form_validation->set_rules('dt_cadastro','dt_cadastro','trim');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('pessoa_historico_id', TRUE));
        } else {
            $data = array(
		'acao' => empty($this->input->post('acao',TRUE))? NULL : $this->input->post('acao',TRUE), 
		'pessoa_id' => empty($this->input->post('pessoa_id',TRUE))? NULL : $this->input->post('pessoa_id',TRUE), 
		'responsavel_pessoa_id' => empty($this->input->post('responsavel_pessoa_id',TRUE))? NULL : $this->input->post('responsavel_pessoa_id',TRUE), 
		'dt_cadastro' => empty($this->input->post('dt_cadastro',TRUE))? NULL : $this->input->post('dt_cadastro',TRUE), 
	    );

            $this->Pessoa_historico_model->update($this->input->post('pessoa_historico_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('pessoa_historico'));
        }
    }
    
    /*
    public function delete($id) 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $row = $this->Pessoa_historico_model->get_by_id($id);

        if ($row) {
            if(@$this->Pessoa_historico_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('pessoa_historico'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('pessoa_historico'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('pessoa_historico'));
        }
    }
        */

    public function _rules() 
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
	$this->form_validation->set_rules('acao', 'acao', 'trim|required');
	$this->form_validation->set_rules('pessoa_id', 'pessoa id', 'trim|required');
	$this->form_validation->set_rules('responsavel_pessoa_id', 'responsavel pessoa id', 'trim|required');
	$this->form_validation->set_rules('dt_cadastro', 'dt cadastro', 'trim|required');

	$this->form_validation->set_rules('pessoa_historico_id', 'pessoa_historico_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){
                PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);

                    $param = array(
         
		 array('acao', '=' , $this->input->post('acao',TRUE)),
		 array('pessoa_id', '=' , $this->input->post('pessoa_id',TRUE)),
		 array('responsavel_pessoa_id', '=' , $this->input->post('responsavel_pessoa_id',TRUE)),
		 array('dt_cadastro', '=' , $this->input->post('dt_cadastro',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'pessoa_historico_data' => $this->Pessoa_historico_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('pessoa_historico/Pessoa_historico_pdf', $data, true);
              

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
    PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        
            $data = array(
                'button'        => 'Gerar',
                'controller'    => 'report',
                'action'        => site_url('pessoa_historico/open_pdf'),
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
               
           
            $this->load->view('pessoa_historico/Pessoa_historico_report', forFrontVue($data));
        
    }
         

}

/* End of file Pessoa_historico.php */
/* Local: ./application/controllers/Pessoa_historico.php */
/* Gerado por RGenerator - 2025-07-09 20:50:07 */