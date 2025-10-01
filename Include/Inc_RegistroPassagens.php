<?php

/* * ****************************************************************************
  Alterado por Gabriel
 * *************************************************************************** */


/* * ***********************************************************************************************************************************
  COMENT�RIO.: CONSULTAR SE PASSAGEM EST� DEVOLVIDA E CANCELADA
 * ************************************************************************************************************************************ */

$sql1 = "SELECT passagem_devolvida, passagem_cancelada FROM passagens.passagem ps WHERE ps.passagem_id = " . $Codigo;
$rs1 = pg_query(abreConexao(), $sql1);
if (!$rs1) {
    echo 'Erro ao realizar procedimento(consulta).';
    exit;
} else {
    $linha = pg_fetch_assoc($rs1);
    If ($linha) {
        $PassagemDevolvida = $linha['passagem_devolvida'];
        $PassagemCancelada = $linha['passagem_cancelada'];
    }
}


/* * ***********************************************************************************************************************************
  COMENT�RIO.: VALIDAR PASSAGEM A SEREM IMPRESSAS A PARTIR DA DATA DE VIAGEM
 * ************************************************************************************************************************************ */
$sqlConsultaAquisicao = "SELECT passagem_aquisicao_obs, passagem_aquisicao_ida_sts, passagem_aquisicao_volta_sts,
								passagem_aquisicao_dt_saida,passagem_aquisicao_hr_saida,
								passagem_aquisicao_dt_chegada, passagem_aquisicao_hr_chegada,
								empresa_ida_id, empresa_volta_id 
						FROM passagens.passagem_aquisicao WHERE passagem_id = " . $Codigo;
$rsConsultaAquisicao = pg_query(abreConexao(), $sqlConsultaAquisicao);

if (!$rsConsultaAquisicao) {
    echo 'Erro ao consulta a aquisi��o da passagem.';
    exit;
} else {
    $linhaAquisicao = pg_fetch_assoc($rsConsultaAquisicao);
    If ($linhaAquisicao) {
        $DataPartidaConfirmada = f_FormataData($linhaAquisicao['passagem_aquisicao_dt_saida']);
        $DataChegadaConfirmada = f_FormataData($linhaAquisicao['passagem_aquisicao_dt_chegada']);
    }
}



//BOTAO CONSULTAR
echo "<td width='20' align='center'>";
if ($_SESSION['BotaoConsultar'] == false) {
    echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_consultar_off.png' alt='Consultar' border='0'>";
} else {
    if ($_SESSION['BotaoConsultar'] != 0) {
        echo "<a href=" . $PaginaLocal . "Consultar.php?cod=" . $CodigoRegistro . "&acao=consultar><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_consultar.png' alt='Consultar' border='0'></a>";
    }
}
echo "</td>";


//BOTAO EDITAR SO APARECE ANTES DA PASSAGEM SER APROVADA
echo "<td width='20' align='center'>";
if ($Status != 0 and $Status != 1 and $Status != -1) {
    echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar_off.png' alt='Editar' border='0'>";
} else {
    echo "<a href=" . $PaginaLocal . "Cadastrar.php?cod=" . $CodigoRegistro . "&acao=consultar><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar.png' alt='Editar'  border='0'></a>";
}
echo "</td>";


//BOTAO EXCLUIR SO APARECE ANTES DA PASSAGEM SER AUTORIZADA
echo "<td width='20' align='center'>";
//echo $Status;
if (($Status != 0 and $Status != 1 and $Status != -1 and $Status != -2)) {
    echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir_off.png' alt='Excluir' border='0'>";
} else {
    echo "<a href=" . $PaginaLocal . "Excluir.php?cod=" . $CodigoRegistro . "&acao=consultar><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir.png'  alt='Excluir' title='Exclus�o n�o dispon�vel!' border='0'></a>";
}
echo "</td>";


