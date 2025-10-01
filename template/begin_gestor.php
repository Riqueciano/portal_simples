<?php error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
 ?>
<!DOCTYPE html>
<?php $nmServer = '_portal'?>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SDR | Secretaria de Desenvolvimento Rural</title>

    <!-- Bootstrap -->
    <link href="https://<?php echo $_SERVER['HTTP_HOST'].'/'.$nmServer ?>/template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://<?php echo $_SERVER['HTTP_HOST'].'/'.$nmServer ?>/template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="https://<?php echo $_SERVER['HTTP_HOST'].'/'.$nmServer ?>/template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="https://<?php echo $_SERVER['HTTP_HOST'].'/'.$nmServer ?>/template/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="https://<?php echo $_SERVER['HTTP_HOST'].'/'.$nmServer ?>/template/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="https://<?php echo $_SERVER['HTTP_HOST'].'/'.$nmServer ?>/template/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="https://<?php echo $_SERVER['HTTP_HOST'].'/'.$nmServer ?>/template/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="https://<?php echo $_SERVER['HTTP_HOST'].'/'.$nmServer ?>/template/build/css/custom.min.css" rel="stylesheet">
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

        #idBodyTotal{
            position: absolute;
            /*top: -20px;
            left: -20px;*/
            background-color: white;
            
            
        }
        #content{
           border:0px solid #F00;
        
            background-color: #2C4257;

            moz-border-radius: 8px;
            -webkit-border-radius: 8px;
            -goog-ms-border-radius: 8px;
            border-radius: 8px;
        }
        
        
    </style>
  </head>

  <body class="nav-md" style='width:100%' id='idBodyTotal'>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
                <a href="#" class="site_title"><img src="https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/bg_logo.png" class="img-thumbnail"><span></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                
              </div>
              
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                   <h3 style="cursor:pointer" onclick='window.open("https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer; ?>/Intranet/sistema", "_self")'><i class="fa fa-home"></i>Voltar</h3><br>
                <ul class="nav side-menu">
                  
                    
                  
                  
                  <?php
            
                    $sistema_id = empty($_GET['sistema'])?$_SESSION['sistema_id']:$_GET['sistema'];
                    
                    
                    
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


                                    where s.secao_st = 0 and s.sistema_id = " . (int)$sistema_id . " and utu.pessoa_id = " . (int)$_SESSION['pessoa_id'];
                    
                    $_SESSION['sistema'] = empty($_GET['sistema'])?$_SESSION['sistema']:$_GET['sistema'];
                    //pega secao
                    $rsSessao = pg_query(abreConexao(), $sql);
                    //$linhaS = pg_fetch_assoc($rsSessao);
                  //echo '<pre>'.$sql.'</pre>';//exit;
                    ?>
            
            <?php
                    while ($linhaS = pg_fetch_assoc($rsSessao)){  ?>   
            <!-- Dropdown-->
            <li><a><i class="<?=  ($linhaS['class_icon_bootstrap'])?>"></i> <?=  rupper($linhaS['secao_ds'])?> <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                                                    
                        <?php 
                                $sql = "select 
                                               a.* from seguranca.tipo_usuario tu
                                    inner join seguranca.tipo_usuario_acao tua
                                            on tua.tipo_usuario_id = tu.tipo_usuario_id
                                    inner join seguranca.acao a	
                                            on a.acao_id = tua.acao_id 
                                    inner join seguranca.usuario_tipo_usuario utu
                                            on utu.tipo_usuario_id = tu.tipo_usuario_id

                                    where a.acao_st = 0 and a.secao_id =" . $linhaS['secao_id'] . " and sistema_id = " . (int)$sistema_id . " and utu.pessoa_id = " . (int)$_SESSION['pessoa_id']; 
                                //echo_pre($sql);
                                $rsAcao = pg_query(abreConexao(), $sql);
                                ;
                                    while ($linhaA = pg_fetch_assoc($rsAcao)){ ?>
                                               <li><a href="<?=$linhaA['acao_url']?>"><?=($linhaA['acao_ds'])?></a></li>        
                                   <?php } ?>
                    </ul>
                   </li> 
                <?php   }
                   
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
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Olá, <?=$_SESSION['pessoa_nm']?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <!--li><a href="javascript:;">Ajuda</a></li-->
                    <li><a href="#"><i class=""></i> <?=$_SESSION["Sistemas"][$_SESSION["Sistema"]]?></a></li>
                    <li><a href="#"><i class=""></i> <?=$_SESSION['est_organizacional_lotacao_sigla']?></a></li>
                    <li><a href="../Login/usuario"><i class="fa fa-sign-out pull-right"></i> Sair</a></li>
                  </ul>
                </li>

                
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            
          </div>
          <!-- /top tiles -->

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">
                 <div class="row x_title">
                  <div class="col-md-6">
                    <h3><?=$_SESSION['sistema_nm'];?></h3>
                  </div>
                  
                </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" id='content' style="">
                      <div class="dashboard_graph">