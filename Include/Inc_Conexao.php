<?php

//definir variï¿½veis
define('TITULO_SISTEMA', 'GESTOR');
define('TITULO_ABREV', 'SDR');
define('TITULO_DESC', 'Secretaria de Desenvolvimento Rural');
define('TITULO_TOTAL', TITULO_ABREV . " - " . TITULO_DESC);
define('Keywords', '');



function env()
{
    $caminho_env = $_SERVER['DOCUMENT_ROOT'] . '/_portal/.ENV';

    if (!file_exists($caminho_env)) {
        die("Arquivo .ENV não encontrado");
    }

    $envContent = file_get_contents($caminho_env);

    $env = [];
    $lines = explode("\n", $envContent);

    foreach ($lines as $line) {
        $line = trim($line);
        // Ignorar linhas vazias ou comentários
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        // Quebrar em chave=valor
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $env[trim($key)] = trim($value);
        }
    }
    return $env;
}



//abre conexao
function abreConexao()
{ //ECHO 1;
    $env = env();
    $conexao = pg_connect("host=localhost dbname=bd_gestor_sdr port=5433 user=postgres password=".$env['DB_PASSWORD']) or die("Conexao com o banco falhou! <input type='button' value='TENTAR NOVAMENTE' class='btn btn-danger' onclick='location.reload();'>");
    return $conexao;
}

class ConexaoBD
{

    private $conexao = null;

    public function __construct() {}

    public function query($query)
    {
        $env = env();
        try {
            if (!$this->conexao) {
                $this->conexao = pg_connect("host=127.0.0.1 dbname=bd_gestor_sdr port=5433 user=postgres password=".$env['DB_PASSWORD']);
            }
            $result = pg_query($query);
            return $result;
        } catch (Exception $e) {
            throw new exception($e->getMessage(), $e->getCode());
        }
    }
}

class ConectaBanco
{

    public $conexao = null;
    public $resultado;
    private $tabela;
    private $esquema;
    public $nLinha = 0;
    private $orderBy;
    private $groupBy;
    public $stmtSQL = "";
    private $contTabela = 0;

    function __construct($tabela, $esquema)
    {
        $this->contTabela = count($tabela);
        for ($i = 0; $i < $this->contTabela; $i++) {
            $this->tabela[$i] = $tabela[$i];
            $this->esquema[$i] = $esquema[$i];
        }
    }

    //ABRE A CONEXï¿½O
    function open()
    {
        $env = env();
        //nao usa esse
        $this->conexao = pg_connect("host=127.0.0.1 dbname=bd_gestor_sdr port=5433 user=postgres password=".$env['DB_PASSWORD']) or die("Conexao com o banco falhou! Clique em F5 ou tente novamente mais tarde");
    }

    //FECHA A CONEXï¿½O
    function close()
    {
        @pg_close($this->conexao);
    }

    // public function inserir($objeto)
    // {
    //     for ($i = 0; $i < $this->contTabela; $i++) {
    //         //Recupera os nomes das colunas da tabela
    //         $this->resultado = pg_query("select column_name, data_type from information_schema.columns where table_name  = '" . $this->tabela[$i] . "' and table_schema = '" . $this->esquema[$i] . "'");
    //         //Preenche a var campos com os nomes das colunas
    //         $campos = null;
    //         $values = null;
    //         while ($coluna = pg_fetch_array($this->resultado)) {
    //             if ($objeto->$coluna["column_name"] != "") {
    //                 $campos .= $coluna["column_name"] . ",";
    //                 //verificar os tipos aceitos no postegre pois no sql ï¿½ diferente exemplo nvarchar nï¿½o existe no postegre
    //                 if ($coluna["data_type"] == "char" or $coluna["data_type"] == "character varying" or $coluna["data_type"] == "character" or $coluna["data_type"] == "text" or $coluna["data_type"] == "date" or $coluna["data_type"] == "time without time zone") {
    //                     $values .= "'" . $objeto->$coluna['column_name'] . "',";
    //                 } else {
    //                     $values .= $objeto->$coluna['column_name'] . ",";
    //                 }
    //             }
    //         }
    //         //localiza a ultima virgula
    //         $vCampos = strrpos($campos, ",");
    //         $vValues = strrpos($values, ",");
    //         //remove a ultima virgula
    //         $campos = substr($campos, 0, $vCampos);
    //         $values = substr($values, 0, $vValues);
    //         //cria a declaracao de insercao
    //         $insereSQL = "INSERT INTO " . $this->esquema[$i] . "." . $this->tabela[$i] . "(" . $campos . ") VALUES (" . $values . ") ";
    //         //executa insercao de registro na tabela
    //         $this->resultado = pg_query($this->conexao, $insereSQL);
    //     }
    // }

