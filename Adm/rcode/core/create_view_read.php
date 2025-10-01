<?php 

/*$string = "<?php include '../template/begin_form.php'?> 
          

";*/

$string = "<?php include '../template/begin_form.php'; ?>
<html>
    <head>
        <title>SDR</title>
        <!--link rel=\"stylesheet\" href=\"<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>\"/-->
        <style>
            
        </style>
    </head>
    <body>
        <h2 style=\"margin-top:0px\">".ucfirst($table_name)." Read</h2>
        <table class=\"table\">";
foreach ($non_pk as $row) {
    $string .= "\n\t    <tr><td>".label($row["column_name"])."</td><td><?php echo $".$row["column_name"]."; ?></td></tr>";
}
$string .= "\n\t    <tr><td></td><td><a href=\"<?php echo site_url('".$c_url."') ?>\" class=\"btn btn-default\">Voltar</a></td></tr>";
$string .= "\n\t</table>
        </body>
</html>
<?php include '../template/end.php'; ?>";

/*$string .= "<?php include '../template/end.php'?> ";*/


$hasil_view_read = createFile($string, $target."views/" . $c_url . "/" . $v_read_file);

?>