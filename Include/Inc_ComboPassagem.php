<?php

//funcao que exibe combo com os tipo passagem
Function f_ComboTipoPassagem($NomeCombo, $FuncaoJavaScript, $codigoEscolhido) {

    echo "<select name=" . $NomeCombo . " id=" . $NomeCombo . " style=width:382px " . $FuncaoJavaScript . ">";
    $sql = "SELECT tipo_passagem_id, tipo_passagem_ds, tipo_passagem_dt_criacao, tipo_passagem_dt_alteracao FROM passagens.tipo_passagem;";
    $rs = pg_query(abreConexao(), $sql);

    echo "<option value=0>[--------------------------------------------------- Selecione ----------------------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        $value = $linha['tipo_passagem_id'];
        $descricao = $linha['tipo_passagem_ds'];

        //if($codigoEscolhido == $descricao)
        if ($codigoEscolhido == $value) {
            echo "<option value=" . $value . " selected>" . $descricao . "</option>";
        } else {
            echo"<option value=" . $value . ">" . $descricao . "</option>";
        }
    }
    return "</select>";
}

Function ComboTipoPassagem($NomeCombo, $FuncaoJavaScript, $codigoEscolhido) {

    echo "<select name=" . $NomeCombo . " style=width:150px " . $FuncaoJavaScript . ">";
    $sql = "SELECT tipo_passagem_id, tipo_passagem_ds, tipo_passagem_dt_criacao, tipo_passagem_dt_alteracao FROM passagens.tipo_passagem;";
    $rs = pg_query(abreConexao(), $sql);

    echo "<option value=0>[--------- Selecione -------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        $value = $linha['tipo_passagem_id'];
        $descricao = $linha['tipo_passagem_ds'];

        //if($codigoEscolhido == $descricao)
        if ($codigoEscolhido == $value) {
            echo "<option value=" . $value . " selected>" . $descricao . "</option>";
        } else {
            echo"<option value=" . $value . ">" . $descricao . "</option>";
        }
    }
    return "</select>";
}

/* * ***************************************************************************
 * Função que exibe combo com as empresas por tipo de passagem
 * $NomeCombo = é o NOME do combo que será passado para a função.
 * $codigoEscolhido = é o CÓDIGO do município que está sendo passado.
 * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
 * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
 * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
 * *************************************************************************** */

Function ComboEmpresaPassagem($NomeCombo, $TipoEmpresaFuncao, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho) {

    if (!empty($TipoEmpresaFuncao)) {

        /* if($TipoEmpresaFuncao == "")
          {
          $TipoEmpresaFuncao = 1;
          } */

        //echo "<select name=".$NomeCombo." style=width:382px ".$FuncaoJavaScript.">";
        echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

        $sql = "SELECT	empresa_id, tipo_passagem_id, empresa_nm, empresa_nom_contato, empresa_endereco, estado_uf, municipio_cd, empresa_email, empresa_num_fone,
				empresa_num_fax, empresa_num_cnpj, empresa_num_inscr_estadual, empresa_dt_criacao, empresa_hr_criacao
				FROM	passagens.empresa
				WHERE	empresa_st = 0 and tipo_passagem_id =" . $TipoEmpresaFuncao . " ORDER BY empresa_nm;";

        $rs = pg_query(abreConexao(), $sql);

        echo "<option value=0>[--------------------------------------------------- Selecione ----------------------------------------------]</option>";
        while ($linha = pg_fetch_assoc($rs)) {
            $value = $linha['empresa_id'];
            $descricao = $linha['empresa_nm'];

            //if($codigoEscolhido == $descricao)
            if ($codigoEscolhido == $value) {
                echo "<option value=" . $value . " selected>" . $descricao . "</option>";
            } else {
                echo"<option value=" . $value . ">" . $descricao . "</option>";
            }
        }
        return "</select>";
    }
}

