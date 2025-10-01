<?php

//FUNÇÃO PARA INCLUIR DOCUMENTOS
function F_AcaoIncluirDocumento(
$PaginaLocal, $documento_numero, $tipo_origem, $cmbSetorOrigem, $cmbOrgaoOrigem, $documento_numero_original, $tipo_documento_id, $documento_dt, $documento_dt_recebimento, $assunto_id, $discriminacao_assunto, $qtde_paginas, $subassunto_id, $documento_modelo_pai_id, $gerar_numero_original) {
    echo '1°'.date('m-i').'<br>';
    //FORMATA OS DADOS CONSULTADOS
    $documento_numero = trim($documento_numero);

    //VERIFICA O CID NÃO FOI INFORMADO E GERA O NUMERO
    if ($documento_numero == '') {
        //GERA A SELEÇÃO PARA CAPTURA DO NUMERO ATUAL
        $sqlSelect = "SELECT numero, mascara_cid, orgao_id FROM documento.cid_numero";

        //REALIZADA A SELEÇÃO
        $rsSelect = pg_query(abreConexao(), $sqlSelect);

        //ASSOCIA OS VALORES
        $dados = pg_fetch_assoc($rsSelect);

        //CAPTURA O ULTIMO NUMERO, O ANO E A MASCARA DO CID
        $ultimoNumero = $dados['numero'];
        $mascara_cid = trim($dados['mascara_cid']);
        $orgao_id = $dados['orgao_id'];

        //CRIA VARIAVEL PARA CONTER O NUMERO DO CID
        $numero_formatado = '';

        //GERA O NUMERO A SER INSERIDO NO NOVO REGISTRO
        $proximoNumero = $ultimoNumero + 1;
        $Numero = $proximoNumero;

        //VERIFICA O TAMANHO DO NUMERO
        $Tamanho = strlen($Numero);

        //VERIFICA SE NÃO FOI INFORMADA MASCARA
        if ($mascara_cid == '') {
            //GERA O NUMERO A SER INSERIDO NO BANCO
            $Numero = $proximoNumero;
        }
        //EXISTE MASCARA
        else {
            //CAPTURA OS CAMPOS DA MASCARA DO CID
            $mascara_cid = explode(' ', $mascara_cid);

            //ANALISA OS CAMPOS DA MASCARA DO CID
            for ($i = 0; $i < count($mascara_cid); $i++) {
                //VERIFICA SE O TRATAMENTO É PARA ANO
                if ($mascara_cid[$i] == 'ANO') {
                    //INSERE O ANO NA FORMATAÇÃO
                    $numero_formatado .= date('y');
                }
                //VERIFICA SE O TRATAMENTO É SEQUENCIA
                else if ($mascara_cid[$i][0] == '[') {
                    //DEFINE A QUANTIDADE MINIMA DE DIGITOS
                    $qtdMinimaDigitos = (strlen($mascara_cid[$i]) - 2);

                    //DEFINE Q QUANTIDADE DE ZEROS
                    $TamanhoZero = $qtdMinimaDigitos - $Tamanho;

                    //CRIA A SEQUENCIA
                    $sequencia = '';

                    //CONCATENA O NUMERO DO DOCUMENTO PARA OBTER A QUANTIDADE MINIMA DE DIGITOS
                    for ($j = 1; $j <= $TamanhoZero; $j++) {
                        $sequencia .= '0';
                    }

                    //APLICA A SEQUENCIA
                    $numero_formatado .= $sequencia . $proximoNumero;
                }
                //SE NÃO FOR SEQUENCIA NEM ANO
                else {
                    //CAPTURA O TEXTO DA FORMATAÇÃO
                    $numero_formatado .= $mascara_cid[$i];
                }
            }

            //SE A CONSULTA FOR REALIZADA INCREMENTA O NUMERO ATUAL DOS DOCUMENTOS PARA A PROXIMA INSERÇÃO
            $sqlUpdate = "UPDATE documento.cid_numero SET numero = " . $proximoNumero . " WHERE numero = " . $ultimoNumero . "";

            //REALIZADA O INCREMENTO
            pg_query(abreConexao(), $sqlUpdate);

            //CALCULA O DIGITO DO NUMERO INFORMADO
            $Digito = F_GerarDigitoSEP($numero_formatado);

            //ATRIBUI O DIGITO
            $numero_formatado = $numero_formatado . $Digito;

            //GERA O NUMERO A SER INSERIDO NO BANCO
            $documento_numero = $numero_formatado;
        }
    }

    //*********************************************************
    //VERIFICA SE A OPÇÃO PARA GERAR NUMERO ORIGINAL FOI MARCADA
    if ($gerar_numero_original == 'Gerar Numero') {
        //VERIFICA SE FOI GERADO O CID
        if ($numero_formatado == '') {
            //VERIFICA SE O ANO ENCONTRADO ESTA DESATUALIZO ATUAL
            $sqlSelect = "SELECT ano FROM documento.cid_numero";

            //REALIZADA A SELEÇÃO
            $rsSelect = pg_query(abreConexao(), $sqlSelect);

            //ASSOCIA OS VALORES
            $dados = pg_fetch_assoc($rsSelect);

            //CAPTURA O ANO REGISTRADO E O ANO ATUAL
            $ano = $dados['ano'];
            $anoAtual = date("Y");

            //REALIZA A VERIFICAÇÃO
            if ($ano < $anoAtual) {
                //ATUALIZA O ANO
                $sqlUpdate = "UPDATE documento.cid_numero SET ano = " . $anoAtual . ", numero = 0 WHERE ano = " . $ano . "";

                //REALIZADA O INCREMENTO
                pg_query(abreConexao(), $sqlUpdate);
            }

            //GERA A SELEÇÃO PARA CAPTURA DO NUMERO ATUAL
            $sqlSelect = "SELECT numero, ano, mascara_cid, orgao_id FROM documento.cid_numero";

            //REALIZADA A SELEÇÃO
            $rsSelect = pg_query(abreConexao(), $sqlSelect);

            //ASSOCIA OS VALORES
            $dados = pg_fetch_assoc($rsSelect);

            //CAPTURA O ULTIMO NUMERO, O ANO E A MASCARA DO CID
            $ultimoNumero = $dados['numero'];
            $ano = $dados['ano'];
            $mascara_cid = trim($dados['mascara_cid']);
            $orgao_id = $dados['orgao_id'];

            //CRIA VARIAVEL PARA CONTER O NUMERO DO CID
            $numero_formatado = '';

            //GERA O NUMERO A SER INSERIDO NO NOVO REGISTRO
            $proximoNumero = $ultimoNumero + 1;
            $Numero = $proximoNumero;

            //VERIFICA O TAMANHO DO NUMERO
            $Tamanho = strlen($Numero);

            //VERIFICA SE NÃO FOI INFORMADA MASCARA
            if ($mascara_cid == '') {
                //GERA O NUMERO A SER INSERIDO NO BANCO
                $Numero = $proximoNumero;
            }
            //EXISTE MASCARA
            else {
                //CAPTURA OS CAMPOS DA MASCARA DO CID
                $mascara_cid = explode(' ', $mascara_cid);

                //ANALISA OS CAMPOS DA MASCARA DO CID
                for ($i = 0; $i < count($mascara_cid); $i++) {
                    //VERIFICA SE O TRATAMENTO É PARA ANO
                    if ($mascara_cid[$i] == 'ANO') {
                        //INSERE O ANO NA FORMATAÇÃO
                        $numero_formatado .= $ano;
                    }
                    //VERIFICA SE O TRATAMENTO É SEQUENCIA
                    else if ($mascara_cid[$i][0] == '[') {
                        //DEFINE A QUANTIDADE MINIMA DE DIGITOS
                        $qtdMinimaDigitos = (strlen($mascara_cid[$i]) - 2);

                        //DEFINE Q QUANTIDADE DE ZEROS
                        $TamanhoZero = $qtdMinimaDigitos - $Tamanho;

                        //CRIA A SEQUENCIA
                        $sequencia = '';

                        //CONCATENA O NUMERO DO DOCUMENTO PARA OBTER A QUANTIDADE MINIMA DE DIGITOS
                        for ($j = 1; $j <= $TamanhoZero; $j++) {
                            $sequencia .= '0';
                        }

                        //APLICA A SEQUENCIA
                        $numero_formatado .= $sequencia . $proximoNumero;
                    }
                    //SE NÃO FOR SEQUENCIA NEM ANO
                    else {
                        //CAPTURA O TEXTO DA FORMATAÇÃO
                        $numero_formatado .= $mascara_cid[$i];
                    }
                }

                //SE A CONSULTA FOR REALIZADA INCREMENTA O NUMERO ATUAL DOS DOCUMENTOS PARA A PROXIMA INSERÇÃO
                $sqlUpdate = "UPDATE documento.cid_numero SET numero = " . $proximoNumero . " WHERE numero = " . $ultimoNumero . "";

                //REALIZADA O INCREMENTO
                pg_query(abreConexao(), $sqlUpdate);

                //GERA O NUMERO A SER INSERIDO NO BANCO
                //$documento_numero = $numero_formatado;
            }
        }

        //VERIFICA SE O DOCUMENTO SERÁ CADASTRADOR PARA SETOR
        if ($tipo_origem == 'I') {
            //SELECIONA A TABELA DE NUMERAÇÃO DO CONTROLE INTERNO DE DOCUMENTOS
            $sqlSelect = "SELECT numero, ano FROM documento.documento_numero WHERE tipo_documento_id = " . $tipo_documento_id . " AND setor_id = " . $cmbSetorOrigem . "";
        }
        //VERIFICA SE O DOCUMENTO SERÁ CADASTRADOR PARA ORGÃO
        else if ($tipo_origem == 'E') {
            //SELECIONA A TABELA DE NUMERAÇÃO DO CONTROLE INTERNO DE DOCUMENTOS
            $sqlSelect = "SELECT numero, ano FROM documento.documento_numero WHERE tipo_documento_id = " . $tipo_documento_id . " AND orgao_id = " . $cmbOrgaoOrigem . "";
        }

        //REALIZADA A SELEÇÃO
        $rsSelect = pg_query(abreConexao(), $sqlSelect);

        //ASSOCIA OS VALORES
        $dados = pg_fetch_assoc($rsSelect);

        //CAPTURA A QUANTIDADE DE REGISTROS SELECIONADOS
        $qtdRegistrosSelecionados = pg_num_rows($rsSelect);

        //SE A QUANTIDADE DE REGISTROS SELECIONADOS FOR IGUAL A ZERO (NAO HOUVEREM REGISTROS)
        if ($qtdRegistrosSelecionados == 0) {
            //CAPTURA O ANO ATUAL
            $ano = date("Y");

            //DEFINE UM NUMERO INICIAL COMO 0
            $numero = 0;

            //VERIFICA SE O DOCUMENTO SERÁ CADASTRADOR PARA SETOR
            if ($tipo_origem == 'I') {
                //GERA A QUERY
                $sqlInsert = "INSERT INTO documento.documento_numero(numero, ano, tipo_documento_id, setor_id, orgao_id) VALUES (" . $numero . ", " . $ano . ", " . $tipo_documento_id . ", " . $cmbSetorOrigem . ", " . $orgao_id . ")";
            }
            //VERIFICA SE O DOCUMENTO SERÁ CADASTRADOR PARA ORGÃO
            else if ($tipo_origem == 'E') {
                //GERA A QUERY
                $sqlInsert = "INSERT INTO documento.documento_numero(numero, ano, tipo_documento_id, setor_id, orgao_id) VALUES (" . $numero . ", " . $ano . ", " . $tipo_documento_id . ", 0, " . $cmbOrgaoOrigem . ")";
            }

            //REALIZADA A INSERÇÃO
            $rsInsert = pg_query(abreConexao(), $sqlInsert);
        }

        //VERIFICA SE O ANO ENCONTRADO ESTA DESATUALIZO ATUAL
        $sqlSelect = "SELECT ano FROM documento.documento_numero";

        //REALIZADA A SELEÇÃO
        $rsSelect = pg_query(abreConexao(), $sqlSelect);

        //ASSOCIA OS VALORES
        $dados = pg_fetch_assoc($rsSelect);

        //CAPTURA O ANO REGISTRADO E O ANO ATUAL
        $ano = $dados['ano'];
        $anoAtual = date("Y");

        //REALIZA A VERIFICAÇÃO
        if ($ano < $anoAtual) {
            //ATUALIZA O ANO
            $sqlUpdate = "UPDATE documento.documento_numero SET ano = " . $anoAtual . ", numero = 0";

            //REALIZADA O INCREMENTO
            pg_query(abreConexao(), $sqlUpdate);
        }

        //VERIFICA SE O DOCUMENTO SERÁ CADASTRADOR PARA SETOR
        if ($tipo_origem == 'I') {
            //GERA A SELEÇÃO PARA CAPTURA DO NUMERO ATUAL
            $sqlSelect = "SELECT numero, ano FROM documento.documento_numero WHERE tipo_documento_id = " . $tipo_documento_id . " AND setor_id = " . $cmbSetorOrigem . "";
        }
        //VERIFICA SE O DOCUMENTO SERÁ CADASTRADOR PARA ORGÃO
        else if ($tipo_origem == 'E') {
            //GERA A SELEÇÃO PARA CAPTURA DO NUMERO ATUAL
            $sqlSelect = "SELECT numero, ano FROM documento.documento_numero WHERE tipo_documento_id = " . $tipo_documento_id . " AND orgao_id = " . $cmbOrgaoOrigem . "";
        }

        //REALIZADA A SELEÇÃO
        $rsSelect = pg_query(abreConexao(), $sqlSelect);

        //ASSOCIA OS VALORES
        $dados = pg_fetch_assoc($rsSelect);

        //CAPTURA O ULTIMO NUMERO E O ANO
        $ultimoNumeroOriginal = $dados['numero'];
        $ano = $dados['ano'];

        //GERA O NUMERO A SER INSERIDO NO NOVO REGISTRO
        $proximoNumeroOriginal = $ultimoNumeroOriginal + 1;
        $documento_numero_original = $proximoNumeroOriginal;

        //VERIFICA O TAMANHO DO NUMERO
        $Tamanho = strlen($documento_numero_original);

        //QUERY PARA CAPTURAR A MASCARA DO NUMERO ORIGINAL
        $sqlSelect = "SELECT mascara_numero_original FROM documento.tipo_documento WHERE tipo_documento_id = " . $tipo_documento_id . "";

        //REALIZADA A SELEÇÃO
        $rsSelect = pg_query(abreConexao(), $sqlSelect);

        //ASSOCIA OS VALORES
        $linhaMascara = pg_fetch_assoc($rsSelect);

        //CAPTURA A MASCARA
        $mascara_numero_original = trim($linhaMascara['mascara_numero_original']);

        //SE NÃO EXISTE MASCARA
        if ($mascara_numero_original == '') {
            //GERA O NUMERO A SER INSERIDO NO BANCO
            $documento_numero_original = $proximoNumeroOriginal;
        }
        //EXISTE MASCARA
        else {
            //CRIA VARIAVEL PARA CONTER O NUMERO ORGINAL
            $numero_original_formatado = '';

            //VERIFICA SE EXISTE MASCARA VÁLIDA
            if ($mascara_numero_original != '') {
                //CAPTURA OS CAMPOS DA MASCARA
                $mascara_numero_original = explode(' ', $mascara_numero_original);

                //ANALISA OS CAMPOS DA MASCARA
                for ($i = 0; $i < count($mascara_numero_original); $i++) {
                    //VERIFICA SE O TRATAMENTO É PARA ANO
                    if ($mascara_numero_original[$i] == 'ANO') {
                        //INSERE O ANO NA FORMATAÇÃO
                        $numero_original_formatado .= $ano;
                    }
                    //VERIFICA SE O TRATAMENTO É PARA USAR O NUMERO DO CID
                    else if ($mascara_numero_original[$i] == 'CID') {
                        //CRIA A SEQUENCIA
                        $sequencia = '';

                        //CONCATENA O NUMERO DO DOCUMENTO PARA OBTER A QUANTIDADE MINIMA DE DIGITOS
                        for ($j = 1; $j <= $TamanhoZero; $j++) {
                            $sequencia .= '0';
                        }

                        //INSERE O ANO NA FORMATAÇÃO
                        $numero_original_formatado .= $sequencia . $proximoNumero;
                    }
                    //VERIFICA SE O TRATAMENTO É SEQUENCIA
                    else if ($mascara_numero_original[$i][0] == '[') {
                        //DEFINE A QUANTIDADE MINIMA DE DIGITOS
                        $qtdMinimaDigitos = (strlen($mascara_numero_original[$i]) - 2);

                        //DEFINE Q QUANTIDADE DE ZEROS
                        $TamanhoZeroNumeroOriginal = $qtdMinimaDigitos - $Tamanho;

                        //CRIA A SEQUENCIA
                        $sequencia = '';

                        //CONCATENA O NUMERO DO DOCUMENTO PARA OBTER A QUANTIDADE MINIMA DE DIGITOS
                        for ($j = 1; $j <= $TamanhoZeroNumeroOriginal; $j++) {
                            $sequencia .= '0';
                        }

                        //APLICA A SEQUENCIA
                        $numero_original_formatado .= $sequencia . $proximoNumeroOriginal;
                    }
                    //SE NÃO FOR SEQUENCIA NEM ANO
                    else {
                        //CAPTURA O TEXTO DA FORMATAÇÃO
                        $numero_original_formatado .= $mascara_numero_original[$i];
                    }
                }
            }

            //GERA O NUMERO A SER INSERIDO NO BANCO
            $documento_numero_original = $numero_original_formatado;

            //VERIFICA SE O DOCUMENTO SERÁ CADASTRADOR PARA SETOR
            if ($tipo_origem == 'I') {
                //SE A CONSULTA FOR REALIZADA INCREMENTA O NUMERO ATUAL DOS DOCUMENTOS PARA A PROXIMA INSERÇÃO
                $sqlUpdate = "UPDATE documento.documento_numero SET numero = " . $proximoNumeroOriginal . " WHERE numero = " . $ultimoNumeroOriginal . " AND tipo_documento_id = " . $tipo_documento_id . " AND setor_id = " . $cmbSetorOrigem . "";
            }
            //VERIFICA SE O DOCUMENTO SERÁ CADASTRADOR PARA ORGÃO
            else if ($tipo_origem == 'E') {
                //SE A CONSULTA FOR REALIZADA INCREMENTA O NUMERO ATUAL DOS DOCUMENTOS PARA A PROXIMA INSERÇÃO
                $sqlUpdate = "UPDATE documento.documento_numero SET numero = " . $proximoNumeroOriginal . " WHERE numero = " . $ultimoNumeroOriginal . " AND tipo_documento_id = " . $tipo_documento_id . " AND orgao_id = " . $cmbOrgaoOrigem . "";
            }

            //REALIZADA O INCREMENTO
            pg_query(abreConexao(), $sqlUpdate);
        }
        
    }

    //TRATAMENTO PARA INSERÇÃO DA ORIGEM
    if ($tipo_origem == 'I') {
        $origem_est_organizacional_id = $cmbSetorOrigem;
    } else {
        $origem_est_organizacional_id = 0;
    }
    if ($tipo_origem == 'E') {
        $origem_orgao_id = $cmbOrgaoOrigem;
    } else {
        $origem_orgao_id = 0;
    }

    //CAPTURANDO AS VARIAVEIS A SEREM INSERIDAS NO BANCO
    $documento_numero_original = strip_tags(trim($documento_numero_original));
    $cadastro_est_organizacional_id = F_RetornaEstOrganizacionalDoFuncionario($_SESSION['UsuarioCodigo']);
    $cadastro_pessoa_id = $_SESSION['UsuarioCodigo'];
    $responsavel_id = $_SESSION['UsuarioCodigo'];


    ####################################################################################################################################################
    //apartir de 31/05/2016 o responsavel é o solicitante em diaria
    //pega id do solicitane pela diaria
    $sql = "select * from diaria.diaria where diaria_numero = '$documento_numero_original' ";
    //echo $sql;exit;
    $rsd = pg_query(abreConexao(), $sql);

    //echo $tipo_documento_id;
    /* 85 diaria */ /* 46 COMPROVAÇÃO */



    //if ($tipo_documento_id == 85 || $subassunto_id == 46/*COMPROVAÇÃO*/) { //echo 9;
    if ($_SESSION['unidade_orcamentaria_id'] != 3) {//BAHIATER
        if ((int) pg_num_rows($rsd) > 0) {

            $linhaD = pg_fetch_assoc($rsd);
            $diaria_solicitante = $linhaD['diaria_solicitante'];
            $responsavel_id = $diaria_solicitante;
            $cadastro_est_organizacional_id = F_RetornaEstOrganizacionalDoFuncionario($responsavel_id);

            if (empty($responsavel_id)) {
                echo "erro, consultar APG - e001";
                exit;
            }
        }
    }
    
    
    
    //echo "linha";
    //exit;
    ####################################################################################################################################################



    $discriminacao_assunto = strip_tags(addslashes(trim($discriminacao_assunto)));
    $documento_dt_criacao = "'" . date("Y-m-d") . " " . date("H:i:s") . "'";
    $documento_dt_alteracao = "'" . date("Y-m-d") . " " . date("H:i:s") . "'";

    //TRATAMENTO PARA INSERÇÃO DO DOCUMENTO PAI USADO COMO MODELO
    if ($documento_modelo_pai_id == '')
        $documento_modelo_pai_id = 0;

    //TRATAMENTO CONDICIONAL
    if ($gerar_numero_original == 'Gerar Numero') {
        $numero_original_sistema = 'V';
    } else {
        $numero_original_sistema = 'F';
    }


    if (empty($documento_dt_recebimento)) {
        $documento_dt_recebimento = $documento_dt_criacao;
    }

    if (empty($responsavel_id)) {
        $responsavel_id = $_SESSION['UsuarioCodigo'];
    }

    ########################################################################################
    #verifica se ja existe um documento igual antes de inserir, se existir não insere
    $sql = " select 1 from documento.documento  
                       where documento_numero_original = '$documento_numero_original' 
                            and assunto_id  = " .$assunto_id . "  
                                   and subassunto_id = $subassunto_id ";
    
  //echo_pre($sql);exit;

    $rsTemp = pg_query(abreConexao(), $sql);
    if (true) {
    //if (pg_num_rows($rsTemp) == 0) {
    

        //GERANDO A ESTRUTURA DE INSERÇÃO
   $sqlInsereDocumento = "
    INSERT INTO  
    (
        documento_numero,
        documento_numero_original,
        tipo_documento_id,
        cadastro_est_organizacional_id,
        cadastro_pessoa_id,
        responsavel_id,
        documento_dt,
        documento_dt_recebimento,
        assunto_id,
        discriminacao_assunto,
        documento_dt_criacao,
        tipo_origem,
        origem_orgao_id,
        origem_est_organizacional_id,
        qtde_paginas,
        subassunto_id,
        documento_modelo_pai_id,
        numero_original_sistema
    )
    VALUES
    (
        '" . $documento_numero . "',
        '" . $documento_numero_original . "',
        " . $tipo_documento_id . ",
        " . $cadastro_est_organizacional_id . ",
        " . $responsavel_id . ",
        " . $responsavel_id . ",
        '" . $documento_dt . "',
        '" . $documento_dt_recebimento . "',
        " . $assunto_id . ",
        '" . $discriminacao_assunto . "',
        " . $documento_dt_criacao . ",
        '" . $tipo_origem . "',
        " . $origem_orgao_id . ",
        " . $origem_est_organizacional_id . ",
        " . $qtde_paginas . ",
        " . $subassunto_id . ",
        " . $documento_modelo_pai_id . ",
        '" . $numero_original_sistema . "'
    )";
//echo_pre($sqlInsereDocumento);exit;
 
        //INSERE O DOCUMENTO
        pg_query(abreConexao(), $sqlInsereDocumento);

        //CAPTURA O ID DO DOCUMENTO CRIADO
        $sqlConsulta = "SELECT documento_id FROM documento.documento WHERE documento_numero = '" . $documento_numero . "'";

        //REALIZANDO A CONSULTA
        $rsConsulta = pg_query(abreConexao(), $sqlConsulta);

        //ASSOCIANDO OS DADOS DA CONSULTA EM UM VETOR
        $linha = pg_fetch_assoc($rsConsulta);

        //CAPTURANDO AS VARIAVEIS DA CONSULTA REALIZADA
        $documento_id = $linha['documento_id'];

        //INSERE OS INTERESSADOS COM O DOCUMENTO
        for ($i = 0; $i < count($_SESSION['interessados']); $i++) {
            //CAPTURA OS VALORES A SEREM INSERIDOS
            $interessado_id = $_SESSION['interessados'][$i][0];
            $interessado_nm = trim($_SESSION['interessados'][$i][1]);
            $interessado_tipo = $_SESSION['interessados'][$i][2];

            //TRATAMENTO PARA O ID DO INTERESSADO
            if ($interessado_id == "") {
                $interessado_id = 0;
            }

            //TRATAMENTO PARA A RELAÇÃO DE INTERESSE (TRATAMENTO TEMPORÁRIO)
            if ($i == 0) {
                $tipo_relacao_interesse_id = 1;
            } else {
                $tipo_relacao_interesse_id = 'NULL';
            }

            //INCLUI OS INTERESSADOS DO DOCUMENTO
            $sqlInsereInteressado = "
        INSERT INTO documento.vic_documento_interessado
        (
            documento_id,
            interessado_id,
            interessado_nm,
            interessado_tipo,
            vic_documento_interessado_dt,
            tipo_relacao_interesse_id
        )
        VALUES
        (
            " . $documento_id . ",
            " . $interessado_id . ",
            '" . $interessado_nm . "',
            '" . $interessado_tipo . "',
            NOW(),
            " . $tipo_relacao_interesse_id . "
        )";

            //INSERE O INTERESSADO
            pg_query(abreConexao(), $sqlInsereInteressado);
        }
    }

    //CAPTURA O ID DO DOCUMENTO CRIADO
    $sqlConsulta = "SELECT * FROM documento.documento WHERE documento_numero = '" . $documento_numero . "'";

    //REALIZANDO A CONSULTA
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);

    //ASSOCIANDO OS DADOS DA CONSULTA EM UM VETOR
    $Documento = pg_fetch_assoc($rsConsulta);

    //RETORNA O NUMERO DO DOCUMENTO INCLUIDO
    return $Documento;
}

