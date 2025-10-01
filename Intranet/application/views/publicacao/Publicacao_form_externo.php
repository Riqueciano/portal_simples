<?php include '../template/_begin_intranet.php'; ?> 
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
        <h1 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i><?php echo $publicacao_titulo; ?></span> </h1> <?php echo dbToData($publicacao_dt_publicacao); ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                    <div class='x_content'>
                        <div style='overflow-x:auto'>
                            <table class='table'>                                 
                                <tr> 
                                    <td align='center'>  
                                        <div class="item form-group">
                                             <img src="https://<?= $_SERVER['HTTP_HOST'].'/_portal/anexos/anexo_intranet/publicacao/'.$publicacao_img?>" style="width:50%">
                                       </div> 
                                    </td>
                                </tr>	
                                <tr>                   
                                    <td>  
                                        <p >
                                           <?php echo $publicacao_corpo; ?>
                                        </p>
                                    </td>
                                </tr> 	
                                <tr>
                                    <td>
                                        <label for="publicacao_link">Link <?php echo form_error('publicacao_link') ?></label>
                                    </td>                    
                                    <td>  
                                        <div class="form-group">
                                            <?php echo $publicacao_link; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr> 
                                    <td colspan='2'>
                                        <input type="hidden" name="publicacao_id" value="<?php echo $publicacao_id; ?>" /> 
                                        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                                        <!-- <a href="<?php echo site_url('publicacao/intranet') ?>" class="btn btn-default">Voltar</a> -->

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