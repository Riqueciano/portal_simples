
<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$nmServer = '_portal';
$sistema_id = 43; //termo
//caso não esteja logado, redireciona para o Login
//echo '<pre>'; print_r($_SESSION['Sistemas'][$_SESSION['sistema']]); echo '</pre>';
?>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/jquery/jquery-2.1.1.js"></script>

        <title>SDR | Secretaria de Desenvolvimento Rural</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">


        <script src="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/js/bootstrap_2.min.js"></script>



        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/css/bootstrap.min.css" rel="stylesheet">

        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/css/animate.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/css/custom.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/css/icheck/flat/green.css" rel="stylesheet">


        <script src="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/js/jquery.min.js"></script>


        <!-- Bootstrap core CSS -->

        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/css/bootstrap.min.css" rel="stylesheet">

        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/css/animate.min.css" rel="stylesheet">
 
        <!-- editor -->
        <link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/css/editor/index.css" rel="stylesheet">
        <!-- select2 -->
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/css/select/select2.min.css" rel="stylesheet">
        <!-- switchery -->
        <link rel="stylesheet" href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>template/production/css/switchery/switchery.min.css" />
        <script type="text/javascript" language="javascript" src="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>JavaScript/fwJS.js"></script>

        <!--[if lt IE 9]>
            <script src="../assets/js/ie8-responsive-file-warning.js"></script>
            <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        <script>
            function mascaraCPF(evento, objeto)
            {
                var keypress = (window.event) ? event.keyCode : evento.which;
                campo = eval(objeto);

                caracteres = '0123456789';
                separacao1 = '.';
                separacao2 = '-';
                conjunto1 = 3;
                conjunto2 = 7;
                conjunto3 = 11;

                if ((caracteres.search(String.fromCharCode(keypress)) != -1) && campo.value.length < (14))
                {
                    if (campo.value.length == conjunto1)
                        campo.value = campo.value + separacao1;
                    else if (campo.value.length == conjunto2)
                        campo.value = campo.value + separacao1;
                    else if (campo.value.length == conjunto3)
                        campo.value = campo.value + separacao2;
                } else
                    event.returnValue = false;

            }
            function mascaraCNPJ(evento, objeto)
            {
                var keypress = (window.event) ? event.keyCode : evento.which;
                campo = eval(objeto);

                caracteres = '0123456789';
                separacao1 = '.';
                separacao2 = '-';
                separacao3 = '/';
                conjunto1 = 2;
                conjunto2 = 6;
                conjunto3 = 10;
                conjunto4 = 15;

                if ((caracteres.search(String.fromCharCode(keypress)) != -1) && campo.value.length < (18))
                {
                    if (campo.value.length == conjunto1)
                        campo.value = campo.value + separacao1;
                    else if (campo.value.length == conjunto2)
                        campo.value = campo.value + separacao1;
                    else if (campo.value.length == conjunto3)
                        campo.value = campo.value + separacao3;
                    else if (campo.value.length == conjunto4)
                        campo.value = campo.value + separacao2;
                } else
                    event.returnValue = false;

            }
        </script>
    </head>
    <style>
@import url('https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/css/fonte/cyrilluc-etc.css');
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

        #content{
            border:0px solid #F00;

            background-color: #2C4257;

            moz-border-radius: 8px;
            -webkit-border-radius: 8px;
            -goog-ms-border-radius: 8px;
            border-radius: 8px;
        }

        th{
            /*background-color: #2C4257;*/
            background-color: #3F5367;
            color: white;
            font-size: 13px
        }


        table{
            width:100%; 
            border-collapse:collapse; 
        }


        /* Define the hover highlight color for the table row */
        .table tr:hover {
            background-color: #DDF4EF;
            border:#68CFB8 2px solid;
        }
    </style>



    <body class="nav-md" style='width:100%' id='idBodyTotal'>
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">   <br> 
                            <a href="#" class="site_title"><img src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/Imagens/Topo/bg_logo.png"    class="img-thumbnail"></a>

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
                                <h3 style="cursor:pointer" onclick='window.open("https://www.portalsema.ba.gov.br/", "_self")'><i class="fa fa-home"></i>SDR</h3><br>
                                <ul class="nav side-menu">
                                    <li>
                                        <a href="https://<?=$_SERVER['HTTP_HOST'] .'/'.$nmServer?>Selo/usuario/create"><i class="glyphicon glyphicon-user"></i> Faça seu cadastro </a>
                                    </li> 
                                    <li>
                                        <a href="https://<?=$_SERVER['HTTP_HOST'] .'/'.$nmServer?>/intranetsdr/?model_ini=model_login_selo"><i class="glyphicon glyphicon-globe"></i> Login  </a>
                                    </li> 
                                    <li>
                                        <a href="https://<?=$_SERVER['HTTP_HOST'] .'/'.$nmServer?>/selo/login/inicio_Login_esqueceu"><i class="glyphicon glyphicon-search"></i> Esqueci a senha  </a>
                                    </li> 

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
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>
                            <div class="text-right" ><br>
                                <!--a href="<?php echo site_url('comprador/inicio') ?>"  style="font-size:20px;color:red"><i class=" glyphicon glyphicon-off"></i></a-->
                            </div>
                            <ul class="nav navbar-nav navbar-right">

                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    <!-- top tiles -->
                    <div class="row tile_count">
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"></span>
                        </div>
                    </div>
                    <!-- /top tiles -->

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <!--div class="dashboard_graph"-->

                            <!--div class="row x_title">
                                <h3><?php echo 'Termo de adesão' ?></h3>
                            </div-->
                            <div class="col-md-12 col-sm-12 col-xs-12" id='content2' style="">

                               