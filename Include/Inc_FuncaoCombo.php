<?php
/*
**************************************************
combo que carrega as pessoas juridicas
**************************************************
 *
 */
function f_ComboPJ($codigoEscolhido){ 
  
  $sql = "SELECT pessoa_id, pessoa_nm FROM dados_unico.pessoa WHERE pessoa_st = 0 AND pessoa_tipo = 'J' ORDER BY UPPER(pessoa_nm)";
 
  echo "<select id='cmbPJ' name='cmbPJ' style=width:300px>";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=0>[------------------------------------ Selecione ------------------------------------]</option>";
  while($linha=pg_fetch_assoc($rs))
  { $codigo = $linha['pessoa_id'];
	$descricao 	= $linha['pessoa_nm'];
	if ((int)$codigoEscolhido== (int)$codigo)
    {  echo "<option value=" .$codigo. " selected>" .$descricao."</option>";
    }
    else
    {  echo "<option value=" .$codigo.">".$descricao."</option>";
    }
  }
  echo "</select>";
}
function f_ComboSetor($nome,$acao,$tamanho,$param){ 
  
  $sql = "SELECT * from dados_unico.est_organizacional where est_organizacional_st =0 $param order by est_organizacional_sigla ";
 //echo $sql;
  echo "<select id='$nome' name='$nome' style='width:$tamanho' onchenge='$acao' >";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=''>.:Selecione:.</option>";
  while($linha=pg_fetch_assoc($rs)){
        $codigo = $linha['est_organizacional_id'];
	$descricao 	= $linha['est_organizacional_sigla'];
        echo "<option value=" .$codigo. " >" .$descricao."</option>";
  }
  echo "</select>";
}
/*
**************************************************
combo que carrega as pessoas juridicas para contrato
**************************************************
 *
 */
function f_ComboPJContrato($codigoEscolhido)
{ echo "<select id='cmbPJ' name='cmbPJ' style=width:300px>";
  $sql = "SELECT p.pessoa_id, pessoa_nm FROM dados_unico.pessoa p, dados_unico.pessoa_juridica pj WHERE (p.pessoa_id = pj.pessoa_id) AND pessoa_juridica_fornecedor = 1 AND pessoa_st = 0 AND pessoa_tipo = 'J' ORDER BY UPPER(pessoa_nm)";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=0>[------------------------------------ Selecione ------------------------------------]</option>";
  while($linha=pg_fetch_assoc($rs))
  {  $codigo = $linha['pessoa_id'];
     $descricao = $linha['pessoa_nm'];
     if((int)$codigoEscolhido==(int)$codigo)
     {  echo "<option value=" .$codigo. " selected>".$descricao."</option>";
     }
	 else
     {  echo "<option value=".$codigo.">".$descricao."</option>";
     }

 }
 echo "</select>";

}
/*
 *consulta cargos permanentes e temporarios
 */
function f_ComboCargo($NomeCombo, $codigoEscolhido,$Tipo,$tamanho="302")
{  
	$sql = "SELECT * FROM dados_unico.cargo WHERE funcionario_tipo_id =".$Tipo." AND cargo_st = 0 AND cargo_id <> 0 ORDER BY UPPER(cargo_ds)";
	echo "<select id='".$NomeCombo."' name='".$NomeCombo."' style=width:".$tamanho."px>";
   
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[------------------------------------ Selecione ------------------------------------]</option>";
   while($linha=pg_fetch_assoc($rs))
   {
     if ($codigoEscolhido==$linha['cargo_id'])
     {  echo "<option value=" .$linha['cargo_id']. " selected>".$linha['cargo_ds']. "</option>";
     }
	 else
     { echo"<option value=" .$linha['cargo_id']. ">".$linha['cargo_ds']. "</option>";
     }

   }
   echo "</select>";
}

/*
**************************************************
combo que carrega as funcoes
**************************************************
 *
 */
function f_ComboFuncao($codigoEscolhido)
{  echo "<select id='cmbFuncao' name='cmbFuncao' style=width:260px>";
   $sql = "SELECT * FROM dados_unico.funcao WHERE funcao_st = 0 AND funcao_id <> 0 ORDER BY UPPER(funcao_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[----------------------------- Selecione -----------------------------]</option>";
   while($linha=pg_fetch_assoc($rs))
   {  $codigo = $linha['funcao_id'];
      $descricao = $linha['funcao_ds'];
      if((int)$codigoEscolhido==(int)$codigo)
      {  echo "<option value=" .$codigo. " selected>".$descricao."</option>";
      }
      else
      {  echo "<option value=".$codigo.">".$descricao. "</option>";
      }
   }
   echo "</select>";
}
/*
**************************************************
combo que carrega as lotacoes
**************************************************
 *
 */
