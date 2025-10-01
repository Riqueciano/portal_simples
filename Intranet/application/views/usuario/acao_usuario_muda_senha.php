<?php include '../template/_begin_login_2025.php'; ?>
<style>
    .btn-microsoft {
        background-color: rgba(28, 76, 172, 0.22);
        border: 1px solid rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(5px);
        padding: 10px 16px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        height: 48px;
    }

    .btn-microsoft:hover {
        background-color: rgba(28, 76, 172, 0.42);
    }
</style>

<body>
    <div class="login-box">
        <h2 style="color: white;">Portal SDR</h2>
        <h2 style="color: white; font-size: 20px;">Atualizar Senha</h2>
        <form id="form" method="post" action="<?= $action ?>">

            <div class="form-group mb-3">
                <b style="color: white; font-size: 16px"><?php echo empty($mensagem) ? '' : $mensagem ?></b>
            </div>
            <div class="form-group mb-3">
                <input type="text" class="custom-input" placeholder="Senha Atual" required id="senha_atual" name="senha_atual" />
            </div>
            <div class="form-group mb-3">
                <input type="text" class="custom-input" placeholder="Nova Senha" required id="nova_senha" name="nova_senha" />
            </div>

            <input type="button" class="btn btn-vermelho" value="Renovar senha" onclick="submeter()">


            <input type="button" class="btn btn-outline-success mt-2" value="Voltar ao Portal SDR" onclick="voltar_portal()">

             
                <button class="btn btn-microsoft"
                    onclick="abrirOutlook()">
                    <img src="https://www.portalsema.ba.gov.br/_portal/Icones/intranet/ICONE-OUTLOOK.png"
                        alt="Microsoft"
                        style="width: 62px; height: 62px;">
                    <span style="color: #000; font-weight: 400; font-size: 16px; line-height: 62px;">Redefinir senha do e-mail Outlook </span>
                </button>
             

            <div class="footer-text">
                <strong style="color: white;">SDR - Secretaria de Desenvolvimento Rural</strong><br>
                <a href="https://www.portalsema.ba.gov.br/" target="_blank" class="text-decoration-none" style="color: white; padding: 10px;">
                    <img src="<?= iPATH ?>Icones/folha2.png" alt="" style="width: 20px; height: 20px; cursor: pointer;"> www.portalsdr.ba.gov.br
                </a>
            </div>

        </form>
    </div>
</body>




<script>


    function abrirOutlook() {
        window.open("https://portaldefacilidades.ba.gov.br/#/senha/redefinir", "_blank");
    }

    $(document).ready(function() {
        if ('<?= $erro ?>' == '2') {
            $('#senha_atual').hide();
            $('#nova_senha').hide();
            $('#btn_renovar').hide();
        }
    });



    function submeter() {
        if ($('#senha_atual').val() == '') {
            alert('Favor informar sua senha tual');
            $('#senha_atual').focus();
            return false;
        }
        if ($('#nova_senha').val() == '') {
            alert('Favor informar suanova senha ');
            $('#senha_atual').focus();
            return false;
        }




        $('#form').submit();
    }

    function voltar_portal() {
        window.open("<?= iPATH ?>", "_self");
    }
</script>