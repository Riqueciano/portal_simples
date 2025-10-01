<?php
$sqlConsulta = "SELECT * FROM dados_unico.contrato c, dados_unico.pessoa p WHERE (c.pessoa_id = p.pessoa_id) AND contrato_dt_termino <> '' AND contrato_st <> 2 ORDER BY contrato_num";
$rsConsulta=pg_query(abreConexao(),$$sqlConsulta);
?>
        <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30"><tr><td class="titulo_pagina"><font size="1">&nbsp;Contrato (contratos com data de vencimento menor que 31 dias)</font></td></tr></table>

        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
            <tr>
                <td>

                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                        <tr height="21" class="dataLabel">
                            <td width="100" align="center">N&uacute;mero</td>
                            <td width="280">&nbsp;Descri&ccedil;&atilde;o</td>
                            <td width="280">&nbsp;Empresa</td>
                            <td width="88" align="center">Data T&eacute;rmino</td>
                            <td width="50" align="center">Faltam</td>
                        </tr>
<?
 while ($linha=pg_fetch_assoc($rsConsulta))
 {  $DataAtual= date("d/m/Y");
    $Numero=$linha['contrato_num'];
    $Descricao=$linha['contrato_ds'];
    $Empresa=$linha['pessoa_nm'];
    $DataTermino=$linha['contrato_dt_termino'];

    $vetDataAtual=explode("/", $DataAtual);
    $DiaDataAtual = $vetDataAtual[0];
    $MesDataAtual = $vetDataAtual[1];
    $AnoDataAtual = $vetDataAtual[2];

    $vetDataTermino=explode("/", $DataTermino);
    $DiaDataTermino = $vetDataTermino[0];
    $MesDataTermino = $vetDataTermino[1];
    $AnoDataTermino = $vetDataTermino[2];

    //calculo timestam das duas datas
    $timestamp1 = mktime(0,0,0,$MesDataAtual,$DiaDataAtual,$AnoDataAtual);
    $timestamp2 = mktime(4,12,0,$MesDataTermino,$DiaDataTermino,$AnoDataTermino);

    //diminuo a uma data a outra
    $segundos_diferenca = $timestamp1 - $timestamp2;
    //echo $segundos_diferenca;

    //converto segundos em dias
    $dias_diferenca = $segundos_diferenca / (60 * 60 * 24);

    //obtenho o valor absoluto dos dias (tiro o possível sinal negativo)
    $dias_diferenca = abs($dias_diferenca);

    //tiro os decimais aos dias de diferenca
    $dias_diferenca = floor($dias_diferenca);
    $Dias=$dias_diferenca = floor($dias_diferenca);
    if (($Dias < 90) &&($Dias >= 0))
    {  echo "<tr height=21 class=dataField>";
       echo "<td align=center>".$Numero. "</td>";
       echo "<td>&nbsp;".$Descricao. "</td>";
       echo "<td>&nbsp;".$Empresa."</td>";
       echo "<td align=center>".$DataTermino."</td>";
       echo "<td align=center><font color=#ff0000>".$Dias." dias</font></td>";
       echo "</tr>";
   }
 }

?>
                    </table>
                </td>
            </tr>
        </table>

