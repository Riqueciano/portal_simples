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
      <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Dados_unico.pessoa_fisica <?php // echo $button ?></h2>   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'><tr>  <td>   
                    <div class="form-group">
                    <label for="character">Pessoa Fisica Sexo <?php echo form_error('pessoa_fisica_sexo') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_sexo" id="pessoa_fisica_sexo"  placeholder="Pessoa Fisica Sexo"  v-model="form.pessoa_fisica_sexo"    maxlength = '1' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Cpf* <?php echo form_error('pessoa_fisica_cpf') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_cpf" id="pessoa_fisica_cpf"  placeholder="Pessoa Fisica Cpf"  v-model="form.pessoa_fisica_cpf" required='required'   maxlength = '20' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Dt Nasc <?php echo form_error('pessoa_fisica_dt_nasc') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_dt_nasc" id="pessoa_fisica_dt_nasc"  placeholder="Pessoa Fisica Dt Nasc"  v-model="form.pessoa_fisica_dt_nasc"    maxlength = '10' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Rg <?php echo form_error('pessoa_fisica_rg') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_rg" id="pessoa_fisica_rg"  placeholder="Pessoa Fisica Rg"  v-model="form.pessoa_fisica_rg"    maxlength = '20' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Rg Orgao <?php echo form_error('pessoa_fisica_rg_orgao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_rg_orgao" id="pessoa_fisica_rg_orgao"  placeholder="Pessoa Fisica Rg Orgao"  v-model="form.pessoa_fisica_rg_orgao"    maxlength = '50' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character">Pessoa Fisica Rg Uf <?php echo form_error('pessoa_fisica_rg_uf') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_rg_uf" id="pessoa_fisica_rg_uf"  placeholder="Pessoa Fisica Rg Uf"  v-model="form.pessoa_fisica_rg_uf"    maxlength = '2' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Rg Dt <?php echo form_error('pessoa_fisica_rg_dt') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_rg_dt" id="pessoa_fisica_rg_dt"  placeholder="Pessoa Fisica Rg Dt"  v-model="form.pessoa_fisica_rg_dt"    maxlength = '10' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Passaporte <?php echo form_error('pessoa_fisica_passaporte') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_passaporte" id="pessoa_fisica_passaporte"  placeholder="Pessoa Fisica Passaporte"  v-model="form.pessoa_fisica_passaporte"    maxlength = '50' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Nm Pai <?php echo form_error('pessoa_fisica_nm_pai') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_nm_pai" id="pessoa_fisica_nm_pai"  placeholder="Pessoa Fisica Nm Pai"  v-model="form.pessoa_fisica_nm_pai"    maxlength = '255' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Nm Mae <?php echo form_error('pessoa_fisica_nm_mae') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_nm_mae" id="pessoa_fisica_nm_mae"  placeholder="Pessoa Fisica Nm Mae"  v-model="form.pessoa_fisica_nm_mae"    maxlength = '255' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Grupo Sanguineo <?php echo form_error('pessoa_fisica_grupo_sanguineo') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_grupo_sanguineo" id="pessoa_fisica_grupo_sanguineo"  placeholder="Pessoa Fisica Grupo Sanguineo"  v-model="form.pessoa_fisica_grupo_sanguineo"    maxlength = '3' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Nacionalidade <?php echo form_error('pessoa_fisica_nacionalidade') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_nacionalidade" id="pessoa_fisica_nacionalidade"  placeholder="Pessoa Fisica Nacionalidade"  v-model="form.pessoa_fisica_nacionalidade"    maxlength = '50' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Naturalidade <?php echo form_error('pessoa_fisica_naturalidade') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_naturalidade" id="pessoa_fisica_naturalidade"  placeholder="Pessoa Fisica Naturalidade"  v-model="form.pessoa_fisica_naturalidade"    maxlength = '10' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character">Pessoa Fisica Naturalidade Uf <?php echo form_error('pessoa_fisica_naturalidade_uf') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_naturalidade_uf" id="pessoa_fisica_naturalidade_uf"  placeholder="Pessoa Fisica Naturalidade Uf"  v-model="form.pessoa_fisica_naturalidade_uf"    maxlength = '2' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Clt <?php echo form_error('pessoa_fisica_clt') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_clt" id="pessoa_fisica_clt"  placeholder="Pessoa Fisica Clt"  v-model="form.pessoa_fisica_clt"    maxlength = '20' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Clt Serie <?php echo form_error('pessoa_fisica_clt_serie') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_clt_serie" id="pessoa_fisica_clt_serie"  placeholder="Pessoa Fisica Clt Serie"  v-model="form.pessoa_fisica_clt_serie"    maxlength = '10' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character">Pessoa Fisica Clt Uf <?php echo form_error('pessoa_fisica_clt_uf') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_clt_uf" id="pessoa_fisica_clt_uf"  placeholder="Pessoa Fisica Clt Uf"  v-model="form.pessoa_fisica_clt_uf"    maxlength = '2' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Titulo <?php echo form_error('pessoa_fisica_titulo') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_titulo" id="pessoa_fisica_titulo"  placeholder="Pessoa Fisica Titulo"  v-model="form.pessoa_fisica_titulo"    maxlength = '20' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Titulo Zona <?php echo form_error('pessoa_fisica_titulo_zona') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_titulo_zona" id="pessoa_fisica_titulo_zona"  placeholder="Pessoa Fisica Titulo Zona"  v-model="form.pessoa_fisica_titulo_zona"    maxlength = '20' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Titulo Secao <?php echo form_error('pessoa_fisica_titulo_secao') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_titulo_secao" id="pessoa_fisica_titulo_secao"  placeholder="Pessoa Fisica Titulo Secao"  v-model="form.pessoa_fisica_titulo_secao"    maxlength = '20' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Titulo Cidade <?php echo form_error('pessoa_fisica_titulo_cidade') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_titulo_cidade" id="pessoa_fisica_titulo_cidade"  placeholder="Pessoa Fisica Titulo Cidade"  v-model="form.pessoa_fisica_titulo_cidade"    maxlength = '10' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character">Pessoa Fisica Titulo Uf <?php echo form_error('pessoa_fisica_titulo_uf') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_titulo_uf" id="pessoa_fisica_titulo_uf"  placeholder="Pessoa Fisica Titulo Uf"  v-model="form.pessoa_fisica_titulo_uf"    maxlength = '2' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Cnh <?php echo form_error('pessoa_fisica_cnh') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_cnh" id="pessoa_fisica_cnh"  placeholder="Pessoa Fisica Cnh"  v-model="form.pessoa_fisica_cnh"    maxlength = '20' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Cnh Categoria <?php echo form_error('pessoa_fisica_cnh_categoria') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_cnh_categoria" id="pessoa_fisica_cnh_categoria"  placeholder="Pessoa Fisica Cnh Categoria"  v-model="form.pessoa_fisica_cnh_categoria"    maxlength = '2' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Cnh Validade <?php echo form_error('pessoa_fisica_cnh_validade') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_cnh_validade" id="pessoa_fisica_cnh_validade"  placeholder="Pessoa Fisica Cnh Validade"  v-model="form.pessoa_fisica_cnh_validade"    maxlength = '10' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Reservista <?php echo form_error('pessoa_fisica_reservista') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_reservista" id="pessoa_fisica_reservista"  placeholder="Pessoa Fisica Reservista"  v-model="form.pessoa_fisica_reservista"    maxlength = '20' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Reservista Ministerio <?php echo form_error('pessoa_fisica_reservista_ministerio') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_reservista_ministerio" id="pessoa_fisica_reservista_ministerio"  placeholder="Pessoa Fisica Reservista Ministerio"  v-model="form.pessoa_fisica_reservista_ministerio"    maxlength = '20' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character">Pessoa Fisica Reservista Uf <?php echo form_error('pessoa_fisica_reservista_uf') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_reservista_uf" id="pessoa_fisica_reservista_uf"  placeholder="Pessoa Fisica Reservista Uf"  v-model="form.pessoa_fisica_reservista_uf"    maxlength = '2' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Pis <?php echo form_error('pessoa_fisica_pis') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_pis" id="pessoa_fisica_pis"  placeholder="Pessoa Fisica Pis"  v-model="form.pessoa_fisica_pis"    maxlength = '50' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="smallint">Estado Civil Id <?php echo form_error('estado_civil_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select2 :options="estado_civil"  v-model='form.estado_civil_id'  id='estado_civil_id'  name='estado_civil_id'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="smallint">Nivel Escolar Id <?php echo form_error('nivel_escolar_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">
<select2 :options="nivel_escolar"  v-model='form.nivel_escolar_id'  id='nivel_escolar_id'  name='nivel_escolar_id'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="numeric">Pessoa Fisica Funcionario <?php echo form_error('pessoa_fisica_funcionario') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="pessoa_fisica_funcionario" id="pessoa_fisica_funcionario"  placeholder="Pessoa Fisica Funcionario"  v-model="form.pessoa_fisica_funcionario"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Cnh Lente Corretiva <?php echo form_error('pessoa_fisica_cnh_lente_corretiva') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_cnh_lente_corretiva" id="pessoa_fisica_cnh_lente_corretiva"  placeholder="Pessoa Fisica Cnh Lente Corretiva"  v-model="form.pessoa_fisica_cnh_lente_corretiva"    maxlength = '1' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Filho <?php echo form_error('pessoa_fisica_filho') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_filho" id="pessoa_fisica_filho"  placeholder="Pessoa Fisica Filho"  v-model="form.pessoa_fisica_filho"    maxlength = '2' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Filha <?php echo form_error('pessoa_fisica_filha') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_filha" id="pessoa_fisica_filha"  placeholder="Pessoa Fisica Filha"  v-model="form.pessoa_fisica_filha"    maxlength = '2' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Apelido <?php echo form_error('pessoa_apelido') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_apelido" id="pessoa_apelido"  placeholder="Pessoa Apelido"  v-model="form.pessoa_apelido"    maxlength = '70' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Pessoa Fisica Foto <?php echo form_error('pessoa_fisica_foto') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="pessoa_fisica_foto" id="pessoa_fisica_foto"  placeholder="Pessoa Fisica Foto"  v-model="form.pessoa_fisica_foto"   onkeypress="mascara(this, soNumeros);"   maxlength = '70' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Pessoa Fisica St Site <?php echo form_error('pessoa_fisica_st_site') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="pessoa_fisica_st_site" id="pessoa_fisica_st_site"  placeholder="Pessoa Fisica St Site"  v-model="form.pessoa_fisica_st_site"   onkeypress="mascara(this, soNumeros);"   maxlength = '70' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Represen <?php echo form_error('pessoa_fisica_represen') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_represen" id="pessoa_fisica_represen"  placeholder="Pessoa Fisica Represen"  v-model="form.pessoa_fisica_represen"    maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Represen Desc <?php echo form_error('pessoa_fisica_represen_desc') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_represen_desc" id="pessoa_fisica_represen_desc"  placeholder="Pessoa Fisica Represen Desc"  v-model="form.pessoa_fisica_represen_desc"    maxlength = '100' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="character varying">Pessoa Fisica Ano Ingresso <?php echo form_error('pessoa_fisica_ano_ingresso') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="text" class="form-control" name="pessoa_fisica_ano_ingresso" id="pessoa_fisica_ano_ingresso"  placeholder="Pessoa Fisica Ano Ingresso"  v-model="form.pessoa_fisica_ano_ingresso"    maxlength = '10' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Area Profissional Id <?php echo form_error('area_profissional_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="area_profissional_id" id="area_profissional_id"  placeholder="Area Profissional Id"  v-model="form.area_profissional_id"   onkeypress="mascara(this, soNumeros);"   maxlength = '10' />	</div> 
                 </td>  </tr><tr>  <td>   
                    <div class="form-group">
                    <label for="integer">Pessoa Fisica Id* <?php echo form_error('pessoa_fisica_id') ?></label>
                                        </div>
                        </td>  <td>  
                            <div class="item form-group">  <input type="number" class="form-control" name="pessoa_fisica_id" id="pessoa_fisica_id"  placeholder="Pessoa Fisica Id"  v-model="form.pessoa_fisica_id" required='required'  onkeypress="mascara(this, soNumeros);"   maxlength = '10' />	</div> 
                 </td>  </tr><tr> 
                <td colspan='2'>        
<input type="hidden" name="pessoa_id" value="<?php echo $pessoa_id; ?>" />         
<button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>         
<a href="<?php echo site_url('pessoa_fisica') ?>" class="btn btn-default">Voltar</a> </td>
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
estado_civil: <?=$estado_civil?>, nivel_escolar: <?=$nivel_escolar?>, pessoa: <?=$pessoa?>, 
/*form*/ 
    form: { pessoa_fisica_sexo: "<?= $pessoa_fisica_sexo?>",
  pessoa_fisica_cpf: "<?= $pessoa_fisica_cpf?>",
  pessoa_fisica_dt_nasc: "<?= $pessoa_fisica_dt_nasc?>",
  pessoa_fisica_rg: "<?= $pessoa_fisica_rg?>",
  pessoa_fisica_rg_orgao: "<?= $pessoa_fisica_rg_orgao?>",
  pessoa_fisica_rg_uf: "<?= $pessoa_fisica_rg_uf?>",
  pessoa_fisica_rg_dt: "<?= $pessoa_fisica_rg_dt?>",
  pessoa_fisica_passaporte: "<?= $pessoa_fisica_passaporte?>",
  pessoa_fisica_nm_pai: "<?= $pessoa_fisica_nm_pai?>",
  pessoa_fisica_nm_mae: "<?= $pessoa_fisica_nm_mae?>",
  pessoa_fisica_grupo_sanguineo: "<?= $pessoa_fisica_grupo_sanguineo?>",
  pessoa_fisica_nacionalidade: "<?= $pessoa_fisica_nacionalidade?>",
  pessoa_fisica_naturalidade: "<?= $pessoa_fisica_naturalidade?>",
  pessoa_fisica_naturalidade_uf: "<?= $pessoa_fisica_naturalidade_uf?>",
  pessoa_fisica_clt: "<?= $pessoa_fisica_clt?>",
  pessoa_fisica_clt_serie: "<?= $pessoa_fisica_clt_serie?>",
  pessoa_fisica_clt_uf: "<?= $pessoa_fisica_clt_uf?>",
  pessoa_fisica_titulo: "<?= $pessoa_fisica_titulo?>",
  pessoa_fisica_titulo_zona: "<?= $pessoa_fisica_titulo_zona?>",
  pessoa_fisica_titulo_secao: "<?= $pessoa_fisica_titulo_secao?>",
  pessoa_fisica_titulo_cidade: "<?= $pessoa_fisica_titulo_cidade?>",
  pessoa_fisica_titulo_uf: "<?= $pessoa_fisica_titulo_uf?>",
  pessoa_fisica_cnh: "<?= $pessoa_fisica_cnh?>",
  pessoa_fisica_cnh_categoria: "<?= $pessoa_fisica_cnh_categoria?>",
  pessoa_fisica_cnh_validade: "<?= $pessoa_fisica_cnh_validade?>",
  pessoa_fisica_reservista: "<?= $pessoa_fisica_reservista?>",
  pessoa_fisica_reservista_ministerio: "<?= $pessoa_fisica_reservista_ministerio?>",
  pessoa_fisica_reservista_uf: "<?= $pessoa_fisica_reservista_uf?>",
  pessoa_fisica_pis: "<?= $pessoa_fisica_pis?>",
  estado_civil_id: "<?= $estado_civil_id?>",
  nivel_escolar_id: "<?= $nivel_escolar_id?>",
  pessoa_fisica_funcionario: "<?= $pessoa_fisica_funcionario?>",
  pessoa_fisica_cnh_lente_corretiva: "<?= $pessoa_fisica_cnh_lente_corretiva?>",
  pessoa_fisica_filho: "<?= $pessoa_fisica_filho?>",
  pessoa_fisica_filha: "<?= $pessoa_fisica_filha?>",
  pessoa_apelido: "<?= $pessoa_apelido?>",
  pessoa_fisica_foto: "<?= $pessoa_fisica_foto?>",
  pessoa_fisica_st_site: "<?= $pessoa_fisica_st_site?>",
  pessoa_fisica_represen: "<?= $pessoa_fisica_represen?>",
  pessoa_fisica_represen_desc: "<?= $pessoa_fisica_represen_desc?>",
  pessoa_fisica_ano_ingresso: "<?= $pessoa_fisica_ano_ingresso?>",
  area_profissional_id: "<?= $area_profissional_id?>",
  pessoa_fisica_id: "<?= $pessoa_fisica_id?>",
   
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