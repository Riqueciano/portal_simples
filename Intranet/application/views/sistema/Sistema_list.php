<?php include_once '../template/_begin_sistema.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SDR</title>
    <script src="<?= iPATH ?>JavaScript/vue/vue3/vue3.5.13.global.prod.js" defer></script>
    <link rel="manifest" href="<?= iPATH ?>manifest.json">


</head>

<script>
    const CACHE_NAME = "meu-app-cache-v1";
    const urlsToCache = ["/", "/index.html", "/style.css", "/app.js"];

    self.addEventListener("install", (event) => {
        event.waitUntil(
            caches.open(CACHE_NAME).then((cache) => cache.addAll(urlsToCache))
        );
    });

    self.addEventListener("fetch", (event) => {
        event.respondWith(
            caches.match(event.request).then((resposta) => resposta || fetch(event.request))
        );
    });

    // window.addEventListener("online", () => alert("Conectado!"));
    // window.addEventListener("offline", () => alert("Sem conexão!"));
</script>

<style>
    [v-cloak] {
        display: none;
    }

    @media (max-width: 1280px) {
        .ocultar-ate-1281 {
            display: none !important;
        }

        #barra-titulo {
            height: 10px !important;
        }
    }
</style>


<div id="app" v-cloak>

    <body class="body-bg">
        <!--div class="ocultar-ate-1281">
            <div class="text-align div-instagram desktop-only ocultar-ate-1280" id="instagram-widget" v-if="janela_instragram == true">
                <div class="card-header">
                    Acompanhe nosso Instagram
                </div>
                <div class="cartao-instagram">
                    <blockquote
                        class="instagram-media"
                        data-instgrm-permalink="https://www.instagram.com/sdrbahia/"
                        data-instgrm-version="14">
                    </blockquote>
                    <script async src="//www.instagram.com/embed.js"></script>
                    <input type="button" value="Fechar" @click="janela_instragram = false" class="btn btn-sm btn-danger">
                </div>
            </div> 
        </div-->


        <div v-show="appCarregado == true">
            <h2 style="margin-top:0px"></h2>
            <div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12">
                            <div class="">
                                <div class="x_title row menu-topo" @mouseleave="showCalendar = false">
                                    <div class="col-md-3 col-sm-3 col-xs-3 position-relative flex" style="gap: 15px;" @mouseleave="showCalendar = false">
                                        <div style="width: 550px;">
                                            <div @mouseenter="menuAberto = true" @click="menuAberto = !menuAberto">
                                                <!-- <i class="glyphicon glyphicon-leaf folha" @mouseenter="menuAberto = true" @click="menuAberto = !menuAberto"></i> -->
                                                <img :src="imagem_logo_principal_old" class="icone-menu-topo"
                                                    @mouseenter="menuAberto = true"
                                                    @click="menuAberto = !menuAberto">
                                                <span style="padding-left: 15px;  color: white">
                                                    <p class="mobile-only">{{ nome }} ({{ usuario }})</p>
                                                    <p class="desktop-only">Bem Vindo(a) {{ usuario }} ao Portal de Sistemas SDR</p>
                                                </span>


                                            </div>

                                        </div>
                                    </div>

                                    <div class="menu-bar col-md-6 col-sm-6 col-xs-6 position-relative text-center">

                                        <div class="menu-item" v-show="janelaAberta == true">

                                            <div class="submenu" v-if="false">
                                                <div class="submenu-item">
                                                    <span style="color: white; " @click="AbrirPaginaInicial()">Página Inicial</span>
                                                </div>
                                                <div class="submenu-item">
                                                    <span style="color: white;" @click="atualizarIframe()">Atualizar Página </span>
                                                </div>
                                                <div class="submenu-item">
                                                    <span style="color: white;" @click="alterar_tela_cheia(1)">{{ isFullscreen ? 'Sair da Tela Cheia' : 'Tela Cheia' }}</span>
                                                </div>
                                                <div class="submenu-item">
                                                    <span style="color: white;" @click="voltarIframe()">Voltar</span>
                                                </div>
                                                <div class="submenu-item">
                                                    <span style="color: white;" @click="fecharJanela()">Fechar {{janela_titulo}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-for="(m, key) in menu" :key="key" class="menu-item" v-if="false">
                                            <i :class="m.secao_icone" style="margin-right: 10px;"></i>

                                            <span class="menu-item-text">{{ capitalizarPalavras(m.secao_ds) }}</span>

                                            <div class="submenu">
                                                <div v-for="(sm, smkey) in m.secao_menu" :key="smkey" class="submenu-item" @click="abrirJanelaPeloMenu(sm.sistema_url, sm.acao_url)">
                                                    <span style="color: white;">{{ capitalizarPalavras(sm.acao_ds) }} </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="calendar-container col-md-3 col-sm-3 col-xs-3 text-right"

                                        @mouseenter="showCalendar = true" @click="showCalendar = !showCalendar">
                                        <div
                                            style="cursor: pointer; color: white; display: inline-flex; align-items: center; white-space: nowrap;">
                                            <!-- <i class="glyphicon glyphicon-time" style="margin-right: 4px;"></i> -->
                                            <span style="padding: 5px;">

                                                <img src="<?= iPATH ?>Icones/clock.png" alt="" style="width: 20px; height: 20px;">
                                            </span>

                                            <span style="color: white; ">{{ horaAtual }}</span>
                                        </div>

                                        <div v-if="showCalendar" class="mini-calendar" @mouseleave="showCalendar = false">
                                            <div style="text-align:center; margin-bottom: 6px;">
                                                {{ monthNames[currentMonth] }} {{ currentYear }}
                                            </div>
                                            <table class="calendar-table">
                                                <thead>
                                                    <tr>
                                                        <th v-for="d in weekDays" :key="d">{{ d }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(week, wi) in calendarDays" :key="wi">
                                                        <td v-for="(day, di) in week" :key="di"
                                                            @click="selectDate(day)"
                                                            :class="{ selected: isSelected(day) }">
                                                            {{ day || '' }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <!-- Relógio fixo no canto superior direito -->

                                <div class="x_content " style="padding-top: 50px;">
                                    <div class="busca-container desktop-only">
                                        <div class="input-group busca-box" v-show="sistema_data.length > 10">
                                            <input
                                                id="buscador"
                                                type="text"
                                                class="form-control"
                                                v-model="busca"
                                                placeholder="Buscar">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <img src="https://www.portalsema.ba.gov.br/_portal/Imagens/Topo/brasao_completo.png" id="brasao" style="width: 300px;" class="desktop-only"> -->


                                    <div :class="janelaAberta ? 'desktop-area nao-clicavel' : 'desktop-area'">
                                        <ul class="desktop-listagem">
                                            <!-- <li v-for="(sistema, index) in sistema_data" class="desktop-icon" @click="abrirSistema(sistema.sistema_id)"> -->
                                            <li v-for="(sistema, index) in sistema_filtrado" class="desktop-icon" @click="abrirSistema(sistema.sistema_id, sistema.sistema_nm, 1, sistema.sistema_icone, sistema.sistema_url)">
                                                <div class="glyphicon-class">
                                                    <div class="icon-overlay"></div>
                                                    <img :src="'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/' + sistema.sistema_icone" alt="Ícone" class="img-responsive">
                                                    <span class="desktop-label" style="color: white"> {{ sistema.sistema_nm }}</span>
                                                </div>
                                            </li>.
                                            <!--li class="desktop-icon" v-show="sistema_filtrado.length > 2">
                                                <div class="glyphicon-class">
                                                    <a href="https://frequenciabahia.ba.gov.br/#/" target="_blank">
                                                        <div class="icon-overlay"></div>
                                                        <img :src="'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/frequencia_bahia.png'" alt="Ícone" class="img-responsive">
                                                        <span class="desktop-label" style="color: white"> Frequência Bahia</span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="desktop-icon" v-show="sistema_filtrado.length > 2">
                                                <div class="glyphicon-class">
                                                    <a href="https://rhbahia.ba.gov.br/" target="_blank">
                                                        <div class="icon-overlay"></div>
                                                        <img :src="'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/rh_bahia.png'" alt="Ícone" class="img-responsive">
                                                        <span class="desktop-label" style="color: white"> RH Bahia</span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="desktop-icon" v-show="sistema_filtrado.length > 2">
                                                <div class="glyphicon-class">
                                                    <a href="https://sd.produs.com.br/" target="_blank">
                                                        <div class="icon-overlay"></div>
                                                        <img :src="'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/produs.png'" alt="Ícone" class="img-responsive">
                                                        <span class="desktop-label" style="color: white"> Informática / Produs</span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="desktop-icon" v-show="sistema_filtrado.length > 2">
                                                <div class="glyphicon-class">
                                                    <a href="https://www.portalsema.ba.gov.br/_portal/Sipaf/Produto" target="_blank">
                                                        <div class="icon-overlay"></div>
                                                        <img :src="'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/intranet/ICONE-SIPAF.png'" alt="Ícone" class="img-responsive">
                                                        <span class="desktop-label" style="color: white"> SIPAF (site)</span>
                                                    </a>
                                                </div>
                                            </li-->
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="dock">
                    <a
                        class="dock-item"
                        v-for="(item, index) in dockIcons"
                        :key="index"
                        :href="item.url"
                        :target="item.target">
                        <img
                            :src="item.src"
                            :alt="item.name">
                        <span class="tooltip">{{ item.title }}</span>
                    </a>
                    <a class="dock-item mobile-only">
                        <img
                            :src="'<?= iPATH ?>Icones/expandir.png'"
                            @click="alterar_tela_cheia(null)">
                        <span class="tooltip">Usuário</span>
                    </a>
                </div>


            </div>
            <div id="loadingAnimation" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; overflow: hidden;">
                <div id="transitionEffect" style="position: absolute; top: 0; left: 0; width: 0; height: 100%; background: #fff; transition: width 0.5s;"></div>
            </div>
            <button class="fullscreen-btn desktop-only" @click="alterar_tela_cheia(null)">
                <img
                    :src="'<?= iPATH ?>Icones/expandir.png'"
                    style="width: 20px; height: 20px;"
                    title="Usuario"> {{ isFullscreen ? 'Sair da Tela Cheia' : 'Tela Cheia' }}
            </button>


            <!-- Janela modal tipo macOS -->
            <div>
                <div
                    id="janela-macos"
                    ref="janelaMacos"
                    class="janela-macos light"
                    :style="{ top: posY + 'px', left: posX + 'px' }"
                    @mousedown="trazerParaFrente">


                    <!-- Barra de título macOS -->
                    <div class="barra-titulo" @mousedown.prevent="iniciarArraste" style="padding-right: 200px;">
                        <div>
                            <div class="botoes" style="padding-left: 18px;">
                                <span class="botao fechar" @click="fecharJanela()" title="Fechar">
                                    <span class="x-fechar">x</span>
                                </span>
                                <span class="botao minimizar" @click="alterar_tela_cheia(0)" title="Minimizar"  >
                                    <span class="x-minimizar">-</span>
                                </span>
                                <span class="botao maximizar" @click="alterar_tela_cheia(1)" title="Maximizar"  >
                                    <span class="x-maximizar">+</span>
                                </span>

                                <span class="botao circulo-atualizar" @click="voltarIframe()" title="Voltar">
                                    <span class="">
                                        <b class="glyphicon glyphicon-arrow-left" style="padding-left: 1px; color:white; font-size: 8px;"></b>
                                    </span>
                                </span>
                                <span :class="carregandoIframe ? 'botao-girando circulo-atualizar' : 'botao circulo-atualizar'" @click="atualizarIframe()" title="Avançar">
                                    <span class="">
                                        <b :class="!carregandoIframe ? 'glyphicon glyphicon-repeat circular' : 'glyphicon glyphicon-repeat circular-girando'"></b>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div style="color: white; margin-left: 10px; width: 100px;white-space: nowrap;" @click="copia_url()"><b>{{ janela_titulo }} - {{ janela_perfil?.toLowerCase() }}</b></div>
                        <div class="menu-bar col-md-6 col-sm-6 col-xs-6 position-relative text-center">
                            <div class="menu-item" v-show="janelaAberta == true">
                                <img :src="imagem_logo_principal" class="icone-menu-topo" style="margin-right: 10px; "> <span style="color: white;"> Menu</span>
                                <div class="submenu">
                                    <div class="submenu-item">
                                        <span style="color: white; " @click="AbrirPaginaInicial()">Página Inicial</span>
                                    </div>
                                    <div class="submenu-item">
                                        <span style="color: white;" @click="atualizarIframe()">Atualizar Página </span>
                                    </div>
                                    <div class="submenu-item">
                                        <span style="color: white;" @click="alterar_tela_cheia(1)">{{ isFullscreen ? 'Sair da Tela Cheia' : 'Tela Cheia' }}</span>
                                    </div>
                                    <div class="submenu-item">
                                        <span style="color: white;" @click="voltarIframe()">Voltar</span>
                                    </div>
                                    <div class="submenu-item">
                                        <span style="color: white;" @click="fecharJanela()">Fechar {{janela_titulo}}</span>
                                    </div>
                                </div>
                            </div>
                            <div v-for="(m, key) in menu" :key="key" class="menu-item">
                                <i :class="m.secao_icone" style="margin-right: 10px;"></i>

                                <span class="menu-item-text">{{ capitalizarPalavras(m.secao_ds) }}</span>

                                <div class="submenu">
                                    <div v-for="(sm, smkey) in m.secao_menu" :key="smkey" class="submenu-item" @click="abrirJanelaPeloMenu(sm.sistema_url, sm.acao_url)">
                                        <span style="color: white;">{{ capitalizarPalavras(sm.acao_ds) }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="height: 100%; padding-right: 200px; border: 0px;" @click="copia_url()"> <small v-if="mostrarURL">{{ janela_url }}</small></div>
                    </div>


                    <!-- Conteúdo -->
                    <iframe
                        id="janela_iframe"
                        ref="iframe"
                        :src="urlSistema"
                        loading="lazy"
                        class="conteudo-iframe"
                        @load="iframeCarregadoSucesso()"
                        @error="tratarErroIframe"></iframe>
                </div>
            </div>

            <div class="logo_governo_vigente desktop-only" v-if="flag_imagem_visivel == true" style="position: relative; display: inline-block;">
                <!-- Bolinhas flutuando -->
                <div v-show="false">
                    <div
                        v-for="cor in cores"
                        :key="cor"
                        :style="{
                                width: '20px',
                                height: '20px',
                                borderRadius: '50%',
                                backgroundColor: cor,
                                cursor: 'pointer',
                                border: '2px solid #fff',
                                boxShadow: '0 0 5px rgba(0,0,0,0.3)'
                            }"
                        @click="mudarCorFundo(cor)">
                    </div>
                </div>

                <!-- Sua imagem -->
                <img src="<?= iPATH ?>Imagens/logo_governo_vigente.png" class="logo_governo_vigente">
            </div>


        </div>
    </body>
    <div v-if="carregandoIframe" class="loading-overlay">
        <b> Carregando..
            <!-- <img src="<?= iPATH ?>Icones/iphone-backup.png" alt="Loading" class="loading-gif" style="width: 200px; height: 200px;"></b> -->
    </div>

</div>


<script type="module">
    const {
        createApp,
        ref,
        reactive,
        onMounted
    } = Vue;


    import * as func from "<?= iPATH ?>JavaScript/func.js";

    const app = createApp({
        data() {
            const today = new Date();
            return {
                cores: [
                    '#2A4759',
                    '#A7C1A8',
                    '#80D8C3',
                    '#4DA8DA',
                    '#EAEBD0',
                    '#F79B72',
                    '#2A4759',
                ],
                carregandoIframe: true,
                janela_instragram: true,
                erroURLIframe: false,
                appCarregado: false,
                imagem_logo_principal: '<?= iPATH ?>Icones/folha2.png',
                imagem_logo_principal_old: '<?= iPATH ?>Icones/folha2.png',
                imagem_logo_saturno: '<?= iPATH ?>Icones/saturno.png',
                SECRETARIA_NOME: "<?= SECRETARIA_NOME ?>",
                SECRETARIA_SIGLA: "<?= SECRETARIA_SIGLA ?>",
                mostrarURL: false,
                flag_abrir_janela_ativo: true,
                flag_imagem_visivel: true,
                janelaAberta: false,
                janela_titulo: '',
                janela_url: '',
                urlSistema: '',
                janela_perfil: '',
                //posição inicial da janela
                posX: 150,
                posY: 30,
                offsetX: 0,
                offsetY: 0,

                width: 800,
                height: 600,
                redimensionando: false,
                direcaoRedimensionamento: null,
                mouseInicio: {
                    x: 0,
                    y: 0
                },
                tamanhoInicio: {
                    width: 0,
                    height: 0
                },

                arrastoAtivado: false,
                menuAberto: false,
                nome: '<?= $pessoa_nm_temp ?>',
                est_organizacional_lotacao_sigla: '<?= $_SESSION['est_organizacional_lotacao_sigla'] ?>',
                usuario: '<?= $usuario_login ?>',
                horaAtual: ref('00:00:00'),
                showCalendar: false,
                selectedDate: new Date(),
                currentMonth: today.getMonth(),
                currentYear: today.getFullYear(),
                weekDays: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
                monthNames: [
                    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                ],
                isFullscreen: false,
                busca: '',
                q: '<?= $q ?>',
                sistema_data: <?= $sistema_data ?>,
                HTTP_HOST: '<?= HTTP_HOST ?>',
                mouseX: null,
                animacao_loading: false,
                dockIcons: [

                    {
                        id: 0,
                        name: 'Portal SDR',
                        src: 'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/home.png',
                        url: 'https://www.portalsema.ba.gov.br/_portal/Intra/intranet',
                        target: '_blank',
                        title: 'Portal SDR',
                        abrir_janela: false
                    },
                    // {
                    //     id: 11,
                    //     name: 'SDR',
                    //     src: 'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/intranet/ICONE-PORTAL-GOVBA.png',
                    //     url: 'https://www.ba.gov.br/sdr/',
                    //     target: '_blank',
                    //     title: 'SDR',
                    //     abrir_janela: false
                    // },
                    {
                        id: 1,
                        name: 'Outlook',
                        src: 'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/outlook4.png',
                        url: 'https://outlook.office.com/owa/',
                        target: '_blank',
                        title: 'Outlook',
                        abrir_janela: false
                    },
                    // {
                    //     id: 1,
                    //     name: 'SIPAF',
                    //     src: 'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/selo_sipaf.png',
                    //     url: 'https://www.portalsema.ba.gov.br/_portal/Sipaf/Produto',
                    //     target: '_blank',
                    //     title: 'SIPAF'
                    // },
                    {
                        id: 3,
                        name: 'SEI - SERVIDORES',
                        src: 'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/sei_sem_fundo.png',
                        url: 'https://seibahia.ba.gov.br/',
                        target: '_blank',
                        title: 'SEI - SERVIDORES',
                        abrir_janela: false
                    },
                    {
                        id: 4,
                        name: 'Facilidades PRODEB',
                        src: 'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/portal_facilidades.png',
                        url: 'https://portaldefacilidades.ba.gov.br/',
                        target: '_blank',
                        title: 'Facilidades PRODEB',
                        abrir_janela: false
                    },
                    {
                        id: 3,
                        name: 'SEI - EXTERNO',
                        src: 'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/icones/intranet/ICONE-ACESSO EXTERNO-SEI.png',
                        url: 'https://seibahia.ba.gov.br/sei/controlador_externo.php?acao=usuario_externo_logar&id_orgao_acesso_externo=0',
                        target: '_blank',
                        title: 'SEI - EXTERNO',
                        abrir_janela: false
                    },




                    {
                        id: 5,
                        name: 'Trocar Senha',
                        src: 'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/pass.png',
                        url: '<?= site_url('usuario/acao_usuario_muda_senha') ?>',
                        target: '_self',
                        title: 'Trocar Senha',
                        abrir_janela: false
                    },
                    {
                        id: 6,
                        name: 'Sair',
                        src: 'https://' + '<?= $_SERVER['HTTP_HOST'] ?>' + '/_portal/Icones/sair.png',
                        url: '<?= site_url('usuario') ?>',
                        target: '_self',
                        title: 'Sair',
                        abrir_janela: false
                    },

                ],
                resolucao: '',
                menu: [],
                sistema_id_atual: '',
                sistema_nm_atual: '',
                carregar_menu_atual: 1,
                sistema_icone_atual: '',
                sistema_url_atual: ''
            }
        },
        mounted() {

            this.dockRef = this.$refs.dockRef;
            setInterval(this.atualizarRelogio, 1000)
            setInterval(() => this.atualizarUrlIframe(), 500);
            //this.alterar_tela_cheia();
            this.mostrarResolucao();
            this.appCarregado = true;
            this.bloquearCliquesRapidos();

            //ocultar depois de uns 3 minutos 
            setTimeout(() => {
                this.janela_instragram = false;
            }, 50000); //180000

        },
        computed: {
            sistema_filtrado: function() {
                const termo = this.busca.toLowerCase();
                return this.sistema_data.filter(s =>
                    s.sistema_nm.toLowerCase().includes(termo)
                );
            },
            calendarDays: function() {
                const days = [];
                const firstDay = new Date(this.currentYear, this.currentMonth, 1);
                const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
                const startWeekDay = firstDay.getDay(); // 0 (Dom) a 6 (Sáb)
                const totalDays = lastDay.getDate();

                let week = Array(startWeekDay).fill(null);
                for (let day = 1; day <= totalDays; day++) {
                    week.push(day);
                    if (week.length === 7) {
                        days.push(week);
                        week = [];
                    }
                }
                if (week.length) {
                    while (week.length < 7) week.push(null);
                    days.push(week);
                }

                return days;
            },
        },
        watch: {
            carregandoIframe: function() {
                setTimeout(() => {
                    this.menuAberto = false;
                }, 3000);
            },
            urlSistema: function(novo, antigo) {

                //se cair na url do sistema, redireciona para a tela de login
                if (novo == 'https://www.portalsema.ba.gov.br/_portal/Intra/intranet' ||
                    antigo == 'https://www.portalsema.ba.gov.br/_portal/Intra/intranet' ||
                    novo == 'https://www.localhost/_portal/Intra/intranet' ||
                    antigo == 'https://www.localhost/_portal/Intra/intranet' ||

                    novo == 'Acesso negado' ||
                    antigo == 'Acesso negado'
                ) {
                    alert('Sessão expirada, por gentileza faça login novamente');
                    window.location.href = '<?= site_url('usuario') ?>';
                }
            }
        },
        methods: {
            voltarIframe() {
                const iframe = document.getElementById('janela_iframe');
                if (iframe) {
                    try {
                        iframe.contentWindow.history.back();
                    } catch (e) {
                        // Ignora qualquer erro (ex: sem histórico, cross-origin, etc.)
                        console.warn('Não foi possível voltar no iframe:', e);
                    }
                }
            },


            iframeCarregadoSucesso() {
                // setTimeout(() => {
                this.carregandoIframe = false;

            },
            capitalizarPalavras(texto) {
                return texto
                    .toLowerCase()
                    .split(' ')
                    .map(palavra => palavra.charAt(0).toUpperCase() + palavra.slice(1))
                    .join(' ');
            },

            atualizarIframe: function() {
                const iframe = document.getElementById('janela_iframe');
                if (iframe) {
                    iframe.contentWindow.location.reload();
                }
            },
            chamarDeepSeek: async function() {

                let prompt = prompt("informe sua pergunta")
                const response = await fetch("https://api.deepseek.com/v1/chat/completions", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer SUA_API_KEY"
                    },
                    body: JSON.stringify({
                        model: "deepseek-chat", // ou outro nome de modelo
                        messages: [{
                            role: "user",
                            content: prompt
                        }]
                    })
                });

                const data = await response.json();
                // console.log(data.choices[0].message.content);
            },
            copia_url: function() {
                this.mostrarURL = !this.mostrarURL;
                navigator.clipboard.writeText(this.janela_url)
                    //   .then(() => alert('URL copiada!'))
                    .catch(err => alert('Erro ao copiar: ' + err));
            },

            //pega o url da pagina e atualiza no topo do iframe/jenela
            atualizarUrlIframe: function() {
                const iframe = document.getElementById('janela_iframe');

                try {
                    const urlAtual = iframe.contentWindow.location.href;
                    this.janela_url = ' ' + urlAtual;
                } catch (e) {
                    this.janela_url = "Acesso negado (domínio diferente)";
                }
            },
            ajax_verifica_logado: async function() {
                let url = '<?= site_url('usuario/ajax_verifica_logado') ?>';
                try {
                    let result = await fetch(url);
                    let json = await result.json();
                    if (json.logado == false) {
                        alert('Sessão expirada, faça login novamente');
                        window.location.href = '<?= site_url('usuario') ?>';
                    }
                } catch (e) {
                    console.log(e);
                }
            },
            abrirJanelaPeloMenu: async function(sistema_url, acao_url) {
                this.carregandoIframe = true;
                //alert(sistema_url);
                let urlTemp = sistema_url.split('/');
                let url = urlTemp[1];
                this.janela_url = "https://" + '<?php echo $_SERVER['HTTP_HOST'] ?>' + '/_portal/' + url + '/' + acao_url;
                this.urlSistema = this.janela_url;
                // alert(this.janela_url);
                setTimeout(() => {
                    this.carregandoIframe = false;
                }, 3000);

            },
            fecharJanela: async function() {

                await this.$nextTick();
                this.imagem_logo_principal = this.imagem_logo_principal_old;
                this.janela_titulo = '';
                this.janela_perfil = '';
                this.mostrarURL = false;
                this.menu = [];
                const el = this.$refs.janelaMacos;
                if (el) {
                    el.classList.remove('maximizando');
                    // el.classList.add('minimizando');
                    this.janelaAberta = false;
                    this.urlSistema = null;
                } else {
                    console.warn('Elemento não encontrado');
                }


            },
            tratarErroIframe() {
                alert("URL inacessível ou com erro");
                window.location.href = "https://" + <?php echo json_encode($_SERVER['HTTP_HOST']); ?> + "/_portal/Intranet/usuario";
            },
            AbrirPaginaInicial: async function() {
                this.carregandoIframe = true;
                await this.ajax_verifica_logado();
                this.urlSistema = this.sistema_url_atual;
                setTimeout(() => {
                    this.carregandoIframe = false;
                }, 3000);
            },
            abrirSistema: async function(sistema_id, sistema_nm, carregar_menu = 1, sistema_icone, sistema_url) {

                // this.carregandoIframe = true;
                this.sistema_id_atual = sistema_id;
                this.sistema_nm_atual = sistema_nm;
                this.carregar_menu_atual = carregar_menu;
                this.sistema_icone_atual = sistema_icone;
                this.sistema_url_atual = sistema_url;

                await this.ajax_verifica_logado();
                this.imagem_logo_principal = "<?= iPATH ?>Icones/" + sistema_icone;

                let url = `<?= site_url('/usuario/select_sistema/?sistema=') ?>${sistema_id}`;

                //atualiza o url do iframe
                this.urlSistema = url;


                this.janelaAberta = true; // Abre a janela para renderizar no DOM
                this.janela_titulo = sistema_nm;


                if (window.innerWidth < 768 || this.flag_abrir_janela_ativo == false) {
                    window.location.href = url;
                } else {
                    //adiciona css que da efeito de minimizar ao fechar
                    await this.$nextTick(async () => {
                        const el = this.$refs.janelaMacos;
                        if (el) {
                            if (el.classList.contains('maximizando')) {
                                el.classList.remove('maximizando');
                            }


                            setTimeout(() => {
                                el.classList.add('maximizando');
                            }, 300);

                        } else {
                            console.warn('Elemento não encontrado');
                        }

                        // Aguarda a busca do perfil antes de continuar
                        await this.ajax_busca_perfil_sistema_janela_menu(sistema_id);

                    });
                    //------------------------------------


                }


            },


            ajax_busca_perfil_sistema_janela_menu: async function(sistema_id) {
                let url = '<?= site_url('pessoa/ajax_busca_perfil_sistema_janela_menu') ?>/?sistema_id=' + sistema_id;
                // alert(url)
                try {
                    let result = await fetch(url);
                    if (!result.ok) {
                        console.error(`Erro HTTP: ${result.status}`);
                        alert("Erro, favor tentar novamente");
                        window.location.href = '/_portal/Intranet/usuario';
                        return; // interrompe o fluxo
                    }


                    let json = await result.json();
                    this.janela_perfil = json.perfil?.toUpperCase();
                    this.menu = json.menu;
                    // console.log(this.menu);
                    // alert(this.janela_perfil);
                } catch (error) {
                    console.error('Erro ao buscar perfil:', error);
                }
            },

            iniciarArraste: function(event) {
                if (!this.arrastoAtivado) {
                    return;
                }
                this.offsetX = event.clientX - this.posX;
                this.offsetY = event.clientY - this.posY;
                document.addEventListener('mousemove', this.arrastando);
                document.addEventListener('mouseup', this.pararArraste);
            },
            arrastando: function(event) {
                this.posX = event.clientX - this.offsetX;
                this.posY = event.clientY - this.offsetY;
            },
            pararArraste: function() {
                document.removeEventListener('mousemove', this.arrastando);
                document.removeEventListener('mouseup', this.pararArraste);
            },
            bloquearCliquesRapidos(delay = 500) {
                let lastClickTime = 0;

                document.body.addEventListener('click', function(e) {
                    const now = Date.now();

                    if (now - lastClickTime < delay) {
                        e.stopImmediatePropagation();
                        e.preventDefault();
                        return false;
                    }

                    lastClickTime = now;
                }, true); // fase de captura
            },


            trazerParaFrente: function() {
                // Caso queira manipular z-index depois
            },
            selectDate: function(day) {
                // if (!day) return;
                // this.selectedDate = new Date(this.currentYear, this.currentMonth, day);
                // this.showCalendar = false;
                // alert(`Data selecionada: ${this.selectedDate.toLocaleDateString()}`);
            },
            isSelected: function(day) {
                if (!day || !this.selectedDate) return false;
                return this.selectedDate.getDate() === day &&
                    this.selectedDate.getMonth() === this.currentMonth &&
                    this.selectedDate.getFullYear() === this.currentYear;
            },
            atualizarRelogio: function() {
                const agora = new Date();

                // Obtém as horas e minutos
                const horas = String(agora.getHours()).padStart(2, '0');
                const minutos = String(agora.getMinutes()).padStart(2, '0');
                const segundos = String(agora.getSeconds()).padStart(2, '0');

                // Array com os dias da semana
                const diasDaSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'];

                // Array com os meses por extenso
                const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

                // Obtém o dia da semana e o mês por extenso
                const diaDaSemana = diasDaSemana[agora.getDay()];
                const mes = meses[agora.getMonth()];

                // Obtém o dia e ano
                const dia = String(agora.getDate()).padStart(2, '0');
                const ano = agora.getFullYear();

                // Atualiza o valor de horaAtual com o dia da semana, data, mês por extenso, horas e minutos
                this.horaAtual = `${diaDaSemana}, ${dia} de ${mes} | ${horas}:${minutos}`;
                //this.horaAtual = `${diaDaSemana}, ${dia} de ${mes} de ${ano} | ${horas}:${minutos}:${segundos}`;
                //this.horaAtual = `${diaDaSemana}, ${dia} de ${mes} - ${horas}:${minutos}`;
            },

            alterar_tela_cheia: function(sempre_tela_cheia) {
                const doc = document.documentElement


                if (sempre_tela_cheia == 0 && this.isFullscreen == false) {
                    return false;
                }

                if (this.isFullscreen == true) {
                    this.isFullscreen = false;
                    document.exitFullscreen()
                    return;
                }
                if (this.isFullscreen == false) {
                    this.isFullscreen = true;
                    doc.requestFullscreen()
                    return;
                }
                /*
                                    if (sempre_tela_cheia == 1) {
                                        this.isFullscreen = true;
                                        doc.requestFullscreen()
                                        return;
                                    }
                                    if (sempre_tela_cheia == 0) {
                                        this.isFullscreen = false;
                                        document.exitFullscreen()
                                        return;
                                    }*/


                if (!document.fullscreenElement) {
                    if (doc.requestFullscreen) {
                        doc.requestFullscreen()
                    }
                    this.isFullscreen = true
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen()
                    }
                    this.isFullscreen = false
                }
            },

            sair_sistema: function() {
                if (this.HTTP_HOST == 'localhost') {
                    window.location.href = "<?= PORTAL_SDR_LOCALHOST ?>";
                } else {
                    window.location.href = "<?= PORTAL_SDR ?>";
                }
            },
            onMouseMove: function(event) {
                const rect = this.dockRef.getBoundingClientRect();
                this.mouseX = event.clientX - rect.left;
            },
            getScale: function(index) {
                if (this.mouseX === null) return 1;
                const img = this.dockRef.children[index].querySelector('img');
                const center = img.offsetLeft + img.offsetWidth / 2;
                const dist = Math.abs(this.mouseX - center);
                const scale = Math.max(1, 2 - dist / 100);
                return scale.toFixed(2);
            },
            resetZoom: function() {
                this.mouseX = null;
            },
            mostrarResolucao: function() {
                const largura = window.innerWidth;
                const altura = window.innerHeight;

                this.resolucao = `${largura} x ${altura} `;
                // console.log(this.resolucao);


            },
            mudarCorFundo(cor) {
                document.documentElement.style.setProperty('--body-bg-color', cor);
            }
        }
    });

    app.mount('#app');
</script>

<link rel="stylesheet" href="<?= base_url('assets/css/sistema/sistema.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sistema/menu-bar.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sistema/mac.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sistema/botoes.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sistema/desktop.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sistema/buscador.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sistema/calendario-relogio.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sistema/dock.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sistema/fullscreen.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sistema/instagram.css'); ?>">





</html>