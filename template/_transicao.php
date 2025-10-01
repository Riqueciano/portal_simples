<?php
    $nmServer = 'gestorsdr';
    $sistema_id = empty($_GET['sistema']) ? $_SESSION['sistema'] : $_GET['sistema'];
?>
<script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/jquery/jquery-2.1.1.js"></script>
<style>
    #load_pagina {
        width:30%;
        position:relative;
        top:100px;
        left:35%;
    }
</style>    

<img id='load_pagina' src='https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/Icones/load_circulo.gif'  >
<script>


    $(document).ready(function () {alert()
        $.ajax({
            url: "https://www.portalsema.ba.gov.br/_portal/SistemaDocumentos2/Assunto",
            type: "POST",
            dataType: "html",
            async: false,
            data: {

            },
            success: function (retorno) {
                alert()
                $('#tudo').html(retorno);
            }
        });
    });

</script>
<div id='tudo'></div>



