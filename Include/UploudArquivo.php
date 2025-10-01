<?php

class UploadArquivo {

    private $arquivo;
    private $tamanho;
    private $formato;
    private $formatoText;
    private $id;
    private $destino;
    private $tamParamMax;
    //upload_multiplo
    private $name;
    private $type;
    private $tmp_name;
    private $error;
    private $size;

    public function __construct() {
        
    }

    public function upload($arquivo, $caminho, $titulo = null, $tamParamMax = null, $extencao = null) {

        
        
        //echo $codContrato ."--".$codModifContrato;exit;
        //generico*********************************************************************************************
        $arquivo1   = $arquivo;
        $temp       = $arquivo1['tmp_name'];
        $type       = $arquivo1['type'];
//echo $type;exit;
        //define a extensão do arquivo  
           switch ($type) {
            case 'application/vnd.ms-excel':
                $tipo = '.xls';
                break;
            case 'vnd.openxmlformats-officedocument.wordprocessingml.document':
                $tipo = '.docx';
                break;
            case 'application/msword':
                $tipo = '.doc';
                break;
            case 'application/pdf':
                $tipo = '.pdf';
                break;
            default:
                $tipo = '.png';
                break;
            }
        //valida apenas se o parametro for passado #legado
        if (!empty($extencao)) {
            //valida se o contrato está no formato PDF
            if ('.'.rupper($extencao) != rupper($tipo)) {
                $msg = "[Erro] Escolha um arquivo no formato " .rupper($extencao) . "!";
                echo "<script> 
                            window.alert('$msg'); 
                            //volta pagina
                            javascript:history.back(1);
                         </script>";
                exit;
            }
        }

        //print_r($_FILES['obra_arquivo']['type']);exit;
        
        
        
        //define o tamanho maximo
        if (empty($tamParamMax)) {
            $tamanhoMax = 1024 * 1024 * 80; // 20Mb
        } else {
            $tamanhoMax = 1024 * 1024 * (int) $tamParamMax;
        }
        //valida o tamanho do anexo
        //echo $tamanhoMax.'<'.$arquivo1['size'];exit;
        if (intval($arquivo1['size']) > $tamanhoMax) {
            return "[Erro] Tamanho excedido, limite de 80MB!";
            exit;
        }

        //echo 1;exit;
        $arquivo_minusculo = strtolower($arquivo1['name']);
        $caracteres = array("ç", "~", "^", "]", "[", "{", "}", ";", ":", "´", ",", ">", "<", "-", "/", "|", "@", "$", "%", "ã", "â", "á", "à", "é", "è", "ó", "ò", "+", "=", "*", "&", "(", ")", "!", "#", "?", "`", "ã", " ", "©");
        $arquivo_tratado = str_replace($caracteres, "", $arquivo_minusculo);
        //****************************************************************************************************
        //upload de contrato

        if (!(empty($arquivo))) { 
            //arquivo
            $nomeArquivo = $titulo . '-' . date('d-m-Y-H-i-s') . $tipo;
            //caminho
            $destino = $caminho . $nomeArquivo;

            //$destino = "saasas";
            if (move_uploaded_file($arquivo1['tmp_name'], $destino)) {
                echo "<script>window.alert('Arquivo enviado com sucesso.');</script>";
            } else {
                echo "<script>window.alert('Erro ao enviar o arquivo');</script>";
            }
        }

        return $nomeArquivo;
    }
    
    
    public function upload_multiplo($name = null
                                    , $type = null
                                    , $tmp_name = null
                                    , $error = null
                                    , $size = null
                                    , $caminho
                                    , $titulo = null
                                    , $tamParamMax = null
                                    , $extencao = null) { 

        
        
        //echo $codContrato ."--".$codModifContrato;exit;
        //generico*********************************************************************************************
       
        $temp = $tmp_name;

        //define a extensão do arquivo  
         switch ($type) {
            case 'application/vnd.ms-excel':
                $tipo = '.xls';
                break;
            case 'vnd.openxmlformats-officedocument.wordprocessingml.document':
                $tipo = '.docx';
                break;
            case 'application/msword':
                $tipo = '.doc';
                break;
            case 'application/pdf':
                $tipo = '.pdf';
                break;
            default:
                $tipo = '.png';
                break;
            }
            
        //valida apenas se o parametro for passado #legado
        if (!empty($extencao)) {
            //valida se o contrato está no formato PDF
            if ('.'.rupper($extencao) != rupper($tipo)) {
                $msg = "[Erro] Escolha um arquivo no formato " .rupper($extencao) . "!";
                echo "<script> 
                            window.alert('$msg'); 
                            //volta pagina
                            javascript:history.back(1);
                         </script>";
                exit;
            }
        }

        //print_r($_FILES['obra_arquivo']['type']);exit;
        
        
        //echo 1;
        //define o tamanho maximo
        if (empty($tamParamMax)) {
            $tamanhoMax = 1024 * 1024 * 80; // 20Mb
        } else {
            $tamanhoMax = 1024 * 1024 * (int) $tamParamMax;
        }
        //valida o tamanho do anexo
        //echo $tamanhoMax.'<'.$arquivo1['size'];exit;
        if (intval($size) > $tamanhoMax) {
            return "[Erro] Tamanho excedido, limite de 80MB!";
            exit;
        }

        
        //echo 1;
        $arquivo_minusculo = strtolower($name);
        $caracteres = array("ç", "~", "^", "]", "[", "{", "}", ";", ":", "´", ",", ">", "<", "-", "/", "|", "@", "$", "%", "ã", "â", "á", "à", "é", "è", "ó", "ò", "+", "=", "*", "&", "(", ")", "!", "#", "?", "`", "ã", " ", "©");
        $arquivo_tratado = str_replace($caracteres, "", $arquivo_minusculo);
        //****************************************************************************************************
        //upload de contrato

        if (!(empty($name))) { //echo $name;
            //arquivo
            $nomeArquivo = $titulo . '-' . date('d-m-Y-H-i-s') . $tipo;
            //caminho
            $destino = $caminho . $nomeArquivo;

            //$destino = "saasas";
            if (move_uploaded_file($tmp_name, $destino)) {
                //echo "<script>window.alert('Arquivo enviado com sucesso.');</script>";
            } else {
                echo "<script>window.alert('Erro ao enviar o arquivo');</script>";
            }
        }
//exit;
        return $nomeArquivo;
    }

}


