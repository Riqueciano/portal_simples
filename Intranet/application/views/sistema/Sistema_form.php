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
        <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Seguranca.sistema <?php // echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        
<table class='table'>	
<tr> 
                 
	 <td>   
                    <div class="form-group">
                    <label for="character varying">Sistema Nm* <?php echo form_error('sistema_nm') ?></label>
                                        </div>
                        </td>
    <td>  
                            <div class="item form-group">
	  <input type="text" class="form-control" name="sistema_nm" id="sistema_nm"  placeholder="Sistema Nm"  value="<?php echo $sistema_nm; ?>" required='required'   maxlength = '50' />
	</div> 
                 </td>
                
 </tr>	
<tr> 
                 
	 <td>   
                    <div class="form-group">
                    <label for="character varying">Sistema Ds <?php echo form_error('sistema_ds') ?></label>
                                        </div>
                        </td>
    <td>  
                            <div class="item form-group">
	  <input type="text" class="form-control" name="sistema_ds" id="sistema_ds"  placeholder="Sistema Ds"  value="<?php echo $sistema_ds; ?>"    maxlength = '255' />
	</div> 
                 </td>
                
 </tr>	
<tr> 
                 
	 <td>   
                    <div class="form-group">
                    <label for="character varying">Sistema Icone <?php echo form_error('sistema_icone') ?></label>
                                        </div>
                        </td>
    <td>  
                            <div class="item form-group">
	  <input type="text" class="form-control" name="sistema_icone" id="sistema_icone"  placeholder="Sistema Icone"  value="<?php echo $sistema_icone; ?>"    maxlength = '50' />
	</div> 
                 </td>
                
 </tr>	
<tr> 
                 
	 <td>   
                    <div class="form-group">
                    <label for="numeric">Sistema St <?php echo form_error('sistema_st') ?></label>
                                        </div>
                        </td>
    <td>  
                            <div class="item form-group">
	  <input type="number" class="form-control" name="sistema_st" id="sistema_st"  placeholder="Sistema St"  value="<?php echo $sistema_st; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
	</div> 
                 </td>
                
 </tr>	
<tr> 
                 
	 <td>   
                    <div class="form-group">
                    <label for="date">Sistema Dt Criacao* <?php echo form_error('sistema_dt_criacao') ?></label>
                                        </div>
                        </td>
    <td>  
                            <div class="item form-group">
	  <input type="date" class="form-control" name="sistema_dt_criacao" id="sistema_dt_criacao"  placeholder="Sistema Dt Criacao"  value="<?php echo $sistema_dt_criacao; ?>" required='required'  onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '50' />
	</div> 
                 </td>
                
 </tr>	
<tr> 
                 
	 <td>   
                    <div class="form-group">
                    <label for="date">Sistema Dt Alteracao <?php echo form_error('sistema_dt_alteracao') ?></label>
                                        </div>
                        </td>
    <td>  
                            <div class="item form-group">
	  <input type="date" class="form-control" name="sistema_dt_alteracao" id="sistema_dt_alteracao"  placeholder="Sistema Dt Alteracao"  value="<?php echo $sistema_dt_alteracao; ?>"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '50' />
	</div> 
                 </td>
                
 </tr>	
<tr> 
                 
	 <td>   
                    <div class="form-group">
                    <label for="character varying">Sistema Url <?php echo form_error('sistema_url') ?></label>
                                        </div>
                        </td>
    <td>  
                            <div class="item form-group">
	  <input type="text" class="form-control" name="sistema_url" id="sistema_url"  placeholder="Sistema Url"  value="<?php echo $sistema_url; ?>"    maxlength = '100' />
	</div> 
                 </td>
                
 </tr>
<tr> 
                <td colspan='2'>
	        <input type="hidden" name="sistema_id" value="<?php echo $sistema_id; ?>" /> 
	        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	        <a href="<?php echo site_url('sistema') ?>" class="btn btn-default">Voltar</a>
	
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