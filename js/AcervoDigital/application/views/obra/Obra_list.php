<?php
include '../template/begin.php';

$perfil = $_SESSION['Sistemas'][$_SESSION['sistema']];

$pendencites = 0;
foreach ($obra_data_pendencia as $o) {
    if ($o->flag_aprovacao_autor == 0 or $o->status_id == 1) {
        $pendencites++;
    }
}
//echo $perfil;
if ($perfil == 'Moderador' or $perfil == 'Administrador' or $perfil == 'Gestor') {
    $mensagem_pendencias = 'Existem públicações pendentes';
} else {
    $mensagem_pendencias = 'Existem públicações pendentes, para aprovar click no <i class="glyphicon glyphicon-thumbs-up" style="color:green"></i>';
}

$mensagem_pendencias = 'Existem públicações pendentes';
?> 
<html>
    <head>
        <title>SDR</title>
        <!--link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/-->
        <style>

        </style>
    </head>
    <body>
        <h2 style="margin-top:0px"><?php echo  ($perfil=='Usuário'?'MINHAS PUBLICAÇÕES':'PUBLICAÇÕES')?></h2>
        <?php if ($pendencites > 0) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $mensagem_pendencias ?>
            </div>
        <?php } ?>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php
                if (empty($pessoa->instituicao_autor) and $perfil=='Usuário') {
                    echo anchor(site_url('Usuario/update_complemento/' . $_SESSION['pessoa_id']), 'Incluir Nova Públicação', 'class="btn btn-warning"');
                } else {
                    echo anchor(site_url('obra/create'), 'Incluir Nova Públicação', 'class="btn btn-primary"');
                }
                ?>
            </div>
            <div class="col-md-3 text-center">

                <div style="margin-top: 8px" id="message">
                    <?php
                    if ($perfil == 'Usuário') {
                        echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : '';
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('obra/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php
                            if ($q <> '') {
                                ?>
                                <a href="<?php echo site_url('obra'); ?>" class="btn btn-default">X</a>
                                <?php
                            }
                            ?>
                            <button class="btn btn-primary" type="submit">Procurar</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div style='overflow-x:auto'>
            <table class="table table-striped" style="margin-bottom: 10px">
                <tr>
                    <!--th>No</th-->
                    <td align='' colspan='10' style='background-color:#40BB9A;color:white'><b style='font-size: 15px'> EM PROCESSO</b></td>
                </tr>
                <tr style='background-color:#ECECEC'>
                    <!--th>No</th-->
                    <td align='center' style="width:2%">-</td>
                    <td><b>Título</b></td>
                    <td><b>Autor(es)</b></td>
                    <!--td><b>Instituição</b></td-->
                    <td><b>Tipo</b></td>
                    <td><b>Ano</b></td>
                    <!--td><b>Anexo</b></td-->
                    <td><b>Status </b></td>
                </tr>
                <?php
                foreach ($obra_data_pendencia as $obra) {
                    ?>
                    <tr>
                            <!--td width="80px"><?php echo ++$start ?></td-->
                        <td style="text-align:center" width="100px">
                            <?php
                            if ($perfil == 'Usuário') {
                                //echo anchor(site_url('obra/read/'.$obra->obra_id),' ',"class='glyphicon glyphicon-search' title='Consultar' "); 
                                //echo ' | '; 
                                //echo anchor(site_url('obra/update/'.$obra->obra_id),' ',"class='glyphicon glyphicon-pencil' title='Editar' "); 

                                echo anchor(site_url('obra/read/' . $obra->obra_id), ' ', "class='glyphicon glyphicon-search' title='Consultar' ");
                                //echo ' | ';
                                //echo anchor(site_url('obra/autor_aprova/' . $obra->obra_id), ' ', "class='glyphicon glyphicon-thumbs-up' style='color:green' title='Aprovar' " . ' ' . 'onclick="javasciprt: return confirm(\'Aprovar obra?\')"');
                                //echo ' | ';
                                //echo anchor(site_url('obra/autor_reprova/' . $obra->obra_id), ' ', "class='glyphicon glyphicon-thumbs-down' style='color:red' title='Reprovar' " . ' ' . 'onclick="javasciprt: return confirm(\'Reprovar obra?\')"');
                            } else {
                                echo anchor(site_url('obra/read_aprovacao/' . $obra->obra_id), ' ', "class='glyphicon glyphicon-search' title='Aprovar/Reprovar' ");
                            }

                            //echo ' | '; 
                            //
				 ?>
                        </td>
                        <td><?php echo $obra->obra_titulo ?></td>
                        <td>
                            <?php 
                            $autores  = $obra->pessoa_nm;
                            $autores .= empty($obra->coautor1)?'': ', '.$obra->coautor1;
                            $autores .= empty($obra->coautor2)?'': ', '.$obra->coautor2;
                            $autores .= empty($obra->coautor3)?'': ', '.$obra->coautor3;
                            $autores .= empty($obra->coautor4)?'': ', '.$obra->coautor4;
                            echo $autores;  
                           ?>
                        </td>
                        <td><?php echo $obra->obra_tipo_nm ?></td> 
                        <td><?php echo $obra->ano ?></td> 
                        <td>
                            <b>
                                    <?php 


                                    //1;"Aguardando Aprovação"
                                    //3;"Reprovado"
                                    //2;"OK"
                                    //----------------
                                    //flag_aprovacao_autor

                                    //se for 2, a cepex ja autorizou
                                    if($obra->status_id == 2 and $obra->flag_aprovacao_autor == 0){
                                        echo "Aguardando Autorização do Autor";
                                    }else if($obra->status_id == 3 and $obra->flag_aprovacao_autor == 0){
                                        echo "Publicação cancelada";
                                    }else if($obra->status_id == 1 and $obra->flag_aprovacao_autor == 2){
                                        echo "Aguardando Autorização da CEPEX";
                                    }else if($obra->status_id == 1 and $obra->flag_aprovacao_autor == 1){
                                        echo "Aguardando Autorização da CEPEX";
                                    }
                                ?>
                            </b>    
                        </td>

                    </tr>
                    <?php
                }
                ?>
            
                <tr>
                    <!--th>No</th-->
                    <td align='' colspan='10' style='background-color:#40BB9A;color:white'> <b style='font-size:15px'> <?php echo  ($perfil=='Usuário'?'MINHAS PUBLICAÇÕES':'PUBLICAÇÕES')?></b></td>

                </tr>
                <tr style='background-color:#ECECEC'>
                    <!--th>No</th-->
                    <td align='center' >-</td>
                    <td><b>Título</b></td>
                    <td><b>Autor</b></td>
                    <td><b>Tipo</b></td>
                    <td><b>Ano</b></td>
                    <td style="width:10%"><b>Status</b></th>
                </tr>
                <?php
                foreach ($obra_data_ok as $obra) {
                    ?>
                    <tr>
                            <!--td width="80px"><?php echo ++$start ?></td-->
                        <td style="text-align:center" width="100px">
                            <?php
                            if ($perfil == 'Usuário') {
                                //echo anchor(site_url('obra/read/'.$obra->obra_id),' ',"class='glyphicon glyphicon-search' title='Consultar' "); 
                                //echo ' | '; 
                                //echo anchor(site_url('obra/update/'.$obra->obra_id),' ',"class='glyphicon glyphicon-pencil' title='Editar' "); 

                                echo anchor(site_url('obra/read/' . $obra->obra_id), ' ', "class='glyphicon glyphicon-search' title='Consultar' ");
                                //echo ' | ';
                                //echo anchor(site_url('obra/autor_aprova/' . $obra->obra_id), ' ', "class='glyphicon glyphicon-thumbs-up' style='color:green' title='Aprovar' " . ' ' . 'onclick="javasciprt: return confirm(\'Aprovar obra?\')"');
                                //echo ' | ';
                                //echo anchor(site_url('obra/autor_reprova/' . $obra->obra_id), ' ', "class='glyphicon glyphicon-thumbs-down' style='color:red' title='Reprovar' " . ' ' . 'onclick="javasciprt: return confirm(\'Reprovar obra?\')"');
                            } else {
                                echo anchor(site_url('obra/read_aprovacao/' . $obra->obra_id), ' ', "class='glyphicon glyphicon-search' title='Aprovar/Reprovar' ");
                            }

                            //echo ' | '; 
                            //
				 ?>
                        </td>
                        <td><?php echo $obra->obra_titulo ?></td>
                        <td><?php echo $obra->pessoa_nm ?></td>
                        <td><?php echo $obra->obra_tipo_nm ?></td>
                        <td><?php echo $obra->ano ?></td>
                        
                        <td>
                        <?php 
                        
                        
                        //1;"Aguardando Aprovação"
                        //3;"Reprovado"
                        //2;"OK"
                        //----------------
                        //flag_aprovacao_autor

                        //se for 2, a cepex ja autorizou
                        if($obra->status_id == 2 and $obra->flag_aprovacao_autor == 0){
                            echo "Aguardando Autorização do Autor";
                        }else if($obra->status_id == 3 and $obra->flag_aprovacao_autor == 0){
                            echo "Publicação cancelada";
                        }else if($obra->status_id == 1 and $obra->flag_aprovacao_autor == 2){
                            echo "Aguardando Autorização da CEPEX";
                        }else if($obra->status_id == 1 and $obra->flag_aprovacao_autor == 1){
                            echo "Aguardando Autorização da CEPEX";
                        }else if($obra->status_id == 2 and $obra->flag_aprovacao_autor == 1){
                            echo "Publicado";
                        }?>
                        
                        </td>
                    


                        
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <div class="row">
            <!--div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Linhas: <?php echo $total_rows ?></a>
            </div-->
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </body>
</html>
<?php include '../template/end.php'; ?>