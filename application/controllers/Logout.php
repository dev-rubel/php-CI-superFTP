<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	/**
     * Super FTP 
     * Logout controller
     * @author Nur Alam Rubel
     * @date 27-05-18
     * 
      */

    public function index() 
    {
        unset($_SESSION['userInfo']);
        session_destroy();
        redirect('login');
    }


}