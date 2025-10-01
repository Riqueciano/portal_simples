<?php include '../template/begin_1_2018rn.php'; ?>
<html>
    <head>
        
    </head>
    <body>
    
        <!-- ###app### -->
    <div  id='app'>    
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Abelha.abelha <?php // echo $button ?></h2>   
        <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td  style='width:10%'>   
                    <div class="form-group">
                            <label for="character varying">Abelha Nm* <?php echo form_error('abelha_nm') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="text" class="form-control" name="abelha_nm" id="abelha_nm"  placeholder=""  v-model="form.abelha_nm" required='required'   maxlength = '150' />	</div> 
                 </td>  </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="character varying">Referencia <?php echo form_error('referencia') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="text" class="form-control" name="referencia" id="referencia"  placeholder=""  v-model="form.referencia"    maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="integer">Abelha Genero Id* <?php echo form_error('abelha_genero_id') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group">
 <select2-component id="abelha_genero_id" name="abelha_genero_id" :selected="form.abelha_genero_id"  v-model="form.abelha_genero_id" :options="abelha_genero"></select2-component>	</div> 
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
<input type="hidden" name="abelha_id" value="<?php echo $abelha_id; ?>" />         
<button id="btnGravar" type="button" class="btn btn-primary" @click="submeter()">{{button}}</button>         
<a href="<?php echo site_url('abelha') ?>" class="btn btn-default">Voltar</a> </td>
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
abelha_genero: <?=$abelha_genero?>, 
/*form*/ 
    form: { abelha_nm: "<?= $abelha_nm?>",
  referencia: "<?= $referencia?>",
  abelha_genero_id: "<?= $abelha_genero_id?>",
   
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