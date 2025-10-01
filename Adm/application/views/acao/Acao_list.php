<?php
include '../template/begin_1_2018rn.php';
?>
<html>

<head>
    <title>SDR</title>
    <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->
    <script>
        function novo() {
            // alert()
            if ('<?= (int)$filtro_sistema_id ?>' == '0') {
                alert('Selecione o sistema');
                $('#filtro_sistema_id').focus();
                return false;
            } else {
                window.location.href = "<?= site_url('acao/create/?sistema_id=' . (int)$filtro_sistema_id) ?>";
            }
        }
    </script>
</head>

<body>
    <form action="<?php echo site_url('acao/index'); ?>" class="form-inline" method="get">
        <h2 style="margin-top:0px">Listagem - Menu (acao)</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-8">
                <?php //echo anchor(site_url('acao/create'), 'Novo', 'class="btn btn-success"'); ?>
            </div>
            <div class="col-md-4 text-right">

                <!-- <div class="input-group">
                    <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                    <span class="input-group-btn">
                        <?php
                        if ($q <> '') {
                        ?>
                            <a href="<?php echo site_url('acao'); ?>" class="btn btn-default">X</a>
                        <?php
                        }
                        ?>
                        <button class="btn btn-primary" type="submit">Procurar</button>
                    </span>
                </div> -->

            </div>
        </div>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4 text-center">
                <table class="table" style="width:60%">
                    <tbody>
                        <tr>
                            <td>
                                <b>Sistema</b>
                            </td>
                            <td colspan="2">
                                <?php echo utf8_encode(combo('filtro_sistema_id', 'seguranca.sistema', 'sistema_id', 'sistema_nm', 'submit()', $filtro_sistema_id, " and sistema_st=0 order by sistema_nm")); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Menu</b>
                            </td>
                            <td>
                                <?php echo combo('secao_id', 'seguranca.secao', 'secao_id', 'secao_ds', 'submit()', $secao_id, " and sistema_id = $filtro_sistema_id order by secao_id"); ?>
                            </td>
                            <td>
                                <a href="<?= site_url('acao') ?>" class='btn btn-default'>Limpar</a>
                            </td>
                            <td>
                                <!-- <a href="<?= site_url('acao/create') ?>" class='btn btn-success'>Novo</a> -->
                                <input type="button" value="Novo" class="btn btn-success" onclick='novo();'>
                            </td>
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
                    <th>Sistema </th>
                    <th>Menu(Secao) </th>
                    <th>Sub-menu (Acao)</th>
                    <th>Acao Url</th>
                    <th>Situacao</th>
                    <th>Acao Indice (ordem)</th>

                </tr><?php
                        foreach ($acao_data as $acao) {
                        ?>
                    <tr>
                        <!--td width="80px"><?php echo ++$start ?></td-->
                        <td style="text-align:center" width="100px">
                            <?php
                            echo anchor(site_url('acao/read/' . $acao->acao_id), ' ', "class='glyphicon glyphicon-search' title='Consultar' ");
                            echo ' | ';
                            echo anchor(site_url('acao/update/' . $acao->acao_id), ' ', "class='glyphicon glyphicon-pencil' title='Editar' ");
                            echo ' | ';
                            echo anchor(site_url('acao/delete/' . $acao->acao_id), ' ', "class='glyphicon glyphicon-trash' title='Excluir' " . ' ' .  'onclick="javasciprt: return confirm(\'Tem certeza que deseja apagar o Registro?\')"');
                            ?>
                        </td>
                        <td><?php echo  (rupper($acao->sistema_nm)) ?></td>
                        <td><?php echo  ($acao->secao_ds) ?></td>
                        <td><?php echo  ($acao->acao_ds) ?></td>
                        <td><?php echo  ($acao->acao_url) ?></td>
                        <td>
                            <a href='<?= site_url('Acao/muda_status/' . $acao->acao_id) ?>'>
                                <b><?php echo $acao->acao_st == 0 ? '<b class="green">Ativo</b>' : '<b  class="red">Inativo</b>' ?></b>
                            </a>
                        </td>
                        <td><?php echo $acao->acao_indice ?></td>
                    </tr>
                <?php
                        }
                ?>
            </table>
        </div>
        <!-- <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Linhas: <?php echo $total_rows ?></a>
            </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div> -->
    </form>
</body>

</html>
<?php include '../template/_end.php'; ?>