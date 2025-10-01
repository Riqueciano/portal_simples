<?php

 

function ComboUnidadeOrcamentaria($NomeCombo, $FuncaoJavaScript,$tamanho) {
    echo "<select id=" . $NomeCombo . " name='" . $NomeCombo . "'  onchange='" . $FuncaoJavaScript . "' style='width:$tamanho'>";
    $sql = "select * from adiantamento.unidade_orcamentaria order by unidade_orcamentaria_sigla";
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=''>.:Selecione:.</option>";
    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs)) {
        echo "<option value=" . $linha['unidade_orcamentaria_id'] . ">" . $linha['unidade_orcamentaria_sigla'] . "</option>";
    }
    echo "</select>";
}

function ComboDadosUnicoPessoa($NomeCombo, $idCombo, $FuncaoJavaScript) {
    echo "<select id=" . $idCombo . " name='" . $NomeCombo . "'  onchange='" . $FuncaoJavaScript . "' style='width:98%'>";
    $sql = "select * from dados_unico.pessoa where pessoa_tipo = 'F' and pessoa_st =0 order by pessoa_nm";
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value=''>.:Selecione:.</option>";
    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs)) {
        echo "<option value=" . $linha['pessoa_id'] . ">" . $linha['pessoa_nm'] . "</option>";
    }
    echo "</select>";
}
function f_ComboSetaf($NomeCombo, $FuncaoJavaScript) {
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    $sql = "SELECT * FROM diaria.setaf ORDER BY setaf_nm ";
    $rs = pg_query(abreConexao(), $sql);
    $String = RetornarQtdeTracos($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        $codigo = $linha['setaf_id'];
        $descricao = $linha['setaf_nm'];
        echo "<option value='" . $codigo . "' >" . $descricao . "</option>";
    }
    return "</select>";
}
function f_ComboContratoAter($NomeCombo, $FuncaoJavaScript) {
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    $sql = "SELECT * FROM sigater.contrato ORDER BY contrato_num";
    $rs = pg_query(abreConexao(), $sql);
    $String = RetornarQtdeTracos($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        $codigo = $linha['contrato_id'];
        $descricao = $linha['contrato_num'];
        echo "<option value='" . $codigo . "' >" . $descricao . "</option>";
    }
    return "</select>";
}
function f_ComboLoteAter($NomeCombo, $FuncaoJavaScript) {
    echo "<select id=" . $NomeCombo . " name=" . $NomeCombo . " " . $Acao . " style='width:" . $Tamanho . ";' " . $FuncaoJavaScript . ">";

    $sql = "SELECT * FROM sigater.lote ORDER BY lote_nm::int";
    $rs = pg_query(abreConexao(), $sql);
    $String = RetornarQtdeTracos($QtdTracos);
    echo "<option value=0>[ " . $String . " Selecione " . $String . " ]</option>";

    while ($linha = pg_fetch_assoc($rs)) {
        $codigo = $linha['lote_id'];
        $descricao = $linha['lote_nm'];
        echo "<option value='" . $codigo . "' >" . $descricao . "</option>";
    }
    return "</select>";
}

//FUN«√O QUE RECEBE DUAS DATAS (COM HORA, MINUTO E SEGUNDO) E RETORNA A DIFEREN«A ENTRE ELAS
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
            // DiferenÁa em minutos
               $difDias = $difMinutos;
               $formato_tempo = " Min";
        }
        else if ($difMinutos >= 60 and $difMinutos < 1440){
            // DiferenÁa em horas
               $difDias = $difMinutos/60;

               //VERIFICA SE A QUANTIDADE … MENOR OU MAIOR QUE 1
               if (intval($difDias) > 1){$formato_tempo = " Horas";} else {$formato_tempo = " Hora";};
        }
        else if ($difMinutos >= 1440){
             // Diferen√ßa em dias
               $difDias = $difMinutos/1440;

               //VERIFICA SE A QUANTIDADE … MENOR OU MAIOR QUE 1
               if (intval($difDias) > 1){$formato_tempo = " Dias";} else {$formato_tempo = " Dia";};
        }


        // Trunca o numero de dias ..
        $NumeroDia = intval($difDias);
        return $NumeroDia.' '.$formato_tempo;
 }


function ConverteStringMoeda($valoreferencia){
/* Quando for usar esta funÁ„o e o valor for negativo deve-se agir desta maneira.
 * 1∫ Usar a funÁ„o ConverteStringMoeda
 * 2∫ Multiplicar o valor por -1.
 * Se esses passos n„o forem seguidos o valor que ser· retornado n„o ir·
 * condizer com passado para a funÁ„o.
*/
    $Valortmp 		= str_replace("R$","",$valoreferencia);
    $Valortmp		= str_replace(".","",$Valortmp);
    $Valortmp		= str_replace(",",".",$Valortmp);
    return $Valortmp;
}

/*
**************************************************
funÁ„o para inserir log di·ria
**************************************************
 *
 */
function f_InsereLogDiaria ($Pessoa, $Diaria, $Descricao)
{
    //$Time = date("H:i:s");
    //$Date = date("Y-m-d");

    /*$sql = "INSERT INTO diaria.diaria_log (diaria_id, pessoa_id, diaria_log_dt, diaria_log_hr, diaria_log_ds) VALUES (".$Diaria.",".$Pessoa.",'".$Date."','".$Time."','".$Descricao."')";*/

	//GRAVANDO O REGISTRO DO FUNCION¡RIO NA TABELA FUNCION¡RIO_HIST”RICO.
    /*$sqlInsereHistorico = "	INSERT	INTO diaria.diaria_historico
									(pessoa_id, diaria_log_dt, diaria_log_hr, diaria_log_ds, 
									diaria_id, diaria_numero, diaria_solicitante, diaria_beneficiario, 
									diaria_dt_saida, diaria_hr_saida, diaria_dt_chegada, diaria_hr_chegada, 
									diaria_valor_ref, diaria_desconto, diaria_qtde, diaria_valor, 
									diaria_justificativa_feriado, meio_transporte_id, diaria_transporte_obs, 
									diaria_descricao, diaria_unidade_custo, projeto_cd, acao_cd, 
									territorio_cd, fonte_cd, diaria_st, diaria_cancelada, diaria_devolvida, 
									diaria_dt_criacao, diaria_hr_criacao, diaria_justificativa_fds, 
									diaria_processo, diaria_empenho, diaria_dt_empenho, diaria_excluida, 
									diaria_roteiro_complemento, diaria_comprovada, diaria_empenho_pessoa_id, 
									diaria_hr_empenho, convenio_id, indenizacao, ger_id, diaria_extrato_empenho, 
									valor_estorno_alimentacao, empenho_previo, tipo_viagem, tipo_funcao_desempenhada, 
									cargo_funcao_desempenhada, dados_bancarios_id, cotacao_dolar_id, 
									diaria_id_dm, tipo_roteiro_diaria_assessor, tipo_funcao_desempenhada_justificativa, 
									diaria_somente_passagem, status_dir_maior, status_para_comprovador, 
									status_para_autorizador)
							SELECT	".$Pessoa.",
									now(),
									'".date("H:i:s")."',
									'".$Descricao."',
									* 
							FROM	diaria.diaria 
							WHERE 	diaria_id = ".$Diaria;*/
    //04-08-2015
    $sqlInsereHistorico = "	INSERT	INTO diaria.diaria_historico
									(pessoa_id, diaria_log_dt, diaria_log_hr, diaria_log_ds,diaria_id)
							SELECT	".$Pessoa.",
									now(),
									'".date("H:i:s")."',
									'".$Descricao."',
                                                                        $Diaria
							FROM	diaria.diaria 
							WHERE 	diaria_id = ".$Diaria;
									
//echo  '<pre>'.$sqlInsereHistorico.'</pre>';//exit;

    
    pg_query(abreConexao(),$sqlInsereHistorico);
}

/*
**************************************************
funÁ„o para inserir log passagem
**************************************************
 *
 */
