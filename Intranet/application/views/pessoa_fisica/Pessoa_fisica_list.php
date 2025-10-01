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
        <h2 style="margin-top:0px">Listagem - Dados_unico.pessoa_fisica</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('pessoa_fisica/create'),'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-2 text-right">
            </div>
            <div class="col-md-3 text-right">
                <!--form action="<?php echo site_url('pessoa_fisica/index'); ?>" class="form-inline" method="get"-->
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
		<th>Pessoa Fisica Sexo</th>
		<th>Pessoa Fisica Cpf</th>
		<th>Pessoa Fisica Dt Nasc</th>
		<th>Pessoa Fisica Rg</th>
		<th>Pessoa Fisica Rg Orgao</th>
		<th>Pessoa Fisica Rg Uf</th>
		<th>Pessoa Fisica Rg Dt</th>
		<th>Pessoa Fisica Passaporte</th>
		<th>Pessoa Fisica Nm Pai</th>
		<th>Pessoa Fisica Nm Mae</th>
		<th>Pessoa Fisica Grupo Sanguineo</th>
		<th>Pessoa Fisica Nacionalidade</th>
		<th>Pessoa Fisica Naturalidade</th>
		<th>Pessoa Fisica Naturalidade Uf</th>
		<th>Pessoa Fisica Clt</th>
		<th>Pessoa Fisica Clt Serie</th>
		<th>Pessoa Fisica Clt Uf</th>
		<th>Pessoa Fisica Titulo</th>
		<th>Pessoa Fisica Titulo Zona</th>
		<th>Pessoa Fisica Titulo Secao</th>
		<th>Pessoa Fisica Titulo Cidade</th>
		<th>Pessoa Fisica Titulo Uf</th>
		<th>Pessoa Fisica Cnh</th>
		<th>Pessoa Fisica Cnh Categoria</th>
		<th>Pessoa Fisica Cnh Validade</th>
		<th>Pessoa Fisica Reservista</th>
		<th>Pessoa Fisica Reservista Ministerio</th>
		<th>Pessoa Fisica Reservista Uf</th>
		<th>Pessoa Fisica Pis</th>
		<th>Estado Civil Id</th>
		<th>Nivel Escolar Id</th>
		<th>Pessoa Fisica Funcionario</th>
		<th>Pessoa Fisica Cnh Lente Corretiva</th>
		<th>Pessoa Fisica Filho</th>
		<th>Pessoa Fisica Filha</th>
		<th>Pessoa Apelido</th>
		<th>Pessoa Fisica Foto</th>
		<th>Pessoa Fisica St Site</th>
		<th>Pessoa Fisica Represen</th>
		<th>Pessoa Fisica Represen Desc</th>
		<th>Pessoa Fisica Ano Ingresso</th>
		<th>Area Profissional Id</th>
		<th>Pessoa Fisica Id</th>

            </tr><tr  v-for="(i, index) in pessoa_fisica_data"  >            <td style="text-align:center" width="100px">
                                <a class='glyphicon glyphicon-search' title='Consultar' :href="'<?= site_url('pessoa_fisica/read/') ?>' + i.pessoa_id"></a>
                                |
                                <a class='glyphicon glyphicon-pencil' title='Editar' :href="'<?= site_url('pessoa_fisica/update/') ?>' + i.pessoa_id "></a>
                                |
                                <a class='glyphicon glyphicon-trash' title='Excluir' :href="'<?= site_url('pessoa_fisica/delete/') ?>' + i.pessoa_id " onclick="javascript: return confirm('Tem certeza que deseja apagar o Registro?')"></a>
                        </td>
			<td>{{i.pessoa_fisica_sexo}} </td>
			<td>{{i.pessoa_fisica_cpf}} </td>
			<td>{{i.pessoa_fisica_dt_nasc}} </td>
			<td>{{i.pessoa_fisica_rg}} </td>
			<td>{{i.pessoa_fisica_rg_orgao}} </td>
			<td>{{i.pessoa_fisica_rg_uf}} </td>
			<td>{{i.pessoa_fisica_rg_dt}} </td>
			<td>{{i.pessoa_fisica_passaporte}} </td>
			<td>{{i.pessoa_fisica_nm_pai}} </td>
			<td>{{i.pessoa_fisica_nm_mae}} </td>
			<td>{{i.pessoa_fisica_grupo_sanguineo}} </td>
			<td>{{i.pessoa_fisica_nacionalidade}} </td>
			<td>{{i.pessoa_fisica_naturalidade}} </td>
			<td>{{i.pessoa_fisica_naturalidade_uf}} </td>
			<td>{{i.pessoa_fisica_clt}} </td>
			<td>{{i.pessoa_fisica_clt_serie}} </td>
			<td>{{i.pessoa_fisica_clt_uf}} </td>
			<td>{{i.pessoa_fisica_titulo}} </td>
			<td>{{i.pessoa_fisica_titulo_zona}} </td>
			<td>{{i.pessoa_fisica_titulo_secao}} </td>
			<td>{{i.pessoa_fisica_titulo_cidade}} </td>
			<td>{{i.pessoa_fisica_titulo_uf}} </td>
			<td>{{i.pessoa_fisica_cnh}} </td>
			<td>{{i.pessoa_fisica_cnh_categoria}} </td>
			<td>{{i.pessoa_fisica_cnh_validade}} </td>
			<td>{{i.pessoa_fisica_reservista}} </td>
			<td>{{i.pessoa_fisica_reservista_ministerio}} </td>
			<td>{{i.pessoa_fisica_reservista_uf}} </td>
			<td>{{i.pessoa_fisica_pis}} </td>
			<td>{{i.estado_civil_id}} </td>
			<td>{{i.nivel_escolar_id}} </td>
			<td>{{i.pessoa_fisica_funcionario}} </td>
			<td>{{i.pessoa_fisica_cnh_lente_corretiva}} </td>
			<td>{{i.pessoa_fisica_filho}} </td>
			<td>{{i.pessoa_fisica_filha}} </td>
			<td>{{i.pessoa_apelido}} </td>
			<td>{{i.pessoa_fisica_foto}} </td>
			<td>{{i.pessoa_fisica_st_site}} </td>
			<td>{{i.pessoa_fisica_represen}} </td>
			<td>{{i.pessoa_fisica_represen_desc}} </td>
			<td>{{i.pessoa_fisica_ano_ingresso}} </td>
			<td>{{i.area_profissional_id}} </td>
			<td>{{i.pessoa_fisica_id}} </td>
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
            pessoa_fisica_data: <?= $pessoa_fisica_data ?>,
            total_rows: <?= $total_rows ?>, 
        },
        methods: { 
                limpaFiltro: function() { 
                    this.q = '';
                    this.atualizaLista();
                },
                atualizaLista: async function() {
                    let url = '<?= site_url('pessoa_fisica/index') ?>?q=' + this.q + '&format=json';
                    let result = await fetch(url);
                    let json = await result.json();
                    this.pessoa_fisica_data = json;
                }
            }, 
        mounted() {
             
        },
    });
</script>
    </body>
      </html>
<?php include '../template/end.php'; ?>