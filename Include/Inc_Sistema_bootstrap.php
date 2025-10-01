<?php
//QUERY DE CONSULTA
$sqlConsulta = "
        SELECT
            s.sistema_id,
            sistema_nm,
            sistema_ds,
            sistema_url,
            sistema_icone,
            tipo_usuario_ds
        FROM
            seguranca.sistema s,
            seguranca.usuario u,
            seguranca.usuario_tipo_usuario utu,
            seguranca.tipo_usuario tp
        WHERE
            (utu.pessoa_id = u.pessoa_id) AND
            (s.sistema_id = tp.sistema_id) AND
            (tp.tipo_usuario_id = utu.tipo_usuario_id) AND
            sistema_st = 0 AND
            u.pessoa_id = " . $_SESSION['UsuarioCodigo'] . "
        ORDER BY
            UPPER(sistema_nm)";


//echo_pre($sqlConsulta);
//REALIZA A CONSULTA
$rsConsulta = pg_query(abreConexao(), $sqlConsulta);

//INICIA A TABELA
//CRIA CONTADOR AUXILIAR
$Colunas = 0;

//REALIZA A IMPRESSÃO DOS SISTEMAS EM TELA
while ($linha = pg_fetch_assoc($rsConsulta)) {
    //INCREMENTA A CONLUNA
    //CAPTURA AS VARIAVEIS DA CONSULTA
    $Codigo = $linha['sistema_id'];
    $Nome = $linha['sistema_nm'];
    $Descricao = $linha['sistema_ds'];
    $URL = $linha['sistema_url'];
    $Icone = $linha['sistema_icone'];
    $ds = $linha['tipo_usuario_ds'];

    //CAPTURA AS VARIAVEIS A SEREM USADAS
    $sistemas[$Codigo] = $ds;
    ?>
 
    <li>
        <?php echo  '<a href="' . $URL . '?sistema=' . $Codigo . '">'?>
        <span class="glyphicon-class"><?php echo '<img style="width:55px" src="https://www.portalsema.ba.gov.br/_portal/Icones/' . $Icone . '" alt="' . $Nome . '" border="0"></a> '; ?></span>
        <span class="" aria-hidden="true"><b><?=$Nome?></b></span>
        <?php echo  '</a>'?>
    </li>
    

    <?php
    /*
      //APRESENTA A COLUNA
      echo '<td>';
      echo '<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="sistema">';
      echo '<tr valing="top">';
      echo '<td><a href="'.$URL.'?sistema='.$Codigo.'"><img style="width:55px" src="https://www.portalsema.ba.gov.br/_portal/Icones/'.$Icone.'" alt="'.$Nome.'" border="0"></a></td>';
      echo '<td title="'.$Descricao.'" align="left"><a href="'.$URL.'?sistema='.$Codigo.'">';
      echo '<span class="titulo">'.$Nome.'</span><br/>';
      //echo ''.$Descricao.'';
      echo ''.F_TruncarString($Descricao, 125).'';
      echo '</a></td>';
      echo '</tr>';
      echo '</table>';
      echo '</td>'; */
    $Colunas++;
}

//CRIANDO A SESSÃO DE SISTEMA
if (isset($_SESSION["Sistemas"])) {
    unset($_SESSION["Sistemas"]);
}

//ATRIBUINDO A SESSÃO DO SISTEMA
$_SESSION["Sistemas"] = $sistemas;
?>