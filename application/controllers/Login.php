<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
     * Super FTP 
     * Login controller
     * @author Nur Alam Rubel
     * @date 27-05-18
     * 
      */

    public function __construct() 
    {   
        parent::__construct();
        if(!empty($_SESSION['userInfo'])) {
            redirect('ftp');
        }
    }

    public function index() 
    {
        $this->load->view('login/index');
    }

    /**
     * login check function
     * 
     * @return Response
     * @route login-check
      */
    public function loginCheck() 
    {
        $post = $this->input->post();
        /* User select email */
        if(strpos($post['user'],'@') && strpos($post['user'],'.')) {
            $result = $this->user->loginWithEmailUser($post,'email');
            $this->rdrWithMsg($result,'ftp');
        } elseif(!strpos($post['user'],'@')) {
        /* User select username */
            $result = $this->user->loginWithEmailUser($post,'user');
            $this->rdrWithMsg($result,'ftp');
        } else {
        /* Wrong Input */
            $this->session->set_flashdata('msg', ['danger'=>['Wrong Input.']]);
            redirect('login');
        }
    }

    /**
     * redirect with message function
     * 
     * @return Response
     * @reference login-check function
      */
    public function rdrWithMsg($data,$redirect) 
    {
        if(is_array($data)) {
            $data[0]['userFtpAccess'] = explode(',',$data[0]['userFtpAccess']);
            $data[0]['userFtpFileAccess'] = explode(',',$data[0]['userFtpFileAccess']);
            $_SESSION['userInfo'] = $data[0];
            $this->session->set_flashdata('msg', ['success'=>['Login Success.']]);
            redirect($redirect);
        } else {
            $this->session->set_flashdata('msg', ['danger'=>['User & Password Invalid.']]);
            redirect('login');
        }
    }

}