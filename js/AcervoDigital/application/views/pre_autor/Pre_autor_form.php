<?php include '../template/begin.php'; ?>
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
        <h2 style="margin-top:0px"><span id='spanAcaoForm'>Cadastro</span> Autor <?php // echo $button   ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" >
            <table class='table'>	
                <tr> 
                    <td>
                        <div class="form-group">
                            <label for="character varying">Nome* <?php echo form_error('pre_autor_nm') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="pre_autor_nm" id="pre_autor_nm" placeholder="Nome" value="<?php echo $pre_autor_nm; ?>" required='required'   maxlength = '200' />
                            </div>
                        </div>
                    </td> 
                </tr>	
                <tr> 
                    <td>
                        <div class="form-group">
                            <label for="character varying">Cpf* <?php echo form_error('cpf') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Cpf" value="<?php echo $cpf; ?>" required='required'  onkeypress="mascara(this, cpfM);"  maxlength = '14' />
                            </div>
                        </div>
                    </td> 
                </tr>	
                <tr> 
                    <td>
                        <div class="form-group">
                            <label for="character varying">Email* <?php echo form_error('email') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" required='required'   maxlength = '200' />
                            </div>
                        </div>
                    </td> 
                </tr>	
                <tr> 
                    <td>
                        <div class="form-group">
                            <label for="character varying">Instituicao* <?php echo form_error('instituicao') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="instituicao" id="instituicao" placeholder="Instituicao" value="<?php echo $instituicao; ?>" required='required'   maxlength = '200' />
                            </div>
                        </div>
                    </td> 
                </tr>	
            </table>	
            <table class="table">	
                <tr> 
                    <td style="width:100px">
                        <div class="form-group">
                            <label for="character varying">DDD* <?php echo form_error('telefone_ddd') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="telefone_ddd" id="telefone_ddd" placeholder="Telefone Ddd" value="<?php echo $telefone_ddd; ?>" required='required'   maxlength = '2' />
                            </div>
                        </div>
                    </td>  
                    <td>
                        <div class="form-group">
                            <label for="character varying">Telefone* <?php echo form_error('telefone') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Telefone" value="<?php echo $telefone; ?>" required='required'   maxlength = '15' />
                            </div>
                        </div>
                    </td> 
                </tr>
            </table>	
            <table class="table">
                <tr> 
                    <td>
                        <input type="hidden" name="autor_complemento_id" value="<?php echo $autor_complemento_id; ?>" /> 
                        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('pre_autor') ?>" class="btn btn-default">Voltar</a>
                    </td>
                </tr>  
            </table>   
        </form>
    </body>
</html>

<?php include '../template/end.php'; ?>