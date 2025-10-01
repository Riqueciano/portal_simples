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
            }
        });


         
    </script>
</head>

<body>
    <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Trocar senha (pelo administrador)</span>  <?php // echo $button 
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
                                        <label for="character varying">Login* <?php echo form_error('usuario_login') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                    <?php echo $usuario_login; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr id='tr_senha'>
                                <td>
                                    <label for="usuario_senha">Usuario Senha* <?php echo form_error('usuario_senha') ?></label>                                    
                                </td>
                                <td>
                                    <div class="form-group">
                                    <b id='b_msg_senha' style="display: none" class='red'>  DEIXAR O CAMPO EM BRANCO IMPLICA EM NÃO ALTERAR A SENHA ANTERIORMENTE CADASTRADA  </b>
                                        <textarea class="form-control" rows="1" name="usuario_senha" id="usuario_senha" required='required' placeholder=""></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="usuario_senha">Pessoa* <?php echo form_error('usuario_senha') ?></label>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <?=$pessoa_nm?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="usuario_senha">Empresa</label>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <?=$empresa_nm?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="usuario_senha">Lotação</label>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <?=$lotacao_nm?>
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
                    <div style='overflow-x:auto'>
                        <table class='table'>
                        <tr>
                                <td colspan='2'>
                                    <input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>" />
                                    <button id="btnGravar" type="submit" class="btn btn-danger" onclick="">Atualizar senha</button>
                                    <a href="<?php echo site_url('usuario') ?>" class="btn btn-default">Voltar ao início</a>

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