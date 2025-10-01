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
                 
            </div>






            <div style='overflow-x:auto'>
                <table class="table table-striped" style="margin-bottom: 10px" v-show='visivel_cotacoes'>
                    <tr>
                        <!--th>No</th-->
                        <th align='center'>-</th>
                        <th>Nº</th>
                        <th>Descrição</th>
                        <th>Produto/preço medio</th>
                        <th>Solicitante</th>
                        <th>Data</th>

                        <!-- <th>Status</th> -->

                    </tr>
                    <tr v-for="(i, index) in cotacao_data">
                        <td style="text-align:center" width="100px">
                            <a title='Consultar' :href="'<?= site_url('cotacao/read/') ?>' + i.cotacao_id" target='_blank'>
                                <button class='btn bt-sm btn-warning'>
                                    <i class="glyphicon glyphicon-search"></i> Consultar
                                </button>
                            </a>
                            <!--|
                            <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('cotacao/update/') ?>' + i.cotacao_id "></a>
                            |-->
                            <!-- <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('cotacao/delete/') ?>' + i.cotacao_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a> -->
                        </td>
                        <td>{{i.cotacao_numero}} </td>
                        <td>{{i.cotacao_ds??'-'}} </td>
                        <td>
                            <table class="table">
                                <tr v-for="(po, pokey) in i.precos">
                                    <td> {{po.produto_nm}}</td>
                                    <td> {{formatarParaMoeda(po.valor)}}</td>
                                </tr>
                            </table>
                            <!-- <div v-for="(p, pkey) in i.precos">
                                {{p.produto_nm + ' - R$ '+p.valor}}
                            </div> -->
                        </td>
                        <td>
                            <table class="table">
                                <tr>
                                    <td><b>Solicitante/comprador</b< /td>
                                    <td>{{i.pessoa_nm}} </td>
                                </tr>
                                <tr>
                                    <td><b>CNPJ</b< /td>
                                    <td>{{i.pessoa_cnpj}} </td>
                                </tr>
                                <tr>
                                    <td><b>Município</b< /td>
                                    <td>{{i.municipio_nm}} </td>
                                </tr>
                                <tr>
                                    <td><b>Território</b></td>
                                    <td>{{i.territorio_nm}} </td>
                                </tr>
                            </table>
                        </td>
                        <td>{{dataToBRcomHora(i.cotacao_dt)}} </td>

                        <!-- <td>{{+i.flag_autorizado==0?'Aguardando Analise da SUAF/SDR':'Cotação Liberada'}} </td> -->
                    </tr>

                </table>

                <table class="table" v-show='visivel_produtos'>
                    <tr>
                        <th>Produtos</th>
                        <th>QTD Cotações</th>
                    </tr>
                    <tr v-for="(i, key) in produtos">
                        <td>{{i.produto_nm}}</td>
                        <td>
                            <span class="badge badge-secondary" v-if="+i.qtd_cotacoes>0">{{i.qtd_cotacoes}}</span>
                            <span v-else>-</span>
                        </td>
                        <!-- <td>
                            <pre>
                            {{i.sql}}
                            </pre>
                        </td> -->
                    </tr>
                </table>
                <table class="table" v-show='visivel_categorias'>
                    <tr>
                        <th>Categorias</th>
                        <th>QTD Cotações</th>
                    </tr>
                    <tr v-for="(i, key) in categorias">
                        <td>{{i.categoria_nm}}</td>
                        <td>
                            <span class="badge badge-secondary" v-if="+i.qtd_cotacoes>0">{{i.qtd_cotacoes}}</span>
                            <span v-else>-</span>
                        </td>
                    </tr>
                </table>
                <table class="table" v-show='visivel_usuarios'>
                    <tr>
                        <th>Usuários</th>
                        <th>Perfil</th>
                    </tr>
                    <tr v-for="(i, key) in usuarios_cotacao">
                        <td>{{i.pessoa_nm}}</td>
                        <td>
                            {{i.tipo_usuario_ds}}
                        </td>
                    </tr>
                </table>
            </div>
            <table class="table" v-show='visivel_fornecedores'>
                <tr>
                    <th>Fornecedores</th>
                    <th>-</th>
                </tr>
                <tr v-for="(i, key) in fornecedores">
                    <td>{{i.pessoa_nm}}</td>
                    <td>
                        <table class="table">
                            <tr>
                                <th>
                                    Produto
                                </th>
                                <th>Data criação(preço)</th>
                                <th>Validade do Preço</th>
                            </tr>
                            <tr v-for="(p, pkey) in i.lista_produtos">
                                <td>{{p.produto_nm}}</td>
                                <td>{{formatarData(p.produto_preco_dt)}}</td>
                                <td>
                                    <!-- <div class="green" v-show="p.flag_preco_dentro_do_prazo==1">Dentro do Prazo</div>
                                    <div class="red" v-show="p.flag_preco_dentro_do_prazo==0">Fora do Prazo</div> -->

                                    em desenvolvimento
                                </td>
                            </tr>
                        </table>
                    </td>
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