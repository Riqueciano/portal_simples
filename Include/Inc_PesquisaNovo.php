<script type="text/javascript" language="javascript">

    function FiltrarForm(frm)
    {
        for (cont = 0; cont < frm.elements.length; cont++)
            frm.elements[cont].style.backgroundColor = '';

        /*    
        if (frm.txtFiltro.value == "" && $('#flag_interno').val() == '-1')
        {
            alert("Digite filtro para busca.");
            frm.txtFiltro.focus();
            frm.txtFiltro.style.backgroundColor = '#B9DCFF';
            return false;
        }*/

        frm.action = "<?= $PaginaLocal ?>Inicio.php?acao=buscar&filtro=" ;
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

<table cellpadding="0" cellspacing="0" border="0" width="100%">
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
                                <td class="dataField">&nbsp;<input name="txtFiltro" id="txtFiltro" maxlength="1000" style="width: 60% " type="text" value="<?= $RetornoFiltro ?>"/>&nbsp;</td>
                                <td ><input type="button"  onClick="Javascript:FiltrarForm(document.Form);" class="btn-small btn-primary" value="Pesquisar" /></td>
                                <?php if($RetornoFiltro!="") { ?>
                                <td ><input type="button"  onClick="Javascript:TodosForm(document.Form);" class="btn-small btn-danger" value="Exibir Todos" /></td>
                                <?php } else { ?>
                                <td>&nbsp;</td>
                                <?php }?>
                                
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                        <input type="radio"  name='radio_filtro' id='ck_exibir_todos' onclick="FiltrarForm(document.Form)" value='1'> Exibir Todos
                                    </label>
                                    <label>
                                        <input type="radio"  name='radio_filtro' id='ck_exibir_pendencias' onclick="FiltrarForm(document.Form)"  value='2'> Exibir pendências
                                    </label>
                                    <label>
                                        <input type="radio"  name='radio_filtro'  id='ck_exibir_ultimos10_dias' onclick="FiltrarForm(document.Form)"  value='3' checked> Últimos 10 dias
                                    </label>
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