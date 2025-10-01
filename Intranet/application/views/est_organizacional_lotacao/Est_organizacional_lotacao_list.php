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
    <div id='app' v-cloak></div>
      <!--###app###-->
      <template id='app-template'>
      <div>
        <h2 style="margin-top:0px">Listagem - Dados_unico.est_organizacional_lotacao</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('est_organizacional_lotacao/create'),'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-2 text-right">
            </div>
            <div class="col-md-3 text-right">
                <!--form action="<?php echo site_url('est_organizacional_lotacao/index'); ?>" class="form-inline" method="get"-->
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
		<th>Est Organizacional Lotacao Sup Cd</th>
		<th>Est Organizacional Lotacao Ds</th>
		<th>Est Organizacional Lotacao Sigla</th>
		<th>Est Organizacional Lotacao St</th>
		<th>Est Organizacional Lotacao Dt Criacao</th>
		<th>Est Organizacional Lotacao Dt Alteracao</th>

            </tr><tr  v-for="(i, index) in est_organizacional_lotacao_data"  >            <td style="text-align:center" width="100px">
                                <a class='glyphicon glyphicon-search' title='Consultar' :href="'<?= site_url('est_organizacional_lotacao/read/') ?>' + i.est_organizacional_lotacao_id"></a>
                                |
                                <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('est_organizacional_lotacao/update/') ?>' + i.est_organizacional_lotacao_id "></a>
                                |
                                <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('est_organizacional_lotacao/delete/') ?>' + i.est_organizacional_lotacao_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                        </td>
			<td>{{i.est_organizacional_lotacao_sup_cd}} </td>
			<td>{{i.est_organizacional_lotacao_ds}} </td>
			<td>{{i.est_organizacional_lotacao_sigla}} </td>
			<td>{{i.est_organizacional_lotacao_st}} </td>
			<td>{{i.est_organizacional_lotacao_dt_criacao}} </td>
			<td>{{i.est_organizacional_lotacao_dt_alteracao}} </td>
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
      </template>
    
    <script>
    new Vue({
        el: "#app",
        template: "#app-template",
        data: {
            q: '<?=$q?>', 
            message: '', 
            est_organizacional_lotacao_data: <?= $est_organizacional_lotacao_data ?>,
            total_rows: <?= $total_rows ?>, 
        },
        methods: { 
                limpaFiltro: function() { 
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    let url = '<?= site_url('est_organizacional_lotacao/index') ?>?q=' + this.q + '&format=json';
                    let result = await fetch(url);
                    let json = await result.json();
                    this.est_organizacional_lotacao_data = json;
                }
            }, 
        mounted() {
             
        },
    });
</script>
    </body>
      </html>
<?php include '../template/end.php'; ?>