<?php

function combo($name, $table, $pk, $field, $javascript, $selected=null, $param = null, $multiple = '', $texto =' .:Selecione:. ', $campos = null) {
    if ($multiple == '1' || $multiple == 'multiple' || $multiple == true) {
        $multiple = 'multiple';
    } else {
        $multiple = '';
    }
    $ci = get_instance();

    $sql = "select * $campos  from " . $table . " where 1=1 " . $param . ' ';
    $data = $ci->db->query($sql)->result();

    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    
    $cmb = "<select $multiple name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript'>";

    $cmb .= "<option  value=''>'$texto'</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$pk . "'";
        $cmb .= $selected == $d->$pk ? " selected='selected'" : "";
        $cmb .= ">" . rupper($d->$field) . '</option>';
    }
    $cmb .= "</select>";


    return $cmb;
}



function comboChamada($name, $table, $pk, $field, $javascript, $selected, $param = null, $multiple = '', $texto =' .:Selecione:. ', $campos = null) {
    if ($multiple == '1' || $multiple == 'multiple' || $multiple == true) {
        $multiple = 'multiple';
    } else {
        $multiple = '';
    }
    $ci = get_instance();
    
    $sql = "select * $campos  from " . $table . " where 1=1 " . $param . ' ';
    $data = $ci->db->query($sql)->result();
    
    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select required $multiple name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript'>";
    
    $cmb .= "<option  value=''>'$texto'</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$pk . "'";
        $cmb .= $selected == $d->$pk ? " selected='selected'" : "";
        $cmb .= ">" . rupper($d->$field) . '</option>';
    }
    $cmb .= "</select>";
    
    
    return $cmb;
}


function comboLote_2($name, $javascript, $selected, $param = null, $multiple = '', $texto = '.:Selecione:.') {

    $ci = get_instance();

    $sql = "select 'CP.: '||chamada_publica_nm||' - Lote:'||lote_nm as chamada_lote ,*  from sigater_indireta.lote l  
                                         inner join sigater_indireta.chamada_publica c 
                                             on l.chamada_publica_id = c.chamada_publica_id 
                              where 1=1 " . $param . ' ';
    //echo_pre($sql);
    $data = $ci->db->query($sql)->result();

    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select  name='$name' id='$idName' class='form-control' tabindex='-1' onchange='$javascript' style='width:95%'>";

    $cmb .= "<option  value=''>$texto</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->lote_id . "'";
        $cmb .= $selected == $d->lote_id ? " selected='selected'" : "";
        $cmb .= ">" . rupper($d->chamada_lote) . '</option>';
    }
    $cmb .= "</select>";


    return $cmb;
}

function comboLote($name, $javascript, $selected, $param = null, $multiple = '', $texto = '.:Selecione:.') {
    if ($multiple == '1' || $multiple == 'multiple' || $multiple == true) {
        $multiple = 'multiple';
    } else {
        $multiple = '';
    }
    $ci = get_instance();

    $sql = "select chamada_publica_nm||'/'||lote_nm as chamada_lote ,*  from sigater_indireta.lote l  
                                         inner join sigater_indireta.chamada_publica c 
                                             on l.chamada_publica_id = c.chamada_publica_id 
                              where 1=1 " . $param . ' ';
    echo_pre($sql);
    $data = $ci->db->query()->result($sql);

    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select $multiple name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript'>";

    $cmb .= "<option  value=''>$texto</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->lote_id . "'";
        $cmb .= $selected == $d->lote_id ? " selected='selected'" : "";
        $cmb .= ">" . rupper($d->chamada_lote) . '</option>';
    }
    $cmb .= "</select>";


    return $cmb;
}

function comboAtividade($name, $javascript, $selected, $param = null, $multiple = '') {
    if ($multiple == '1' || $multiple == 'multiple' || $multiple == true) {
        $multiple = 'multiple';
    } else {
        $multiple = '';
    }
    $ci = get_instance();

    $sql = "select *, atividade_pai_nm||' ('||qtd_horas||'H)'||' - Lote: '|| lote_nm as atividade_pai_nm_horas  
                         from sigater_indireta.atividade a
                            inner join sigater_indireta.atividade_pai ap
                                    on a.atividade_pai_id = ap.atividade_pai_id
                            inner join sigater_indireta.lote l
                                    on l.lote_id = a.lote_id
                            inner join sigater_indireta.lote_fiscal lf
                                    on lf.lote_id = l.lote_id and lf.fiscal_pessoa_id = " . $_SESSION['pessoa_id'] . " 
                                where 1=1 " . $param . ' ';
    //echo_pre($sql);
    $data = $ci->db->query($sql)->result();

    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select $multiple name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript'>";

    $cmb .= "<option  value=''>.:Selecione:.</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->atividade_id . "'";
        $cmb .= $selected == $d->atividade_id ? " selected='selected'" : "";
        $cmb .= ">" . rupper($d->atividade_pai_nm_horas) . '</option>';
    }
    $cmb .= "</select>";


    return $cmb;
}

