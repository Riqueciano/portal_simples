<?php include '../template/begin_1_2018rn_externo.php'; ?>

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
    <div id='app' v-cloak>
        <div class="x_panel">
            <h2 style="margin-top:0px">Inscrição Realizada com Sucesso!</h2>
            <!-- {{responsavel_email.toUpperCase()}} -->
            <br>
            <div class="alert alert-success" role="alert">
                <h2 style="font-size:15px">Dados para acessar o sistema, foram enviados para <b>{{responsavel_email.toUpperCase()}}</b></h2>

            </div>
        </div>

    </div>

    <script type="module">
        import {
            createApp
        } from "<?= iPATH ?>JavaScript/vue/vue3/vue.esm-browser.prod.js"
        import * as func from "<?= iPATH ?>JavaScript/func.js"

        const app = createApp({
            data() {
                return {
                    responsavel_email: '<?= $responsavel_email ?>',
                }
            },
            methods: {},
            mounted() {

            },
        })

        app.mount('#app');
    </script>
</body>

</html>
<?php include '../template/end.php'; ?>