/*
  Function f_ComboDiariaPassagem($NomeCombo,$codigoEscolhido, $dataInicial, $Beneficiario, $FuncaoJavaScript){

  echo	"<select name=".$NomeCombo." style=width:110px ".$FuncaoJavaScript.">";

  $sql	=	"SELECT d.diaria_id, d.diaria_numero FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, dados_unico.pessoa_fisica pf
  WHERE (pf.pessoa_id = f.pessoa_id)
  AND (p.pessoa_id = f.pessoa_id)
  AND (d.diaria_beneficiario = f.pessoa_id)
  AND p.pessoa_id = ".$Beneficiario." and d.diaria_dt_saida = '".$dataInicial."'";

  $rs		= pg_query(abreConexao(),$sql);

  echo "<option value=0>[------Selecione-----]</option>";
  while ($linha=pg_fetch_assoc($rs)){
  $value		= $linha['diaria_id'];
  $descricao	= $linha['diaria_numero'];


  if($codigoEscolhido == $value)
  {
  echo "<option selected  value=" .$value. ">" .$descricao. "</option>";
  }else{
  echo "<option  value=" .$value. ">" .$descricao. "</option>";
  }
  }
  return "</select>";
  } */

/* $CodigoSistema = é o ID da ação que é passada
  $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo
  $Acao = serve para desabilitar o combo para o mesmo não ser alterado
 */

Function f_ComboTipoUserGeralPassagem($CodigoSistema, $FuncaoJavaScript, $Acao) {
    echo "<select name=cmbTipoUserGeral " . $Acao . " style=width:230px " . $FuncaoJavaScript . ">";

    $sql = "SELECT tipo_usuario_id, tipo_usuario_ds FROM seguranca.tipo_usuario WHERE sistema_id = " . $CodigoSistema . " AND tipo_usuario_st = 0 AND tipo_usuario_id NOT IN(87)  ORDER BY tipo_usuario_ds";
    $rs = pg_query(abreConexao(), $sql);

    echo "<option value=0>[ ----------------------- Selecione ----------------------- ]</option>";

    While ($linha = pg_fetch_assoc($rs)) {
        $codigo = $linha ['tipo_usuario_id'];
        $descricao = $linha ['tipo_usuario_ds'];
        if ((int) $CodigoSistema == (int) $codigo) {
            echo "<option value=" . $codigo . " selected>" . $descricao . "</option>";
        } else {
            echo "<option value=" . $codigo . ">" . $descricao . "</option>";
        }
    }
    echo "</select>";
}

Function ComboUsuarioModuloPassagem($CodigoSistema, $CodigoTipoUsuario, $codigoEscolhido, $FuncaoJavaScript) {
    if (!empty($CodigoTipoUsuario)) {

        echo "<select name=cmbUsuarioModulo  style = width:280px " . $FuncaoJavaScript . ">";

        //$CodigoTipoUsuario	= intval($_GET['Tipo_Usuario_id']);

        if ($CodigoTipoUsuario == "") {
            $sql = "SELECT 	p.pessoa_id, p.pessoa_nm
				FROM seguranca.usuario_tipo_usuario utu
				JOIN seguranca.tipo_usuario tu 		ON utu.tipo_usuario_id 		= tu.tipo_usuario_id
				JOIN dados_unico.pessoa p			ON utu.pessoa_id 		= p.pessoa_id
				WHERE 		tu.sistema_id 			= " . $CodigoSistema . "
				ORDER BY	UPPER(pessoa_nm)";
        } else {
            $sql = "SELECT 	p.pessoa_id, p.pessoa_nm
				FROM seguranca.usuario_tipo_usuario utu
				JOIN seguranca.tipo_usuario tu 			ON utu.tipo_usuario_id 		= tu.tipo_usuario_id
				JOIN dados_unico.pessoa p			ON utu.pessoa_id 		= p.pessoa_id
				WHERE 		tu.tipo_usuario_id 	= " . $CodigoTipoUsuario . "
				AND			tu.sistema_id 		= " . $CodigoSistema . "
				ORDER BY	UPPER(pessoa_nm)";
        }


        $rs = pg_query(abreConexao(), $sql);

        echo "<option value=0>[----------------------------------- Selecione ------------------------------]</option>";
        //converte para inteiro o (int)$codigoEscolhido
        while ($linha = pg_fetch_assoc($rs)) {
            if ($codigoEscolhido == $linha['pessoa_id']) {
                echo "<option  value=" . $linha['pessoa_id'] . " selected>" . $linha['pessoa_nm'] . "</option>";
            } else {
                echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
            }
        }
        echo "</select>";
        //echo $sql;
    }
}

