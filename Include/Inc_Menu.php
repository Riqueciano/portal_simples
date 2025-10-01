<?php
$Auxiliar1 = 0;
$Auxiliar2 = 0;

?>
<div id="container">
<table cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" width="180" class="leftColumaMenu">
                <tr>
                    <td width="5"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/menu_tab_esq.gif" width="5" height="21" border="0" alt=""></td>
                    <td style="background-image : url(https://www.portalsema.ba.gov.br/_portal/Imagens/menu_tab_meio.gif);" width="100%"><span style="margin-left:5px;">Opções do Menu</span></td>
                    <td width="5"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/menu_tab_dir.gif" width="9" height="21" border="0" alt=""></td>
                </tr>
            </table>
            <table width="180" cellpadding="0" cellspacing="0"><tr><td height="1"></td></tr></table>
            <table cellpadding="0" cellspacing="0" border="0" width="180">
                <tr>
                    <td>
                        <?php
                        //SE O PERFIL FOR ADMINITRADOR. CARREGA TODAS AS AÇÕES E SESSÕES
                        
                            $sqlMenu= "
                            SELECT
                                s.secao_id,
                                a.acao_id,
                                acao_ds,
                                acao_url,
                                secao_ds
                                FROM
                                seguranca.acao a,
                                seguranca.secao s
                            WHERE
                                a.secao_id = s.secao_id AND
                                acao_st = 0 AND
                                secao_st = 0 AND
                                sistema_id = '".$_SESSION['sistema_id']."'
                            GROUP BY
                                s.secao_id,
                                a.acao_id,
                                acao_ds,
                                acao_url,
                                secao_ds,
                                secao_indice,
                                acao_indice
                            ORDER BY
                                secao_indice,
                                acao_indice";
                        
                            // echo_pre($sqlMenu);

                        //REALIZA A CONSULTA
                        $rsMenu = pg_query(abreConexao(),$sqlMenu);

                        // var_dump( $rsMenu );

                        //ASSOCIA OS DADOS CONSULTADOS
                        while ($linha = pg_fetch_assoc($rsMenu))
                        {
                            //CAPTURA OS DADOS CONSULTADOS
                            $AcaoCodigo  = $linha['acao_id'];
                            $SecaoCodigo = $linha['secao_id'];
                            $AcaoNome    = $linha['acao_ds'];
                            $SecaoNome   = $linha['secao_ds'];
                            $AcaoURL     = $linha['acao_url'];

                            if ($Auxiliar1 == $SecaoCodigo) {
                                echo "<table width=180 cellpadding=0 cellspacing=1 border=0>
                                                    <tr height=20>
                                                            <td onMouseOver=this.style.background='#DFDEDE';this.style.cursor='hand'; onMouseOut=this.style.background='#EDEDED';this.style.cursor='auto'; class=menu_modulo>
                                                                    <a href='".$AcaoURL."?id=".$AcaoCodigo."'>&nbsp;".$AcaoNome."</a>
                                                            </td>
                                                    </tr>
                                      </table>";
                            }else {
                                if ($Auxiliar1 == 0) {
                                    $Auxiliar2 = 0;
                                }else {
                                    $Auxiliar2 = $Auxiliar2 + 2;
                                }

                            //    echo 1;exit;
                                echo "</div>
                                    <div class=header id='".str_replace($SecaoNome," ", "")."' style=DISPLAY: block>
                                    <table width=180 cellpadding=1 cellspacing=0 class=subMenu>
                                     <tr height=20 class=menu_modulo>
                                             <td width=16 align=center background='https://www.portalsdr;ba.gov.br/_portal/Imagens/bg_menu.gif'><img src=https://www.portalsema.ba.gov.br/_portal/Imagens/menu_seta_1.gif border=0 align=center></td>
                                             <!--td><a href='#' onClick=WM_collapse(".$Auxiliar2."); return false>&nbsp;<b>".$SecaoNome."--2</b></a></td-->
											 <td onClick=WM_collapse(".$Auxiliar2."); style='cursor:pointer'>&nbsp;<b>".$SecaoNome."</b></td>
                                     </tr>
                                    </table>                                    

                                    <table width=180 cellpadding=1 cellspacing=0 height=1>
                                            <tr>
                                                <td></td>
                                            </tr>
                                    </table>

                                    <div class=links id='".str_replace($SecaoNome," ", "")."'Content style='DISPLAY: none'>
                                        <table width=180 cellpadding=0 cellspacing=1 border=0>
                                                <tr height=20>
                                                        <td onMouseOver=this.style.background='#DFDEDE';this.style.cursor='hand'; onMouseOut=this.style.background='#EDEDED';this.style.cursor='auto'; class=menu_modulo>
                                                                <a href='".$AcaoURL."?id=".$AcaoCodigo."'>&nbsp;".$AcaoNome."</a>
                                                        </td>
                                                </tr>
                                        </table>
                                        ";
                            }
                            $Auxiliar1 = $SecaoCodigo;
                        }
                        
                        ?>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>