<?php 
header ('Content-type: text/html; charset=ISO-8859-1'); 
include '../template/begin_1_2018rn.php'; 
?>
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
        <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Perfil Usuário <?php // echo $button  ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                    <div class='x_content'>
                        <div style='overflow-x:auto'>

                            <table class='table'>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="character varying">Tipo Usuario Ds* <?php echo form_error('tipo_usuario_ds') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="text" class="form-control" name="tipo_usuario_ds" id="tipo_usuario_ds"  placeholder="Tipo Usuario Ds"  value="<?php echo $tipo_usuario_ds; ?>" required='required'   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="numeric">Tipo Usuario St <?php echo form_error('tipo_usuario_st') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="number" class="form-control" name="tipo_usuario_st" id="tipo_usuario_st"  placeholder="Tipo Usuario St"  value="<?php echo $tipo_usuario_st; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="smallint">Sistema * <?php echo form_error('sistema_id') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">   
                                            <?php echo combo('sistema_id_correto', 'seguranca.sistema', 'sistema_id', 'sistema_nm', '', $sistema_id_correto, ""); ?>
                                        </div> 
                                    </td>

                                </tr>
                                <tr> 
                                    <td colspan='2'>
                                        <input type="hidden" name="tipo_usuario_id" value="<?php echo $tipo_usuario_id; ?>" /> 
                                        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                                        <a href="<?php echo site_url('tipo_usuario') ?>" class="btn btn-default">Voltar</a>

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