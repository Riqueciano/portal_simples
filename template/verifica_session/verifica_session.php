<?php


if(empty($_SESSION['pessoa_id']) and $validar_pagina == true){
    $retorno =  'session_vazia';exit;
}else{
    $retorno =  'ok';
}

if(empty($_SESSION['est_organizacional_id'])){
    $retorno =  'session_vazia';exit;
}else{
    $retorno =  'ok';
}
//$retorno =  'session_vazia';
//$retorno =  'session_vazia';
echo $retorno;