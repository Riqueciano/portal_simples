<?php
//CONTROLE DE P�GINA PARA LIMPAR O FILTRO.
if (!isset($_SESSION['PaginaLocalControle']))
{
    $_SESSION['PaginaLocalControle'] = $PaginaLocal;
}
//SE A P�GINA GRAVADA NA SESSION FOR DIFERENTE DA P�GINA LOCAL IR� LIMPAR O RETORNO DO FILTRO.
if ($_SESSION['PaginaLocalControle'] != $PaginaLocal)
{
    $_SESSION['PaginaLocalControle'] = $PaginaLocal;
    unset($_SESSION['Busca']);
    $RetornoFiltro = NULL;
    //$txtFiltro = NULL;
}
?>