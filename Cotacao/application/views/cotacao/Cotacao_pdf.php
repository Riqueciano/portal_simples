 <div id="conteudo_pagina" class="avoid-break">

     <div class="col-md-12">
         <div class="x_panel">
             <div class="x_content">
                 <div style="overflow-x:auto">
                     <table class="table">
                         <tr>
                             <td>
                                 <img src="<?= iPATH ?>/imagens/Topo/bg_logo_estado_pb.jpg" alt="" style="width: 70px;">
                             </td>
                             <td>
                                 <b style="font-size: 13px;">
                                     GOVERNO DO ESTADO DA BAHIA <br>
                                     Secretaria do Meio Ambiente - SEMA <br>
                                     SUPERINTENDÊNCIA DE AGRICULTURA FAMILIAR - SUAF
                                 </b>
                             </td>
                         </tr>
                     </table>

                     <br><br>
                     <?= AVISO_TESTE ?>
                     <h2 style="margin-top:0px">
                         <span id="spanAcaoForm"><i class="glyphicon glyphicon-chevron-right"></i> Cotação</span>
                     </h2>

                     <table border="0" style="width: 100%">
                         <tr>
                             <td style="width: 50%">
                                 <table class="table">
                                     <tr>
                                         <td style="width: 10%"><label for="integer">Nº Cotação </label></td>
                                         <td><b class="green"><?= $cotacao->cotacao_numero ?></b></td>
                                     </tr>
                                     <tr style="display: <?= empty($solicitado_para_pessoa->pessoa_nm) ? 'none' : '' ?>;">
                                         <td><label for="integer">Entidade </label></td>
                                         <td><b class="green"><?= empty($solicitado_para_pessoa->pessoa_nm) ? '' : primeiraMaiuscula($solicitado_para_pessoa->pessoa_nm) ?></b></td>
                                     </tr>
                                     <tr style="display: <?= empty($solicitado_para_pessoa->pessoa_nm) ? 'none' : '' ?>;">
                                         <td><label for="integer">CNPJ/CPF </label></td>
                                         <td><b class="green"><?= empty($solicitado_para_pessoa->pessoa_cnpj) ? '' : $solicitado_para_pessoa->pessoa_cnpj ?></b></td>
                                     </tr>
                                     <tr style="display: <?= empty($solicitado_para_pessoa->pessoa_nm) ? '' : 'none' ?>;">
                                         <td><label for="integer">CNPJ/CPJ </label></td>
                                         <td><b class="green"><?= $pessoa_cnpj . ' / ' . $pessoa_fisica_cpf ?></b></td>
                                     </tr>
                                     <tr>
                                         <td><label for="integer">Solicitante </label></td>
                                         <td><b class="green"><?= $pessoa_nm ?></b></td>
                                     </tr>
                                     <tr>
                                         <td><label for="cotacao_ds">Descrição </label></td>
                                         <td><?= $cotacao_ds ?></td>
                                     </tr>
                                 </table>
                             </td>
                             <td align="center">
                                 <div style="border: 1px solid black; width: 160px">
                                     <b style="text-align: center; padding-top: 5px;">Validador</b>
                                     <div style="margin-bottom:10px;">
                                         <img src="<?= saveImageFromUrlReturnUrl(site_url('cotacao/cotacao_validador/' . $cotacao->cotacao_id)) ?>" alt="" style="max-height:150px;">
                                     </div>
                                 </div>

                             </td>
                         </tr>
                     </table>

                 </div>
             </div>
         </div>
     </div>

     <?php
        $max_itens_por_tabela = 10;
        $total_itens = count($cotacao_media);
        $soma = 0;

        foreach ($cotacao_media as $i => $cm) {
            // Quebra de página antes de nova tabela (exceto a primeira)
            if ($i % $max_itens_por_tabela == 0) {
                if ($i != 0) {
                    echo '<div class="page-break"></div>';
                }

                if ($i == 0) {
                    // echo '<div style="margin-bottom:10px;">
                    //         <img src="' . saveImageFromUrlReturnUrl(site_url('cotacao/cotacao_validador/' . $cotacao->cotacao_id)) . '" alt="" style="max-height:150px;">
                    //       </div>';
                }

                echo '<table class="table" border="1" style="width: 100%;">
                    <tr>
                        <th style="background-color: #ededed; width: 20px">Cod</th>
                        <th style="background-color: #ededed;">Produto</th>
                        <th style="background-color: #ededed; width: 40px">Preço médio (R$)</th>
                    </tr>';
            }
        ?>

         <tr>
             <td align="center" class="fonte-menor"><?= $cm->produto_id ?></td>
             <td align="center" class="fonte-menor">
                 <b><?= primeiraMaiuscula($cm->produto_nm_completo) ?></b><br>
                  <?= primeiraMaiuscula($cm->produto_ds) ?> 
             </td>
             <td align="center" class="fonte-menor"><?= number_format($cm->valor_medio, 2, ',', '.') ?></td>
         </tr>

         <?php
            $soma += (float)$cm->valor_medio;

            $ultimo_item = ($i + 1 == $total_itens);
            $fim_da_tabela = (($i + 1) % $max_itens_por_tabela == 0 || $ultimo_item);

            if ($fim_da_tabela) {
                if ($ultimo_item) {
                    /*echo '<tr style="background-color: #ededed">
                        <td colspan="2" align="center"><b>Total</b></td>
                        <td align="center"><b>' . number_format($soma, 2, ',', '.') . '</b></td>
                      </tr>';*/
                }
                echo '</table>';
            }
        }


        echo '
