<?php
/*
**************************************************
função para inserir log diaria
**************************************************
 *
 */
function f_InsereLogDiaria($Pessoa,$Diaria,$Descricao)
{ $sql="INSERT INTO diaria.diaria_log (diaria_id, pessoa_id, diaria_log_dt, diaria_log_hr, diaria_log_ds) VALUES ('" .$Diaria. "'". ", '"
           .$Pessoa. "'".  ", '"."'" .$Date."'".  "', '" ."'".$Time."'". "', '"."'" .$Descricao."'". "')";
	pg_query(abreConexao(),$sql);

}
/*
**************************************************
função para inserir log
**************************************************
 *
 */
function f_InsereLog($Descricao)
{
	$sql = "INSERT INTO dados_unico.log_evento (pessoa_id, log_evento_dt, log_evento_hr, log_evento_ds) VALUES ('" .$_SESSION['UsuarioCodigo']."'"
    .", '" ."'".$Date."'". "', '"."'". $Time."'". "', '" ."'". $Descricao."'". "')";
    pg_query(abreConexao(),$sqlMenu);
}
/*'**************************************************

**************************************************
função para formata data no padrao DD/MM/AAAA
**************************************************
 *
 */
function f_FormataData($Data)
{   $vetData = explode("/", $Data);
    $Dia = $vetData[0];
	$Mes = $vetData[1];
	$Ano = $vetData[2];
    if(strlen($Dia)==1)
	{ $Dia = "0". $Dia;
    }
	if (strlen($Mes)==1)
	{	$Mes = "0" . $Mes;
    }
    return implode("/", array($Dia,$Mes,$Ano));


}
/*
 *************************************************

**************************************************
função para carregar os paises
**************************************************
 *
 */
function f_ComboPais($NomeCombo, $codigoEscolhido)
{  print "<select name=" .$NomeCombo." style=width:100px>";
   $sql = "SELECT pais_ds FROM dados_unico.pais";
   $rs=pg_query(abreConexao(),$sql);
   While ($linha=pg_fetch_assoc($rs))
   {  $descricao = $rs['pais_ds'];
      if ($codigoEscolhido == $descricao)
      { print "<option value=" .$descricao. " selected>" .$descricao. "</option>";
      }
	  else
	  {	print "<option value=" .$descricao.">" .$descricao."</option>";
       }
   }
	print "</select>";

}
/*
**************************************************
**************************************************
função para carregar os estados
**************************************************
 *
 */
function f_ComboEstado($NomeCombo,$FuncaoJavaScript,$codigoEscolhido)
{  print "<select name=" .$NomeCombo. " style=width:45px " .$FuncaoJavaScript.  ">";
   $sql = "SELECT estado_uf FROM dados_unico.estado";
   $rs=pg_query(abreConexao(),$sql);
   while ($linha=pg_fetch_assoc($rs))
   {  $descricao = $linha['estado_uf'];
      if($codigoEscolhido == $descricao)
	  {  print "<option value=" .$descricao. " selected>" .$descricao. "</option>";
      }
	  else
	  { print"<option value=" .$descricao. ">" .$descricao. "</option>";
      }
   }
   print "</select>";


}
/*
**************************************************

**************************************************
função para carregar os municipios
**************************************************
 *
 */
function f_ComboMunicipio($NomeCombo,$EstadoFuncao, $codigoEscolhido)
{  if($EstadoFuncao == "")
    { $EstadoFuncao = "BA";
    }
    print "<select name=" .$NomeCombo. " style=width:200px>";
	$sql = "SELECT municipio_cd, municipio_ds, municipio_capital FROM dados_unico.municipio WHERE estado_uf = '"."'". $EstadoFuncao."'". "' ORDER BY municipio_ds";
	$rs=pg_query(abreConexao(),$sql);
    while ($linha=pg_fetch_assoc($rs)) 
    { $codigo = $linha['municipio_cd'];
	  $descricao = $linha['municipio_ds'];
	  $capital = $linha['municipio_capital'];
      if (strval($codigoEscolhido) == strval($codigo))
	  {  print "<option value=" .$codigo.  " selected>"  .$descricao.  "</option>";
      }
      else
	  { if (((int)$capital == 1) && ($codigoEscolhido == ""))
		{ print "<option value=" .$codigo." selected>" .$descricao. "</option>";
        }
        Else
		{ print "<option value=" .$codigo. ">" .$descricao. "</option>";
        }
      }
    }
    print "</select>";
}
/*
**************************************************


**************************************************
função para carregar os niveis escolares
**************************************************
 *
 */
