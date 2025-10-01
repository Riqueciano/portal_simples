<?php
$iPATH = $_SERVER['HTTP_HOST'] . "/_portal//";
$upload_path  = 'https://' . $_SERVER['HTTP_HOST'] . '/_portal/anexos/anexo_atendimento/';






$controller = "https://" . $_SERVER['HTTP_HOST'] . '/_portal/intranet/publicacao/';

?>

<!DOCTYPE html>
<html lang="en">

<head>


  <!-- <script src="https://cdn.jsdelivr.net/npm/vue@3"></script> -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SDR - Secretaria de Desenvolvimento Rural</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Arsha
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Updated: May 13 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


  <!-- Adicionando Vue.js -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>

<body class="index-page">
  <!--###app###-->
  <div>
    <header id="header" class="header d-flex align-items-center fixed-top">
      <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="index.html" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/bg_logo.png" alt="" style="border-radius: 10px;">
          <h1 class="sitename">SDR</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#hero" class="">Inicio</a></li>
            <!-- <li><a href="#sobre_sdr">SDR</a></li> -->

            <li><a href="#noticias">Notícias</a></li>
            <!-- <li><a href="#sistemas">Sistemas</a></li>
          <li><a href="#planilhas">Planilhas</a></li> -->

            <li><a href="#gestores">Gestores</a></li>
            <!-- <li><a href="#aniversariantes">Aniversariantes</a></li> -->
            <li class="dropdown"><a href="#"><span>Sistemas</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="#sistemas">Sistemas</a></li>
                <li><a href="#planilhas">Planilhas</a></li>
                <li><a href="#sipaf">SIPAF/Produtos</a></li>
                <li><a href="#aniversariantes">Aniversariantes</a></li>
              </ul>
            </li>
            <li class="dropdown"><a href="#"><span>SDR</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="#sobre_sdr">Sobre a SDR</a></li>
                <li><a href="#sobre_sdr">SDR</a></li>
                <li><a href="https://www.sda.sdr.ba.gov.br/">SDA</a></li>
                <li><a href="https://www.car.ba.gov.br/">CAR</a></li>
                <li><a href="https://www.bahiater.sdr.ba.gov.br/">BAHIATER</a></li>
              </ul>
            </li>
            <li class="dropdown"><a href="#"><span>Contato</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="#contact">CONTATO</a></li>
                <li><a href="https://www.portalsema.ba.gov.br/_portal/Intranet/funcionario/">COLABORADORES</a></li>
              </ul>
            </li>
            <li><a href="#contact">Contato</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <!-- <a class="btn-getstarted" href="#about">Get Started</a> -->

      </div>
    </header>

    <main class="main">
      <div id='appIntranet'>

        <!-- Hero Section -->
        <section id="hero" class="hero section">

          <div class="container">
            <div class="row gy-4">
              <div class="col-lg-8 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                <!-- <h1 class="">Cassossel</h1> -->
                <!-- <p class="">-</p> -->
                <div class="container px-5">
                  <div class="row gx-5 align-items-center">



                    <div class="col-lg-12">
                      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                          <li data-target="#carouselExampleIndicators" v-for="(i, index) in carrossel" :data-slide-to="index" :class="index==0?'active':''"></li>
                        </ol>

                        <div class="carousel-inner">
                          <div :class="'carousel-item' + (index==0?'active':'')" v-for="(i, index) in carrossel">
                            <img style="border-radius: 20px" class="d-block w-100" :src="'<?= $upload_path ?>' + i.publicacao_img" alt="First slide">
                            <div class="text-center">
                              <b>{{i.publicacao_titulo}}</b>
                            </div>
                          </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
              </div>
            </div>
          </div>
        </section><!-- /Hero Section -->

        <!-- Clients Section -->
        <section id="clients" class="clients section">
          <div class="container" data-aos="zoom-in">
            <div class="swiper">
              <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": "auto",
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "spaceBetween": 40
                    },
                    "480": {
                      "slidesPerView": 3,
                      "spaceBetween": 60
                    },
                    "640": {
                      "slidesPerView": 4,
                      "spaceBetween": 80
                    },
                    "992": {
                      "slidesPerView": 5,
                      "spaceBetween": 120
                    },
                    "1200": {
                      "slidesPerView": 6,
                      "spaceBetween": 120
                    }
                  }
                }
              </script>
              <div class="swiper-wrapper align-items-center">
                <div class="swiper-slide"><b>SDR</b></div>
                <div class="swiper-slide"><b>GABINETE</b></div>
                <div class="swiper-slide"><b>APG</b></div>
                <div class="swiper-slide"><b>CAR</b></div>
                <div class="swiper-slide"><b>BAHIATER</b></div>
                <div class="swiper-slide"><b>SUAF</b></div>
                <div class="swiper-slide"><b>SDA</b></div>
                <div class="swiper-slide"><b>SUTRAG</b></div>
                <div class="swiper-slide"><b>DG</b></div>

                <!-- <div class="swiper-slide"><img src="assets/img/clients/client-2.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-3.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-4.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-5.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-6.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-7.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt=""></div> -->
              </div>
            </div>

          </div>

        </section><!-- /Clients Section -->

        <!-- About Section -->
        <section id="sobre_sdr" class="about section">

          <!-- Section Title -->
          <div class="container section-title" data-aos="fade-up">
            <h2 class="">SDR</h2>
          </div><!-- End Section Title -->

          <div class="container">

            <div class="row gy-4">

              <div class="col-lg-12 content" data-aos="fade-up" data-aos-delay="100">
                <p>
                  SDR - Secretaria de Desenvolvimento Rural
                </p>
                <ul>
                  <li><i class="bi bi-check2-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo
                      consequat.</span></li>
                  <li><i class="bi bi-check2-circle"></i> <span>Duis aute irure dolor in reprehenderit in voluptate
                      velit.</span></li>
                  <li><i class="bi bi-check2-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo</span></li>
                </ul>
              </div>



            </div>

          </div>

        </section><!-- /About Section -->

        <!-- Why Us Section -->

        <section id="noticias" class="section why-us" data-builder="section">
          <div class="container-fluid">

            <div class="row gy-4">

              <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">

                <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
                  <h3 class=""><span class="">Últimas Notícias</span></h3>
                </div>
                <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">
                  <!-- {{noticias}} -->
                  <div class="faq-item" v-for="(i, index) in noticias">
                    <h3>
                      <span v-if="(index+1) < 10">0{{index+1}}</span>
                      <span v-if="(index+1) >= 10">{{index+1}}</span>
                      Dolor sit amet consectetur adipiscing elit pellentesque?
                    </h3>
                    <div class="faq-content">
                      <p>
                        Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar
                        elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque
                        eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis
                        sed odio morbi quis
                      </p>
                    </div>
                    <i class="faq-toggle bi bi-chevron-right"></i>
                  </div>

                  <div class="faq-item">
                    <h3><span>99</span> Ver todas as notícias</h3>
                    <div class="faq-content">
                      <input type="button" value="Ver todas as notícias" class="btn btn-sm btn-primary">
                    </div>
                    <i class="faq-toggle bi bi-chevron-right"></i>
                  </div> 

                  <div class="faq-item"  v-for="(i, index) in noticias">
                    <h3><span>99</span> Ver todas as notícias</h3>
                    <div class="faq-content">
                      <input type="button" value="Ver todas as notícias" class="btn btn-sm btn-primary">
                    </div>
                    <i class="faq-toggle bi bi-chevron-right"></i>
                  </div> 

                </div>

              </div>

              <div class="col-lg-5 order-1 order-lg-2 why-us-img align-top">
                <img src="assets/img/why-us.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="100">
              </div>
            </div>

          </div>
        </section><!-- /Why Us Section -->



        <!-- Skills Section -->
        <section id="aniversariantes" class="skills section">

          <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row">

              <div class="col-lg-6 d-flex align-items-center">
                <img src="assets/img/skills.png" class="img-fluid" alt="">
              </div>

              <div class="col-lg-6 pt-4 pt-lg-0 content">

                <h3>Aniversariantes do mês</h3>


                <div class="skills-content skills-animation">

                  <table class="table">
                    <tr>
                      <th>Data</th>
                      <th>Aniversariante</th>
                      <th>Lotação</th>
                    </tr>
                    <tr>
                      <td>
                        10/10
                      </td>
                      <td>
                        João da Silva
                      </td>
                      <td>
                        SDR/GAB/XYZ
                      </td>
                    </tr>
                    <tr>
                      <td>
                        10/10
                      </td>
                      <td>
                        João da Silva
                      </td>
                      <td>
                        SDR/GAB/XYZ
                      </td>
                    </tr>
                    <tr>
                      <td>
                        10/10
                      </td>
                      <td>
                        João da Silva
                      </td>
                      <td>
                        SDR/GAB/XYZ
                      </td>
                    </tr>
                  </table>

                </div>

              </div>
            </div>

          </div>

        </section><!-- /Skills Section -->

        <!-- Services Section -->
        <section id="sistemas" class="services section">
          <!-- Section Title -->
          <div class="container section-title" data-aos="fade-up">
            <h2>Sistemas</h2>
            <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
          </div><!-- End Section Title -->

          <div class="container">

            <div class="row gy-4">

              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-activity icon"></i></div>
                  <h4><a href="https://www.portalsema.ba.gov.br/_portal/Intranet/usuario" class="stretched-link">Portal
                      Gestor</a></h4>
                  <p>Portal de Sistemas da SDR</p>
                </div>
              </div>

              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                  <h4><a href="https://seibahia.ba.gov.br/" class="stretched-link">SEI</a></h4>
                  <p>Sistema Eletrônico de Informações </p>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                  <h4><a href="https://www.portalseibahia.saeb.ba.gov.br/pagina-acesso-externo" class="stretched-link">SEI
                      - ACESSO EXTERNO</a></h4>
                  <p>Sistema Eletrônico de Informações </p>
                </div>
              </div>

              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
                  <h4><a href="https://outlook.office365.com/mail/" class="stretched-link">Outlook</a></h4>
                  <p>O Microsoft Outlook é um sistema de software de gerenciamento de informações pessoais da Microsoft
                  </p>
                </div>
              </div>

              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="500">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                  <h4><a href="https://bahiater.sigater.ba.gov.br/_portal/Intranet/usuario" class="stretched-link">SIGATER</a></h4>
                  <p>Sistema de Aestão de Assistência Técnica e Extensão Rural</p>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="600">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                  <h4><a href="https://www.portalsema.ba.gov.br/intra_old/?model_ini=cadastro_formularios&pag=form_garantia_safra" class="stretched-link">GARANTIA SAFRA</a></h4>
                  <p>Termo de Adesão ao Seguro Garantia-Safra</p>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="700">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                  <h4><a href="https://www.portalsema.ba.gov.br/_portal/Sipaf/Produto" class="stretched-link">SIPAF</a></h4>
                  <p>Selo de Identificação da Participação da Agricultura Familiar</p>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="800">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                  <h4><a href="https://www.portalsema.ba.gov.br/_portal/AcervoDigital/obra/obra_buscador" class="stretched-link">Biblioteca Virtual</a></h4>
                  <p>A Biblioteca da Agricultura Familiar valoriza a produção acadêmica e experimental baiana</p>
                </div>
              </div>

              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="900">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                  <h4><a href="https://www.portalsema.ba.gov.br/_portal/Formater/curso/todos_cursos" class="stretched-link">FORMATER</a></h4>
                  <p>O FORMATER é o programa de formação da BAHIATER</p>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="1000">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                  <h4><a href="https://dool.egba.ba.gov.br/" class="stretched-link">Diário Oficial</a></h4>
                  <p>Diário Oficial do Estado da BAHIA</p>
                </div>
              </div>

            </div>

          </div>

        </section><!-- /Services Section -->
        <section id="planilhas" class="services section">
          <!-- Section Title -->
          <div class="container section-title" data-aos="fade-up">
            <h2>Planilhas</h2>
            <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
          </div><!-- End Section Title -->

          <div class="container">

            <div class="row gy-4">

              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-activity icon"></i></div>
                  <h4><a href="https://www.portalsema.ba.gov.br/_portal/anexos/anexo_intranet/PORTAL_GESTOR_CADASTRO_DE_USUARIO.xlsx" class="stretched-link">Cadastro Gestor</a></h4>
                  <p>Planilha de cadastro</p>
                </div>
              </div>

              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                  <h4><a href="https://www.portalseibahia.saeb.ba.gov.br/service-desk-0" class="stretched-link">SEI</a>
                  </h4>
                  <p>Planilhas de cadastro, alteração de cargo, relotação, etc</p>
                </div>
              </div>


            </div>

          </div>

        </section><!-- /Services Section -->

        <!-- Call To Action Section -->
        <section id="call-to-action" class="call-to-action section" style="display: none;">

          <img src="assets/img/cta-bg.jpg" alt="">

          <div class="container">

            <div class="row" data-aos="zoom-in" data-aos-delay="100">
              <div class="col-xl-9 text-center text-xl-start">
                <h3>Call To Action</h3>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                  Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                  laborum.</p>
              </div>
              <div class="col-xl-3 cta-btn-container text-center">
                <a class="cta-btn align-middle" href="#">Call To Action</a>
              </div>
            </div>

          </div>

        </section><!-- /Call To Action Section -->

        <!-- Portfolio Section -->
        <section id="sipaf" class="portfolio section">
          <!-- Section Title -->
          <div class="container section-title" data-aos="fade-up">
            <h2>SIPAF/Produtos</h2>
            <p>Selo de Identificação de Produtos da Agricultura Familiar</p>
          </div><!-- End Section Title -->

          <div class="container">

            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

              <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                <li data-filter="*" class="filter-active">Todos</li>
                <li data-filter=".filter-app">Benidas</li>
                <li data-filter=".filter-product">Cereais</li>
                <li data-filter=".filter-branding">Doces</li>
                <li data-filter=".filter-branding">Horti-fruti</li>
                <li data-filter=".filter-branding">Pescado</li>
                <li data-filter=".filter-branding">Sementes</li>
                <li data-filter=".filter-branding">Carnes</li>
                <li data-filter=".filter-branding">Chocolate</li>
                <li data-filter=".filter-branding">Amêndoas</li>
                <li data-filter=".filter-branding">Pastas</li>
                <li data-filter=".filter-branding">Gelerias</li>
                <li data-filter=".filter-product">Mel</li>
                <li data-filter=".filter-product">Artesanato</li>
                <li data-filter=".filter-product">Conserva</li>
                <li data-filter=".filter-product">Borracha</li>
                <li data-filter=".filter-product">Temperos Frescos</li>
                <li data-filter=".filter-product">Artesanato</li>
                <li data-filter=".filter-product">Biscoitos</li>
                <li data-filter=".filter-app">Cachaça e derivados</li>
                <li data-filter=".filter-app">Fatinha</li>
                <li data-filter=".filter-app">Café</li>
                <li data-filter=".filter-app">Óleo</li>
                <li data-filter=".filter-app">Pães, bolos e derivados</li>
              </ul><!-- End Portfolio Filters -->

              <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                  <img src="assets/img/masonry-portfolio/masonry-portfolio-1.jpg" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4>App 1</h4>
                    <p>Lorem ipsum, dolor sit</p>
                    <a href="assets/img/masonry-portfolio/masonry-portfolio-1.jpg" title="App 1" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                  </div>
                </div><!-- End Portfolio Item -->

                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                  <img src="assets/img/masonry-portfolio/masonry-portfolio-2.jpg" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4>Product 1</h4>
                    <p>Lorem ipsum, dolor sit</p>
                    <a href="assets/img/masonry-portfolio/masonry-portfolio-2.jpg" title="Product 1" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                  </div>
                </div><!-- End Portfolio Item -->

                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                  <img src="assets/img/masonry-portfolio/masonry-portfolio-3.jpg" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4>Branding 1</h4>
                    <p>Lorem ipsum, dolor sit</p>
                    <a href="assets/img/masonry-portfolio/masonry-portfolio-3.jpg" title="Branding 1" data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                  </div>
                </div><!-- End Portfolio Item -->

                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                  <img src="assets/img/masonry-portfolio/masonry-portfolio-4.jpg" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4>App 2</h4>
                    <p>Lorem ipsum, dolor sit</p>
                    <a href="assets/img/masonry-portfolio/masonry-portfolio-4.jpg" title="App 2" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                  </div>
                </div><!-- End Portfolio Item -->

                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                  <img src="assets/img/masonry-portfolio/masonry-portfolio-5.jpg" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4>Product 2</h4>
                    <p>Lorem ipsum, dolor sit</p>
                    <a href="assets/img/masonry-portfolio/masonry-portfolio-5.jpg" title="Product 2" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                  </div>
                </div><!-- End Portfolio Item -->

                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                  <img src="assets/img/masonry-portfolio/masonry-portfolio-6.jpg" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4>Branding 2</h4>
                    <p>Lorem ipsum, dolor sit</p>
                    <a href="assets/img/masonry-portfolio/masonry-portfolio-6.jpg" title="Branding 2" data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                  </div>
                </div><!-- End Portfolio Item -->

                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                  <img src="assets/img/masonry-portfolio/masonry-portfolio-7.jpg" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4>App 3</h4>
                    <p>Lorem ipsum, dolor sit</p>
                    <a href="assets/img/masonry-portfolio/masonry-portfolio-7.jpg" title="App 3" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                  </div>
                </div><!-- End Portfolio Item -->

                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                  <img src="assets/img/masonry-portfolio/masonry-portfolio-8.jpg" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4>Product 3</h4>
                    <p>Lorem ipsum, dolor sit</p>
                    <a href="assets/img/masonry-portfolio/masonry-portfolio-8.jpg" title="Product 3" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                  </div>
                </div><!-- End Portfolio Item -->

                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                  <img src="assets/img/masonry-portfolio/masonry-portfolio-9.jpg" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4>Branding 3</h4>
                    <p>Lorem ipsum, dolor sit</p>
                    <a href="assets/img/masonry-portfolio/masonry-portfolio-9.jpg" title="Branding 2" data-gallery="portfolio-gallery-branding" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                  </div>
                </div><!-- End Portfolio Item -->

              </div><!-- End Portfolio Container -->

            </div>

          </div>

        </section><!-- /Portfolio Section -->

        <!-- Team Section -->
        <section id="gestores" class="team section">
          <!-- Section Title -->
          <div class="container section-title" data-aos="fade-up">
            <h2>Gestores</h2>
          </div><!-- End Section Title -->

          <div class="container">

            <div class="row gy-4">

              <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="team-member d-flex align-items-start">
                  <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
                  <div class="member-info">
                    <h4>Walter White</h4>
                    <span>Chief Executive Officer</span>
                    <p>Explicabo voluptatem mollitia et repellat qui dolorum quasi</p>
                    <div class="social">
                      <a href=""><i class="bi bi-twitter"></i></a>
                      <a href=""><i class="bi bi-facebook"></i></a>
                      <a href=""><i class="bi bi-instagram"></i></a>
                      <a href=""> <i class="bi bi-linkedin"></i> </a>
                    </div>
                  </div>
                </div>
              </div><!-- End Team Member -->

              <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="team-member d-flex align-items-start">
                  <div class="pic"><img src="assets/img/team/team-2.jpg" class="img-fluid" alt=""></div>
                  <div class="member-info">
                    <h4>Sarah Jhonson</h4>
                    <span>Product Manager</span>
                    <p>Aut maiores voluptates amet et quis praesentium qui senda para</p>
                    <div class="social">
                      <a href=""><i class="bi bi-twitter"></i></a>
                      <a href=""><i class="bi bi-facebook"></i></a>
                      <a href=""><i class="bi bi-instagram"></i></a>
                      <a href=""> <i class="bi bi-linkedin"></i> </a>
                    </div>
                  </div>
                </div>
              </div><!-- End Team Member -->

              <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                <div class="team-member d-flex align-items-start">
                  <div class="pic"><img src="assets/img/team/team-3.jpg" class="img-fluid" alt=""></div>
                  <div class="member-info">
                    <h4>William Anderson</h4>
                    <span>CTO</span>
                    <p>Quisquam facilis cum velit laborum corrupti fuga rerum quia</p>
                    <div class="social">
                      <a href=""><i class="bi bi-twitter"></i></a>
                      <a href=""><i class="bi bi-facebook"></i></a>
                      <a href=""><i class="bi bi-instagram"></i></a>
                      <a href=""> <i class="bi bi-linkedin"></i> </a>
                    </div>
                  </div>
                </div>
              </div><!-- End Team Member -->

              <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                <div class="team-member d-flex align-items-start">
                  <div class="pic"><img src="assets/img/team/team-4.jpg" class="img-fluid" alt=""></div>
                  <div class="member-info">
                    <h4>Amanda Jepson</h4>
                    <span>Accountant</span>
                    <p>Dolorum tempora officiis odit laborum officiis et et accusamus</p>
                    <div class="social">
                      <a href=""><i class="bi bi-twitter"></i></a>
                      <a href=""><i class="bi bi-facebook"></i></a>
                      <a href=""><i class="bi bi-instagram"></i></a>
                      <a href=""> <i class="bi bi-linkedin"></i> </a>
                    </div>
                  </div>
                </div>
              </div><!-- End Team Member -->

            </div>

          </div>

        </section><!-- /Team Section -->

        <!-- Pricing Section -->
        <section id="pricing" class="pricing section" style="display: none">

          <!-- Section Title -->
          <div class="container section-title" data-aos="fade-up">
            <h2>Pricing</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
          </div><!-- End Section Title -->

          <div class="container">

            <div class="row gy-4">

              <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="pricing-item">
                  <h3>Free Plan</h3>
                  <h4><sup>$</sup>0<span> / month</span></h4>
                  <ul>
                    <li><i class="bi bi-check"></i> <span>Quam adipiscing vitae proin</span></li>
                    <li><i class="bi bi-check"></i> <span>Nec feugiat nisl pretium</span></li>
                    <li><i class="bi bi-check"></i> <span>Nulla at volutpat diam uteera</span></li>
                    <li class="na"><i class="bi bi-x"></i> <span>Pharetra massa massa ultricies</span></li>
                    <li class="na"><i class="bi bi-x"></i> <span>Massa ultricies mi quis hendrerit</span></li>
                  </ul>
                  <a href="#" class="buy-btn">Buy Now</a>
                </div>
              </div><!-- End Pricing Item -->

              <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="pricing-item featured">
                  <h3>Business Plan</h3>
                  <h4><sup>$</sup>29<span> / month</span></h4>
                  <ul>
                    <li><i class="bi bi-check"></i> <span>Quam adipiscing vitae proin</span></li>
                    <li><i class="bi bi-check"></i> <span>Nec feugiat nisl pretium</span></li>
                    <li><i class="bi bi-check"></i> <span>Nulla at volutpat diam uteera</span></li>
                    <li><i class="bi bi-check"></i> <span>Pharetra massa massa ultricies</span></li>
                    <li><i class="bi bi-check"></i> <span>Massa ultricies mi quis hendrerit</span></li>
                  </ul>
                  <a href="#" class="buy-btn">Buy Now</a>
                </div>
              </div><!-- End Pricing Item -->

              <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="pricing-item">
                  <h3>Developer Plan</h3>
                  <h4><sup>$</sup>49<span> / month</span></h4>
                  <ul>
                    <li><i class="bi bi-check"></i> <span>Quam adipiscing vitae proin</span></li>
                    <li><i class="bi bi-check"></i> <span>Nec feugiat nisl pretium</span></li>
                    <li><i class="bi bi-check"></i> <span>Nulla at volutpat diam uteera</span></li>
                    <li><i class="bi bi-check"></i> <span>Pharetra massa massa ultricies</span></li>
                    <li><i class="bi bi-check"></i> <span>Massa ultricies mi quis hendrerit</span></li>
                  </ul>
                  <a href="#" class="buy-btn">Buy Now</a>
                </div>
              </div><!-- End Pricing Item -->

            </div>

          </div>

        </section><!-- /Pricing Section -->



        <!-- Contact Section -->
        <section id="contact" class="contact section">

          <!-- Section Title -->
          <div class="container section-title" data-aos="fade-up">
            <h2>Contato</h2>
            <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
          </div><!-- End Section Title -->

          <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

              <div class="col-lg-12">

                <div class="info-wrap">
                  <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                    <i class="bi bi-geo-alt flex-shrink-0"></i>
                    <div>
                      <h3>Endereço</h3>
                      <p>Endereço: 1ª Avenida Centro Administrativo da Bahia, 2 - Centro Administrativo da Bahia,
                        Salvador -
                        BA, 41745-000</p>
                    </div>
                  </div><!-- End Info Item -->

                  <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                    <i class="bi bi-telephone flex-shrink-0"></i>
                    <div>
                      <h3>Telefone</h3>
                      <p>71 xxxxx-xxxx</p>
                    </div>
                  </div><!-- End Info Item -->

                  <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                    <i class="bi bi-envelope flex-shrink-0"></i>
                    <div>
                      <h3>E-mail</h3>
                      <p>info@example.com</p>
                    </div>
                  </div><!-- End Info Item -->

                  <!-- <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus"
                frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe> -->
                </div>
              </div>

              <div class="col-lg-7" style="display: none;">
                <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                  <div class="row gy-4">

                    <div class="col-md-6">
                      <label for="name-field" class="pb-2">Your Name</label>
                      <input type="text" name="name" id="name-field" class="form-control" required="">
                    </div>

                    <div class="col-md-6">
                      <label for="email-field" class="pb-2">Your Email</label>
                      <input type="email" class="form-control" name="email" id="email-field" required="">
                    </div>

                    <div class="col-md-12">
                      <label for="subject-field" class="pb-2">Subject</label>
                      <input type="text" class="form-control" name="subject" id="subject-field" required="">
                    </div>

                    <div class="col-md-12">
                      <label for="message-field" class="pb-2">Message</label>
                      <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                    </div>

                    <div class="col-md-12 text-center">
                      <div class="loading">Loading</div>
                      <div class="error-message"></div>
                      <div class="sent-message">Your message has been sent. Thank you!</div>

                      <button type="submit">Send Message</button>
                    </div>

                  </div>
                </form>
              </div><!-- End Contact Form -->

            </div>

          </div>

        </section><!-- /Contact Section -->
      </div>
      <!-- end app -->
      <script>
        new Vue({
          el: '#appIntranet',
          data: {
            message: 'Olá, Vue.js!',
            controller: '<?= $controller ?>',
            carrossel: [],
            noticias: [ { "publicacao_id": "394", "publicacao_titulo": ".", "publicacao_dt_publicacao": "2023-02-15 00:00:00", "publicacao_img": "sipaf_novo211.jpg", "publicacao_corpo": null, "publicacao_st": "1", "publicacao_dt_criacao": "2023-02-15 00:00:00", "publicacao_dt_alteracao": null, "publicacao_tipo": "1", "publicacao_link": null, "ativo": "0", "flag_carrossel": "0" }, { "publicacao_id": "445", "publicacao_titulo": ".", "publicacao_dt_publicacao": "2024-03-08 00:00:00", "publicacao_img": "ID_MULHERES_SDR_INTRANET_copiar.jpg", "publicacao_corpo": null, "publicacao_st": "1", "publicacao_dt_criacao": "2024-03-08 00:00:00", "publicacao_dt_alteracao": null, "publicacao_tipo": "1", "publicacao_link": null, "ativo": "0", "flag_carrossel": "0" }, { "publicacao_id": "430", "publicacao_titulo": null, "publicacao_dt_publicacao": "2023-09-04 00:00:00", "publicacao_img": "WhatsApp_Image_2023-09-01_at_16.23.272.jpeg", "publicacao_corpo": null, "publicacao_st": "1", "publicacao_dt_criacao": "2023-09-04 00:00:00", "publicacao_dt_alteracao": null, "publicacao_tipo": "1", "publicacao_link": null, "ativo": "0", "flag_carrossel": "0" }, { "publicacao_id": "431", "publicacao_titulo": ".", "publicacao_dt_publicacao": "2023-09-04 00:00:00", "publicacao_img": "WhatsApp_Image_2023-08-31_at_10.36.21.jpeg", "publicacao_corpo": null, "publicacao_st": "1", "publicacao_dt_criacao": "2023-09-04 00:00:00", "publicacao_dt_alteracao": null, "publicacao_tipo": "1", "publicacao_link": null, "ativo": "0", "flag_carrossel": "0" } ],
          },
          methods: {
            ajax_consulta_publicacoes: async function(limit, flag_carrossel, campo) {
              if (campo == 'noticias') {
                this.noticias = [];
              }
              if (campo == 'carrossel') {
                this.carrossel = [];
              }

              let url = this.controller + "ajax_consulta_publicacoes/" +
                '?format=json' +
                '&limit=' + limit +
                '&flag_carrossel=' + flag_carrossel

              //  alert(url)
              let result = await fetch(url);
              let json = await result.json();

              if (campo == 'noticias') {
                this.noticias = json;
              }
              if (campo == 'carrossel') {
                this.carrossel = json;
              }
            },

          },
          mounted() {
            this.ajax_consulta_publicacoes(5, 1, 'carrossel')
            // this.ajax_consulta_publicacoes(4, 0, 'noticias')
          },
        })
      </script>
    </main>

    <footer id="footer" class="footer">


      <div class="container footer-top">
        <div class="row gy-4">






          <div class="col-lg-4 col-md-12">
            <h4>Redes Sociais</h4>
            <div class="social-links d-flex">
              <!-- <a href=""><i class="bi bi-twitter"></i></a> -->
              <a href="https://www.facebook.com/sdrbahia"><i class="bi bi-facebook"></i></a>
              <a href="https://www.instagram.com/sdrbahia/"><i class="bi bi-instagram"></i></a>
              <!-- <a href=""><i class="bi bi-linkedin"></i></a> -->
            </div>
          </div>

        </div>
      </div>

      <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">SDR</strong> <span>All Rights Reserved</span></p>
        <div class="credits">

        </div>
      </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
  </div>
</body>




</html>