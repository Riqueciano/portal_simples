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
        <h2 style="margin-top:0px">Listagem - Dados_unico.banco</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('banco/create'),'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('banco/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('banco'); ?>" class="btn btn-default">X</a>
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
		<th>Banco Cd</th>
		<th>Banco Ds</th>
		<th>Banco St</th>
		<th>Banco Dt Criacao</th>
		<th>Banco Dt Alteracao</th>

            </tr><?php
            foreach ($banco_data as $banco)
            {
                ?>
                <tr>
			<!--td width="80px"><?php echo ++$start ?></td-->
			<td style="text-align:center" width="100px">
				 <?php 
				 echo anchor(site_url('banco/read/'.$banco->banco_id),' ',"class='glyphicon glyphicon-search' title='Consultar' "); 
				 echo ' | '; 
				 echo anchor(site_url('banco/update/'.$banco->banco_id),' ',"class='glyphicon glyphicon-pencil' title='Editar' "); 
				 echo ' | '; 
				 echo anchor(site_url('banco/delete/'.$banco->banco_id),' ', "class='glyphicon glyphicon-trash' title='Excluir' " .' '.  'onclick="javasciprt: return confirm(\'Tem certeza que deseja apagar o Registro?\')"'); 
				 ?>
			 </td>
			<td><?php echo $banco->banco_cd ?></td>
			<td><?php echo $banco->banco_ds ?></td>
			<td><?php echo $banco->banco_st ?></td>
			<td><?php echo $banco->banco_dt_criacao ?></td>
			<td><?php echo $banco->banco_dt_alteracao ?></td>
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