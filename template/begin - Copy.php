<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

//echo 'ã';
$nmServer = '_portal';
$sistema_id = empty($_GET['sistema']) ? $_SESSION['sistema'] : $_GET['sistema'];
/*
  echo '<br>';
  echo 'get->'.$_GET['sistema'];
  echo '<br>';
  echo 'session->'.$_SESSION['sistema'];
  echo '<br>'; */

//caso n?o esteja logado, redireciona para o Login
if (!isset($_SESSION['pessoa_id'])) {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . "/" . $nmServer . '/Intranet/publicacao/intranet');
}

//echo '<pre>'; print_r($_SESSION['Sistemas'][$_SESSION['sistema']]); echo '</pre>';
?>
<html lang="en">

<head>
    <script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/vue2.6/vue.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!--sem cache-->
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">


    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/jquery/jquery-2.1.1.js"></script>

    <title>SDR | Secretaria de Desenvolvimento Rural</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">




    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/bootstrap_2.min.js"></script>



    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/bootstrap.min.css" rel="stylesheet">

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
    <script type="text/javascript" language="javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/fwJS.js"></script>

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
    @font-face {
  font-family: 'FontAwesome';
  src: url('https://netdna.bootstrapcdn.com/font-awesome/3.0.2/font/fontawesome-webfont.eot?v=3.0.2');
  src: url('https://netdna.bootstrapcdn.com/font-awesome/3.0.2/font/fontawesome-webfont.eot?#iefix&v=3.0.2') format('embedded-opentype'),
       url('https://netdna.bootstrapcdn.com/font-awesome/3.0.2/font/fontawesome-webfont.woff?v=3.0.2') format('woff'),
       url('https://netdna.bootstrapcdn.com/font-awesome/3.0.2/font/fontawesome-webfont.ttf?v=3.0.2') format('truetype'),
       url('https://netdna.bootstrapcdn.com/font-awesome/3.0.2/font/fontawesome-webfont.svg?v=3.0.2#fontawesomeregular') format('svg');
  font-weight: normal;
  font-style: normal;
}

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
            data: {},
            success: function(retorno) {
                //alert(retorno)
                if (retorno == 'session_vazia') {
                    alert('Sess?o encerrada por falta de uso, favor efetuar o login novamente');
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
                                $ci = get_instance();
                                //pega seção



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
                                $secao = $ci->db->query($sql)->result();
                                //echo '<pre>'.$sql.'</pre>'; exit;
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
                                            // echo '<pre>'.$sql.'</pre>';exit;
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

                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <!--div class="sidebar-footer hidden-small">
                          <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                          </a>
                          <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                          </a>
                          <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                          </a>
                          <a data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                          </a>
                        </div-->
                    <!-- /menu footer buttons -->
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
                                    Bem vindo(a) <small> <b><?= ucfirst(rlower($nome[0])) ?> (<?//= trim($_SESSION['Sistemas'][$_SESSION['sistema']]) ?>)</b></small> ao <b>"<?php echo $title = rupper(@nomeSistema($sistema_id)) ?>"</b>

                                    <span class="glyphicon glyphicon-user"></span>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <!--ul class="dropdown-menu dropdown-usermenu pull-right"-->
                                <ul class="dropdown-menu dropdown-usermenu pull-right" style='width:50%'>
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
                        <div class="col-md-12 col-sm-12 col-xs-12" id='content2' style="">

                            <div class="dashboard_graph">
                                <?php @$ci->db->close() ?>