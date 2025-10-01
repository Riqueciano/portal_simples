<?php
function buscarDadosGer($ger_id, $ContaContabil)
{
     $SqlConsulta = "Select ger_banco,ger_agencia, ger_conta, conta_contabil from diaria.ger where ger_id =".(int)$ger_id;
     $rs =  pg_query(abreConexao(),$SqlConsulta);
     $linhaConsulta = pg_fetch_assoc($rs);

     if($linhaConsulta)
     {
          if ($ContaContabil == 1)
          {
              $GERContaContabil = $linhaConsulta['conta_contabil'];
              return $GERContaContabil;
          }
          else
          {
              $GERBanco = $linhaConsulta['ger_banco'];
              $GERAG    = $linhaConsulta['ger_agencia'];
              $GERConta = $linhaConsulta['ger_conta'];
              $GERDados = " Bco: ".$GERBanco.", Ag: ".$GERAG.", CC: ".$GERConta;
              return $GERDados;
          }
     }
}

function buscarDadosBancarios($DadosBancariosID)
    {
        $DadosBancarios = "";
        $sqlConsulta = "SELECT banco_cd, dados_bancarios_agencia, dados_bancarios_conta
                                 FROM dados_unico.dados_bancarios db, dados_unico.banco b
                                 WHERE db.banco_id = b.banco_id AND dados_bancarios_id = ".$DadosBancariosID;
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        $linhars=pg_fetch_assoc($rsConsulta);
        If($linhars)
        {
            $BancoCod   = $linhars['banco_cd'];
            $BancoAG    = $linhars['dados_bancarios_agencia'];
            $BancoConta = $linhars['dados_bancarios_conta'];
            $DadosBancarios = "Bco: ".$BancoCod.", AG: ".$BancoAG.", CC: ". $BancoConta;
            return  $DadosBancarios;
        }
    }
?>
