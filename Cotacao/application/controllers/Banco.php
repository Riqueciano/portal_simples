<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banco extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Banco_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'banco/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'banco/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'banco/';
            $config['first_url'] = base_url() . 'banco/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Banco_model->total_rows($q);
        $banco = $this->Banco_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'banco_data' => $banco,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('banco/Banco_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Banco_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('banco/create_action'),
	    'banco_id' => $row->banco_id   ,
	    'banco_cd' => $row->banco_cd   ,
	    'banco_ds' => $row->banco_ds   ,
	    'banco_st' => $row->banco_st   ,
	    'banco_dt_criacao' => $row->banco_dt_criacao   ,
	    'banco_dt_alteracao' => $row->banco_dt_alteracao   ,
	    );
            $this->load->view('banco/Banco_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('banco'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('banco/create_action'),
	    'banco_id' => set_value('banco_id'),
	    'banco_cd' => set_value('banco_cd'),
	    'banco_ds' => set_value('banco_ds'),
	    'banco_st' => set_value('banco_st'),
	    'banco_dt_criacao' => set_value('banco_dt_criacao'),
	    'banco_dt_alteracao' => set_value('banco_dt_alteracao'),
	);
        $this->load->view('banco/Banco_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('banco_cd', NULL,'trim|required|max_length[3]');
		$this->form_validation->set_rules('banco_ds', NULL,'trim|required|max_length[50]');
		$this->form_validation->set_rules('banco_st', NULL,'trim|numeric');
		$this->form_validation->set_rules('banco_dt_criacao', NULL,'trim');
		$this->form_validation->set_rules('banco_dt_alteracao', NULL,'trim');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'banco_cd' => 	 empty($this->input->post('banco_cd',TRUE))? NULL : $this->input->post('banco_cd',TRUE),
		'banco_ds' => 	 empty($this->input->post('banco_ds',TRUE))? NULL : $this->input->post('banco_ds',TRUE),
		'banco_st' => 	 empty($this->input->post('banco_st',TRUE))? NULL : $this->input->post('banco_st',TRUE),
		'banco_dt_criacao' => 	 empty($this->input->post('banco_dt_criacao',TRUE))? NULL : $this->input->post('banco_dt_criacao',TRUE),
		'banco_dt_alteracao' => 	 empty($this->input->post('banco_dt_alteracao',TRUE))? NULL : $this->input->post('banco_dt_alteracao',TRUE),
	    );

            $this->Banco_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('banco'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Banco_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('banco/update_action'),
		'banco_id' => set_value('banco_id', $row->banco_id),
		'banco_cd' => set_value('banco_cd', $row->banco_cd),
		'banco_ds' => set_value('banco_ds', $row->banco_ds),
		'banco_st' => set_value('banco_st', $row->banco_st),
		'banco_dt_criacao' => set_value('banco_dt_criacao', $row->banco_dt_criacao),
		'banco_dt_alteracao' => set_value('banco_dt_alteracao', $row->banco_dt_alteracao),
	    );
            $this->load->view('banco/Banco_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('banco'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('banco_cd','banco_cd','trim|required|max_length[3]');
		$this->form_validation->set_rules('banco_ds','banco_ds','trim|required|max_length[50]');
		$this->form_validation->set_rules('banco_st','banco_st','trim|numeric');
		$this->form_validation->set_rules('banco_dt_criacao','banco_dt_criacao','trim');
		$this->form_validation->set_rules('banco_dt_alteracao','banco_dt_alteracao','trim');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('banco_id', TRUE));
        } else {
            $data = array(
		'banco_cd' => empty($this->input->post('banco_cd',TRUE))? NULL : $this->input->post('banco_cd',TRUE), 
		'banco_ds' => empty($this->input->post('banco_ds',TRUE))? NULL : $this->input->post('banco_ds',TRUE), 
		'banco_st' => empty($this->input->post('banco_st',TRUE))? NULL : $this->input->post('banco_st',TRUE), 
		'banco_dt_criacao' => empty($this->input->post('banco_dt_criacao',TRUE))? NULL : $this->input->post('banco_dt_criacao',TRUE), 
		'banco_dt_alteracao' => empty($this->input->post('banco_dt_alteracao',TRUE))? NULL : $this->input->post('banco_dt_alteracao',TRUE), 
	    );

            $this->Banco_model->update($this->input->post('banco_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('banco'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Banco_model->get_by_id($id);

        if ($row) {
            if(@$this->Banco_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('banco'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('banco'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('banco'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('banco_cd', 'banco cd', 'trim|required');
	$this->form_validation->set_rules('banco_ds', 'banco ds', 'trim|required');
	$this->form_validation->set_rules('banco_st', 'banco st', 'trim|required');
	$this->form_validation->set_rules('banco_dt_criacao', 'banco dt criacao', 'trim|required');
	$this->form_validation->set_rules('banco_dt_alteracao', 'banco dt alteracao', 'trim|required');

	$this->form_validation->set_rules('banco_id', 'banco_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('banco_cd', '=' , $this->input->post('banco_cd',TRUE)),
		 array('banco_ds', '=' , $this->input->post('banco_ds',TRUE)),
		 array('banco_st', '=' , $this->input->post('banco_st',TRUE)),
		 array('banco_dt_criacao', '=' , $this->input->post('banco_dt_criacao',TRUE)),
		 array('banco_dt_alteracao', '=' , $this->input->post('banco_dt_alteracao',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'banco_data' => $this->Banco_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('banco/Banco_pdf', $data, true);
              

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
                'action'        => site_url('banco/open_pdf'),
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
               
           
            $this->load->view('banco/Banco_report', $data);
        
    }
         

}

/* End of file Banco.php */
/* Local: ./application/controllers/Banco.php */
/* Gerado por RGenerator - 2020-01-16 20:12:53 */