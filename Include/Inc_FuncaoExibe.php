<?php

/*
 * *************************************************
  combo que carrega as pessoas juridicas
 * *************************************************
 *
 */

function f_ExibePJ($codigoEscolhido) {
    $sql = "SELECT pessoa_nm FROM dados_unico.pessoa WHERE pessoa_id = '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    if ($linha) {
        echo $linha['pessoa_nm'];
    }
}

/*
 * *************************************************
  exibe a funcao escolhida
 * *************************************************
 *
 */

function f_ConsultaFuncao($codigoEscolhido) {
    $sql = "SELECT funcao_ds FROM dados_unico.funcao WHERE funcao_id = '" . $codigoEscolhido . "'";

    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['funcao_ds'];
}

function f_ConsultaCargo($codigoEscolhido) {
    if ($codigoEscolhido != "" || $codigoEscolhido != 0) {
        $sql = "SELECT cargo_ds FROM dados_unico.cargo WHERE cargo_id = '" . $codigoEscolhido . "'";

        $rs = pg_query(abreConexao(), $sql);
        $linha = pg_fetch_assoc($rs);
        echo $linha['cargo_ds'];
    }
}

function f_ConsultaCargoReturn($codigoEscolhido) {
    if ($codigoEscolhido != 0) {
        $sqlExtra = "SELECT cargo_ds FROM dados_unico.cargo WHERE cargo_id = '" . $codigoEscolhido . "'";
        $rsExtra = pg_query(abreConexao(), $sqlExtra);
        $linhaExtra = pg_fetch_assoc($rsExtra);

        $CargoDS = $linhaExtra['cargo_ds'];
    } else {
        $CargoDS = "";
    }
    return $CargoDS;
}

/*
 * *************************************************
  exibe a lotacao
 * *************************************************
 *
 */

function f_ConsultaLotacao($codigoEscolhido) {
    $sql = "SELECT lotacao_ds FROM dados_unico.lotacao WHERE lotacao_id = '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['lotacao_ds'];
}

/*
 * *************************************************
  exibe o contrato
 * *************************************************
 *
 */

function f_ConsultaContrato($codigoEscolhido) {
    $sql = "SELECT contrato_ds FROM dados_unico.contrato WHERE contrato_id = '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['contrato_ds'];
}

/*
 * *************************************************
  exibe tipo do contrato
 * *************************************************
 *
 */

function f_ConsultaContratoTipo($codigoEscolhido) {
    $sql = "SELECT contrato_tipo_ds FROM dados_unico.contrato_tipo WHERE contrato_tipo_id = '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['contrato_tipo_ds'];
}

/*
  funcao para exibir titulo de formulario
 *
 */

function ExibirTitulo($strTitulo) {
    if ($strTitulo != "") {
        echo "<table cellpadding=0 cellspacing=0 border=0 width=100% height=30><tr><td class=titulo_pagina><font size=1>" . $strTitulo . "</font></td></tr></table>";
    }
}

/*
 * *************************************************
  exibe nome pessoa
 * *************************************************
 *
 */

function f_ConsultaNomeFuncionario($codigoEscolhido) {
    $sql = "SELECT pessoa_nm FROM dados_unico.pessoa p, dados_unico.funcionario f WHERE (p.pessoa_id = f.pessoa_id) AND f.pessoa_id= '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['pessoa_nm'];
}

function f_ConsultaCPFFuncionario($codigoEscolhido) {
    $sql = "   select pessoa_fisica_cpf from dados_unico.pessoa_fisica pf where pf.pessoa_id =  " . (int) $codigoEscolhido . " ";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['pessoa_fisica_cpf'];
}

function f_ConsultaRGFuncionario($codigoEscolhido) {
    $sql = "   select pessoa_fisica_rg from dados_unico.pessoa_fisica pf where pf.pessoa_id =  " . (int) $codigoEscolhido . " ";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['pessoa_fisica_rg'];
}

function f_ConsultaDtNascimentoFuncionario($codigoEscolhido) {
    $sql = "   select pessoa_fisica_dt_nasc from dados_unico.pessoa_fisica pf where pf.pessoa_id =  " . (int) $codigoEscolhido . " ";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['pessoa_fisica_dt_nasc'];
}

function f_ConsultaCelularFuncionario($codigoEscolhido) {
    $sql = "   
select '('||telefone_ddd||')'||telefone_num as celular from dados_unico.telefone where telefone_tipo='M' and pessoa_id =  " . (int) $codigoEscolhido . " ";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['celular'];
}

function f_ConsultaEmailFuncionario($codigoEscolhido) {
    $sql = "   
            select funcionario_email from dados_unico.funcionario where pessoa_id =  " . (int) $codigoEscolhido . " ";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['funcionario_email'];
}