//FUNÇÃO PARA GERAR O NÚMERO DO DIGITO DO SEP
function F_GerarDigitoSEP($numero) {
    //SE O NUMERO FOI INFORMADO E TEM TAMANHO 12 REALIZADO O TRATAMENTO
    if (($numero != '') && (strlen($numero) == 12)) {
        //CRIA INDICE PARA PEGAR TODOS OS DIGITOS DO NUMERO RECEBIDO
        $indiceNumero = 0;

        //CRIA SOMADOR PARA REALIZAR A VALIDAÇÃO DO DIGITO
        $somador = 0;

        //REALIZA DUAS VEZES A MULTIPLICAÇÃO DE 2 A 7
        for ($i = 0; $i < 2; $i++) {
            //REALIZA A MULTIPLICAÇÃO DE 2 A 7
            for ($j = 7; $j > 1; $j--) {
                //CAPTURA O DIGITO ATUAL
                $digitoAtual = $numero[$indiceNumero];

                //MULTIPLICA O DIGITO ATUAL PELA CONSTANTE ATUAL DE 7 A 2 EM ORDEM
                $resultado = $digitoAtual * $j;

                //SOMA O RESULTADO AO TOTAL ATUAL
                $somador = $resultado + $somador;

                //PASSA PARA O PROXIMO DIGITO
                $indiceNumero++;
            }
        }

        //DIVIDE O TOTAL POR 11 E CAPTURA O RESTO
        $RestoDoTotalDividoPorOnze = $somador % 11;

        //SUBTRAI ONZE DO RESTO
        $RestoDoTotalDividoPorOnzeMenosOnze = $RestoDoTotalDividoPorOnze - 11;

        //CAPTURA O DIGITO (MODULO DO TOTAL DIVIDIDO POR ONZE MENOS ONZE)
        $Digito = abs($RestoDoTotalDividoPorOnzeMenosOnze);

        //REALIZA TRATAMENTO PARA SITUAÇÕES EM QUE O DIGITO POSSUIR MAIS DE UM CARACTERE
        if ($Digito == 10) {
            $Digito = 0;
        }
        if ($Digito == 11) {
            $Digito = 0;
        }

        //RETORNA O DIGITO
        return $Digito;
    }
    //SE OS CRITERIOS DO NUMERO RECEBIDO NÃO ATENDEREM A FUNÇÃO RETORNA A LETRA 'D'
    else {
        return 'D';
    }
}

