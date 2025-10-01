<?php

//esquema + . + table
$table_name_min_temp = explode('.', $table_name);

//apenas o nome da table
$table_name_min = $table_name_min_temp[1];

$string = "<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class " . $s. "  extends CI_Model
{
    function __construct()
    {
         
        \$this->load->model('$m'); ";

foreach ($non_pk as $row) {
    for ($i = 0; $i < count($fk); $i++) {
        if ($row["column_name"] == $fk[$i]['column_name']) {
            $temFK = 1;
            $index = $i;
            $foreign_table_name = $fk[$i]['foreign_table_name'];
        }
    }
    // var_dump($fk);
    if ($temFK == 1) {
        $string .= "\n\$this->load->model('" . ucfirst($foreign_table_name) . "_model'); \n";
        $temFK = 0;
    }
}


$string .=       "  
    }";
 



$string .= "\n\n}\n\n/* End of file $s_file */
/* Local: ./application/services/$s_file */
/* Gerado por RGenerator - " . date('Y-m-d H:i:s') . " */";
 

 


if(!$hasil_controller = createFile($string, $target . 'services/' . $s_file)){
    echo "Erro ao criar arquivo $s_file";
    exit;
};
