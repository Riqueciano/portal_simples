<?php include '../template/begin_1_2018rn.php'; ?>
<html>

<head>

</head>

<body>

    <!-- ###app### -->
    <style> [v-cloak] {display: none;}</style>
    <div id='app' v-cloak></div>
    <!-- ### -->

    <template id="app-template">
        <div>
            <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Cotacao.categoria <?php // echo $button 
                                                                                                                                                    ?></h2>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class='col-md-12' name='' id=''>
                    <div class='x_panel' id=''>
                        <div class='x_content'>
                            <div style='overflow-x:auto'>
                                <table class='table'>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">Categoria Nm* <?php echo form_error('categoria_nm') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="categoria_nm" id="categoria_nm" placeholder="Categoria Nm" v-model="form.categoria_nm" required='required' maxlength='200' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'>
                                            <input type="hidden" name="categoria_id" value="<?php echo $categoria_id; ?>" />
                                            <button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>
                                            <a href="<?php echo site_url('categoria') ?>" class="btn btn-default">Voltar</a>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </template>
    <!--script type="text/x-template" id="select2-template">
        <select>
           <slot></slot>
        </select>
    </script-->


    <!--monta combobox-->
    <!--script type="text/javascript" language="javascript" src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/vue/select2/montaSelect.js"></script-->
    <script type="text/javascript" language="javascript" src="<?php echo iPATH ?>/JavaScript/vue/select2/montaSelect.js"></script>

    <script>
        new Vue({
            el: "#app",
            template: "#app-template",
            data: {
                message: '',
                button: "<?= $button ?>",
                controller: "<?= $controller ?>",
                form: {
                    categoria_nm: "<?= $categoria_nm ?>",

                },
            },
            computed: {

            },
            methods: {

            },
            mounted() {
                if (this.controller == 'read') {
                    $("input").prop("disabled", true);
                    $("select").prop("disabled", true);
                    $("textarea").prop("disabled", true);
                    $("#btnGravar").hide();
                } else if (this.controller == 'create') {
                    //tela de create
                } else if (this.controller == 'update') {
                    //tela de update 
                }
            },
        });
    </script>
</body>

</html>

<?php include '../template/end.php'; ?>