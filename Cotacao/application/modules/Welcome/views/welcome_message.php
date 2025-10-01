<?php include '../template/begin.php'; ?>
<style>
    .links-tutoriais {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 30px 0;
        flex-wrap: wrap;
    }

    .links-tutoriais .link {
        background: #f4f4f4;
        padding: 12px 18px;
        border-radius: 10px;
        text-decoration: none;
        color: #333;
        font-weight: bold;
        font-size: 15px;
        border: 2px solid #ddd;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .links-tutoriais .link:hover {
        background: #789484;
        color: white;
        border-color: #789484;
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }



    /**css do modal */
    /* fundo escuro */
    /* fundo escuro */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    /* caixa do modal */
    .modal-content {
        position: relative;
        width: 95%;
        height: 95%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* iframe estiloso */
    .iframe-estiloso {
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 1.0);
        background: transparent;
        /* removi fundo branco */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .iframe-estiloso:hover {
        transform: scale(1.01);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 1.0);
    }

    /* botão fechar fixo embaixo */
    .close {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 14px 30px;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        background: #b00000;
        /* vermelho forte e sólido */
        border: none;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: none !important;
        /* removi sombra que dava impressão de translucidez */
        z-index: 1100;
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .close:hover {
        background: #800000;
        /* mais escuro no hover */
        transform: translateX(-50%) scale(1.05);
    }
</style>
<div id="app">


    <table style="width:100%">
        <tr>
            <td align='center'>
                <img :src="logoPath" alt="Logo" style="width: 200px; padding-top: 20px;">
                <h2><b>BEM VINDO <span style="color: #30ADAB">{{ perfilUpper }}</span></b></h2>

                <div class="links-tutoriais" v-if="perfil !== 'Fornecedor' && perfil !== 'Tecnico/Consultor'">
                    <a :href="siteUrl('cotacao')" class='link'>
                        Minhas cotações
                    </a>
                </div>

                <div class="links-tutoriais" v-if="perfil === 'Fornecedor'">
                    <a :href="siteUrl('produto')" class='link'>
                        Atualizar meus preços
                    </a>
                </div>

                <div class="links-tutoriais" v-if="perfil === 'Tecnico/Consultor'">
                    <a :href="siteUrl('acompanhamento')" class='link'>
                        Acompanhar Fornecedores
                    </a>
                </div>
            </td>
        </tr>
    </table>

    <div class="links-tutoriais">
        <a v-for="manual in manuais" :key="manual.nome" class='link' :href="manual.url" download v-show="verificaSeManualPodeSerVistoPeloPerfil(manual.arquivo)">
            <i class="glyphicon glyphicon-book" style="color: #789484"></i> {{ manual.nome }}
        </a>
    </div>
    <div class="links-tutoriais">
        <span class='link' style="background-color: #789484; color: white;" @click="abrirModal">
            <img src="<?= iPATHIcones ?>bahia.png" alt="" style="width: 90px;"> Mapa de Disponibilidade Comercial 
        </span>
    </div>
    <div class="links-tutoriais">
        <span class='link' style="background-color: #789484; color: white;"  >
            <i class="glyphicon glyphicon-apple" style="color: #789484"></i> Mapa de Produtos (em breve)
        </span>
    </div>

    <div>
        <!-- Modal estiloso -->
        <div v-if="mostrarModal" class="modal-overlay">
            <div class="modal-content">
                <span class="close" @click="fecharModal" style="background-color: red;">&times; Fechar</span>
                <iframe :src="iframeSrc" class="iframe-estiloso"></iframe>
            </div>
        </div>
    </div>
</div>


<script type="module">
    import {
        createApp
    } from "<?= iPATH ?>JavaScript/vue/vue3/vue.esm-browser.prod.js"

    createApp({
        data() {
            return {
                mostrarModal: false,
                iframeSrc: '',
                url_mapa: "https://<?= $_SERVER['SERVER_NAME'] ?>/_portal/vereda_info/municipio/mapa_cotacao_preco/?usando_iframe=1",
                perfil: "<?= $_SESSION['perfil'] ?>",
                logoPath: "<?= iPATH ?>Imagens/cotacao/cotacao-rural-1.png",
                anexoPath: "<?= anexoPATHExterno ?>cotacao/",
                siteBase: "<?= site_url() ?>",
                manuais: [{
                        nome: "Manual do Fornecedor",
                        arquivo: "Manual_Cotacao_Fornecedor.pdf",
                        perfils: ['Fornecedor', 'Tecnico/Consultor', 'Gestor', 'Administrador']
                    },
                    {
                        nome: "Manual do Comprador",
                        arquivo: "Manual_Cotacao_Comprador.pdf",
                        perfils: ['Comprador', 'Tecnico/Consultor', 'Gestor', 'Administrador']
                    },
                    {
                        nome: "Manual do Nutricionista",
                        arquivo: "Manual_cotacao_Nutricionista_responsavel_pela_escola.pdf",
                        perfils: ['Nutricionista', 'Gestor', 'Administrador']
                    }
                ]
            }
        },
        computed: {
            perfilUpper() {
                return this.perfil.toUpperCase();
            }
        },
        methods: {
            abrirModal() {
                this.iframeSrc = this.url_mapa
                this.mostrarModal = true
            },
            fecharModal() {
                this.mostrarModal = false
                this.iframeSrc = ""
            },

            siteUrl(path) {
                return this.siteBase + path;
            },
            verificaSeManualPodeSerVistoPeloPerfil(arquivo) {
                return this.manuais.find(m => m.arquivo === arquivo).perfils.includes(this.perfil);
            },
            verificaSeTemCAF: function() {
                //função criada para os usuarios do SIPAF q possuem caf, porem em outra tabela, função faz pequena migração de dados
                let url = '<?= site_url('acompanhamento/ajax_verifica_se_tem_caf') ?>?q=' + this.q + '&format=json';

                let result = fetch(url);

            },
        },
        mounted() {
            this.verificaSeTemCAF();
            // Transformar nomes em URLs completas
            this.manuais = this.manuais.map(m => ({
                ...m,
                url: this.anexoPath + m.arquivo
            }));
        }
    }).mount("#app");
</script>

<?php include '../template/end.php'; ?>