<?php

function arrayToString(array $campos): string {
    return implode(', ', $campos);
}
###########################################################################################################################################################################################
##SEGURAN�A################################################################################################################################################################################
###########################################################################################################################################################################################
function ULTIMA_CONSULTA($exit = false)
{
    $ci = @get_instance();


    @echo_pre(@$ci->db->last_query());
    if ($exit == true) {
        exit;
    }
}

/**
  * Valida se o IP de acesso � do Brasil usando ranges de IPs brasileiros
 * @param bool $validacao_ativa Flag para ativar/desativar a valida��o
 * @return void
 */
function VALIDA_ACESSO_BRASIL($validacao_ativa = false)
{
    //se desativa, nao precisa validar
    if ($validacao_ativa == false) {
        return;
    }

    $ip = $_SERVER['REMOTE_ADDR'];

    // Ignora IPs locais
    if ($ip == '127.0.0.1' || $ip == '::1' || $ip == '10.63.30.83' || $ip == '192.168.1.103') {
        return;
    }

    // Lista completa de ranges de IP do Brasil
    $ranges_brasil = [
        // Grandes provedores e operadoras
        ['177.0.0.0', '177.255.255.255'],    // Claro/NET/Embratel
        ['179.0.0.0', '179.255.255.255'],    // Vivo/Telef�nica
        ['186.192.0.0', '186.255.255.255'],  // Oi/Brasil Telecom
        ['187.0.0.0', '187.255.255.255'],    // Claro/NET
        ['189.0.0.0', '189.255.255.255'],    // Vivo/GVT
        ['191.0.0.0', '191.255.255.255'],    // Diversos provedores

        // Faixas governamentais e educacionais
        ['143.106.0.0', '143.106.255.255'],  // UNICAMP
        ['143.54.0.0', '143.54.255.255'],    // UFRGS
        ['161.24.0.0', '161.24.255.255'],    // Governo
        ['164.41.0.0', '164.41.255.255'],    // UnB
        ['200.0.0.0', '200.255.255.255'],    // Diversos
        ['201.0.0.0', '201.255.255.255'],    // Diversos

        // Operadoras m�veis
        ['138.0.0.0', '138.255.255.255'],    // TIM
        ['139.82.0.0', '139.82.255.255'],    // Oi M�vel
        ['170.66.0.0', '170.66.255.255'],    // Vivo M�vel
        ['170.238.0.0', '170.238.255.255'],  // Claro M�vel

        // Provedores regionais
        ['152.84.0.0', '152.84.255.255'],
        ['155.211.0.0', '155.211.255.255'],
        ['157.86.0.0', '157.86.255.255'],
        ['158.108.0.0', '158.108.255.255'],
        ['160.19.0.0', '160.19.255.255'],
        ['163.136.0.0', '163.136.255.255'],
        ['164.85.0.0', '164.85.255.255'],
        ['166.143.0.0', '166.143.255.255'],
        ['170.245.0.0', '170.245.255.255'],

        // Ranges adicionais
        ['168.0.0.0', '168.255.255.255'],
        ['169.57.0.0', '169.57.255.255'],
        ['173.192.0.0', '173.192.255.255'],
        ['198.0.0.0', '198.255.255.255'],
        ['204.0.0.0', '204.255.255.255'],

        // IPv4 adicionais Brasil
        ['45.160.0.0', '45.175.255.255'],
        ['131.0.0.0', '131.255.255.255'],
        ['132.255.0.0', '132.255.255.255'],
        ['139.82.0.0', '139.82.255.255'],
        ['152.92.0.0', '152.92.255.255'],
        ['153.92.0.0', '153.92.255.255'],
        ['155.211.0.0', '155.211.255.255'],
        ['157.86.0.0', '157.86.255.255'],
        ['158.108.0.0', '158.108.255.255'],
        ['164.41.0.0', '164.41.255.255'],
        ['164.85.0.0', '164.85.255.255'],
        ['170.150.0.0', '170.150.255.255'],
        ['170.239.0.0', '170.239.255.255'],
        ['170.245.0.0', '170.245.255.255'],
        ['177.0.0.0', '177.255.255.255'],
        ['179.0.0.0', '179.255.255.255'],
        ['186.192.0.0', '186.255.255.255'],
        ['187.0.0.0', '187.255.255.255'],
        ['189.0.0.0', '189.255.255.255'],
        ['191.0.0.0', '191.255.255.255'],
        ['192.146.0.0', '192.146.255.255'],
        ['192.147.0.0', '192.147.255.255'],
        ['192.153.0.0', '192.153.255.255'],
        ['192.159.0.0', '192.159.255.255'],
        ['192.197.0.0', '192.197.255.255'],
        ['192.198.0.0', '192.198.255.255'],
        ['192.207.0.0', '192.207.255.255'],
        ['192.231.0.0', '192.231.255.255'],
        ['192.251.0.0', '192.251.255.255'],
        ['198.17.0.0', '198.17.255.255'],
        ['198.49.0.0', '198.49.255.255'],
        ['198.58.0.0', '198.58.255.255'],
        ['200.0.0.0', '200.255.255.255'],
        ['201.0.0.0', '201.255.255.255']
    ];

    $ip_long = ip2long($ip);
    $is_ip_brasil = false;

    foreach ($ranges_brasil as $range) {
        $min = ip2long($range[0]);
        $max = ip2long($range[1]);

        if ($ip_long >= $min && $ip_long <= $max) {
            $is_ip_brasil = true;
            break;
        }
    }

    if (!$is_ip_brasil) {
        error_log('Tentativa de acesso de IP n�o brasileiro: ' . $ip);
        echo 'Acesso permitido apenas para IPs do Brasil';
        exit;
    }
}
function PROTECAO_LOGIN($validar_pagina = true)
{
    if (empty($_SESSION['pessoa_id']) and $validar_pagina == true) {
        //echo "<script> alert('Favor realizar o login novamente')</script>";
        redirect("https://www.portalsema.ba.gov.br/_portal/Intranet/usuario");
    }
}
function PROTECAO_DDOS($limit = 60, $window = 60)
/**roda no construtor do CI_Controller em Controller.php */
{
    $ip = $_SERVER['REMOTE_ADDR']; // Obt�m o IP do visitante

    // Inicializa o array de controle na sess�o, se necess�rio
    if (!isset($_SESSION['rate_limit'])) {
        $_SESSION['rate_limit'] = [];
    }

    // Inicializa os dados para o IP atual, caso n�o exista
    if (!isset($_SESSION['rate_limit'][$ip])) {
        $_SESSION['rate_limit'][$ip] = [
            'count' => 0, // Contador de requisi��es
            'start_time' => time(), // Tempo inicial do per�odo
        ];
    }

    // Dados do IP atual
    $data = &$_SESSION['rate_limit'][$ip]; // Refer�ncia para os dados do IP
    $current_time = time(); // Hora atual

    // Verifica se o intervalo da janela expirou
    if ($current_time - $data['start_time'] > $window) {
        // Reinicia a contagem e o tempo da janela
        $data['count'] = 1;
        $data['start_time'] = $current_time;
        return false; // N�o excedeu o limite
    }

    // Incrementa o contador de requisi��es
    $data['count']++;

    // Verifica se o limite foi excedido
    if ($data['count'] > $limit) {
        // Limite excedido: retorna erro 429
        header('HTTP/1.1 429 Too Many Requests');
        echo "Voc� foi bloqueado por excesso de requisi��es.";
        exit; // Interrompe a execu��o do script
    }

    return false; // N�o excedeu o limite
}
function removerAcentos($string)
{
    $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string); // Remove acentos de forma segura
    return trim(preg_replace('/[^\p{L}\p{N}\s]/u', '', $string)); // Remove caracteres n�o alfanum�ricos
}
//recebe array com os  perfils q tem acesso ao controller
function PROTECAO_PERFIL($array)
{
    $perfil_logado = empty($_SESSION['perfil']) ? null : $_SESSION['perfil'];
    if (empty($perfil_logado)) {
        redirect("https://www.portalsema.ba.gov.br");
        // echo "perfil n�o informado";
        exit;
    }
    $flag_tem_permissao = 0;
    foreach ($array as $a) {
        //  echo rupper($a) ."-".rupper($perfil_logado)."<br>";//exit;

       if (removerAcentos(rupper($a)) == removerAcentos(rupper($perfil_logado))) {
            $flag_tem_permissao  = 1;
        }
    }
    if ($flag_tem_permissao == 0) {
        echo "Voc� n�o tem permiss�o para acessar esta p�gina";
        exit;
    }
}



