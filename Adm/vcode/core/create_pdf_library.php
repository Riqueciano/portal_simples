<?php 

$string = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class pdf {
    
    function pdf()
    {
        \$CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load(\$param=NULL)
    {
        /*include_once APPPATH.'/third_party/mpdf/mpdf.php';*/
         include_once CPATH.'/util/mpdf_6/mpdf.php';
         $orientacao           = 'L';
         
        //if (\$params == NULL)
        //{
            //\$param = '\"en-GB-x\",\"A4\",\"\",\"\",10,10,10,10,6,3';   
             \$param = '\"pt\",\"A4\",\"\",\"\",10,10,10,10,6,3,\"h\"';   
        //}
         
        return new mPDF(\$param);
    }
}


/* Final do Arquivo pdf.php */
/* Local: ./application/libraries/pdf.php */
/* Data -  ".date('Y-m-d H:i:s')." */";



$hasil_pdf = createFile($string, $target."libraries/pdf.php");

?>