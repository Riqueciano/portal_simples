<?php
function f_diferenca_date($start, $end)
{
        // para o funcionamento desta função a data te que estar no formato
        // date("Y-m-d");
        $sdate = strtotime($start);
        $edate = strtotime($end);

        $time = $edate - $sdate;
        if($time>=0 && $time<=59) {
                // Seconds
                //$timeshift = $time.' seconds ';
                $time = array ("Seg"=>round($sec,0));

        } elseif($time>=60 && $time<=3599) {
                // Minutes + Seconds
                $pmin = ($edate - $sdate) / 60;
                $premin = explode('.', $pmin);

                $presec = $pmin-$premin[0];
                $sec = $presec*60;

                //$timeshift = $premin[0].' min '.round($sec,0).' sec ';
                $time = array ("Min"=> $min[0], "Seg"=>round($sec,0));

        } elseif($time>=3600 && $time<=86399) {
                // Hours + Minutes
                $phour = ($edate - $sdate) / 3600;
                $prehour = explode('.',$phour);

                $premin = $phour-$prehour[0];
                $min = explode('.',$premin*60);

                $presec = '0.'.$min[1];
                $sec = $presec*60;

                //$timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';
                $time = array ("Hora"=>$prehour[0],"Min"=> $min[0], "Seg"=>round($sec,0));

        } elseif($time>=86400) {
                // Days + Hours + Minutes
                $pday = ($edate - $sdate) / 86400;
                $preday = explode('.',$pday);

                $phour = $pday-$preday[0];
                $prehour = explode('.',$phour*24);

                $premin = ($phour*24)-$prehour[0];
                $min = explode('.',$premin*60);

                $presec = '0.'.$min[1];
                $sec = $presec*60;

                //$timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';
                $time = array ("Dias"=>$preday[0], "Hora"=>$prehour[0],"Min"=> $min[0], "Seg"=>round($sec,0));

        }
        return $time; // retorna um array.
}

function CancelaSolicitacoesAntigas()
{//Esta função serve para o sistema de transporte
    
    $data = date("Y-m-d");
    $time = date("H:i:s");
    
    $sqlConsulta     = "SELECT * FROM seguranca.verificacao_diaria WHERE sistema_id = 3";
    $rsConsulta      = pg_query(abreConexao(),$sqlConsulta);
    $linharsConsulta = pg_fetch_assoc($rsConsulta);

    if (($linharsConsulta['verificacao_diaria_dt'] != $data) || ($linharsConsulta['verificacao_diaria_dt'] == NULL))
    {
        $sqlConsulta1 = "SELECT * FROM transporte.solicitacao WHERE solicitacao_situacao <= 3 AND solicitacao_st <= 1";
        $rsConsulta1  = pg_query(abreConexao(),$sqlConsulta1);

        while($linharsConsulta1 = pg_fetch_assoc($rsConsulta1))
        {
            $Codigo                 = $linharsConsulta1['solicitacao_id'];
            $Codigodata             = $linharsConsulta1['solicitacao_numero'];
            $solicitacao_obs_gestor = $linharsConsulta1['solicitacao_obs_gestor'];

            $dateOLD    = substr($linharsConsulta1['solicitacao_saida_dt_prevista'],0,10);
            $resultado  = f_diferenca_date($dateOLD, $data);
            $Mensagem1 = "ALTERAÇÃO DA SV: ".$Codigodata.", MODIFICADA POR: ".$_SESSION['UsuarioNome'].". DIAS DE ATRASO: ".$resultado["Dias"];


            if ($resultado["Dias"] > 7)
            {
                $BeginTrans= "BEGIN WORK";
                pg_query(abreConexao(),$BeginTrans);

                if (strlen($solicitacao_obs_gestor)+strlen($Mensagem1) > 253)
                {
                   $Mensagem = trim($solicitacao_obs_gestor);
                }
                else
                {
                   $Mensagem = trim($solicitacao_obs_gestor)." ".$Mensagem1;
                }

                if (strlen ($Mensagem)> 253)
                {//REDUNDÂNCIA PARA GARANTIR QUE A MENSAGEM NÃO PASSE DE 255 CARACTERES
                   $Mensagem = trim($solicitacao_obs_gestor)." VERIFICAR LOG.";
                }

                $sqlAltera = "UPDATE transporte.solicitacao SET solicitacao_st = 2, solicitacao_obs_gestor = '".trim($Mensagem)."' WHERE (solicitacao_situacao <= 3 OR solicitacao_devolvida = 1) AND solicitacao_id = ".$Codigo;
                $sqlAltera = strtoupper($sqlAltera);
                pg_query(abreConexao(),$sqlAltera);

                $sqlInsere = "INSERT INTO transporte.transporte_log(solicitacao_id,
                                                                    usuario_id,
                                                                    transporte_log_ds,
                                                                    transporte_log_dt,
                                                                    transporte_log_hr)
                                                            VALUES (".$Codigo.",
                                                                    ".$_SESSION['UsuarioCodigo'].",
                                                                    '".trim($Mensagem)."',
                                                                    '".$data."',
                                                                    '".$time."')";
                $sqlInsere = strtoupper($sqlInsere);
                pg_query(abreConexao(),$sqlInsere);

                If ($Err != 0)
                {
                   $RollbackTrans = "ROLLBACK";
                   pg_query(abreConexao(),$RollbackTrans);

                   echo $Err;
                }
                Else
                {
                   $CommitTrans="COMMIT";
                   pg_query(abreConexao(),$CommitTrans);
                }
            }//IF dentro do WHILE
        } //WHILE

        if (pg_num_rows($rsConsulta) != 0 )
        {//Se houver registro apenas irá alterar o Usuário, data e hora da alteração
            $sqlUPDATE = "UPDATE seguranca.verificacao_diaria 
                            SET pessoa_id = ".$_SESSION['UsuarioCodigo'].", verificacao_diaria_dt = '".$data."',
                                verificacao_diaria_hr = '".$time."'
                            WHERE sistema_id = ".$_SESSION['Sistema'];
            pg_query(abreConexao(),$sqlUPDATE);
            ?>
             <script > window.location="SolicitarGestaoInicio.php"</script>
            <?php
        }
        else
        {//Se não houver registro insere o mesmo.
            $sqlInsere = "INSERT INTO seguranca.verificacao_diaria(sistema_id, pessoa_id, verificacao_diaria_dt, verificacao_diaria_hr)
                            VALUES (".$_SESSION['Sistema'].", ".$_SESSION['UsuarioCodigo'].", '".$data."', '".$time."');";
            $sqlInsere = strtoupper($sqlInsere);
            pg_query(abreConexao(),$sqlInsere);
            ?>
             <script > window.location="SolicitarGestaoInicio.php"</script>
            <?php
        }
    }//IF
}//Fim da FUNÇÂO