function VALIDA_IMPUT($input)
{
    // Lista de padr�es comuns de SQL Injection
    $patterns = [
        '/\bUNION\b/i',
        '/\bSELECT\b/i',
        '/\bINSERT\b/i',
        '/\bUPDATE\b/i',
        '/\bDELETE\b/i',
        '/\bDROP\b/i',
        '/\bALTER\b/i',
        '/\bCREATE\b/i',
        '/\bTRUNCATE\b/i',
        '/\bREPLACE\b/i',
        '/\bRENAME\b/i',
        '/\bEXEC\b/i',
        '/\bSHOW\b/i',
        '/\bGRANT\b/i',
        '/\bREVOKE\b/i',
        '/\bCALL\b/i',
        '/\bDESCRIBE\b/i',
        '/\bEXPLAIN\b/i',
        '/\bHANDLER\b/i',
        '/\bLOAD\b/i',
        '/\bLOCK\b/i',
        '/\bUNLOCK\b/i',
        '/\bMERGE\b/i',
        '/\bOR\b/i',
        '/\bAND\b/i',
        '/\bLIKE\b/i',
        '/\bHAVING\b/i',
        '/\bORDER\s+BY\b/i',
        '/\bGROUP\s+BY\b/i',
        '/\bOUTFILE\b/i',
        '/\bINTO\b\s+\bOUTFILE\b/i',
        '/\bINFORMATION_SCHEMA\b/i',
        '/\bDATABASE\s*\(\s*\)/i',
        '/\bUSER\s*\(\s*\)/i',
        '/\bCURRENT_USER\s*\(\s*\)/i',
        '/\bSESSION_USER\s*\(\s*\)/i',
        '/\bVERSION\s*\(\s*\)/i',
        '/\bBENCHMARK\s*\(\s*\)/i',
        '/\bSLEEP\s*\(\s*\)/i',
        //'/(--|#|\/\*)/' , '/\/\*.*?\*\//s', '/#.*\n?/', '/\-\-.*/'
    ];


    $input_validado = $input;
    if (is_array($input)) {
        // Converte o array em uma string separada por espa�os
        $input_validado = implode(' ', $input);
    }
    if (!empty($input_validado)) {
        // Verifica se algum padr�o suspeito existe na entrada
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input_validado)) {
                echo "Existem palavras e/ou caracteres que n�o s�o permitidos no seu cadastro/filtro.";
                exit;
                return false; // Detectado padr�o de SQL Injection
            }
        }
    }

    // Se passou em todas as verifica��es, retorna o valor
    return $input;
}

