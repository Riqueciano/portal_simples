<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pdf {

    function pdf() {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }

    function load($orientacao = 'P') {
        /* include_once APPPATH.'/third_party/mpdf/mpdf.php'; */
        include_once CPATH . '/util/mpdf_6/mpdf.php';
       

        //if ($params == NULL)
        //{
        //$param = '"en-GB-x","A4","","",10,10,10,10,6,3';   
        $param = '"pt","A4","","",10,10,10,10,6,3,"h"';
        //}

        return new mPDF(
                 'PT'
                , 'A4'
                , ""
                , ""
                , 5/* esquerda */
                , 5/* direita */
                , 7/* topo */
                , 6/* baixo */
                , 2
                , 0
                , $orientacao);
    }
    
    function RReport($param = array()) {
        
        include_once CPATH . '/util/mpdf_6/mpdf.php';
        $orientacao = 'L';

        
        
        //if ($params == NULL)
        //{
        //$param = '"en-GB-x","A4","","",10,10,10,10,6,3';   
        $param = '"pt","A4","","",10,10,10,10,6,3,"h"';
        //}

        return new mPDF(
                'PT'
                , 'A4'
                , ""
                , ""
                , 5/* esquerda */
                , 5/* direita */
                , 7/* topo */
                , 6/* baixo */
                , 2
                , 0
                , 'L'
                
                );
        
        
    }

}

/* Final do Arquivo pdf.php */
/* Local: ./application/libraries/pdf.php */
/* Data -  2016-12-26 10:23:06 */