function comboSimples($name, $table, $pk, $field, $javascript, $selected, $param = null, $multiple = '', $textSelect = '.:Selecione:.', $class = NULL) {
    if ($multiple == '1' || $multiple == 'multiple' || $multiple == true) {
        $multiple = 'multiple';
    } else {
        $multiple = '';
    }
    $ci = get_instance();


    $data = $ci->db->query("select * from " . $table . " where 1=1 " . $param . ' ')->result();

    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select $multiple name='$name' id='$idName'  onchange='$javascript' class='$class form-control'>";

    $cmb .= "<option  value=''>$textSelect</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$pk . "'";
        $cmb .= $selected == $d->$pk ? " selected='selected'" : "";
        $cmb .= ">" . rupper($d->$field) . '</option>';
    }
    $cmb .= "</select>";


    return $cmb;
}

function comboPessoa($name, $javaScript = null, $selected=null, $param = null, $multiple = null, $simples = null) {
    //echo $field;exit;
    $ci = get_instance();

    $sql = "select p.* from dados_unico.pessoa  p
                    inner join dados_unico.pessoa_fisica pf
                        on pf.pessoa_id = p.pessoa_id 
              where p.pessoa_st = 0 " . $param . " order by p.pessoa_nm ";

    //echo_pre($sql);
    $data = $ci->db->query($sql)->result();

    $idName = str_replace("[]", "", $name);
    $class = '';
    if ($simples == null) {
        $class = "select2_single ";
    }

    $cmb = "<select $multiple name='$name' id='$idName' class='$class form-control' tabindex='-1' onchange='$javaScript'>";
    $cmb .= "<option  selected value=''>.:Selecione:.</option>";
    $id = 'pessoa_id';
    $texto = 'pessoa_nm';
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$id . "'";
        $cmb .= $selected == $d->$id ? " selected='selected'" : "";
        $cmb .= ">" . strtoupper($d->$texto) . '</option>';
    }
    $cmb .= "</select>";
    return $cmb;
}

function comboTecnicoIndireta($name, $javaScript = null, $selected=null, $param = null, $multiple = null, $simples = null) {
    //echo $field;exit;
    $ci = get_instance();

    $sql = "select p.* from public.vi_funcionario_perfil  v
		inner join dados_unico.pessoa p
			on p.pessoa_id = v.pessoa_id
	where v.sistema_id = 42
		and v.tipo_usuario_id = 167/*Técnico*/ order by p.pessoa_nm ";

    //echo_pre($sql);
    $data = $ci->db->query($sql)->result();

    $idName = str_replace("[]", "", $name);
    $class = '';


    $cmb = "<select $multiple name='$name' id='$idName' class='$class form-control'  onchange='$javaScript'>";
    $cmb .= "<option  selected value=''>.:Selecione:.</option>";
    $id = 'pessoa_id';
    $texto = 'pessoa_nm';
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$id . "'";
        $cmb .= $selected == $d->$id ? " selected='selected'" : "";
        $cmb .= ">" . strtoupper($d->$texto) . '</option>';
    }
    $cmb .= "</select>";
    return $cmb;
}

function comboTecnicoIndireta_old($name, $javaScript = null, $selected=null, $param = null, $multiple = null, $simples = null) {
    //echo $field;exit;
    $ci = get_instance();

    $sql = "select p.* from dados_unico.pessoa p
                    inner join dados_unico.funcionario f
                            on f.pessoa_id = p.pessoa_id
            where f.funcionario_tipo_id = 148/*ATER - INDIRETA*/
                        and p.pessoa_st = 0 " . $param . " order by p.pessoa_nm ";

    //echo_pre($sql);
    $data = $ci->db->query($sql)->result();

    $idName = str_replace("[]", "", $name);
    $class = '';


    $cmb = "<select $multiple name='$name' id='$idName' class='$class form-control'  onchange='$javaScript'>";
    $cmb .= "<option  selected value=''>.:Selecione:.</option>";
    $id = 'pessoa_id';
    $texto = 'pessoa_nm';
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$id . "'";
        $cmb .= $selected == $d->$id ? " selected='selected'" : "";
        $cmb .= ">" . strtoupper($d->$texto) . '</option>';
    }
    $cmb .= "</select>";
    return $cmb;
}

