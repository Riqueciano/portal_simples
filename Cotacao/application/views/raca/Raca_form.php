<?php include '../template/begin_1_2018rn.php'; ?>
<html>
    <head>
        
    </head>
    <body>
    
        <!-- ###app### -->
    <div  id='app'>    
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Cotacao.raca <?php // echo $button ?></h2>   
        <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td  style='width:10%'>   
                    <div class="form-group">
                            <label for="character varying">Raca Nm <?php echo form_error('raca_nm') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="text" class="form-control" name="raca_nm" id="raca_nm"  placeholder=""  v-model="form.raca_nm"    maxlength = '200' />	</div> 
                 </td>  </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="integer">Raca Nota <?php echo form_error('raca_nota') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="number" class="form-control" name="raca_nota" id="raca_nota"  placeholder=""  v-model="form.raca_nota"   onkeypress="mascara(this, soNumeros);"   maxlength = '200' />	</div> 
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
<input type="hidden" name="raca_id" value="<?php echo $raca_id; ?>" />         
<button id="btnGravar" type="button" class="btn btn-primary" @click="submeter()">{{button}}</button>         
<a href="<?php echo site_url('raca') ?>" class="btn btn-default">Voltar</a> </td>
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
                controller: "<?= $controller ?>",    form: { raca_nm: "<?= $raca_nm?>",
  raca_nota: "<?= $raca_nota?>",
   
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