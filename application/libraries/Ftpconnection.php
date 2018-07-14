<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpconnection {

    /**
     * Super FTP 
     * Ftp_Connection library
     * @author Nur Alam Rubel
     * @date 05-06-18
     * 
    */

    protected $CI;

    public function __construct() 
    {
        $this->CI =& get_instance();
    }

    /**
     * ajax request for ftp data
     * click on ftp list menu
     * 
     * @return Response
    */
    public function getFtpContent($post) 
    {               
        $data['ftpInfo']        = $this->CI->ftpM->getFtpAccountInfo($post['id']);
        $data['ftpDir']         = $this->getFtpConnection($post['id'],$data['ftpInfo']['ftpPath'],'list'); 
        $data['ftpIdDynamic']   = str_replace(' ','_',$data['ftpInfo']['ftpName']);
        /* for multiple ftp connection user session array multidimansion */
        /* each array each hold each ftp connection info */
        /* unset previous sesson */
        unset($_SESSION[$data['ftpIdDynamic']]['ftpId']);
        unset($_SESSION[$data['ftpIdDynamic']]['basePath']);
        unset($_SESSION[$data['ftpIdDynamic']]['previousPath']);
        unset($_SESSION[$data['ftpIdDynamic']]['currentPath']); 
        /* set new session */
        $_SESSION[$data['ftpIdDynamic']]['ftpId']           = $post['id'];
        $_SESSION[$data['ftpIdDynamic']]['basePath']        = $data['ftpInfo']['ftpPath'];
        $_SESSION[$data['ftpIdDynamic']]['previousPath']    = $data['ftpInfo']['ftpPath'];
        $_SESSION[$data['ftpIdDynamic']]['currentPath']     = $data['ftpInfo']['ftpPath'];
        return $data;
    }
      
    /**
     * ajax request for ftp data
     * click on ftp directory folder
     * 
     * @return Response
    */
    public function getFtpContentInfo($post)
    {
        /* Create previous path from current path */
        $pre = explode('/',$post['path']);
        if($post['path'] !== $_SESSION[$post['dynamicid']]['basePath']) {
            $_SESSION[$post['dynamicid']]['previousPath'] = implode('/',array_slice($pre,0,-2)).'/';
        } else {
            $_SESSION[$post['dynamicid']]['previousPath'] = $_SESSION[$post['dynamicid']]['currentPath'];
        }
        /* Set current path */
        $_SESSION[$post['dynamicid']]['currentPath'] = $post['path'];
        $data['ftpInfo']        = $this->CI->ftpM->getFtpAccountInfo($_SESSION[$post['dynamicid']]['ftpId']);
        $data['ftpDir']         = $this->getFtpConnection($_SESSION[$post['dynamicid']]['ftpId'],$post['path'],'list'); 
        $data['ftpIdDynamic']   = str_replace(' ','_',$data['ftpInfo']['ftpName']);
        return $data;
    }
      
    /**
     * ajax request for ftp data
     * click on ftp directory folder/files/upload
     * 
     * @return Response
    */
    public function getFtpContent2($ftpDynamicId,$path)
    {
        $data['ftpInfo']        = $this->CI->ftpM->getFtpAccountInfo($_SESSION[$ftpDynamicId]['ftpId']);
        $data['ftpDir']         = $this->getFtpConnection($_SESSION[$ftpDynamicId]['ftpId'],$path,'list'); 
        $data['ftpIdDynamic']   = $ftpDynamicId;
        return $data;
    }
      
    /**
     * ftp connection for ajax request
     * 
     * @return ftp directory data
    */
    public function getFtpConnection($serverId,$serverPath='',$dir='list',$localPath='') 
    {
        $serverInfo = $this->CI->ftpM->getFtpAccountInfo($serverId);
        extract($serverInfo);
        $this->CI->load->library('ftp');
        $config['hostname'] = $ftpHost;
        $config['username'] = $ftpUser;
        $config['password'] = $this->CI->encryption->decrypt($ftpPassword);
        $config['debug']    = TRUE;
        $this->CI->ftp->connect($config);
        if($dir == 'list') {
            $response = $this->CI->ftp->list_files($serverPath);
        } elseif($dir == 'download') {
            /* download for edit the download file and upload */
            $response = $this->CI->ftp->download($serverPath, $localPath, 'ascii');
        } elseif($dir == 'upload') {
            $response = $this->CI->ftp->upload($localPath, $serverPath, 'ascii', 0777);
        } elseif($dir == 'rename') {
            /* serverPath   ==  privious filename path */
            /* localPath    ==  new filename path */
            $response = $this->CI->ftp->rename($serverPath, $localPath);
        } elseif($dir == 'move') {
            /* serverPath == from file path */
            /* localPath == to file path */
            $response = $this->CI->ftp->move($serverPath, $localPath);
        } elseif($dir == 'delete_file') {
            /* serverPath == delete file path */            
            $response = $this->CI->ftp->delete_file($serverPath);
        } elseif($dir =='delete_dir') {
            /* serverPath == delete folder path */
            $result = $this->CI->ftp->list_files($serverPath);
            if($result) {
                $response = $this->CI->ftp->delete_dir($serverPath);
            }            
        } elseif($dir == 'mkdir') {
            /* serverPath == create folder path */
            $response = $this->CI->ftp->mkdir($serverPath, 0755);
        }
        $this->CI->ftp->close();
        return $response;
    }
  
}




?>