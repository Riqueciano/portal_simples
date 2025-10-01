<?php
$sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_dt_criacao, est_organizacional_sigla FROM dados_unico.funcionario f,
               dados_unico.est_organizacional est, dados_unico.est_organizacional_funcionario eof, seguranca.usuario u RIGHT JOIN dados_unico.pessoa p ON
               (p.pessoa_id = u.pessoa_id) WHERE (usuario_login is null) AND (f.pessoa_id = p.pessoa_id) AND (f.funcionario_id = eof.funcionario_id) AND
               (est.est_organizacional_id = eof.est_organizacional_id) AND est_organizacional_funcionario_st = 0 ORDER BY UPPER(pessoa_dt_criacao) DESC ";
$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
?>
        <table cellpadding="0" cellspacing="0" border="0" width="100%" height="30"><tr><td class="titulo_pagina"><font size="1">&nbsp;Funcionários récem cadastrados</font></td></tr></table>

        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
            <tr>
                <td>

                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                        <tr height="21" class="dataLabel">
                        	<td>&nbsp;</td>
                            <td width="300" align="center">Funcion&aacute;rio</td>
                            <td width="300" align="center">Estrutura</td>
                            <td>&nbsp;Criado em</td>
                        </tr>
<?
	                    While ($linha=pg_fetch_assoc($rsConsulta))
                        {   echo "<tr height=21 class=dataField>";
							echo "<td width='20' align='center'><a href=UsuarioCadastrar.php?cod=" .$linha['pessoa_id']."&acao=consultar><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar.png' alt='Editar' border='0'></a></td>";
							echo "<td align=left>&nbsp;".$linha['pessoa_nm']. "</td>";
							echo "<td align=left>&nbsp;" .$linha['est_organizacional_sigla']. "</td>";
							echo "<td>&nbsp;".$linha['pessoa_dt_criacao']. "</td>" ;
							echo "</tr>";

                        }
?>
                    </table>
                </td>
            </tr>
        </table>

