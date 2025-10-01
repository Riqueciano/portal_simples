<?php include '../template/begin_1_2018rn.php'; ?>
<html>
    <head>
        
    </head>
    <body>
    
        <!-- ###app### -->
    <div  id='app'>    
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Intranet.publicacao <?php // echo $button ?></h2>   
        <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td  style='width:10%'>   
                    <div class="form-group">
                            <label for="character varying">Publicacao Titulo <?php echo form_error('publicacao_titulo') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="text" class="form-control" name="publicacao_titulo" id="publicacao_titulo"  placeholder=""  v-model="form.publicacao_titulo"    maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="timestamp without time zone">Publicacao Dt Publicacao <?php echo form_error('publicacao_dt_publicacao') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="text" class="form-control" name="publicacao_dt_publicacao" id="publicacao_dt_publicacao"  placeholder=""  v-model="form.publicacao_dt_publicacao"    maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="character varying">Publicacao Img <?php echo form_error('publicacao_img') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="text" class="form-control" name="publicacao_img" id="publicacao_img"  placeholder=""  v-model="form.publicacao_img"    maxlength = '100' />	</div> 
                 </td>  </tr><tr>  
            <td >
                <label for="publicacao_corpo">Publicacao Corpo <?php echo form_error('publicacao_corpo') ?></label>
            </td>                    
            <td>  
                <div class="form-group">
                        <textarea maxlength="80000"  class="form-control" rows="3" v-model="form.publicacao_corpo"  name="publicacao_corpo" id="publicacao_corpo"   placeholder=""  >{{form.publicacao_corpo }}</textarea>
                </div>
            </td> </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="integer">Publicacao St <?php echo form_error('publicacao_st') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="number" class="form-control" name="publicacao_st" id="publicacao_st"  placeholder=""  v-model="form.publicacao_st"   onkeypress="mascara(this, soNumeros);"   maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="timestamp without time zone">Publicacao Dt Criacao <?php echo form_error('publicacao_dt_criacao') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="text" class="form-control" name="publicacao_dt_criacao" id="publicacao_dt_criacao"  placeholder=""  v-model="form.publicacao_dt_criacao"    maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="timestamp without time zone">Publicacao Dt Alteracao <?php echo form_error('publicacao_dt_alteracao') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="text" class="form-control" name="publicacao_dt_alteracao" id="publicacao_dt_alteracao"  placeholder=""  v-model="form.publicacao_dt_alteracao"    maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="integer">Publicacao Tipo <?php echo form_error('publicacao_tipo') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="number" class="form-control" name="publicacao_tipo" id="publicacao_tipo"  placeholder=""  v-model="form.publicacao_tipo"   onkeypress="mascara(this, soNumeros);"   maxlength = '100' />	</div> 
                 </td>  </tr><tr>  
            <td >
                <label for="publicacao_link">Publicacao Link <?php echo form_error('publicacao_link') ?></label>
            </td>                    
            <td>  
                <div class="form-group">
                        <textarea maxlength="1000"  class="form-control" rows="3" v-model="form.publicacao_link"  name="publicacao_link" id="publicacao_link"   placeholder=""  >{{form.publicacao_link }}</textarea>
                </div>
            </td> </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="integer">Ativo <?php echo form_error('ativo') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="number" class="form-control" name="ativo" id="ativo"  placeholder=""  v-model="form.ativo"   onkeypress="mascara(this, soNumeros);"   maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td  >   
                    <div class="form-group">
                            <label for="integer">Flag Carrossel <?php echo form_error('flag_carrossel') ?></label>
                                                </div>
                                </td>  <td>  
                            <div class="item form-group"> 
 <input type="number" class="form-control" name="flag_carrossel" id="flag_carrossel"  placeholder=""  v-model="form.flag_carrossel"   onkeypress="mascara(this, soNumeros);"   maxlength = '100' />	</div> 
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
<input type="hidden" name="publicacao_id" value="<?php echo $publicacao_id; ?>" />         
<button id="btnGravar" type="button" class="btn btn-primary" @click="submeter()">{{button}}</button>         
<a href="<?php echo site_url('publicacao') ?>" class="btn btn-default">Voltar</a> </td>
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
                controller: "<?= $controller ?>",    form: { publicacao_titulo: "<?= $publicacao_titulo?>",
  publicacao_dt_publicacao: "<?= $publicacao_dt_publicacao?>",
  publicacao_img: "<?= $publicacao_img?>",
  publicacao_corpo: "<?= $publicacao_corpo?>",
  publicacao_st: "<?= $publicacao_st?>",
  publicacao_dt_criacao: "<?= $publicacao_dt_criacao?>",
  publicacao_dt_alteracao: "<?= $publicacao_dt_alteracao?>",
  publicacao_tipo: "<?= $publicacao_tipo?>",
  publicacao_link: "<?= $publicacao_link?>",
  ativo: "<?= $ativo?>",
  flag_carrossel: "<?= $flag_carrossel?>",
   
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