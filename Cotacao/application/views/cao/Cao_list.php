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
    <style> [v-cloak] {display: none;}</style>
    <div id='app' v-cloak>
        <div v-if='carregando' class='overlay'>
            <img src='<?= iPATHGif ?>/lego.gif' alt='Carregando' class='loading-gif' style='width: 20%; border-radius: 50px'>
        </div>
        <div :class="{ 'blurred': carregando }" >
            <h2 style="margin-top:0px">Listagem - Cotacao.cao</h2>
            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                    <?php echo anchor(site_url('cao/create'), 'Novo', 'class="btn btn-success"'); ?>
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
                    <!--form action="<?php echo site_url('cao/index'); ?>" class="form-inline" method="get"-->
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
                <table class="table table-striped" style="margin-bottom: 10px">
                    <tr>
                        <!--th>No</th-->
                        <th align='center'>-</th>
                        <th>Cao Nm</th>
                        <th>Cao</th>

                    </tr>
                    <tr v-for="(i, index) in cao_data">
                        <td style="text-align:center" width="100px">
                            <a class='glyphicon glyphicon-search' title='Consultar' :href="'<?= site_url('cao/read/') ?>' + i.cao_id"></a>
                            |
                            <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('cao/update/') ?>' + i.cao_id "></a>
                            |
                            <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('cao/delete/') ?>' + i.cao_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                        </td>
                        <td>{{i.cao_nm}} </td>
                        <td>{{i.cao}} </td>
                    </tr>

                </table>
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
                    carregando: false,
                    q: '<?= $q ?>',
                    message: '',
                    cao_data: <?= $cao_data ?>,
                    total_rows: <?= $total_rows ?>,
                }
            },
            methods: {
                dataToBR,
                dataToBRcomHora,
                moedaBR,
                limpaFiltro: function() {
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    this.carregando = true;
                    this.cao_data = [];
                    let url = '<?= site_url('cao/index') ?>?q=' + this.q + '&format=json';
                    let result = await fetch(url);
                    let json = await result.json();
                    this.cao_data = json;
                    this.carregando = false;
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