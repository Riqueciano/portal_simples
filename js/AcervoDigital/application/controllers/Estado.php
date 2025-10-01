<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Estado extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Estado_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $estado = $this->Estado_model->get_all();

        $data = array(
            'estado_data' => $estado
        );

        $this->load->view('estado/Estado_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Estado_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('estado/create_action'),
	    'estado_id' => $row->estado_id   ,
	    'estado_uf' => $row->estado_uf   ,
	    );
            $this->load->view('estado/Estado_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('estado'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('estado/create_action'),
	    'estado_id' => set_value('estado_id'),
	    'estado_uf' => set_value('estado_uf'),
	);
        $this->load->view('estado/Estado_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('estado_uf', NULL,'trim|max_length[2]');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
		'estado_uf' => 	 empty($this->input->post('estado_uf',TRUE))? NULL : $this->input->post('estado_uf',TRUE),
	    );

            $this->Estado_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('estado'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Estado_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('estado/update_action'),
		'estado_id' => set_value('estado_id', $row->estado_id),
		'estado_uf' => set_value('estado_uf', $row->estado_uf),
	    );
            $this->load->view('estado/Estado_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('estado'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('estado_uf','estado_uf','trim|max_length[2]');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('estado_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
		'estado_uf' => empty($this->input->post('estado_uf',TRUE))? NULL : $this->input->post('estado_uf',TRUE), 
	    );

            $this->Estado_model->update($this->input->post('estado_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('estado'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Estado_model->get_by_id($id);

        if ($row) {
            if(@$this->Estado_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('estado'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('estado'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('estado'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('estado_uf', 'estado uf', 'trim|required');

	$this->form_validation->set_rules('estado_id', 'estado_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('estado_uf', '=' , $this->input->post('estado_uf',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'estado_data' => $this->Estado_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('estado/Estado_pdf', $data, true);
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
                'action'        => site_url('estado/open_pdf'),
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
               
           
            $this->load->view('estado/Estado_report', $data);
        
    }
         

}

/* End of file Estado.php */
/* Local: ./application/controllers/Estado.php */
/* Gerado por RGenerator - 2018-05-22 16:08:40 */