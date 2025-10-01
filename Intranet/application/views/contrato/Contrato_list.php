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
        <h2 style="margin-top:0px">Listagem - Dados_unico.contrato</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('contrato/create'),'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-2 text-right">
            </div>
            <div class="col-md-3 text-right">
                <!--form action="<?php echo site_url('contrato/index'); ?>" class="form-inline" method="get"-->
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
		<th>Pessoa Id</th>
		<th>Contrato Num</th>
		<th>Contrato Ds</th>
		<th>Contrato Dt Inicio</th>
		<th>Contrato Dt Termino</th>
		<th>Contrato Valor</th>
		<th>Contrato St</th>
		<th>Contrato Dt Criacao</th>
		<th>Contrato Dt Alteracao</th>
		<th>Contrato Num Max</th>
		<th>Contrato Tipo Id</th>

            </tr><tr  v-for="(i, index) in contrato_data"  >            <td style="text-align:center" width="100px">
                                <a class='glyphicon glyphicon-search' title='Consultar' :href="'<?= site_url('contrato/read/') ?>' + i.contrato_id"></a>
                                |
                                <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('contrato/update/') ?>' + i.contrato_id "></a>
                                |
                                <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('contrato/delete/') ?>' + i.contrato_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                        </td>
			<td>{{i.pessoa_id}} </td>
			<td>{{i.contrato_num}} </td>
			<td>{{i.contrato_ds}} </td>
			<td>{{i.contrato_dt_inicio}} </td>
			<td>{{i.contrato_dt_termino}} </td>
			<td>{{i.contrato_valor}} </td>
			<td>{{i.contrato_st}} </td>
			<td>{{i.contrato_dt_criacao}} </td>
			<td>{{i.contrato_dt_alteracao}} </td>
			<td>{{i.contrato_num_max}} </td>
			<td>{{i.contrato_tipo_id}} </td>
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
            contrato_data: <?= $contrato_data ?>,
            total_rows: <?= $total_rows ?>, 
        },
        methods: { 
                limpaFiltro: function() { 
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    let url = '<?= site_url('contrato/index') ?>?q=' + this.q + '&format=json';
                    let result = await fetch(url);
                    let json = await result.json();
                    this.contrato_data = json;
                }
            }, 
        mounted() {
             
        },
    });
</script>
    </body>
      </html>
<?php include '../template/end.php'; ?>