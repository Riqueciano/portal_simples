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
        <h2 style="margin-top:0px">Listagem - Dados_unico.pessoa</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('pessoa/create'),'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-2 text-right">
            </div>
            <div class="col-md-3 text-right">
                <!--form action="<?php echo site_url('pessoa/index'); ?>" class="form-inline" method="get"-->
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
		<th>Pessoa Nm</th>
		<th>Pessoa Tipo</th>
		<th>Pessoa Email</th>
		<th>Pessoa St</th>
		<th>Pessoa Dt Criacao</th>
		<th>Pessoa Dt Alteracao</th>
		<th>Pessoa Usuario Criador</th>
		<th>Setaf Id</th>
		<th>Ater Contrato Id</th>
		<th>Lote Id</th>
		<th>Flag Usuario Acervo Digital</th>
		<th>Cpf Autor</th>
		<th>Instituicao Autor</th>
		<th>Semaf Municipio Id</th>
		<th>Ppa Municipio Id</th>
		<th>Empresa Id</th>
		<th>Flag Cadastro Externo</th>
		<th>Menipolicultor Territorio Id</th>
		<th>Sipaf Municipio Id</th>
		<th>Prefeito Municipio Id</th>
		<th>Cartorio Municipio Id</th>
		<th>Proposta Dupla Numero</th>

            </tr><tr  v-for="(i, index) in pessoa_data"  >            <td style="text-align:center" width="100px">
                                <a class='glyphicon glyphicon-search' title='Consultar' :href="'<?= site_url('pessoa/read/') ?>' + i.pessoa_id"></a>
                                |
                                <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('pessoa/update/') ?>' + i.pessoa_id "></a>
                                |
                                <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('pessoa/delete/') ?>' + i.pessoa_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                        </td>
			<td>{{i.pessoa_nm}} </td>
			<td>{{i.pessoa_tipo}} </td>
			<td>{{i.pessoa_email}} </td>
			<td>{{i.pessoa_st}} </td>
			<td>{{i.pessoa_dt_criacao}} </td>
			<td>{{i.pessoa_dt_alteracao}} </td>
			<td>{{i.pessoa_usuario_criador}} </td>
			<td>{{i.setaf_id}} </td>
			<td>{{i.ater_contrato_id}} </td>
			<td>{{i.lote_id}} </td>
			<td>{{i.flag_usuario_acervo_digital}} </td>
			<td>{{i.cpf_autor}} </td>
			<td>{{i.instituicao_autor}} </td>
			<td>{{i.semaf_municipio_id}} </td>
			<td>{{i.ppa_municipio_id}} </td>
			<td>{{i.empresa_id}} </td>
			<td>{{i.flag_cadastro_externo}} </td>
			<td>{{i.menipolicultor_territorio_id}} </td>
			<td>{{i.sipaf_municipio_id}} </td>
			<td>{{i.prefeito_municipio_id}} </td>
			<td>{{i.cartorio_municipio_id}} </td>
			<td>{{i.proposta_dupla_numero}} </td>
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
            pessoa_data: <?= $pessoa_data ?>,
            total_rows: <?= $total_rows ?>, 
        },
        methods: { 
                limpaFiltro: function() { 
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    let url = '<?= site_url('pessoa/index') ?>?q=' + this.q + '&format=json';
                    let result = await fetch(url);
                    let json = await result.json();
                    this.pessoa_data = json;
                }
            }, 
        mounted() {
             
        },
    });
</script>
    </body>
      </html>
<?php include '../template/end.php'; ?>