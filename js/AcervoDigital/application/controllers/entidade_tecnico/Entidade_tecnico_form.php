<?php include '../template/begin.php'; ?>
<html>
    <head>
        <script type="text/javascript">
            $(document).ready(function () {
                //

                if ('<?= $controller ?>' == 'read') {
                    $("input").prop("disabled", true);
                    $("select").prop("disabled", true);
                    $("textarea").prop("disabled", true);
                    $("#btnGravar").hide();
                    $('#divPessoaNm').hide('fast');
                    AjaxCarregaContrato();
                    $('#lote_id').val('<?=$lote_id?>');
                } else if ('<?= $controller ?>' == 'create') {
                    $('#divPessoaId').hide('fast');
                    //tela de create
                } else if ('<?= $controller ?>' == 'update') {
                    $('#divPessoaId').hide('fast');
                    $('#divPessoaNm').show();
                    AjaxCarregaContrato();
                    //tela de update
                    var pessoa_nm = $('#pessoa_id :selected').text();
                    //alert(pessoa_nm)
                    //$('#divPessoaNm').html('<b>' + pessoa_nm + '</b>');
                    $('#pessoa_nm').val(pessoa_nm);
                    $('#lote_id').val('<?=$lote_id?>');
                   
                   //label_tecnico_cpf
                   var cpf = $('#tecnico_cpf').val();
                   $('#label_tecnico_cpf').html('<br><b>'+cpf+'</b>');
                   $('#div_tecnico_cpf').hide();
                }
            });

            function AjaxValidaCPFUnico() {
                var tecnico_cpf = $('#tecnico_cpf').val();
                var entidade_tecnico_id = $('#entidade_tecnico_id').val();
                var controller = '<?= $controller ?>';
                if (tecnico_cpf == '') {
                    return false;
                }
                $.ajax({
                    url: "<?= site_url('/Entidade_tecnico/AjaxValidaCPFUnico') ?>/",
                    type: "POST",
                    dataType: "html",
                    async: false,
                    data: {
                        tecnico_cpf: tecnico_cpf,
                        controller: controller,
                        entidade_tecnico_id: entidade_tecnico_id,
                    },
                    success: function (retorno) {
                        if (retorno == 'existe') {
                            alert('CPF "' + tecnico_cpf + '" já Cadastrado!');
                            $('#tecnico_cpf').val('')
                            return false;
                        }
                    }
                });
            }

            function AjaxValidaPreposto() {
                var entidade_id = $('#entidade_id').val();
                var entidade_nm = $('#entidade_id :selected').text();
                var entidade_tecnico_id = $('#entidade_tecnico_id').val();
                
                if (entidade_id == '') {
                    alert('Entidade em Branco!');
                    $('#flag_preposto').val('');
                    return false;
                }
                if ($('#flag_preposto').val() == '1') {
                    $.ajax({
                        url: "<?= site_url('/Entidade_tecnico/AjaxValidaPreposto') ?>/",
                        type: "POST",
                        dataType: "html",
                        async: false,
                        data: {
                            entidade_id: entidade_id,
                            flag_preposto: $('#flag_preposto').val(),
                            entidade_tecnico_id: entidade_tecnico_id,
                        },
                        success: function (retorno) {
                            if(retorno=='existe'){
                                alert('Já existe um Preposto para entidade "'+entidade_nm+'"');
                                $('#flag_preposto').val('')
                                return false;
                            }
                        }
                    });
                }
            }
            
            
            
            
            
             function AjaxCarregaContrato() {
                var entidade_id = $('#entidade_id').val();

                   if (entidade_id == '') {
                       alert('Entidade em Branco!');
                       $('#entidade_id').val('');
                       return false;
                   }

                   $.ajax({
                       url: "<?= site_url('/Lote/AjaxCarregaContrato') ?>/",
                       type: "POST",
                       dataType: "html",
                       async: false,
                       data: {
                           entidade_id: $('#entidade_id').val(),
                       },
                       success: function (retorno) {
                           //alert(retorno)
                           //$('#div').html(retorno)
                           $("#lote_id option").each(function () {
                               $(this).remove();
                           });

                           var option = new Option('.:Selecione:.', '');
                           $('#lote_id').append(option);
                           if (retorno != 'null') {
                               var arqJson = JSON.parse(retorno);
                               if (arqJson.length > 0) {
                                   for (var i = 0; i < arqJson.length; i++) {
                                       var option = new Option(arqJson[i].contrato_num, arqJson[i].lote_id);
                                       $('#lote_id').append(option);
                                   }
                               }
                           }
                       }
                });
            }
        </script>
    </head>
    <body>
        <div id='div'></div>
        <h2 style="margin-top:0px"><span id='spanAcaoForm'>Cadastro</span> - Técnico do Contrato<?php // echo $button      ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

            <table class='table'>	
                <tr> 
                    <td style="width: 30%">
                        <div class="form-group">
                            <label for="integer">Instituição* <?php echo form_error('entidade_id') ?></label>
                            <div class="item form-group"><?php echo combo('entidade_id', 'sigater_indireta.entidade', 'entidade_id', 'entidade_nm', 'AjaxCarregaContrato()', $entidade_id, ""); ?>
                            </div>
                        </div>
                    </td>
                    <td style="width: 30%">
                        <div class="form-group">
                            <label for="integer">Contrato/Lote* <?php echo form_error('lote_id') ?></label>
                            <div class="item form-group">
                                <select id='lote_id' name='lote_id' class='select2_single form-control'>
                                    <option value=''>.:Selecione:.</option>
                                </select>    
                            </div>
                        </div>
                    </td>
                    </tr>
            </table>        
            <table class='table'>        
                    <tr>
                        <td colspan="1" style="width: 50%">
                        <div class="form-group">
                            <label for="integer">Nome<?php echo form_error('pessoa_id') ?></label>
                            <div id='divPessoaNm' class="item form-group"> <input type="text" id='pessoa_nm'  name='pessoa_nm' class="form-control"></div>
                            <div id='divPessoaId' class="item form-group">
                                <?php echo combo('pessoa_id', 'dados_unico.pessoa', 'pessoa_id', 'pessoa_nm', '', $pessoa_id, ""); ?>
                            </div>
                        </div>
                    </td> 
                    <td colspan="1" style="width: 25%">
                        <div class="form-group">
                            <label for="character varying">CPF/LOGIN* <?php echo form_error('tecnico_cpf') ?></label>
                            <span id="label_tecnico_cpf"></span>
                            <div class="item form-group" id="div_tecnico_cpf">
                                <input type="text" onpaste='return false' class="form-control" name="tecnico_cpf" id="tecnico_cpf" placeholder="Cpf" value="<?php echo $tecnico_cpf; ?>" required='required'   maxlength = '25' onblur="AjaxValidaCPFUnico()" onkeypress="mascara(this, soNumeros);" />
                            </div>
                        </div>
                    </td> 
                
                    <td colspan="1" style="width: 25%">
                        <div class="form-group">
                            <label for="character varying">Preposto?* <?php echo form_error('flag_preposto') ?></label>
                            <div class="item form-group">
                                <?php 
                                
                                    switch ($flag_preposto) {
                                        case 0:
                                               $selectedNao = ' selected '; 
                                               $selectedSim = ' ';
                                            break;
                                        case 1:
                                        case 7:
                                               $selectedNao = ' '; 
                                               $selectedSim = ' selected ';
                                            break;
                                    }
                                ?>
                                <select class="form-control" style="width: 30%" onchange="AjaxValidaPreposto()" name="flag_preposto" id="flag_preposto">
                                    <option value="">.:Selecione:.</option>
                                    <option value="0" <?=$selectedNao?> >Não</option>
                                    <option value="1" <?=$selectedSim?> >SIM</option>
                                </select>
                            </div>
                        </div>
                    </td> 



                </tr>
            </table>
            <table class="table">
                <tr> 
                    <td style="width: 10%">
                        <div class="form-group">
                            <label for="character varying">DDD 1* <?php echo form_error('tecnico_ddd_1') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="tecnico_ddd_1" id="tecnico_ddd_1" placeholder="DDD" value="<?php echo $tecnico_ddd_1; ?>" required='required'   maxlength = '2' onkeypress="mascara(this, soNumeros);" />
                            </div>
                        </div>
                    </td>
                    <td style="width: 30%">
                        <div class="form-group">
                            <label for="character varying">Telefone 1* <?php echo form_error('tecnico_tel_1') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="tecnico_tel_1" id="tecnico_tel_1" placeholder="Telefone" value="<?php echo $tecnico_tel_1; ?>" required='required'   maxlength = '15' onkeypress="mascara(this, soNumeros);" />
                            </div>
                        </div>
                    </td>
                    <td style="width: 60%">
                        <div class="form-group">
                            <label for="character varying">E-mail 1* <?php echo form_error('tecnico_email') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="tecnico_email" id="tecnico_email" placeholder="Email" value="<?php echo $tecnico_email; ?>" required='required'   maxlength = '80' />
                            </div>
                        </div>
                    </td>
                </tr>
                <tr> 
                    <td>
                        <div class="form-group">
                            <label for="character varying">DDD 2 <?php echo form_error('tecnico_ddd_2') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="tecnico_ddd_2" id="tecnico_ddd_2" placeholder="DDD" value="<?php echo $tecnico_ddd_2; ?>"    maxlength = '2' onkeypress="mascara(this, soNumeros);" />
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <label for="character varying">Telefone 2 <?php echo form_error('tecnico_tel_2') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="tecnico_tel_2" id="tecnico_tel_2" placeholder="Telefone" value="<?php echo $tecnico_tel_2; ?>"    maxlength = '15' onkeypress="mascara(this, soNumeros);" />
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <label for="character varying">E-mail 2 <?php echo form_error('tecnico_email_2') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="tecnico_email_2" id="tecnico_email_2" placeholder="Email" value="<?php echo $tecnico_email_2; ?>"   maxlength = '80' />
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <table class='table'>
                <tr>
                    <th>
                        Histórico
                    </th>
                    <th>
                        Data
                    </th>
                    <th>
                        Responsável
                    </th>
                </tr>
                <?php foreach ($tecnico_log_model as $tl) { ?>
                    <tr> 
                        <td>
                            <?= $tl->log_ds ?>
                        </td> 
                        <td>
                            <?= DBToDataHora($tl->data) ?>
                        </td> 
                        <td>
                            <?= $tl->pessoa_nm ?>
                        </td> 
                    </tr>  
                <?php } ?>
                <tr> 
                    <td colspan="3">
                        <input type="hidden" name="entidade_tecnico_id" value="<?php echo $entidade_tecnico_id; ?>" /> 
                        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('entidade_tecnico') ?>" class="btn btn-default">Voltar</a>

                    </td>
                </tr>  

            </table>   
        </form>
    </body>
</html>

<?php include '../template/end.php'; ?>