//BOTAO COMPROVAR SO APARECE DEPOIS DA PASSAGEM AQUISI��O
echo "<td width='20' align='center'>";
if ($Status != 3) {
    echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar_off.png' title='Comprova��o da Passagem n�o dispon�vel!' alt='Comprova��o da Passagem n�o dispon�vel!' border='0' />";
} else {

    if ($Solicitante == $_SESSION['UsuarioCodigo'] or $Beneficiario == $_SESSION['UsuarioCodigo'] or $_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Administrador") {

        $dtcPartidaConfirmada = (!empty($DataPartidaConfirmada) ? $convert->date_bra_para_timestamp($DataPartidaConfirmada) : 0);
        $dtcChegadaConfirmada = (!empty($DataChegadaConfirmada) ? $convert->date_bra_para_timestamp($DataChegadaConfirmada) : 0);
        $dtc = $convert->date_bra_para_timestamp(date("d/m/Y"));

        
        
        //if (($dtcChegadaConfirmada == 0 AND $dtcPartidaConfirmada < $dtc) or ( $dtcPartidaConfirmada == 0 AND $dtcChegadaConfirmada < $dtc) or ( $dtcPartidaConfirmada > 0 AND $dtcPartidaConfirmada < $dtc) AND ( $dtcChegadaConfirmada > 0 AND $dtcChegadaConfirmada < $dtc)) {
        if (true) {//pode comprovar a qual quer momento apos a aquisi��o
            echo "<a href='" . $PaginaLocal . "Comprovar.php?cod=" . $CodigoRegistro . "&acao=consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar.png' title='Comprovar Passagem' alt='Comprovar Passagem' border='0' /></a>";
        } else {
            echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar_off.png' title='Comprova��o da Passagem n�o dispon�vel!' alt='Comprova��o da Passagem n�o dispon�vel' border='0' />";
        }
    } else {
        echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar_off.png' title='Comprova��o da Passagem n�o dispon�vel!' alt='Comprova��o da Passagem n�o dispon�vel' border='0' />";
    }
}
echo "</td>";





/*
  if($Status < 9)
  {
  echo "<td align='center'><a href='javascript:ImprimirPassagem(".$Codigo.");'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir.png' border='0' alt='Exibir Solicita��o de Passagem' title='Exibir Solicita��o de Passagem!'></a></td>";
  }
  else
  {
  echo "<td>";
  echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir_off.png' alt='Exibi��o da Solicita��o n�o dispon�vel' title='Exibi��o da Solicita��o n�o dispon�vel!' border='0'>";
  echo "</td>";
  } */




//BOTAO IMPRIMIR SOLICITA��O/COMPROVA��O
//if(($PassagemDevolvida == 0)&&($Status == 9)&&($PassagemCancelada==0))
//if(1==1)

