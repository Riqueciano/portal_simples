<?php

//VERIFICA NAVEGAÇÃO VINDA DE OUTRA PÁGINA DIFERENTE DA LOCAL
if ($xss->xss_clean($_GET['pagina']) == "") {
    $PaginaLocal = "SolicitacaoAutorizacao";
} else {
    $PaginaLocal = $xss->xss_clean($_GET['pagina']);
}
$_SESSION['OrigemPagina'] = "SolicitacaoAutorizacao";

//CAPTURA O ROTEIRO
$Roteiro = $xss->xss_clean($_GET['roteiro']);
if (($AcaoSistema == "buscar") || ($AcaoSistema == "")) {
    //CAPTURA A ORDENAÇÃO
    if (isset($_GET['order'])) {
        $order = $xss->xss_clean($_GET['order']);
    } else {
        $order = 1;
    }
    $OrderBy = '';

    //VERIFICA A ORDENAÇÃO
    if ($order == 1) {
        $OrderBy = 'ORDER BY passagem_numero';
    } else if ($order == 2) {
        $OrderBy = 'ORDER BY pessoa_nm';
    } else if ($order == 3) {
        $OrderBy = 'ORDER BY passagem_dt_saida';
    } else if ($order == 4) {
        $OrderBy = 'ORDER BY passagem_dt_chegada';
    }

    //VERIFICA E CAPTURA O TIPO DE ORDENAÇÃO (CRESCENTE E DECRESCENTE)
    if (isset($_GET['typeOrder'])) {
        $typeOrder = $xss->xss_clean($_GET['typeOrder']);
    } else {
        $typeOrder = 0;
    }
    if ($typeOrder == 0) {
        $OrderBy = $OrderBy . ' ASC';
        $typeOrder = 1;
    } else if ($typeOrder == 1) {
        $OrderBy = $OrderBy . ' DESC';
        $typeOrder = 0;
    }

    //CAPTURA O TIPO DE SETA
    if ($typeOrder == 0) {
        $seta = 'esconde_filtro';
    } else if ($typeOrder == 1) {
        $seta = 'esconde_filtro2';
    }

    //REALIZA A CONSULTA DE ACORDO COM O FILTRO
    if ($RetornoFiltro != "") {
        //Eric DO
        if ($_SESSION['TipoUsuario'] == 51 || $_SESSION['TipoUsuario'] == 49 || $_SESSION['TipoUsuario'] == 52) {
            $sqlConsulta = "
            SELECT
                *
            FROM
                passagens.passagem ps,
                dados_unico.funcionario f,
                dados_unico.pessoa p
            WHERE
                (p.pessoa_id = f.pessoa_id) AND
                (ps.passagem_beneficiario = f.pessoa_id) AND
				passagem_reembolso_st = 0 AND
                passagem_st = 0 AND
				passagem_devolvida = 0 AND
                passagem_cancelada = 0 AND
                passagem_excluida = 0 AND
                (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR passagem_numero ILIKE '%" . $RetornoFiltro . "%')
           " . $OrderBy . "";
        } else {
            //CONSULTA COM FILTRO
            $sqlConsulta = "
            SELECT
                *
            FROM
                passagens.passagem ps,
                dados_unico.funcionario f,
                dados_unico.pessoa p
            WHERE
                (p.pessoa_id = f.pessoa_id) AND
                (ps.passagem_beneficiario = f.pessoa_id) AND
				passagem_reembolso_st = 0 AND
                passagem_st = 0 AND
				passagem_devolvida = 0 AND
                passagem_cancelada = 0 AND
                passagem_excluida = 0 AND
                (pessoa_nm ILIKE '%" . $RetornoFiltro . "%' OR passagem_numero ILIKE '%" . $RetornoFiltro . "%')
            " . $OrderBy . "";
        }
    } else {
        //Eric DO
        //if( $_SESSION['TipoUsuario'] == 46 || intval($_GET["codDO"]) == 46)
        if ($_SESSION['TipoUsuario'] == 51 || $_SESSION['TipoUsuario'] == 49 || $_SESSION['TipoUsuario'] == 52) {
            $sqlConsulta = "
            SELECT
                *
            FROM
				passagens.passagem ps,
                dados_unico.funcionario f,
                dados_unico.pessoa p
            WHERE
                (p.pessoa_id = f.pessoa_id) AND
                (ps.passagem_beneficiario = f.pessoa_id) AND
				passagem_reembolso_st = 0 AND
                passagem_st = 0 AND
				passagem_devolvida = 0 AND
                passagem_excluida = 0 AND
                passagem_cancelada = 0
            " . $OrderBy . "";
        } else {
            //CONSULTA SEM FILTRO
            $sqlConsulta = "
            SELECT
                *
            FROM
                passagens.passagem ps,
                dados_unico.funcionario f,
                dados_unico.pessoa p
            WHERE
                (p.pessoa_id = f.pessoa_id) AND
                (ps.passagem_beneficiario = f.pessoa_id) AND
				passagem_reembolso_st = 0 AND
                passagem_st = 0 AND
				passagem_devolvida = 0 AND
                passagem_excluida = 0 AND
                passagem_cancelada = 0
            " . $OrderBy . "";
        }
    }

    //DEFININDO CAIXA ALTA PARA A QUERY
    $sqlConsulta = strtoupper($sqlConsulta);
    //echo $sqlConsulta;
    //REALIZANDO A CONSULTA
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
} else if ($AcaoSistema == "autorizar") {

    if (intval($xss->xss_clean($_SESSION['UsuarioCodigo'])) == 0) {
        //DESTROI AS SESSÕES DE LOGIN E DEMAIS SESSÕES
        session_destroy();
        //RETORNA PARA A TELA DE LOGIN
        header("Location: ../Home/Login.php");
        exit;
    }


    $Date = date("Y-m-d");
    $Codigo = intval($xss->xss_clean($_GET['cod']));
    $Time = date("H:i:s");
    //$Processo	= $xss->xss_clean($_POST['ProcessoNum']);
    //$Reembolso				= $xss->xss_clean($_REQUEST['txtValReembolso']);

    $sqlConsulta = "SELECT * FROM passagens.passagem ps, dados_unico.funcionario f, dados_unico.pessoa p WHERE (p.pessoa_id = f.pessoa_id) AND (ps.passagem_beneficiario = f.pessoa_id) AND ps.passagem_id = " . $Codigo;
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
    $linha = pg_fetch_assoc($rsConsulta);

    /* if($linha){

      if($linha['passagem_reembolso_valor'] != ""){

      $sqlAltera = "UPDATE passagens.passagem SET passagem_reembolso_st = 1 WHERE passagem_id IN (" .$Codigo. ")";

      pg_query(abreConexao(),$sqlAltera);
      }


      } */

    if ($_SESSION['TipoUsuario'] == 49 || $_SESSION['TipoUsuario'] == 51 || $_SESSION['TipoUsuario'] == 52) {
        $sqlAltera = "UPDATE passagens.passagem SET passagem_st = 1 WHERE passagem_id IN (" . $Codigo . ")";
    }


    pg_query(abreConexao(), $sqlAltera);

    $sqlConsulta = "SELECT funcionario_id FROM dados_unico.funcionario WHERE pessoa_id = " . intval($xss->xss_clean($_SESSION['UsuarioCodigo']));
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);
    $linha = pg_fetch_assoc($rsConsulta);
    //Eric DO
    if ($_SESSION['TipoUsuario'] == 49 || $_SESSION['TipoUsuario'] == 51 || $_SESSION['TipoUsuario'] == 52) {
        $sqlInsere = "INSERT INTO passagens.passagem_autorizacao (passagem_id, passagem_autorizacao_func, passagem_autorizacao_func_exec, passagem_autorizacao_dt, passagem_autorizacao_hr) VALUES (" . $Codigo . ", " . $linha['funcionario_id'] . ", 10, '" . $Date . "', '" . $Time . "')";
    }

    pg_query(abreConexao(), $sqlInsere);


    //Envia email para Aprovador
    /* $sqAutorizador = "SELECT pessoa_id
      FROM passagens.email_tipo_usuario
      WHERE tipo_usuario_id = 52 AND est_organizacional_id = (select ef.est_organizacional_id from dados_unico.funcionario df, dados_unico.est_organizacional_funcionario ef where df.pessoa_id =".intval($xss->xss_clean($_SESSION['UsuarioCodigo']))." AND df.funcionario_id = ef.funcionario_id);";

      $rsAutorizador = pg_query(abreConexao(),$sqAutorizador);
      while($lin=pg_fetch_assoc($rsAutorizador)) {
      Util::sendMailPassagem($lin['pessoa_id'], "Aprovador","");
      } */

    echo "<script>window.location = 'SolicitacaoAutorizacaoInicio.php ';</script>";
}
?>
