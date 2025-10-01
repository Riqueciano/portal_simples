<?php
header('Content-type: text/html; charset=ISO-8859-1');
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
                window.location.href = "<?= site_url('tipo_usuario_acao/create/?sistema_id=' . (int)$filtro_sistema_id) ?>";
            }
        }

        function limpa_e_submit(){
            $('#tipo_usuario_id').val('');
            $('#secao_id').val('');
            $('#form').submit();
        }
    </script>
</head>

<body>
    <form id='form' action="<?php echo site_url('tipo_usuario_acao/index'); ?>" class="form-inline" method="get">
        <h2 style="margin-top:0px">Listagem - Sub-menu(Ação) x perfil</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">

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



            </div>
        </div>
        <div class="row">
            <div class="col-md-4 text-center">
                <table class="table" style="width:60%">
                    <tbody>
                        <tr>
                            <td>
                                <b>Sistema</b>
                            </td>
                            <td colspan="3">
                                <?php echo combo('filtro_sistema_id', 'seguranca.sistema', 'sistema_id', 'sistema_nm', 'limpa_e_submit()', $filtro_sistema_id, " and sistema_st=0 order by sistema_nm"); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Perfil</b>
                            </td>
                            <td colspan="3">
                                <?php echo combo('tipo_usuario_id', 'seguranca.tipo_usuario', 'tipo_usuario_id', 'tipo_usuario_ds', 'submit()', $tipo_usuario_id, " and sistema_id = $filtro_sistema_id  order by tipo_usuario_ds"); ?>
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
                                <a href="<?= site_url('tipo_usuario_acao') ?>" class='btn btn-default'>Limpar</a>
                            </td>
                            <td>
                                <?php // echo anchor(site_url('tipo_usuario_acao/create'), 'Novo', 'class="btn btn-success"'); 
                                ?>
                                <!-- <a href='<?= site_url("tipo_usuario_acao/create/?sistema_id=" . $filtro_sistema_id) ?>'> -->
                                <input type="button" value="Novo" class="btn btn-success" onclick='novo();'>
                                <!-- </a> -->
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
                    <th>Sub-menu (Acao)</th>
                    <th>Menu (secao)</th>
                    <th>Sistema</th>
                    <th>Perfil (tipo usuario)</th> 


                </tr><?php
                        foreach ($tipo_usuario_acao_data as $tipo_usuario_acao) {
                        ?>
                    <tr>
                        <!--td width="80px"><?php echo ++$start ?></td-->
                        <td style="text-align:center" width="100px">
                            <?php
                            echo anchor(site_url('tipo_usuario_acao/read/' . $tipo_usuario_acao->tipo_usuario_acao_id), ' ', "class='glyphicon glyphicon-search' title='Consultar' ");
                            echo ' | ';
                            echo anchor(site_url('tipo_usuario_acao/update/' . $tipo_usuario_acao->tipo_usuario_acao_id), ' ', "class='glyphicon glyphicon-pencil' title='Editar' ");
                            echo ' | ';
                            echo anchor(site_url('tipo_usuario_acao/delete/' . $tipo_usuario_acao->tipo_usuario_acao_id), ' ', "class='glyphicon glyphicon-trash' title='Excluir' " . ' ' .  'onclick="javasciprt: return confirm(\'Tem certeza que deseja apagar o Registro?\')"');
                            ?>
                        </td>
                        <td><?php echo $tipo_usuario_acao->acao_ds ?></td>
                        <td><?php echo $tipo_usuario_acao->secao_ds ?></td>
                        <td><?php echo $tipo_usuario_acao->sistema_nm ?></td>
                        <td><?php echo $tipo_usuario_acao->tipo_usuario_ds ?></td> 

                    </tr>
                <?php
                        }
                ?>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Linhas: <?php echo count($tipo_usuario_acao_data)  ?></a>
            </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </form>
</body>

</html>
<?php include '../template/end.php'; ?>