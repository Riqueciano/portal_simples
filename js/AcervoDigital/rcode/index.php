<?php
//error_reporting(0);
require_once 'core/harviacode.php';
require_once 'core/helper.php';
require_once 'core/process.php';
//include '../../template/begin_harviacode.php';
//caso não esteja logado, redireciona para o Login
##GESTOR
//echo $_SESSION['pessoa_id'];
if(!isset($_SESSION['pessoa_id'])){
    echo "Logue no sistema Gestor";
    exit;
}
?>
<!doctype html>
<html>
    <head>
        <title>Rcode Codeigniter 2.0</title>
        <link rel="stylesheet" href="core/bootstrap.min.css">
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="col-md-5">
                <form action="index.php" method="POST">

                    <div class="form-group">
                        <label>Select Table - <a href="<?php echo $_SERVER['PHP_SELF'] ?>">Refresh</a></label>
                        <select id="table_name" name="table_name" class="form-control" onchange="setname()">
                            <option value="">.:Selecione:.</option>
                            <?php
                            $table_list = $hc->table_list();
                            $table_list_selected = isset($_POST['table_name']) ? $_POST['table_name'] : '';
                            foreach ($table_list as $table) {
                                ?>
                                <option value="<?php echo $table['table_name'] ?>" <?php echo $table_list_selected == $table['table_name'] ? 'selected="selected"' : ''; ?>><?php echo $table['table_name_tela'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <label><input type='checkbox' checked name='flag_view_list' value='1'/>List</label>
                        <label><input type='checkbox' checked name='flag_view_form' value='1'/>Form</label>
                        <label><input type='checkbox' checked name='flag_model' value='1'/>Model</label>
                        <label><input type='checkbox'checked name='flag_controller'  value='1'/>Controller</label>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <?php $jenis_tabel = isset($_POST['jenis_tabel']) ? $_POST['jenis_tabel'] : 'reguler_table'; ?>
                            <div class="col-md-6">
                                <div class="radio" style="margin-bottom: 0px; margin-top: 0px">
                                    <label>
                                        <input type="radio" name="jenis_tabel" value="reguler_table" <?php echo $jenis_tabel == 'reguler_table' ? 'checked' : ''; ?>>
                                        Reguler Table
                                    </label>
                                </div>                            
                            </div>
                            <div class="col-md-6">
                                <div class="radio" style="margin-bottom: 0px; margin-top: 0px">
                                    <label>
                                        <input type="radio" name="jenis_tabel" value="datatables" <?php echo $jenis_tabel == 'datatables' ? 'checked' : ''; ?>>
                                        Datatables
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <?php $export_excel = isset($_POST['export_excel']) ? $_POST['export_excel'] : ''; ?>
                            <label>
                                <input type="checkbox" name="export_excel" value="1" <?php echo $export_excel == '1' ? 'checked' : '' ?>>
                                Export Excel
                            </label>
                        </div>
                    </div>    

                    <div class="form-group">
                        <div class="checkbox">
                            <?php $export_word = isset($_POST['export_word']) ? $_POST['export_word'] : ''; ?>
                            <label>
                                <input type="checkbox" name="export_word" value="1" <?php echo $export_word == '1' ? 'checked' : '' ?>>
                                Export Word
                            </label>
                        </div>
                    </div>    

                                        <div class="form-group">
                                            <div class="checkbox  <?php // echo file_exists('../application/third_party/mpdf/mpdf.php') ? '' : 'disabled';   ?>">
                    <?php  $export_pdf = isset($_POST['export_pdf']) ? $_POST['export_pdf'] : ''; ?>
                                                <label>
                                                    <input type="checkbox" name="export_pdf" value="1" <?php // echo $export_pdf == '1' ? 'checked' : ''   ?>
                    <?php  //echo file_exists('../application/third_party/mpdf/mpdf.php') ? '' : 'disabled'; ?>>
                                                    Export PDF
                                                </label>
                    <?php  //echo file_exists('../application/third_party/mpdf/mpdf.php') ? '' : '<small class="text-danger">mpdf required, download <a href="https://harviacode.com">here</a></small>'; ?>
                                            </div>
                                        </div>


                    <div class="form-group">
                        <label>Custom Controller Name</label>
                        <input type="text" id="controller" name="controller" value="<?php echo isset($_POST['controller']) ? $_POST['controller'] : '' ?>" class="form-control" placeholder="Controller Name" />
                    </div>
                    <div class="form-group">
                        <label>Custom Model Name</label>
                        <input type="text" id="model" name="model" value="<?php echo isset($_POST['model']) ? $_POST['model'] : '' ?>" class="form-control" placeholder="Controller Name" />
                    </div>
                     <div class="form-group">
                        <label>SubCrud</label> - Cria CRUD "dentro" do crud principal
                        <select id="sub_table_name" name="sub_table_name" class="form-control" >
                            <option value="">.:Selecione:.</option>
                            <?php
                            $table_list = $hc->table_list();
                            $table_list_selected = isset($sub_table_name) ? $sub_table_name : '';
                            foreach ($table_list as $table) {
                                ?>
                                <option value="<?php echo $table['table_name'] ?>" <?php echo $table_list_selected == $table['table_name'] ? 'selected="selected"' : ''; ?>><?php echo $table['table_name_tela'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" value="Generate" name="generate" class="btn btn-primary" onclick="javascript: return confirm('This will overwrite the existing files. Continue ?')" />
                    <!--input type="submit" value="Generate All" name="generateall" class="btn btn-danger" onclick="javascript: return confirm('WARNING !! This will generate code for ALL TABLE and overwrite the existing files\
                    \nPlease double check before continue. Continue ?')" /-->
                    <a href="core/setting.php" class="btn btn-default">Setting</a>
                </form>
                <br>

                <?php
                foreach ($hasil as $h) {
                    echo '<p>' . $h . '</p>';
                }
                ?>
            </div>
            <div class="col-md-7">
                <h3 style="margin-top: 0px">Codeigniter CRUD Generator @Riqueciano</h3>
                <p><strong>About :</strong></p>
                <p>
                    Baseado no Harviacode 1.3.1 para MYSQL
                </p>
                
                <p><strong>Pendencias e limitacoes :</strong></p>
                <ul>
                    <li>-Toda tabela deve ter PK</li>
                    <li>-PK deve ser o primeiro campo na tabela</li>
                    <li>-Apenas Postgres</li>
                    <li>-Não suporta time with time zone, apenas date</li>
                    
                </ul>
                <p><strong>Important :</strong></p>
                <ul>
                    <li>On application/config/autoload.php, load database library, session library and url helper</li>
                    <li>On application/config/config.php, set :</b>.
                        <ul>
                            <li>$config['base_url'] = 'https://127.0.0.1/yourprojectname'</li>
                            <li>$config['index_page'] = ''</li>
                            <li>$config['url_suffix'] = '.html'</li>
                            <li>$config['encryption_key'] = 'randomstring'</li>
                            <li>*add helper combo_helper</li>

                        </ul>

                    </li>
                     </ul>
                
            </div>
        </div>
        <script type="text/javascript">
            function capitalize(s) {
                return s && s[0].toUpperCase() + s.slice(1);
            }

            function setname() {
                var table_name = document.getElementById('table_name').value.toLowerCase();
                if (table_name != '') {
                    
                    var temp = table_name.split('.');
                    /*
                    document.getElementById('controller').value     = capitalize(table_name).replace(".", "_");
                    document.getElementById('model').value          = capitalize(table_name).replace(".", "_") + '_model';
                    */
                   //alert(temp[1])
                    document.getElementById('controller').value     = capitalize(temp[1]);
                    document.getElementById('model').value          = capitalize(temp[1]) + '_model';
                } else {
                    document.getElementById('controller').value     = '';
                    document.getElementById('model').value          = '';
                }
            }
        </script>
    </body>
</html>
<?php // include '../../template/end_harviacode.php' ?>