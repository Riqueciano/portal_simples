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
            }
        });
    </script>
</head>

<body>
    <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Dados_unico.banco <?php // echo $button 
                                                                                                                                            ?></h2>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class='col-md-12' name='' id=''>
            <div class='x_panel' id=''>
                <div class='x_content'>
                    <div style='overflow-x:auto'>

                        <table class='table'>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="character">Banco Cd* <?php echo form_error('banco_cd') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="text" class="form-control" name="banco_cd" id="banco_cd" placeholder="Banco Cd" value="<?php echo $banco_cd; ?>" required='required' maxlength='3' />
                                    </div>
                                </td>

                            </tr>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="character varying">Banco Ds* <?php echo form_error('banco_ds') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="text" class="form-control" name="banco_ds" id="banco_ds" placeholder="Banco Ds" value="<?php echo $banco_ds; ?>" required='required' maxlength='50' />
                                    </div>
                                </td>

                            </tr>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="numeric">Banco St <?php echo form_error('banco_st') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="number" class="form-control" name="banco_st" id="banco_st" placeholder="Banco St" value="<?php echo $banco_st; ?>" onkeypress="mascara(this, soNumeros);" maxlength='50' />
                                    </div>
                                </td>

                            </tr>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="date">Banco Dt Criacao <?php echo form_error('banco_dt_criacao') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="date" class="form-control" name="banco_dt_criacao" id="banco_dt_criacao" placeholder="Banco Dt Criacao" value="<?php echo $banco_dt_criacao; ?>" onKeyPress='return false;' onPaste='Return false' maxlength='10' maxlength='50' />
                                    </div>
                                </td>

                            </tr>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="date">Banco Dt Alteracao <?php echo form_error('banco_dt_alteracao') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="date" class="form-control" name="banco_dt_alteracao" id="banco_dt_alteracao" placeholder="Banco Dt Alteracao" value="<?php echo $banco_dt_alteracao; ?>" onKeyPress='return false;' onPaste='Return false' maxlength='10' maxlength='50' />
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td colspan='2'>
                                    <input type="hidden" name="banco_id" value="<?php echo $banco_id; ?>" />
                                    <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button>
                                    <a href="<?php echo site_url('banco') ?>" class="btn btn-default">Voltar</a>

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