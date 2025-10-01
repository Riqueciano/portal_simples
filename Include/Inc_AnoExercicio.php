<?php
   /*
    * Select Distinct : seleciona os valores distintos encontrados no BD
    * Substring: retorna uma substring da variável passada (atributos for é um LOOP FOR do 1º caractere ate o 4º)
    * date_part: retorna a parte que for especificada, neste caso o ANO "year" do atributo d.diaria_dt_criacao
   */

  switch ($_SESSION['Sistema'])
  {
      case 2: SistemaDiarias(); break;
      case 3: SistemaTransporte(); break;
        //terminar com os demais sistemas...
  }

//Combo dinamico do Sistema de Diária (ANO)
function SistemaDiarias ()
{
    $codigoEscolhido = date("Y");
    
    echo "<select id='cmbAnoSolicitacao' name='cmbAnoSolicitacao' style=width:55px>";
    
    $sql = "SELECT DISTINCT SUBSTRING(d.diaria_dt_criacao FROM 1 FOR 4) AS diaria_dt_criacao FROM diaria.diaria d
                WHERE DATE_PART('year',d.diaria_dt_criacao) = (SUBSTRING(d.diaria_dt_criacao FROM 1 FOR 4))";
    $rs  = pg_query(abreConexao(),$sql);
    
    While ($linha = pg_fetch_assoc($rs))
    {
        $ano = $linha['diaria_dt_criacao'];
        
        if ($codigoEscolhido == $ano)
        { 
            echo "<option value=".$ano." selected>".$ano."</option>";
        }
        else
        {	
            echo "<option value=".$ano.">".$ano."</option>";
        }
    }
    echo "</select>";
}
//Combo dinamico do Sistema de Transporte (ANO)

function SistemaTransporte ()
{
    $codigoEscolhido = date("Y");
    
    echo "<select id='cmbAnoSolicitacao' name='cmbAnoSolicitacao' style=width:55px>";
    
    $sql = "SELECT DISTINCT SUBSTRING(t.solicitacao_dt FROM 1 FOR 4) AS solicitacao_dt FROM transporte.solicitacao t
                WHERE DATE_PART('year',t.solicitacao_dt) = (SUBSTRING(t.solicitacao_dt FROM 1 FOR 4))";
    $rs  = pg_query(abreConexao(),$sql);
    
    While ($linha = pg_fetch_assoc($rs))
    {
        $ano = $linha['solicitacao_dt'];
        
        if ($codigoEscolhido == $ano)
        {
            echo "<option value=".$ano." selected>".$ano."</option>";
        }
        else
        {
            echo "<option value=".$ano.">".$ano."</option>";
        }
    }
    echo "</select>";
}
?>