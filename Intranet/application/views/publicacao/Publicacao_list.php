<?php include '../template/begin.php';
?>
<html>

<head>
    <title>SDR</title>
    <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->
    <style>

    </style>
</head>

<body>
    <form action="<?php echo site_url('publicacao/index'); ?>" class="form-inline" method="get">
        <h2 style="margin-top:0px">intranet</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('publicacao/create'), 'Novo', 'class="btn btn-success"'); ?>
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
                            <a href="<?php echo site_url('publicacao'); ?>" class="btn btn-default">X</a>
                        <?php
                        }
                        ?>
                        <button class="btn btn-primary" type="submit">Procurar</button>
                    </span>
                </div>

            </div>
        </div>
        <div style='overflow-x:auto'>
            <b class="red">*Ordenado pela ordem de cadastro</b>
            <br>
            <b>Exibir</b>
            <br>
            <select name="ativo" id="ativo" class="form-control" style="width: 40%;" onchange="submit()">
                <option value="-1">.:Exibir todos:.</option>
                <option value="0">Inativos</option>
                <option value="1">Ativos</option>
            </select>
            <script>$('#ativo').val('<?=$ativo?>')</script>
            <table class="table table-striped" style="margin-bottom: 10px">
                <tr>
                    <!--th>No</th-->
                    <th align='center'>-</th>
                    <th>Título</th>
                    <th>Data Exibição </th>
                    <th>Carrossel</th>
                    <th>Ativo</th>

                </tr><?php
                        // var_dump($publicacao_data);
                        foreach ($publicacao_data as $publicacao) {
                        ?>
                    <tr>
                        <!--td width="80px"><?php echo ++$start ?></td-->
                        <td style="text-align:center" width="100px">
                            <?php
                            echo anchor(site_url('publicacao/exibir_externo/' . $publicacao->publicacao_id), ' ', "class='glyphicon glyphicon-search' title='Consultar' ");
                            echo ' | ';
                            echo anchor(site_url('publicacao/update/' . $publicacao->publicacao_id), ' ', "class='glyphicon glyphicon-pencil' title='Editar' ");
                            // echo ' | ';
                            // echo anchor(site_url('publicacao/delete/' . $publicacao->publicacao_id), ' ', "class='glyphicon glyphicon-trash' title='Excluir' " . ' ' .  'onclick="javasciprt: return confirm(\'Tem certeza que deseja apagar o Registro?\')"');
                            ?>
                        </td>
                        <td><?php echo $publicacao->publicacao_titulo ?></td>
                        <td><?php echo @DBToData($publicacao->publicacao_dt_publicacao) ?></td>
                        <td><?php echo $publicacao->flag_carrossel == 1 ? '<p class="green">[Sim]</p>' : '<p class="red">[Não]</p>' ?></td>
                        <td>
                            <a href='<?= site_url('publicacao/altera_status/' . $publicacao->publicacao_id) ?>'>
                                <?php echo $publicacao->ativo == 1 ? "<b style='color:green'>Ativo</b>" : "<b style='color:red'>Inativo</b>" ?>
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