/*
 * *************************************************
  exibe tipo de funcionário
 * *************************************************
 *
 */

function f_ConsultaNomeTipoFuncionario($codigoEscolhido) {
    $sql = "SELECT ft.funcionario_tipo_ds FROM dados_unico.pessoa p, dados_unico.funcionario f, dados_unico.funcionario_tipo ft WHERE (p.pessoa_id = f.pessoa_id) AND (f.funcionario_tipo_id = ft.funcionario_tipo_id) AND f.pessoa_id= '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['funcionario_tipo_ds'];
}

function f_RetornaNomeFuncionario($codigoEscolhido) {
    if ($codigoEscolhido != '') {
        $sql = "SELECT pessoa_nm FROM dados_unico.pessoa p, dados_unico.funcionario f WHERE (p.pessoa_id = f.pessoa_id) AND f.pessoa_id= '" . $codigoEscolhido . "'";
        $rs = pg_query(abreConexao(), $sql);
        $linha = pg_fetch_assoc($rs);
        return $linha['pessoa_nm'];
    } else {
        return '';
    }
}

/*
 * *************************************************
  exibe tipo de passagem
 * *************************************************
 *
 */

function f_ConsultaTipoPassagem($codigoEscolhido) {
    $sql = "SELECT tipo_passagem_ds FROM passagens.tipo_passagem WHERE tipo_passagem_id = '" . ($codigoEscolhido == "" ? "-1" : $codigoEscolhido) . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    return $linha['tipo_passagem_ds'];
}

/*
 * *************************************************
  exibe nome da empresa
 * *************************************************
 *
 */

function f_ConsultaNomeEmpresa($codigoEscolhido) {
    $sql = "SELECT empresa_nm FROM passagens.empresa WHERE empresa_id = '" . ($codigoEscolhido == "" ? "-1" : $codigoEscolhido) . "'";

    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    return $linha['empresa_nm'];
}

/*
 * *************************************************
  exibe nome da categoria da empresa
 * *************************************************
 *
 */

function f_ConsultaNomeCategEmpresa($codigoEscolhido) {
    $sql = "SELECT categoria_transporte_ds FROM passagens.categoria_transporte WHERE categoria_transporte_id = '" . ($codigoEscolhido == "" ? "-1" : $codigoEscolhido) . "'";

    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    return $linha['categoria_transporte_ds'];
}

/*
 * *************************************************
  exibe tipo/quantidade de processos (CAIXA)
 * *************************************************
 *
 */

function f_ConsultaTipoProcesso($codigoEscolhido) {
    $sql = "SELECT caixa_processos_tipo_ds FROM diaria.caixa_processos_tipo d WHERE d.caixa_processos_tipo_id= '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['caixa_processos_tipo_ds'];
}

function f_retornaDescricaoTipoProcesso($codigoEscolhido) {
    $sql = "SELECT caixa_processos_tipo_ds FROM diaria.caixa_processos_tipo d WHERE d.caixa_processos_tipo_id= '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    return $linha['caixa_processos_tipo_ds'];
}

function f_RetornaNomeStatusCaixaDiaria($codigoEscolhido) {
    if ($codigoEscolhido == 0) {
        return "Aberta";
    } else if ($codigoEscolhido == 1) {
        return "Fechada";
    }
}

function f_ConsultaQtdeProcesso($codigoEscolhido) {
    $sql = "SELECT * FROM diaria.caixa_processos_vinculo c WHERE c.caixa_id= '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $qtdeProcessos = pg_num_rows($rs);
    return $qtdeProcessos;
}

/*
 * *************************************************
  exibe numero da diaria/proceso (CAIXA)
 * *************************************************
 *
 */

function f_ConsultaNumeroDiaria($codigoEscolhido) {
    $sql = "SELECT * FROM diaria.diaria d WHERE d.diaria_id= '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['diaria_numero'];
}

function f_BuscaNumeroDiaria($codigoEscolhido) {
    $sql = "SELECT * FROM diaria.diaria d WHERE d.diaria_id= '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    return $linha['diaria_numero'];
}

function f_ConsultaNumeroProcesso($codigoEscolhido) {
    $sql = "SELECT * FROM diaria.diaria d WHERE d.diaria_id= '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    echo $linha['diaria_processo'];
}

function f_ReturnaNumeroProcesso($codigoEscolhido) {
    $sql = "SELECT * FROM diaria.diaria d WHERE d.diaria_id= '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    return $linha['diaria_processo'];
}

function f_BuscaNumeroProcesso($codigoEscolhido) {
    $sql = "SELECT * FROM diaria.diaria d WHERE d.diaria_id= '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    return $linha['diaria_processo'];
}