function comboCronogramaAtividade($name, $javascript, $selected, $param = null) {

    $ci = get_instance();


    $data = $ci->db->query("select * from sigater_indireta.cronograma c 
                                inner join sigater_indireta.atividade a
                                    on a.atividade_id = c.atividade_id
                              where 1=1 " . $param . ' ')->result();

    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript'>";

    $cmb .= "<option  value=''>.:Selecione:.</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->cronograma_id . "'";
        $cmb .= $selected == $d->cronograma_id ? " selected='selected'" : "";
        $cmb .= ">" . $d->atividade_pai_nm . "</option>";
    }
    $cmb .= "</select>";


    return $cmb;
}

function comboMunicipioCronograma($name, $javascript, $selected, $param = null, $multiple = '') {
    if ($multiple == '1' || $multiple == 'multiple' || $multiple == true) {
        $multiple = 'multiple';
    } else {
        $multiple = '';
    }
    $ci = get_instance();

    $sql = "select 
                    distinct
                           
                         m.municipio_nm || ' - Lote: ' || l.lote_nm as municipio_lote
                         ,m.municipio_id   
                        from sigater_indireta.cronograma c
                        inner join sigater_indireta.atividade a
                                on a.atividade_id = c.atividade_id 
                        inner join sigater_indireta.lote l	
                                on l.lote_id = a.lote_id
                        inner join sigater_indireta.lote_municipio lm
                                on l.lote_id = lm.lote_id
                        inner join indice.municipio m
                                on m.municipio_id = lm.municipio_id
                   where 1=1 " . $param . ' ';

    //echo_pre($sql);
    $data = $ci->db->query($sql)->result();

    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select $multiple name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript'>";

    $cmb .= "<option  value=''>.:Selecione:.</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->municipio_id . "'";
        $cmb .= $selected == $d->municipio_id ? " selected='selected'" : "";
        $cmb .= ">" . rupper($d->municipio_lote) . '</option>';
    }
    $cmb .= "</select>";


    return $cmb;
}

function comboTecnico($name, $javascript, $selected, $param = null) {

    $ci = get_instance();
    /*
      $sql = "
      select  'CP.: '||cp.chamada_publica_nm||' - Lote: '||l.lote_nm as chamada_lote, l.*
      from sigater_indireta.entidade_tecnico et
      inner join dados_unico.pessoa p
      on p.pessoa_id = et.pessoa_id and p.pessoa_st =0
      inner join sigater_indireta.entidade e
      on e.entidade_id = et.entidade_id
      inner join sigater_indireta.lote l
      on l.entidade_id = e.entidade_id
      inner join sigater_indireta.chamada_publica cp
      on cp.chamada_publica_id = l.chamada_publica_id
      where et.pessoa_id  = ".$_SESSION['pessoa_id']."  order by cp.chamada_publica_nm, l.lote_nm
      ";
     */
    $sql = " 
        select distinct 'CP.: '||cp.chamada_publica_nm||' - Lote: '||l.lote_nm as chamada_lote, l.lote_id 
           from sigater_indireta.lote_tecnico lt
                    inner join sigater_indireta.lote l
                                       on l.lote_id = lt.lote_id
                               inner join sigater_indireta.chamada_publica cp
                                       on cp.chamada_publica_id = l.chamada_publica_id
                               where l.contrato_num is not null and lt.tecnico_pessoa_id = " . $_SESSION['pessoa_id'];



    //echo_pre($sql);//exit;
    $data = $ci->db->query($sql)->result();

    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select  name='$name' id='$idName'  onchange='$javascript' class='form-control'>";

    $cmb .= "<option  value=''>.:Selecione:.</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->lote_id . "'";
        $cmb .= $selected == $d->lote_id ? " selected='selected'" : "";
        $cmb .= ">" . rupper($d->chamada_lote) . '</option>';
    }
    $cmb .= "</select>";


    return $cmb;
}

function comboFiscal($name, $javascript, $selected, $param = null) {

    $ci = get_instance();

    $sql = "select 'CP.: '||cp.chamada_publica_nm ||' - Lote: '||lote_nm ||' - Contrato: '||contrato_num as chamada_lote, * from sigater_indireta.lote_fiscal lf
                                inner join sigater_indireta.lote l
                                        on l.lote_id = lf.lote_id
                                inner join sigater_indireta.chamada_publica cp
                                        on cp.chamada_publica_id = l.chamada_publica_id 
                            where lf.fiscal_pessoa_id =" . $_SESSION['pessoa_id'] . "            " . $param . ' ';

  //  echo_pre($sql);
    $data = $ci->db->query($sql)->result();

    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript' style='width:95%'>";

    $cmb .= "<option  value=''>.:Selecione:.</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->lote_id . "'";
        $cmb .= $selected == $d->lote_id ? " selected='selected'" : "";
        $cmb .= ">" . $d->chamada_lote . "</option>";
    }
    $cmb .= "</select>";


    return $cmb;
}

