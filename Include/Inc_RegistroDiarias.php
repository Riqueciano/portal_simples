<?php

/* * *****************************************************************************
  TODOS OS BOT�ES DO SISTEMA DE DI�RIAS SER�O CONTROLADOS NESTE ARQUIVO.
 * ***************************************************************************** */

$sql1 = "SELECT diaria_comprovada,
                diaria_devolvida 
            FROM diaria.diaria d 
            WHERE d.diaria_id = " . $Codigo;

$rs1 = pg_query(abreConexao(), $sql1);
$linha = pg_fetch_assoc($rs1);

$DiariaComprovada = $linha['diaria_comprovada'];
$DiariaDevolvida = $linha['diaria_devolvida'];

echo "<td width='20' align='center'>";

//echo $Status;
//CONTROLE DE EXIBI��O DO BOT�O CONSULTAR.
if ($_SESSION['BotaoConsultar'] == false) {
    echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_consultar_off.png' title='Consultar Di�ria' alt='Consultar Di�ria' border='0' />";
    
} else {
    //SE A DI�RIA J� FOI COMPROVADA EXIBIR� A CONSULTA DA COMPROVA��O.
    if ($Status > 6) {
        echo "<a href=ComprovacaoConsultar.php?cod=" . $CodigoRegistro . "&acao=consultar&pagina=Solicitacao><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_consultar.png' title='Consultar Di�ria' alt='Consultar Di�ria' border='0' /></a>";
    } else {
        if ($_SESSION['BotaoConsultar'] != 0) {
            echo "<a href=" . $PaginaLocal . "Consultar.php?cod=" . $CodigoRegistro . "&acao=consultar><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_consultar.png' title='Consultar Di�ria' alt='Consultar Di�ria' border='0' /></a>";
        }
    }
}
echo "</td>";
echo "<td width='20' align='center'>";



//O SISTEMA S� POSSIBILITA A EDI��O SE N�O OCORREU EMPENHO PR�VIO E SE A MESMA AINDA N�O FOI APROVADA.
//if (($Status == 0 || $Status == -1.1 || $PermitirEdicao == true) || ($EmpenhoPrevio == 0)) {
if (($Status == 0 || $Status == -1.1 )) {
    if((int)$Status!=2 and (int)$Status!=4){
        echo "<a href=" . $PaginaLocal . "Cadastrar.php?cod=" . $CodigoRegistro . "&acao=consultar><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar.png' title='Editar Di�ria' alt='Editar Di�ria' border='0' /></a>";
    
        
    }else{
        echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar_off.png' title='Editar Di�ria' alt='Editar Di�ria' border='0' />";
    
    }
} else {
    echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar_off.png' title='Editar Di�ria' alt='Editar Di�ria' border='0' />";
}


echo "</td>";
echo "<td width='20' align='center'>";

//O SISTEMA S� POSSIBILITA A EXCLUS�O DA DI�RIA apos DO EMPENHO.
if (($Status > 2) || (($Status < 2) && ($DiariaEmpenho != ""))) {//echo '$Status';
    echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir_off.png' title='Excluir Di�ria' alt='Excluir Di�ria' border='0' />";
} else {
    if ($DiariaComprovada == "1") {
        echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir_off.png' title='Excluir Di�ria' alt='Excluir Di�ria' border='0' />";
    } else {
        if ((int) $Status != 2) {
            echo "<a href=" . $PaginaLocal . "Excluir.php?cod=" . $CodigoRegistro . "&acao=consultar><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir.png' title='Excluir Di�ria' alt='Excluir Di�ria' border='0' /></a>";
        } else {
            echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir_off.png' title='Excluir Di�ria' alt='Excluir Di�ria' border='0' />";
        }
    }
}
echo "</td>";
echo "<td width='60' align='center'>";
echo "<a href='https://www.portalsema.ba.gov.br/_portal/SistemaDiarias/SolicitacaoImprimirPDF.php?acao=imprimir&cod=$CodigoRegistro&ComDirigente=true' target='_blank'>
            <img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir.png' border='0' title='Exibir Solicita��o'  border='0'  />
      </a>";
    
