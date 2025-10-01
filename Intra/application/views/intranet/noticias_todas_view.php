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

        <a href="<?=site_url('intranet')?>" class="logo d-flex align-items-center me-auto">
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
          <div class="container section-title" data-aos="fade-up">
            <h2>Notícias</h2>
            <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
          </div><!-- End Section Title -->

          <div class="container">

            <div class="row gy-4">

              <div class="col-lg-12">

                <div class="info-wrap">
                  <div class="info-item d-flex">
                    <i class="bi bi-newspaper flex-shrink-0"></i>
                    <div class="row justify-content-center align-items-center">
                      <!-- <h3>Endereço</h3> -->

                      <p style="text-align: justify;">

                      <div v-for="(i, index) in noticias" class="card" style="width: 18rem;">
                        <a :href="'<?= site_url('intranet/noticia/') ?>' + i.publicacao_id + '#noticia'">
                          <div class="card-header" style=" font-size: 12px">

                            <div class="row">
                              <div class="col-lg-6">
                                <img :src="'<?= iPATH ?>' + i.publicacao_img" alt="" style="width: 100%; border-radius: 5px;" v-if="!i.publicacao_img_min">
                                <img :src="'<?= iPATH ?>' + i.publicacao_img_min" alt="" style="width: 100%; border-radius: 5px;"  v-if="i.publicacao_img_min">
                              </div>
                              <div class="col-lg-6">
                                <b> {{dataToDb(i.publicacao_dt_publicacao)}} </b>
                                <br>
                                {{i.publicacao_titulo}}


                              </div>
                            </div>
                          </div>
                        </a>
                      </div>
                      </p>
                    </div>
                  </div><!-- End Info Item -->



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

            noticias: <?= $noticias ?>,
          },
          methods: {
            dataToDb: function(dataAmericana) {
              // Verifica se a data foi passada
              if (!dataAmericana) {
                return "";
              }

              // Divide a string da data em partes
              var partes = dataAmericana.split(' ');

              // Pega a parte da data (sem a hora)
              var dataParte = partes[0];

              // Separa o ano, mês e dia
              var [ano, mes, dia] = dataParte.split('-');

              // Formata a data no padrão brasileiro
              var dataBrasileira = dia + '/' + mes + '/' + ano;

              return dataBrasileira;
            }
          },
          mounted() {
            // this.ajax_consulta_publicacoes(5, 1, 'carrossel')
            // this.ajax_consulta_publicacoes(4, 0, 'noticias')
          },
        })
      </script>
    </main>

     

    <?php include '../template_intranet_verde/end.php'; ?>