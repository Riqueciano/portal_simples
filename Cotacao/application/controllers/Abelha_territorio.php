<?php

// if (!defined('BASEPATH'))
//     exit('No direct script access allowed');

// class Abelha_territorio extends CI_Controller
// {
//     function __construct()
//     {
//         parent::__construct();
//         $this->load->model('Abelha_territorio_model'); 
// $this->load->model('Abelha_model'); 

// $this->load->model('Territorio_model'); 
//   $this->load->library('form_validation');
//     }
    

//     public function index()
//     {   
//         PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
//         $q = urldecode($this->input->get('q', TRUE));
//         $format = urldecode($this->input->get('format', TRUE));
//         $start = (int)$this->input->get('start');
        
         

//         $config['per_page'] = 30;
//         $config['page_query_string'] = TRUE;
//         $config['total_rows'] = $this->Abelha_territorio_model->total_rows($q);
//         $abelha_territorio = $this->Abelha_territorio_model->get_limit_data($config['per_page'], $start, $q);

//         ## para retorno json no front
//         if($format == 'json'){
//             echo json($abelha_territorio);
//             exit;
//         }

//         $this->load->library('pagination');
//         $this->pagination->initialize($config);

//         $data = array(
//             'abelha_territorio_data' => json($abelha_territorio),
//             'q' => $q,
//             'format' => $format,
//             'pagination' => $this->pagination->create_links(),
//             'total_rows' => $config['total_rows'],
//             'start' => $start,
//         );
//         $this->load->view('abelha_territorio/Abelha_territorio_list', forFrontVue($data));
//     }

//     public function read($id) 
//     {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
//         $this->session->set_flashdata('message', '');
//         $row = $this->Abelha_territorio_model->get_by_id($id); $abelha = $this->Abelha_model->get_all_combobox(); $territorio = $this->Territorio_model->get_all_combobox();   if ($row) {
//                     $data = array(
//                         'abelha' => json($abelha),	'territorio' => json($territorio),	 
//                         'button' => '',
//                         'controller' => 'read',
//                         'action' => site_url('abelha_territorio/create_action'),
// 	    'abelha_territorio_id' => $row->abelha_territorio_id   ,
// 	    'abelha_id' => $row->abelha_id   ,
// 	    'territorio_id' => $row->territorio_id   ,
// 	    );
//             $this->load->view('abelha_territorio/Abelha_territorio_form', forFrontVue($data));
//         } else {
//             $this->session->set_flashdata('message', 'Record Not Found');
//             redirect(site_url('abelha_territorio'));
//         }
//     }

//     public function create() 
//     {    PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);$abelha = $this->Abelha_model->get_all_combobox(); $territorio = $this->Territorio_model->get_all_combobox(); $data = array(
//             'abelha' => json($abelha),	'territorio' => json($territorio),	
//             'button' => 'Gravar',
//             'controller' => 'create',
//             'action' => site_url('abelha_territorio/create_action'),
// 	    'abelha_territorio_id' => set_value('abelha_territorio_id'),
// 	    'abelha_id' => set_value('abelha_id'),
// 	    'territorio_id' => set_value('territorio_id'),
// 	);
//         $this->load->view('abelha_territorio/Abelha_territorio_form', forFrontVue($data));
//     }
    
//     public function create_action() 
//     {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
//         $this->_rules();
// 		$this->form_validation->set_rules('abelha_id', NULL,'trim|required|integer');
// 		$this->form_validation->set_rules('territorio_id', NULL,'trim|required|integer');

// if ($this->form_validation->run() == FALSE) {
//             $this->create();
//         } else {
//             $data = array(
// 		'abelha_id' => 	 empty($this->input->post('abelha_id',TRUE))? NULL : $this->input->post('abelha_id',TRUE),
// 		'territorio_id' => 	 empty($this->input->post('territorio_id',TRUE))? NULL : $this->input->post('territorio_id',TRUE),
// 	    );

//             $this->Abelha_territorio_model->insert($data);
//             $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
//             redirect(site_url('abelha_territorio'));
//         }
//     }
    
//     public function update($id) 
//     {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
//         $this->session->set_flashdata('message', '');
//         $row = $this->Abelha_territorio_model->get_by_id($id);
//   $abelha = $this->Abelha_model->get_all_combobox(); $territorio = $this->Territorio_model->get_all_combobox();   if ($row) {
//             $data = array(
//                 'abelha' => json($abelha),'territorio' => json($territorio),
//                 'button' => 'Atualizar',
//                 'controller' => 'update',
//                 'action' => site_url('abelha_territorio/update_action'),
// 		'abelha_territorio_id' => set_value('abelha_territorio_id', $row->abelha_territorio_id),
// 		'abelha_id' => set_value('abelha_id', $row->abelha_id),
// 		'territorio_id' => set_value('territorio_id', $row->territorio_id),
// 	    );
//             $this->load->view('abelha_territorio/Abelha_territorio_form', forFrontVue($data));
//         } else {
//             $this->session->set_flashdata('message', 'Registro Não Encontrado');
//             redirect(site_url('abelha_territorio'));
//         }
//     }
    
