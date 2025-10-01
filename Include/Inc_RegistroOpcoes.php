

<table border="0" cellpadding="0" cellspacing="0" width="798" height="20">
    <tr class="GridPaginacaoCabecalho">
        <td align="left"><a href="<?=$PaginaLocal?>Cadastrar.php?acaoTitulo=Cadastrar&pagina=<?=$PaginaLocal?>" class="GridPaginacaoRegistroNumRegistro">&nbsp;Novo</a>     
        <?php
        //VERIFICA SE HÁ ALGUM DOCUMENTO CADASTRADO PARA HABILITAR A OPÇÃO DE MARCAR/DESMARCAR TODOS
        if (pg_num_rows($rsConsulta) > 1)
        {
        ?>
            &nbsp;|&nbsp;
            <?php if($_SESSION['Sistemas'][1] != 'Cadastro PJ'){?> 
            <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="Javascript:ExcluirForm(document.Form, document.Form.checkbox);">Excluir</a>
            <?php }else{ ?>
              
            <?php }?>
        </td>
        
            <td align="right"><a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:MarcaCheckbox(document.Form.checkbox);">Marcar Todos</a>
            &nbsp;|&nbsp;
           
            <a href="#" class="GridPaginacaoRegistroNumRegistro" onClick="javascript:DesmarcaCheckbox(document.Form.checkbox);">Desmarcar Todos&nbsp;</a></td>
            

         <?php
        }
        else
        {
        ?>
            &nbsp;|&nbsp;
            <font color="gray">Exluir</font></td>
            <td align="right" style="color:gray">
            Marcar Todos
            &nbsp;|&nbsp;
            Desmarcar Todos&nbsp;</td>
        <?php
        }
        ?>
    </tr>
</table>