<?php include '../template/begin_1_2018rn.php'; ?>
<html>
    <head>
        
    </head>
    <body>
    
        <!-- ###app### -->
        <style> [v-cloak] {display: none;}</style>
    <div id='app' v-cloak></div>
        <!-- ### -->

    <template id="app-template">
    <div>    
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Dados_unico.funcionario_tipo <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Funcionario Tipo Ds* <?php echo form_error('funcionario_tipo_ds') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="funcionario_tipo_ds" id="funcionario_tipo_ds"  placeholder="Funcionario Tipo Ds"  v-model="form.funcionario_tipo_ds" required='required'   maxlength = '50' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="numeric">Funcionario Tipo Terceirizado <?php echo form_error('funcionario_tipo_terceirizado') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="funcionario_tipo_terceirizado" id="funcionario_tipo_terceirizado"  placeholder="Funcionario Tipo Terceirizado"  v-model="form.funcionario_tipo_terceirizado"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Flag Ativo <?php echo form_error('flag_ativo') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="flag_ativo" id="flag_ativo"  placeholder="Flag Ativo"  v-model="form.flag_ativo"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="funcionario_tipo_id" value="<?php echo $funcionario_tipo_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('funcionario_tipo') ?>" class="btn btn-default">Voltar</a> </td>
</tr>  

</table> 
</div>
                        </div>
                    </div>
                </div>
</form>
</div>
</template>
<!--script type="text/x-template" id="select2-template">
        <select>
           <slot></slot>
        </select>
    </script-->


<!--monta combobox-->
<!--script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/select2/montaSelect.js"></script-->
<script type="text/javascript" language="javascript" src="<?php echo iPATH ?>/JavaScript/vue/select2/montaSelect.js"></script>

<script>
        new Vue({
            el: "#app",
            template: "#app-template",
            data: {
                message: '',
                button: "<?= $button ?>",
                controller: "<?= $controller ?>",    form: { funcionario_tipo_ds: "<?= $funcionario_tipo_ds?>",
  funcionario_tipo_terceirizado: "<?= $funcionario_tipo_terceirizado?>",
  flag_ativo: "<?= $flag_ativo?>",
   
                },
            },
            computed: { 

            },
            methods: {

            },
            mounted() {
                if (this.controller == 'read') {
                    $("input").prop("disabled", true);
                    $("select").prop("disabled", true);
                    $("textarea").prop("disabled", true);
                    $("#btnGravar").hide();
                } else if (this.controller == 'create') {
                    //tela de create
                } else if (this.controller == 'update') {
                    //tela de update 
                }
            },
        });  
    </script>
</body> 
</html>

<?php include '../template/end.php'; ?>