//FUNÇÃO PARA ALTERAR DOCUMENTOS
function F_AcaoAlterarDocumento(
$PaginaLocal, $documento_id, $numero_documento, $tipo_origem, $cmbSetorOrigem, $cmbOrgaoOrigem, $documento_numero_original, $tipo_documento_id, $documento_dt, $documento_dt_recebimento, $assunto_id, $discriminacao_assunto, $qtde_paginas, $subassunto_id, $documento_modelo_pai_id, $txtNumeroOriginalNaoEditavel) {
    //FORMATANDO OS DADOS OBTIDOS
    $txtNumeroOriginalNaoEditavel = trim($txtNumeroOriginalNaoEditavel);

    //TRATAMENTO PARA A ALTERAÇÃO DO ORGÃO DE ORIGEM DO DOCUMENTO
    if ($tipo_origem == 'I') {
        $origem_est_organizacional_id = $cmbSetorOrigem;
    } else {
        $origem_est_organizacional_id = 0;
    }
    if ($tipo_origem == 'E') {
        $origem_orgao_id = $cmbOrgaoOrigem;
    } else {
        $origem_orgao_id = 0;
    }

    //CAPTURA A DATA DE ALTERAÇÃO
    $documento_dt_alteracao = "'" . date("Y-m-d") . " " . date("H:i:s") . "'";

    //FORMATA OS DADOS CONSULTADOS
    $discriminacao_assunto = strip_tags(trim($discriminacao_assunto));
    $documento_numero_original = strip_tags($documento_numero_original);

    //TRATAMENTO PARA O NUMERO ORIGINAL
    if ($txtNumeroOriginalNaoEditavel != '') {
        $documento_numero_original = $txtNumeroOriginalNaoEditavel;
    }

    //TRATAMENTO PARA O DOCUMENTO MODELO PAI
    if (trim($documento_modelo_pai_id) == '') {
        $documento_modelo_pai_id = 0;
    }

    //QUERY DE ALTERAÇÃO
    $sqlAltera = "
    UPDATE
        documento.documento
    SET
        documento_numero_original                       ='" . $documento_numero_original . "',
        tipo_documento_id                               ='" . $tipo_documento_id . "',
        documento_dt                                    ='" . $documento_dt . "',
        documento_dt_recebimento                        ='" . $documento_dt_recebimento . "',
        assunto_id                                      ='" . $assunto_id . "',
        discriminacao_assunto                           ='" . $discriminacao_assunto . "',
        tipo_origem                                     ='" . $tipo_origem . "',
        origem_orgao_id                                 ='" . $origem_orgao_id . "',
        origem_est_organizacional_id                    ='" . $origem_est_organizacional_id . "',
        qtde_paginas                                    ='" . $qtde_paginas . "',
        documento_dt_alteracao                          =" . $documento_dt_alteracao . ",
        subassunto_id                                   ='" . $subassunto_id . "',
        documento_modelo_pai_id                         =" . $documento_modelo_pai_id . "
    WHERE
        documento_id                                    =" . $documento_id . "";

    //VERIFCA SE A ALTERAÇÃO FOI REALIZADA
    if (pg_query(abreConexao(), $sqlAltera)) {
        //CONSULTA OS INTERESSADOS
        $sqlConsultaInteressados = "
        SELECT
            VDI.interessado_nm
        FROM
            documento.vic_documento_interessado VDI
        WHERE
            VDI.documento_id = " . $documento_id . "
        ORDER BY
            VDI.vic_documento_interessado_dt";

        //REALIZANDO A CONSULTA
        $rsConsultaInteressados = pg_query(abreConexao(), $sqlConsultaInteressados);

        //ASSOCIANDO OS DADOS DA CONSULTA EM UM VETOR
        while ($linhaInteressados = pg_fetch_assoc($rsConsultaInteressados)) {
            //CAPTURA OS DADOS CONSULTADOS
            $interessado_nm_old = trim($linhaInteressados['interessado_nm']);

            //VARIVEI PARA CONTROLE DO REGISTRO
            $encontrei = FALSE;

            //VERIFICA SE O REGISTRO ANTERIOR AINDA EXISTE
            for ($i = 0; $i < count($_SESSION['interessados']); $i++) {
                //CAPTURA OS VALORES A SEREM INSERIDOS
                $interessado_id = $_SESSION['interessados'][$i][0];
                $interessado_nm = trim($_SESSION['interessados'][$i][1]);
                $interessado_tipo = $_SESSION['interessados'][$i][2];

                //VERIFICA SE EXISTE
                if ($interessado_nm_old == $interessado_nm) {
                    $encontrei = TRUE;
                    break;
                }
            }

            //SE NÃO ENCONTROU INCLUI
            if ($encontrei == FALSE) {
                //REMOVE DO BANCO
                $sqlDeletaInteressado = "
                DELETE FROM
                    documento.vic_documento_interessado
                WHERE
                    documento_id = " . $documento_id . " AND
                    interessado_nm = '" . $interessado_nm_old . "'";

                //REALIZANDO A CONSULTA
                pg_query(abreConexao(), $sqlDeletaInteressado);
            }
        }

        //VERIFICA SE ALGUM DOS VALORES DE SESSÃO NÃO ESTÁ NO BANCO
        for ($i = 0; $i < count($_SESSION['interessados']); $i++) {
            //CAPTURA OS VALORES A SEREM INSERIDOS
            $interessado_id = $_SESSION['interessados'][$i][0];
            $interessado_nm = trim($_SESSION['interessados'][$i][1]);
            $interessado_tipo = $_SESSION['interessados'][$i][2];

            //CONSULTA OS INTERESSADOS
            $sqlConsultaInteressado = "
            SELECT
                VDI.interessado_nm
            FROM
                documento.vic_documento_interessado VDI
            WHERE
                VDI.documento_id = " . $documento_id . " AND
                VDI.interessado_nm = '" . $interessado_nm . "'
            ORDER BY
                VDI.vic_documento_interessado_dt";

            //VERIFICA SE NÃO EXISTE CRIA
            $rsConsultaInteressado = pg_query(abreConexao(), $sqlConsultaInteressado);

            //VERIFICA SE ENCONTROU
            if (pg_num_rows($rsConsultaInteressado) == 0) {
                //TRATAMENTO PARA O ID DO INTERESSADO
                if ($interessado_id == "") {
                    $interessado_id = 0;
                }

                //TRATAMENTO PARA A RELAÇÃO DE INTERESSE (TRATAMENTO TEMPORÁRIO)
                if ($i == 0) {
                    $tipo_relacao_interesse_id = 1;
                } else {
                    $tipo_relacao_interesse_id = 'NULL';
                }

                //INCLUI OS INTERESSADOS DO DOCUMENTO
                $sqlInsere = "
                INSERT INTO documento.vic_documento_interessado
                (
                    documento_id,
                    interessado_id,
                    interessado_nm,
                    interessado_tipo,
                    vic_documento_interessado_dt,
                    tipo_relacao_interesse_id
                )
                VALUES
                (
                    " . $documento_id . ",
                    " . $interessado_id . ",
                    '" . $interessado_nm . "',
                    '" . $interessado_tipo . "',
                    NOW(),
                    " . $tipo_relacao_interesse_id . "
                )";

                //VERIFCA SE A CONSULTA FOI REALIZADA
                if (!(pg_query(abreConexao(), $sqlInsere))) {
                    echo "<script>alert ('Erro ao Cadastrar. Caso a Dificuldade Persista, Favor Contactar o Suporte Técnico');</script>";
                }
            }
        }

        //QUERY DE ALTERAÇÃO DO HISTORICO
        $sqlInsere = "
        INSERT INTO documento.documento_historico
        (
            documento_id,
            pessoa_id,
            dt_alteracao,
            tipo_alteracao
        )
        VALUES
        (
            " . $documento_id . ",
            " . $_SESSION['UsuarioCodigo'] . ",
            " . $documento_dt_alteracao . ",
            'C'
        )";

        //VERIFCA SE A INSERÇÃO FOI REALIZADA
        if (!(pg_query(abreConexao(), $sqlInsere))) {
            echo "<script>alert ('Erro ao Editar. Caso a Dificuldade Persista, Favor Contactar o Suporte Técnico');</script>";
        }
    } else {
        echo "<script>alert ('Erro ao Editar. Caso a Dificuldade Persista, Favor Contactar o Suporte Técnico');</script>";
    }

    //RETORNA O NUMERO ALTERADO
    return $numero_documento;
}

