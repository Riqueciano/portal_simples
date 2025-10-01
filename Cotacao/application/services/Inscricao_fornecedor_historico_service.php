<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inscricao_fornecedor_historico_service  extends CI_Model
{
    function __construct()
    {
         
        $this->load->model('Inscricao_fornecedor_historico_model'); 
$this->load->model('Inscricao_fornecedor_model'); 

$this->load->model('Pessoa_model'); 
  
    }

}

/* End of file Inscricao_fornecedor_historico_service.php */
/* Local: ./application/services/Inscricao_fornecedor_historico_service.php */
/* Gerado por RGenerator - 2025-08-01 14:28:31 */