function f_ComboNivelEscolar($codigoEscolhido)
{  print "<select name=cmbNivelEscolar style=width:120px>";
   $sql = "SELECT * FROM dados_unico.nivel_escolar WHERE nivel_escolar_st = 0 AND nivel_escolar_id <> 0 ORDER BY nivel_escolar_ds";
   $rs=pg_query(abreConexao(),$sql);
   print "<option value=0>[------ Selecione ------]</option>";
   while ($linha=pg_fetch_assoc($rs)) 
   {  $codigo = $linha['nivel_escolar_id'];
	  $descricao = $linha['nivel_escolar_ds'];
	  if (((int)$codigoEscolhido) == ((int)$codigo))
	  {  print "<option value=" .$codigo. " selected>" .$descricao. "</option>";
      }
      else
	  {	print "<option value=" .$codigo. ">"  .substr($descricao,0,47). "</option>";
      }
   }
   print "</select>";


}
/*
**************************************************

**************************************************
função para carregar os estados civis
**************************************************
 *
 */
function f_ComboEstadoCivil($codigoEscolhido)
{  print "<select name=cmbEstadoCivil style=width:120px>";
   $sql = "SELECT * FROM dados_unico.estado_civil WHERE estado_civil_st = 0 AND estado_civil_id <> 0 ORDER BY estado_civil_ds";
   $rs=pg_query(abreConexao(),$sql);
   print "<option value=0>[------ Selecione ------]</option>";
   while ($linha=pg_fetch_assoc($rs))
   {  $codigo=$linha['estado_civil_id'];
	  $descricao=$linha['estado_civil_ds'];
	  if ((int)$codigoEscolhido== (int)$codigo)
      {  print "<option value=" .$codigo. " selected>" .$descricao. "</option>";
      }
      else
	  {  print "<option value=".$codigo. ">" .substr($descricao,0,47). "</option>";
      }
    }
	print"</select>";


}
/*
**************************************************

**************************************************
função para carregar os tipos de funcionários
**************************************************
 *
 */
function f_ComboTipoFuncionario($codigoEscolhido)
{ print "<select name=cmbFuncionarioTipo style=width:140px>";
  $sql = "SELECT * FROM dados_unico.funcionario_tipo WHERE funcionario_tipo_terceirizado = 0 ORDER BY funcionario_tipo_ds";
  $rs=pg_query(abreConexao(),$sql);
  print "<option value=0>[--------- Selecione ---------]</option>";
  while ($linha=pg_fetch_assoc($rs)) 
  { $codigo = $linha['funcionario_tipo_id'];
	$descricao = $linha['funcionario_tipo_ds'];
    if ((int)$codigoEscolhido==(int)$codigo)
      {  print "<option value=" .$codigo. " selected>" .$descricao. "</option>";
      }
      else
	  {  print "<option value=".$codigo. ">" .substr($descricao,0,47). "</option>";
      }
   }
   print"</select>";


}
/*
**************************************************


**************************************************

**************************************************
função para carregar ministerios da defesa
**************************************************
 *
 */
function f_ComboMinisterio($codigoEscolhido)
{ if($codigoEscolhido != "")
  { switch ($codigoEscolhido)
    {
    case "Aeronáutica":
      $MinisterioAero = "selected";
        break;
    case "Exército":
        $MinisterioExer = "selected";
        break;
    case "Marinha":
        $MinisterioMari = "selected";
        break;
    }
  }
  print "<select name=cmbMinisterio style=width:120px>";
  print "<option value=0>[------ Selecione ------]</option>";
  print "<option value=Aeronáutica ".$MinisterioAero. ">Aeronáutica</option>";
  print "<option value=Exército ".$MinisterioExer.">Exército</option>";
  print "<option value=Marinha ".$MinisterioMari.">Marinha</option>";
  print "</select>";

}
/*
**************************************************

**************************************************
função para carregar estrutura organizacional sigla
**************************************************
 *
 */
