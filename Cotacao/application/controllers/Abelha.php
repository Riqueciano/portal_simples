<?php

// if (!defined('BASEPATH'))
//     exit('No direct script access allowed');

// class Abelha extends CI_Controller
// {
//     function __construct()
//     {
//         parent::__construct();
//         $this->load->model('Abelha_model'); 
// $this->load->model('Abelha_genero_model'); 
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
//         $config['total_rows'] = $this->Abelha_model->total_rows($q);
//         $abelha = $this->Abelha_model->get_limit_data($config['per_page'], $start, $q);

//         ## para retorno json no front
//         if($format == 'json'){
//             echo json($abelha);
//             exit;
//         }

//         $this->load->library('pagination');
//         $this->pagination->initialize($config);

//         $data = array(
//             'abelha_data' => json($abelha),
//             'q' => $q,
//             'format' => $format,
//             'pagination' => $this->pagination->create_links(),
//             'total_rows' => $config['total_rows'],
//             'start' => $start,
//         );
//         $this->load->view('abelha/Abelha_list', forFrontVue($data));
//     }

//     public function read($id) 
//     {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
//         $this->session->set_flashdata('message', '');
//         $row = $this->Abelha_model->get_by_id($id); $abelha_genero = $this->Abelha_genero_model->get_all_combobox();   if ($row) {
//                     $data = array(
//                         'abelha_genero' => json($abelha_genero),	 
//                         'button' => '',
//                         'controller' => 'read',
//                         'action' => site_url('abelha/create_action'),
// 	    'abelha_id' => $row->abelha_id   ,
// 	    'abelha_nm' => $row->abelha_nm   ,
// 	    'referencia' => $row->referencia   ,
// 	    'abelha_genero_id' => $row->abelha_genero_id   ,
// 	    );
//             $this->load->view('abelha/Abelha_form', forFrontVue($data));
//         } else {
//             $this->session->set_flashdata('message', 'Record Not Found');
//             redirect(site_url('abelha'));
//         }
//     }

//     public function create() 
//     {    PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);$abelha_genero = $this->Abelha_genero_model->get_all_combobox(); $data = array(
//             'abelha_genero' => json($abelha_genero),	
//             'button' => 'Gravar',
//             'controller' => 'create',
//             'action' => site_url('abelha/create_action'),
// 	    'abelha_id' => set_value('abelha_id'),
// 	    'abelha_nm' => set_value('abelha_nm'),
// 	    'referencia' => set_value('referencia'),
// 	    'abelha_genero_id' => set_value('abelha_genero_id'),
// 	);
//         $this->load->view('abelha/Abelha_form', forFrontVue($data));
//     }
    
//     public function create_action() 
//     {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
//         $this->_rules();
// 		$this->form_validation->set_rules('abelha_nm', NULL,'trim|required|max_length[150]');
// 		$this->form_validation->set_rules('referencia', NULL,'trim|max_length[100]');
// 		$this->form_validation->set_rules('abelha_genero_id', NULL,'trim|required|integer');

// if ($this->form_validation->run() == FALSE) {
//             $this->create();
//         } else {
//             $data = array(
// 		'abelha_nm' => 	 empty($this->input->post('abelha_nm',TRUE))? NULL : $this->input->post('abelha_nm',TRUE),
// 		'referencia' => 	 empty($this->input->post('referencia',TRUE))? NULL : $this->input->post('referencia',TRUE),
// 		'abelha_genero_id' => 	 empty($this->input->post('abelha_genero_id',TRUE))? NULL : $this->input->post('abelha_genero_id',TRUE),
// 	    );

//             $this->Abelha_model->insert($data);
//             $this->session->set_flashdata('message', 'Registro Criado com Sucesso');
//             redirect(site_url('abelha'));
//         }
//     }
    
