<script type="text/javascript" language="javascript">

    function FiltrarForm(frm)
    {
        for (cont = 0; cont < frm.elements.length; cont++)
            frm.elements[cont].style.backgroundColor = '';

        if (frm.txtFiltro.value == "")
        {
            alert("Digite filtro para busca.");
            frm.txtFiltro.focus();
            frm.txtFiltro.style.backgroundColor = '#B9DCFF';
            return false;
        }

        frm.action = "<?= $PaginaLocal ?>Inicio.php?acao=buscar&filtro=" + frm.cmbStatus.value;
        frm.submit();
    }

    function TodosForm(frm)
    {
        frm.txtFiltro.value = "";
        frm.action = "<?= $PaginaLocal ?>Inicio.php";
        frm.submit();
    }

    function RedirectStatus(frm)
    {
        frm.action = "<?= $PaginaLocal ?>Inicio.php?filtro=" + frm.cmbStatus.value;
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
                                <td width="275" class="dataField">&nbsp;<input name="txtFiltro" id="txtFiltro" maxlength="100" type="text" value="<?= $RetornoFiltro ?>" style=" width:265px; height:15px;"/>&nbsp;</td>
                                <td width="75" ><input type="button" style="width:70px; " onClick="Javascript:FiltrarForm(document.Form);" class="botao" value="Pesquisar" /></td>
                                <? if($RetornoFiltro!="") { ?>
                                <td width="95"><input type="button" style="width:90px; " onClick="Javascript:TodosForm(document.Form);" class="botao" value="Exibir Todos" /></td>
                                <? } else { ?>
                                <td>&nbsp;</td>
                                <? }?>
                                <td class="dataLinha" align="right">Ver Status
                                    <?php
                                    if ($numFiltro == "") {
                                        $strAtivo = "";
                                        $strInativo = "";
                                        $strTodos = "Selected";
                                    } elseif ($numFiltro == 0) {
                                        $strAtivo = "Selected";
                                        $strInativo = "";
                                        $strTodos = "";
                                    } elseif ($numFiltro == 1) {
                                        $strAtivo = "";
                                        $strInativo = "Selected";
                                        $strTodos = "";
                                    }
                                    echo "<select name='cmbStatus' onchange='RedirectStatus(document.Form);'>";
                                    echo "  <option value='' " . $strTodos . ">Todos</option>";
                                    echo "  <option value='0' " . $strAtivo . ">Ativo</option>";
                                    echo "  <option value='1' " . $strInativo . ">Inativo</option>";
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