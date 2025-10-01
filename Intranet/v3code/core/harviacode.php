<?php

class Harviacode
{

    private $host;
    private $user;
    private $password;
    private $database;
    private $sql;

    function __construct()
    {
        $this->connection();
    }


    function pega_valores_env(){
        $caminho_env = $_SERVER['DOCUMENT_ROOT'] . '/_portal/.ENV';

        if (!file_exists($caminho_env)) {
            die("Arquivo .ENV não encontrado");
        }
        
        $envContent = file_get_contents($caminho_env);
        
        $env = [];
        $lines = explode("\n", $envContent);
        
        foreach ($lines as $line) {
            $line = trim($line);
            // Ignorar linhas vazias ou comentários
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            // Quebrar em chave=valor
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $env[trim($key)] = trim($value);
            }
        }
        return $env;
    }
    function connection()
    {
       
        $env = $this->pega_valores_env();
        
 


        $this->host = $env['DB_HOST'];
        $this->user = $env['DB_USERNAME'];
        $this->password = $env['DB_PASSWORD'];
        $this->database = $env['DB_DATABASE'];

        //$this->sql = new mysqli($this->host, $this->user, $this->password, $this->database);
        $this->sql = pg_connect("host=$this->host dbname=$this->database port=5433 user=$this->user password=$this->password");
        /* if ($this->sql->connect_error)
          {
          echo $this->sql->connect_error . ", please check 'application/config/database.php'.";
          die();
          }
         */
        // unlink($con);
    }

    function table_list()
    {
        //$query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE table_catalog='".$this->database."'";
        $query = "SELECT TABLE_schema ||'.'|| TABLE_NAME as TABLE_NAME, TABLE_schema ||'.'|| TABLE_NAME as TABLE_NAME_tela   
                 FROM INFORMATION_SCHEMA.TABLES WHERE table_catalog='" . $this->database . "' 
                     order by TABLE_schema ||'.'|| TABLE_NAME
                ";
        // echo '1'. $query;exit;
        $stmt = pg_query($this->sql, $query);
        //$stmt->bind_param('s', $this->database);
        //$stmt->bind_result($table_name);
        //$stmt->execute();
        while ($coluna = pg_fetch_array($stmt)) {
            $fields[] = array('table_name' => $coluna['table_name'], 'table_name_tela' => $coluna['table_name_tela']);
        }
        //print_r($fields);exit;
        return $fields;
        // $stmt->close();
        //$this->sql->close();
    }

    function primary_field($table)
    {

        $tb = explode('.', $table);
        $table = $tb[1];
        $table_schema = $tb[0];
        // echo $table;exit;


        $query = "SELECT 
                    COLUMN_NAME as column_name
                    , case when dtd_identifier ='1' then 'ON' 
                                     else 'NO' end as COLUMN_KEY
                    , character_maximum_length,is_nullable 
                        FROM INFORMATION_SCHEMA.COLUMNS
                WHERE table_catalog='" . $this->database . "' AND TABLE_NAME='$table' and table_schema = '$table_schema' AND dtd_identifier = '1'";
        // echo '2'.$query;exit;
        $stmt = pg_query($this->sql, $query);
        //$stmt->bind_param('ss', $this->database, $table);
        //$stmt->bind_result($column_name, $column_key);
        //$stmt->execute();
        //$stmt->fetch();
        while ($coluna = pg_fetch_array($stmt)) {
            $column_name = $coluna['column_name'];
        }
        //echo '$column_name='.$column_name;exit;
        return $column_name;
        //$stmt->close();
        //$this->sql->close();
    }

    function not_primary_field($table)
    {

        $tb = explode('.', $table);
        $table = $tb[1];
        $table_schema = $tb[0];

        $query = "SELECT COLUMN_NAME,case when dtd_identifier ='1' then 'ON' 
                                           else 'NO' end as COLUMN_KEY
                                           , DATA_TYPE 
                        ,character_maximum_length,is_nullable     
                        FROM INFORMATION_SCHEMA.COLUMNS WHERE table_catalog='" . $this->database . "' AND TABLE_NAME='$table' and table_schema = '$table_schema'  AND dtd_identifier <> '1'";
        // echo '3'.'<pre>'.$query.'</pre>';exit;
        $stmt = pg_query($this->sql, $query);
        //$stmt->bind_param('ss', $this->database, $table);
        //$stmt->pg_fetch_array($column_name, $column_key, $data_type);
        while ($coluna = pg_fetch_array($stmt)) {
            $column_name = $coluna['column_name'];
            $column_key = $coluna['column_key'];
            $data_type = $coluna['data_type'];
            $character_maximum_length = $coluna['character_maximum_length'];
            $is_nullable = $coluna['is_nullable'];

            $fields[] = array(
                'column_name' => $column_name,
                'column_key' => $column_key,
                'character_maximum_length' => $character_maximum_length,
                'is_nullable' => $is_nullable,
                'data_type' => $data_type
            );
        }
        /*
          $stmt->execute();
          while ($stmt->fetch()) {
          $fields[] = array('column_name' => $column_name, 'column_key' => $column_key, 'data_type' => $data_type);
          } */

        //print_r($fields);
        return $fields;
        //$stmt->close();
        //$this->sql->close();
    }

    function all_field($table)
    {
        // echo $table . '<br>';
        $tb = explode('.', $table);
        $table_schema = $tb[0];
        $table = $tb[1];
        //$tb_temp = str_replace('.', '_', $tb[1]);




        $query = "SELECT COLUMN_NAME,case when dtd_identifier ='1' then 'ON' 
                                           else 'NO' end as COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_catalog='" . $this->database . "' AND TABLE_NAME='$table' and table_schema = '$table_schema' ";
        // echo '4'.$query;exit;
        $stmt = pg_query($this->sql, $query);
        //$stmt->bind_param('ss', $this->database, $table);
        //$stmt->bind_result($column_name, $column_key, $data_type);
        //$stmt->execute();
        while ($coluna = pg_fetch_array($stmt)) {
            $fields[] = array('column_name' => $coluna['column_name'], 'column_key' => $coluna['column_key'], 'data_type' => $coluna['data_type']);
        }
        return $fields;
        //$stmt->close();
        //$this->sql->close();
    }

    function field_fk($table)
    {

        $tb = explode('.', $table);
        $table = $tb[1];
        $table_schema = $tb[0];

        //$query = "SELECT *  FROM information_schema.table_constraints WHERE TABLE_NAME='$table' and table_schema = '$table_schema'  AND constraint_type = 'FOREIGN KEY'";
        $query = "select distinct

                                tc.constraint_schema || '.' || tc.table_name || '.' || kcu.column_name as physical_full_name,  
                                tc.constraint_schema,
                                tc.table_name, 
                                kcu.column_name, 
                                ccu.table_name as foreign_table_name, 
                                ccu.column_name as foreign_column_name,
                                tc.constraint_type
                                ,ccu.table_schema || '.' || ccu.table_name as tb_fk
                                
                                ,ccu.table_schema || '.' || ccu.table_name as schema_table_fk
                                ,ccu.table_name || '.' || ccu.column_name as table_column_fk
                                
                                ,ccu.table_schema as foreign_schema
                                

                from information_schema.constraint_column_usage ccu
                        inner join information_schema.table_constraints as tc  
                                on ccu.constraint_name = tc.constraint_name  
                        inner join information_schema.key_column_usage kcu
                                on tc.constraint_name = kcu.constraint_name 
                                    and tc.table_name = kcu.table_name
                where tc.constraint_schema = '$table_schema'
                      and tc.table_name = '$table'
                      and ccu.constraint_schema = '$table_schema'
                      and constraint_type in ('FOREIGN KEY')
                 order by ccu.table_schema || '.' || ccu.table_name /*schema_table_fk*/ ";


        //  echo '<pre>'.$query.'</pre>' ; exit;
        $stmt = pg_query($this->sql, $query);
        //$stmt->bind_param('ss', $this->database, $table);
        //$stmt->pg_fetch_array($column_name, $column_key, $data_type);
        $fields = array();
        while ($coluna = pg_fetch_array($stmt)) {
            $column_name = $coluna['column_name'];
            $foreign_table_name = $coluna['foreign_table_name'];
            $tb_fk = $coluna['tb_fk'];
            $schema_table_fk = $coluna['schema_table_fk'];
            $table_column_fk = $coluna['table_column_fk'];
            $foreign_schema = $coluna['foreign_schema'];
            $foreign_column_name = $coluna['foreign_column_name'];
            $table_schema = $table_schema;
            $data_type = 'int';
            $fields[] = array(
                'column_name' => $column_name,
                'data_type' => $data_type,
                'foreign_table_name' => $foreign_table_name,
                'table_schema' => $table_schema,
                'tb_fk' => $tb_fk,
                'schema_table_fk' => $schema_table_fk,
                'table_column_fk' => $table_column_fk,
                'foreign_schema' => $foreign_schema,
                'foreign_column_name' => $foreign_column_name
            );
        }
        //print_r($fields);
        /*
          $stmt->execute();
          while ($stmt->fetch()) {
          $fields[] = array('column_name' => $column_name, 'column_key' => $column_key, 'data_type' => $data_type);
          } */
        return $fields;
        //$stmt->close();
        //$this->sql->close();
    }
    function retorna_colunas($schema, $table)
    {

        // $tb = explode('.', $table);
        // $table = $tb[1];
        // $table_schema = $tb[0];

        //$query = "SELECT *  FROM information_schema.table_constraints WHERE TABLE_NAME='$table' and table_schema = '$table_schema'  AND constraint_type = 'FOREIGN KEY'";
        $query = "SELECT COLUMN_NAME 
                            FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE table_name = '$table' and table_schema='$schema' ";


        // echo '<pre>' . $query . '</pre>';
        // exit;
        $retorno = pg_query($this->sql, $query);
        return $campos = pg_fetch_array($retorno);
        // var_dump($campos);
        // exit;


        // return $fields; 


    }
}


//end class

$hc = new Harviacode();