/**
 * Valida a origem das requisi��es
 * @return void
 */
function VALIDA_ORIGEM_REQUEST()
{
    // Lista de dom�nios permitidos
     $DOMINIOS_PERMITIDOS = [ '10.63.30.83', '192.168.1.103' ,
        'localhost',
        '192.168.1.107',
        'portalsdr.ba.gov.br',
        'www.portalsdr.ba.gov.br'
    ];;

    // Lista de referers permitidos (buscadores)
    $REFERERS_PERMITIDOS = [
        'google.com',
        'www.google.com',
        'bing.com',
        'www.bing.com',
        'yahoo.com',
        'www.yahoo.com',
        'search.yahoo.com',
        'duckduckgo.com',
        'www.duckduckgo.com',
        'yandex.com',
        'sdr.ba.gov.br',
        'ba.gov.br',
        'br.gov.br',
        'www.yandex.com'
    ];

    // Lista de ferramentas de teste proibidas
    $FERRAMENTAS_PROIBIDAS = [
        // Ferramentas de API Testing
        'postman',
        'insomnia',
        'swagger',
        'soapui',
        'paw',
        'advancedrestclient',
        'postwoman',

        // Utilit�rios de linha de comando
        'curl',
        'wget',
        'httpie',
        'axios',

        // Frameworks e Bibliotecas
        'python-requests',
        'python-urllib',
        'java-http',
        'apache-http',
        'okhttp',
        'guzzle',

        // Ferramentas de Seguran�a/Pentest
        'burp',
        'burpsuite',
        'zap',
        'owasp',
        'acunetix',
        'nmap',
        'nikto',
        'metasploit',

        // Browsers Automatizados
        'selenium',
        'puppeteer',
        'playwright',
        'phantomjs',
        'headless',

        // Ferramentas de Scraping
        'scrapy',
        'beautifulsoup',
        'httrack',
        'webhttrack'
    ];

    // Headers necess�rios
    $host = strtolower($_SERVER['HTTP_HOST'] ?? '');
    $origin = strtolower($_SERVER['HTTP_ORIGIN'] ?? '');
    $referer = strtolower($_SERVER['HTTP_REFERER'] ?? '');
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
    $sec_fetch_site = $_SERVER['HTTP_SEC_FETCH_SITE'] ?? '';

    // 1. Valida��o do Host
    if (empty($host) || !in_array($host, $DOMINIOS_PERMITIDOS)) {
        echo 'Requisi��o n�o permitida';
        exit;
    }

    // 2. Bloqueio de ferramentas de teste
    foreach ($FERRAMENTAS_PROIBIDAS as $ferramenta) {
        if (stripos($user_agent, $ferramenta) !== false || empty($sec_fetch_site)) {
            echo 'Requisi��o n�o permitida';
            exit;
        }
    }

    // 3. Valida��o de Origin
    if ($origin && !in_array(parse_url($origin, PHP_URL_HOST), $DOMINIOS_PERMITIDOS)) {
        echo 'Requisi��o n�o permitida';
        exit;
    }

    // 4. Valida��o de Referer
    if ($referer) {
        $referer_host = parse_url($referer, PHP_URL_HOST);

        // Verifica se o referer � de um buscador permitido
        $is_search_engine = false;
        foreach ($REFERERS_PERMITIDOS as $buscador) {
            if (strpos($referer_host, $buscador) !== false) {
                $is_search_engine = true;
                break;
            }
        }

        if (!$is_search_engine && !in_array($referer_host, $DOMINIOS_PERMITIDOS)) {
            echo 'Requisi��o n�o permitida';
            exit;
        }
    }

    // 5. Log de requisi��es sem origin/referer
    // if (!$origin && !$referer && in_array($host, $DOMINIOS_PERMITIDOS)) {
    //     error_log(sprintf(
    //         'Aviso: Requisi��o sem Origin/Referer - Host: %s, IP: %s',
    //         $host,
    //         $_SERVER['REMOTE_ADDR']
    //     ));
    // }
}







