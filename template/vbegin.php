<?php

$nmServer = '_portal';
$sistema_id = empty($_GET['sistema']) ? $_SESSION['sistema'] : $_GET['sistema'];
/*
      echo '<br>';
      echo 'get->'.$_GET['sistema'];
      echo '<br>';
      echo 'session->'.$_SESSION['sistema'];
      echo '<br>'; 
     */
//caso não esteja logado, redireciona para o Login
if (!isset($_SESSION['pessoa_id'])) {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . "/" . $nmServer . '/Intranet/publicacao/intranet');
}

//echo '<pre>'; print_r($_SESSION['Sistemas'][$_SESSION['sistema']]); echo '</pre>';
?>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/vue2.6/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/4.0.11/vue-router.cjs.js" integrity="sha512-5Pt4hiQAots3nvh1UjE/gChzPuYHOV009I+iC0j5nLzDYxZ7aEMVcpzF+x/VWv2D9g6/fx75yieuOFz2OcSrjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--sem cache-->
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />


    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/jquery/jquery-2.1.1.js"></script>

    <title>SDR | Secretaria de Desenvolvimento Rural</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">




    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/bootstrap_2.min.js"></script>



    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer  ?>/template/production/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/custom.css" rel="stylesheet">
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/icheck/flat/green.css" rel="stylesheet">


    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/jquery.min.js"></script>

    <script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/wizard/jquery.smartWizard.js"></script>
    <!-- Bootstrap core CSS -->

    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/animate.min.css" rel="stylesheet">
 
    <!-- editor -->
    <!--link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet"-->
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/font-awesome.css" rel="stylesheet">


    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/editor/index.css" rel="stylesheet">
    <!-- select2 -->
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/select/select2.min.css" rel="stylesheet">
    <!-- switchery -->
    <link rel="stylesheet" href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/switchery/switchery.min.css" />

    <!--
            <script type="text/javascript" language="javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/js/jexcel-master/dist/jexcel.js"></script>
            <link rel="stylesheet" href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/js/jexcel-master/dist/jexcel.css" />
            -->
    <link rel="stylesheet" href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/switchery/switchery.min.css" />
    <script type="text/javascript" language="javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/fwJS.js"></script>
    <!--
            <script src="https://bossanova.uk/jsuites/v2/jsuites.js"></script>
            <link rel="stylesheet" href="https://bossanova.uk/jsuites/v2/jsuites.css" type="text/css" />
-->
    <!--[if lt IE 9]>
                <script src="../assets/js/ie8-responsive-file-warning.js"></script>
                <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
                  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                <![endif]-->

</head>
<style>
    #content {
        border: 0px solid #F00;

        background-color: #2C4257;

        moz-border-radius: 8px;
        -webkit-border-radius: 8px;
        -goog-ms-border-radius: 8px;
        border-radius: 8px;
    }

    th {
        /*background-color: #2C4257;*/
        background-color: #3F5367;
        color: white;
        font-size: 12px
    }

    td {
        /*background-color: #2C4257;*/
        font-size: 12px
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }


    /* Define the hover highlight color for the table row */
    .table tr:hover {
        background-color: #DDF4EF;
        border: #68CFB8 2px solid;
    }
</style>

<script>
    $(document).ready(function() {
        $("form").submit(function() {
            //alert('em desenvolvimento');
            //$('#btnGravar').attr('disabled', true); 
        });
    });

    window.setInterval(AjaxverificaSession, 10000);

    function AjaxverificaSession() {
        $.ajax({
            url: "https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/verifica_session/verifica_session.php",
            type: "POST",
            dataType: "html",
            async: false,
            data: {

            },
            success: function(retorno) {
                //alert(retorno)
                if (retorno == 'session_vazia') {
                    alert('Sessão encerrada por falta de uso, favor efetuar o login novamente');
                    window.open('https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>', '_self');
                }
            }
        });
    }

    function abreTransicao(pagina) {
        $('#form_begin').attr("action", 'https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/Intranet/transicao');
        $('#pagina_begin').val(pagina);
        $('#form_begin').submit();
    }
</script>

<form id="form_begin" method="post" action="" style="display:none">
    <input type="hidden" value="" id="pagina_begin" name="pagina_begin">
</form>