function f_ComboEstruturaOrganizacionalSigla()
{  print "<select name=cmbEstOrganizacional style=width:200px>";
   $sql = "SELECT * FROM dados_unico.est_organizacional WHERE est_organizacional_st = 0 ORDER BY est_organizacional_sigla";
   $rs=pg_query(abreConexao(),$sql);
   print"<option value=0>[------------------- Selecione -------------------]</option>";
   While ($linha=pg_fetch_assoc($rs))
   { $codigo = $linha['est_organizacional_id'];
	 $descricao = $linha['est_organizacional_sigla'];
	 print "<option value=" .$codigo.">" .$descricao."</option>";
    }
	print"</select>";

}
/*
'**************************************************
 carrega a estrutura de atuacao da secretaria (exercendo alguma funcao)
 */

function f_ComboEstruturaOrganizacional($NomeCombo, $codigoEscolhido)
{ print "<select name=" .$NomeCombo." style=width:200px>";
  $sql = "SELECT * FROM dados_unico.est_organizacional WHERE est_organizacional_st = 0 ORDER BY est_organizacional_sigla";
  $rs=pg_query(abreConexao(),$sql);
  print"<option value=0>[------------------- Selecione -------------------]</option>";
   While ($linha=pg_fetch_assoc($rs))
   { if ((int)$codigoEscolhido== (int)($linha['est_organizacional_id']))
     {  print "<option value=" .$rs['est_organizacional_id']. " selected>".$linha['est_organizacional_sigla']. "</option>";
     }
	 else
     { print"<option value=" .$linha['est_organizacional_id']. ">".$linha['est_organizacional_sigla']. "</option>";
     }

   }
   print "</select>";
}
/*
 * carrega a estrutura de lotacao da secretaria (origem)
 */


/*
**************************************************
função para carregar bancos (unidades financeiras)
**************************************************
 * //Carrega combo de bancos
 */
Function f_ComboBanco($codigoEscolhido)
{ print "<select name=cmbBanco style=width:190px>";
  $sql = "SELECT * FROM dados_unico.banco WHERE banco_st = 0 AND banco_id <> 0 ORDER BY UPPER(banco_ds)";
  $rs=pg_query(abreConexao(),$sql);
  print "<option value=0>[------------------ Selecione ------------------]</option>";
  While ($linha=pg_fetch_assoc($rs))
  { $codigo = $linha ['banco_id'];
    $descricao= $linha ['banco_ds'];
	if((int)$codigoEscolhido==(int)$codigo)
	{ print "<option value=" .$codigo." selected>".$descricao."</option>";
    }
    else
    { print "<option value=".$codigo. ">".$descricao."</option>";
    }
  }
  print "</select>";
}
		
/*
**************************************************

**************************************************
função para carregar tipos de conta
**************************************************
 *
 */
function f_ComboTipoConta($codigoEscolhido)
{

   switch ($codigoEscolhido) 
    {
    case "C":
      $ContaPoupanca = "selected";
        break;
    case "P":
        $ContaPoupanca = "selected";
        break;
    
    }
    print "<select name=cmbTipoConta style=width:115px>";
	print "<option value=C ".$ContaCorrente. ">Conta Corrente</option>";
	print "<option value=P ".$ContaPoupanca. ">Conta Poupança</option>";
	print "</select>";

}
/*
'**************************************************
'carrega os orgaos do estado da bahia
 *
 */
function f_ComboOrgao($codigoEscolhido,$NomeCombo)
{ print "<select name=" .$NomeCombo. " style=width:175px>";
  $sql = "SELECT * FROM dados_unico.orgao WHERE orgao_st = 0 AND orgao_id <> 0 ORDER BY UPPER(orgao_ds)";
  $rs=pg_query(abreConexao(),$sql);
  print "<option value=0>[------------------------------------------------- Selecione -------------------------------------------------]</option>";
  While ($linha=pg_fetch_assoc($rs))
  { if($codigoEscolhido != "")
    {  if ((int)$codigoEscolhido == (int)($linha ['orgao_id']))
       { print "<option value=" .$linha ['orgao_id']. " selected>" .$linha ['orgao_ds']."</option>";
       }
	  else
	  {	print "<option value=" .$linha ['orgao_id'].">" .$linha ['orgao_ds']. "</option>";
      }
    }
	else
	{  print "<option value=" .$linha ['orgao_id']. ">" .$linha ['orgao_ds']. "</option>";
    }
   }
	print  "</select>";
}

