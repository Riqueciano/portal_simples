<?php include '../template/_begin_login_2025.php'; ?> 

<body>
    <div class="login-box">
        <h2 style="color: white;">Portal SDR</h2>
        <form id="form" method="post" action="<?= $action ?>">
            <?php if (!empty($msg_erro)) { ?>
                <div class="alert alert-danger text-center" role="alert">
                    <strong><?= $msg_erro ?></strong>
                </div>
            <?php } ?>
            <b style="color: white"><?=empty($mensagem)?'':$mensagem?></b>
            <div class="form-group mb-3"> 
                <input type="text" class="custom-input" placeholder="Informe seu usuario" required id="usuario_login" name="usuario_login"  /> 
            </div> 

            <input type="button" class="btn btn-vermelho" value="Renovar senha" onclick="submeter()"> 


            <input type="button" class="btn btn-outline-success mt-2" value="Voltar ao Portal SDR" onclick="voltar_portal()">

            <div class="footer-text">
                <strong style="color: #004080;">SDR - Secretaria de Desenvolvimento Rural</strong><br>
                <a href="https://www.portalsema.ba.gov.br/" target="_blank" class="text-decoration-none">
                    <i class="glyphicon glyphicon-leaf" style="font-size: 18px;"></i> www.portalsdr.ba.gov.br
                </a>
            </div>

        </form>
    </div>
</body>

 
<script>
    
    $( document ).ready(function() {
        if('<?=$erro?>' == '2'){
            $('#usuario_login').hide();
            $('#btn_renovar').hide();
        }
    });
    
    function submeter() {
        if ($('#usuario_login').val() == '') {
            alert('Login em branco');
            $('#usuario_login').focus();
            return false;
        }
        
        
       
 
        $('#form').submit();
    }

    function voltar_portal() {
        window.open("<?= iPATH ?>", "_self");
    }
</script>
 