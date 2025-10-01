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
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Dados_unico.funcao <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Funcao Ds* <?php echo form_error('funcao_ds') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="funcao_ds" id="funcao_ds"  placeholder="Funcao Ds"  v-model="form.funcao_ds" required='required'   maxlength = '50' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="numeric">Funcao St <?php echo form_error('funcao_st') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="funcao_st" id="funcao_st"  placeholder="Funcao St"  v-model="form.funcao_st"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="date">Funcao Dt Criacao <?php echo form_error('funcao_dt_criacao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="date" class="form-control" name="funcao_dt_criacao" id="funcao_dt_criacao"  placeholder="Funcao Dt Criacao"  v-model="form.funcao_dt_criacao"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '50' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="date">Funcao Dt Alteracao <?php echo form_error('funcao_dt_alteracao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="date" class="form-control" name="funcao_dt_alteracao" id="funcao_dt_alteracao"  placeholder="Funcao Dt Alteracao"  v-model="form.funcao_dt_alteracao"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '50' />	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="funcao_id" value="<?php echo $funcao_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('funcao') ?>" class="btn btn-default">Voltar</a> </td>
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
                controller: "<?= $controller ?>",    form: { funcao_ds: "<?= $funcao_ds?>",
  funcao_st: "<?= $funcao_st?>",
  funcao_dt_criacao: "<?= $funcao_dt_criacao?>",
  funcao_dt_alteracao: "<?= $funcao_dt_alteracao?>",
   
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