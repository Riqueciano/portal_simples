<?php
include '../template/begin_1_2018rn.php'; ?>
<html>



<body>

    <!-- ###app### -->
    <style> [v-cloak] {display: none;}</style>
    <div id='app' v-cloak></div>
    <!-- ### -->

    <template id="app-template">
        <div>
            <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> produto <?php  ?></h2>
            <form id='form' action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class='col-md-12' name='' id=''>
                    <div class='x_panel' id=''>
                        <div class='x_content'>
                            <div style='overflow-x:auto'>
                                <table class='table'>
                                    <tr>
                                        <td style="width: 10%">
                                            <div class="form-group">
                                                <label for="character varying">Produto* <?php echo form_error('produto_nm') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <b class="RED">*Em caso de produtos Orgânicos coloque no final do nome do produto " - ORGÂNICO"</b>
                                            <div class="item form-group">
                                                <input type="text" class="form-control" name="produto_nm" id="produto_nm" placeholder="Produto Nm" v-model="form.produto_nm" required='required' maxlength='300' />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="produto_ds">Descrição <?php echo form_error('produto_ds') ?></label>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <textarea maxlength="800" class="form-control" rows="3" v-model="form.produto_ds" name="produto_ds" id="produto_ds" placeholder="">{{form.produto_ds }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="display: none">
                                        <td>
                                            <div class="form-group">
                                                <label for="integer" CLASS='red'>Tipo VAI SER APAGARDO<?php echo form_error('produto_tipo_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                continue alimentando o tipo, ate a alteração ser feita
                                                <select2 :options="produto_tipo" v-model='form.produto_tipo_id' id='produto_tipo_id' name='produto_tipo_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Categoria <?php echo form_error('produto_tipo_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <!-- {{categoria}}
                                                ---
                                                {{form.categoria_id}} -->
                                                <!-- <select2 :options="categoria" v-model='form.categoria_id' id='categoria_id' name='categoria_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2> -->
                                                <select v-model='form.categoria_id' id='categoria_id' name='categoria_id' class="form-control" require="require">
                                                    <option value="">.:Selecione:.</option>
                                                    <option v-for="(i, key) in categoria" :value="i.id">{{i.text}}</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-show='false'>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">Quantidade * <br>

                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="red"> ex1: Produto duzia de ovos, o valor informado deve ser 1 <br>
                                                ex2: Produto "Polpa 5kg", valor informado deve ser 5</small>
                                            <div class="item form-group"> <input type="number" class="form-control" name="produto_qtd" id="produto_qtd" v-model="form.produto_qtd" required='required' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">unidade de medida <?php echo form_error('produto_tipo_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="unidade_medida" v-model='form.unidade_medida_id' id='unidade_medida_id' name='unidade_medida_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Status * <?php echo form_error('status_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="status" v-model='form.status_id' id='status_id' name='status_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Orgânico?* <?php echo form_error('status_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <select name="flag_organico" id="flag_organico" v-model="form.flag_organico" class="form-control" style="width: 20%;">
                                                <option value="0">Não</option>
                                                <option value="1">SIm</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'>
                                            <input type="hidden" name="produto_id" value="<?php echo $produto_id; ?>" />
                                            <button id="btnGravar" type="button" class="btn btn-primary" @click="submeter()">{{button}}</button>
                                            <a href="<?php echo site_url('produto') ?>" class="btn btn-default">Voltar</a>
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
                /*tag select*/
                produto_tipo: <?= $produto_tipo ?>,
                unidade_medida: <?= $unidade_medida ?>,
                status: <?= $status ?>,
                categoria: <?= $categoria ?>,
                /*form*/
                form: {
                    produto_nm: "<?= $produto_nm ?>",
                    produto_ds: "<?= $produto_ds ?>",
                    produto_tipo_id: "<?= $produto_tipo_id ?>",
                    categoria_id: "<?= $categoria_id ?>",
                    status_id: "<?= $status_id ?>",
                    flag_organico: "<?= $flag_organico ?>",
                    unidade_medida_id: "<?= $unidade_medida_id ?>",
                    produto_qtd: "<?= empty($produto_qtd) ? 1 : $produto_qtd ?>",

                },
            },
            computed: {

            },
            methods: {
                submeter: function() {
                    if (!this.form.produto_nm) {
                        alert('Campo em branco');
                        return false
                    }
                    if (!this.form.produto_ds) {
                        alert('Campo em branco');
                        return false
                    }
                    if (!this.form.categoria_id) {
                        alert('Campo em branco');
                        return false
                    }
                    if (!this.form.produto_qtd) {
                        alert('Campo em branco');
                        return false
                    }
                    if (!this.form.unidade_medida_id) {
                        alert('Campo em branco');
                        return false
                    }
                    if (!this.form.status_id) {
                        alert('Campo em branco');
                        return false
                    }
                    $('#form').submit()
                }
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