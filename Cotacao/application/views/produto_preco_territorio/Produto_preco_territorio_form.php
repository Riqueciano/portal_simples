<?php include '../template/begin_1_2018rn.php'; ?>
<html>
    <head>
        
    </head>
    <body>
    
        <!-- ###app### -->
    <div  id='app'>    
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Cotacao.produto_preco_territorio <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Produto Preco Id* <?php echo form_error('produto_preco_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select   v-model='form.produto_preco_id'  id='produto_preco_id'  name='produto_preco_id' class='select2_single form-control'>
                            <option  value=''>.:Selecione:.</option>
                            <option  :value='i.id' v-for="(i,key) in  produto_preco ">{{i.text}}</option>
                        </select>	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Territorio Id* <?php echo form_error('territorio_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select   v-model='form.territorio_id'  id='territorio_id'  name='territorio_id' class='select2_single form-control'>
                            <option  value=''>.:Selecione:.</option>
                            <option  :value='i.id' v-for="(i,key) in  territorio ">{{i.text}}</option>
                        </select>	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="double precision">Produto Preco Territorio Valor* <?php echo form_error('produto_preco_territorio_valor') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="" class="form-control" name="produto_preco_territorio_valor" id="produto_preco_territorio_valor"  placeholder=""  v-model="form.produto_preco_territorio_valor" required='required'  onkeypress="mascara(this, money);"   />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Produto Preco Territorio Ativo <?php echo form_error('produto_preco_territorio_ativo') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="produto_preco_territorio_ativo" id="produto_preco_territorio_ativo"  placeholder=""  v-model="form.produto_preco_territorio_ativo"   onkeypress="mascara(this, soNumeros);"   />	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="produto_preco_territorio_id" value="<?php echo $produto_preco_territorio_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('produto_preco_territorio') ?>" class="btn btn-default">Voltar</a> </td>
</tr>  

</table> 
</div>
                        </div>
                    </div>
                </div>
</form>
</div>
<!--script type="text/x-template" id="select2-template">
        <select>
           <slot></slot>
        </select>
    </script-->



<script type="module">
            import {
                createApp
            } from "<?=iPATH?>JavaScript/vue/vue3/vue.esm-browser.prod.js"
            import * as func from "<?= iPATH ?>JavaScript/func.js"
const app = createApp({
        data() { 
            return {
                message: '',
                button: "<?= $button ?>",
                controller: "<?= $controller ?>",
/*tag select*/ 
produto_preco: <?=$produto_preco?>, territorio: <?=$territorio?>, 
/*form*/ 
    form: { produto_preco_id: "<?= $produto_preco_id?>",
  territorio_id: "<?= $territorio_id?>",
  produto_preco_territorio_valor: "<?= $produto_preco_territorio_valor?>",
  produto_preco_territorio_ativo: "<?= $produto_preco_territorio_ativo?>",
   
                    }
                }//end data()
            },
            computed: { 

            },
            methods: {
                dataToBR,
                dataToBRcomHora, 
            },
            watch: {
                
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
        })
        
        app.mount('#app');
    </script>
</body> 
</html>

<?php include '../template/end.php'; ?>