/*

'**************************************************
'função para carregar grupo sanguineo
'**************************************************
 *
 */
function f_ComboGrupoSanguineo($codigoEscolhido)
{
		switch ($codigoEscolhido)
        { case "A+":
              $SangueAP = "selected";
              break;
          case "A-":
              $SangueAN = "selected";
              break;
          case "AB+":
              $SangueABP = "selected";
              break;
          case "AB-":
              $SangueABN = "selected";
              break;
         case "B+":
              $SangueBP = "selected";
              break;
          case "B-":
              $SangueBN = "selected";
              break;
          case "O+":
              $SangueOP = "selected";
              break;
          case "O-":
              $SangueON = "selected";
              break;

    }
    print "<select name=cmbGrupoSanguineo style=width:120px>";
	print "<option value=0>[------ Selecione ------]</option>";
	print "<option value=A+ ".$SangueAP. ">Tipo A+</option>";
	print "<option value=A- " .$SangueAN. ">Tipo A-</option>";
	print "<option value=AB+ " .$SangueABP. ">Tipo AB+</option>";
	print "<option value=AB- " .$SangueABN.">Tipo AB-</option>";
	print "<option value=B+ " .$SangueBP.">Tipo B+</option>";
	print"<option value=B- " .$SangueBN. ">Tipo B-</option>";
	print "<option value=O+ " .$SangueOP. ">Tipo O+</option>";
	print"<option value=O- " .$SangueON. ">Tipo O-</option>";
	print"</select>";

}
/*
'**************************************************

'**************************************************
'função para carregar órgãos do governo do estado
'**************************************************
 *
 */
Function f_ConsultaEstadoCivil($codigoEscolhido)
{  $sql = "SELECT estado_civil_ds FROM dados_unico.estado_civil WHERE estado_civil_id = '" .$codigoEscolhido."'";
		$rs=pg_query(abreConexao(),$sql);
        $linha=pg_fetch_assoc($rs);
		print $linha['estado_civil_ds'];
}
/*
'**************************************************

'**************************************************
'função para carregar órgãos do governo do estado
'**************************************************
 *
 */
function f_ConsultaNivelEscolar($codigoEscolhido)
{ $sql = "SELECT nivel_escolar_ds FROM dados_unico.nivel_escolar WHERE nivel_escolar_id = '".$codigoEscolhido."'";
  $rs=pg_query(abreConexao(),$sql);
  $linha=pg_fetch_assoc($rs);
  print $linha['nivel_escolar_ds'];


}
/*
**************************************************

**************************************************
função para carregar órgãos do governo do estado
**************************************************
 *
 */
function f_ConsultaMunicipio($codigoEscolhido)
{  $sql = "SELECT municipio_ds FROM dados_unico.municipio WHERE municipio_cd = '" .$codigoEscolhido."'";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   print $linha['municipio_ds'];

}
/*
**************************************************

**************************************************
função para carregar órgãos do governo do estado
**************************************************
 *
 */
function f_ConsultaTipoFuncionario($codigoEscolhido)
{ $sql = "SELECT funcionario_tipo_ds FROM dados_unico.funcionario_tipo WHERE funcionario_tipo_id = '" .$codigoEscolhido."'";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   print $linha['funcionario_tipo_ds'];
}
/*
**************************************************

**************************************************
função para carregar órgãos do governo do estado
**************************************************
 *
 */
function f_ConsultaOrgao($codigoEscolhido)
{ $sql = "SELECT orgao_ds FROM dados_unico.orgao WHERE orgao_id = '".$codigoEscolhido."'";
  $rs=pg_query(abreConexao(),$sql);
  $linha=pg_fetch_assoc($rs);
  print $linha['orgao_ds'];


}
/*
 **************************************************

'**************************************************
'função para carregar órgãos do governo do estado
'**************************************************
 *
 */
function f_ConsultaEstruturaOrganizacional($codigoEscolhido)
{  if($codigoEscolhido!= "")
   { $sql = "SELECT est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = '".$codigoEscolhido."'";
	 $rs=pg_query(abreConexao(),$sql);
     $linha=pg_fetch_assoc($rs);
     print $linha['est_organizacional_ds'];

   }
}

