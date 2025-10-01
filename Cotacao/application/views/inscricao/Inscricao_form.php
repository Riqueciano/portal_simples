<?php include '../template/begin_1_2018rn_externo.php'; ?>
<html>

<head>

</head>

<body>

    <!-- ###app### -->
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
    <div id='app' v-cloak>
        <div class="x_panel">
            <img src="<?= iPATH ?>Imagens/cotacao/cotacao-rural-1.png" alt="Logo" style="width: 200px; padding-top: 20px;">




            <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Inscrição <b>Compradores / Estudiosos</b> </span> </h2>
            <!-- <p>
            <b style="font-size: 15px;">ORIENTAÇÃO PARA COMPRADORES:</b> Realize seu cadastro neste formulário para obter por e-mail seu logim e senha de acesso
        </p> -->

            <div class="captcha-container" v-show="capValidado==false">
                <img :src="captchaSrc" class="captcha-image" alt="CAPTCHA" />
                <!-- <button type="button" @click="reloadCaptcha"  class="btn btn-sm btn-default">Atualizar</button> -->
                <br>
                <input type="text" v-model="captchaInput" placeholder="Digite o conteúdo da imagem" class="form-control" style="width: 250px;" />
                <br>
                <input type="button" value="Avançar" @click="validaCaptchar" class="btn btn-sm btn-success" style="width: 250px;">
                <br>
                <a href="https://www.portalsema.ba.gov.br/_portal/Intranet/usuario">
                    <input type="button" value="Já possuo login e senha" class="btn btn-sm btn-primary" style="width: 250px;">
                </a>
                <br>
                <a href="https://www.portalsema.ba.gov.br/_portal/Intranet/usuario/resetar_senha">
                    <input type="button" value="Esqueci minha senha" class="btn btn-sm btn-danger" style="width: 250px;">
                </a>
            </div>
        </div>


        <br>
        <br>
        <div class="x_panel">
            <div class="captcha-container" v-show="capValidado==false">
                <b>Recomendamos que utilize o navegador Google Chrome Atualizado </b>
                <img
                    style="width: 30px;"
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Google_Chrome_icon_%28February_2022%29.svg/480px-Google_Chrome_icon_%28February_2022%29.svg.png" alt="">
            </div>


            <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" v-show="capValidado==true">
                <div class='col-md-12' name='' id=''>
                    <div class='x_panel' id=''>
                        <h2>Responsável pela ENTIDADE</h2>
                        <div class='x_content'>
                            <div style='overflow-x:auto'>
                                <table class='table'>

                                    <tr>
                                        <td style="width: 15%;">
                                            <div class="form-group">
                                                <label for="character varying">Responsável* <?php echo form_error('responsavel_nm') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" name="responsavel_nm" id="responsavel_nm" placeholder="" v-model="form.responsavel_nm" required='required' maxlength='200' />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">CPF* <?php echo form_error('responsavel_cpf') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" @input="mascararCPF" name="responsavel_cpf" id="responsavel_cpf" placeholder="" v-model="responsavel_cpf" required='required' maxlength='14' />
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-md-12' name='' id=''>
                    <div class='x_panel' id=''>
                        <div class='x_content'>
                            <h2>Entidade </h2>
                            <div style='overflow-x:auto'>
                                <table class='table'>
                                    <tr>
                                        <td style="width: 15%;">
                                            <div class="form-group">
                                                <label for="character varying">Comprador <br>(nome da Entidade)* <?php echo form_error('responsavel_nm') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="comprador_nm" id="comprador_nm" placeholder="" v-model="form.comprador_nm" required='required' maxlength='200' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Categoria*</b></td>
                                        <td>
                                            <select name="comprador_categoria_id" id="comprador_categoria_id" v-model="form.comprador_categoria_id" class="form-control">
                                                <option value="">.:Selecione:.</option>
                                                <option v-for="(i, index) in comprador_categoria" :value="i.id">{{i.text}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">Email* <?php echo form_error('responsavel_email') ?></label>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" name="responsavel_email" @blur="ajax_verifica_duplicidade()" id="responsavel_email" placeholder="" v-model="form.responsavel_email" required='required' maxlength='200' />
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                    <td>
                                        <label for="mensagem">Mensagem <?php echo form_error('mensagem') ?></label>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <textarea maxlength="800" class="form-control" rows="3" v-model="form.mensagem" name="mensagem" id="mensagem" placeholder="">{{form.mensagem }}</textarea>
                                        </div>
                                    </td>
                                </tr> -->
                                    <!-- <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="timestamp without time zone">Dt Create <?php echo form_error('dt_create') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="dt_create" id="dt_create" placeholder="" v-model="form.dt_create" maxlength='200' /> </div>
                                    </td>
                                </tr> -->
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">CNPJ* <?php echo form_error('cnpj') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" @input="mascararCNPJ()" require="require" name="cnpj" id="cnpj" placeholder="" v-model="form.cnpj" maxlength='18' />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Municipio * <?php echo form_error('inscricao_municipio_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select v-model='inscricao_municipio_id' id='inscricao_municipio_id' name='inscricao_municipio_id' class='form-control'>
                                                    <option value=''>.:Selecione:.</option>
                                                    <option :value='i.id' v-for="(i,key) in  municipio ">{{i.text}}</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>


                                </table>
                                <table class="table">
                                    <tr>
                                        <td colspan='1'>
                                            <input type="hidden" name="inscricao_id" value="<?php echo $inscricao_id; ?>" />
                                            <button id="btnGravar" type="button" @click="submeter" class="btn btn-primary">Enviar</button>
                                            <!-- <a href="<?php echo site_url('inscricao') ?>" class="btn btn-default">Voltar</a> -->
                                        </td>
                                        <td>
                                            <a href="https://www.portalsema.ba.gov.br/_portal/Intranet/usuario/resetar_senha">
                                                <input type="button" value="Esqueci minha senha" class="btn btn-sm btn-danger">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <script type="module">
        import {
            createApp
        } from "<?= iPATH ?>JavaScript/vue/vue3/vue.esm-browser.prod.js"
        import * as func from "<?= iPATH ?>JavaScript/func.js"

        const app = createApp({
            data() {
                return {
                    captchaSrc: '',
                    captchaValue: '',
                    captchaInput: '',
                    capValidado: <?= $capValidado ?>,
                    message: '',
                    button: "<?= $button ?>",
                    controller: "<?= $controller ?>",
                    /*tag select*/
                    pessoa: <?= $pessoa ?>,
                    municipio: <?= $municipio ?>,
                    comprador_categoria: <?= $comprador_categoria ?>,
                    /*form*/
                    responsavel_cpf: "<?= $responsavel_cpf ?>",
                    form: {
                        responsavel_nm: "<?= $responsavel_nm ?>",

                        responsavel_email: "<?= $responsavel_email ?>",
                        mensagem: "<?= $mensagem ?>",
                        dt_create: "<?= $dt_create ?>",
                        cnpj: "<?= $cnpj ?>",

                        pessoa_id: "<?= $pessoa_id ?>",
                        comprador_nm: "<?= $comprador_nm ?>",
                        comprador_categoria_id: "<?= $comprador_categoria_id ?>",

                    },
                    inscricao_municipio_id: "<?= $inscricao_municipio_id ?>",
                } //end data()
            },
            computed: {

            },
            methods: {
                dataToBR,
                dataToBRcomHora,
                submeter: async function() {

                    if (await this.ajax_valida_email_unico() == false) {
                        return false;
                    }

                    // return false;
                    // if(!this.form.responsavel_nm){
                    //     alert("campo em branco, favor preencher");
                    //     return false;
                    // }
                    // if(!this.responsavel_cpf){
                    //     alert("campo em branco, favor preencher");
                    //     return false;
                    // }
                    // if(!this.form.comprador_nm){
                    //     alert("campo em branco, favor preencher");
                    //     return false;
                    // }
                    if (!this.form.comprador_categoria_id) {
                        alert("Categoria em branco, favor preencher");
                        return false;
                    }
                    // if(!this.form.responsavel_email){
                    //     alert("campo em branco, favor preencher");
                    //     return false;
                    // }
                    // if(!this.form.cnpj){
                    //     alert("campo em branco, favor preencher");
                    //     return false;
                    // }



                    if (this.validarEmail(this.form.responsavel_email) == false) {
                        alert('E-mail inválido');

                        // $('#responsavel_email').focus() 
                        return false;
                    }
                    $('#form').submit()
                },
                mascararCNPJ: async function() {
                    // alert(this.form.cnpj)
                    this.form.cnpj = await func.mascararCNPJ(this.form.cnpj);
                    if (this.form.cnpj.length == 18) {
                        if (func.validarCNPJ(this.form.cnpj) == false) {
                            alert('CNPJ inválido')
                            this.form.cnpj = '';
                            return false;
                        }
                    }
                    this.ajax_verifica_duplicidade();
                },

                ajax_valida_email_unico: async function() {
                    if (!this.form.responsavel_email) {
                        alert("Favor informar o e-mail");
                        return false;
                    }
                    let url = '<?= site_url('inscricao/ajax_valida_email_unico') ?>' +
                        '?responsavel_email=' + this.form.responsavel_email;
                    let result = await fetch(url);
                    let json = await result.json();
                    if (json.situacao == 'email_ja_existe') {
                        alert('Atenção, o E-MAIL "' + this.form.responsavel_email + '" já está em uso, favor utilizar outro. Caso tenha esquecido sua senha, click no botão "Esqueci minha senha"');
                        this.form.responsavel_email = null
                        return false;
                    }
                },

                ajax_verifica_duplicidade: async function() {

                    if (!this.responsavel_email) {
                        return false;
                    }
                    let url = '<?= site_url('inscricao/ajax_verifica_duplicidade') ?>' +
                        '?responsavel_cpf=' + this.responsavel_cpf +
                        '&responsavel_email=' + this.form.responsavel_email +
                        '&cnpj=' + this.form.cnpj;
                    //   alert(url)
                    let result = await fetch(url);

                    let json = await result.json();
                    // alert(json.situacao )
                    if (json.situacao == 'cpf_ja_existe') {
                        alert('Atenção, o CPF "' + this.responsavel_cpf + '" já está em uso');
                        this.responsavel_cpf = null
                        return false;
                    }


                    if (json.situacao == 'email_ja_existe') {
                        alert('Atenção, o E-MAIL "' + this.form.responsavel_email + '" já está em uso');
                        this.form.responsavel_email = null
                        return false;
                    }
                    if (json.situacao == 'cnpj_ja_existe') {
                        alert('Atenção, o CNPJ "' + this.form.cnpj + '" já está em uso');
                        this.form.cnpj = null
                        return false;
                    }
                },
                mascararCPF: async function() {
                    this.responsavel_cpf = func.mascararCPF(this.responsavel_cpf)
                    if (this.responsavel_cpf.length == 14) {
                        if (this.responsavel_cpf.length == 14) {
                            // alert(func.validarCPF(this.responsavel_cpf))
                            if (func.validarCPF(this.responsavel_cpf) == false) {
                                alert('CPF inválido');
                                this.responsavel_cpf = '';
                                return false;

                            }
                            // alert('verifica se tem duplicidade');
                            await this.ajax_verifica_duplicidade()
                        }
                    }
                },
                validarEmail: function(email) {
                    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return regex.test(email);
                },
                generateCaptcha: function() {
                    const charsArray = "0123456789";
                    const lengthOtp = 4;
                    let captcha = [];
                    for (let i = 0; i < lengthOtp; i++) {
                        const index = Math.floor(Math.random() * charsArray.length);
                        captcha.push(charsArray[index]);
                    }
                    const canv = document.createElement("canvas");
                    canv.width = 150;
                    canv.height = 50;
                    const ctx = canv.getContext("2d");
                    ctx.font = "30px Georgia";
                    ctx.strokeText(captcha.join(""), 10, 30);
                    return {
                        image: canv.toDataURL("image/png"),
                        value: captcha.join("")
                    };
                },
                reloadCaptcha: function() {
                    const captcha = this.generateCaptcha();
                    this.captchaSrc = captcha.image;
                    this.captchaValue = captcha.value;
                },
                validaCaptchar: async function() {
                    if (this.captchaInput?.toUpperCase() === this.captchaValue?.toUpperCase()) {
                        // alert('CAPTCHA verified');
                        // Process form submission here
                        this.capValidado = true
                    } else {
                        alert('Atenção, tente novamente!');
                        this.captchaInput = null
                        await this.reloadCaptcha(); // Redraw CAPTCHA on failure
                        return false;
                    }
                },
                getBrowserName: function() {
                    var userAgent = navigator.userAgent;
                    var browserName;

                    if (userAgent.indexOf("Firefox") > -1) {
                        browserName = "Mozilla Firefox";
                    } else if (userAgent.indexOf("Opera") > -1 || userAgent.indexOf("OPR") > -1) {
                        browserName = "Opera";
                    } else if (userAgent.indexOf("Trident") > -1) {
                        browserName = "Microsoft Internet Explorer";
                    } else if (userAgent.indexOf("Edge") > -1) {
                        browserName = "Microsoft Edge";
                    } else if (userAgent.indexOf("Chrome") > -1) {
                        browserName = "Google Chrome";
                    } else if (userAgent.indexOf("Safari") > -1) {
                        browserName = "Apple Safari";
                    } else {
                        browserName = "Desconhecido";
                    }

                    return browserName;
                },

            },
            watch: {

            },
            mounted() {

                this.reloadCaptcha();

                let navegador = this.getBrowserName()
                //alert(navegador)
                if (navegador != 'Google Chrome' && navegador != 'Mozilla Firefox') {
                    alert("Atenção\nPara maior comodidade e segurança utilize os navegadores Google Chrome ou Firefox");
                    window.location.href = "https://www.portalsema.ba.gov.br/_portal/Intra/intranet#sistemas";
                    return false;
                }

                if (this.controller == 'read') {
                    $("input").prop("disabled", true);
                    $("select").prop("disabled", true);
                    $("textarea").prop("disabled", true);
                    $("#btnGravar").hide();
                } else if (this.controller == 'create') {
                    //tela de create
                    // alert("Atenção!\nApós o cadastro aguarde contato da SUAF/SDR!")
                    // alert("Atenção!\nApós o cadastro aguarde contato por e-mail da SUAF/SDR!\nSeu cadastro será analisado")
                } else if (this.controller == 'update') {
                    //tela de update 
                }
            },
        })

        app.mount('#app');
    </script>
</body>

</html>

<?php include '../template/end.php'; ?>