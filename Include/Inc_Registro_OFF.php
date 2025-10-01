<?php
echo "<td width='20' align='center'><input type='checkbox' class='checkbox' name='checkbox_OFF' value=".$CodigoRegistro." disabled title='Registro não pode ser Marcado para Ação Multipla!!!'></td>";
echo "<td width='20' align='center'><a href='".$PaginaLocal."Consultar.php?cod=".$CodigoRegistro."&acao=consultar&acaoTitulo=Consultar'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_consultar.png' alt='Consultar' border='0'></a></td>";
echo "<td width='20' align='center'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_alterar_off.png' alt='Editar' border='0'></a></td>";
echo "<td width='20' align='center'><img src='https://www.portalsema.ba.gov.br/_portal/Icones/ico_excluir_off.png'  alt='Excluir' border='0'></a></td>";
?>