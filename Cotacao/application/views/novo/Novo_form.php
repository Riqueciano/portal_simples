<?php include '../template/begin_1_2018rn.php'; ?>
<html>
    <head>
        
    </head>
    <body>
    
        <!-- ###app### -->
    <div  id='app'>    
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Cotacao.novo <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Novo <?php echo form_error('novo') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="novo" id="novo"  placeholder=""  v-model="form.novo"    maxlength = '300' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="timestamp without time zone">Dataa <?php echo form_error('dataa') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="dataa" id="dataa"  placeholder=""  v-model="form.dataa"    maxlength = '300' />	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="novo_id" value="<?php echo $novo_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('novo') ?>" class="btn btn-default">Voltar</a> </td>
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
                controller: "<?= $controller ?>",    form: { novo: "<?= $novo?>",
  dataa: "<?= $dataa?>",
   
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