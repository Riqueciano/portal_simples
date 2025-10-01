<?php
header ('Content-type: text/html; charset=ISO-8859-1'); 
// include '../template/begin_1_2018rn.php'; 
include '../template/begin_1_2018.php';
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
                // ajax_carrega_acao_por_sistema();
                // $('#acao_id').val('<?= $acao_id ?>')
                // $('#tipo_usuario_id').val('<?= $tipo_usuario_id ?>')
            }
        });

        function ajax_carrega_acao_por_sistema() {
            if ($('#sistema_id_correto').val() == '') {
                return false;
            }
            $.ajax({
                url: "<?= site_url('/acao/ajax_carrega_acao_por_sistema') ?>/",
                type: "post",
                dataType: "html",
                async: false,
                data: {
                    sistema_id_correto: $('#sistema_id_correto').val(),
                },
                success: function(retorno) {
                    alert(retorno)
                    // $('#div_div').html(retorno);
                    $("#acao_id option").each(function() {
                        $(this).remove();
                    });

                    var option = new Option('.:Selecione:.', '');
                    $('#acao_id').append(option);
                    if (retorno != 'null') {
                        var arqJson = JSON.parse(retorno);
                        if (arqJson.length > 0) {
                            for (var i = 0; i < arqJson.length; i++) {
                                var option = new Option(arqJson[i].acao_ds, arqJson[i].acao_id);
                                $('#acao_id').append(option);
                            }
                        }
                    }
                }
            });
            //atualiza o perfil pelo sistema
            ajax_carrega_perfil_por_sistema();
        }

        function ajax_carrega_perfil_por_sistema() {
            if ($('#sistema_id_correto').val() == '') {
                return false;
            }
            $.ajax({
                url: "<?= site_url('/tipo_usuario/ajax_carrega_perfil_por_sistema') ?>/",
                type: "get",
                dataType: "html",
                async: false,
                data: {
                    sistema_id_correto: $('#sistema_id_correto').val(),
                },
                success: function(retorno) {
                    // alert(retorno) 
                    $("#tipo_usuario_id option").each(function() {
                        $(this).remove();
                    });

                    var option = new Option('.:Selecione:.', '');
                    $('#tipo_usuario_id').append(option);
                    if (retorno != 'null') {
                        var arqJson = JSON.parse(retorno);
                        if (arqJson.length > 0) {
                            for (var i = 0; i < arqJson.length; i++) {
                                var option = new Option(arqJson[i].tipo_usuario_ds, arqJson[i].tipo_usuario_id);
                                $('#tipo_usuario_id').append(option);
                            }
                        }
                    }
                }
            });
        }
    </script>
</head>

<body>
    <div id='div_div'></div>
    <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Ação x perfil <?php ?></h2>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class='col-md-12' name='' id=''>
            <div class='x_panel' id=''>
                <div class='x_content'>
                    <div style='overflow-x:auto'>

                        <table class='table'>
                            <tr>
                                <td style='width:14%'>Sistema</td>
                                <td>
                                    <?php echo $sistema_nm ?>
                                    <div style='display: none'>
                                        <?php echo comboSimples('sistema_id_correto', 'seguranca.sistema', 'sistema_id', 'sistema_nm', 'ajax_carrega_acao_por_sistema()', $sistema_id_correto, " order by sistema_nm"); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="smallint">Sub-menu (ação)* <?php echo form_error('acao_id') ?></label>

                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $param = "and secao_id in (select secao_id from seguranca.secao where sistema_id = $sistema_id_correto)";
                                    echo comboSimples('acao_id', 'seguranca.acao', 'acao_id', 'acao_ds', '', $acao_id, $param . " order by acao_ds"); ?>
                                    <!-- <select name="acao_id" id="acao_id" class="form-control">
                                        <option selected>.:Selecione:.</option>
                                    </select> -->
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Perfil (tipo usuario)
                                </td>
                                <td>
                                    <?php echo combo('tipo_usuario_id', 'seguranca.tipo_usuario', 'tipo_usuario_id', 'tipo_usuario_ds', '', $tipo_usuario_id, " and sistema_id = $sistema_id_correto order by tipo_usuario_ds"); ?>
                                </td>
                                <td>
                                
                                    <!-- <select name="tipo_usuario_id" id="tipo_usuario_id" class="form-control">
                                        <option selected>.:Selecione:.</option>
                                    </select>
                                    <script>
                                        $('#tipo_usuario_id').val('<?= $tipo_usuario_id ?>')
                                    </script> -->
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'>
                                    <input type="hidden" name="tipo_usuario_acao_id" value="<?php echo $tipo_usuario_acao_id; ?>" />
                                    <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button>
                                    <a href="<?php echo site_url('tipo_usuario_acao') ?>" class="btn btn-default">Voltar</a>
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