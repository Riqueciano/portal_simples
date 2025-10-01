<?php
header('Content-type: text/html; charset=ISO-8859-1');
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
    <form action="<?php echo site_url('secao/index'); ?>" class="form-inline" method="get">
        <h2 style="margin-top:0px">Listagem - Menu (secao)</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('secao/create'), 'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-4">

            </div>

            <div class="col-md-4 text-right">

            </div>
        </div>
        <div class="row">
            <table class="table" style='width: 40%'>
                <tbody>
                    <tr>
                        <td>
                            <b>Sistema</b>
                        </td>
                        <td>
                            <?php echo combo('sistema_id_filtro', 'seguranca.sistema', 'sistema_id', 'sistema_nm', 'submit()', $sistema_id_filtro, " and sistema_st =0 order by sistema_nm"); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style='overflow-x:auto'>
            <table class="table table-striped" style="margin-bottom: 10px">
                <tr>
                    <!--th>No</th-->
                    <th align='center'>-</th>
                    <th>Sistema </th>
                    <th>Descrição</th>
                    <th>Secao St</th>
                    <th>Indice (ordem)</th>
                    <th>Class Icon Bootstrap</th>

                </tr><?php
                        foreach ($secao_data as $secao) {
                        ?>
                    <tr>
                        <!--td width="80px"><?php echo ++$start ?></td-->
                        <td style="text-align:center" width="100px">
                            <?php
                            echo anchor(site_url('secao/read/' . $secao->secao_id), ' ', "class='glyphicon glyphicon-search' title='Consultar' ");
                            echo ' | ';
                            echo anchor(site_url('secao/update/' . $secao->secao_id), ' ', "class='glyphicon glyphicon-pencil' title='Editar' ");
                            echo ' | ';
                            echo anchor(site_url('secao/delete/' . $secao->secao_id), ' ', "class='glyphicon glyphicon-trash' title='Excluir' " . ' ' .  'onclick="javasciprt: return confirm(\'Tem certeza que deseja apagar o Registro?\')"');
                            ?>
                        </td>
                        <td><?php echo $secao->sistema_nm ?></td>
                        <td><?php echo $secao->secao_ds ?></td>
                        <td><?php echo $secao->secao_st ?></td>
                        <td><?php echo $secao->secao_indice ?></td>
                        <td><?php echo $secao->class_icon_bootstrap ?></td>
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