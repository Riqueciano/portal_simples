<?php
/*******************************************************************************
 Copyright 2012 SEMA - Secretaria do Meio Ambiente - Bahia. All Rights Reserved.
 @author danillobs@gmail.com (Danillo Barreto)
*******************************************************************************/
/*******************************************************************************
   FUNÇÃO QUE CRIA A VARIÁVEL CONTENDO OS ID´S DAS TUPLAS QUE SERÃO EXCLUÍDAS
*******************************************************************************/
function f_ExclusaoMultipla ()
{
    $CodigosArray = "'";
    $i=0;

    while($i < $_GET["qtdcheckbox"])
    {
        if (isset($_GET["checkbox".$i])) // VERIFICA SE O CHECKBOX ESTA MARCADO
        {
            $CodigosArray .= $_GET["checkbox".$i] . "','";
        }
        $i++;
    }
    
    $CodigosArray = substr($CodigosArray, 0, (strlen($CodigosArray)-2));
    $_SESSION['excluirMultiplosCod'] = $CodigosArray; //Passando o array por session para realização do UPDATE
}
?>