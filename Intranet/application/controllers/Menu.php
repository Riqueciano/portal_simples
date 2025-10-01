<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador','Gestor','Usuario', 'ascom']);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'menu/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'menu/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'menu/';
            $config['first_url'] = base_url() . 'menu/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Menu_model->total_rows($q);
        $menu = $this->Menu_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'menu_data' => $menu,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('menu/Menu_list', $data);
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Menu_model->get_by_id($id);
        if ($row) {
                    $data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('menu/create_action'),
	    'menu_id' => $row->menu_id   ,
	    'menu_nm' => $row->menu_nm   ,
	    'menu_icon' => $row->menu_icon   ,
	    );
            $this->load->view('menu/Menu_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('menu/create_action'),
	    'menu_id' => set_value('menu_id'),
	    'menu_nm' => set_value('menu_nm'),
	    'menu_icon' => set_value('menu_icon'),
	);
        $this->load->view('menu/Menu_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('menu_nm', NULL,'trim|required|max_length[300]');
		$this->form_validation->set_rules('menu_icon', NULL,'trim|required|max_length[300]');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'menu_nm' => 	 empty($this->input->post('menu_nm',TRUE))? NULL : $this->input->post('menu_nm',TRUE),
		'menu_icon' => 	 empty($this->input->post('menu_icon',TRUE))? NULL : $this->input->post('menu_icon',TRUE),
	    );

            $this->Menu_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('menu'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Menu_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('menu/update_action'),
		'menu_id' => set_value('menu_id', $row->menu_id),
		'menu_nm' => set_value('menu_nm', $row->menu_nm),
		'menu_icon' => set_value('menu_icon', $row->menu_icon),
	    );
            $this->load->view('menu/Menu_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('menu'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('menu_nm','menu_nm','trim|required|max_length[300]');
		$this->form_validation->set_rules('menu_icon','menu_icon','trim|required|max_length[300]');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('menu_id', TRUE));
        } else {
            $data = array(
		'menu_nm' => empty($this->input->post('menu_nm',TRUE))? NULL : $this->input->post('menu_nm',TRUE), 
		'menu_icon' => empty($this->input->post('menu_icon',TRUE))? NULL : $this->input->post('menu_icon',TRUE), 
	    );

            $this->Menu_model->update($this->input->post('menu_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('menu'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Menu_model->get_by_id($id);

        if ($row) {
            if(@$this->Menu_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('menu'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('menu'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('menu'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('menu_nm', 'menu nm', 'trim|required');
	$this->form_validation->set_rules('menu_icon', 'menu icon', 'trim|required');

	$this->form_validation->set_rules('menu_id', 'menu_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('menu_nm', '=' , $this->input->post('menu_nm',TRUE)),
		 array('menu_icon', '=' , $this->input->post('menu_icon',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'menu_data' => $this->Menu_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('menu/Menu_pdf', $data, true);
              

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
                'action'        => site_url('menu/open_pdf'),
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
               
           
            $this->load->view('menu/Menu_report', $data);
        
    }
         

}

/* End of file Menu.php */
/* Local: ./application/controllers/Menu.php */
/* Gerado por RGenerator - 2019-09-25 10:59:23 */