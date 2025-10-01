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
        <h2 style="margin-top:0px"><span id='spanAcaoForm'>Cadastro</span> Instituição <?php // echo $button    ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

            <table class='table'>	
                <tr> 
                    <td>
                        <div class="form-group">
                            <label for="character varying">Instituição* <?php echo form_error('instituicao_nm') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="instituicao_nm" id="instituicao_nm" placeholder="Instituicao Nm" value="<?php echo $instituicao_nm; ?>" required='required'   maxlength = '200' />
                            </div>
                        </div>
                    </td> 
                </tr>	
                <tr> 
                    <td>
                        <div class="form-group">
                            <label for="character varying">Sigla <?php echo form_error('instituicao_sigla') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="instituicao_sigla" id="instituicao_sigla" placeholder="Instituicao Sigla" value="<?php echo $instituicao_sigla; ?>"    maxlength = '20' />
                            </div>
                        </div>
                    </td> 
                </tr>	
                <tr> 
                    <td>
                        <div class="form-group">
                            <label for="character varying">Endereço* <?php echo form_error('instituicao_endereco') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="instituicao_endereco" id="instituicao_endereco" placeholder="Instituicao Endereco" value="<?php echo $instituicao_endereco; ?>" required='required'   maxlength = '500' />
                            </div>
                        </div>
                    </td> 
                </tr>	
                <tr> 
                    <td>
                        <div class="form-group">
                            <label for="character varying">CEP <?php echo form_error('instituicao_endereco_cep') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="instituicao_endereco_cep" id="instituicao_endereco_cep" placeholder="Instituicao Endereco Cep" value="<?php echo $instituicao_endereco_cep; ?>"    maxlength = '20' />
                            </div>
                        </div>
                    </td> 
                </tr>	
                <tr> 
                    <td>
                        <div class="form-group">
                            <label for="integer">Municipio* <?php echo form_error('municipio_id') ?></label>
                            <div class="item form-group"><?php echo combo('municipio_id', 'indice.municipio', 'municipio_id', 'municipio_nm', '', $municipio_id, " and ativo=1 and estado_uf='BA' order by municipio_nm"); ?>
                            </div>
                        </div>
                    </td> 
                </tr>
                <tr> 
                    <td>
                        <input type="hidden" name="instituicao_id" value="<?php echo $instituicao_id; ?>" /> 
                        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('instituicao') ?>" class="btn btn-default">Voltar</a>

                    </td>
                </tr>  

            </table>   
        </form>
    </body>
</html>

<?php include '../template/end.php'; ?>