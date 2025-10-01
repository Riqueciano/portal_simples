<table border="0" cellpadding="0" cellspacing="0" width="798" height="20">
<?
    if($qtdPagina>0){
?>
	<tr>
    	<td width="90" align="left" class="GridPaginacaoCabecalhoClaro">Página <?= $paginaAtual ?> de <?= $qtdPagina ?></td>
        <td width="508" align="center" class="GridPaginacaoCabecalhoClaro">&nbsp;
<?
if($qtdPagina<25){
    if ($paginaAtual > 1){
        $paginaAnterior = ($paginaAtual-2);
        print "<a href='".$PaginaLocal."Inicio.php?paginaAtual=$paginaAnterior&cmbStatus=$cmbStatus&txtFiltro=$txtFiltro'><font color='#065387'>[Anterior]</font></a>&nbsp;&nbsp;";
    }
    if ($qtdPagina > 1){
        for ( $contadorPaginacao = 1; $contadorPaginacao <= $qtdPagina; $contadorPaginacao++){
            if ($contadorPaginacao == $paginaAtual){
                print "<font color='#000000' size='1'>&nbsp;<B>$contadorPaginacao</B>&nbsp;</strong>";
            }else{
                $paginaMostrar = ($contadorPaginacao -1);
                print "&nbsp;<a href='".$PaginaLocal."Inicio.php?paginaAtual=$paginaMostrar&cmbStatus=$cmbStatus&txtFiltro=$txtFiltro'><font color='#065387' size='1'>$contadorPaginacao</font></a>&nbsp;";
            }
        }

    }
    if ( $paginaAtual < $qtdPagina){
        print "&nbsp;&nbsp;<a href='".$PaginaLocal."Inicio.php?paginaAtual=$paginaAtual&cmbStatus=$cmbStatus&txtFiltro=$txtFiltro'><font color='#065387'>[Próxima]</font></a>";
    }
}else{
    if ($paginaAtual > 1){
        $paginaAnterior = ($paginaAtual-2);
        print "<a href='".$PaginaLocal."Inicio.php?paginaAtual=$paginaAnterior&cmbStatus=$cmbStatus&txtFiltro=$txtFiltro'><font color='#065387'>[Anterior]</font></a>&nbsp;&nbsp;";
        print "<a href='".$PaginaLocal."Inicio.php?paginaAtual=0&cmbStatus=$cmbStatus&txtFiltro=$txtFiltro'><font color='#065387'>1</font></a>";
        print "<font color='#065387'>...</font>";
    }
    for ( $contadorPaginacao = 1; $contadorPaginacao <= $qtdPagina; $contadorPaginacao++){
        if ($contadorPaginacao == $paginaAtual){
            print "<font color='#000000' size='1'><B>$contadorPaginacao</B></strong>";
        }
    }
    if ( $paginaAtual < $qtdPagina){
            $ultimaPag=$qtdPagina-1;
        print "<font color='#065387'>...</font>";
        print "<a href='".$PaginaLocal."Inicio.php?paginaAtual=$ultimaPag&cmbStatus=$cmbStatus&txtFiltro=$txtFiltro'><font color='#065387'>$qtdPagina</font></a>&nbsp;&nbsp;";
        print "&nbsp;&nbsp;<a href='".$PaginaLocal."Inicio.php?paginaAtual=$paginaAtual&cmbStatus=$cmbStatus&txtFiltro=$txtFiltro'><font color='#065387'>[Próxima]</font></a>";
    }
}
?>
		&nbsp;
        </td>                                                                              
        <td width="200" align="right" class="GridPaginacaoCabecalhoClaro">
		<? 
			if ($qtdRegistroTotal == 1){echo ('Registro Encontrado ');}
			else{echo ('Registros Encontrados ');}
						
			echo ("[ ".$qtdRegistroTotal." ]");
		?>
        </td>
  </tr>
<?
    }else{
?>
  <tr>
    	<td width="798" align="center" class="GridPaginacaoCabecalhoClaro">Não Existe Registro</td>
  </tr>
<?
    }
?>
</table>