function f_ConsultaEstruturaOrganizacionalLotacao($codigoEscolhido)
{ if (codigoEscolhido != "")
  { $sql = "SELECT est_organizacional_lotacao_ds FROM dados_unico.est_organizacional_lotacao WHERE est_organizacional_lotacao_id = '".$codigoEscolhido."'";
	$rs=pg_query(abreConexao(),$sql);
     $linha=pg_fetch_assoc($rs);
     print $linha['est_organizacional_lotacao_ds'];

  }
}
/*
'**************************************************

'**************************************************
'função para carregar órgãos do governo do estado
'**************************************************
 *
 */
function f_ConsultaEstruturaOrganizacionalSigla($codigoEscolhido)
{ if ($codigoEscolhido != "")
  { $sql = "SELECT est_organizacional_sigla FROM dados_unico.est_organizacional WHERE est_organizacional_id = '".$codigoEscolhido."'";
    $rs=pg_query(abreConexao(),$sql);
    $linha=pg_fetch_assoc($rs);
    print $linha['est_organizacional_sigla'];
  }
}

function f_PossuiFeriado($Inicio, $Fim)
{  $DataAcrescida = $Inicio;
  //retira a barra '/' da data e retorna um array
  $vetData=explode("/", $DataAcrescida);
  $DiaAcrescido = $vetData[0];
  $MesAcrescido = $vetData[1];
  $AnoAcrescido = $vetData[2];
  // depois inclui a barra '-' pois o strotime só trabalha com data no formato americano
  $DataAcrescida=implode("-", array($DiaAcrescido,$MesAcrescido,$AnoAcrescido));

  $vetDataF=explode("/", $Fim);
  $DiaAcrescidoF = $vetDataF[0];
  $MesAcrescidoF = $vetDataF[1];
  $AnoAcrescidoF = $vetDataF[2];
  $Fim=implode("-", array($DiaAcrescidoF,$MesAcrescidoF,$AnoAcrescidoF));

  $timestampDataAcrescida = strtotime($DataAcrescida);
  $timestampFim = strtotime($Fim);
  // compara o timeStamp

  //pega o ultimo dia do mes da data acrescida e o ultimo dia do anoAcrescido
  $ultimoDiaDoMesAcrescido = cal_days_in_month(CAL_GREGORIAN, $MesAcrescido, $AnoAcrescido);
  $ultimoDiaDoAno=cal_days_in_month(CAL_GREGORIAN, 12, $AnoAcrescido);

   While ($timestampDataAcrescida < $timestampFim)
   { $vetData = explode("-", $DataAcrescida);
     $DiaAcrescido = $vetData[0];
	 $MesAcrescido = $vetData[1];
	 $AnoAcrescido = $vetData[2];

     if (strlen($DiaAcrescido)==1)
	 {  $DiaAcrescido = "0" .$DiaAcrescido;
     }

     if(strlen($MesAcrescido)==1)
     { $MesAcrescido = "0" .$MesAcrescido;
     }
     // inclui a barra para pesquisar no banco
     $DataAcrescida = implode("/", array($DiaAcrescido,$MesAcrescido,$AnoAcrescido));

     $sqlConsultaFeriado = "SELECT feriado_id FROM dados_unico.feriado WHERE feriado_dt = '" .$DataAcrescida. "'";

     $rsConsultaFeriado=pg_query(abreConexao(),$sqlConsultaFeriado);
     $linha=pg_fetch_array($rsConsultaFeriado);
     // se encontrar um resultado retorna true
     if($linha>0)
     {  return true;
     }
     //DataAcrescida = DateAdd("d",1,DataAcrescida);
     // acrescenta-se mais um dia
     if($DiaAcrescido<$ultimoDiaDoMesAcrescido)
     {  $vetData[0]=$vetData[0]+1;
        $DiaAcrescido=$vetData[0];
     }
     // se o dia atingiu o ultimo dia do mês muda-se para o proximo mes
     else
     { $vetData[1]=$vetData[1]+1;
        $MesAcrescido=$vetData[1];
        $DiaAcrescido="01";
        $ultimoDiaDoMesAcrescido = cal_days_in_month(CAL_GREGORIAN, $MesAcrescido, $AnoAcrescido);
     }
     // se o dia atingiu o ultimo dia do mês muda-se para o proximo mes e for o ultimo mes do ano muda-se o ano
     if(($DiaAcrescido==$ultimoDiaDoAno)&&($MesAcrescido=="12"))
     { $DiaAcrescido="01";
       $MesAcrescido="01";
       $ultimoDiaDoAno=cal_days_in_month(CAL_GREGORIAN, 12, $AnoAcrescido);
       $vetData[2]=$vetData[2]+1;
       $AnoAcrescido=$vetData[2];
     }
     $DataAcrescida=implode("-", array($DiaAcrescido,$MesAcrescido,$AnoAcrescido));
     $timestampDataAcrescida = strtotime($DataAcrescida);
  }
  return false;
}

