<?php
/*******************************************************************************
 Copyright 2011 SEMA - Secretaria do Meio Ambiente - Bahia. All Rights Reserved.
 *******************************************************************************/
//CAPTURA A ORDENA��O
if(isset($_GET['order'])){$order = $_GET['order'];} else {$order = 1;}
$OrderBy = '';

//VERIFICA E CAPTURA O TIPO DE ORDENA��O (CRESCENTE E DECRESCENTE)
if(isset($_GET['typeOrder'])){$typeOrder = $_GET['typeOrder'];}
else {$typeOrder = 0;}
if ($typeOrder == 0){$OrderBy = $OrderBy.' ASC';$typeOrder = 1;}
else if ($typeOrder == 1){$OrderBy = $OrderBy.' DESC';$typeOrder = 0;}

//CAPTURA O TIPO DE SETA
if ($typeOrder == 0){$seta = 'esconde_filtro';}
else if ($typeOrder == 1){$seta = 'esconde_filtro2';}
?>