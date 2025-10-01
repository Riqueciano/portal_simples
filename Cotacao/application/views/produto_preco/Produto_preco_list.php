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
            <h2 style="margin-top:0px">Listagem - produto_preco</h2>
            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                    <?php echo anchor(site_url('produto_preco/create'), 'Novo', 'class="btn btn-success"'); ?>
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
                    <!--form action="<?php echo site_url('produto_preco/index'); ?>" class="form-inline" method="get"-->
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
                        <th>Produto Id</th>
                        <th>Pessoa Id</th>
                        <th>Valor</th>
                        <th>Produto Preco Dt</th>
                        <th>Ativo</th>

                    </tr>
                    <tr v-for="(i, index) in produto_preco_data">
                        <td style="text-align:center" width="100px">
                            <a class='glyphicon glyphicon-search' title='Consultar' :href="'<?= site_url('produto_preco/read/') ?>' + i.produto_preco_id"></a>
                            |
                            <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('produto_preco/update/') ?>' + i.produto_preco_id "></a>
                            |
                            <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('produto_preco/delete/') ?>' + i.produto_preco_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                        </td>
                        <td>{{i.produto_nm}} </td>
                        <td>{{i.pessoa_nm}} </td>
                        <td>{{i.valor}} </td>
                        <td>{{dataToBRcomHora(i.produto_preco_dt)}} </td>
                        <td>{{i.ativo}} </td>
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
    </template>

    <script>
        new Vue({
            el: "#app",
            template: "#app-template",
            data: {
                q: '<?= $q ?>',
                message: '',
                produto_preco_data: <?= $produto_preco_data ?>,
                total_rows: <?= $total_rows ?>,
            },
            methods: {
                limpaFiltro: function() {
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    let url = '<?= site_url('produto_preco/index') ?>?q=' + this.q + '&format=json';
                    let result = await fetch(url);
                    let json = await result.json();
                    this.produto_preco_data = json;
                }
            },
            mounted() {

            },
        });
    </script>
</body>

</html>
<?php include '../template/end.php'; ?>