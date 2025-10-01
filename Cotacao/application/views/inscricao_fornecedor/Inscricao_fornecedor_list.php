<?php include '../template/begin.php'; ?>

<html>

<head>
    <title>SDR</title>
    <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->
    <style>

    </style>
</head>

<body>
    <!--###app###-->
    <style>
        [v-cloak] {
            display: none;
        }

        .td-label {
            max-width: 300px;
            width: 200px;
            word-wrap: break-word;
            word-break: break-word;
            vertical-align: top;
        }

        .td-content {
            max-width: 400px;
            word-wrap: break-word;
            word-break: break-word;
        }
    </style>
    <div id='app' v-cloak>
        <h2 style="margin-top:0px">Listagem - de Fornecedores inscritos</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-3">
                <?php echo anchor(site_url('inscricao_fornecedor/create'), 'Novo', 'class="btn btn-success"'); ?>
            </div>

            <div class="col-md-6">
                <table>
                    <tr>
                        <td><b>Território</b>
                            <select name="territorio" id="territorio" v-model="filtro_territorio_id" class="form-control" @change="ajax_carrega_municipios_por_territorio">
                                <option value="">Selecione</option>
                                <option v-for="t in territorio" :value="t.territorio_id">{{t.territorio_nm?.toUpperCase()}}</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Município</b>
                            <select name="municipio" id="municipio" v-model="filtro_municipio_id" class="form-control" @change="atualizaLista()">
                                <option value="">Selecione</option>
                                <option v-for="m in municipio" :value="m.municipio_id">{{m.municipio_nm?.toUpperCase()}}</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-3  ">
                <br>
                <!--form action="<?php echo site_url('inscricao_fornecedor/index'); ?>" class="form-inline" method="get"-->
                <div class=" ">
                    <input type="text" class="form-control" name="q" v-model="q" placeholder="Procurar">
                    <span>
                        <button class="btn btn-primary" type="button" style="width: 100%" @click='atualizaLista()'>Procurar</button>
                        <br>
                        <button class="btn btn-warning" @click='limpaFiltro()' style="width: 100%">Limpar filtros</button>


                    </span>
                </div>
                <!--/form-->
            </div>
        </div>
        <img src="<?= iPATHGif ?>/risco_infinito.gif" alt="" style="width: 20%;" v-show="carregando">
        <div class="row" v-show="!carregando">
            <div class="col-md-12">
                <table class="table table-striped" style="margin-bottom: 10px">
                    <tr>
                        <td colspan="3" align="center">
                            <h2><i class="glyphicon glyphicon-user"></i>Cadastros externos</h2>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1" align="center">
                            Aguardando Autorização  xxxx
                        </td>
                        <td colspan="2">
                            <input type="button" value="Exibir Aguardando Autorização" class="btn-sm btn-danger btn">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-primary btn-sm">Total: {{inscricao_fornecedor_data.length}}</a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <?php echo $pagination ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <!-- <th align='center'>-</th> -->
                        <th>Responsável</th>
                        <th>E-mail | telefone(whatsapp)</th>
                        <th>Fornecedor </th>
                    </tr>
                    <tr v-for="(i, index) in inscricao_fornecedor_data">
                        <td>{{i.responsavel_nm?.toUpperCase()}} </td>

                        <td>
                            <table class="table">
                                <tr>
                                    <td class="td-label"><b>Fornecedor</b></td>
                                    <td class="td-content">{{i.fornecedor_nm?.toUpperCase()}}</td>
                                </tr>
                                <tr>
                                    <td class="td-label"><b>E-mail | telefone(whatsapp)</b></td>
                                    <td class="td-content"><b>{{i.fornecedor_email?.toUpperCase()}}</b><br>{{i.responsavel_telefone}}</td>
                                </tr>
                                <tr>
                                    <td class="td-label"><b>Nome Fantasia</b></td>
                                    <td class="td-content">{{i.fornecedor_nm_fantasia?.toUpperCase()}}</td>
                                </tr>
                                <tr>
                                    <td class="td-label"><b>CPF</b></td>
                                    <td class="td-content">{{i.responsavel_cpf}}</td>
                                </tr>
                                <tr>
                                    <td class="td-label"><b>CNPJ</b></td>
                                    <td class="td-content">{{i.fornecedor_cnpj}}</td>
                                </tr>
                                <tr>
                                    <td class="td-label"><b>DAP/CAF</b></td>
                                    <td class="td-content">{{i.dap_caf?.toUpperCase()}}</td>
                                </tr>
                                <tr>
                                    <td class="td-label"><b>Whatsapp</b></td>
                                    <td class="td-content">{{i.responsavel_telefone}}</td>
                                </tr>
                                <tr>
                                    <td class="td-label"><b>Categoria</b></td>
                                    <td class="td-content">{{i.fornecedor_categoria_nm?.toUpperCase()}}</td>
                                </tr>
                                <tr>
                                    <td class="td-label"><b>Municipio/Território</b></td>
                                    <td class="td-content">
                                        <b>{{i.municipio_nm?.toUpperCase()}}</b><br>
                                        <b class="green">{{i.territorio_nm?.toUpperCase()}}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-label"><b>Data do Cadastro</b></td>
                                    <td class="td-content">{{dataToBRcomHora(i.dt_cadastro)}}</td>
                                </tr>
                            </table>

                        </td>
                        <td>

                            <div v-if="!i.fornecedor_pessoa_id" v-show="!i.reprovado_motivo">
                                <a :href="'<?= site_url('inscricao_fornecedor/aprovacao_fornecedor_action/') ?>' + i.inscricao_fornecedor_id " onclick="javascript: return confirm('Tem certeza que deseja Aprovar este cadastro?\nLogin e senha são enviados para o Fornecedor acessar o sistema')">
                                    <input type="button" value="Aprovar" class="btn-sm btn-success btn">
                                </a>
                                <input type="button" value="Reprovar" class="btn-sm btn-danger btn" @click="ajax_reprovar_inscricao_fornecedor(i.inscricao_fornecedor_id)">
                            </div>



                            <div v-if="i.fornecedor_pessoa_id && !i.reprovado_motivo">
                                <b class="green">Fornecedor APROVADO</b>
                            </div>

                            <div v-if="i.reprovado_motivo">
                                <b class="red">Fornecedor REPROVADO</b>
                            </div>
                            <div v-show="i.fornecedor_pessoa_id">
                                <br>

                                <div class="alert alert-success" role="alert">
                                    <b>Aprovado</b> <br>
                                    <small>fornecedor_pessoa_id = {{i.fornecedor_pessoa_id}}</small>
                                </div>
                            </div>

                            <br>
                            <br>


                            <div v-show="i.fornecedor_pessoa_id">
                                <div class="badge" v-show="i.inscricao_fornecedor_email_aberto==1" style="background-color: green;">Primeiro EMAIL com login enviado foi LIDO</div>

                                <div class="badge" v-show="i.inscricao_fornecedor_email_aberto==0" style="background-color: red;">Primeiro EMAIL com login enviado NÃO LIDO</div>
                            </div>




                            <table class="table table-striped" v-show="false">
                                <tr>
                                    <td><b>Histórico</b></td>
                                    <td><b>Data</b></td>
                                </tr>
                                <tr v-for="h in i.inscricao_fornecedor_historico">
                                    <td>{{h.inscricao_fornecedor_historico_acao}} </td>
                                    <td>{{dataToBRcomHora(h.inscricao_fornecedor_historico_dt)}}</td>
                                </tr>
                            </table>
                            <table class="table">
                                <tr v-if="i.fornecedor_pessoa_id && !i.reprovado_motivo && i.pessoa_st == 0">
                                    <td class="td-label"><b></td>
                                    <td class="td-content">
                                        <div>
                                            <input type="button" value="Inativar" class="btn-sm btn-warning btn" @click="ajax_inativar_usuario(i.fornecedor_pessoa_id)">
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="i.ultimo_login">
                                    <td class="td-label"><b>Último Login</b></td>
                                    <td class="td-content">{{dataToBRcomHora(i.ultimo_login)}}</td>
                                </tr>
                                <tr v-if="i.registros_email_login > 1">
                                    <td class="td-label"><b class="red">E-mail Duplicado Login</b></td>
                                    <td class="td-content red">Existem {{i.registros_email_login}} registros com esse e-mail.</td>
                                </tr>
                                <tr v-if="i.registros_email_inscricao > 1">
                                    <td class="td-label"><b class="red">Inscrições com email Duplicado </b></td>
                                    <td class="td-content red">Existem {{i.registros_email_inscricao}} registros com esse e-mail.</td>
                                </tr>
                                <tr v-if="i.numero_produtos_ativos">
                                    <td class="td-label"><b class="text-warning">Produtos Ativos</b></td>
                                    <td class="td-content">{{i.numero_produtos_ativos}}</td>
                                </tr>
                                <tr v-if="i.numero_produtos_inativos">
                                    <td class="td-label"><b class="text-warning">Produtos Inativos</b></td>
                                    <td class="td-content">{{i.numero_produtos_inativos}}</td>
                                </tr>
                                <tr v-if="i.pessoa_st == 1">
                                    <td class="td-label"><b class="red">Status</b></td>
                                    <td class="td-content red">Usuário INATIVO</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </div>
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <td colspan="3" align="center">
                            <h2> <i class="glyphicon glyphicon-user"></i> Lista de Fornecedores Ativos</h2>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <input type="button" :value="'Usuários Ativos ' + usuarios_fornecedor.length" class="btn-sm btn-primary btn">
                        </td>
                    </tr>
                    <tr>
                        <th>Usuário | Fornecedor</th>
                        <th style="width: 30%;">CNPJ</th>
                        <th>Login</th>
                    </tr>
                    <tr v-for="(u,ukey) in usuarios_fornecedor">
                        <td>
                            <b>{{u.pessoa_nm?.toUpperCase()}}</b>
                            <br>
                            id: {{u.pessoa_id}}
                        </td>
                        <td>{{u.pessoa_cnpj?.toUpperCase()}}</td>
                        <td>{{u.usuario_login?.toUpperCase()}}</td>
                    </tr>
                </table>
            </div>
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
                    q: '<?= $q ?>',
                    message: '',
                    inscricao_fornecedor_data: <?= $inscricao_fornecedor_data ?>,
                    total_rows: <?= $total_rows ?>,
                    territorio: <?= $territorio ?>,
                    municipio: <?= $municipio ?>,
                    usuarios_fornecedor: <?= $usuarios_fornecedor ?>,
                    filtro_territorio_id: "",
                    filtro_municipio_id: "",
                    carregando: false,
                }
            },
            methods: {
                dataToBR,
                dataToBRcomHora,
                moedaBR,
                ajax_carrega_municipios_por_territorio: async function() {
                    let url = '<?= site_url('municipio/ajax_carrega_municipios_por_territorio') ?>/?territorio_id=' + this.filtro_territorio_id;
                    // console.log(url);
                    let result = await fetch(url);
                    let json = await result.json();
                    this.municipio = json;
                    await this.atualizaLista();
                },
                ajax_reprovar_inscricao_fornecedor: async function(inscricao_fornecedor_id) {
                    let motivo = prompt("Favor informar o motivo da reprovação.\nAtenção está mensagem será enviada por e-mail ao solicitante");
                    if (!motivo) {
                        alert("Favor informar o motivo");
                        return false
                    }
                    let conf = confirm("Atenção! Está ação é irreversível, deseja continuar?");
                    if (conf == false) {
                        return false
                    }

                    let url = '<?= site_url('inscricao_fornecedor/ajax_reprovar_inscricao_fornecedor') ?>/' + inscricao_fornecedor_id + "/?motivo=" + motivo;
                    //   alert(url)
                    let result = await fetch(url);
                    let json = await result.json();

                    await this.atualizaLista();
                    // window.location.reload(true);
                },
                ajax_inativar_usuario: async function(pessoa_id) {
                    let conf = confirm("Atenção! Está ação irá inativar o usuário, deseja continuar?");
                    if (conf == false) {
                        return false
                    }

                    let url = '<?= site_url('pessoa/ajax_inativar_usuario') ?>?pessoa_id=' + pessoa_id;

                    //   alert(url)
                    let result = await fetch(url);
                    let json = await result.json();

                    await this.atualizaLista();
                    // window.location.reload(true);
                },
                limpaFiltro: function() {
                    this.q = '';
                    this.filtro_territorio_id = '';
                    this.filtro_municipio_id = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    this.carregando = true;
                    // this.inscricao_fornecedor_data = [];
                    let param = 'q=' + this.q + '&format=json';
                    param += '&filtro_territorio_id=' + this.filtro_territorio_id;
                    param += '&filtro_municipio_id=' + this.filtro_municipio_id;

                    let url = '<?= site_url('inscricao_fornecedor/index') ?>?' + param;
                    console.log(url)
                    let result = await fetch(url);
                    let json = await result.json();
                    this.inscricao_fornecedor_data = json;

                    await this.atualizaListaUsuarios();
                    this.carregando = false;
                },
                atualizaListaUsuarios: async function() {
                    // this.usuarios_fornecedor = [];
                    let param = 'q=' + this.q + '&format=json_usuarios';
                    param += '&filtro_territorio_id=' + this.filtro_territorio_id;
                    param += '&filtro_municipio_id=' + this.filtro_municipio_id;

                    let url = '<?= site_url('inscricao_fornecedor/index') ?>?' + param;
                    // console.log(url)
                    let result = await fetch(url);
                    let json = await result.json();
                    this.usuarios_fornecedor = json;
                }
            },
            mounted() {

            },
        })

        app.mount('#app');
    </script>
</body>

</html>
<?php include '../template/end.php'; ?>