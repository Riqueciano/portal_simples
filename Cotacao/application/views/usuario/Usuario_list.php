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
    <form action="<?php echo site_url('usuario/index'); ?>" class="form-inline" method="get">
        <h2 style="margin-top:0px">Listagem - Usuário</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="row">
                <div class="col-md-4">
                    <?php echo anchor(site_url('usuario/create'), 'Novo', 'class="btn btn-success"'); ?>
                </div>
                <div class="col-md-3 text-center">
                    <div style="margin-top: 8px" id="message">
                        <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                        ?>
                    </div>
                </div>
                <div class="col-md-1 text-right">

                </div>
                <div class="col-md-4 text-right">

                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php
                            if ($q <> '') {
                            ?>
                                <a href="<?php echo site_url('usuario'); ?>" class="btn btn-default">X</a>
                            <?php
                            }
                            ?>
                            <button class="btn btn-primary" type="submit">Procurar</button>
                        </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td style='width:10%'><b>Empresa</b></td>
                            <td><?php  echo combo('empresa_id', 'dados_unico.empresa', 'empresa_id', 'empresa_nm', 'submit()', $empresa_id,  " order by empresa_nm"); ?></td>
                        </tr>
                        <tr>
                            <td><b>Lotação</b></td>
                            <td><?php  echo combo('lotacao_id', 'dados_unico.lotacao', 'lotacao_id', 'lotacao_nm', 'submit()', $lotacao_id,  " and empresa_id = $empresa_id order by lotacao_nm"); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style='overflow-x:auto'>
            <table class="table table-striped" style="margin-bottom: 10px">
                <tr>
                    <!--th>No</th-->
                    <th align='center'>-</th>
                    <th>Login</th>
                    <th>Pessoa</th>
                    <th>Empresa</th>
                    <th>Lotação</th>
                    <th>Situação</th>


                </tr><?php
                        foreach ($usuario_data as $u) {
                        ?>
                    <tr>
                        <!--td width="80px"><?php echo ++$start ?></td-->
                        <td style="text-align:center" width="100px">
                            <?php
                            echo anchor(site_url('usuario/read/' . $u->usuario_id), ' ', "class='glyphicon glyphicon-search' title='Consultar' ");
                            echo ' | ';
                            echo anchor(site_url('usuario/update/' . $u->usuario_id), ' ', "class='glyphicon glyphicon-pencil' title='Editar' ");
                            echo ' | ';//delete � com pessoa_id (legado, sistema antigo)
                            echo anchor(site_url('usuario/delete/' . $u->pessoa_id), ' ', "class='glyphicon glyphicon-trash' title='Excluir' " . ' ' .  'onclick="javasciprt: return confirm(\'Tem certeza que deseja apagar o Registro?\')"');
                            ?>
                        </td>
                        <td><?php echo $u->usuario_login ?></td>
                        <td><?php echo empty($u->pessoa_nm) ? '-' : rupper($u->pessoa_nm) ?></td>
                        <td><?php echo empty($u->empresa_nm) ? '-' : rupper($u->empresa_nm) ?></td>
                        <td><?php echo empty($u->lotacao_nm) ? '-' : rupper($u->lotacao_nm) ?></td>
                        <td>
                            <a href='<?= site_url('Usuario/ativar_inativar/' . $u->usuario_id) ?>'>
                                <b><?php echo $u->ativo == 1 ? '[Ativo]' : '[Inativo]' ?></b>
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
    </form>
</body>

</html>
<?php include '../template/end.php'; ?>