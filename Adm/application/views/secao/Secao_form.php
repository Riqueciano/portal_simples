<?php 
header ('Content-type: text/html; charset=ISO-8859-1'); 
include '../template/begin_1_2018rn.php'; 
?>
<html>
    <head>
        <script type="text/javascript">
            $(document).ready(function () {
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
        </script>
    </head>
    <body>
        <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Menu (secao) <?php // echo $button  ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                    <div class='x_content'>
                        <div style='overflow-x:auto'>
                            <table class='table'>	
                                <tr> 
                                    <td style='width:15%'>   
                                        <div class="form-group">
                                            <label for="smallint">Sistema* <?php echo form_error('sistema_id') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group"> 
                                            <?php echo comboSimples('sistema_id_correto', 'seguranca.sistema', 'sistema_id', 'sistema_nm', '', $sistema_id_correto, " order by sistema_nm"); ?>
                                        </div> 
                                    </td>
                                </tr>	
                                <tr>
                                    <td>   
                                        <div class="form-group">
                                            <label for="character varying">Secao Ds* <?php echo form_error('secao_ds') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="text" class="form-control" name="secao_ds" id="secao_ds"  placeholder="Secao Ds"  value="<?php echo $secao_ds; ?>" required='required'   maxlength = '50' />
                                        </div> 
                                    </td>
                                </tr>	
                                <tr> 
                                    <td>   
                                        <div class="form-group">
                                            <label for="numeric">Secao St <?php echo form_error('secao_st') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="number" class="form-control" name="secao_st" id="secao_st"  placeholder="Secao St"  value="<?php echo $secao_st; ?>"   onkeypress="mascara(this, soNumeros);"   maxlength = '50' />
                                        </div> 
                                    </td>
                                </tr>	
                                <tr> 
                                    <td>   
                                        <div class="form-group">
                                            <label for="smallint">Secao Indice <?php echo form_error('secao_indice') ?></label>
                                        </div>
                                    </td>
                                    <td>  
                                        <div class="item form-group">
                                            <input type="text" class="form-control" name="secao_indice" id="secao_indice"  placeholder="Secao Indice"  value="<?php echo $secao_indice; ?>"    maxlength = '50' />
                                        </div> 
                                    </td>
                                </tr>	
                                <tr> 
                                    <td>
                                        <label for="class_icon_bootstrap">Class Icon Bootstrap <?php echo form_error('class_icon_bootstrap') ?></label>
                                    </td>                    
                                    <td>  
                                        <div class="form-group">
                                            
                                            <a href="https://getbootstrap.com/docs/3.3/components/" class="btn btn-warning btn-sm" target="_blank">Icones</a>
                                            <br>
                                            <textarea class="form-control" rows="3" name="class_icon_bootstrap" id="class_icon_bootstrap"   placeholder="Class Icon Bootstrap"  ><?php echo $class_icon_bootstrap; ?></textarea>
                                        </div>
                                    </td>
                                </tr> 
                                <tr> 
                                    <td colspan='2'>
                                        <input type="hidden" name="secao_id" value="<?php echo $secao_id; ?>" /> 
                                        <button id="btnGravar" type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                                        <a href="<?php echo site_url('secao') ?>" class="btn btn-default">Voltar</a>
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