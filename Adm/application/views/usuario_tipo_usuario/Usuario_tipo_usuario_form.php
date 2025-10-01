<?php 
header ('Content-type: text/html; charset=ISO-8859-1'); 
include '../template/begin_1_2018rn.php'; ?>
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
            }
        });
    </script>
</head>

<body>
    <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Seguranca.usuario_tipo_usuario <?php // echo $button 
                                                                                                                                                        ?></h2>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class='col-md-12' name='' id=''>
            <div class='x_panel' id=''>
                <div class='x_content'>
                    <div style='overflow-x:auto'>

                        <table class='table'>
                            <tr>
                                <td colspan='2'>
                                    <input type="hidden" name="pessoa_id" value="<?php echo $pessoa_id; ?>" />
                                    <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button>
                                    <a href="<?php echo site_url('usuario_tipo_usuario') ?>" class="btn btn-default">Voltar</a>

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