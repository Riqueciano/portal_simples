<?php include '../template/begin_1_2018.php'; ?>
<html>
    <head>
        <script type="text/javascript">
            $(document).ready(function () {
                if ('<?= $controller ?>' == 'read') {
                    $("input").prop("disabled", true);
                    $("select").prop("disabled", true);
                    $("textarea").prop("disabled", true);
                    $("#btnGravar").hide();
                } else if ('<?= $controller ?>' == 'create') {
                    //tela de create
                } else if ('<?= $controller ?>' == 'update') {
                    //tela de update
                }
            });
        </script>
    </head>
    <body>
        <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Seguranca.usuario <?php // echo $button  ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                    <div class='x_content'>
                        <div style='overflow-x:auto'>

                            <table class='table'>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="character varying">Usuario Login* <?php echo form_error('usuario_login') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="text" class="form-control" name="usuario_login" id="usuario_login"  placeholder="Usuario Login"  value="<?php echo $usuario_login; ?>" required='required'   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 


                                    <td>
                                        <label for="usuario_senha">Usuario Senha* <?php echo form_error('usuario_senha') ?></label>
                                    </td>                    
                                    <td>  
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" name="usuario_senha" id="usuario_senha" required='required'  placeholder="Usuario Senha"  ><?php echo $usuario_senha; ?></textarea>
                                        </div>
                                    </td>
                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="numeric">Usuario St <?php echo form_error('usuario_st') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="number" class="form-control" name="usuario_st" id="usuario_st"  placeholder="Usuario St"  value="<?php echo $usuario_st; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="date">Usuario Dt Criacao <?php echo form_error('usuario_dt_criacao') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="date" class="form-control" name="usuario_dt_criacao" id="usuario_dt_criacao"  placeholder="Usuario Dt Criacao"  value="<?php echo $usuario_dt_criacao; ?>"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="date">Usuario Dt Alteracao <?php echo form_error('usuario_dt_alteracao') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="date" class="form-control" name="usuario_dt_alteracao" id="usuario_dt_alteracao"  placeholder="Usuario Dt Alteracao"  value="<?php echo $usuario_dt_alteracao; ?>"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="numeric">Usuario Primeiro Logon <?php echo form_error('usuario_primeiro_logon') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="number" class="form-control" name="usuario_primeiro_logon" id="usuario_primeiro_logon"  placeholder="Usuario Primeiro Logon"  value="<?php echo $usuario_primeiro_logon; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="integer">Usuario Diaria <?php echo form_error('usuario_diaria') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="number" class="form-control" name="usuario_diaria" id="usuario_diaria"  placeholder="Usuario Diaria"  value="<?php echo $usuario_diaria; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="integer">Usuario Login St <?php echo form_error('usuario_login_st') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="number" class="form-control" name="usuario_login_st" id="usuario_login_st"  placeholder="Usuario Login St"  value="<?php echo $usuario_login_st; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="time with time zone">Usuario Login Dt Alteracao <?php echo form_error('usuario_login_dt_alteracao') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="text" class="form-control" name="usuario_login_dt_alteracao" id="usuario_login_dt_alteracao"  placeholder="Usuario Login Dt Alteracao"  value="<?php echo $usuario_login_dt_alteracao; ?>"    maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="integer">Usuario Login Alterador <?php echo form_error('usuario_login_alterador') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="number" class="form-control" name="usuario_login_alterador" id="usuario_login_alterador"  placeholder="Usuario Login Alterador"  value="<?php echo $usuario_login_alterador; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="date">Validade <?php echo form_error('validade') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="date" class="form-control" name="validade" id="validade"  placeholder="Validade"  value="<?php echo $validade; ?>"   onKeyPress='return false;' onPaste='Return false' maxlength='10'   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="integer">Flag Senha Nova <?php echo form_error('flag_senha_nova') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="number" class="form-control" name="flag_senha_nova" id="flag_senha_nova"  placeholder="Flag Senha Nova"  value="<?php echo $flag_senha_nova; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>	
                                <tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="integer">Usuario Id* <?php echo form_error('usuario_id') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="number" class="form-control" name="usuario_id" id="usuario_id"  placeholder="Usuario Id"  value="<?php echo $usuario_id; ?>" required='required'  onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
                                        </div> 
                                    </td>

                                </tr>
                                <tr> 
                                    <td colspan='2'>
                                        <input type="hidden" name="pessoa_id" value="<?php echo $pessoa_id; ?>" /> 
                                        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                                        <a href="<?php echo site_url('usuario') ?>" class="btn btn-default">Voltar</a>

                                    </td>
                                </tr>  

                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>

<?php include '../template/end.php'; ?>