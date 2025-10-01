<?php 
include '../template/begin.php'; ?> 
<html>
    <head>
        <title>SDR</title>
        <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->
        <style>
            
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Listagem - Public.vi_login</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('vi_login/create'),'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('vi_login/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('vi_login'); ?>" class="btn btn-default">X</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Procurar</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div style='overflow-x:auto'>
        <table class="table table-striped" style="margin-bottom: 10px">
            <tr>
                <!--th>No</th-->
		<th align='center'>-</th>
		<th>Sistema Nm</th>
		<th>Tipo Usuario Id</th>
		<th>Tipo Usuario Ds</th>
		<th>Pessoa Id</th>
		<th>Pessoa Nm</th>
		<th>Funcionario Email</th>
		<th>Setaf Id</th>
		<th>Setaf Nm</th>
		<th>Usuario Login</th>
		<th>Usuario Senha</th>

            </tr>
                <?php
            foreach ($vi_login_data as $vi_login)
            {
                ?>
                <tr>
			<!--td width="80px"><?php echo ++$start ?></td-->
			<td style="text-align:center" width="100px">
				 <?php 
				 echo anchor(site_url('vi_login/read/'.$vi_login->sistema_id),' ',"class='glyphicon glyphicon-search' title='Consultar' "); 
				 echo ' | '; 
				 echo anchor(site_url('vi_login/update/'.$vi_login->sistema_id),' ',"class='glyphicon glyphicon-pencil' title='Editar' "); 
				 echo ' | '; 
				 echo anchor(site_url('vi_login/delete/'.$vi_login->sistema_id),' ', "class='glyphicon glyphicon-trash' title='Excluir' " .' '.  'onclick="javasciprt: return confirm(\'Tem certeza que deseja apagar o Registro?\')"'); 
				 ?>
			 </td>
			<td><?php echo $vi_login->sistema_nm ?></td>
			<td><?php echo $vi_login->tipo_usuario_id ?></td>
			<td><?php echo $vi_login->tipo_usuario_ds ?></td>
			<td><?php echo $vi_login->pessoa_id ?></td>
			<td><?php echo $vi_login->pessoa_nm ?></td>
			<td><?php echo $vi_login->funcionario_email ?></td>
			<td><?php echo $vi_login->setaf_id ?></td>
			<td><?php echo $vi_login->setaf_nm ?></td>
			<td><?php echo $vi_login->usuario_login ?></td>
			<td><?php echo $vi_login->usuario_senha ?></td>
		</tr>
                <?php
            }
            ?>
        </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Linhas: <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </body>
</html>
<?php include '../template/end.php'; ?>