<?php include '../template/begin_1_2018rn_externo.php'; ?>
<html>

<head>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/simple-captcha/1.0.0/simple-captcha.min.js"></script> -->
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
            <!-- <h1 style="font-size:20px">COTAÇÃO RURAL BAHIA</h1> -->
            <br>
            <br>
            <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i> Inscrição de Fornecedores</h2>
            <!-- <p> <b>ORIENTAÇÃO PARA FORNECEDORES </b>
            <br> 1. Fornecedores devem se cadastrar via Internet, através deste site. Acesse o sistema de "Cadastro do Fornecedor" 
            <br> 2. Para cadastro de novos produtos, acesse a Aba SEUS PRODUTOS. Item NOVO" 
            <br> 3. O fornecedor deverá atualizar o sistema regularmente a fim de facilitar o processo de aquisição pelos órgãos compradores. 
            <br> 4. Qualquer modificação de "contato" deverá ser ajustado no sistema a fim de mantê-lo sempre atualizado. -->
            <!-- <br> 5. Termo de Responsabilidade</p> -->

            <div class="captcha-container" v-show="capValidado==false">
                <img :src="captchaSrc" class="captcha-image" alt="CAPTCHA" />
                <!-- <button type="button" @click="reloadCaptcha"  class="btn btn-sm btn-default">Atualizar</button> -->
                <input type="text" v-model="captchaInput" placeholder="Digite o conteúdo da imagem" class="form-control" style="width: 250px;" />
                <br>
                <input type="button" value="Avançar para Inscrição" @click="validaCaptchar" class="btn btn-sm btn-success" style="width: 250px;">
                <br>
                <a href="https://www.portalsema.ba.gov.br/_portal/Intranet/usuario">
                    <input type="button" value="Já possuo login e senha" class="btn btn-sm btn-primary" style="width: 250px;">
                </a>
                <br>
                <a href="https://www.portalsema.ba.gov.br/_portal/Intranet/usuario/resetar_senha">
                    <input type="button" value="Esqueci minha senha" class="btn btn-sm btn-danger" style="width: 250px;">
                </a>
            </div>
            <br>
            <br>
            <div class="captcha-container" v-show="capValidado==false">
                <b>Recomendamos que utilize o navegador Google Chrome Atualizado </b>
                <img
                    style="width: 30px;"
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Google_Chrome_icon_%28February_2022%29.svg/480px-Google_Chrome_icon_%28February_2022%29.svg.png" alt="">
            </div>


            <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" v-show="capValidado==true">
                <div class='col-md-12' name='' id=''>
                    <div class='x_panel' id=''>
                        <div class='x_content'>
                            <h2><i class="glyphicon glyphicon-user"></i> Respónsavel pela Instituição</h2>
                            <div style='overflow-x:auto'>
                                <table class='table'>
                                    <!-- <tr>
                                    <td style='width:10%'>
                                        <div class="form-group">
                                            <label for="integer">Fornecedor Pessoa Id <?php echo form_error('fornecedor_pessoa_id') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group">
                                            <select2-component v-model="form.fornecedor_pessoa_id" :options="pessoa"></select2-component>
                                        </div>
                                    </td>
                                </tr> -->
                                    <tr>
                                        <td style='width:10%'>
                                            <div class="form-group">
                                                <label for="character varying">Responsável * <?php echo form_error('responsavel_nm') ?></label>
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
                                                <input type="text" class="form-control" name="responsavel_cpf" id="responsavel_cpf" @input="mascararCPF" placeholder="" v-model="form.responsavel_cpf" required='required' maxlength='20' />
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">Celular (whatsapp)* <?php echo form_error('responsavel_telefone') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="responsavel_telefone"
                                                    id="responsavel_telefone"
                                                    placeholder="(99) 99999-9999"
                                                    v-model="form.responsavel_telefone"
                                                    @input="form.responsavel_telefone = maskTelefone(form.responsavel_telefone)"
                                                    maxlength="16"
                                                    required />
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
                            <h2><i class="glyphicon glyphicon-user"></i> Fornecedor </h2>
                            <div style='overflow-x:auto'>
                                <table class='table'>
                                    <tr>
                                        <td style="width: 10%;">
                                            <div class="form-group">
                                                <label for="character varying">Fornecedor* <?php echo form_error('fornecedor_nm') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" name="fornecedor_nm" id="fornecedor_nm" placeholder="" v-model="form.fornecedor_nm" required='required' maxlength='200' />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Categoria*</b>
                                        </td>
                                        <td>
                                            <!-- {{fornecedor_categoria}} -->
                                            <select name="fornecedor_categoria_id" id="fornecedor_categoria_id"
                                                class="form-control"
                                                v-model="form.fornecedor_categoria_id">
                                                <option value="">.:Selecione:.</option>
                                                <option v-for="(i, key) in fornecedor_categoria" :value="i.id">{{i.text}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying"> Nome Fantasia<?php echo form_error('fornecedor_nm_fantasia') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" name="fornecedor_nm_fantasia" id="fornecedor_nm_fantasia" placeholder="" v-model="form.fornecedor_nm_fantasia" required='required' maxlength='200' />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">E-mail* <?php echo form_error('fornecedor_email') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" name="fornecedor_email" @blur="ajax_verifica_email_sipaf();ajax_verifica_duplicidade()"
                                                    id="fornecedor_email" placeholder="" v-model="form.fornecedor_email" required='required' maxlength='200' />
                                            </div>
                                            <div class="green" v-show="mensagem_sipaf">{{mensagem_sipaf}}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Tipo*</b></td>
                                        <td>
                                            <select v-model="form.inscricao_fornecedor_tipo" id="inscricao_fornecedor_tipo" name="inscricao_fornecedor_tipo"
                                                @chenge="valida_inscricao_fornecedor_tipo"
                                                class="form-control">
                                                <option value="">.:Selecione:.</option>
                                                <option value="PJ">Pessoa Juridica</option>
                                                <option value="PF">Pessoa Física</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr v-show="form.inscricao_fornecedor_tipo == 'PJ'">
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">CNPJ <?php echo form_error('fornecedor_cnpj') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" name="fornecedor_cnpj" id="fornecedor_cnpj" placeholder="" @input="mascararCNPJ" v-model="form.fornecedor_cnpj" maxlength='100' />
                                            </div>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">DAP/CAF* <?php echo form_error('dap_caf') ?></label>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <b class="red">Atenção ao informar os dados corretos</b>
                                                <input type="text" class="form-control" name="dap_caf" id="dap_caf" placeholder="" v-model="form.dap_caf" required='required' maxlength='100' />
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class='x_panel' id=''>
                        <div class='x_content'>
                            <h2><i class="glyphicon glyphicon-user"></i> Endereço do FORNECEDOR </h2>
                            <div style='overflow-x:auto'>
                                <table class='table'>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">MunicÍpio* <?php echo form_error('fornecedor_municipio_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <!-- <p class="red">será utilizado como referência para as cotações</p> -->
                                                <select2-component id="fornecedor_municipio_id" name="fornecedor_municipio_id" :selected="form.fornecedor_municipio_id" v-model="form.fornecedor_municipio_id" :options="municipio">
                                                </select2-component>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10%;">
                                            <div class="form-group">
                                                <label for="character varying">Endereço* <?php echo form_error('fornecedor_nm') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" name="fornecedor_endereco" id="fornecedor_endereco" placeholder="" v-model="form.fornecedor_endereco" required='required' maxlength='200' />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">Bairro* <?php echo form_error('fornecedor_nm_fantasia') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" name="fornecedor_bairro" id="fornecedor_bairro" placeholder="" v-model="form.fornecedor_bairro" required='required' maxlength='20' />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">CEP* <?php echo form_error('fornecedor_nm_fantasia') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="number" class="form-control" name="fornecedor_cep" id="fornecedor_cep" placeholder="" v-model="form.fornecedor_cep" required='required' maxlength='20' />
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class='x_panel' id=''>
                        <div class='x_content'>
                            <div style='overflow-x:auto'>
                                <table class='table'>

                                    <tr>
                                        <td>
                                            O cadastro não garante a inscrição, seu cadastro será submetido a avaliação da SDR/SUAF
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class='x_panel' id=''>
                        <div class='x_content'>
                            <div style='overflow-x:auto'>
                                <table class='table'>

                                    <tr>
                                        <td colspan='2'>
                                            <input type="hidden" name="inscricao_fornecedor_id" value="<?php echo $inscricao_fornecedor_id; ?>" />
                                            <button id="btnGravar" type="button" class="btn btn-primary" @click="submeter()">{{button}}</button>
                                            <!-- <a href="<?php echo site_url('inscricao_fornecedor') ?>" class="btn btn-default">Voltar</a> -->
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


    <!-- <select2-component v-model="id" :options="array"></select2-component> -->
    <script type="module">
        import {
            createApp
        } from "<?= iPATH ?>JavaScript/vue/vue3/vue.esm-browser.prod.js"

        import {
            Select2Component
        } from "<?= iPATH ?>JavaScript/vue/select2/Select2Component.js"

        import * as func from "<?= iPATH ?>JavaScript/func.js"



        const app = createApp({
            components: {
                Select2Component
            },
            data() {
                return {
                    mensagem_sipaf: '',
                    captchaSrc: '',
                    captchaValue: '',
                    captchaInput: '',
                    capValidado: false,
                    message: '',
                    button: "<?= $button ?>",
                    controller: "<?= $controller ?>",
                    /*tag select*/
                    pessoa: <?= $pessoa ?>,
                    pessoa: <?= $pessoa ?>,
                    municipio: <?= $municipio ?>,
                    fornecedor_categoria: <?= $fornecedor_categoria ?>,

                    /*form*/
                    form: {
                        fornecedor_pessoa_id: "<?= $fornecedor_pessoa_id ?>",
                        inscricao_fornecedor_tipo: "<?= $inscricao_fornecedor_tipo ?>",
                        responsavel_nm: "<?= $responsavel_nm ?>",
                        responsavel_cpf: "<?= $responsavel_cpf ?>",
                        fornecedor_email: "<?= $fornecedor_email ?>",
                        responsavel_telefone: "<?= $responsavel_telefone ?>",
                        dt_cadastro: "<?= $dt_cadastro ?>",
                        fornecedor_nm: "<?= $fornecedor_nm ?>",
                        fornecedor_nm_fantasia: "<?= $fornecedor_nm_fantasia ?>",
                        fornecedor_cnpj: "<?= $fornecedor_cnpj ?>",
                        fornecedor_municipio_id: "<?= $fornecedor_municipio_id ?>",
                        autorizador_cadastro_gestor_pessoa_id: "<?= $autorizador_cadastro_gestor_pessoa_id ?>",
                        reprovado_motivo: "<?= $reprovado_motivo ?>",
                        dap_caf: "<?= $dap_caf ?>",
                        fornecedor_endereco: "<?= $fornecedor_endereco ?>",
                        fornecedor_bairro: "<?= $fornecedor_bairro ?>",
                        fornecedor_cep: "<?= $fornecedor_cep ?>",
                        fornecedor_categoria_id: "<?= $fornecedor_categoria_id ?>",
                    }
                } //end data()
            },
            computed: {

            },
            methods: {
                dataToBR,
                dataToBRcomHora,
                moedaBR,
                maskTelefone(v) {
                    if (!v) return '';
                    // mantém só números
                    let s = String(v).replace(/\D/g, '');

                    // remove código do país 55 se vier junto
                    if (s.startsWith('55')) s = s.slice(2);

                    // limita a 11 dígitos (DD + número)
                    s = s.slice(0, 11);

                    // aplica máscara dinâmica
                    if (s.length <= 2) {
                        return `(${s}`;
                    } else if (s.length <= 6) { // (DD) 9xx- or (DD) xxxx
                        return `(${s.slice(0,2)}) ${s.slice(2)}`;
                    } else if (s.length <= 10) { // 10 dígitos: (DD) xxxx-xxxx
                        return `(${s.slice(0,2)}) ${s.slice(2,6)}-${s.slice(6)}`;
                    } else { // 11 dígitos: (DD) xxxxx-xxxx
                        return `(${s.slice(0,2)}) ${s.slice(2,7)}-${s.slice(7,11)}`;
                    }
                },
                valida_inscricao_fornecedor_tipo: function() {
                    if (this.form.inscricao_fornecedor_tipo == 'PF') {
                        this.form.fornecedor_cnpj = null

                    }
                },
                //se o email for do sipaf, vc sera redirecionado para outro formulario
                ajax_verifica_email_sipaf: async function() {
                    let url = '<?= site_url('inscricao_fornecedor/ajax_verifica_email_sipaf') ?>' + '?fornecedor_email=' + this.form.fornecedor_email;
                    let result = await fetch(url);
                    let json = await result.json();
                    if (json.situacao == 'email_sipaf_existe') {
                        alert('Atenção, o email "' + this.form.fornecedor_email + '" é do SIPAF, você sera redirecionado para um formulario especifico');
                        this.form.fornecedor_email = null
                        return false;
                    }
                },
                submeter: function() {
                    if (!this.form.fornecedor_categoria_id) {
                        alert('Favor informar a categoria')
                        return false
                    }
                    if (!this.form.fornecedor_municipio_id) {
                        alert('Favor informar o municipio')
                        return false
                    }
                    if (this.form.inscricao_fornecedor_tipo == 'PJ') {
                        if (!this.form.fornecedor_cnpj) {
                            alert('Favor informar o CNPJ')
                            return false
                        }
                    }

                    alert("Atenção!\nApós o cadastro aguarde contato por email da SUAF/SDR!\nSeu cadastro será analisado")
                    $('#form').submit()
                },
                async ajax_verifica_duplicidade() {
                    if (!this.form.fornecedor_email || !this.form.fornecedor_cnpj || !this.form.responsavel_cpf) {
                        return false;
                    }

                    let url = '<?= site_url('inscricao_fornecedor/ajax_verifica_duplicidade') ?>' +
                        '?responsavel_cpf=' + this.form.responsavel_cpf +
                        '&fornecedor_email=' + this.form.fornecedor_email +
                        '&fornecedor_cnpj=' + this.form.fornecedor_cnpj;

                    // window.open(url)
                    let result = await fetch(url);
                    let json = await result.json();

                    if (this.validar_cpf(json) == false) {
                        return false;
                    }
                    if (this.validar_email(json) == false) {
                        return false;
                    }
                    if (this.validar_cnpj(json) == false) {
                        return false;
                    }

                    return true;
                },

                validar_cpf(json) {
                    if (json?.situacao === 'cpf_ja_existe') {
                        alert(`Atenção, o CPF "${this.form.responsavel_cpf}" já está em uso`);
                        this.form.responsavel_cpf = null;
                        return false;
                    }
                    return true;
                },

                validar_email(json) {
                    if (json?.situacao === 'email_ja_existe' && this.form.fornecedor_email) {
                        alert(`Atenção, o E-MAIL "${this.form.fornecedor_email}" já está em uso`);
                        this.form.fornecedor_email = null;
                        return false;
                    }
                    return true;
                },

                validar_cnpj(json) {
                    if (json?.situacao === 'cnpj_ja_existe') {
                        alert(`Atenção, o CNPJ "${this.form.fornecedor_cnpj}" já está em uso`);
                        this.form.fornecedor_cnpj = null;
                        return false;
                    }
                    return true;
                },
                mascararCPF: async function() {
                    this.form.responsavel_cpf = func.mascararCPF(this.form.responsavel_cpf)
                    if (this.form.responsavel_cpf.length == 14) {
                        if (this.form.responsavel_cpf.length == 14) {
                            // alert(func.validarCPF(this.responsavel_cpf))
                            if (func.validarCPF(this.form.responsavel_cpf) == false) {
                                alert('CPF inválido');
                                this.form.responsavel_cpf = '';
                                return false;
                            }
                            await this.ajax_verifica_duplicidade()
                        }
                    }

                },
                mascararCNPJ: async function() {
                    //  alert(this.form.fornecedor_cnpj)
                    this.form.fornecedor_cnpj = await func.mascararCNPJ(this.form.fornecedor_cnpj);
                    if (this.form.fornecedor_cnpj.length == 18) {
                        if (func.validarCNPJ(this.form.fornecedor_cnpj) == false) {
                            alert('CNPJ inválido')
                            this.form.fornecedor_cnpj = '';
                            return false;
                        }
                        await this.ajax_verifica_duplicidade()
                    }

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
                }
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