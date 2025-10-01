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
       <span id='spanAcaoForm'><h1><i class='glyphicon glyphicon-chevron-right'></i></span><?php echo rupper($menu_item_titulo); ?></h1>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                    <div class='x_content'>
                        <div style='overflow-x:auto'>
                            <table class='table'>
                                <tr>                   
                                    <td  align="center">
                                        <img src="https://<?= $_SERVER['HTTP_HOST'].'/_portal/anexos/anexo_intranet/menu_item/'.$menu_item_img?>" style="width:35%">
                                     
                                    </td>
                                </tr>	
                                <tr> 
                                    <td >  
                                        <p>
                                            <?php echo $menu_item_texto; ?>
                                        </p>
                                    </td>
                                </tr>                                
                                <?php if(!empty($menu_item_link)){ ?>
                                <tr>                   
                                    <td>  
                                        <div class="form-group">
                                            <b>Link externo</b><br>
                                            <b style="color:red"><?php echo $menu_item_link; ?></b>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                                 
                                 
                                <tr> 
                                    <td colspan=''>
                                        <a href="<?php echo site_url('publicacao/intranet') ?>" class="btn btn-default">Voltar</a>

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

<?php include '../template/_end.php'; ?>