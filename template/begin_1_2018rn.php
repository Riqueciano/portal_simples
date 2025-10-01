<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

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
if (empty($_SESSION['pessoa_id']) or empty($_SESSION['sistema_id'])) {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . "/" . $nmServer . '/Intranet/publicacao/intranet');
}

//echo '<pre>'; print_r($_SESSION['Sistemas'][$_SESSION['sistema']]); echo '</pre>';
?>

<style>
    .loading-overlay {
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(255, 255, 255, 0.9);
        font-size: 14px;
        z-index: 9999;
    }
</style>
<script>
    // Oculta a div de carregamento quando TUDO estiver carregado
    window.addEventListener('load', function() {
        const overlay = document.querySelector('.loading-overlay');
        overlay.style.display = 'none';
    });
</script>
<div class="loading-overlay">
    <b>Carregando...</b>
</div>

<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/vue2.6/vue.min.js"></script>
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



    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer  ?>/template/production/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/custom.css" rel="stylesheet">
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/icheck/flat/green.css" rel="stylesheet">


    <script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/jquery.min.js"></script>

    <script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/js/wizard/jquery.smartWizard.js"></script>
    <!-- Bootstrap core CSS -->


    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/template/production/css/icheck/flat/green.css" rel="stylesheet">
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
    <script type="text/javascript" language="javascript" src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/fwJS.js?rand=<?= rand(0, 100) ?>"></script>



    <script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/select2/select2.js"></script>
    <link rel="stylesheet" type="text/css" href="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/select2/select2.css" />
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

    #content2 {
    background: rgba(255, 255, 255, 0.7); /* fundo branco translúcido */
    backdrop-filter: blur(8px);           /* efeito vidro */
    -webkit-backdrop-filter: blur(8px);   /* compatibilidade com Safari */
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.8s ease-in, opacity 0.8s ease-in;
    transform-origin: bottom right;

    /* redundâncias antigas removidas, veja abaixo */
    /* border: 0px solid #F00; */
    /* moz-border-radius: 8px; */
    /* -webkit-border-radius: 8px; */
    /* -goog-ms-border-radius: 8px; */
}

#content2.minimizando {
    transform:
        scaleY(0.1) scaleX(0.1)
        translateX(200px) translateY(100vh)
        perspective(1000px) rotateX(45deg) rotateY(-25deg);
    opacity: 0;
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

    /* Oculta por padrão */
    .pc-only {
        display: none !important;
    }

    /* Mostra apenas em telas com largura maior que 768px (típico de desktop ou tablet grande) */
    @media (min-width: 769px) {
        .pc-only {
            display: block !important;
        }
    }

    /* Oculta por padrão */
    .cel-only {
        display: none !important;
    }

    /* Mostra apenas em telas com largura menor ou igual a 768px (típico de celular) */
    @media (max-width: 768px) {
        .cel-only {
            display: block !important;
        }
    }

    #div_logo_voltar_avancar {
        top: 16px;
        left: 16px;
        width: 100%;
        /* ajuste conforme o tamanho desejado */
        background-color: rgba(255, 255, 255, 0.7);
        /* translúcido */
        backdrop-filter: blur(5px);
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        text-align: center;
        padding: 8px;
    }

    #div_logo_voltar_avancar img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    #div_logo_voltar_avancar .button-group {
        display: flex;
        justify-content: center;
        gap: 6px;
    }

    #div_logo_voltar_avancar button {
        background: none;
        border: none;
        font-size: 18px;
        color: #333;
        cursor: pointer;
        padding: 10px;
        border-radius: 50%;
        /* Faz o botão ser circular */
        width: 40px;
        /* Define a largura do círculo */
        height: 40px;
        /* Define a altura do círculo */
        display: flex;
        align-items: center;
        justify-content: center;
        /* Centraliza o ícone */
        transition: color 0.2s ease;
    }

    #div_logo_voltar_avancar button:hover {
        color: #000;
    }

    #div_logo_voltar_avancar #btn-voltar i {
        font-size: 20px;
        /* Ajusta o tamanho do ícone */
    }

    #div_logo_voltar_avancar #btn-avançar i {
        font-size: 20px;
        /* Ajusta o tamanho do ícone */
    }


    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(242, 240, 240, 0.85);
        /* fundo escuro com transparência */
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #loading-gif {
        width: 120px;
        height: auto;
        border-radius: 20px;
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

<script>
    /*document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('btn-voltar').addEventListener('click', function (e) {
    e.preventDefault();
    const conteudo = document.getElementById('content2');
    conteudo.classList.add('minimizando');

    setTimeout(() => {
      window.open('https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/Intranet/sistema', '_self');
    }, 800);
  });
});*/
</script>
<!-- <div id="loading-overlay">
   <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Imagens/gif/lego.gif" alt="Carregando..." id="loading-gif">
</div> -->


<script>
    // window.addEventListener('load', function() {
    //     const overlay = document.getElementById('loading-overlay');
    //     overlay.style.transition = 'opacity 0.5s ease';
    //     overlay.style.opacity = 0;
    //     setTimeout(() => overlay.style.display = 'none', 500);
    // });
</script>
<form id="form_begin" method="post" action="" style="display:none">
    <input type="hidden" value="" id="pagina_begin" name="pagina_begin">
</form>

<body class="nav-md" style='width:100%' id='idBodyTotal'>
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="">
                    <div id="div_logo_voltar_avancar" class="pc-only">
                        <a style="padding: 0; border-radius: 8px;" href="#" class="site_title">
                            <img src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/Imagens/Topo/bg_logo.png" class="img-thumbnail" alt="Logo">
                        </a>
                        <div class="button-group">
                            <button id="btn-voltar" onclick="window.history.back()" title="Voltar">
                                <i class="glyphicon glyphicon-chevron-left"></i>
                            </button>
                            <button id="btn-avançar" onclick="window.history.forward()" title="Avançar">
                                <i class="glyphicon glyphicon-chevron-right"></i>
                            </button>
                        </div>
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


                                <!-- <li>
                                    <a style="cursor:pointer" id="btn-voltar"  ><i class="fa fa-home"></i> <b>VOLTAR</b> </a>
                                </li> -->

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
            <div class="cel-only">
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
                                        <small> <b><?= ucfirst(rlower($nome[0])) ?> </b></small><b><?php echo $title = rupper(@nomeSistema($sistema_id)) ?>"</b>

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
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main" id='main'>
                <!-- top tiles -->
                <!-- /top tiles -->

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!--div class="dashboard_graph"-->

                        <!--div class="row x_title">
                                    <h3><?php echo $title = @nomeSistema($sistema_id) ?></h3>
                                </div-->
                        <div class="col-md-12 col-sm-12 col-xs-12" id='content2' style="">

                            <!-- parte do template para combobox(select2) com vue  -->
                            <script type="text/x-template" id="select2-template">
                                <select>
                                <slot></slot>
                                </select>
                            </script>
                            <!-- parte do template para combobox(select2) com vue -->
                            <?php @$ci->db->close() ?>