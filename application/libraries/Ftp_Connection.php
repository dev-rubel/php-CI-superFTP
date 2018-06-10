<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftp_Connection {

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
        $data['ftpInfo'] = $this->CI->ftpM->getFtpAccountInfo($post['id']);
        $data['ftpDir']  = $this->getFtpConnection($post['id'],$data['ftpInfo']['ftpPath'],'list'); 
        $data['ftpIdDynamic']  = str_replace(' ','_',$data['ftpInfo']['ftpName']);
        /* multiple ftp connection user session array multidimansion */
        /* each array each hold each ftp connection info */
        /* unset previous sesson */
        unset($_SESSION[$data['ftpIdDynamic']]['ftpId']);
        unset($_SESSION[$data['ftpIdDynamic']]['basePath']);
        unset($_SESSION[$data['ftpIdDynamic']]['previousPath']);
        unset($_SESSION[$data['ftpIdDynamic']]['currentPath']); 
        /* set new session */
        $_SESSION[$data['ftpIdDynamic']]['ftpId'] = $post['id'];
        $_SESSION[$data['ftpIdDynamic']]['basePath'] = $data['ftpInfo']['ftpPath'];
        $_SESSION[$data['ftpIdDynamic']]['previousPath'] = $data['ftpInfo']['ftpPath'];
        $_SESSION[$data['ftpIdDynamic']]['currentPath'] = $data['ftpInfo']['ftpPath'];
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
        $data['ftpInfo'] = $this->CI->ftpM->getFtpAccountInfo($_SESSION[$post['dynamicid']]['ftpId']);
        $data['ftpDir']  = $this->getFtpConnection($_SESSION[$post['dynamicid']]['ftpId'],$post['path'],'list'); 
        $data['ftpIdDynamic']  = str_replace(' ','_',$data['ftpInfo']['ftpName']);
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
            $list = $this->CI->ftp->list_files($serverPath);
        } elseif($dir == 'download') {
            $list = $this->CI->ftp->download($serverPath, $localPath, 'ascii');
        }
        $this->CI->ftp->close();
        return $list;
    }
  
}




?>