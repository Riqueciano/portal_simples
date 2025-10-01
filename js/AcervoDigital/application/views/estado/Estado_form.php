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
        <h2 style="margin-top:0px"><span id='spanAcaoForm'>Cadastro</span> Indice.estado <?php // echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        
<table class='table'>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="character">Estado Uf <?php echo form_error('estado_uf') ?></label>
     <div class="item form-group">
	  <input type="text" class="form-control" name="estado_uf" id="estado_uf" placeholder="Estado Uf" value="<?php echo $estado_uf; ?>"    maxlength = '2' />
	</div>
</div>
</td> 
               </tr>
<tr> 
                <td>
	        <input type="hidden" name="estado_id" value="<?php echo $estado_id; ?>" /> 
	        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	        <a href="<?php echo site_url('estado') ?>" class="btn btn-default">Voltar</a>
	
                </td>
</tr>  

</table>   
</form>
    </body>
</html>

<?php include '../template/end.php'; ?>