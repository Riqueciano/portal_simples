<?php
//CONTROLE DE P핯INA PARA LIMPAR O FILTRO.
if (!isset($_SESSION['PaginaLocalControle']))
{
    $_SESSION['PaginaLocalControle'] = $PaginaLocal;
}
//SE A P핯INA GRAVADA NA SESSION FOR DIFERENTE DA P핯INA LOCAL IR� LIMPAR O RETORNO DO FILTRO.
if ($_SESSION['PaginaLocalControle'] != $PaginaLocal)
{
    $_SESSION['PaginaLocalControle'] = $PaginaLocal;
    unset($_SESSION['Busca']);
    $RetornoFiltro = NULL;
    //$txtFiltro = NULL;
}
?>