function f_ComboLotacao($codigoEscolhido)
{  echo "<select id='cmbLotacao' name='cmbLotacao' style=width:200px>";
   $sql = "SELECT * FROM dados_unico.lotacao WHERE lotacao_st = 0 AND lotacao_id <> 0 ORDER BY UPPER(lotacao_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[------------------- Selecione -------------------]</option>";
   while($linha=pg_fetch_assoc($rs))
   {  $codigo = $linha['lotacao_id'];
      $descricao = $linha['lotacao_ds'];
      if((int)$codigoEscolhido==(int)$codigo)
      {  echo "<option value=".$codigo." selected>".$descricao."</option>";
      }
      else
      {  echo "<option value=".$codigo.">" .$descricao. "</option>";
      }
   }
   echo "</select>";
}
/*
**************************************************
combo que carrega contratos
**************************************************
 *
 */
function f_ComboContrato($codigoEscolhido, $FuncaoJavaScript)
{  /*  esta parte do codigo jÃ¡ estava comentada no asp e nÃ£o sofreu alteraÃ§Ã£o
   sqlTotal 	= "SELECT COUNT(*) FROM dados_unico.funcionario WHERE contrato_st = 0 AND contrato_id <> 0 ORDER BY UPPER(contrato_ds)"
   Set rsTotal = objConexao.execute(sqlTotal)
 *
 */
   echo "<select id='cmbContrato' name='cmbContrato' ".$FuncaoJavaScript." style=width:330px>";
   $sql = "SELECT * FROM dados_unico.contrato WHERE contrato_st = 0 AND contrato_id <> 0 ORDER BY UPPER(contrato_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[----------------------------------------- Selecione -----------------------------------------]</option>";
   while($linha=pg_fetch_assoc($rs))
   { $codigo = $linha['contrato_id'];
	 $descricao = $linha['contrato_ds'];
	 $numero = $linha['contrato_num'];
	 $total = $linha['contrato_num_max'];
     
     $sqlConsultaTipo = "SELECT funcionario_tipo_id FROM dados_unico.funcionario_tipo WHERE funcionario_tipo_terceirizado = 1";
	 $rsConsultaTipo=pg_query(abreConexao(),$sqlConsultaTipo);
     $linha2=pg_fetch_assoc($rsConsultaTipo);

     if($linha2)
     {  $CodigoTipo = $linha2['funcionario_tipo_id'];
     }
     
     $sqlConsultaQtde = "SELECT COUNT(funcionario_id) as Total FROM dados_unico.funcionario WHERE contrato_id = '".$codigo. "'"." AND funcionario_tipo_id = '".$CodigoTipo."'";
	 $rsConsultaQtde=pg_query(abreConexao(),$sqlConsultaQtde);
     /* esta parte do codigo jÃ¡ estava comentada no asp e nÃ£o sofreu alteraÃ§Ã£o
      * If CInt(total) > CInt(rsConsultaQtde("Total")) Then
      */
     if((int)$codigoEscolhido==(int)$codigo)
     {  echo "<option value=".$codigo." selected>".$numero." - " .$descricao."</option>";
     }
     else
     {  echo "<option value=".$codigo.">".$numero." - ".$descricao."</option>";
     }
   
  }
  echo "</select>";

}
/*
**************************************************
carrega os tipos de contrato
**************************************************
 *
 */
function f_ContratoTipo($codigoEscolhido)
{  echo "<select id='cmbContratoTipo' name='cmbContratoTipo' style=width:160px>";
   $sql = "SELECT * FROM dados_unico.contrato_tipo ORDER BY UPPER(contrato_tipo_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[------------- Selecione ------------]</option>";
   echo "<option value=0></option>";
   while($linha=pg_fetch_assoc($rs))
   {  $codigo = $linha['contrato_tipo_id'];
	  $descricao = $linha['contrato_tipo_ds'];
	  if((int)$codigoEscolhido==(int)$codigo)
      {  echo "<option value=".$codigo. " selected>".$descricao. "</option>";
      }
      else
      {  echo "<option value=" .$codigo. ">" .$descricao. "</option>";
      }
   }
   echo "</select>";
}

