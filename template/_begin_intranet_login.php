<?php 
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

//header ('Content-type: text/html; charset=UTF-8'); 
 
    $nmServer = '_portal';  
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




            <script src="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/js/bootstrap_2.min.js"></script>
            <link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">



            <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/css/bootstrap.min.css" rel="stylesheet">

            <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/fonts/css/font-awesome.min.css" rel="stylesheet">
            <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/css/animate.min.css" rel="stylesheet">

            <!-- Custom styling plus plugins -->
            <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/css/custom.css" rel="stylesheet">
            <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/css/icheck/flat/green.css" rel="stylesheet">


            <script src="https://<?= $_SERVER['HTTP_HOST'].'/'. $nmServer ?>/template/production/js/jquery.min.js"></script>

            <script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/js/wizard/jquery.smartWizard.js"></script>
            <!-- Bootstrap core CSS -->

            <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/css/bootstrap.min.css" rel="stylesheet">

            <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/fonts/css/font-awesome.min.css" rel="stylesheet">
            <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/css/animate.min.css" rel="stylesheet">

            


            <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
            <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/css/editor/index.css" rel="stylesheet">
            <!-- select2 -->
            <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/css/select/select2.min.css" rel="stylesheet">
            <!-- switchery -->
            <link rel="stylesheet" href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/css/switchery/switchery.min.css" />
            
            <!--
            <script type="text/javascript" language="javascript" src="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/js/jexcel-master/dist/jexcel.js"></script>
            <link rel="stylesheet" href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/js/jexcel-master/dist/jexcel.css" />
            -->
             <link rel="stylesheet" href="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/css/switchery/switchery.min.css" />
            <script type="text/javascript" language="javascript" src="https://<?= $_SERVER['HTTP_HOST'].'/'.$nmServer ?>/JavaScript/fwJS.js"></script>
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
                font-size: 12px
            }
            td{
                /*background-color: #2C4257;*/
                font-size: 12px
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
 

        <form id="form_begin" method="post" action="" style="display:none">
            <input type="hidden" value="" id="pagina_begin" name="pagina_begin">
        </form>

        <body class="nav-md" style='width:100%' id='idBodyTotal'>
            <div class="container body">
                <div class="main_container">
                    <div class="col-md-3 left_col">
                        <div class="left_col scroll-view">
                            <div class="navbar nav_title" style="border: 0;">   <br> 
                                <a href="#" class="site_title"><img src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/Imagens/Topo/bg_logo.png"    class="img-thumbnail"></a>
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
                                <ul class="nav navbar-nav navbar-right" >

                                    <li class="">
                                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Secretaria do Meio Ambiente - SEMA 
                                            <span class="glyphicon glyphicon-leaf green"></span>
                                        </a>                                        
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- /top navigation -->

                    <!-- page content -->
                    <div class="" role="main" id='main'>
                        
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12" id='content2' style="">

                                   