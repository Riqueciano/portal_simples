<?php
include 'Inc_Linha.php';

$sistema_id = empty($_SESSION['Sistema'])?0:$_SESSION['Sistema'];
$SistemaNome = '';
$SistemaURL  = '';
if($sistema_id == "" ) { 
    // echo "<script>window.location = '../Home/Login.php';</script>";
}
else {
    $sistema_id = empty($_SESSION['Sistema'])?0:$_SESSION['Sistema'];
    $sqlAba = "SELECT sistema_nm, sistema_url FROM seguranca.sistema WHERE sistema_id = '" .$sistema_id."'";
    $rsAba = pg_query(abreConexao(),$sqlAba);
    $linhaAba=pg_fetch_assoc($rsAba);
    if($linhaAba) {
        $SistemaNome = $linhaAba['sistema_nm'];
        $SistemaURL  = $linhaAba['sistema_url'];
    }
}
    if(($SistemaNome=='Serviços')OR($SistemaNome=='Reserva'))
    {
        ?>
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
            <tr>
                <td align="left" width="100%">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left" width="115">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="9" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab.gif"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/tab_esq.gif" width="9" height="20"></td>
                                        <td width="98" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab.gif"><div align="center"><a class="linktab" href="https://<?=$_SERVER['HTTP_HOST'] .'/'.$_SESSION['pasta_sistema_pai']?>/Intranet/sistema">Voltar</a></div></td>
                                        <td width="8" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab.gif"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/tab_dir.gif" width="8" height="20"></td>
                                    </tr>
                                </table>
                            </td>
                            <td align="left" width="215">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="9" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab_on.gif"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/tab_esq_on.gif" width="9" height="20"></td>
                                        <td width="198" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab_on.gif"><div align="center"><font class="linktab"><?=$SistemaNome?></font></div></td>
                                        <td width="8" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab_on.gif"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/tab_dir_on.gif" width="8" height="20"></td>
                                    </tr>
                                </table>
                            </td>
                            <td align="right">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
                                    <tr>
                                        <td class="dataLinha" align="right"><b>Acesso: </b><?=$_SESSION["Sistemas"][$_SESSION["Sistema"]]?>
                                            <?php
                                            //TRATAMENTO PARA A DESCRIÇÃO DA UNIDADE
                                            if ($_SESSION['UsuarioEstDescricao'] != '')
                                            {
                                                //APRESENTA A DESCRIÇÃO DA UNIDADE
                                                echo ' | <b>Unidade:</b> '.$_SESSION['UsuarioEstDescricao'].'';
                                            }
                                            ?>
                                            </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/vazio.gif" height="1"></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="bgcolor"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/vazio.gif" height="6"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/vazio.gif" height="5"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
<?php
    }
    else
    {
?>
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
            <tr>
                <td align="left" width="100%">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left" width="115">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="9" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab.gif"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/tab_esq.gif" width="9" height="20"></td>
                                        <td width="98" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab.gif"><div align="center"><a class="linktab" href="https://<?=$_SERVER['HTTP_HOST'] .'/'.$_SESSION['pasta_sistema_pai']?>/Intranet/sistema">Voltar</a></div></td>
                                        <td width="8" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab.gif"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/tab_dir.gif" width="8" height="20"></td>
                                    </tr>
                                </table>
                            </td>
                            <td align="left" width="215">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="9" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab_on.gif"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/tab_esq_on.gif" width="9" height="20"></td>
                                        <td width="198" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab_on.gif"><div align="center"><font class="linktab"><?=$SistemaNome?></font></div></td>
                                        <td width="8" background="https://www.portalsema.ba.gov.br/_portal/Imagens/bg_tab_on.gif"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/tab_dir_on.gif" width="8" height="20"></td>
                                    </tr>
                                </table>
                            </td>
                            <td align="right">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
                                    <tr>
                                        <td class="dataLinha" align="right"><b>Acesso: </b><?=$_SESSION["Sistemas"][$_SESSION["Sistema"]]?>
                                            <?php
                                            //TRATAMENTO PARA A DESCRIÇÃO DA UNIDADE
                                            if ($_SESSION['UsuarioEstDescricao'] != '')
                                            {
                                                //APRESENTA A DESCRIÇÃO DA UNIDADE
                                                echo ' | <b>Unidade:</b> '.$_SESSION['UsuarioEstDescricao'].'';
                                            }
                                            ?>
                                            </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/vazio.gif" height="1"></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="bgcolor"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/vazio.gif" height="6"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/vazio.gif" height="5"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
<?php
    }
?>