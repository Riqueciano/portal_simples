<?php 

//vem concatenado com o schema
$table_name;
$tableMinTemp = explode('.', $table_name);
$tableMin = $tableMinTemp[1];





$string = "<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class " . $m . " extends CI_Model
{

    public \$table = '$table_name';
    public \$id = '$pk';
    public \$order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        \$this->db->order_by(\$this->table.'.'.\$this->id, \$this->order);
        return \$this->db->get(\$this->table)->result();
    }

    // get all for combobox 
    function get_all_combobox(\$param = null, \$order = null)
    {
        \$this->db->select(\"\$this->id as id, \$this->id as text\");
        if(!empty(\$param)){
            \$this->db->where(\$param);
        }
        if(!empty(\$order)){
            \$this->db->order_by(\$order);
        }else{
            \$this->db->order_by(\$this->table . '.' . \$this->id, 'asc');
        }
        
        return \$this->db->get(\$this->table)->result();
    }

    // get data by id
    function get_by_id(\$id)
    {
        \$this->db->where(\$this->id, \$id);
        return \$this->db->get(\$this->table)->row();
    }
    
    // get total rows
    function total_rows(\$q = NULL) {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/
        \@$this->db->ilike('$table_name.$pk', \$q);";

foreach ($non_pk as $row) {
    $string .= "\n\t\$this->db->or_ilike('" . $tableMin.'.'.$row['column_name'] ."', \$q);";
}    

$string .= "\n\t\$this->db->from(\$this->table);
        return \$this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data(\$limit, \$start = 0, \$q = NULL) {
        \$this->db->select('*');
        \$this->db->order_by(\$this->table.'.'.\$this->id, \$this->order);
        \@$this->db->ilike('$tableMin.$pk', \$q);";

foreach ($non_pk as $row) {
    $string .= "\n\t\$this->db->or_ilike('" .$tableMin.'.'. $row['column_name'] ."', \$q);";
}    
//monta os join com as tabelas estranjeiras
$i=1;
foreach ($fk as $row) {
    if($tb_old == $row['schema_table_fk']){
        $i++;
        $tbTemp                 = explode('.',$row['schema_table_fk']);
        $tb                     = $tbTemp[1];
        $alias                  = ' as '.(substr($tb,0,1)).$i;
        $alias2                 = (substr($tb,0,1)).$i.'.';
        $columnTemp             = (substr($tb,0,1)).$i;
        //so a tabela
        $foreign_column_name    = $row['foreign_column_name'];
    }else{
        $alias                  = '';
        $alias2                 = '';
        $columnTemp             = $row['column_name'];
        //schema . tabela
        $foreign_column_name    = $row['table_column_fk'];
        $i                      = 1;
    }
    
    $string .= "\n\t\$this->db->join('" .$row['schema_table_fk'].$alias ."','".$tableMin.'.'. $row['column_name']." = ".$alias2.$foreign_column_name."', 'INNER');";
    $tb_old = $row['schema_table_fk'];
}    

$string .= "\n\t\$this->db->limit(\$limit, \$start);
        return \$this->db->get(\$this->table)->result();
    }";



//consulta com parametros 
$string .= "
    
            function get_all_data(\$param,\$order=null) {
    ";
$string .= "    
                \$this->db->select('*');
              
                ";
$string .= "        \$where = '1=1 ';
                    foreach (\$param as \$array) {
                        //se tiver parametro
                        if(\$array[2] != ''){
                                \$where .=  \" and \".\$array[0].\" \". \$array[1] .\" '\".\$array[2].\"' \";
                            }
                    }";


foreach ($fk as $row) {
    if($tb_old == $row['schema_table_fk']){
        $i++;
        $tbTemp                 = explode('.',$row['schema_table_fk']);
        $tb                     = $tbTemp[1];
        $alias                  = ' as '.(substr($tb,0,1)).$i;
        $alias2                 = (substr($tb,0,1)).$i.'.';
        $columnTemp             = (substr($tb,0,1)).$i;
        //so a tabela
        $foreign_column_name    = $row['foreign_column_name'];
    }else{
        $alias                  = '';
        $alias2                 = '';
        $columnTemp             = $row['column_name'];
        //schema . tabela
        $foreign_column_name    = $row['table_column_fk'];
        $i                      = 1;
    }
    $string .= "\n\t\$this->db->join('" .$row['schema_table_fk'].$alias ."','".$tableMin.'.'. $row['column_name']." = ".$alias2.$foreign_column_name."', 'INNER');";
    $tb_old = $row['schema_table_fk'];
}
    $string .= " 
                 \$this->db->where(\$where); 
                 \$this->db->order_by(\$order);  
                 return \$this->db->get(\$this->table)->result();
         }// end get_all_data
         
";










    // insert data
 $string .=
  "
 function insert(\$data)
    {
        \$this->db->insert(\$this->table, \$data);
    }

    // update data
    function update(\$id, \$data)
    {
        \$this->db->where(\$this->id, \$id);
        \$this->db->update(\$this->table, \$data);
    }

    // delete data
    function delete(\$id)
    {
        \$this->db->where(\$this->id, \$id);
        
        if(!\$this->db->delete(\$this->table)){
            return 'erro_dependencia';
        }
    }

}

/* Final do arquivo $m_file */
/* Local: ./application/models/$m_file */
/* Data - ".date('Y-m-d H:i:s')." */";






$hasil_model = createFile($string, $target."models/" . $m_file);

?>