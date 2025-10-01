<?php
include '../template/begin_1_2018.php';


$perfil = $_SESSION['Sistemas'][$_SESSION['sistema']];
?>
<html>
    <head>
        <script type="text/javascript">
            $(document).ready(function () {
                if ('<?= $controller ?>' == 'read') {
                    $("input").prop("disabled", true);
                    $("select").prop("disabled", true);
                    $("textarea").prop("disabled", true);
                    $("#div_add_palavra_chave").hide();
                    $(".td_excluir_palavra").hide();
                    $("#td_anexo").hide();
                    $("#btnGravar").hide();
                } else if ('<?= $controller ?>' == 'create') {
                    //tela de create
                } else if ('<?= $controller ?>' == 'update') {
                    //tela de update
                    alert('IMPORTANTE: Após a edição, esta Obra será avaliada novamente e está sujeita a reprovação.');
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


            function exibeModalAutor() {
                $('#modal_autor').modal('show');
            }

            function ajaxCadastroSimplesAutor() {

                if ($('#email').val() == '') {
                    alert('Favor informar o e-mail do autor');
                    $('#email').focus();
                    return false;
                }
                if ($('#pessoa_nm').val() == '') {
                    alert('Favor informar o Nome do autor');
                    $('#pessoa_nm').focus();
                    return false;
                }

                $.ajax({
                    url: "<?= site_url('/usuario/ajax_create_action') ?>/",
                    type: "POST",
                    dataType: "html",
                    async: false,
                    data: {
                        email: $('#email').val(),
                        pessoa_nm: $('#pessoa_nm').val(),
                    },
                    success: function (retorno) {
                        //alert(retorno)
                        if (retorno == 'ja_cadastrado') {
                            alert('Usuario já cadastrado');
                            $('#email').val('')
                            return false;
                        }

                        alert('Cadastro realizado!\nE-mail solicitando a autorização para publicação da obra enviado ao Autor');
                        $("#pessoa_id option").each(function () {
                            $(this).remove();
                        });
                        var option = new Option('.:Selecione:.', '');
                        $('#pessoa_id').append(option);

                        if (retorno != 'null') {
                            var arqJson = JSON.parse(retorno);
                            if (arqJson.length > 0) {
                                for (var i = 0; i < arqJson.length; i++) {
                                    var option = new Option(arqJson[i].pessoa_nm, arqJson[i].pessoa_id);
                                    $('#pessoa_id').append(option);
                                }
                            }
                        }
                        $('#modal_autor').modal('hide');
                    }

                });
            }

            function submeter() {
                var obra_tipo_id = $('#obra_tipo_id').val();
                if (obra_tipo_id == '') {
                    alert('Tipo da Obra em branco');
                    $('#obra_tipo_id').focus();
                    return false;
                }
                var obra_titulo = $('#obra_titulo').val();
                if (obra_titulo == '') {
                    alert('Tipo da Obra em branco');
                    $('#obra_titulo').focus();
                    return false;
                }
                if ($('#pessoa_id').val() == '') {
                    alert('Favor informar o Autor');
                    $('#pessoa_id').focus();
                    return false;
                }

                if ($('#obra_anexo').val() == '') {
                    alert('Favor anexar o arquivo');
                    $('#obra_anexo').focus();
                    return false;
                }
                if ($('#ano').val() == '') {
                    alert('Ano/Publicação em branco');
                    $('#ano').focus();
                    return false;
                }
                $('#form').submit();
            }


        </script>
    </head>
    <body>
        <h2 style="margin-top:0px"><span id='spanAcaoForm'></span> Cadastro de Publicações <?php // echo $button            ?></h2>
        <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class="col-md-12" name="divitem" id="divitem">
                <div class="x_panel" id='div_promer'>
                    <div class="x_title" style=" background-color: ">
                        <div class="col-md-9">
                            <i class="glyphicon glyphicon-book"> </i> <b>Obra</b>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div style='overflow-x:auto'>
                            <table class='table'>	
                                <tr> 
                                    <td colspan="" style="width: 70%">
                                        <div class="form-group">
                                            <label for="character varying">TÍTULO DA OBRA* <?php echo form_error('obra_titulo') ?></label>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" name="obra_titulo" id="obra_titulo" placeholder="Obra Titulo" value="<?php echo $obra_titulo; ?>" required='required'   maxlength = '300' />
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label for="integer">TIPO* <?php echo form_error('obra_tipo_id') ?></label>
                                            <div class="item form-group">
                                                <?php echo comboSimples('obra_tipo_id', 'acervo.obra_tipo', 'obra_tipo_id', 'obra_tipo_nm', '', $obra_tipo_id, " order by obra_tipo_nm"); ?>
                                            </div>
                                        </div>
                                    </td> 
                                    <td>
                                        <div class="form-group">
                                            <label for="integer">ANO/PUBLICAÇÃO* <?php echo form_error('obra_tipo_id') ?></label>
                                            <div class="item form-group">
                                                <select class="form-control" id='ano' name='ano'>
                                                    <option value=''>.:Selecione:.</option>
                                                    <?php
                                                        $ano = (int)date('Y');
                                                        for($i = $ano;$i > $ano-20;$i--){
                                                            echo "<option value='$i'>$i</option>";
                                                        }
                                                    ?>
                                                </select>
                                                <script>$('#ano').val('<?=$ano?>')</script>
                                            </div>
                                        </div>
                                    </td> 
                                    <!--td>
                                        <div class="form-group">
                                            <label for="integer">Qtd Pag* <?php echo form_error('qtd_pag') ?></label>
                                            <div class="item form-group">
                                                <input type="number" class="form-control" name="qtd_pag" id="qtd_pag" placeholder="Qtd Pag" value="<?php echo $qtd_pag; ?>" required='required'  onkeypress="mascara(this, soNumeros);"   maxlength = '300' />
                                            </div>
                                        </div>
                                    </td-->
                                </tr> 
                            </table> 
                            <table class="table">

                                <!--tr>
                                    <td colspan='4'>
                                        <b>Informações do(s) Autor(es)</b><br>
                                        <textarea id='autor_ds' name='autor_ds' class='form-control'><?= $autor_ds ?></textarea>                     
                                    </td>
                                </tr--> 
                                <tr> 
                                    <td colspan="4">
                                        <div class="form-group">
                                            <label for="character varying">REFERÊNCIA BIBLIOGRÁFICA * <?php echo form_error('resumo') ?></label>
                                            <div class="item form-group"> 
                                                <textarea class="form-control" name="referencia" id="referencia" maxlength = '2000' rows="2"><?php echo $resumo; ?></textarea>
                                            </div>
                                        </div>
                                    </td> 
                                </tr>
                                <tr> 
                                    <td colspan="4">
                                        <div class="form-group">
                                            <label for="character varying">RESUMO (até 2 mil caracteres)* <?php echo form_error('resumo') ?></label>
                                            <div class="item form-group"> 
                                                <textarea class="form-control" name="resumo" id="resumo" maxlength = '2000' rows="5"><?php echo $resumo; ?></textarea>
                                            </div>
                                        </div>
                                    </td> 
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="col-md-12" name="divitem" id="divitem">
                <div class="x_panel" id='div_promer'>
                    <div class="x_title" style=" background-color: ">
                        <div class="col-md-9">
                            <i class="glyphicon glyphicon-chevron-right"> </i> <b>AUTOR(ES)</b>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div style='overflow-x:auto'>
                            <table class="table">
                                <tr>
                                    <td colspan="2">
                                        <b>Autor principal*</b><br>
                                        <?php
                                        if ($perfil == 'Administrador' or $perfil == 'Moderador' or $perfil == 'Gestor') {
                                            echo "<div style='width:99%'> 
                                                                " . combo('pessoa_id', 'dados_unico.pessoa', 'pessoa_id', 'pessoa_nm', '', $pessoa_id, " and pessoa_st = 0 and flag_usuario_acervo_digital=1 order by pessoa_nm");
                                            echo "</div>"
                                            ?>  
                                        <?php } else {
                                            ?>
                                            <input type="hidden" id='pessoa_id' name='pessoa_id' value='<?= $_SESSION['pessoa_id']; ?>'>
                                            <?php
                                            echo $_SESSION['pessoa_nm'];
                                        }
                                        ?>
                                        <?php if ($perfil == 'Administrador' || $perfil == 'Moderador' || $perfil == 'Gestor') { ?>
                                        <td colspan="1">
                                            <br><input type="button" class="btn btn-warning"  onclick="exibeModalAutor()" value="Novo Autor" style="width:100px">
                                        </td>
                                        <td colspan="2">
                                        </td>
                                    <?php } ?>
                                    </td>
                                </tr>
                                <tr> 
                                    <td style="width: 50%">
                                        <div style="width: 99%">
                                            Co-autor 1:<input type="text" id="coautor1" name="coautor1"  maxlength="40" class="form-control" value='<?= $coautor1 ?>'>
                                        </div>    
                                    </td>
                                    <td style="width: 50%">
                                        <div style="width: 99%">
                                            Co-autor 2:<input type="text" id="coautor2" name="coautor2"  maxlength="40" class="form-control" value='<?= $coautor2 ?>'>
                                        </div>    
                                    </td>
                                </tr> 
                                <tr> 
                                    <td style="width: 50%">
                                        <div style="width: 99%">
                                            Co-autor 3:<input type="text" id="coautor3" name="coautor3"  maxlength="40" class="form-control" value='<?= $coautor3 ?>'>
                                        </div>    
                                    </td>
                                    <td style="width: 50%">
                                        <div style="width: 99%">
                                            Co-autor 4:<input type="text" id="coautor4" name="coautor4"  maxlength="40" class="form-control" value='<?= $coautor4 ?>'>
                                        </div>    
                                    </td>
                                </tr> 
                            </table>        
                        </div>
                    </div>
                </div>
            </div>


            <div  class="col-md-6" id="div_add_palavra_chave">
                <div class="x_panel" id=''>
                    <div class="x_title" style=" background-color: ">
                        <div class="col-md-9">
                            <i class="glyphicon glyphicon-chevron-right"> </i> <b>ADICIONAR PALAVRAS-CHAVE (Assunto)</b>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div style='overflow-x:auto'>
                            <table class="table">
                                <tr> 
                                    <td style="width: 60%">
                                        <div style="width: 99%">
                                            <input type="text" id="palavra"  maxlength="40" class="form-control">
                                        </div>    
                                    </td>
                                    <td  style="width: 40%">
                                        <input type="button" class="btn btn-success" value="Adicionar" onclick="addPalavra()" style="width: 98%">
                                    </td>
                                </tr> 
                            </table>           
                        </div>
                    </div>
                </div>
            </div>
            <div  class="col-md-6">
                <div class="x_panel" id=''>
                    <div class="x_title" style=" background-color: ">
                        <div class="col-md-9">
                            <i class="glyphicon glyphicon-tags"> </i>  <b>PALAVRAS-CHAVE (Assunto)</b>
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
                                        <td class="td_excluir_palavra">
                                            <i onclick="RemoveTableRow(this)" class="glyphicon glyphicon-remove" style="cursor:pointer;color:red;font-size:16px"></i>
                                        </td>
                                    </tr>   
                                <?php }
                                ?>
                            </table>           
                        </div>
                    </div>
                </div>
            </div>
            <div  class="col-md-12" name="divitem" id="divitem">
                <div class="x_panel" id='div_promer'>
                    <div class="x_title" style=" background-color: ">
                        <div class="col-md-9">
                            <i class="glyphicon glyphicon-paperclip"> </i> <b>ANEXO*</b>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div style='overflow-x:auto'>
                            <table>
                                <tr>    
                                    <td id="td_anexo">
                                        <div class="form-group"> 
                                            <div class="item form-group">
                                                <input type="file" class="form-control" id='obra_anexo' name='obra_anexo'>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>   
                        </div>
                    </div>
                </div>
            </div>
            <table class="table">
                <!--tr> 
                    <td>
                        <div class="form-group">
                            <label for="character varying">Anexo <?php echo form_error('obra_anexo') ?></label>
                            <div class="item form-group">
                                <input type="text" class="form-control" name="obra_anexo" id="obra_anexo" placeholder="Obra Anexo" value="<?php echo $obra_anexo; ?>"    maxlength = '200' />
                            </div>
                        </div>
                    </td> 
                </tr-->  
                <tr> 
                    <td>
                        <input type="hidden" name="obra_id" value="<?php echo $obra_id; ?>" /> 
                        <button id="btnGravar" type="button" onclick="submeter()" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('obra') ?>" class="btn btn-default">Voltar</a>

                        <?php
                        if ($controller == 'read') {
                            echo anchor(site_url('obra/autor_aprova/' . $obra_id), ' ', "data-toggle='tooltip' class='glyphicon glyphicon-thumbs-up' style='color:green;font-size:30px' title='Aprovar' " . ' ' . 'onclick="javasciprt: return confirm(\'Aprovar obra?\')"');
                            echo ' | ';
                            echo anchor(site_url('obra/autor_reprova/' . $obra_id), ' ', "data-toggle='tooltip'class='glyphicon glyphicon-thumbs-down' style='color:red;font-size:30px' title='Reprovar' " . ' ' . 'onclick="javasciprt: return confirm(\'Reprovar obra?\')"');
                        }
                        ?>
                    </td>
                </tr>  
            </table>
            <div id="modal_autor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                <div class="modal-dialog" style="width:60%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                            <h4 class="modal-title" id="myModalLabel"><span id='titulo_obra'></span> </h4>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tr>
                                    <th>Nome*</th>
                                    <th>E-mail*</th>
                                </tr>
                                <tr>
                                    <td><input type="" class="form-control" id="pessoa_nm" placeholder="Nome do autor"></td>
                                    <td><input type="email" class="form-control" id="email"  placeholder="exemplo@exemplo.com"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-md-10">
                                    <button type="button" class="btn btn-success" onclick="ajaxCadastroSimplesAutor()">Cadastrar</button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>

<?php include '../template/end.php'; ?>