    // public function selecionaID($condicao)
    // {
    //     $esqtab = "";
    //     for ($i = 0; $i < $this->contTabela; $i++) {
    //         $esqtab .= $this->esquema[$i] . '.' . $this->tabela[$i] . ' "' . $i . '"';

    //         if ($i < ($this->contTabela - 1)) {
    //             $esqtab = ", ";
    //         }
    //     }
    //     //cria a declaracao de remocao
    //     $selecionaSQL = "SELECT * FROM " . $esqtab . " WHERE " . $condicao;
    //     //executa remocao de registro da tabela
    //     $this->resultado = pg_query($this->conexao, $selecionaSQL);
    // }

    // public function selecionar($campos, $condicao)
    // {
    //     //se campos for vazio, busca todos os campos da tabela
    //     if ($campos == "") {
    //         $selCampos = "*";
    //     } else {
    //         $selCampos = $campos;
    //     }

    //     $esqtab = "";

    //     for ($i = 0; $i < $this->contTabela; $i++) {
    //         $esqtab .= $this->esquema[$i] . '.' . $this->tabela[$i] . ' "' . $i . '"';
    //         if ($i < ($this->contTabela - 1)) {
    //             $esqtab .= ", ";
    //         }
    //     }
    //     //cria a declaracao de consulta
    //     if ($condicao != "") {
    //         $selecionaSQL = "SELECT " . $selCampos . " FROM " . $esqtab . " WHERE " . $condicao;
    //     } else {
    //         $selecionaSQL = "SELECT " . $selCampos . " FROM " . $esqtab;
    //     }
    //     $selecionaSQL .= $this->orderBy;
    //     $selecionaSQL .= $this->groupBy;
    //     $this->stmtSQL = $selecionaSQL;
    //     //executa consulta de registro na tabela
    //     $this->resultado = pg_query($this->conexao, $selecionaSQL);
    // }

    // public function atualizar($objeto, $condicao)
    // {
    //     for ($i = 0; $i < $this->contTabela; $i++) {
    //         //Recupera os nomes das colunas da tabela
    //         $this->resultado = pg_query("select column_name, data_type from information_schema.columns where table_name  = '" . $this->tabela[$i] . "' and table_schema = '" . $this->esquema[$i] . "'");
    //         //Preenche a var campos com os nomes das colunas
    //         while ($coluna = pg_fetch_array($this->resultado)) {
    //             if ($objeto->$coluna["column_name"] != "") {
    //                 if ($coluna["data_type"] == "char" or $coluna["data_type"] == "character varying" or $coluna["data_type"] == "character" or $coluna["data_type"] == "text" or $coluna["data_type"] == "date" or $coluna["data_type"] == "time without time zone") {
    //                     $campos .= $coluna["column_name"] . "='" . $objeto->$coluna['column_name'] . "',";
    //                 } else {
    //                     $campos .= $coluna["column_name"] . "=" . $objeto->$coluna['column_name'] . ",";
    //                 }
    //             }
    //         }
    //         //localiza a ï¿½ltima virgula
    //         $posicao = strrpos($campos, ",");
    //         //remove a ultima virgula
    //         $campos = substr($campos, 0, $posicao);
    //         //cria a declaracao de insercao
    //         $atualizaSQL = "UPDATE " . $this->esquema[$i] . "." . $this->tabela[$i] . " SET " . $campos . " WHERE " . $condicao;
    //         //executa atualizacao de registro na tabela
    //         $this->resultado = pg_query($this->conexao, $atualizaSQL);
    //     }
    // }

    // public function alterarCampo($alteracao, $condicao)
    // {
    //     for ($i = 0; $i < $this->contTabela; $i++) {
    //         if ($condicao != "") {
    //             $atualizaSQL = "UPDATE " . $this->esquema[$i] . "." . $this->tabela[$i] . " SET " . $alteracao . " WHERE " . $condicao;
    //         } else {
    //             $atualizaSQL = "UPDATE " . $this->esquema[$i] . "." . $this->tabela[$i] . " SET " . $alteracao;
    //         }

    //         $this->resultado = pg_query($this->conexao, $atualizaSQL);
    //     }
    // }

    // public function orderBy($orderBy)
    // {
    //     $order = " ORDER BY " . $orderBy;
    //     $this->orderBy = $order;
    // }

    // public function remover($condicao)
    // {
    //     for ($i = 0; $i < $this->contTabela; $i++) {
    //         $removeSQL = "DELETE FROM " . $this->esquema[$i] . "." . $this->tabela[$i] . " WHERE " . $condicao;
    //         $this->resultado = pg_query($this->conexao, $removeSQL);
    //     }
    // }

    // public function query($query)
    // {
    //     $this->open();
    //     $this->resultado = pg_query($this->conexao, $query);
    //     $this->close();
    //     return $this->resultado;
    // }
}