if ($Status < 3/* aguardando liberacao de empenho */) {
//echo '$Status';     
      if(strtotime(dataToDB($DataChegada)) < strtotime((date("Y-m-d"))) and $flag_comprovacao==0 and (int)$Status>1/*apos a aprova��o DG*/ ) {
            //echo dataToDB($DataChegada).'<br><br>'.date("Y-m-d");
            echo "<a href='SolicitacaoComprovar.php?cod=" . $CodigoRegistro . "&acao=consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' /></a>";
      }else{
            echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar_off.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' />";
      }
     
} else {
//echo $Status;exit;
    if ((int) $Status == 2 or (int) $Status == 4) {//echo 2;
        echo "<a href='SolicitacaoComprovar.php?cod=" . $CodigoRegistro . "&acao=consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' /></a>";
    }else{


    if ($Status >= 3) { 
        //SE A DI�RIA AINDA N�O FOI COMPROVADA.
        if ($DiariaComprovada == "0") {
            //SE FOR O BENEFICI�RIO DA DI�RIA O SISTEMA IR� PERMITIR A COMPROVA��O.
            /* or $_SESSION['UsuarioCodigo'] = 258 */

            //if ($Beneficiario == $_SESSION['UsuarioCodigo'])
            //BENEFICI�RIO OU SOLICITANTE A PEDIDO DA DF 19/11/2013
            if ($Solicitante == $_SESSION['UsuarioCodigo'] or $Beneficiario == $_SESSION['UsuarioCodigo'] or $_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Administrador") {
                //echo 3;
                if($flag_comprovacao==0 || $Status==4 ){
                    echo "<a href='SolicitacaoComprovar.php?cod=" . $CodigoRegistro . "&acao=consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' /></a>";
                }else{
                    echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar_off.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' />";
                }
                
            } else {
                if (($Solicitante == $_SESSION['UsuarioCodigo']) && (($Motorista == 1) || ($FuncionarioTipo == 10))) {
                    //echo 4;
                    echo "<a href='SolicitacaoComprovar.php?cod=" . $CodigoRegistro . "&acao=consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' /></a>";
                
                    
                } else {
                    if (strtotime(dataToDB($DataChegada)) < strtotime((date("Y-m-d"))) ) {//echo 4;
                        echo "<a href='SolicitacaoComprovar.php?cod=" . $CodigoRegistro . "&acao=consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' /></a>";
                    } else {//echo 1;
                        echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar_off.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' />";
                    }//echo 1
                }
            }
        } else { 
            //SE A DI�RIA FOI DEVOLVIDA IR� ENTRAR NESSE IF.
            if ($DiariaDevolvida == "1") {
                //SE FOR O BENEFICI�RIO DA DI�RIA O SISTEMA IR� PERMITIR A COMPROVA��O.
                //if ($Beneficiario == $_SESSION['UsuarioCodigo'])
                //BENEFICI�RIO OU SOLICITANTE A PEDIDO DA DF 19/11/2013
                if ($Solicitante == $_SESSION['UsuarioCodigo'] or $Beneficiario == $_SESSION['UsuarioCodigo'] or $_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Administrador") {
                    //echo 5;
                    echo "<a href='SolicitacaoComprovar.php?cod=" . $CodigoRegistro . "&acao=consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar.png'  alt='Comprovar' border='0'></a>";
                } else {
                    if (($Solicitante == $_SESSION['UsuarioCodigo']) && (($Motorista == 1) || ($FuncionarioTipo == 10))) {
                        //echo 6;
                        echo "<a href='SolicitacaoComprovar.php?cod=" . $CodigoRegistro . "&acao=consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' /></a>";
                    } else {
                        if (strtotime(dataToDB($DataChegada)) < strtotime((date("Y-m-d"))) ) {//echo 1;
                            //echo 7;
                            echo "<a href='SolicitacaoComprovar.php?cod=" . $CodigoRegistro . "&acao=consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' /></a>";
                        } else {//echo 2;
                            echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar_off.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' />";
                        }
                    }
                }
            } else {
                
                    echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_comprovar_off.png' title='Comprovar Di�ria' alt='Comprovar Di�ria' border='0' />";
                
            }
        }
}}
}
echo "</td>";
echo "<td width='20' align='center'>";

