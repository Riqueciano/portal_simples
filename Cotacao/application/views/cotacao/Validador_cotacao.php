<?php include '../template/begin_vue_sem_validacao_intranet.php'; ?>
<html>

<head>

</head>

<body>
    <!-- <!DOCTYPE html>
    <html>

    <head>
        <title>Mapa Simples com Leaflet</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    </head>

    <body>
        <div id="map" style="width: 100%; height: 600px;"></div>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            var map = L.map('map').setView([51.505, -0.09], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
        </script>
    </body>

    </html> -->
    <!-- ###app### -->
    <style>
        [v-cloak] {
            display: none;
        }


        /************ oculta a barra de menu lateral */
        body.nav-md .container.body .right_col,
        body.nav-md .container.body .top_nav {
            width: 100%;
            margin: 0;
        }

        body.nav-md .container.body .col-md-3.left_col {
            display: none;
        }

        body.nav-md .container.body .right_col {
            width: 100%;
            padding-right: 0
        }

        .right_col {
            padding: 10px !important;
        }

        /* ***************************************** */
        h2 {
            font-size: 23px;
        }

        #content2 {
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            margin-left: 0px !important;
            margin-right: 0px !important;
        }
    </style>
    <div id='app' v-cloak></div>
    <!-- ### -->

    <template id="app-template">
        <div>
            <input type="hidden" name="cotacao_id" id="cotacao_id" value="<?php echo $cotacao_id; ?>" />

            <div class='x_panel' id=''>
                <div class="row">

                    <table class="table">
                        <tr>
                            <td align="center" colspan="2">
                                <img src="<?php echo iPATH; ?>Imagens/cotacao/cotacao-rural-1.png" style="width: 40%; border-radius: 10px; padding: 10px">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h2 style="margin-top:0px"><span id='spanAcaoForm'>Cotação realizada no dia {{dataToBR(cotacao.cotacao_dt)}}</span> </h2>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 10%">
                                <div class="form-group">
                                    <label for="integer">Solicitante <?php echo form_error('cotacao_pessoa_id') ?></label>
                                </div>
                            </td>
                            <td>
                                <b class="green">{{pessoa_nm}}</b>
                                <div class="item form-group" style="display: none">
                                    <select2 :options="pessoa" v-model='form.cotacao_pessoa_id' id='cotacao_pessoa_id' name='cotacao_pessoa_id'>
                                        <option disabled value=''>.:Selecione:.</option>
                                    </select2>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="cotacao_ds">Descrição<br>Motivo<br>Finalidade* <?php echo form_error('cotacao_ds') ?></label>
                            </td>
                            <td>
                                <div class="form-group">
                                    {{form.cotacao_ds }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cotacao_ds">Data da Solicitação </label>
                            </td>
                            <td>
                                {{dataToBR(cotacao.cotacao_dt)}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cotacao_ds">Validade </label>
                            </td>
                            <td>
                                <!-- {{cotacao.cotacao_dt.substring(0,10)}}
                                                {{DIAS_VALIDADE_PRECO}} -->
                                <b class="red">
                                    {{dataToBR(somaDias(cotacao.cotacao_dt.substring(0,10),DIAS_VALIDADE_PRECO))}}
                                </b> ({{DIAS_VALIDADE_PRECO}} dias corridos)
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="row">
                    <h2> <i class='glyphicon glyphicon-arrow-down'></i> Média dos produtos da Cotação</h2>
                    <table class="table">
                        <tr>
                            <th>Produto</th>
                            <th>Preço medio</th>
                        </tr>
                        <tr v-for="(i, index) in cotacao_media">
                            <td>{{i.produto_nm_completo}}</td>
                            <td>{{moedaBR(i.valor_medio)}}</td>
                        </tr>
                        <tr style="background-color: #ededed">
                            <td><b>Total</b></td>
                            <td><b>{{moedaBR(soma_valor_medio)}}</b></td>
                        </tr>
                    </table>

                </div>
                <div class="row">
                    <h2> <i class='glyphicon glyphicon-arrow-down'></i> Detalhamento da cotação</h2>
                    <table class='table'>
                        <tr>
                            <th>Produto</th>
                            <!-- <th>Data</th> -->
                            <th>Fornecedor </th>
                            <th>Valor</th>
                        </tr>
                        <!--item ja adicionados-->
                        <tr v-for="(i, index) in produto_preco_cotacao">
                            <td>
                                <b class='green'>{{i.produto_nm_completo}}</b>
                                <input type="hidden" :value="i.produto_preco_id" name='produto_preco_id[]'>
                                <input type="hidden" :value="i.produto_id" name='produto_id[]'>
                                <input type="hidden" :value="i.valor" name='valor[]'>
                                <input type="hidden" :value="i.produto_preco_dt" name='produto_preco_dt[]'>
                            </td>
                            <!-- <td>{{formatarDataHora(i.produto_preco_dt)}}</td> -->
                            <td>
                                <table class="table">
                                    <tr>
                                        <td>
                                            <b>Fornecedor</b>
                                            {{i.pessoa_nm}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>CNPJ</b>
                                            {{i.pessoa_cnpj}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Território</b>
                                            {{i.territorio_nm??'Não informado'}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <b class='green'>{{moedaBR(i.valor)}}</b>
                            </td>
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
                instrucoes: [
                    // '1 - para receber a cotação é necessario aguardar analise da Equipe SUAF/SDR',
                    // '1 - o usuário pode criar quantas cotações achar necessario (por produto);', 
                    // '2 - não é possivel editar uma cotação salva;',
                    // '3 - a cotação pode ser excluida;',
                ],
                DIAS_VALIDADE_PRECO: <?= DIAS_VALIDADE_PRECO ?>,
                param_municipio_id: '',
                param_territorio_id: '',
                flag_cotacao_ja_add: false,
                temp_produto_visible: true,
                message: '',
                temp_produto_nm: '',
                button: "<?= $button ?>",
                controller: "<?= $controller ?>",
                flag_autorizado: "<?= (int)$flag_autorizado ?>",
                fornecedor_territorio_nm: "<?= $fornecedor_territorio_nm ?>",
                fornecedor_territorio_id: "<?= $fornecedor_territorio_id ?>",
                pessoa_nm: "<?= $pessoa_nm ?>",
                produto_preco: [],
                produto_preco_cotacao: <?= $produto_preco_cotacao ?>,
                territorio: <?= $territorio ?>,
                municipio: <?= $municipio ?>,
                /*tag select*/
                pessoa: <?= $pessoa ?>,
                cotacao: <?= $cotacao ?>,
                produto: <?= $produto ?>,
                temp_produto_id: 0,
                executou: 0,
                media_3_itens: 0,
                soma_valor_medio: 0,
                territorio_nm: '',
                cotacao_territorio_id: '', //<?= (int)$cotacao_territorio_id ?>,
                cotacao_media: [],
                /*form*/
                form: {
                    cotacao_pessoa_id: "<?= $cotacao_pessoa_id ?>",
                    cotacao_dt: "<?= $cotacao_dt ?>",
                    cotacao_ds: "<?= $cotacao_ds ?>",

                },
            },
            computed: {

            },
            methods: {
                somaDias: function(dataStr, dias) {
                    // Converter a string da data para um objeto Date
                    let partes = dataStr.split('-');
                    let ano = parseInt(partes[0], 10);
                    let mes = parseInt(partes[1], 10) - 1; // Subtrai 1 do mês porque os meses são baseados em zero
                    let dia = parseInt(partes[2], 10);
                    let data = new Date(ano, mes, dia);

                    // Adicionar os dias
                    data.setDate(data.getDate() + dias);

                    // Formatar a data no formato yyyy-mm-dd
                    let novoAno = data.getFullYear();
                    let novoMes = (data.getMonth() + 1).toString().padStart(2, '0'); // Adiciona 1 ao mês
                    let novoDia = data.getDate().toString().padStart(2, '0');

                    return `${novoAno}-${novoMes}-${novoDia}`;
                },
                valida_fornecedor_duplicado: function(param_pessoa_id, remover) {
                    alert(remover)
                    let desmarcar = -1;
                    this.produto_preco.map((i, key) => {
                        // alert(i.pessoa_id)
                        if (i.selecionado == true) {
                            if (i.pessoa_id == param_pessoa_id) {
                                alert('ja adicionado')
                                return false;
                            }
                        }
                    })
                    this.produto_preco.map((i, key) => {
                        if (remover == key) {
                            // alert(i.pessoa_id)
                            alert(remover)
                            i.selecionado = undefined
                        }
                    })
                },
                alterar_filtro_produto: function() {
                    let conf = confirm('Cotação é feita para apenas um unico produto!\n\nPara alterar o produto, a cotação atual é perdida, deseja continuar?');
                    if (conf == false) {
                        return false
                    } else {
                        window.location.reload(true);
                    }

                },

                calcula_soma_valor_medio: function() {
                    this.cotacao_media.map((i, index) => {
                        this.soma_valor_medio += +i.valor_medio
                    })
                },



                ajaxCarregaCotacao: async function() {
                    this.produto_preco = []
                    this.executou++

                    let url = '<?= site_url('produto_preco/ajax_carrega_cotacao') ?>/?produto_id=' + this.temp_produto_id + "&param_territorio_id=" + this.cotacao_territorio_id + "&param_municipio_id=" + this.param_municipio_id;
                    //alert(url)
                    let result = await fetch(url);
                    let json = await result.json();
                    // alert()
                    if (json.length == 0) {
                        alert('Preço não encontrado')
                    }
                    this.produto_preco = json;

                    let tem_territorio_principal_entidade = false;
                    if (this.produto_preco.length > 0) {
                        this.produto_preco.map(i => {
                            //:class="i.flag_territorio == 'flag_territorio_principal'?'verde':''">
                            if (i.flag_territorio == 'flag_territorio_principal') {
                                tem_territorio_principal_entidade = true;
                            }
                        })
                    }
                    // if(tem_territorio_principal_entidade == false){
                    //     alert("Para o seu/selecionado território não existem fornecedores");
                    // }

                    // if (+json.length < 3) {
                    //     alert('Infelizmente não existe o minimo de três Fornecedores para o produto "'+this.temp_produto_nm+'"');
                    //     this.produto_preco = []
                    //     this.media_3_itens = 0;
                    //     return false;
                    // }

                    let qtd_itens = 0;
                    let soma = 0;

                    this.produto_preco.map(i => {
                        soma += +i.valor;
                        qtd_itens++;
                    })

                    this.media_3_itens = soma / qtd_itens

                    this.calcula_dotacao();
                },
                calcula_preco_medio_produto: function(produto_id) {
                    let soma = 0;
                    let qtd_itens = 0;
                    this.produto_preco_cotacao.map((i, index) => {
                        if (i.produto_id == produto_id) {
                            soma += +i.valor;
                            qtd_itens++;
                        }
                    })
                    return soma / qtd_itens;
                },
                calcula_dotacao: function() {

                    this.cotacao_media = []
                    let produto_nm_atual = ''
                    this.produto_preco_cotacao.map((i, index) => {

                        if (produto_nm_atual != i.produto_nm || index == 0) {

                            let item = {
                                'index': index,
                                'produto_nm': i.produto_nm,
                                'produto_nm_completo': i.produto_nm_completo,
                                'valor_medio': this.calcula_preco_medio_produto(i.produto_id),
                                'data_cotacao': 'hoje'
                            }
                            this.cotacao_media.push(item)

                        }

                        //salva o atual para comparar no proximo loop
                        produto_nm_atual = i.produto_nm
                    })
                },
                imprimir: function() {
                    //let html = $('#div_todo_html').html();
                    //$('#input_todo_html').val(html);
                    // $('#form').attr('action', "<?= site_url('cotacao/open_pdf') ?>");
                    // $('#form').submit();
                },
                ajax_carrega_municipios_por_territorio: async function() {
                    this.municipio = []
                    this.produto_preco = []
                    this.produto_preco_cotacao = []
                    this.cotacao_media = []
                    this.temp_produto_visible = true
                    this.flag_cotacao_ja_add = false
                    this.temp_produto_id = ''
                    let url = '<?= site_url('municipio/ajax_carrega_municipios_por_territorio') ?>/' + this.cotacao_territorio_id;
                    // alert(url)
                    let result = await fetch(url);
                    let json = await result.json();
                    // alert()
                    // if (json.length == 0) {
                    //     alert('Preço não encontrado')
                    // }
                    this.municipio = json;
                },
                ajax_carrega_produtos_por_municipio: async function() {
                    let url = '<?= site_url('produto/ajax_carrega_produtos_por_municipio') ?>/' + this.param_municipio_id;
                    alert(url)
                    let result = await fetch(url);
                    let json = await result.json();
                    // alert(json.length)
                    //1 =é vazio, apenas a opção selecione do combo
                    if (json.length == 1) {
                        alert('Nenhum produto encontrado para o município selecionado')
                        // aki
                        this.produto_preco_cotacao = []
                        this.produto_preco = []
                        this.cotacao_media = []
                    }
                    this.produto = json;
                },
                limpar_filtros_cotacao: function() {
                    window.location.reload(true);
                },
                formatarDataHora: function(dataAmericana) {
                    var partes = dataAmericana.split(' ');
                    var dataPartes = partes[0].split('-');
                    var horaPartes = partes[1].split(':');

                    // Construindo a data no formato brasileiro
                    var dataBrasileira = dataPartes[2] + '/' + dataPartes[1] + '/' + dataPartes[0];
                    var hora = horaPartes[0] + ':' + horaPartes[1];

                    // Retornando a data no formato brasileiro com hora
                    return dataBrasileira + ' ' + hora;
                },

            },
            watch: {
                temp_produto_id(novo, anterior) {

                    this.temp_produto_nm = '';
                    if ($('#temp_produto_id :selected').text() != '.:Selecione:.') {
                        this.temp_produto_nm = $('#temp_produto_id :selected').text();
                    }


                    if (this.temp_produto_id != '') {
                        this.ajaxCarregaCotacao();
                    }
                    // this.temp_produto_visible = false

                },
                async cotacao_territorio_id(novo, anterior) {

                    // if (this.temp_produto_id != '') {
                    //     this.ajaxCarregaCotacao();
                    // }
                    // await this.ajax_carrega_municipios_por_territorio()

                }

            },
            mounted() {
                this.territorio_nm = $('#cotacao_territorio_id :selected').text();
                //alert(this.territorio_nm)
                if ((this.territorio_nm == '' || this.territorio_nm == '.:Selecione:.') && this.controller != 'read') {
                    alert("Seu cadastro está incompleto, favor entrar em contato com a SDR/SUAF para atualização");
                    window.location.replace("<?= site_url('cotacao') ?>");
                }
                if (this.controller == 'read') {
                    $("input").prop("disabled", true);
                    $("select").prop("disabled", true);
                    $("textarea").prop("disabled", true);
                    $("#input_todo_html").prop("disabled", false);
                    $("#cotacao_id").prop("disabled", false);
                    $("#cotacao_id").show();
                    $("#btnGravar").hide();
                    this.calcula_dotacao()
                    this.calcula_soma_valor_medio()

                } else if (this.controller == 'create') {
                    //tela de create
                } else if (this.controller == 'update') {
                    //tela de update 
                    this.calcula_dotacao()
                    this.calcula_soma_valor_medio()
                }
            },
        });
    </script>
    <style>
        .verde {
            color: green
        }
    </style>
</body>

</html>

<?php include '../template/end.php'; ?>