<?php

global    $path_serv, $xss, $regStatus, $regStatusRequisicaoReprografia, $regMeses, $convert, $dataDecreto, $urlArquivoBaseOrcamento, $urlArquivoContrato, $urlArquivoAnexoMalaDireta, $urlArquivoAnexoAcompanhamento, $urlArquivoAnexoEnvioDocumento, $urlArquivoQuestionario, $urlArquivoConvitePassagem, $urlArquivosDiaria, $maxSolicitacaoPass, $arrDotacaoOrcamentaria, $tituloPagina, $hrInicioExpediente, $hrFimExpediente, $hrInicioAlmoco, $hrFimAlmoco, $tituloPagina, $Keywords, $maxSolicitacaoPass, $metaPagina, $ipServer, $ipServerEmpty, $ipServerExterno, $ipServerExternoEmpty, $arrMes30, $arrMes31, $globalVlrTicketAlimentacao, $tituloPagina2, $arrHoras;

$ipServer                   = 'https://127.0.0.1/';
$ipServerEmpty              = '127.0.0.1';
$ipServerExterno            = 'https://www.portalsema.ba.gov.br/';
$ipServerExternoEmpty       = 'www.portalsdr.ba.gov.br';
$ipServerExternoNm          = 'www.portalsdr.ba.gov.br/';
$globalVlrTicketAlimentacao = 12.0;
$dt_implantacao_sei         = '2018-02-27';


$hrInicioExpediente         = '08:30'; //para o modulo de transporte
$hrFimExpediente            = '18:00'; //para o modulo de transporte
$hrInicioAlmoco             = '12:01'; //para o modulo de transporte
$hrFimAlmoco                = '13:30'; //para o modulo de transporte
$metaPagina                 = "Desenvolvimento Rural, Secretaria de Desenvolvimento Rural, SDR, SDR BA, SDR-BA";
$tituloPagina               = "SDR - Secretaria de Desenvolvimento Rural";
$tituloPagina2              = "Secretaria de Desenvolvimento Rural";
$Keywords                   = "Rural, Secretaria de Desenvolvimento Rural, Estadual, Bahia, SDR, SDR BA, SDR-BA";
$maxSolicitacaoPass         = 8; //maximo de solicita��es de passagens
$path_serv                  = "E:\\xampp5\\htdocs\\_portal\\";




//$path_serv = "E:\\xampp8\\htdocs\\GestorSeplan\\";
//include_once($path_serv."Util/xss/Input.php");
include_once($path_serv . "Lib/fwConvert.php");


$urlArquivoBaseOrcamento = $path_serv . "IncludePhp\\excel_reader2\\arquivos_base_orcamento\\";
$urlArquivosExcelReader = $path_serv . "IncludePhp\\excel_reader2\\";

$urlArquivoAnexoMalaDireta = $path_serv . "SistemaContatoMalaDireta\\anexos\\";


$urlArquivoAnexoAcompanhamento = $path_serv . "anexos\\anexo_acompanhamento\\";
$urlArquivoAnexoEnvioDocumento = $path_serv . "anexos\\anexo_envio_documento\\";
$urlArquivoConvitePassagem     = $path_serv . "anexos\\anexo_convite_passagem\\";
$urlArquivosDiaria             = $path_serv . "anexos\\anexo_diaria\\";

$urlArquivoContrato            = $path_serv . "anexos\\anexo_contrato\\";
$urlArquivoQuestionario        = $path_serv . "anexos\\anexo_questionario\\";


$xss        = null; //new CI_Input();
$convert    = null; //new Convert();


//INCLUINDO AS CONFIGURA��ES B�SICAS DOS SISTEMAS.
include_once 'funcoes.php';
include_once 'Inc_Conexao.php';
include_once 'Inc_Funcao.php';
include_once 'Inc_FuncaoCombo.php';
include_once 'Inc_FuncaoDiarias.php';
include_once 'Inc_FuncaoReservas.php';
include_once 'Inc_FuncaoExibe.php';
include_once 'Inc_ComboDiaria.php';
include_once 'Inc_ComboPassagem.php';





