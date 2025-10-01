<?php include '../template/begin.php'; ?> 
<html>
    <head>
        <title>SDR</title>
        <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->
        <style>
            
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Listagem - Sub-menu</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('menu_item/create'),'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('menu_item/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('menu_item'); ?>" class="btn btn-default">X</a>
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
		<th>Menu </th>
		<th> Título</th> 
		<th>Texto</th>
		<th>Link</th>
		<th> Tipo </th> 
		<!-- <th> Ativo</th>  -->

            </tr><?php
            foreach ($menu_item_data as $menu_item){
                ?>
                <tr>
			<!--td width="80px"><?php echo ++$start ?></td-->
			<td style="text-align:center" width="100px">
				 <?php 
				 echo anchor(site_url('menu_item/read/'.$menu_item->menu_item_id),' ',"class='glyphicon glyphicon-search' title='Consultar' "); 
				 echo ' | '; 
				 echo anchor(site_url('menu_item/update/'.$menu_item->menu_item_id),' ',"class='glyphicon glyphicon-pencil' title='Editar' "); 
				 echo ' | '; 
				 echo anchor(site_url('menu_item/delete/'.$menu_item->menu_item_id),' ', "class='glyphicon glyphicon-trash' title='Excluir' " .' '.  'onclick="javasciprt: return confirm(\'Tem certeza que deseja apagar o Registro?\')"'); 
				 ?>
			 </td>
			<td><?php echo $menu_item->menu_nm ?></td>
			<td><?php echo $menu_item->menu_item_titulo ?></td> 
			<td><?php echo $menu_item->menu_item_texto ?></td>
			<td><?php echo $menu_item->menu_item_link ?></td>
			<td><?php echo $menu_item->menu_item_tipo_nm ?></td> 
			<!-- <td><php echo $menu_item->menu_item_ativo ?></td>  -->
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