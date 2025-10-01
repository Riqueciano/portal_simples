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
            <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Dados_unico.pessoa <?php // echo $button 
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
                                                <label for="character varying">Pessoa Nm <?php echo form_error('pessoa_nm') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="pessoa_nm" id="pessoa_nm" placeholder="Pessoa Nm" v-model="form.pessoa_nm" maxlength='200' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character">Pessoa Tipo* <?php echo form_error('pessoa_tipo') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="pessoa_tipo" id="pessoa_tipo" placeholder="Pessoa Tipo" v-model="form.pessoa_tipo" required='required' maxlength='1' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">Pessoa Email <?php echo form_error('pessoa_email') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="pessoa_email" id="pessoa_email" placeholder="Pessoa Email" v-model="form.pessoa_email" maxlength='200' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="numeric">Pessoa St <?php echo form_error('pessoa_st') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="pessoa_st" id="pessoa_st" placeholder="Pessoa St" v-model="form.pessoa_st" onkeypress="mascara(this, soNumeros);" maxlength='200' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="date">Pessoa Dt Criacao <?php echo form_error('pessoa_dt_criacao') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="date" class="form-control" name="pessoa_dt_criacao" id="pessoa_dt_criacao" placeholder="Pessoa Dt Criacao" v-model="form.pessoa_dt_criacao" onKeyPress='return false;' onPaste='Return false' maxlength='10' maxlength='200' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="date">Pessoa Dt Alteracao <?php echo form_error('pessoa_dt_alteracao') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="date" class="form-control" name="pessoa_dt_alteracao" id="pessoa_dt_alteracao" placeholder="Pessoa Dt Alteracao" v-model="form.pessoa_dt_alteracao" onKeyPress='return false;' onPaste='Return false' maxlength='10' maxlength='200' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Pessoa Usuario Criador* <?php echo form_error('pessoa_usuario_criador') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="pessoa_usuario_criador" id="pessoa_usuario_criador" placeholder="Pessoa Usuario Criador" v-model="form.pessoa_usuario_criador" required='required' onkeypress="mascara(this, soNumeros);" maxlength='200' /> </div>
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
                                                <label for="integer">Ater Contrato Id <?php echo form_error('ater_contrato_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="ater_contrato_id" id="ater_contrato_id" placeholder="Ater Contrato Id" v-model="form.ater_contrato_id" onkeypress="mascara(this, soNumeros);" maxlength='200' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Lote Id <?php echo form_error('lote_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="lote" v-model='form.lote_id' id='lote_id' name='lote_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Flag Usuario Acervo Digital <?php echo form_error('flag_usuario_acervo_digital') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="flag_usuario_acervo_digital" id="flag_usuario_acervo_digital" placeholder="Flag Usuario Acervo Digital" v-model="form.flag_usuario_acervo_digital" onkeypress="mascara(this, soNumeros);" maxlength='200' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">Cpf Autor <?php echo form_error('cpf_autor') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="cpf_autor" id="cpf_autor" placeholder="Cpf Autor" v-model="form.cpf_autor" maxlength='100' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="character varying">Instituicao Autor <?php echo form_error('instituicao_autor') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="text" class="form-control" name="instituicao_autor" id="instituicao_autor" placeholder="Instituicao Autor" v-model="form.instituicao_autor" maxlength='100' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Semaf Municipio Id <?php echo form_error('semaf_municipio_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="municipio" v-model='form.semaf_municipio_id' id='semaf_municipio_id' name='semaf_municipio_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Ppa Municipio Id <?php echo form_error('ppa_municipio_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="municipio" v-model='form.ppa_municipio_id' id='ppa_municipio_id' name='ppa_municipio_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Empresa Id <?php echo form_error('empresa_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="empresa" v-model='form.empresa_id' id='empresa_id' name='empresa_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Flag Cadastro Externo <?php echo form_error('flag_cadastro_externo') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="flag_cadastro_externo" id="flag_cadastro_externo" placeholder="Flag Cadastro Externo" v-model="form.flag_cadastro_externo" onkeypress="mascara(this, soNumeros);" maxlength='100' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Menipolicultor Territorio Id <?php echo form_error('menipolicultor_territorio_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="territorio" v-model='form.menipolicultor_territorio_id' id='menipolicultor_territorio_id' name='menipolicultor_territorio_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Sipaf Municipio Id <?php echo form_error('sipaf_municipio_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="sipaf_municipio_id" id="sipaf_municipio_id" placeholder="Sipaf Municipio Id" v-model="form.sipaf_municipio_id" onkeypress="mascara(this, soNumeros);" maxlength='100' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Prefeito Municipio Id <?php echo form_error('prefeito_municipio_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="municipio" v-model='form.prefeito_municipio_id' id='prefeito_municipio_id' name='prefeito_municipio_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Cartorio Municipio Id <?php echo form_error('cartorio_municipio_id') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group">
                                                <select2 :options="municipio" v-model='form.cartorio_municipio_id' id='cartorio_municipio_id' name='cartorio_municipio_id'>
                                                    <option disabled value=''>.:Selecione:.</option>
                                                </select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="integer">Proposta Dupla Numero <?php echo form_error('proposta_dupla_numero') ?></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item form-group"> <input type="number" class="form-control" name="proposta_dupla_numero" id="proposta_dupla_numero" placeholder="Proposta Dupla Numero" v-model="form.proposta_dupla_numero" onkeypress="mascara(this, soNumeros);" maxlength='100' /> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'>
                                            <input type="hidden" name="pessoa_id" value="<?php echo $pessoa_id; ?>" />
                                            <button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>
                                            <a href="<?php echo site_url('pessoa') ?>" class="btn btn-default">Voltar</a>
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
                municipio: <?= $municipio ?>,
                municipio: <?= $municipio ?>,
                municipio: <?= $municipio ?>,
                municipio: <?= $municipio ?>,
                territorio: <?= $territorio ?>,
                empresa: <?= $empresa ?>,
                lote: <?= $lote ?>,
                /*form*/
                form: {
                    pessoa_nm: "<?= $pessoa_nm ?>",
                    pessoa_tipo: "<?= $pessoa_tipo ?>",
                    pessoa_email: "<?= $pessoa_email ?>",
                    pessoa_st: "<?= $pessoa_st ?>",
                    pessoa_dt_criacao: "<?= $pessoa_dt_criacao ?>",
                    pessoa_dt_alteracao: "<?= $pessoa_dt_alteracao ?>",
                    pessoa_usuario_criador: "<?= $pessoa_usuario_criador ?>",
                    setaf_id: "<?= $setaf_id ?>",
                    ater_contrato_id: "<?= $ater_contrato_id ?>",
                    lote_id: "<?= $lote_id ?>",
                    flag_usuario_acervo_digital: "<?= $flag_usuario_acervo_digital ?>",
                    cpf_autor: "<?= $cpf_autor ?>",
                    instituicao_autor: "<?= $instituicao_autor ?>",
                    semaf_municipio_id: "<?= $semaf_municipio_id ?>",
                    ppa_municipio_id: "<?= $ppa_municipio_id ?>",
                    empresa_id: "<?= $empresa_id ?>",
                    flag_cadastro_externo: "<?= $flag_cadastro_externo ?>",
                    menipolicultor_territorio_id: "<?= $menipolicultor_territorio_id ?>",
                    sipaf_municipio_id: "<?= $sipaf_municipio_id ?>",
                    prefeito_municipio_id: "<?= $prefeito_municipio_id ?>",
                    cartorio_municipio_id: "<?= $cartorio_municipio_id ?>",
                    proposta_dupla_numero: "<?= $proposta_dupla_numero ?>",

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