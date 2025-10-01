<?php 

/*
$string .= "<?php include '../template/begin.php'?> 
          

";*/

$string = "<?php include '../template/begin.php'; ?> 
<html>
    <head>
        <title>SDR</title>
        <!--link rel=\"stylesheet\" href=\"<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>\"/-->
        <style>
            
        </style>
    </head>
    <body>
        <h2 style=\"margin-top:0px\">Listagem - ".ucfirst($table_name)."</h2>
        <div class=\"row\" style=\"margin-bottom: 10px\">
            <div class=\"col-md-4\">
                <?php echo anchor(site_url('".$c_url."/create'),'Novo', 'class=\"btn btn-success\"'); ?>
            </div>
            <div class=\"col-md-3 text-center\">
                <div style=\"margin-top: 8px\" id=\"message\">
                    <?php //echo \$this->session->userdata('message') <> '' ? \$this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class=\"col-md-1 text-right\">
            </div>
            <div class=\"col-md-4 text-right\">
                <form action=\"<?php echo site_url('$c_url/index'); ?>\" class=\"form-inline\" method=\"get\">
                    <div class=\"input-group\">
                        <input type=\"text\" class=\"form-control\" name=\"q\" value=\"<?php echo \$q; ?>\">
                        <span class=\"input-group-btn\">
                            <?php 
                                if (\$q <> '')
                                {
                                    ?>
                                    <a href=\"<?php echo site_url('$c_url'); ?>\" class=\"btn btn-default\">X</a>
                                    <?php
                                }
                            ?>
                          <button class=\"btn btn-primary\" type=\"submit\">Procurar</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div style='overflow-x:auto'>
        <table class=\"table table-striped\" style=\"margin-bottom: 10px\">
            <tr>
                <!--th>No</th-->";
$string .= "\n\t\t<th align='center'>-</th>";
foreach ($non_pk as $row) {
    $string .= "\n\t\t<th>" . label($row['column_name']) . "</th>";
}
$string .= "\n
            </tr>";
$string .= "<?php
            foreach ($" . $c_url . "_data as \$$c_url)
            {
                ?>
                <tr>";

$string .= "\n\t\t\t<!--td width=\"80px\"><?php echo ++\$start ?></td-->";


$string .= "\n\t\t\t<td style=\"text-align:center\" width=\"100px\">"
        . "\n\t\t\t\t <?php "
        
        . "\n\t\t\t\t echo anchor(site_url('".$c_url."/read/'.$".$c_url."->".$pk."),' ',\"class='glyphicon glyphicon-search' title='Consultar' \"); "
       
        //. "\n\t\t\t\t echo \"<a href='\".site_url().\"".$c_url."/read/'.$".$c_url."->".$pk."'><span class='glyphicon glyphicon-search'></span></a>\" ;"
       
            
           
        
        . "\n\t\t\t\t echo ' | '; "
        . "\n\t\t\t\t echo anchor(site_url('".$c_url."/update/'.$".$c_url."->".$pk."),' ',\"class='glyphicon glyphicon-pencil' title='Editar' \"); "
        . "\n\t\t\t\t echo ' | '; "
        . "\n\t\t\t\t echo anchor(site_url('".$c_url."/delete/'.$".$c_url."->".$pk."),' ', \"class='glyphicon glyphicon-trash' title='Excluir' \" .' '.  'onclick=\"javasciprt: return confirm(\\'Tem certeza que deseja apagar o Registro?\\')\"'); "
        . "\n\t\t\t\t ?>"
        . "\n\t\t\t </td>";

foreach ($non_pk as $row) {
    $string .= "\n\t\t\t<td><?php echo $" . $c_url ."->". $row['column_name'] . " ?></td>";
}

$string .=  "\n\t\t</tr>
                <?php
            }
            ?>
        </table>
        </div>
        <div class=\"row\">
            <div class=\"col-md-6\">
                <a href=\"#\" class=\"btn btn-primary\">Total Linhas: <?php echo \$total_rows ?></a>";
if ($export_excel == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/excel'), 'Excel', 'class=\"btn btn-primary\"'); ?>";
}
if ($export_word == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/word'), 'Word', 'class=\"btn btn-primary\"'); ?>";
}
if ($export_pdf == '1') {
    $string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/pdf'), 'PDF', 'class=\"btn btn-primary\"'); ?>";
}



$string .= "\n\t    </div>
            <div class=\"col-md-6 text-right\">
                <?php echo \$pagination ?>
            </div>
        </div>
    </body>
</html>
<?php include '../template/end.php'; ?>";

/*$string .= "<?php include '../template/end.php'?> ";*/


$hasil_view_list = createFile($string, $target."views/" . $c_url . "/" . $v_list_file);

?>