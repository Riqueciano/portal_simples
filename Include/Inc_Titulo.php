<?php
    
    echo $_SESSION['sistema_id'];exit;
    //CASO A PÁGINA LOCAL NÃO EXISTA OU TENHA QUE SER MODIFICADA A MESMA SERÁ
    //PASSADA VIA GET E SERÁ ATRIBUÍDA A VARIÁVEL $PaginaLocal.
    if (isset($_GET['pagina']))
    {
        $PaginaLocal = trim($_GET['pagina']);
    }

    $acao_id = empty($_GET['acao_id'])?0:$_GET['acao_id'];
    $id = empty($_GET['id'])?0:$_GET['id'];

    //COMO O PADRÃO DO SISTEMA ERA PASSAR A AÇÃO ID OU O ID DE FORMA DIRETA E
    //FOI VERIFICADA UMA FALHA POR CAUSA DESTA MODALIDADE FOI CRIADA A MODALIDADE
    //DA PÁGINA LOGO ACIMA, PORÉM POR COMPATIBILIZAÇÃO FOI MANTIDO O PADRÃO
    if (isset($_GET['acao_id']))
    {
        $numCodigoAcao = $acao_id;
    }
    else
    {
        $numCodigoAcao = $id;
    }

    //CASO O ID TENHA SIDO PASSADO A CONSULTA SERÁ FEITA PELO ID QUE É MAIS RÁPIDA
    if($numCodigoAcao != "" )
    {
        $sqlTitulo = "SELECT SE.secao_ds,
                             SA.acao_ds,
                             SA.acao_id,
                             SIS.sistema_nm
                         FROM seguranca.sistema SIS
                             JOIN seguranca.secao SE
                                 ON SIS.sistema_id = SE.sistema_id
                             JOIN seguranca.acao SA
                                 ON SE.secao_id = SA.secao_id
                         WHERE SIS.sistema_id = ".$_SESSION["Sistema"]."
                             AND SA.acao_id = ".$numCodigoAcao;

        $rsTitulo  = pg_query(abreConexao(),$sqlTitulo);
        $linha 	   = pg_fetch_assoc($rsTitulo);

        $sistema_nm                 = trim($linha['sistema_nm']);
        $_SESSION["Titulo"]         = $linha['secao_ds'];
        $_SESSION["SubTitulo"]      = $linha['acao_ds'];
        $_SESSION['acaoCodigo']     = $_GET['id'];
    }
    //SE NÃO FOR PASSADO O ID A PESQUISA SERÁ FEITA PELA PÁGINA LOCAL.
    else
    {

        $sqlTitulo = "SELECT SE.secao_ds,
                             SA.acao_ds,
                             SA.acao_id,
                             SIS.sistema_nm
                         FROM seguranca.sistema SIS
                             JOIN seguranca.secao SE
                                 ON SIS.sistema_id = SE.sistema_id
                             JOIN seguranca.acao SA
                                 ON SE.secao_id = SA.secao_id
                         WHERE SIS.sistema_id = ".$_SESSION["Sistema"]."
                             AND TRIM(SA.acao_url) ILIKE TRIM('".$PaginaLocal."Inicio.%')";
        $rsTitulo  = pg_query(abreConexao(),$sqlTitulo);
        $linha 	   = pg_fetch_assoc($rsTitulo);

        $sistema_nm                 = trim($linha['sistema_nm']);
        $_SESSION["Titulo"]         = $linha['secao_ds'];
        $_SESSION["SubTitulo"]      = $linha['acao_ds'];
        $_SESSION['acaoCodigo']     = $linha['acao_id'];
    }

    //VERIFICA SE O USUÁRIO ESTÁ LOGADO EM UM SISTEMA
    if (trim($_SESSION['Sistema']) != '')
    {
        //CRIA O TITULO
        $Titulo = 'Sistema de '.$sistema_nm;

        //VERIFICA SE EXISTE O TITULO
        if ($_SESSION["Titulo"] != ''){$Titulo .=  ' / '.$_SESSION["Titulo"];}

        //VERIFICA SE EXISTE O SUB TITULO
        if ($_SESSION["SubTitulo"] != ''){$Titulo .=  ' / '.$_SESSION["SubTitulo"];}

        //VERIFICA SE EXISTE AÇÃO TITULO
        if ($_GET['acaoTitulo'] != ''){$Titulo .=  ' / '.$_GET['acaoTitulo'];}

        //ALTERA O TITULO
        echo '<script type="text/javascript" language="javascript">document.title = "'.$Titulo.'";</script>';
    }

    //COMPATIBILIZANDO O CAMINHO DA PASTA DA IMAGEM PARA OS SISTEMAS COM MVC E SEM MVC
    //
    //if (($sistema_nm == 'Reserva') || ($sistema_nm == 'Serviços'))

    if (($_SESSION["Sistema"] == 5) || ($_SESSION["Sistema"] == 6))
    {
        //CAMINHO ESPECÍFICO PARA OS SISTEMAS QUE UTILIZAM O PADRÃO MVC.
        $Caminho_da_pasta = "../../";
    }
    else
    {
        $Caminho_da_pasta = "../";
    }

    //MONTANDO O TÍTULO DA PÁGINA
    if(isset($_GET["acaoTitulo"]))
    {
        $Titulo = $_SESSION["Titulo"]." \ ".$_SESSION["SubTitulo"]." \ ".$_GET["acaoTitulo"];
    }
    else
    {
        $Titulo = $_SESSION["Titulo"]." \ ".$_SESSION["SubTitulo"];
    }
?>
<table cellpadding="2" cellspacing="2" border="0" width="800" class="TabModulo">
    <tr>
        <td align="left" class="titulo_pagina">&nbsp;<?=$Titulo?></td>
        <td width="120" align="right">
            <table width="120" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="40" align="right"><a href="Javascript:history.go(0)"><img alt="" src="<?=$Caminho_da_pasta?>Imagens/refresh.gif" border="0"/></a>&nbsp;</td>
                    <td width="20" align="left"><a href="Javascript:history.go(0)" class="Voltarlink">Refresh&nbsp;</a></td>
                    <td width="20" align="right"><a href='Javascript:window.location.href="<?=$PaginaLocal?>Inicio.php";'><img alt="" src='<?=$Caminho_da_pasta?>Imagens/voltar.gif' border="0"/></a></td>
                    <td width="20" align="left"><a href='Javascript:window.location.href="<?=$PaginaLocal?>Inicio.php";' class='Voltarlink'>Voltar</a></td>
                </tr>
            </table>
        </td>
    </tr>
</table>