function comboPreposto($name, $javascript, $selected, $param = null) {
    
    $ci = get_instance();
    
    $sql = "select 'CP.: '||cp.chamada_publica_nm ||' - Lote: '||lote_nm ||' - Contrato: '||contrato_num as chamada_lote, * from sigater_indireta.lote l
                                inner join sigater_indireta.chamada_publica cp
                                        on cp.chamada_publica_id = l.chamada_publica_id
                            where l.gerente_pessoa_id =" . $_SESSION['pessoa_id'] . "            " . $param . ' ';
    
    //  echo_pre($sql);
    $data = $ci->db->query($sql)->result();
    
    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript' style='width:95%'>";
    
    $cmb .= "<option  value=''>.:Selecione:.</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->lote_id . "'";
        $cmb .= $selected == $d->lote_id ? " selected='selected'" : "";
        $cmb .= ">" . $d->chamada_lote . "</option>";
    }
    $cmb .= "</select>";
    
    
    return $cmb;
}

function comboAtivi2($name, $table, $pk, $javascript, $selected, $param = null, $multiple = '', $texto = '.:Selecione:.', $campos = null) {
    if ($multiple == '1' || $multiple == 'multiple' || $multiple == true) {
        $multiple = 'multiple';
    } else {
        $multiple = '';
    }
    $ci = get_instance();

    $sql = "select * $campos, atividade_pai_cd ||' - '|| atividade_pai_nm as cd_atividade_nm from " . $table . " where 1=1 " . $param . ' ';
    $data = $ci->db->query($sql)->result();

    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select $multiple name='$name' id='$idName' class='select2_single form-control' tabindex='-1' onchange='$javascript'  style='width:100%'>";

    $cmb .= "<option  value=''>$texto</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$pk . "'";
        $cmb .= $selected == $d->$pk ? " selected='selected'" : "";
        $cmb .= ">" . rupper($d->cd_atividade_nm) . '</option>';
    }
    $cmb .= "</select>";


    return $cmb;
}

function comboAtivi2Simples($name, $table, $pk, $javascript, $selected, $param = null, $multiple = '', $texto = '.:Selecione:.', $campos = null) {
    if ($multiple == '1' || $multiple == 'multiple' || $multiple == true) {
        $multiple = 'multiple';
    } else {
        $multiple = '';
    }
    $ci = get_instance();

    $sql = "select * $campos, atividade_pai_cd ||' - '|| atividade_pai_nm as cd_atividade_nm from " . $table . " where 1=1 " . $param . ' ';
    //echo_pre($sql);
    $data = $ci->db->query($sql)->result();

    //se for multiplo, remove o [] do id
    $idName = str_replace("[]", "", $name);
    $cmb = "<select $multiple name='$name' id='$idName' class='form-control' onchange='$javascript'  style='width:100%'>";

    $cmb .= "<option  value=''>$texto</option>";
    foreach ($data as $d) {
        $cmb .= "<option value='" . $d->$pk . "'";
        $cmb .= $selected == $d->$pk ? " selected='selected'" : "";
        $cmb .= ">" . rupper($d->cd_atividade_nm) . '</option>';
    }
    $cmb .= "</select>";


    return $cmb;
}

function retornaMesAnoPosicaoCronograma($chamada_publica_id, $mes) {
    //echo $mes;exit;
    $ci = get_instance();
    $query = "select * from sigater_indireta.chamada_publica where chamada_publica_id = $chamada_publica_id";

    $data = $ci->db->query($query)->row();

    $dataInicio = $data->dt_chamada_ini;
    $dataFim = $data->dt_chamada_fim;
    //echo dbTodata($dataInicio).'-'.dbTodata($dataFim).'<br>';
    //echo 1;exit;
    $dt_i = new DateTime($dataInicio);
    $dt_f = new DateTime($dataFim);


    $mes--;
    $ultima_data = date('Y-m-d', strtotime("+$mes month", strtotime($dataInicio)));

    return ($ultima_data);
}


function calculaPorcentagem($porcentagem, $valor_cheio){
    
    $valor = ($porcentagem * $valor_cheio)/100;
    
    return $valor;
}
