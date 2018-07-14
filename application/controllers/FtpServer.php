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
        $this->load->library('ftpconnection');
    }

    /**
     * ftpFileDownload function
     * 
     * @return Response
    */
    public function ftpFileDownload($serverName,$fileName)
    {
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
        $localPath  = $tempPath.$fileName;
        $serverId   = $_SESSION[$serverName]['ftpId'];
        $this->ftpconnection->getFtpConnection($serverId,$serverPath,'download',$localPath);
        return $data = [
            'tempPath' => $tempPath,
            'fileName' => $fileName
        ];
    }

    /**
     * ftpFileEdit function
     * 
     * @return Response
    */
    public function ftpFileEdit()
    {
        $serverId   = $this->uri->segment(2);
        $fileName   = $this->uri->segment(3);
        $download   = $this->ftpFileDownload($serverId,$fileName);

        /* load file edit page */
        $data = [
            'file' => $download['fileName'],
            'path' => $download['tempPath']
        ];

        $data['serverPath']     = $_SESSION[$serverId]['currentPath'];
        $data['localPath']      = $download['tempPath'];
        $data['active']         = '';
        $data['serverId']       = $serverId;
        $data['title']          = $fileName.' | Super FTP';
		$data['ftpContent']     = $this->load->view('ftp/pages/editorPage',$data,true);
		$data['ftpList']        = $this->load->view('ftp/ftpList','',true);
		$this->load->view('ftp/index',$data);
    }

    /**
     * ftpFileDelete function
     * 
     * @return Response
    */
    public function ftpFileDelete()
    {
        $serverId = $this->uri->segment(2);
        $fileName = $this->uri->segment(3);
        $filePath = $_SESSION[$serverId]['currentPath'].$fileName;
        
        $result = $this->ftpconnection->getFtpConnection($_SESSION[$serverId]['ftpId'],$filePath,'delete_file');
        if($result) {
            $data = $this->ftpconnection->getFtpContent2($serverId,$_SESSION[$serverId]['currentPath']);
            $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
            echo $this->jsonMsgReturn(true,'Success',$html);
        } else {
            echo $this->jsonMsgReturn(false,'Error! See console log.',$result);
        }
    }

    /**
     * ajax request for ftp data
     * click on ftp list menu
     * 
     * @return Response
    */
    public function getFtpContent() 
    {
        $data = $this->ftpconnection->getFtpContent($_POST);
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
        $data = $this->ftpconnection->getFtpContentInfo($_POST);
        $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
        echo $this->jsonMsgReturn(true,'Success',$html);
    }

    /**
     * ftpFileUpload function
     * 
     * @return Response
    */
    public function ftpFileUpload()
    {
        $uploadPath = $_SESSION[$_POST['directoryId']]['currentPath'].$_FILES['filename']['name'];
        $filePath   = $_FILES['filename']['tmp_name'];
        $result     = $this->ftpconnection->getFtpConnection($_SESSION[$_POST['directoryId']]['ftpId'],$uploadPath,'upload',$filePath);
        if($result) {
            $data = $this->ftpconnection->getFtpContent2($_POST['directoryId'],$_SESSION[$_POST['directoryId']]['currentPath']);
            $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
            echo $this->jsonMsgReturn(true,'Success',$html);
        } else {
            echo $this->jsonMsgReturn(false,'Error! See console log.',$result);
        }        
    }

    /**
     * ftpMakeFolder function
     * 
     * @return Response
    */
    public function ftpMakeFolder()
    {
        $currentPath    = $_SESSION[$_POST['directoryId']]['currentPath'];
        $folderName     = $_POST['foldername'];
        $result         = $this->ftpconnection->getFtpConnection($_SESSION[$_POST['directoryId']]['ftpId'],$currentPath.$folderName,'mkdir');
        if($result) {
            $data = $this->ftpconnection->getFtpContent2($_POST['directoryId'],$currentPath);
            $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
            echo $this->jsonMsgReturn(true,'Success',$html);
        } else {
            echo $this->jsonMsgReturn(false,'Error! See console log.',$result);
        }
    }

    /**
     * ftpFolderDelete function
     * 
     * @return Response
    */
    public function ftpFolderDelete()
    {
        $serverId       = $this->uri->segment(2);
        $folderName     = $this->uri->segment(3);
        $folderPath     = $_SESSION[$serverId]['currentPath'].$folderName.'/';
        
        $result = $this->ftpconnection->getFtpConnection($_SESSION[$serverId]['ftpId'],$folderPath,'delete_dir');
        if($result) {
            $data = $this->ftpconnection->getFtpContent2($serverId,$_SESSION[$serverId]['currentPath']);
            $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
            echo $this->jsonMsgReturn(true,'Success',$html);
        } else {
            echo $this->jsonMsgReturn(false,'Error! See console log.',$result);
        }
    }    

    /**
     * ftpFileRename function
     * 
     * @return Response
    */
    public function ftpFileRename()
    {
        $currentPath = $_SESSION[$_POST['directoryId']]['currentPath'];
        $oldFileName = $currentPath.$_POST['oldFileName'];
        $newFileName = $currentPath.$_POST['newFileName'];
        
        $result = $this->ftpconnection->getFtpConnection($_SESSION[$_POST['directoryId']]['ftpId'],$oldFileName,'rename',$newFileName);
        if($result) {
            $data = $this->ftpconnection->getFtpContent2($_POST['directoryId'],$currentPath);
            $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
            echo $this->jsonMsgReturn(true,'Success',$html);
        } else {
            echo $this->jsonMsgReturn(false,'Error! See console log.',$result);
        }  
    }

    /**
     * ftpFileMove function
     * 
     * @return json
    */
    public function ftpFileMove()
    {
        $serverId       = $this->uri->segment(2);
        /* if isset movepath */
        if(isset($_SESSION[$serverId]['movePath'])) {
            unset($_SESSION[$serverId]['movePath']);
        }        
        $fileName       = $this->uri->segment(3);
        $filePath       = $_SESSION[$serverId]['currentPath'];
        $_SESSION[$serverId]['movePath']['path'] = $filePath;
        $_SESSION[$serverId]['movePath']['file'] = $fileName;

        $data = $this->ftpconnection->getFtpContent2($serverId,$_SESSION[$serverId]['currentPath']);
        $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
        echo $this->jsonMsgReturn(true,'Success',$html);
    }

    /**
     * ftpFileMoveTransfer function
     * 
     * @return json
    */
    public function ftpFileMoveTransfer()
    {
        $serverId       = $this->uri->segment(2);
        /* if isset movepath */
        if(isset($_SESSION[$serverId]['movePath'])) {
            $fileName = $_SESSION[$serverId]['movePath']['file'];
            $moveFrom   = $_SESSION[$serverId]['movePath']['path'].$fileName;
            $moveTo     = $_SESSION[$serverId]['currentPath'].$fileName;
            
            $result = $this->ftpconnection->getFtpConnection($_SESSION[$serverId]['ftpId'],$moveFrom,'move',$moveTo);
            if($result) {
                /* unset movepath */
                unset($_SESSION[$serverId]['movePath']);
                $data = $this->ftpconnection->getFtpContent2($serverId,$_SESSION[$serverId]['currentPath']);
                $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
                echo $this->jsonMsgReturn(true,'File Moved',$html);
            }            
        } else {
            $data = $this->ftpconnection->getFtpContent2($serverId,$_SESSION[$serverId]['currentPath']);
            $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
            echo $this->jsonMsgReturn(false,'Error',$html);
        }        
    }

    /**
     * ftpCancleMove function
     * 
     * @return json
    */
    public function ftpCancleMove()
    {
        $serverId       = $this->uri->segment(2);
        /* unset movepath */
        unset($_SESSION[$serverId]['movePath']);       

        $data = $this->ftpconnection->getFtpContent2($serverId,$_SESSION[$serverId]['currentPath']);
        $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
        echo $this->jsonMsgReturn(true,'Move Cancled',$html);
    }

    /**
     * ftpFileCopy function
     * 
     * @return json
    */
    public function ftpFileCopy()
    {
        $serverId       = $this->uri->segment(2);
        /* if isset movepath */
        if(isset($_SESSION[$serverId]['copyPath'])) {
            unset($_SESSION[$serverId]['copyPath']);
        }        
        $fileName       = $this->uri->segment(3);
        $filePath       = $_SESSION[$serverId]['currentPath'];
        $download = $this->ftpFileDownload($serverId,$fileName);

        $_SESSION[$serverId]['copyPath']['localPath']   = $download['tempPath'];
        $_SESSION[$serverId]['copyPath']['path']        = $filePath;
        $_SESSION[$serverId]['copyPath']['file']        = $fileName;

        $data = $this->ftpconnection->getFtpContent2($serverId,$_SESSION[$serverId]['currentPath']);
        $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
        echo $this->jsonMsgReturn(true,'Success',$html);
    }

    /**
     * ftpFileMoveTransfer function
     * 
     * @return json
    */
    public function ftpFileCopyTransfer()
    {
        $serverId       = $this->uri->segment(2);
        /* if isset movepath */
        if(isset($_SESSION[$serverId]['copyPath'])) {
            $fileName   = $_SESSION[$serverId]['copyPath']['file'];
            /* local path */
            $moveFrom   = $_SESSION[$serverId]['copyPath']['localPath'].$fileName;
            /* dastination/server path */
            $moveTo     = $_SESSION[$serverId]['currentPath'].$fileName;
            
            $result = $this->ftpconnection->getFtpConnection($_SESSION[$serverId]['ftpId'],$moveTo,'upload',$moveFrom);
            if($result) {
                /* unlink local path file */
                unlink($moveFrom);
                /* unset copypath */
                unset($_SESSION[$serverId]['copyPath']);
                $data = $this->ftpconnection->getFtpContent2($serverId,$_SESSION[$serverId]['currentPath']);
                $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
                echo $this->jsonMsgReturn(true,'File Copyed',$html);
            }
        } else {
            $data = $this->ftpconnection->getFtpContent2($serverId,$_SESSION[$serverId]['currentPath']);
            $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
            echo $this->jsonMsgReturn(false,'Error',$html);
        }        
    }

    /**
     * ftpCancleCopy function
     * 
     * @return json
    */
    public function ftpCancleCopy()
    {
        $serverId = $this->uri->segment(2);
        /* unlink local path file */
        unlink($_SESSION[$serverId]['copyPath']['localPath'].$_SESSION[$serverId]['copyPath']['file']);
        /* unset copypath */
        unset($_SESSION[$serverId]['copyPath']);        

        $data = $this->ftpconnection->getFtpContent2($serverId,$_SESSION[$serverId]['currentPath']);
        $html = $this->load->view('ftp/pages/ftpDirPage',$data,true);
        echo $this->jsonMsgReturn(true,'Copy Cancled',$html);
    }

    /**
     * ftpFileUpdate function
     * 
     * @return json
    */
    public function ftpFileUpdate()
    {        
        /* create local path */
        $localPath = $_POST['localPath'].$_POST['fileName'];
        /* get current file ftp server root */
        $this->db->where('ftpName',$_POST['serverId']);
        $currentServerRoot = $this->db->get('ftp_ftpaccounts')->row()->ftpPath;
        /* trim root from current server file path */
        $filePathWithoutRoot    = ltrim($_POST['serverPath'],$currentServerRoot);
        $serverPath             = $filePathWithoutRoot.$_POST['fileName'];
        /* if multiple ftp server select fill will save once and use repeatly */
        if($_POST['indecator'] == 0) {
            /* update file content */
            file_put_contents($localPath, $_POST['data']);
        }
        $serverName     = $_POST['eachServer'];
        /* upload data to each server */
        $this->db->select('id, ftpPath');
        $this->db->where('ftpName',$serverName);
        $eachServer     = $this->db->get('ftp_ftpaccounts')->result_array();
        $eachServerPath = $eachServer[0]['ftpPath'].$serverPath;
        $result = $this->ftpconnection->getFtpConnection($eachServer[0]['id'],$eachServerPath,'upload',$localPath);
        if($result) {
            $this->jsonMsgReturn(true, $serverName.' Success.', $_POST['indecator']);
        } else {
            $this->jsonMsgReturn(false, $serverName.' Error.', $_POST['indecator']);
        }
        // echo json_encode($_POST);        
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