/*
 * *************************************************
  CONSULTA: QUANTIDADE DE CAIXAS/CRIACAO DA CAIXA
 * *************************************************
 *
 */

function f_ConsultaQtdeCaixas() {
    $sql = "SELECT * FROM diaria.caixa_processos";
    $rs = pg_query(abreConexao(), $sql);
    $qtdeCaixas = pg_num_rows($rs);
    return $qtdeCaixas;
}

function f_MascaraNumeroCaixa($numeroCaixa) {
    if ($numeroCaixa < 10) {
        $numeroCaixa = '00' . $numeroCaixa;
    } else if (($numeroCaixa >= 10) && ($numeroCaixa < 100)) {
        $numeroCaixa = '0' . $numeroCaixa;
    }
    //else if (($numeroCaixa >= 100)&&($numeroCaixa < 1000)){$numeroCaixa = '0'.$numeroCaixa;}

    return $numeroCaixa;
}

function f_ConsultaQtdeCaixasFechadas() {
    $sql = "SELECT * FROM diaria.caixa_processos WHERE caixa_processos_st=1";
    $rs = pg_query(abreConexao(), $sql);
    $qtdeCaixas = pg_num_rows($rs);
    return $qtdeCaixas;
}

function f_ConsultaPosicao($processo_id, $caixa_id) {
    $sql = "SELECT processo_id FROM diaria.caixa_processos_vinculo WHERE caixa_id=" . $caixa_id . "";
    $rs = pg_query(abreConexao(), $sql);

    $contador = 1;
    $posição;
    while ($linha = pg_fetch_assoc($rs)) {
        if ($linha ['processo_id'] == $processo_id) {
            $posição = $contador;
        }

        $contador++;
    }

    return $posição;
}

function f_ConsultaCaixasCriadas($caixa_processos_tipo_id) {
    $sql = "SELECT * FROM diaria.caixa_processos WHERE caixa_processos_tipo_id = " . $caixa_processos_tipo_id . "";
    $rs = pg_query(abreConexao(), $sql);
    $qtdeCaixas = pg_num_rows($rs);
    return $qtdeCaixas;
}

function f_ConsultaCaixasNaoAbertas() {
    $sql = "SELECT caixa_processos_tipo_id FROM diaria.caixa_processos_tipo WHERE caixa_processos_tipo_st=0";
    $rs = pg_query(abreConexao(), $sql);

    $VerificaQtdeTipos = pg_num_rows($rs);
    $VerificaQtdeCaixasAbertasPorTipo = 0;

    while ($tiposCaixa = pg_fetch_assoc($rs)) {
        $sqlSelect = "SELECT * FROM diaria.caixa_processos WHERE caixa_processos_tipo_id = " . $tiposCaixa['caixa_processos_tipo_id'] . "";
        $rsSelect = pg_query(abreConexao(), $sqlSelect);
        $qtdeCaixasAbertasPorTipo = pg_num_rows($rsSelect);

        if ($qtdeCaixasAbertasPorTipo > 0) {
            $VerificaQtdeCaixasAbertasPorTipo = $VerificaQtdeCaixasAbertasPorTipo + 1;
        }
    }

    if ($VerificaQtdeCaixasAbertasPorTipo == $VerificaQtdeTipos) {
        return 1;
    } else {
        return 0;
    }
}

/*
 * *************************************************
  exibe o meio de transporte
 * *************************************************
 *
 */

function f_ExibeMeioTransporte($codigoEscolhido) {
    $sql = "SELECT meio_transporte_ds FROM diaria.meio_transporte WHERE meio_transporte_id = '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    if ($linha) {
        echo $linha['meio_transporte_ds'];
    }
}

/*
 * *************************************************
  exibe o motivo
 * *************************************************
 *
 */

function f_ExibeMotivo($codigoEscolhido) {
    $sql = "SELECT motivo_ds FROM diaria.motivo WHERE motivo_id = '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    if ($linha) {
        echo ($linha['motivo_ds']);
    }
}

/*
 * *************************************************
  exibe o submotivo
 * *************************************************
 *
 */

function f_ExibeSubMotivo($codigoEscolhido) {
    $sql = "SELECT sub_motivo_ds FROM diaria.sub_motivo WHERE sub_motivo_id = '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    if ($linha) {  //
        echo ($linha['sub_motivo_ds']);
    }
}

/*
 * *************************************************
  exibe o projeto
 * *************************************************
 *
 */

function f_ExibeProjeto($codigoEscolhido) {
    if ($codigoEscolhido != '') {
        $sql = "SELECT projeto_cd, projeto_ds FROM diaria.projeto WHERE projeto_cd = '" . $codigoEscolhido . "'";
        $rs = pg_query(abreConexao(), $sql);
        $linha = pg_fetch_assoc($rs);
        if ($linha) {
            echo $linha['projeto_cd'] . " - " . $linha['projeto_ds'];
        }
    }
}

