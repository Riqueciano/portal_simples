</div>
</div>
</div>
</div>
<footer id="rodape">
    <div class="">
        <p class="pull-right"><strong>SDR - Secretaria de Desenvolvimento Rural</strong>  |
            <span class="lead" > <i class="glyphicon glyphicon-leaf green"></i></span><br>
            <b title="APG - Acessoria de Planejamento e Gestão" data-toggle="tooltip" data-placement="bottom" style="cursor:pointer">
            © Copyright 2015 - <?=date('Y')?> | APG</b>
        </p>
    </div>
    <div class="clearfix"></div>
</footer>
</div>



</div>
<!-- /page content -->

<!-- footer content -->

<!-- /footer content -->
</div>
</div>

<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/bootstrap.min.js"></script>

<!-- chart js -->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/chartjs/chart.min.js"></script>
<!-- bootstrap progress js -->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/nicescroll/jquery.nicescroll.min.js"></script>
<!-- icheck -->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/icheck/icheck.min.js"></script>

<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/custom.js"></script>
<!-- form validation -->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/validator/validator.js"></script>



<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/bootstrap.min.js"></script>

<!-- chart js -->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/chartjs/chart.min.js"></script>
<!-- bootstrap progress js -->
<!--script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/s/progressbar/bootstrap-progressbar.min.js"></script-->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/nicescroll/jquery.nicescroll.min.js"></script>
<!-- icheck -->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/icheck/icheck.min.js"></script>
<!-- tags -->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/tags/jquery.tagsinput.min.js"></script>
<!-- switchery -->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/switchery/switchery.min.js"></script>
<!-- daterangepicker -->
<script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/moment.min2.js"></script>
<script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/datepicker/daterangepicker.js"></script>
<!-- richtext editor -->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/editor/bootstrap-wysiwyg.js"></script>
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/editor/external/jquery.hotkeys.js"></script>
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/editor/external/google-code-prettify/prettify.js"></script>
<!-- select2 -->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/select/select2.full.js"></script>
<!-- form validation -->
<script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/parsley/parsley.min.js"></script>
<!-- textarea resize -->
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/textarea/autosize.min.js"></script>
<script>
    autosize($('.resizable_textarea'));
</script>
<!-- Autocomplete -->
<script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/autocomplete/countries.js"></script>
<script src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/autocomplete/jquery.autocomplete.js"></script>


<!-- graficos - echart-->
<script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/echart/echarts-all.js"></script>
<script type="text/javascript" src="https://<?= $_SERVER['HTTP_HOST'] ?>/_portal/template/production/js/echart/green.js"></script>


<script>
        // initialize the validator function
        validator.message['date'] = 'not a real date';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
                .on('blur', 'input[required], input.optional, select.required', validator.checkField)
                .on('change', 'select.required', validator.checkField)
                .on('keypress', 'input[required][pattern]', validator.keypress);

        $('.multi.required')
                .on('keyup blur', 'input', function () {
                    validator.checkField.apply($(this).siblings().last()[0]);
                });

        // bind the validation to the form submit event
        //$('#send').click('submit');//.prop('disabled', true);

        $('form').submit(function (e) {
            e.preventDefault();
            var submit = true;
            // evaluate the form using generic validaing
            if (!validator.checkAll($(this))) {
                submit = false;
            }

            if (submit)
                this.submit();
            return false;
        });

        /* FOR DEMO ONLY */
        $('#vfields').change(function () {
            $('form').toggleClass('mode2');
        }).prop('checked', false);

        $('#alerts').change(function () {
            validator.defaults.alerts = (this.checked) ? false : true;
            if (this.checked)
                $('form .alert').remove();
        }).prop('checked', false);



        $(document).ready(function () {
            $(".select2_single").select2({
                placeholder: ".:Selecione:.",
                allowClear: true
            });
            $(".select2_group").select2({});
            $(".select2_multiple").select2({
                maximumSelectionLength: 4,
                placeholder: "With Max Selection limit 4",
                allowClear: true
            });
        });


</script>


</body>
<script>
    //google Analytics
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-89030392-1', 'auto');
    ga('send', 'pageview');

</script>

<style>
    /* Overlay cobrindo a tela */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(5px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    /* GIF de carregamento */
    .loading-gif {
        width: 20%;
        border-radius: 50px;
    }

    /* Adiciona blur ao conteúdo */
    .blurred {
        filter: blur(5px);
        pointer-events: none;
        /* Bloqueia interações */
    }
</style>

</html>