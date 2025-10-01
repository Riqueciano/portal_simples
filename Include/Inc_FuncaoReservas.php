<?php
function ComboEspacoTipo($evento_tipo_nm)
{
    echo '<select name=solicitacao_nm style="width:315px"';
    echo '<option></option>';
    echo '<option value=0>[-------------------------------------- Selecione -------------------------------------]</option>';
    
    $sql = "SELECT * FROM reserva.evento_tipo WHERE (evento_tipo_st = 0) ORDER BY UPPER(evento_tipo_nm)";
    $rs = pg_query(abreConexao(),$sql);
    while($linha = pg_fetch_assoc($rs))
    {
        if ($evento_tipo_nm == $linha['evento_tipo_nm'])
        {
            echo "<option value=".$linha['evento_tipo_nm']." selected>1" .$linha['evento_tipo_nm']. "</option>";            
        }
        else
        {
            echo "<option value=".$linha['evento_tipo_nm'].">" .$linha['evento_tipo_nm']. "</option>";
        }
    }
}
?>
