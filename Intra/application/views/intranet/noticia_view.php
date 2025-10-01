<?php
$iPATH = $_SERVER['HTTP_HOST'] . "/_portal//";
$upload_path  = 'https://' . $_SERVER['HTTP_HOST'] . '/_portal/anexos/anexo_intranet/';






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
  <link href="https://www.portalsema.ba.gov.br/sipaf/template/img/favicon.png" rel="icon">
  <link href="<?= ASSETS ?>/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= ASSETS ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= ASSETS ?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= ASSETS ?>/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= ASSETS ?>/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= ASSETS ?>/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="<?= ASSETS ?>/assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Arsha
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Updated: May 13 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->




  <!-- Adicionando Vue.js -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>

<body class="index-page">
  <!--###app###-->
  <div>
    <header id="header" class="header d-flex align-items-center fixed-top">
      <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="<?= site_url('intranet') ?>" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/brasao_completo.png" alt="" style="width:100%">
          <!-- <h1 class="sitename">SDR</h1> -->
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>

            <li class="dropdown"><a href="<?= site_url('intranet') ?>"><span>Voltar</span> </a>

            </li>


            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <!-- <a class="btn-getstarted" href="#about">Get Started</a> -->

      </div>
    </header>

    <main class="main">
      <div id='appIntranet'>

        <br>
        <br>
        <br>


        <!-- Contact Section -->
        <section id="noticia" class="contact section">

          <!-- Section Title -->
          <div class="container section-title">
            <h2><i class="bi bi-newspaper flex-shrink-0"></i> {{publicacao.publicacao_titulo}}</h2>
            <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
          </div><!-- End Section Title -->

          <div class="container">

            <div class="row gy-4">

              <div class="col-lg-12">
                <div class="info-wrap">
                  <div class="info-item d-flex">
                    <!-- <i class="bi bi-newspaper flex-shrink-0"></i> -->
                    <div class="row justify-content-center align-items-center">
                      <!-- <h3>Endereço</h3> -->
                      <img :src="'<?= iPATH ?>' + publicacao.publicacao_img" alt="" style="width: 60%; border-radius: 5px;">
                      <br>
                      <br>
                      <p style="text-align: justify; white-space: pre-line;">
                        {{publicacao.publicacao_corpo}}
                      </p>


                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </section>


      </div>
      <!-- end app -->
      <script>
        new Vue({
          el: '#appIntranet',
          data: {

            publicacao: <?= $publicacao ?>,
          },
          methods: {
            formataTexto: function() {

              // let div_noticia = $('#div_noticia').html()

              // const textoComBr = div_noticia.replace('\n', '<br>');
              // document.getElementById('div_noticia').innerHTML = textoComBr;
            }
          },
          mounted() {
            // this.formataTexto();
          },
        })
      </script>
    </main>




    <?php include '../template_intranet_verde/end.php'; ?>