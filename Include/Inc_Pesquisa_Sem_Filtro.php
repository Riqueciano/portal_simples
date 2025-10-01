<script type="text/javascript" language="javascript">
    function FiltrarForm(frm)
    {
        for(cont=0; cont < frm.elements.length; cont++)
                frm.elements[cont].style.backgroundColor = '';

        if (frm.txtFiltro.value == "")
        {
                alert("Digite filtro para busca.");
                frm.txtFiltro.focus();
                frm.txtFiltro.style.backgroundColor='#B9DCFF';
                return false;
        }

        frm.action = "<?=$PaginaLocal?>Inicio.php?acao=buscar&filtrotxt="+frm.txtFiltro.value;
        //MANIPULA O LINK DO FORMULÁRIO
        frm.target = '';
        frm.submit();
    }

    function TodosForm(frm)
    {
        frm.txtFiltro.value = "";
        frm.action = "<?=$PaginaLocal?>Inicio.php";
        //MANIPULA O LINK DO FORMULÁRIO
        frm.target = '';
        frm.submit();
    }
</script>

<?php
//VERIFICA SE A PESQUISA FOI REALIZADA A APRESENTA O BOTÃO EXIBIR TODOS
if($RetornoFiltro!=""){$BotaoTodos = '<input type="button" id="btnExibirTodos" name="btnExibirTodos" class="botao" style="width:90px;" onClick="Javascript:TodosForm(document.Form);" value="Exibir Todos"/> ';}
else{$BotaoTodos = '&nbsp;';}

//APRESENTA A TABELA DE PESAQUISA
echo '<table cellpadding="0" cellspacing="0" border="0" width="800" class="tabPesquisa">';
echo '<tr class="LinhaTexto"><td height="4"></td></tr>';
echo '<tr class="LinhaTexto" valign="middle">';
echo '<td width="" class="dataField">';
echo '&nbsp;<input id="txtFiltro" name="txtFiltro" maxlength="100" type="text" value="'.$RetornoFiltro.'" style="width:265px;">';
echo '&nbsp;<input type="button" id="btnPesquisar" name="btnPesquisar" class="botao" style="width:70px;" onClick="Javascript:FiltrarForm(document.Form);" value="Pesquisar"/>&nbsp;'.$BotaoTodos.'';
echo '</td>';
echo '<td class="dataLinha" align="right">';
echo '</td>';
echo '</tr>';
echo '<tr class="LinhaTexto"><td height="4"></td></tr>';
echo '</table>';
?>