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
            <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Indice.municipio <?php // echo $button 
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
                                                <label for="character varying">Municipio Nm <?php echo form_error('municipio_nm') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="municipio_nm" id="municipio_nm" placeholder="Municipio Nm" v-model="form.municipio_nm" maxlength='150' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Municipio St <?php echo form_error('municipio_st') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="municipio_st" id="municipio_st" placeholder="Municipio St" v-model="form.municipio_st" onkeypress="mascara(this, soNumeros);" maxlength='150' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Territorio Id <?php echo form_error('territorio_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="territorio" v-model='form.territorio_id' id='territorio_id' name='territorio_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character">Estado Uf <?php echo form_error('estado_uf') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="estado_uf" id="estado_uf" placeholder="Estado Uf" v-model="form.estado_uf" maxlength='2' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Flag Capital <?php echo form_error('flag_capital') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="flag_capital" id="flag_capital" placeholder="Flag Capital" v-model="form.flag_capital" onkeypress="mascara(this, soNumeros);" maxlength='2' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="double precision">Incremento <?php echo form_error('incremento') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="" class="form-control" name="incremento" id="incremento" placeholder="Incremento" v-model="form.incremento" onkeypress="mascara(this, money);" maxlength='2' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Setaf Id <?php echo form_error('setaf_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="setaf" v-model='form.setaf_id' id='setaf_id' name='setaf_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Adesao Semaf <?php echo form_error('adesao_semaf') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="adesao_semaf" id="adesao_semaf" placeholder="Adesao Semaf" v-model="form.adesao_semaf" onkeypress="mascara(this, soNumeros);" maxlength='2' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="date">Dt Adesao Semaf <?php echo form_error('dt_adesao_semaf') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="date" class="form-control" name="dt_adesao_semaf" id="dt_adesao_semaf" placeholder="Dt Adesao Semaf" v-model="form.dt_adesao_semaf" onKeyPress='return false;' onPaste='Return false' maxlength='10' maxlength='2' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Adesao Instrumento Id <?php echo form_error('adesao_instrumento_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="instrumento" v-model='form.adesao_instrumento_id' id='adesao_instrumento_id' name='adesao_instrumento_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">Adesao Instrumento Num <?php echo form_error('adesao_instrumento_num') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="adesao_instrumento_num" id="adesao_instrumento_num" placeholder="Adesao Instrumento Num" v-model="form.adesao_instrumento_num" maxlength='40' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">Cod Ibge <?php echo form_error('cod_ibge') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="cod_ibge" id="cod_ibge" placeholder="Cod Ibge" v-model="form.cod_ibge" maxlength='20' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">Cod Veri Ibge <?php echo form_error('cod_veri_ibge') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="cod_veri_ibge" id="cod_veri_ibge" placeholder="Cod Veri Ibge" v-model="form.cod_veri_ibge" maxlength='20' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Ativo <?php echo form_error('ativo') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="ativo" id="ativo" placeholder="Ativo" v-model="form.ativo" onkeypress="mascara(this, soNumeros);" maxlength='20' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Flag Litoral <?php echo form_error('flag_litoral') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="flag_litoral" id="flag_litoral" placeholder="Flag Litoral" v-model="form.flag_litoral" onkeypress="mascara(this, soNumeros);" maxlength='20' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="geom">Geom <?php echo form_error('geom') ?></label>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <textarea maxlength="9999999" class="form-control" rows="3" v-model="form.geom" name="geom" id="geom" placeholder="">{{form.geom }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'>
                                            <input type="hidden" name="municipio_id" value="<?php echo $municipio_id; ?>" />
                                            <button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>
                                            <a href="<?php echo site_url('municipio') ?>" class="btn btn-default">Voltar</a>
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
                setaf: <?= $setaf ?>,
                territorio: <?= $territorio ?>,
                instrumento: <?= $instrumento ?>,
                /*form*/
                form: {
                    municipio_nm: "<?= $municipio_nm ?>",
                    municipio_st: "<?= $municipio_st ?>",
                    territorio_id: "<?= $territorio_id ?>",
                    estado_uf: "<?= $estado_uf ?>",
                    flag_capital: "<?= $flag_capital ?>",
                    incremento: "<?= $incremento ?>",
                    setaf_id: "<?= $setaf_id ?>",
                    adesao_semaf: "<?= $adesao_semaf ?>",
                    dt_adesao_semaf: "<?= $dt_adesao_semaf ?>",
                    adesao_instrumento_id: "<?= $adesao_instrumento_id ?>",
                    adesao_instrumento_num: "<?= $adesao_instrumento_num ?>",
                    cod_ibge: "<?= $cod_ibge ?>",
                    cod_veri_ibge: "<?= $cod_veri_ibge ?>",
                    ativo: "<?= $ativo ?>",
                    flag_litoral: "<?= $flag_litoral ?>",
                    geom: "<?= $geom ?>",

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