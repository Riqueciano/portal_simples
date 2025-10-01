<?php include '../template/begin_1_2018rn.php'; ?>
<html>
    <head>
        
    </head>
    <body>
    
        <!-- ###app### -->
    <div  id='app'>    
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Selo.produto_tipo <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Produto Tipo Nm <?php echo form_error('produto_tipo_nm') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="produto_tipo_nm" id="produto_tipo_nm"  placeholder="Produto Tipo Nm"  v-model="form.produto_tipo_nm"    maxlength = '200' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Icone <?php echo form_error('icone') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="icone" id="icone"  placeholder="Icone"  v-model="form.icone"    maxlength = '200' />	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="produto_tipo_id" value="<?php echo $produto_tipo_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('produto_tipo') ?>" class="btn btn-default">Voltar</a> </td>
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


<!--monta combobox-->
<!--script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/select2/montaSelect.js"></script-->
<script type="text/javascript" language="javascript" src="<?php echo iPATH ?>/JavaScript/vue/select2/montaSelect.js"></script>

<script type="module">
            import {
                createApp
            } from "https://127.0.0.1/<?=$nmServer?>JavaScript/vue/vue3/vue.esm-browser.prod.js"

    createApp({
        data() { 
            return {
                message: '',
                button: "<?= $button ?>",
                controller: "<?= $controller ?>",    form: { produto_tipo_nm: "<?= $produto_tipo_nm?>",
  icone: "<?= $icone?>",
   
                    }
                }//end data()
            },
            computed: { 

            },
            methods: {

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
        }).mount('#app');  
    </script>
</body> 
</html>

<?php include '../template/end.php'; ?>