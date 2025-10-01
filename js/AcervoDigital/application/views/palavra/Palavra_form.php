<?php include '../template/begin.php'; ?>
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
        <h2 style="margin-top:0px"><span id='spanAcaoForm'>Cadastro</span> Acervo.palavra <?php // echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        
<table class='table'>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="character varying">Palavra* <?php echo form_error('palavra') ?></label>
     <div class="item form-group">
	  <input type="text" class="form-control" name="palavra" id="palavra" placeholder="Palavra" value="<?php echo $palavra; ?>" required='required'   maxlength = '50' />
	</div>
</div>
</td> 
               </tr>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="integer">Flag Aprovado <?php echo form_error('flag_aprovado') ?></label>
     <div class="item form-group">
	  <input type="number" class="form-control" name="flag_aprovado" id="flag_aprovado" placeholder="Flag Aprovado" value="<?php echo $flag_aprovado; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
	</div>
</div>
</td> 
               </tr>
<tr> 
                <td>
	        <input type="hidden" name="palavra_id" value="<?php echo $palavra_id; ?>" /> 
	        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	        <a href="<?php echo site_url('palavra') ?>" class="btn btn-default">Voltar</a>
	
                </td>
</tr>  

</table>   
</form>
    </body>
</html>

<?php include '../template/end.php'; ?>