function f_ConsultaProjeto($codigoEscolhido) {
    if ($codigoEscolhido != '') {
        $sql = "SELECT projeto_ds FROM diaria.projeto p WHERE p.projeto_cd= '" . $codigoEscolhido . "'";
        $rs = pg_query(abreConexao(), $sql);
        $linha = pg_fetch_assoc($rs);
        return $linha['projeto_ds'];
    }
}

/*
 * *************************************************
  exibe o unidade de custo
 * *************************************************
 *
 */

function f_ExibeUnidadeCusto($codigoEscolhido) {
    if ($codigoEscolhido != '') {
        $sql = "SELECT est_organizacional_sigla, est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = '" . $codigoEscolhido . "'";
        $rs = pg_query(abreConexao(), $sql);
        $linha = pg_fetch_assoc($rs);
        if ($linha) {
            echo $linha['est_organizacional_sigla'] . " - " . $linha['est_organizacional_ds'];
        }
    }
}

/*
 * *************************************************
  exibe o acao
 * *************************************************
 *
 */

function f_ExibeAcao($codigoEscolhido) {
    if ($codigoEscolhido != '') {
        $sql = "SELECT acao_cd, acao_ds FROM diaria.acao WHERE acao_cd = '" . $codigoEscolhido . "'";
        $rs = pg_query(abreConexao(), $sql);
        $linha = pg_fetch_assoc($rs);
        if ($linha) {
            echo $linha['acao_cd'] . " - " . $linha['acao_ds'];
        }
    }
}

/*
 * *************************************************
  exibe o territorio
 * *************************************************
 *
 */

function f_ExibeTerritorio($codigoEscolhido) {
    $sql = "SELECT territorio_cd, territorio_ds FROM diaria.territorio WHERE territorio_cd = '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    if ($linha) {
        echo $linha['territorio_cd'] . " - " . $linha['territorio_ds'];
    }
}

/*
 * *************************************************
  exibe o fonte
 * *************************************************
 *
 */

function f_ExibeFonte($codigoEscolhido) {
    $sql = "SELECT fonte_cd, fonte_ds FROM diaria.fonte WHERE fonte_cd = '" . $codigoEscolhido . "'";
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    if ($linha) {
        echo $linha['fonte_cd'] . " - " . $linha['fonte_ds'];
    }
}

Function f_ExibeTipoVeiculo($codigoEscolhido) {
    if ($codigoEscolhido != "") {
        $sql = "SELECT tipo_veiculo_ds FROM transporte.tipo_veiculo where tipo_veiculo_id =  " . $codigoEscolhido;

        $rs = pg_query(abreConexao(), $sql);
        $linhars = pg_fetch_assoc($rs);

        if ($linhars) {
            return $linhars['tipo_veiculo_ds'];
        }
    }
}
Function f_ExibeTipoVeiculoTodos($codigoEscolhido) {
    if ($codigoEscolhido != "") {
        $sql = "SELECT tipo_veiculo_ds FROM transporte.tipo_veiculo where tipo_veiculo_id =  " . $codigoEscolhido;

        $rs = pg_query(abreConexao(), $sql);
        $linhars = pg_fetch_assoc($rs);

        if ($linhars) {
            return $linhars['tipo_veiculo_ds'];
        }
    }
}

function f_ConsultaCampoFuncionario($campo, $pessoa = null, $funcionario = null) {

    $comp = "";

    if ($pessoa != null) {
        $comp = " AND p.pessoa_id = " . $pessoa;
    } elseif ($funcionario != null) {
        $comp = " AND f.funcionario_id = " . $funcionario;
    }


    if ($comp != "") {
        $sql = "	SELECT	f.funcionario_email, p.pessoa_nm  
						FROM	dados_unico.pessoa		p, 
								seguranca.usuario		u, 
								dados_unico.funcionario f 
						WHERE	(p.pessoa_id = f.pessoa_id) AND 
								(p.pessoa_id = u.pessoa_id) " . $comp;

        $rs = pg_query(abreConexao(), $sql);
        if (!$rs) {
            echo 'Erro ao realizar procedimento.';
            exit;
        } else {
            $linhaConsultaFunc = pg_fetch_assoc($rs);
            if ($linhaConsultaFunc) {
                if ($campo == 'email') {
                    return $linhaConsultaFunc['funcionario_email'];
                } elseif ($campo == 'nome') {
                    return $linhaConsultaFunc['pessoa_nm'];
                }
            }
        }
    }
}

?>