//FUNÇÃO PARA CONSULTAR DOCUMENTOS
function F_AcaoConsultarDocumento($documento_id) {
    //REALIZA A CONSULTA DOS DADOS
    $sqlConsultaDocumento = "
    SELECT
        D.documento_id,
        D.documento_numero,
        D.documento_numero_original,
        D.tipo_documento_id,
        TD.tipo_documento_sigla,
        TD.tipo_documento_ds,
        D.cadastro_est_organizacional_id,
        D.cadastro_pessoa_id,
        P.pessoa_nm,
        D.documento_dt,
        D.documento_dt_recebimento,
        D.assunto_id,
        A.assunto_ds,
        D.discriminacao_assunto,
        D.documento_situacao,
        D.documento_dt_criacao,
        D.documento_dt_alteracao,
        D.tipo_origem,
        D.origem_orgao_id,
        D.origem_est_organizacional_id,
        D.qtde_paginas,
        D.documento_dt_alteracao,
        D.subassunto_id,
        SA.subassunto_ds,
        D.responsavel_id,
        D.documento_modelo_pai_id,
        D.numero_original_sistema,
        D.origem_cid_old_setor_id
    FROM
        documento.documento D
            LEFT OUTER JOIN documento.tipo_documento TD ON (D.tipo_documento_id = TD.tipo_documento_id)
            LEFT OUTER JOIN documento.assunto A ON (D.assunto_id = A.assunto_id)
            LEFT OUTER JOIN dados_unico.pessoa P ON (D.cadastro_pessoa_id = P.pessoa_id)
            LEFT OUTER JOIN documento.subassunto SA ON (D.subassunto_id = SA.subassunto_id)
    WHERE
        D.documento_id = " . $documento_id . "
    LIMIT 1";

    //REALIZANDO A CONSULTA
    $rsConsultaDocumento = pg_query(abreConexao(), $sqlConsultaDocumento);

    //ASSOCIANDO OS DADOS DA CONSULTA EM UM VETOR
    $Documento = pg_fetch_assoc($rsConsultaDocumento);

    //RETORNA O VETOR DOS DADOS CONSULTADOS
    return $Documento;
}

