<?php 

//echo count($fk);exit;
/*$string = "<?php include '../template/begin_1_2018rn.php'?> 
          

";*/

$string = "<?php include '../template/begin_1_2018rn.php'; ?>
<html>
    <head>
        <script type=\"text/javascript\">
            $(document).ready(function () {
                if('<?=\$controller?>'=='read'){
                    $(\"input\").prop(\"disabled\", true);
                    $(\"select\").prop(\"disabled\", true);
                    $(\"textarea\").prop(\"disabled\", true);
                    $(\"#btnGravar\").hide();
                }else if('<?=\$controller?>'=='create'){
                    //tela de create
                }else if('<?=\$controller?>'=='update'){
                    //tela de update
                }else if('<?=\$controller?>'=='report'){
                    $('input').removeAttr(\"required\");
                }
            });
        </script>
    </head>
    <body>
        <h2 style=\"margin-top:0px\">Relatório: ".ucfirst($table_name)." <?php // echo \$button ?></h2>
        <form action=\"<?php echo \$action; ?>\" method=\"post\" enctype=\"multipart/form-data\">
        \n<table class='table'>";
foreach ($non_pk as $row) {
    $string .="\t\n<tr> 
                 <td>";
    if ($row["data_type"] == 'text'){
    $string .= "\n\t    <div class=\"form-group\">
                            <label for=\"".$row["column_name"]."\">".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></label>
                            <textarea class=\"form-control\" rows=\"3\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\"><?php echo $".$row["column_name"]."; ?></textarea>
        </div>";
    } else{
    $string .= "\n\t    <div class=\"form-group\">
            <label for=\"".$row["data_type"]."\">".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></label>
    "; 
      //verifica se ï¿½ uma FK
        $entrou = 0;
        $index  = 0;
        for($i=0;$i<count($fk);$i++){
            if($row["column_name"]==$fk[$i]['column_name']){
              $temFK = 1;  
              $index = $i;
            }
        }
   
        //adiciciona efeito
        $string .=" <div class=\"item form-group\">";
        if($temFK == 1){
            //echo 'tb_fk='.$row["tb_fk"];exit;
            $string .= "<?php  echo combo('".$row["column_name"]."','".$fk[$index]["tb_fk"]."','".$row["column_name"]."','".$row["column_name"]."','',$".$fk[$index]["column_name"].",\"\");?>";
        }else{
            
            ##NOT NULL
            if($row['is_nullable']=='NO'){
                $required = "required='required'";
            }else{
                $required = "";
            }
            
            ##VALIDAÇÃO
            if($row['data_type']=='numeric' || $row['data_type']=='integer'){
                $type = "number";
                $mask = "";
            }else if($row['data_type']=='date' ){
                $type = "date";
                $mask = " onKeyPress='return false'; onPaste='Return false' maxlength='10' ";
            }else if($row['data_type']=='time without time zone' ){
                $type = "time";
                $mask = "  maxlength='5' ";
            }else{
                $type = "text";
                $mask = "";
            }
            if((int)$row['character_maximum_length']>0){
                $maxlength = " maxlength = '".(int)$row['character_maximum_length']."'";
            }
            
            
            //echo $row["column_name"].'.'.$row['data_type'].'<br>';
            $string .="\n\t  <input type=\"$type\" class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\"  $required $mask $maxlength />";
        }
        $string .="\n\t</div>";
        
        
        
      $string .="\n</div>";
    }
    $string .="\n</td> 
               </tr>";
    //zera a informação se a coluna atual é uma FK
    $temFK =0;
}
$string .="\n<tr> 
                <td>";

$string .= "\n\t        <button id=\"btnGravar\" type=\"submit\" class=\"btn btn-primary\"><?php echo \$button ?></button> ";
$string .= "\n\t        <a href=\"javascript:window.history.go(-1)\" class=\"btn btn-default\">Voltar</a>";
$string .= "\n\t
                </td>
</tr>  

</table>   
</form>
    </body>
</html>

<?php include '../template/end.php'; ?>";


/*$string .= "<?php include '../template/end.php'?> ";*/

//echo $string, $target."views/" . $c_url . "/" . $v_report_file;exit;

$hasil_view_report = createFile($string, $target."views/" . $c_url . "/" . $v_report_file);

?>