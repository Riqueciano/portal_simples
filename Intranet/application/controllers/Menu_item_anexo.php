<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_item_anexo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_item_anexo_model');
        $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'menu_item_anexo/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'menu_item_anexo/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'menu_item_anexo/';
            $config['first_url'] = base_url() . 'menu_item_anexo/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Menu_item_anexo_model->total_rows($q);
        $menu_item_anexo = $this->Menu_item_anexo_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'menu_item_anexo_data' => $menu_item_anexo,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('menu_item_anexo/Menu_item_anexo_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Menu_item_anexo_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('menu_item_anexo/create_action'),
	    'menu_item_anexo_id' => $row->menu_item_anexo_id   ,
	    'menu_item_anexo' => $row->menu_item_anexo   ,
	    'menu_item_id' => $row->menu_item_id   ,
	    );
            $this->load->view('menu_item_anexo/Menu_item_anexo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu_item_anexo'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('menu_item_anexo/create_action'),
	    'menu_item_anexo_id' => set_value('menu_item_anexo_id'),
	    'menu_item_anexo' => set_value('menu_item_anexo'),
	    'menu_item_id' => set_value('menu_item_id'),
	);
        $this->load->view('menu_item_anexo/Menu_item_anexo_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('menu_item_anexo', NULL,'trim|required|max_length[800]');
		$this->form_validation->set_rules('menu_item_id', NULL,'trim|required|integer');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'menu_item_anexo' => 	 empty($this->input->post('menu_item_anexo',TRUE))? NULL : $this->input->post('menu_item_anexo',TRUE),
		'menu_item_id' => 	 empty($this->input->post('menu_item_id',TRUE))? NULL : $this->input->post('menu_item_id',TRUE),
	    );

            $this->Menu_item_anexo_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('menu_item_anexo'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Menu_item_anexo_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('menu_item_anexo/update_action'),
		'menu_item_anexo_id' => set_value('menu_item_anexo_id', $row->menu_item_anexo_id),
		'menu_item_anexo' => set_value('menu_item_anexo', $row->menu_item_anexo),
		'menu_item_id' => set_value('menu_item_id', $row->menu_item_id),
	    );
            $this->load->view('menu_item_anexo/Menu_item_anexo_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('menu_item_anexo'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('menu_item_anexo','menu_item_anexo','trim|required|max_length[800]');
		$this->form_validation->set_rules('menu_item_id','menu_item_id','trim|required|integer');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('menu_item_anexo_id', TRUE));
        } else {
            $data = array(
		'menu_item_anexo' => empty($this->input->post('menu_item_anexo',TRUE))? NULL : $this->input->post('menu_item_anexo',TRUE), 
		'menu_item_id' => empty($this->input->post('menu_item_id',TRUE))? NULL : $this->input->post('menu_item_id',TRUE), 
	    );

            $this->Menu_item_anexo_model->update($this->input->post('menu_item_anexo_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('menu_item_anexo'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Menu_item_anexo_model->get_by_id($id);

        if ($row) {
            if(@$this->Menu_item_anexo_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('menu_item_anexo'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('menu_item_anexo'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('menu_item_anexo'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('menu_item_anexo', 'menu item anexo', 'trim|required');
	$this->form_validation->set_rules('menu_item_id', 'menu item id', 'trim|required');

	$this->form_validation->set_rules('menu_item_anexo_id', 'menu_item_anexo_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('menu_item_anexo', '=' , $this->input->post('menu_item_anexo',TRUE)),
		 array('menu_item_id', '=' , $this->input->post('menu_item_id',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'menu_item_anexo_data' => $this->Menu_item_anexo_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('menu_item_anexo/Menu_item_anexo_pdf', $data, true);
              

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
                'action'        => site_url('menu_item_anexo/open_pdf'),
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
               
           
            $this->load->view('menu_item_anexo/Menu_item_anexo_report', $data);
        
    }
         

}

/* End of file Menu_item_anexo.php */
/* Local: ./application/controllers/Menu_item_anexo.php */
/* Gerado por RGenerator - 2019-09-25 15:25:49 */