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
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Dados_unico.contrato <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Pessoa Id* <?php echo form_error('pessoa_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select2 :options="pessoa_juridica"  v-model='form.pessoa_id'  id='pessoa_id'  name='pessoa_id'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Contrato Num <?php echo form_error('contrato_num') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="contrato_num" id="contrato_num"  placeholder="Contrato Num"  v-model="form.contrato_num"    maxlength = '10' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Contrato Ds <?php echo form_error('contrato_ds') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="contrato_ds" id="contrato_ds"  placeholder="Contrato Ds"  v-model="form.contrato_ds"    maxlength = '200' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Contrato Dt Inicio <?php echo form_error('contrato_dt_inicio') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="contrato_dt_inicio" id="contrato_dt_inicio"  placeholder="Contrato Dt Inicio"  v-model="form.contrato_dt_inicio"    maxlength = '10' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Contrato Dt Termino <?php echo form_error('contrato_dt_termino') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="contrato_dt_termino" id="contrato_dt_termino"  placeholder="Contrato Dt Termino"  v-model="form.contrato_dt_termino"    maxlength = '10' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Contrato Valor <?php echo form_error('contrato_valor') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="contrato_valor" id="contrato_valor"  placeholder="Contrato Valor"  v-model="form.contrato_valor"    maxlength = '15' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="numeric">Contrato St <?php echo form_error('contrato_st') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="contrato_st" id="contrato_st"  placeholder="Contrato St"  v-model="form.contrato_st"   onkeypress="mascara(this, soNumeros);"   maxlength = '15' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="date">Contrato Dt Criacao <?php echo form_error('contrato_dt_criacao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="date" class="form-control" name="contrato_dt_criacao" id="contrato_dt_criacao"  placeholder="Contrato Dt Criacao"  v-model="form.contrato_dt_criacao"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '15' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="date">Contrato Dt Alteracao <?php echo form_error('contrato_dt_alteracao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="date" class="form-control" name="contrato_dt_alteracao" id="contrato_dt_alteracao"  placeholder="Contrato Dt Alteracao"  v-model="form.contrato_dt_alteracao"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '15' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="smallint">Contrato Num Max <?php echo form_error('contrato_num_max') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="contrato_num_max" id="contrato_num_max"  placeholder="Contrato Num Max"  v-model="form.contrato_num_max"    maxlength = '15' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="smallint">Contrato Tipo Id <?php echo form_error('contrato_tipo_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select2 :options="contrato_tipo"  v-model='form.contrato_tipo_id'  id='contrato_tipo_id'  name='contrato_tipo_id'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="contrato_id" value="<?php echo $contrato_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('contrato') ?>" class="btn btn-default">Voltar</a> </td>
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
contrato_tipo: <?=$contrato_tipo?>, pessoa_juridica: <?=$pessoa_juridica?>, 
/*form*/ 
    form: { pessoa_id: "<?= $pessoa_id?>",
  contrato_num: "<?= $contrato_num?>",
  contrato_ds: "<?= $contrato_ds?>",
  contrato_dt_inicio: "<?= $contrato_dt_inicio?>",
  contrato_dt_termino: "<?= $contrato_dt_termino?>",
  contrato_valor: "<?= $contrato_valor?>",
  contrato_st: "<?= $contrato_st?>",
  contrato_dt_criacao: "<?= $contrato_dt_criacao?>",
  contrato_dt_alteracao: "<?= $contrato_dt_alteracao?>",
  contrato_num_max: "<?= $contrato_num_max?>",
  contrato_tipo_id: "<?= $contrato_tipo_id?>",
   
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