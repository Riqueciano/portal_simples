<?php include '../template/begin.php'; ?> 


<script>
    $( document ).ready(function() {
        alert('Prezado(a) sr(a) <?=rupper($_SESSION['pessoa_nm'])?>\n\nIdentificamos que seu cadastro est� incompleto, para continuar publicando obras no ACERVO DIGITAL SDR � necessario antes concluir o cadastro.')
        if('<?=$this->session->userdata('message')?>' != ''){
            $('#mensagem_cadastro').show();
        }
    });
    

    function submeter() {
        var pessoa_nm = $('#pessoa_nm').val();
        var instituicao_id = $('#instituicao_id').val();
        var usuario_login = $('#usuario_login').val();
        var pessoa_email = $('#pessoa_email').val();
        var pessoa_email_conf = $('#pessoa_email_conf').val();


        if (pessoa_nm == '') {
            alert('Nome do Autor em branco');
            $('#pessoa_nm').focus();
            return false;
        }
        if (instituicao_id == '') {
            alert('Institui��o em branco');
            $('#instituicao_id').focus();
            return false;
        }
        if (usuario_login == '') {
            alert('CPF em branco');
            $('#usuario_login').focus();
            return false;
        }
        if (pessoa_email == '') {
            alert('E-mail em branco');
            $('#pessoa_email').focus();
            return false;
        }
        if (pessoa_email == '') {
            alert('E-mail em branco');
            $('#pessoa_email').focus();
            return false;
        }
        if (pessoa_email != pessoa_email_conf) {
            alert('E-mail de confirma��o diferente do e-mail informado');
            $('#pessoa_email_conf').val(''); 
            $('#pessoa_email_conf').focus();
            return false;
        }

        $('#form').submit()
    }
</script>
<div class="alert alert-success" role="alert" id="mensagem_cadastro" style="display: none">
  <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
</div>


<h2>Cadastro Autor</h2> 
 
<form id="form" method="post" action="<?= $action ?>">
    <table class="table">        
        <tr>
            <td style="width:15%">Nome do Autor*</td>
            <td><input type="text" class="form-control" id='pessoa_nm' name='pessoa_nm' value="<?= $pessoa_nm ?>"></td> 
        </tr>
        <tr>
            <td>Institui��o*</td>
            <!--td><?php echo combo('instituicao_id', 'acervo.instituicao', 'instituicao_id', 'instituicao_nm', '', $instituicao_id, ""); ?></td--> 
            <td><input type="text" class="form-control"  id='instituicao_nm' name='instituicao_nm' value="<?= $instituicao_nm ?>"></td> 
        </tr>
        <tr>
            <td>CPF*</td>
            <td><input type="text" class="form-control"  id='cpf' name='cpf' value="<?= $cpf ?>" onkeypress="mascara(this, cpfM);" maxlength="15" style='width:30%'></td> 
        </tr>
        <tr>
            <td>E-mail*</td>
            <td><?= $pessoa_email ?></td> 
        </tr>
    </table>
    <input type="button" value="Gravar" class="btn btn-primary" onclick="submeter()">
</form>
<?php include '../template/end.php'; ?> 
