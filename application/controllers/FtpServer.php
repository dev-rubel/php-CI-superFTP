<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpserver extends CI_Controller {

	/**
     * Super FTP 
     * FtpServer controller
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
        /* load ftp connection laibrary */
        $this->load->library('ftp_connection');
    }

    /**
     * ftpFileEdit function
     * 
     * @return Response
    */
    public function ftpFileEdit()
    {
        $serverName = $this->uri->segment(2);
        $fileName = $this->uri->segment(3);
        /* if folder not exits */        
        if(!is_dir('ftpDir/'.$serverName)) {
            mkdir('ftpDir/'.$serverName,0777,true);            
        } 
        /* create exact path folders */
        $tempPath = 'ftpDir/'.$serverName.'/';
        $paths = explode('/',$_SESSION[$serverName]['currentPath']);           
        foreach($paths as $k=>$path) {
            if(!empty($path)) {
                $tempPath .= $path;
                if(!is_dir($tempPath)) {
                    mkdir($tempPath,0777,true);
                }
                $tempPath .= '/';
            }
        }        
        /* create serverpath and localpath to download file */
        $serverPath = $_SESSION[$serverName]['currentPath'].$fileName;
        $localPath = $tempPath.$fileName;
        $serverId = $_SESSION[$serverName]['ftpId'];
        $data = $this->ftp_connection->getFtpConnection($serverId,$serverPath,'download',$localPath);
        /* load file edit page */
        $data = [
            'file' =>$fileName,
            'path' => $tempPath
        ];
        $data['active'] = '';        
        $data['title'] = $serverName.' | Super FTP';
		$data['ftpContent'] = $this->load->view('ftp/pages/editorPage',$data,true);
		$data['ftpList'] = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }

    /**
     * ajax request for ftp data
     * click on ftp list menu
     * 
     * @return Response
    */
    public function getFtpContent() 
    {
        $data = $this->ftp_connection->getFtpContent($_POST);
        $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
        echo $this->jsonMsgReturn(true,'Success',$html);
    }

    /**
     * ajax request for ftp data
     * click on ftp directory folder
     * 
     * @return Response
    */
    public function getFtpContentInfo() 
    {        
        $data = $this->ftp_connection->getFtpContentInfo($_POST);
        $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
        echo $this->jsonMsgReturn(true,'Success',$html);
    }

    public function test()
    {
        echo $this->jsonMsgReturn(true,'Success',$_FILES);
    }

    public function test2()
    {
        echo $this->jsonMsgReturn(true,'Success',$_POST);
    }

    /**
     * json encode string for ajax request
     * 
     * @return json
    */
    public function jsonMsgReturn($type, $msg, $html='')
    {
        echo json_encode(['type'=>$type,'msg'=>$msg,'html'=>$html]);
    }


}

?>