<?php
//nao é esse
//include '../template/begin.php'; ?>

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
                <div class='col-md-3'>
                    <h2 style="margin-top:0px">Indicadores</h2>

                    <input type="button" value="Exibir Todas Cotações" class="btn btn-sm btn-success" @click="exibir_filtros('cotacoes')" style="width: 250px;"> <br>
                    <input type="button" value="Produtos x qtd cotações" class="btn btn-sm btn-success" @click="exibir_filtros('produtos')" style="width: 250px;"> <br>
                    <input type="button" value="Categorias x qtd cotações" class="btn btn-sm btn-success" @click="exibir_filtros('categorias')" style="width: 250px;"> <br>
                    <input type="button" value="Usuários x Perfil" class="btn btn-sm btn-success" @click="exibir_filtros('usuarios')" style="width: 250px;"> <br>
                    <input type="button" value="Fornecedores x Produtos" class="btn btn-sm btn-success" @click="exibir_filtros('fornecedores')" style="width: 250px;"> <br>


                    <a href="<?= site_url('cotacao/indicadores_media') ?>">
                        <input type="button" value="Preço médio (bahia x território)" class="btn btn-sm btn-success" style="width: 250px;"> <br>
                    </a>
                    <a href="<?= site_url('produto_preco/qualidade_preco') ?>" target="_blank">
                        <input type="button" value="Avaliar qualidade do preço - TESTE" class="btn btn-sm btn-success" style="width: 250px;"> <br>
                    </a>
                </div>
                <div v-show="carregando">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Carregando...</span>
                        <img src="<?= iPATHGif ?>Disk.gif" alt="Carregando...">
                    </div>
                </div>
                <div class='col-md-9' v-show="!carregando">
                   
                    <b>Território:</b>
                    <select v-model="param_territorio_id" class="form-control" @change="ajax_atualiza_totais()" style="width: 30%;">
                        <option value="">.:BAHIA:.</option>
                        <option v-for="t in territorio" :value="t.territorio_id">{{t.territorio_nm?.toUpperCase()}}</option>
                    </select>
                    <table class="table table-striped" style="width: 30%;">
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
                            <td><b>Quantidade de Produtos (BAHIA)</b></td>
                            <td><span class="red">{{totais.produtos_qtd}}</span></td>
                        </tr> 
                        <tr>
                            <td><b>Quantidade de Preços Ativos</b></td>
                            <td><span >{{totais.precos_qtd}}</span></td>
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
                q: '<?= $q ?>',
                pessoa_nm: '<?= $_SESSION['pessoa_nm'] ?>',
                perfil: '<?= $_SESSION['perfil'] ?>',
                message: '',
                cotacao_data: <?= $cotacao_data ?>,
                territorio: <?= $territorio ?>,
                categorias: <?= $categorias ?>,
                usuarios_cotacao: <?= $usuarios_cotacao ?>,
                fornecedores: <?= $fornecedores ?>,
                produtos: <?= $produtos ?>,
                total_rows: <?= $total_rows ?>,
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