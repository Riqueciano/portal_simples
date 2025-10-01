


<?php include '../template/begin_semvalidacao.php'; ?> 
<style>
    /* style the elements with CSS */
    #pleaserotate-graphic{
        fill: #fff;
        width: 250px
    }

    #pleaserotate-backdrop {
        color: #fff;
        background-color: #000;
    }
</style>


<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/js/pleaserotate.min.js"></script>


<style>
    #linha{
        backgroud-color:red
    }

    b{
        font-size:12px
    }

</style>

<script>
    function exibe_oculta_busca(acao) {
        $('#acao_busca').val(acao);
        if (acao == 'palavra') {
            $('#div_palavra_id').show();
            $('#div_pessoa_id').hide();
        } else {
            $('#div_palavra_id').hide();
            $('#div_pessoa_id').show();

        }
    }

    function submeter() {
        var palavra_id = $('#palavra_id').val();
        var autores = $('#autores').val();
        var instituicao = $('#instituicao').val();


        if ((palavra_id == null || palavra_id == 'null' || palavra_id == '') && autores == '' && instituicao == '') {
            alert('Favor selecionar algum filtro');
            return false;
        }

        $('#form').submit();
    }

</script>
<div  style='background-image: "<?= 'https://' . $_SERVER['HTTP_HOST'] . "/_portal/" ?>Imagens/rural_imagem.jpg"'>
    <form id='form' action='<?= $action ?>' method="post">
        <input type="hidden" value="" id="acao_busca" name="acao_busca">
        <!--div class="row" id='linha'>
            <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12"  align="center">
                <h1><i class='glyphicon glyphicon-leaf green'  ></i> <?= utf8_decode('ColeÃ§Ã£o da Agricultura Familiar') ?></h1>
            </div>
        </div-->

        <!--div class="row" id='linha'>
            <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12"  align="center">
                <img src="<?= 'https://' . $_SERVER['HTTP_HOST'] . "/_portal/" ?>Imagens/rural_imagem.jpg" style="width: 38%">
            </div>
        </div-->
        <br>
        <div class="row">
            <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12"  align="center" style="width:1200px">
                <div class="x_panel" id='' style='width:90%'>   
                    <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12"  align="center">
                        <img src="<?= 'https://' . $_SERVER['HTTP_HOST'] . "/_portal/" ?>Imagens/rural_imagem.jpg" style="width: 102%">
                    </div>
                    <div class="x_content">
                        <div    align="center">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <!--h2><i class="fa fa-bars"></i> Acervo Digital </h2-->
                                        <ul class="nav navbar-right panel_toolbox">
                                            <!--li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#">Settings 1</a>
                                                    </li>
                                                    <li><a href="#">Settings 2</a>
                                                    </li>
                                                </ul>
                                            </li
                                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                                            </li-->
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Assunto</a>
                                                </li>
                                                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Autor(es)</a>
                                                </li>
                                                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Instituição</a>
                                                </li>
                                            </ul>
                                            <div id="myTabContent" class="tab-content">
                                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                                    <?php echo combo('palavra_id[]', 'acervo.palavra', 'palavra_id', 'palavra', '', null, " and flag_aprovado=1 order by palavra", 'multiple'); ?>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                                    <input type="text" name="autores" id="autores" class="form-control" maxlength="100" >
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                                    <input type="text" name="instituicao" id="instituicao" class="form-control" maxlength="100" >
                                                </div>
                                            </div>
                                        </div><br>
                                        <input type="button" class="btn btn-primary" value="Pesquisar"  onclick="submeter()"  style="width: 70%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <br>
        <div class="row">
            <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12"  align="center">

                <!--input type="button" class="btn btn-success" value="Estou com Sorte" style="width: 15%"-->
            </div>
        </div>
    </form>
</div>
<!--table class="table"> 
<?php
/* $l = 0;
  foreach ($palavra as $p) {
  //if($l%3==0 or $l==0){
  echo "<tr>";
  //}
  echo "       <td><b> $p->palavra  </b></td>";
  //if($l%3==0 or $l==0){
  echo "</tr>";
  //}
  $l++;
  } */
?>
 
</table-->

<?php include '../template/end.php'; ?>