//RETORNAR O ID DO DOCUMENTO
function F_RetornaIdDocumento($documento_numero) {
    //QUERY PARA CONSULTA O DOCUMENTO DE ACORDO COM O NUMERO
    $sqlConsulta = 'SELECT documento_id FROM documento.documento WHERE documento_numero = ' . $documento_numero . '';

    //REALIZA A CONSULTA
    $rsConsulta = pg_query(abreConexao(), $sqlConsulta);

    //ASOCIA OS DADOS DA CONSULTA
    $linha = pg_fetch_assoc($rsConsulta);

    //CAPTURA O DADO CONSULTADO
    $documento_id = $linha['documento_id'];

    //RETORNA O ID
    return $documento_id;
}

//**************************************************
//FUNÇÃO PARA CARREGAR OS TIPOS DE DOCUMENTOS
//**************************************************
function f_ComboTodosOsTiposDeDocumento($codigoEscolhido, $NomeCombo, $Tamanho) {
    //DEFINDO O NOME E TAMANHO DO COMBO BOX CONFORME SETADO AO CHAMAR A FUNÇÃO
    echo "<select name=" . $NomeCombo . " style='width:" . $Tamanho . "px;'>";

    //CONSULTA DOS IDS E DAS DESCRIÇÕES DOS TIPOS DE DOCUMENTO EXISTENTES EM REGISTROS DE DOCUMENTOS
    $sql = "SELECT DISTINCT TD.tipo_documento_id,
                            TD.tipo_documento_ds
                FROM documento.tipo_documento TD
                JOIN documento.documento D 
                    ON TD.tipo_documento_id = D.tipo_documento_id
                ORDER BY TD.tipo_documento_ds";

    //REALIZA A CONSULTA
    $rs = pg_query(abreConexao(), $sql);

    //VERIFICA O TAMANHO EM PIXELS PARA IMPRESSÃO CORRETA DA OPÇÃO "SELECIONE"
    if (($Tamanho > 0) && ($Tamanho <= 100)) {
        $AuxTamanho = 0;
    } else if (($Tamanho > 100) && ($Tamanho <= 200)) {
        $AuxTamanho = $Tamanho / 12;
    } else if (($Tamanho > 200) && ($Tamanho <= 300)) {
        $AuxTamanho = $Tamanho / 11;
    } else if (($Tamanho > 300) && ($Tamanho <= 400)) {
        $AuxTamanho = $Tamanho / 10;
    } else if (($Tamanho > 400) && ($Tamanho <= 500)) {
        $AuxTamanho = $Tamanho / 9;
    } else if (($Tamanho > 500) && ($Tamanho <= 600)) {
        $AuxTamanho = $Tamanho / 8;
    } else if ($Tamanho > 600) {
        $AuxTamanho = $Tamanho / 7;
    }

    $StringTracos = "";
    for ($i = 1; $i <= ($AuxTamanho); $i++) {
        $StringTracos .= "-";
    }

    //INICIA A CRIAÇÃO DO COMBO
    echo "<option value=0>[" . $StringTracos . " Selecione " . $StringTracos . "]</option>";

    //PRENCHE O COMBO
    while ($linha = pg_fetch_assoc($rs)) {
        //CAPTURA OS VALORES SETADOS
        $codigo = $linha['tipo_documento_id'];
        $descricao = $linha['tipo_documento_ds'];

        $AuxDescricao = $descricao;

        //VERIFICA SE O VALOR CAPTURADO É O MESMO QUE RECEBIDO PELA FUNÇÃO E MARCA COMO SELECIONADO
        if (((int) $codigoEscolhido) == ((int) $codigo)) {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $codigo . " selected>" . $AuxDescricao . "</option>";
        } else {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $codigo . ">" . $AuxDescricao . "</option>";
        }
    }

    //FINALIZA O COMBO
    echo "</select>";
}

