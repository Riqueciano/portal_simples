<?php include '../template/_begin_login_2025.php'; ?>

<body>
    <div id="app" class="login-box">
        <h2 style="color: white;">Portal SDR</h2>

        <form id="form" method="post" :action="action" @submit="submeter">

            <div v-if="msgErro" class="alert alert-danger text-center" role="alert">
                <strong>{{ msgErro }}</strong>
            </div>

            <div class="form-group mb-3 text-center" v-if="flag_imagem_visivel == true">
                <img src="<?= iPATH ?>Imagens/logo_governo_vigente.png" alt="" class="logo_governo_vigente">
            </div>

            <div class="form-group mb-3 text-center">
                <b style="color: white;">Secretaria de Desenvolvimento Rural</b>
            </div>

            <div class="form-group mb-3">
                <input type="text" class="custom-input" placeholder="Usuário" v-model="usuario_login" name="usuario_login" id="usuario_login" required autocomplete="username" @keyup.enter="submeter"/>
            </div>

            <div class="form-group mb-3">
                <input type="password" class="custom-input" placeholder="Senha" v-model="usuario_senha" name="password" id="usuario_senha" required autocomplete="current-password" @keyup.enter="submeter"/>
            </div>

            <input type="submit" class="btn btn-primary" value="Entrar">

            <input type="button" class="btn btn-vermelho" value="Esqueci minha senha" @click="abrirEsquecerSenha">
            <input type="button" class="btn btn-outline-success mt-2" value="Voltar ao Portal SDR" @click="voltarPortal">

            <div class="footer-text">
                <a href="https://www.portalsema.ba.gov.br/" target="_blank" class="text-decoration-none" style="color: white;">
                    <img src="<?= iPATH ?>Icones/folha2.png" alt="" style="width: 20px; height: 20px; cursor: pointer;"> www.portalsdr.ba.gov.br
                </a>
            </div>
        </form>
    </div>

    <script type="module">
        import {
            createApp
        } from "<?= iPATH ?>JavaScript/vue/vue3/vue.esm-browser.prod.js";

        createApp({
            data() {
                return {
                    flag_imagem_visivel: true,
                    usuario_login: '',
                    usuario_senha: '',
                    msgErro: <?= json_encode($msg_erro ?? '') ?>,
                    action: "<?= $action ?>"
                };
            },
            methods: {
                submeter(event) {
                    if (!this.usuario_login.trim()) {
                        alert('Login em branco');
                        event.preventDefault();
                        return;
                    }
                    if (!this.usuario_senha.trim()) {
                        alert('Senha em branco');
                        event.preventDefault();
                        return;
                    }
                    // Caso contrário, o envio natural continua e o navegador pode salvar os dados
                },
                abrirEsquecerSenha() {
                    window.open("<?= site_url('usuario/resetar_senha') ?>", "_self");
                },
                voltarPortal() {
                    window.open("<?= iPATH ?>", "_self");
                }
            }
        }).mount('#app');
    </script>

    <style>
        .logo_governo_vigente {
            max-width: 200px;
            height: auto;
            border-radius: 10px;
        }
    </style>
</body>
</html>
