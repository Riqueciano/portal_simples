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

            function addPalavra() {

                var palavra = $('#palavra').val();
                if (palavra == '') {
                    alert('Favor informar a palavra-chave antes de adicionar');
                    return false;
                }

                var newRow = $("<tr>");
                var cols = "";

                cols += '<td>';
                cols += '&nbsp;' + palavra + "<input type='hidden' name='palavra[]' value='" + palavra + "' class='palavra'>";
                cols += '</td>';
                cols += '<td>';
                cols += '       <i onclick="RemoveTableRow(this)" class="glyphicon glyphicon-remove" style="cursor:pointer;color:red;font-size:16px"></i>';
                cols += '</td>';
                newRow.append(cols);
                $("#tb_palavra_chave").append(newRow);

                $('#palavra').val('');
            }


            function aprovarObra(acao) {
                $('#acao').val(acao);
                $('#form').submit();
            }

            function publicar() {
                var aprovados = 0;
                $(".flag_aprovado").each(function (index) {
                    //alert($(this).val())
                    if ($(this).val() == '1') {
                        aprovados++;
                    }
                });
                //alert(aprovados)
                if (aprovados == 0) {
                    alert('Não é possível publicar uma obra sem palavras-chave');
                    return false;
                }
                
                $("#form").attr("action", "<?= site_url('obra/publicar_obra') ?>");
                alert('Obra publicada');
                $("#form").submit();
            }

            function reprovar() {
                if ($('#motivo_reprovacao').val() == '') {
                    alert('Favor informar o motivo da reprovação');
                    $('#tr_motivo_reprovacao').show();
                    $('#motivo_reprovacao').focus();
                    return false;
                }
                $('#tr_motivo_reprovacao').show();
                $("#form").attr("action", "<?= site_url('obra/reprovar_obra') ?>");
                alert('Obra reprovada');
                $("#form").submit();
            }

        </script>
    </head>
    <body>
        <h2 style="margin-top:0px"><span id='spanAcaoForm'>Cadastro</span> Acervo  <?php // echo $button   ?></h2>
        <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <input type='hidden' id='acao' name='acao'>
            <input type='hidden' id='obra_id' name='obra_id' value='<?=$obra_id?>'>
            <table class='table'>	
                <tr> 
                    <td colspan="4">
                        <div class="form-group">
                            <label for="character varying">Obra Título* <?php echo form_error('obra_titulo') ?></label>
                            <div class="item form-group">
                                <?php echo $obra_titulo; ?>
                            </div>
                        </div>
                    </td> 
                    
                </tr>   
                <tr>    
                    <td>
                        <div class="form-group">
                            <label for="integer">Instituicao* <?php echo form_error('instituicao_id') ?></label>
                            <div class="item form-group"><?php echo $instituicao_nm ?>
                            </div>
                        </div>
                    </td> 
                    <td>
                        <div class="form-group">
                            <label for="integer">Tipo* <?php echo form_error('obra_tipo_id') ?></label>
                            <div class="item form-group"><?php echo $obra_tipo_nm ?>
                            </div>
                        </div>
                    </td> 
                    <td>
                        <div class="form-group">
                            <label for="integer">Qtd Pag* <?php echo form_error('qtd_pag') ?></label>
                            <div class="item form-group">
                                <?php echo $qtd_pag; ?> 
                            </div>
                        </div>
                    </td> 
                    <td>
                        <div class="form-group">
                            <label for="integer">Status<?php echo form_error('status_id') ?></label>
                            <div class="item form-group"><?php echo $status_nm ?>
                            </div>
                        </div>
                    </td> 
                    <!--td>
                        <div class="form-group">
                            <label for="character varying">Obra Anexo <?php echo form_error('obra_anexo') ?></label>
                            <div class="item form-group">
                                <input type="file" class="form-control" name="obra_anexo" id="obra_anexo" placeholder="Obra Anexo" value="<?php echo $obra_anexo; ?>"    maxlength = '200' />
                            </div>
                        </div>
                    </td-->
                </tr> 	
                <tr> 
                    <td colspan="4">
                        <div class="form-group">
                            <label for="character varying">Resumo* <?php echo form_error('resumo') ?></label>
                            <div class="item form-group"> 
                                <p><?php echo $resumo; ?> </p>
                            </div>
                        </div>
                    </td> 
                </tr>
            </table> 
            <div  class="col-md-6">
                <div class="x_panel" id='div_promer'>
                    <div class="x_title" style=" background-color: ">
                        <div class="col-md-9">
                            <i class="glyphicon glyphicon-chevron-right"> </i> <b>Palavras-Chave</b>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div style='overflow-x:auto'>
                            <table class="table"  id="tb_palavra_chave">  
                                <?php foreach ($obra_palavra as $op) { ?>
                                    <tr>
                                        <td>
                                            <?= $op->palavra ?>
                                            <input type='hidden' name='palavra[]' value='<?= $op->palavra ?>' class='palavra'>
                                        </td>                                        
                                        <td style="width: 5px">
                                            <?= anchor(site_url('palavra/reprovar/?palavra_id=' . $op->palavra_id . '&obra_id=' . $obra_id . '&palavra=' . $op->palavra), ' ', "class='glyphicon glyphicon-thumbs-down' style='color:red;font-size:16px' title='Excluir' " . ' ' . 'onclick="javasciprt: return confirm(\'Tem certeza que deseja REPROVAR a Palavra-Chave?\')"') ?>
                                            <!--i onclick="aprovarReprovarPalavra('reprovar','<?= $op->palavra_id ?>')" class="glyphicon glyphicon-thumbs-down" style="cursor:pointer;color:red;font-size:16px"></i-->
                                        </td>
                                        <td  style="width: 5px">
                                            <?= anchor(site_url('palavra/aprovar/?palavra_id=' . $op->palavra_id . '&obra_id=' . $obra_id . '&palavra=' . $op->palavra), ' ', "class='glyphicon glyphicon-thumbs-up' style='color:green;font-size:16px' title='Excluir' " . ' ' . 'onclick="javasciprt: return confirm(\'Tem certeza que deseja APROVAR a Palavra-Chave?\')"') ?>
                                            <!--i onclick="aprovarReprovarPalavra('aprovar','<?= $op->palavra_id ?>')" class="glyphicon glyphicon-thumbs-up" style="cursor:pointer;color:green;font-size:16px"></i-->
                                        </td>
                                        <td  style="width: ">
                                            <?php
                                            switch ($op->flag_aprovado) {
                                                case 0:
                                                    $text = 'Aguardando/Reprovado';
                                                    $color = 'red';
                                                    break;
                                                case 1:
                                                    $text = 'Aprovado';
                                                    $color = 'green';
                                                    break;
                                                default:
                                                    break;
                                            }
                                            ?>
                                            <p style="color:<?= $color ?>"><?= $text ?></p>
                                            <input class='flag_aprovado' type="hidden" value="<?= $op->flag_aprovado ?>">
                                        </td>
                                    </tr>   
                                <?php }
                                ?>
                            </table>           
                        </div>
                    </div>
                </div>
            </div>
            <div  class="col-md-6">
                <table class="table">     
                    <tr>	
                        <th>Publicar Obra?</th>	
                    </tr>
                    <tr id="tr_motivo_reprovacao" style="display: none">
                        <td><b>Motivo da Reprovação</b><br>
                            <textarea class="form-control" id="motivo_reprovacao" name="motivo_reprovacao"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div class="form-group">
                                <label for="integer">  <?php echo form_error('status_id') ?></label>
                                <div class="item form-group" style="font-size:20px">
                                    <input type="button" value="Publicar" class="btn btn-success" onclick="publicar()"/> 
                                    <input type="button" value="Reprovar" class="btn btn-danger"  onclick="reprovar()"/> 
                                </div>
                            </div>
                        </td> 
                    </tr>
                </table>
            </div>

            <table class="table">     

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
                <?php foreach ($obra_historico as $oh) { ?>
                    <tr>
                        <td>
                            <?= $oh->acao ?>
                        </td>
                        <td>
                            <?= DBToDataHora($oh->dt_cadastro) ?>
                        </td>
                        <td>
                            <?= $oh->pessoa_nm ?>
                        </td>
                    </tr>
<?php }
?>

            </table>   
        </form>
    </body>
</html>

<?php include '../template/end.php'; ?>