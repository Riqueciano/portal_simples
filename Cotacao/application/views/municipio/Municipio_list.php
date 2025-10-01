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
        <h2 style="margin-top:0px">Listagem - Indice.municipio</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('municipio/create'),'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-2 text-right">
            </div>
            <div class="col-md-3 text-right">
                <!--form action="<?php echo site_url('municipio/index'); ?>" class="form-inline" method="get"-->
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
		<th>Municipio Nm</th>
		<th>Municipio St</th>
		<th>Territorio Id</th>
		<th>Estado Uf</th>
		<th>Flag Capital</th>
		<th>Incremento</th>
		<th>Setaf Id</th>
		<th>Adesao Semaf</th>
		<th>Dt Adesao Semaf</th>
		<th>Adesao Instrumento Id</th>
		<th>Adesao Instrumento Num</th>
		<th>Cod Ibge</th>
		<th>Cod Veri Ibge</th>
		<th>Ativo</th>
		<th>Flag Litoral</th>
		<th>Geom</th>

            </tr><tr  v-for="(i, index) in municipio_data"  >            <td style="text-align:center" width="100px">
                                <a class='glyphicon glyphicon-search' title='Consultar' :href="'<?= site_url('municipio/read/') ?>' + i.municipio_id"></a>
                                |
                                <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('municipio/update/') ?>' + i.municipio_id "></a>
                                |
                                <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('municipio/delete/') ?>' + i.municipio_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                        </td>
			<td>{{i.municipio_nm}} </td>
			<td>{{i.municipio_st}} </td>
			<td>{{i.territorio_id}} </td>
			<td>{{i.estado_uf}} </td>
			<td>{{i.flag_capital}} </td>
			<td>{{i.incremento}} </td>
			<td>{{i.setaf_id}} </td>
			<td>{{i.adesao_semaf}} </td>
			<td>{{i.dt_adesao_semaf}} </td>
			<td>{{i.adesao_instrumento_id}} </td>
			<td>{{i.adesao_instrumento_num}} </td>
			<td>{{i.cod_ibge}} </td>
			<td>{{i.cod_veri_ibge}} </td>
			<td>{{i.ativo}} </td>
			<td>{{i.flag_litoral}} </td>
			<td>{{i.geom}} </td>
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
            municipio_data: <?= $municipio_data ?>,
            total_rows: <?= $total_rows ?>, 
        },
        methods: { 
                limpaFiltro: function() { 
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    let url = '<?= site_url('municipio/index') ?>?q=' + this.q + '&format=json';
                    let result = await fetch(url);
                    let json = await result.json();
                    this.municipio_data = json;
                }
            }, 
        mounted() {
             
        },
    });
</script>
    </body>
      </html>
<?php include '../template/end.php'; ?>