//**************************************************
//FUNÇÃO PARA CARREGAR OS ASSUNTOS CADASTRAVEIS
//**************************************************
function f_ComboAssuntoCadastravel($codigoEscolhido, $NomeCombo, $Tamanho, $Ajax) {
    //DEFINDO O NOME E TAMANHO DO COMBO BOX CONFORME SETADO AO CHAMAR A FUNÇÃO
    echo "<select id=" . $NomeCombo . " name='" . $NomeCombo . "' style=width:" . $Tamanho . "px " . $Ajax . ">";

    //CONSULTA DOS IDS E DAS DESCRIÇÕES DOS ASSUNTOS
    $sql = "
    SELECT
        DISTINCT ON (A.assunto_ds) assunto_ds,
        A.assunto_id
    FROM
        documento.assunto A INNER JOIN documento.subassunto SA ON SA.assunto_id = A.assunto_id
    WHERE
        A.assunto_st = 0 AND
        A.assunto_id <> 0
    ORDER BY
        A.assunto_ds";

    //REALIZA A CONSULTA
    $rs = pg_query(abreConexao(), $sql);

    //VERIFICA O TAMANHO EM PIXELS PARA IMPRESSÃO CORRETA DA OPÇÃO "SELECIONE"
    if (($Tamanho > 0) && ($Tamanho <= 100)) {
        $AuxTamanho = 0;
    } else if (($Tamanho > 100) && ($Tamanho <= 200)) {
        $AuxTamanho = $Tamanho / 12;
    } else if (($Tamanho > 200) && ($Tamanho <= 300)) {
        $AuxTamanho = $Tamanho / 11;
    } else if (($Tamanho > 300) && ($Tamanho <= 400)) {
        $AuxTamanho = $Tamanho / 10;
    } else if (($Tamanho > 400) && ($Tamanho <= 500)) {
        $AuxTamanho = $Tamanho / 9;
    } else if (($Tamanho > 500) && ($Tamanho <= 600)) {
        $AuxTamanho = $Tamanho / 8;
    } else if ($Tamanho > 600) {
        $AuxTamanho = $Tamanho / 7;
    }

    //INICIA A CRIAÇÃO DO COMBO
    echo "<option value=0>[";
    for ($i = 1; $i <= ($AuxTamanho); $i++) {
        echo "-";
    }
    echo " Selecione ";
    for ($i = 1; $i <= ($AuxTamanho); $i++) {
        echo "-";
    }
    echo "]</option>";

    //PRENCHE O COMBO
    while ($linha = pg_fetch_assoc($rs)) {
        //CAPTURA OS VALORES SETADOS
        $codigo = $linha['assunto_id'];
        $descricao = $linha['assunto_ds'];

        //VERIFICA A QUANTIDADE DE PALAVRAS A SEREM MOSTRADAS DE ACORDO COM O TAMANHO
        if (($Tamanho > 0) && ($Tamanho <= 100)) {
            $string = explode(" ", $descricao);
            $AuxDescricao = "$string[0]";
            $AuxDescricao.= " ...";
        } else if (($Tamanho > 100) && ($Tamanho <= 200)) {
            $string = explode(" ", $descricao);
            $AuxDescricao = "$string[0] $string[1]";
            $AuxDescricao.= " ...";
        } else {
            $AuxDescricao = $descricao;
        }

        //VERIFICA SE O VALOR CAPTURADO É O MESMO QUE RECEBIDO PELA FUNÇÃO E MARCA COMO SELECIONADO
        if (((int) $codigoEscolhido) == ((int) $codigo)) {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $codigo . " selected>" . $AuxDescricao . "</option>";
        } else {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $codigo . ">" . $AuxDescricao . "</option>";
        }
    }

    //FINALIZA O COMBO
    echo "</select>";
}