###########################################################################################################################################################################################
###########################################################################################################################################################################################
###########################################################################################################################################################################################

function nomeSistema($sistema_id)
{
    //echo $field;exit;
    $ci = get_instance();
    $query = "select * from seguranca.sistema where sistema_id = " . (int) $sistema_id;

    $data = $ci->db->query($query)->result();
    foreach ($data as $d) {
        $sistema_nm = $d->sistema_nm;
    }
    return $sistema_nm;
}

function calcula_porcentagem($meta, $exec)
{

    if ($meta == 0 or $exec == 0) {
        $porcentagem = 0;
    } else {
        $porcentagem = ($exec * 100) / $meta;
    }

    return number_format((float) $porcentagem, 2);
}

function retornaEventos($param = null)
{
    //echo $field;exit;
    $ci = get_instance();
    $query = "
                    select 
                    
                     ap.atividade_pai_nm
                    ,cr.qtd
                    ,cr.data
                    ,cr.comentario
                    ,EXTRACT(DAY FROM cr.data) as dia
                    ,EXTRACT(MONTH FROM cr.data) as mes
                    ,EXTRACT(YEAR FROM cr.data) as ano
                     from sigater_indireta.cronograma cr
                    inner join sigater_indireta.atividade a
                            on a.atividade_id = cr.atividade_id
                    inner join sigater_indireta.contrato co
                            on co.contrato_id = a.contrato_id
		
                    where 1=1 " . $param;
    //echo_pre($query);

    $data = $ci->db->query($query)->result();
    $events = '';
    foreach ($data as $d) {

        $events .= "{
                            title: '" . ($d->atividade_pai_nm) . "',
                            qtd: '$d->qtd',
                            comentario: '$d->comentario',
                            start: new Date($d->ano, " . ($d->mes - 1) . ", $d->dia),
                            allDay: true
                        },
                  ";
    }
    echo $events;
}

