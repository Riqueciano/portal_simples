<?php

function combo($name,$table,$pk,$field,$javascript, $selected,$param=null,$multiple='',$texto='.:Selecione:.',$campos=null){
    if($multiple=='1' || $multiple =='multiple' || $multiple ==true  ){
        $multiple = 'multiple';
    }else{
        $multiple = '';
    }
    $ci = get_instance();
    
    $sql = "select * $campos  from ".$table." where 1=1 ".$param.' ';
    //echo $sql;
    $data = $ci->db->query($sql)->result();
    
    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select $multiple name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript' style='800px'>";
    
    $cmb .= "<option  value=''>$texto</option>";
    foreach ($data as $d){      
      $cmb .= "<option value='".$d->$pk."'";
        $cmb .= $selected==$d->$pk?" selected='selected'":"";
        $cmb .= ">". rupper($d->$field).'</option>';
    }   
    $cmb .="</select>";
    return $cmb;
}
function comboVendedorIni($name,$selected,$javascript ,$param=null){
    
    //echo $javascript;exit;
    $ci = get_instance();
    
    $sql = "select *  from campanha.vendedor where 1=1 ".$param.' ';
    //echo $sql;
    $data = $ci->db->query($sql)->result();
    
    $cmb = "<select name='$name' id='$name' class='select2_single form-control' tabindex='-1' onchange='$javascript' style='800px'>";
    
    $cmb .= "<option  value=''>.:Selecione:.</option>";
    foreach ($data as $d){      
      $cmb .= "<option value='".$d->vendedor_id."'";
        $cmb .= $selected==$d->vendedor_id?" selected='selected'":"";
        $cmb .= "> ". rupper($d->vendedor_cnpj).'</option>';
    }   
    $cmb .="</select>";
    return $cmb;
}
function comboPessoaSetor($name,$table,$pk,$field,$javascript, $selected,$param=null,$multiple='',$texto='.:Selecione:.',$campos=null){
    if($multiple=='1' || $multiple =='multiple' || $multiple ==true  ){
        $multiple = 'multiple';
    }else{
        $multiple = '';
    }
    $ci = get_instance();
    
    $sql = "select * from vi_pessoa_unidade_orcamentaria2 order by pessoa_nm";
    //echo $sql;
    $data = $ci->db->query($sql)->result();
    
    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select $multiple name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript' style='800px'>";
    
    $cmb .= "<option  value=''>$texto</option>";
    foreach ($data as $d){      
      $cmb .= "<option value='".$d->pessoa_id."'";
        $cmb .= $selected==$d->$pk?" selected='selected'":"";
        $cmb .= ">". rupper($d->pessoa_nm).' - '.rupper($d->est_organizacional_sigla).'</option>';
    }   
    $cmb .="</select>";
    
    
    return $cmb;
}
function comboCaixaArquivo($name,$table,$pk,$field,$javascript, $selected,$param=null,$multiple='',$texto='.:Selecione:.',$campos=null){
    if($multiple=='1' || $multiple =='multiple' || $multiple ==true  ){
        $multiple = 'multiple';
    }else{
        $multiple = '';
    }
    $ci = get_instance();
    
    $sql = "select * FROM documento2.caixa c 
                            inner join documento2.armario a
                                on a.armario_id = c.armario_id
                    where 1=1 ".$param.' ';
    //echo $sql;
    $data = $ci->db->query($sql)->result();
    
    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select $multiple name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript'>";
    
    $cmb .= "<option  value=''>$texto</option>";
    foreach ($data as $d){      
      $cmb .= "<option value='".$d->$pk."'";
        $cmb .= $selected==$d->$pk?" selected='selected'":"";
        $cmb .= ">". rupper('Caixa: '.$d->caixa_nm.' - Armário: '.$d->armario_nm).'</option>';
    }   
    $cmb .="</select>";
    
    
    return $cmb;
}
function comboSimples($name,$table,$pk,$field,$javascript, $selected,$param=null,$multiple='',$textSelect='.:Selecione:.',$class=NULL){
    if($multiple=='1' || $multiple =='multiple' || $multiple ==true  ){
        $multiple = 'multiple';
    }else{
        $multiple = '';
    }
    $ci = get_instance();
    
    
    $data = $ci->db->query("select * from ".$table." where 1=1 ".$param.' ')->result();
    
    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select $multiple name='$name' id='$idName'  onchange='$javascript' class='$class form-control'>";
    
    $cmb .= "<option  value=''>$textSelect</option>";
    foreach ($data as $d){      
      $cmb .= "<option value='".$d->$pk."'";
        $cmb .= $selected==$d->$pk?" selected='selected'":"";
        $cmb .= ">". rupper($d->$field).'</option>';
    }   
    $cmb .="</select>";
    
    
    return $cmb;
}
