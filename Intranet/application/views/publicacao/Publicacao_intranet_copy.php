<?php include '../template/_begin_intranet.php'; ?> 
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<!-- NEVE DE NATAL
<script type="text/javascript">
	var endereco = "https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/flocoNeve.png";
</script>
<script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/nevando.js"></script>
-->
<div class="row">
<div  class='col-md-8' name='' id=''>
    <div class='x_panel' id=''>
        <div class='x_content'>
            <div style='overflow-x:auto'>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" >
                        
                      <?php
                    //   print_r($publicacao);
                            $i = 0;
                            foreach ($publicacao as $key => $p) {
                                if(!empty($p->publicacao_titulo)){
                                    $active = "";
                                    if($i==0){
                                        $active = "active";
                                    }else{
                                        $active = "";
                                    }
                                    ?>
                                 <div class="item <?= $active ?>" >
                                    <a href="<?=site_url('publicacao/exibir_externo/'.$p->publicacao_id)?>"  > 
                                        <img src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . '_portal' ?>/anexos/anexo_intranet/publicacao/<?=$p->publicacao_img?>" style='width:100%' >
                                        <div class="carousel-caption" style='cursor:pointer;' >
                                            <h3><?=$p->publicacao_titulo?></h3>
                                            <!--p>1111</p-->
                                        </div>
                                    </a>    
                                </div>

                            <?php  
                                $i++;  }
                            }?>
                        
                         
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div  class='col-md-4' name='' id=''> 
        
        <!--lottie-player
            src="https://assets3.lottiefiles.com/packages/lf20_3ISPZJ.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay >
        </lottie-player-->
</div>
<div  class='col-md-4' name='' id=''>
    <div class='x_panel' id=''>
        <div class='x_content'><b><h4>Aniversariantes do mês <a href="<?=site_url('publicacao/list')?>"><i class="fa fa-search" style="color:orangered"></i></a></h4></b>
            <div style='overflow-x:auto'>
                <table class="table" >                    
                    <?php 
                        foreach ($aniversariante_mes_15 as $key => $a) { 
                            if(!empty($a->pessoa_nm)){ ?>
                          <tr >
                                <td style="font-size:10px">
                                <?php 
                                    $class = "";
                                    if((int)$a->dia == (int)date('d')){
                                        $class = "fa fa-birthday-cake ";
                                        $bold_i = "<b style='color:orangered>'>";
                                        $bold_f = "</b>"; 
                                        ?>
                                        <i class="<?=$class?>" style="color:orangered"></i>
                                    <?php }else{  
                                        $bold_i = '';
                                        $bold_f = '';
                                        $css    = '';
                                       echo  $a->dia.'/'.$a->mes;
                                     }
                                ?>                                    
                                </td>
                                <td  style="font-size:10px" >
                                        <?=$bold_i.$a->pessoa_nm.$bold_f?>
                                </td>
                                <td  style="font-size:10px">
                                        <?=$bold_i.$a->est_organizacional_sigla.$bold_f?>
                                </td>
                          </tr>  
                     <?php   }
                         }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
</div>


<?php include '../template/_end.php'; ?>