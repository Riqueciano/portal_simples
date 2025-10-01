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
    <style> [v-cloak] {display: none;}</style>
    <div id='app' v-cloak>
        <div v-show="flag_carregando==true">
            <img src="<?= iPATHGif ?>/lego.gif" alt="" style="width: 30%; border-radius: 30px">
        </div>
        <div v-show="flag_carregando==false">
            <h2 style="margin-top:0px">Secretaria de Desenvolvimento Rural</h2>
            <h5 style="margin-top:0px"><i class="glyphicon glyphicon-user"></i><b class="green">{{titulo}}</b></h5>

            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                    <?php //echo anchor(site_url('funcionario/create'), 'Novo', 'class="btn btn-success"'); 
                    ?>
                </div>
                <div class="col-md-1 text-center">
                    <div style="margin-top: 8px" id="message">
                        <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <b>Lotação</b>
                    <select name="est_organizacional_id" id="est_organizacional_id" v-model="est_organizacional_id" @change='atualizaLista()' class="form-control">
                        <option value="">.:Selecione:.</option>
                        <option :value="e.id" v-for="(e, ekey) in est_organizacional">{{e.text.toUpperCase()}}</option>
                    </select>
                </div>
                <div class="col-md-3 text-right">-
                    <!--form action="<?php echo site_url('funcionario/index'); ?>" class="form-inline" method="get"-->
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" v-model="q" placeholder="nome, lotação..">
                        <span class="input-group-btn">
                            <button class="btn btn-default" @click='limpaFiltro()' v-show="q.length != 0" style="color: red;"><b>X</b></button>
                            <button class="btn btn-primary" type="button" @click='atualizaLista()'>Procurar</button>
                        </span>
                    </div>
                    <!--/form-->
                </div>
            </div>
            <div style='overflow-x:auto'>
                <table class="table table-striped" style="margin-bottom: 10px">
                    <tr>
                        <th>Colaborador</th>
                        <th>Lotação</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <!-- <th>Tipo</th> -->
                        <th>-</th>
                    </tr>
                    <tr v-for="(i, index) in funcionario_data">
                        <td> <b>{{i.pessoa_nm?.toUpperCase()}}</b> </td>
                        <td>
                            <b style="cursor: pointer" @click="filtrar_por_lotacao(i.est_organizacional_id)">
                                <i class="glyphicon glyphicon-zoom-in"></i>

                                <span class="badge badge-secondary">{{i.est_organizacional_sigla?.toUpperCase()}}</span>
                            </b>

                        </td>
                        <td>{{i.telefone?.toUpperCase()}} </td>
                        <td>{{i.funcionario_email?.toUpperCase()}} </td>
                        <!-- <td>
                           <b v-if="i.funcionario_tipo_id==10">Colaborador Eventual SEM VINCULO</b>
                           <b v-else>CARGO</b> 
                           
                         </td> -->
                        <td>{{i.pessoa_st==0?'Ativo':'Inativo'}} </td>
                    </tr>
                </table>
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
                    est_organizacional_id: '',
                    flag_carregando: false,
                    q: '<?= $q ?>',
                    message: '',
                    funcionario_data: <?= $funcionario_data ?>,
                    est_organizacional: <?= $est_organizacional ?>,
                    total_rows: <?= $total_rows ?>,
                    titulo: '<?= $titulo ?>',
                }
            },
            methods: {
                dataToBR,
                dataToBRcomHora,
                limpaFiltro: function() {
                    this.q = '';
                    this.est_organizacional_id = null;
                    this.atualizaLista();
                },
                sleep: function(ms) {
                    return new Promise(resolve => setTimeout(resolve, ms));
                },
                filtrar_por_lotacao: async function(est_organizacional_id) {
                    this.est_organizacional_id = est_organizacional_id
                    this.q = ''
                    await this.atualizaLista()

                },
                atualizaLista: async function() {

                    //se tiver digitado, limpa o filtro
                    // alert(this.q)
                    if(this.q){
                        this.est_organizacional_id = ''
                    }

                    this.q = this.q?.toUpperCase()

                    this.flag_carregando = true;
                    let url = '<?= site_url('funcionario/') . $controller ?>?q=' + this.q + '&format=json&est_organizacional_id=' + this.est_organizacional_id;
                    // alert(url)
                    // try {

                    let result = await fetch(url);
                    let json = await result.json();
                    this.funcionario_data = json;
                    this.flag_carregando = false;
                    await sleep(1000);


                    // } catch (error) {
                    //     alert('Algo deu errado, tente nomente');
                    //     window.location.reload(true);
                    // }

                }
            },
            watch: {
                // est_organizacional_id(novo, antigo){
                //     alert('executou')
                // }
            },
            mounted() {

            },

        })

        app.mount('#app');
    </script>
</body>

</html>
<?php include '../template/end.php'; ?>