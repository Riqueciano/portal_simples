<?php
$auxiliar1 = 0;
$auxiliar2 = 0;
?>
<div id="container">
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" border="0" width="180" class="leftColumaMenu">
                    <tr>
                        <td width="5"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/menu_tab_esq.gif" width="5" height="21" border="0"></td>
                        <td style="background-image : url(https://www.portalsema.ba.gov.br/_portal/Imagens/menu_tab_meio.gif);" width="100%">&nbsp;&nbsp;Op&ccedil;&otilde;es do Menu</td>
                        <td width="5"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/menu_tab_dir.gif" width="9" height="21" border="0"></td>
                    </tr>
                </table>
                <table width="180" cellpadding="0" cellspacing="0" height="1"><tr><td></td></tr></table>
                <table cellpadding="0" cellspacing="0" border="0" width="180">
                    <tr>
                        <td>
                            <?php
                            //   se o perfil do usuario for administrador, o sistema carrega todas as acoes, caso contrario carrega apenas as que tem permissao
                            if ($_SESSION['Administrador'] == 0) {
                                $sqlMenu = "SELECT s.secao_id, a.acao_id, acao_ds, acao_url, secao_ds FROM seguranca.acao a, seguranca.secao s, seguranca.tipo_usuario_acao tua WHERE
                    (tua.acao_id = a.acao_id)AND (tua.tipo_usuario_id = '" . $_SESSION['TipoUsuario'] . "'" . ") AND (a.secao_id = s.secao_id) AND acao_st = 0 AND
                    secao_st = 0 AND sistema_id = '" . $_SESSION['Sistema'] . "' GROUP BY s.secao_id, a.acao_id, acao_ds, acao_url, secao_ds, secao_indice,
                    acao_indice ORDER BY secao_indice, acao_indice";
                            } else {

                                $sqlMenu = "SELECT s.secao_id, a.acao_id, acao_ds, acao_url, secao_ds FROM seguranca.acao a, seguranca.secao s WHERE
                    (a.secao_id = s.secao_id) AND acao_st = 0 AND secao_st = 0 AND sistema_id = '" . $_SESSION['Sistema'] . "'GROUP BY s.secao_id, a.acao_id, acao_ds,acao_url, secao_ds, secao_indice, acao_indice ORDER BY secao_indice, acao_indice";
                            }


                            $rsMenu = pg_query(abreConexao(), $sqlMenu);
                            while ($linha = pg_fetch_assoc($rsMenu)) {
                                $acaoCodigo = $linha['acao_id'];
                                $secaoCodigo = $linha['secao_id'];
                                $acaoNome = $linha['acao_ds'];
                                $secaoNome = $linha['secao_ds'];
                                $acaoURL = $linha['acao_url'];
                                if ($auxiliar1 == $secaoCodigo) {
                                    print "<table width=180 cellpadding=0 cellspacing=1 border=0>
            <tr height=20>
            <td onMouseOver=this.style.background='#DFDEDE';this.style.cursor='hand'; onMouseOut=this.style.background='#EDEDED';this.style.cursor='auto';
            class=menu_modulo>
            <a href=" . $acaoURL . "?acao_id=" . $acaoCodigo . ">&nbsp;" . $acaoNome . "</a>
            </td></tr></table>";
                                } else {
                                    if ($auxiliar1 == 0) {
                                        $auxiliar2 = 0;
                                    } else {
                                        $auxiliar2 = $auxiliar2 + 2;
                                    }
                                    print "</div>
            <div class=header id='" . str_replace($secaoNome, " ", "") . "' style=DISPLAY: block>
            <table width=180 cellpadding=1 cellspacing=0 class=subMenu>
            <tr height=20 class=menu_modulo>
            <td width=16 align=center background=https://www.portalsema.ba.gov.br/_portal/Imagens/bg_menu.gif><img src=https://www.portalsema.ba.gov.br/_portal/Imagens/menu_seta_1.gif border=0 align=center></td>
            <td><a href=# onClick=WM_collapse(" . $auxiliar2 . "); return false>&nbsp;<b>" . $secaoNome . "</b></a></td>
            </tr>
            </table>
            <table width=180 cellpadding=1 cellspacing=0><tr><td></td></tr></table>
            <div class=links id='" . str_replace($secaoNome, " ", "") . "'Content style='DISPLAY: none'>
            <table width=180 cellpadding=0 cellspacing=1 border=0>
            <tr height=20>
            <td onMouseOver=this.style.background='#DFDEDE';this.style.cursor='hand';
            onMouseOut=this.style.background='#EDEDED';this.style.cursor='auto'; class=menu_modulo>
            <a href=" . $acaoURL . "?acao_id=" . $acaoCodigo . ">&nbsp;" . $acaoNome . "</a></td>
            </tr>
            </table>";
                                }
                                $auxiliar1 = $secaoCodigo;
                            }
                            ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>