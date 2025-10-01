<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$nmServer = '_portal';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDR | Secretaria de Desenvolvimento Rural</title>

    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/jquery/jquery-2.1.1.js"></script>
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">

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

        body,
        html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%; 
            background-color: #5E7457;
            background-image: url('https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template_intranet_verde/assets/bg/bg_incolor.png');
            background-size: 1500px;
            background-position: top left;
            background-repeat: repeat;
            /* filter: blur(10px); */
            z-index: -1;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
            color: #000;
            z-index: 1;
        }

        .login-box h2 {
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .login-box .btn {
            width: 100%;
        }

        .login-box .btn+.btn {
            margin-top: 10px;
        }

        .footer-text {
            font-size: 0.9em;
            color: #555;
            text-align: center;
            margin-top: 25px;
        }

        .btn-vermelho {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-vermelho:hover {
            background-color: #c82333;
        }

        .custom-input {
            width: 100%;
            padding: 12px 16px;
            font-size: 16px;
            border: 2px solid rgba(0, 123, 255, 0.5);
            border-radius: 12px;
            outline: none;
            background-color: rgba(255, 255, 255, 0.2);
            /* translúcido */
            color: #fff;
            backdrop-filter: blur(10px);
            /* efeito de vidro */
            -webkit-backdrop-filter: blur(10px);
            /* suporte Safari */
            transition: border-color 0.3s, box-shadow 0.3s, background-color 0.3s;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
        }

        .custom-input:focus {
            border-color: rgba(0, 123, 255, 0.8);
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.3);
            background-color: rgba(255, 255, 255, 0.3);
        }

        .custom-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
    </style>

</head>