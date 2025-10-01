<?php include '../template/begin_1_2018rn.php'; ?>

<!-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> -->
<html>

<head>
    <title>SDR</title>
    <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

</head>

<body>

    <style>
        [v-cloak] {
            display: none;
        }
    </style>
    <div id='app' v-cloak>
        <img src="<?= iPATHGif ?>risco_infinito.gif" alt="" v-show="carregando" style="width: 20%;">
        <form action="<?php echo site_url('produto/index'); ?>" class="form-inline" method="get" id='form'>
            <div>
                <h2 style="margin-top:0px">Listagem - Produtos x preço</h2>


                <div class="row" style="margin-bottom: 10px" v-show="!carregando">
                    <div class="col-md-12">
                        <span v-if="perfil_usuario =='Administrador' || perfil_usuario =='Gestor' ">
                            <small>Apenas o Tecnico realiza cadastros</small> <br>
                            <a class='btn btn-success btn-sm' title='Preço' href="<?= site_url('produto/create/') ?>">
                                Novo produto
                            </a>
                            <!-- <input type="button" value="DUPLICAR PRODUTOS MARCADOS PARA - ORGÂNICO" class="btn btn-danger" @click="duplicar_produtos_marcados_para_organico()"> -->
                        </span>
                        <br>
                        <table class="table">
                            <!-- <tr>
                                <th style="width: 33%;">Exibir produtos</th>
                                <th style="width: 33%;" v-if="flag_exibir_produtos=='com_preco'">Meus produtos</th>
                                <th style="width: 33%;">Produtos</th>
                                <th style="width: 33%;">Categoria</th>
                                <th>-</th>
                            </tr> -->
                            <tr>
                                <td style="width: 30%;"> <b>Exibir</b> <br>
                                    <select v-model="flag_exibir_produtos" name="flag_exibir_produtos" id="flag_exibir_produtos" class="form-control" @change="filtro_produto_id = ''; atualizaLista()" v-model="flag_exibir_produtos">
                                        <option value="com_preco">MEUS produtos (COM preço)</option>
                                        <option value="sem_preco">Outros produtos (SEM preço definido por você)</option>
                                    </select>
                                </td>
                                <td>
                                    <b>Produtos</b><br>
                                    <div>
                                        <!-- <select v-model="filtro_produto_id" name="filtro_produto_id" id="filtro_produto_id" class="form-control" @change="atualizaLista()">
                                            <option value="">.:Todos:.</option>
                                            <option v-for="(i, key) in produto_com_preco_todos" :value="i.produto_id">{{i.produto_nm}}</option>
                                        </select> -->
                                        <!-- {{produto_com_preco_todos}} -->
                                        <!-- {{filtro_produto_id}}
                                        <select2-component v-model="filtro_produto_id" id="filtro_produto_id" name="filtro_produto_id" :options="produto_com_preco_todos">
                                        </select2-component> -->

                                        <select v-model="filtro_produto_id" id="filtro_produto_id" name="filtro_produto_id" class="form-control">
                                            <option value="">.:Selecione:.</option>
                                            <option v-for="(i, key) in produto_com_preco_todos" :value="i.id">{{i.text}}</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td> <b>Categoria</b><br>
                                    <!-- <select v-model="filtro_categoria_id" name="filtro_categoria_id" id="filtro_categoria_id" class="select2_single form-control" @change="atualiza_filtro_categoria(this)">
                                        <option value="">.:Todos:.</option>
                                        <option v-for="(i, key) in categoria" :value="i.id">{{i.text}}</option>
                                    </select> -->
                                    <!-- <select2-component v-model="filtro_categoria_id" id="filtro_categoria_id" name="filtro_categoria_id" :options="categoria">
                                    </select2-component> -->
                                    <select v-model="filtro_categoria_id" id="filtro_categoria_id" name="filtro_categoria_id" class="form-control" @change="atualizaLista(); ">
                                        <option value="">.:Selecione:.</option>
                                        <option v-for="(i, key) in categoria" :value="i.id">{{i.text}}</option>
                                    </select>

                                </td>
                                <td> <b>-</b> <br>
                                    <a href="<?= site_url('produto') ?>">
                                        <input type="button" value="Limpar filtros" class="btn btn-sm btn-warning">
                                    </a>

                                </td>
                            </tr>
                        </table>


                    </div>


                    <div class="col-md-5 text-right">

                        <!-- <div class="input-group">
                            <input type="text" class="form-control" name="q" v-model="q">
                            <span class="input-group-btn">
                                <button class="btn btn-default" @click='limpaFiltro()' v-show="q.length != 0">X</button>
                                <button class="btn btn-primary" type="button" @click='atualizaLista()'>Buscar</button>
                            </span>
                        </div> -->
                    </div>
                </div>

                <div style='overflow-x:auto' v-show="!carregando">
                    <!-- {{filtro_produto_id}} -->
                    <div v-show="perfil_usuario=='Administrador' || perfil_usuario=='Gestor' ">
                        <b>Listagem de Todos Produtos (visivel apenas para Administrador/Gestor)</b> <br>
                        <!-- {{listagem_todos_produtos}} -->
                        <select2-component v-model="filtro_produto_id" id="filtro_produto_id" name="filtro_produto_id" :options="listagem_todos_produtos">
                        </select2-component>
                    </div>

                    <div style="margin-bottom: 10px" v-show="perfil_usuario=='Administrador' || perfil_usuario=='Gestor' || perfil_usuario=='Fornecedor'">
                        <input type="button" value="Renovar TODOS os preços" @click="renovar_todos_produtos_fornecedor_mesmo_preco()" class="btn btn-sm btn-success">
                    </div>

                    <span class="badge badge-secondary" v-if="flag_exibir_produtos=='com_preco'" style="margin-bottom: 10px">Qtd Produtos: {{produto_com_preco?.length}}</span>
                    <table class="table table-striped" style="margin-bottom: 10px" v-if="flag_exibir_produtos=='com_preco'" id='tb_filtro_produto_com_preco'>
                        <tr>
                            <!--th>No</th-->
                            <th align='center' style="width: 5%" colspan="2">-</th>
                            <th style="width: 40%">Produto</th>
                            <th style="width: 55%">Preços por território(R$)</th>
                            <!-- <th>Produto Tipo Id</th> -->
                            <!-- <th>Status Id</th> -->
                        </tr>
                        <tr v-for="(i, index) in produto_com_preco">
                            <td>
                                <span class="badge badge-secondary">{{+index+1}}</span>
                            </td>
                            <td style="text-align:center" width="100px" v-show="perfil_usuario !='Tecnico/Consultor'">

                                <!--<a class='btn btn-default btn-sm' title='Consultar' :href="'<?= site_url('produto/read/') ?>' + i.produto_id">Consultar</a>
                                |-->

                                <a class='btn btn-danger btn-sm' title='Preço' :href="'<?= site_url('produto_preco/create/') ?>' + i.produto_id" v-if="perfil_usuario !='Gestor'">
                                    Atualizar Preço
                                </a>
                                <div v-if="perfil_usuario =='Gestor' || perfil_usuario =='Administrador'">
                                    |
                                    <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('produto/update/') ?>' + i.produto_id "></a>
                                    |
                                    <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('produto/delete/') ?>' + i.produto_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                                </div>
                            </td>
                            <td>
                                <table class="table">
                                    <tr>
                                        <td><b>Produto</b></td>
                                        <td>
                                            <span class="badge badge-secondary">{{i.produto_nm?.toUpperCase()}}</span>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td><b>Quantidade</b></td>
                                        <td>{{i.produto_qtd}}</td>
                                    </tr> -->
                                    <tr>
                                        <td><b>Categoria</b></td>
                                        <td><b class="red">{{i.categoria_nm??'-'}}</b> </td>
                                    </tr>
                                    <tr>
                                        <td><b>Unidade de Medida</b></td>
                                        <td>{{i.unidade_medida_nm}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <b>Descrição</b> <br>
                                            {{i.produto_ds}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Orgânico?</b>
                                        </td>
                                        <td>
                                            <span class="badge" v-if="i.flag_organico == 1" style="background-color: green; color: white;">Orgânico</span>
                                            <span class="badge" v-if="i.flag_organico == 0">Não</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="table">
                                    <tr>
                                        <th>Território</th>
                                        <th>Preço (R$) </th>
                                        <th>Data de Cadastro </th>
                                        <th>Data de Vencimento DO PREÇO </th>
                                        <th>Situação</th>
                                    </tr>
                                    <tr v-for="(p, pkey) in i.territorio_precos" v-show="+p.produto_preco_territorio_valor > 0">
                                        <td>
                                            <div v-if="+p.produto_preco_territorio_valor == 0" class="red">{{p.territorio_nm?.toUpperCase()}}</div>
                                            <div v-if="+p.produto_preco_territorio_valor > 0" class="green">{{p.territorio_nm?.toUpperCase()}}</div>
                                        </td>
                                        <td align="right">
                                            <div class="red" v-if="+p.produto_preco_territorio_valor == 0">
                                                R$ {{formatarNumeroParaDinheiro(p.produto_preco_territorio_valor)}}
                                            </div>
                                            <div class="green" v-else>
                                                R$ {{formatarNumeroParaDinheiro(p.produto_preco_territorio_valor)}}
                                            </div>
                                        </td>
                                        <td align="right">
                                            {{dataToBR(p.produto_preco_territorio_dt_cadastro)}}
                                        </td>
                                        <td align="right">
                                            <div class="badge">{{adicionarDias(p.produto_preco_territorio_dt_cadastro, DIAS_VALIDADE_PRECO)}}</div>
                                        </td>
                                        <td>
                                             
                                            <div class="badge" style="background-color: green;" v-if="verifica_vencido(p.produto_preco_territorio_dt_cadastro?.substring(0,10)) == true">DENTRO DO PRAZO</div>
                                            <div class="badge" style="background-color: red;" v-else>PREÇO FORA DO PRAZO DE {{DIAS_VALIDADE_PRECO}} DIAS</div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr v-if="produto_com_preco.length==0">
                            <td colspan="1"></td>
                            <td colspan="1">Nenhum item encontrado, favor revisar o filtro</td>
                            <td colspan="5"></td>
                        </tr>
                    </table>
                    <div id='div_produtos_sem_preco' v-if="flag_exibir_produtos=='sem_preco'">
                        <!-- <span>
                            <br> Procurar
                            <i class="glyphicon glyphicon-search"></i><input type="text" id="filtro_produto_sem_preco" onkeyup="filtraTabela('tb_filtro_produto_sem_preco','filtro_produto_sem_preco')" placeholder="Digite o nome do produto" class="form-control" style="width:30%">
                        </span> -->

                        <span class="badge badge-secondary" v-if="flag_exibir_produtos=='sem_preco'" style="margin-bottom: 10px">Qtd Produtos: {{produto_sem_preco?.length}}</span>
                        <table class="table table-striped" style="margin-bottom: 10px" id="tb_filtro_produto_sem_preco">
                            <tr>
                                <th align='center' style="width: 1%" colspan="2">-</th>
                                <th style="width: 30%">Produto </th>

                            </tr>
                            <tr v-for="(i, index) in produto_sem_preco">
                                <td>
                                    <span class="badge badge-secondary">{{+index+1}}</span>
                                </td>
                                <td style="text-align:center" width="100px">
                                    <a class='btn btn-danger btn-sm' title='Preço' :href="'<?= site_url('produto_preco/create/') ?>' + i.produto_id" v-if="perfil_usuario !='Gestor'">
                                        Cadastrar Preço
                                    </a>
                                    <div v-if="perfil_usuario =='Gestor'">
                                        |
                                        <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('produto/update/') ?>' + i.produto_id "></a>
                                        |
                                        <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('produto/delete/') ?>' + i.produto_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                                    </div>
                                    <br>
                                    <br>
                                    <div v-if="perfil_usuario =='Gestor'">
                                        <div v-show="i.flag_organico == 0">
                                            <b class="red">Duplicar para Organico?</b>
                                            <input type="button" value="Duplicar" @click="duplicar_produtos_marcados_para_organico_unico(i.produto_id)" class="btn btn-danger">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <table class="table">
                                        <tr>
                                            <td style="width: 15%;"><b>Produto</b></td>
                                            <td>
                                                <span class="badge" v-if="i.flag_organico == 0">{{i.produto_nm}}</span>
                                                <span class="badge" style="background-color: #28a745;" v-if="i.flag_organico == 1">{{i.produto_nm}}</span>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td><b>Quantidade</b></td>
                                            <td>{{i.produto_qtd}}</td>
                                        </tr> -->
                                        <tr>
                                            <td><b>Categoria</b></td>
                                            <td><b class="red">{{i.categoria_nm??'-'}}</b> </td>
                                        </tr>
                                        <tr>
                                            <td><b>Unidade de Medida</b></td>
                                            <td>{{i.unidade_medida_nm}}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Descrição </b>
                                            </td>
                                            <td>
                                                {{i.produto_ds}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Orgânico?</b>
                                            </td>
                                            <td>
                                                <span class="badge" v-if="i.flag_organico == 1" style="background-color: #28a745; color: white;">ORGÂNICO</span>
                                                <span class="badge" v-if="i.flag_organico == 0">Não</span>
                                            </td>
                                        </tr>
                                    </table>


                                </td>
                            </tr>
                            <tr v-if="produto_sem_preco.length==0">
                                <td colspan="4">Nenhum item encontrado, favor revisar o filtro</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- <div class="row" v-show="produto_sem_preco.length > 0" style="display: none">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-primary">Total Linhas: {{produto_sem_preco.length}}</a>
                    </div>
                </div> -->
            </div>
        </form>
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
                    qtd_vencidos: 0,
                    duplicar_produto_id: [],
                    filtro_produto_id: '',
                    filtro_categoria_id: <?= (int)$filtro_categoria_id ?>,
                    carregando: false,
                    q: '<?= $q ?>',
                    message: '',
                    perfil_usuario: "<?= $_SESSION['perfil'] ?>",
                    listagem_todos_produtos: <?= $listagem_todos_produtos ?>,
                    produto_com_preco_todos: <?= $produto_com_preco_todos ?>,
                    produto_com_preco: <?= $produto_com_preco ?>,
                    produto_sem_preco: <?= $produto_sem_preco ?>,
                    categoria: <?= $categoria ?>,
                    total_rows: <?= $total_rows ?>,
                    flag_exibir_produtos: '<?= $flag_exibir_produtos ?>',
                    filtro_produto_id: '<?= $filtro_produto_id ?>',
                    DIAS_VALIDADE_PRECO: <?= (int)DIAS_VALIDADE_PRECO ?>
                }
            },
            computed: {

            },
            methods: {
                dataToBR,
                dataToBRcomHora,
                moedaBR,
                adicionarDias(data, dias) {
                    if (!data || !dias) {
                        return data;
                    }
                    const dataObj = new Date(data);
                    dataObj.setDate(dataObj.getDate() + dias);
                    return dataObj.toISOString().split('T')[0];
                },
                retorna_qtd_vencidos() {
                    this.qtd_vencidos = 0;
                    this.produto_com_preco.map(i => {
                        if (this.verifica_vencido(i.produto_preco_dt)) {
                            this.qtd_vencidos++;
                        }
                    })
                },
                renovar_todos_produtos_fornecedor_mesmo_preco: async function() {
                    this.carregando = true;
                    // Rolagem suave até o topo
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                    let conf = confirm('ATENÇÃO!\nTem certeza que deseja renovar todos os produtos, mantendo o mesmo preço? Está ação não pode ser desfeita')
                    if (conf == false) {
                        this.carregando = false;
                        return false
                    }

                    let url = '<?= site_url('produto_preco/renovar_todos_produtos_fornecedor_mesmo_preco') ?>';

                    let result = await fetch(url);
                    let json = await result.json();
                    console.log(json)
                    console.log("----")

                    if (json?.acao == 'acao') {
                        //atualiza pagina 
                        window.location.reload(true); // em alguns navegadores antigos, true força reload do servidor

                        //window.location.href = window.location.href;
                    }

                    // this.carregando = false;
                    window.location.href = window.location.href;
                },
                adicionarDias: function(dataString, dias) {
                    try {
                        if (!dataString || isNaN(dias)) return dataString;

                        const data = new Date(dataString);
                        if (isNaN(data)) return dataString; // data inválida

                        data.setDate(data.getDate() + Number(dias));
                        return this.dataToBR(data.toISOString().split('T')[0]);
                    } catch (e) {
                        return dataString; // Se ocorrer erro, retorna o valor original
                    }
                },
                duplicar_produtos_marcados_para_organico: async function() {
                    let conf = confirm('Certeza que deseja duplicar os produtos selecionados para "Organico"? Está ação não pode ser desfeita')
                    if (conf == false) {
                        return false
                    }

                    var formulario = document.getElementById('form');
                    formulario.action = '<?= site_url('produto/duplicar_produtos_marcados_para_organico') ?>';
                    formulario.method = 'post';

                    $("#form").submit()
                },
                duplicar_produtos_marcados_para_organico_unico: async function(duplicar_produto_id) {
                    let conf = confirm('Certeza que deseja duplicar o produto selecionado?')
                    if (conf == false) {
                        return false
                    }

                    // var formulario = document.getElementById('form');

                    let url = '<?= site_url('produto/duplicar_produtos_marcados_para_organico_unico/') ?>' + duplicar_produto_id;
                    let result = await fetch(url);
                    let json = await result.json();

                    if (json.status == 'success') {
                        // alert('Produto duplicado com sucesso')
                        await this.atualizaLista();
                    }
                },




                verifica_vencido: function(date1) {
                        // Converte a string "AAAA/mm/dd" para objeto Date
                        const dt_preco_cadastrado = new Date(date1);

                        // Obtém a data atual (zerando horas para comparar apenas datas)
                        const hoje = new Date();
                        hoje.setHours(0, 0, 0, 0);

                         

                        // Calcula a data de vencimento
                        const data_vencimento = new Date(dt_preco_cadastrado);
                        data_vencimento.setDate(dt_preco_cadastrado.getDate() + this.DIAS_VALIDADE_PRECO);

                         
                        return hoje < data_vencimento;
                    }

                    ,
                filtraTabela: function(tabela_id_parametro, filtro_id_parametro) {

                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById(filtro_id_parametro);
                    filter = input.value.toUpperCase();
                    table = document.getElementById(tabela_id_parametro);
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[1];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                },
                limpaFiltro: function() {
                    this.q = '';
                    this.atualizaLista();
                    // this.atualizaListaTodosProdutos();
                },
                atualizaListaProdutoFiltro: async function() {
                    this.produto_com_preco_todos = null
                    let url = '<?= site_url('produto/atualiza_lista_produto_filtro') ?>/?flag_exibir_produtos=' + this.flag_exibir_produtos + "&filtro_categoria_id=" + this.filtro_categoria_id;
                    // alert(url)
                    let result = await fetch(url);
                    let json = await result.json();
                    //   console.log(json)
                    // alert('aki')
                    //  alert(url)
                    this.produto_com_preco_todos = json
                },
                atualizaLista: async function() {
                    // alert()
                    this.carregando = true;
                    // this.produto_com_preco = [];
                    let url = ""
                    let result = ""
                    let json = ""
                    // alert(this.flag_exibir_produtos)
                    if (this.flag_exibir_produtos == 'com_preco') {
                        url = '<?= site_url('produto/busca_produtos') ?>?q=' + this.q + '&filtro_produto_id=' + this.filtro_produto_id + '&format=json/produto_com_preco' + "&filtro_categoria_id=" + this.filtro_categoria_id;
                        result = await fetch(url);
                        json = await result.json();
                        //alert(url)
                        this.produto_com_preco = json;
                    }
                    if (this.flag_exibir_produtos == 'sem_preco') {
                        url = '<?= site_url('produto/busca_produtos') ?>?q=' + this.q + '&filtro_produto_id=' + this.filtro_produto_id + '&format=json/produto_sem_preco' + "&filtro_categoria_id=" + this.filtro_categoria_id;
                        result = await fetch(url);
                        json = await result.json();
                        //alert(url)
                        this.produto_sem_preco = json;
                    }
                    // alert(this.flag_exibir_produtos)
                    this.carregando = false;

                    await this.atualizaListaProdutoFiltro();

                },
                atualizaListaTodosProdutos: async function() {

                    this.carregando = true;
                    this.listagem_todos_produtos = [];
                    let url = ""
                    let result = ""
                    let json = ""

                    url = '<?= site_url('produto/atualizaListaTodosProdutos') ?>?filtro_categoria_id=' + this.filtro_categoria_id;
                    //alert(url)
                    result = await fetch(url);
                    json = await result.json();
                    // alert(json)
                    this.listagem_todos_produtos = json;

                    this.carregando = false;
                },
                submeter: function() {

                },
                formatarNumeroParaDinheiro: function(numero) {
                    // Arredondar o número para duas casas decimais
                    const numeroFormatado = Number(numero).toFixed(2);

                    // Converter o número formatado em uma string
                    const numeroString = numeroFormatado.toString();

                    // Separar a parte inteira da parte decimal
                    const partes = numeroString.split('.');

                    // Formatar a parte inteira com separador de milhares
                    partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                    // Adicionar vírgula como separador decimal
                    const numeroFormatadoBrasil = partes.join(',');

                    // Adicionar o símbolo de real (R$) na frente do número
                    return numeroFormatadoBrasil;
                },

                // 
                exibi_mensagem_se_produtos_vencidos: async function() {

                    let tem_produtos_desatualizados = false;
                    this.produto_com_preco.map(i => {
                        // alert(i.ultimo_dt_preco); 
                        if (this.verifica_vencido(i.ultimo_dt_preco?.substring(0, 10))) {
                            tem_produtos_desatualizados = true
                        }
                    })

                    if (tem_produtos_desatualizados == true && (this.perfil_usuario != 'Administracao' || this.perfil_usuario != 'Gestor')) {
                        alert('Atenção! Você tem produtos com Preço Desatualizado\nProdutos com preço desatualizados não ficam disponíveis para cotações ');
                    }
                }
            },
            watch: {
                filtro_categoria_id(novo, antigo) {
                    this.atualizaLista()

                    //this.atualizaListaTodosProdutos();
                },
                filtro_produto_id(novo, antigo) {
                    this.atualizaLista()
                    //this.atualizaListaTodosProdutos();
                }
            },
            mounted() {
                this.exibi_mensagem_se_produtos_vencidos();

                this.atualizaLista()
                //this.atualizaListaTodosProdutos()

                this.retorna_qtd_vencidos()
            },
        })

        app.mount('#app');
    </script>
    <!-- <script>
        new Vue({
            el: "#app",
            template: "#app-template",
            data: {
                 
            },
            methods: {},
            mounted() {


            },

        });
    </script> -->
</body>

</html>
<?php include '../template/end.php'; ?>