function f_ComboSistema($NomeCombo, $codigoEscolhido, $FuncaoJavaScript)
{  echo "<select id='".$NomeCombo. "' name='".$NomeCombo. "' style=width:240px " .$FuncaoJavaScript. ">";
   $sql = "SELECT sistema_id, sistema_nm FROM seguranca.sistema WHERE sistema_st = 0 ORDER BY UPPER(sistema_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[-------------------------- Selecione --------------------------]</option>";
    while($linha=pg_fetch_assoc($rs))
    {  $codigo = $linha['sistema_id'];
	   $descricao = $linha['sistema_nm'];
	   if((int)$codigoEscolhido==(int)$codigo)
       {  echo "<option value=" .$codigo. " selected>".$descricao. "</option>";
       }
       else
       {  echo "<option value=" .$codigo. ">" .$descricao. "</option>";
       }
    }
   echo "</select>";
}

function f_ComboSecao($NomeCombo, $codigoEscolhido, $codigoFiltro)
{  echo "<select id='".$NomeCombo."' name='".$NomeCombo."' style=width:240px>";
   $sql = "SELECT * FROM seguranca.secao WHERE secao_st = 0 AND sistema_id = '" .$codigoFiltro."'". " ORDER BY UPPER(secao_ds)";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[-------------------------- Selecione --------------------------]</option>";
   while($linha=pg_fetch_assoc($rs))
    {  $codigo = $linha['secao_id'];
	   $descricao = $linha['secao_ds'];
          if((int)$codigoEscolhido==(int)$codigo)
       {  echo "<option value=" .$codigo. " selected>".$descricao. "</option>";
       }
       else
       {  echo "<option value=" .$codigo. ">" .$descricao. "</option>";
       }
    }
   echo "</select>";
}
/*******************************************************************************
    COMBO QUE IRÁ CARREGAR TODAS AS CLASSES CADASTRADAS NO CADASTRO ÚNICO
*******************************************************************************/
function f_ComboClasse($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{
    /*****************************************************************************
    * $NomeCombo = é o NOME do combo que será passado para a função.
    * $codigoEscolhido = é o CÓDIGO da classe que está sendo passado.
    * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
    * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
    * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
    * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
    *****************************************************************************/
    echo "<select id='".$NomeCombo."' name='".$NomeCombo."' ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";
    
    $sqlClasse = "SELECT * FROM diaria.classe WHERE classe_st = 0 ORDER BY UPPER(classe_nm)";
    $rsClasse=pg_query(abreConexao(),$sqlClasse);

    $String = RetornarQtdeTracos ($QtdTracos);
    echo "<option value=0>[ ".$String." Selecione ".$String." ]</option>";

    while ($linhaClasse=pg_fetch_assoc($rsClasse))
    {
        $codigo    = $linhaClasse['classe_id'];
	$descricao = $linhaClasse['classe_nm']." - ".$linhaClasse['classe_ds'];
        if ((int)($codigoEscolhido) == (int)($codigo))
	{
            echo "<option value=".$codigo." selected>".$descricao."</option>";
        }
        else
        {
            echo "<option value=".$codigo.">".$descricao."</option>";
        }
    }
    echo "</select>";
}
/*******************************************************************************
    COMBO QUE IRÁ CARREGAR TODAS AS CLASSES CADASTRADAS NO CADASTRO ÚNICO - 
  A DIFERENÇA DA FUNÇÃO ACIMA É QUE NESTA TRARÁ APENAS O NOME DE CADA CLASSE
*******************************************************************************/
function f_ComboClasseNome($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{
    /*****************************************************************************
    * $NomeCombo = é o NOME do combo que será passado para a função.
    * $codigoEscolhido = é a STRING da classe que está sendo passado.
    * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
    * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
    * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
    * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
    *****************************************************************************/
    echo "<select id='".$NomeCombo."' name='".$NomeCombo."' ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";
    
    $sqlClasse = "SELECT classe_nm 
                        FROM diaria.classe 
                        WHERE classe_st = 0 
                        GROUP BY classe_nm 
                        ORDER BY UPPER(classe_nm)";
    $rsClasse=pg_query(abreConexao(),$sqlClasse);

    $String = RetornarQtdeTracos ($QtdTracos);
    echo "<option value=0>[ ".$String." Selecione ".$String." ]</option>";

    while ($linhaClasse=pg_fetch_assoc($rsClasse))
    {
        $codigo    = trim($linhaClasse['classe_nm']);
	$descricao = trim($linhaClasse['classe_nm'])." - CLASSE ".trim($linhaClasse['classe_nm']);
        if ((string)trim(($codigoEscolhido)) == (string)($codigo))
	{
            echo "<option value=".$codigo." selected>".$descricao."</option>";
        }
        else
        {
            echo "<option value=".$codigo.">".$descricao."</option>";
        }
    }
    echo "</select>";
}
/*******************************************************************************
        COMBO QUE IRÁ CARREGAR TODOS OS GRUPO DE PAISESA CADASTRADOS
*******************************************************************************/
function f_ComboPaisGrupo($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{
    /*****************************************************************************
    * $NomeCombo = é o NOME do combo que será passado para a função.
    * $codigoEscolhido = é o CÓDIGO do país grupo que está sendo passado.
    * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
    * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
    * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
    * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
    *****************************************************************************/
    echo "<select id='".$NomeCombo."' name='".$NomeCombo."' ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

    $sqlPaisGrupo = "SELECT * 
                        FROM dados_unico.pais_grupo
                        WHERE pais_grupo_st = 0 
                        ORDER BY UPPER(pais_grupo_nm)";
    $rsPaisGrupo=pg_query(abreConexao(),$sqlPaisGrupo);

    $String = RetornarQtdeTracos ($QtdTracos);
    echo "<option value=0>[ ".$String." Selecione ".$String." ]</option>";

    while ($linhaPaisGrupo=pg_fetch_assoc($rsPaisGrupo))
    {
        $codigo    = $linhaPaisGrupo['pais_grupo_id'];
	$descricao = $linhaPaisGrupo['pais_grupo_nm'];
        if ((int)($codigoEscolhido) == (int)($codigo))
	{
            echo "<option value=".$codigo." selected>".$descricao."</option>";
        }
        else
        {
            echo "<option value=".$codigo.">".$descricao."</option>";
        }
    }
    echo "</select>";
}

/*******************************************************************************
        FUNÇÃO QUE EXIBE OS BENEFICIÁRIOS DO SISTEMA DE DIÁRIAS
*******************************************************************************/
Function ComboFuncionario($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos){ 
   
    
    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

    $sql = "SELECT f.funcionario_id,
                   p.pessoa_nm
                FROM dados_unico.pessoa p,
                     dados_unico.funcionario f
                WHERE (p.pessoa_id = f.pessoa_id)
                    AND funcionario_st = 0
                ORDER BY UPPER(pessoa_nm)";

    $rs = pg_query(abreConexao(),$sql);

    $String = CalculaTamanhoDiaria ($QtdTracos);

    echo "<option value=0>.:Selecione:.</option>";

    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs))
    {
        if ($codigoEscolhido==$linha['pessoa_id'] and !empty($codigoEscolhido))
        {
            echo "<option selected value=".$linha['pessoa_id'].">".$linha['pessoa_nm']."</option>";
        }
        else
        {
            echo "<option value=" .$linha['pessoa_id'].">".$linha['pessoa_nm']."</option>";
        }
    }
    echo "</select>";
}

Function ComboADUnidadeOrcamentaria($NomeCombo, $FuncaoJavaScript, $Acao, $Tamanho){   /*$codigoEscolhido = é o ID do sistema que é passado.
      $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
      $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
      $Tamanho = É o tamanho do combo passado em px.
      $QtdTracos = É a quantidade de traços que irá separar o [ da palavra Selecione
    */
	//echo "------------";
    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

    $sql = "select * from adiantamento.unidade_orcamentaria
                ORDER BY unidade_orcamentaria_nm";

    $rs = pg_query(abreConexao(),$sql);

    echo "<option value=0>.:Selecione:.</option>";

    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs)){
            echo "<option value=" .$linha['unidade_orcamentaria_id'].">".$linha['unidade_orcamentaria_nm']."</option>";   
    }
    echo "</select>";
}

?>