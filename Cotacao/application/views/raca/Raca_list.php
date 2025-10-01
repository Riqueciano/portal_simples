<?php include '../template/begin.php'; ?> 
 
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
        <h2 style="margin-top:0px">Listagem - Cotacao.raca</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('raca/create'),'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-2 text-right">
            </div>
            <div class="col-md-3 text-right">
                <!--form action="<?php echo site_url('raca/index'); ?>" class="form-inline" method="get"-->
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" v-model="q">
                        <span class="input-group-btn">
                             <button class="btn btn-default" @click='limpaFiltro()' v-show="q.length != 0">X</button>
                             <button class="btn btn-primary" type="button" @click='atualizaLista()'>Procurar</button>
                        </span>
                    </div>
                <!--/form-->
            </div>
        </div>
        <div style='overflow-x:auto'>
        <table class="table table-striped" style="margin-bottom: 10px">
            <tr>
                <!--th>No</th-->
		<th align='center'>-</th>
		<th>Raca Nm</th>
		<th>Raca Nota</th>

            </tr><tr  v-for="(i, index) in raca_data"  >            <td style="text-align:center" width="100px">
                                <a class='glyphicon glyphicon-search' title='Consultar' :href="'<?= site_url('raca/read/') ?>' + i.raca_id"></a>
                                |
                                <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('raca/update/') ?>' + i.raca_id "></a>
                                |
                                <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('raca/delete/') ?>' + i.raca_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                        </td>
			<td>{{i.raca_nm}} </td>
			<td>{{i.raca_nota}} </td>
		</tr>
              
        </table>
        </div>
        <div class="row"  v-show="q.length == 0">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Linhas: {{total_rows}}</a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
      </div>
    
<!-- <select2-component v-model="id" :options="array"></select2-component> -->
      <script type="module">
            import {
                createApp
            } from "<?=iPATH?>JavaScript/vue/vue3/vue.esm-browser.prod.js"

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
                            q: '<?=$q?>', 
                            message: '', 
                            raca_data: <?= $raca_data ?>,
                            total_rows: <?= $total_rows ?>, 
                    }
        },
        methods: { 
                dataToBR,
                dataToBRcomHora, 
                moedaBR, 
                limpaFiltro: function() { 
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    this.raca_data = [];
                    let url = '<?= site_url('raca/index') ?>?q=' + this.q + '&format=json';
                    let result = await fetch(url);
                    let json = await result.json();
                    this.raca_data = json;
                }
            }, 
        mounted() {
             
        },
    })
    
    app.mount('#app');
</script>
    </body>
      </html>
<?php include '../template/end.php'; ?>