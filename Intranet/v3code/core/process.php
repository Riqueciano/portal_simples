<?php
// phpinfo();
$hasil = array();

if (isset($_POST['generate'])) {
    // get form data
    $table_name = safe($_POST['table_name']);


    //caso usuario deseje criar uma tela de crud dentro da outra "crud dependente"
    $sub_table_name = safe($_POST['sub_table_name']);


    $jenis_tabel = safe($_POST['jenis_tabel']);
    $export_excel = array();
    $export_word = array();
    $export_pdf = array();
    $controller = safe($_POST['controller']);
    $model = safe($_POST['model']);


    $flag_view_list = safe($_POST['flag_view_list']);
    $flag_view_form = safe($_POST['flag_view_form']);
    $flag_model = safe($_POST['flag_model']);
    $flag_controller = safe($_POST['flag_controller']);
    $flag_service = safe($_POST['flag_service']);

    // echo 1; exit;
    ///echo '$controller='.$controller;exit;

    if ($table_name <> '') {


        // set data
        $table_name = $table_name;
        $table_name_barra = str_replace('.', '_', $table_name);

        $table_name_min_temp = explode('.', $table_name);

        $table_name_min = $table_name_min_temp[1];


        //variavel nome dos arquivos
        $tbNm = $table_name_min;

        //echo '$table_name_min=='.$table_name_min;exit;
        //echo 'esse=$table_name='.$table_name;exit;
        $c = $controller <> '' ? ucfirst($controller) : ucfirst($tbNm);


        //echo $c.'<br>';
        $m = $model <> '' ? ucfirst($model) : ucfirst($tbNm) . '_model';
        $s = empty($flag_service) ? null  : ucfirst($tbNm) . '_service';
        // echo $s;exit;


        $v_list = ucfirst($tbNm) . "_list";
        $v_read = ucfirst($tbNm) . "_read";
        $v_form = ucfirst($tbNm) . "_form";
        $v_report = ucfirst($tbNm) . "_report";
        $v_doc = ucfirst($tbNm) . "_doc";
        $v_pdf = ucfirst($tbNm) . "_pdf";

        // url
        $c_url = strtolower($c);
        //echo $c_url;exit;
        // filename
        $c_file = $c . '.php';
        $s_file = $s . '.php';
        $m_file = $m . '.php';
        $v_list_file = $v_list . '.php';
        $v_read_file = $v_read . '.php';
        $v_form_file = $v_form . '.php';
        $v_report_file = $v_report . '.php';
        $v_doc_file = $v_doc . '.php';
        $v_pdf_file = $v_pdf . '.php';

        // read setting
        $get_setting = readJSON('core/settingjson.cfg');
        $target = $get_setting->target;

        if (!file_exists($target . "views/" . $c_url)) {
            mkdir($target . "views/" . $c_url, 0777, true);
        }
        //echo '$table_name='.$table_name;exit;


        $table_name_ponto = str_replace('_', '.', $table_name);
        $table_name_ponto = $table_name;


        //echo $table_name_ponto;exit;
        $pk = $hc->primary_field($table_name_ponto);


        $fk = $hc->field_fk($table_name_ponto);
        //print_r($fk);exit;
        //echo '<br>esse='.($fk['tb_fk']);exit;
        $non_pk = $hc->not_primary_field($table_name_ponto);
        $all = $hc->all_field($table_name_ponto);


        //echo '$table_name='.$table_name;exit;
        // generate
        include 'core/create_config_pagination.php';


        $flag_controller == 1 ? include 'core/create_controller.php' : '';
        $flag_service == 1 ? include 'core/create_service.php' : '';


        $flag_model == 1 ? include 'core/create_model.php' : '';


        if ($flag_view_list == 1) {
            $jenis_tabel == 'reguler_table' ? include 'core/create_view_list.php' : include 'core/create_view_list_datatables.php';
        }

        $flag_view_form == 1 ? include 'core/create_view_form.php' : '';


        //cria a tela de busca relatorio
        $export_pdf == 1 ? include 'core/create_view_report.php' : '';
        //include 'core/create_view_report.php';
        //a tela de read no novo crud � a mesma do form
        //include 'core/create_view_read.php';

        $export_excel == 1 ? include 'core/create_exportexcel_helper.php' : '';
        $export_word == 1 ? include 'core/create_view_list_doc.php' : '';
        $export_pdf == 1 ? include 'core/create_pdf_library.php' : '';
        $export_pdf == 1 ? include 'core/create_view_list_pdf.php' : '';



        $hasil[] = $hasil_controller;
        $hasil[] = $hasil_model;
        $hasil[] = $hasil_view_list;
        $hasil[] = $hasil_view_form;
        $hasil[] = $hasil_view_read;
        $hasil[] = $hasil_view_doc;
        $hasil[] = $hasil_view_pdf;
        $hasil[] = $hasil_config_pagination;
        $hasil[] = $hasil_exportexcel;
        $hasil[] = $hasil_pdf;
        $hasil[] = $hasil_view_report;
    } else {
        $hasil[] = 'No table selected.';
    }
}