//padrao brasileiro para americano
function dataToDB($data)
{
    $data = trim($data);
    return str_replace('--', '', $data[6] . $data[7] . $data[8] . $data[9] . "-" . $data[3] . $data[4] . "-" . $data[0] . $data[1]);
}

//padrao americano para brasileiro
function DBToData($data, $simbolo = "/")
{
    $data = trim($data);
    return str_replace('//', '', $data[8] . $data[9] . $simbolo . $data[5] . $data[6] . $simbolo . $data[0] . $data[1] . $data[2] . $data[3]);
}

function DBToDataHora($data, $simbolo = "/")
{
    $data = trim($data);
    return str_replace('//', '', $data[8] . $data[9] . $simbolo . $data[5] . $data[6] . $simbolo . $data[0] . $data[1] . $data[2] . $data[3]) . ' - ' . substr($data, 10, 6);
}

function retornaHoraData($dataDB)
{
    return substr($dataDB, 10, 9);
}

function echo_pre($sql)
{
    echo "<pre>" . $sql . '</pre>';
}

function rupper($str)
{
    $temp = @str_replace("'", "", strtoupper(strtr($str, "�����������������", "�����������������")));

    return trim($temp);
}

function rlower($str)
{
    $temp = str_replace("'", "", strtolower(strtr($str, "����������������", "����������������")));

    return trim($temp);
}

function numeroMask($num)
{
    $num = (float) $num;
    return number_format($num, 2, ',', '.');
}

function proximoStatusSolicitacaoDiaria($status_id)
{
    $ci = get_instance();
    $query = "
        select ordem,status_id from diaria2.status  
                          where   ordem > (select s2.ordem from diaria2.status s2 
                                                where s2.status_id = $status_id ) 
            order by ordem limit 1
             ";
    //echo_pre($query);exit;
    $data = $ci->db->query($query)->result();
    foreach ($data as $d) {
        $status_id = $d->status_id;
    }
    return $status_id;
}

function retornaMes($mes_cod)
{
    $ci = get_instance();
    $query = "
        select * from dados_unico.mes where mes_cod =  $mes_cod
                          
             ";
    //echo_pre($query);exit;
    $data = $ci->db->query($query)->result();
    foreach ($data as $d) {
        $mes = $d->mes_nm;
    }
    return $mes;
}

function retornaVigencia($lote_id)
{
    //echo $field;exit;
    $ci = get_instance();
    $query = "select con.*
               from sigater_indireta.cronograma c
                    inner join sigater_indireta.atividade a
                        on a.atividade_id = c.atividade_id
                    inner join sigater_indireta.lote l
                        on a.lote_id = l.lote_id
                    inner join sigater_indireta.contrato con
                        on con.contrato_id = l.contrato_id
                    where a.lote_id = $lote_id limit 1";
    //echo_pre($query);
    $data = $ci->db->query($query)->result();
    foreach ($data as $d) {
        $retorno = $d->vigencia_ini . '|' . $d->vigencia_fim . '|' . $d->contrato_id;
    }
    return $retorno;
}

function retornaTecnicos($cronograma_id)
{
    $html = '';
    $ci = get_instance();
    $query = "select * from sigater_indireta.cronograma_tecnico ct
                inner join dados_unico.pessoa p
                        on p.pessoa_id = ct.tecnico_pessoa_id 
                 where ct.cronograma_id = " . (int) $cronograma_id;

    //echo_pre($query);

    $data = $ci->db->query($query)->result();

    //echo count($data);exit;

    foreach ($data as $d) {
        $html .= "<tr class='trTecnico_$cronograma_id' style='display: none;' > 
                    <td>-</td>
                    <td>-</td>
                    <td>
                             " . anchor(site_url('cronograma_tecnico/delete/' . $d->cronograma_tecnico_id), ' ', "class='glyphicon glyphicon-trash' title='Excluir' " . ' ' . 'onclick="javasciprt: return confirm(\'Tem certeza que deseja apagar o Registro?\')"') . "  
                    </td>
                    <td colspan=4>$d->pessoa_nm</td> 
                 </tr>";
    }
    //echo $html;

    return $html;
}

