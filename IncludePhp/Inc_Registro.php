<td width='20' align='center'><a href='../View/<?= $PaginaLocal ?>Consultar.php?reg_id=<?= $reg_id ?>&acao=consultar&titulo=<?=$_SESSION["Titulo"]?>&subtitulo=<?=$_SESSION["SubTitulo"]?>&acaoTitulo=Consultar&pagina=<?=$PaginaLocal?>'><img src='../https://www.portalsema.ba.gov.br/_portal/Icones/ico_consultar.png' alt='Consultar' border='0'></a></td>
<?if ($linha['solicitacao_situacao']==0){ ?>
<td width='20' align='center'><a href='../View/<?= $PaginaLocal ?>Cadastrar.php?reg_id=<?= $reg_id?>&acao=editar&titulo=<?=$_SESSION["Titulo"]?>&subtitulo=<?=$_SESSION["SubTitulo"]?>&acaoTitulo=Editar&pagina=<?=$PaginaLocal?>'><img src='../https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar.png' alt='Editar' border='0'></a></td>
<td width='20' align='center'><a href='../View/<?= $PaginaLocal ?>Consultar.php?reg_id=<?= $reg_id ?>&acao=excluir&titulo=<?=$_SESSION["Titulo"]?>&subtitulo=<?=$_SESSION["SubTitulo"]?>&acaoTitulo=Excluir&pagina=<?=$PaginaLocal?>'><img src='../https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir.png'  alt='Excluir' border='0'></a></td>
<?}else{?>
<td width='20' align='center'><img src='../https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar_off.png' alt='Editar' border='0'></td>
<td width='20' align='center'><img src='../https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir_off.png'  alt='Excluir' border='0'></td>
<?}?>


