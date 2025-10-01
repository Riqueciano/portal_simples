<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inscricao_fornecedor_historico extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Inscricao_fornecedor_historico_model'); 
        
        $this->load->service('Inscricao_fornecedor_historico_service'); 
        
$this->load->model('Inscricao_fornecedor_model'); 

$this->load->model('Pessoa_model'); 
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
        $config['total_rows'] = $this->Inscricao_fornecedor_historico_model->total_rows($q);
        $inscricao_fornecedor_historico = $this->Inscricao_fornecedor_historico_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if($format == 'json'){
            echo json($inscricao_fornecedor_historico);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'inscricao_fornecedor_historico_data' => json($inscricao_fornecedor_historico),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('inscricao_fornecedor_historico/Inscricao_fornecedor_historico_list', forFrontVue($data));
    }

    public function read($id) 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Inscricao_fornecedor_historico_model->get_by_id($id); $inscricao_fornecedor = $this->Inscricao_fornecedor_model->get_all_combobox(); $pessoa = $this->Pessoa_model->get_all_combobox();   if ($row) {
                    $data = array(
                        'inscricao_fornecedor' => json($inscricao_fornecedor),	'pessoa' => json($pessoa),	 
                        'button' => '',
                        'controller' => 'read',
                        'action' => site_url('inscricao_fornecedor_historico/create_action'),
	    'inscricao_fornecedor_historico_id' => $row->inscricao_fornecedor_historico_id   ,
	    'inscricao_fornecedor_historico_dt' => $row->inscricao_fornecedor_historico_dt   ,
	    'inscricao_fornecedor_historico_acao' => $row->inscricao_fornecedor_historico_acao   ,
	    'flag_email_aberto' => $row->flag_email_aberto   ,
	    'inscricao_fornecedor_id' => $row->inscricao_fornecedor_id   ,
	    'inscricao_fornecedor_historico_pessoa_id' => $row->inscricao_fornecedor_historico_pessoa_id   ,
	    );
            $this->load->view('inscricao_fornecedor_historico/Inscricao_fornecedor_historico_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('inscricao_fornecedor_historico'));
        }
    }

    public function create() 
    {    PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);$inscricao_fornecedor = $this->Inscricao_fornecedor_model->get_all_combobox(); $pessoa = $this->Pessoa_model->get_all_combobox(); $data = array(
            'inscricao_fornecedor' => json($inscricao_fornecedor),	'pessoa' => json($pessoa),	
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('inscricao_fornecedor_historico/create_action'),
	    'inscricao_fornecedor_historico_id' => set_value('inscricao_fornecedor_historico_id'),
	    'inscricao_fornecedor_historico_dt' => set_value('inscricao_fornecedor_historico_dt'),
	    'inscricao_fornecedor_historico_acao' => set_value('inscricao_fornecedor_historico_acao'),
	    'flag_email_aberto' => set_value('flag_email_aberto'),
	    'inscricao_fornecedor_id' => set_value('inscricao_fornecedor_id'),
	    'inscricao_fornecedor_historico_pessoa_id' => set_value('inscricao_fornecedor_historico_pessoa_id'),
	);
        $this->load->view('inscricao_fornecedor_historico/Inscricao_fornecedor_historico_form', forFrontVue($data));
    }
    
    public function create_action() 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->_rules();
		$this->form_validation->set_rules('inscricao_fornecedor_historico_dt', NULL,'trim');
		$this->form_validation->set_rules('inscricao_fornecedor_historico_acao', NULL,'trim|max_length[200]');
		$this->form_validation->set_rules('flag_email_aberto', NULL,'trim|integer');
		$this->form_validation->set_rules('inscricao_fornecedor_id', NULL,'trim|integer');
		$this->form_validation->set_rules('inscricao_fornecedor_historico_pessoa_id', NULL,'trim|integer');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'inscricao_fornecedor_historico_dt' => 	 empty($this->input->post('inscricao_fornecedor_historico_dt',TRUE))? NULL : $this->input->post('inscricao_fornecedor_historico_dt',TRUE),
		'inscricao_fornecedor_historico_acao' => 	 empty($this->input->post('inscricao_fornecedor_historico_acao',TRUE))? NULL : $this->input->post('inscricao_fornecedor_historico_acao',TRUE),
		'flag_email_aberto' => 	 empty($this->input->post('flag_email_aberto',TRUE))? NULL : $this->input->post('flag_email_aberto',TRUE),
		'inscricao_fornecedor_id' => 	 empty($this->input->post('inscricao_fornecedor_id',TRUE))? NULL : $this->input->post('inscricao_fornecedor_id',TRUE),
		'inscricao_fornecedor_historico_pessoa_id' => 	 empty($this->input->post('inscricao_fornecedor_historico_pessoa_id',TRUE))? NULL : $this->input->post('inscricao_fornecedor_historico_pessoa_id',TRUE),
	    );

            $this->Inscricao_fornecedor_historico_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('inscricao_fornecedor_historico'));
        }
    }
    
    public function update($id) 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->session->set_flashdata('message', '');
        $row = $this->Inscricao_fornecedor_historico_model->get_by_id($id);
  $inscricao_fornecedor = $this->Inscricao_fornecedor_model->get_all_combobox(); $pessoa = $this->Pessoa_model->get_all_combobox();   if ($row) {
            $data = array(
                'inscricao_fornecedor' => json($inscricao_fornecedor),'pessoa' => json($pessoa),
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('inscricao_fornecedor_historico/update_action'),
		'inscricao_fornecedor_historico_id' => set_value('inscricao_fornecedor_historico_id', $row->inscricao_fornecedor_historico_id),
		'inscricao_fornecedor_historico_dt' => set_value('inscricao_fornecedor_historico_dt', $row->inscricao_fornecedor_historico_dt),
		'inscricao_fornecedor_historico_acao' => set_value('inscricao_fornecedor_historico_acao', $row->inscricao_fornecedor_historico_acao),
		'flag_email_aberto' => set_value('flag_email_aberto', $row->flag_email_aberto),
		'inscricao_fornecedor_id' => set_value('inscricao_fornecedor_id', $row->inscricao_fornecedor_id),
		'inscricao_fornecedor_historico_pessoa_id' => set_value('inscricao_fornecedor_historico_pessoa_id', $row->inscricao_fornecedor_historico_pessoa_id),
	    );
            $this->load->view('inscricao_fornecedor_historico/Inscricao_fornecedor_historico_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('inscricao_fornecedor_historico'));
        }
    }
    
    public function update_action() 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $this->_rules();
		$this->form_validation->set_rules('inscricao_fornecedor_historico_dt','inscricao_fornecedor_historico_dt','trim');
		$this->form_validation->set_rules('inscricao_fornecedor_historico_acao','inscricao_fornecedor_historico_acao','trim|max_length[200]');
		$this->form_validation->set_rules('flag_email_aberto','flag_email_aberto','trim|integer');
		$this->form_validation->set_rules('inscricao_fornecedor_id','inscricao_fornecedor_id','trim|integer');
		$this->form_validation->set_rules('inscricao_fornecedor_historico_pessoa_id','inscricao_fornecedor_historico_pessoa_id','trim|integer');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('inscricao_fornecedor_historico_id', TRUE));
        } else {
            $data = array(
		'inscricao_fornecedor_historico_dt' => empty($this->input->post('inscricao_fornecedor_historico_dt',TRUE))? NULL : $this->input->post('inscricao_fornecedor_historico_dt',TRUE), 
		'inscricao_fornecedor_historico_acao' => empty($this->input->post('inscricao_fornecedor_historico_acao',TRUE))? NULL : $this->input->post('inscricao_fornecedor_historico_acao',TRUE), 
		'flag_email_aberto' => empty($this->input->post('flag_email_aberto',TRUE))? NULL : $this->input->post('flag_email_aberto',TRUE), 
		'inscricao_fornecedor_id' => empty($this->input->post('inscricao_fornecedor_id',TRUE))? NULL : $this->input->post('inscricao_fornecedor_id',TRUE), 
		'inscricao_fornecedor_historico_pessoa_id' => empty($this->input->post('inscricao_fornecedor_historico_pessoa_id',TRUE))? NULL : $this->input->post('inscricao_fornecedor_historico_pessoa_id',TRUE), 
	    );

            $this->Inscricao_fornecedor_historico_model->update($this->input->post('inscricao_fornecedor_historico_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('inscricao_fornecedor_historico'));
        }
    }
    
    /*
    public function delete($id) 
    {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        $row = $this->Inscricao_fornecedor_historico_model->get_by_id($id);

        if ($row) {
            if(@$this->Inscricao_fornecedor_historico_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('inscricao_fornecedor_historico'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('inscricao_fornecedor_historico'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('inscricao_fornecedor_historico'));
        }
    }*/

    public function _rules() 
    { PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
	$this->form_validation->set_rules('inscricao_fornecedor_historico_dt', 'inscricao fornecedor historico dt', 'trim|required');
	$this->form_validation->set_rules('inscricao_fornecedor_historico_acao', 'inscricao fornecedor historico acao', 'trim|required');
	$this->form_validation->set_rules('flag_email_aberto', 'flag email aberto', 'trim|required');
	$this->form_validation->set_rules('inscricao_fornecedor_id', 'inscricao fornecedor id', 'trim|required');
	$this->form_validation->set_rules('inscricao_fornecedor_historico_pessoa_id', 'inscricao fornecedor historico pessoa id', 'trim|required');

	$this->form_validation->set_rules('inscricao_fornecedor_historico_id', 'inscricao_fornecedor_historico_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){
                PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);

                    $param = array(
         
		 array('inscricao_fornecedor_historico_dt', '=' , $this->input->post('inscricao_fornecedor_historico_dt',TRUE)),
		 array('inscricao_fornecedor_historico_acao', '=' , $this->input->post('inscricao_fornecedor_historico_acao',TRUE)),
		 array('flag_email_aberto', '=' , $this->input->post('flag_email_aberto',TRUE)),
		 array('inscricao_fornecedor_id', '=' , $this->input->post('inscricao_fornecedor_id',TRUE)),
		 array('inscricao_fornecedor_historico_pessoa_id', '=' , $this->input->post('inscricao_fornecedor_historico_pessoa_id',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'inscricao_fornecedor_historico_data' => $this->Inscricao_fornecedor_historico_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('inscricao_fornecedor_historico/Inscricao_fornecedor_historico_pdf', $data, true);
              

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
                'action'        => site_url('inscricao_fornecedor_historico/open_pdf'),
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
               
           
            $this->load->view('inscricao_fornecedor_historico/Inscricao_fornecedor_historico_report', forFrontVue($data));
        
    }
         

}

/* End of file Inscricao_fornecedor_historico.php */
/* Local: ./application/controllers/Inscricao_fornecedor_historico.php */
/* Gerado por RGenerator - 2025-08-01 14:28:31 */