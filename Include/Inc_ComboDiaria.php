<?php

/* * *****************************************************************************
  FUNÇÃO QUE EXIBE OS BENEFICIÁRIOS DO SISTEMA DE DIÁRIAS
 * ***************************************************************************** */

function ComboBeneficiario($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{ /* $codigoEscolhido = é o ID do sistema que é passado.
  $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
  $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
  $Tamanho = É o tamanho do combo passado em px.
  $QtdTracos = É a quantidade de traços que irá separar o [ da palavra Selecione
 */
    //echo "------------";
    if ($_SESSION['ComboBeneficiarioDiariaOff'] == "disabled") {
        $StringRetornoFiltro = " AND v2.pessoa_id = " . $codigoEscolhido;
    } else {
        $StringRetornoFiltro = "";
    }


    //A pedido da CMO 05.02.2014 - Liberação diárias para funcionário terceirizado
    //AND f.funcionario_tipo_id <> 3
    // $sql = "SELECT f.pessoa_id,
    //                trim(pessoa_nm) as pessoa_nm
    //             FROM dados_unico.pessoa p,
    //                  dados_unico.funcionario f
    //             WHERE (p.pessoa_id = f.pessoa_id)
    //                 AND funcionario_st = 0
    //                 AND (funcionario_dt_demissao = '' or funcionario_dt_demissao is null)
    //                 AND funcionario_tipo_id <> 7
    //                 /*AND funcionario_validacao_rh = 1	*/
    // 				" . $StringRetornoFiltro . "
    //                 and p.pessoa_id in (select v2.pessoa_id from vi_pessoa_unidade_orcamentaria2 ve where v2.unidade_orcamentaria_id = ".$_SESSION['unidade_orcamentaria_id'].")
    //             ORDER BY UPPER(pessoa_nm)";
    $sql = "select 
                v2.pessoa_id
                ,trim(v2.pessoa_nm) as pessoa_nm                
                from vi_pessoa_unidade_orcamentaria2 v2 
                    inner join dados_unico.funcionario f
                        on f.pessoa_id = v2.pessoa_id AND funcionario_tipo_id not in (7, 150)
                where v2.unidade_orcamentaria_id = " . $_SESSION['unidade_orcamentaria_id'] . "  $StringRetornoFiltro
                ORDER BY UPPER(v2.pessoa_nm)";
    //  echo_pre($sql);
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    $rs = pg_query(abreConexao(), $sql);

    $String = CalculaTamanhoDiaria($QtdTracos);

    echo "<option value=0>.:Selecione:.</option>";

    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == $linha['pessoa_id']) {
            echo "<option selected value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}
function ComboBeneficiarioSimples($NomeCombo)
{ /* $codigoEscolhido = é o ID do sistema que é passado.
  $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
  $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
  $Tamanho = É o tamanho do combo passado em px.
  $QtdTracos = É a quantidade de traços que irá separar o [ da palavra Selecione
 */


    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";
    //A pedido da CMO 05.02.2014 - Liberação diárias para funcionário terceirizado
    //AND f.funcionario_tipo_id <> 3
    $sql = "SELECT f.pessoa_id,
                   pessoa_nm
                FROM dados_unico.pessoa p,
                     dados_unico.funcionario f
                WHERE (p.pessoa_id = f.pessoa_id)
                    AND funcionario_st = 0
                    AND funcionario_dt_demissao = ''
                    AND funcionario_tipo_id <> 7
                    AND funcionario_validacao_rh = 1	
					" . $StringRetornoFiltro . "
                ORDER BY UPPER(pessoa_nm)";
    //echo_pre($sql);
    $rs = pg_query(abreConexao(), $sql);

    $String = CalculaTamanhoDiaria($QtdTracos);

    echo "<option value=0>.:Selecione:.</option>";

    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == $linha['pessoa_id']) {
            echo "<option selected value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  FUNÇÃO QUE EXIBE OS BENEFICIÁRIOS DO SISTEMA DE DIÁRIAS
 * ***************************************************************************** */

function ComboBeneficiario2($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{ /* $codigoEscolhido = é o ID do sistema que é passado.
  $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
  $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
  $Tamanho = É o tamanho do combo passado em px.
  $QtdTracos = É a quantidade de traços que irá separar o [ da palavra Selecione
 */
    //echo "------------";
    if ($_SESSION['ComboBeneficiarioDiariaOff'] == "disabled") {
        $StringRetornoFiltro = " AND f.pessoa_id = " . $codigoEscolhido;
    } else {
        $StringRetornoFiltro = "";
    }


    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    //A pedido da CMO 05.02.2014 - Liberação diárias para funcionário terceirizado
    //AND f.funcionario_tipo_id <> 3

    $sql = "SELECT f.pessoa_id,
                   pessoa_nm
                FROM dados_unico.pessoa p,
                     dados_unico.funcionario f
                WHERE (p.pessoa_id = f.pessoa_id)
                    AND funcionario_st = 0
                   	
					" . $StringRetornoFiltro . "
                ORDER BY UPPER(pessoa_nm)";

    $rs = pg_query(abreConexao(), $sql);

    $String = CalculaTamanhoDiaria($QtdTracos);

    echo "<option value=0>.:Selecione:.</option>";

    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == $linha['pessoa_id']) {
            echo "<option selected value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}



function ComboDiariaStatus($NomeCombo, $FuncaoJavaScript)
{


    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . "  onchange='" . $FuncaoJavaScript . "'>";

    $sql = "select * from diaria.status order by status_nm";

    $rs = pg_query(abreConexao(), $sql);

    echo "<option value=''>.:Selecione:.</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        echo "<option value=" . $linha['status_cd'] . ">" . $linha['status_nm'] . "</option>";
    }
    echo "</select>";
}
function ComboPassagensStatus($NomeCombo, $FuncaoJavaScript)
{


    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . "  onchange='" . $FuncaoJavaScript . "'>";

    $sql = "select * from passagens.status order by status_nm";

    $rs = pg_query(abreConexao(), $sql);

    echo "<option value=''>.:Selecione:.</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        echo "<option value=" . $linha['status_cd'] . ">" . $linha['status_nm'] . "</option>";
    }
    echo "</select>";
}
function ComboDiariaPendenciaStatus($NomeCombo, $FuncaoJavaScript)
{


    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . "  onchange='" . $FuncaoJavaScript . "'>";

    $sql = "select * from diaria.pendencia_status order by pendencia_ds";

    $rs = pg_query(abreConexao(), $sql);

    echo "<option value=''>.:Selecione:.</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        echo "<option value=" . $linha['pendencia_status_id'] . ">" . $linha['pendencia_ds'] . "</option>";
    }
    echo "</select>";
}

function ComboDiariaTransporte($NomeCombo, $FuncaoJavaScript)
{


    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . "  onchange='" . $FuncaoJavaScript . "'>";

    $sql = "select * from transporte.status order by status_nm";

    $rs = pg_query(abreConexao(), $sql);

    echo "<option value=''>.:Selecione:.</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        echo "<option value=" . $linha['status_cd'] . ">" . $linha['status_nm'] . "</option>";
    }
    echo "</select>";
}

/* * *****************************************************************************
  FUNÇÃO QUE EXIBE OS BENEFICIÁRIOS DO SISTEMA DE DIÁRIAS POR UNIDADE
 * ***************************************************************************** */

function ComboBeneficiarioPorUnidade($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos, $Unidade)
{ /* $codigoEscolhido = é o ID do sistema que é passado.
  $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
  $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
  $Tamanho = É o tamanho do combo passado em px.
  $QtdTracos = É a quantidade de traços que irá separar o [ da palavra Selecione
  $Unidade = é o ID da unidade do beneficiário que é passado.
 */
    //echo "------------";
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    //A pedido da CMO 05.02.2014 - Liberação diárias para funcionário terceirizado
    //AND f.funcionario_tipo_id <> 3

    $sql = "SELECT 	f.pessoa_id,
				p.pessoa_nm
			FROM 	
				dados_unico.pessoa p,
				dados_unico.funcionario f,
				dados_unico.est_organizacional_funcionario ef,
				dados_unico.est_organizacional o
			WHERE 	(p.pessoa_id = f.pessoa_id)
				AND f.funcionario_st = 0
				AND f.funcionario_dt_demissao = ''
				AND f.funcionario_tipo_id <> 7
				AND f.funcionario_validacao_rh = 1 
				AND f.funcionario_diaria_bloqueio = 0
				AND p.pessoa_st = 0
				AND ef.funcionario_id	= f.funcionario_id 
				AND ef.est_organizacional_funcionario_st = 0
				AND ef.est_organizacional_id = o.est_organizacional_id
				AND o.est_organizacional_id= " . $Unidade . "
			ORDER BY UPPER(pessoa_nm)";

    $rs = pg_query(abreConexao(), $sql);

    $String = CalculaTamanhoDiaria($QtdTracos);

    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == $linha['pessoa_id']) {
            echo "<option selected value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  FUNÇÃO QUE EXIBE OS BENEFICIÁRIOS DO SISTEMA DE DIÁRIAS
 * ***************************************************************************** */

function ComboSolicitanteTrnasporte($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{ /* $codigoEscolhido = é o ID do sistema que é passado.
  $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
  $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
  $Tamanho = É o tamanho do combo passado em px.
  $QtdTracos = É a quantidade de traços que irá separar o [ da palavra Selecione
 */
    //echo "------------";
    $sql = "SELECT f.pessoa_id,
                   pessoa_nm
                FROM dados_unico.pessoa p,
                     dados_unico.funcionario f
                WHERE (p.pessoa_id = f.pessoa_id)
                    AND funcionario_st = 0
                 
                ORDER BY UPPER(pessoa_nm)";


    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";



    /*
      AND funcionario_tipo_id <> 3
      AND funcionario_tipo_id <> 7
      AND funcionario_validacao_rh = 1
     */

    $rs = pg_query(abreConexao(), $sql);

    $String = CalculaTamanhoDiaria($QtdTracos);

    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == $linha['pessoa_id']) {
            echo "<option selected value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}
function ComboSolicitanteDiariaEmergencial($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{

    //echo "------------";
    $sql = "SELECT f.pessoa_id,
                   v.pessoa_nm
                FROM dados_unico.pessoa p,
                     dados_unico.funcionario f,
                     vi_pessoa_unidade_orcamentaria2 v
                WHERE p.pessoa_id = f.pessoa_id
                and v.pessoa_id = p.pessoa_id
                and v.unidade_orcamentaria_id = " . $_SESSION['unidade_orcamentaria_id'] . "  
                    AND funcionario_st = 0
                 
                ORDER BY UPPER(trim(v.pessoa_nm))";
    // ECHO_PRE($sql);

    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";



    /*
      AND funcionario_tipo_id <> 3
      AND funcionario_tipo_id <> 7
      AND funcionario_validacao_rh = 1
     */

    $rs = pg_query(abreConexao(), $sql);

    $String = CalculaTamanhoDiaria($QtdTracos);

    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == $linha['pessoa_id']) {
            echo "<option selected value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  FUNÇÃO UNIDADE DE CUSTO
 * ***************************************************************************** */

function ComboACP($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{ /* $codigoEscolhido = é o ID do sistema que é passado.
  $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
  $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
  $Tamanho = É o tamanho do combo passado em px.
  $QtdTracos = É a quantidade de traços que irá separar o [ da palavra Selecione
 */
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    $sql = "SELECT * FROM dados_unico.est_organizacional
                WHERE est_organizacional_centro_custo = 1
                    AND est_organizacional_st = 0
                ORDER BY est_organizacional_centro_custo_num";
    $rs = pg_query(abreConexao(), $sql);

    $String = CalculaTamanhoDiaria($QtdTracos);

    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    echo "<option value=0></option>";

    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido != "") {
            if ((int) $codigoEscolhido == (int) $linha['est_organizacional_id']) {
                echo "<option value=" . $linha['est_organizacional_id'] . " selected>" . $linha['est_organizacional_centro_custo_num'] . " ----> "
                    . $linha['est_organizacional_sigla'] . " ----> " . $linha['est_organizacional_ds'] . "</option>";
            } else {
                echo "<option value=" . $linha['est_organizacional_id'] . ">" . $linha['est_organizacional_centro_custo_num'] . " ----> "
                    . $linha['est_organizacional_sigla'] . " ----> " . $linha['est_organizacional_ds'] . "</option>";
            }
        } else {
            echo "<option value=" . $linha['est_organizacional_id'] . ">" . $linha['est_organizacional_centro_custo_num'] . " ----> "
                . $linha['est_organizacional_sigla'] . " ----> " . $linha['est_organizacional_ds'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  FUNÇÃO QUE RETORNA A QUANTIDADE DE TRAÇOS PARA O COMBO
 * ***************************************************************************** */

function CalculaTamanhoDiaria($QtdTracos)
{ //$QtdTracos é a quantidade de - que será exibido no combo.
    $Cont = 0;
    $String = '';
    while ($Cont < $QtdTracos) {
        if ($String == '') {
            $String = '-';
        } else {
            $String .= '-';
        }
        $Cont++;
    }
    return $String;
}
