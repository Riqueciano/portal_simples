<?php

//esquema + . + table
$table_name_min_temp = explode('.', $table_name);

//apenas o nome da table
$table_name_min = $table_name_min_temp[1];

$string = "<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class " . $c . " extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        \$this->load->model('$m');
        \$this->load->library('form_validation');
    }";

if ($jenis_tabel == 'reguler_table') {
    
$string .= "\n\n    public function index()
    {
        \$q = urldecode(\$this->input->get('q', TRUE));
        \$start = intval(\$this->input->get('start'));
        
        if (\$q <> '') {
            \$config['base_url']  = base_url() . '$c_url/?q=' . urlencode(\$q);
            \$config['first_url'] = base_url() . '$c_url/?q=' . urlencode(\$q);
            \$this->session->set_flashdata('message', '');
        } else {
            \$config['base_url']  = base_url() . '$c_url/';
            \$config['first_url'] = base_url() . '$c_url/';
        }

        \$config['per_page'] = 10;
        \$config['page_query_string'] = TRUE;
        \$config['total_rows'] = \$this->" . $m . "->total_rows(\$q);
        \$$c_url = \$this->" . $m . "->get_limit_data(\$config['per_page'], \$start, \$q);

        \$this->load->library('pagination');
        \$this->pagination->initialize(\$config);

        \$data = array(
            '" . $c_url . "_data' => \$$c_url,
            'q' => \$q,
            'pagination' => \$this->pagination->create_links(),
            'total_rows' => \$config['total_rows'],
            'start' => \$start,
        );
        \$this->load->view('$c_url/$v_list', \$data);
    }";

} else {
    
$string .="\n\n    public function index()
    {
        \$$c_url = \$this->" . $m . "->get_all();

        \$data = array(
            '" . $c_url . "_data' => \$$c_url
        );

        \$this->load->view('$c_url/$v_list', \$data);
    }";

}
    