if (isset($_POST['generateall'])) {

    $jenis_tabel = safe($_POST['jenis_tabel']);
    $export_excel = safe($_POST['export_excel']);
    $export_word = safe($_POST['export_word']);
    $export_pdf = safe($_POST['export_pdf']);

    $table_list = $hc->table_list();
    foreach ($table_list as $row) {

        $table_name = $row['table_name'];
        //echo '$table_name='.$table_name;exit;
        $c = ucfirst($table_name);
        $m = ucfirst($table_name) . '_model';
        $v_list = $table_name . "_list";
        $v_read = $table_name . "_read";
        $v_form = $table_name . "_form";
        $v_doc = $table_name . "_doc";
        $v_pdf = $table_name . "_pdf";

        // url
        $c_url = strtolower($c);

        // filename
        $c_file = $c . '.php';
        $m_file = $m . '.php';
        $v_list_file = $v_list . '.php';
        $v_read_file = $v_read . '.php';
        $v_form_file = $v_form . '.php';
        $v_doc_file = $v_doc . '.php';
        $v_pdf_file = $v_pdf . '.php';

        // read setting
        $get_setting = readJSON('core/settingjson.cfg');
        $target = $get_setting->target;
        if (!file_exists($target . "views/" . $c_url)) {
            mkdir($target . "views/" . $c_url, 0777, true);
        }

        $pk = $hc->primary_field($table_name);
        $non_pk = $hc->not_primary_field($table_name);
        $all = $hc->all_field($table_name);

        // generate
        include 'core/create_config_pagination.php';
        include 'core/create_controller.php';
        $flag_model == 1 ? include 'core/create_model.php' : '';

        if ($flag_view_list == 1) {
            $jenis_tabel == 'reguler_table' ? include 'core/create_view_list.php' : include 'core/create_view_list_datatables.php';
        }
        $flag_view_form == 1 ? include 'core/create_view_form.php' : '';
        //include 'core/create_view_read.php';

        $export_excel == 1 ? include 'core/create_exportexcel_helper.php' : '';
        $export_word == 1 ? include 'core/create_view_list_doc.php' : '';
        $export_pdf == 1 ? include 'core/create_pdf_library.php' : '';
        $export_pdf == 1 ? include 'core/create_view_list_pdf.php' : '';
        $export_pdf == 1 ? include 'core/create_view_report.php' : '';

        $hasil[] = $hasil_controller;
        $hasil[] = $hasil_model;
        $hasil[] = $hasil_view_list;
        $hasil[] = $hasil_view_form;
        $hasil[] = $hasil_view_read;
        $hasil[] = $hasil_view_doc;
        $hasil[] = $hasil_view_report;
    }

    $hasil[] = $hasil_config_pagination;
    $hasil[] = $hasil_exportexcel;
    $hasil[] = $hasil_pdf;
}



#########################
//sub crud

if (!empty($sub_table_name)) {

    $table_name = $sub_table_name;

    $table_name_barra = str_replace('.', '_', $table_name);

    $table_name_min_temp = explode('.', $table_name);

    $table_name_min = $table_name_min_temp[1];
    $table_name_ponto = str_replace('_', '.', $table_name);
    $table_name_ponto = $table_name;

    $pk = $hc->primary_field($table_name_ponto);

    $fk = $hc->field_fk($table_name_ponto);


    //variavel nome dos arquivos
    $tbNm = $table_name_min;

    $m = $model <> '' ? ucfirst($model) : ucfirst($tbNm) . '_model';
    $m = ucfirst($table_name) . '_model';
    $m_file = $m . '.php';

    $m_file = $m . '.php';

    $hasil[] = $hasil_controller;
    $hasil[] = $hasil_model;
    $hasil[] = $hasil_view_list;
    $hasil[] = $hasil_view_form;
    $hasil[] = $hasil_view_read;
    $hasil[] = $hasil_view_doc;
    $hasil[] = $hasil_view_pdf;
    $hasil[] = $hasil_config_pagination;
    $hasil[] = $hasil_exportexcel;
    $hasil[] = $hasil_pdf;
    $hasil[] = $hasil_view_report;

    $m = ucfirst($table_name) . '_model';
    $m_file = $m . '.php';

    $pk = $hc->primary_field($table_name);
    $non_pk = $hc->not_primary_field($table_name);
    $all = $hc->all_field($table_name);
    include 'core/create_model.php';
    exit;
}
