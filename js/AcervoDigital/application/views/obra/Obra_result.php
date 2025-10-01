<?php include '../template/begin_semvalidacao.php'; ?>



<style>
    .div_obra_modal{
        padding: 5px 20px;font-size:15px;
        text-align: justify;
    }

    #div_autor_ds{
        padding: 5px 20px;font-size:12px;
        text-align: center;
    }

    #icon_download{  
        width: 100px
    }
    #link_obra_anexo{
        cursor:pointer
    }
    table{
        font-size:13px;
    }

</style>

<script>

$(document).ready(function() {
            $('#table_result').DataTable();
    } );


    function AjaxObraResumo(obra_id) {

        $('#modal_obra').modal('show');
        $.ajax({
            url: "<?= site_url('/obra/AjaxObraResumo') ?>/",
            type: "POST",
            dataType: "html",
            async: false,
            data: {
                obra_id: obra_id,
            },
            success: function (retorno) {

                if (retorno != 'null') {
                    var arqJson = JSON.parse(retorno);
                    $('#titulo_obra').html(arqJson.obra_titulo);
                    $('#div_autores').html('Autor(es): '+arqJson.autores);
                    $('#titulo_obra').html(arqJson.obra_titulo); 
                    $('#corpo_modal').html('<br><b>Resumo</b><br>'+arqJson.resumo);
                    $('#referencia').html('<br><br><small>Referência Bibliografica: '+arqJson.referencia+'</small>');
                    $('#div_palavras_chave').html("<BR><b style='font-size:12px'>PALAVRAS-CHAVE:</b> " + arqJson.palavras_chave);
                    if(arqJson.instituicao_nm != ''){
                        $('#instituicao_nm').html("<br><br><b style='font-size:12px'>INSTITUIÇÃO:</b> " + arqJson.instituicao_nm);
                    }
                    $('#link_obra').html("" + arqJson.link_obra + '');
                    $('#link_obra_anexo').attr('href', arqJson.link_obra_anexo)

                    if (arqJson.obra_anexo == '') {
                        $('#link_obra_anexo').hide();
                    } else {
                        $('#link_obra_anexo').show();
                    }
                }


            }
        });
    }

 
</script>
<?php
 
?>
<form action="<?=$action?>" id='form' method="post">
    <?php
    foreach ($palavra_id as $p) { ?>
        <input type="hidden" name="palavra_id[]" id="palavra_id" class="form-control" maxlength="100" value='<?=$p?>'>
    <?php } ?>
 <input type="hidden" name="autores" id="autores" class="form-control" maxlength="100"  value='<?=$autores?>'>
 <input type="hidden" name="acao_busca" id="acao_busca" class="form-control" maxlength="100"  value='<?=$acao_busca?>'>
<div  class="col-md-12"  >
    <div class="x_panel" id=''>
        <div class="col-md-6"><a href="<?= site_url('obra/obra_buscador') ?>" style='color:green'><b style="cursor:pointer;font-size:20px" ><i class="glyphicon glyphicon-triangle-left"></i>NOVA BUSCA</b></a><br> Palavras-chave: 
            <?php foreach ($palavra as $p) { ?>     
                <span class="badge badge-success" style="background-color:green"><?= $p->palavra ?></span>
            <?php }
            ?>            
            | Autor:  <?=$autores;?>            
        </div>
        <div class="col-md-6">
                <b style="cursor:" > </b>
                <br> Ano: <select class="" id='ano' name='ano' onchange="submit()">
                                <option value=''>Todos</option>
                                <?php
                                    $anoTemp = (int)date('Y');
                                    for($i = $anoTemp;$i > $anoTemp-10;$i--){
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                            </select>
                            <script>$('#ano').val('<?=$ano?>')</script>            
                <!--br> Instituição:  <?php echo comboSimples('obra_tipo_id', 'acervo.obra_tipo', 'obra_tipo_id', 'obra_tipo_nm', '', null, " order by obra_tipo_nm"); ?>     -->   
        </div>
    </div>
</div>


<table class="table" id='table_result'>
    <tr>
        <th style="width: 2%"> - </th>
        <th> Título</th>
        <th> Autor(es)</th>
        <th> Instituição</th> 
        <th> Ano</th> 
    </tr>
    <?php foreach ($obra as $o) { ?>
        <tr>
            <td>
                <span style='cursor:pointer' class='glyphicon glyphicon-search' title='Consultar' onclick='AjaxObraResumo("<?= $o->obra_id ?>")'></span>
                <?php //echo anchor(site_url('obra/read_result/'.$o->obra_id),' ',"class='glyphicon glyphicon-search' title='Consultar' target='_blank'");  ?>
            </td>
            <td>
                <?= rupper($o->obra_titulo) ?>
            </td>
            <td>
                 <?php 
                            $autores  = $o->pessoa_nm;
                            $autores .= empty($o->coautor1)?'': ', '.$o->coautor1;
                            $autores .= empty($o->coautor2)?'': ', '.$o->coautor2;
                            $autores .= empty($o->coautor3)?'': ', '.$o->coautor3;
                            $autores .= empty($o->coautor4)?'': ', '.$o->coautor4;
                            echo rupper($autores);  
                 ?>
            </td>
            <td>
                <?= rupper($o->instituicao_autor) ?>
            </td>
            <td>
                <?= $o->ano ?>
            </td>
        </tr>
    <?php }
    ?>
    <div id="modal_obra" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
        <div class="modal-dialog" style="width:60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                    <h4 class="modal-title" id="myModalLabel"><span id='titulo_obra'></span> </h4>

                </div>
                <div class="modal-body">
                    <div id="div_autores" style="" class="div_obra_modal"></div>                    
                    <div id="corpo_modal" style="" class="div_obra_modal"></div>                    
                    <div id="referencia" style="" class=""></div>                    
                    <span id="div_palavras_chave" class="div_obra_modal"></span>
                    <span id="instituicao_nm" class="div_obra_modal"></span>
                    <br>
                    <br>
                    <i class="glyphicon glyphicon-link"></i> <span id="link_obra"></span>
                    <!--button onclick="controC('#link_obra')">Copiar</button-->  

                    <br><br>  
                    <a id='link_obra_anexo' download href='#'><input type='button' class='btn btn-success' id='icon_download' value="Baixar"></a>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Fechar</button> 
                </div>
            </div>
        </div>
    </div>
</table>
    </form>
<?php include '../template/end.php'; ?>