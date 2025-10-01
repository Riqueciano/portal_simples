<?php
// header ('Content-type: text/html; charset=ISO-8859-1'); 
// include '../template/begin_1_2018rn.php'; 
include '../template/begin_1_2018.php';
?>
<html>

<head>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
                // ajax_busca_secao_pelo_sistema();
                $('#secao_id').val('<?= $secao_id ?>')
            }
        });

        function ajax_busca_secao_pelo_sistema() {

            if ($('#sistema_id').val() == '') {
                return false;
            }
            // let retorno = await axios.get('<?= site_url('secao/ajax_busca_secao_pelo_sistema/?sistema_id=') ?>' + $('#sistema_id_temp').val());


            $.ajax({
                url: "<?= site_url('/Acao/ajax_busca_secao_pelo_sistema') ?>/",
                type: "get",
                dataType: "html",
                async: false,
                data: {
                    sistema_id_temp: $('#sistema_id_temp').val(),
                },
                success: function(retorno) {
                    //  alert(retorno) 
                    //  $('#div_div').html(retorno)
                    $("#secao_id option").each(function() {
                        $(this).remove();
                    });

                    var option = new Option('.:Selecione:.', '');
                    $('#secao_id').append(option);
                    if (retorno != 'null') {
                        var arqJson = JSON.parse(retorno);
                        if (arqJson.length > 0) {
                            for (var i = 0; i < arqJson.length; i++) {
                                var option = new Option(arqJson[i].secao_ds, arqJson[i].secao_id);
                                $('#secao_id').append(option);
                            }
                        }
                    }
                }
            });
        }
    </script>
</head>
<div id='div_div'></div>

<body><?php //echo $action; 
        ?>
    <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> sub-Menu (acao) <?php // echo $button  
                                                                                                                                        ?></h2>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class='col-md-12' name='' id=''>
            <div class='x_panel' id=''>
                <div class='x_content'>
                    <div style='overflow-x:auto'>

                        <table class='table'>
                            <tr>

                                <td style='width:10%'>
                                    <div class="form-group">
                                        <label for="smallint">Sistema* <?php echo form_error('secao_id') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <?php echo $sistema_nm; ?>
                                        <div style="display: none">
                                            <?php echo comboSimples('sistema_id_temp', 'seguranca.sistema', 'sistema_id', 'sistema_nm', '', $sistema_id_temp, " order by sistema_nm"); ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="smallint">Secao(menu)* <?php echo form_error('secao_id') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <?php 
                                        echo combo('secao_id', 'seguranca.secao', 'secao_id', 'secao_ds', '', $secao_id, " and sistema_id = $sistema_id_temp order by secao_ds"); 
                                        ?>
                                        <!-- <select name="secao_id" id="secao_id" class="form-control">
                                            <option>.:Selecione:.</option>
                                        </select> -->
                                    </div>
                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="character varying">Descricao* <?php echo form_error('acao_ds') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="text" class="form-control" name="acao_descricao" id="acao_ds" placeholder="Acao Ds" value="<?php echo $acao_ds; ?>" required='required' maxlength='50' />
                                    </div>
                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="character varying"> Url* <?php echo form_error('acao_url') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="text" class="form-control" name="acao_url" id="acao_url" placeholder="Acao Url" value="<?php echo $acao_url; ?>" required='required' maxlength='50' />
                                    </div>
                                </td>
                            </tr>
                            <tr style='display: none'>
                                <td>
                                    <div class="form-group">
                                        <label for="numeric">Acao St <?php echo form_error('acao_st') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="number" class="form-control" name="acao_st" id="acao_st" placeholder="Acao St" value="<?php echo $acao_st; ?>" onkeypress="mascara(this, soNumeros);" maxlength='50' />
                                    </div>
                                </td>

                            </tr>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="smallint">Ordem (Indice) <?php echo form_error('acao_indice') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="text" class="form-control" name="acao_indice" id="acao_indice" placeholder="Acao Indice" value="<?php echo $acao_indice; ?>" maxlength='50' />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'>
                                    <input type="hidden" name="acao_id" value="<?php echo $acao_id; ?>" />
                                    <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button>
                                    <a href="<?php echo site_url('acao') ?>" class="btn btn-default">Voltar</a>
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