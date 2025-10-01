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
    <div id='app' v-cloak></div>
    <!--###app###-->
    <template id='app-template'>
        <div>
            <h2 style="margin-top:0px">Analise dos preços - Desvio Padrão</h2>
            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">

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

                <p>*Valores em <b class="red">Vermelho</b> estão fora do desvio padrão</p>
                <table class="table" style="width: 80%" v-show="!carregando">
                    <tr>
                        <th style="width: 40%">Território</th>
                        <th>Produto</th>
                        <th>#</th>
                    </tr>
                    <tr>
                        <td>
                            <select v-model="param_territorio_id" @change='param_produto_id = ""; atualizaLista()' class="form-control">
                                <option value="">Selecione</option>
                                <option v-for="i in territorio" :value="i.territorio_id">{{i.territorio_nm}}</option>
                            </select>
                        </td>
                        <td style="width: 50%">
                            <select v-model="param_produto_id" @change='atualizaLista()' class="form-control">
                                <option value="">Selecione</option>
                                <option v-for="i in produto" :value="i.produto_id">{{i.produto_nm}}</option>
                            </select>
                        </td>
                        <td>
                            <a href="<?= site_url('produto_preco/qualidade_preco') ?>" class="btn btn-danger">Limpar</a>
                        </td>
                    </tr>
                </table>
                <div v-show="carregando">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Carregando...</span>
                        <img src="<?= iPATHGif ?>Disk.gif" alt="Carregando...">
                    </div>
                </div>

                <b>Quantidade de Preços fora do desvio padrão: <span class="badge badge-danger" style="background-color: red;">{{quantidadeForaDoDesvioPadrao}}</span></b>
                <table class="table table-striped" style="margin-bottom: 10px">
                    <tr>
                        <!--th>No</th-->
                        <th align='center'>-</th>
                        <th>Produto</th>
                        <th>Fornecedor</th>
                        <th>Territorio</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Ativo</th>
                    </tr>
                    <tr v-for="(i, index) in produto_preco_data" v-show="!carregando">
                        <td style="text-align:center" width="100px">
                            {{index+1}}
                        </td>
                        <td>{{i.produto_nm}} </td>
                        <td>{{i.pessoa_nm}} </td>
                        <td>{{i.territorio_nm}} </td>
                        <td>
                            <span v-if="i.fora_desvio_padrao == true" class="red" style="font-size: 20px;">{{formatarParaMoeda(i.produto_preco_territorio_valor)}} </span>
                            <span v-else class="green">{{formatarParaMoeda(i.produto_preco_territorio_valor)}} </span>
                        </td>
                        <td>{{dataToBRcomHora(i.produto_preco_dt)}} </td>
                        <td>{{i.ativo==1?'Sim':'Não'}} </td>
                    </tr>

                </table>
            </div>


        </div>
    </template>

    <script>
        new Vue({
            el: "#app",
            template: "#app-template",
            data: {
                quantidadeForaDoDesvioPadrao: 0,
                carregando: false,
                territorio: <?= $territorio ?>,
                produto: <?= $produto ?>,
                param_territorio_id: '',
                param_produto_id: '',
                q: '<?= $q ?>',
                message: '',
                produto_preco_data: <?= $produto_preco_data ?>,
                total_rows: <?= $total_rows ?>,
                media: 0,
                desvioPadrao: null,
                faixa1: null,
                foraDaFaixa2: null,
                foraDaFaixa2PorProduto: {},


            },
            computed: {

            },
            methods: {

                formatarParaMoeda: function(valor) {
                    return new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    }).format(valor);
                },
                limpaFiltro: function() {
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    this.carregando = true;
                    let url = '<?= site_url('produto_preco/qualidade_preco') ?>?q=' + this.q + '&format=json' + '&param_produto_id=' + this.param_produto_id + '&param_territorio_id=' + this.param_territorio_id;
                    let result = await fetch(url);
                    let json = await result.json();
                    this.produto_preco_data = json;
                    //window.open(url);
                    await this.buscaDesvioPadrao();

                    await this.atualizaListaProduto();
                    this.carregando = false;
                },
                atualizaListaProduto: async function() {

                    if (this.param_territorio_id) {
                        //alert(this.param_territorio_id);
                        //atualiza a lista de produtos, so traz os produtos q estao em this.produto_preco_data e coloca em ordem alfabetica desconsiderando maisuculas e minuscualas+
                        this.produto = this.produto.filter(p => this.produto_preco_data.some(pp => pp.produto_id == p.produto_id));
                        this.produto.sort((a, b) => a.produto_nm.toLowerCase().localeCompare(b.produto_nm.toLowerCase()));
                    }
                },

                buscaDesvioPadrao: async function() {
                    this.quantidadeForaDoDesvioPadrao = 0;
                    // Extrai os valores como números
                    const valores = this.produto_preco_data.map(p => Number(p.produto_preco_territorio_valor));

                    // Calcula média e desvio padrão
                    const media = valores.reduce((a, b) => a + b, 0) / valores.length;
                    const variancia = valores.reduce((soma, v) => soma + Math.pow(v - media, 2), 0) / valores.length;
                    const desvio = Math.sqrt(variancia);

                    const limiteMin = media - desvio;
                    const limiteMax = media + desvio;

                    // Percorre os dados e alerta os que estão fora da faixa
                    this.produto_preco_data = this.produto_preco_data.map(p => {
                        const valor = Number(p.produto_preco_territorio_valor);
                        p.fora_desvio_padrao = false; // padrão

                        if (valor < limiteMin || valor > limiteMax) {
                            p.fora_desvio_padrao = true;
                            this.quantidadeForaDoDesvioPadrao++;
                        }

                        return p; // MUITO IMPORTANTE retornar o objeto para atualizar o array
                    });
                },



            },
            mounted() {
                //this.analisarValores();
            },
        });
    </script>
</body>

</html>
<?php include '../template/end.php'; ?>