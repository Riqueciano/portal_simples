<?php

//echo '<br><br><br><br>pk->'.  var_dump($fk);//exit;
/* $string = "<?php include '../template/begin_1_2018rn.php'?> 


  "; */
//print_r($fk);echo '<br>';
//echo '<br>aki<br>';

$string = "<?php include '../template/begin_1_2018rn.php'; ?>
<html>
    <head>
        
    </head>
    <body>
    
        <!-- ###app### -->
        <style> [v-cloak] {display: none;}</style>
    <div id='app' v-cloak></div>
        <!-- ### -->

    <template id=\"app-template\">
    <div>    
      <h2 style=\"margin-top:0px\"><span id='spanAcaoForm'><i class='glyphicon glyphicon-chevron-right'></i>Cadastro</span> " . ucfirst($table_name) . " <?php // echo \$button ?></h2>   
        <form action=\"<?php echo \$action; ?>\" method=\"post\" enctype=\"multipart/form-data\">
            <div  class='col-md-12' name='' id=''>
                <div class='x_panel' id=''>
                            <div class='x_content'>
                                <div style='overflow-x:auto'>
        <table class='table'>";
foreach ($non_pk as $row) {
    $string .= "<tr> ";
    ##NOT NULL
    if ($row['is_nullable'] == 'NO') {
        $required = "required='required'";
        $asterisco = "*";
    } else {
        $required = "";
        $asterisco = "";
    }


    if ($row["data_type"] == 'text' or (int)$row['character_maximum_length'] >= 400) {
        $string .= " 
            <td>
                <label for=\"" . $row["column_name"] . "\">" . label($row["column_name"]) . "$asterisco <?php echo form_error('" . $row["column_name"] . "') ?></label>
            </td>                    
            <td>  
        <div class=\"form-group\">
        <textarea maxlength=\"".(int) $row['character_maximum_length']."\"  class=\"form-control\" rows=\"3\" v-model=\"form." . $row["column_name"] . "\"  name=\"" . $row["column_name"] . "\" id=\"" . $row["column_name"] . "\" $required  placeholder=\"\"  >{{form." . $row["column_name"] . " }}</textarea>
        </div>
            </td>";
    } else {

        $string .= " <td>   
                    <div class=\"form-group\">
                    <label for=\"" . $row["data_type"] . "\">" . label($row["column_name"]) . $asterisco . " <?php echo form_error('" . $row["column_name"] . "') ?></label>
                                        </div>
                        </td>  ";
        //verifica se ï¿½ uma FK
        $entrou = 0;
        $index = 0;
        for ($i = 0; $i < count($fk); $i++) {
            if ($row["column_name"] == $fk[$i]['column_name']) {
                $temFK = 1;
                $index = $i;
            }
        }

        //adiciciona efeito
        $string .= "<td>  
                            <div class=\"item form-group\">";
        if ($temFK == 1) {
            //echo 'tb_fk='.$row["tb_fk"];exit;
            // var_dump($fk);
            /* $string .= "        <?php  echo combo('" . $row["column_name"] . "','" . $fk[$index]["tb_fk"] . "','" . $row["column_name"] . "','" . $row["column_name"] . "','',$" . $fk[$index]["column_name"] . ",\"\");?>";*/

            // $string .= "\n<select  class='select2_single form-control' tabindex='-1' v-model='form.".$row["column_name"]."' id='".$row["column_name"]."' name='".$row["column_name"]."'>
            //                     <option value=''>.:Selecione:.</option>
            //                     <option  v-for='(i, index) in ".$fk[$index]["foreign_table_name"]."' :value=\"i.".$row["column_name"]."\"> {{i.".$fk[$index]["foreign_column_name"]."}}</option>
            //             </select> ";

            $string .= "\n<select2 :options=\"".$fk[$index]["foreign_table_name"]."\"  v-model='form.".$row["column_name"]."'  id='".$row["column_name"]."'  name='".$row["column_name"]."'>
                    <option disabled value=''>.:Selecione:.</option>
                </select2>";
            // $string .= "\n<v-select :options=\"" . $fk[$index]["foreign_table_name"] . "\" v-model='form." . $fk[$index]["foreign_column_name"] . "' id='" . $fk[$index]["foreign_column_name"] . "' name='" . $fk[$index]["foreign_column_name"] . "' ></v-select>";
        } else {



            ##VALIDAÇÃO
            echo $row['data_type'] . '<br>';
            if ($row['data_type'] == 'numeric' || $row['data_type'] == 'integer') {
                $type = "number";
                $mask = " onkeypress=\"mascara(this, soNumeros);\" ";
            } else if ($row['data_type'] == 'double precision') {
                $type = "";
                $mask = " onkeypress=\"mascara(this, money);\" ";
            } else if ($row['data_type'] == 'date') {
                $type = "date";
                $mask = " onKeyPress='return false;' onPaste='Return false' maxlength='10' ";
            } else if ($row['data_type'] == 'time without time zone') {
                $type = "time";
                $mask = "  maxlength='5' ";
            } else {
                $type = "text";
                $mask = "";
            }
            if ((int) $row['character_maximum_length'] > 0) {
                $maxlength = " maxlength = '" . (int) $row['character_maximum_length'] . "'";
            }


            //echo $row["column_name"].'.'.$row['data_type'].'<br>';
            $string .= "  <input type=\"$type\" class=\"form-control\" name=\"" . $row["column_name"] . "\" id=\"" . $row["column_name"] . "\"  placeholder=\"" . label($row["column_name"]) . "\"  v-model=\"form." . $row["column_name"] . "\" $required $mask $maxlength />";
        }
        $string .= "\t</div> 
                 </td> ";
    }
    $string .= " </tr>";
    //zera a informação se a coluna atual é uma FK
    $temFK = 0;
}
$string .= "<tr> 
                <td colspan='2'>";
