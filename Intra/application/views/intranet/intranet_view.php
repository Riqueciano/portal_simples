<?php include '../template_intranet_verde/begin.php'; ?>


 
<link rel="stylesheet" href="<?= base_url('assets/css/intranet_view.css') ?>">

<title>SDR | Secretaria de Desenvolvimento Rural</title>
<meta name="description" content="Site oficial da Secretaria de Desenvolvimento Rural da Bahia. Acompanhe nossos programas, ações e notícias sobre o desenvolvimento rural sustentável.">
<meta name="keywords" content="SDR, Secretaria de Desenvolvimento Rural, Bahia, agricultura, agricultura familiar, agricultura familiar sustentável">
<meta name="author" content="Secretaria de Desenvolvimento Rural da Bahia">
<meta name="robots" content="index, follow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<body class="index-page service-container">
  <!--div class="bandeirolas" >
    <svg class="corda-svg" width="100%" height="60">
      <path d="M0,30 
             C 20% 10, 40% 50, 60% 10, 80% 50, 100% 30"
        stroke="#8B4513" stroke-width="4" fill="transparent" />
    </svg>

    <div class="corda">
      <div class="bandeirinha" style="background-color: #FF4C4C;"></div>
      <div class="bandeirinha" style="background-color: #FFD93D;"></div>
      <div class="bandeirinha" style="background-color:rgb(17, 119, 17);"></div>
      <div class="bandeirinha" style="background-color:rgb(8, 67, 168);"></div>
      <div class="bandeirinha pc-only" style="background-color: #FF4C4C;"></div>
      <div class="bandeirinha pc-only" style="background-color: #FFD93D;"></div>
      <div class="bandeirinha pc-only" style="background-color:rgb(17, 119, 17);"></div>
      <div class="bandeirinha pc-only" style="background-color:rgb(8, 67, 168);"></div>
    </div>
  </div>-->

  <main class="main">
    <div id='appIntranet'>
      <div>
        <button @click="toggleMenu" class="botao-menu">
          <i class="bi bi-list"></i>
        </button>

        <nav
          class="menu-flutuante"
          v-show="menuAberto">
          <ul>
            <li class="dropdown">
              <a href="#hero">Início</a>
            </li>
            <li class="dropdown">
              <a href="#sistemas">Utilitários</a>
            </li>
            <li class="dropdown">
              <a href="#agricultura_familiar_servicos">Serviços</a>
            </li>
            <li class="dropdown">
              <a href="#planilhas">Planilhas/Tutoriais</a>
            </li>
            <li class="dropdown">
              <a href="#espaco_do_servidor">Espaço do Servidor</a>
            </li>
            <li class="dropdown">
              <a href="#contact">Contato</a>
            </li>
          </ul>
        </nav>
      </div>



      <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

          <!-- Logo (lado esquerdo) -->
          <a href="<?= site_url('intranet') ?>" class="logo d-flex align-items-center">
            <img src="https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/brasao_completo.png" alt="Logo" style="width:100%" />
          </a>



          <!-- Menu (nav) -->
          <nav class="navmenu" id="navmenu">
            <ul>
              <li><a href="#hero">Início</a></li>
              <li><a href="#sistemas">Utilitários</a></li>
              <li><a href="#agricultura_familiar_servicos">Serviços</a></li>
              <li><a href="#planilhas">Planilhas/Tutoriais</a></li>
              <li><a href="#espaco_do_servidor">Espaço do Servidor</a></li>

              <li class="dropdown">
                <a href="#" @click.prevent="toggleDropdown('link')" class="dropdown-toggle">
                  Link <i class="bi bi-chevron-down"></i>
                </a>
                <ul v-if="dropdownOpen === 'link'" class="dropdown-menu">
                  <li><a href="https://www.sdr.ba.gov.br/" target="_blank">SDR</a></li>
                  <li><a href="https://www.sda.sdr.ba.gov.br/" target="_blank">SDA</a></li>
                  <li><a href="https://www.car.ba.gov.br/" target="_blank">CAR</a></li>
                  <li><a href="https://www.bahiater.sdr.ba.gov.br/" target="_blank">BAHIATER</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" @click.prevent="toggleDropdown('contato')" class="dropdown-toggle">
                  Contato <i class="bi bi-chevron-down"></i>
                </a>
                <ul v-if="dropdownOpen === 'contato'" class="dropdown-menu">
                  <li><a href="#contact">Contato</a></li>
                  <li><a href="https://www.portalsema.ba.gov.br/_portal/Ramais/ramais" target="_blank">Ramais - Servidores SDR</a></li>
                </ul>
              </li>
            </ul>
          </nav>

        </div>
      </header>


      <!-- Hero Section -->
      <section id="hero" class="hero section">

        <div class="container" style="top:-1px !important">
          <div class="row gy-4">
            <!-- Conteúdo Principal -->
            <div class="col-lg-9 col-md-8 col-sm-12 d-flex justify-content-center align-items-start">
              <div class="text-align" style="width: 100%;">
                <div class="container px-5">
                  <div class="row gx-5 align-items-start"> <!-- Aqui também: align-items-start -->
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
                      <div class="carousel-inner">
                        <div v-for="(i, index) in carrossel" :class="'carousel-item ' + (index === 0 ? 'active' : '')">
                          <div class="d-flex justify-content-center">
                            <!-- Link externo, se existir -->
                            <a :href="i.publicacao_link" target="_blank" v-if="i.publicacao_link" style="display: inline-block;">
                              <img :src="'<?= iPATH ?>' + i.publicacao_img"
                                alt="Imagem"
                                style="border-radius: 20px; max-height: 500px; max-width: 100%; object-fit: cover; display: block;">
                            </a>

                            <!-- Apenas imagem -->
                            <img v-else
                              :src="'<?= iPATH ?>' + i.publicacao_img"
                              alt="Imagem"
                              style="border-radius: 20px; max-height: 500px; max-width: 100%; object-fit: cover; display: block;">

                            <!-- ID escondido -->
                            <div style="display: none;">{{ i.publicacao_id }}</div>
                          </div>
                        </div>
                      </div>

                      <!-- Removido padding-top -->
                      <div class="text-align mt-3">
                        <div class="card" style="width: 100%; background-color:#5F7557; color: #FFFFFF">
                          <div class="card-header text-center">
                            <a href="<?= site_url('intranet/aniversariantes/#aniversariantes') ?>" v-show="aniversariantes_hoje.length > 0">
                              <b style="color: white">
                                <i class="bi bi-cake2"></i>
                                HOJE TEMOS {{ numeroPorExtenso(aniversariantes_hoje.length) }} ANIVERSARIANTE(S)
                                <i class="bi bi-cake2"></i>
                              </b>
                            </a>
                            <a href="<?= site_url('intranet/aniversariantes/#aniversariantes') ?>" v-show="aniversariantes_hoje.length == 0">
                              <b style="color: white">
                                <i class="bi bi-cake2"></i>
                                ANIVERSARIANTE(S) DO MÊS DE {{ mes_nm?.toUpperCase() }}
                                <i class="bi bi-cake2"></i>
                              </b>
                            </a>
                          </div>
                        </div>
                      </div>

                      <!-- Botões de navegação -->
                      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Próximo</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>




            <!-- Conteúdo Lateral -->
            <div class="col-lg-3 col-md-4 col-sm-12 d-flex justify-content-center align-items-start">

              <div class="text-align">
                <div class="card-header" style="color: #FFFFFF; font-size: 12px">

                  <div>
                    <div class="cartao-instagram">
                      <blockquote
                        class="instagram-media"
                        data-instgrm-permalink="https://www.instagram.com/sdrbahia/"
                        data-instgrm-version="14">
                      </blockquote>
                    </div>


                    <script async src="//www.instagram.com/embed.js"></script>

                  </div>
                </div>

              </div>
            </div>



          </div>
      </section>




      <!-- Services Section -->
      <section id="sistemas" class="services section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Utilitários</h2>
          <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
        </div><!-- End Section Title -->

        <div class="container">
          <div class="row gy-4">
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Intranet/usuario" class="stretched-link"
                  style="color: white !important"
                  target="_blank">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/pasta3.png" style="max-width: 70px; !important">
                  </div>
                  <h4 class="titulo_icone">
                    Sistema Gestor
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://rhbahia.ba.gov.br/" class="stretched-link"
                  style="color: white !important"
                  target="_blank">
                  <div class="icon">
                    <!-- <img src="https://rhbahia.ba.gov.br/sites/all/themes/rhbahia/logo.png" alt="Início" > -->
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-RH-BAHIA.png">
                  </div>
                  <h4 class="titulo_icone">
                    RH Bahia / Diárias</h4>

                </a>
              </div>
            </div>
            
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://sd.produs.com.br/index.php?noAUTO=1" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon" style="color: red">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-PRODUS.png">
                  </div>
                  <h4 class="titulo_icone">
                    Informática PRODUS
                </a></h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://frequenciabahia.ba.gov.br/#/" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon" style="color: red">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-FREQUENCIA-BAHIA.png" alt="Brasao do estado da Bahia">
                  </div>
                  <h4 class="titulo_icone">
                    Frequência Bahia
                </a>
                </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://outlook.office365.com/mail/" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon" style="color: red">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-OUTLOOK.png" alt="Outlook">
                  </div>
                  <h4 class="titulo_icone">
                    Outlook
                  </h4>
                </a>
              </div>
            </div> 

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative ">
                <a href="https://www.portalsema.ba.gov.br/_portal/Ramais/ramais" target="_blank" class="stretched-link" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-RAMAIS.png" alt="Outlook">
                  </div>
                  <h4 class="titulo_icone">
                    Ramais
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="<?= site_url('intranet/aniversariantes/#aniversariantes') ?>" class="stretched-link" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-ANIVERSARIOS.png" alt="Outlook">
                  </div>
                  <h4 class="titulo_icone">
                    Aniversariantes
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://seibahia.ba.gov.br/" class="stretched-link" target="_blank" style="color: white !important">
                  <!-- <div class="icon"><i class="bi bi-chat-left-quote"></i></div> -->
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-ACESSO-SEI.png">
                  </div>
                  <h4 class="titulo_icone">
                    SEI
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://www.portalseibahia.saeb.ba.gov.br/pagina-acesso-externo" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-ACESSO EXTERNO-SEI.png">
                  </div>
                  <h4 class="titulo_icone">
                    SEI - Acesso Externo
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://painelbisei.saeb.ba.gov.br/#/" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/bi.png" style="max-width: 60px; !important">
                  </div>
                  <h4 class="titulo_icone">
                    BI SEI
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex " data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://bahiater.sigater.ba.gov.br/_portal/Intranet/usuario" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-SIGATER.png">
                  </div>
                  <h4 class="titulo_icone">
                    SIGATER
                  </h4>
                </a>

              </div>
            </div> 
          </div>

        </div>

      </section>
      <section id="agricultura_familiar_servicos" class="services section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Serviços</h2>
          <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
        </div><!-- End Section Title -->

        <div class="container">
          <div class="row gy-4">            

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">

                <h4 class="titulo_icone"><a href="<?= site_url('intranet/cotacao_cadastro/#cadastro') ?>" class="stretched-link" target="_blank">
                    <div class="icon">
                      <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-COTACAO-RURAL.png" style="max-width: 90px; !important">
                    </div>
                  </a>
                  Cotação Rural Bahia
                </h4>

              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="<?= site_url('intranet/mudas_sementes_cadastro/#cadastro') ?>" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-MUDAS-E-SEMENTES.png">
                  </div>
                  <h4 class="titulo_icone">
                    Mudas & Sementes
                </a>
                </h4>
                </a>
              </div>
            </div>
             
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://www.portalsema.ba.gov.br/_portal/Rede_distribuicao/solicitante/create" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-ELETRIFICACAO-RURAL.png">
                  </div>
                  <h4 class="titulo_icone">
                    Eletrificação Rural na Bahia
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://www.portalsema.ba.gov.br/_portal/Garantia_safra_controle/solicitacao/create" target="_blank" class="stretched-link" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-GARANTIA-SAFRA.png">
                  </div>
                  <h4 class="titulo_icone">
                    Inscrição - Garantia Safra
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" title="Selo de Identificação da Participação da Agricultura Familiar"> 
              <div class="service-item position-relative">
                <a href="https://www.portalsema.ba.gov.br/_portal/Sipaf/Produto" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-SIPAF.png">
                  </div>
                </a>
                <h4 class="titulo_icone" >
                  SIPAF  
                </h4>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://www.portalsema.ba.gov.br/_portal/AcervoDigital/obra/obra_buscador" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-BIBLIOTECA-VIRTUAL.png">
                  </div>
                  <h4 class="titulo_icone">
                    Biblioteca Virtual
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://www.portalsema.ba.gov.br/_portal/Monitora_perda_abelha/ocorrencias/create" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/abelha-mao.png">
                  </div>
                  <h4 class="titulo_icone">
                    Monitoramento das Perdas de Abelhas
                  </h4>
                </a>
              </div>
            </div>

            <!-- <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
                <div class="service-item position-relative">
                  <div class="icon"><i class="bi bi-film"></i></div>
                  <h4><a href="https://www.portalsema.ba.gov.br/_portal/Formater/curso/todos_cursos" class="stretched-link" target="_blank">FORMATER</a></h4>
                  <p style='color: white'>O FORMATER é o programa de formação do BAHIATER</p>
                </div>
              </div> -->


          </div>

        </div>

      </section><!-- /Services Section -->
      <section id="planilhas" class="services section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Planilhas/Tutoriais</h2>
          <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
        </div><!-- End Section Title -->

        <div class="container">
          <div class="row gy-4">

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://www.portalsema.ba.gov.br/_portal/anexos_externos/tutoriais/cadastro_usuario_sei_sdr_externo.pdf" class="stretched-link" target="_blank" style="color: white !important">
                  <!-- <div class="icon" style="color: red"><i class="bi bi-info-square-fill"></i></div> -->
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-CADASTRO-EXTERNO-SEI.png">
                  </div>
                  <h4 class="titulo_icone">
                    Cadastro SEI - Externo
                  </h4>
                </a>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="http://www.portalseibahia.saeb.ba.gov.br/service-desk-0" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-CADASTRO-SERVIDORES.png">
                  </div>
                  <h4 class="titulo_icone">
                    Cadastro SEI - Servidores
                  </h4>
                </a>
              </div>
            </div>



            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative ">
                <a href="https://www.portalsema.ba.gov.br/_portal/anexos_externos/manual_recepcao_funcionarios.pdf" target="_blank" class="stretched-link" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-NOVOS-SERVIDORES.png">
                  </div>
                  <h4 class="titulo_icone">
                    Recepção novos Servidores
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative ">
                <a href="https://www.escolavirtual.gov.br/curso/74" target="_blank" class="stretched-link" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-CURSO-ONLINE.png">
                  </div>
                  <h4 class="titulo_icone">
                    Curso Online - SEI
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://www.portalseibahia.saeb.ba.gov.br/service-desk-0" target="_blank" class="stretched-link">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-PLANILHA-SEI.png">
                  </div>
                  <h4 class="titulo_icone">
                    Planilhas do SEI
                  </h4>
                </a>
              </div>
            </div>

            <!-- <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" v->
              <div class="service-item position-relative">
                <a href="https://www.portalseibahia.saeb.ba.gov.br/service-desk-0" target="_blank" class="stretched-link">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/excel.png" >
                  </div>
                  <h4 class="titulo_icone">
                    SEI
                  </h4>
                </a>
                <p>Planilhas de cadastro, alteração de cargo, relotação, etc</p>
              </div>
            </div> -->
          </div>
        </div>

      </section><!-- /Services Section -->
      <section id="espaco_do_servidor" class="services section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Espaço do Servidor</h2>
          <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
        </div><!-- End Section Title -->
        <div class="container">

          <div class="row gy-4">


            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://www.ba.gov.br/" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-PORTAL-GOVBA.png">
                  </div>
                  <h4 class="titulo_icone">
                    BA.GOV.BR
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://www.legislabahia.ba.gov.br/" target="_blank" class="stretched-link" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-LEGISLA-BAHIA.png">
                  </div>
                  <h4 class="titulo_icone">
                    Legisla.ba
                  </h4>
                </a>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative ">
                <a href="https://www.escolavirtual.gov.br/" target="_blank" class="stretched-link" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-ESCOLA VIRTUAL-GOVBR.png">
                  </div>
                  <h4 class="titulo_icone">
                    Escola Virtual GOV.BR
                  </h4>
                </a>

              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex " data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://www.planserv.ba.gov.br/planserv" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-PLANSERV.png">
                  </div>
                  <h4 class="titulo_icone">
                    PLANSERV
                  </h4>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://portaldefacilidades.ba.gov.br/" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-PRODEB.png">
                  </div>
                  <h4 class="titulo_icone">
                    Facilidades PRODEB
                  </h4>
                </a>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
              <div class="service-item position-relative">
                <a href="https://dool.egba.ba.gov.br/" class="stretched-link" target="_blank" style="color: white !important">
                  <div class="icon">
                    <img src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/intranet/ICONE-DIARIO-OFICIAL.png">
                  </div>
                  <h4 class="titulo_icone">
                    Diário Oficial
                  </h4>
                </a>
              </div>
            </div>

          </div>

        </div>

      </section><!-- /Services Section -->








      <!-- Contact Section -->
      <section id="contact" class="contact section div-contato">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Contato</h2>
          <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
        </div><!-- End Section Title -->

        <div class="container " data-aos="fade-up">
          <div class="row gy-4">
            <div class="col-lg-12">
              <div class="info-wrap">
                <div class="info-item d-flex" data-aos="fade-up">
                  <i class="bi bi-geo-alt flex-shrink-0"></i>
                  <div>
                    <h3>Endereço</h3>
                    <p>Endereço: 1ª Avenida Centro Administrativo da Bahia, 2 - Centro Administrativo da Bahia,
                      Salvador -
                      BA, 41745-000</p>
                  </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex" data-aos="fade-up">
                  <i class="bi bi-telephone flex-shrink-0"></i>
                  <div>
                    <h3>Telefone</h3>
                    <p>71 3115-6700</p>
                  </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex" data-aos="fade-up">
                  <i class="bi bi-envelope flex-shrink-0"></i>
                  <div>
                    <h3>E-mail</h3>
                    <p>ouvidoria@sdr.ba.gov.br</p>
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

          buscador: '',
          titulo_noticia_principal: '',
          imagem_noticia_principal: '',
          corpo_noticia_principal: '',
          colaboradores: [],
          controller: '<?= $controller ?>',
          mes_nm: '<?= $mes_nm ?>',
          carrossel: <?= $carrossel ?>,
          noticias: <?= $noticias ?>,
          noticias_top: <?= $noticias_top ?>,
          aniversariante_mes_todos: <?= $aniversariante_mes ?>,
          aniversariante_mes_menor: <?= $aniversariante_mes_menor ?>,
          aniversariantes_hoje: <?= $aniversariantes_hoje ?>,
          visivel_aniversariante_mes_todos: false,
          visivel_aniversariante_mes_menor: true,
          carregando: false,
          postagem_teste: "https://www.instagram.com/sdrbahia/reel/DJr5D8FvMtl/",
          isMenuOpen: false,
          dropdownOpen: null, // 'link' ou 'contato' ou null
          menuAberto: false,
          dropdownOpen: null


        },
        methods: {
          toggleMenu() {
            this.menuAberto = !this.menuAberto;
          },
          toggleDropdown(item) {
            this.dropdownOpen = this.dropdownOpen === item ? null : item;
          },
          sleep: async function(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
          },
          monta_noticia_maior: async function(noticia) {
            this.carregando = true
            this.titulo_noticia_principal = null
            this.imagem_noticia_principal = null
            this.corpo_noticia_principal = null
            await this.sleep(600)

            this.titulo_noticia_principal = noticia.publicacao_titulo?.toUpperCase()
            this.imagem_noticia_principal = '<?= $upload_path ?>publicacao/' + noticia.publicacao_img
            this.corpo_noticia_principal = noticia.publicacao_corpo
            this.carregando = false

          },



          ajax_buscar_colaboradores: async function() {
            this.colaboradores = [];
            let url = "<?= site_url('intranet/ajax_buscar_colaboradores/') ?>" +
              '?format=json' +
              '&buscador=' + this.buscador

            // alert(url);return false;

            // alert(url)
            let result = await fetch(url);
            let json = await result.json();
            this.colaboradores = json;
          },
          ajax_consulta_publicacoes: async function(limit, flag_carrossel, campo) {
            if (campo == 'noticias') {
              this.noticias = [];
            }
            if (campo == 'carrossel') {
              this.carrossel = [];
            }


            let url = "<?= site_url('publicacao/ajax_consulta_publicacoes/') ?>" +
              '?format=json' +
              '&limit=' + limit +
              '&flag_carrossel=' + flag_carrossel

            // alert(url)
            let result = await fetch(url);
            let json = await result.json();

            if (campo == 'noticias') {
              this.noticias = json;
            }
            if (campo == 'carrossel') {
              this.carrossel = json;
            }
          },
          numeroPorExtenso: function(numero) {
            const unidades = ["zero", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"];
            const especiais = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove"];
            const dezenas = ["", "", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
            const centenas = ["", "cento", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];

            if (numero === 0) return "zero";
            if (numero === 100) return "cem";

            function parteMenorQueMil(n) {
              let texto = "";

              const c = Math.floor(n / 100);
              const d = Math.floor((n % 100) / 10);
              const u = n % 10;

              if (c > 0) texto += centenas[c];

              if (d === 1) {
                if (texto) texto += " e ";
                texto += especiais[u];
              } else {
                if (d > 1) {
                  if (texto) texto += " e ";
                  texto += dezenas[d];
                }

                if (u > 0) {
                  if (texto) texto += " e ";
                  texto += unidades[u];
                }
              }

              return texto;
            }

            let resultado = "";

            const milhar = Math.floor(numero / 1000);
            const resto = numero % 1000;

            if (milhar > 0) {
              if (milhar === 1) {
                resultado += "mil";
              } else {
                resultado += parteMenorQueMil(milhar) + " mil";
              }
            }

            if (resto > 0) {
              if (resultado) resultado += resto < 100 ? " e " : ", ";
              resultado += parteMenorQueMil(resto);
            }

            return resultado?.toUpperCase();
          }

        },
        mounted() {

          // this.ajax_consulta_publicacoes(5, 1, 'carrossel')
          // this.ajax_consulta_publicacoes(4, 0, 'noticias')
          // alert()
        },
      })
    </script>
  </main>



  <?php include '../template_intranet_verde/end.php'; ?>
