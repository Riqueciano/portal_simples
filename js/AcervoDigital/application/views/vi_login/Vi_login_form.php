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
        <h2 style="margin-top:0px"><span id='spanAcaoForm'>Cadastro</span> Public.vi_login <?php // echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        
<table class='table'>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="character varying">Sistema Nm <?php echo form_error('sistema_nm') ?></label>
     <div class="item form-group">
	  <input type="text" class="form-control" name="sistema_nm" id="sistema_nm" placeholder="Sistema Nm" value="<?php echo $sistema_nm; ?>"    maxlength = '50' />
	</div>
</div>
</td> 
               </tr>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="smallint">Tipo Usuario Id <?php echo form_error('tipo_usuario_id') ?></label>
     <div class="item form-group">
	  <input type="text" class="form-control" name="tipo_usuario_id" id="tipo_usuario_id" placeholder="Tipo Usuario Id" value="<?php echo $tipo_usuario_id; ?>"    maxlength = '50' />
	</div>
</div>
</td> 
               </tr>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="character varying">Tipo Usuario Ds <?php echo form_error('tipo_usuario_ds') ?></label>
     <div class="item form-group">
	  <input type="text" class="form-control" name="tipo_usuario_ds" id="tipo_usuario_ds" placeholder="Tipo Usuario Ds" value="<?php echo $tipo_usuario_ds; ?>"    maxlength = '50' />
	</div>
</div>
</td> 
               </tr>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="integer">Pessoa Id <?php echo form_error('pessoa_id') ?></label>
     <div class="item form-group">
	  <input type="number" class="form-control" name="pessoa_id" id="pessoa_id" placeholder="Pessoa Id" value="<?php echo $pessoa_id; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
	</div>
</div>
</td> 
               </tr>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="character varying">Pessoa Nm <?php echo form_error('pessoa_nm') ?></label>
     <div class="item form-group">
	  <input type="text" class="form-control" name="pessoa_nm" id="pessoa_nm" placeholder="Pessoa Nm" value="<?php echo $pessoa_nm; ?>"    maxlength = '200' />
	</div>
</div>
</td> 
               </tr>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="character varying">Funcionario Email <?php echo form_error('funcionario_email') ?></label>
     <div class="item form-group">
	  <input type="text" class="form-control" name="funcionario_email" id="funcionario_email" placeholder="Funcionario Email" value="<?php echo $funcionario_email; ?>"    maxlength = '200' />
	</div>
</div>
</td> 
               </tr>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="integer">Setaf Id <?php echo form_error('setaf_id') ?></label>
     <div class="item form-group">
	  <input type="number" class="form-control" name="setaf_id" id="setaf_id" placeholder="Setaf Id" value="<?php echo $setaf_id; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '200' />
	</div>
</div>
</td> 
               </tr>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="character varying">Setaf Nm <?php echo form_error('setaf_nm') ?></label>
     <div class="item form-group">
	  <input type="text" class="form-control" name="setaf_nm" id="setaf_nm" placeholder="Setaf Nm" value="<?php echo $setaf_nm; ?>"    maxlength = '100' />
	</div>
</div>
</td> 
               </tr>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="character varying">Usuario Login <?php echo form_error('usuario_login') ?></label>
     <div class="item form-group">
	  <input type="text" class="form-control" name="usuario_login" id="usuario_login" placeholder="Usuario Login" value="<?php echo $usuario_login; ?>"    maxlength = '50' />
	</div>
</div>
</td> 
               </tr>	
<tr> 
                 <td>
	    <div class="form-group">
            <label for="character varying">Usuario Senha <?php echo form_error('usuario_senha') ?></label>
     <div class="item form-group">
	  <input type="text" class="form-control" name="usuario_senha" id="usuario_senha" placeholder="Usuario Senha" value="<?php echo $usuario_senha; ?>"    maxlength = '9999' />
	</div>
</div>
</td> 
               </tr>
<tr> 
                <td>
	        <input type="hidden" name="sistema_id" value="<?php echo $sistema_id; ?>" /> 
	        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	        <a href="<?php echo site_url('vi_login') ?>" class="btn btn-default">Voltar</a>
	
                </td>
</tr>  

</table>   
</form>
    </body>
</html>

<?php include '../template/end.php'; ?>