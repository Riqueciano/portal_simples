<?php include '../template/begin.php';?>
<script>
    
        $( document ).ready(function() {
            //window.location.replace("<?=site_url('Painel/mapa')?>");
         });
</script>
<table style="width:100%">
   
    <tr>
        <td align='center' >
            <h2>BEM VINDO<small></small></h2>
            <!--img style="width:30%" src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Imagens/gif/loadTaaqui.gif"-->
            <!-- <a href="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/anexos/anexo_abelha/TUTORIAL_CADASTRO_MELIPONICULTOR.pptx">
                <input type="button" class="btn btn-primary" value="Iniciar">
            </a> 
            <a href="<?=site_url("proposta")?>">
                <input type="button" class="btn btn-primary" value="Iniciar">
            </a>-->
        </td>
    </tr>
    <tr>
        <td>
            <?php echo phpinfo(); ?>
        </td>
    </tr>
</table>

<?php include '../template/end.php'; ?>