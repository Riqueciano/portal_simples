<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Solicitante_service  extends CI_Model
{
    function __construct()
    {
         
        $this->load->model('Solicitante_model'); 
$this->load->model('Municipio_model'); 

$this->load->model('Solicitante_tipo_model'); 

$this->load->model('Pessoa_model'); 
  
    }

}

/* End of file Solicitante_service.php */
/* Local: ./application/services/Solicitante_service.php */
/* Gerado por RGenerator - 2025-08-21 20:57:26 */