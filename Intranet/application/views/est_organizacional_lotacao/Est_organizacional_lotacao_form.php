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
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Dados_unico.est_organizacional_lotacao <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="smallint">Est Organizacional Lotacao Sup Cd <?php echo form_error('est_organizacional_lotacao_sup_cd') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="est_organizacional_lotacao_sup_cd" id="est_organizacional_lotacao_sup_cd"  placeholder="Est Organizacional Lotacao Sup Cd"  v-model="form.est_organizacional_lotacao_sup_cd"    />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Est Organizacional Lotacao Ds* <?php echo form_error('est_organizacional_lotacao_ds') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="est_organizacional_lotacao_ds" id="est_organizacional_lotacao_ds"  placeholder="Est Organizacional Lotacao Ds"  v-model="form.est_organizacional_lotacao_ds" required='required'   maxlength = '255' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Est Organizacional Lotacao Sigla* <?php echo form_error('est_organizacional_lotacao_sigla') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="est_organizacional_lotacao_sigla" id="est_organizacional_lotacao_sigla"  placeholder="Est Organizacional Lotacao Sigla"  v-model="form.est_organizacional_lotacao_sigla" required='required'   maxlength = '80' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="numeric">Est Organizacional Lotacao St* <?php echo form_error('est_organizacional_lotacao_st') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="est_organizacional_lotacao_st" id="est_organizacional_lotacao_st"  placeholder="Est Organizacional Lotacao St"  v-model="form.est_organizacional_lotacao_st" required='required'  onkeypress="mascara(this, soNumeros);"   maxlength = '80' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="date">Est Organizacional Lotacao Dt Criacao <?php echo form_error('est_organizacional_lotacao_dt_criacao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="date" class="form-control" name="est_organizacional_lotacao_dt_criacao" id="est_organizacional_lotacao_dt_criacao"  placeholder="Est Organizacional Lotacao Dt Criacao"  v-model="form.est_organizacional_lotacao_dt_criacao"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '80' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="date">Est Organizacional Lotacao Dt Alteracao <?php echo form_error('est_organizacional_lotacao_dt_alteracao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="date" class="form-control" name="est_organizacional_lotacao_dt_alteracao" id="est_organizacional_lotacao_dt_alteracao"  placeholder="Est Organizacional Lotacao Dt Alteracao"  v-model="form.est_organizacional_lotacao_dt_alteracao"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '80' />	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="est_organizacional_lotacao_id" value="<?php echo $est_organizacional_lotacao_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('est_organizacional_lotacao') ?>" class="btn btn-default">Voltar</a> </td>
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
                controller: "<?= $controller ?>",    form: { est_organizacional_lotacao_sup_cd: "<?= $est_organizacional_lotacao_sup_cd?>",
  est_organizacional_lotacao_ds: "<?= $est_organizacional_lotacao_ds?>",
  est_organizacional_lotacao_sigla: "<?= $est_organizacional_lotacao_sigla?>",
  est_organizacional_lotacao_st: "<?= $est_organizacional_lotacao_st?>",
  est_organizacional_lotacao_dt_criacao: "<?= $est_organizacional_lotacao_dt_criacao?>",
  est_organizacional_lotacao_dt_alteracao: "<?= $est_organizacional_lotacao_dt_alteracao?>",
   
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