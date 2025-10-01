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
            // include_once CPATH . '/util/mpdf_6/mpdf.php';
            include_once '../util/mpdf_6/mpdf.php';
            
            
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
            
            function excel($html = '', $nome_arquivo = 'arquivo') {
                $excel = "";
                $arquivo = str_replace(' ', '_', $nome_arquivo) . date("d-m-Y") . '.xls';
                ## Configurações header para forçar o download
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: application/x-msexcel");
                header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
                header("Content-Description: PHP Generated Data");
                $excel .= $html;
                echo $excel;
                exit;
            }
            
            function RReport($orientacao = 'P') {
                
                // include_once CPATH . '/util/mpdf_6/mpdf.php';
                include_once '../util/mpdf/src/mpdf.php';
                
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
                        , 17/* topo */
                        , 6/* baixo */
                        , 2
                        , 0
                        , $orientacao
                        );
                }
                
            
            function RReportMin($orientacao = 'P') {
                
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
                        , 15/* esquerda */
                        , 15/* direita */
                        , 17/* topo */
                        , 6/* baixo */
                        , 2
                        , 0
                        , $orientacao
                        );
                }
                
            }
            
            /* Final do Arquivo pdf.php */
            /* Local: ./application/libraries/pdf.php */
            /* Data -  2016-12-26 10:23:06 */