//**************************************************
//FUNÇÃO PARA CARREGAR OS SUBASSUNTOS
//**************************************************
function f_ComboSubAssunto($codigoEscolhido, $codigoMaster, $NomeCombo, $Tamanho) {
    //DEFINDO O NOME E TAMANHO DO COMBO BOX CONFORME SETADO AO CHAMAR A FUNÇÃO
    echo "<select name='" . $NomeCombo . "' style=width:" . $Tamanho . "px>";

    //CONSULTA DOS IDS E DAS DESCRIÇÕES DOS ASSUNTOS
    $sql = "
        SELECT
            subassunto_id,
            subassunto_ds
        FROM
            documento.subassunto
        WHERE
            subassunto_st = 0 AND
            subassunto_id <> 0 AND
            assunto_id = " . $codigoMaster . "
        ORDER BY
            subassunto_ds";

    //REALIZA A CONSULTA
    $rs = pg_query(abreConexao(), $sql);

    //VERIFICA O TAMANHO EM PIXELS PARA IMPRESSÃO CORRETA DA OPÇÃO "SELECIONE"
    if (($Tamanho > 0) && ($Tamanho <= 100)) {
        $AuxTamanho = 0;
    } else if (($Tamanho > 100) && ($Tamanho <= 200)) {
        $AuxTamanho = $Tamanho / 12;
    } else if (($Tamanho > 200) && ($Tamanho <= 300)) {
        $AuxTamanho = $Tamanho / 11;
    } else if (($Tamanho > 300) && ($Tamanho <= 400)) {
        $AuxTamanho = $Tamanho / 10;
    } else if (($Tamanho > 400) && ($Tamanho <= 500)) {
        $AuxTamanho = $Tamanho / 9;
    } else if (($Tamanho > 500) && ($Tamanho <= 600)) {
        $AuxTamanho = $Tamanho / 8;
    } else if ($Tamanho > 600) {
        $AuxTamanho = $Tamanho / 7;
    }

    //INICIA A CRIAÇÃO DO COMBO
    echo "<option value=0>[";
    for ($i = 1; $i <= ($AuxTamanho); $i++) {
        echo "-";
    }
    echo " Selecione ";
    for ($i = 1; $i <= ($AuxTamanho); $i++) {
        echo "-";
    }
    echo "]</option>";

    //PRENCHE O COMBO
    while ($linha = pg_fetch_assoc($rs)) {
        //CAPTURA OS VALORES SETADOS
        $codigo = $linha['subassunto_id'];
        $descricao = $linha['subassunto_ds'];

        //VERIFICA A QUANTIDADE DE PALAVRAS A SEREM MOSTRADAS DE ACORDO COM O TAMANHO
        if (($Tamanho > 0) && ($Tamanho <= 100)) {
            $string = explode(" ", $descricao);
            $AuxDescricao = "$string[0]";
            $AuxDescricao.= " ...";
        } else if (($Tamanho > 100) && ($Tamanho <= 200)) {
            $string = explode(" ", $descricao);
            $AuxDescricao = "$string[0] $string[1]";
            $AuxDescricao.= " ...";
        } else {
            $AuxDescricao = $descricao;
        }

        //VERIFICA SE O VALOR CAPTURADO É O MESMO QUE RECEBIDO PELA FUNÇÃO E MARCA COMO SELECIONADO
        if (((int) $codigoEscolhido) == ((int) $codigo)) {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $codigo . " selected>" . $AuxDescricao . "</option>";
        } else {
            //APRESENTA ITEM SELECIONADO
            echo "<option value=" . $codigo . ">" . $AuxDescricao . "</option>";
        }
    }

    //FINALIZA O COMBO
    echo "</select>";
}

