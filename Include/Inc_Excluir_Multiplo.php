<?php
/*******************************************************************************
 Copyright 2012 SEMA - Secretaria do Meio Ambiente - Bahia. All Rights Reserved.
 @author danillobs@gmail.com (Danillo Barreto)
*******************************************************************************/
/*******************************************************************************
   FUN��O QUE CRIA A VARI�VEL CONTENDO OS ID�S DAS TUPLAS QUE SER�O EXCLU�DAS
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
    $_SESSION['excluirMultiplosCod'] = $CodigosArray; //Passando o array por session para realiza��o do UPDATE
}
?>