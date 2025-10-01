<?php

include '../template/begin.php'; ?>

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
            <div class='row'>
                <h2><i class="glyphicon glyphicon-tag"></i> Totalizadores</h2>
                <div v-show="carregando">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Carregando...</span>
                        <img src="<?= iPATHGif ?>Disk.gif" alt="Carregando...">
                    </div>
                </div>
                <div class='col-md-4' v-show="!carregando">

                    <b>Território:</b>
                    <select v-model="param_territorio_id" class="form-control" @change="ajax_atualiza_totais()"  >
                        <option value="">#BAHIA#</option>
                        <option v-for="t in territorio" :value="t.territorio_id">{{t.territorio_nm?.toUpperCase()}}</option>
                    </select>
                    <table class="table table-striped"  >
                        <tr>
                            <th colspan="2">Indicadores de Fornecedor</th>
                        </tr>
                        <tr>
                            <td><b>Total de Fornecedores cadastrados</b></td>
                            <td>{{totais.fornecedores_cadastrados}}</td>
                        </tr>
                        <tr>
                            <td><b>Total de PF cadastrados COM PREÇO ATIVO</b></td>
                            <td>{{totais.fornecedores_cadastrados_pf_com_preco}}</td>
                        </tr>
                        <tr>
                            <td><b>Total de PF cadastrados SEM PREÇO ATIVO</b></td>
                            <td>{{totais.fornecedores_cadastrados_pf_sem_preco}}</td>
                        </tr>
                        <tr>
                            <td><b>Total de PJ cadastrados COM PREÇO ATIVO</b></td>
                            <td>{{totais.fornecedores_cadastrados_pj_com_preco}}</td>
                        </tr>
                        <tr>
                            <td><b>Total de PJ cadastrados SEM PREÇO ATIVO</b></td>
                            <td>{{totais.fornecedores_cadastrados_pj_sem_preco}}</td>
                        </tr>
                        <tr>
                            <td><b>Quantidade de Produtos (com preço)</b></td>
                            <td><span class="">{{totais.produtos_qtd}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Quantidade de Preços - ATIVOS </b></td>
                            <td><span>{{totais.precos_qtd}}</span></td>
                        </tr>
                        <!--    tr>
                            <td><b>Quantidade de Preços - INATIVOS </b></td>
                            <td><span>{{totais.precos_qtd_inativos}}</span></td>
                        </tr>-->
                    </table>
                </div>
                <div class="col-md-3" v-show="!carregando">
                    <table class="table">
                        <tr>
                            <th>Categoria - Fornecedor</th>
                            <th>Quantidade de Fornecedores</th>
                        </tr>
                        <tr v-for="f in totais.fornecedor_categoria">
                            <td>{{f.fornecedor_categoria_nm}}</td> 
                            <td>{{f.fornecedores?.length}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-3" v-show="!carregando">
                    <table class="table">
                        <tr>
                            <th>Categoria - Comprador</th>
                            <th>Quantidade de Compradores</th>
                        </tr>
                        <tr v-for="f in totais.comprador_categoria">
                            <td>{{f.comprador_categoria_nm}}</td> 
                            <td>{{f.compradores?.length}}</td>
                        </tr>
                    </table>
                </div>
            </div>



        </div>
    </template>

    <script>
        new Vue({
            el: "#app",
            template: "#app-template",
            data: {
                carregando: false,
                param_territorio_id: '',
                visivel_cotacoes: false,
                visivel_produtos: false,
                visivel_categorias: false,
                visivel_usuarios: false,
                visivel_fornecedores: false,
                pessoa_nm: '<?= $_SESSION['pessoa_nm'] ?>',
                perfil: '<?= $_SESSION['perfil'] ?>',
                message: '',
                territorio: <?= $territorio ?>,
                totais: <?= $totais ?>,

            },
            methods: {
                ajax_atualiza_totais: async function() {
                    this.carregando = true;
                    let url = '<?= site_url('cotacao/calcula_indicadores') ?>?territorio_id=' + this.param_territorio_id + '&format=json';
                    // window.open(url, '_blank');
                    let result = await fetch(url);
                    let json = await result.json();
                    this.totais = json;

                    console.log(json);
                    this.carregando = false;
                },
                limpaFiltro: function() {
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    let url = '<?= site_url('cotacao/index') ?>?q=' + this.q + '&format=json';
                    let result = await fetch(url);
                    let json = await result.json();
                    this.cotacao_data = json;
                },
                formatarParaMoeda: function(numero) {
                    return new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    }).format(numero);
                },

                exibir_filtros: function(campo) {
                    if (campo == 'cotacoes') {
                        this.visivel_cotacoes = true
                        this.visivel_produtos = false
                        this.visivel_categorias = false
                        this.visivel_usuarios = false
                        this.visivel_fornecedores = false
                    }
                    if (campo == 'produtos') {
                        this.visivel_cotacoes = false
                        this.visivel_produtos = true
                        this.visivel_categorias = false
                        this.visivel_usuarios = false
                        this.visivel_fornecedores = false
                    }
                    if (campo == 'usuarios') {
                        this.visivel_cotacoes = false
                        this.visivel_produtos = false
                        this.visivel_categorias = false
                        this.visivel_usuarios = true
                        this.visivel_fornecedores = false
                    }
                    if (campo == 'categorias') {
                        this.visivel_cotacoes = false
                        this.visivel_produtos = false
                        this.visivel_usuarios = false
                        this.visivel_categorias = true
                        this.visivel_fornecedores = false
                    }
                    if (campo == 'fornecedores') {
                        this.visivel_cotacoes = false
                        this.visivel_produtos = false
                        this.visivel_usuarios = false
                        this.visivel_categorias = false
                        this.visivel_fornecedores = true
                    }
                },
                formatarData: function(data) {
                    // Criar um objeto Date a partir da string de data fornecida
                    const date = new Date(data);

                    // Extrair os componentes da data
                    const dia = String(date.getDate()).padStart(2, '0');
                    const mes = String(date.getMonth() + 1).padStart(2, '0'); // Mês começa em 0
                    const ano = date.getFullYear();

                    // Extrair os componentes do tempo
                    const horas = String(date.getHours()).padStart(2, '0');
                    const minutos = String(date.getMinutes()).padStart(2, '0');
                    const segundos = String(date.getSeconds()).padStart(2, '0');

                    // Formatar a data e a hora no formato desejado
                    const dataFormatada = `${dia}/${mes}/${ano} ${horas}:${minutos}:${segundos}`;

                    return dataFormatada;
                }
            },
            mounted() {

            },
        });
    </script>
</body>

</html>
<?php include '../template/end.php'; ?>