/*
 * *************************************************
  projetos
 * *************************************************
 */

function f_ComboProjetoPassagem($codigoEscolhido, $FuncaoJavaScript) {
    echo "<select id='cmbProjeto' name='cmbProjeto' style='width:785px;' " . $FuncaoJavaScript . ">";
    $sql = "SELECT projeto_cd, projeto_ds FROM diaria.projeto WHERE projeto_st = 0 ORDER BY projeto_cd";
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    echo "<option value=0></option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if ((int) $codigoEscolhido == (int) ($linha['projeto_cd'])) {
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

function f_ComboProjetoPassagemPAOE($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Tamanho, $EO_Funcionario_id) {

    if ($EO_Funcionario_id != "") {
        $sql = "SELECT 	DISTINCT P.projeto_cd, P.projeto_ds 
					FROM	diaria.projeto P, diaria.associacao_PAOE AP
					WHERE	(P.projeto_cd = AP.projeto_cd) AND
							P.projeto_st = 0 AND
							AP.est_organizacional_id = " . $EO_Funcionario_id . "   
					ORDER BY projeto_cd";
        $rs = pg_query(abreConexao(), $sql);

        /* }else{

          $sql	= "SELECT DISTINCT projeto_cd, projeto_ds FROM diaria.projeto WHERE projeto_st = 0 ORDER BY projeto_cd";
          $rs		= pg_query(abreConexao(),$sql);
          } */

        echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " style='width: " . $Tamanho . ";' " . $FuncaoJavaScript . ">";
        echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
        while ($linha = pg_fetch_assoc($rs)) {
            if ((int) $codigoEscolhido == (int) ($linha['projeto_cd'])) {
                echo "<option value=" . $linha['projeto_cd'] . " selected>" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
            } else {
                echo "<option value=" . $linha['projeto_cd'] . ">" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
            }
        }
        echo "</select>";
    }
}

Function f_ComboProjetoAux($codigoEscolhido, $FuncaoJavaScript, $unidadeCusto) {
    echo "<select name=cmbProjeto style=width:785px " . $FuncaoJavaScript . ">";

    if (!empty($unidadeCusto)) {
        $sql = "SELECT projeto_cd, projeto_ds
					FROM diaria.projeto WHERE projeto_st = 0 and est_organizacional_id = " . $unidadeCusto . "
					ORDER BY projeto_cd";

        $rs = pg_query(abreConexao(), $sql);
        echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
        echo "<option value=0></option>";
        while ($linha = pg_fetch_assoc($rs)) {
            if ($codigoEscolhido == ($linha['projeto_cd'])) {
                echo "<option value=" . $linha['projeto_cd'] . " selected>" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
            } else {
                echo "<option value=" . $linha['projeto_cd'] . ">" . $linha['projeto_cd'] . " ----> " . $linha['projeto_ds'] . "</option>";
            }
        }
    } else {
        echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
        echo "<option value=0></option>";
    }

    echo "</select>";
}

//86 ADM 87 SOLIC 88AUTOR //89APROVA  //90DA
function f_ComboAutorizadorPassagens($codigoEscolhido, $Nome) {

    //echo "<select name=cmbAutorizador".$Nome."[] id=cmbAutorizador".$Nome." style='width:793px;height:193px ' multiple='multiple' >";
    echo "<select id='cmbAutorizador" . $Nome . "' name='cmbAutorizador" . $Nome . "' style=width:382px>";

    $sql = "SELECT	f.pessoa_id, pessoa_nm 
			FROM	dados_unico.pessoa p, dados_unico.funcionario f, seguranca.usuario_tipo_usuario utu 
			WHERE	(p.pessoa_id = utu.pessoa_id) AND 
					(p.pessoa_id = f.pessoa_id) AND 
					p.pessoa_st = 0 AND 
					(utu.tipo_usuario_id = 88 or utu.tipo_usuario_id = 89 or utu.tipo_usuario_id = 90) 
			ORDER BY 
					UPPER(pessoa_nm)";

    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=0>[--------------------------------------------------- Selecione ------------------------------------------------]</option>";
    while ($linha = pg_fetch_assoc($rs)) {
        if (isset($codigoEscolhido)) {
            /* if (in_array($linha['pessoa_id'], $codigoEscolhido))
              {
              echo "<option value=" .$linha['pessoa_id']." selected>" .$linha['pessoa_nm']."</option>";
              }
              else
              {
              echo "<option value=" .$linha['pessoa_id']. ">" .$linha['pessoa_nm']. "</option>";
              } */

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
  FUNÇÃO QUE EXIBE OS BENEFICIÁRIOS DO SISTEMA DE PASSAGENS

  $codigoEscolhido	= é o ID do sistema que é passado.
  $FuncaoJavaScript	= é a função JAVASCRIPT que é passado para o combo.
  $Acao				= serve para desabilitar o combo para o mesmo não ser alterado.
  $Tamanho			= é o tamanho do combo passado em px.
  $QtdTracos			= é a quantidade de traços que irá separar o [ da palavra Selecione

 * ***************************************************************************** */

//Function ComboBeneficiarioPassagens($codigoEscolhido, $FuncaoJavaScript)
Function ComboBeneficiarioPassagens($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos) {
    //echo "<select name=cmbBeneficiario style=width:382px ".$FuncaoJavaScript.">";
    //Filtro por Lotação
    if ($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Administrador") { //ADM
        //AND funcionario_tipo_id <> 3

        /* $sql = "SELECT f.pessoa_id, pessoa_nm FROM dados_unico.pessoa p ,dados_unico.funcionario f
          WHERE (p.pessoa_id = f.pessoa_id) AND pessoa_st = 0  AND
          funcionario_validacao_rh = 1 GROUP BY f.pessoa_id, pessoa_nm ORDER BY UPPER(pessoa_nm)"; */

        $sql = "SELECT	f.pessoa_id, p.pessoa_nm 
				FROM	dados_unico.pessoa p ,
						dados_unico.funcionario f, vi_pessoa_unidade_orcamentaria2 v
				WHERE 
						(p.pessoa_id				= f.pessoa_id)		AND 
						p.pessoa_st					= 0					AND
						f.funcionario_validacao_rh	= 1					AND 
						f.funcionario_st			= 0					AND
						f.funcionario_dt_demissao	= ''				AND
						f.funcionario_tipo_id		<> 7				AND
						f.funcionario_validacao_rh	= 1	
                                                and v.pessoa_id                 = p.pessoa_id
                                                /*and v.unidade_orcamentaria_id = " . $_SESSION['UnidadeOrcamentariaId'] . "*/
				ORDER BY UPPER(p.pessoa_nm)";
    } else if ($_SESSION["Sistemas"][$_SESSION["Sistema"]] == "Aprovador") { //Aprovador
        $sql = "SELECT f.pessoa_id, p.pessoa_nm, ef.est_organizacional_id
				
                    FROM dados_unico.pessoa p
                        , dados_unico.funcionario f
                        , dados_unico.est_organizacional_funcionario ef
                        , vi_pessoa_unidade_orcamentaria2 v
				WHERE (p.pessoa_id = f.pessoa_id) AND pessoa_st = 0 AND funcionario_tipo_id <> 3 AND funcionario_validacao_rh = 1
				AND ef.funcionario_id = f.funcionario_id AND
				(
				ef.est_organizacional_id = (select efb.est_organizacional_id from dados_unico.funcionario dfb, dados_unico.est_organizacional_funcionario efb where dfb.pessoa_id =" . $_SESSION['UsuarioCodigo'] . " AND dfb.funcionario_id = efb.funcionario_id and efb.est_organizacional_funcionario_st = 0)
				or
				p.pessoa_id in (select utu.pessoa_id from seguranca.usuario_tipo_usuario utu where utu.tipo_usuario_id in(88,89) and utu.pessoa_id not in (218,83,86,95,430,307,700,331,391))
				or
				f.pessoa_id in (176,835,412,253,599,441,424,701)
				)
				AND ef.est_organizacional_funcionario_st = 0
                                and v.pessoa_id                 = p.pessoa_id
                                and v.unidade_orcamentaria_id = " . $_SESSION['UnidadeOrcamentariaId'] . "
				GROUP BY f.pessoa_id, pessoa_nm, ef.est_organizacional_id
				ORDER BY UPPER(p.pessoa_nm)";
    } else {
        //listar todos os funcionados do setor e sub-setor
        /* $sql = "SELECT f.pessoa_id, pessoa_nm FROM dados_unico.pessoa p ,dados_unico.funcionario f, dados_unico.est_organizacional_funcionario ef
          WHERE (p.pessoa_id = f.pessoa_id) AND pessoa_st = 0  AND
          funcionario_validacao_rh = 1 AND ef.funcionario_id = f.funcionario_id
          AND (
          ef.est_organizacional_id =
          (select efb.est_organizacional_id from dados_unico.funcionario dfb, dados_unico.est_organizacional_funcionario efb where dfb.pessoa_id =".$_SESSION['UsuarioCodigo']." AND dfb.funcionario_id = efb.funcionario_id and efb.est_organizacional_funcionario_st = 0) OR
          ef.est_organizacional_id in
          (select est_organizacional_id
          from dados_unico.est_organizacional eo
          where eo.est_organizacional_st = 0
          and est_organizacional_sup_cd = (select efb.est_organizacional_id from dados_unico.funcionario dfb, dados_unico.est_organizacional_funcionario efb where dfb.pessoa_id =".$_SESSION['UsuarioCodigo']." AND dfb.funcionario_id = efb.funcionario_id and efb.est_organizacional_funcionario_st = 0))
          )
          AND ef.est_organizacional_funcionario_st = 0
          GROUP BY f.pessoa_id, pessoa_nm ORDER BY UPPER(pessoa_nm)"; */

        //listar todos os funcionados 
        $sql = "SELECT	f.pessoa_id, p.pessoa_nm 
                                FROM              dados_unico.pessoa p 
						, dados_unico.funcionario f
                                                , vi_pessoa_unidade_orcamentaria2 v
				WHERE 
						   (p.pessoa_id = f.pessoa_id) 
						and p.pessoa_st = 0 
						and f.funcionario_validacao_rh = 1  
						and f.funcionario_st = 0 
						and f.funcionario_dt_demissao = '' 
						and f.funcionario_tipo_id <> 7 
						and f.funcionario_validacao_rh = 1
                                                and v.pessoa_id = p.pessoa_id
                                                and v.unidade_orcamentaria_id = " . $_SESSION['UnidadeOrcamentariaId'] . "
				ORDER BY UPPER(p.pessoa_nm)";
    }
    //echo_pre($sql);
    $rs = pg_query(abreConexao(), $sql);

    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";
    $String = CalculaTamanhoDiaria($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == $linha['pessoa_id']) {
            echo "<option selected value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}

Function ComboBeneficiarioPassagens2($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos) {

    $sql = "select * from
(
select max(pessoa_id) as pessoa_id, upper(pessoa_nm) as pessoa_nm  
                          from dados_unico.pessoa p where pessoa_tipo='F' and pessoa_st =0/*and pessoa_nm ilike '%carmen%'*/ 

                          group by pessoa_nm
                          ) as consulta order by pessoa_nm ";
    //echo_pre($sql);
    
    $rs = pg_query(abreConexao(), $sql);

    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";
    $String = CalculaTamanhoDiaria($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == $linha['pessoa_id']) {
            echo "<option selected value=" . $linha['pessoa_id'] . ">" . trim(utf8_encode($linha['pessoa_nm'])) . "</option>";
        } else {
            echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *******************PASSAGEM TEMP****************** */

/* * *****************************************************************************
  FUNÇÃO UNIDADE DE CUSTO

  $codigoEscolhido	= é o ID do sistema que é passado.
  $FuncaoJavaScript	= é a função JAVASCRIPT que é passado para o combo.
  $Acao				= serve para desabilitar o combo para o mesmo não ser alterado.
  $Tamanho			= É o tamanho do combo passado em px.
  $QtdTracos			= É a quantidade de traços que irá separar o [ da palavra Selecione
 * ***************************************************************************** */

//Function ComboACPPassagem($codigoEscolhido, $FuncaoJavaScript)
Function ComboACPPassagem($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos) {
    //echo "<select name=cmbUnidadeCusto style=width:785px ".$FuncaoJavaScript.">";

    /* $sql = "SELECT	* 
      FROM	dados_unico.est_organizacional
      WHERE	est_organizacional_centro_custo = 1 AND
      est_organizacional_st = 0
      ORDER BY est_organizacional_centro_custo_num"; */


    $sql = "SELECT * 
			FROM	dados_unico.est_organizacional 
			WHERE	est_organizacional_centro_custo = 1 AND
					est_organizacional_st = 0 AND 
					est_organizacional_id = " . $codigoEscolhido;

    $rs = pg_query(abreConexao(), $sql);

    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

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
  Combo do TIPO DE DOCUMENTO quando a Diaria foi INDENIZADA
 * ***************************************************************************** */

//function f_ComboDocumentoPassagem($codigoEscolhido) 
Function f_ComboDocumentoPassagem($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos) {
    $sqlConsulta = "SELECT * FROM passagens.passagem_tipo_doc ORDER BY passagem_tipo_doc_ds";
    $rs = pg_query(abreConexao(), $sqlConsulta);

    //echo "<select id='cmbDocumento' name='cmbDocumento' style=width:240px >";
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    $String = CalculaTamanhoDiaria($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";
    echo "<option value=0></option>";

    //echo "<option value=0>[-------------------------- Selecione --------------------------]</option>";
    //echo "<option value=0></option>";

    while ($linhars = pg_fetch_assoc($rs)) {
        if ($codigoEscolhido == ($linhars['passagem_tipo_doc_id'])) {
            echo "<option value=" . $linhars['passagem_tipo_doc_id'] . " selected>" . $linhars['passagem_tipo_doc_ds'] . "</option>";
        } else {
            echo "<option value=" . $linhars['passagem_tipo_doc_id'] . ">" . $linhars['passagem_tipo_doc_ds'] . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  COMBO QUE EXIBE O(S) MEIO(S) DE TRANSPORTE TERRESTRE
 * ***************************************************************************** */

function f_ComboMeioTransportePassagem($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos) {
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
                FROM passagens.categoria_transporte
                WHERE categoria_transporte_st = 0 
                ORDER BY UPPER(categoria_transporte_ds)";
    $rs = pg_query(abreConexao(), $sql);

    $String = RetornarQtdeTracos($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        $codigo = $linha['categoria_transporte_id'];
        $descricao = $linha['categoria_transporte_ds'];
        if ((int) ($codigoEscolhido) == (int) ($codigo)) {
            echo "<option value=" . $codigo . " selected>" . $descricao . "</option>";
        } else {
            echo "<option value=" . $codigo . ">" . $descricao . "</option>";
        }
    }
    echo "</select>";
}

/* * *****************************************************************************
  FUNÇÃO QUE RETORNA A QUANTIDADE DE TRAÇOS PARA O COMBO
 * ***************************************************************************** */

function CalculaTamanhoPassagem($QtdTracos) {//$QtdTracos é a quantidade de - que será exibido no combo.
    $Cont = 0;
    $String = '';
    while ($Cont < $QtdTracos) {
        if ($String == '') {
            $String = '-';
        } else {
            $String .= '-';
        }
        $Cont ++;
    }
    return $String;
}

?>