$gmtDate = gmdate("D, d M Y H:i:s");
@header("Content-Type: text/html; charset=ISO-8859-1", true);
@header("Expires: {$gmtDate} GMT");
@header("Last-Modified: {$gmtDate} GMT");

@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
@header("Cache-Control: no-cache");
@header("Pragma: no-cache");

//if($_SESSION['pessoa_id'] == ""){header("Location: ../Home/Login.php");}

$AcaoSistema = empty($_GET['acao']) ? null : $_GET['acao'];

if (isset($_POST['txtFiltro']) && (trim($_POST['txtFiltro']) != "")) {
    //RETIRA OS CARACTERES DE ESPA�O ANTERIORES E POSTERIORES
    $_SESSION["Busca"] = trim($_POST['txtFiltro']);
}

if (!$_GET) {
    $_SESSION["Busca"] = "";
}

$buscar = empty($_SESSION["Busca"]) ? '' : $_SESSION["Busca"];
$RetornoFiltro = $buscar;

$nocheck = empty($_REQUEST['nocheck']) ? 0 : (int)$_REQUEST['nocheck'];
/*if ($nocheck == 0) {//echo 'para';exit;
    if (isset($_GET["sistema"]) && !checaAcesso($_GET["sistema"])) {
        //echo 0;exit;
        if (($_GET["sistema"] == "5") || ($_GET["sistema"] == "6")) {
            //echo 1;exit;
            header("Location: ../../Home/Home.php");
        } else {
            //echo 2;exit;
            header("Location: ../Home/Home.php");
        }
    }
}*/

//VARI�VEL QUE RETORNAR� A MENSAGEM DE ERRO PADR�O QUANDO N�O HOUVER REGISTROS NA BUSCA.
$MsgRegistroVazio = ":: Registro(s) n&atilde;o encontrado(s) ::";

//VARI�VEL QUE ARMAZENAR� O ERRO RETORNADO PELO BANCO DE DADOS.
$MensagemErroBD = "";

//ESTA VARI�VEL SERVE PARA DEFINIR A QUANTIDADE DE REGISTROS QUE SER�O EXIBIDOS NA PAGINA��O
$iPageSize = 16;

//array que define os status dos registros
$regStatus = array(
    0 => 'Ativo',
    1 => 'Inativo',
    2 => 'Excluido'
);


//array que define os status dos requisi��es de servi�o a repografia
$regStatusRequisicaoReprografia = array(
    0 => 'Aguardando Autoriza��o',
    1 => '',
    2 => 'Excluido',
    3 => '',
    5 => 'Realizado',
    7 => 'N�o Realizado',
    4 => 'Autorizado',
    6 => 'N�o Autorizado',
    8 => 'Todos'

);

//array com os meses do ano
$regMeses = array(
    1 => 'Janeiro',
    2 => 'Fevereiro',
    3 => 'Mar�o',
    4 => 'Abril',
    5 => 'Maio',
    6 => 'Junho',
    7 => 'Julho',
    8 => 'Agosto',
    9 => 'Setembro',
    10 => 'Outubro',
    11 => 'Novembro',
    12 => 'Dezembro'
);


