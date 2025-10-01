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
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Cotacao.produto_preco_cotacao <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Entidade Pessoa Id* <?php echo form_error('entidade_pessoa_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select2 :options="pessoa"  v-model='form.entidade_pessoa_id'  id='entidade_pessoa_id'  name='entidade_pessoa_id'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Cotacao Id* <?php echo form_error('cotacao_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select2 :options="cotacao"  v-model='form.cotacao_id'  id='cotacao_id'  name='cotacao_id'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Produto Id* <?php echo form_error('produto_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select2 :options="produto"  v-model='form.produto_id'  id='produto_id'  name='produto_id'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="double precision">Valor* <?php echo form_error('valor') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="" class="form-control" name="valor" id="valor"  placeholder="Valor"  v-model="form.valor" required='required'  onkeypress="mascara(this, money);"   />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="timestamp without time zone">Produto Preco Dt <?php echo form_error('produto_preco_dt') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="produto_preco_dt" id="produto_preco_dt"  placeholder="Produto Preco Dt"  v-model="form.produto_preco_dt"    />	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="produto_preco_cotacao_id" value="<?php echo $produto_preco_cotacao_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('produto_preco_cotacao') ?>" class="btn btn-default">Voltar</a> </td>
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
cotacao: <?=$cotacao?>, produto: <?=$produto?>, pessoa: <?=$pessoa?>, 
/*form*/ 
    form: { entidade_pessoa_id: "<?= $entidade_pessoa_id?>",
  cotacao_id: "<?= $cotacao_id?>",
  produto_id: "<?= $produto_id?>",
  valor: "<?= $valor?>",
  produto_preco_dt: "<?= $produto_preco_dt?>",
   
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