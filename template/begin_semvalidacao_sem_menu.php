<link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">

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


        <script src="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/js/bootstrap_2.min.js"></script>



        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/bootstrap.min.css" rel="stylesheet">

        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/animate.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/custom.css" rel="stylesheet">
        <link href="https://<?= $_SERVER['HTTP_HOST'] .'/'.$nmServer?>/template/production/css/icheck/flat/green.css" rel="stylesheet">


        <script src="https://<?= $_SERVER['HTTP_HOST'].'/'.$nmServer ?>/template/production/js/jquery.min.js"></script>


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
        <script type="text/javascript" language="javascript" src="https://<?= $_SERVER['HTTP_HOST'].'/'.$nmServer ?>/JavaScript/fwJS.js"></script>

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



     