if ($Status <= 2) {
    echo "<td><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir_off.png' alt='Exibi��o da Solicita��o/Comprova��o n�o dispon�vel' title='Exibi��o da Solicita��o dispon�vel a partir da Aquisi��o da Passagem!' border='0'></td>";
} elseif ($Status == 3) {
    echo "<td align='center'><a href='javascript:ImprimirPassagem(" . $Codigo . ");'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir.png' border='0' alt='Exibir Solicita��o de Passagem' title='Exibir Solicita��o de Passagem!'></a></td>";
} elseif ($Status >= 4) {

    /*     * ***********************************************************************************************************************************
      COMENT�RIO.: VALIDAR PASSAGEM A SEREM IMPRESSAS A PARTIR DA DATA DE VIAGEM
     * ************************************************************************************************************************************ */

    /* $sqlConsultaAquisicao = "SELECT passagem_aquisicao_obs, passagem_aquisicao_ida_sts, passagem_aquisicao_volta_sts,
      passagem_aquisicao_dt_saida,passagem_aquisicao_hr_saida,
      passagem_aquisicao_dt_chegada, passagem_aquisicao_hr_chegada,
      empresa_ida_id, empresa_volta_id
      FROM passagens.passagem_aquisicao WHERE passagem_id = ".$Codigo;
      $rsConsultaAquisicao = pg_query(abreConexao(),$sqlConsultaAquisicao);

      if (!$rsConsultaAquisicao){
      echo 'Erro ao consulta a aquisi��o da passagem.';
      exit;
      }else{
      $linhaAquisicao=pg_fetch_assoc($rsConsultaAquisicao);
      If($linhaAquisicao)
      {
      $DataPartidaConfirmada			= f_FormataData($linhaAquisicao['passagem_aquisicao_dt_saida']);
      $DataChegadaConfirmada			= f_FormataData($linhaAquisicao['passagem_aquisicao_dt_chegada']);
      }
      } */

    $dtcPartidaConfirmada = (!empty($DataPartidaConfirmada) ? $convert->date_bra_para_timestamp($DataPartidaConfirmada) : 0);
    $dtcChegadaConfirmada = (!empty($DataChegadaConfirmada) ? $convert->date_bra_para_timestamp($DataChegadaConfirmada) : 0);
    $dtc = $convert->date_bra_para_timestamp(date("d/m/Y"));

    //if (($dtcChegadaConfirmada == 0 AND $dtcPartidaConfirmada < $dtc) or ( $dtcPartidaConfirmada == 0 AND $dtcChegadaConfirmada < $dtc) or ( $dtcPartidaConfirmada > 0 AND $dtcPartidaConfirmada < $dtc) AND ( $dtcChegadaConfirmada > 0 AND $dtcChegadaConfirmada < $dtc)) {
    if (true) {
        echo "<td align='center'><a href='javascript:ImprimirPassagemComprovacao(" . $Codigo . ");'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/impressao_comp.png' border='0' alt='Exibir Comprova��o' title='Exibir Comprova��o!'></a></td>";
    } else {
        echo "<td>";
        echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/impressao_comp_off.png' alt='Exibir Comprova��o' title='Exibi��o da Comprova��o dispon�vel a partir da Data da Viagem!' border='0'>";
        echo "</td>";
    }
}



//BOTAO REQUISI��O TERRESTRE
if (($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "DA") || ($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Administrador")) {

    if (($Status <= 4) and ( ($TipoPassagemIda == 2) or ( $TipoPassagemVolta == 2))) {
        //echo "<td align='center'><a href='javascript:ImprimirPassagemRequisicaoTerrestre(" . $Codigo . ");'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_requisicao.png' border='0' alt='Exibir Requisi��o de Passagem Terrestre' title='Exibir Requisi��o de Passagem Terrestre!'></a></td>";
    } else {
        //echo "<td><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_requisicao_off.png' alt='Exibi��o da Requisi��o Terrestre n�o dispon�vel' title='Exibi��o da Requisi��o Terrestre n�o dispon�vel!' border='0'></td>";
    }
}

//todos antes da comprova��o
if($Status < 3 && $Status !=-2 ){
echo "<td width='20' align='center' title='cancelar'>";
    echo "<a href=" . $PaginaLocal . "Cadastrar.php?cod=" . $CodigoRegistro . "&acao=consultar&acao2=cancelar><img src='https://www.portalsema.ba.gov.br/_portal/Icones/cancelar.png' alt='Editar'  border='0'></a>";
echo "</td>";
}else{
echo "<td width='20' align='center'>";
 echo "<a><img src='https://www.portalsema.ba.gov.br/_portal/Icones/cancelar_off.png' title='N�o � poss�vel cancelar'  border='0'></a>";
echo "</td>"; 
}

if(empty($caminho_convite_passagem)){
   echo "<td width='20' align='center'>";
   echo "   <a><img id='imgArquivo' src='https://www.portalsema.ba.gov.br/_portal/Icones/clip_off.png' title='Sem Anexo'  border='0'></a>";
   echo "</td>";  
}else{
    echo "<td width='20' align='center' title='cancelar'>";
    echo "  <a target='_blank' href='../anexos/anexo_convite_passagem/$caminho_convite_passagem'>
                <img id='imgArquivo' style='width:20px' src='https://www.portalsema.ba.gov.br/_portal/Imagens/clip.png' title='Baixar Arquivo'/>   
            </a>";
    echo "</td>";
}

?>
