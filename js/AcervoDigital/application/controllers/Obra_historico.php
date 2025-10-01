<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Obra_historico extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Obra_historico_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'obra_historico/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'obra_historico/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'obra_historico/';
            $config['first_url'] = base_url() . 'obra_historico/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Obra_historico_model->total_rows($q);
        $obra_historico = $this->Obra_historico_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'obra_historico_data' => $obra_historico,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('obra_historico/Obra_historico_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Obra_historico_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('obra_historico/create_action'),
	    'obra_historico_id' => $row->obra_historico_id   ,
	    'acao' => $row->acao   ,
	    'dt_cadastro' => $row->dt_cadastro   ,
	    'obra_id' => $row->obra_id   ,
	    'pessoa_id' => $row->pessoa_id   ,
	    );
            $this->load->view('obra_historico/Obra_historico_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('obra_historico'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('obra_historico/create_action'),
	    'obra_historico_id' => set_value('obra_historico_id'),
	    'acao' => set_value('acao'),
	    'dt_cadastro' => set_value('dt_cadastro'),
	    'obra_id' => set_value('obra_id'),
	    'pessoa_id' => set_value('pessoa_id'),
	);
        $this->load->view('obra_historico/Obra_historico_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('acao', NULL,'trim|max_length[150]');
		$this->form_validation->set_rules('dt_cadastro', NULL,'trim');
		$this->form_validation->set_rules('obra_id', NULL,'trim|required|integer');
		$this->form_validation->set_rules('pessoa_id', NULL,'trim|required|integer');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
		'acao' => 	 empty($this->input->post('acao',TRUE))? NULL : $this->input->post('acao',TRUE),
		'dt_cadastro' => 	 empty($this->input->post('dt_cadastro',TRUE))? NULL : $this->input->post('dt_cadastro',TRUE),
		'obra_id' => 	 empty($this->input->post('obra_id',TRUE))? NULL : $this->input->post('obra_id',TRUE),
		'pessoa_id' => 	 empty($this->input->post('pessoa_id',TRUE))? NULL : $this->input->post('pessoa_id',TRUE),
	    );

            $this->Obra_historico_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('obra_historico'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Obra_historico_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('obra_historico/update_action'),
		'obra_historico_id' => set_value('obra_historico_id', $row->obra_historico_id),
		'acao' => set_value('acao', $row->acao),
		'dt_cadastro' => set_value('dt_cadastro', $row->dt_cadastro),
		'obra_id' => set_value('obra_id', $row->obra_id),
		'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
	    );
            $this->load->view('obra_historico/Obra_historico_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('obra_historico'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('acao','acao','trim|max_length[150]');
		$this->form_validation->set_rules('dt_cadastro','dt_cadastro','trim');
		$this->form_validation->set_rules('obra_id','obra_id','trim|required|integer');
		$this->form_validation->set_rules('pessoa_id','pessoa_id','trim|required|integer');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('obra_historico_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
		'acao' => empty($this->input->post('acao',TRUE))? NULL : $this->input->post('acao',TRUE), 
		'dt_cadastro' => empty($this->input->post('dt_cadastro',TRUE))? NULL : $this->input->post('dt_cadastro',TRUE), 
		'obra_id' => empty($this->input->post('obra_id',TRUE))? NULL : $this->input->post('obra_id',TRUE), 
		'pessoa_id' => empty($this->input->post('pessoa_id',TRUE))? NULL : $this->input->post('pessoa_id',TRUE), 
	    );

            $this->Obra_historico_model->update($this->input->post('obra_historico_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('obra_historico'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Obra_historico_model->get_by_id($id);

        if ($row) {
            if(@$this->Obra_historico_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('obra_historico'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('obra_historico'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('obra_historico'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('acao', 'acao', 'trim|required');
	$this->form_validation->set_rules('dt_cadastro', 'dt cadastro', 'trim|required');
	$this->form_validation->set_rules('obra_id', 'obra id', 'trim|required');
	$this->form_validation->set_rules('pessoa_id', 'pessoa id', 'trim|required');

	$this->form_validation->set_rules('obra_historico_id', 'obra_historico_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('acao', '=' , $this->input->post('acao',TRUE)),
		 array('dt_cadastro', '=' , $this->input->post('dt_cadastro',TRUE)),
		 array('obra_id', '=' , $this->input->post('obra_id',TRUE)),
		 array('pessoa_id', '=' , $this->input->post('pessoa_id',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'obra_historico_data' => $this->Obra_historico_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('obra_historico/Obra_historico_pdf', $data, true);
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
                'action'        => site_url('obra_historico/open_pdf'),
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
               
           
            $this->load->view('obra_historico/Obra_historico_report', $data);
        
    }
         

}

/* End of file Obra_historico.php */
/* Local: ./application/controllers/Obra_historico.php */
/* Gerado por RGenerator - 2018-04-02 16:18:12 */