<br><br>
<table class="table" border="1" style="width: 100%">
            <tr>
                <td colspan="8" style="border: none" align="center"><b>
                    <h2>Detalhamento dos Fornecedores</h2>
                </b></td>
            </tr>
             <tr style="background-color: #ededed">
                <th style="width: 20px">-</th>
                <th>Fornecedor</th>
                <th>Documento</th>
                <th>Categoria</th>
                <th>Municipio</th>
                <th>Território</th>
                <th>Endereço</th>
                <th>E-email</th>
            </tr>';
        foreach ($fornecedores_desta_cotacao as $index => $fdc) {

            //exibi CNPJ, senao CPF
            $cnpj_cpf = !empty($fdc->pessoa_cnpj) ? 'CNPJ: <br>' . $fdc->pessoa_cnpj : 'CPF: <br>' . $fdc->pessoa_fisica_cpf;
            echo '<tr>
                    <td class="fonte-menor">' . ($index + 1) . '</td>
                    <td class="fonte-menor"> ' . primeiraMaiuscula($fdc->pessoa_nm) . '</td>
                    <td class="fonte-menor" align="center">' . $cnpj_cpf . '</td>
                    <td class="fonte-menor">' . primeiraMaiuscula($fdc->fornecedor_categoria_nm) . '</td>
                    <td class="fonte-menor">' . primeiraMaiuscula($fdc->municipio_nm) . '</td>
                    <td class="fonte-menor">' . primeiraMaiuscula($fdc->territorio_nm) . '</td>
                    <td class="fonte-menor">' . primeiraMaiuscula($fdc->fornecedor_endereco) . '</td>
                    <td class="fonte-menor">' . rlower($fdc->funcionario_email) . '</td>
             </tr>';
        }
        echo '</table>