$string .= "        \n<input type=\"hidden\" name=\"" . $pk . "\" value=\"<?php echo $" . $pk . "; ?>\" /> ";
$string .= "        \n<button id=\"btnGravar\" type=\"submit\" class=\"btn btn-primary\">{{button}}</button> ";
$string .= "        \n<a href=\"<?php echo site_url('" . $c_url . "') ?>\" class=\"btn btn-default\">Voltar</a>";
$string .= " </td>
</tr>  

</table> 
</div>
                        </div>
                    </div>
                </div>
</form>
</div>
</template>
<!--script type=\"text/x-template\" id=\"select2-template\">
        <select>
           <slot></slot>
        </select>
    </script-->


<!--monta combobox-->
<!--script type=\"text/javascript\" language=\"javascript\" src=\"https://<?php echo \$_SERVER['HTTP_HOST'] . '/' . \$nmServer ?>/JavaScript/vue/select2/montaSelect.js\"></script-->
<script type=\"text/javascript\" language=\"javascript\" src=\"<?php echo iPATH ?>/JavaScript/vue/select2/montaSelect.js\"></script>

<script>
        new Vue({
            el: \"#app\",
            template: \"#app-template\",
            data: {
                message: '',
                button: \"<?= \$button ?>\",
                controller: \"<?= \$controller ?>\",";
$string .= count($fk) == 0 ? "" : "\n/*tag select*/ \n";
for ($i = 0; $i < count($fk); $i++) {
    $string .= $fk[$i]['foreign_table_name'] . ": <?=$" . $fk[$i]['foreign_table_name'] . "?>, ";
}
$string .= count($fk) == 0 ? "" : "\n/*form*/ \n";
$string .= "    form: { ";
// var_dump($fk);
// exit;
//monta as variaveis  do form
$temFK = 0;
foreach ($non_pk as $row) {
    $string .= $row["column_name"] . ": \"<?= $" . $row["column_name"] . "?>\",\n  ";
}


$string .=             " 
                },
            },
            computed: { 

            },
            methods: {

            },
            mounted() {
                if (this.controller == 'read') {
                    $(\"input\").prop(\"disabled\", true);
                    $(\"select\").prop(\"disabled\", true);
                    $(\"textarea\").prop(\"disabled\", true);
                    $(\"#btnGravar\").hide();
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

<?php include '../template/end.php'; ?>";


/* $string .= "<?php include '../template/end.php'?> "; */

$hasil_view_form = createFile($string, $target . "views/" . $c_url . "/" . $v_form_file);
