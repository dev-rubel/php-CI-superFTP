<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    /**
     * Super FTP 
     * Ftp controller
     * @author Nur Alam Rubel
     * @date 27-05-18
     * 
      */

      public function __construct() 
      {   
          parent::__construct();
          if(empty($_SESSION['userInfo'])) {
              redirect('login');
          }
      }
      
	/**
     * add user page
     * 
     * @return Response
     * @route add-user
      */
	public function addUserFtp()
	{
        $data2['ftps'] = $this->ftpM->getFtpAccounts();
        $data['active'] = 'addUserFtp';
        $data['title'] = 'Add User | Super FTP';
		$data['ftpContent'] = $this->load->view('user/addUserFtp',$data2,true);
		$data['ftpList'] = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }
      
	/**
     * add user ftp account function
     * 
     * @return Response
     * @route add-user-account
      */
	public function addUserFtpAccount()
	{
        $post = $this->input->post();
        $this->load->library('form_validation');
        if($post['userDesignation'] == 1 || $post['userDesignation'] == '') { 
            /* Add admin account */
            if ($this->form_validation->run('ftpUserAdminAccount') == FALSE) {
                $errors = $this->form_validation->error_array();
                $this->session->set_flashdata('msg', ['danger'=>$errors]);
                redirect('add-user');
            } else {
                $post['userFtpAccess'] = 'all';
                $post['userFtpFileAccess'] = 'all';
                $post['datetime'] = strtotime(date('Y-m-d'));
                $this->user->addUserAccount($post);
                $this->session->set_flashdata('msg', ['success'=>['User Account add success.']]);
                redirect('add-user');                
            }
        } elseif($post['userDesignation'] == 2) { 
            /* Add user account */
            if ($this->form_validation->run('ftpUserUserAccount') == FALSE) {
                $errors = $this->form_validation->error_array();
                $this->session->set_flashdata('msg', ['danger'=>$errors]);
                redirect('add-user');
            } else {
                $post['userFtpAccess'] = implode(',',$post['userFtpAccess']);
                $post['userFtpFileAccess'] = implode(',',$post['userFtpFileAccess']);
                $post['datetime'] = strtotime(date('Y-m-d'));
                $this->user->addUserAccount($post);
                $this->session->set_flashdata('msg', ['success'=>['User Account add success.']]);
                redirect('add-user');  
            }
        } else {
            $this->session->set_flashdata('msg', ['danger'=>['Unknown Error!!']]);
            redirect('add-user');
        }       
    }

	/**
     * edit user account page
     * 
     * @return Response
     * @route edit-user/(:num)
      */
	public function editUserFtpAccount($id)
	{
        $data2['ftps'] = $this->ftpM->getFtpAccounts();
        $data2['users'] = $this->user->getUserAccounts($id);
        $data['active'] = 'manageUserFtp';
        $data['title'] = 'Edit User Account | Super FTP';
		$data['ftpContent'] = $this->load->view('user/editUserAccount',$data2,true);
		$data['ftpList'] = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }

	/**
     * update user account function
     * 
     * @return Response
     * @route update-user-account/(:num)
      */
	public function updateUserFtpAccount($id)
	{
        $post = $this->input->post();
        $this->load->library('form_validation');
        if($post['userDesignation'] == 1 || $post['userDesignation'] == '') { 
            /* Add admin account */
            if ($this->form_validation->run('ftpUserAdminAccount') == FALSE) {
                $errors = $this->form_validation->error_array();
                $this->session->set_flashdata('msg', ['danger'=>$errors]);
                redirect('add-user');
            } else {
                $post['userFtpAccess'] = 'all';
                $post['userFtpFileAccess'] = 'all';
                $post['datetime'] = strtotime(date('Y-m-d'));
                $this->user->updateUserAccount($post,$id);
                $this->session->set_flashdata('msg', ['success'=>['User Account update success.']]);
                redirect('edit-user/'.$id);
            }
        } elseif($post['userDesignation'] == 2) { 
            /* Add user account */
            if ($this->form_validation->run('ftpUserUserAccount') == FALSE) {
                $errors = $this->form_validation->error_array();
                $this->session->set_flashdata('msg', ['danger'=>$errors]);
                redirect('add-user');
            } else {
                $post['userFtpAccess'] = implode(',',$post['userFtpAccess']);
                $post['userFtpFileAccess'] = implode(',',$post['userFtpFileAccess']);
                $post['datetime'] = strtotime(date('Y-m-d'));
                $this->user->updateUserAccount($post,$id);
                $this->session->set_flashdata('msg', ['success'=>['User Account update success.']]);
                redirect('edit-user/'.$id);
            }
        } else {
            $this->session->set_flashdata('msg', ['danger'=>['Unknown Error!!']]);
            redirect('add-user');
        }    
    }

	/**
     * delete user account function
     * 
     * @return Response
     * @route delete-user-account/(:num)
      */
	public function deleteUserFtpAccount($id)
	{
        $this->user->deleteUserAccounts($id);
        $this->session->set_flashdata('msg', ['success'=>['User Account delete success.']]);
        redirect('manage-user');
    }

	/**
     * manage user page
     * 
     * @return Response
     * @route manage-user
      */
	public function manageUserFtp()
	{
        $data2['users'] = $this->user->getUserAccounts();
        $data['active'] = 'manageUserFtp';
        $data['title'] = 'Manage User | Super FTP';
		$data['ftpContent'] = $this->load->view('user/manageUserFtp',$data2,true);
		$data['ftpList'] = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }

	/**
     * user profile page
     * 
     * @return Response
     * @route user-profile
      */
	public function userProfile()
	{
        $data2['users'] = $_SESSION['userInfo'];
        $data['active'] = 'manageUserFtp';
        $data['title'] = 'User Profile | Super FTP';
		$data['ftpContent'] = $this->load->view('user/userProfile',$data2,true);
		$data['ftpList'] = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }

	/**
     * update user profile function
     * 
     * @return Response
     * @route update-user-account-info
      */
	public function userProfileUpdate()
	{
        $post = $this->input->post();
        /* For security parpas */
        if(isset($post['userName']) || isset($post['userEmail'])) {
            unset($post['userName']);
            unset($post['userEmail']);
        }
        $this->load->library('form_validation');
        if(!isset($post['changePassword'])) {
            if ($this->form_validation->run('ftpUserUpdateAccountWithoutPassword') == FALSE) {
                $errors = $this->form_validation->error_array();
                $this->session->set_flashdata('msg', ['danger'=>$errors]);
                redirect('user-profile');
            } else {
                $data = [
                    'userFullName' => $post['userFullName']
                ];
                $this->user->updateUserInfo($data,$_SESSION['userInfo']['id'],false);
                $this->session->set_flashdata('msg', ['success'=>['Account information update success.']]);
                redirect('ftp');
            }            
        } else {
            if ($this->form_validation->run('ftpUserUpdateAccountWithPassword') == FALSE) {
                $errors = $this->form_validation->error_array();
                $this->session->set_flashdata('msg', ['danger'=>$errors]);
                redirect('user-profile');
            } else {
                $data = [
                    'userFullName' => $post['userFullName'],
                    'userPassword' => $post['userConfPassword'],
                ];
                $this->user->updateUserInfo($data,$_SESSION['userInfo']['id'],true);
                $this->session->set_flashdata('msg', ['success'=>['Account information update success.']]);
                redirect('ftp');
            }
        }
        
    }

    public function oldpassword_check($oldPassword) 
    {
        if($this->user->checkOldPassword($_SESSION['userInfo']['id'],$oldPassword)) {
            return true;
        } else {
            $this->form_validation->set_message('oldpassword_check', '{field} are not match.');
            return false;
        }
    }
    
}
