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
    //caso n�o esteja logado, redireciona para o Login
    //if (!isset($_SESSION['pessoa_id'])) {
       //header("Location: https://".$_SERVER['HTTP_HOST']."/".$nmServer.'/Intranet/publicacao/intranet');
    //}

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
            
              /************ oculta a barra de menu lateral */
    body.nav-md .container.body .right_col,
    body.nav-md .container.body .top_nav {
        width: 100%;
        margin: 0;
    }

    body.nav-md .container.body .col-md-3.left_col {
        display: none;
    }

    body.nav-md .container.body .right_col {
        width: 100%;
        padding-right: 0
    }

    .right_col {
        padding: 10px !important;
    }
    /* ***************************************** */
           
        </style>

<div id="todo_conteudo">

       
               