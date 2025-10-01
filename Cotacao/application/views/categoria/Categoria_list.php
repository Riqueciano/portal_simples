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
    <div id='app' v-cloak></div>
    <!--###app###-->
    <template id='app-template'>
        <div>
            <h2 style="margin-top:0px">Listagem - categoria</h2>
            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                    <?php echo anchor(site_url('categoria/create'), 'Novo', 'class="btn btn-success"'); ?>
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
                    <!--form action="<?php echo site_url('categoria/index'); ?>" class="form-inline" method="get"-->
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
                <div class='row'>
                    <div class="col-md-12">
                        <table class="table table-striped" style="margin-bottom: 10px">
                            <tr>
                                <!--th>No</th-->
                                <th align='center'>-</th>
                                <th>Categoria</th>
                                <th>Produtos</th>

                            </tr>
                            <tr v-for="(i, index) in categoria_data">
                                <td style="text-align:center" width="100px">
                                    <a class='glyphicon glyphicon-search' title='Consultar' :href="'<?= site_url('categoria/read/') ?>' + i.categoria_id"></a>
                                    |
                                    <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('categoria/update/') ?>' + i.categoria_id "></a>
                                    |
                                    <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('categoria/delete/') ?>' + i.categoria_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                                </td>
                                <td>{{i.categoria_nm}} </td>
                                <td>
                                    <table  v-show="i.produtos.length>0" class="table">
                                        <tr>
                                            <th>-</th>
                                            <th> <p style="padding: 5px;">Produtos</p></th>
                                        </tr>
                                        <tr v-for="(p, pkey) in i.produtos">
                                            <td>{{pkey+1}}</td>
                                            <td>{{p.produto_nm?.toUpperCase()}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </div> 

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
    </template>

    <script>
        new Vue({
            el: "#app",
            template: "#app-template",
            data: {
                q: '<?= $q ?>',
                message: '',
                categoria_data: <?= $categoria_data ?>,
                total_rows: <?= $total_rows ?>,
            },
            methods: {
                limpaFiltro: function() {
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    let url = '<?= site_url('categoria/index') ?>?q=' + this.q + '&format=json';
                    let result = await fetch(url);
                    let json = await result.json();
                    this.categoria_data = json;
                }
            },
            mounted() {

            },
        });
    </script>
</body>

</html>
<?php include '../template/end.php'; ?>