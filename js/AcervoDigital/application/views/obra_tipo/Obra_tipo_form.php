<?php include '../template/begin.php'; ?>
<html>
    <head>
        <script type="text/javascript">
            $(document).ready(function () {
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
        <h2 style="margin-top:0px"><span id='spanAcaoForm'>Cadastro</span> - Tipo da Obra <?php // echo $button  ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

            <table class='table'>	
                <tr> 
                    <td>
                        <div class="form-group">
                            <label for="character varying">Tipo* <?php echo form_error('obra_tipo_nm') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="obra_tipo_nm" id="obra_tipo_nm" placeholder="Obra Tipo Nm" value="<?php echo $obra_tipo_nm; ?>" required='required'   maxlength = '200' />
                            </div>
                        </div>
                    </td> 
                </tr>	
                <!--tr> 
                    <td>
                        <div class="form-group">
                            <label for="integer">Obra Ativo* <?php echo form_error('obra_ativo') ?></label>
                            <div class="item form-group">
                                <input type="number" class="form-control" name="obra_ativo" id="obra_ativo" placeholder="Obra Ativo" value="<?php echo $obra_ativo; ?>" required='required'  onkeypress="mascara(this, soNumeros);"   maxlength = '200' />
                            </div>
                        </div>
                    </td> 
                </tr-->
                <tr> 
                    <td>
                        <input type="hidden" name="obra_tipo_id" value="<?php echo $obra_tipo_id; ?>" /> 
                        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('obra_tipo') ?>" class="btn btn-default">Voltar</a>

                    </td>
                </tr>  

            </table>   
        </form>
    </body>
</html>

<?php include '../template/end.php'; ?>