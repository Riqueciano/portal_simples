<?php
include_once "Inc_Conexao.php";


function checaAcesso($id)
{
    if( isset($_SESSION["Sistemas"][$id]) )
        return true;
    else
        return false;
}

/*
 * Inverte a data normal para o formato de banco de dados:
 * Ex.: 03/09/2010 -> 2010-09-03
 */
function dataToDB($data)
{
    $data = trim($data);
    return str_replace('--','',$data[6].$data[7].$data[8].$data[9]."-".$data[3].$data[4]."-".$data[0].$data[1]);
}

/*
 * Inverte a data do banco de dados para o formato 'normal':
 * Ex.: 2010-09-03 -> 03/09/2010
 */
function DBToData($data, $simbolo = "/")
{
    $data = trim($data);
    return str_replace('//','',$data[8].$data[9].$simbolo.$data[5].$data[6].$simbolo.$data[0].$data[1].$data[2].$data[3]);
}

function DBToDataHora($data, $simbolo = "/")
{
    $data = trim($data);
    return str_replace('//','',$data[8].$data[9].$simbolo.$data[5].$data[6].$simbolo.$data[0].$data[1].$data[2].$data[3]) .' - '. substr($data,10,9)  ;
}

/*
 * Inverte a data do Timestamp para o formato normal e retorna um vetor com a data e a hora:
 * Ex.: 2010-09-03 00:00:00 -> ["Data"] => 03/09/2010 ["Hora"] => 00:00:00
 */
function TimestampToData($timestamp, $simbolo = "/")
{
    $ret["Data"] = $timestamp[8].$timestamp[9].$simbolo.$timestamp[5].$timestamp[6].$simbolo.$timestamp[0].$timestamp[1].$timestamp[2].$timestamp[3];
    $ret["Hora"] = $timestamp[11].$timestamp[12].$timestamp[13].$timestamp[14].$timestamp[15].$timestamp[16].$timestamp[17].$timestamp[18];
    return $ret;
}

//$conexao = new ConexaoBD();

if(isset($_REQUEST["acao"]))
{
    $acao = $_REQUEST["acao"];

    switch($acao)
    {
        case "buscaCPF":
            if(isset($_POST["cpf"]))
            {
                $cpf = $_POST["cpf"];
                $sqlConsulta = "SELECT f.pessoa_id,funcionario_tipo_id FROM dados_unico.pessoa_fisica p,dados_unico.funcionario f WHERE p.pessoa_id = f.pessoa_id and pessoa_fisica_cpf = '".$cpf."'";
                $result = pg_query(abreConexao(),$sqlConsulta);
                $linha  = pg_fetch_assoc($result);
                if($linha)
                {
                    if ($linha['funcionario_tipo_id'] == 1)
                        echo "FP"; // Funcionário Permanente.
                    elseif ($linha['funcionario_tipo_id'] == 2)
                        echo 'FTE';// Funcionário Temporário.
                    elseif ($linha['funcionario_tipo_id'] == 3)
                        echo 'FT'; // Funcionario Terceirizado.
                    elseif ($linha['funcionario_tipo_id'] == 7)
                        echo 'FE'; // Funcionario Estagiário.
                    elseif ($linha['funcionario_tipo_id'] == 10)
                        echo 'FEV';// Funcionario Eventual.
                }
                else
                {
                    $sqlConsulta = "SELECT pessoa_id FROM dados_unico.pessoa_fisica p WHERE pessoa_fisica_cpf = '".$cpf."'";
                    $result = pg_query(abreConexao(),$sqlConsulta);
                    $linha  = pg_fetch_assoc($result);
                    if($linha)
                        echo 'PF'; //Pessoa Física .
                    else
                        echo "NE"; //Não encontrado.
                }
            }
        break;
        case "carregaCPFPessoa": 
            
                $funcionarioId = $_GET["funcionarioId"];
            //echo  2;exit;
                $sqlConsulta = "
                                select 
                                        pf.pessoa_fisica_cpf
                                       ,f.funcionario_id  
                                 from dados_unico.pessoa_fisica pf
                                    inner join dados_unico.funcionario f
                                         on pf.pessoa_id = f.pessoa_id
                                    where f.funcionario_id = ".$funcionarioId."
                                    limit 1
                              ";
                
                $result = @pg_query(abreConexao(),$sqlConsulta);
                $linha  = @pg_fetch_assoc($result);
                if($linha){
                    echo $linha['pessoa_fisica_cpf'];;
                }
        break;

        case "buscaMatricula":
            if(isset($_POST["matricula"]))
            {
                $matricula  = $_POST["matricula"];
                $sqlConsulta = "SELECT * FROM dados_unico.funcionario WHERE funcionario_matricula = '".$matricula."'";
                $result     = pg_query(abreConexao(), $sqlConsulta);
                if(pg_fetch_assoc($result))
                    echo "Existe";
                else
                    echo "Nao existe";
            }
        break;
    }
}
?>