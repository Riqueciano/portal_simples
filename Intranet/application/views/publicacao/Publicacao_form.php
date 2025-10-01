<?php include '../template/begin_1_2018.php'; ?>
<html>

<head>
    <script type="text/javascript">
        $(document).ready(function() {
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

        function submeter() {
           
            if(!$('#publicacao_titulo').val()){
                alert('Favor informar o titulo');
                $('#publicacao_titulo').focus()
                return false;
            }
 
  
            // if ($('#publicacao_titulo').val().length < 5) {
            //     $('#publicacao_titulo').focus();
            //     alert('Favor infromar um título valido');
            //     return false;   
            // }   

             if ($('#publicacao_dt_publicacao').val() == '') {
                alert('Favor escolher uma data!');
                $('#publicacao_dt_publicacao').focus();
                return false;
            }
            $('#form').submit();
        }
    </script>
</head>

<body>
    <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Intranet.publicacao <?php // echo $button  
                                                                                                                                            ?></h2>
    <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class='col-md-12' name='' id=''>
            <div class='x_panel' id=''>
                <div class='x_content'>
                    <div style='overflow-x:auto'>

                        <table class='table'>
                            <tr>

                                <td style="width: 15%">
                                    <div class="form-group">
                                        <label for="character varying">Título <?php echo form_error('publicacao_titulo') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        
                                         <textarea class="form-control" name="publicacao_titulo" 
                                         id="publicacao_titulo" placeholder="Titulo"  maxlength='100' ><?php echo $publicacao_titulo; ?></textarea>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <b>Carrossel?</b>
                                </td>
                                <td>
                                    <select name="flag_carrossel" id="flag_carrossel" class="form-control">
                                        <option value="0">Não (É considerado uma notícia)</option>
                                        <option value="1">Sim (Fica em destaque no carossel)</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="timestamp without time zone">Data <?php echo form_error('publicacao_dt_publicacao') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="DATE" style="width: 20%" class="form-control" name="publicacao_dt_publicacao" id="publicacao_dt_publicacao" placeholder="Data" value="<?php echo $publicacao_dt_publicacao; ?>" maxlength='100' />
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>

                                    <div class="form-group">

                                        <label for="character varying">Imagem <?php echo form_error('publicacao_img') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <b class="red">Limite 700kb </b>
                                        <b class="red"> - Limite estipulado devido a qualidade ruim da internet em algumas unidades </b>
                                        <br>
                                        <small class="red">Imagens grandes deixam o carregamento da pagina lenta, favor anexar a imagem no menor tamanho possivel</small>
                                        <input type="file" class="form-control" name="publicacao_img" id="publicacao_img" placeholder="Publicacao Img" value="<?php echo $publicacao_img; ?>" maxlength='100' />
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label for="publicacao_link"> Link externo <?php echo form_error('publicacao_link') ?></label>                                   
                                </td>
                                <td>
                                    <div class="form-group">
                                    <b class="red">O banner se torna clicavel, caso o link seja fornecido</b> <br>
                                    <b class="red">ex.: https://www.site.com.br</b>
                                        <textarea class="form-control" rows="3" name="publicacao_link" id="publicacao_link" placeholder="Publicacao Link"><?php echo $publicacao_link; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="publicacao_corpo">Corpo <?php echo form_error('publicacao_corpo') ?></label>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="20" name="publicacao_corpo" id="publicacao_corpo"><?php echo $publicacao_corpo; ?></textarea>
                                    </div>
                                </td>
                            </tr>



                            <!--tr> 

                                    <td>   
                                        <div class="form-group">
                                            <label for="integer">Publicacao Tipo <?php echo form_error('publicacao_tipo') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="number" class="form-control" name="publicacao_tipo" id="publicacao_tipo"  placeholder="Publicacao Tipo"  value="<?php echo 1; //$publicacao_tipo; 
                                                                                                                                                                            ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '100' />
                                        </div> 
                                    </td>

                                </tr-->
                           
                            <tr>
                                <td colspan='2'>
                                    <input type="hidden" name="publicacao_id" value="<?php echo $publicacao_id; ?>" />
                                    <button id="btnGravar" type="button" onclick="submeter()" class="btn btn-primary"><?php echo $button ?></button>
                                    <a href="<?php echo site_url('publicacao') ?>" class="btn btn-default">Voltar</a>

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