<body class="nav-md" style='width:100%' id='idBodyTotal'>
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;"> <br>
                        <a href="#" class="site_title"><img src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/Imagens/Topo/bg_logo.png" class="img-thumbnail"></a>

                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile">

                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu"><br>
                        <div class="menu_section">
                            <!-- <h3 style="cursor:pointer" onclick='window.open("https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer; ?>/Intranet/sistema", "_self")'><i class="fa fa-home"></i>VOLTAR</h3><br> -->
                            <ul class="nav side-menu">

                                <?php
                                //echo $_SESSION['sistema'];//exit;
                                $ci = @get_instance();
                                //pega seÃ§Ã£o



                                $sql = "select 
                                      distinct s.*
                               from seguranca.tipo_usuario tu
                                    inner join seguranca.tipo_usuario_acao tua
                                            on tua.tipo_usuario_id = tu.tipo_usuario_id
                                    inner join seguranca.acao a	
                                            on a.acao_id = tua.acao_id 

                                    inner join seguranca.usuario_tipo_usuario utu
                                            on utu.tipo_usuario_id = tu.tipo_usuario_id
                                    inner join seguranca.secao s
                                            on s.secao_id = a.secao_id


                                    where s.secao_st = 0 and s.sistema_id = " . (int) $sistema_id . " and utu.pessoa_id = " . (int) $_SESSION['pessoa_id'] . " 
                                order by s.secao_indice        
                             ";
                                //echo_pre($sql);exit;

                                $_SESSION['sistema'] = empty($_GET['sistema']) ? $_SESSION['sistema'] : $_GET['sistema'];
                                //pega secao
                                $secao = @$ci->db->query($sql)->result();
                                //echo '<pre>'.$sql.'</pre>';//exit;
                                ?>


                                <li><a style="cursor:pointer" href='https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer; ?>/Intranet/sistema'><i class="fa fa-home"></i> <b>VOLTAR</b> </a></li>

                                <?php foreach ($secao as $s) { ?>
                                    <!-- Dropdown-->
                                    <li><a><i class="<?= rupper($s->class_icon_bootstrap) ?>"></i> <?= rupper($s->secao_ds) ?> <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">

                                            <?php
                                            $sql = "select 
                                               a.*,s.* from seguranca.tipo_usuario tu
                                    inner join seguranca.tipo_usuario_acao tua
                                            on tua.tipo_usuario_id = tu.tipo_usuario_id
                                    inner join seguranca.acao a	
                                            on a.acao_id = tua.acao_id 
                                    inner join seguranca.usuario_tipo_usuario utu
                                            on utu.tipo_usuario_id = tu.tipo_usuario_id
                                    inner join seguranca.sistema s
					    on s.sistema_id = tu.sistema_id        
                                    where a.acao_st = 0 and a.secao_id =" . $s->secao_id . " and s.sistema_id = " . (int) $sistema_id . " and utu.pessoa_id = " . (int) $_SESSION['pessoa_id'] . " 
                                        order by a.acao_indice ";
                                            //echo '<pre>'.$sql.'</pre>';
                                            $acao = @$ci->db->query($sql)->result();
                                            foreach ($acao as $a) {
                                                $urlTemp = explode('/', $a->sistema_url);
                                                $url = $urlTemp[1];
                                            ?>
                                                <li><a href="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer . '/' . $url . '/' . $a->acao_url ?>"><?= (($a->acao_ds)) ?></a></li>
                                                <!--li><a onclick="abreTransicao('https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer . '/' . $url . '/' . $a->acao_url ?>')"><?= (($a->acao_ds)) ?></a></li-->
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php }
                                ?>

                            </ul>
                        </div>


                    </div>

                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav" id="topNavgation">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="glyphicon glyphicon-tasks"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">

                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <?php $nome = explode(' ', $_SESSION['pessoa_nm']); ?>
                                    Bem vindo(a) <small> <b><?= ucfirst(rlower($nome[0])) ?> (<? //= trim($_SESSION['Sistemas'][$_SESSION['sistema']]) 
                                                                                                ?>)</b></small> ao <b>"<?php echo $title = rupper(@nomeSistema($sistema_id)) ?>"</b>

                                    <span class="glyphicon glyphicon-user"></span>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <!--ul class="dropdown-menu dropdown-usermenu pull-right"-->
                                <ul class="dropdown-menu dropdown-usermenu pull-right" style='width:65%'>
                                    <table class="table">
                                        <tr>
                                            <td style='width:20%'><b>Usuário</b></td>
                                            <td><?= ucfirst(rlower($nome[0])) ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Modulo</b></td>
                                            <td><?= @nomeSistema($sistema_id) ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Lotação</b></td>
                                            <td><?= $_SESSION['est_organizacional_sigla'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Perfil</b></td>
                                            <td><?= $_SESSION['Sistemas'][$_SESSION['sistema']] ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>SETAF</b></td>
                                            <td><?= empty($_SESSION['setaf_nm']) ? '-' : $_SESSION['setaf_nm'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>ATER-Contrato</b></td>
                                            <td><?= empty($_SESSION['ater_contrato_num']) ? '-' : $_SESSION['ater_contrato_num']  ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <a href="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/Intranet/usuario" class="btn btn-danger" style='width:100%'>
                                                    <b><i class="glyphicon glyphicon-off"></i> Sair</b>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </ul>
                            </li>


                        </ul>

                    </nav>

                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main" id='main'>
                <!-- top tiles -->
                <div class="row tile_count" id="divTitleCount">
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                        <span class="count_top"></span>
                    </div>
                </div>
                <!-- /top tiles -->

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!--div class="dashboard_graph"-->

                        <!--div class="row x_title">
                                    <h3><?php echo $title = @nomeSistema($sistema_id) ?></h3>
                                </div-->
                        <?php @$ci->db->close() ?>
                        <div class="col-md-12 col-sm-12 col-xs-12" id='content2' style="">




                        </div>
                          <script>

                          </script>                          


                    </div>
                </div>
            </div>
            <footer id="rodape">
                <div class="">
                    <p class="pull-right"><b>SDR - Secretaria de Desenvolvimento Rural</b> |
                        <span class="lead"> <i class="glyphicon glyphicon-leaf green"></i></span><br>
                        <b title="APG - Acessoria de Planejamento e Gestão" data-toggle="tooltip" data-placement="bottom" style="cursor:pointer">
                            © Copyright 2015 - <?= date('Y') ?> | APG</b>
                    </p>
                </div>
                <div class="clearfix"></div>
            </footer>
        </div>



    </div>
    <!-- /page content -->

    <!-- footer content -->

    <!-- /footer content -->
    </div>
    </div>

    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/icheck/icheck.min.js"></script>

    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/custom.js"></script>
    <!-- form validation -->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/validator/validator.js"></script>



    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <!--script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/s/progressbar/bootstrap-progressbar.min.js"></script-->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/icheck/icheck.min.js"></script>
    <!-- tags -->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/tags/jquery.tagsinput.min.js"></script>
    <!-- switchery -->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/switchery/switchery.min.js"></script>
    <!-- daterangepicker -->
    <script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/moment.min2.js"></script>
    <script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/datepicker/daterangepicker.js"></script>
    <!-- richtext editor -->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/editor/bootstrap-wysiwyg.js"></script>
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/editor/external/jquery.hotkeys.js"></script>
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/editor/external/google-code-prettify/prettify.js"></script>
    <!-- select2 -->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/select/select2.full.js"></script>
    <!-- form validation -->
    <script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/parsley/parsley.min.js"></script>
    <!-- textarea resize -->
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/textarea/autosize.min.js"></script>
    <script>
        autosize($('.resizable_textarea'));
    </script>
    <!-- Autocomplete -->
    <script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/autocomplete/countries.js"></script>
    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/autocomplete/jquery.autocomplete.js"></script>


    <!-- graficos - echart-->
    <script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/echart/echarts-all.js"></script>
    <script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/echart/green.js"></script>


    <script>
        // initialize the validator function
        validator.message['date'] = 'not a real date';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
            .on('blur', 'input[required], input.optional, select.required', validator.checkField)
            .on('change', 'select.required', validator.checkField)
            .on('keypress', 'input[required][pattern]', validator.keypress);

        $('.multi.required')
            .on('keyup blur', 'input', function() {
                validator.checkField.apply($(this).siblings().last()[0]);
            });

        // bind the validation to the form submit event
        //$('#send').click('submit');//.prop('disabled', true);

        $('form').submit(function(e) {
            e.preventDefault();
            var submit = true;
            // evaluate the form using generic validaing
            if (!validator.checkAll($(this))) {
                submit = false;
            }

            if (submit)
                this.submit();
            return false;
        });

        /* FOR DEMO ONLY */
        $('#vfields').change(function() {
            $('form').toggleClass('mode2');
        }).prop('checked', false);

        $('#alerts').change(function() {
            validator.defaults.alerts = (this.checked) ? false : true;
            if (this.checked)
                $('form .alert').remove();
        }).prop('checked', false);



        $(document).ready(function() {
            $(".select2_single").select2({
                //placeholder: ".:Selecione:.",
                allowClear: true
            });
            $(".select2_group").select2({});
            $(".select2_multiple").select2({
                maximumSelectionLength: 4,
                placeholder: "With Max Selection limit 4",
                allowClear: true
            });
        });
    </script>


</body>
<script>
    //google Analytics
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-89030392-1', 'auto');
    ga('send', 'pageview');
</script>



</html>