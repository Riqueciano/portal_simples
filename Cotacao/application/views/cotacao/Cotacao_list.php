<?php include '../template/begin.php'; ?>

<html>

<head>
    <title>SDR</title>
    <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->
    <style>

    </style>
</head>

<body>

    <style>
        [v-cloak] {
            display: none;
        }
    </style>
    <div id='app' v-cloak>
        <div>
            <div v-if='carregando' class='overlay'>
                <img src='<?= iPATHGif ?>/lego.gif' alt='Carregando' class='loading-gif' style='width: 20%; border-radius: 50px'>
            </div>
            <h2 style="margin-top:0px">Minhas Cotações - <span>{{pessoa_nm}}</span></h2>
            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                    <?php echo anchor(site_url('cotacao/create'), 'Solicitar Nova Cotação', 'class="btn btn-success"'); ?>
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
                    <!--form action="<?php echo site_url('cotacao/index'); ?>" class="form-inline" method="get"-->
                    <!--div class="input-group">
                        <input type="text" class="form-control" name="q" v-model="q">
                        <span class="input-group-btn">
                            <button class="btn btn-default" @click='limpaFiltro()' v-show="q.length != 0">X</button>
                            <button class="btn btn-primary" type="button" @click='atualizaLista()'>Procurar</button>
                        </span>
                    </div-->
                    <!--/form-->
                </div>
            </div>
            <div style='overflow-x:auto' class="col-md-12">
                <table class="table" style="width: 50%">
                    <tr>
                        <th colspan="4">Pesquise nas SUAS Cotações</th>
                    </tr>
                    <!-- <tr>
                        <td style="width: 20%;">
                            <b>Entidades em que você fez cotações</b>
                        </td>
                        <td style="width: 20%;">
                            <select name="" id="" class="form-control" v-model="fornecedor_pessoa_id" @change="atualizaLista()" style="width: 40%;">
                                <option value="">.:Todos:.</option>
                                <option v-for="(f, fkey) in fornecedores" :value="f.pessoa_id">{{f.pessoa_nm?.toUpperCase()}}</option>
                            </select>
                        </td>
                        <td></td>
                    </tr> -->
                    <tr v-show="perfil == 'Nutricionista' || perfil == 'Administrador' || perfil == 'Gestor'">
                        <td style="width: 20%">
                            <b>Solicitei cotação para </b> <br>
                            <b class="red">[Campo disponível apenas para Nutricionista/Gestores]</b>
                            <br>
                            <select name="solicitado_para_pessoa_id" id="solicitado_para_pessoa_id" v-model="solicitado_para_pessoa_id" @change="atualizaLista()" class="form-control">
                                <option value="">.:Todos:.</option>
                                <option v-for="(p, pkey) in solicitado_para" :value="p.pessoa_id">{{p.pessoa_nm?.toUpperCase()}}</option>
                            </select>
                        </td>
                    </tr>
                    <tr v-show="perfil == 'Nutricionista' || perfil == 'Administrador' || perfil == 'Gestor'">
                        <td>
                            <b>Produtos cotados por você</b>
                            <br>
                            <select name="produto_id" id="produto_id" v-model="produto_id" @change="atualizaLista()" class="form-control">
                                <option value=''>.:Todos:.</option>
                                <option v-for="(p, pkey) in produtos_cotados" :value="p.produto_id">{{p.produto_nm?.toUpperCase()}}</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Período</b>
                            <br>
                            <table class="table">
                                <tr>
                                    <td style="width: 10%;"><b>Início</b>
                                        <br>
                                        <input type="date" name="data_inicio" id="data_inicio" v-model="data_inicio" class="form-control" @change="atualizaLista()">
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Fim</b>
                                        <br>
                                        <input type="date" name="data_fim" id="data_fim" v-model="data_fim" class="form-control" @change="atualizaLista() ">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--tr>
                        <td><b>Valor</b></td>
                        <td>
                            <b>Maior que </b>
                            <input type="number" name="valor" id="valor" v-model="valor" class="form-control" placeholder="0,00" style="width: 30%">
                            <select name="comparacao" id="comparacao" class="form-control" v-model="comparacao" @change="atualizaLista()" v-show="false">
                                <option value="maior_q">maior que</option>
                                <option value="menor_q">menor que</option>
                                <option value="igual">igual</option>
                            </select>
                        </td>
                        <td>
                            <br>
                            <input type="button" value="Procurar" class="btn btn-primary" @click="atualizaLista()">
                            <input type="button" value="Limpar filtros" class="btn btn-danger" @click="limpaFiltro()">
                        </td>
                    </tr-->
                </table>
                <!-- <div v-show="fornecedores.length > 0">
                    <select class="form-control" v-model="cotacao_ds" name="cotacao_ds" id="cotacao_ds" v-show="false">
                        <option value="">.:Selecione:.</option>
                        <option v-for="(item, index) in motivo_cotacao" :key="index" :value="item.value">
                            {{ item.label }}
                        </option>
                    </select>
                </div> -->

                <h2 style="padding: 10px;"><i class="glyphicon glyphicon-tag"></i> Suas Cotações: {{cotacao_data.length  }}</h2>
                <table class="table table-striped" style="margin-bottom: 10px">
                    <tr>
                        <!--th>No</th-->
                        <th align='center'>-</th>
                        <th>Nº</th>
                        <th>Cotação</th>
                        <th>Solicitante</th> 
                        <!--th>Valor</th>-->
                    </tr>
                    <tr v-for="(i, index) in cotacao_data" v-show="exibe_oculta_cotacao_pelo_valor(i.indicadores[0]?.soma) ">
                        <td style="text-align:center" width="100px">
                            <a title='Consultar' :href="'<?= site_url('cotacao/read/') ?>' + i.cotacao_id" v-show="false">
                                <button class='btn btn-sm btn-warning' style="width: 120px;">
                                    <i class="glyphicon glyphicon-search"></i> Consultar
                                </button>
                            </a>
                            <a title='Imprimir' :href="'<?= site_url('cotacao/open_pdf') ?>/?cotacao_id=' + i.cotacao_id" target="_blank">
                                <button class='btn btn-sm btn-danger' style="width: 120px;">
                                    <i class="glyphicon glyphicon-print"></i> Imprimir
                                </button>
                            </a>
                            <!--|
                            <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('cotacao/update/') ?>' + i.cotacao_id "></a>
                            |-->
                            <!-- <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('cotacao/delete/') ?>' + i.cotacao_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a> -->
                        </td>
                        <td>
                            <span class="badge badge-secondary">{{i.cotacao_numero}}</span>

                        </td>
                        <td>
                            <span class="" v-show="i.solicitado_para_pessoa_nm">Solicitado para: <b class="red">{{i.solicitado_para_pessoa_nm?.toUpperCase()}}</b></span>

                            <table class="table">
                                <tr>
                                    <td colspan="6">
                                        <p style="padding: 5px;font-size: 10px;"><i class="glyphicon glyphicon-asterisk"></i> <b>Motivo/finalidade:</b> {{i.cotacao_ds?.toUpperCase()}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>-</th>  
                                    <th>Fornecedores</th>
                                    <th>Produto</th>
                                    <th>Preço médio</th>
                                    <th>Data</th>
                                    <th>Endereço</th>
                                    <th>Email</th>
                                </tr>
                                <tr v-for="(po, pokey) in i.precos">
                                    <td>{{pokey+1}}</td>
                                    <td style="font-size: 10px;"> {{po.pessoa_nm?.toUpperCase()}}</td>
                                    <td style="font-size: 10px;">
                                        <div class="badge" style="background-color: #28a745;" v-if="produto_id == po.produto_id">{{po.produto_nm?.toUpperCase()}}</div>
                                        <div v-else>{{po.produto_nm?.toUpperCase()}}</div>
                                    </td>
                                    <td style="font-size: 10px;"> {{formatarParaMoeda(po.valor)}}</td>
                                    <td style="font-size: 10px;"> {{dataToBR(po.produto_preco_dt)}}</td>
                                    <td style="font-size: 10px;"> {{(po.fornecedor_endereco?.toUpperCase())}}</td>
                                    <td style="font-size: 10px;"> {{(po.funcionario_email?.toUpperCase())}}</td>
                                </tr>

                            </table>
                            <!-- <div v-for="(p, pkey) in i.precos">
                                {{p.produto_nm + ' - R$ '+p.valor}}
                            </div> -->
                        </td>
                        <td>
                            <table class="table">
                                <tr>
                                    <td style="width: 20%;"><b>Solicitante/comprador</b></td>
                                    <td>{{i.pessoa_nm?.toUpperCase()}} </td>
                                </tr>
                                <tr>
                                    <td><b>CNPJ</b></td>
                                    <td>{{i.pessoa_cnpj}} </td>
                                </tr>
                                <tr>
                                    <td><b>Município</b></td>
                                    <td>{{i.municipio_nm?.toUpperCase()}} </td>
                                </tr>
                                <tr>
                                    <td><b>Território</b></td>
                                    <td>{{i.territorio_nm?.toUpperCase()}} </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="badge" style="background-color: #28a745;">Data</div>
                                    </td>
                                    <td>
                                        <div class="badge" style="background-color: #28a745;"> {{dataToBRcomHora(i.cotacao_dt)}} </div>

                                    </td>
                                </tr>
                            </table>
                        </td>
                        <!--td>{{formatarParaMoeda(i.indicadores[0]?.soma)}}</td>-->
                       
                    </tr>
                </table>
            </div>
            <div class="row" v-show="q.length == 0">
                <!-- <div class="col-md-6">
                    <a href="#" class="btn btn-primary">Total Linhas: {{total_rows}}</a>
                </div> -->
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>
            </div>
        </div>
    </div>



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
                    pessoa_nm: '<?= $_SESSION['pessoa_nm'] ?>',
                    perfil: '<?= $_SESSION['perfil'] ?>',
                    message: '',
                    cotacao_data: <?= $cotacao_data ?>,
                    total_rows: <?= $total_rows ?>,
                    fornecedores: <?= $fornecedores ?>,
                    produtos_cotados: <?= $produtos_cotados ?>,
                    solicitado_para: <?= $solicitado_para ?>,
                    pessoa_id: '',
                    produto_id: '',
                    fornecedor_pessoa_id: '',
                    cotacao_ds: '',
                    carregando: false,
                    motivo_cotacao: <?= MOTIVO_COTACAO ?>,
                    data_inicio: '',
                    data_fim: '',
                    comparacao: 'maior_q',
                    valor: null,
                    solicitado_para_pessoa_id: '',
                }
            },
            methods: {
                dataToBR,
                dataToBRcomHora,
                moedaBR,
                exibe_oculta_cotacao_pelo_valor: function(cotacao_valor) {
                    if (+cotacao_valor >= +this.valor) {
                        return true;
                    } else {
                        return false;
                    }
                },
                limpaFiltro: function() {
                    location.reload();
                },
                atualizaLista: async function() {
                    this.carregando = true;

                    let param = "?q=" + this.q;
                    param += "&format=json";
                    param += "&fornecedor_pessoa_id=" + this.fornecedor_pessoa_id;
                    // param += "&pessoa_id=" + this.pessoa_id;
                    param += "&produto_id=" + this.produto_id;
                    param += "&cotacao_ds=" + this.cotacao_ds;
                    param += "&data_inicio=" + this.data_inicio;
                    param += "&data_fim=" + this.data_fim;
                    param += "&comparacao=" + this.comparacao;
                    param += "&valor=" + this.valor;
                    param += "&solicitado_para_pessoa_id=" + this.solicitado_para_pessoa_id;

                    let url = '<?= site_url('cotacao/index') ?>' + param;
                    // alert(url);
                    let result = await fetch(url);
                    let json = await result.json();
                    this.cotacao_data = json;

                    setTimeout(() => {
                        this.carregando = false;
                    }, 500);

                    // this.atualizaListaPeloValor()

                },

                // atualizaListaPeloValor: function(){
                //     // if(this.comparacao == 'maior_q' && +this.valor > 0){
                //     //     this.cotacao_data = this.cotacao_data.filter(i => (i.indicadores[0].soma??0) >= +this.valor);
                //     // }
                //     // if(this.comparacao == 'menor_q' && +this.valor > 0){
                //     //     this.cotacao_data = this.cotacao_data.filter(i => (i.indicadores[0].soma??0 ) <= +this.valor);
                //     // }
                //     // if(this.comparacao == 'igual'){
                //     //     this.cotacao_data = this.cotacao_data.filter(i => (i.indicadores[0].soma??0) == +this.valor);
                //     // }
                // },
                formatarParaMoeda: function(numero) {
                    return new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    }).format(numero);
                }
            },
            mounted() {

            },
        });

        app.mount('#app');
    </script>
</body>

</html>
<?php include '../template/end.php'; ?>