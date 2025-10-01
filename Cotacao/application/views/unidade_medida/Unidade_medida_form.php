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
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Selo.unidade_medida <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Unidade Medida Nm <?php echo form_error('unidade_medida_nm') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="unidade_medida_nm" id="unidade_medida_nm"  placeholder="Unidade Medida Nm"  v-model="form.unidade_medida_nm"    maxlength = '250' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Ativo <?php echo form_error('ativo') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="ativo" id="ativo"  placeholder="Ativo"  v-model="form.ativo"   onkeypress="mascara(this, soNumeros);"   maxlength = '250' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Unidade Medida Sigla* <?php echo form_error('unidade_medida_sigla') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="unidade_medida_sigla" id="unidade_medida_sigla"  placeholder="Unidade Medida Sigla"  v-model="form.unidade_medida_sigla" required='required'   maxlength = '10' />	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="unidade_medida_id" value="<?php echo $unidade_medida_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('unidade_medida') ?>" class="btn btn-default">Voltar</a> </td>
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
                controller: "<?= $controller ?>",    form: { unidade_medida_nm: "<?= $unidade_medida_nm?>",
  ativo: "<?= $ativo?>",
  unidade_medida_sigla: "<?= $unidade_medida_sigla?>",
   
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