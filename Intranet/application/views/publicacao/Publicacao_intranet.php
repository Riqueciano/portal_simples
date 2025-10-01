<?php include '../template/_begin_intranet.php'; ?>

<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<!-- NEVE DE NATAL
<script type="text/javascript">
	var endereco = "https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/flocoNeve.png";
</script>
<script src="https://<?= $_SERVER['HTTP_HOST'] . '/' . $nmServer ?>/JavaScript/nevando.js"></script>
-->
<div class="row">
    <div class='col-md-8' name='' id=''>
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
                        <div class="carousel-inner">

                            <?php
                            //   print_r($publicacao);
                            $i = 0;
                            foreach ($publicacao as $key => $p) {
                                if (!empty($p->publicacao_titulo)) {
                                    $active = "";
                                    if ($i == 0) {
                                        $active = "active";
                                    } else {
                                        $active = "";
                                    }
                            ?>
                                    <div class="item <?= $active ?>">
                                        <a href="<?= site_url('publicacao/exibir_externo/' . $p->publicacao_id) ?>">
                                            <img src="https://<?php echo $_SERVER['HTTP_HOST'] . '/' . '_portal' ?>/anexos/anexo_intranet/publicacao/<?= $p->publicacao_img ?>" style='width:100%'>
                                            <div class="carousel-caption" style='cursor:pointer;'>
                                                <h3><?= $p->publicacao_titulo ?></h3>
                                                <!--p>1111</p-->
                                            </div>
                                        </a>
                                    </div>

                            <?php
                                    $i++;
                                }
                            } ?>


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

    <div class='col-md-4' name='' id=''>

        <!--lottie-player
            src="https://assets3.lottiefiles.com/packages/lf20_3ISPZJ.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay >
        </lottie-player-->
    </div>
    <div class='col-md-4' name='' id=''>
        <div class='x_panel' id=''>
            <div class='x_content'><b>
                    <h4>Aniversariantes do mês <a href="#" title='Exibir todos aniversáriantes do mês'><i class="fa fa-search" style="color:orangered"></i></a></h4>
                </b>
                <div style='overflow-x:auto'>
                    <table class="table">
                        <tr>
                            <th style="">
                                Data
                            </th>
                            <th style="">
                                Aniversariante
                            </th>
                            <th style="">
                                Lotação
                            </th>
                        </tr> 
                        <!-- <tr>
                            <td><small><b class=""> 08/12 
                                <img 
                                style="width: 28px;"
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSkj26iVtrVE0-GD8UUJjjZ1CzjU1hzBt7w1VDHYKKCbMBgk_xcvDZmOLuVy1w3WmjNduw&usqp=CAU" alt="">
                            </b></small></td>
                            <td><small><b class="">IRACEMA CONCEIÇÃO SILVA PRATA</b></small></td>
                            <td><small><b class="">SDR/GAB/DG/DA/CEO</b></small></td>
                        </tr>  
                        <tr>
                            <td><small><b class="red"> 05/12  
                                <img 
                                style="width: 28px;"
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSkj26iVtrVE0-GD8UUJjjZ1CzjU1hzBt7w1VDHYKKCbMBgk_xcvDZmOLuVy1w3WmjNduw&usqp=CAU" alt="">
                            </b></small></td>
                            <td><small><b class="">ÂNGELA CRISTINA DOS SANTOS TORRES</b></small></td>
                            <td><small><b class="">SDR/GAB/DG/DA/CSG</b></small></td>
                        </tr>  -->
                        <?php
                        foreach ($aniversariante_mes_15 as $key => $a) {
                            if (!empty($a->pessoa_nm)) { ?>  
                                <tr style="">
                                    <td style="font-size:10px">
                                        <?php

                                        if ((int)$a->dia == (int)date('d')) {
                                            $class = "fa fa-birthday-cake ";
                                            $bold_i = "<b style='color:orangered>'>";
                                            $bold_f = "</b>";
                                            echo  $a->dia . '/' . $a->mes;
                                        } else {
                                            $class = "";
                                            $bold_i = '';
                                            $bold_f = '';
                                            $css    = '';
                                            echo  $a->dia . '/' . $a->mes;
                                        }
                                        ?>
                                    </td>
                                    <td style="font-size:10px">
                                        <i class="<?= $class ?>" style="color:orangered"></i> <?= $bold_i . $a->pessoa_nm . $bold_f ?>
                                    </td>
                                    <td style="font-size:10px">
                                        <?= $bold_i . $a->upper . $bold_f ?>
                                    </td>
                                </tr>
                        <?php   }
                        }
                        ?>
                    </table>
                </div>
                <div id="modal-aniversariantes" class="modal-container">
                    <div class="modal">
                        <button class="fechar">x</button>
                        <!-- modal -->
                        <h2 style="text-align: center">Aniversariantes do mês</h2>
                        <div style='overflow-x:auto'>
                            <table class="table">
                                <th style="">
                                    Data
                                </th>
                                <th style="">
                                    Aniversariante
                                </th>
                                <th style="">
                                    Lotação
                                </th>
                                <th style="">
                                    E-mail
                                </th>
                                <?php
                                foreach ($aniversariante_mes as $key => $a) {
                                    if (!empty($a->pessoa_nm)) { ?>
                                        <tr style="">
                                            <td style="font-size:10px">
                                                <?php
                                                if ((int)$a->dia == (int)date('d')) {
                                                    $class = "fa fa-birthday-cake ";
                                                    $bold_i = "<b style='color:orangered>'>";
                                                    $bold_f = "</b>";
                                                    echo  $a->dia . '/' . $a->mes;
                                                } else {
                                                    $bold_i = '';
                                                    $bold_f = '';
                                                    $css    = '';
                                                    $class = "";
                                                    echo  $a->dia . '/' . $a->mes;
                                                }
                                                ?>
                                            </td>
                                            <td style="font-size:10px">
                                                <i class="<?= $class ?>" style="color:orangered"></i> <?= $bold_i . $a->pessoa_nm . $bold_f ?>
                                            </td>
                                            <td style="font-size:10px">
                                                <?= $bold_i . $a->upper . $bold_f ?>
                                            </td>
                                            <td style="font-size:10px">
                                                <?= rupper($a->funcionario_email) ?>
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
    </div>
</div>

<style>
    .modal-container {
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, .5);
        position: fixed;
        top: 0px;
        left: 0px;
        z-index: 2000;
        display: none;
        justify-content: center;
        align-items: center;
    }

    .modal-container.mostrar {
        display: flex;
    }

    .modal {
        background: white;
        width: 60%;
        min-width: 300px;
        padding: 40px;
        /* border: 10px solid #988b7a; */
        box-shadow: 0 0 0 10px white;
        position: relative;
    }

    @keyframes modal {
        from {
            opacity: 0;
            transform: translate3d(0, -60px, 0);
        }

        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    .mostrar .modal {
        animation: modal .3s;
        overflow: auto;
        height: 545px;
        display: block;
    }

    .fechar {
        position: absolute;
        font-size: 1.2em;
        top: 0px;
        right: 0px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 4px solid white;
        background: #9999;
        color: white;
        font-family: "PT Mono", monospace;
        cursor: pointer;
        box-shadow: 0 4px 4px 0 rgba(0, 0, 0, .3);
    }
</style>

<script type="text/javascript">
    const search = document.querySelector('.fa-search');
    search.addEventListener('click', () => iniciaModal('modal-aniversariantes'));
    console.log(search);
    document.addEventListener('scroll', () => {
        if (window.pageYOffset > 800) {
            iniciaModal('modal-aniversariantes')
        }
    })

    function iniciaModal(modalID) {

        // const modal = document.getElementById(modalID);
        // console.log(modal)


        const modal = document.getElementById(modalID);
        if (modal) {
            modal.classList.add('mostrar');
            console.log(modal)
            modal.addEventListener('click', (e) => {
                if (e.target.id == modalID || e.target.className == 'fechar') {
                    modal.classList.remove('mostrar');
                    localStorage.fechaModal = modalID;
                }
            });
        }

    }
</script>

<?php include '../template/_end.php'; ?>