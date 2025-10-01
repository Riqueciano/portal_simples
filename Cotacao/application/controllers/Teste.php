<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teste extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Teste_model');   $this->load->library('form_validation');
        PROTECAO_PERFIL(['Administrador', 'Gestor', 'Usuario', 'Solicitante', 'Fornecedor', 'Comprador', 'Tecnico/Consultor', 'Nutricionista']);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $format = urldecode($this->input->get('format', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . 'teste/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'teste/?q=' . urlencode($q);
            $this->session->set_flashdata('message', '');
        } else {
            $config['base_url']  = base_url() . 'teste/';
            $config['first_url'] = base_url() . 'teste/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Teste_model->total_rows($q);
        $teste = $this->Teste_model->get_limit_data($config['per_page'], $start, $q);

        ## para retorno json no front
        if($format == 'json'){
            echo json($teste);
            exit;
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'teste_data' => json($teste),
            'q' => $q,
            'format' => $format,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('teste/Teste_list', forFrontVue($data));
    }

    public function read($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Teste_model->get_by_id($id);   if ($row) {
                    $data = array(
                         
                        'button' => '',
                        'controller' => 'read',
                        'action' => site_url('teste/create_action'),
	    'teste_id' => $row->teste_id   ,
	    'teste_nm' => $row->teste_nm   ,
	    );
            $this->load->view('teste/Teste_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('teste'));
        }
    }

    public function create() 
    {$data = array(
            
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('teste/create_action'),
	    'teste_id' => set_value('teste_id'),
	    'teste_nm' => set_value('teste_nm'),
	);
        $this->load->view('teste/Teste_form', forFrontVue($data));
    }
    
    public function create_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('teste_nm', NULL,'trim|max_length[100]');

if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'teste_nm' => 	 empty($this->input->post('teste_nm',TRUE))? NULL : $this->input->post('teste_nm',TRUE),
	    );

            $this->Teste_model->insert($data);
            $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('teste'));
        }
    }
    
    public function update($id) 
    {
        $this->session->set_flashdata('message', '');
        $row = $this->Teste_model->get_by_id($id);
    if ($row) {
            $data = array(
                
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('teste/update_action'),
		'teste_id' => set_value('teste_id', $row->teste_id),
		'teste_nm' => set_value('teste_nm', $row->teste_nm),
	    );
            $this->load->view('teste/Teste_form', forFrontVue($data));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('teste'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
		$this->form_validation->set_rules('teste_nm','teste_nm','trim|max_length[100]');

if ($this->form_validation->run() == FALSE) {
            #echo validation_errors();
            $this->update($this->input->post('teste_id', TRUE));
        } else {
            $data = array(
		'teste_nm' => empty($this->input->post('teste_nm',TRUE))? NULL : $this->input->post('teste_nm',TRUE), 
	    );

            $this->Teste_model->update($this->input->post('teste_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('teste'));
        }
    }
    
    /*
    public function delete($id) 
    {
        $row = $this->Teste_model->get_by_id($id);

        if ($row) {
            if(@$this->Teste_model->delete($id)=='erro_dependencia'){
               $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('teste'));
            }
                

            $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('teste'));
        } else {
            $this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('teste'));
        }
    }
    */

    public function _rules() 
    {
	$this->form_validation->set_rules('teste_nm', 'teste nm', 'trim|required');

	$this->form_validation->set_rules('teste_id', 'teste_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    } 
            public function open_pdf(){

                    $param = array(
         
		 array('teste_nm', '=' , $this->input->post('teste_nm',TRUE)),  );//end array dos parametros
          
              $data = array(
                    'teste_data' => $this->Teste_model->get_all_data($param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          $html =  $this->load->view('teste/Teste_pdf', $data, true);
              

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
                'action'        => site_url('teste/open_pdf'),
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
               
           
            $this->load->view('teste/Teste_report', forFrontVue($data));
        
    }
         

}

/* End of file Teste.php */
/* Local: ./application/controllers/Teste.php */
/* Gerado por RGenerator - 2024-01-17 19:31:41 */