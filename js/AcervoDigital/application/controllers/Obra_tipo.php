<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Obra_tipo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Obra_tipo_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'obra_tipo/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'obra_tipo/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'obra_tipo/';
            $config['first_url'] = base_url() . 'obra_tipo/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Obra_tipo_model->total_rows($q);
        $obra_tipo = $this->Obra_tipo_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'obra_tipo_data' => $obra_tipo,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('obra_tipo/Obra_tipo_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Obra_tipo_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('obra_tipo/create_action'),
	    'obra_tipo_id' => $row->obra_tipo_id   ,
	    'obra_tipo_nm' => $row->obra_tipo_nm   ,
	    'obra_ativo' => $row->obra_ativo   ,
	    );
            $this->load->view('obra_tipo/Obra_tipo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('obra_tipo'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('obra_tipo/create_action'),
	    'obra_tipo_id' => set_value('obra_tipo_id'),
	    'obra_tipo_nm' => set_value('obra_tipo_nm'),
	    'obra_ativo' => set_value('obra_ativo'),
	);
        $this->load->view('obra_tipo/Obra_tipo_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('obra_tipo_nm', NULL,'trim|required|max_length[200]');
		$this->form_validation->set_rules('obra_ativo', NULL,'trim|required|integer');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
		'obra_tipo_nm' => 	 empty($this->input->post('obra_tipo_nm',TRUE))? NULL : $this->input->post('obra_tipo_nm',TRUE),
		'obra_ativo' => 	 empty($this->input->post('obra_ativo',TRUE))? NULL : $this->input->post('obra_ativo',TRUE),
	    );

            $this->Obra_tipo_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('obra_tipo'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Obra_tipo_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('obra_tipo/update_action'),
		'obra_tipo_id' => set_value('obra_tipo_id', $row->obra_tipo_id),
		'obra_tipo_nm' => set_value('obra_tipo_nm', $row->obra_tipo_nm),
		'obra_ativo' => set_value('obra_ativo', $row->obra_ativo),
	    );
            $this->load->view('obra_tipo/Obra_tipo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('obra_tipo'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('obra_tipo_nm','obra_tipo_nm','trim|required|max_length[200]');
		$this->form_validation->set_rules('obra_ativo','obra_ativo','trim|required|integer');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('obra_tipo_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
		'obra_tipo_nm' => empty($this->input->post('obra_tipo_nm',TRUE))? NULL : $this->input->post('obra_tipo_nm',TRUE), 
		'obra_ativo' => empty($this->input->post('obra_ativo',TRUE))? NULL : $this->input->post('obra_ativo',TRUE), 
	    );

            $this->Obra_tipo_model->update($this->input->post('obra_tipo_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('obra_tipo'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Obra_tipo_model->get_by_id($id);

        if ($row) {
            if(@$this->Obra_tipo_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('obra_tipo'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('obra_tipo'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('obra_tipo'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('obra_tipo_nm', 'obra tipo nm', 'trim|required');
	$this->form_validation->set_rules('obra_ativo', 'obra ativo', 'trim|required');

	$this->form_validation->set_rules('obra_tipo_id', 'obra_tipo_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('obra_tipo_nm', '=' , $this->input->post('obra_tipo_nm',TRUE)),
		 array('obra_ativo', '=' , $this->input->post('obra_ativo',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'obra_tipo_data' => $this->Obra_tipo_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('obra_tipo/Obra_tipo_pdf', $data, true);
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
                'action'        => site_url('obra_tipo/open_pdf'),
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
               
           
            $this->load->view('obra_tipo/Obra_tipo_report', $data);
        
    }
         

}

/* End of file Obra_tipo.php */
/* Local: ./application/controllers/Obra_tipo.php */
/* Gerado por RGenerator - 2018-03-27 17:04:07 */