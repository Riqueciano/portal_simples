<?php include '../template/begin_1_2018.php'; ?>
<html>
    <head>
        <script type="text/javascript">
            $(document).ready(function () {
                if('<?=$controller?>'=='read'){
                    $("input").prop("disabled", true);
                    $("select").prop("disabled", true);
                    $("textarea").prop("disabled", true);
                    $("#btnGravar").hide();
                }else if('<?=$controller?>'=='create'){
                    //tela de create
                }else if('<?=$controller?>'=='update'){
                    //tela de update
                }
            });
        </script>
    </head>
    <body>
        <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Intranet.menu_item_anexo <?php // echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        
<table class='table'>	
<tr> 
                 
	 
            <td>
                <label for="menu_item_anexo">Menu Item Anexo* <?php echo form_error('menu_item_anexo') ?></label>
            </td>                    
            <td>  
        <div class="form-group">
            <textarea class="form-control" rows="3" name="menu_item_anexo" id="menu_item_anexo" required='required'  placeholder="Menu Item Anexo"  ><?php echo $menu_item_anexo; ?></textarea>
        </div>
            </td>
 </tr>	
<tr> 
                 
	 <td>   
                    <div class="form-group">
                    <label for="integer">Menu Item Id* <?php echo form_error('menu_item_id') ?></label>
                                        </div>
                        </td>
    <td>  
                            <div class="item form-group">        <?php  echo combo('menu_item_id','intranet.menu_item','menu_item_id','menu_item_id','',$menu_item_id,"");?>
	</div> 
                 </td>
                
 </tr>
<tr> 
                <td colspan='2'>
	        <input type="hidden" name="menu_item_anexo_id" value="<?php echo $menu_item_anexo_id; ?>" /> 
	        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	        <a href="<?php echo site_url('menu_item_anexo') ?>" class="btn btn-default">Voltar</a>
	
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