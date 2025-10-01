<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$nmServer = '_portal';
$sistema_id = empty($_GET['sistema']) ? $_SESSION['sistema'] : $_GET['sistema'];

//caso não esteja logado, redireciona para o Login
if (!isset($_SESSION['pessoa_id'])) {
    header("Location: https://".$_SERVER['HTTP_HOST']."/".$nmServer.'/Intranet/publicacao/intranet');
}

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
        <script src="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/js/bootstrap_2.min.js"></script>
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/bootstrap.min.css" rel="stylesheet">

        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/animate.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/custom.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/icheck/flat/green.css" rel="stylesheet">
        <link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">


        <script src="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/js/jquery.min.js"></script>


        <!-- Bootstrap core CSS -->

        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/bootstrap.min.css" rel="stylesheet">

        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/animate.min.css" rel="stylesheet">
 
        <!-- editor -->
        <link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/editor/index.css" rel="stylesheet">
        <!-- select2 -->
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/select/select2.min.css" rel="stylesheet">
        <!-- switchery -->
        <link rel="stylesheet" href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/switchery/switchery.min.css" />
        <script type="text/javascript" language="javascript" src="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/JavaScript/fwJS.js"></script>
        <script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/vue2.6/vue.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/select2/select2.js"></script>
    <link rel="stylesheet" type="text/css" href="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/select2/select2.css" />
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



    <body class="" style='width:100%' id='idBodyTotal'>
        <div class="container body">
            <div class="main_container">
                <!-- top navigation -->
                
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    <!-- top tiles -->
                    
                    <!-- /top tiles -->

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="col-md-12 col-sm-12 col-xs-12" id='content2' style="">

                                    