function f_PossuiFimSemana($Inicio, $Fim)
{ $DataAcrescida = $Inicio;
  //retira a barra '/' da data e retorna um array
  $vetData=explode("/", $DataAcrescida);
  $DiaAcrescido = $vetData[0];
  $MesAcrescido = $vetData[1];
  $AnoAcrescido = $vetData[2];
  // depois inclui a barra '-' pois o strotime sÃ³ trabalha com data no formato americano
  $DataAcrescida=implode("-", array($DiaAcrescido,$MesAcrescido,$AnoAcrescido));

  $vetDataF=explode("/", $Fim);
  $DiaAcrescidoF = $vetDataF[0];
  $MesAcrescidoF = $vetDataF[1];
  $AnoAcrescidoF = $vetDataF[2];
  $Fim=implode("-", array($DiaAcrescidoF,$MesAcrescidoF,$AnoAcrescidoF));

  $timestampDataAcrescida = strtotime($DataAcrescida);
  $timestampFim = strtotime($Fim);
  // compara o timeStamp

  //pega o ultimo dia do mes da data acrescida e o ultimo dia do anoAcrescido
  $ultimoDiaDoMesAcrescido = cal_days_in_month(CAL_GREGORIAN, $MesAcrescido, $AnoAcrescido);
  $ultimoDiaDoAno=cal_days_in_month(CAL_GREGORIAN, 12, $AnoAcrescido);
  while ( $timestampDataAcrescida <$timestampFim)
  { $vetData = explode("-", $DataAcrescida);
    $DiaAcrescido = $vetData[0];
	$MesAcrescido = $vetData[1];
	$AnoAcrescido = $vetData[2];
    $ultimo = mktime(0, 0, 0, $MesAcrescido, $DiaAcrescido, $AnoAcrescido);
    $dia_semana = date("w", $ultimo);
    if (($dia_semana== 0) || ($dia_semana== 6))
    { return true;
    }
     //DataAcrescida = DateAdd("d",1,DataAcrescida);
     // acrescenta-se mais um dia
     if($DiaAcrescido<$ultimoDiaDoMesAcrescido)
     {  $vetData[0]=$vetData[0]+1;
        $DiaAcrescido=$vetData[0];
     }
     // se o dia atingiu o ultimo dia do mês muda-se para o proximo mes
     else
     { $vetData[1]=$vetData[1]+1;
        $MesAcrescido=$vetData[1];
        $DiaAcrescido="01";
        $ultimoDiaDoMesAcrescido = cal_days_in_month(CAL_GREGORIAN, $MesAcrescido, $AnoAcrescido);
     }
     // se o dia atingiu o ultimo dia do mês muda-se para o proximo mes e for o ultimo mes do ano muda-se o ano
     if(($DiaAcrescido==$ultimoDiaDoAno)&&($MesAcrescido=="12"))
     { $DiaAcrescido="01";
       $MesAcrescido="01";
       $ultimoDiaDoAno=cal_days_in_month(CAL_GREGORIAN, 12, $AnoAcrescido);
       $vetData[2]=$vetData[2]+1;
       $AnoAcrescido=$vetData[2];
     }
     $DataAcrescida=implode("-", array($DiaAcrescido,$MesAcrescido,$AnoAcrescido));
     $timestampDataAcrescida = strtotime($DataAcrescida);
  }
  return false;


}

?>
