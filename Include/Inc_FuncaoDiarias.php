<?php

/* * *****************************************************************************
  Copyright 2012 SEMA - Secretaria do Meio Ambiente - Bahia. All Rights Reserved.
  @co-author danillobs@gmail.com (Danillo Barreto)
 * ***************************************************************************** */
/* * *****************************************************************************
  FUNÇÃO QUE REALIZA A CONSULTA OS MOTIVOS DAS SOLICITAÇÕES DAS DIÁRIAS
  POR ISSO NECESSITA QUE SEJA PASSADO O TIPO COMO PARAMETRO.
  OS TIPOS SÃO:(1-cancelamento, 2-devolucao, 3-solicitacao)
 * ***************************************************************************** */

function f_ComboMotivoDiariaDevolver($NomeCombo, $codigoEscolhido, $Tipo, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos) {
    /*     * ***************************************************************************
     * $NomeCombo = é o NOME do combo que será passado para a função.
     * $codigoEscolhido = é o CÓDIGO do município que está sendo passado.
     * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
     * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
     * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
     * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
     * *************************************************************************** */
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    $sqlMotivo = "SELECT * 
                FROM diaria.motivo 
                WHERE (motivo_tipo_id = '" . $Tipo . "'" . ") 
                    AND (motivo_st = 0) 
                    AND (motivo_id <> 0) 
                ORDER BY UPPER(motivo_ds)";

    $rsMotivo = pg_query(abreConexao(), $sqlMotivo);

    $String = RetornarQtdeTracos($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    while ($linhaMotivo = pg_fetch_assoc($rsMotivo)) {
        $codigo = $linhaMotivo['motivo_id'];
        $descricao = $linhaMotivo['motivo_ds'];
        if ((int) ($codigoEscolhido) == (int) ($codigo)) {
            echo "<option value=" . $codigo . " selected>" . ($descricao) . "</option>";
        } else {
            echo "<option value=" . $codigo . ">" . ($descricao) . "</option>";
        }
    }
    echo "</select>";
}

function f_ComboMotivoDiaria($NomeCombo, $codigoEscolhido, $Tipo, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos) {
    /*     * ***************************************************************************
     * $NomeCombo = é o NOME do combo que será passado para a função.
     * $codigoEscolhido = é o CÓDIGO do município que está sendo passado.
     * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
     * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
     * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
     * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
     * *************************************************************************** */
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    $sqlMotivo = "SELECT * 
                FROM diaria.motivo 
                WHERE (motivo_tipo_id = '" . $Tipo . "'" . ") 
                    AND (motivo_st = 0)";
    if ($Tipo != 2 and $Tipo != 1) {
        $sqlMotivo .=" and motivo_id > 161 /* 03-08-2015*/";
    }
   
 $sqlMotivo .=" AND (motivo_id <> 0)  ";


    $sqlMotivo .="ORDER BY UPPER(motivo_ds)";
    //echo $sqlMotivo;exit;
    $rsMotivo = pg_query(abreConexao(), $sqlMotivo);

    $String = RetornarQtdeTracos($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    while ($linhaMotivo = pg_fetch_assoc($rsMotivo)) {
        $codigo = $linhaMotivo['motivo_id'];
        $descricao = $linhaMotivo['motivo_ds'];
        if ((int) ($codigoEscolhido) == (int) ($codigo)) {
            echo "<option value=" . $codigo . " selected>" . ($descricao) . "</option>";
        } else {
            echo "<option value=" . $codigo . ">" . ($descricao) . "</option>";
        }
    }
    echo "</select>";
}


/* * *****************************************************************************
  Consulta os submotivos das solicitacoes de diarias,
  por isso passa o parametro motivo
 * ***************************************************************************** */

function f_ComboSubMotivoDiaria($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos) {
    /*     * ***************************************************************************
     * $NomeCombo = é o NOME do combo que será passado para a função.
     * $codigoEscolhido = é o CÓDIGO do município que está sendo passado.
     * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
     * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
     * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
     * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
     * *************************************************************************** */
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    $sqlSubMotivo = "SELECT * 
                        FROM diaria.sub_motivo 
                        WHERE (sub_motivo_st = 0) 
                            AND (sub_motivo_id <> 0) and sub_motivo_id > 131 /* 03-08-2015 */
                        ORDER BY UPPER(sub_motivo_ds)";
    $rsSubMotivo = pg_query(abreConexao(), $sqlSubMotivo);

    $String = RetornarQtdeTracos($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    while ($linhaSubMotivo = pg_fetch_assoc($rsSubMotivo)) {
        $codigo = $linhaSubMotivo['sub_motivo_id'];
        $descricao = $linhaSubMotivo['sub_motivo_ds'];
        if ((int) ($codigoEscolhido) == (int) ($codigo)) {
            echo "<option value=" . $codigo . " selected>" . utf8_decode($descricao) . "</option>";
        } else {
            echo "<option value=" . $codigo . ">" . utf8_decode($descricao) . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  função para carregar tipos dos motivos
 * ***************************************************************************** */

function ComboMotivoTipo($cod) {
    echo "<select id='cmbMotivoTipo' name='cmbMotivoTipo' style='width:202px;'>";
    $sql = "SELECT motivo_tipo_id, motivo_tipo_ds FROM diaria.motivo_tipo WHERE (motivo_tipo_st = 0) AND (motivo_tipo_id <> 0) ORDER BY UPPER(motivo_tipo_ds)";
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[-------------------- Selecione -------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ((int) $cod == (int) ($linha['motivo_tipo_id'])) {
            echo "<option value=" . $linha['motivo_tipo_id'] . " selected>" . $linha['motivo_tipo_ds'] . "</option>";
        } else {
            echo "<option value=" . $linha['motivo_tipo_id'] . ">" . $linha['motivo_tipo_ds'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  função para carregar tipos de acao
 * ***************************************************************************** */

function f_ComboAcaoTipo($codigoEscolhido) {
    switch ($codigoEscolhido) {
        case "D":
            $AcaoD = "selected";
            break;
        case "NDC":
            $AcaoNDC = "selected";
            break;
        case "NDNC":
            $AcaoNDNC = "selected";
            break;
        case "NF-Não Informado":
            $AcaoNF = "selected";
            break;
    }
    echo "<select id='cmbAcaoTipo' name='cmbAcaoTipo' style='width:114px;'>";
    echo "<option value=0>[----- Selecione -----]</option>";
    echo "<option value=D " . $AcaoD . ">D</option>";
    echo "<option value=NDC " . $AcaoNDC . ">NDC</option>";
    echo "<option value=NDNC " . $AcaoNDNC . ">NDNC</option>";
    echo "<option value=NF-Não Informado " . $AcaoNF . ">NF-Não Informado</option>";
    echo "</select>";
}

/* * *****************************************************************************
  projetos
 * ***************************************************************************** */

function f_ComboProjeto($codigoEscolhido, $FuncaoJavaScript) {
    echo "<select id='cmbProjeto' name='cmbProjeto' style='width:785px;' " . $FuncaoJavaScript . ">";
    $sql = "SELECT projeto_cd, projeto_ds FROM diaria.projeto WHERE projeto_st = 0 ORDER BY projeto_cd";
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ( $codigoEscolhido ==  ($linha['projeto_cd'])) {
            echo "<option value=" . $linha['projeto_cd'] . " selected>" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
        } else {
            echo "<option value=" . $linha['projeto_cd'] . ">" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  projetos da unidade custo
  Data........: 20/02/2014
  Comentário..: Listar apenas os projetos da unidade de custo, a pedido da DO
 * ***************************************************************************** */

function f_ComboProjetoUnidade($codigoEscolhido, $FuncaoJavaScript, $unidadeCusto) {
    echo "<select id='cmbProjeto' name='cmbProjeto' style='width:785px;' " . $FuncaoJavaScript . ">";
    $sql = "SELECT projeto_cd, projeto_ds FROM diaria.projeto WHERE projeto_st = 0 and est_organizacional_id = " . $unidadeCusto . " ORDER BY projeto_cd";
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido ==  ($linha['projeto_cd'])) {
            echo "<option value=" . $linha['projeto_cd'] . " selected>" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
        } else {
            echo "<option value=" . $linha['projeto_cd'] . ">" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  Carrega todos os convênios válidos (que não estão vencidos)
 * ***************************************************************************** */

function f_Convenio($codigoEscolhido) {
    /*3;"BAHIATER"
      4;"CDA"
      2;"APG"
      5;"CAR"
    */
//echo     $_SESSION['unidade_orcamentaria_id'];

switch ($_SESSION['unidade_orcamentaria_id']) {
    case 3:
        $unidade_orcamentaria_nm = 'BAHIATER';
        $whereUnidade = "AND est_organizacional_sigla ilike '%$unidade_orcamentaria_nm%'";
        break;
    case 4:
        $unidade_orcamentaria_nm = 'CDA';
        $whereUnidade = "AND est_organizacional_sigla ilike '%$unidade_orcamentaria_nm%'";
        break;
    case 2:
        $unidade_orcamentaria_nm = '';
        $whereUnidade = "AND est_organizacional_sigla not ilike '%BAHIATER%' and est_organizacional_sigla not ilike '%CDA%'";
        break;
    case 5:
        $unidade_orcamentaria_nm = 'CAR';
        $whereUnidade = "AND est_organizacional_sigla ilike '%$unidade_orcamentaria_nm%'";
        break;

    default:
        $whereUnidade = '';
        break;
}
    
    
    $sqlConsulta = "SELECT projeto_cd, projeto_ds, convenio_dt_vencimento, projeto_convenio FROM diaria.projeto p 
                        inner join dados_unico.est_organizacional eo
                                on eo.est_organizacional_id = p.est_organizacional_id
                WHERE projeto_st = 0 AND convenio_dt_vencimento > to_date('" . date("Y-m-d") . "', 'YYYY-MM-DD') AND projeto_convenio = 1 
                    $whereUnidade
                 ORDER BY projeto_cd";
  //echo_pre($sqlConsulta);
    echo "<select id='cmbConvenio' name='cmbConvenio' style='width:785px;' >";
    
    $rs = pg_query(abreConexao(), $sqlConsulta);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    while ($linhars = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido ==  ($linhars['projeto_cd'])) {
            echo "<option value=" . $linhars['projeto_cd'] . " selected>" . $linhars['projeto_cd'] . " ----> " . $linhars['projeto_ds'] . "</option>";
        } else {
            echo "<option value=" . $linhars['projeto_cd'] . ">" . $linhars['projeto_cd'] . " ----> " . $linhars['projeto_ds'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  COMBO QUE EXIBE A(S) AÇÃO(ÕES)
 * ***************************************************************************** */

function f_ComboAcao($codigoEscolhido, $projeto, $FuncaoJavaScript) {
   
    echo "<select id='cmbAcao' name='cmbAcao' style='width:785px;' " . $FuncaoJavaScript . ">";
    if ($projeto == "") {
        $sql = "SELECT DISTINCT acao_cd, acao_sequencial, acao_ds FROM diaria.acao WHERE acao_st = 0 ORDER BY acao_cd";
    } else {
        $sql = "SELECT DISTINCT a.acao_cd, acao_sequencial, acao_ds FROM diaria.acao a, diaria.projeto_acao_territorio pat WHERE projeto_cd = '" . $projeto . "'" . " AND (a.acao_cd = pat.acao_cd) AND acao_st = 0 ORDER BY acao_cd";
    }

    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ((int) $codigoEscolhido == (int) ($linha['acao_cd'])) {
            echo "<option value=" . $linha['acao_cd'] . " selected>" . $linha['acao_cd'] . "." . $linha['acao_sequencial'] . " ----> " . $linha['acao_ds'] . "</option>";
        } else {
            echo "<option value=" . $linha['acao_cd'] . ">" . $linha['acao_cd'] . "." . $linha['acao_sequencial'] . " ----> " . $linha['acao_ds'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  COMBO QUE EXIBE O(S) TERRITÓRIO(S)
 * ***************************************************************************** */

function f_ComboTerritorio($acao, $codigoEscolhido, $FuncaoJavaScript, $Tamanho) {
    //CONSULTA DOS IDS E DAS DESCRIÇÕES ATIVAS
    if ($acao == "") {
        //CONSULTA TODOS OS TERRITÓRIOS QUE FORAM ASSOCIADOS E NÃO FORAM REMOVIDOS
        /* $sql = "
          SELECT DISTINCT territorio_cd,
          territorio_ds
          FROM diaria.territorio
          WHERE territorio_st = 0 AND
          territorio_cd IN
          (SELECT territorio_cd
          FROM diaria.projeto_acao_territorio
          WHERE projeto_acao_territorio_st <> 2
          GROUP BY territorio_cd)
          ORDER BY territorio_cd"; */

        $sql = "SELECT DISTINCT territorio_cd, territorio_ds 
				FROM diaria.territorio 
				WHERE territorio_st = 0 
				ORDER BY territorio_cd";
    } else {
        //CONSULTA TODOS OS TERRITORIOS DA AÇÃO / PRODUTO QUE FORAM ASSOCIADOS E NÃO FORAM REMOVIDOS
        $sql = "SELECT DISTINCT t.territorio_cd,
                           territorio_ds
                    FROM diaria.territorio t,
                         diaria.projeto_acao_territorio pat
                    WHERE pat.acao_cd = '" . $acao . "' AND
                          t.territorio_cd = pat.territorio_cd AND
                          territorio_st = 0 AND
                          projeto_acao_territorio_st <> 2
                    ORDER BY t.territorio_cd";

        /* $sql = "SELECT DISTINCT t.territorio_cd, territorio_ds 
          FROM diaria.territorio t, diaria.projeto_acao_territorio pat
          WHERE pat.acao_cd = '".$acao."' AND (t.territorio_cd = pat.territorio_cd) AND territorio_st = 0 ORDER BY t.territorio_cd"; */
    }
    //REALIZA A CONSULTA
    $rs = pg_query(abreConexao(), $sql);
    //DEFINDO O NOME E TAMANHO DO COMBO BOX CONFORME SETADO AO CHAMAR A FUNÇÃO
    echo "<select id='cmbTerritorio' name='cmbTerritorio' style='width: " . $Tamanho . ";' " . $FuncaoJavaScript . ">";
    //INICIA A CRIAÇÃO DO COMBO
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    //INICIA A CRIAÇÃO DO COMBO
    //PRENCHE O COMBO
    while ($linha = pg_fetch_assoc($rs)) {
        //VERIFICA SE O VALOR CAPTURADO É O MESMO QUE RECEBIDO PELA FUNÇÃO E MARCA COMO SELECIONADO
        if ((int) $codigoEscolhido == (int) $linha['territorio_cd']) {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $linha['territorio_cd'] . " selected>" . $linha['territorio_cd'] . " ----> " . $linha['territorio_ds'] . "</option>";
        } else {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $linha['territorio_cd'] . ">" . $linha['territorio_cd'] . " ----> " . $linha['territorio_ds'] . "</option>";
        }
    }
    //FINALIZA O COMBO
    echo "</select>";
}

/* * *****************************************************************************
  COMBO QUE EXIBE O(S) MEIO(S) DE TRANSPORTE
 * ***************************************************************************** */

function f_ComboMeioTransporte($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos) {
    /*     * ***************************************************************************
     * $NomeCombo = é o NOME do combo que será passado para a função.
     * $codigoEscolhido = é o CÓDIGO do município que está sendo passado.
     * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
     * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
     * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
     * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
     * *************************************************************************** */
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    $sql = "SELECT * 
                FROM diaria.meio_transporte 
                WHERE meio_transporte_st = 0 
                ORDER BY UPPER(meio_transporte_ds)";
    $rs = pg_query(abreConexao(), $sql);

    $String = RetornarQtdeTracos($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        $codigo = $linha['meio_transporte_id'];
        $descricao = $linha['meio_transporte_ds'];
        if ((int) ($codigoEscolhido) == (int) ($codigo)) {
            echo "<option value=" . $codigo . " selected>" . $descricao . "</option>";
        } else {
            echo "<option value=" . $codigo . ">" . $descricao . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  COMBO QUE EXIBE OS AUTORIZADORE(S) DA UNIDADE(S) DE CUSTO
 * ***************************************************************************** */

function f_ComboAutorizador($codigoEscolhido, $Contador) {
    echo "<select id='cmbAutorizador" . $Contador . "' name='cmbAutorizador" . $Contador . "' style=width:382px>";

    $sql = "SELECT f.pessoa_id, 
                   pessoa_nm 
               FROM dados_unico.pessoa p
               JOIN dados_unico.funcionario f
                    ON p.pessoa_id = f.pessoa_id 
               JOIN seguranca.usuario_tipo_usuario utu 
                    ON p.pessoa_id = utu.pessoa_id 
                        AND (tipo_usuario_id = 5 OR tipo_usuario_id = 6 or tipo_usuario_id = 91 or tipo_usuario_id = 120 or tipo_usuario_id = 121)
               WHERE pessoa_st = 0 
               ORDER BY UPPER(pessoa_nm)";
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[--------------------------------------------------- Selecione ------------------------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido != "") {
            if ((int) $codigoEscolhido == (int) ($linha['pessoa_id'])) {
                echo "<option value=" . $linha['pessoa_id'] . " selected>" . $linha['pessoa_nm'] . "</option>";
            } else {
                echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
            }
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}
function f_ComboAutorizadorSetaf($codigoEscolhido, $Contador, $param=null) {
    $sql = "
                select * from dados_unico.pessoa p
                    
                where p.setaf_id is not null
                 and p.pessoa_st = 0  $param
                   ORDER BY UPPER(p.pessoa_nm)";
   // echo $sql;
    echo "<select id='cmbAutorizador" . $Contador . "' name='cmbAutorizador" . $Contador . "' style=width:382px>";

    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[--------------------------------------------------- Selecione ------------------------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido != "") {
            if ((int) $codigoEscolhido == (int) ($linha['pessoa_id'])) {
                echo "<option value=" . $linha['pessoa_id'] . " selected>" . $linha['pessoa_nm'] . "</option>";
            } else {
                echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
            }
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}



/* * *****************************************************************************
  COMBO QUE EXIBE OS APROVADORES(S) DA UNIDADE(S) DE CUSTO
 * ***************************************************************************** */

function f_ComboAprovador($codigoEscolhido, $Contador) {
    echo "<select id='cmbAprovador" . $Contador . "' name='cmbAprovador" . $Contador . "' style=width:280px>";

    $sql = "SELECT distinct f.pessoa_id, 
                   pessoa_nm 
               FROM dados_unico.pessoa p
               JOIN dados_unico.funcionario f
                    ON p.pessoa_id = f.pessoa_id 
               JOIN seguranca.usuario_tipo_usuario utu 
                    ON p.pessoa_id = utu.pessoa_id 
                        
               inner join  seguranca.tipo_usuario tu
	            on tu.tipo_usuario_id = utu.tipo_usuario_id         
               WHERE pessoa_st = 0 AND tu.tipo_usuario_id in(6,149)
                ";
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[-------------------------------- Selecione --------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido != "") {
            if ((int) $codigoEscolhido == (int) ($linha['pessoa_id'])) {
                echo "<option value=" . $linha['pessoa_id'] . " selected>" . $linha['pessoa_nm'] . "</option>";
            } else {
                echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
            }
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}

function f_ComboAprovadorAutorizadorGeral($codigoEscolhido, $Contador,$perfil ,$sistema_id) {
    echo "<select id='cmbAprovador" . $Contador . "' name='cmbAprovador" . $Contador . "' style=width:280px>";

    $sql = "SELECT *
               FROM dados_unico.pessoa p
               JOIN dados_unico.funcionario f
                    ON p.pessoa_id = f.pessoa_id 
               JOIN seguranca.usuario_tipo_usuario utu 
                    ON p.pessoa_id = utu.pessoa_id 
                        
		inner join seguranca.tipo_usuario tu
			on tu.tipo_usuario_id = utu.tipo_usuario_id
               WHERE pessoa_st = 0 AND tu.tipo_usuario_ds ilike '$perfil' and sistema_id = $sistema_id
               ORDER BY UPPER(pessoa_nm)"
;
//echo_pre($sql);
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[-------------------------------- Selecione --------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido != "") {
            if ((int) $codigoEscolhido == (int) ($linha['pessoa_id'])) {
                echo "<option value=" . $linha['pessoa_id'] . " selected>" . $linha['pessoa_nm'] . "</option>";
            } else {
                echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
            }
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}


function f_ComboDiariasDf($name, $unidade_orcamentaria_id,$javascript) {
     $unidadeOrc = array(
     '3'=>"BAHIATER"
    ,'4'=>"CDA"
    ,'2'=>"APG"
    ,'5'=>"CAR");
if($unidade_orcamentaria_id != ''){
    if($unidade_orcamentaria_id==2){
        $where .= "  and eo.est_organizacional_sigla NOT ilike '%".'CDA'."%'";
        $where .= "  and eo.est_organizacional_sigla NOT ilike '%".'BAHIATER'."%'";
        $where .= "  and eo.est_organizacional_sigla NOT ilike '%".'CAR'."%'";
    }
    
    if($unidade_orcamentaria_id==3){
        $where .= "  and eo.est_organizacional_sigla  ilike '%".'BAHIATER'."%'";
    }
    if($unidade_orcamentaria_id==5){
        $where .= "  and eo.est_organizacional_sigla  ilike '%".'CAR'."%'";
    }
    if($unidade_orcamentaria_id==4){
        $where .= "  and eo.est_organizacional_sigla  ilike '%".'CDA'."%'";
    }
 }else{
     $where='';
 }

    echo "<select id='$name" .  "' name='$name" . "' onchange='$javascript'>";

    $sql = "select * from diaria.diaria d
            inner join diaria.status st on st.status_cd::float = diaria_st::float
            inner join diaria.diaria_financeiro df on df.diaria_id = d.diaria_id

            inner join dados_unico.funcionario f 
                on d.diaria_beneficiario = f.pessoa_id 
            inner join dados_unico.est_organizacional_funcionario eof 
                on eof.funcionario_id = f.funcionario_id 
            inner join dados_unico.est_organizacional eo 
                on eo.est_organizacional_id = eof.est_organizacional_id and est_organizacional_funcionario_st =0
                where 1=1 $where
            order by trim(diaria_numero)::bigint";
    
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=''>.:Selecione:.</option>";
    while ($linha = pg_fetch_assoc($rs)) {
         echo "<option value=" . $linha['diaria_id'] . ">" . $linha['diaria_numero'] . "</option>";
    }
    echo "</select>";
}
function f_ComboPendenciaStatus($name, $javascript) {

    

    echo "<select id='$name" .  "' name='$name" . "' onchange='$javascript'>";

    $sql = "select * from diaria.pendencia_status s order by pendencia_ds";
    
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=''>.:Selecione:.</option>";
    while ($linha = pg_fetch_assoc($rs)) {
         echo "<option value=" . $linha['pendencia_status_id'] . ">" . $linha['pendencia_ds'] . "</option>";
    }
    echo "</select>";
}

/* * *****************************************************************************
  COMBO QUE EXIBE A(S) FONTE(S)
 * ***************************************************************************** */

function f_ComboFonte($codigoEscolhido, $Tamanho) {
    echo "<select id='cmbFonte' name='cmbFonte' onChange=\"$('#cmbFonte').attr('style', 'width:785px; background-color:white;');\" style=width:" . $Tamanho . "px>";
    $sql = "SELECT * FROM diaria.fonte WHERE fonte_st = 0 ORDER BY fonte_cd";
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == "") {
            if ((int) ($linha['fonte_padrao']) == 1) {
                echo "<option value=" . $linha['fonte_cd'] . " selected>" . $linha['fonte_cd'] . " - " . $linha['fonte_ds'] . "</option>";
            } else {
                echo "<option value=" . $linha['fonte_cd'] . ">" . $linha['fonte_cd'] . " - " . $linha['fonte_ds'] . "</option>";
            }
        } else {
            if ((int) $codigoEscolhido == (int) ($linha['fonte_cd'])) {
                echo "<option value=" . $linha['fonte_cd'] . " selected>" . $linha['fonte_cd'] . " - " . $linha['fonte_ds'] . "</option>";
            } else {
                echo "<option value=" . $linha['fonte_cd'] . ">" . $linha['fonte_cd'] . " - " . $linha['fonte_ds'] . "</option>";
            }
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  municipio
 * ***************************************************************************** */

function f_ComboMunicipioDiaria($codigoEscolhido) {
    echo "<select id='cmbMunicipio' name='cmbMunicipio' style=width:785>";
    $sql = "SELECT * FROM dados_unico.municipio WHERE estado_uf = '" . $codigoEscolhido . "' ORDER BY UPPER(municipio_ds)";
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    echo "<option value=0></option>";
    while ($linha = pg_fetch_assoc($rs)) {
        $codigo = $linha['municipio_cd'];
        $descricao = $linha['municipio_ds'];
        echo "<option value=" . $codigo . ">" . $descricao . "</option>";
    }
    echo "</select>";
}

/* * *****************************************************************************
  Combo do TIPO DE DOCUMENTO quando a Diaria foi INDENIZADA
 * ***************************************************************************** */

function f_ComboDocumento($codigoEscolhido) {
    echo "<select id='cmbDocumento' name='cmbDocumento' style=width:240px >";
    $sqlConsulta = "SELECT * FROM diaria.diaria_tipo_doc";
    $rs = pg_query(abreConexao(), $sqlConsulta);
    echo "<option value=0>[-------------------------- Selecione --------------------------]</option>";
    echo "<option value=0></option>";
    while ($linhars = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == ($linhars['diaria_tipo_doc_id'])) {
            echo "<option value=" . $linhars['diaria_tipo_doc_id'] . " selected>" . $linhars['diaria_tipo_doc_ds'] . "</option>";
        } else {
            echo "<option value=" . $linhars['diaria_tipo_doc_id'] . ">" . $linhars['diaria_tipo_doc_ds'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  FUNÇÃO QUE RETORNA O VALOR REFERÊNCIA PARA O CÁLCULO DA DIÁRIA
  O VALOR REFERÊNCIA É BASEADO NO CARGO TEMPORÁRIO E NO CARGO PERMANENTE
 * ***************************************************************************** */

function f_ValorReferencia($CodBeneficiario, $DataPartida, $DirigenteMaior, $Precursor, $TipoChamada) {
    $TemporarioValor = false;
    $PermanenteValor = false;
    $DirigenteMaior = (int) $DirigenteMaior;
    if (($Precursor == 'true') || ($TipoChamada == 'Assessor')) {
        if (($DirigenteMaior != '0') || ($DirigenteMaior != '')) {
            //CASO O ID PASSADO SEJA 3 - CHEFE DE CERIMONIAL, RETORNARÁ O CARGO DO GOVERNADOR
            if ($DirigenteMaior == 3) {
                $sql = "SELECT F.cargo_temporario, F.cargo_permanente
                            FROM dados_unico.funcionario F
                            JOIN dados_unico.funcao_dirigente_funcionario FDF
                                ON F.funcionario_id = FDF.func_dir_funcionario_id_funcionario
                            JOIN dados_unico.funcao_dirigente FD
                                ON FDF.func_dir_funcionario_funcao_id = FD.funcao_dirigente_id
                                    AND FDF.func_dir_funcionario_status = 0
                                    AND FD.funcao_dirigente_id = 1";
            } else {
                $sql = "SELECT F.cargo_temporario, F.cargo_permanente
                            FROM dados_unico.funcionario F
                            JOIN dados_unico.funcao_dirigente_funcionario FDF
                                ON F.funcionario_id = FDF.func_dir_funcionario_id_funcionario
                            JOIN dados_unico.funcao_dirigente FD
                                ON FDF.func_dir_funcionario_funcao_id = FD.funcao_dirigente_id
                                    AND FDF.func_dir_funcionario_status = 0
                                    AND FD.funcao_dirigente_id = '" . $DirigenteMaior . "'";
            }
        }
    } else {
        $sql = "SELECT cargo_temporario, cargo_permanente
                    FROM dados_unico.funcionario
                    WHERE pessoa_id = '" . $CodBeneficiario . "'";
    }
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    //VERIFICANDO O CARGO TEMPORÁRIO DO BENEFICIÁRIO
    if ($linha['cargo_temporario'] != 0) {
        $CargoTemporario = $linha['cargo_temporario'];
        if (!empty($DataPartida)) {
            $sql1 = "SELECT cl.classe_id, classe_nm, cv.classe_valor
                            FROM dados_unico.cargo ca,
                                 diaria.classe cl,
                                 diaria.classe_valor cv
                            WHERE (ca.classe_id = cl.classe_id)
                                AND (cl.classe_id = cv.classe_id) 
                                AND to_date('" . $DataPartida . "','DD/MM/YYYY') BETWEEN classe_valor_dt_vigencia_inicio
                                        AND classe_valor_dt_vigencia_fim
                                AND cargo_id = '" . $CargoTemporario . "'";
            $rs1 = pg_query(abreConexao(), $sql1);
            $linha1 = pg_fetch_assoc($rs1);

            if (!$linha1) {//problematica
                $sql1 = "SELECT cl.classe_id, classe_nm, cv.classe_valor
                                FROM dados_unico.cargo ca,
                                     diaria.classe cl,
                                     diaria.classe_valor cv
                                WHERE (ca.classe_id = cl.classe_id)
                                    AND (cl.classe_id = cv.classe_id) 
                                    AND classe_valor_st = 0
                                     AND to_date('" . $DataPartida . "','DD/MM/YYYY') BETWEEN classe_valor_dt_vigencia_inicio
                                        AND classe_valor_dt_vigencia_fim
                                    AND cargo_id = '" . $CargoTemporario . "'";
                $sql1 = "select 
                                  cl.classe_id
                                , classe_nm
                                , cv.classe_valor 
                             from dados_unico.cargo ca
                                            left join diaria.classe cl
                                                    on ca.classe_id = cl.classe_id
                                            left join diaria.classe_valor cv
                                                    on cl.classe_id = cv.classe_id
                                    where classe_valor_st = 0
                                                                  AND (to_date('$DataPartida','DD/MM/YYYY') > classe_valor_dt_vigencia_inicio) --AND classe_valor_dt_vigencia_fim)
                                                                AND cargo_id = '$CargoTemporario'
                            limit 1";
                
                //echo_pre($sql1);
                $rs1 = pg_query(abreConexao(), $sql1);
                $linha1 = pg_fetch_assoc($rs1);
            }
        } else {
            $sql1 = "SELECT cl.classe_id, classe_nm, cv.classe_valor
                            FROM dados_unico.cargo ca,
                                 diaria.classe cl,
                                 diaria.classe_valor cv
                            WHERE (ca.classe_id = cl.classe_id)
                                AND (cl.classe_id = cv.classe_id) 
                                AND classe_valor_st = 0
                                AND cargo_id = '" . $CargoTemporario . "'";
            $rs1 = pg_query(abreConexao(), $sql1);
            $linha1 = pg_fetch_assoc($rs1);
        }
        $TemporarioValor = true;
    }
    //VERIFICANDO O CARGO PERMANENTE DO BENEFICIÁRIO
    if ($linha['cargo_permanente'] != 0) {
        $CargoPermanente = $linha['cargo_permanente'];

        if (!empty($DataPartida)) { 
            $sql2 = "SELECT cl.classe_id, classe_nm, cv.classe_valor
                            FROM dados_unico.cargo ca,
                                 diaria.classe cl,
                                 diaria.classe_valor cv
                            WHERE (ca.classe_id = cl.classe_id)
                                AND (cl.classe_id = cv.classe_id) 
                                AND to_date('" . $DataPartida . "','DD/MM/YYYY') BETWEEN classe_valor_dt_vigencia_inicio
                                                            AND classe_valor_dt_vigencia_fim
                                AND cargo_id = '" . $CargoPermanente . "'";
            $rs2 = pg_query(abreConexao(), $sql2);
            $linha2 = pg_fetch_assoc($rs2);

            if (!$linha2) {
                $sql2 = "SELECT cl.classe_id, classe_nm, cv.classe_valor
                            FROM dados_unico.cargo ca,
                                 diaria.classe cl,
                                 diaria.classe_valor cv
                            WHERE (ca.classe_id = cl.classe_id)
                                AND (cl.classe_id = cv.classe_id) 
                                AND classe_valor_st = 0
                                AND cargo_id = '" . $CargoPermanente . "'";
                $rs2 = pg_query(abreConexao(), $sql2);
                $linha2 = pg_fetch_assoc($rs2);
            }
        } else {
            $sql2 = "SELECT cl.classe_id, classe_nm, cv.classe_valor
                            FROM dados_unico.cargo ca,
                                 diaria.classe cl,
                                 diaria.classe_valor cv
                            WHERE (ca.classe_id = cl.classe_id)
                                AND (cl.classe_id = cv.classe_id) 
                                AND classe_valor_st = 0
                                AND cargo_id = '" . $CargoPermanente . "'";
            $rs2 = pg_query(abreConexao(), $sql2);
            $linha2 = pg_fetch_assoc($rs2);
        }
        $PermanenteValor = true;
    }

    if (($TemporarioValor) && ($PermanenteValor)) {
        if ((int) ($linha1['classe_valor']) > (int) ($linha2['classe_valor'])) {
            $ValorDiaria = $linha1['classe_valor'];
            $ValorDiariaDescricao = $linha1['classe_nm'];
            $ClasseID = $linha1['classe_id'];
        } else {
            $ValorDiaria = $linha2['classe_valor'];
            $ValorDiariaDescricao = $linha2['classe_nm'];
            $ClasseID = $linha2['classe_id'];
        }
    } elseif ($TemporarioValor) {
        $ValorDiaria = $linha1['classe_valor'];
        $ValorDiariaDescricao = $linha1['classe_nm'];
        $ClasseID = $linha1['classe_id'];
    } elseif ($PermanenteValor) {
        $ValorDiaria = $linha2['classe_valor'];
        $ValorDiariaDescricao = $linha2['classe_nm'];
        $ClasseID = $linha2['classe_id'];
    }
    if ($TipoChamada == 'Assessor') {
        /*echo "<input type='hidden' id='txtClasseID_" . $CodBeneficiario . "' name='txtClasseID_" . $CodBeneficiario . "' value=" . $ClasseID . " />
              <input type='hidden' id='txtClasseNM_" . $CodBeneficiario . "' name='txtClasseNM_" . $CodBeneficiario . "' value=" . $ValorDiariaDescricao . " />
              <input type='hidden' id='txtValorReferencia_" . $CodBeneficiario . "' name='txtValorReferencia_" . $CodBeneficiario . "' value=" . $ValorDiaria . " />&nbsp;" . number_format($ValorDiaria, 2, ',', '.') . " referente a Classe " . $ValorDiariaDescricao;
        */echo "<input type='hidden' id='txtClasseID_" . $CodBeneficiario . "' name='txtClasseID_" . $CodBeneficiario . "' value=" . $ClasseID . " />
              <input type='hidden' id='txtClasseNM_" . $CodBeneficiario . "' name='txtClasseNM_" . $CodBeneficiario . "' value=" . $ValorDiariaDescricao . " />
              <input type='hidden' id='txtValorReferencia_" . $CodBeneficiario . "' name='txtValorReferencia_" . $CodBeneficiario . "' value=" . $ValorDiaria . " />" ;
    } else {
        /*echo "<input type='hidden' id='txtClasseID' name='txtClasseID' value=" . $ClasseID . " />
              <input type='hidden' id='txtClasseNM' name='txtClasseNM' value=" . $ValorDiariaDescricao . " />
              <input type='hidden' id='txtValorReferencia' name='txtValorReferencia' value=" . $ValorDiaria . " />&nbsp;" . number_format($ValorDiaria, 2, ',', '.') . " referente a Classe " . $ValorDiariaDescricao;
        */echo "<input type='hidden' id='txtClasseID' name='txtClasseID' value=" . $ClasseID . " />
              <input type='hidden' id='txtClasseNM' name='txtClasseNM' value=" . $ValorDiariaDescricao . " />
              <input type='hidden' id='txtValorReferencia' name='txtValorReferencia' value=" . $ValorDiaria . " />";
    }
}

/* * *****************************************************************************
  FUNÇÃO QUE RETORNA O VALOR REFERÊNCIA PARA O CÁLCULO DA DIÁRIA
  O VALOR REFERÊNCIA É BASEADO NO CARGO TEMPORÁRIO E NO CARGO PERMANENTE
 * ***************************************************************************** */

function f_ValorReferencia_Internacional($CodBeneficiario, $DirigenteMaior, $PaisDestinoID, $PrecursorRepresentante, $DataPartida, $CotacaoDolarID, $TipoChamada) {
    $TemporarioValor = false;
    $PermanenteValor = false;
    $DirigenteMaior = (int) $DirigenteMaior;
    $CotacaoDolarID = (int) $CotacaoDolarID;

    if (($PaisDestinoID == '') || ($PaisDestinoID == 'undefined')) {
        //CASO NÃO VENHA NENHUM PAIS ATRIBUI O BRASIL, POIS O VALOR REFERÊNCIA DELE É 0 (ZERO).
        $PaisDestinoID = 1;
    }

    if ($PrecursorRepresentante == 'true') {
        if (($DirigenteMaior != '0') || ($DirigenteMaior != '')) {
            //CASO O ID PASSADO SEJA 3 - CHEFE DE CERIMONIAL, RETORNARÁ O CARGO DO GOVERNADOR
            if ($DirigenteMaior == 3) {
                $sql = "SELECT F.cargo_temporario, F.cargo_permanente
                            FROM dados_unico.funcionario F
                            JOIN dados_unico.funcao_dirigente_funcionario FDF
                                ON F.funcionario_id = FDF.func_dir_funcionario_id_funcionario
                            JOIN dados_unico.funcao_dirigente FD
                                ON FDF.func_dir_funcionario_funcao_id = FD.funcao_dirigente_id
                                    AND FDF.func_dir_funcionario_status = 0
                                    AND FD.funcao_dirigente_id = 1";
            } else {
                $sql = "SELECT F.cargo_temporario, F.cargo_permanente
                            FROM dados_unico.funcionario F
                            JOIN dados_unico.funcao_dirigente_funcionario FDF
                                ON F.funcionario_id = FDF.func_dir_funcionario_id_funcionario
                            JOIN dados_unico.funcao_dirigente FD
                                ON FDF.func_dir_funcionario_funcao_id = FD.funcao_dirigente_id
                                    AND FDF.func_dir_funcionario_status = 0
                                    AND FD.funcao_dirigente_id = " . $DirigenteMaior;
            }
        }
    } else {
        $sql = "SELECT cargo_temporario, cargo_permanente
                    FROM dados_unico.funcionario
                    WHERE pessoa_id = " . $CodBeneficiario;
    }
    $rs = pg_query(abreConexao(), $sql);
    $linha = pg_fetch_assoc($rs);
    //VERIFICANDO O CARGO TEMPORÁRIO DO BENEFICIÁRIO
    if ($linha['cargo_temporario'] != 0) {
        $CargoTemporario = $linha['cargo_temporario'];
        if (!empty($DataPartida)) {
            $sql1 = "SELECT  CL.classe_id, CL.classe_nm, PGV.pais_grupo_valor
                        FROM dados_unico.cargo CA
                        JOIN diaria.classe CL
                            ON CA.classe_id = CL.classe_id
                        JOIN diaria.pais_grupo_valor PGV
                            ON CL.classe_id = PGV.classe_id
                                AND (to_date('" . $DataPartida . "','DD/MM/YYYY') BETWEEN PGV.pais_grupo_valor_dt_vigencia_inicio::DATE AND PGV.pais_grupo_valor_dt_vigencia_fim::DATE)
                        JOIN dados_unico.pais P
                            ON P.pais_grupo_id = PGV.pais_grupo_id
                                AND P.pais_id = " . $PaisDestinoID . "
                        WHERE CA.cargo_id = " . $CargoTemporario;
            $rs1 = pg_query(abreConexao(), $sql1);
            $linha1 = pg_fetch_assoc($rs1);

            if (!$linha1) {
                $sql1 = "SELECT  CL.classe_id, CL.classe_nm, PGV.pais_grupo_valor
                            FROM dados_unico.cargo CA
                            JOIN diaria.classe CL
                                ON CA.classe_id = CL.classe_id
                            JOIN diaria.pais_grupo_valor PGV
                                ON CL.classe_id = PGV.classe_id
                                    AND pgv.pais_grupo_valor_st = 0
                            JOIN dados_unico.pais P
                                ON P.pais_grupo_id = PGV.pais_grupo_id
                                    AND P.pais_id = " . $PaisDestinoID . "
                            WHERE CA.cargo_id = " . $CargoTemporario;
                $rs1 = pg_query(abreConexao(), $sql1);
                $linha1 = pg_fetch_assoc($rs1);
            }
        } else {
            $sql1 = "SELECT  CL.classe_id, CL.classe_nm, PGV.pais_grupo_valor
                        FROM dados_unico.cargo CA
                        JOIN diaria.classe CL
                            ON CA.classe_id = CL.classe_id
                        JOIN diaria.pais_grupo_valor PGV
                            ON CL.classe_id = PGV.classe_id
                                AND pgv.pais_grupo_valor_st = 0
                        JOIN dados_unico.pais P
                            ON P.pais_grupo_id = PGV.pais_grupo_id
                                AND P.pais_id = " . $PaisDestinoID . "
                        WHERE CA.cargo_id = " . $CargoTemporario;
            $rs1 = pg_query(abreConexao(), $sql1);
            $linha1 = pg_fetch_assoc($rs1);
        }
        $TemporarioValor = true;
    }
    //VERIFICANDO O CARGO PERMANENTE DO BENEFICIÁRIO
    if ($linha['cargo_permanente'] != 0) {
        $CargoPermanente = $linha['cargo_permanente'];

        if (!empty($DataPartida)) {
            $sql2 = "SELECT  CL.classe_id, CL.classe_nm, PGV.pais_grupo_valor
                        FROM dados_unico.cargo CA
                        JOIN diaria.classe CL
                            ON CA.classe_id = CL.classe_id
                        JOIN diaria.pais_grupo_valor PGV
                            ON CL.classe_id = PGV.classe_id
                                AND (to_date('" . $DataPartida . "','DD/MM/YYYY') BETWEEN PGV.pais_grupo_valor_dt_vigencia_inicio::DATE AND PGV.pais_grupo_valor_dt_vigencia_fim::DATE)
                        JOIN dados_unico.pais P
                            ON P.pais_grupo_id = PGV.pais_grupo_id
                                AND P.pais_id = " . $PaisDestinoID . "
                        WHERE CA.cargo_id = " . $CargoPermanente;
            $rs2 = pg_query(abreConexao(), $sql2);
            $linha2 = pg_fetch_assoc($rs2);

            if (!$linha2) {
                $sql2 = "SELECT  CL.classe_id, CL.classe_nm, PGV.pais_grupo_valor
                            FROM dados_unico.cargo CA
                            JOIN diaria.classe CL
                                ON CA.classe_id = CL.classe_id
                            JOIN diaria.pais_grupo_valor PGV
                                ON CL.classe_id = PGV.classe_id
                                    AND pgv.pais_grupo_valor_st = 0
                            JOIN dados_unico.pais P
                                ON P.pais_grupo_id = PGV.pais_grupo_id
                                    AND P.pais_id = " . $PaisDestinoID . "
                            WHERE CA.cargo_id = " . $CargoPermanente;
                $rs2 = pg_query(abreConexao(), $sql2);
                $linha2 = pg_fetch_assoc($rs2);
            }
        } else {
            $sql2 = "SELECT  CL.classe_id, CL.classe_nm, PGV.pais_grupo_valor
                            FROM dados_unico.cargo CA
                            JOIN diaria.classe CL
                                ON CA.classe_id = CL.classe_id
                            JOIN diaria.pais_grupo_valor PGV
                                ON CL.classe_id = PGV.classe_id
                                    AND pgv.pais_grupo_valor_st = 0
                            JOIN dados_unico.pais P
                                ON P.pais_grupo_id = PGV.pais_grupo_id
                                    AND P.pais_id = " . $PaisDestinoID . "
                            WHERE CA.cargo_id = " . $CargoPermanente;
            $rs2 = pg_query(abreConexao(), $sql2);
            $linha2 = pg_fetch_assoc($rs2);
        }
        $PermanenteValor = true;
    }
    //CASO JÁ ESTEJA COMPROVANDO A DIÁRIA TEM QUE TRAZER O ID DA COTAÇÃO DO DOLAR
    //DO DIA DA SOLICITAÇÃO.
    if ($CotacaoDolarID != '') {
        $sqlConsultaCotacaoDolar = "SELECT cotacao_dolar_id,
                                        cotacao_dolar_valor
                                        FROM diaria.cotacao_dolar
                                        WHERE cotacao_dolar_id = " . $CotacaoDolarID;
    } else {
        $sqlConsultaCotacaoDolar = "SELECT cotacao_dolar_id,
                                        cotacao_dolar_valor
                                        FROM diaria.cotacao_dolar
                                        WHERE cotacao_dolar_st = 0";
    }
    $rsConsultaCotacaoDolar = pg_query(abreConexao(), $sqlConsultaCotacaoDolar);
    $linhaConsultaCotacaoDolar = pg_fetch_assoc($rsConsultaCotacaoDolar);

    if (($TemporarioValor) && ($PermanenteValor)) {
        if ((int) ($linha1['classe_valor']) >= (int) ($linha2['classe_valor'])) {
            $ValorDiaria = $linha1['pais_grupo_valor'] * $linhaConsultaCotacaoDolar['cotacao_dolar_valor'];
            $ValorDiariaDescricao = $linha1['classe_nm'];
            $ClasseID = $linha1['classe_id'];
        } else {
            $ValorDiaria = $linha2['pais_grupo_valor'] * $linhaConsultaCotacaoDolar['cotacao_dolar_valor'];
            $ValorDiariaDescricao = $linha2['classe_nm'];
            $ClasseID = $linha2['classe_id'];
        }
    } elseif ($TemporarioValor) {
        $ValorDiaria = $linha1['pais_grupo_valor'] * $linhaConsultaCotacaoDolar['cotacao_dolar_valor'];
        $ValorDiariaDescricao = $linha1['classe_nm'];
        $ClasseID = $linha1['classe_id'];
    } elseif ($PermanenteValor) {
        $ValorDiaria = $linha2['pais_grupo_valor'] * $linhaConsultaCotacaoDolar['cotacao_dolar_valor'];
        $ValorDiariaDescricao = $linha2['classe_nm'];
        $ClasseID = $linha2['classe_id'];
    }
    if ($TipoChamada == 'Assessor') {
        echo "<input type='hidden' id='txtClasseID_Internacional_" . $CodBeneficiario . "' name='txtClasseID_Internacional_" . $CodBeneficiario . "' value=" . $ClasseID . ">
            <input type='hidden' id='txtClasseNM_Internacional_" . $CodBeneficiario . "' name='txtClasseNM_Internacional_" . $CodBeneficiario . "' value=" . $ValorDiariaDescricao . ">
            <input type='hidden' id='txtValorReferencia_Internacional_" . $CodBeneficiario . "' name='txtValorReferencia_Internacional_" . $CodBeneficiario . "' value=" . $ValorDiaria . " style='width:75px;' readonly>&nbsp;R$ " . number_format($ValorDiaria, 2, ',', '.') . " Classe " . $ValorDiariaDescricao . " - Dollar: " . number_format($linhaConsultaCotacaoDolar['cotacao_dolar_valor'], 2, ',', '.');
    } else {
        echo "<input type='hidden' id='txtClasseID_Internacional' name='txtClasseID_Internacional' value=" . $ClasseID . ">
              <input type='hidden' id='txtClasseNM_Internacional' name='txtClasseNM_Internacional' value=" . $ValorDiariaDescricao . ">
              <input type='hidden' id='txtValorReferencia_Internacional' name='txtValorReferencia_Internacional' value=" . $ValorDiaria . " style='width:75px;' readonly>&nbsp;R$ " . number_format($ValorDiaria, 2, ',', '.') . " Classe " . $ValorDiariaDescricao . " - Dollar: " . number_format($linhaConsultaCotacaoDolar['cotacao_dolar_valor'], 2, ',', '.');
    }
}

/* * *****************************************************************************
  FUNÇÃO QUE IRÁ VERIFICAR SE EXISTE PENDÊNCIAS PARA O BENEFICIÁRIO.
 * ***************************************************************************** */

function f_ConsultaBloqueioSolicitante($Beneficiario) {
    /* Esta função foi feita para retornar no momento da aprovação da diaria exibir Pendências
      que existam no beneficiário. Solicitações para Aprovar >> no fim da página antes
      do botão aprovar. *** Danillo 01-12-2010 11:33 AM ***
     * ** MODIFICADA POR: Danillo 06-11-2012 15:07 AM ***
     */
    $dataExtra = date("d/m/Y");

    $sqlConsultaBloq = "SELECT D.diaria_id,
                               D.diaria_numero,
                               D.diaria_dt_chegada,
                               D.diaria_valor,
                               D.diaria_st,
                               D.diaria_comprovada,
                               DF.diaria_execucao_dt, 
                               CASE 
                                   WHEN (to_date(D.diaria_dt_chegada,'DD/MM/YYYY') - now()::DATE) < 0 THEN (to_date(D.diaria_dt_chegada,'DD/MM/YYYY') - now()::DATE) * -1
                                   WHEN (to_date(D.diaria_dt_chegada,'DD/MM/YYYY') - now()::DATE) > 0 THEN (to_date(D.diaria_dt_chegada,'DD/MM/YYYY') - now()::DATE)
                               END AS dias_em_atraso, 
                               CASE 
                                   WHEN (to_date(D.diaria_dt_chegada,'DD/MM/YYYY') - now()::DATE) *- 1 <= 5 THEN 'N'
                                   WHEN (to_date(D.diaria_dt_chegada,'DD/MM/YYYY') - now()::DATE) *- 1 > 5 THEN 'S'
                               END AS contabilizar 
                            FROM diaria.diaria D
                            LEFT JOIN diaria.diaria_financeiro DF
                                ON (D.diaria_id = DF.diaria_id)
                            WHERE ((D.diaria_st >=3 ) and (D.diaria_st <= 5))
                                AND D.diaria_beneficiario = " . $Beneficiario . " 
                                AND D.diaria_comprovada <> 1
                                AND (to_date(D.diaria_dt_chegada,'DD/MM/YYYY') <= to_date('" . $dataExtra . "','DD/MM/YYYY'))
                            ORDER BY D.diaria_id";

    $rsBloq = pg_query(abreConexao(), $sqlConsultaBloq);
    $cont = 1;
    $cor = 1;
    $flag = 0;

    while ($linharsBloq = pg_fetch_assoc($rsBloq)) {
        if ($flag == 0) {
            include "../Include/Inc_Linha.php";
            echo ("<table width='800' border='1' cellpadding='0' bordercolor='#FF0000' cellspacing='0' class='TabelaFormulario'>");
            echo("<tr>");
            echo("<td>");
            echo("<table width='100%' border='0' cellpadding='0' cellspacing='1'>");
            echo("<tr height='21'>");
            echo("<td class='dataTitulo' width='320' colspan='8'>&nbsp;Pend&ecirc;ncias</td>");
            echo("</tr>");
            echo("<tr height='21'>");
            echo("<td width='15' class='dataLabel'>&nbsp;#</td>");
            echo("<td width='130' class='dataLabel'>&nbsp;N&uacute;mero</td>");
            echo("<td width='105' class='dataLabel'>&nbsp;Dias de atraso</td>");
            echo("<td width='102' class='dataLabel'>&nbsp;Pago</td>");
            echo("<td width='105' class='dataLabel'>&nbsp;Dias ap&oacute;s Pgto</td>");
            echo("<td width='100' class='dataLabel'>&nbsp;Data Retorno</td>");
            echo("<td width='90' class='dataLabel'>&nbsp;Valor</td>");
            echo("<td width='150' class='dataLabel'>&nbsp;Status</td>");
            echo("</tr>");
            $flag ++;
        }//fim do if do flag == 0

        if ($cor == 1) {
            $classe = "dataField";
        } else {
            $classe = "dataField2";
        }
        $cor *= -1;

        echo "<tr height='21'>";
        echo "  <td class='$classe'>&nbsp;<b>" . $cont++ . "&nbsp;</b></td>";
        echo "  <td class='$classe'>&nbsp;" . $linharsBloq['diaria_numero'] . "</td>";
        echo "  <td class='$classe'>&nbsp;" . $linharsBloq['dias_em_atraso'] . " Dia(s)</td>";
        echo "  <td class='$classe'>&nbsp;";

        $DataExecucao = f_FormataData($linharsBloq['diaria_execucao_dt']);

        if ($linharsBloq['diaria_execucao_dt'] != "") {
            include_once "../Include/Inc_funcao.php";
            $DataFormatada = f_FormataData($linharsBloq['diaria_execucao_dt']);
            $DataFormatada = f_CalculaAtraso($DataFormatada);
            $Img = "<img src='https://www.portalsema.ba.gov.br/_portal/Imagens/diarias_pagas_on.png' title='Credito Efetuado em  : " . $DataExecucao . "' alt='Credito Efetuado em  : " . $DataExecucao . "' />";
            $DataFormatada = $DataFormatada . " Dia(s) ";
        } else {
            $Img = "<img src='https://www.portalsema.ba.gov.br/_portal/Imagens/diarias_pagas_off.png' title='Falta Pagamento da Diaria" . $DataExecucao . "' alt='Falta Pagamento da Diaria" . $DataExecucao . "' />";
            $DataFormatada = 0;
            $DataFormatada = $DataFormatada . " Dia(s) ";
        }

        echo $Img . " </td>";
        echo "<td class='$classe'>&nbsp;" . $DataFormatada . " </td>";
        echo "  <td class='$classe'>&nbsp;" . $linharsBloq['diaria_dt_chegada'] . "</td>";
        echo "  <td class='$classe'>&nbsp;" . $linharsBloq['diaria_valor'] . "</td>";
        echo "  <td class='$classe'>&nbsp;" . f_RetornaStatus($linharsBloq['diaria_st']) . "</td>";

        echo "</tr>";
    }//fim do while

    if ($flag >= 1) {
        echo("</table>");
        echo("</td>");
        echo("</tr>");
        echo("</table>");
    }//fim do if flag >= 1
}

//fim da função f_ConsultaBloqueioSolicitante

/* * *****************************************************************************
  FUNÇÃO QUE IRÁ RETORNAR O STATUS DO SISTEMA DE DIÁRIAS
 * ***************************************************************************** */

function f_RetornaStatus($Status) {
    switch ($Status) {
        case 0: $StatusNome = "Aguardando Autoriza&ccedil;&atilde;o";
            break;
        case 1: $StatusNome = "Aguardando Aprova&ccedil;&atilde;o";
            break;
        case 2: $StatusNome = "Aguardando Empenho";
            break;
        case 3: $StatusNome = "Aguardando Pagamento";
            break;
        case 4: $StatusNome = "Aguardando Comprova&ccedil;&atilde;o";
            break;
        case 5: $StatusNome = "Aguardando Documenta&ccedil;&atilde;o";
            break;
        case 6: $StatusNome = "Aguardando 2ª Empenho";
            break;
        case 7: $StatusNome = "Aguardando 2ª Pagamento";
            break;
        case 8: $StatusNome = "Aguardando Análise Financeira";
            break;
        case 9: $StatusNome = "Concluida";
            break;
    }
    return $StatusNome;
}

function f_CalculaAtraso($data) {
    $dataBanco = explode("/", $data);

    //A função mktime recebe os argumentos (hora, minuto, segundos, mes, dia, ano).
    $diaBanco = mktime(0, 0, 0, $dataBanco[1], $dataBanco[0], $dataBanco[2]);
    $dataAtual = date("Y-m-d");
    $dataAtual = explode("-", $dataAtual);
    $diaAtual = mktime(0, 0, 0, $dataAtual[1], $dataAtual[2], $dataAtual[0]);
    $diferencaDataTempo = ($diaAtual - $diaBanco);

    //converte o tempo em dias
    $DiferencaDias = round(($diferencaDataTempo / 60 / 60 / 24));

    if (isset($DiferencaDias)) {
        return $DiferencaDias;
    } else {
        return $DiferencaDias = 0;
    }
}

//* montar  numero de processo a partir do numero de solicitaÃ§Ã£o gerado no sistema, nestea caso foi DE: SD  gerando numero de processo para  diarias
//* ex: N. SD 201002345   gerou 14 2010 9 0 02345  (1420109002345)
// VERIFICA SE O SISTEMA ESTÁ SETADO PARA GERAR O Nº DO PROCESSO USANDO SISTEMA ESPECIFICO PARA ESTE FIM
function f_NumeroProcesso($diaria_numero) {
    //FUNÇÕES NECESSÁRIAS PARA A CONSULTA DE DADOS INCLUIDAS CASO AINDA NAO TENHAM SIDO
    include_once "IncludeLocal/Inc_Funcao.php";

    //VERIFICA SE O NUMERO DEVE SER GERADO NO SISTEMA DE DOCUMENTOS
    $usar_sistema_documentos = F_VerificarUsoSistemaDocumentos();

    //VERIFICA SE O NUMERO DEVE SER GERADO NO SISTEMA DE DOCUMENTOS
    if ($usar_sistema_documentos == 'S') {
        //CRIA A DIÁRIA NO SISTEMA DE DOCUMENTOS
        include_once "../Include/Inc_FuncaoDocumentos.php";

        //CAPTURA OS DADOS DA DIÁRIA
        $sqlConsulta = "
        SELECT
            diaria_id,
            diaria_descricao,
            diaria_beneficiario,
            diaria_solicitante,
            diaria_unidade_custo
        FROM
            diaria.diaria
        WHERE
            diaria_numero = '" . $diaria_numero . "'";

        //REALIZANDO A CONSULTA
        $rsConsulta = pg_query(abreConexao(), $sqlConsulta);

        //ASSOCIANDO OS DADOS DA CONSULTA
        $linharsConsulta = pg_fetch_assoc($rsConsulta);

        //CAPTURANDO AS VARIAVEIS CONSULTADAS
        $diaria_id = $linharsConsulta['diaria_id'];
        $diaria_descricao = $linharsConsulta['diaria_descricao'];
        $diaria_beneficiario = $linharsConsulta['diaria_beneficiario'];
        $diaria_solicitante = $linharsConsulta['diaria_solicitante'];
        $diaria_unidade_custo = $linharsConsulta['diaria_unidade_custo'];

        //QUERY PARA CONSULTAR OS DADOS A SEREM UTILIZADOS PARA GERAR O PROCESSO
        $sqlConsulta = "
        SELECT
            sd_tipo_origem,
            sd_tipo_documento_id,
            sd_assunto_id,
            sd_subassunto_id,
            sd_qtde_paginas
        FROM
            diaria.diaria_parametros";

        //REALIZANDO A CONSULTA
        $rsConsulta = pg_query(abreConexao(), $sqlConsulta);

        //ASSOCIANDO OS DADOS DA CONSULTA
        $linharsConsulta = pg_fetch_assoc($rsConsulta);

        //CAPTURANDO AS VARIAVEIS CONSULTADAS
        $tipo_origem = $linharsConsulta['sd_tipo_origem'];
        $tipo_documento_id = $linharsConsulta['sd_tipo_documento_id'];
        
        
        //echo $tipo_documento_id;exit;
        
        $assunto_id = $linharsConsulta['sd_assunto_id'];
        $subassunto_id = $linharsConsulta['sd_subassunto_id'];
        $qtde_paginas = $linharsConsulta['sd_qtde_paginas'];

        //SETA AS VARIAIVES        
        $cmbSetorOrigem = $diaria_unidade_custo;
        $documento_numero_original = $diaria_numero;
        $documento_dt = date("Y-m-d");
        $documento_dt_recebimento = date("Y-m-d");
        $discriminacao_assunto = $diaria_descricao;

        //APAGA A SESSÃO DE INTERESSADOS
        unset($_SESSION['interessados']);

        //CAPTURA OS VALORES A SEREM INSERIDOS
        $_SESSION['interessados'][0][0] = $diaria_beneficiario;
        $_SESSION['interessados'][0][1] = f_NomePessoa($diaria_beneficiario);
        $_SESSION['interessados'][0][2] = 'F';

        
        
        
        //echo '$documento_numero='.$documento_numero;exit;
        
        //INCLUI O DOCUMENTO E CAPTURA O NÚMERO CRIADO
        /*$Documento = F_AcaoIncluirDocumento(
                $PaginaLocal, $documento_numero, $tipo_origem, $cmbSetorOrigem, $cmbOrgaoOrigem, $documento_numero_original, $tipo_documento_id, $documento_dt, $documento_dt_recebimento, $assunto_id, $discriminacao_assunto, $qtde_paginas, $subassunto_id, $documento_modelo_pai_id, $gerar_numero_original);
        */
        /*
        $Documento = F_AcaoIncluirDocumentoNovoSistema(
                $PaginaLocal, $documento_numero, $tipo_origem, $cmbSetorOrigem, $cmbOrgaoOrigem, $documento_numero_original, $tipo_documento_id, $documento_dt, $documento_dt_recebimento, $assunto_id, $discriminacao_assunto, $qtde_paginas, $subassunto_id, $documento_modelo_pai_id, $gerar_numero_original);
        */
        $Documento = F_AcaoIncluirDocumentoNovoSistema($documento_numero_original=$diaria_numero
                                                    ,$assunto_id = 404/*'"DIARIA"'*/ 
                                                    ,$subassunto_id=null
                                                    ,$discriminacao_assunto
                                                    ,$tipo_origem='I'
                        ,$posfixo='D'
                        ,$documento_tipo_id='122'/*diaria*/
                        ,$assunto_ds='',null,$diaria_beneficiario,f_NomePessoa($diaria_beneficiario));
        
        //echo 1;exit;
        //APAGA A SESSÃO DE INTERESSADOS
        unset($_SESSION['interessados']);

        //CAPTURA OS DADOS DO DOCUMENTO INCLUIDO
        $documento_id = $Documento['documento_id'];
        $documento_numero = $Documento['documento_numero'];
        
        ############################################
        //de-para diaria e documento
        //nao utiliza mais
        $sql = "insert into diaria.diaria_documento(diaria_id,documento_id) values($diaria_id, $documento_id)";
        //pg_query(abreConexao(), $sql);

        //RETORNA O NÚMERO CRIADO
        return $documento_numero;

        //FINALIZA A CRIAÇÃO DA DIÁRIA NO SISTEMA DE DOCUMENTOS
        //******************************************************
    }
    //O NÚMERO DO PROCESSO SERÁ GERADO USANDO LÓGICA DO PRÓPRIO SISTEMA DE DIÁRIAS
    else if ($usar_sistema_documentos == 'N') {
        $DTAno = date("Y");
        $DTAno = "14" . $DTAno . "9";
        $Zeros = "0";
        $TamanhoSD = strlen($diaria_numero);
        $NumDiaria = substr($diaria_numero, 4, $TamanhoSD);
        return $Processo = $DTAno . $Zeros . $NumDiaria;
    }
}

/* * *****************************************************************************
  FUNÇÃO PARA CARREGAR AS UNIDADES DE CUSTO
 * ***************************************************************************** */

function f_ComboUnidadeCusto($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos, $Status) {
    /*     * *****************************************************************************
      Copyright 2012 SEMA - Secretaria do Meio Ambiente - Bahia. All Rights Reserved.
      @author danillobs@gmail.com (Danillo Barreto)
     * ***************************************************************************** */
    /*     * ***************************************************************************
     * $NomeCombo = é o NOME do combo que será passado para a função.
     * $codigoEscolhido = é o CÓDIGO do município que está sendo passado.
     * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
     * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
     * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
     * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
     * *************************************************************************** */
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    if (($Status == 0) || ($Status == 1)) {
        $StringStatus = " est_organizacional_st = " . $Status . " AND ";
    } else {
        $StringStatus = " est_organizacional_st <> 2 AND ";
    }

    $sql = "SELECT est_organizacional_id,
                   est_organizacional_ds,
                   est_organizacional_centro_custo_num
              FROM dados_unico.est_organizacional
              WHERE " . $StringStatus . " est_organizacional_centro_custo = 1
              ORDER BY est_organizacional_id";
    $rs = pg_query(abreConexao(), $sql);

    $String = RetornarQtdeTracos($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        $codigo = $linha['est_organizacional_id'];
        $descricao = $linha['est_organizacional_centro_custo_num'] . " - " . $linha['est_organizacional_ds'];
        if (strval($codigoEscolhido) == strval($codigo)) {
            echo "<option value=" . $codigo . " selected>" . $descricao . "</option>";
        } else {
            if (((int) $capital == 1) && ($codigoEscolhido == "")) {
                echo "<option value=" . $codigo . " selected>" . $descricao . "</option>";
            } Else {
                echo "<option value=" . $codigo . ">" . $descricao . "</option>";
            }
        }
    }
    return "</select>";
}

/* * *****************************************************************************
  projetos da unidade custo
  Data........: 20/02/2014
  Comentário..: Listar apenas os projetos da unidade de custo, a pedido da DO
  para diárias e passagens
 * ***************************************************************************** */

function f_ComboProjetoPAOE($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Tamanho, $EO_Funcionario_id) {

    //CONSULTA UNIDADE E UNIDADE SUPERIOR DO BENEFICIÁRIO
    /* $sqlConsultaUnidadeCusto = "SELECT EOF.est_organizacional_id,
      EO.est_organizacional_sup_cd
      FROM dados_unico.funcionario F
      JOIN dados_unico.est_organizacional_funcionario EOF
      ON F.funcionario_id = EOF.funcionario_id
      AND est_organizacional_funcionario_st = 0
      JOIN dados_unico.est_organizacional EO
      ON EO.est_organizacional_id = EOF.est_organizacional_id
      WHERE F.pessoa_id = ".$BeneficiarioID;
      $rsConsultaUnidadeCusto		= pg_query(abreConexao(), $sqlConsultaUnidadeCusto);
      $linhaConsultaUnidadeCusto	= pg_fetch_assoc($rsConsultaUnidadeCusto);

      $EO_Funcionario_id = $linhaConsultaUnidadeCusto ['est_organizacional_id'];
      $EO_SUP_id         = $linhaConsultaUnidadeCusto ['est_organizacional_sup_cd']; */
    //COMO O RETORNO DA FUNÇÃO É SUCESSO=UNIDADE_CUSTO_ID TEM QUE USAR O EXPLODE
    //$Unidade = explode('=',ProcurarCentroDeCusto($EO_Funcionario_id, $EO_SUP_id));
    //$UnidadeCusto = $Unidade[1];

    if ($EO_Funcionario_id != "") {
        $sql = "SELECT 	DISTINCT P.projeto_cd, P.projeto_ds 
					FROM	diaria.projeto P, diaria.associacao_PAOE AP
					WHERE	(P.projeto_cd::varchar = AP.projeto_cd::varchar) AND
							P.projeto_st = 0 AND
							AP.est_organizacional_id = " . $EO_Funcionario_id . "   
					ORDER BY projeto_cd";
        $rs = pg_query(abreConexao(), $sql);

        /* }else{

          $sql	= "SELECT DISTINCT projeto_cd, projeto_ds FROM diaria.projeto WHERE projeto_st = 0 ORDER BY projeto_cd";
          $rs		= pg_query(abreConexao(),$sql); */

        echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " style='width: " . $Tamanho . ";' " . $FuncaoJavaScript . ">";
        echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
        while ($linha = pg_fetch_assoc($rs)) {
            if ( $codigoEscolhido == ($linha['projeto_cd'])) {
                echo "<option value=" . $linha['projeto_cd'] . " selected>" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
            } else {
                echo "<option value=" . $linha['projeto_cd'] . ">" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
            }
        }
        echo "</select>";
    }
}

/* * *****************************************************************************
  projetos da unidade custo
  Data........: 20/02/2014
  Comentário..: Listar todos os projetos ativos, para tela Associar PAOE
 * ***************************************************************************** */

function f_ComboProjetoAssociarPAOE($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Tamanho) {
    $sql = "SELECT DISTINCT projeto_cd, projeto_ds FROM diaria.projeto WHERE projeto_st = 0 ORDER BY projeto_cd";
    $rs = pg_query(abreConexao(), $sql);

    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " style='width: " . $Tamanho . ";' " . $FuncaoJavaScript . ">";
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ( $codigoEscolhido == ($linha['projeto_cd'])) {
            echo "<option value=" . $linha['projeto_cd'] . " selected>" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
        } else {
            echo "<option value=" . $linha['projeto_cd'] . ">" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  COMBO QUE EXIBE A(S) AÇÃO(ÕES)
 * ***************************************************************************** */

function f_ComboAcaoPAOE($NomeCombo, $codigoEscolhido, $projeto, $FuncaoJavaScript, $Tamanho, $EO_Funcionario_id) {

    if ($projeto == "" and $EO_Funcionario_id == "") {
        $sql = "SELECT DISTINCT acao_cd, acao_sequencial, acao_ds 
        FROM diaria.acao WHERE acao_st = 0 ORDER BY acao_cd";
    } else {
        /* $sql = "SELECT DISTINCT a.acao_cd, acao_sequencial, acao_ds FROM diaria.acao a, diaria.projeto_acao_territorio pat WHERE projeto_cd = '".$projeto."'". " AND (a.acao_cd = pat.acao_cd) AND acao_st = 0 ORDER BY acao_cd"; */

        $projeto = explode('.',$projeto);
        // $sql = "SELECT DISTINCT a.acao_cd, a.acao_sequencial, a.acao_ds 
		// 		FROM	diaria.acao a, diaria.associacao_PAOE ap 
		// 		WHERE	ap.projeto_cd::varchar = '" . $projeto[0] . "' AND 
		// 				(a.acao_cd = ap.acao_cd) AND
		// 				ap.est_organizacional_id = " . $EO_Funcionario_id . " AND
		// 				a.acao_st = 0 
		// 		ORDER BY acao_cd";
        $param_comp='';
        // $unidade_orcamentaria_sigla = $_SESSION['unidade_orcamentaria_sigla'];
        // $unidade_orcamentaria_sigla = $unidade_orcamentaria_sigla=='SDA'?'CDA':$unidade_orcamentaria_sigla;
        // if($projeto[0]==2000){
        //     $param_comp = "and case when a.acao_cd ='9999' then a.acao_ds ilike '%sdr%' 
        //                             when a.acao_cd ='9998'then a.acao_ds ilike '%bahiater%'
        //                             when a.acao_cd ='9997' then a.acao_ds ilike '%cda%'
        //                             end
        //                             ";
        // }
        $sql = "SELECT DISTINCT a.acao_cd, a.acao_sequencial, a.acao_ds 
				FROM	diaria.acao a, diaria.associacao_PAOE ap 
				WHERE	ap.projeto_cd::varchar = '" . $projeto[0] . "' AND 
						(a.acao_cd = ap.acao_cd)  
						 and a.acao_st = 0 $param_comp
				ORDER BY acao_cd";

                $sql ="
				select distinct a.* from diaria.acao a
					inner join diaria.associacao_paoe ap
					    on a.acao_cd = ap.acao_cd
							where a.acao_st =0  and ap.projeto_cd =  '".$projeto[0]."'
							order by a.acao_cd
                            ";
    }
 //echo "<pre>".$sql."</pre>";
    $rs = pg_query(abreConexao(), $sql);


    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " style='width: " . $Tamanho . ";' " . $FuncaoJavaScript . ">";
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ((int) $codigoEscolhido == (int) ($linha['acao_cd'])) {
            echo "<option value=" . $linha['acao_cd'] . " selected>" . $linha['acao_cd'] . "." . $linha['acao_sequencial'] . " ----> " . $linha['acao_ds'] . "</option>";
        } else {
            echo "<option value=" . $linha['acao_cd'] . ">" . $linha['acao_cd'] . "." . $linha['acao_sequencial'] . " ----> " . $linha['acao_ds'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  COMBO QUE EXIBE O(S) TERRITÓRIO(S)
 * ***************************************************************************** */

function f_ComboTerritorioPAOE($NomeCombo, $projeto, $acao, $codigoEscolhido, $FuncaoJavaScript, $Tamanho, $EO_Funcionario_id) {
    //CONSULTA DOS IDS E DAS DESCRIÇÕES ATIVAS
    if ($projeto == "" and $acao == "" and $EO_Funcionario_id == "") {
        //CONSULTA TODOS OS TERRITÓRIOS QUE FORAM ASSOCIADOS E NÃO FORAM REMOVIDOS
        /* $sql = "
          SELECT DISTINCT territorio_cd,
          territorio_ds
          FROM diaria.territorio
          WHERE territorio_st = 0 AND
          territorio_cd IN
          (SELECT territorio_cd
          FROM diaria.projeto_acao_territorio
          WHERE projeto_acao_territorio_st <> 2
          GROUP BY territorio_cd)
          ORDER BY territorio_cd"; */

        $sql = "SELECT DISTINCT territorio_cd, territorio_ds 
				FROM diaria.territorio 
				WHERE territorio_st = 0 
				ORDER BY territorio_cd";
    } else {
        //CONSULTA TODOS OS TERRITORIOS DA AÇÃO / PRODUTO QUE FORAM ASSOCIADOS E NÃO FORAM REMOVIDOS
        $sql = "SELECT DISTINCT t.territorio_cd,
                           t.territorio_ds
                    FROM diaria.territorio t,
                         diaria.associacao_PAOE ap
                    WHERE ap.projeto_cd::varchar = '" . $projeto . "' AND 
						  ap.acao_cd = " . $acao . " AND
                          t.territorio_cd = ap.territorio_cd AND
                          t.territorio_st = 0 AND
						  ap.est_organizacional_id = " . $EO_Funcionario_id . " AND
                          ap.associacao_PAOE_st <> 2
                    ORDER BY t.territorio_cd";

        /* $sql = "SELECT DISTINCT t.territorio_cd, territorio_ds 
          FROM diaria.territorio t, diaria.projeto_acao_territorio pat
          WHERE pat.acao_cd = '".$acao."' AND (t.territorio_cd = pat.territorio_cd) AND territorio_st = 0 ORDER BY t.territorio_cd"; */
    }

    //REALIZA A CONSULTA
    $rs = pg_query(abreConexao(), $sql);
    //DEFINDO O NOME E TAMANHO DO COMBO BOX CONFORME SETADO AO CHAMAR A FUNÇÃO
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " style='width: " . $Tamanho . ";' " . $FuncaoJavaScript . ">";
    //INICIA A CRIAÇÃO DO COMBO
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    //INICIA A CRIAÇÃO DO COMBO
    //PRENCHE O COMBO
    while ($linha = pg_fetch_assoc($rs)) {
        //VERIFICA SE O VALOR CAPTURADO É O MESMO QUE RECEBIDO PELA FUNÇÃO E MARCA COMO SELECIONADO
        if ((int) $codigoEscolhido == (int) $linha['territorio_cd']) {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $linha['territorio_cd'] . " selected>" . $linha['territorio_cd'] . " ----> " . $linha['territorio_ds'] . "</option>";
        } else {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $linha['territorio_cd'] . ">" . $linha['territorio_cd'] . " ----> " . $linha['territorio_ds'] . "</option>";
        }
    }
    //FINALIZA O COMBO
    echo "</select>";
}
function f_ComboTerritorioSimples($NomeCombo, $projeto, $acao, $codigoEscolhido, $FuncaoJavaScript, $Tamanho, $EO_Funcionario_id) {
    
        //CONSULTA TODOS OS TERRITORIOS DA AÇÃO / PRODUTO QUE FORAM ASSOCIADOS E NÃO FORAM REMOVIDOS
        $sql = "SELECT DISTINCT
                           t.territorio_cd,
                           t.territorio_ds
                    FROM diaria.territorio t,
                         diaria.associacao_PAOE ap
                    WHERE  
                          t.territorio_cd = ap.territorio_cd AND
                          t.territorio_st = 0   
                    ORDER BY t.territorio_cd";

        /* $sql = "SELECT DISTINCT t.territorio_cd, territorio_ds 
          FROM diaria.territorio t, diaria.projeto_acao_territorio pat
          WHERE pat.acao_cd = '".$acao."' AND (t.territorio_cd = pat.territorio_cd) AND territorio_st = 0 ORDER BY t.territorio_cd"; */

// echo "<pre>".$sql.'</pre>';
    //REALIZA A CONSULTA
    $rs = pg_query(abreConexao(), $sql);
    //DEFINDO O NOME E TAMANHO DO COMBO BOX CONFORME SETADO AO CHAMAR A FUNÇÃO
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " style='width: " . $Tamanho . ";' " . $FuncaoJavaScript . ">";
    //INICIA A CRIAÇÃO DO COMBO
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    //INICIA A CRIAÇÃO DO COMBO
    //PRENCHE O COMBO
    while ($linha = pg_fetch_assoc($rs)) {
        //VERIFICA SE O VALOR CAPTURADO É O MESMO QUE RECEBIDO PELA FUNÇÃO E MARCA COMO SELECIONADO
        if ((int) $codigoEscolhido == (int) $linha['territorio_cd']) {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $linha['territorio_cd'] . " selected>" . $linha['territorio_cd'] . " ----> " . $linha['territorio_ds'] . "</option>";
        } else {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $linha['territorio_cd'] . ">" . $linha['territorio_cd'] . " ----> " . $linha['territorio_ds'] . "</option>";
        }
    }
    //FINALIZA O COMBO
    echo "</select>";
}

/* * *****************************************************************************
  fonte da unidade
  Data........: 25/02/2014
  Comentário..: Listar apenas os projetos da unidade de custo, a pedido da DO
 * ***************************************************************************** */

function f_ComboFontePAOE($NomeCombo, $projeto, $acao, $territorio, $codigoEscolhido, $FuncaoJavaScript, $Tamanho, $EO_Funcionario_id) {

    if ($projeto != "" and $acao != "" and $territorio != "" and $EO_Funcionario_id != "") {
        $sql = "SELECT 	DISTINCT FT.*
				FROM	diaria.fonte FT, diaria.associacao_PAOE AP
				WHERE	(FT.fonte_cd = AP.fonte_cd) AND
						FT.fonte_st = 0 AND
						AP.projeto_cd::varchar = '" . $projeto . "' AND
						AP.acao_cd = " . $acao . " AND 
						AP.territorio_cd = " . $territorio . " AND
						AP.est_organizacional_id = " . $EO_Funcionario_id . " AND
						AP.associacao_PAOE_st <> 2
				ORDER BY fonte_cd";

        $rs = pg_query(abreConexao(), $sql);
    } else {

        $sql = "SELECT DISTINCT * FROM diaria.fonte WHERE fonte_st = 0 ORDER BY fonte_cd";
        $rs = pg_query(abreConexao(), $sql);
    }

    //echo "<select id='cmbFonte' name='cmbFonte' onChange=\"$('#cmbFonte').attr('style', 'width:785px; background-color:white;');\" style=width:".$Tamanho."px>";
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " style='width: " . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    //$sql = "SELECT * FROM diaria.fonte WHERE fonte_st = 0 ORDER BY fonte_cd";
    //$rs=pg_query(abreConexao(),$sql);

    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == "") {
            if ((int) ($linha['fonte_padrao']) == 1) {
                echo "<option value=" . $linha['fonte_cd'] . " selected>" . $linha['fonte_cd'] . " - " . $linha['fonte_ds'] . "</option>";
            } else {
                echo "<option value=" . $linha['fonte_cd'] . ">" . $linha['fonte_cd'] . " - " . $linha['fonte_ds'] . "</option>";
            }
        } else {
            if ((int) $codigoEscolhido == (int) ($linha['fonte_cd'])) {
                echo "<option value=" . $linha['fonte_cd'] . " selected>" . $linha['fonte_cd'] . " - " . $linha['fonte_ds'] . "</option>";
            } else {
                echo "<option value=" . $linha['fonte_cd'] . ">" . $linha['fonte_cd'] . " - " . $linha['fonte_ds'] . "</option>";
            }
        }
    }
    echo "</select>";
}





function f_ConsultaDiariaLog($diaria_id) {
    $sql = "select * from diaria.log  
                          left join diaria.diaria d  
                             on d.diaria_id = log.diaria_id
                          left join dados_unico.pessoa p
                             on p.pessoa_id = log.pessoa_id 
                             where d.diaria_id = $diaria_id order by dt_cadastro ";
    //echo_pre($sql);
    return $rs = pg_query(abreConexao(), $sql);

    
}
