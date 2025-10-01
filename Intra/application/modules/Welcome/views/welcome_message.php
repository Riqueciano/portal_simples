<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

    $(document).ready(function () {
        // Redireciona o usu�rio para a p�gina da DevMedia ap�s cinco segundos
        setTimeout(function () {
            window.location.href = "<?=site_url('intranet')?>";
        },1000);
    });
</script>

<p style="text-align: justify;">

    <br> 
</p>
<br>
<table style="width:100%">
    <tr>
        <td align='center' >
            <h2> Carregando</h2>
            <img style="width:30%" src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Imagens/gif/loadTaaqui.gif">
        </td>
    </tr>
</table>

