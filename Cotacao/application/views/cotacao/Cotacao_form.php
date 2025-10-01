<?php include '../template/begin_1_2018rn.php'; ?>
<html>

<head>

</head>

<body>



    <style>
        [v-cloak] {
            display: none;
        }

        /* Estilo do modal */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            min-width: 300px;
            max-width: 90%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .modal-footer {
            margin-top: 20px;
            text-align: right;
        }

        .btn {
            padding: 6px 12px;
            margin-left: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-default {
            background-color: #ccc;
            color: black;
        }



        /**modal */
        /** modal */
        .modal-mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            /* move o modal para o topo */
            padding-top: 40px;
            /* espaço do topo */
        }

        .modal-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .modal-container {
            width: 800px;
            max-width: 95%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Cabeçalho do modal */
        .modal-header {
            padding: 16px;
            background-color: #004085;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Botão de fechar */
        .modal-header .btn-fechar {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal-header .btn-fechar:hover {
            background-color: #c82333;
        }

        .modal-body {
            height: 500px;
            padding: 0;
        }

        .modal-body iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .modal-footer {
            padding: 12px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
    </style>
    <div id='app' v-cloak>
        <div>
            <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cotação por Produto</span> <?php // echo $button 
                                                                                                                                            ?></h2>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id='form'>
                <input type="hidden" name="cotacao_id" id="cotacao_id" value="<?php echo $cotacao_id; ?>" />
                <div id='div_todo_html'>
                    <div class="row">
                        <div class='col-md-12' name='' id='' v-if="controller=='read'">
                            <div class='x_panel' id=''>
                                <div class='x_content'>
                                    <div style='overflow-x:auto'>
                                        <table class='table'>
                                            <tr>
                                                <td class="red">
                                                    <span v-for="(i, key) in instrucoes">
                                                        <span class="">{{i}}</span> <br>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo site_url('cotacao') ?>" class="btn btn-default">Voltar</a>
                                                    <a class="btn btn-danger" v-if="controller != 'create'" @click="imprimir()">Imprimir</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-12' name='' id=''>
                            <div class='x_panel' id=''>
                                <div class='x_content'>
                                    <div style='overflow-x:auto'>
                                        <table class='table'>
                                            <tr>
                                                <td style="width: 10%">
                                               
                                                        <label for="integer">Solicitante </label>
                                                   <br>
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
                                                    <label for="cotacao_ds">Motivo/Finalidade* <?php echo form_error('cotacao_ds') ?></label> <br>
                                                    <div class="form-group">
                                                        <!-- <textarea maxlength="800" class="form-control" rows="2" v-model="form.cotacao_ds" name="cotacao_ds" id="cotacao_ds" placeholder="">{{form.cotacao_ds }}</textarea> -->
                                                        <div v-show="controller !='read'">
                                                            <select class="form-control" v-model="form.cotacao_ds" name="cotacao_ds" id="cotacao_ds">
                                                                <option value="">.:Selecione:.</option>
                                                                <option v-for="(item, index) in motivo_cotacao" :key="index" :value="item.value">
                                                                    {{ item.label }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div v-show="controller =='read'">
                                                            {{form.cotacao_ds}}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr v-show="perfil == 'Nutricionista' || perfil == 'Administrador' || perfil == 'Gestor'">
                                                <td> 
                                                    <b>Solicitar para:</b>
                                                    <br>
                                                    <b class="red">1 - Campo disponível apenas para Nutricionista/Gestores;</b> <br>
                                                    <b class="red">2 - Ao trocar o território/escola, a cotação abaixo é limpa;</b> <br>
                                                    <b class="red">3 - Selecione o territorio, municipio e escola para continuar;</b> <br>
                                                    <table class="table" style="width: 70%">
                                                        <tr>
                                                            <th style="width: 20%">Terrítorio</th>
                                                            <th style="width: 20%">Munícipio</th>
                                                            <th style="width: 60%">COD_SEC - Escola </th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <select name="solicitado_para_territorio_id" id="solicitado_para_territorio_id" v-model="solicitado_para_territorio_id"
                                                                    @change="ajax_carrega_solicitado_para_por_territorio"
                                                                    class="form-control"
                                                                    :disabled="controller === 'read'">
                                                                    <option value="">.:Todos:.</option>
                                                                    <option v-for="(t, index) in solicitado_para_territorio" :key="index" :value="t.territorio_id">
                                                                        {{ t.territorio_nm?.toUpperCase() }}
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="solicitado_para_municipio_id" id="solicitado_para_municipio_id" v-model="solicitado_para_municipio_id"
                                                                    @change="ajax_carrega_solicitado_para_por_territorio"
                                                                    class="form-control"
                                                                    :disabled="controller === 'read'">
                                                                    <option value="">.:Todos:.</option>
                                                                    <option v-for="(i, key) in municipios_solicitado_para" :value="i.id">{{i.text}}</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="solicitado_para_pessoa_id" id="solicitado_para_pessoa_id" v-model="solicitado_para_pessoa_id" class="form-control"
                                                                    :disabled="controller === 'read'" @change="alterarTerritorioPelaEscola()">
                                                                    <option value="">.:Selecione:.</option>
                                                                    <optgroup v-for="(grupo, territorio) in agrupadoPorTerritorio" :key="territorio" :label="territorio">
                                                                        <option
                                                                            v-for="(pessoa, index) in grupo"
                                                                            :key="pessoa.pessoa_id"
                                                                            :value="pessoa.pessoa_id">
                                                                            {{ pessoa.cod_sec }} - {{ pessoa.pessoa_nm }}
                                                                        </option>
                                                                    </optgroup>
                                                                </select>

                                                            </td>
                                                        </tr>
                                                        <tr v-show="controller !== 'read'">
                                                            <td colspan="3">
                                                                <input @click="exibir_modal" type="button" value="Caso não encontre a Escola, cadastre aqui" style="width: 100%;" class="btn btn-sm btn-danger">
                                                                <!-- <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal">
                                                                Caso não encontre a Escola, cadastre aqui
                                                            </button>  -->
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- Modal -->
                                                    <div v-if="modalAberto" class="modal-mask">
                                                        <div class="modal-wrapper">
                                                            <div class="modal-container">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Cadastrar Escola</h5>
                                                                    <button class="btn-fechar" @click="fechar_modal">Fechar</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <iframe :src="iframeUrl"></iframe>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <!-- Outros botões, se quiser -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-8' name='' id='' v-if="controller !='read'">
                            <div class='x_panel' id=''>
                                <div class='x_content'>
                                    <div style='overflow-x:auto'>
                                        <div class="alert alert-success" role="alert">
                                            Ao montar sua Cotação, prefira produtos regionais do seu terrório <b>{{fornecedor_territorio_nm}}</b>
                                        </div>
                                        <h2><i class="glyphicon glyphicon-apple"></i> Produto - <small class='red'>selecione o produto</small></b></h2>
                                        <table class='table'>
                                            <!-- <tr style="display: none;">
                                            <td style="width: 50%;">
                                                <div>
                                                    <b>Território <small>(do fornecedor)</small></b> <br> 
                                                    <select name="cotacao_territorio_id" id="cotacao_territorio_id" class="form-control" @change="ajax_carrega_municipios_por_territorio" v-model="cotacao_territorio_id">
                                                        <option value=''>Todos Territórios</option>
                                                        <option v-for="(t,tkey) in territorio" :value='t.id'>{{t.text}}</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td style="width: 50%;">
                                                <b>Munícipio <small>(do fornecedor)</small></b> <br>
                                                <select name="param_municipio_id" id="param_municipio_id" v-model='param_municipio_id' class='form-control' @change="ajax_carrega_produtos_por_municipio">
                                                    <option value="">Todos</option>
                                                    <option v-for="(m, mkey) in municipio" :value="m.id">{{m.text}}</option>
                                                </select> 
                                            </td>
                                        </tr> -->
                                            <tr>
                                                <td colspan="4">
                                                    <b>Território</b>
                                                    <select @change="ajaxCarregaCotacao(); ajax_carrega_produtos_com_preco_valido_territorio()" v-model="flag_exibir_todos_produtos_territorio" name="flag_exibir_todos_produtos_territorio" id="flag_exibir_todos_produtos_territorio" class="form-control">
                                                        <option value="0">Exibir todos Territórios</option>
                                                        <option value="1">Exibir apenas o seu Território {{fornecedor_territorio_nm}}</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 70%;">
                                                    <b v-show="flag_cotacao_ja_add==true" class='green'>{{temp_produto_nm}}</b>
                                                    <span v-show="temp_produto_visible == true">
                                                        <b>Produto</b> <br> <small>{{produto.length}} produtos(s) encontrados</small>
                                                        <select2-component
                                                            :selected="temp_produto_id"
                                                            v-model="temp_produto_id"
                                                            :options="produto"
                                                            required>
                                                        </select2-component>

                                                        <!-- <select v-model='temp_produto_id' id='temp_produto_id' style="width: 100%;" class="form-control" @change="ajaxCarregaCotacao">
                                                        <option value='' disabled>.:Selecione:.</option>
                                                        <option v-for="(i, key) in produto" :value="i.id">{{i.text}}</option>
                                                    </select> -->
                                                    </span>
                                                </td>
                                                <td>
                                                    <b>&nbsp;<br></b>

                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class='col-md-6' name='' id='' v-if="controller !='read'">
                            <div class='x_panel' id=''>
                                <div class='x_content'>
                                    <div style='overflow-x:auto'>
                                        <h2><i class='glyphicon glyphicon-th-list'></i> Monte sua cotação</h2> <br>
                                        <div v-if="media && desvioPadrao" v-show="false">

                                            <h3 style="font-size: 12px;">
                                                <b>Média: <i class="glyphicon glyphicon-question-sign" style="cursor: pointer; color:blue" title="soma de todos os valores dividida pela quantidade de valores - representa o valor médio do conjunto"></i></b> R$ {{ media }}

                                                <span v-if="foraDaFaixa2.length > 0"> | <b>Desvio padrão:<i class="glyphicon glyphicon-question-sign" style="cursor: pointer; color:blue" title="Mede o quanto os valores se afastam da média; quanto maior o desvio, mais espalhados (variáveis) estão os dados"></i></b> R$ {{ desvioPadrao }}</span>
                                            </h3>

                                            <div v-show="false">
                                                <h4 style="font-size: 12px;">Valores dentro da faixa 1 :</h4>
                                                <ul>
                                                    <li v-for="p in faixa1" :key="p.nome" style="font-size: 12px;">
                                                        {{ p.nome }} - R$ {{ moedaBR(p.valor??'0') }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div v-show="true" v-if="foraDaFaixa2.length > 0">
                                                <h4 style="color: red; font-size: 12px;">
                                                    <i class="glyphicon glyphicon-stop" style="cursor: pointer; color:red" title="Valores discrepantes: valores que se afastam da média; quanto maior o desvio, mais espalhados (variáveis) estão os dados"></i>
                                                    Valores discrepantes:
                                                </h4>
                                                <ul>
                                                    <li v-for="p in foraDaFaixa2" :key="p.nome" style="font-size: 12px;">
                                                        <span class="red"> <b>{{ moedaBR(p.valor??'0') }}</b></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- <h2><i class='glyphicon glyphicon-th-list'></i> Monte sua cotação</h2> <br> -->
                                        <!-- {{message}} -->
                                        <b class="red">{{temp_produto_nm}}</b>
                                        <!-- <span v-if="temp_produto_id !=''">três melhores preços</span> -->
                                        <table class='table'>
                                            <tr>
                                                <th>-</th>
                                                <!-- <th>Data</th> -->
                                                <th style="width: 40%">Fornecedor</th>
                                                <th style="width: 50%">Territorio</th>
                                                <th style="width: 10%">Preço</th>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    Legenda: <span style="color: green"><i class="glyphicon glyphicon-stop"></i> Fornecedores do seu território <b>{{fornecedor_territorio_nm}}</b></span>
                                                </td>
                                            </tr>
                                            <tr v-if="produto_preco.length > 7 ">
                                                <td colspan="4">
                                                    <input type="button" value="Adicionar" class="btn btn-success btn-sm" @click="addProdutoPreco()" style="width: 100%">
                                                </td>
                                            </tr>
                                            <!--item que vão ser adicionados-->
                                            <tr v-for="(i, index) in produto_preco" :class="i.territorio_id == fornecedor_territorio_id ? 'verde' : ''">
                                                <td>
                                                    <!-- <input type="checkbox" name="" id="" v-model="i.selecionado" 
                                                @click="valida_fornecedor_duplicado(i.pessoa_id, index)"
                                                :checked="i.selecionado==true?'checked':''"
                                                > -->
                                                    <input class='checkbox_cotacoes' type="checkbox" name="" id="" v-model="i.selecionado" @change="valida_fornecedor_duplicado(i.pessoa_id, index)">
                                                </td>
                                                <!-- <td>
                                                {{formatarDataHora(i.produto_preco_dt)}}
                                            </td> -->
                                                <td>
                                                    {{i.pessoa_nm_fantasia ? i.pessoa_nm_fantasia : i.pessoa_nm}} <br>

                                                    <b>{{i.pessoa_cnpj}}</b>
                                                </td>
                                                <td>
                                                    <!-- <i class="glyphicon glyphicon-zoom-in" @click="abrirModal(i.territorio_id)" style="cursor: pointer;"></i> -->
                                                    <!-- {{i.municipio_nm??'Não informado'}} <br> -->
                                                    <span class="badge" style="background-color: green" v-if="i.territorio_id == fornecedor_territorio_id"><b>{{i.territorio_nm}}</b></span>
                                                    <span v-else><b>{{i.territorio_nm ?? 'Não informado'}}</b></span>
                                                    Munícipios:
                                                    <span v-for="(m, index) in i.municipios" :key="m.municipio_id">
                                                        <small style="font-size: 10px;">{{capitalizarPalavras(m.municipio_nm)}}<span v-if="index < i.municipios.length - 1">, </span></small>
                                                    </span>
                                                </td>
                                                <td align="right">
                                                    <!-- <b class='red'>{{moedaBR(i.valor)}}</b> -->
                                                    <b :class='esta_fora_da_faixa(+i.valor)?"red":""'>{{moedaBR(+i.valor)}}</b>
                                                </td>
                                            </tr>
                                            <tr v-if="produto_preco.length>0">
                                                <td colspan="4">
                                                    <input type="button" value="Adicionar" class="btn btn-success btn-sm" @click="addProdutoPreco()" style="width: 100%">
                                                </td>
                                            </tr>
                                            <tr v-show="carregando">
                                                <td align="center" colspan="4">
                                                    <img src="<?= iPATHGif ?>/risco_infinito.gif" alt="" style="width: 20%;">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" name='' id='div_cotacao_ja_criada'>
                            <div class='x_panel' id=''>
                                <div class='x_content'>
                                    <div style='overflow-x:auto'>
                                        <h2> <i class='glyphicon glyphicon-arrow-down'></i> Sua cotação</h2>
                                        <br>
                                        <table class="table">
                                            <tr>
                                                <th>Produto</th>
                                                <th>Preço medio</th>
                                            </tr>
                                            <tr v-for="(i, index) in cotacao_media">
                                                <td>{{i.produto_nm_completo}}</td>
                                                <td align="right">{{moedaBR(+i.valor_medio)}}</td>
                                            </tr>
                                            <tr style="background-color: #ededed">
                                                <td><b>Total</b></td>
                                                <td align="right"><b>{{moedaBR(+soma_valor_medio)}}</b></td>
                                            </tr>
                                        </table>
                                        <button id="" type="button" class="btn btn-danger btn-sm" @click="limpaCotacao" v-if="controller !='read'" v-show="flag_cotacao_ja_add == true" style="width: 100%;">Limpar cotação</button>
                                        <hr>
                                        <h2> <i class='glyphicon glyphicon-arrow-down'></i> Detalhamento da cotação</h2>
                                        <table class='table'>
                                            <tr>
                                                <th>Produto</th>
                                                <!-- <th>Data</th> -->
                                                <th>Fornecedor</th>
                                                <th>Territorio</th>
                                                <th>Valor</th>
                                            </tr>
                                            <!--item ja adicionados-->
                                            <tr v-for="(i, index) in produto_preco_cotacao">
                                                <td>
                                                    <b class=' '>{{i.produto_nm_completo}}</b>
                                                    <input type="hidden" :value="i.produto_preco_id" name='produto_preco_id[]'>
                                                    <input type="hidden" :value="i.produto_id" name='produto_id[]'>
                                                    <input type="hidden" :value="i.valor" name='valor[]'>
                                                    <input type="hidden" :value="i.produto_preco_dt" name='produto_preco_dt[]'>
                                                </td>
                                                <!-- <td>{{formatarDataHora(i.produto_preco_dt)}}</td> -->
                                                <td>{{i.pessoa_nm}}</td>
                                                <td>{{i.territorio_nm??'Não informado'}}</td>
                                                <td align="right">
                                                    <b>{{moedaBR(+i.valor)}}</b>
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <input type="button" value="Limpar" @click="limpar_filtros_cotacao" class="btn btn-sm btn-danger" style="width: 100%;" v-show="produto_preco_cotacao.length > 0 && controller != 'read'">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-12' name='' id='' v-if="controller=='create' || controller=='update' ">
                            <div class='x_panel' id=''>
                                <div class='x_content'>
                                    <div style='overflow-x:auto'>
                                        <table class='table'>
                                            <tr>
                                                <td class='red'>
                                                    <span v-for="(i, key) in instrucoes">
                                                        <span class="">{{i}}</span> <br>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>*Está Cotação tem validade de <?= DIAS_VALIDADE_PRECO ?> dia(s)</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <button id="btnGravar" type="button" class="btn btn-primary" @click="submeter()">
                                                        {{controller=='create'?'Avançar/Salvar Cotação':'Solicitar Cotação'}}
                                                    </button>

                                                    <a href="<?php echo site_url('cotacao') ?>" class="btn btn-default">Voltar</a>
                                                    <a href="<?php echo site_url('cotacao') ?>" class="btn btn-danger" v-if="controller != 'create'">Imprimir</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="input_todo_html" name="input_todo_html">
            </form>

        </div>


    </div>
    <!--script type="text/x-template" id="select2-template">
        <select>
           <slot></slot>
        </select>
    </script-->


    <!--monta combobox-->
    <!--script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/select2/montaSelect.js"></script-->
    <script type="text/javascript" language="javascript" src="<?php echo iPATH ?>/JavaScript/vue/select2/montaSelect.js"></script>

    <script type="module">
        import {
            createApp
        } from "<?= iPATH ?>JavaScript/vue/vue3/vue.esm-browser.prod.js"
        import {
            Select2Component
        } from "<?= iPATH ?>JavaScript/vue/select2/Select2Component.js"

        import * as func from "<?= iPATH ?>/JavaScript/func.js"

        const app = createApp({
            components: {
                Select2Component
            },
            data() {
                return {
                    modalAberto: false,

                    flag_exibir_todos_produtos_territorio: 1,
                    carregando: false,
                    motivo_cotacao: <?= MOTIVO_COTACAO ?>,
                    perfil: '<?= $_SESSION['perfil'] ?>',
                    instrucoes: [
                        // '1 - para receber a cotação é necessario aguardar analise da Equipe SUAF/SDR',
                        // '1 - o usuário pode criar quantas cotações achar necessario (por produto);', 
                        // '2 - não é possivel editar uma cotação salva;',
                        // '3 - a cotação pode ser excluida;',
                    ],
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
                    solicitado_para: <?= $solicitado_para ?>,
                    solicitado_para_pessoa_id: '<?= empty($solicitado_para_pessoa_id) ? '' : $solicitado_para_pessoa_id ?>',
                    solicitado_para_territorio_id: '',
                    solicitado_para_municipio_id: '',
                    territorio: <?= $territorio ?>,
                    solicitado_para_territorio: <?= $solicitado_para_territorio ?>,
                    municipio: <?= $municipio ?>,
                    pessoa: <?= $pessoa ?>,
                    produto: <?= $produto ?>,
                    temp_produto_id: 0,
                    executou: 0,
                    media_3_itens: 0,
                    soma_valor_medio: 0,
                    territorio_nm: '',
                    cotacao_territorio_id: '',
                    cotacao_media: [],
                    municipios_solicitado_para: null,

                    media: null,
                    desvioPadrao: null,
                    faixa1: [],
                    foraDaFaixa2: [],


                    form: {
                        cotacao_pessoa_id: "<?= $cotacao_pessoa_id ?>",
                        cotacao_dt: "<?= $cotacao_dt ?>",
                        cotacao_ds: "<?= $cotacao_ds ?>",
                    },

                }
            },
            computed: {
                agrupadoPorTerritorio() {
                    const grupos = {};
                    this.solicitado_para.forEach(pessoa => {
                        const territorio = pessoa.territorio_nm || 'Sem território';
                        if (!grupos[territorio]) {
                            grupos[territorio] = [];
                        }
                        grupos[territorio].push(pessoa);
                    });
                    return grupos;
                }
            },
            watch: {
                temp_produto_id: async function(anterior, atual) {
                    //console.log(anterior, atual)
                    await this.ajaxCarregaCotacao();

                    await this.analisarValores();
                }
            },
            methods: {
                dataToBR,
                dataToBRcomHora,
                moedaBR,
                alterarTerritorioPelaEscola: async function() {

                    //alert(this.solicitado_para_territorio_id)
                    if (!this.solicitado_para_territorio_id) {
                        alert('favor informar o territorio')
                        return false
                    }



                    if (!this.solicitado_para_pessoa_id) {
                        alert('favor informar a escola')
                        return false
                    }


                    await this.ajax_carrega_nome_territorio(this.solicitado_para_territorio_id)

                    this.fornecedor_territorio_id = this.solicitado_para_territorio_id
                    this.param_territorio_id = this.solicitado_para_territorio_id
                    //this.param_municipio_id = this.solicitado_para_municipio_id
                    this.param_pessoa_id = this.solicitado_para_pessoa_id
                    this.cotacao_territorio_id = this.solicitado_para_territorio_id
                    this.cotacao_pessoa_id = this.solicitado_para_pessoa_id


                    await this.ajax_carrega_produtos_com_preco_valido_territorio();


                    //limpar o edtalhamento da cotacao
                    this.produto_preco = [];
                    this.produto_preco_cotacao = [];
                    this.cotacao_media = [];
                    this.soma_valor_medio = 0;



                },
                ajax_carrega_nome_territorio: async function(territorio_id) {
                    let url = '<?= site_url('territorio/ajax_carrega_nome_territorio') ?>/?territorio_id=' + territorio_id;
                    let result = await fetch(url);
                    let json = await result.json();
                    console.log(json.territorio_nm)
                    this.fornecedor_territorio_nm = json?.territorio_nm;
                },
                capitalizarPalavras: function(texto) {
                    return texto
                        .toLowerCase() // coloca tudo em minúsculas primeiro
                        .split(' ') // divide por espaço
                        .filter(p => p.trim() !== '') // remove espaços duplos
                        .map(palavra => palavra.charAt(0).toUpperCase() + palavra.slice(1))
                        .join(' ');
                },


                esta_fora_da_faixa: function(valor) {
                    const margem = 0.001;
                    return this.foraDaFaixa2.some(p => Math.abs(p.valor - valor) < margem);
                },
                analisarValores: function() {
                    const valores = this.produto_preco.map(p => +p.valor);
                    const media = valores.reduce((a, b) => +a + +b, 0) / valores.length;
                    const variancia = valores.reduce((soma, v) => soma + Math.pow(v - media, 2), 0) / valores.length;
                    const desvio = Math.sqrt(variancia);

                    this.media = media.toFixed(2);
                    this.desvioPadrao = desvio.toFixed(2);

                    const limiteMin1 = media - desvio;
                    const limiteMax1 = media + desvio;
                    const limiteMin2 = media - 2 * desvio;
                    const limiteMax2 = media + 2 * desvio;

                    this.faixa1 = this.produto_preco.filter(p => +p.valor >= +limiteMin1 && +p.valor <= +limiteMax1);
                    this.foraDaFaixa2 = this.produto_preco.filter(p => +p.valor < +limiteMin2 || +p.valor > +limiteMax2);
                },

                limpar_filtros_cotacao: function() {
                    // this.produto_preco = []
                    this.cotacao_media = []
                    this.produto_preco_cotacao = []
                },
                fechar_modal: function() {
                    //quero que atualize a pagina
                    location.reload()
                    // $('#modal_escolha').modal('hide')
                },
                exibir_modal_old: function(visitante_id, visita_id) {
                    this.declaracao_visitante_id = visitante_id
                    this.declaracao_visita_id = visita_id
                    $('#modal_escolha').modal('show')
                },
                gerarUrlIframe() {
                    // Gera a URL do iframe dinamicamente se necessário
                    return `<?= base_url('inscricao/create/?cadastrando_escola=1') ?>`
                },
                exibir_modal: function(visitante_id, visita_id) {
                    this.declaracao_visitante_id = visitante_id
                    this.declaracao_visita_id = visita_id
                    this.iframeUrl = this.gerarUrlIframe()
                    this.modalAberto = true
                },
                formatarDataHora: function(data) {
                    // Verifica se a entrada é uma data válida
                    if (Object.prototype.toString.call(data) !== "[object Date]" || isNaN(data)) {
                        // console.error("A entrada não é uma data válida.");
                        return '';
                    }

                    // Obtém os componentes da data e hora
                    const dia = String(data.getDate()).padStart(2, '0'); // Dia com 2 dígitos
                    const mes = String(data.getMonth() + 1).padStart(2, '0'); // Mês com 2 dígitos (lembre-se que os meses começam de 0)
                    const ano = data.getFullYear(); // Ano
                    const hora = String(data.getHours()).padStart(2, '0'); // Hora com 2 dígitos
                    const minuto = String(data.getMinutes()).padStart(2, '0'); // Minuto com 2 dígitos
                    const segundo = String(data.getSeconds()).padStart(2, '0'); // Segundo com 2 dígitos

                    // Formata a data e hora no formato "dd/mm/yyyy hh:mm:ss"
                    return `${dia}/${mes}/${ano} ${hora}:${minuto}:${segundo}`;
                },
                ajax_carrega_municipios_por_territorio_filtro: async function() {
                    this.municipios_solicitado_para = []

                    let url = '<?= site_url('municipio/ajax_carrega_municipios_por_territorio') ?>/?territorio_id=' + this.solicitado_para_territorio_id
                    // alert(url)
                    let result = await fetch(url);
                    let json = await result.json();
                    this.municipios_solicitado_para = json;

                },
                ajax_carrega_produtos_com_preco_valido_territorio: async function() {
                    //atualiza o produto a depender do territorio
                    this.produto = []
                    //esta usando o territorio da pessoa cadastrada
                    let url = '<?= site_url('produto/ajax_carrega_produtos_com_preco_valido_territorio') ?>/?flag_exibir_todos_produtos_territorio=' + this.flag_exibir_todos_produtos_territorio +
                        "&territorio_id=" + this.cotacao_territorio_id + "&cotacao_pessoa_id=" + this.cotacao_pessoa_id
                    //alert(this.cotacao_pessoa_id)
                    // window.open(url)
                    //window.open(url)
                    let result = await fetch(url);
                    let json = await result.json();
                    this.produto = json
                },
                ajaxCarregaCotacao: async function() {
                    if (!this.temp_produto_id) {
                        return false
                    }
                    this.carregando = true;
                    this.produto_preco = []
                    this.executou++

                    //se nao tiver escola, nao manda nada
                    this.cotacao_pessoa_id = this.cotacao_pessoa_id ?? ''
                    let url = '<?= site_url('produto_preco/ajax_carrega_cotacao') ?>/?produto_id=' + this.temp_produto_id +
                        "&param_territorio_id=" + this.cotacao_territorio_id +
                        "&param_municipio_id=" + this.param_municipio_id +
                        "&cotacao_pessoa_id=" + this.cotacao_pessoa_id +
                        "&flag_exibir_todos_produtos_territorio=" + this.flag_exibir_todos_produtos_territorio;

                    // window.open(url)
                    this.message = url
                    let result = await fetch(url);
                    let json = await result.json();
                    if (json.length == 0) {
                        alert('Nenhum fornecedor encontrado');
                    }
                    this.produto_preco = json;
                    let tem_territorio_principal_entidade = false;
                    if (this.produto_preco.length > 0) {
                        this.produto_preco.map(i => {
                            if (i.flag_territorio == 'flag_territorio_principal') {
                                tem_territorio_principal_entidade = true;
                            }
                        })
                    }
                    let qtd_itens = 0;
                    let soma = 0;
                    this.produto_preco.map(i => {
                        soma += +i.valor;
                        qtd_itens++;
                    })
                    this.media_3_itens = soma / qtd_itens
                    await this.calcula_dotacao();
                    await this.ajax_carrega_produtos_com_preco_valido_territorio();
                    this.carregando = false;

                },
                ajax_carrega_solicitado_para_por_territorio: async function() {

                    await this.ajax_carrega_municipios_por_territorio_filtro();

                    if(this.solicitado_para_territorio_id == '' || this.solicitado_para_municipio_id == ''){
                        this.solicitado_para = []
                        return false;
                    }
                    this.solicitado_para = []
                    let url = '<?= site_url('pessoa/ajax_carrega_solicitado_para_por_territorio') ?>/?territorio_id=' + this.solicitado_para_territorio_id + "&municipio_id=" + this.solicitado_para_municipio_id
                    // alert(url)
                    let result = await fetch(url);
                    let json = await result.json();
                    this.solicitado_para = json

                    await this.ajax_carrega_produtos_com_preco_valido_territorio();
                },
                valida_fornecedor_duplicado: function(param_pessoa_id, indexSelecionado) {
                    let desmarcar = -1;
                    let msg_exibida = false
                    this.produto_preco.map((i, key) => {
                        if (i.selecionado == true) {
                            if (i.pessoa_id == param_pessoa_id && msg_exibida == false && indexSelecionado != key) {
                                alert('Atenção! Você NÃO pode escolher dois preços do mesmo Fornecedor')
                                msg_exibida = true
                                this.produto_preco.map((p, pkey) => {
                                    if (key == pkey) {
                                        i.selecionado = false
                                    }
                                })
                                return false;
                            }
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
                submeter: function() {
                    if (this.form.cotacao_ds.length == 0) {
                        alert('Favor informar a Motivo/Finalidade da cotação')
                        $('#cotacao_ds').focus();
                        return false;
                    }
                    if (this.produto_preco_cotacao.length == 0) {
                        alert("Favor adicionar os produtos a sua cotação");
                        return false;
                    } else {
                        $('#form').submit();
                    }
                },
                calcula_soma_valor_medio: async function() {
                    this.soma_valor_medio = 0;
                    this.cotacao_media.map((i, index) => {
                        //alert(parseFloat(i.valor_medio))
                        this.soma_valor_medio += parseFloat(i.valor_medio)
                    })
                },
                limpaCotacao: function() {
                    this.ajaxCarregaCotacao()
                    this.produto_preco_cotacao = []
                    this.cotacao_media = []
                    this.soma_valor_medio = 0;
                    this.temp_produto_visible = true;
                },
                addProdutoPreco: function() {
                    let flag_prod_ja_add = false;
                    let tem_selecionado = false
                    this.produto_preco.map(i => {
                        if (i.selecionado == true) {
                            tem_selecionado = true
                        }
                    })
                    if (tem_selecionado == false) {
                        alert('Antes de adicionar, favor selecionar sua cotação');
                        return false;
                    }
                    this.produto_preco_cotacao.map((i, index) => {
                        if (i.produto_id == this.temp_produto_id && flag_prod_ja_add == false) {
                            alert("Produto já adicionado a sua cotação");
                            flag_prod_ja_add = true;
                        }
                    })
                    let qtd_selecionados = 0;
                    this.produto_preco.map(i => {
                        if (i.selecionado == true) {
                            qtd_selecionados++
                        }
                    })
                    this.produto_preco = this.produto_preco.filter((i) => i.selecionado == true);
                    if (flag_prod_ja_add == false) {
                        this.produto_preco_cotacao = this.produto_preco_cotacao.concat(this.produto_preco)
                        this.calcula_dotacao();
                        this.calcula_soma_valor_medio();
                    }
                    this.produto_preco = []
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
                calcula_dotacao: async function() {
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
                        produto_nm_atual = i.produto_nm
                    })
                },
                imprimir: function() {

                    window.open("<?= site_url('cotacao/open_pdf') ?>/?cotacao_id=" + <?php echo (int)$cotacao_id; ?>, '_blank');
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
                    let url = '<?= site_url('municipio/ajax_carrega_municipios_por_territorio') ?>/?territorio_id=' + this.param_territorio_id
                    let result = await fetch(url);
                    let json = await result.json();
                    this.municipio = json;
                }
            },
            async mounted() {

                await this.ajax_carrega_produtos_com_preco_valido_territorio()
                await this.ajaxCarregaCotacao()
                await this.calcula_dotacao()
                await this.calcula_soma_valor_medio()
                if (this.controller == 'read') {

                }
            },
        })

        app.mount('#app')
    </script>

    <style>
        .verde {
            color: green
        }
    </style>
</body>

</html>

<?php include '../template/end.php'; ?>