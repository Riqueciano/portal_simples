<?php
echo '<table border="0" cellpadding="0" cellspacing="0" width="798" height="20">';
echo '<tr class="GridPaginacaoRegistroNumRegistro">';
echo '<td align="left"><a href="'.$PaginaLocal.'Cadastrar.php?acaoTitulo=Cadastrar" class="GridPaginacaoRegistroNumRegistro">&nbsp;Novo</a>';

//VERIFICA SE HÁ ALGUM DOCUMENTO CADASTRADO PARA HABILITAR A OPÇÃO DE MARCAR/DESMARCAR TODOS
if (pg_num_rows($rsConsulta) > 1)
{
    echo '&nbsp;|&nbsp;';
    echo '<a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="Javascript:ExcluirMultiplo(document.Form, document.Form.checkbox, \''.$PaginaLocal.'\');">Excluir</a></td>';
    echo '<td align="right"><a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:MarcaCheckbox(document.Form.checkbox);">Marcar Todos</a>';
    echo '&nbsp;|&nbsp;';
    echo '<a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:DesmarcaCheckbox(document.Form.checkbox);">Desmarcar Todos&nbsp;</a></td>';
}
else
{
    echo '&nbsp;|&nbsp;';
    echo '<font color="gray">Exluir</font></td>';
    echo '<td align="right" style="color:gray">';
    echo 'Marcar Todos';
    echo '&nbsp;|&nbsp;';
    echo 'Desmarcar Todos&nbsp;</td>';
}

echo '</tr>';
echo '</table>';
?>