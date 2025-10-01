<?php 
header ('Content-type: text/html; charset=ISO-8859-1'); 
include '../template/begin_1_2018rn.php'; 
?>
<html>

<head>
    <script type="text/javascript">
        $(document).ready(function() {
            if ('<?= $controller ?>' == 'read') {
                $("input").prop("disabled", true);
                $("select").prop("disabled", true);
                $("textarea").prop("disabled", true);
                $("#btnGravar").hide();
            } else if ('<?= $controller ?>' == 'create') {
                //tela de create
            } else if ('<?= $controller ?>' == 'update') {
                //tela de update
            }
        });

        function submeter(){
            if($('#sistema_nm').val()==''){
                alert('Favor informar o nome do sistema');
                $('#sistema_nm').focus();
                return false;
            }
            if($('#sistema_icone').val()==''){
                alert('Favor informar o icone do sistema');
                $('#sistema_icone').focus();
                return false;
            }
            if($('#sistema_url').val()==''){
                alert('Favor informar o URL do sistema');
                $('#sistema_url').focus();
                return false;
            }
            if($('#controller_principal').val()==''){
                alert('Favor informar o Controller principal do sistema');
                $('#controller_principal').focus();
                return false;
            }
            // if($('#bootstrap_icon').val()==''){
            //     alert('Favor informar o icone bootstrap  do sistema');
            //     $('#bootstrap_icon').focus();
            //     return false;
            // }
            $('#form').submit(); return
        }
    </script>
</head>

<body>
    <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Sistemas <?php // echo $button 
                                                                                                                                    ?></h2>
    <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class='col-md-12' name='' id=''>
            <div class='x_panel' id=''>
                <div class='x_content'>
                    <div style='overflow-x:auto'>

                        <table class='table'>
                            <tr>

                                <td style='width:10%;'>
                                    <div class="form-group">
                                        <label for="character varying">Sistema* <?php echo form_error('sistema_nm') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="text" class="form-control" name="sistema_nm" id="sistema_nm" placeholder="Sistema Nm" value="<?php echo $sistema_nm; ?>" required='required' maxlength='50' />
                                    </div>
                                </td>

                            </tr>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="character varying">Descrição <?php echo form_error('sistema_ds') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="text" class="form-control" name="sistema_ds" id="sistema_ds" placeholder="Sistema Ds" value="<?php echo $sistema_ds; ?>" maxlength='255' />
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="character varying">Icone (png) <?php echo form_error('sistema_icone') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group"> 
                                        <div class='col-md-11' name='' id=''>
                                            <input style='width:40%' type="text" class="form-control" name="sistema_icone" id="sistema_icone" placeholder="" value="<?php echo $sistema_icone; ?>" maxlength='50' />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="character varying">Icone (bootstrap) <?php echo form_error('sistema_icone') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <div class='col-md-1' name='' id=''>
                                            <a href="https://getbootstrap.com/docs/3.3/components/" target="_blank">
                                                <input type="button" value="Ver classes" class="btn btn-danger">
                                            </a>
                                        </div>
                                        <div class='col-md-11' name='' id=''>
                                            <input style='width:40%' type="text" class="form-control" name="bootstrap_icon" id="bootstrap_icon" placeholder="glyphicon glyphicon-user" value="<?php //echo $bootstrap_icon; ?>" maxlength='50' />
                                        </div>
                                    </div>
                                </td>
                            </tr> -->
                            <!-- <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="numeric">Sistema St <?php echo form_error('sistema_st') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="number" class="form-control" name="sistema_st" id="sistema_st" placeholder="Sistema St" value="<?php echo $sistema_st; ?>" onkeypress="mascara(this, soNumeros);" maxlength='50' />
                                    </div>
                                </td>
                            </tr> -->
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="character varying">Sistema Url (pasta onde esta o sistema) <?php echo form_error('sistema_url') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="text" class="form-control" name="sistema_url" id="sistema_url" placeholder="Sistema Url" value="<?php echo $sistema_url; ?>" maxlength='100' />
                                    </div>
                                </td>
                            </tr>
                            <!-- <tr>

                                <td>
                                    <div class="form-group">
                                        <label for="character varying">Controller Principal </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <input type="text" class="form-control" name="controller_principal" id="controller_principal" placeholder="" value="<?php echo $controller_principal; ?>" maxlength='300' />
                                    </div>
                                </td>
                            </tr> -->
                            <tr>
                                <td colspan='2'>
                                    <input type="hidden" name="sistema_id" value="<?php echo $sistema_id_correto; ?>" />
                                    <button id="btnGravar" type="button" class="btn btn-primary" onclick="submeter()"><?php echo $button ?></button>
                                    <a href="<?php echo site_url('sistema') ?>" class="btn btn-default">Voltar</a>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>

<?php include '../template/end.php'; ?>