function retornaNmMes($mes)
{
    while ((int) $mes > 12) {
        $mes -= 12;
    }
    switch ($mes) {
        case 1:
            $mesNm = 'Janeiro';
            break;
        case 2:
            $mesNm = 'Fevereiro';
            break;
        case 3:
            $mesNm = 'Mar�o';
            break;
        case 4:
            $mesNm = 'Abril';
            break;
        case 5:
            $mesNm = 'Maio';
            break;
        case 6:
            $mesNm = 'Junho';
            break;
        case 7:
            $mesNm = 'Julho';
            break;
        case 8:
            $mesNm = 'Agosto';
            break;
        case 9:
            $mesNm = 'Setembro';
            break;
        case 10:
            $mesNm = 'Outubro';
            break;
        case 11:
            $mesNm = 'Novembro';
            break;
        case 12:
            $mesNm = 'Dezembro';
            break;

        default:
            $mesNm = '[n�o existe]';
            break;
    }
    return $mesNm;
}

function retornaIntMes($mes)
{
    while ((int) $mes > 12) {
        $mes -= 12;
    }

    return $mes;
}

function retornaRegraHomologacao($qtd, $atividade_id)
{
    if ((int) $qtd > 0) {
        $ci = get_instance();

        //pega dados da atividade
        $sqlAtividade = "select * from sigater_indireta.atividade a where atividade_id = " . $atividade_id;
        $data = $ci->db->query($sqlAtividade)->row();
        $atividade_tipo_id = (int) $data->atividade_tipo_id;


        $query = "select 
                         at.atividade_tipo_nm ||' >> '|| rh.observacao as observacao
                        ,rh.porcentagem 
                        ,rh.regra_tipo_id
                        ,rt.regra_tipo_nm
            
                    from sigater_indireta.regra_homologacao rh
                        inner join sigater_indireta.atividade_tipo at
                            on at.atividade_tipo_id = rh.atividade_tipo_id
                        inner join sigater_indireta.regra_tipo rt
                            on rt.regra_tipo_id = rh.regra_tipo_id
                        where rh.atividade_tipo_id = $atividade_tipo_id and $qtd between rh.ini_atestes and rh.fim_atestes limit 1";

        // echo_pre($query);
        unset($data);
        $data = $ci->db->query($query)->row();
    } else {
        $data = NULL;
    }
    return $data;
}

function qtdMunicipiosCadastrados()
{
    //echo $field;exit;
    $ci = get_instance();
    $query = "select count(distinct municipio_id) as qtd from sigater_indireta.lote_municipio lm";

    $data = $ci->db->query($query)->result();
    foreach ($data as $d) {
        $qtd = $d->qtd;
    }
    return $qtd;
}

function qtdFiscais()
{
    //echo $field;exit;
    $ci = get_instance();
    $query = "select count(distinct fiscal_pessoa_id) as qtd  from sigater_indireta.lote_fiscal";

    $data = $ci->db->query($query)->result();
    foreach ($data as $d) {
        $qtd = $d->qtd;
    }
    return $qtd;
}

function qtdTecnicos()
{
    //echo $field;exit;
    $ci = get_instance();
    $query = "select count(distinct v.pessoa_id) as qtd from vi_funcionario_perfil v
                inner join dados_unico.pessoa p
                        on p.pessoa_id = v.pessoa_id
                 where p.pessoa_st = 0 and tipo_usuario_id =167 /*tecnico do indireta*/";

    $data = $ci->db->query($query)->result();
    foreach ($data as $d) {
        $qtd = $d->qtd;
    }
    return $qtd;
}

function qtdInstituicoes()
{
    //echo $field;exit;
    $ci = get_instance();
    $query = "select count(1) as qtd from sigater_indireta.Entidade";

    $data = $ci->db->query($query)->result();
    foreach ($data as $d) {
        $qtd = $d->qtd;
    }
    return $qtd;
}

function qtdExecutor()
{
    //echo $field;exit;
    $ci = get_instance();
    $query = "select count(distinct executor_pessoa_id) as qtd  from sigater_indireta.lote_executor";

    $data = $ci->db->query($query)->result();
    foreach ($data as $d) {
        $qtd = $d->qtd;
    }
    return $qtd;
}