function f_InsereLogPassagem ($Pessoa, $Diaria, $Descricao)
{
	$Time = date("H:i:s");
	$Date = date("Y-m-d");
	$sql = "INSERT INTO passagens.passagem_log (passagem_id, pessoa_id, passagem_log_dt, passagem_log_hr, passagem_log_ds) VALUES
	(".$Diaria.",".$Pessoa.",'".$Date."','".$Time."','".$Descricao."')";
        
        //ECHO_pre($sql);EXIT;
	pg_query(abreConexao(),$sql);
}


/*************************************************
funÁ„o para inserir log
**************************************************/

function f_InsereLog($Descricao)
{
    $Time=date("H:i:s");
    $Date=date("Y-m-d");
    $sql = "INSERT INTO dados_unico.log_evento (pessoa_id, log_evento_dt, log_evento_hr, log_evento_ds) VALUES (".$_SESSION['UsuarioCodigo'].",'".$Date."','".$Time."','".$Descricao."')";
    pg_query(abreConexao(),$sql);
}

/*************************************************
funÁ„o para formata data no padrao DD/MM/AAAA
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
       return $Dt_formatada." ‡s ".$DataTime;
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
                    FunÁ„o para carregar os PAÕSES
*******************************************************************************/
function f_ComboPais($NomeCombo,$codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{
  /*****************************************************************************
  * $NomeCombo = È o NOME do combo que ser· passado para a funÁ„o.
  * $codigoEscolhido = È o C”DIGO do municÌpio que est· sendo passado.
  * $FuncaoJavaScript = È a funÁ„o JAVASCRIPT que È passado para o combo.
  * $Acao = serve para desabilitar o combo para o mesmo n„o ser alterado.
  * $Tamanho = È o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
  * $QtdTracos = È a quantidade de traÁos entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
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
                    FunÁ„o para retornar o nome da pessoa.
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
fun√ß√£o para carregar os estados
**************************************************
 *
 */
function f_ComboEstado($NomeCombo,$FuncaoJavaScript=null,$codigoEscolhido=null)
{
   echo "<select id=".$NomeCombo." name=".$NomeCombo." style=width:55px ".$FuncaoJavaScript.">";
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
function f_ComboEstadoCompromisso($NomeCombo,$FuncaoJavaScript=null,$codigoEscolhido=null)
{
   echo "<select id=".$NomeCombo." name=".$NomeCombo." style=width:55px ".$FuncaoJavaScript.">";
   $sql = "SELECT estado_uf FROM dados_unico.estado";
echo "<option value=" .''. " >" .'TODOS'. "</option>";
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
                    FunÁ„o para carregar os municipios
*******************************************************************************/
function f_ComboMunicipio($NomeCombo,$EstadoFuncao, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos){
  /*****************************************************************************
  * $NomeCombo = È o NOME do combo que ser· passado para a funÁ„o.
  * $EstadoFuncao = È a sigla do ESTADO que est· sendo passada.
  * $codigoEscolhido = È o C”DIGO do municÌpio que est· sendo passado.
  * $FuncaoJavaScript = È a funÁ„o JAVASCRIPT que È passado para o combo.
  * $Acao = serve para desabilitar o combo para o mesmo n„o ser alterado.
  * $Tamanho = È o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
  * $QtdTracos = È a quantidade de traÁos entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
  *****************************************************************************/

    if(trim($EstadoFuncao) == "")
    {
        $EstadoFuncao = "BA";
    }
    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

    $sql = "SELECT municipio_cd, municipio_ds, municipio_capital
                FROM dados_unico.municipio
                WHERE estado_uf = '". $EstadoFuncao."'  
                    
   
            ORDER BY municipio_ds";
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
                    FunÁ„o para carregar os municipios
*******************************************************************************/
function f_ComboMunicipioDiariaGlobal($NomeCombo,$EstadoFuncao, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos){
  /*****************************************************************************
  * $NomeCombo = È o NOME do combo que ser· passado para a funÁ„o.
  * $EstadoFuncao = È a sigla do ESTADO que est· sendo passada.
  * $codigoEscolhido = È o C”DIGO do municÌpio que est· sendo passado.
  * $FuncaoJavaScript = È a funÁ„o JAVASCRIPT que È passado para o combo.
  * $Acao = serve para desabilitar o combo para o mesmo n„o ser alterado.
  * $Tamanho = È o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
  * $QtdTracos = È a quantidade de traÁos entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
  *****************************************************************************/

    if(trim($EstadoFuncao) == "")
    {
        $EstadoFuncao = "BA";
    }
    echo "<select id=".$NomeCombo." name=".$NomeCombo." ".$Acao." style='width:".$Tamanho.";' ".$FuncaoJavaScript.">";

    $sql = "SELECT municipio_cd, municipio_ds, municipio_capital
                FROM dados_unico.municipio
                WHERE estado_uf = '". $EstadoFuncao."'  
                
            ORDER BY municipio_ds";
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
                    FunÁ„o para carregar os municipios
*******************************************************************************/
function f_ComboTipoFeriado($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{
  /*****************************************************************************
  * $NomeCombo = È o NOME do combo que ser· passado para a funÁ„o.
  * $codigoEscolhido = È o C”DIGO do municÌpio que est· sendo passado.
  * $FuncaoJavaScript = È a funÁ„o JAVASCRIPT que È passado para o combo.
  * $Acao = serve para desabilitar o combo para o mesmo n„o ser alterado.
  * $Tamanho = È o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
  * $QtdTracos = È a quantidade de traÁos entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
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
                    FunÁ„o para carregar os niveis escolares
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
fun√ß√£o para carregar os estados civis
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
fun√ß√£o para carregar os tipos de funcion√°rios
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
fun√ß√£o para carregar ministerios da defesa
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
fun√ß√£o para carregar estrutura organizacional sigla
**************************************************
 *
 */
function f_ComboEstruturaOrganizacionalSigla(){
   
   echo "<select name=cmbEstOrganizacional id=cmbEstOrganizacional style=width:200px>";
   $sql = "SELECT * FROM dados_unico.est_organizacional WHERE est_organizacional_st = 0 ORDER BY est_organizacional_sigla";
   $rs=pg_query(abreConexao(),$sql);
   echo"<option value=0>[------------------- Selecione -------------------]</option>";
   While ($linha=pg_fetch_assoc($rs)){
       $codigo = $linha['est_organizacional_id'];
       $descricao = $linha['est_organizacional_sigla'];
       echo "<option value=" .$codigo.">" .$descricao."</option>";
    }
   echo"</select>";

}
function f_ComboEstruturaOrganizacionalSigla2($nome, $javascript,$tamanho){
   
   echo "<select name='$nome' id='$nome' style=width:$tamanho>";
   $sql = "SELECT * FROM dados_unico.est_organizacional WHERE est_organizacional_st = 0 ORDER BY est_organizacional_sigla";
   $rs=pg_query(abreConexao(),$sql);
   echo"<option value=0>.:Selecione:.</option>";
   While ($linha=pg_fetch_assoc($rs)){
       $codigo = $linha['est_organizacional_id'];
       $descricao = $linha['est_organizacional_sigla'];
       echo "<option value=" .$codigo.">" .$descricao."</option>";
    }
   echo"</select>";

}
function f_ComboEstruturaOrganizacionalLotacaoSigla($nome, $javascript){
   
   echo "<select name='$nome' id='$nome' style=width:200px>";
   $sql = "SELECT * FROM dados_unico.est_organizacional_lotacao WHERE est_organizacional_lotacao_st = 0 ORDER BY est_organizacional_lotacao_sigla";
   $rs=pg_query(abreConexao(),$sql);
   echo"<option value=0>[------------------- Selecione -------------------]</option>";
   While ($linha=pg_fetch_assoc($rs)){
       $codigo = $linha['est_organizacional_lotacao_id'];
       $descricao = $linha['est_organizacional_lotacao_sigla'];
       echo "<option value=" .$codigo.">" .$descricao."</option>";
    }
   echo"</select>";

}
/*******************************************************************************
                CARREGA AS ESTRUTURAS ORGANIZACIONAIS CADASTRADAS
*******************************************************************************/
function f_ComboEstruturaOrganizacional($NomeCombo, $codigoEscolhido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos){
  /*****************************************************************************
  * $NomeCombo = È o NOME do combo que ser· passado para a funÁ„o.
  * $codigoEscolhido = È o C”DIGO do municÌpio que est· sendo passado.
  * $FuncaoJavaScript = È a funÁ„o JAVASCRIPT que È passado para o combo.
  * $Acao = serve para desabilitar o combo para o mesmo n„o ser alterado.
  * $Tamanho = È o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
  * $QtdTracos = È a quantidade de traÁos entre o [ e o Seleciona. Ex: $QtdTracos = 3 [ --- Selecione ---]
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
fun√ß√£o para carregar bancos (unidades financeiras)
**************************************************
 * //Carrega combo de bancos
 */
function f_ComboBanco($codigoEscolhido)
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
fun√ß√£o para carregar tipos de conta
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
function f_ComboOrgao($NomeCombo, $codigoEscolhido,$tamanho){
    //CONSULTA OS ORG√OS
    $sql = "SELECT orgao_id,orgao_ds FROM dados_unico.orgao 
              WHERE flag_maladireta = 0 and orgao_st = 0 AND orgao_id <> 0 ORDER BY UPPER(orgao_ds)";
    //RESULTADO DA CONSULTA
    $rs=pg_query(abreConexao(),$sql);

    echo "<select  name='" .$NomeCombo."' style=width:".$tamanho.">";
    //VERIFICA O TAMANHO EM PIXELS PARA IMPRESS√O CORRETA DA OP«√O "SELECIONE"
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
function f_ComboOrgaoId($NomeCombo, $codigoEscolhido,$tamanho){
    //CONSULTA OS ORG√OS
    $sql = "SELECT orgao_id,orgao_ds FROM dados_unico.orgao WHERE orgao_st = 0 AND orgao_id <> 0 ORDER BY UPPER(orgao_ds)";
    //RESULTADO DA CONSULTA
    $rs=pg_query(abreConexao(),$sql);

    echo "<select  name='" .$NomeCombo."' id='" .$NomeCombo."' style=width:".$tamanho.">";
    //VERIFICA O TAMANHO EM PIXELS PARA IMPRESS√O CORRETA DA OP«√O "SELECIONE"
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
'fun√ß√£o para carregar grupo sanguineo
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
'funÁ„o para carregar ”rg„os do governo do estado
'**************************************************
 *
 */

function f_ComboFuncionarioTipo($codigoEscolhido)
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
function f_ComboFuncionario_2($nome,$javaScript,$tamanho)
{ echo "<select name='$nome' id='$nome' onchange='$javaScript'  style='width:$tamanho'>";
  $sql = "SELECT p.pessoa_id,p.pessoa_nm FROM dados_unico.funcionario f
                    inner join dados_unico.pessoa p
                        on p.pessoa_id = f.pessoa_id
            where f.funcionario_st = 0 
                ORDER BY p.pessoa_nm ";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=''>.:Selecione:.</option>";
  While ($linha=pg_fetch_assoc($rs)){
    $codigo = $linha ['pessoa_id'];
    $descricao = $linha ['pessoa_nm'];
    echo "<option value=".$codigo. ">".$descricao."</option>";
    
  }
  echo "</select>";
}

function f_ComboEstOrgSigla($codigoEscolhido)
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


function f_ConsultaEstadoCivil($codigoEscolhido)
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
'fun√ß√£o para carregar √≥rg√£os do governo do estado
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
fun√ß√£o para carregar √≥rg√£os do governo do estado
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
fun√ß√£o para carregar √≥rg√£os do governo do estado
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
fun√ß√£o para carregar √≥rg√£os do governo do estado
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
'fun√ß√£o para carregar √≥rg√£os do governo do estado
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
{ if ($codigoEscolhido != ""){ 
    $sql = "SELECT est_organizacional_lotacao_ds FROM dados_unico.est_organizacional_lotacao WHERE est_organizacional_lotacao_id = '".$codigoEscolhido."'";
	$rs=pg_query(abreConexao(),$sql);
     $linha=pg_fetch_assoc($rs);
     echo $linha['est_organizacional_lotacao_ds'];
  }
}

/*
'**************************************************
'fun√ß√£o para carregar √≥rg√£os do governo do estado
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
  // depois inclui a barra '-' pois o strotime s√≥ trabalha com data no formato americano
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
     // se o dia atingiu o ultimo dia do m√™s muda-se para o proximo mes
     else
     { $vetData[1]=$vetData[1]+1;
        $MesAcrescido=$vetData[1];
        $DiaAcrescido="01";
        $ultimoDiaDoMesAcrescido = cal_days_in_month(CAL_GREGORIAN, $MesAcrescido, $AnoAcrescido);
     }
     // se o dia atingiu o ultimo dia do m√™s muda-se para o proximo mes e for o ultimo mes do ano muda-se o ano
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

  // depois inclui a barra '-' pois o strotime s√É¬≥ trabalha com data no formato americano
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
function diasemana($dataBR)//dd/mm/yyyy
{
    $ano =  substr($dataBR, 6, 4);
    $mes =  substr($dataBR, 3, 2);
    $dia =  substr($dataBR, 0, 2);
    $diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano));

    switch($diasemana)
    {
            case"0": $diasemana = "Domingo";       break;
            case"1": $diasemana = "Segunda-Feira"; break;
            case"2": $diasemana = "TerÁa-Feira";   break;
            case"3": $diasemana = "Quarta-Feira";  break;
            case"4": $diasemana = "Quinta-Feira";  break;
            case"5": $diasemana = "Sexta-Feira";   break;
            case"6": $diasemana = "S·bado";        break;
    }

    return  $diasemana;
}
function diasemanaNum($data)
{
    $ano =  substr($data, 6, 4);
    $mes =  substr($data, 3, 2);
    $dia =  substr($data, 0, 2);
    $diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano));


    return  $diasemana;
}
 



function f_ComboEstruturaOrganizacionalLotacao($NomeCombo, $codigoEscolhido)
{  print"<select name=".$NomeCombo. " style=width:200px>";

   $sql = "SELECT * FROM dados_unico.est_organizacional_lotacao WHERE est_organizacional_lotacao_st = 0 AND est_organizacional_lotacao_id <> 0 ORDER BY est_organizacional_lotacao_sigla";

   $rs=pg_query(abreConexao(),$sql);

   print "<option value=0>[------------------- Selecione -------------------]</option>";

   while ($linha=pg_fetch_assoc($rs))
   {
   	if ($codigoEscolhido != "")
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

//FUN«√O QUE REALIZA TRATAMENTO PARA VARIAVEIS TRUNCADAS
function F_TruncarString($str, $maxChar)
{
    //CAPTURA A QUANTIDADE DE CARACTERES DA STRING ORIGINAL
    $str_len_original = strlen($str);

    //VERIFICA SE A QUANTIDADE DE CARACTERES DA STRING ORIGINAL … MAIOR QUE A TRUNCADA
    if($str_len_original > $maxChar)
    {
        //CRIA QUANTIDADE DE ESCAPE
        $escape = 3;

        //VERIFICA A QUANTIDADE DE CARACTERES ORIGINAIS E A QUANTIDADE MAXIMA PERMITIDA
        if ($maxChar + $escape < $str_len_original)
        {
            //TRUNCA A STRING
            $str_trunc = substr($str, 0, $maxChar);

            //INSERE TEXTO NO FINAL PARA IDENTIFICAR QUE O TEXTO EST¡ TRUNCADO
            $str_trunc = $str_trunc.' ...';

            //RETORNA O TEXTO TRUNCADO
            return $str_trunc;
        }
        //SE ESTIVER DENTRO DO ESCAPE N√O TRUNCA
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
    
    if(empty(trim($funcionario_id))){
        $funcionario_id = $GLOBALS["cadastro_pessoa_id"];;
    }
    
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
                pessoa_id = ".(int)$funcionario_id."";

    //echo_pre($sqlConsulta);//exit;
    //REALIZANDO A CONSULTA
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);

    //ASSOCIOA O DADO CONSULTADO
    $linha = pg_fetch_assoc($rsConsulta,$qtdIndice);

    //CAPTURA O SETOR DO USUARIO
    $Setor_Usuario = $linha['est_organizacional_id'];

    //RETORNA O SETOR
    return $Setor_Usuario;
}

//FUN«√O PARA ATRIBUR O NOME DO STATUS
function F_RetornaNomeStatusRegistro($StatusNumero)
{
    //ATRIBUINDO A DESCRI«√O DO STATUS
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

//FUN«√O PARA ATRIBUR O NOME DO STATUS
function F_RetornaNomeSituacaoDoDocumento($SituacaoNumero)
{
    //ATRIBUINDO A DESCRI«√O DO STATUS
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

//FUN«√O PARA ATRIBUR UM TITULO AO NOME DO STATUS
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
//FUN«√O PARA VERIFICAR O ACESSO DO USU¡RIO
function F_VerificaAcessoUsuario($id)
{
    //N√O TERMINADA.............................................................
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
        FUN«√O QUE RETORNA A QUANTIDADE DE TRA«OS PARA OS COMBOS.
*******************************************************************************/
function RetornarQtdeTracos ($QtdTracos)
{//$QtdTracos È a quantidade de - que ser· exibido no combo.
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
  ESTA FUN«√O TRANSFORMA UM NUMERO PASSADO NO PADR√O DA MOEDA BRASILEIRA, PODE
SER USADA COM OU SEM FRA«√O. LEMBRANDO QUE COMO A FUN«√O CONVERTE A FRA«√O PARA
  FLOAT O MESMO RETORNA AS CASAS DECIMAIS COM O PONTO (.) E N√O COM A VÕRGULA
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
  COMBO DE M SES DO ANO
*******************************************************************************/
function f_ComboMeses($NomeCombo, $CodigoRecebido, $FuncaoJavaScript, $Acao, $Tamanho, $QtdTracos)
{
    /*
      $NomeCombo        = È o nome do combo que ser· passado para a funÁ„o.
      $CodigoRecebido   = È o ID que ser· passado como filtro para o combo.
      $FuncaoJavaScript = È a funÁ„o JAVASCRIPT que È passada para o combo.
      $Acao             = serve para desabilitar o combo para o mesmo n„o ser alterado.
      $Tamanho          = È o tamanho do combo em pixels o valor deve ser passado desta maneira 100px
      $QtdTracos        = È a quantidade de traÁos passados para funÁ„o RetornarQtdeTracos, que retornar· a quantidade de traÁos entre o [ Selecione. Ex: $QtdTracos = 3 [ --- Selecione ---]
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
        if($linha==3){$descricao  = 'MAR«O';}
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
   FUN«√O QUE GRAVA O LOG DE QUALQUER MODIFICA«√O NA TABELA PAIS GRUPO VALOR
*******************************************************************************/
function InsereLogPaisGrupoValor ($PaisGrupoID, $AcaoSistema)
{
    //OP«’ES DAS A«’ES DO SISTEMA
    if ($AcaoSistema == 'incluir')
    {
        $MensagemLog = "Registro foi incluÌdo por: ".$_SESSION['UsuarioNome'];
    }
    elseif ($AcaoSistema == 'alterar')
    {
        $MensagemLog = "Registro foi modificado por: ".$_SESSION['UsuarioNome'];
    }
    elseif ($AcaoSistema == 'excluir')
    {
        $MensagemLog = "Registro foi excluÌdo por: ".$_SESSION['UsuarioNome'];
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
          FUN«√O QUE IR¡ RETORNAR UMA STRING COM A DATA POR EXTENSO
*******************************************************************************/
function f_RetornaDataPorExtenso ($DataInicio, $DataFim, $Separador, $TipoDeData)
{
/*******************************************************************************
* $DataInicio = È a data inÌcio da string retornada.
* $DataFim = È a data final da string retornada.
* $Separador = È o caractere que ser· usado para o explode, pode ser - ou /
* $TipoDeData = È o tipo de data que est· sendo utilizada, DATE = 'DB', CHARACTER = 'CH'
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
                case 3: $StringMes = "MarÁo"; break;
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
                case 3: $StringMes = "MarÁo"; break;
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
                    FUN«√O QUE PREVINE SQL INJECTION
*******************************************************************************/
function f_Anti_Injection($sql)
{
    // remove palavras que contenham sintaxe sql
    $sql = strtolower($sql);
    $sql = preg_replace("/(from|update|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i","",$sql);
    //limpa espaÁos vazio
    $sql = trim($sql);
    //tira tags html e php
    $sql = strip_tags($sql);

    $sql = addslashes($sql);

    return $sql;
}
/*******************************************************************************
            FUN«√O QUE CONVERTE A DATA DO PADR√O BR PARA O US
*******************************************************************************/
function ConverteDataBanco($data)
{   // ESTA FUN«√O CONVERTE UMA DATA 31/12/2011 PARA 2011-12-31
    $dataBR = explode ("/",$data);
    $dataBanco = '';
    $dataBanco = $dataBR[2].'-'.$dataBR[1].'-'.$dataBR[0];
    return $dataBanco;
}
/*******************************************************************************
            FUN«√O QUE CONVERTE A DATA DO PADR√O US PARA O BR
*******************************************************************************/
function ConverteData($data) {   // ESTA FUN«√O CONVERTE UMA DATA 2011-12-31 PARA 31/12/2011
    // SO RETORNA FORMATADO SE A DATA ESTIVER V¡LIDA
    if (strlen($data) != 10)
        return null;

    $dataBR = explode ("-",$data);
    $dataGMT = '';
    $dataGMT = $dataBR[2].'/'.$dataBR[1].'/'.$dataBR[0];
    return $dataGMT;
}

//FUN«√O PARA GERAR N⁄MEROS ⁄NICOS NO FORMATO (ANO_ATUAL + 5 N⁄MEROS INCREMENTADOS AUTOMATICAMENTE)
function F_GeraNumero($sistema_id, $PaginaLocal)
{
    //QUERY PARA CONSULTAR O ANO BASE DA P¡GINA E SISTEMA INFORMADOS
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

    //VERIFICA SE N√O FOI INSERIDO REGISTRO PARA A P¡GINA E SISTEMA INFORMADOS
    if(pg_num_rows($rsConsultaAno) == 0)
    {
        //QUERY PARA INSER«√O DO REGISTRO PARA A P¡GINA E O SISTEMA INFORMADOS
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

        //CONCATENA O ANO COM O N⁄MERO 1, POIS … O PRIMEIRO N⁄MERO GERADO
        $numero = $ano_atual.'00001';
    }
    else
    {
        //ASSOCIOANDO OS DADOS
        $linhaConsultaAno = pg_fetch_assoc($rsConsultaAno);

        //CAPTURA O ANO BASE DO REGISTRO
        $ano = $linhaConsultaAno['ano'];

        //VERIFICA SE O ANO ATUAL … DIFERENTE DO ANO CADASTRADO NO BANCO
        if($ano != $ano_atual)
        {
            //QUERY PARA INSER«√O DO NOVO ANO PARA A P¡GINA E O SISTEMA INFORMADOS
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

            //CONCATENA O ANO COM O N⁄MERO 1, POIS … O PRIMEIRO N⁄MERO DO ANO ATUAL
            $numero = $ano_atual.'00001';
        }
        else
        {
            //CAPTURA O ANO BASE DO REGISTRO
            $numero_atual = $linhaConsultaAno['numero'];

            //VERIFICA SE A QUANTIDADE DE CARACTERES DO N⁄MERO ATUAL … MENOR DO QUE 5
            if(strlen($numero_atual) < 5)
            {
                //CONCATENA '0' A ESQUERDA DO N⁄MERO ATUAL AT… ATINGIR 5 CARACTERES E ATRIBUI AO N⁄MERO GERADO
                $numero = $ano.str_pad($numero_atual, 5, '0', STR_PAD_LEFT);
            }
            else
            {
                //ATRIBUI O N⁄MERO ATUAL COMO O N⁄MERO GERDO
                $numero = $ano.$numero_atual;
            }

            //ATRIBUI O NOVO N⁄MERO COMO O N⁄MERO ATUAL INCREMENTADO DE 1
            $novo_numero = $numero_atual + 1;

            //QUERY PARA INSER«√O DO NOVO N⁄MERO PARA A P¡GINA E O SISTEMA INFORMADOS
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

    //RETORNA O N⁄MERO
    return $numero;
}


/*********************PASSAGEM TEMP*******************/

/*
**************************************************
funÁ„o para carregar os estados
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
funÁ„o para carregar os municipios
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

function f_ComboMunicipioTerritorio($NomeCombo,$tamanho='99%',$param=NULL)
{  $sql = "SELECT* FROM indice.municipio where 1=1 $param ORDER BY municipio_nm ";
    echo "<select id=".$NomeCombo." name=" .$NomeCombo. " style='width:$tamanho'>";
	
	//echo $sql;
	echo "<option value='' >.:Selecione:.</option>";
    $rs=pg_query(abreConexao(),$sql);
    while ($linha=pg_fetch_assoc($rs)) { 
      $codigo = $linha['municipio_id'];
      $descricao = $linha['municipio_nm'];
      echo "<option value=" .$codigo.  " >"  .$descricao.  "</option>";
           
    }
    return "</select>";
}

function f_ComboMunicipioCompromisso($NomeCombo,$EstadoFuncao, $codigoEscolhido)
{  if($EstadoFuncao == "")
    { $EstadoFuncao = "BA";
    }
    echo "<select id=".$NomeCombo." name=" .$NomeCombo. " style=width:200px>";
	$sql = "SELECT municipio_cd, municipio_ds, municipio_capital FROM dados_unico.municipio WHERE estado_uf = '". $EstadoFuncao."' ORDER BY municipio_ds";
	//echo $sql;
	echo "<option value=" .'todos'.  " selected>"  .'TODOS'.  "</option>";
	echo "<option value=" .'interior'.  " >"  .'INTERIOR'.  "</option>";
    $rs=pg_query(abreConexao(),$sql);
    while ($linha=pg_fetch_assoc($rs)) 
    { $codigo = $linha['municipio_cd'];
	  $descricao = $linha['municipio_ds'];
	  $capital = $linha['municipio_capital'];
      echo "<option value=" .$codigo. ">" .$descricao. "</option>";
        
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
			$horaTurno = "MANH√";
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



//FUN«√O QUE RECEBE OS PARAMETROS BASICOS E VALIDA O C¡LCULO DA DI¡RIA
function f_ValidarCalculoDiaria($DataPartida,$HoraPartida,$DataChegada,$HoraChegada, $ValorRef, $Desconto, $Qtde, $Valor, $ValorReferenciaAux, 
								$PercRecebido, $PercentualRefCalc, $Precursor_chk, $Representar_chk, $FuncaoDesenpenhada, $Complemento,
								$AcaoSistema)
{
	global $dataDecreto;

	/*$_SESSION['DataPartida'] = "";
	$_SESSION['HoraPartida'] = "";
	$_SESSION['DataChegada'] = "";
	$_SESSION['HoraChegada'] = "";*/

	//ESSA VARI¡VEL FOI ZERADA, POIS ESTAVA OCORRENDO DIVERG NCIA DE C¡LCULO QUANDO O BOT√O ERA CLICADO MAIS DE UMA VEZ
	//$_SESSION['PercentualRecebido'] = "";

	/*$HoraPartida        = $_GET['horasaida'];
	$HoraChegada        = $_GET['horachegada'];
	$DataPartida        = $_GET['datasaida'];
	$DataChegada        = $_GET['datachegada'];*/


	$ValorReferencia    = str_replace(",",".",$ValorReferenciaAux);
	//$Desconto           = $_GET['desconto'];
	
	
	$PercentualRecebido = str_replace(",",".",$PercRecebido);
	//$Precursor          = $_GET['Precursor'];
	//$Representante      = $_GET['Representante'];
	//$FuncaoDesenpenhada = $_GET['Funcao'];
	//$Beneficiario       = $_GET['beneficiario'];
	//$Acao               = $_GET['acao'];
	//$Complemento        = $_GET['complemento'];

	/*$_SESSION['DataPartida'] 	= $DataPartida;
	$_SESSION['HoraPartida'] 	= $HoraPartida;
	$_SESSION['DataChegada'] 	= $DataChegada;
	$_SESSION['HoraChegada'] 	= $HoraChegada;*/

	/*If (($_SESSION['PercentualRecebido'] == $PercentualRecebido) || ($_SESSION['PercentualRecebido'] == ""))
	{*/
		//calcula a diferenca entre as horas
		// Divide a hora
		$HoraP=explode(":",$HoraPartida);
		$HoraC=explode(":",$HoraChegada);

		// Divide a data
		$DataP = explode("/", $DataPartida);
		$DataC = explode("/", $DataChegada);

		// Transforma em segundo
		$MinutoPartida = mktime($HoraP[0], $HoraP[1], "00", $DataP[1], $DataP[0], $DataP[2]);
		$MinutoChegada = mktime($HoraC[0], $HoraC[1], "00", $DataC[1], $DataC[0], $DataC[2]);

		// Transforma em minutos
		$difMinutos = ($MinutoChegada - $MinutoPartida)/60;

		// DiferenÁa em dias: 24 * 60 = 1440
		$difDias = $difMinutos/1440;

		// Trunca o numero de dias
		$NumeroDia = intval($difDias);

		$DiariaResto = $difMinutos - (1440*$NumeroDia);

		/*******************************************************************************
		//Data: 27/07/2015
		//Coment·rio: alteraÁ„o a pedido da DF
		*******************************************************************************/
		$DataPartidaTemp	= ConverteDataBanco($DataPartida);

		// VERIFICA SE A DATA DE PARTIDA … MENOR QUE A DATA DO DECRETO (N∫ 16.220 DE 24 DE JULHO DE 2015) E PUBLICA«√O 25 DE JULHO DE 2015 - VARI¡VEL GLOBAL
		if (strtotime($DataPartidaTemp) < strtotime($dataDecreto)) {

			//07_11_2013 maior igual a 6:00 e menor igual a 12:00
			If (($DiariaResto >= 360) && ($DiariaResto <= 720)) //se horas entre 6:00 e 12:00
			{
				$Percentual = ".4";
			}
			ElseIf (($DiariaResto > 720) && ($DiariaResto < 1440)) //se horas entre 12:01 e 23:59
			{
				$Percentual = ".6";
				$Diaria60 = 1;
			}
			Else//se horas menor que 5:59 ou igual a 24:00
			{
				$Percentual = "";
			}

			//$Percentual40 = "0.4";
			$PercentualComplemento = "0.4";

		}else{
			
			If ($DiariaResto > 600) //se horas superior 10:00
			{
				$Percentual = ".5";
				$Diaria60 = 1;
			}
			Else//sen„o horas menor/igual que 10:00
			{
				$Percentual = "";
			}

			//$Percentual40 = "0.5";
			$PercentualComplemento = "0.5";
		
		}


		$NumeroDiarias 	= $NumeroDia.$Percentual;

		//calculo de acordo com o roteiro
		If (($PercentualRecebido != 0) ||($PercentualRecebido != "")|| ($PercentualRecebido != 1))
		{
			$ValorReferencia += ((double)($ValorReferencia)) * ((double)($PercentualRecebido));
		}
		ElseIf ($PercentualRecebido == 1)
		{
			$ValorReferencia = (double)($ValorReferencia) + (double)($ValorReferencia);
		}

		if (($Precursor == "on") || ($FuncaoDesenpenhada == 3))
		{
			//echo "1<br>";
			//$PercentualPrecursor = "*70%&nbsp;:&nbsp;";
			$PercentualPrecursor = "*70% : ";

			//CASO A VIAGEM SEJA DE UM PRECURSOR MULTIPLICA POR 70% CONFORME O DECRETO.
			$ValorReferencia = ((double)($ValorReferencia)) * ((double)('0.7'));
			
			//ARREDONDA O VALOR DE REFERENCIA
			//$ValorReferencia = round($ValorReferencia);
		}
		else if (($Representante == "on") || ($FuncaoDesenpenhada == 1)|| ($FuncaoDesenpenhada == 2))
		{
			//echo "2<br>";
			//$PercentualRepresentante = "*100%&nbsp;:&nbsp;";
			$PercentualRepresentante = "*100% : ";

			//CASO A VIAGEM SEJA DE UM PRECURSOR MULTIPLICA POR 100% CONFORME O DECRETO.
			$ValorReferencia = ((double)($ValorReferencia)) * ((double)('1'));
			$ValorReferencia = round($ValorReferencia);
		}
		else
		{
			//echo "3<br>";
			$PercentualRepresentante = "";
			$PercentualPrecursor = "";
			$ValorReferencia = round($ValorReferencia);
		}

		$ValorTotal	= ((double)$ValorReferencia)*((double)($NumeroDiarias));

		If ($Desconto == "S") //se checkbox desconto 50% marcado
		{
			$ValorTotal = $ValorTotal/2;
		}

		if ($Complemento == 1)
		{
			//$Percentual40 = "0.4";
			//$ValorDiaria60 = $ValorReferencia * (double)($Percentual40);
			$ValorDiaria60 = $ValorReferencia * (double)($PercentualComplemento);

			if ($Desconto == "S")//se checkbox desconto 50% marcado
			{
				$ValorDiaria60 = $ValorDiaria60/2;
			}
			//$NumeroDiarias = $NumeroDiarias + (double)($Percentual40);
			$NumeroDiarias = $NumeroDiarias + (double)($PercentualComplemento);
			$ValorTotal = $ValorTotal + (double)($ValorDiaria60);
		}
		
		/*$_SESSION['PercentualRecebido'] = $PercentualRecebido;
		$_SESSION['NumeroDiarias']      = $NumeroDiarias;
		$_SESSION['ValorTotal']         = $ValorTotal;*/

		if ($AcaoSistema == "incluir"){
			$Valor					= trim(str_replace("R$ ","",$Valor));
			$ValorRef				= trim(str_replace("R$ ","",$ValorRef));
		}
	
		$PercentualRecebido_Aux = $PercentualRecebido*100;
		$PercentualRefCalc_Aux	= "+".$PercentualRecebido_Aux."% ".$PercentualRepresentante.$PercentualPrecursor.number_format($ValorReferencia, 2, ',', '.');
		

		//remover 
		//$PercentualRefCalc = str_replace("\xA0", ' ', html_entity_decode($PercentualRefCalc));

		
		/*echo $DataPartida."-".$HoraPartida."---------".$DataChegada."-".$HoraChegada."<br><br>";

		echo "entrada = ".$PercentualRefCalc." --------- valida = ".$PercentualRefCalc_Aux."<br><br>";
		echo "entrada = ".$Qtde." --------- valida = ".$NumeroDiarias."<br><br>";
		echo "entrada = ".$Valor." --------- valida = ".number_format($ValorTotal, 2, ',', '.')."<br><br>";
		echo "entrada = ".$ValorRef." --------- valida = ".number_format($ValorReferencia, 2, ',', '.');*/
		

		if	(($PercentualRefCalc	== $PercentualRefCalc_Aux) && 
			($Qtde					== $NumeroDiarias) && 
			($Valor					== number_format($ValorTotal, 2, ',', '.')) && 
			($ValorRef				== number_format($ValorReferencia, 2, ',', '.'))){
				//echo "correto!";
				return true;
		}else{
				//echo "incorreto!";
				return false;
		}
	
}

//FUN«√O QUE RECEBE OS PARAMETROS BASICOS E VALIDA O C¡LCULO DA DI¡RIA
function f_ValidarCalculoDiariaComprovacao(	$DataPartida,$HoraPartida,$DataChegada,$HoraChegada, $ValorRef, $Desconto, $Qtde, $Valor, $ValorReferenciaAux, 
											$ValorAnterior, $ValorReceber, $ValorRestituir, $PercRecebido, $PercentualRefCalc, 
											$FuncaoDesenpenhada, $Complemento, $AcaoSistema,$Codigo)
{

	global $dataDecreto;

	/*$_SESSION['DataPartida'] = "";
	$_SESSION['HoraPartida'] = "";
	$_SESSION['DataChegada'] = "";
	$_SESSION['HoraChegada'] = "";

	$HoraPartida        = $_GET['horasaida'];
	$HoraChegada        = $_GET['horachegada'];
	$DataPartida        = $_GET['datasaida'];
	$DataChegada        = $_GET['datachegada'];
	$ValorReferencia    = str_replace(",",".",$_GET['valor']);*/
	$ValorReferencia    = str_replace(",",".",$ValorReferenciaAux);

	//$Desconto				= $_GET['desconto'];
	$PercentualRecebido		= str_replace(",",".",$PercRecebido);
	//$FuncaoDesenpenhada	= $_GET['Funcao'];
	//$ValorAnterior			= $_GET['ant'];
	//$Complemento			= $_GET['complemento'];

	/*$_SESSION['DataPartida'] = $DataPartida;
	$_SESSION['HoraPartida'] = $HoraPartida;
	$_SESSION['DataChegada'] = $DataChegada;
	$_SESSION['HoraChegada'] = $HoraChegada;*/

	$Diaria60 = 0;


    //calcula a diferenca entre as horas
    // Divide a hora
    $HoraP = explode(":",$HoraPartida);
    $HoraC = explode(":",$HoraChegada);

    // Divide a data
    $DataP = explode("/", $DataPartida);
    $DataC = explode("/", $DataChegada);

    // Transforma em segundo
    $MinutoPartida = mktime($HoraP[0], $HoraP[1], "00", $DataP[1], $DataP[0], $DataP[2]);
    $MinutoChegada = mktime($HoraC[0], $HoraC[1], "00", $DataC[1], $DataC[0], $DataC[2]);

    // Transforma em minutos
    $difMinutos = ($MinutoChegada - $MinutoPartida)/60;

    // Diferen√ßa em dias
    $difDias = $difMinutos/1440;

    // Trunca o numero de dias ..
    $NumeroDia = intval($difDias);

    $DiariaResto = $difMinutos - (1440*$NumeroDia);


	/*******************************************************************************
	//Data: 27/07/2015
	//Coment·rio: alteraÁ„o a pedido da DF
	*******************************************************************************/
	$DataPartidaTemp	= ConverteDataBanco($DataPartida);

	// VERIFICA SE A DATA DE PARTIDA … MENOR QUE A DATA DO DECRETO (N∫ 16.220 DE 24 DE JULHO DE 2015) E PUBLICA«√O 25 DE JULHO DE 2015 - VARI¡VEL GLOBAL
	if (strtotime($DataPartidaTemp) < strtotime($dataDecreto)) {

		//07_11_2013 maior igual a 6:00 e menor igual a 12:00
		if (($DiariaResto >= 360) && ($DiariaResto <= 720)) //se horas entre 6:00 e 12:00
		{
			$Percentual = ".4";
		}
		elseif (($DiariaResto > 720) && ($DiariaResto < 1440))//se horas entre 12:01 e 23:59
		{
			$Percentual = ".6";
			$Diaria60 = 1;
		}
		else	//se horas menor que 5:59 ou igual a 24:00
		{
			$Percentual = "";
		}
		
		//$Percentual40 = "0.4";
		$PercentualComplemento = "0.4";

	}else{

		If ($DiariaResto > 600) //se horas superior 10:00
		{
			$Percentual = ".5";
			$Diaria60 = 1;
		}
		Else//sen„o horas menor/igual que 10:00
		{
			$Percentual = "";
		}

		//$Percentual40 = "0.5";
		$PercentualComplemento = "0.5";	
	
	}


    $NumeroDiarias 	= $NumeroDia.$Percentual;

    //calculo de acordo com o roteiro
    if (($PercentualRecebido != 0)||($PercentualRecebido != "")||($PercentualRecebido != 1))
    {
        $ValorReferencia = (double)($ValorReferencia) + ((double)($ValorReferencia) * (double)($PercentualRecebido));
    }
    elseif ($PercentualRecebido == 1)
    {
        $ValorReferencia = (double)($ValorReferencia) + (double)($ValorReferencia);
    }

    if ($FuncaoDesenpenhada == 3)
    {
        $PercentualPrecursor = "*70% : ";
        //CASO A VIAGEM SEJA DE UM PRECURSOR MULTIPLICA POR 70% CONFORME O DECRETO.
        $ValorReferencia = ((double)($ValorReferencia)) * ((double)('0.7'));
      //Cometado para atender solicitaÁ„o da governadoria no caso - Diarias cheia para precurso = 70% de 202,00 = 141,40   06/03/2013
     //$ValorReferencia = round($ValorReferencia);
    }
    else if (($FuncaoDesenpenhada == 1)|| ($FuncaoDesenpenhada == 2))
    {
        $PercentualRepresentante = "*100% : ";
        //CASO A VIAGEM SEJA DE UM PRECURSOR MULTIPLICA POR 100% CONFORME O DECRETO.
        $ValorReferencia = ((double)($ValorReferencia)) * ((double)('1'));
		$ValorReferencia = round($ValorReferencia);
    }
    else
    {
        $PercentualRepresentante	= "";
        $PercentualPrecursor		= "";
		$ValorReferencia			= round($ValorReferencia);
    }
    //Cometado para atender solicitaÁ„o da governadoria no caso - Diarias cheia para precurso = 70% de 202,00 = 141,40  06/03/2013
    //$ValorReferencia = round($ValorReferencia);

    $ValorTotal	= (double)($ValorReferencia) * (double)($NumeroDiarias);

    if ($Desconto == "S")//se checkbox desconto 50% marcado
    {
        $ValorTotal = $ValorTotal/2;
    }

    // Resolveu o problema do calculo equivocado ..
    $ValorAnterior	= str_replace("R$","",$ValorAnterior);
    $ValorAnterior	= str_replace(".","",$ValorAnterior);
    $ValorAnterior	= str_replace(",",".",$ValorAnterior);
    $ValorTotal 	= str_replace(",",".",$ValorTotal);

    $ValorComprovado = ((double)($ValorTotal)) - ((double)($ValorAnterior));



    if ($Complemento == 1)
    {
        //$Percentual40 = "0.4";
        //$ValorDiaria60 = $ValorReferencia * (double)($Percentual40);
		$ValorDiaria60 = $ValorReferencia * (double)($PercentualComplemento);

        if ($Desconto == "S")//se checkbox desconto 50% marcado
        {
            $ValorDiaria60 = $ValorDiaria60/2;
        }
        //$NumeroDiarias	= $NumeroDiarias + (double)($Percentual40);
		$NumeroDiarias	= $NumeroDiarias + (double)($PercentualComplemento);
        $ValorTotal		= $ValorTotal + (double)($ValorDiaria60);

        $ValorComprovado = (double)($ValorTotal) - (double)($ValorAnterior);
    }
    //ESSE PERCENTUAL … O PERCENTUAL DO ROTEIRO.
    /*$_SESSION['PercentualRecebido'] = $PercentualRecebido;
    $_SESSION['NumeroDiarias']      = $NumeroDiarias;
    $_SESSION['ValorTotal']         = $ValorTotal;*/


    if (substr($ValorComprovado,0,1) == "-")
    {
        $ValorComprovado	= (-1)*$ValorComprovado;
        $Restituir			= $ValorComprovado;
    }
    else
    {
        $Receber			= $ValorComprovado;
    }



	$Valor					= trim(str_replace("R$ ","",$Valor));
	$ValorRef				= trim(str_replace("R$ ","",$ValorRef));

	$PercentualRecebido_Aux = $PercentualRecebido*100;
	$PercentualRefCalc_Aux	= "+".$PercentualRecebido_Aux."% ".number_format($ValorReferencia, 2, ',', '.');
	
        
        
        //alteraÁ„o 25/08/2015
        $valorFloat = (float)  str_replace(',', '.', $Valor);
        $ValorTotalFloat = (float)$ValorTotal;
        
	//remover 
	//$PercentualRefCalc = str_replace("\xA0", ' ', html_entity_decode($PercentualRefCalc));

	echo "ValorComprovado = ".$ValorComprovado."<br><br>";
	echo "Datas = ".$DataPartida."-".$HoraPartida."---------".$DataChegada."-".$HoraChegada."<br><br>";

	echo "PercentualRefCalc = ".$PercentualRefCalc." --------- valida = ".$PercentualRefCalc_Aux."<br><br>";
	echo "Qtde = ".$Qtde." --------- valida = ".$NumeroDiarias."<br><br>";
	echo "Valor = ".$valorFloat." --------- valida = ".$ValorTotalFloat."<br><br>";
	echo "ValorRef = ".$ValorRef." --------- valida = ".number_format($ValorReferencia, 2, ',', '.')."<br><br>";
	
	echo "ValorRestituir = ".$ValorRestituir." --------- valida = ".number_format($Restituir, 2, ',', '.')."<br><br>";
	echo "ValorReceber = ".$ValorReceber." --------- valida = ".number_format($Receber, 2, ',', '.');
        
       // exit;
     
	/*
        //pega dados da diaria
        $sql = "select * from diaria.diaria where diaria_id = $Codigo";
        $rs = pg_query(abreConexao(), $sql);
        
        $linha = pg_fetch_assoc($rs);
        */
        
       
        
	if	(($PercentualRefCalc        == $PercentualRefCalc_Aux) && 
		($Qtde			    == $NumeroDiarias) && 
		($valorFloat		    == $ValorTotalFloat) && 
		($ValorRef		    == number_format($ValorReferencia, 2, ',', '.')) &&
		($ValorRestituir	    == number_format($Restituir, 2, ',', '.')) &&
		($ValorReceber		    == number_format($Receber, 2, ',', '.')) 
                        or $Codigo == '4418'
                        or $Codigo == '4398' /*erro de comprovaÁıes que usaram reduÁ„o de 50% */
                ){
			//echo "correto!";exit;
			return true;
	}else{
			//echo "<br>incorreto!";exit;
			return false;
	}





}



function f_ComboRelatoriosSalvos($NomeCombo, $codigoEscolhido) {
    echo"<select name=" . $NomeCombo . " id=" . $NomeCombo . " style=width:500px>";
    $sql = "select * from orcamento.consulta where flag_persistencia = 1 and consulta_nm is not null and consulta_nm !=''
            order by consulta_nm";
    $rs = pg_query(abreConexao(), $sql);
    echo "<option value='' selected>.:Selecione:.</option>";
    While ($linha = pg_fetch_assoc($rs)) {

        echo "<option value=" . $linha['consulta_id'] . " >" . $linha['consulta_nm'] . "</option>";
    }
    echo "</select>";
}

function removeAcentos($string, $slug = false) {
  $string = strtolower($string);
  // CÛdigo ASCII das vogais
  $ascii['a'] = range(224, 230);
  $ascii['e'] = range(232, 235);
  $ascii['i'] = range(236, 239);
  $ascii['o'] = array_merge(range(242, 246), array(240, 248));
  $ascii['u'] = range(249, 252);
  // CÛdigo ASCII dos outros caracteres
  $ascii['b'] = array(223);
  $ascii['c'] = array(231);
  $ascii['d'] = array(208);
  $ascii['n'] = array(241);
  $ascii['y'] = array(253, 255);
  foreach ($ascii as $key=>$item) {
    $acentos = '';
    foreach ($item AS $codigo) $acentos .= chr($codigo);
    $troca[$key] = '/['.$acentos.']/i';
  }
  $string = preg_replace(array_values($troca), array_keys($troca), $string);
  // Slug?
  if ($slug) {
    // Troca tudo que n„o for letra ou n˙mero por um caractere ($slug)
    $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
    // Tira os caracteres ($slug) repetidos
    $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
    $string = trim($string, $slug);
  }
  return $string;
}

function rupperRemoveAcentos($str){
    $temp = @str_replace("Ù", "O", str_replace("'", "", strtoupper(strtr($str ,"·ÈÌÛ˙‚ÍÙ„ı‡ËÏÚ˘ÁÈ","AEIOUAEOAOAEIOUCE"))));
    $temp = @str_replace("'", "", strtoupper(strtr($str ,"¡…Õ”⁄¬ ‘√’¿»Ã“Ÿ«","AEIOUAEOAOAEIOUC")));
    
    return trim($temp);
}
function rupper($str){
    $temp = @str_replace("'", "", strtoupper(strtr($str ,"·ÈÌÛ˙‚ÍÙ„ı‡ËÏÚ˘Á","¡…Õ”⁄¬ ‘√’¿»Ã“Ÿ«")));
    
    return trim($temp);
}

function rlower($str){
    $temp = str_replace("'", "", strtolower(strtr($str ,"¡…Õ”⁄¬ ‘√’¿»Ã“Ÿ«","·ÈÌÛ˙‚ÍÙ„ı‡ËÏÚ˘Á")));
    
    return trim($temp);
}

function trataHtmlCompromisso($str){NBSP;
    $temp = rupper($str);
    $temp = str_replace('&NBSP;', " ", $temp);
    $temp = str_replace('NULL', " ", $temp);
    //$temp = str_replace('PAUTA:', " ", $temp);
    $str = rlower($str);
    $temp = str_replace('&amp;', " ", $temp);
    $str = rupper($str);
    $temp = str_replace('&AMP;', " ", $temp);
    $temp = str_replace("NBSP;", " ", $temp);
    $temp = str_replace('NBSP', " ", $temp);
    $temp = str_replace('&', " ", $temp);
    //$temp = str_replace("&nbsp;", " ", $temp);
    
    return ($temp);
}

function echo_pre($sql){
    echo '<pre>'.($sql).'</pre>';
}



function montaNumeroSolicitacao($esquema, $tabela,$tamanhoNumero=null){
    //valor padr„o
    if(empty($tamanhoNumero)){
        $tamanhoNumero = 9;
    }
    $tamanhoNumero = $tamanhoNumero - 4;/*ex:2015*/
    $sql        = "select max($tabela"."_id) as id from $esquema.$tabela ";
    //ECHO $sql.'<br>';
    $rs         = pg_query(abreConexao(), $sql);
    $linha      = pg_fetch_assoc($rs);
    $idMax      = $linha['id'] + 1;
    $qnt = strlen($idMax);
    for($i=0;$i<($tamanhoNumero-$qnt);$i++){
        $zeros .='0'; 
    }
    return  $sdNumero = date('Y').$zeros.$idMax;
}


function valorPorExtenso($valor=0, $complemento=true) {
	$singular = array("centavo", "real", "mil", "milh„o", "bilh„o", "trilh„o", "quatrilh„o");
	$plural = array("centavos", "reais", "mil", "milhıes", "bilhıes", "trilhıes","quatrilhıes");
 
	$c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
	$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
	$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
	$u = array("", "um", "dois", "trÍs", "quatro", "cinco", "seis","sete", "oito", "nove");
 
	$z=0;
 
	$valor = number_format($valor, 2, ".", ".");
	$inteiro = explode(".", $valor);
	for($i=0;$i<count($inteiro);$i++)
		for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
			$inteiro[$i] = "0".$inteiro[$i];
 
	// $fim identifica onde que deve se dar junÁ„o de centenas por "e" ou por "," ?
	$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
	for ($i=0;$i<count($inteiro);$i++) {
		$valor = $inteiro[$i];
		$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
		$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
		$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
	
		$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
		$t = count($inteiro)-1-$i;
		if ($complemento == true) {
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
		}
		if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
	}
 
	return($rt ? $rt : "zero");
}


function montaNumProcessoAdiantamento($solicitacao_id){
    
$sql = " select * from documento.cid_numero";

/*
//echo $sql;exit;
$rs = pg_query(abreConexao(), $sql);

"1540 ANO [000000]--";
'1540201600000042A';
'1540201600000042';
'15402016000042A'
if($linhars = pg_fetch_assoc($rs)){
    $mascara_cid =   $linhars['mascara_cid'];
}
*/
$mascara_cid = '1540';
$ano = date('Y');
$ano = date('Y');
$ano = substr($ano, 2,2);

//pega a parte dos numero
$temp = explode(' ',$mascara_cid);
$numeros = str_replace(']','',  str_replace('[','',$temp[2]));

//000000--8-2
$numeros = $mascara_cid.$ano;

//echo $numeros.strlen(trim((string)$numeros)) .'-'.  strlen($solicitacao_id);
//exit;

//echo strlen($numeros);
for($i=0;$i<(strlen($numeros)  -  strlen($solicitacao_id));$i++){
    $zeros .='0';
}
//$zeros = '000';
//montando processo
return $processo_numero = $temp[0].$ano.$zeros.$solicitacao_id.'RA';   
}


function verificaFerias($beneficiario_id, $txtDataPartida, $txtDataChegada){
    
    if(empty($txtDataChegada)){
        $txtDataChegada = $txtDataPartida;
    }
    
    //verifica se o beneficiario esta de ferias
    $sql = "select * from dados_unico.evento_agenda ea 
	inner join dados_unico.evento e
		on e.evento_id = ea.evento_id 
        where e.evento_tipo_id = 2/*ferias*/
            and 
                    (
                    '".dataToDB($txtDataPartida)."' between ea.data and ea.data + ea.dias  -1
                        or 
                     '".dataToDB($txtDataChegada)."' between ea.data and ea.data + ea.dias -1 
                    )
             and e.pessoa_id =     $beneficiario_id   
             ";
    //echo_pre($sql);exit;
    $R = pg_query(abreConexao(), $sql);
    $quant = (int)pg_num_rows($R);
    if($quant>0){
         return false;
    }else{
        return true;
    }
    
}

function br($quant){
    for($i=0;$i<$quant;$i++){
        $var .= "<br>"; 
    }
    return $var;
}


function retornaDiaSemanaGlobal($data) {
    if (!empty($data)) {
        setlocale(LC_ALL, 'pt_BR', 'ptb');
        //print strftime("%A, %d de %B de %Y", strtotime($data)); 
        return ucfirst(strftime("%A", strtotime($data)));
    } else {
        return '';
    }
}




function trataNull($campo){
    
    $campo = empty($campo)? 'null' : "'" . str_replace("'", '', trim($campo)) . "'";
    
    return $campo; 
}



function f_PassageirosTransporte($solicitacao_id){
    
   $sql = "select p.* from transporte.passageiro ps
                inner join dados_unico.pessoa p
                        on p.pessoa_id = ps.pessoa_id where ps.solicitacao_id =  ".(int)$solicitacao_id;
   
   //echo_pre($sql);
   $rs=pg_query(abreConexao(),$sql);
   $passageiros = '';
   $p=0;
   if ($linha=pg_fetch_assoc($rs)){
       if($p==0){
            $passageiros .=  $linha['pessoa_nm'];
       }else{
            $passageiros .= ', '.$linha['pessoa_nm'];
       }
        $p++;
   }
   
   return $passageiros;
} 

function f_ComboChamadoTecnicos($nome,$javaScript,$tamanho)
{ echo "<select name='$nome' id='$nome' onchange='$javaScript'  style='width:$tamanho'>";
  $sql = "
select distinct p.* from seguranca.tipo_usuario tu
inner join seguranca.sistema s 
	on s.sistema_id = tu.sistema_id
	

inner join seguranca.usuario_tipo_usuario utu
	on utu.tipo_usuario_id = tu.tipo_usuario_id 
inner join dados_unico.pessoa p
	on p.pessoa_id = utu.pessoa_id
where s.sistema_id=38/*sati*/ and tu.tipo_usuario_id != 154/*solicitante*/";
  $rs=pg_query(abreConexao(),$sql);
  echo "<option value=''>.:Selecione:.</option>";
  While ($linha=pg_fetch_assoc($rs)){
    $codigo = $linha ['pessoa_id'];
    $descricao = $linha ['pessoa_nm'];
    echo "<option value=".$codigo. ">".$descricao."</option>";
    
  }
  echo "</select>";
}