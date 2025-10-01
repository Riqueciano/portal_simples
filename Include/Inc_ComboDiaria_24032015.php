<?php
/*******************************************************************************
        FUN��O QUE EXIBE OS BENEFICI�RIOS DO SISTEMA DE DI�RIAS
*******************************************************************************/
Function ComboBeneficiario($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{   /*$codigoEscolhido = � o ID do sistema que � passado.
      $FuncaoJavaScript = � a fun��o JAVASCRIPT que � passado para o combo.
      $Acao = serve para desabilitar o combo para o mesmo n�o ser alterado.
      $Tamanho = � o tamanho do combo passado em px.
      $QtdTracos = � a quantidade de tra�os que ir� separar o [ da palavra Selecione
    */
	//echo "------------";
    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

	//A pedido da CMO 05.02.2014 - Libera��o di�rias para funcion�rio terceirizado
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
                ORDER BY UPPER(pessoa_nm)";

    $rs = pg_query(abreConexao(),$sql);

    $String = CalculaTamanhoDiaria ($QtdTracos);

    echo "<option value=0>[ ".$String." Selecione ".$String." ]</option>";

    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs))
    {
        if ($codigoEscolhido==$linha['pessoa_id'])
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

/*******************************************************************************
        FUN��O QUE EXIBE OS BENEFICI�RIOS DO SISTEMA DE DI�RIAS POR UNIDADE
*******************************************************************************/
Function ComboBeneficiarioPorUnidade($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos, $Unidade)
{   /*$codigoEscolhido = � o ID do sistema que � passado.
      $FuncaoJavaScript = � a fun��o JAVASCRIPT que � passado para o combo.
      $Acao = serve para desabilitar o combo para o mesmo n�o ser alterado.
      $Tamanho = � o tamanho do combo passado em px.
      $QtdTracos = � a quantidade de tra�os que ir� separar o [ da palavra Selecione
	  $Unidade = � o ID da unidade do benefici�rio que � passado.
    */
	//echo "------------";
    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

	//A pedido da CMO 05.02.2014 - Libera��o di�rias para funcion�rio terceirizado
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
				AND o.est_organizacional_id= ".$Unidade."
			ORDER BY UPPER(pessoa_nm)";

    $rs = pg_query(abreConexao(),$sql);

    $String = CalculaTamanhoDiaria ($QtdTracos);

    echo "<option value=0>[ ".$String." Selecione ".$String." ]</option>";

    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs))
    {
        if ($codigoEscolhido==$linha['pessoa_id'])
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



/*******************************************************************************
        FUN��O QUE EXIBE OS BENEFICI�RIOS DO SISTEMA DE DI�RIAS
*******************************************************************************/
Function ComboSolicitanteTrnasporte($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{   /*$codigoEscolhido = � o ID do sistema que � passado.
      $FuncaoJavaScript = � a fun��o JAVASCRIPT que � passado para o combo.
      $Acao = serve para desabilitar o combo para o mesmo n�o ser alterado.
      $Tamanho = � o tamanho do combo passado em px.
      $QtdTracos = � a quantidade de tra�os que ir� separar o [ da palavra Selecione
    */
	//echo "------------";
    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

    $sql = "SELECT f.pessoa_id,
                   pessoa_nm
                FROM dados_unico.pessoa p,
                     dados_unico.funcionario f
                WHERE (p.pessoa_id = f.pessoa_id)
                    AND funcionario_st = 0
                    AND funcionario_dt_demissao = ''
                ORDER BY UPPER(pessoa_nm)";

	/*
                    AND funcionario_tipo_id <> 3
                    AND funcionario_tipo_id <> 7
                    AND funcionario_validacao_rh = 1	
	*/

    $rs = pg_query(abreConexao(),$sql);

    $String = CalculaTamanhoDiaria ($QtdTracos);

    echo "<option value=0>[ ".$String." Selecione ".$String." ]</option>";

    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs))
    {
        if ($codigoEscolhido==$linha['pessoa_id'])
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
/*******************************************************************************
                        FUN��O UNIDADE DE CUSTO
*******************************************************************************/
Function ComboACP($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{   /*$codigoEscolhido = � o ID do sistema que � passado.
      $FuncaoJavaScript = � a fun��o JAVASCRIPT que � passado para o combo.
      $Acao = serve para desabilitar o combo para o mesmo n�o ser alterado.
      $Tamanho = � o tamanho do combo passado em px.
      $QtdTracos = � a quantidade de tra�os que ir� separar o [ da palavra Selecione
    */
    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

    $sql = "SELECT * FROM dados_unico.est_organizacional
                WHERE est_organizacional_centro_custo = 1
                    AND est_organizacional_st = 0
                ORDER BY est_organizacional_centro_custo_num";
    $rs=pg_query(abreConexao(),$sql);

    $String = CalculaTamanhoDiaria ($QtdTracos);

    echo "<option value=0>[ ".$String." Selecione ".$String." ]</option>";

    echo "<option value=0></option>";

    while ($linha=pg_fetch_assoc($rs))
    {
        if($codigoEscolhido!="")
        {
            if ((int)$codigoEscolhido==(int)$linha['est_organizacional_id'])
            {
                echo  "<option value=".$linha['est_organizacional_id']." selected>".$linha['est_organizacional_centro_custo_num']." ----> "
                    .$linha['est_organizacional_sigla']." ----> ".$linha['est_organizacional_ds']."</option>";
            }
            else
            {
                echo "<option value=".$linha['est_organizacional_id'].">".$linha['est_organizacional_centro_custo_num']. " ----> "
                    .$linha['est_organizacional_sigla']." ----> ".$linha['est_organizacional_ds']."</option>";
            }
        }
        else
        {
            echo "<option value=".$linha['est_organizacional_id'].">".$linha['est_organizacional_centro_custo_num']." ----> "
                .$linha['est_organizacional_sigla']." ----> ".$linha['est_organizacional_ds']."</option>";
        }
    }
    echo "</select>";
}
/*******************************************************************************
        FUN��O QUE RETORNA A QUANTIDADE DE TRA�OS PARA O COMBO
*******************************************************************************/
function CalculaTamanhoDiaria ($QtdTracos)
{//$QtdTracos � a quantidade de - que ser� exibido no combo.
    $Cont   = 0;
    $String ='';
    while ( $Cont < $QtdTracos )
    {
       if ($String == '')
       {
           $String = '-';
       }
       else
       {
           $String .= '-';
       }
       $Cont ++;
    }
    return $String;
}


?>