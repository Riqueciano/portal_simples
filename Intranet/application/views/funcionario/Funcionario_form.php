<?php include '../template/begin_1_2018rn.php'; ?>
<html>

<head>

</head>

<body>

    <!-- ###app### -->
    <style> [v-cloak] {display: none;}</style>
    <div id='app' v-cloak>
        <h2 style="margin-top:0px"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> Dados_unico.funcionario <?php // echo $button 
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
                                            <label for="integer">Pessoa Id* <?php echo form_error('pessoa_id') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group">
                                            <select v-model='form.pessoa_id' id='pessoa_id' name='pessoa_id' class='select2_single form-control'>
                                                <option value=''>.:Selecione:.</option>
                                                <option :value='i.id' v-for="(i,key) in  pessoa_fisica ">{{i.text}}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="smallint">Funcionario Tipo Id* <?php echo form_error('funcionario_tipo_id') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group">
                                            <select v-model='form.funcionario_tipo_id' id='funcionario_tipo_id' name='funcionario_tipo_id' class='select2_single form-control'>
                                                <option value=''>.:Selecione:.</option>
                                                <option :value='i.id' v-for="(i,key) in  funcionario_tipo ">{{i.text}}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="smallint">Funcao Id <?php echo form_error('funcao_id') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group">
                                            <select v-model='form.funcao_id' id='funcao_id' name='funcao_id' class='select2_single form-control'>
                                                <option value=''>.:Selecione:.</option>
                                                <option :value='i.id' v-for="(i,key) in  funcao ">{{i.text}}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="smallint">Cargo Permanente <?php echo form_error('cargo_permanente') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group">
                                            <select v-model='form.cargo_permanente' id='cargo_permanente' name='cargo_permanente' class='select2_single form-control'>
                                                <option value=''>.:Selecione:.</option>
                                                <option :value='i.id' v-for="(i,key) in  cargo ">{{i.text}}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="character varying">Funcionario Matricula <?php echo form_error('funcionario_matricula') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="funcionario_matricula" id="funcionario_matricula" placeholder="" v-model="form.funcionario_matricula" maxlength='20' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="character varying">Funcionario Ramal <?php echo form_error('funcionario_ramal') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="funcionario_ramal" id="funcionario_ramal" placeholder="" v-model="form.funcionario_ramal" maxlength='5' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="character varying">Funcionario Email <?php echo form_error('funcionario_email') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="funcionario_email" id="funcionario_email" placeholder="" v-model="form.funcionario_email" maxlength='200' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="character varying">Funcionario Dt Admissao <?php echo form_error('funcionario_dt_admissao') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="funcionario_dt_admissao" id="funcionario_dt_admissao" placeholder="" v-model="form.funcionario_dt_admissao" maxlength='10' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="character varying">Funcionario Dt Demissao <?php echo form_error('funcionario_dt_demissao') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="funcionario_dt_demissao" id="funcionario_dt_demissao" placeholder="" v-model="form.funcionario_dt_demissao" maxlength='10' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="smallint">Funcionario Orgao Origem <?php echo form_error('funcionario_orgao_origem') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group">
                                            <select v-model='form.funcionario_orgao_origem' id='funcionario_orgao_origem' name='funcionario_orgao_origem' class='select2_single form-control'>
                                                <option value=''>.:Selecione:.</option>
                                                <option :value='i.id' v-for="(i,key) in  orgao ">{{i.text}}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="character varying">Funcionario Conta Fgts <?php echo form_error('funcionario_conta_fgts') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="funcionario_conta_fgts" id="funcionario_conta_fgts" placeholder="" v-model="form.funcionario_conta_fgts" maxlength='20' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="smallint">Contrato Id <?php echo form_error('contrato_id') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group">
                                            <select v-model='form.contrato_id' id='contrato_id' name='contrato_id' class='select2_single form-control'>
                                                <option value=''>.:Selecione:.</option>
                                                <option :value='i.id' v-for="(i,key) in  contrato ">{{i.text}}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="character varying">Funcionario Salario <?php echo form_error('funcionario_salario') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="funcionario_salario" id="funcionario_salario" placeholder="" v-model="form.funcionario_salario" maxlength='20' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="smallint">Cargo Temporario <?php echo form_error('cargo_temporario') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group">
                                            <select v-model='form.cargo_temporario' id='cargo_temporario' name='cargo_temporario' class='select2_single form-control'>
                                                <option value=''>.:Selecione:.</option>
                                                <option :value='i.id' v-for="(i,key) in  cargo ">{{i.text}}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="smallint">Funcionario Orgao Destino <?php echo form_error('funcionario_orgao_destino') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group">
                                            <select v-model='form.funcionario_orgao_destino' id='funcionario_orgao_destino' name='funcionario_orgao_destino' class='select2_single form-control'>
                                                <option value=''>.:Selecione:.</option>
                                                <option :value='i.id' v-for="(i,key) in  orgao ">{{i.text}}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="smallint">Est Organizacional Lotacao Id <?php echo form_error('est_organizacional_lotacao_id') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group">
                                            <select v-model='form.est_organizacional_lotacao_id' id='est_organizacional_lotacao_id' name='est_organizacional_lotacao_id' class='select2_single form-control'>
                                                <option value=''>.:Selecione:.</option>
                                                <option :value='i.id' v-for="(i,key) in  est_organizacional_lotacao ">{{i.text}}</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="numeric">Funcionario Validacao Propria <?php echo form_error('funcionario_validacao_propria') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="number" class="form-control" name="funcionario_validacao_propria" id="funcionario_validacao_propria" placeholder="" v-model="form.funcionario_validacao_propria" onkeypress="mascara(this, soNumeros);" maxlength='20' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="numeric">Funcionario Validacao Rh <?php echo form_error('funcionario_validacao_rh') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="number" class="form-control" name="funcionario_validacao_rh" id="funcionario_validacao_rh" placeholder="" v-model="form.funcionario_validacao_rh" onkeypress="mascara(this, soNumeros);" maxlength='20' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="numeric">Funcionario Envio Email <?php echo form_error('funcionario_envio_email') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="number" class="form-control" name="funcionario_envio_email" id="funcionario_envio_email" placeholder="" v-model="form.funcionario_envio_email" onkeypress="mascara(this, soNumeros);" maxlength='20' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="smallint">Funcionario Tipo Id Old <?php echo form_error('funcionario_tipo_id_old') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="funcionario_tipo_id_old" id="funcionario_tipo_id_old" placeholder="" v-model="form.funcionario_tipo_id_old" maxlength='20' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="integer">Motorista <?php echo form_error('motorista') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="number" class="form-control" name="motorista" id="motorista" placeholder="" v-model="form.motorista" onkeypress="mascara(this, soNumeros);" maxlength='20' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="character varying">Funcionario Onus <?php echo form_error('funcionario_onus') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="funcionario_onus" id="funcionario_onus" placeholder="" v-model="form.funcionario_onus" maxlength='1' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="integer">Funcionario Funcao Id <?php echo form_error('funcionario_funcao_id') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="number" class="form-control" name="funcionario_funcao_id" id="funcionario_funcao_id" placeholder="" v-model="form.funcionario_funcao_id" onkeypress="mascara(this, soNumeros);" maxlength='1' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="smallint">Funcionario Localizacao* <?php echo form_error('funcionario_localizacao') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="funcionario_localizacao" id="funcionario_localizacao" placeholder="" v-model="form.funcionario_localizacao" required='required' maxlength='1' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="integer">Funcionario St <?php echo form_error('funcionario_st') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="number" class="form-control" name="funcionario_st" id="funcionario_st" placeholder="" v-model="form.funcionario_st" onkeypress="mascara(this, soNumeros);" maxlength='1' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="timestamp with time zone">Funcionario Dt Alteracao <?php echo form_error('funcionario_dt_alteracao') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="funcionario_dt_alteracao" id="funcionario_dt_alteracao" placeholder="" v-model="form.funcionario_dt_alteracao" maxlength='1' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="numeric">Funcionario Diaria Bloqueio <?php echo form_error('funcionario_diaria_bloqueio') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="number" class="form-control" name="funcionario_diaria_bloqueio" id="funcionario_diaria_bloqueio" placeholder="" v-model="form.funcionario_diaria_bloqueio" onkeypress="mascara(this, soNumeros);" maxlength='1' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="character varying">Cartao Adiantamento Numero <?php echo form_error('cartao_adiantamento_numero') ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group"> <input type="text" class="form-control" name="cartao_adiantamento_numero" id="cartao_adiantamento_numero" placeholder="" v-model="form.cartao_adiantamento_numero" maxlength='50' /> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='2'>
                                        <input type="hidden" name="funcionario_id" value="<?php echo $funcionario_id; ?>" />
                                        <button id="btnGravar" type="submit" class="btn btn-primary">{{button}}</button>
                                        <a href="<?php echo site_url('funcionario') ?>" class="btn btn-default">Voltar</a>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--script type="text/x-template" id="select2-template">
        <select>
           <slot></slot>
        </select>
    </script-->



    <script type="module">
        import {
            createApp
        } from "<?= iPATH ?>JavaScript/vue/vue3/vue.esm-browser.prod.js"
        import * as func from "<?= iPATH ?>JavaScript/func.js"
        const app = createApp({
            data() {
                return {
                    message: '',
                    button: "<?= $button ?>",
                    controller: "<?= $controller ?>",
                    /*tag select*/
                    cargo: <?= $cargo ?>,
                    cargo: <?= $cargo ?>,
                    contrato: <?= $contrato ?>,
                    est_organizacional_lotacao: <?= $est_organizacional_lotacao ?>,
                    funcao: <?= $funcao ?>,
                    funcionario_tipo: <?= $funcionario_tipo ?>,
                    orgao: <?= $orgao ?>,
                    orgao: <?= $orgao ?>,
                    pessoa_fisica: <?= $pessoa_fisica ?>,
                    /*form*/
                    form: {
                        pessoa_id: "<?= $pessoa_id ?>",
                        funcionario_tipo_id: "<?= $funcionario_tipo_id ?>",
                        funcao_id: "<?= $funcao_id ?>",
                        cargo_permanente: "<?= $cargo_permanente ?>",
                        funcionario_matricula: "<?= $funcionario_matricula ?>",
                        funcionario_ramal: "<?= $funcionario_ramal ?>",
                        funcionario_email: "<?= $funcionario_email ?>",
                        funcionario_dt_admissao: "<?= $funcionario_dt_admissao ?>",
                        funcionario_dt_demissao: "<?= $funcionario_dt_demissao ?>",
                        funcionario_orgao_origem: "<?= $funcionario_orgao_origem ?>",
                        funcionario_conta_fgts: "<?= $funcionario_conta_fgts ?>",
                        contrato_id: "<?= $contrato_id ?>",
                        funcionario_salario: "<?= $funcionario_salario ?>",
                        cargo_temporario: "<?= $cargo_temporario ?>",
                        funcionario_orgao_destino: "<?= $funcionario_orgao_destino ?>",
                        est_organizacional_lotacao_id: "<?= $est_organizacional_lotacao_id ?>",
                        funcionario_validacao_propria: "<?= $funcionario_validacao_propria ?>",
                        funcionario_validacao_rh: "<?= $funcionario_validacao_rh ?>",
                        funcionario_envio_email: "<?= $funcionario_envio_email ?>",
                        funcionario_tipo_id_old: "<?= $funcionario_tipo_id_old ?>",
                        motorista: "<?= $motorista ?>",
                        funcionario_onus: "<?= $funcionario_onus ?>",
                        funcionario_funcao_id: "<?= $funcionario_funcao_id ?>",
                        funcionario_localizacao: "<?= $funcionario_localizacao ?>",
                        funcionario_st: "<?= $funcionario_st ?>",
                        funcionario_dt_alteracao: "<?= $funcionario_dt_alteracao ?>",
                        funcionario_diaria_bloqueio: "<?= $funcionario_diaria_bloqueio ?>",
                        cartao_adiantamento_numero: "<?= $cartao_adiantamento_numero ?>",

                    }
                } //end data()
            },
            computed: {

            },
            methods: {
                dataToBR,
                dataToBRcomHora,
            },
            watch: {

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
        })

        app.mount('#app');
    </script>
</body>

</html>

<?php include '../template/end.php'; ?>