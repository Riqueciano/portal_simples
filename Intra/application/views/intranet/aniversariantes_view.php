<?php
$iPATH = $_SERVER['HTTP_HOST'] . "/_portal//";
$upload_path  = 'https://' . $_SERVER['HTTP_HOST'] . '/_portal/anexos/anexo_intranet/';






$controller = "https://" . $_SERVER['HTTP_HOST'] . '/_portal/intranet/publicacao/';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <style>
    body {
      background-color: white !important;
    }

    #aniversariantes {
      background-color: white !important;
    }
  </style>

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
        <!-- Hero Section -->

        <br>
        <br>
        <br>

        <!-- Contact Section -->
        <section id="aniversariantes" class="contact section">
          <!-- Section Title -->
          <div class="container section-title" data-aos="fade-up">

            <h2 v-if="+mes_fim == mes">Aniversariantes do Mês de {{mes_nm}}</h2>
            <h2 v-else>Todos os Aniversariantes</h2>
            <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
          </div><!-- End Section Title -->

          <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

              <div class="col-lg-12">

                <div class="info-wrap">
                  <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                    <i class="bi bi-cake2"></i>
                    <div class="row justify-content-center align-items-center">
                      <p style="text-align: justify;">

                      <table class="table" style="font-size: 12px; width: 100%">
                        <tr>
                          <th style="width: 10%;">Data</th>
                          <th style="width: 50%;">Aniversariantes</th>
                          <th style="width: 40%;">Lotação</th>
                          <th style="width: 40%;">E-mail</th>
                        </tr>
                        <tr v-for="(i, key) in aniversariantes_hoje" v-show="aniversariantes_hoje.length > 0">
                          <td style="color: red;">
                            <span class="badge badge-secondary">
                              <div v-if="+mes_fim == mes">{{i.dia +'/'+i.mes}}</div>
                              <div v-else>{{i.dia +'/'+i.mes}}</div>
                            </span>

                          </td>
                          <td style="color: red;">
                            {{i.pessoa_nm}}
                          </td>
                          <td style="color: red;">
                            {{i.est_organizacional_sigla}}
                          </td>
                          <td style="color: red;">
                          <div v-if="validarEmail(i.funcionario_email)">{{i.funcionario_email?.toUpperCase()}}</div>
                          <div v-else>-</div>
                          </td>
                        </tr>

                        <tr v-for="(i, key) in aniversariante_mes">
                          <td>

                            <div v-if="+mes_fim == mes">{{i.dia +'/'+i.mes}}</div>
                            <div v-else>{{i.dia +'/'+i.mes}}</div>

                          </td>
                          <td>
                            {{i.pessoa_nm}}
                          </td>
                          <td>
                            {{i.est_organizacional_sigla}}
                          </td>
                          <td>
                             <div v-if="validarEmail(i.funcionario_email)">{{i.funcionario_email?.toUpperCase()}}</div>
                             <div v-else>-</div>
                          </td>
                        </tr>
                      </table>


                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <a href="<?= site_url('intranet/aniversariantes_todos/#aniversariantes_todos') ?>" v-if="+mes_fim == mes">
                <input type="button" value="Ver todos" class="btn btn-min btn-danger">
              </a>
              <a href="<?= site_url('intranet/aniversariantes/#aniversariantes') ?>" v-else>
                <input type="button" value="Voltar" class="btn btn-min btn-warning">
              </a>



            </div>
          </div>
        </section>


      </div>
      <!-- end app -->
      <script>
        new Vue({
          el: '#appIntranet',
          data: {

            mes: <?= (int)date('m') ?>,
            mes_nm: '<?= $mes_nm ?>',
            mes_ini: <?= (int)$mes_ini ?>,
            mes_fim: <?= (int)$mes_fim ?>,
            aniversariante_mes: <?= $aniversariante_mes ?>,
            aniversariantes_hoje: <?= $aniversariantes_hoje ?>,
          },
          methods: {
            validarEmail(email) {
              const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
              return regex.test(email);
            },

          },
          mounted() {
            // this.ajax_consulta_publicacoes(5, 1, 'carrossel')
            // this.ajax_consulta_publicacoes(4, 0, 'noticias')
          },
        })
      </script>
    </main>



    <?php include '../template_intranet_verde/end.php'; ?>