if (($Status >= 3) && ($Status <= 8)) {
    //SE A DI�RIA J� FOI COMPROVADA SER� PESQUISADA A EXIST�NCIA DE D�VIDA.
    if ($DiariaComprovada == "1") {
        $sqlGer = "SELECT diaria_comprovacao_saldo_tipo 
                        FROM diaria.diaria_comprovacao 
                        WHERE diaria_id = " . $Codigo;

        $rsGer = pg_query(abreConexao(), $sqlGer);
        $linha = pg_fetch_assoc($rsGer);

        if ($linha) {
            //CASO HAJA D�BITO - O BENEFICI�RIO TER� QUE RESTITUIR.
            if ($linha['diaria_comprovacao_saldo_tipo'] == "D") {
                if ($DiariaDevolvida == "0") {
                    //CONSULTA SE A DI�RIA � DO TIPO CONVENIO (CONVENIO == 0 -> N�O, CONVENIO != 0 -> SIM)
                    $sqlConsultaDiaria = "SELECT convenio_id 
                                                    FROM diaria.diaria 
                                                    WHERE diaria_id = " . $Codigo;

                    $rsConsultaDiaria = pg_query(abreConexao(), $sqlConsultaDiaria);
                    $linhaConsultaDiaria = pg_fetch_assoc($rsConsultaDiaria);
                    $convenio_id = $linhaConsultaDiaria['convenio_id'];

                  //  echo "<a href='javascript:ImprimirDiariaGER(" . $CodigoRegistro . ", " . $convenio_id . ");'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir_ger.png' title='Imprimir GER' alt='Imprimir GER' border='0' /></a>";
                } else {
                  //  echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir_ger_off.png' title='Imprimir GER' alt='Imprimir GER' border='0' />";
                }
            } else {
               // echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir_ger_off.png' title='Imprimir GER' alt='Imprimir GER' border='0' />";
            }
        }
    } else {
      //  echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir_ger_off.png' title='Imprimir GER' alt='Imprimir GER' border='0' />";
    }
} else {
   // echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir_ger_off.png' title='Imprimir GER' alt='Imprimir GER' border='0' />";
}

//SE A DI�RIA J� FOI COMPROVADA E AINDA N�O FOI CONCLU�DA.
if (($DiariaComprovada == "1") && ($Status <= 8)) {
        echo "<td align='center'>
                <a href='javascript:ImprimirComprovacaoDiaria(" . $Codigo . ");'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir.png' border='0' title='Exibir Comprova��o' alt='Exibir Comprova��o' border='0' /></a>
              </td>";
} else {
    if($flag_comprovacao == 1){
        echo "<td align='center'><a href='javascript:ImprimirComprovacaoDiaria(" . $Codigo . ");'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir.png' border='0' title='Exibir Comprova��o' alt='Exibir Comprova��o' border='0' /></a></td>";
    }else{
        echo "<td>";
        echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_imprimir_off.png' title='Exibir Comprova��o' alt='Exibir Comprova��o' border='0' />";
        echo "</td>";
    }
}
?>

<td>
    <a href="SolicitacaoInicio_historico_pdf.php?cod=<?=$Codigo?>" target='_blank'>
        <img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_agendar.png' title='Exibir Historico'  border='0' />
    </a>
</td>