<br><br>';






        $max_linhas_por_tabela = 5;
        $total_itens = count($produto_preco_cotacao);

        // echo '<div class="page-break"></div>'; // quebra antes de começar essa seção


        $i = 0;
        foreach ($produto_preco_cotacao as $ppc) {

            // nova tabela a cada X linhas
            if ($i % $max_linhas_por_tabela == 0) {
                if ($i > 0) {
                    echo '</table><div class="page-break"></div>';
                }

                echo '<br>
        <table class="table" border="1" style="width: 100%">
            <tr>
                <td colspan="7" style="border: none" align="center"><b>
                    <h2>Detalhamento do Itens da Cotação</h2>
                </b></td>
            </tr>
            <tr style="background-color: #ededed">
                <th style="width: 20px">Cod</th>
                <th>Produto</th>
                <th>Fornecedor</th>
                <th>DAP/CAF</th>
                <th>Município</th>
                <th>Território</th>
                <th>Valor</th>
            </tr>';
            }
            ?>
         <tr>
             <td><?= $ppc->produto_id ?></td>
             <td><b><?= primeiraMaiuscula($ppc->produto_nm_completo) ?></b></td>
             <td>
                 <table style="font-size: 10px;">
                     <tr>
                         <td class="fonte-menor"><b>Fornecedor</b></td>
                         <td class="fonte-menor"><?= primeiraMaiuscula($ppc->pessoa_nm) ?></td>
                     </tr>
                     <tr>
                         <td class="fonte-menor"><b>Tipo</b></td>
                         <td class="fonte-menor"><?= !empty($ppc->pessoa_cnpj) ? 'Pessoa Jurídica' : 'Pessoa Física' ?></td>
                     </tr>
                     <tr style="display: <?= !empty($ppc->pessoa_cnpj) ? '' : 'none' ?>;">
                         <td class="fonte-menor"><b>CNPJ</b></td>
                         <td class="fonte-menor"><?= $ppc->pessoa_cnpj ?></td>
                     </tr>
                     <tr style="display: <?= !empty($ppc->pessoa_fisica_cpf) ? '' : 'none' ?>;">
                         <td class="fonte-menor"><b>CPF</b></td>
                         <td class="fonte-menor"><?= $ppc->pessoa_fisica_cpf ?></td>
                     </tr>
                 </table>
             </td>
             <td class="fonte-menor"><?= $ppc->pessoa_dap ?></td>
             <td class="fonte-menor"><?= primeiraMaiuscula($ppc->municipio_nm) ?></td>
             <td class="fonte-menor"><?= primeiraMaiuscula($ppc->territorio_nm) ?></td>
             <td align="right" class="fonte-menor">R$ <?= number_format($ppc->valor, 2, ',', '.') ?></td>
         </tr>
     <?php
            $i++;
        }



        // fechar a última tabela
        if ($total_itens > 0) {
            echo '</table>';
        }
        ?>


     <br><br>
     <small class="texto_pequeno">*Esta cotação tem validade de <?= DIAS_VALIDADE_PRECO ?> dias a partir da data de sua criação <?= dbToData($cotacao_dt) ?>.</small><br>
     <small class="texto_pequeno">*Válido até <?= dbToData(date('Y-m-d', strtotime("$cotacao_dt + " . DIAS_VALIDADE_PRECO . " days"))) ?></small>
 </div>

 <!-- Estilos -->
 <style>
     .fonte-menor {
         font-size: 11px;
     }


     .texto_pequeno {
         font-size: 12px;
     }

     .table {
         font-size: 11px;
         border-collapse: collapse;
         page-break-inside: auto;
         break-inside: avoid;
     }

     td,
     th {
         padding: 3px;
         page-break-inside: avoid !important;
         break-inside: avoid !important;
         word-wrap: break-word;
     }

     .page-break {
         page-break-before: always;
         break-before: page;
     }

     .avoid-break {
         page-break-inside: avoid;
         break-inside: avoid;
     }

     .table tr {
         page-break-inside: avoid;
     }
 </style>

 <!-- Scripts -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
 <script>
     function convertToPDF() {
         const element = document.getElementById('conteudo_pagina');

         const options = {
             margin: [10, 10, 10, 10],
             filename: 'cotacao.pdf',
             image: {
                 type: 'jpeg',
                 quality: 1.0
             },
             html2canvas: {
                 scale: 2,
                 useCORS: true
             },
             jsPDF: {
                 unit: 'mm',
                 format: 'a4',
                 orientation: 'portrait'
             },
             pagebreak: {
                 mode: ['css', 'legacy'],
                 before: '.page-break'
             }
         };

         html2pdf()
             .set(options)
             .from(element)
             .toPdf()
             .get('pdf')
             .then(function(pdf) {
                 const totalPages = pdf.internal.getNumberOfPages();
                 for (let i = 1; i <= totalPages; i++) {
                     pdf.setPage(i);
                     pdf.setFontSize(10);
                     pdf.text(
                         'Sistema de Consulta e Cotação de Produtos SDR -  pág ' + i + ' de ' + totalPages,
                         pdf.internal.pageSize.getWidth() / 2,
                         pdf.internal.pageSize.getHeight() - 5, {
                             align: 'center'
                         }
                     );
                 }

                 const blob = pdf.output('blob');
                 const url = URL.createObjectURL(blob);
                 window.open(url, '_self');
             });
     }

     setTimeout(convertToPDF, 10);
 </script>