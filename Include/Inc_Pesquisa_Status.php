
<script type="text/javascript" language="javascript">

    function Redirect(frm)
    {
        frm.action = "SolicitacaoConsultaGlobalInicio.php?Status="+frm.cmbStatusSolicitacao.value+"&ano="+frm.cmbanoSolicitacao.value;
        frm.submit();
    }

</script>

<table cellpadding="0" cellspacing="0" border="0" width="800">
    <tr>
        <td align="center" class="tabPesquisa" >
            <table cellpadding="0" border="0" cellspacing="0" width="100%">
                <tr>
                    <td><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/vazio.gif" width="1" height="3" border="0" alt=""/></td>
                </tr>
                <tr>
                    <td valign="top" class="LinhaTexto">
                        <table cellpadding="0" border="0" cellspacing="0" width="100%">
                            <tr>
                                <td class="dataLinha" align="right">Status SD
                                    <?php
                                    $StatusSolicitacao0  = "";
                                    $StatusSolicitacao1  = "";
                                    $StatusSolicitacao2  = "";
                                    $StatusSolicitacao3  = "";
                                    $StatusSolicitacao4  = "";
                                    $StatusSolicitacao5  = "";
                                    $StatusSolicitacao6  = "";
                                    $StatusSolicitacao7  = "";
                                    $StatusSolicitacao8  = "";
                                    $StatusSolicitacao9  = "";
                                    $StatusSolicitacao10  = "";
                                    $StatusSolicitacao11  = "";

                                    if($StatusSolicitacao == "") {
                                        $StatusSolicitacao0 = "Selected";
                                    }
                                    elseif ($StatusSolicitacao == 0) {
                                        $StatusSolicitacao0 = "Selected";
                                    }
                                    elseif ($StatusSolicitacao == 1) {
                                        $StatusSolicitacao1="Selected";
                                    }
                                    elseif ($StatusSolicitacao == 2) {
                                        $StatusSolicitacao2="Selected";
                                    }
                                    elseif ($StatusSolicitacao == 3) {
                                        $StatusSolicitacao3 = "Selected";
                                    }
                                    elseif ($StatusSolicitacao == 4) {
                                        $StatusSolicitacao4 = "Selected";
                                    }
                                    elseif ($StatusSolicitacao == 5) {
                                        $StatusSolicitacao5 = "Selected";
                                    }
                                    elseif ($StatusSolicitacao == 6) {
                                        $StatusSolicitacao6 = "Selected";
                                    }
                                    elseif ($StatusSolicitacao == 7) {
                                        $StatusSolicitacao7 = "Selected";
                                    }
                                    elseif ($StatusSolicitacao == 8) {
                                        $StatusSolicitacao8 = "Selected";
                                    }
                                    elseif ($StatusSolicitacao == 9) {
                                        $StatusSolicitacao9 = "Selected";
                                    }

                                    elseif ($StatusSolicitacao == 10) {
                                        $StatusSolicitacao10 = "Selected";
                                    }
                                    elseif ($StatusSolicitacao == 11) {
                                        $StatusSolicitacao11 = "Selected";
                                    }

                                    $Anosolicitacao0 = "";
                                    $Anosolicitacao1 = "";
                                    $Anosolicitacao2 = "";
                                    $Anosolicitacao3 = "";

                                    if ($AnoSolicitacao=="") {
                                        $Anosolicitacao1="Selected";
                                    }
                                    elseif ($AnoSolicitacao==2008) {
                                        $Anosolicitacao0=="Selected";
                                    }
                                    elseif ($AnoSolicitacao==2009) {
                                        $Anosolicitacao1="Selected";
                                    }
                                    elseif ($AnoSolicitacao==2010) {
                                        $Anosolicitacao2="Selected";
                                    }
                                    elseif ($AnoSolicitacao==2011) {
                                        $Anosolicitacao3="Selected";
                                    }

                                    echo "<select name='cmbStatusSolicitacao' onchange='Redirect(document.Form);'>";
                                    echo "  <option value='0' ".$StatusSolicitacao0.">Aguardando Autoriza&ccedil;&atilde;o </option>";
                                    echo "  <option value='1' ".$StatusSolicitacao1.">Aguardando Aprova&ccedil;&atilde;o</option>";
                                    echo "  <option value='2' ".$StatusSolicitacao2.">Aguardando Empenho</option>";
                                    echo "  <option value='3' ".$StatusSolicitacao3.">Aguardando Pagamento</option>";
                                    echo "  <option value='4' ".$StatusSolicitacao4.">Aguardando Comprova&ccedil;&atilde;o</option>";
                                    echo "  <option value='5' ".$StatusSolicitacao5.">Aguardando Documenta&ccedil;&atilde;o</option>";
                                    echo "  <option value='6' ".$StatusSolicitacao6.">Aguardando 2ª Empenho</option>";
                                    echo "  <option value='7' ".$StatusSolicitacao7.">Aguardando 2ª Pagamento</option>";
                                    echo "  <option value='8' ".$StatusSolicitacao8.">Aguardando Análise Financeira</option>";
                                    echo "  <option value='9' ".$StatusSolicitacao9.">Concluida</option>";
                                    echo "  <option value='10' ".$StatusSolicitacao10.">Devolvida</option>";
                                    echo "  <option value='11' ".$StatusSolicitacao11.">Excluida</option>";
                                    echo "</select>";
                                    ?>
                                        Ano
                                    <?php
                                    echo "<select name='cmbanoSolicitacao' onchange='Redirect(document.Form);'>";
                                    echo "<option value='2008' ".$Anosolicitacao0.">2008</option>";
                                    echo "<option value='2009' ".$Anosolicitacao1.">2009</option>";
                                    echo "<option value='2010' ".$Anosolicitacao2.">2010</option>";
                                    echo "<option value='2011' ".$Anosolicitacao3.">2011</option>";
                                    echo "</select>";
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/vazio.gif" width="1" height="2" border="0" alt=""/></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