//array de horas
$arrHoras = array(
    1 => '00:01',
    2 => '00:30',
    3 => '01:00',
    4 => '01:30',
    5 => '02:00',
    6 => '02:30',
    7 => '03:00',
    8 => '03:30',
    9 => '04:00',
    10 => '04:30',
    11 => '05:00',
    12 => '05:30',
    13 => '06:00',
    15 => '06:30',
    16 => '07:00',
    17 => '07:30',
    18 => '08:00',
    19 => '08:30',
    20 => '09:00',
    21 => '09:30',
    22 => '10:00',
    23 => '10:30',
    24 => '11:00',
    25 => '11:30',
    26 => '12:00',
    27 => '12:30',
    28 => '13:00',
    29 => '13:30',
    30 => '14:00',
    31 => '14:30',
    32 => '15:00',
    33 => '15:30',
    34 => '16:00',
    35 => '16:30',
    36 => '17:00',
    37 => '17:30',
    38 => '18:00',
    39 => '18:30',
    40 => '19:00',
    41 => '19:30',
    42 => '20:00',
    43 => '20:30',
    44 => '21:00',
    45 => '21:30',
    46 => '22:00',
    47 => '22:30',
    48 => '23:00',
    49 => '23:59'
);


$arrDotacaoOrcamentaria = array(
    'exercicio' => 'Exerc�cio',
    'poder_cod' => 'C�digo do Poder',
    'poder_nm' => 'Nome do Poder',
    'orgao_cod' => 'C�digo do �rg�o',
    'orgao_nm' => 'Nome do �rg�o',
    'orgao_sigla' => 'Sigla do �rg�o',
    'uo_cod' => 'C�digo da UO',
    'uo_nm' => 'Nome da UO',
    'uo_sigla' => 'Sigla da UO',
    'ug_cod' => 'C�digo da UG',
    'ug_nome' => 'Nome da UG',
    'ug_sigla' => 'Sigla da UG',
    'orgao_destino_cod' => 'C�digo do �rg�o de Destino',
    'orgao_destino_nm' => 'Nome do �rg�o de Destino',
    'orgao_destino_sigla' => 'Sigla do �rg�o de Destino',
    'uo_destino_cod' => 'C�digo da UO Destino',
    'up_destino_nm' => 'Nome da UO Destino',
    'up_destino_sigla' => 'Sigla da UO Destino',
    'ug_destino_cod' => 'C�digo da UG Destino',
    'ug_destino_nm' => 'Nome da UG Destino',
    'ug_destino_sigla' => 'Sigla da UG Destino',
    'udp_cod' => 'C�digo da USP',
    'usp_nm' => 'Nome da USP',
    'usp_sigla' => 'Sigla da USP',
    'acao_tipo' => 'Tipo da A��o',
    'acao_cod' => 'C�digo da A��o',
    'acao_nm' => 'Nome da A��o',
    'acao_sigla' => 'Sigla da A��o',
    'acao_objetivo' => 'Objetivo da A��o',
    'acao_classificacao' => 'Classifica��o da A��o',
    'acao_detalhamento' => 'Detalhamento da A��o',
    'esfera_orcamentaria' => 'Esfera Or�ament�ria',
    'funcao_cod' => 'C�digo da Fun��o',
    'funcao_nm' => 'Nome da Fun��o',
    'funcao_sigla' => 'Sigla da Fun��o',
    'subfuncao_cod' => 'C�digo da Subfun��o',
    'subfuncao_nm' => 'Nome da Subfun��o',
    'subfuncao_sigla' => 'Sigla da Subfun��o',
    'programa_cod' => 'C�digo do Programa',
    'programa_nm' => 'Nome do Programa',
    'programa_sigla' => 'Sigla do Programa',
    'estrutura_estrategica_cod' => 'C�digo da Estrutura Estrat�gica',
    'estrutura_estrategica_nm' => 'Nome da Estrutura Estrat�gica',
    'produto_cod' => 'C�digo do Produto',
    'produto_nm' => 'Nome do Produto',
    'produto_sigla' => 'Sigla do Produto',
    'unidade_medida_cod' => 'C�digo da Unidade de Medida',
    'unidade_medida_nm' => 'Nome da Unidade de Medida',
    'unidade_medida_sigla' => 'Sigla da Unidade de Medida',
    'regiao_cod' => 'C�digo da Regi�o',
    'regiao_nm' => 'Nome da Regi�o',
    'destinacao_cod' => 'C�digo da Destina��o',
    'identificado_uso_cod' => 'C�digo do Identificador de Uso',
    'fonte_cod' => 'C�digo da Fonte',
    'fonte_nm' => 'Nome da Fonte',
    'fonte_sigla' => 'Sigla da Fonte',
    'subfonte_cod' => 'C�digo da Subfonte',
    'subfonte_nm' => 'Nome da Subfonte',
    'subfonte_sigla' => 'Sigla da Subfonte',
    'natureza_cod' => 'C�digo da Natureza',
    'natureza_nm' => 'Nome  da Natureza',
    'natureza_sigla' => 'Sigla da Natureza',
    'categoria_cod' => 'C�digo da Categoria',
    'categoria_economica_nm' => 'Nome  da Categoria Econ�mica',
    'grupo_cod' => 'C�digo do Grupo',
    'grupo_nm' => 'Nome do Grupo',
    'grupo_sigla' => 'Sigla do Grupo',
    'modalidade_cod' => 'C�digo da Modalidade',
    'modalidade_nm' => 'Nome da Modalidade',
    'modalidade_sigla' => 'Sigla da Modalidade',
    'elemento_codigo' => 'C�digo do Elemento',
    'elemento_nm' => 'Nome do Elemento',
    'elemento_sigla' => 'Sigla do Elemento',
    'valor_orcado_inicial' => 'Valor Or�ado Inicial',
    'valor_suplemento' => 'Valor Suplementado',
    'valor_anulado' => 'Valor Anulado',
    'valor_atual' => 'Valor Atual ',
    'valor_descentralizado' => 'Valor Descentralizado',
    'valor_bloqueado' => 'Valor Bloqueado',
    'valor_contigenciado' => 'Valor Contingenciado',
    'valor_ped' => 'Valor PED',
    'valor_empenhado' => 'Valor Empenhado',
    'valor_liquidado' => 'Valor Liquidado',
    'valor_pago' => 'Valor Pago'
);