function qtdLotes()
{
    //echo $field;exit;
    $ci = get_instance();
    $query = "select count(lote_id) as qtd  from sigater_indireta.lote";

    $data = $ci->db->query($query)->result();
    foreach ($data as $d) {
        $qtd = $d->qtd;
    }
    return $qtd;
}

function retornaPosicaoCronograma($chamada_publica_id = 0, $dt_ref = null)
{
    $ci = get_instance();
    $query = "select * from sigater_indireta.chamada_publica where chamada_publica_id = $chamada_publica_id";

    $data = $ci->db->query($query)->row();

    $dataInicio = $data->dt_chamada_ini;



    $data1 = new DateTime($dataInicio);
    $data2 = new DateTime($dt_ref);

    $intervalo = $data1->diff($data2);

    $meses = $intervalo->m;
    if ((int) $intervalo->y > 0) {
        $meses = $meses + ((int) $intervalo->y * 12);
    }

    return ($meses + 1);
}

function retornaPosicaoCronogramaLote($lote_id = 0, $dt_ref = null)
{
    $ci = get_instance();
    $query = "select * from sigater_indireta.lote where lote_id = $lote_id";

    $data = $ci->db->query($query)->row();

    $dataInicio = $data->contrato_dt_ini;



    $data1 = new DateTime($dataInicio);
    $data2 = new DateTime($dt_ref);

    $intervalo = $data1->diff($data2);

    $meses = $intervalo->m;
    if ((int) $intervalo->y > 0) {
        $meses = $meses + ((int) $intervalo->y * 12);
    }

    return ($meses + 1);
}



function numero_extenso($valor)
{

    $valor = number_format($valor, 2, '.', '');

    $v = explode('.', $valor);

    $inteiro = (int) $v[0];
    $decimal = (int) $v[1];


    //$decimal = substr(strpbrk($inteiro, '.'), 1);


    $decimal = $decimal;


    $v_i = convert_number_to_words($inteiro);
    $v_d = convert_number_to_words($decimal);



    if (!empty($decimal)) {
        return $v_i . ' reais e ' . $v_d . ' centavos ';
    } else {
        return $v_i . ' reais';
    }
}

function convert_number_to_words($number)
{

    $hyphen = '-';
    $conjunction = ' e ';
    $separator = ', ';
    $negative = 'menos ';
    $decimal = ' ponto ';
    $dictionary = array(
        0 => 'zero',
        1 => 'um',
        2 => 'dois',
        3 => 'tr�s',
        4 => 'quatro',
        5 => 'cinco',
        6 => 'seis',
        7 => 'sete',
        8 => 'oito',
        9 => 'nove',
        10 => 'dez',
        11 => 'onze',
        12 => 'doze',
        13 => 'treze',
        14 => 'quatorze',
        15 => 'quinze',
        16 => 'dezesseis',
        17 => 'dezessete',
        18 => 'dezoito',
        19 => 'dezenove',
        20 => 'vinte',
        30 => 'trinta',
        40 => 'quarenta',
        50 => 'cinquenta',
        60 => 'sessenta',
        70 => 'setenta',
        80 => 'oitenta',
        90 => 'noventa',
        100 => 'cento',
        200 => 'duzentos',
        300 => 'trezentos',
        400 => 'quatrocentos',
        500 => 'quinhentos',
        600 => 'seiscentos',
        700 => 'setecentos',
        800 => 'oitocentos',
        900 => 'novecentos',
        1000 => 'mil',
        1000000 => array('milh�o', 'milh�es'),
        1000000000 => array('bilh�o', 'bilh�es'),
        1000000000000 => array('trilh�o', 'trilh�es'),
        1000000000000000 => array('quatrilh�o', 'quatrilh�es'),
        1000000000000000000 => array('quinquilh�o', 'quinquilh�es')
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words s� aceita n�meros entre ' . PHP_INT_MAX . ' � ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $conjunction . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = floor($number / 100) * 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            if ($baseUnit == 1000) {
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[1000];
            } elseif ($numBaseUnits == 1) {
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit][0];
            } else {
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit][1];
            }
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}
