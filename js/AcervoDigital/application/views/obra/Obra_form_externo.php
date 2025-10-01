<?php
include '../template/begin_semvalidacao.php';


$perfil = $_SESSION['Sistemas'][$_SESSION['sistema']];
?>
<html>
    <head>
        <script type="text/javascript">
            $(document).ready(function () {

            });


        </script>
    </head>
    <body>
        <h2 style="margin-top:0px"><span id='spanAcaoForm'></span> <?php // echo $button     ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">


            <div  class="col-md-12">
                <div class="x_panel" id=''>                    
                    <div class="x_content">
                        <div style=''>
                            <table class='table'>	
                                <tr> 
                                    <td colspan="4">
                                        <div class="form-group">
                                            <div class="item form-group">
                                                <b><p style="text-align: center;"><?php echo $obra_titulo; ?></p></b>
                                            </div>
                                        </div>
                                    </td>
                                </tr>     
                                <tr>
                                    <td colspan='4'>  
                                        <p style="text-align: right;"><?php echo $autores; ?></p>
                                    </td>
                                </tr> 
                                <tr> 
                                    <td colspan="4">
                                        <div class="form-group"> 
                                            <div class="item form-group"><b>Resumo</b><br> 
                                                <p style="text-align: justify;"><?php echo $resumo; ?></p>
                                            </div>
                                        </div>
                                    </td> 
                                </tr>
                                <tr> 
                                    <td colspan="4">
                                        <div class="form-group"> 
                                            <div class="item form-group"><b>Referência Bibliografica</b><br> 
                                                <p style="text-align:"><?php echo $referencia; ?></p>
                                            </div>
                                        </div>
                                    </td> 
                                </tr>
                            </table>          
                        </div>
                    </div>
                </div>
            </div>
            <div  class="col-md-12">
                <div class="x_panel" id=''>
                    <div class="x_title" style=" background-color: ">
                        <div class="col-md-9">
                            <i class="glyphicon glyphicon-chevron-right"> </i> <b>Palavras-Chave</b>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div style='overflow-x:auto'>
                            
                                <?php
                                $palavras='';
                                foreach ($obra_palavra as $op) { 
                                    $palavras .= "<span class='badge badge-primary'>$op->palavra</span>";;    
                                     }  
                                     echo $palavras;
                                ?>
                                                 
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </body>
</html>

<?php include '../template/end.php'; ?>