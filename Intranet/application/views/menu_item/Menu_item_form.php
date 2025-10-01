<?php include '../template/begin_1_2018.php'; ?>
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
        <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> sub-menuy <?php // echo $button  ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                    <div class='x_content'>
                        <div style='overflow-x:auto'>

                            <table class='table'>	
                                <tr>

                                    <td style="width: 15%">   
                                        <div class="form-group">
                                            <label for="integer">Menu <?php echo form_error('menu_id') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">     
                                           <?php echo comboSimples('menu_id', 'intranet.menu', 'menu_id', 'menu_nm', '', $menu_id, ""); ?>
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="character varying">Menu Item Titulo* <?php echo form_error('menu_item_titulo') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="text" class="form-control" name="menu_item_titulo" id="menu_item_titulo"  placeholder="Menu Item Titulo"  value="<?php echo $menu_item_titulo; ?>" required='required'   maxlength = '300' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 


                                    <td>
                                        <label for="menu_item_img">Menu Item Img <?php echo form_error('menu_item_img') ?></label>
                                    </td>                    
                                    <td>  
                                        <div class="form-group">
                                            <input type="file" name="menu_item_img" id="menu_item_img"  class="form-control" >
                                            <!--textarea class="form-control" rows="3"    placeholder="Menu Item Img"  ><?php echo $menu_item_img; ?></textarea-->
                                        </div>
                                    </td>
                                </tr>	
                                <tr> 


                                    <td>
                                        <label for="menu_item_texto">Corpo da postagem <?php echo form_error('menu_item_texto') ?></label>
                                    </td>                    
                                    <td>  
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" name="menu_item_texto" id="menu_item_texto"   placeholder="Menu Item Texto"  ><?php echo $menu_item_texto; ?></textarea>
                                        </div>
                                    </td>
                                </tr>	
                                <tr> 


                                    <td>
                                        <label for="menu_item_link">Menu Item Link <?php echo form_error('menu_item_link') ?></label>
                                    </td>                    
                                    <td>  
                                        <div class="form-group">
                                            <textarea class="form-control" rows="1" name="menu_item_link" id="menu_item_link"   placeholder="Menu Item Link"  ><?php echo $menu_item_link; ?></textarea>
                                        </div>
                                    </td>
                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="integer">Tipo* <?php echo form_error('menu_item_tipo_id') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group"> 
                                             <?php echo comboSimples('menu_item_tipo_id', 'intranet.menu_item_tipo', 'menu_item_tipo_id', 'menu_item_tipo_nm', '', $menu_item_tipo_id, ""); ?>
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="integer">Ordem <?php echo form_error('menu_item_ordem') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="number" class="form-control" name="menu_item_ordem" id="menu_item_ordem"  placeholder="Menu Item Ordem"  value="<?php echo $menu_item_ordem; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '300' />
                                        </div> 
                                    </td>

                                </tr>
                                <tr> 
                                    <td colspan='2'>
                                        <input type="hidden" name="menu_item_id" value="<?php echo $menu_item_id; ?>" /> 
                                        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                                        <a href="<?php echo site_url('menu_item') ?>" class="btn btn-default">Voltar</a>

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