<?php 
class Ftp_model extends CI_Model {

    protected $t1 = 'ftp_ftpAccounts';
    protected $t2 = 'ftp_settings';

    public function addFtpAccount($post) 
    {
        $post['ftpPassword'] = $this->encryption->encrypt($post['ftpPassword']);
        $result = $this->db->insert($this->t1,$post);
        if($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function updateFtpAccount($post,$id) 
    {
        $post['ftpPassword'] = $this->encryption->encrypt($post['ftpPassword']);
        $this->db->where('id',$id);
        $result = $this->db->update($this->t1,$post);
        if($result) {
            return $id;
        } else {
            return false;
        }
    }

    public function getFtpAccounts($id='') 
    {
        $this->db->from($this->t1);
        if(!empty($id)) {
            $this->db->where('id',$id);
            $result = $this->db->get()->result_array();
            return $result;    
        }
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function deleteFtpAccounts($id) 
    {
        $this->db->where('id',$id);
        $result = $this->db->delete($this->t1);
        return $result;            
    }

    public function updateFtpSettings($where,$post) 
    {
        $this->db->where('name',$where);
        $result = $this->db->update($this->t2,['value'=>$post]);
        return $result;            
    }

    public function getFtpAccountName($id) 
    {
        $this->db->where('id',$id);
        $result = $this->db->get($this->t1)->row()->ftpName;
        return $result;  
    }

    public function getFtpAccountInfo($id) 
    {
        $this->db->where('id',$id);
        $result = $this->db->get($this->t1)->result_array();
        return $result[0];
    }


}


?>