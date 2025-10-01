<?php
if (pg_num_rows($rsConsulta) <= 1)
{
    echo "<td width='20' align='center'><input type='checkbox' class='checkbox' name='checkbox_OFF' value=".$CodigoRegistro." disabled title='Registro não pode ser Marcado para Ação Multipla!!!'></td>";
}
else
{
    echo "<td width='20' align='center'><input type='checkbox' class='checkbox' name='checkbox' value=".$CodigoRegistro." ></td>";
}
echo "<td width='20' align='center'>";
if ($_SESSION['BotaoConsultar'] == false)
{
    echo "<img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_consultar_off.png' title='Consultar' alt='Consultar' border='0'>";
}
else if ($_SESSION['BotaoConsultar'] == true)
{  
    echo "<a href='".$PaginaLocal."Cadastrar.php?cod=".$CodigoRegistro."&acao=consultar&acaoTitulo=Consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_consultar.png' title='Consultar' alt='Consultar' border='0'></a>";
}
echo "</td>";

echo "<td width='20' align='center'><a href='".$PaginaLocal."Cadastrar.php?cod=".$CodigoRegistro."&acao=consultar&acaoTitulo=Editar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar.png' title='Editar' alt='Editar' border='0'></a></td>";
echo "<td width='20' align='center'><a href='".$PaginaLocal."Cadastrar.php?cod=".$CodigoRegistro."&acao=consultar&acaoTitulo=Excluir'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir.png' title='Excluir' alt='Excluir' border='0'></a></td>";

?>