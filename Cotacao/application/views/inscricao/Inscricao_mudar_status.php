<?php include '../template/begin.php'; ?>
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
            var inscricao_status_id = $('#inscricao_status_id').val(); 
            var inscricao_historico_ds = $('#inscricao_historico_ds').val(); 

            if(inscricao_status_id == ''){
                alert('Favor informar o novo status');
                $('#inscricao_status_id').focus();
                return false; 
            }

            if(inscricao_historico_ds == ''){
                alert('Favor a descrição da ação');
                $('#inscricao_historico_ds').focus();
                return false; 
            }

            $('#form').submit();

        }
    </script>
</head>

<body>
    <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i></span> Mudança de Status <?php // echo $button    
                                                                                                                                    ?></h2>

    <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class='col-md-12' name='' id=''>
            <div class='x_panel' id=''>
                <div class='x_content'>
                    <div style='overflow-x:auto'>
                        <h2>Mudar Status</h2>
                        <table class='table'>

                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="character varying">Status* <?php echo form_error('celular_num') ?></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <?php 
                                        $param = "and inscricao_status_id not in(1, 2, 7)";
                                        echo comboSimples('inscricao_status_id', 'sigater_proposta.inscricao_status', 'inscricao_status_id', 'inscricao_status_nm', '', $inscricao_status_id, " $param "); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Descrição*</td>
                                <td>
                                    <textarea name="inscricao_historico_ds" id="inscricao_historico_ds" class="form-control" maxlength="800"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <table class="table">
                <tr>
                    <th style="width: 60%">Ação</th>
                    <th>Responsável</th>
                    <th>Data</th>
                </tr>
                        <?php foreach ($inscricao_historico as $key => $ih) {?>
                            <tr>
                                <td><?=$ih->inscricao_historico_ds?></td>
                                <td><?=$ih->pessoa_nm?></td>
                                <td><?=dbToDataHora($ih->dt_historico)?></td>
                            </tr>
                            
                        <?php } ?>
                   
            </table>
            <div class='x_panel' id=''>
                <div class='x_content'>
                    <div style='overflow-x:auto'>
                        <table class='table'>
                            <tr>
                                <td colspan='2'>
                                    <input type="hidden" name="inscricao_id" value="<?php echo $inscricao_id; ?>" />
                                    <button id="btnGravar" type="button" onclick="submeter()" class="btn btn-primary">Gravar</button>
                                    <a href="<?php echo site_url('inscricao') ?>" class="btn btn-default">Voltar</a>

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