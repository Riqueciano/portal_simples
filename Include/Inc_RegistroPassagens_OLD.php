<?php
/*
*****************************************************************************
 Alterado por Gabriel 
*****************************************************************************
 *
 */
$sql1	= "SELECT passagem_devolvida, passagem_cancelada FROM passagens.passagem ps WHERE ps.passagem_id = " .$Codigo;
$rs1	= pg_query(abreConexao(),$sql1);
if (!$rs1){
	echo 'Erro ao realizar procedimento(consulta).';
	exit;
}

$linha				= pg_fetch_assoc($rs1);
$PassagemDevolvida	= $linha['passagem_devolvida'];
$PassagemCancelada	= $linha['passagem_cancelada'];


echo "<td width='20' align='center'>";

//botao consultar
if($_SESSION['BotaoConsultar'] == false)
{  echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_consultar_off.png' alt='Consultar' border='0'>";
}
else
{  
	if ($_SESSION['BotaoConsultar']!= 0)
      { echo "<a href=".$PaginaLocal."Consultar.php?cod=".$CodigoRegistro."&acao=consultar><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_consultar.png' alt='Consultar' border='0'></a>";
      }

}
echo "</td>";


//botao editar so aparece antes da passagem ser aprovada
echo "<td width='20' align='center'>";
if ($Status != 0 && $Status != 1)
{  
	echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar_off.png' alt='Editar' border='0'>";
}
else
{  
	echo "<a href=".$PaginaLocal."Cadastrar.php?cod=".$CodigoRegistro."&acao=consultar><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar.png' alt='Editar' border='0'></a>";
}
echo "</td>";
echo "<td width='20' align='center'>";

//botao excluir so aparece antes da passagem ser autorizada
if ($Status != 0 && $Status != 1)
{  
  echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir_off.png' alt='Excluir' border='0'>";
}else{
	
   echo "<a href=".$PaginaLocal."Excluir.php?cod=".$CodigoRegistro. "&acao=consultar><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir.png'  alt='Excluir' border='0'></a>";

}
echo "</td>";




if(($PassagemDevolvida == 0)&&($Status == 9)&&($PassagemCancelada==0))

//if(1==1)
{ 

	//ADM OU DA
	/*if( ($_SESSION['TipoUsuario'] == 49) || ($_SESSION['TipoUsuario'] == 53) ){

		echo "<td align='center'><a href='SolicitacaoCancelar.php?cod=".$Codigo."&pagina=Solicitacao&acao=consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/cancelar.png' border='0' alt='Cancelar Passagem'></a></td>";
	}else{
		echo "<td>";
		echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/cancelar_des.png' alt='Cancelar Passagem' border='0'>";
		echo "</td>";
	}*/

	echo "<td align='center'><a href='javascript:ImprimirPassagem(".$Codigo.");'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir.png' border='0' alt='Imprimir Passagem'></a></td>"	;
}
else
{  
	/*echo "<td>";
	echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/cancelar_des.png' alt='Cancelar Passagem' border='0'>";
	echo "</td>";*/

	echo "<td>";
	echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir_off.png' alt='Imprimir Passagem' border='0'>";
	echo "</td>";
}

?>
