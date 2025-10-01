<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_tipo_usuario extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_tipo_usuario_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'usuario_tipo_usuario/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'usuario_tipo_usuario/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'usuario_tipo_usuario/';
            $config['first_url'] = base_url() . 'usuario_tipo_usuario/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Usuario_tipo_usuario_model->total_rows($q);
        $usuario_tipo_usuario = $this->Usuario_tipo_usuario_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'usuario_tipo_usuario_data' => $usuario_tipo_usuario,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('usuario_tipo_usuario/Usuario_tipo_usuario_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Usuario_tipo_usuario_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('usuario_tipo_usuario/create_action'),
	    'pessoa_id' => $row->pessoa_id   ,
	    'tipo_usuario_id' => $row->tipo_usuario_id   ,
	    );
            $this->load->view('usuario_tipo_usuario/Usuario_tipo_usuario_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('usuario_tipo_usuario'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('usuario_tipo_usuario/create_action'),
	    'pessoa_id' => set_value('pessoa_id'),
	    'tipo_usuario_id' => set_value('tipo_usuario_id'),
	);
        $this->load->view('usuario_tipo_usuario/Usuario_tipo_usuario_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('tipo_usuario_id', NULL,'trim|required');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->db->trans_start();
            $data = array(
		'tipo_usuario_id' => 	 empty($this->input->post('tipo_usuario_id',TRUE))? NULL : $this->input->post('tipo_usuario_id',TRUE),
	    );

            $this->Usuario_tipo_usuario_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('usuario_tipo_usuario'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Usuario_tipo_usuario_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('usuario_tipo_usuario/update_action'),
		'pessoa_id' => set_value('pessoa_id', $row->pessoa_id),
		'tipo_usuario_id' => set_value('tipo_usuario_id', $row->tipo_usuario_id),
	    );
            $this->load->view('usuario_tipo_usuario/Usuario_tipo_usuario_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('usuario_tipo_usuario'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('tipo_usuario_id','tipo_usuario_id','trim|required');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('pessoa_id', TRUE));
        } else {
            $this->db->trans_start();
            $data = array(
		'tipo_usuario_id' => empty($this->input->post('tipo_usuario_id',TRUE))? NULL : $this->input->post('tipo_usuario_id',TRUE), 
	    );

            $this->Usuario_tipo_usuario_model->update($this->input->post('pessoa_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            $this->db->trans_complete();
            redirect(site_url('usuario_tipo_usuario'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Usuario_tipo_usuario_model->get_by_id($id);

        if ($row) {
            if(@$this->Usuario_tipo_usuario_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('usuario_tipo_usuario'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('usuario_tipo_usuario'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('usuario_tipo_usuario'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('tipo_usuario_id', 'tipo usuario id', 'trim|required');

	$this->form_validation->set_rules('pessoa_id', 'pessoa_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('tipo_usuario_id', '=' , $this->input->post('tipo_usuario_id',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'usuario_tipo_usuario_data' => $this->Usuario_tipo_usuario_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('usuario_tipo_usuario/Usuario_tipo_usuario_pdf', $data, true);
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
                'action'        => site_url('usuario_tipo_usuario/open_pdf'),
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
               
           
            $this->load->view('usuario_tipo_usuario/Usuario_tipo_usuario_report', $data);
        
    }
         

}

/* End of file Usuario_tipo_usuario.php */
/* Local: ./application/controllers/Usuario_tipo_usuario.php */
/* Gerado por RGenerator - 2018-04-09 18:03:07 */