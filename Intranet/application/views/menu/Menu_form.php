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
        <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Intranet.menu <?php // echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        
<table class='table'>	
<tr> 
                 
	 <td>   
                    <div class="form-group">
                    <label for="character varying">Menu Nm* <?php echo form_error('menu_nm') ?></label>
                                        </div>
                        </td>
    <td>  
                            <div class="item form-group">
	  <input type="text" class="form-control" name="menu_nm" id="menu_nm"  placeholder="Menu Nm"  value="<?php echo $menu_nm; ?>" required='required'   maxlength = '300' />
	</div> 
                 </td>
                
 </tr>	
<tr> 
                 
	 <td>   
                    <div class="form-group">
                    <label for="character varying">Menu Icon* <?php echo form_error('menu_icon') ?></label>
                                        </div>
                        </td>
    <td>  
                            <div class="item form-group">
	  <input type="text" class="form-control" name="menu_icon" id="menu_icon"  placeholder="Menu Icon"  value="<?php echo $menu_icon; ?>" required='required'   maxlength = '300' />
	</div> 
                 </td>
                
 </tr>
<tr> 
                <td colspan='2'>
	        <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>" /> 
	        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	        <a href="<?php echo site_url('menu') ?>" class="btn btn-default">Voltar</a>
	
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