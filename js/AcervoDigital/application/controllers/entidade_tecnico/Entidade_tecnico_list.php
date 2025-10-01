<?php include '../template/begin.php'; ?> 
<html>
    <head>
        <title>SDR</title>
        <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->
        <style>
            
        </style>
    </head>
    <body>
        <form action="<?php echo site_url('entidade_tecnico/index'); ?>" class="form-inline" method="get">
        <h2 style="margin-top:0px">Listagem - Técnico do Contrato</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('entidade_tecnico/create'),'Novo', 'class="btn btn-success"'); ?>
                <br>Contrato:<?php echo combo('lote_id', 'sigater_indireta.lote', 'lote_id', 'contrato_num', 'submit()', $lote_id, " and contrato_num is not null"); ?>
            </div>
            <div class="col-md-3 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-4 text-right">
                
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('entidade_tecnico'); ?>" class="btn btn-default">X</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Procurar</button>
                        </span>
                    </div>
                
            </div>
        </div>
        <div style='overflow-x:auto'>
        <table class="table table-striped" style="margin-bottom: 10px">
            <tr>
                <!--th>No</th-->
		<th align='center'>-</th>
		<th>Técnico</th>
		<th>Contrato</th>
		<th>Instituição</th>
		<th>CPF/Login</th>
		<th>E-MAIL</th>
                <th>Status</th>
            </tr><?php
            foreach ($entidade_tecnico_data as $entidade_tecnico)
            {
                ?>
                <tr>
			<!--td width="80px"><?php echo ++$start ?></td-->
			<td style="text-align:center" width="100px">
                            <?php 
                            echo anchor(site_url('entidade_tecnico/read/'.$entidade_tecnico->entidade_tecnico_id),' ',"class='glyphicon glyphicon-search' title='Consultar' "); 
                            echo ' | '; 
                            echo anchor(site_url('entidade_tecnico/update/'.$entidade_tecnico->entidade_tecnico_id),' ',"class='glyphicon glyphicon-pencil' title='Editar' "); 
                           
                            //echo anchor(site_url('entidade_tecnico/inativa/'.$entidade_tecnico->entidade_tecnico_id),' ', "class='glyphicon glyphicon-remove-sign' title='Inativar' " .' '.  'onclick="javasciprt: return confirm(\'Tem certeza que deseja INATIVAR o Registro?\')"'); 
                            ?>
			</td>
                        <td><?php echo rupper($entidade_tecnico->pessoa_nm) ?></td>
                        <td><?php echo rupper($entidade_tecnico->contrato_num) ?></td>
			<td><?php echo $entidade_tecnico->entidade_nm ?></td>
			<td><?php echo $entidade_tecnico->tecnico_cpf ?></td>
			<td><?php echo $entidade_tecnico->tecnico_email ?></td>
                        <td><?php
                        if((int)$entidade_tecnico->flag_ativo == 0){
                            $ativo_ds = '[Inativo]';
                            $cor      = 'red';
                        }else{
                            $ativo_ds = '[Ativo]';
                            $cor      = 'green';
                        }
                        echo "   <a href='".site_url('entidade_tecnico/inativa/'.$entidade_tecnico->entidade_tecnico_id)."/?flag_ativo=$entidade_tecnico->flag_ativo'>
                                        $ativo_ds 
                                 </a>"
                                ?></td>
                        
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
        </form>
    </body>
</html>
<?php include '../template/end.php'; ?>