<?php include '../template/begin.php'; ?>

<html>

<head>
    <title>SDR</title>
    <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->
    <style>
        table tr {
            font-size: 10px !important;
        }

        table tr td {
            font-size: 10px !important;
        }

        .badge {
            font-size: 10px !important;
        }

        label {
            font-size: 10px !important;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <!--###app###-->
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
    <div id='app' v-cloak>
        <?= AVISO_TESTE ?>
        <img style="width:30%" src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Imagens/gif/loadTaaqui.gif" v-if="carregando">
        <form id="form" action="" method="post" v-show="!carregando">
            <h2 style="margin-top:0px">Listagem - Fornecedores acompanhados por mim <b><?= $_SESSION['pessoa_nm'] ?></b></h2>
            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                    <!-- <?php echo anchor(site_url('acompanhamento/create'), 'Novo', 'class="btn btn-success"'); ?> -->
                </div>
                <div class="col-md-3 text-center">
                    <div style="margin-top: 8px" id="message">
                        <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                        ?>
                    </div>
                </div>
                <div class="col-md-2 text-right">
                </div>
                <div class="col-md-3 text-right" v-if="false">
                    <!--form action="<?php echo site_url('acompanhamento/index'); ?>" class="form-inline" method="get"-->
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" v-model="q">
                        <span class="input-group-btn">
                            <button class="btn btn-default" @click='limpaFiltro()' v-show="q.length != 0">X</button>
                            <button class="btn btn-primary" type="button" @click='atualizaLista()'>Procurar</button>
                        </span>
                    </div>
                    <!--/form-->
                </div>
            </div>

            <div style='overflow-x:auto'>
                <h2 class="red"><i class="glyphicon glyphicon-search"></i> Marque os Territorios que deseja acompanhar</h2>
                <div class="col-md-12">
                    <div v-for="(t, key) in territorio_todos" class="col-md-2">
                        <label style="font-size: 8px;">
                            <input name='territorio_id[]' @click="atualiza_territorio()" :value="t.territorio_id" v-model="t.checked" type="checkbox" class="class_territorio_id"> {{t.territorio_nm?.toUpperCase()}}
                        </label>

                    </div>
                    
                    <a href="<?=site_url('acompanhamento/atualizar_seguindo_territorio') ?>/?limpar_territorios=1"  >
                        <input type="button" @click="desmarcar_todos_territorio()" value="Desmarcar todos Territorios" class="btn btn-danger btn-sm">
                    </a> 

                    <!--a href="<?=site_url('acompanhamento/atualizar_seguindo_territorio') ?>/?adicionar_todos_territorios=1"  >
                        <input type="button" @click="desmarcar_todos_territorio()" value="Adicionar todos territorios" class="btn btn-primary btn-sm">
                    </a>-->

                    <br>
                    <br>
                    <!-- <input type="button" @click="marcar_todos_territorio()" value="Marcar todos" class="btn btn-success">
                    <input type="button" @click="desmarcar_todos_territorio()" value="Desmarcar todos" class="btn btn-danger"> -->
                    <!-- <input type="button" value="Atualizar territórios Acompanhados" class="btn btn-danger"> -->
                </div>

                <div style="padding: 10px; color: red;">
                    *preços apenas de Fornecedores Autorizados
                </div>

                <br>
                <div class="col-md-3">
                    <b>Exibir:</b>
                    <select name="flag_exibir_produtos" v-model="flag_exibir_produtos"  id="flag_exibir_produtos" class="form-control" @change="atualizaLista()">
                        <option value="todos">Exibir todos</option>
                        <option value="sem_produtos">Exibir Fornecedores SEM produtos</option>
                        <option value="com_produtos">Exibir Fornecedores COM produtos</option>
                        <!--option value="com_produtos_fora_prazo">Exibir Fornecedores COM produtos FORA do prazo</option>
                        <option value="com_produtos_dentro_prazo">Exibir Fornecedores COM produtos DENTRO do prazo</option>-->
                    </select>
                </div>



                <table class="table">
                    <tr>
                        <th style="width: 15%;">Resumo do Território</th>
                        <th style="width: 85%;">Detalhamento</th>
                    </tr>
                    <tr v-for="(t, key) in territorio">
                        <td>
                            <span class="badge" style="width: 100%; padding: 5px"> {{t.territorio_nm}} </span>

                            <table class="table">
                                <tr>
                                    <td>Emprendimentos</td>
                                    <td>
                                        <span class="badge"> {{t.entidades.length}}</span>
                                        <!-- <b style="font-size: 15px;">{{t.entidades.length}}</b> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>Produtos</td>
                                    <td>
                                        <span class="badge"> {{t.produto_qtd??'xx'}} </span>
                                        <!-- <b style="font-size: 15px;">{{t.produto_qtd??'xx'}} </b> -->
                                    </td>
                                     
                                </tr>
                                <tr>
                                    <th colspan="2">Prazo do preço <?= DIAS_VALIDADE_PRECO ?> dia(s)</th>
                                </tr>
                                <tr>
                                    <td>No Prazo</td>
                                    <td>
                                        <span class="badge" style="background-color: green;"> {{t.produto_qtd_no_prazo??'xx'}} </span>
                                        <!-- <b style="font-size: 15px;">{{t.produto_qtd??'xx'}} </b> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fora do prazo</td>
                                    <td>
                                        <span class="badge" style="background-color: red;"> {{t.produto_qtd_fora_prazo??'xx'}} </span>
                                        <!-- <b style="font-size: 15px;">{{t.produto_qtd??'xx'}} </b> -->
                                    </td>
                                </tr>
                            </table>

                        </td>
                        <td>

                            <table class="table">
                                <!-- <tr>
                                    <th style="width: 40%;">Entidade</th>
                                    <th>-</th>
                                </tr> -->
                                <tr v-for="(e, ekey) in t.entidades">
                                    <!-- <td>
                                        <span class="badge"> {{ekey+1}} </span>
                                    </td> -->
                                    <td style="width: 30%;">
                                        <table class="table" style="width: 100%;">
                                            <tr>
                                                <td style="width: 10%;"><b>Fornecedor</b></td>
                                                <td>
                                                    <!-- <span class="badge"> {{ekey +1}}</span> -->
                                                    {{e.pessoa_nm}} - {{e.pessoa_id}}

                                                </td>
                                                <!--td><pre>{{e.sql}}</pre></td>-->
                                            </tr>
                                            <tr>
                                                <td><b>Fantasia</b></td>
                                                <td>{{e.pessoa_nm_fantasia}}</td>
                                            </tr>
                                            <tr>
                                                <td><b>CNPJ</b></td>
                                                <td>{{e.pessoa_cnpj??'Não tem'}}</td>
                                            </tr>
                                            <tr>
                                                <td><b>CAF/DAP</b></td>
                                                <td>{{e.pessoa_dap}}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Municipio</b></td>
                                                <td>{{e.municipio_nm}}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Contato</b></td>
                                                <td>

                                                    <span class="badge" v-if="e.responsavel_telefone">{{ e.responsavel_telefone }}</span>

                                                    <a v-if="e.responsavel_telefone"
                                                        :href="'https://wa.me/55' + telefoneZap(e.responsavel_telefone) +  '?text=' + encodeURIComponent(saudacao() + ', meu contato é referente ao sistema Cotacao Rural da SDR - Secretaria de Desenvolvimento Rural')"
                                                        target="_blank">
                                                        <span class="badge" style="background-color: green;">Abrir WhatsApp</span>
                                                    </a>


                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>E-mail</b></td>
                                                <td>
                                                    {{e.fornecedor_email}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table class="table" v-if="e.produto_preco.length > 0">
                                            <tr>
                                                <th style="width: 5%;">-</th>
                                                <th style="width: 50%;">Produto</th>
                                                <th>Preço</th>
                                                <th>Data do cadastro PREÇO</th>
                                                <th>Validade do PREÇO <br> (+ {{DIAS_VALIDADE_PRECO}} dias)</th>
                                                <th>Status</th>
                                            </tr>
                                            <tr v-for="(p, pkey) in e.produto_preco">
                                                <td>
                                                    <span class="badge"> {{pkey+1}} </span>
                                                </td>
                                                <td>{{p.produto_nm}}</td>
                                                <td>{{moedaBR(p.produto_preco_territorio_valor)}}</td>
                                                <td>{{dataToBR(p.produto_preco_territorio_dt_cadastro)}}</td>
                                                <td>
                                                    <span class="badge">{{dataToBR(p.produto_preco_dt_validade??'')}}</span>
                                                </td>

                                                <td>
                                                    <span class="badge verde" v-if="p.status_validade=='Dentro do Prazo'">{{p.status_validade}}</span>
                                                    <span class="badge vermelho" v-if="p.status_validade=='Fora do Prazo'">{{p.status_validade}}</span>
                                                </td>
                                            </tr>
                                        </table>
                                        <div v-else >
                                            <span class="badge" style="background-color: red;">Nenhum Preço Cadastrado</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </div>

        </form>
    </div>
    <style>
        .verde {
            background-color: green;
            color: white;
        }

        .vermelho {
            background-color: red;
            color: white;
        }
    </style>
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
                    flag_exibir_produtos: 'todos',
                    carregando: false,
                    q: '<?= $q ?>',
                    message: '',
                    acompanhamento_data: <?= $acompanhamento_data ?>,
                    total_rows: <?= $total_rows ?>,
                    territorio: <?= $territorio ?>,
                    territorio_todos: <?= $territorio_todos ?>,
                    acompanhamento_territorio_in: <?= $acompanhamento_territorio_in ?>,
                    lista_seguindo_territorio_id: [],
                    DIAS_VALIDADE_PRECO: <?= DIAS_VALIDADE_PRECO ?>
                }
            },
            methods: {
                dataToBR,
                dataToBRcomHora,
                moedaBR,
                async marcar_todos_territorio() {
                    this.territorio_todos.map(t => {
                        t.checked = true;
                    });
                    await this.atualiza_territorio();
                },
                async desmarcar_todos_territorio() {
                    this.territorio_todos.map(t => {
                        t.checked = false;
                    });
                    await this.atualiza_territorio();
                },
                calcula_qtd_produtos: function() {
                    let qtd = 0;
                    this.territorio.map(i => {
                        i.produto_qtd = 0; // Inicializa o produto_qtd corretamente
                        i.produto_qtd_no_prazo = 0;
                        i.produto_qtd_fora_prazo = 0;
                        i.entidades.map(e => {

                            e.produto_preco.map(pp => {
                                i.produto_qtd++

                                // console.table(pp)
                                if (pp.status_validade === 'Dentro do Prazo') {
                                    i.produto_qtd_no_prazo++
                                }
                                if (pp.status_validade === 'Fora do Prazo') {
                                    // alert(pp.status_validade)
                                    i.produto_qtd_fora_prazo++;

                                }
                            })


                        })
                    })
                },
                telefoneZap: function(telefone) {
                    //tem q remover espaços, caracteres eespeciais
                    telefone = telefone.replace(/\D/g, '');
                    telefone = telefone.replace(/\s/g, '');
                    telefone = telefone.replace(/\+/g, '');
                    telefone = telefone.replace(/\(/g, '');
                    telefone = telefone.replace(/\)/g, '');
                    telefone = telefone.replace(/\-/g, '');
                    telefone = telefone.replace(/\./g, '');
                    telefone = telefone.replace(/\s/g, '');
                    return telefone;
                },
                saudacao() {
                    const hora = new Date().getHours();
                    if (hora >= 5 && hora < 12) return "Ola, Bom dia";
                    if (hora >= 12 && hora < 18) return "Ola, Boa tarde";
                    return "Ola, Boa noite";
                },
                limpaFiltro: function() {
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    this.carregando = true;
                    this.territorio = [];
                    let url = '<?= site_url('acompanhamento/index') ?>?q=' + this.q + '&format=json' + '&flag_exibir_produtos=' + this.flag_exibir_produtos;
                    // window.open(url, '_blank');
                    let result = await fetch(url);
                    let json = await result.json();
                    console.log(json)
                    this.territorio = json;
                    this.carregando = false;
                    //alert(this.carregando )
                },
                atualiza_territorio: async function() {
                    this.carregando = true;
                    var form = document.getElementById('form');
                    form.action = '<?= site_url('acompanhamento/atualizar_seguindo_territorio') ?>'; // Define a nova action para o formulário

                    // console.log(this.lista_seguindo_territorio_id)

                    $('#form').submit()
                    // this.carregando = false;
                }
            },
            mounted() {
                this.calcula_qtd_produtos()
            },
        })

        app.mount('#app');
    </script>
</body>

</html>
<?php include '../template/end.php'; ?>