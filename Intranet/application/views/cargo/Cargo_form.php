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
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Dados_unico.cargo <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Cargo Ds* <?php echo form_error('cargo_ds') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="cargo_ds" id="cargo_ds"  placeholder="Cargo Ds"  v-model="form.cargo_ds" required='required'   maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="numeric">Cargo St <?php echo form_error('cargo_st') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="cargo_st" id="cargo_st"  placeholder="Cargo St"  v-model="form.cargo_st"   onkeypress="mascara(this, soNumeros);"   maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="date">Cargo Dt Criacao <?php echo form_error('cargo_dt_criacao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="date" class="form-control" name="cargo_dt_criacao" id="cargo_dt_criacao"  placeholder="Cargo Dt Criacao"  v-model="form.cargo_dt_criacao"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="date">Cargo Dt Alteracao <?php echo form_error('cargo_dt_alteracao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="date" class="form-control" name="cargo_dt_alteracao" id="cargo_dt_alteracao"  placeholder="Cargo Dt Alteracao"  v-model="form.cargo_dt_alteracao"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="smallint">Funcionario Tipo Id <?php echo form_error('funcionario_tipo_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select2 :options="funcionario_tipo"  v-model='form.funcionario_tipo_id'  id='funcionario_tipo_id'  name='funcionario_tipo_id'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="smallint">Classe Id <?php echo form_error('classe_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select2 :options="classe"  v-model='form.classe_id'  id='classe_id'  name='classe_id'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="smallint">Cargo Qtde <?php echo form_error('cargo_qtde') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="cargo_qtde" id="cargo_qtde"  placeholder="Cargo Qtde"  v-model="form.cargo_qtde"    maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Novo Classe Id <?php echo form_error('novo_classe_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select2 :options="classe"  v-model='form.novo_classe_id'  id='novo_classe_id'  name='novo_classe_id'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="cargo_id" value="<?php echo $cargo_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('cargo') ?>" class="btn btn-default">Voltar</a> </td>
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
                controller: "<?= $controller ?>",
/*tag select*/ 
funcionario_tipo: <?=$funcionario_tipo?>, classe: <?=$classe?>, classe: <?=$classe?>, 
/*form*/ 
    form: { cargo_ds: "<?= $cargo_ds?>",
  cargo_st: "<?= $cargo_st?>",
  cargo_dt_criacao: "<?= $cargo_dt_criacao?>",
  cargo_dt_alteracao: "<?= $cargo_dt_alteracao?>",
  funcionario_tipo_id: "<?= $funcionario_tipo_id?>",
  classe_id: "<?= $classe_id?>",
  cargo_qtde: "<?= $cargo_qtde?>",
  novo_classe_id: "<?= $novo_classe_id?>",
   
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