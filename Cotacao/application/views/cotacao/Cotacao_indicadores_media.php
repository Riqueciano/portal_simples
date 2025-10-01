<?php

include '../template/begin.php'; ?>

<html>

<head>
    <title>SDR</title>

</head>

<body>


    <style>
        [v-cloak] {
            display: none;
        }
    </style>
    <div id='app' v-cloak>
        <h2 style="margin-top:0px">Indicadores - Media de Preços BAHIA</h2>

        <select name="territorio_id" id="territorio_id" v-model="parametro_territorio_id" class="form-control" @change="atualizaLista()">
            <option value="9999">.:Selecione:.</option>
            <option value="">BAHIA</option>
            <option v-for="(t, key) in territorios" :value="t.territorio_id">{{t.territorio_nm}}</option>
        </select>
        <table class="table" v-show="!carregando">
            <tr>
                <th style="width: 5%">-</th>
                <th>Produtos</th>
                <th>Media Bahia</th>
                <th>Preços</th>
            </tr>
            <tr v-for="(i, key) in produtos">
                <td>{{key+1}}</td>
                <td>{{i.produto_nm}}</td>
                <td align="right">
                    <div class="badge" style="font-size: 15px">{{formatMoney(i.media_bahia)}}</div>
                </td>
                <td>
                    <table class="table">
                        <tr>
                            <th>-</th>
                            <th>Produtos</th>
                            <th>Territorio</th>
                            <th>Preço</th>
                        </tr>
                        <tr v-for="(f, key) in i.fornecedores_preco">
                            <td class="texto_menor">{{key+1}}</td>
                            <td class="texto_menor">{{f.pessoa_nm}}</td>
                            <td class="texto_menor">{{f.territorio_nm?.toUpperCase()}}</td>
                            <td class="texto_menor" align="right">{{formatMoney(f.produto_preco_territorio_valor)}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div v-show="carregando">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Carregando...</span>
                <img src="<?= iPATHGif ?>Disk.gif" alt="Carregando...">
            </div>
        </div>


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
                        parametro_territorio_id: '9999',
                        produtos: <?= $produtos ?>,
                        territorios: <?= $territorio ?>,
                        carregando: false
                    };
                },
                methods: {
                    formatMoney(value, locale = 'pt-BR', currency = 'BRL') {
                        return new Intl.NumberFormat(locale, {
                            style: 'currency',
                            currency: currency,
                        }).format(value);
                    },
                    atualizaLista: async function() {
                        this.carregando = true;
                        this.produtos = [];

                        let url = '<?= site_url('cotacao/indicadores_media') ?>/?parametro_territorio_id=' + this.parametro_territorio_id + "&format=json";
                        let result = await fetch(url);
                        let json = await result.json();
                        // console.log(json);
                        this.produtos = json;
                        this.carregando = false;
                        // alert(url)
                    }
                },
                mounted() {
                    // Código que deve ser executado quando o componente for montado
                }
            });

            app.mount("#app"); // substitua "#app" pelo ID correto do seu container
        </script>

</body>

<style>
    .texto_menor {
        font-size: 8px;
    }
</style>

</html>
<?php include '../template/end.php'; ?>