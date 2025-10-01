<?php include '../template/begin_semvalidacao.php'; ?>
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
        <style>
            #p_resumo{
                text-align: justify;
                font-size: 18px
            }
        </style>
    </head>
    <body>
        <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <input type='hidden' id='acao' name='acao'>
            <input type='hidden' id='obra_id' name='obra_id' value='<?= $obra_id ?>'>
            <table class='table'> 
                <tr>
                    <td align='center'><h2><?php echo $obra_titulo; ?></h2></td>
                </tr> 
                <tr> 
                    <td colspan="4">
                        <div class="form-group">

                            <label for="character varying"> <?php echo form_error('resumo') ?></label>
                            <div class="item form-group"> 
                                <p id='p_resumo' ><?php echo $resumo; ?> </p>
                            </div>
                        </div>
                    </td> 
                </tr>
            </table> 
            <br>
            <div  class="col-md-12">
                <div class="x_panel" id='div_promer'>
                    <div class="x_title" style=" background-color: ">
                        <div class="col-md-12">
                            <i class="glyphicon glyphicon-chevron-right"> </i> <b>Palavras-Chave</b>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div style='overflow-x:auto'>
                            <div  class="col-md-12"  >
                                <div class="x_panel" id=''>
                                    <div class="col-md-12">
                                        <?php foreach ($obra_palavra as $p) { ?>     
                                            <span class="badge badge-success" style="background-color:green"><?= $p->palavra ?></span>
                                        <?php }
                                        ?>            
                                    </div>   
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> 


        </form>
    </body>
</html>

<?php include '../template/end.php'; ?>