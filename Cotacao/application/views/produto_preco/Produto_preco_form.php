<?php include '../template/begin_1_2018rn.php'; ?>
<html>

<head>

</head>

<body>

    <!-- ###app### -->
    <style>
        [v-cloak] {
            display: none;
        }



        /** quero que essa classe seja flutuante, e acompanhe a rolagem da pagina scroll */
        .botoes-flutuantes {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
    </style>
    <div id='app' v-cloak></div>
    <!-- ### -->

    <template id="app-template">
        <div>
            <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro de</span> Preço<?php  ?></h2>


            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

                <div class='col-md-12' name='' id=''>

                    <div class='x_panel' id=''>
                        <div class='x_content'>
                            <div style='overflow-x:auto'>
                                <div>
                                    <table class="table">
                                        <tr>
                                            <th colspan="2">Ações</th>
                                        </tr>
                                        <tr>
                                            <td colspan='2'>
                                                <input type="hidden" name="produto_preco_id" value="<?php echo $produto_preco_id; ?>" />
                                                <button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>
                                                <a href="<?php echo site_url('produto') ?>" class="btn btn-default">Voltar</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <table class='table'>
                                    <tr>
                                        <td><b>Categoria</b></td>
                                        <td>{{categoria_nm}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10%">
                                            <div class="form-group">
                                                <label for="integer">Produto* <?php echo form_error('produto_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <b>{{produto_nm}}</b>
                                            <div class="item form-group" style="display: none">
                                                <select2 :options="produto" v-model='form.produto_id' id='produto_id' name='produto_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><b>Qtd</b></td>
                                        <td>{{produto_qtd}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Unidade de medida</b></td>
                                        <td>{{unidade_medida_nm}}</td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td>
                                            <div class="form-group red">
                                                <label for="double precision">Novo Valor* <?php echo form_error('valor') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <input type="" class="form-control" name="valor" id="valor" placeholder="Valor" v-model="form.valor" onkeypress="mascara(this, money);" />
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <h2><i class="glyphicon glyphicon-asterisk"></i> Valor por território</h2>
                                <div class="alert alert-success" role="alert">
                                    Preencha apenas os <b>Valores</b> do produto para os territórios que você tem interesse em ofertar
                                </div>
                                <table class="table">
                                    <tr>
                                        <th style="width: 20%;">Território</th>
                                        <th>Valor (R$)</th>
                                        <th style="width: 50%">Municipios do território</th>
                                    </tr>
                                    <tr v-for="(i, key) in territorio">
                                        <td :class="i.produto_preco_territorio_valor>0?'vermelho':''">
                                            <b> {{i.territorio_nm.toUpperCase()}}</b>
                                            <input type="number" name="territorio_id[]" :value="i.territorio_id" class='form-control' style="width: 50%;" v-show='false'>
                                        </td>
                                        <td>
                                            <input name="produto_preco_territorio_valor[]" :value="i.produto_preco_territorio_valor" class='form-control' style="width: 50%;" placeholder="0.00" onkeypress="mascara(this, money);">
                                        </td>
                                        <td>
                                            <input type="button" value="Ver municípios do território" v-show="false"
                                                :id="'btn_municipios_' + i.territorio_id"
                                                @click="ajax_carrega_municipios_por_territorio(i.territorio_id)">
                                            <span v-for="(m, mkey) in i.municipios" style="font-size: 10px;">
                                                <span v-show="mkey == 0"> {{m.municipio_nm}}</span>
                                                <span v-show="mkey != 0">, {{m.municipio_nm}}</span>
                                            </span>
                                            <div :id="'div_municipios_' + i.territorio_id">

                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table">
                        <tr>
                            <th colspan="2">Ações</th>
                        </tr>
                        <tr>
                            <td colspan='2'>
                                <input type="hidden" name="produto_preco_id" value="<?php echo $produto_preco_id; ?>" />
                                <button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>
                                <a href="<?php echo site_url('produto') ?>" class="btn btn-default">Voltar</a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class='col-md-12' name='' id=''>
                    <div class='x_panel' id=''>
                        <div class='x_content'>
                            <h3>Seu histórico</h3> <input type="button" value="Exibir Histórico de preços" @click="exibir_historico = !exibir_historico">
                            <div style='overflow-x:auto'>
                                <table class='table'>
                                    <tr>
                                    <th>Data</th>
                                        <th>Território</th>
                                        
                                        <th>Histório - Preço (R$)</th>
                                    </tr>
                                    <tr v-for="(i, index) in produto_preco_territorio_historico" v-if="i.produto_preco_territorio_valor > 0" v-show="exibir_historico">
                                        <td>
                                            <span>{{dataToBRcomHora(i.produto_preco_territorio_dt_cadastro)}}</span>
                                        </td>
                                        <td>
                                            {{i.territorio_nm}}
                                        </td>
                                        <td>
                                            <b class="green" v-if="i.produto_preco_territorio_valor > 0">{{moedaBR(i.produto_preco_territorio_valor)}}</b>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                            <div v-show="!exibir_historico">
                                <b  @click="exibir_historico = !exibir_historico" style="cursor: pointer;">Seu histórico de preços por território</b>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </template>
    <!--script type="text/x-template" id="select2-template">
        <select>
           <slot></slot>
        </select>
    </script-->


    <!--monta combobox-->
    <!--script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/select2/montaSelect.js"></script-->
    <script type="text/javascript" language="javascript" src="<?php echo iPATH ?>/JavaScript/vue/select2/montaSelect.js"></script>

    <script>
        new Vue({
            el: "#app",
            template: "#app-template",
            data: {
                exibir_historico: false,
                message: '',
                button: "<?= $button ?>",
                controller: "<?= $controller ?>",
                categoria_nm: "<?= $categoria_nm ?>",
                /*tag select*/
                produto: <?= $produto ?>,
                territorio: <?= $territorio ?>,
                produto_preco_territorio_historico: <?= $produto_preco_territorio_historico ?>,
                pessoa: <?= $pessoa ?>,
                produto_nm: '<?= rupper($produto_nm) ?>',
                produto_qtd: '<?= ($produto_qtd) ?>',
                unidade_medida_nm: '<?= rupper($unidade_medida_nm) ?>',
                produto_tipo_nm: '<?= rupper($produto_tipo_nm) ?>',
                /*form*/
                form: {
                    produto_id: "<?= $produto_id ?>",
                    pessoa_id: "<?= $pessoa_id ?>",
                    valor: "<?= $valor ?>",
                    produto_preco_dt: "<?= $produto_preco_dt ?>",
                    ativo: "<?= $ativo ?>",

                },
            },
            computed: {

            },
            methods: {


                ajax_carrega_municipios_por_territorio: async function(territorio_id) {
                    url = '<?= site_url('municipio/ajax_carrega_municipios_por_territorio_result_completo') ?>/' + territorio_id;
                    // alert(url)
                    let result = await fetch(url);
                    let json = await result.json();
                    // alert(json)
                    let municipios = "";
                    municipios += json.map((i, key) => {
                        if (key == 0) {
                            return i.municipio_nm;
                        } else {
                            return ' ' + i.municipio_nm;
                        }

                    })

                    $('#div_municipios_' + territorio_id).html(municipios)
                    $('#btn_municipios_' + territorio_id).hide()
                    console.table(json)
                }
            },
            mounted() {
                if (this.controller == 'read') {
                    $("input").prop("disabled", true);
                    $("select").prop("disabled", true);
                    $("textarea").prop("disabled", true);
                    $("#btnGravar").hide();
                } else if (this.controller == 'create') {
                    //tela de create
                } else if (this.controller == 'update') {
                    //tela de update 
                }


            },
        });
    </script>
    <style>
        .vermelho {
            color: red
        }
    </style>
</body>

</html>

<?php include '../template/end.php'; ?>