<?php 
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

//header ('Content-type: text/html; charset=UTF-8'); 
 
    $nmServer = '_portal'; 
    /*
      echo '<br>';
      echo 'get->'.$_GET['sistema'];
      echo '<br>';
      echo 'session->'.$_SESSION['sistema'];
      echo '<br>'; 
     */
    

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

            <script src="https://<?= $_SERVER['HTTP_HOST'] .'/'. $nmServer ?>/template/production/js/bootstrap_2.min.js"></script>



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
 
            <!-- editor -->
            <!--link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet"-->
            


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

        <script>
 

            function abreTransicao(pagina) {            
                $('#form_begin').attr("action",'https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/Intranet/transicao');
                $('#pagina_begin').val(pagina);
                $('#form_begin').submit();
            }

            function ajax_carrega_item(menu_item_id){
                 $.ajax({
                    url: "<?= site_url('/Menu_item/ajax_carrega_item') ?>/",
                    type: "POST",
                    dataType: "html",
                    async: false,
                    data: {
                        menu_item_id: $('#menu_item_id').val(), 
                    },
                    success: function (retorno) { 
                        
                            alert(retorno)
                    }
                });
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
                                <div class="menu_section"><br>
                                    <!--h3 style="cursor:pointer" onclick='window.open("https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer; ?>/Home/Home.php", "_self")'><i class="fa fa-home"></i>Voltar</h3><br-->
                                    <h3 style="cursor:pointer" onclick='window.open("https://www.sdr.ba.gov.br", "_self")'><i class="fa fa-home"></i>SDR</h3><br>
                                    <ul class="nav side-menu">

                                        <?php foreach ($menu as $key => $m) { ?>   
                                            <!-- Dropdown-->
                                            <li><a><i class="<?= rupper($m->menu_icon) ?>"></i> <?= rupper($m->menu_nm) ?> <span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <?php                                                    
                                                    foreach ($menu_item as $mi) { 
                                                        if($mi->menu_id == $m->menu_id){ ?>
                                                            <li>
                                                                <?php //echo $mi->menu_item_tipo_id;
                                                                    switch ($mi->menu_item_tipo_id) {
                                                                        case 1://"Link externo"
                                                                            ?>
                                                                               <a target='_self' href='<?=$mi->menu_item_link?>'  style="cursor:pointer"><?=$mi->menu_item_titulo?>  </a>
                                                                            <?php
                                                                            break;
                                                                        case 2: //"P�gina interna"
                                                                            ?>
                                                                                <a href='https://<?=$_SERVER['HTTP_HOST'].'/'.$nmServer.'/Intranet/menu_item/read/'.$mi->menu_item_id?>' onclick="ajax_carrega_item(<?=$mi->menu_item_id?>)" style="cursor:pointer"><?=$mi->menu_item_titulo?> </a>
                                                                            <?php   
                                                                            break;

                                                                        default:
                                                                            break;
                                                                    }
                                                                ?>
                                                               
                                                  <?php }
                                               } ?>
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
                                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
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
                                
                                <div class="col-md-12 col-sm-12 col-xs-12" id='content2' style="">

                                   