//     public function update_action() 
//     {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
//         $this->_rules();
// 		$this->form_validation->set_rules('abelha_id','abelha_id','trim|required|integer');
// 		$this->form_validation->set_rules('territorio_id','territorio_id','trim|required|integer');

// if ($this->form_validation->run() == FALSE) {
//             #echo validation_errors();
//             $this->update($this->input->post('abelha_territorio_id', TRUE));
//         } else {
//             $data = array(
// 		'abelha_id' => empty($this->input->post('abelha_id',TRUE))? NULL : $this->input->post('abelha_id',TRUE), 
// 		'territorio_id' => empty($this->input->post('territorio_id',TRUE))? NULL : $this->input->post('territorio_id',TRUE), 
// 	    );

//             $this->Abelha_territorio_model->update($this->input->post('abelha_territorio_id', TRUE), $data);
//             $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
//             redirect(site_url('abelha_territorio'));
//         }
//     }
    
//     public function delete($id) 
//     {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
//         $row = $this->Abelha_territorio_model->get_by_id($id);

//         if ($row) {
//             if(@$this->Abelha_territorio_model->delete($id)=='erro_dependencia'){
//                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
//                redirect(site_url('abelha_territorio'));
//             }
                

//             $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
//             redirect(site_url('abelha_territorio'));
//         } else {
//             $this->session->set_flashdata('message', 'Registro Não Encontrado');
//             redirect(site_url('abelha_territorio'));
//         }
//     }

//     public function _rules() 
//     { PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
// 	$this->form_validation->set_rules('abelha_id', 'abelha id', 'trim|required');
// 	$this->form_validation->set_rules('territorio_id', 'territorio id', 'trim|required');

// 	$this->form_validation->set_rules('abelha_territorio_id', 'abelha_territorio_id', 'trim');
// 	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
//     } 
//             public function open_pdf(){
//                 PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);

//                     $param = array(
         
// 		 array('abelha_id', '=' , $this->input->post('abelha_id',TRUE)),
// 		 array('territorio_id', '=' , $this->input->post('territorio_id',TRUE)),  );//end array dos parametros
          
//               $data = array(
//                     'abelha_territorio_data' => $this->Abelha_territorio_model->get_all_data($param),
//                 'start' => 0
//         );
//             //limite de memoria do pdf atual
//             ini_set('memory_limit', '64M');
            

//           $html =  $this->load->view('abelha_territorio/Abelha_territorio_pdf', $data, true);
              

//           $formato = $this->input->post('formato', TRUE); 
//           $nome_arquivo = 'arquivo';
//           if(rupper($formato) == 'EXCEL'){
//                      $pdf = $this->pdf->excel($html, $nome_arquivo); 
//           }        

//            $this->load->library('pdf');
//            $pdf = $this->pdf->RReport();
           
//             $caminhoImg = CPATH . 'imagens/Topo/bg_logo_min.png';
            
//             //cabeçalho
//             $pdf->SetHeader(" 
//                 <table border=0 class=table style='font-size:12px'>
//                     <tr>
//                         <td rowspan=2><img src='$caminhoImg'></td> 
//                         <td>Governo do Estado da Bahia<br>
//                             Secretaria do Meio Ambiente - SEMA</td> 
//                     </tr>     
//                 </table>    
//                  ",'O',true);
        

//                 $pdf->WriteHTML(utf8_encode($html));    
//                 $pdf->SetFooter("{DATE j/m/Y H:i}|{PAGENO}/{nb}|" . utf8_encode('Nome do Sistema') . "|");
                
//                 $pdf->Output('recurso.recurso.pdf', 'I');

//           } 
        
// public function report() {
//     PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
        
//             $data = array(
//                 'button'        => 'Gerar',
//                 'controller'    => 'report',
//                 'action'        => site_url('abelha_territorio/open_pdf'),
//                 'recurso_id'    => null,
//                 'recurso_nm'    => null,
//                 'recurso_tombo' => null,
//                 'conservacao_id'=> null,
//                 'setaf_id'      => null,
//                 'localizacao'   => null,
//                 'municipio_id'  => null,
//                 'caminho'       => null,
//                 'documento_id'  => null,
//                 'requerente_id' => null,
//                 );
               
           
//             $this->load->view('abelha_territorio/Abelha_territorio_report', forFrontVue($data));
        
//     }
         

// }

/* End of file Abelha_territorio.php */
/* Local: ./application/controllers/Abelha_territorio.php */
/* Gerado por RGenerator - 2024-10-02 19:52:37 */