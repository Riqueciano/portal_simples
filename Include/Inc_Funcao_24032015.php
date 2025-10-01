<?php

//FUNÇÃO PARA INICIA AS TRANSAÇÕES COM O BANCO DE DADOS
/*function F_IniciarTransacao($conexao)
{
    pg_query($conexao, "BEGIN WORK");
}*/

//FUNÇÃO PARA FINALIZAR AS TRANSAÇÕES COM O BANCO DE DADOS
/*function F_FinalizarTransacao($conexao)
{
    if ($Err != 0)
    {
        pg_query($conexao, "ROLLBACK");
    }
    else
    {
        pg_query($conexao, "COMMIT");
    }
}*/

//FUNÇÃO QUE RECEBE DUAS DATAS (COM HORA, MINUTO E SEGUNDO) E RETORNA A DIFERENÇA ENTRE ELAS
function f_DiferencaTempo($DataInicio,$Datafim)
{
    $difMinutos         = 0;
    $DataInicioTmp      = substr($DataInicio, 0, 10);
    $DataFimTmp         = substr($Datafim, 0, 10);
    $HoraInicioTmp      = substr($DataInicio, 10, 15);
    $HoraFimTmp         = substr($Datafim, 10,15);

    // Divide a data  2010-09-16 00:00:00
    $DataInicio     = explode("/", $DataInicioTmp);
    $DataFim        = explode("/",  $DataFimTmp );
    //calcula a diferenca entre as horas
    //Divide a hora
    $HoraInicio = explode(":",$HoraInicioTmp);
    $HoraFim    = explode(":",$HoraFimTmp);

    // Transforma em minutos
    //int mktime ([ int $hora [, int $minuto [, int $second [, int $mes [, int $dia [, int $ano [, int $is_dst ]]]]]]] )
    $MinutoInicio = mktime($HoraInicio[0], $HoraInicio[1], "00", $DataInicio[1], $DataInicio[0], $DataInicio[2]);
    $MinutoFim    = mktime($HoraFim[0], $HoraFim[1], "00", $DataFim[1], $DataFim[0], $DataFim[2]);

    // Transforma em minutos
    $difMinutos = ($MinutoFim-$MinutoInicio)/60;
    $formato_tempo='';

        if ($difMinutos < 60){
            // Diferença em minutos
               $difDias = $difMinutos;
               $formato_tempo = " Min";
        }
        else if ($difMinutos >= 60 and $difMinutos < 1440){
            // Diferença em horas
               $difDias = $difMinutos/60;

               //VERIFICA SE A QUANTIDADE É MENOR OU MAIOR QUE 1
               if (intval($difDias) > 1){$formato_tempo = " Horas";} else {$formato_tempo = " Hora";};
        }
        else if ($difMinutos >= 1440){
             // DiferenÃ§a em dias
               $difDias = $difMinutos/1440;

               //VERIFICA SE A QUANTIDADE É MENOR OU MAIOR QUE 1
               if (intval($difDias) > 1){$formato_tempo = " Dias";} else {$formato_tempo = " Dia";};
        }


        // Trunca o numero de dias ..
        $NumeroDia = intval($difDias);
        return $NumeroDia.' '.$formato_tempo;
 }


function ConverteStringMoeda($valoreferencia){
/* Quando for usar esta função e o valor for negativo deve-se agir desta maneira.
 * 1º Usar a função ConverteStringMoeda
 * 2º Multiplicar o valor por -1.
 * Se esses passos não forem seguidos o valor que será retornado não irá
 * condizer com passado para a função.
*/
    $Valortmp 		= str_replace("R$","",$valoreferencia);
    $Valortmp		= str_replace(".","",$Valortmp);
    $Valortmp		= str_replace(",",".",$Valortmp);
    return $Valortmp;
}

/*
**************************************************
função para inserir log diária
**************************************************
 *
 */
function f_InsereLogDiaria ($Pessoa, $Diaria, $Descricao)
{
    $Time = date("H:i:s");
    $Date = date("Y-m-d");
    $sql = "INSERT INTO diaria.diaria_log (diaria_id, pessoa_id, diaria_log_dt, diaria_log_hr, diaria_log_ds) VALUES (".$Diaria.",".$Pessoa.",'".$Date."','".$Time."','".$Descricao."')";
    pg_query(abreConexao(),$sql);
}

/*
**************************************************
função para inserir log passagem
**************************************************
 *
 */
function f_InsereLogPassagem ($Pessoa, $Diaria, $Descricao)
{
	$Time = date("H:i:s");
	$Date = date("Y-m-d");
	$sql = "INSERT INTO passagens.passagem_log (passagem_id, pessoa_id, passagem_log_dt, passagem_log_hr, passagem_log_ds) VALUES
	(".$Diaria.",".$Pessoa.",'".$Date."','".$Time."','".$Descricao."')";
	pg_query(abreConexao(),$sql);
}


/*************************************************
função para inserir log
**************************************************/

function f_InsereLog($Descricao)
{
    $Time=date("H:i:s");
    $Date=date("Y-m-d");
    $sql = "INSERT INTO dados_unico.log_evento (pessoa_id, log_evento_dt, log_evento_hr, log_evento_ds) VALUES (".$_SESSION['UsuarioCodigo'].",'".$Date."','".$Time."','".$Descricao."')";
    pg_query(abreConexao(),$sql);
}

/*************************************************
função para formata data no padrao DD/MM/AAAA
**************************************************/

function f_FormataTime($Data)
{
	$hora = substr($Data,11,2);
	$minuto = substr($Data,14,2);

	If (strlen($hora)== 1)
    	{	$hora = "0".$hora;
    }
    If (strlen($minuto)== 1)
    	{ $minuto = "0".$minuto;
    }

	return $hora.":".$minuto;
}

function f_FormataData($Data)
{
   if ($Data)
   {
   $dia = substr($Data,8,2);
   $mes = substr($Data,5,2);
   $ano = substr($Data,0,4);
    if(strlen($dia)==1)
	{ $dia = "0". $dia;
    }
	if (strlen($mes)==1)
	{	$mes = "0" . $mes;
    }
    return $dia."/".$mes."/".$ano;
	}
}