function F_AcaoIncluirDocumentoNovoSistema(
                                             $documento_numero_original
                                            ,$assunto_id
                                            ,$subassunto_id
                                            ,$discriminacao_assunto
                                            ,$tipo_origem
                                            ,$posfixo='D'
                                            ,$documento_tipo_id='85'/*diaria*/
                                            ,$assunto_ds='Comprovação de Diária'
                                            ,$est_organizacional_id=null
                                            ,$pessoa_id_interessado=null
                                            ,$pessoa_nm_interessado=null
        ){
    //echo '$flag_tem_cid';exit;
    
    
    $assunto_id = empty($assunto_id)?'null':"'".$assunto_id."'";
    $subassunto_id = empty($subassunto_id)?'null':"'".$subassunto_id."'";
    $discriminacao_assunto = empty($discriminacao_assunto)?'null':"'".$discriminacao_assunto."'";
    $documento_numero_original = empty($documento_numero_original)?'null':"'".$documento_numero_original."'";
    $tipo_origem = empty($tipo_origem)?'null':"'".$tipo_origem."'";
    $documento_tipo_id = empty($documento_tipo_id)?'null':"'".$documento_tipo_id."'";
    $assunto_ds = empty($assunto_ds)?'null':"'".$assunto_ds."'";
    
    if(!empty($est_organizacional_id)){
        $est_organizacional_id = $_SESSION['est_organizacional_id'];
    }
    
    $sql_documento = "
                    INSERT INTO documento2.documento
                    (
                        
                        documento_numero_original, 
                        documento_tipo_id,
                        cadastro_pessoa_id,
                        documento_dt,
                        documento_recebimento_dt,
                        assunto_id,
                        subassunto_id,
                        discriminacao_assunto,
                        tipo_origem,
                        origem_orgao_pessoa_id,
                        origem_est_organizacional_id,
                        qtde_paginas,
                        responsavel_id,                        
                        documento_resumo_assunto,
                        cadastro_est_organizacional_id,
                        local_est_organizacional_id,
                        documento_numero_dup,
                        documento_id_pai,
                        documento_situacao,
                        local_temp_est_organizacional_id,
                        flag_possui_copia,
                        flag_copia
                    )
                    VALUES
                    (
                        
                        $documento_numero_original, 
                        $documento_tipo_id, 
                        ".$_SESSION['pessoa_id'].",
                        '".date('Y-m-d')."' ,
                        '".date('Y-m-d')."' ,
                        $assunto_id,
                        $subassunto_id,
                        $discriminacao_assunto,
                        $tipo_origem,
                        787,/*SDR - SECRETARIA DE DESENVOLVIMENTO RURAL*/
                        null,
                        1,
                        null,                        
                        $assunto_ds,
                        ".$_SESSION['est_organizacional_id'].",
                        ".$_SESSION['est_organizacional_id'].",
                        null,
                        null,
                        0,
                        ".$_SESSION['est_organizacional_id'].",
                        0,
                        0
                    ) RETURNING documento_id";
    
    //echo_pre($sql_documento);exit;
    
     $rsConsulta = pg_query(abreConexao(), $sql_documento);

    //ASSOCIANDO OS DADOS DA CONSULTA EM UM VETOR
    $Documento = pg_fetch_assoc($rsConsulta);
    
    $documento_id = $Documento['documento_id'];
    
    $cid = '1540'.date('y'); 
    $complemento_cid = 8 - strlen($documento_id);
    for ($i = 0; $i < $complemento_cid; $i++) {
        $cid .= '0';
    }
    
    $cid .= $documento_id.$posfixo;
    $sql_update = " 
                update documento2.documento
                    set documento_numero = '$cid'
                where documento_id = $documento_id";
    //echo_pre($sql_update);exit;
    $rsConsulta = pg_query(abreConexao(), $sql_update);
    
    $documento_ret['documento_id']      = $documento_id;
    $documento_ret['documento_numero']  = $cid;
    
    
    ///insere o interessado padrao
    if(!empty($pessoa_id_interessado)){
        $sql = "insert into documento2.interessado(
                                documento_id
                                ,interessado_nm
                                ,pessoa_id
                    ) 
                    values(
                          $documento_id
                        ,'$pessoa_nm_interessado'
                        ,'$pessoa_id_interessado'
                    
                )
                 "; 
        //echo_pre($sql);exit;
        pg_query(abreConexao(), $sql);
        
    }
    
    
    
    return $documento_ret;
    
}


?>