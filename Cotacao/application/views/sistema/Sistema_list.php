<?php 
header ('Content-type: text/html; charset=ISO-8859-1'); 
include '../template/begin_1_2018rn.php'; 
?>

<html>
    <head>
        <title>SDR</title>
        <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->
        <style>
            
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Listagem - Sistema</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('sistema/create'),'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('sistema/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('sistema'); ?>" class="btn btn-default">X</a>
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
		<th>Sistema </th>
		<th>Descrição</th>
		<th>Icone(png)</th>
		<!-- <th>Icone(bootstrap)</th> -->
		<th>Status</th>
		<th>Criacao</th>
		<th>Alteracao</th>
		<th>Sistema Url</th>
		<th>Status</th>
		<!-- <th>Controller Principal</th> -->

            </tr><?php
            foreach ($sistema_data as $sistema)
            {
                ?>
                <tr>
			<!--td width="80px"><?php echo ++$start ?></td-->
			<td style="text-align:center" width="100px">
				 <?php 
				 echo anchor(site_url('sistema/read/'.$sistema->sistema_id),' ',"class='glyphicon glyphicon-search' title='Consultar' "); 
				 echo ' | '; 
				 echo anchor(site_url('sistema/update/'.$sistema->sistema_id),' ',"class='glyphicon glyphicon-pencil' title='Editar' "); 
				 echo ' | '; 
				 echo anchor(site_url('sistema/delete/'.$sistema->sistema_id),' ', "class='glyphicon glyphicon-trash' title='Excluir' " .' '.  'onclick="javasciprt: return confirm(\'Tem certeza que deseja apagar o Registro?\')"'); 
				 ?>
			 </td>
			<td><?php echo $sistema->sistema_nm ?></td>
			<td><?php echo $sistema->sistema_ds ?></td>
			<td><?php echo $sistema->sistema_icone ?></td>
			<!-- <td><?php echo $sistema->bootstrap_icon ?></td> -->
			<td><?php echo $sistema->sistema_st ?></td>
			<td><?php echo empty($sistema->sistema_dt_criacao)?'-':DBToData($sistema->sistema_dt_criacao) ?></td>
			<td><?php echo $sistema->sistema_dt_alteracao ?></td>
			<td><?php echo $sistema->sistema_url ?></td>
			<td>
                <a href='<?=site_url('sistema/ativar_inativar/'.$sistema->sistema_id)?>'>
                    <b><?php echo $sistema->sistema_st==0 ?'[Ativo]':'[Inativo]' ?></b>
                </a>
            </td>
			
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