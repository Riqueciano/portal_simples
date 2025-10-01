<?php header("Content-type: text/html; charset=utf-8"); // echo $caminho; exit; 
?>
<html lang="en">

<head> 
    <meta charset="utf-8">
    <title>SIPAF/SDR</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="<?= $caminho ?>/img/favicon.png" rel="icon">
    <link href="<?= $caminho ?>/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="<?= $caminho ?>/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="<?= $caminho ?>/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?= $caminho ?>/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?= $caminho ?>/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="<?= $caminho ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?= $caminho ?>/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="<?= $caminho ?>/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script>
        (document).ready(function() {
            // $('#modalComum').modal('show');alert()
        });

        function exibe_modal(produto_tipo_id) {
            //alert("https://www.portalsema.ba.gov.br/_portal/Selo/produto/buscador/"+produto_tipo_id)
            $('#iframe_modal').prop('src', "https://www.portalsema.ba.gov.br/_portal/Selo/produto/buscador/" + produto_tipo_id);

            $('#modalComum').modal('show');
        }

        function exibir_modal_produto() {
            $('#modalComum').modal('show');
        }
    </script>
</head>

<body>

    <!--==========================
          Header
        ============================-->
    <header id="header">
        <div class="container-fluid">

            <div id="logo" class="pull-left">
                <h1><a href="https://<?= $_SERVER['HTTP_HOST'] ?>/sipaf" class="scrollto">SDR | SIPAF</a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="#intro"><img src="<?= $caminho ?>/img/logo.png" alt="" title="" /></a>-->
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="menu-active"><a href="#intro">Início</a></li>
                    <li><a href="#about">SIPAF</a></li>

                    <li><a href="#portfolio">PRODUTOS</a></li>
                    <li>
                        <a href="<?= site_url('pessoa/empreendimentos') ?>">EMPREENDIMENTOS</a>
                    </li>
                    <li><a href="#call-to-action">SDR</a></li>
                    <li><a href="#team">SUAF</a></li>

                    <li><a href="#inscricao">inscrição</a></li>
                    <li><a href="https://www.portalsema.ba.gov.br/_portal/Intranet/usuario">Login</a></li>

                    <li><a href="#contact">Contato</a></li>
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </header><!-- #header -->

    <!--==========================
          Intro Section
        ============================-->
    <section id="intro">
        <div class="intro-container">
            <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">

                <ol class="carousel-indicators"></ol>

                <div class="carousel-inner" role="listbox">

                    <div class="carousel-item active">
                        <div class="carousel-background"><img src="<?= $caminho ?>/img/intro-carousel/Capa_Site_Selo2.jpg" alt=""></div>
                        <div class="carousel-container">
                            <div class="carousel-content">
                                <h2></h2>
                                <p></p>
                                <!-- <a  class="btn-get-started scrollto" style='background-color:white; color:black'>SIPAF</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="carousel-background"><img src="<?= $caminho ?>/img/intro-carousel/Capa_Site_Selo.jpg" alt=""></div>
                        <div class="carousel-container">
                            <div class="carousel-content">
                                <h2> </h2>
                                <p></p>
                                <!-- <a  class="btn-get-started scrollto" style='background-color:white; color:black'>SIPAF</a> -->
                            </div>
                        </div>
                    </div>


                    <div class="carousel-item">
                        <div class="carousel-background"><img src="<?= $caminho ?>/img/intro-carousel/Capa_Site_Selo3.jpg" alt=""></div>
                        <div class="carousel-container">
                            <div class="carousel-content">
                                <h2> </h2>
                                <p></p>
                                <!-- <a  class="btn-get-started scrollto" style='background-color:white; color:black'>SIPAF</a> -->
                            </div>
                        </div>
                    </div>


                </div>

                <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>

                <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Próximo</span>
                </a>

            </div>
        </div>
    </section>

    <section id="about" class="wow fadeIn">
        <div class="container text-center">
            <header class="section-header">
                <h3>SIPAF</h3>
                <p>Selo de Identificação da Participação da Agricultura Familiar .</p>

                <p style='text-justify'>O Selo de Identificação de Produtos da Agricultura Familiar –
                    SIPAF – nasceu com o propósito de identificar os produtos da agricultura familiar do Estado da Bahia.
                    O SIPAF oferece aos consumidores a garantia de que estão adquirindo uma produção livre de agrotóxicos,
                    que se baseia nas relações de comércio justo e solidário e do respeito à natureza e as relações sociais.
                    <!--Vale ressaltar que o SIPAF é concedido apenas para .-->
                </p>
            </header>

        </div>
    </section>

    <section id="portfolio" class="section-bg">
        <div class="container">

            <header class="section-header">
                <h3 class="section-title">DESCUBRA</h3>
            </header>
            <div class="row portfolio-container">
                <?php

                foreach ($produtos_mais_procurados as $key => $pt) { ?>
                    <a href="<?= site_url('Produto/produto_tipo/' . $pt->produto_tipo_id) ?>">
                        <div class="col-lg-3 col-md-6 portfolio-item filter-app wow fadeInUp" style="cursor:pointer;">
                            <div class="portfolio-wrap">
                                <figure>
                                    <a href="<?= site_url('Produto/read/' . $pt->produto_id) ?>">
                                        <img style="width:100%" src="<?= $caminho_anexo . '/' . utf8_encode($pt->anexo_foto) ?>">&nbsp;
                                    </a>
                                </figure>
                                <div class="portfolio-info">
                                    <b><?= utf8_encode(rupper($pt->produto_nm)) ?></b>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php }
                  foreach ($produtos_menos_procurados as $key => $pt) { ?>
                    <a href="<?= site_url('Produto/produto_tipo/' . $pt->produto_tipo_id) ?>">
                        <div class="col-lg-3 col-md-6 portfolio-item filter-app wow fadeInUp" style="cursor:pointer;">
                            <div class="portfolio-wrap">
                                <figure>
                                    <a href="<?= site_url('Produto/read/' . $pt->produto_id) ?>">
                                        <img style="width:100%" src="<?= $caminho_anexo . '/' . utf8_encode($pt->anexo_foto) ?>">&nbsp;
                                    </a>
                                </figure>
                                <div class="portfolio-info">
                                    <b><?= utf8_encode(rupper($pt->produto_nm)) ?></b>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>

        </div>
    </section>
     
    <main id="main">

        <section id="portfolio" class="section-bg">
            <div class="container">

                <header class="section-header">
                    <h3 class="section-title">CATEGORIAS</h3>
                </header>
                <div class="row portfolio-container">


                    <?php

                    foreach ($produto_tipo as $key => $pt) { ?>
                        <a href="<?= site_url('Produto/produto_tipo/' . $pt->produto_tipo_id) ?>">
                            <div class="col-lg-3 col-md-6 portfolio-item filter-app wow fadeInUp" style="cursor:pointer;">
                                <div class="portfolio-wrap">
                                    <figure>
                                        <img src="<?= $caminho ?>/img/produto_tipo_icone/<?= $pt->icone ?>" alt="" style="width:100%">
                                    </figure>
                                    <div class="portfolio-info">
                                        <h4><?php

                                            if (strlen($pt->produto_tipo_nm) > 15) {
                                                echo substr(utf8_encode(rupper($pt->produto_tipo_nm)),0,15).'...';
                                            } else {
                                                echo utf8_encode(rupper($pt->produto_tipo_nm));
                                            }


                                            ?></h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php }
                    ?>
                </div>

            </div>
        </section>



        <section id="services" style='display:none'>
            <div class="container">

                <header class="section-header wow fadeInUp">
                    <h3>CURIOSIDADES</h3>
                    <!--p>Laudem latine persequeris id sed, ex 
                            fabulas delectus quo. No vel partiendo abho
                            rreant vituperatoribus, ad pro quaestio lab
                            oramus. Ei ubique vivendum pro. At ius nisl accusam lorenta zanos paradigno tridexa panatarel.</p-->
                </header>

                <div class="row">


                    <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s">
                        <div class="icon"><i class="glyphicon glyphicon-user"></i></div>
                        <h4 class="title"><a href="">Agricultura familiar</a></h4>
                        <p class="description">explicando o que é, importancia texto texto texto texto texto texto texto texto</p>
                    </div>
                    <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s">
                        <div class="icon"><i class="glyphicon glyphicon-home"></i></div>
                        <h4 class="title"><a href="">Agricultura familiar</a></h4>
                        <p class="description">explicando o que é, importancia texto texto texto texto texto texto texto texto</p>
                    </div>
                    <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s">
                        <div class="icon"><i class="glyphicon glyphicon-heart"></i></div>
                        <h4 class="title"><a href="">Agricultura familiar</a></h4>
                        <p class="description">explicando o que é, importancia texto texto texto texto texto texto texto texto</p>
                    </div>
                    <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s">
                        <div class="icon"><i class="glyphicon glyphicon-tags"></i></div>
                        <h4 class="title"><a href="">Agricultura familiar</a></h4>
                        <p class="description">explicando o que é, importancia texto texto texto texto texto texto texto texto</p>
                    </div>


                </div>

            </div>
        </section><!-- #services -->


        <!-- #portfolio -->

        <!--==========================
              Clients Section
            ============================-->

        <!-- #clients -->


        <section id="call-to-action" class="wow fadeIn">
            <div class="container text-center">
                <h3>SDR</h3>
                <p> A Secretaria de Desenvolvimento Rural – SDR – foi criada em 2014 com a finalidade de formular,
                    articular e executar políticas públicas, através de programas, projetos e ações voltadas para a
                    reforma agrária e o desenvolvimento da agricultura familiar.
                    São incluídos na categoria de agricultores familiares, os meeiros, parceiros, quilombolas, populações indígenas,
                    assentados da reforma agrária, trabalhadores rurais, comunidades de fundo e fecho de pastos, pescadores, marisqueiros,
                    ribeirinhos, dentre outros.
                    Os programas, projetos e ações da SDR são norteados pelos princípios da agroecologia, rede solidária de produção e comercialização,
                    desenvolvimento sustentável, gestão e controle social das políticas públicas.
                </p>

            </div>
        </section>
        <section id="team">
            <div class="container">
                <div class="section-header wow fadeInUp">
                    <h3>SUAF</h3>
                    <p>SUAF - SUPERINTEDÊNCIA DE AGRICULTURA FAMILIAR</p>
                    <p> A Superintendência de Agricultura Familiar – SUAF – foi criada no ano de 2015 com a
                        finalidade de estimular e estruturar as atividades econômicas, as organizações e demais segmentos
                        dos agricultores familiares, por meio do planejamento e articulação de programas, projetos e ações
                        sustentáveis e alinhadas com o desenvolvimento da Bahia. São áreas estratégicas de atuação da SUAF,
                        o apoio e fomento à produção e a agregação de valor e acesso aos mercados.

                    </p>
                </div>
        </section>


        <section id="inscricao">
            <div class="container">
                <div class="section-header wow fadeInUp">
                    <h3>INSCRIÇÃO</h3>


                    <p>
                        Selo de Identificação da Participação da Agricultura Familiar<br><br>
                        <a href="https://www.portalsema.ba.gov.br/_portal/Selo/inscricao_sipaf/create">
                            <input type="button" class="btn btn-danger" value="INSCRIÇÃO NO SIPAF">
                        </a>
                        <br>
                        <br>
                         <span class="fa fa-whatsapp" style='color: green' aria-hidden="true">
                                                            <a href="https://wa.me//5571984049726?"> (71) 9.8326-4604 </a>
                                                            </span> 

                        <br>
                        <br>
                        <b>

                    </p>
                </div>


        </section>

        <section id="clients" class="wow fadeInUp">
            <div class="container">

                <header class="section-header">
                    <h3></h3>
                </header>

                <div class="owl-carousel clients-carousel">
                    <?php
                    foreach ($produto_novidade as $key => $p) {
                        if (!empty($p->anexo_foto)) { //echo $p->anexo_foto.'|<br>'
                    ?>
                            <!-- <p onclick="exibir_modal_produto()"> -->
                            <a href="<?= site_url('Produto/read/' . $p->produto_id) ?>">
                                <img src="<?= $caminho_anexo . '/' . utf8_encode($p->anexo_foto) ?>">&nbsp;
                            </a>
                            <!-- </p>         -->
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
        <section id="contact" class="section-bg wow fadeInUp">
            <div class="container">

                <div class="section-header">
                    <h3>Contato</h3>
                </div>

                <div class="row contact-info">

                    <div class="col-md-4">
                        <div class="contact-address">
                            <i class="glyphicon glyphicon-map-marker"></i>
                            <h3>Endereço</h3>
                            <address>Endereço SUAF: 4ª Avenida, nº 405, andar mezanino. CAB/SEAGRI | CEP 41.745-002 | Salvador | Bahia

                            </address>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-phone">
                            <i class="glyphicon glyphicon-phone-alt"></i>
                            <h3>Contato</h3>
                            <p><a href="">(71) 3115 2839</a></p>
                            <a data-toggle="tooltip" data-placement="top" >
                            <a data-toggle="tooltip" data-placement="top" >
                                                            <!-- <span class="fa fa-whatsapp" style='color: green' aria-hidden="true">
                                                            <a href="https://wa.me//5571984049726?"> (71) 9.8326-4604 </a>
                                                            </span>  -->
                                                        </a> 
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-email">
                            <i class="glyphicon glyphicon-comment"></i>
                            <h3>E-mail</h3>
                            <p><a href="mailto:gabinete.suaf@sdr.ba.gov.br">gabinete.suaf@sdr.ba.gov.br</a></p>
                        </div>
                    </div>

                </div>



            </div>
        </section><!-- #contact -->

    </main>

    <!--==========================
                                      Footer
                                    ============================-->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-info">
                        <h3>SIPAF</h3>
                        <p> </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>Redes Sociais</h4>
                        <div class="social-links">
                            <a data-toggle="tooltip" data-placement="top" title="" target="_blank" href="https://www.facebook.com/sdrbahia/" data-original-title="Facebook">
                                <span class="fa fa-facebook" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Twitter" href="https://twitter.com/sdrbahia">
                                <span class="fa fa-twitter" aria-hidden="true"></span>
                            </a>
                            <a href="https://www.instagram.com/sdrbahia/" class="instagram"><i class="fa fa-instagram"></i></a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                SDR - Secretaria de Desenvolvimento Rural
            </div>
            <div class="credits">


            </div>
        </div>
    </footer><!-- #footer -->

    <div id="modalComum" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: ">
            <!-- Modal content-->
            <div class="modal-content" id='autoriza_list_modal'>
                <!--div class="modal-header">
                                                    <h4 class="modal-title">Produto x Território</h4>
                                                </div-->
                <div class="modal-body" id='resultModal'>
                    <div class='div_cid_tramitar'>
                        <iframe id='iframe_modal' src="" style="width:100%; height: 400px" frameborder="0" marginheight="0" marginwidth="0" scrolling="yes"></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>

        </div>
    </div>
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <!-- Uncomment below i you want to use a preloader -->
    <!-- <div id="preloader"></div> -->

    <!-- JavaScript Libraries -->
    <script src="<?= $caminho ?>/lib/jquery/jquery.min.js"></script>
    <script src="<?= $caminho ?>/lib/jquery/jquery-migrate.min.js"></script>
    <script src="<?= $caminho ?>/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $caminho ?>/lib/easing/easing.min.js"></script>
    <script src="<?= $caminho ?>/lib/superfish/hoverIntent.js"></script>
    <script src="<?= $caminho ?>/lib/superfish/superfish.min.js"></script>
    <script src="<?= $caminho ?>/lib/wow/wow.min.js"></script>
    <script src="<?= $caminho ?>/lib/waypoints/waypoints.min.js"></script>
    <script src="<?= $caminho ?>/lib/counterup/counterup.min.js"></script>
    <script src="<?= $caminho ?>/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="<?= $caminho ?>/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="<?= $caminho ?>/lib/lightbox/js/lightbox.min.js"></script>
    <script src="<?= $caminho ?>/lib/touchSwipe/jquery.touchSwipe.min.js"></script>
    <!-- Contact Form JavaScript File -->
    <script src="<?= $caminho ?>/contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="<?= $caminho ?>/js/main.js"></script>

</body>

</html>