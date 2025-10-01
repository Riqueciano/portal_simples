<?php
// LOGADO
if (!empty($_SESSION['UsuarioCodigo']))
{
    //DIVIDE O NOME EM PARTES DE NOMES E SOBRENOMES
    $pessoa_nm = explode(" ", $_SESSION['UsuarioNome']);

    //CAPTURA A QUANTIDADE DE ELEMENTOS DO NOME
    $QtdElementos = count($pessoa_nm);

    //VERIFICA SE O NOME TEM APENAS UM ELEMENTO
    if ($QtdElementos <= 1)
    {
        //CAPTURA O NOME
        $pessoa_nm_trunc = $linha['pessoa_nm'];
    }
    else if ($QtdElementos > 1)
    {
        //CAPTURA O PRIMEIRO E ULTIMO NOME
        $pessoa_nm_trunc = $pessoa_nm[0]." ".$pessoa_nm[$QtdElementos - 1];
    }

    //APRESENTA TEXTO DE USUÁRIO
    $usuario = '<span class="text_saudacao_usuario">Ol&aacute;,</span> <strong>'.ucwords(strtolower($pessoa_nm_trunc)).'</strong>';

   //APRESENTA TEXTO DE AÇÕES

   //VERIFICA O SISTEMA
    if(!empty($_SESSION['Sistema']))
    {

      $Sistema = @$_SESSION['Sistema'];
        //include_once '../Include/Inc_Conexao.php';
           $sqlConsultaTopo = "SELECT
                            sistema_nm,
                            sistema_id
                            FROM seguranca.sistema
                            WHERE sistema_id =".$Sistema;

            $rsConsultaTopo = pg_query(abreConexao(),$sqlConsultaTopo);
            $idSistemas = pg_fetch_assoc($rsConsultaTopo);
    }
       if(($idSistemas['sistema_nm'] == 'Serviços')OR($idSistemas['sistema_nm'] == 'Reserva'))
       {
            $actions = '<a href="../../Home/Senha.php"><span class="text_actions" onMouseOver=\'javascript:this.style.textDecoration = "underline";\' onMouseOut=\'javascript:this.style.textDecoration = "none";\'>Alterar Senha</span></a> | <a href="../../Home/Login.php?acao=LogOff"><span class="text_actions" onMouseOver=\'javascript:this.style.textDecoration = "underline";\' onMouseOut=\'javascript:this.style.textDecoration = "none";\'>Sair</span></a>';
       }
       else
       {
            $actions = '<a href="../Home/Senha.php"><span class="text_actions" onMouseOver=\'javascript:this.style.textDecoration = "underline";\' onMouseOut=\'javascript:this.style.textDecoration = "none";\'>Alterar Senha</span></a> | <a href="../Home/Login.php?acao=LogOff"><span class="text_actions" onMouseOver=\'javascript:this.style.textDecoration = "underline";\' onMouseOut=\'javascript:this.style.textDecoration = "none";\'>Sair</span></a>';
       }
}
//USUARIO NÃO LOGADO
else
{
     
}
   if(true)
   {
?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" height="60">
          <tr>
            <td background="https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/bg_logo_bk.png" width="196px">&nbsp;</td>
            <td background="https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/bg_banner_left.png" width="49px">&nbsp;</td>
            <td background="https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/bg_banner_center.png" valign="top" align="left"><p class="text_banner"></strong></p></td>
            <td background="https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/bg_banner_center.png" valign="top" align="right">
                <p class="text_banner"><span class="text_usuario"></span></p>
            </td>
            <td background="https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/bg_banner_right.png" width="36px">&nbsp;</td>
            <td background="https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/bg_banner_actions.png" valign="top" align="left" width="125px"><p class="text_actions"></p></td>
          </tr>
        </table>
        <br/>
<?php
   }
  ?>
     
 