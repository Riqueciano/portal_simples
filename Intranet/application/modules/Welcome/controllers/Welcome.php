<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct(); 
        $this->load->library('form_validation');
    }

    public function index() { //echo 1;exit;
       
        //redirect(site_url('planejamento/acompanhamento/'));
        $this->load->view('welcome_message');
        //$this->load->view('welcome_message');
    }


}
