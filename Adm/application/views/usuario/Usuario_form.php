<?php 
header ('Content-type: text/html; charset=ISO-8859-1'); 
include '../template/begin_1_2018rn.php'; 
?>
<html>

<head>
    <script type="text/javascript">
        $(document).ready(function() {
            if ('<?= $controller ?>' == 'read') {
                $("input").prop("disabled", true);
                $("select").prop("disabled", true);
                $("textarea").prop("disabled", true);
                $("#btnGravar").hide();
            } else if ('<?= $controller ?>' == 'create') {
                //tela de create
            } else if ('<?= $controller ?>' == 'update') {
                //tela de update
                $('#b_msg_senha').show();
                $('#tr_senha').hide();
                $('#tr_mudar_senha').show();
            }
        });
    </script>
</head>

<body>
    <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Usuário <?php // echo $button 
                                                                                                                                ?></h2>
    <form id='formulario_1' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class='col-md-12' name='' id=''>
            <div class='x_panel' id=''>
                <div class='x_content'>
                    <div style='overflow-x:auto'>
                        <table class='table'>
                            <tr>
                                <td style='width:10%'>
                                    <div class="form-group">
                                        <label for="character varying">Usuario Login* <?php echo form_error('usuario_login') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="text" class="form-control" name="usuario_login" id="usuario_login" placeholder="Usuario Login" value="<?php echo $usuario_login; ?>" maxlength='50' />
                                    </div>
                                </td>
                            </tr>
                            <tr id='tr_senha'>
                                <td>
                                    <label for="usuario_senha">Usuario Senha* <?php echo form_error('usuario_senha') ?></label>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="2" name="usuario_senha" id="usuario_senha" required='required' placeholder=""><?php echo $usuario_senha; ?></textarea>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="usuario_senha">Pessoa* <?php echo form_error('usuario_senha') ?></label>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <b class="red">Visivel apenas "Pessoas" sem usuário</b>
                                        <?php
                                        $param = " and pessoa_id not in (select pessoa_id from seguranca.usuario where pessoa_id != $pessoa_id) ";
                                        echo combo('pessoa_id', 'dados_unico.pessoa', 'pessoa_id', 'pessoa_nm', '', $pessoa_id, $param . " order by pessoa_nm"); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr id='tr_mudar_senha' style='display: none'>
                                <td colspan='2'>
                                    <a href=<?=site_url('Usuario/adm_reseta_senha/'.$usuario_id)?>>
                                        <input type="button" value="MUDAR SENHA" class="btn btn-danger">
                                    </a>
                                </td>
                            </tr>
                            <tr style='display:none'>

                                <td>
                                    <div class="form-group">
                                        <label for="date">Validade <?php echo form_error('validade') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="date" class="form-control" name="validade" id="validade" placeholder="Validade" value="<?php echo $validade; ?>" onKeyPress='return false;' onPaste='Return false' maxlength='10' maxlength='50' />
                                    </div>
                                </td>

                            </tr>


                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-12' name='' id=''>
            <div class='x_panel' id=''>
                <div class='x_content'>
                    <h2>Sistema que possui permissão de acesso</h2>
                    <div style='overflow-x:auto'>
                        <table class='table'>
                            <tr>
                                <th>Sistema</th>
                                <th>Acesso</th>
                                <th>Super usuário (todas secretarias)</th>
                            </tr>
                            <?php
                            foreach ($sistema as $key => $s) { ?>
                                <tr>
                                    <td style='width:15%'>
                                        <b><?= $s->sistema_nm ?></b>
                                        <input type="hidden" name="sistema_id[]" value="<?= $s->sistema_id ?>">
                                    </td>
                                    <td>
                                        <?php echo comboSimples('tipo_usuario_id[]', 'seguranca.tipo_usuario', 'tipo_usuario_id', 'tipo_usuario_ds', '', $s->acesso_tipo_usuario_id, " and sistema_id = " . $s->sistema_id . " order by tipo_usuario_ds"); ?>
                                    </td>
                                    <td>
                                        <?php
                                            switch ((int)$s->usuario_super_secretaria) {
                                                case 0:
                                                    $selected_n = 'selected';
                                                    $selected_s = '';
                                                    break;                                                
                                                case 1:
                                                    $selected_n = '';
                                                    $selected_s = 'selected';
                                                    break;                                                
                                                
                                            }
                                        ?>
                                        <select class='form-control' name='usuario_super_secretaria[]'>
                                                <option value='0' <?=$selected_n?> >Não</option>
                                                <option value='1' <?=$selected_s?> >Sim</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php }
                            if (count($sistema) == 0) {
                                echo "<tr><td colspan='3'>Nenhum</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-12' name='' id=''>
            <div class='x_panel' id=''>
                <div class='x_content'>
                    <div style='overflow-x:auto'>
                        <table class='table'>
                            <tr>
                                <td colspan='2'>
                                    <input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>" />
                                    <button id="btnGravar" type="submit" class="btn btn-primary" onclick=""><?php echo $button ?></button>
                                    <a href="<?php echo site_url('usuario') ?>" class="btn btn-default">Voltar</a>

                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>

<?php include '../template/end.php'; ?>