function f_FormataDataTimeStamp($Data)
{
   if ($Data != '')
   {
       $Dt_formatada = f_FormataData($Data);
       $DataTime = substr($Data, 11, 5);
       return $Dt_formatada." às ".$DataTime;
   }
}
function f_FormataDataTime($Data)
{
   if ($Data != '')
   {
       $Dt_formatada = f_FormataData($Data);
       $DataTime = substr($Data, 11, 5);
       return $Dt_formatada." ".$DataTime;
   }
}
/*******************************************************************************
                    Função para carregar os PAÍSES
*******************************************************************************/
function f_ComboPais($NomeCombo,$codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{
  /*****************************************************************************
  * $NomeCombo = é o NOME do combo que será passado para a função.
  * $codigoEscolhido = é o CÓDIGO do município que está sendo passado.
  * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
  * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
  * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
  * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
  *****************************************************************************/
    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

    $sql = "SELECT pais_id, pais_nm
                FROM dados_unico.pais
                WHERE pais_st = 0
                ORDER BY pais_nm";
    $rs=pg_query(abreConexao(),$sql);

    $String = RetornarQtdeTracos ($QtdTracos);
    echo "<option value=0>[ ".$String." Selecione ".$String." ]</option>";

    while ($linha=pg_fetch_assoc($rs))
    {
        $codigo = $linha['pais_id'];
	$descricao = $linha['pais_nm'];
        if (strval($codigoEscolhido) == strval($codigo))
	{
            echo "<option value=" .$codigo.  " selected>"  .$descricao.  "</option>";
        }
        else if ($descricao == 'BRASIL')
        {
            echo "<option value=" .$codigo.  " selected>"  .$descricao.  "</option>";
        }
        else
        {
            echo "<option value=" .$codigo. ">" .$descricao. "</option>";
        }
    }
    return "</select>";
}
/*******************************************************************************
                    Função para retornar o nome da pessoa.
*******************************************************************************/
function f_NomePessoa($codigoPessoa)
{
    if ($codigoPessoa != '')
    {
        $sql = "SELECT p.pessoa_nm FROM dados_unico.pessoa p WHERE p.pessoa_id = ".$codigoPessoa;
        $rs = pg_query(abreConexao(),$sql);
        $linhars=pg_fetch_assoc($rs);

        If($linhars)
        {
          return $linhars['pessoa_nm'];
        }
    }
    else
    {
        return '';
    }
}

function f_CpfPessoa($codigoPessoa)
{
    if ($codigoPessoa != '')
    {
        $sql = "SELECT pessoa_fisica_cpf FROM dados_unico.pessoa_fisica WHERE pessoa_id = ".$codigoPessoa;
        $rs = pg_query(abreConexao(),$sql);
        $linhars=pg_fetch_assoc($rs);

        If($linhars)
        {
          return $linhars['pessoa_fisica_cpf'];
        }
    }
    else
    {
        return '';
    }
}

function f_CnpjPessoa($codigoPessoa)
{
    if ($codigoPessoa != '')
    {
        $sql = "SELECT pessoa_juridica_cnpj FROM dados_unico.pessoa_juridica WHERE pessoa_id = ".$codigoPessoa;
        $rs = pg_query(abreConexao(),$sql);
        $linhars=pg_fetch_assoc($rs);

        If($linhars)
        {
          return $linhars['pessoa_juridica_cnpj'];
        }
    }
    else
    {
        return '';
    }
}
function f_TelefonePessoa($codigoPessoa)
{
    if ($codigoPessoa != '')
    {
        $sql = "SELECT telefone_ddd, telefone_num FROM dados_unico.telefone WHERE pessoa_id = ".$codigoPessoa." AND telefone_tipo = 'C'";
        $rs = pg_query(abreConexao(),$sql);
        $linhars = pg_fetch_assoc($rs);
        $telefone = '';

        if ($linhars)
        {
            if (trim($linhars['telefone_num']) != '')
            {
                if (trim($linhars['telefone_ddd']) != '')
                {
                    $telefone = '('.$linhars['telefone_ddd'].') '.$linhars['telefone_num'];
                }
                else
                {
                    $telefone = $linhars['telefone_num'];
                }

                return $telefone;
            }
        }
    }
}
function f_TelefoneCelular($codigoPessoa)
{
    if ($codigoPessoa != '')
    {
        $sql = "SELECT telefone_ddd, telefone_num FROM dados_unico.telefone WHERE pessoa_id = ".$codigoPessoa." AND telefone_tipo = 'M'";
        $rs = pg_query(abreConexao(),$sql);
        $linhars = pg_fetch_assoc($rs);
        $telefone = '';

        if ($linhars)
        {
            if (trim($linhars['telefone_num']) != '')
            {
                if (trim($linhars['telefone_ddd']) != '')
                {
                    $telefone = '('.$linhars['telefone_ddd'].') '.$linhars['telefone_num'];
                }
                else
                {
                    $telefone = $linhars['telefone_num'];
                }

                return $telefone;
            }
        }
    }
}
function f_NomePessoaJuridica($codigoPessoa)
{
	$sql = "SELECT p.pessoa_juridica_nm_fantasia FROM dados_unico.pessoa_juridica p WHERE p.pessoa_id = ".$codigoPessoa;
    $rs = pg_query(abreConexao(),$sql);
    $linhars=pg_fetch_assoc($rs);

    If($linhars)
    {
      return $linhars['pessoa_nm'];
    }
}
function f_MatriculaPessoa($codigoPessoa)
{
	$sql = "SELECT f.funcionario_matricula FROM dados_unico.funcionario f WHERE f.pessoa_id = ".$codigoPessoa;
    $rs = pg_query(abreConexao(),$sql);
    $linhars=pg_fetch_assoc($rs);

    If($linhars)
    {
      return $linhars['funcionario_matricula'];
    }
}

/*
**************************************************
funÃ§Ã£o para carregar os estados
**************************************************
 *
 */
function f_ComboEstado($NomeCombo,$FuncaoJavaScript,$codigoEscolhido)
{
   echo "<select id=".$NomeCombo." name=".$NomeCombo." style=width:45px ".$FuncaoJavaScript.">";
   $sql = "SELECT estado_uf FROM dados_unico.estado";

   $rs=pg_query(abreConexao(),$sql);
   while ($linha=pg_fetch_assoc($rs))
   {  $descricao = $linha['estado_uf'];
      if($codigoEscolhido == $descricao)
	  {  echo "<option value=" .$descricao. " selected>" .$descricao. "</option>";
      }
	  else
	  { echo"<option value=" .$descricao. ">" .$descricao. "</option>";
      }
   }
   return "</select>";
}
/*******************************************************************************
                    Função para carregar os municipios
*******************************************************************************/
function f_ComboMunicipio($NomeCombo,$EstadoFuncao, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{
  /*****************************************************************************
  * $NomeCombo = é o NOME do combo que será passado para a função.
  * $EstadoFuncao = é a sigla do ESTADO que está sendo passada.
  * $codigoEscolhido = é o CÓDIGO do município que está sendo passado.
  * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
  * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
  * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
  * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
  *****************************************************************************/

    if(trim($EstadoFuncao) == "")
    {
        $EstadoFuncao = "BA";
    }
    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

    $sql = "SELECT municipio_cd, municipio_ds, municipio_capital
                FROM dados_unico.municipio
                WHERE estado_uf = '". $EstadoFuncao."' ORDER BY municipio_ds";
    $rs=pg_query(abreConexao(),$sql);

    $String = RetornarQtdeTracos ($QtdTracos);
    echo "<option value=0>[ ".$String." Selecione ".$String." ]</option>";

    while ($linha=pg_fetch_assoc($rs))
    {
        $codigo = $linha['municipio_cd'];
	$descricao = $linha['municipio_ds'];
	$capital = $linha['municipio_capital'];
        if (strval($codigoEscolhido) == strval($codigo))
	{
            echo "<option value=" .$codigo.  " selected>"  .$descricao.  "</option>";
        }
        else
        {
            if (((int)$capital == 1) && ($codigoEscolhido == ""))
            {
                echo "<option value=" .$codigo." selected>" .$descricao. "</option>";
            }
            Else
            {
                echo "<option value=" .$codigo. ">" .$descricao. "</option>";
            }
        }
    }
    return "</select>";
}
/*******************************************************************************
                    Função para carregar os municipios
*******************************************************************************/
function f_ComboTipoFeriado($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{
  /*****************************************************************************
  * $NomeCombo = é o NOME do combo que será passado para a função.
  * $codigoEscolhido = é o CÓDIGO do município que está sendo passado.
  * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
  * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
  * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
  * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
  *****************************************************************************/

    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript." title='Tipo do Feriado.'>";

    $sqlConsultaFeriado = "SELECT *
                                FROM dados_unico.tipo_feriado
                                WHERE tipo_feriado_st = 0
                                ORDER BY tipo_feriado_ds ASC, tipo_feriado_id ASC";
    $rsConsultaFeriado=pg_query(abreConexao(),$sqlConsultaFeriado);

    $String = RetornarQtdeTracos ($QtdTracos);
    echo "<option value=0>[ ".$String." Selecione ".$String." ]</option>";

    while ($linhaConsultaFeriado = pg_fetch_assoc($rsConsultaFeriado))
    {
        $codigo    = $linhaConsultaFeriado['tipo_feriado_id'];
	$descricao = $linhaConsultaFeriado['tipo_feriado_ds'];
        if (strval($codigoEscolhido) == strval($codigo))
	{
            echo "<option value=".$codigo." selected>".$descricao."</option>";
        }
        else
        {
            echo "<option value=".$codigo.">".$descricao."</option>";
        }
    }
    return "</select>";
}
/*******************************************************************************
                    Função para carregar os niveis escolares
*******************************************************************************/
function f_ComboNivelEscolar($codigoEscolhido)
{
    echo "<select id=cmbNivelEscolar name=cmbNivelEscolar style=width:120px>";
    $sql = "SELECT * FROM dados_unico.nivel_escolar WHERE nivel_escolar_st = 0 AND nivel_escolar_id <> 0 ORDER BY nivel_escolar_ds";
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value=0>[------ Selecione ------]</option>";
    while ($linha=pg_fetch_assoc($rs))
    {
        $codigo = $linha['nivel_escolar_id'];
        $descricao = $linha['nivel_escolar_ds'];
        if (((int)$codigoEscolhido) == ((int)$codigo))
        {
            echo "<option value=" .$codigo. " selected>" .$descricao. "</option>";
        }
        else
        {
            echo "<option value=" .$codigo. ">"  .substr($descricao,0,47). "</option>";
        }
    }
    echo "</select>";
}
/*
**************************************************

**************************************************
funÃ§Ã£o para carregar os estados civis
**************************************************
 *
 */
function f_ComboEstadoCivil($codigoEscolhido)
{  echo "<select name=cmbEstadoCivil style=width:120px>";
   $sql = "SELECT * FROM dados_unico.estado_civil WHERE estado_civil_st = 0 AND estado_civil_id <> 0 ORDER BY estado_civil_ds";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[------ Selecione ------]</option>";
   while ($linha=pg_fetch_assoc($rs))
   {  $codigo=$linha['estado_civil_id'];
	  $descricao=$linha['estado_civil_ds'];
	  if ((int)$codigoEscolhido== (int)$codigo)
      {  echo "<option value=" .$codigo. " selected>" .$descricao. "</option>";
      }
      else
	  {  echo "<option value=".$codigo. ">" .substr($descricao,0,47). "</option>";
      }
    }
	echo"</select>";
}
/*
**************************************************

**************************************************
funÃ§Ã£o para carregar os tipos de funcionÃ¡rios
**************************************************
 *
 */
function f_ComboTipoFuncionario($codigoEscolhido, $FuncaoJavaScript)
{ echo "<select name=cmbFuncionarioTipo ".$FuncaoJavaScript." style=width:140px>";
  $sql = "SELECT * FROM dados_unico.funcionario_tipo ORDER BY funcionario_tipo_ds";
  //WHERE funcionario_tipo_terceirizado = 0
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=0>[--------- Selecione ---------]</option>";
  while ($linha=pg_fetch_assoc($rs))
  { $codigo = $linha['funcionario_tipo_id'];
	$descricao = $linha['funcionario_tipo_ds'];
    if ((int)$codigoEscolhido==(int)$codigo)
      {  echo "<option value=" .$codigo. " selected>" .$descricao. "</option>";
      }
      else
	  {  echo "<option value=".$codigo. ">" .substr($descricao,0,47). "</option>";
      }
   }
   echo"</select>";
}
/*
**************************************************

**************************************************
funÃ§Ã£o para carregar ministerios da defesa
**************************************************
 *
 */
function f_ComboMinisterio($codigoEscolhido)
{
$codigoEscolhido = rtrim($codigoEscolhido);

$MinisterioAero 	= "";
$MinisterioExer  	= "";
$MinisterioMari		= "";

if($codigoEscolhido != "")
  { switch (strtolower($codigoEscolhido))
    {
    case "aeronautica":
      $MinisterioAero = " selected ";
        break;
    case "exercito":
      $MinisterioExer = " selected ";
        break;
    case "marinha":
      $MinisterioMari = " selected ";
        break;
    }
  }
  echo "<select name=cmbMinisterio style=width:120px>";
  echo "<option value=0>[------ Selecione ------]</option>";
  echo "<option value=Aeronautica ".$MinisterioAero. ">Aeron&aacute;utica</option>";
  echo "<option value=Exercito ".$MinisterioExer.">Ex&eacute;rcito</option>";
  echo "<option value=Marinha ".$MinisterioMari.">Marinha</option>";
  echo "</select>";

}
/*
**************************************************

**************************************************
funÃ§Ã£o para carregar estrutura organizacional sigla
**************************************************
 *
 */
function f_ComboEstruturaOrganizacionalSigla()
{  echo "<select name=cmbEstOrganizacional style=width:200px>";
   $sql = "SELECT * FROM dados_unico.est_organizacional WHERE est_organizacional_st = 0 ORDER BY est_organizacional_sigla";
   $rs=pg_query(abreConexao(),$sql);
   echo"<option value=0>[------------------- Selecione -------------------]</option>";
   While ($linha=pg_fetch_assoc($rs))
   { $codigo = $linha['est_organizacional_id'];
	 $descricao = $linha['est_organizacional_sigla'];
	 echo "<option value=" .$codigo.">" .$descricao."</option>";
    }
	echo"</select>";

}
/*******************************************************************************
                CARREGA AS ESTRUTURAS ORGANIZACIONAIS CADASTRADAS
*******************************************************************************/
function f_ComboEstruturaOrganizacional($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{
  /*****************************************************************************
  * $NomeCombo = é o NOME do combo que será passado para a função.
  * $codigoEscolhido = é o CÓDIGO do município que está sendo passado.
  * $FuncaoJavaScript = é a função JAVASCRIPT que é passado para o combo.
  * $Acao = serve para desabilitar o combo para o mesmo não ser alterado.
  * $Tamanho = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
  * $QtdTracos = é a quantidade de traços entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
  *****************************************************************************/

    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

    $sql = "SELECT *
                FROM dados_unico.est_organizacional
                WHERE est_organizacional_st = 0
                ORDER BY est_organizacional_sigla";
    $rs=pg_query(abreConexao(),$sql);

    $String = RetornarQtdeTracos ($QtdTracos);
    echo "<option value=0>[ ".$String." Selecione ".$String." ]</option>";

    While ($linha=pg_fetch_assoc($rs))
    {
         if ($codigoEscolhido==$linha['est_organizacional_id'])
        {
            echo "<option value=" .$linha['est_organizacional_id']. " selected>".$linha['est_organizacional_sigla']. "</option>";
        }
        else
        {
            echo"<option value=" .$linha['est_organizacional_id']. ">".$linha['est_organizacional_sigla']. "</option>";
        }
    }
    echo "</select>";
}
/**************************************************
 * carrega as guias de recolhimento estadual (GER)
 */

function f_ComboGer($NomeCombo, $codigoEscolhido)
{
   echo"<select name=".$NomeCombo." style=width:200px>";
   $sql = "SELECT*FROM diaria.ger WHERE status = 0 AND
   ger_id <> 0 ORDER BY ger_id, ger_nm_conta";
   $rs=pg_query(abreConexao(),$sql);
   echo "<option value=0>[------------------- Selecione -------------------]</option>";
   While ($linha=pg_fetch_assoc($rs))
   { if ($codigoEscolhido != "")
     {  if((int)$codigoEscolhido == (int)($linha['ger_id']))
        { echo "<option value=".$linha['ger_id']. " selected>".$linha['ger_nm_conta']."</option>";
        }
		else
		{ echo "<option value=".$linha['ger_id'].">".$linha['ger_nm_conta']."</option>";
        }
     }
	 else
	 {  echo "<option value=".$linha['ger_id'].">".$linha['ger_nm_conta']."</option>";
     }
   }
  echo "</select>";
}
/*
**************************************************
funÃ§Ã£o para carregar bancos (unidades financeiras)
**************************************************
 * //Carrega combo de bancos
 */
Function f_ComboBanco($codigoEscolhido)
{ echo "<select name=cmbBanco style=width:190px>";
  $sql = "SELECT * FROM dados_unico.banco WHERE banco_st = 0 AND banco_id <> 0 ORDER BY UPPER(banco_ds)";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=0>[------------------ Selecione ------------------]</option>";
  While ($linha=pg_fetch_assoc($rs))
  { $codigo = $linha ['banco_id'];
    $descricao= $linha ['banco_ds'];
	if((int)$codigoEscolhido==(int)$codigo)
	{ echo "<option value=" .$codigo." selected>".$descricao."</option>";
    }
    else
    { echo "<option value=".$codigo. ">".$descricao."</option>";
    }
  }
  echo "</select>";
}

/*
**************************************************

**************************************************
funÃ§Ã£o para carregar tipos de conta
**************************************************
 *
 */
function f_ComboTipoConta($codigoEscolhido)
{
   switch ($codigoEscolhido)
    {
    case "C":
      $ContaCorrente = "selected";
        break;
    case "P":
        $ContaPoupanca = "selected";
        break;
    }
    echo "<select name=cmbTipoConta style=width:115px>";
	echo "<option value=C ".$ContaCorrente. ">Conta Corrente</option>";
	echo "<option value=P ".$ContaPoupanca. ">Conta Poupan&ccedil;a</option>";
	echo "</select>";

}
/*
'**************************************************
'carrega os orgaos do estado da bahia
 *
 */
function f_ComboOrgao($NomeCombo, $codigoEscolhido,$tamanho)
{
    //CONSULTA OS ORGÃOS
    $sql = "SELECT orgao_id,orgao_ds FROM dados_unico.orgao WHERE orgao_st = 0 AND orgao_id <> 0 ORDER BY UPPER(orgao_ds)";
    //RESULTADO DA CONSULTA
    $rs=pg_query(abreConexao(),$sql);

    echo "<select  name='" .$NomeCombo."' style=width:".$tamanho.">";
    //VERIFICA O TAMANHO EM PIXELS PARA IMPRESSÃO CORRETA DA OPÇÃO "SELECIONE"
    if ($tamanho <= 200){$constante = 16;} //TESTADO
    elseif ($tamanho <= 300){$constante = 17;}
    elseif ($tamanho <= 400){$constante = 20;}
    elseif ($tamanho <= 500){$constante = 27;} //TESTADO
    elseif ($tamanho <= 600){$constante = 37;}
    elseif ($tamanho <= 700){$constante = 47;}
    elseif ($tamanho <= 800){$constante = 57;}

    $AuxTamanho = (($constante*$tamanho)/200);

    echo "<option value=0>[";
    for ($i = 1; $i <= ($AuxTamanho); $i++){echo "-";}
    echo " Selecione ";
    for ($i = 1; $i <= ($AuxTamanho); $i++){echo "-";}
    echo "]</option>";

    While ($linha=pg_fetch_assoc($rs))
    {
        if($codigoEscolhido != "")
        {
            if ((int)$codigoEscolhido == (int)($linha ['orgao_id']))
            {
                echo "<option value=" .$linha ['orgao_id']. " selected>" .$linha ['orgao_ds']."</option>";
            }
            else
            {
                echo "<option value=" .$linha ['orgao_id'].">" .$linha ['orgao_ds']. "</option>";
            }
        }
        else
        {
            echo "<option value=" .$linha ['orgao_id']. ">" .$linha ['orgao_ds']. "</option>";
        }
    }
    echo  "</select>";
}

/*

'**************************************************
'funÃ§Ã£o para carregar grupo sanguineo
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
    echo "<select name=cmbGrupoSanguineo style=width:120px>";
	echo "<option value=0>[------ Selecione ------]</option>";
	echo "<option value=A+ ".$SangueAP. ">Tipo A+</option>";
	echo "<option value=A- " .$SangueAN. ">Tipo A-</option>";
	echo "<option value=AB+ " .$SangueABP. ">Tipo AB+</option>";
	echo "<option value=AB- " .$SangueABN.">Tipo AB-</option>";
	echo "<option value=B+ " .$SangueBP.">Tipo B+</option>";
	echo"<option value=B- " .$SangueBN. ">Tipo B-</option>";
	echo "<option value=O+ " .$SangueOP. ">Tipo O+</option>";
	echo"<option value=O- " .$SangueON. ">Tipo O-</option>";
	echo"</select>";

}
/*
'**************************************************

'**************************************************
'função para carregar Órgãos do governo do estado
'**************************************************
 *
 */

Function f_ComboFuncionarioTipo($codigoEscolhido)
{ echo "<select name=cmbFuncionarioTipo style=width:110px>";
  $sql = "SELECT * FROM dados_unico.funcionario_tipo ORDER BY funcionario_tipo_ds";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=0>[---- Selecione ----]</option>";
  While ($linha=pg_fetch_assoc($rs))
  { $codigo = $linha ['funcionario_tipo_id'];
    $descricao= $linha ['funcionario_tipo_ds'];
	if((int)$codigoEscolhido==(int)$codigo)
	{ echo "<option value=" .$codigo." selected>".$descricao."</option>";
    }
    else
    { echo "<option value=".$codigo. ">".$descricao."</option>";
    }
  }
  echo "</select>";
}

Function f_ComboEstOrgSigla($codigoEscolhido)
{ echo "<select name=cmbEstOrgSigla style=width:190px>";
  $sql = "SELECT est_organizacional_id, est_organizacional_sigla FROM dados_unico.est_organizacional ORDER BY est_organizacional_sigla";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=0>[------------------ Selecione -----------------]</option>";
  While ($linha=pg_fetch_assoc($rs))
  { $codigo = $linha ['est_organizacional_id'];
    $descricao= $linha ['est_organizacional_sigla'];
	if((int)$codigoEscolhido==(int)$codigo)
	{ echo "<option value=" .$codigo." selected>".$descricao."</option>";
    }
    else
    { echo "<option value=".$codigo. ">".$descricao."</option>";
    }
  }
  echo "</select>";
}


Function f_ConsultaEstadoCivil($codigoEscolhido)
{
    if ($codigoEscolhido !="")
    {
        $sql = "SELECT estado_civil_ds FROM dados_unico.estado_civil WHERE estado_civil_id = '" .$codigoEscolhido."'";
        $rs=pg_query(abreConexao(),$sql);
        $linha=pg_fetch_assoc($rs);
        echo $linha['estado_civil_ds'];
    }
}
/*
'**************************************************

'**************************************************
'funÃ§Ã£o para carregar Ã³rgÃ£os do governo do estado
'**************************************************
 *
 */
function f_ConsultaNivelEscolar($codigoEscolhido)
{
    if ($codigoEscolhido !="")
    {
        $sql = "SELECT nivel_escolar_ds FROM dados_unico.nivel_escolar WHERE nivel_escolar_id = '".$codigoEscolhido."'";
        $rs=pg_query(abreConexao(),$sql);
        $linha=pg_fetch_assoc($rs);
        echo $linha['nivel_escolar_ds'];
    }
}
/*
**************************************************

**************************************************
funÃ§Ã£o para carregar Ã³rgÃ£os do governo do estado
**************************************************
 *
 */
function f_ConsultaMunicipio($codigoEscolhido)
{
 	if ($codigoEscolhido != "")
		{
			$sql = "SELECT municipio_ds FROM dados_unico.municipio WHERE municipio_cd = '" .$codigoEscolhido."'";
    		$rs=pg_query(abreConexao(),$sql);

    		if($rs)
    		{
   				$linha=pg_fetch_assoc($rs);
   				echo $linha['municipio_ds'];
    		}
		}
}
function f_ConsultaEstado($codigoEscolhido)
{  $sql = "SELECT estado_uf FROM dados_unico.estado WHERE estado_uf = '" .$codigoEscolhido."'";
   $rs=pg_query(abreConexao(),$sql);
   $linha=pg_fetch_assoc($rs);
   print $linha['estado_uf'];

}

/*
**************************************************

**************************************************
funÃ§Ã£o para carregar Ã³rgÃ£os do governo do estado
**************************************************
 *
 */
function f_ConsultaTipoFuncionario($codigoEscolhido)
{
    if ($codigoEscolhido !="")
    {
        $sql = "SELECT funcionario_tipo_ds FROM dados_unico.funcionario_tipo WHERE funcionario_tipo_id = '".$codigoEscolhido."'";
        $rs = pg_query(abreConexao(),$sql);
        $linha = pg_fetch_assoc($rs);
        echo $linha['funcionario_tipo_ds'];
    }
}
/*
**************************************************

**************************************************
funÃ§Ã£o para carregar Ã³rgÃ£os do governo do estado
**************************************************
 *
 */
function f_ConsultaOrgao($codigoEscolhido)
{
  if ($codigoEscolhido !="")
  {
    $sql = "SELECT orgao_ds FROM dados_unico.orgao WHERE orgao_id = '".$codigoEscolhido."'";
    $rs=pg_query(abreConexao(),$sql);
    $linha=pg_fetch_assoc($rs);
    echo $linha['orgao_ds'];
  }
}
function f_BuscaOrgao($codigoEscolhido)
{
    if ($codigoEscolhido !="")
    {
        $sql = "SELECT orgao_ds FROM dados_unico.orgao WHERE orgao_id = '".$codigoEscolhido."'";
        $rs=pg_query(abreConexao(),$sql);
        $linha=pg_fetch_assoc($rs);
        return $linha['orgao_ds'];
    }
}
/*
 **************************************************

'**************************************************
'funÃ§Ã£o para carregar Ã³rgÃ£os do governo do estado
'**************************************************
 *
 */
function f_ConsultaEstruturaOrganizacional($codigoEscolhido)
{
    if($codigoEscolhido!= "")
    {
        $sql = "SELECT est_organizacional_ds FROM dados_unico.est_organizacional WHERE est_organizacional_id = '".$codigoEscolhido."'";
        $rs=pg_query(abreConexao(),$sql);
        $linha=pg_fetch_assoc($rs);
        return $linha['est_organizacional_ds'];
    }
}

function f_ConsultaEstruturaOrganizacionalLotacao($codigoEscolhido)
{ if ($codigoEscolhido != "")
  { $sql = "SELECT est_organizacional_lotacao_ds FROM dados_unico.est_organizacional_lotacao WHERE est_organizacional_lotacao_id = '".$codigoEscolhido."'";
	$rs=pg_query(abreConexao(),$sql);
     $linha=pg_fetch_assoc($rs);
     echo $linha['est_organizacional_lotacao_ds'];
  }
}

/*
'**************************************************
'funÃ§Ã£o para carregar Ã³rgÃ£os do governo do estado
'**************************************************
 */
function f_ConsultaEstruturaOrganizacionalSigla($codigoEscolhido)
{
    if ($codigoEscolhido != "")
    {
        $sql = "SELECT est_organizacional_sigla FROM dados_unico.est_organizacional WHERE est_organizacional_id = '".$codigoEscolhido."'";
        $rs=pg_query(abreConexao(),$sql);
        $linha=pg_fetch_assoc($rs);
        return $linha['est_organizacional_sigla'];
    }
}

function f_PossuiFeriado($Inicio, $Fim)
{  $DataAcrescida = $Inicio;
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

     $sqlConsultaFeriado = "SELECT feriado_id FROM dados_unico.feriado WHERE to_date(feriado_dt, 'DD/MM/YYYY') = to_date('".$DataAcrescida."','DD/MM/YYYY') ";

     $rsConsultaFeriado=pg_query(abreConexao(),$sqlConsultaFeriado);
     $linha=pg_fetch_array($rsConsultaFeriado);
     // se encontrar um resultado retorna true
     if($linha>0)
     {  return true;
     }
     // acrescenta-se mais um dia
     if($DiaAcrescido<$ultimoDiaDoMesAcrescido)
     {  $vetData[0]=$vetData[0]+1;
        $DiaAcrescido=$vetData[0];
     }
     // se o dia atingiu o ultimo dia do mÃªs muda-se para o proximo mes
     else
     { $vetData[1]=$vetData[1]+1;
        $MesAcrescido=$vetData[1];
        $DiaAcrescido="01";
        $ultimoDiaDoMesAcrescido = cal_days_in_month(CAL_GREGORIAN, $MesAcrescido, $AnoAcrescido);
     }
     // se o dia atingiu o ultimo dia do mÃªs muda-se para o proximo mes e for o ultimo mes do ano muda-se o ano
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
{

  //retira a barra '/' da data e retorna um array
  $vetDataAcr=explode("/", $Inicio);

  // depois inclui a barra '-' pois o strotime sÃƒÂ³ trabalha com data no formato americano
  $DataAcrescida=implode("-", array($vetDataAcr[0], $vetDataAcr[1], $vetDataAcr[2]));

  $vetDataF=explode("/", $Fim);
  $DataFim=implode("-", array($vetDataF[0],$vetDataF[1],$vetDataF[2]));

  $timestampDataAcrescida = strtotime($DataAcrescida);
  $timestampFim = strtotime($Fim);
  // compara o timeStamp

  //pega o ultimo dia do mes da data acrescida e o ultimo dia do anoAcrescido
  $ultimoDiaDoMesAcrescido = cal_days_in_month(CAL_GREGORIAN, $vetDataAcr[1], $vetDataAcr[2]);
  $ultimoDiaDoAno=cal_days_in_month(CAL_GREGORIAN, 12, $vetDataAcr[2]);

  while ( $timestampDataAcrescida <$timestampFim)
  { $vetDataAcr = explode("-", $DataAcrescida);
    $DiaAcrescido = $vetData[0];
	$MesAcrescido = $vetData[1];
	$AnoAcrescido = $vetData[2];
    $ultimo = mktime(0, 0, 0, $MesAcrescido, $DiaAcrescido, $AnoAcrescido);
    $dia_semana = date("w", $ultimo);
    if (($dia_semana== 0) || ($dia_semana== 6))
    { return true;
    }
     // acrescenta-se mais um dia
     if($DiaAcrescido<$ultimoDiaDoMesAcrescido)
     {  $vetData[0]=$vetData[0]+1;
        $DiaAcrescido=$vetData[0];
     }
     // se o dia atingiu o ultimo dia do mes muda-se para o proximo mes
     else
     { $vetData[1]=$vetData[1]+1;
        $MesAcrescido=$vetData[1];
        $DiaAcrescido="01";
        $ultimoDiaDoMesAcrescido = cal_days_in_month(CAL_GREGORIAN, $MesAcrescido, $AnoAcrescido);
     }
     // se o dia atingiu o ultimo dia do mes muda-se para o proximo mes e for o ultimo mes do ano muda-se o ano
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
function diasemana($data)
{
    $ano =  substr($data, 6, 4);
    $mes =  substr($data, 3, 2);
    $dia =  substr($data, 0, 2);
    $diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano));

    switch($diasemana)
    {
            case"0": $diasemana = "Domingo";       break;
            case"1": $diasemana = "Segunda-Feira"; break;
            case"2": $diasemana = "Terça-Feira";   break;
            case"3": $diasemana = "Quarta-Feira";  break;
            case"4": $diasemana = "Quinta-Feira";  break;
            case"5": $diasemana = "Sexta-Feira";   break;
            case"6": $diasemana = "Sábado";        break;
    }

    return  $diasemana;
}

function f_GeraSenha ()
{
    $CaracteresAceitos = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $max = strlen($CaracteresAceitos)-1;
    $password = null;
    for($i=0; $i < 8; $i++)
    {
       $password.= $CaracteresAceitos{mt_rand(0, $max)};
    }
    $sql = "SELECT
                p.pessoa_id,
                p.pessoa_nm,
                u.usuario_login,
                u.usuario_senha
            FROM
                dados_unico.pessoa p
                JOIN seguranca.usuario u ON (p.pessoa_id = u.pessoa_id)
                LEFT JOIN dados_unico.funcionario f ON (p.pessoa_id = f.pessoa_id)
            WHERE
                usuario_login = '" .$_POST['txtLogin']."'";
    $rs = pg_query(abreConexao(),$sql);
    $linhars=pg_fetch_assoc($rs);

    //$sqlUpdate = "UPDATE seguranca.usuario SET usuario_senha ='".sha1($password)."' , usuario_primeiro_logon = '1' WHERE pessoa_id = ".$linhars['pessoa_id'];
	$sqlUpdate = "UPDATE seguranca.usuario SET usuario_senha ='".md5($password)."' , usuario_primeiro_logon = '1' WHERE pessoa_id = ".$linhars['pessoa_id'];
    pg_query(abreConexao(),$sqlUpdate); // NÃ£o dar o comando STRTOUPPER, pois essa string Ã© um HASH

return $password;
}



function f_ComboEstruturaOrganizacionalLotacao($NomeCombo, $codigoEscolhido)
{  print"<select name=".$NomeCombo. " style=width:200px>";

   $sql = "SELECT * FROM dados_unico.est_organizacional_lotacao WHERE est_organizacional_lotacao_st = 0 AND est_organizacional_lotacao_id <> 0 ORDER BY est_organizacional_lotacao_sigla";

   $rs=pg_query(abreConexao(),$sql);

   print "<option value=0>[------------------- Selecione -------------------]</option>";

   while ($linha=pg_fetch_assoc($rs))
   {
   	if (codigoEscolhido != "")
     {
	 	if((int)$codigoEscolhido == (int)($linha['est_organizacional_lotacao_id']))
         {
			print "<option value=" .$linha['est_organizacional_lotacao_id']. " selected>".$linha['est_organizacional_lotacao_sigla']."</option>";
         }
		else
		 {
		 	print "<option value=" .$linha['est_organizacional_lotacao_id'].">".$linha['est_organizacional_lotacao_sigla']. "</option>";
         }
     }
	 else
	 {
	 	print "<option value=" .$linha['est_organizacional_lotacao_id'].  ">".$linha['est_organizacional_lotacao_sigla'].  "</option>";
     }
   }
  print "</select>";
}

//FUNÇÃO QUE REALIZA TRATAMENTO PARA VARIAVEIS TRUNCADAS
function F_TruncarString($str, $maxChar)
{
    //CAPTURA A QUANTIDADE DE CARACTERES DA STRING ORIGINAL
    $str_len_original = strlen($str);

    //VERIFICA SE A QUANTIDADE DE CARACTERES DA STRING ORIGINAL É MAIOR QUE A TRUNCADA
    if($str_len_original > $maxChar)
    {
        //CRIA QUANTIDADE DE ESCAPE
        $escape = 3;

        //VERIFICA A QUANTIDADE DE CARACTERES ORIGINAIS E A QUANTIDADE MAXIMA PERMITIDA
        if ($maxChar + $escape < $str_len_original)
        {
            //TRUNCA A STRING
            $str_trunc = substr($str, 0, $maxChar);

            //INSERE TEXTO NO FINAL PARA IDENTIFICAR QUE O TEXTO ESTÁ TRUNCADO
            $str_trunc = $str_trunc.' ...';

            //RETORNA O TEXTO TRUNCADO
            return $str_trunc;
        }
        //SE ESTIVER DENTRO DO ESCAPE NÃO TRUNCA
        else
        {
            //RETORNA O TEXTO ORIGINAL
            return $str;
        }
    }
    //SE O TAMANHO DA STRING FOR MENOR QUE O TAMANHO A SER TRUNCADO RETORNA A PROPRIA STRING
    else
    {
        //RETORNA O TEXTO ORIGINAL
        return $str;
    }
}

//RETORNAR O SETOR DO FUNCIONARIO
function F_RetornaEstOrganizacionalDoFuncionario($funcionario_id)
{
    //QUERY PARA CAPTURAR O SETOR DO USUARIO
    $sqlConsulta = "
        Select
                EOF.est_organizacional_id
        FROM
                dados_unico.funcionario F,
                dados_unico.est_organizacional_funcionario EOF
        WHERE
                F.funcionario_id = EOF.funcionario_id AND
                est_organizacional_funcionario_st = 0 AND
                pessoa_id = ".$funcionario_id."";

    //REALIZANDO A CONSULTA
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

    //ASSOCIOA O DADO CONSULTADO
    $linha = pg_fetch_assoc($rsConsulta,$qtdIndice);

    //CAPTURA O SETOR DO USUARIO
    $Setor_Usuario = $linha['est_organizacional_id'];

    //RETORNA O SETOR
    return $Setor_Usuario;
}

//FUNÇÃO PARA ATRIBUR O NOME DO STATUS
function F_RetornaNomeStatusRegistro($StatusNumero)
{
    //ATRIBUINDO A DESCRIÇÃO DO STATUS
    if ($StatusNumero != '')
    {
        if ($StatusNumero == "0"){$StatusNome = "Ativo";}
        else if ($StatusNumero == "1"){$StatusNome = "Inativo";}
        else if ($StatusNumero == "2"){$StatusNome = "Excluido";}
    }
    else {$StatusNome = '';}

    //RETORNANDO O NOME DO STATUS
    return $StatusNome;
}

//FUNÇÃO PARA ATRIBUR O NOME DO STATUS
function F_RetornaNomeSituacaoDoDocumento($SituacaoNumero)
{
    //ATRIBUINDO A DESCRIÇÃO DO STATUS
    if ($SituacaoNumero != '')
    {
        if ($SituacaoNumero == "0"){$SituacaoNome = "Criado";}
        else if ($SituacaoNumero == "1"){$SituacaoNome = "Tramitado";}
        else if ($SituacaoNumero == "2"){$SituacaoNome = "Recebido";}
        else if ($SituacaoNumero == "3"){$SituacaoNome = "Arquivado";}
    }
    else {$SituacaoNome = '';}

    //RETORNANDO O NOME DO STATUS
    return $SituacaoNome;
}

//FUNÇÃO PARA ATRIBUR UM TITULO AO NOME DO STATUS
function F_RetornaTituloStatusRegistro($StatusNome)
{
    //TRTAMENTO PARA O TITULO DO STATUS
    if ($StatusNome == 'Ativo'){$StatusTitulo = 'Inativar';}
    else if ($StatusNome == 'Inativo'){$StatusTitulo = 'Ativar';}
    else if ($StatusNome == 'Excluido'){$StatusTitulo = 'Restaurar';}
    else {$title = '';}

    //RETORNANDO O NOME DO STATUS
    return $StatusTitulo;
}
//FUNÇÃO PARA VERIFICAR O ACESSO DO USUÁRIO
function F_VerificaAcessoUsuario($id)
{
    //NÃO TERMINADA.............................................................
    if ($id != '')
    {
        if (!in_array($id, $_SESSION['AcaoID']))
        {
            session_destroy();
            //RETORNA PARA A TELA DE LOGIN
            echo '<script type="text/javascript" language="javascript">window.location = "Login.php";</script>';
        }
    }
    else
    {
        $Pagina = explode ("/",$_SERVER['HTTP_REFERER']);
        $Pagina = $Pagina[count($Pagina)];
    }
}

/*******************************************************************************
        FUNÇÃO QUE RETORNA A QUANTIDADE DE TRAÇOS PARA OS COMBOS.
*******************************************************************************/
function RetornarQtdeTracos ($QtdTracos)
{//$QtdTracos é a quantidade de - que será exibido no combo.
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
/*******************************************************************************
  ESTA FUNÇÃO TRANSFORMA UM NUMERO PASSADO NO PADRÃO DA MOEDA BRASILEIRA, PODE
SER USADA COM OU SEM FRAÇÃO. LEMBRANDO QUE COMO A FUNÇÃO CONVERTE A FRAÇÃO PARA
  FLOAT O MESMO RETORNA AS CASAS DECIMAIS COM O PONTO (.) E NÃO COM A VÍRGULA
*******************************************************************************/
function f_FormatarDinheiro($number, $fractional=false)
{
    //echo formatMoney(1050); # 1,050
    //echo formatMoney(1321435.4, true); # 1,321,435.40
    //echo formatMoney(10059240.42941, true); # 10,059,240.43
    //echo formatMoney(13245); # 13,245
    if ($fractional)
    {
        $number = sprintf('%.2f', $number);
    }
    while (true)
    {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1.$2', $number);
        if ($replaced != $number)
        {
            $number = $replaced;
        }
        else
        {
            break;
        }
    }
    return $number;
}
/*******************************************************************************
  COMBO DE MÊSES DO ANO
*******************************************************************************/
function f_ComboMeses($NomeCombo, $CodigoRecebido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{
    /*
      $NomeCombo        = é o nome do combo que será passado para a função.
      $CodigoRecebido   = é o ID que será passado como filtro para o combo.
      $FuncaoJavaScript = é a função JAVASCRIPT que é passada para o combo.
      $Acao             = serve para desabilitar o combo para o mesmo não ser alterado.
      $Tamanho          = é o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
      $QtdTracos        = é a quantidade de traços passados para função RetornarQtdeTracos, que retornará a quantidade de traços entre o [ Selecione. Ex: $QtdTracos = 3 [ --- Selecione ---]
    */

    $tracos = RetornarQtdeTracos($QtdTracos);

    $meses = 12;
    $linha = 0;
    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";
    echo    "<option value=0>[ ".$tracos." Selecione ".$tracos." ]</option>";


    While ($linha < $meses)
    {
        $linha++;
        $codigo = $linha;

        if($linha==1){$descricao  = 'JANEIRO';}
        if($linha==2){$descricao  = 'FEVEREIRO';}
        if($linha==3){$descricao  = 'MARÇO';}
        if($linha==4){$descricao  = 'ABRIL';}
        if($linha==5){$descricao  = 'MAIO';}
        if($linha==6){$descricao  = 'JUNHO';}
        if($linha==7){$descricao  = 'JULHO';}
        if($linha==8){$descricao  = 'AGOSTO';}
        if($linha==9){$descricao  = 'SETEMBRO';}
        if($linha==10){$descricao  = 'OUTUBRO';}
        if($linha==11){$descricao  = 'NOVEMBRO';}
        if($linha==12){$descricao  = 'DEZEMBRO';}


        if((int)$CodigoRecebido == (int)$codigo)
        {
            echo "<option value= ".$codigo." selected>".$descricao."</option>";
        }
        else
        {
            echo "<option value= ".$codigo. ">".$descricao."</option>";
        }
    }

    echo "</select>";
}
/*******************************************************************************
   FUNÇÃO QUE GRAVA O LOG DE QUALQUER MODIFICAÇÃO NA TABELA PAIS GRUPO VALOR
*******************************************************************************/
function InsereLogPaisGrupoValor ($PaisGrupoID, $AcaoSistema)
{
    //OPÇÕES DAS AÇÕES DO SISTEMA
    if ($AcaoSistema == 'incluir')
    {
        $MensagemLog = "Registro foi incluído por: ".$_SESSION['UsuarioNome'];
    }
    elseif ($AcaoSistema == 'alterar')
    {
        $MensagemLog = "Registro foi modificado por: ".$_SESSION['UsuarioNome'];
    }
    elseif ($AcaoSistema == 'excluir')
    {
        $MensagemLog = "Registro foi excluído por: ".$_SESSION['UsuarioNome'];
    }
    elseif ($AcaoSistema == 'recuperar')
    {
        $MensagemLog = "Registro foi recuperado por: ".$_SESSION['UsuarioNome'];
    }

    $sqlInsereLog = "INSERT INTO diaria.pais_grupo_valor_log
                                    (pais_grupo_valor_id,
                                    pessoa_id,
                                    pais_grupo_valor_log_mensagem)
                            VALUES (".$PaisGrupoID.",
                                    ".$_SESSION['UsuarioCodigo'].",
                                    '".$MensagemLog."')";
    pg_query(abreConexao(),$sqlInsereLog);
}
/*******************************************************************************
          FUNÇÃO QUE IRÁ RETORNAR UMA STRING COM A DATA POR EXTENSO
*******************************************************************************/
function f_RetornaDataPorExtenso ($DataInicio, $DataFim, $Separador, $TipoDeData)
{
/*******************************************************************************
* $DataInicio = é a data início da string retornada.
* $DataFim = é a data final da string retornada.
* $Separador = é o caractere que será usado para o explode, pode ser - ou /
* $TipoDeData = é o tipo de data que está sendo utilizada, DATE = 'DB', CHARACTER = 'CH'
*******************************************************************************/

    $DataInicioTemp = explode($Separador, $DataInicio);
    $DataFimTemp = explode($Separador, $DataFim);

    if ($TipoDeData == 'DB')
    {
        //COMPARANDO OS MESES
        if ($DataInicioTemp[1] == $DataFimTemp[1])
        {
            switch ($DataInicioTemp[1])
            {
                case 1: $StringMes = "Janeiro"; break;
                case 2: $StringMes = "Fevereiro"; break;
                case 3: $StringMes = "Março"; break;
                case 4: $StringMes = "Abril"; break;
                case 5: $StringMes = "Maio"; break;
                case 6: $StringMes = "Junho"; break;
                case 7: $StringMes = "Julho"; break;
                case 8: $StringMes = "Agosto"; break;
                case 9: $StringMes = "Setembro"; break;
                case 10: $StringMes = "Outubro"; break;
                case 11: $StringMes = "Novembro"; break;
                case 12: $StringMes = "Dezembro"; break;
            }
        }

        $DataInicioAux = $DataInicioTemp[2];
        $StringDias = "";

        while ($DataInicioAux <= $DataFimTemp[2])
        {
            if ($StringDias == "")
            {
                $StringDias = $DataInicioTemp[2];
            }
            elseif ($DataInicioAux == $DataFimTemp[2])
            {
                $StringDias .= " e ".$DataInicioAux;
            }
            else
            {
                $StringDias .= ", ".$DataInicioAux;
            }
            $DataInicioAux++;
        }

        $retorno = $StringDias." de ".$StringMes. " de ".$DataInicioTemp[0];
    }
    else
    {
        //COMPARANDO OS MESES
        if ($DataInicioTemp[1] == $DataFimTemp[1])
        {
            switch ($DataInicioTemp[1])
            {
                case 1: $StringMes = "Janeiro"; break;
                case 2: $StringMes = "Fevereiro"; break;
                case 3: $StringMes = "Março"; break;
                case 4: $StringMes = "Abril"; break;
                case 5: $StringMes = "Maio"; break;
                case 6: $StringMes = "Junho"; break;
                case 7: $StringMes = "Julho"; break;
                case 8: $StringMes = "Agosto"; break;
                case 9: $StringMes = "Setembro"; break;
                case 10: $StringMes = "Outubro"; break;
                case 11: $StringMes = "Novembro"; break;
                case 12: $StringMes = "Dezembro"; break;
            }
        }

        $DataInicioAux = $DataInicioTemp[0];
        $StringDias = "";

        while ($DataInicioAux <= $DataFimTemp[0])
        {
            if ($StringDias == "")
            {
                $StringDias = $DataInicioTemp[0];
            }
            elseif ($DataInicioAux == $DataFimTemp[2])
            {
                $StringDias .= " e ".$DataInicioAux;
            }
            else
            {
                $StringDias .= ", ".$DataInicioAux;
            }
            $DataInicioAux++;
        }

        $retorno = $StringDias." de ".$StringMes. " de ".$DataInicioTemp[2];
    }

    return $retorno;
}
/*******************************************************************************
                    FUNÇÃO QUE PREVINE SQL INJECTION
*******************************************************************************/
function f_Anti_Injection($sql)
{
    // remove palavras que contenham sintaxe sql
    $sql = strtolower($sql);
    $sql = preg_replace("/(from|update|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i","",$sql);
    //limpa espaços vazio
    $sql = trim($sql);
    //tira tags html e php
    $sql = strip_tags($sql);

    $sql = addslashes($sql);

    return $sql;
}
/*******************************************************************************
            FUNÇÃO QUE CONVERTE A DATA DO PADRÃO BR PARA O US
*******************************************************************************/
function ConverteDataBanco($data)
{   // ESTA FUNÇÃO CONVERTE UMA DATA 31/12/2011 PARA 2011-12-31
    $dataBR = explode ("/",$data);
    $dataBanco = '';
    $dataBanco = $dataBR[2].'-'.$dataBR[1].'-'.$dataBR[0];
    return $dataBanco;
}
/*******************************************************************************
            FUNÇÃO QUE CONVERTE A DATA DO PADRÃO US PARA O BR
*******************************************************************************/
function ConverteData($data) {   // ESTA FUNÇÃO CONVERTE UMA DATA 2011-12-31 PARA 31/12/2011
    // SO RETORNA FORMATADO SE A DATA ESTIVER VÁLIDA
    if (strlen($data) != 10)
        return null;

    $dataBR = explode ("-",$data);
    $dataGMT = '';
    $dataGMT = $dataBR[2].'/'.$dataBR[1].'/'.$dataBR[0];
    return $dataGMT;
}

//FUNÇÃO PARA GERAR NÚMEROS ÚNICOS NO FORMATO (ANO_ATUAL + 5 NÚMEROS INCREMENTADOS AUTOMATICAMENTE)
function F_GeraNumero($sistema_id, $PaginaLocal)
{
    //QUERY PARA CONSULTAR O ANO BASE DA PÁGINA E SISTEMA INFORMADOS
    $sqlConsultaAno = "
    SELECT
        ano,
        numero
    FROM
        dados_unico.gerar_numero
    WHERE
        sistema_id = ".$sistema_id."
        AND pagina = '".$PaginaLocal."'";

    //REALIZANDO A CONSULTA
    $rsConsultaAno = pg_query(abreConexao(),$sqlConsultaAno);

    //CAPTURA O ANO ATUAL
    $ano_atual = date('Y');

    //VERIFICA SE NÃO FOI INSERIDO REGISTRO PARA A PÁGINA E SISTEMA INFORMADOS
    if(pg_num_rows($rsConsultaAno) == 0)
    {
        //QUERY PARA INSERÇÃO DO REGISTRO PARA A PÁGINA E O SISTEMA INFORMADOS
        $sqlInsere = "
        INSERT INTO dados_unico.gerar_numero
        (
            numero,
            ano,
            sistema_id,
            pagina
        )
        VALUES
        (
            2,
            ".$ano_atual.",
            ".$sistema_id.",
            '".$PaginaLocal."'
        )";

        //REALIZANDO A CONSULTA
        pg_query(abreConexao(),$sqlInsere);

        //CONCATENA O ANO COM O NÚMERO 1, POIS É O PRIMEIRO NÚMERO GERADO
        $numero = $ano_atual.'00001';
    }
    else
    {
        //ASSOCIOANDO OS DADOS
        $linhaConsultaAno = pg_fetch_assoc($rsConsultaAno);

        //CAPTURA O ANO BASE DO REGISTRO
        $ano = $linhaConsultaAno['ano'];

        //VERIFICA SE O ANO ATUAL É DIFERENTE DO ANO CADASTRADO NO BANCO
        if($ano != $ano_atual)
        {
            //QUERY PARA INSERÇÃO DO NOVO ANO PARA A PÁGINA E O SISTEMA INFORMADOS
            $sqlAlteraAno = "
            UPDATE
                dados_unico.gerar_numero
            SET
                numero = 2,
                ano = ".$ano_atual."
            WHERE
                sistema_id = ".$sistema_id."
                AND pagina = '".$PaginaLocal."'";

            //REALIZANDO A CONSULTA
            pg_query(abreConexao(),$sqlAlteraAno);

            //CONCATENA O ANO COM O NÚMERO 1, POIS É O PRIMEIRO NÚMERO DO ANO ATUAL
            $numero = $ano_atual.'00001';
        }
        else
        {
            //CAPTURA O ANO BASE DO REGISTRO
            $numero_atual = $linhaConsultaAno['numero'];

            //VERIFICA SE A QUANTIDADE DE CARACTERES DO NÚMERO ATUAL É MENOR DO QUE 5
            if(strlen($numero_atual) < 5)
            {
                //CONCATENA '0' A ESQUERDA DO NÚMERO ATUAL ATÉ ATINGIR 5 CARACTERES E ATRIBUI AO NÚMERO GERADO
                $numero = $ano.str_pad($numero_atual, 5, '0', STR_PAD_LEFT);
            }
            else
            {
                //ATRIBUI O NÚMERO ATUAL COMO O NÚMERO GERDO
                $numero = $ano.$numero_atual;
            }

            //ATRIBUI O NOVO NÚMERO COMO O NÚMERO ATUAL INCREMENTADO DE 1
            $novo_numero = $numero_atual + 1;

            //QUERY PARA INSERÇÃO DO NOVO NÚMERO PARA A PÁGINA E O SISTEMA INFORMADOS
            $sqlAlteraNumero = "
            UPDATE
                dados_unico.gerar_numero
            SET
                numero = ".$novo_numero."
            WHERE
                sistema_id = ".$sistema_id."
                AND pagina = '".$PaginaLocal."'";

            //REALIZANDO A CONSULTA
            pg_query(abreConexao(),$sqlAlteraNumero);
        }
    }

    //RETORNA O NÚMERO
    return $numero;
}


/*********************PASSAGEM TEMP*******************/

/*
**************************************************
função para carregar os estados
**************************************************
 *
 */
function f_ComboEstadoPassagem($NomeCombo,$FuncaoJavaScript,$codigoEscolhido)
{  
   echo "<select name=".$NomeCombo." style=width:45px ".$FuncaoJavaScript.">";
   $sql = "SELECT estado_uf FROM dados_unico.estado";
   
   $rs=pg_query(abreConexao(),$sql);
   while ($linha=pg_fetch_assoc($rs))
   {  $descricao = $linha['estado_uf'];
      if($codigoEscolhido == $descricao)
	  {  echo "<option value=" .$descricao. " selected>" .$descricao. "</option>";
      }
	  else
	  { echo"<option value=" .$descricao. ">" .$descricao. "</option>";
      }
   }
   return "</select>";


}
/*
**************************************************

**************************************************
função para carregar os municipios
**************************************************
 *
 */
function f_ComboMunicipioPassagem($NomeCombo,$EstadoFuncao, $codigoEscolhido)
{  if($EstadoFuncao == "")
    { $EstadoFuncao = "BA";
    }
    echo "<select id=".$NomeCombo." name=" .$NomeCombo. " style=width:200px>";
	$sql = "SELECT municipio_cd, municipio_ds, municipio_capital FROM dados_unico.municipio WHERE estado_uf = '". $EstadoFuncao."' ORDER BY municipio_ds";
	//echo $sql;
	
    $rs=pg_query(abreConexao(),$sql);
    while ($linha=pg_fetch_assoc($rs)) 
    { $codigo = $linha['municipio_cd'];
	  $descricao = $linha['municipio_ds'];
	  $capital = $linha['municipio_capital'];
      if (strval($codigoEscolhido) == strval($codigo))
	  {  echo "<option value=" .$codigo.  " selected>"  .$descricao.  "</option>";
      }
      else
	  { if (((int)$capital == 1) && ($codigoEscolhido == ""))
		{ echo "<option value=" .$codigo." selected>" .$descricao. "</option>";
        }
        Else
		{ echo "<option value=" .$codigo. ">" .$descricao. "</option>";
        }
      }
    }
    return "</select>";
}

function horaTurno($hora)
{
	//total de minutos
	$array_h_m		= explode(":",$hora);
	$tot_minutos	= ($array_h_m[0] * 60);
	$tot_minutos	= $tot_minutos + $array_h_m[1];

	//valida hora
	$horaTurno		= "";
	$pattern		= "/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])$/";
    
	if(preg_match($pattern,$hora))
	{
		If (($tot_minutos >= 360) && ($tot_minutos <= 720)) //se horas entre 6:00 e 12:00
		{
			$horaTurno = "MANHÃ";
		}
		ElseIf (($tot_minutos > 720) && ($tot_minutos < 1080 )) //se horas entre 12:01 e 17:59
		{
			$horaTurno = "TARDE";
		}
		Else//se horas entre 18:00 e 05:59
		{
			$horaTurno = "NOITE";
		}
	}
	return $horaTurno;
}
?>