$arrStatusDiaria = array(
    '-1' => 'Aguardando Libera��o',
    '0' => 'Aguardando Autoriza��o',
    '22' => 'Aguardando Projeto/Atividade',
    '1' => 'Aguardando Aprova��o',
    '21' => 'Aguardando Concess�o',
    '2' => 'Aguardando Empenho',
    '23' => 'Aguardando Empenho(Libera��o)',
    '3' => 'Aguardando Pagamento',
    '4' => 'Aguardando Comprova��o',
    '5' => 'Comprova��o Pendente acima 5 dias',
    '6' => 'Aguardando 2� Empenho',
    '24' => 'Aguardando 2� Empenho(Libera��o)',
    '7' => 'Aguardando 2� Pagamento',
    '8' => 'Em An�lise',
    '9' => 'Conclu�da'




);
//add o bootstrap em todas as telas, includive nos modulos legados
//include "Inc_cssBootstrap.php";


function validarSqlInjectionGestorAntigo($input)
{
    // Converte o input para string para evitar problemas com tipos de dados diferentes
    $input = (string) $input;

    // Express�es regulares para detectar poss�veis SQL Injection
    $patterns = [
        '/select\s+/i',      // detecta SELECT
        '/insert\s+/i',      // detecta INSERT
        '/update\s+/i',      // detecta UPDATE
        '/delete\s+/i',      // detecta DELETE
        '/drop\s+/i',        // detecta DROP
        '/union\s+/i',       // detecta UNION
        '/--/i',             // detecta -- (coment�rio em SQL)
        '/\b(=|<|>|;|\*|\/|--|\')\b/', // detecta operadores e caracteres especiais
        '/\/\*/i',           // detecta /* (coment�rio em SQL)
        '/\*\/\*/i'          // detecta */ (coment�rio em SQL)
    ];

    // Verifica o input para padr�es SQL
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            echo "algo suspeito favor entrar em contato com a APG";
             exit;
            //return false;  // Encontrou algo suspeito
        }
    }


    return $input;
}