$string .= "\n\n    public function read(\$id) 
    {
        \$this->session->set_flashdata('message', '');
        \$row = \$this->" . $m . "->get_by_id(\$id);
        if (\$row) {
                    \$data = array(
            'button' => '',
            'controller' => 'read',
            'action' => site_url('$c_url/create_action'),";
foreach ($all as $row) {
    $string .= "\n\t    '" . $row['column_name'] . "' => \$row->".$row['column_name']."   ,";
}

$string .= "\n\t    );
            \$this->load->view('$c_url/$v_form', \$data);
        } else {
            \$this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('$c_url'));
        }
    }

    public function create() 
    {
        \$data = array(
            'button' => 'Gravar',
            'controller' => 'create',
            'action' => site_url('$c_url/create_action'),";
foreach ($all as $row) {
    $string .= "\n\t    '" . $row['column_name'] . "' => set_value('" . $row['column_name'] . "'),";
}
$string .= "\n\t);
        \$this->load->view('$c_url/$v_form', \$data);
    }
    
    public function create_action() 
    {
        \$this->_rules();";
foreach ($non_pk as $row) {
    /*
    Lista de regras que podem ser utilizadas:
            required: Retorna FALSE se o campo está vazio.
            matches: Retorna FALSE se o campo não tiver o mesmo valor que o campo passado como parâmetro. Utilização: matches[form_item]
            is_unique: Retorna FALSE se o campo não for único na tabela e campo definidos no parâmetro. Utilização: is_unique[tabela.campo]
            min_length: Retorna FALSE se o campo for menor que o número passado como parâmetro. Utilização: min_length[6]
            max_length: Retorna FALSE se o campo for maior que o número passado como parâmetro. Utilização max_length[12]
            exact_length: Retorna FALSE se o campo não for exatamente do mesmo tamanho que o número passado como parâmetro. Utilização: exact_length[8]
            greater_than: Retorna FALSE se o campo for menor que o parâmetro ou não for numérico. Utilização: greater_than[8]
            less_than: Retorna FALSE se o campo for maior que o parâmetro ou não for numérico. Utilização: less_than[8]
            alpha: Retorna FALSE se o campo conter algo além de caracteres do alfabeto.
            alpha_numeric: Retorna FALSE se o campo contém algo além de caracteres alfanuméricos.
            alpha_dash: Retorna FALSE se o campo contém algo além de caracteres alfanuméricos, sublinhados (_) ou traços (-).
            numeric: Retorna FALSE se o campo contém algo além de caracteres numéricos.
            integer: Retorna FALSE se o campo contém algo além de um inteiro.
            decimal: Retorna FALSE se o campo contém algo além de um decimal (ele usa ?.? (ponto) para definir o decimal).
            is_natural: Retorna FALSE se o campo contém algo além de um número natural: 0, 1, 2, 3, etc.
            is_natural_no_zero: Retorna FALSE se o campo contém algo além de um número natural, mas sem o zero: 1, 2, 3, etc.
            valid_email: Retorna FALSE se o campo não contém um endereço de email válido.
            valid_emails: Retorna FALSE se qualquer um dos valores separados por vírgula não for um email válido.
            valid_ip: Retorna FALSE se o IP fornecido não for válido. Aceita um parâmetro opcional para especificar o formato do IP: ?IPv4? ou ?IPv6?.
            valid_base64: Retorna FALSE se a string fornecida contém algo além de carácteres Base64.*/
    if($row['data_type']=='numeric'){
        $data_type = '|numeric';
    }else if($row['data_type']=='integer'){
        $data_type = '|integer';
    }else if($row['data_type']=='decimal' or $row['data_type']=='float'or $row['data_type']== 'double precision'){
        $data_type = '|decimal';
    }else{
        $data_type = '';
    }
    
    if(!empty($row['character_maximum_length'])){
        $max_length = '|max_length['.$row['character_maximum_length'].']';
    }else{
        $max_length = '';
    }
    //echo $row['column_name'].'>>'.$row['data_type'].'>>('.$row['character_maximum_length'].')<br>';//exit;
    
    if($row['is_nullable']=='NO'){
        $required='|required';
    }else{
        $required='';
    }
    
    
    $string .= "\n\t\t\$this->form_validation->set_rules('" . $row['column_name'] . "', NULL,'trim$required" . $data_type . "$max_length');";
}

    $string .= "\n\nif (\$this->form_validation->run() == FALSE) {
            \$this->create();
        } else {
            \$data = array(";
foreach ($non_pk as $row) {
    $string .= "\n\t\t'" . $row['column_name'] . "' => \t empty(\$this->input->post('" . $row['column_name'] . "',TRUE))? NULL : \$this->input->post('" . $row['column_name'] . "',TRUE),";
}
$string .= "\n\t    );

            \$this->".$m."->insert(\$data);
            \$this->session->set_flashdata('message', 'Registro Criado com Sucesso');
            redirect(site_url('$c_url'));
        }
    }
    
    public function update(\$id) 
    {
        \$this->session->set_flashdata('message', '');
        \$row = \$this->".$m."->get_by_id(\$id);

        if (\$row) {
            \$data = array(
                'button' => 'Atualizar',
                'controller' => 'update',
                'action' => site_url('$c_url/update_action'),";
foreach ($all as $row) {
    
    
    $string .= "\n\t\t'" . $row['column_name'] . "' => set_value('" . $row['column_name'] . "', \$row->". $row['column_name']."),";
}
$string .= "\n\t    );
            \$this->load->view('$c_url/$v_form', \$data);
        } else {
            \$this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('$c_url'));
        }
    }
    
    public function update_action() 
    {
        \$this->_rules();";
        
foreach ($non_pk as $row) {
    /*
    Lista de regras que podem ser utilizadas:
            required: Retorna FALSE se o campo está vazio.
            matches: Retorna FALSE se o campo não tiver o mesmo valor que o campo passado como parâmetro. Utilização: matches[form_item]
            is_unique: Retorna FALSE se o campo não for único na tabela e campo definidos no parâmetro. Utilização: is_unique[tabela.campo]
            min_length: Retorna FALSE se o campo for menor que o número passado como parâmetro. Utilização: min_length[6]
            max_length: Retorna FALSE se o campo for maior que o número passado como parâmetro. Utilização max_length[12]
            exact_length: Retorna FALSE se o campo não for exatamente do mesmo tamanho que o número passado como parâmetro. Utilização: exact_length[8]
            greater_than: Retorna FALSE se o campo for menor que o parâmetro ou não for numérico. Utilização: greater_than[8]
            less_than: Retorna FALSE se o campo for maior que o parâmetro ou não for numérico. Utilização: less_than[8]
            alpha: Retorna FALSE se o campo conter algo além de caracteres do alfabeto.
            alpha_numeric: Retorna FALSE se o campo contém algo além de caracteres alfanuméricos.
            alpha_dash: Retorna FALSE se o campo contém algo além de caracteres alfanuméricos, sublinhados (_) ou traços (-).
            numeric: Retorna FALSE se o campo contém algo além de caracteres numéricos.
            integer: Retorna FALSE se o campo contém algo além de um inteiro.
            decimal: Retorna FALSE se o campo contém algo além de um decimal (ele usa ?.? (ponto) para definir o decimal).
            is_natural: Retorna FALSE se o campo contém algo além de um número natural: 0, 1, 2, 3, etc.
            is_natural_no_zero: Retorna FALSE se o campo contém algo além de um número natural, mas sem o zero: 1, 2, 3, etc.
            valid_email: Retorna FALSE se o campo não contém um endereço de email válido.
            valid_emails: Retorna FALSE se qualquer um dos valores separados por vírgula não for um email válido.
            valid_ip: Retorna FALSE se o IP fornecido não for válido. Aceita um parâmetro opcional para especificar o formato do IP: ?IPv4? ou ?IPv6?.
            valid_base64: Retorna FALSE se a string fornecida contém algo além de carácteres Base64.*/
    if($row['data_type']=='numeric'){
        $data_type = '|numeric';
    }else if($row['data_type']=='integer'){
        $data_type = '|integer';
    }else if($row['data_type']=='decimal' or $row['data_type']=='float'or $row['data_type']== 'double precision'){
        $data_type = '|decimal';
    }else{
        $data_type = '';
    }
    
    if(!empty($row['character_maximum_length'])){
        $max_length = '|max_length['.$row['character_maximum_length'].']';
    }else{
        $max_length = '';
    }
    //echo $row['column_name'].'>>'.$row['data_type'].'>>('.$row['character_maximum_length'].')<br>';//exit;
    
    if($row['is_nullable']=='NO'){
        $required='|required';
    }else{
        $required='';
    }
    
    
    $string .= "\n\t\t\$this->form_validation->set_rules('" . $row['column_name'] . "','" . $row['column_name'] . "','trim$required" . $data_type . "$max_length');";
}

     $string .= "\n\nif (\$this->form_validation->run() == FALSE) {
            #echo validation_errors();
            \$this->update(\$this->input->post('$pk', TRUE));
        } else {
            \$data = array(";
foreach ($non_pk as $row) {
    if($row['data_type']=='date'){
        $funcData_ini = "dataToDB(";
        $funcData_fim = ")";
    }else{
        $funcData_ini = "";
        $funcData_fim = "";
    }
    
    $string .= "\n\t\t'" . $row['column_name'] . "' => empty(\$this->input->post('" . $row['column_name'] . "',TRUE))? NULL : \$this->input->post('" . $row['column_name'] . "',TRUE), ";
}    
$string .= "\n\t    );

            \$this->".$m."->update(\$this->input->post('$pk', TRUE), \$data);
            \$this->session->set_flashdata('message', 'Registro Atualizado com Sucesso');
            redirect(site_url('$c_url'));
        }
    }
    
    public function delete(\$id) 
    {
        \$row = \$this->".$m."->get_by_id(\$id);

        if (\$row) {
            if(@\$this->".$m."->delete(\$id)=='erro_dependencia'){
               \$this->session->set_flashdata('message', 'Registro NÃO pode ser deletado por estar sendo utilizado!');
               redirect(site_url('$c_url'));
            }
                

            \$this->session->set_flashdata('message', 'Registro Deletado com Sucesso');
            redirect(site_url('$c_url'));
        } else {
            \$this->session->set_flashdata('message', 'Registro Não Encontrado');
            redirect(site_url('$c_url'));
        }
    }

    public function _rules() 
    {";
foreach ($non_pk as $row) {
    $int = $row3['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? '|numeric' : '';
    $string .= "\n\t\$this->form_validation->set_rules('".$row['column_name']."', '".  strtolower(label($row['column_name']))."', 'trim|required$int');";
}    
$string .= "\n\n\t\$this->form_validation->set_rules('$pk', '$pk', 'trim');";
$string .= "\n\t\$this->form_validation->set_error_delimiters('<span class=\"text-danger\">', '</span>');
    }";

if ($export_excel == '1') {
    $string .= "\n\n    public function excel()
    {
        \$this->load->helper('exportexcel');
        \$namaFile = \"$table_name.xls\";
        \$judul = \"$table_name\";
        \$tablehead = 0;
        \$tablebody = 1;
        \$nourut = 1;
        //penulisan header
        header(\"Pragma: public\");
        header(\"Expires: 0\");
        header(\"Cache-Control: must-revalidate, post-check=0,pre-check=0\");
        header(\"Content-Type: application/force-download\");
        header(\"Content-Type: application/octet-stream\");
        header(\"Content-Type: application/download\");
        header(\"Content-Disposition: attachment;filename=\" . \$namaFile . \"\");
        header(\"Content-Transfer-Encoding: binary \");

        xlsBOF();

        \$kolomhead = 0;
        xlsWriteLabel(\$tablehead, \$kolomhead++, \"No\");";
foreach ($non_pk as $row) {
        $column_name = label($row['column_name']);
        $string .= "\n\txlsWriteLabel(\$tablehead, \$kolomhead++, \"$column_name\");";
}
$string .= "\n\n\tforeach (\$this->" . $m . "->get_limit_data(null) as \$data) {
            \$kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber(\$tablebody, \$kolombody++, \$nourut);";
foreach ($non_pk as $row) {
        $column_name = $row['column_name'];
        $xlsWrite = $row['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? 'xlsWriteNumber' : 'xlsWriteLabel';
        $string .= "\n\t    " . $xlsWrite . "(\$tablebody, \$kolombody++, \$data->$column_name);";
}
$string .= "\n\n\t    \$tablebody++;
            \$nourut++;
        }

        xlsEOF();
        exit();
    }";
}

if ($export_word == '1') {
    $string .= "\n\n    public function word()
    {
        header(\"Content-type: application/vnd.ms-word\");
        header(\"Content-Disposition: attachment;Filename=$table_name.doc\");

        \$data = array(
            '" . $table_name . "_data' => \$this->" . $m . "->get_limit_data(null),
            'start' => 0
        );
        
        \$this->load->view('" . $c_url ."/". $v_doc . "',\$data);
    }";
}

if ($export_pdf == '1') {
    $string .= "\n\n    function pdf()
    {
        \$data = array(
            '" . $table_name . "_data' => \$this->" . $m . "->get_limit_data(null),
            'start' => 0
        );
        
        ini_set('memory_limit', '32M');
        \$html = \$this->load->view('" . $c_url ."/". $v_pdf . "', \$data, true);
        \$this->load->library('pdf');
        \$pdf = \$this->pdf->load();
        \$pdf->WriteHTML(\$html);
        \$pdf->Output('" . $table_name . ".pdf', 'D'); 
    }";
}




#################
#controler q abre o o pdf
$string .=" 
            public function open_pdf(){

                    \$param = array(
         ";
foreach ($non_pk as $row) {
    $string .= "\n\t\t array('" . $row['column_name'] . "', '=' , \$this->input->post('" . $row['column_name'] . "',TRUE)),";
}
$string .="  );//end array dos parametros
         ";

$string .=" 
              \$data = array(
                    '" . $table_name_min . "_data' => \$this->" . $m . "->get_all_data(\$param),
                'start' => 0
        );
            //limite de memoria do pdf atual
            ini_set('memory_limit', '64M');
            

          \$html =  \$this->load->view('$c_url/$v_pdf', \$data, true);
              

          \$formato = \$this->input->post('formato', TRUE); 
          \$nome_arquivo = 'arquivo';
          if(rupper(\$formato) == 'EXCEL'){
                     \$pdf = \$this->pdf->excel(\$html, \$nome_arquivo); 
          }        

           \$this->load->library('pdf');
           \$pdf = \$this->pdf->RReport();
           
            \$caminhoImg = CPATH . 'imagens/Topo/bg_logo_min.png';
            
            //cabeçalho
            \$pdf->SetHeader(\" 
                <table border=0 class=table style='font-size:12px'>
                    <tr>
                        <td rowspan=2><img src='\$caminhoImg'></td> 
                        <td>Governo do Estado da Bahia<br>
                            Secretaria do Meio Ambiente - SEMA</td> 
                    </tr>     
                </table>    
                 \",'O',true);
        

                \$pdf->WriteHTML(utf8_encode(\$html));    
                \$pdf->SetFooter(\"{DATE j/m/Y H:i}|{PAGENO}/{nb}|\" . utf8_encode('Nome do Sistema') . \"|\");
                
                \$pdf->Output('recurso.recurso.pdf', 'I');

         ";
 $string .=" }";

############################
//controler que chama a pagina da consulta do relatorio

$string .=" 
        
public function report() {
        
            \$data = array(
                'button'        => 'Gerar',
                'controller'    => 'report',
                'action'        => site_url('$c_url/open_pdf'),
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
               
           
            \$this->load->view('$c_url/$v_report', \$data);
        
    }
         ";



$string .= "\n\n}\n\n/* End of file $c_file */
/* Local: ./application/controllers/$c_file */
/* Gerado por RGenerator - ".date('Y-m-d H:i:s')." */";






$hasil_controller = createFile($string, $target . "controllers/" . $c_file);

?>