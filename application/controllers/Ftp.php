<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftp extends CI_Controller {

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

	public function index()
	{
        $data['active'] = '';        
        $data['title'] = 'Dashboard | Super FTP';
		$data['ftpContent'] = $this->load->view('ftp/pages/dashboardFtp','',true);
		$data['ftpList'] = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }
    
    /**
     * add ftp page
     * 
     * @return Response
     * @route add-ftp
      */

    public function addFtp() 
    {
        $data['active'] = 'addFtp';
        $data['title'] = 'Add FTP Account | Super FTP';
        $data['ftpContent'] = $this->load->view('ftp/pages/addFtp','',true);
		$data['ftpList'] = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }
    
    /**
     * add ftp account function
     * 
     * @return Response | String 
     * @route add-ftp-account
      */

    public function addFtpAccount() 
    {
        $post = $this->input->post();
        $this->load->library('form_validation');
        if ($this->form_validation->run('ftpAccount') == FALSE) {
            $errors = $this->form_validation->error_array();
            $this->session->set_flashdata('msg', ['danger'=>$errors]);
            redirect('add-ftp');
        } else {
            $post['createDateTime'] = strtotime(date('Y-m-d'));
            $this->ftpM->addFtpAccount($post);
            $this->session->set_flashdata('msg', ['success'=>['FTP Account add success.']]);
            redirect('add-ftp');
        }
    }
    
    /**
     * edit ftp page
     * 
     * @return Response
     * @route edit-ftp
      */

    public function editFtp() 
    {
        $data2['ftps'] = $this->ftpM->getFtpAccounts();
        $data['active'] = 'editFtp';
        $data['title'] = 'Edit FTP Account | Super FTP';
        $data['ftpContent'] = $this->load->view('ftp/pages/editFtp',$data2,true);
		$data['ftpList'] = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }
    
    /**
     * edit ftp account page
     * 
     * $param $id
     * @return Response
     * @route edit-ftp/(:num)
      */

    public function editFtpAccount($id) 
    {
        $data2['ftps'] = $this->ftpM->getFtpAccounts($id);
        $data['active'] = 'editFtp';
        $data['title'] = 'Edit '.$data2['ftps'][0]['ftpName'].' FTP Account | Super FTP';
        $data['ftpContent'] = $this->load->view('ftp/pages/editFtpForm',$data2,true);
		$data['ftpList'] = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }
    
    /**
     * update ftp account function
     * 
     * $param $id
     * @return Response
     * @route update-ftp-account/(:num)
      */

    public function updateFtpAccount($id) 
    {
        $post = $this->input->post();
        $this->load->library('form_validation');
        if ($this->form_validation->run('ftpAccount2') == FALSE) {
            $errors = $this->form_validation->error_array();
            $this->session->set_flashdata('msg', ['danger'=>$errors]);
            redirect('edit-ftp/'.$id);
        } else {
            $this->ftpM->updateFtpAccount($post,$id);
            $this->session->set_flashdata('msg', ['success'=>['FTP Account update success.']]);
            redirect('edit-ftp');
        }
    }
    
    /**
     * delete ftp page
     * 
     * @return Response
     * @route delete-ftp
      */

    public function deleteFtp() 
    {
        $data2['ftps'] = $this->ftpM->getFtpAccounts();
        $data['active'] = 'deleteFtp';
        $data['title'] = 'Delete FTP Account | Super FTP';
        $data['ftpContent'] = $this->load->view('ftp/pages/deleteFtp',$data2,true);
		$data['ftpList'] = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }
    
    /**
     * delete ftp account function
     * 
     * @return Response
     * @route delete-ftp-account
      */

    public function deleteFtpAccount($id) 
    {
        $this->ftpM->deleteFtpAccounts($id);
        $this->session->set_flashdata('msg', ['success'=>['FTP Account delete success.']]);
        redirect('delete-ftp');
    }
        
    /**
     * settings ftp page
     * 
     * @return Response
     * @route settings
      */

    public function settingsFtp() 
    {
        $data['active'] = 'settingsFtp';
        $data['title'] = 'FTP Settings | Super FTP';
        $data['ftpContent'] = $this->load->view('ftp/pages/settingsFtp','',true);
		$data['ftpList'] = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }
        
    /**
     * update settings ftp function
     * 
     * @return Response
      */
    public function updateSettingsFtp() 
    {
        $post = $this->input->post('systemGeneralColor');
        $this->ftpM->updateFtpSettings('systemGeneralColor',$post[0]);
        $this->session->set_flashdata('msg', ['success'=>['FTP setting update success.']]);
        redirect('settings');
    }

    /**
     * ajax request for ftp data
     * 
     * @return Response
      */
    public function getFtpContent() 
    {        
        /* unset previous sesson */
        unset($_SESSION['ftpId']);
        unset($_SESSION['basePath']);
        unset($_SESSION['previousPath']);
        unset($_SESSION['currentPath']);        
        $data['ftpInfo'] = $this->ftpM->getFtpAccountInfo($_POST['id']);
        $data['ftpDir']  = $this->getFtpConnection($data['ftpInfo'],$data['ftpInfo']['ftpPath'],'list'); 
        /* set new session */
        $_SESSION['ftpId'] = $_POST['id'];
        $_SESSION['basePath'] = $data['ftpInfo']['ftpPath'];
        $_SESSION['previousPath'] = $data['ftpInfo']['ftpPath'];
        $_SESSION['currentPath'] = $data['ftpInfo']['ftpPath'];
        $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
        echo $this->jsonMsgReturn(true,'Success',$html);
    }

    public function getFtpContentTwo() 
    {
        /* Create previous path from current path */
        $pre = explode('/',$_POST['path']);
        if($_POST['path'] !== $_SESSION['basePath']) {
            $_SESSION['previousPath'] = implode('/',array_slice($pre,0,-2)).'/';
        } else {
            $_SESSION['previousPath'] = $_SESSION['currentPath'];
        }        
        /* Set current path */
        $_SESSION['currentPath'] = $_POST['path'];
        $data['ftpInfo'] = $this->ftpM->getFtpAccountInfo($_SESSION['ftpId']);
        $data['ftpDir']  = $this->getFtpConnection($data['ftpInfo'],$_POST['path'],'list'); 
        $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
        echo $this->jsonMsgReturn(true,'Success',$html);
    }
    
    /**
     * ftp connection for ajax request
     * 
     * @return ftp directory data
      */
    public function getFtpConnection($ftpData,$path,$dir='list') 
    {
        extract($ftpData);
        $this->load->library('ftp');
        $config['hostname'] = $ftpHost;
        $config['username'] = $ftpUser;
        $config['password'] = $this->encryption->decrypt($ftpPassword);
        $config['debug']    = TRUE;
        $this->ftp->connect($config);
        if($dir == 'list') {
            $list = $this->ftp->list_files($path);
        }         
        $this->ftp->close();
        return $list;
    }

    /**
     * json encode string for ajax request
     * 
     * @return json
      */
    function jsonMsgReturn($type, $msg, $html='')
    {
        echo json_encode(['type'=>$type,'msg'=>$msg,'html'=>$html]);
    }
}
