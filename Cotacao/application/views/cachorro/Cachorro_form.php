<?php include '../template/begin_1_2018rn.php'; ?>
<html>
    <head>
        
    </head>
    <body>
    
        <!-- ###app### -->
    <div  id='app'>    
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Cotacao.cachorro <?php // echo $button ?></h2>   
        <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td  style='width:10%'>   
                    <div class="form-group">
                            <label for="character varying">Cachorro Nm* <?php echo form_error('cachorro_nm') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="text" class="form-control" name="cachorro_nm" id="cachorro_nm"  placeholder=""  v-model="form.cachorro_nm" required='required'   maxlength = '20' />	</div> 
                 </td>  </tr><tr>  
            <td >
                <label for="cachorro_descricao">Cachorro Descricao <?php echo form_error('cachorro_descricao') ?></label>
            </td>                    
            <td>  
                <div class="form-group">
                        <textarea maxlength="600"  class="form-control" rows="3" v-model="form.cachorro_descricao"  name="cachorro_descricao" id="cachorro_descricao"   placeholder=""  >{{form.cachorro_descricao }}</textarea>
                </div>
            </td> </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="date">Nascimento* <?php echo form_error('nascimento') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="date" class="form-control" name="nascimento" id="nascimento"  placeholder=""  v-model="form.nascimento" required='required'  onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '20' />	</div> 
                 </td>  </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="integer">Raca Id* <?php echo form_error('raca_id') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group">
 <select2-component id="raca_id" name="raca_id" :selected="form.raca_id"  v-model="form.raca_id" :options="raca"></select2-component>	</div> 
                 </td>  </tr>
                                </table>
                            </div>
                        </div>
                    </div> 
            <div class='x_panel' id=''>
        <div class='x_content'>
<div style='overflow-x:auto'>
<table class='table'>

<tr> 
                <td colspan='2'>        
<input type="hidden" name="cachorro_id" value="<?php echo $cachorro_id; ?>" />         
<button id="btnGravar" type="button" class="btn btn-primary" @click="submeter()">{{button}}</button>         
<a href="<?php echo site_url('cachorro') ?>" class="btn btn-default">Voltar</a> </td>
</tr>  

</table> 
</div>
                        </div>
                    </div>
                </div>
</form>
</div>
 

<!-- <select2-component v-model="id" :options="array" ></select2-component   > -->
<script type="module">
            import {
                createApp
            } from "<?=iPATH?>JavaScript/vue/vue3/vue.esm-browser.prod.js"

            import {
                Select2Component
            } from "<?= iPATH ?>JavaScript/vue/select2/Select2Component.js"

            import * as func from "<?= iPATH ?>JavaScript/func.js"



const app = createApp({
    components: {
        Select2Component
    },
        data() { 
            return {
                message: '',
                button: "<?= $button ?>",
                controller: "<?= $controller ?>",
/*tag select*/ 
raca: <?=$raca?>, 
/*form*/ 
    form: { cachorro_nm: "<?= $cachorro_nm?>",
  cachorro_descricao: "<?= $cachorro_descricao?>",
  nascimento: "<?= $nascimento?>",
  raca_id: "<?= $raca_id?>",
   
                    }
                }//end data()
            },
            computed: { 

            },
            methods: {
                dataToBR,
                dataToBRcomHora, 
                moedaBR, 
                submeter: function(){
                    $('#form').submit()
                },
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