function EmpenhoPrevio(){
$dataAtual   = date("d/m/Y");
$data        = date("Y-m-d");
$time        = date("H:i:s");
$funcionario = $_SESSION['UsuarioCodigo'];

    $sqlConsulta     = "SELECT * FROM seguranca.verificacao_diaria WHERE sistema_id = 2";
    $rsConsulta      = pg_query(abreConexao(),$sqlConsulta);
    $linharsConsulta = pg_fetch_assoc($rsConsulta);

    if (($linharsConsulta['verificacao_diaria_hr'] != $time) || ($linharsConsulta['verificacao_diaria_dt'] == NULL))
    {
         $sqlConsulta0 = "SELECT * FROM dados_unico.rotina_programada p
                                 JOIN dados_unico.rotina_horario h
                                 ON p.id_horario = h.id_horario
                                 WHERE status = 0";
         $rsConsulta0 = pg_query(abreConexao(),$sqlConsulta0);
         while($linhaConsulta0=pg_fetch_assoc($rsConsulta0)){
             $hora = $linhaConsulta0['horario'];
         }
         
         if ($time > $hora ){
             $sqlConsulta = "SELECT diaria_id, empenho_previo
                                 FROM diaria.diaria
                                 WHERE ((diaria_st = 0 OR diaria_st = 1) AND empenho_previo = 0)
                                   AND diaria_cancelada = 0
                                   AND diaria_excluida = 0
                                   AND diaria_dt_saida = '".$dataAtual."'";
                                   
             $rConsulta = pg_query(abreConexao(),$sqlConsulta);

             while($linhaConsulta=pg_fetch_assoc($rConsulta)) {
                 $codigo = $linhaConsulta['diaria_id'];
                 $sqlUpdate = "UPDATE diaria.diaria
                                  SET empenho_previo = 1
                                WHERE diaria_id =".$codigo;
                 pg_query(abreConexao(),$sqlUpdate);

                 $sqlInsere = "INSERT INTO diaria.diaria_empenho_previo
                                      (diaria_id,
                                       diaria_empenho_previo_func,
                                       diaria_empenho_previo_dt,
                                       diaria_empenho_previo_hr)
                                     VALUES (".$codigo.", ".$funcionario.",
                                             '".$dataAtual."', '".$time."');";
                 pg_query(abreConexao(),$sqlInsere);
             }
             if (pg_num_rows($rConsulta) != 0){
                 if (pg_num_rows($rsConsulta) != 0)
                {//Se houver registro apenas irá alterar o Usuário, data e hora da alteração
                    $sqlUPDATE = "UPDATE seguranca.verificacao_diaria
                                    SET pessoa_id = ".$_SESSION['UsuarioCodigo'].", verificacao_diaria_dt = '".$data."',
                                        verificacao_diaria_hr = '".$time."'
                                    WHERE sistema_id = ".$_SESSION['Sistema'];
                    pg_query(abreConexao(),$sqlUPDATE);
                    ?>
                     <script > window.location="SolicitacaoGestaoInicio.php?acao=buscar"</script>
                    <?php
                }
                else
                {//Se não houver registro insere o mesmo.
                    $sqlInsere = "INSERT INTO seguranca.verificacao_diaria(sistema_id, pessoa_id, verificacao_diaria_dt, verificacao_diaria_hr)
                                    VALUES (".$_SESSION['Sistema'].", ".$_SESSION['UsuarioCodigo'].", '".$data."', '".$time."');";
                    $sqlInsere = strtoupper($sqlInsere);
                    pg_query(abreConexao(),$sqlInsere);
                    ?>
                     <script > window.location="SolicitacaoGestaoInicio.php?acao=buscar"</script>
                    <?php
                }
             }else{
                 ?>
                 <script > window.location="SolicitacaoGestaoInicio.php?acao=buscar"</script>
                <?php
             }
        }    
    }
}
/************************************************************************************************/
// Esta função subitrai ou adiciona apenas dias úteis a partir de uma data inicial.
/************************************************************************************************/
function Verifica_Dias_Uteis($data,$int_qtd_dias,$sinal) {
/*
 * $data         - É a data de inicio da verificação e que deve estar no padrão americano ? aaaa-mm-dd.
 * $int_qtd_dias - É um inteiro que será a quantidade de dias uteis que deverão ser adicionados ou subitraidos da data passada.
 * $sinal        - É o sinal de - ou + para informar para onde a função deve ir, retroceder com o sinal de MENOS (-) ou avançar com o sinal de MAIS (+).
 * gmdate        - string gmdate ( string $format [, int $timestamp ] ) Idêntica a função date() exceto que o tempo está em Greenwich Mean Time (GMT).



*/
    $array_data = explode('-', $data);
    $count_days = 0;
    $int_qtd_dias_uteis = 0;

    while ( $int_qtd_dias_uteis < $int_qtd_dias )
    {
        $count_days++;

            if($sinal == '-')
            {
                if ( ( $dias_da_semana = gmdate('w', strtotime('-'.$count_days.' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6' )
                {
                    $sqlConsultaFeriado = "
                                            SELECT
                                                    feriado_id
                                            FROM
                                                dados_unico.feriado
                                            WHERE
                                                SUBSTRING(CAST(feriado_dt as varchar) FROM 6 FOR 10) = SUBSTRING(CAST(to_date('". gmdate('Y/m/d',strtotime('+'.$count_days.' day',strtotime($data)))."','DD/MM/YYY') as varchar) FROM 6 FOR 10)";

                    $rsConsultaFeriado=pg_query(abreConexao(),$sqlConsultaFeriado);
                    $linha=pg_num_rows($rsConsultaFeriado);

                    if($linha != 0)
                    {
                        $int_qtd_dias_uteis -1;
                    }
                    
                    $int_qtd_dias_uteis++;
                }
            }
            else
            {
                if ( ( $dias_da_semana = gmdate('w', strtotime('+'.$count_days.' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6' ) 
                {
                    $sqlConsultaFeriado = "
                                            SELECT
                                                    feriado_id
                                            FROM
                                                dados_unico.feriado
                                            WHERE
                                                SUBSTRING(CAST(feriado_dt as varchar) FROM 6 FOR 10) = SUBSTRING(CAST(to_date('". gmdate('Y/m/d',strtotime('+'.$count_days.' day',strtotime($data)))."','DD/MM/YYY') as varchar) FROM 6 FOR 10)";

                    $rsConsultaFeriado=pg_query(abreConexao(),$sqlConsultaFeriado);
                    $linha=pg_num_rows($rsConsultaFeriado);

                    if($linha != 0)
                    {
                        $int_qtd_dias_uteis -1;
                    }
                    
                    $int_qtd_dias_uteis++;
                }
            }
    }

    if($sinal == '-')
    {
        return gmdate('d/m/Y',strtotime('-'.$count_days.' day',strtotime($data)));
    }
    else
    {
        return gmdate('d/m/Y',strtotime('+'.$count_days.' day',strtotime($data)));
    }
}
//Fim da função.
?>