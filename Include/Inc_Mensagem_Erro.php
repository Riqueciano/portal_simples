<?php
if ($MensagemErroBD != "")
{
    echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
    echo "<tr>";
    echo "<td class='MensagemErro'><span id='erro'>".$MensagemErroBD."</span></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><img src='https://www.portalsema.ba.gov.br/_portal/Imagens/vazio.gif' width='1' height='10' border='0'></td>";
    echo "</tr>";
    echo "</table>";
}
?>