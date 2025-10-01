<?php
include '../template/begin_1_2018rn.php';
?>
<html>

<head>
    <title>SDR</title>
    <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->
    <script>
        function ajaxAlteraStatus(pessoa_id) {
            $.ajax({
                url: "<?= site_url('/pessoa/ajaxAlteraStatus') ?>/",
                type: "post",
                dataType: "html",
                async: false,
                data: {
                    pessoa_id: pessoa_id,
                },
                success: function(retorno) {
                    alert('Alterado')

                    $('#status_nm_' + pessoa_id).html(retorno);
                }
            });
        }
    </script>
</head>

<body>
    <form id='form' action="<?php echo site_url('tipo_usuario/index'); ?>" class="form-inline" method="get">
        <h2 style="margin-top:0px">Listagem - Perfil Usuário</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('tipo_usuario/create'), 'Novo', 'class="btn btn-success"'); ?>
                <a href="<?php echo site_url('tipo_usuario'); ?>" class="btn btn-default">Limpar</a>
            </div>
            <div class="col-md-8 text-right">

                <!-- <div class="input-group">
                    <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                    <span class="input-group-btn">
                        <?php
                        if ($q <> '') {
                        ?>
                            <a href="<?php echo site_url('tipo_usuario'); ?>" class="btn btn-default">X</a>
                        <?php
                        }
                        ?>
                        <button class="btn btn-primary" type="submit">Procurar</button>
                    </span>
                </div> -->
                
            </div>
            <div class="col-md-12">
                <table class="table" style="width:60%">
                    <tbody>
                        <tr>
                            <td>
                                <b>Sistema</b>
                            </td>
                            <td colspan="3">
                                <?php echo combo('filtro_sistema_id', 'seguranca.sistema', 'sistema_id', 'sistema_nm', 'submit()', $filtro_sistema_id, " and sistema_st=0 order by sistema_nm"); ?>
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
                    <th>Perfil</th>
                    <!-- <th>Tipo Usuario St</th> -->
                    <!-- <th>Sistema</th> -->
                    <th>Usuários Ativos</th>

                </tr><?php
                        foreach ($tipo_usuario_data as $tipo_usuario) {
                        ?>
                    <tr>
                        <!--td width="80px"><?php echo ++$start ?></td-->
                        <td style="text-align:center" width="50px">
                            <?php
                            echo anchor(site_url('tipo_usuario/read/' . $tipo_usuario->tipo_usuario_id), ' ', "class='glyphicon glyphicon-search' title='Consultar' ");
                            echo '<br><br>';
                            echo anchor(site_url('tipo_usuario/update/' . $tipo_usuario->tipo_usuario_id), ' ', "class='glyphicon glyphicon-pencil' title='Editar' ");
                            echo '<br><br>';
                            echo anchor(site_url('tipo_usuario/delete/' . $tipo_usuario->tipo_usuario_id), ' ', "class='glyphicon glyphicon-trash' title='Excluir' " . ' ' .  'onclick="javasciprt: return confirm(\'Tem certeza que deseja apagar o Registro?\')"');
                            ?>
                        </td>
                        <td>

                            <span class="badge badge-primary"><?php echo $tipo_usuario->tipo_usuario_ds ?></span>
                        </td>
                        <!-- <td><?php echo $tipo_usuario->tipo_usuario_st ?></td> -->
                        <!-- <td><?php echo $tipo_usuario->sistema_nm  ?></td> -->
                        <td>
                            <?php //echo "Total: ".count($tipo_usuario->usuarios);
                            if (count($tipo_usuario->usuarios) > 0) {
                                $ativos = 0;
                                $inativos = 0;
                                foreach ($tipo_usuario->usuarios as $key => $u) {
                                    if ($u->pessoa_st == 0) {
                                        $ativos++;
                                    } else {
                                        $inativos++;
                                    }
                                }
                                echo "Ativos: " . $ativos . " | Inativos: " . $inativos;
                            ?>
                                <table class="table">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Login</th>
                                        <th>Lotação</th>
                                        <th>E-mail</th>
                                        <th>Telefone</th>
                                        <th>Status</th>
                                    </tr>
                                    <?php

                                    foreach ($tipo_usuario->usuarios as $key => $u) {
                                        $class = '';
                                        if ($u->pessoa_st == 1) {
                                            $class = 'inativos';
                                        }
                                        echo "<tr class='$class'>";
                                        echo "<td style='width:50%'>"; ?>

                                        <?= $u->pessoa_id ?>
                                        <br>
                                        <a href="https://<?=$_SERVER['HTTP_HOST']?>/_portal/CadastroServidorSDR/usuario_tipo_usuario/?pessoa_id=<?= $u->pessoa_id ?>">
                                            Perfil
                                        </a>
                                        <br>
                                        <a href="https://<?=$_SERVER['HTTP_HOST']?>/_portal/CadastroServidorSDR/pessoa/update/<?= $u->pessoa_id ?>">
                                            Editar
                                        </a>

                                    <?php
                                        echo "</td>";
                                        echo "<td style='width:50%'>$u->pessoa_nm</td>";
                                        echo "<td style='width:20px'>$u->usuario_login</td>";
                                        echo "<td  style=''>$u->est_organizacional_sigla</td>";
                                        echo "<td  style=''>$u->funcionario_email</td>";
                                        echo "<td  style='width:10px'>$u->telefone</td>";
                                        echo "<td  style='width:10px'>
                                                    <p style='cursor: pointer' onclick='ajaxAlteraStatus($u->pessoa_id)'>     
                                                    " . ($u->pessoa_st == 0 ? '<span class="green" id="status_nm_' . $u->pessoa_id . '">[ATIVO]</span>' : '<span class="red" id="status_nm_' . $u->pessoa_id . '">[INATIVO]</span>') . "
                                                    </p>
                                              </td>";
                                        echo "</tr>";
                                    } ?>
                                </table>
                            <?php
                            }
                            ?>

                        </td>
                    </tr>
                <?php
                        }
                ?>
            </table>

            <?php

            if (count($tipo_usuario_data) == 0) {
                echo "favor escolher um sistema para o filtro, consulta demorada";
            }
            ?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Linhas: <?php echo count($tipo_usuario_data) ?></a>
            </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </form>
    <style>
        .inativos {
            background-color: #ededed;
        }
    </style>
</body>

</html>
<?php include '../template/end.php'; ?>