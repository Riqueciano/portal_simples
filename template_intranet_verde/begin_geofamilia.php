<?php //include '../template_intranet/begin.php'; 
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

<!-- Bootstrap 3 CSS com Glyphicons -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!-- Adicionando Vue.js -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>

<body class="index-page">
  <!--###app###-->
  <div>
  <header id="header" class="header d-flex align-items-center fixed-top"
      style="background: rgba(239, 235, 235, 0.25); backdrop-filter: blur(10px);">
      <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="<?= site_url('intranet') ?>" class="logo d-flex align-items-center me-auto">
          <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/sigaf/pagina-sobre/img/Logo-sigaf.png" alt="" style="width:100%">
          <b style="color: white;">VEREDA</b>
        </a>
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><b><a href="<?= LINK_SIGAF ?>" style="color: white;">Voltar</a></b></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </header>

    <main class="main">
      <div id='appIntranet'>
        <!-- Hero Section -->

        <br>
        <br>
        <br>
        <br>
        <br>

        <!-- Contact Section -->
        <section id="conteudo" class="contact section" style="width: 100%; padding: 0; margin: 0;">
          <div style="width: 100%; padding: 0; margin: 0;" data-aos="fade-up" data-aos-delay="100">

            <div class="row" style="width: 100%; margin: 0;">
 
               
                     