//     public function update($id) 
//     {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
//         $this->session->set_flashdata('message', '');
//         $row = $this->Abelha_model->get_by_id($id);
//   $abelha_genero = $this->Abelha_genero_model->get_all_combobox();   if ($row) {
//             $data = array(
//                 'abelha_genero' => json($abelha_genero),
//                 'button' => 'Atualizar',
//                 'controller' => 'update',
//                 'action' => site_url('abelha/update_action'),
// 		'abelha_id' => set_value('abelha_id', $row->abelha_id),
// 		'abelha_nm' => set_value('abelha_nm', $row->abelha_nm),
// 		'referencia' => set_value('referencia', $row->referencia),
// 		'abelha_genero_id' => set_value('abelha_genero_id', $row->abelha_genero_id),
// 	    );
//             $this->load->view('abelha/Abelha_form', forFrontVue($data));
//         } else {
//             $this->session->set_flashdata('message', 'Registro Não Encontrado');
//             redirect(site_url('abelha'));
//         }
//     }
    
//     public function update_action() 
//     {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
//         $this->_rules();
// 		$this->form_validation->set_rules('abelha_nm','abelha_nm','trim|required|max_length[150]');
// 		$this->form_validation->set_rules('referencia','referencia','trim|max_length[100]');
// 		$this->form_validation->set_rules('abelha_genero_id','abelha_genero_id','trim|required|integer');

// if ($this->form_validation->run() == FALSE) {
//             #echo validation_errors();
//             $this->update($this->input->post('abelha_id', TRUE));
//         } else {
//             $data = array(
// 		'abelha_nm' => empty($this->input->post('abelha_nm',TRUE))? NULL : $this->input->post('abelha_nm',TRUE), 
// 		'referencia' => empty($this->input->post('referencia',TRUE))? NULL : $this->input->post('referencia',TRUE), 
// 		'abelha_genero_id' => empty($this->input->post('abelha_genero_id',TRUE))? NULL : $this->input->post('abelha_genero_id',TRUE), 
// 	    );

//             $this->Abelha_model->update($this->input->post('abelha_id', TRUE), $data);
//             $this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
//             redirect(site_url('abelha'));
//         }
//     }
    
//     public function delete($id) 
//     {   PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
//         $row = $this->Abelha_model->get_by_id($id);

//         if ($row) {
//             if(@$this->Abelha_model->delete($id)=='erro_dependencia'){
//                $this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
//                redirect(site_url('abelha'));
//             }
                

//             $this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
//             redirect(site_url('abelha'));
//         } else {
//             $this->session->set_flashdata('message', 'Registro Não Encontrado');
//             redirect(site_url('abelha'));
//         }
//     }

//     public function _rules() 
//     { PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);
// 	$this->form_validation->set_rules('abelha_nm', 'abelha nm', 'trim|required');
// 	$this->form_validation->set_rules('referencia', 'referencia', 'trim|required');
// 	$this->form_validation->set_rules('abelha_genero_id', 'abelha genero id', 'trim|required');

// 	$this->form_validation->set_rules('abelha_id', 'abelha_id', 'trim');
// 	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
//     } 
//             public function open_pdf(){
//                 PROTECAO_PERFIL(['Administrador','Gestor','Usuario']);

//                     $param = array(
         
// 		 array('abelha_nm', '=' , $this->input->post('abelha_nm',TRUE)),
// 		 array('referencia', '=' , $this->input->post('referencia',TRUE)),
// 		 array('abelha_genero_id', '=' , $this->input->post('abelha_genero_id',TRUE)),  );//end array dos parametros
          
//               $data = array(
//                     'abelha_data' => $this->Abelha_model->get_all_data($param),
//                 'start' => 0
//         );
//             //limite de memoria do pdf atual
//             ini_set('memory_limit', '64M');
            

//           $html =  $this->load->view('abelha/Abelha_pdf', $data, true);
              

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
//                 'action'        => site_url('abelha/open_pdf'),
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
               
           
//             $this->load->view('abelha/Abelha_report', forFrontVue($data));
        
//     }
         

// }

/* End of file Abelha.php */
/* Local: ./application/controllers/Abelha.php */
/* Gerado por RGenerator - 2024-10-02 19:28:28 */