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
    </style>
    <div id='app' v-cloak>
        <h2 style="margin-top:0px">Listagem - Inscritos</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('inscricao/create'), 'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                    ?>
                </div>
            </div>
            <div class="col-md-2 text-right">
            </div>
            <div class="col-md-3 text-right">
                <!--form action="<?php echo site_url('inscricao/index'); ?>" class="form-inline" method="get"-->
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
            <div class="col-md-10">
                <table class="table table-striped" style="margin-bottom: 10px">
                    <tr>
                        <th>Comprador/categoria</th>
                        <!-- <th align='center'>-</th> -->
                        <th>Responsavel</th>
                        <th> Email</th>
                        <!-- <th>Mensagem</th> -->
                        <th>Criado em:</th>
                        <th>CNPJ</th>
                        <th>Municipio</th>
                        <th> - </th>
                    </tr>
                    <tr v-for="(i, index) in inscricao_data">
                        <!-- <td style="text-align:center" width="100px">
                            <a class='glyphicon glyphicon-search' title='Consultar' :href="'<?= site_url('inscricao/read/') ?>' + i.inscricao_id"></a>
                            |
                            <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('inscricao/update/') ?>' + i.inscricao_id "></a>
                            |
                            <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('inscricao/delete/') ?>' + i.inscricao_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                        </td> -->
                        <td>
                            {{ i.comprador_nm?.toUpperCase() }}
                            <br> <b class="red">{{ i.comprador_categoria_nm?.toUpperCase() }}</b>
                        </td>
                        <td>{{ i.responsavel_nm?.toUpperCase() }} </td>
                        <td>{{ i.responsavel_email?.toUpperCase() }} </td>
                        <td>{{ dataToBRcomHora(i.dt_create) }} </td>
                        <td>{{ i.cnpj }} </td>
                        <td>{{ i.municipio_nm }} </td>
                        <td>
                            <table class="table table-bordered table-sm" style="margin: 0; width: 100%;">
                                <tr>
                                    <td class="td-label"><b>Último Acesso:</b></td>
                                    <td class="td-content">
                                        {{ i.ultimo_login ? dataToBRcomHora(i.ultimo_login) : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-label"><b>Nº Cotações:</b></td>
                                    <td class="td-content">
                                        {{ i.numero_cotacoes ?? 0 }}
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                </table>
            </div>
            <div class="col-md-2">
                <table class="table">
                    <tr>
                        <th>Território</th>
                        <th>Quantidade</th>
                    </tr>
                    <tr v-for="(t, index) in territorio">
                        <td>{{t.territorio_nm?.toUpperCase()}}</td>
                        <td>

                            <div v-show="t.qtd_usuarios == 0"> {{t.qtd_usuarios}}</div>
                            <badge class="badge badge-success" v-show="t.qtd_usuarios > 0">{{t.qtd_usuarios}}</badge>
                        </td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>
                            <badge class="badge badge-success">{{inscricao_data.length}}</badge>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row" v-show="q.length == 0">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Linhas: {{total_rows}}</a>
            </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
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
                    q: '<?= $q ?>',
                    message: '',
                    inscricao_data: <?= $inscricao_data ?>,
                    total_rows: <?= $total_rows ?>,
                    territorio: <?= $territorio ?>,
                }
            },
            methods: {
                dataToBR,
                dataToBRcomHora,
                limpaFiltro: function() {
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    let url = '<?= site_url('inscricao/index') ?>?q=' + this.q + '&format=json';
                    console.log(url);
                    let result = await fetch(url);
                    let json = await result.json();
                    this.inscricao_data = json;
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