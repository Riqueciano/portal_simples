<?php

function combo($name,$table,$pk,$field,$javascritp, $selected,$selectText='.:Selecione:.'){
    //echo $field;exit;
    $ci = get_instance();
    $cmb = "<select name='$name' id='$name' class='form-control' onchange='$javascritp'>";
    $data = $ci->db->get($table)->result();
    //echo '<pre>';print_r($data);exit;
    
    $cmb .= "<option  selected value=''>$selectText</option>";
    foreach ($data as $d){      
      $cmb .= "<option value='".$d->$pk."'";
        $cmb .= $selected==$d->$pk?" selected='selected'":"";
        $cmb .= ">". strtoupper($d->$field).'</option>';
    }   
    $cmb .="</select>";
    return $cmb;
}