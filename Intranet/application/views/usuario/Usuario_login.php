<?php include '../template/_begin_login_2025.php'; ?>

<script src="https://alcdn.msauth.net/browser/2.38.0/js/msal-browser.min.js"></script>


<style>
    .btn-microsoft {
        background-color: rgba(28, 76, 172, 0.22);
        border: 1px solid rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(5px);
        padding: 10px 16px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        height: 48px;
    }

    .btn-microsoft:hover {
        background-color: rgba(28, 76, 172, 0.42);
    }
</style>

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


            <div v-show="logou_ms == false">
                <div class="form-group mb-3 text-center">
                    <b style="color: white;">Secretaria de Desenvolvimento Rural</b>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="custom-input" placeholder="Usuário" v-model="usuario_login" name="usuario_login" id="usuario_login" required />
                </div>
                <div class="form-group mb-3">
                    <input type="password" class="custom-input" placeholder="Senha" v-model="usuario_senha" name="password" id="usuario_senha" required autocomplete="current-password" />
                </div>

                <input type="submit" class="btn btn-primary" value="Entrar">
            </div>


            <button class="btn btn-microsoft"  v-if="host == 'localhost'"
                @click="loginWithMicrosoft">
                <img src="https://www.portalsema.ba.gov.br/_portal/Icones/intranet/ICONE-OUTLOOK.png"
                    alt="Microsoft"
                    style="width: 62px; height: 62px;">
                <span style="color: #000; font-weight: 400; font-size: 16px; line-height: 62px;">Outlook (servidores/localhost) </span>
            </button>



            <div v-show="logou_ms == false">
                <input type="button" class="btn btn-vermelho" value="Esqueci minha senha" @click="abrirEsquecerSenha">
                <input type="button" class="btn btn-outline-success mt-2" value="Voltar ao Portal SDR" @click="voltarPortal">
            </div>



            <div v-if="user">
                <hr>
                <p><strong>Nome:</strong> {{ user.displayName }}</p>
                <p><strong>Email:</strong> {{ user.mail || user.userPrincipalName }}</p>
            </div>
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



        let msalConfig = {
            auth: {
                clientId: "<?= MS_clientId ?>",
                authority: "<?= MS_authority ?>",
                redirectUri: "<?= MS_redirectUri ?>"
                // redirectUri: "https://www.portalsema.ba.gov.br/_portal/Intranet/usuario/ms_login"
            },
            cache: {
                cacheLocation: "sessionStorage", // mais temporário que localStorage
                storeAuthStateInCookie: false // evita fallback em cookies
            }
        };


        let msalInstance = new msal.PublicClientApplication(msalConfig);


        const loginRequest = {
            scopes: ['user.read']
        };


        createApp({
            data() {
                return {

                    flag_imagem_visivel: true,
                    usuario_login: '',
                    usuario_senha: '',
                    msgErro: <?= json_encode($msg_erro ?? '') ?>,
                    action: "<?= $action ?>",
                    token: '',
                    logou_ms: false,
                    host: "<?= $_SERVER['HTTP_HOST'] ?>",

                };
            },
            mounted() {
                this.logoutMicrosoft()
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
                },
                async logoutMicrosoft() {

                    try {
                        const account = msalInstance.getActiveAccount();

                        if (account) {
                            await msalInstance.logoutPopup({
                                account
                            });
                            console.log("Logout OK");

                            // Se quiser redirecionar após o logout:
                            window.location.href = "https://" + "<?php echo $_SERVER['HTTP_HOST']; ?>" + "/_portal/Intranet/usuario/logout_ms";
                        } else {
                            console.warn("Nenhuma conta ativa para logout.");
                        }
                    } catch (error) {
                        console.error("Erro no logout:", error);
                        alert("Erro ao fazer logout da Microsoft.");
                    }
                },

                async loginWithMicrosoft() {
                    try {
                        // Login via popup
                        const loginResponse = await msalInstance.loginPopup({
                            scopes: ['user.read']
                        });
                        console.log("Login OK", loginResponse);

                        const account = loginResponse.account;

                        // Tenta obter token silenciosamente
                        const tokenResponse = await msalInstance.acquireTokenSilent({
                            scopes: ['user.read'],
                            account
                        });
                        
                        const accessToken = tokenResponse.accessToken;

                        // Envia o token para o backend para validação
                        const response = await fetch('<?= site_url('usuario/validar_login') ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                token: accessToken
                            })
                        });

                        if (!response.ok) {
                            throw new Error("Erro na validação do token no servidor.");
                        }

                        if (response.ok) {
                            this.logou_ms = true;
                            window.location.href = "https://" + "<?php echo $_SERVER['HTTP_HOST']; ?>" + "/_portal/Intranet/usuario/usuario_login_ms";
                        }


                    } catch (error) {
                        console.error("Erro no login:", error);
                        alert("Erro ao fazer login com Microsoft.");
                    }
                },

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