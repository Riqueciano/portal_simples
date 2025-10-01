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
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Dados_unico.orgao <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Orgao Ds <?php echo form_error('orgao_ds') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="orgao_ds" id="orgao_ds"  placeholder="Orgao Ds"  v-model="form.orgao_ds"    maxlength = '300' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="numeric">Orgao St <?php echo form_error('orgao_st') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="orgao_st" id="orgao_st"  placeholder="Orgao St"  v-model="form.orgao_st"   onkeypress="mascara(this, soNumeros);"   maxlength = '300' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="date">Orgao Dt Criacao <?php echo form_error('orgao_dt_criacao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="date" class="form-control" name="orgao_dt_criacao" id="orgao_dt_criacao"  placeholder="Orgao Dt Criacao"  v-model="form.orgao_dt_criacao"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '300' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="date">Orgao Dt Alteracao <?php echo form_error('orgao_dt_alteracao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="date" class="form-control" name="orgao_dt_alteracao" id="orgao_dt_alteracao"  placeholder="Orgao Dt Alteracao"  v-model="form.orgao_dt_alteracao"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '300' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Flag Maladireta <?php echo form_error('flag_maladireta') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="flag_maladireta" id="flag_maladireta"  placeholder="Flag Maladireta"  v-model="form.flag_maladireta"   onkeypress="mascara(this, soNumeros);"   maxlength = '300' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Maladireta Cd <?php echo form_error('maladireta_cd') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="maladireta_cd" id="maladireta_cd"  placeholder="Maladireta Cd"  v-model="form.maladireta_cd"    maxlength = '20' />	</div> 
                 </td>  </tr><tr>  
            <td>
                <label for="endereco">Endereco <?php echo form_error('endereco') ?></label>
            </td>                    
            <td>  
        <div class="form-group">
        <textarea maxlength="800"  class="form-control" rows="3" v-model="form.endereco"  name="endereco" id="endereco"   placeholder=""  >{{form.endereco }}</textarea>
        </div>
            </td> </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Segmento Id <?php echo form_error('segmento_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select2 :options="segmento"  v-model='form.segmento_id'  id='segmento_id'  name='segmento_id'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="orgao_id" value="<?php echo $orgao_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('orgao') ?>" class="btn btn-default">Voltar</a> </td>
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
segmento: <?=$segmento?>, 
/*form*/ 
    form: { orgao_ds: "<?= $orgao_ds?>",
  orgao_st: "<?= $orgao_st?>",
  orgao_dt_criacao: "<?= $orgao_dt_criacao?>",
  orgao_dt_alteracao: "<?= $orgao_dt_alteracao?>",
  flag_maladireta: "<?= $flag_maladireta?>",
  maladireta_cd: "<?= $maladireta_cd?>",
  endereco: "<?= $endereco?>",
  segmento_id: "<?= $segmento_id?>",
   
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