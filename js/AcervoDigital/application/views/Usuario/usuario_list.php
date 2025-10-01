<?php include '../template/begin.php'; ?>


<h2>Autores</h2>
<a class="btn btn-success" href="<?=site_url('usuario/create')?>">Novo</a>
<table class="table">
    <tr>
        <th>Autor</th>
        <th>Usuario</th>
        <th>Ativo</th>
    </tr>
    <?php
     foreach ($vi_login as $l) {?>
    <tr>
        <td><?=$l->pessoa_nm?></td>
        <td><?=$l->usuario_login?></td>
        <td>
            <?php
            switch ($l->pessoa_st) {
                case 0:
                    $color='green';
                    break;
                case 1:
                    $color='red';
                    break;
                default:
                    $color='red';
                    break;
            }
            ?>
             <a style='color:<?=$color?>' href='<?=site_url('Pessoa/muda_status/?pessoa_id='.$l->pessoa_id."&pessoa_st=".$l->pessoa_st)?>'><?php echo $l->pessoa_st==0?'Ativo':'Inativo' ?></a>
        </td>
    </tr>
    <?php }     ?>
</table>
<?php include '../template/end.php';?> 
