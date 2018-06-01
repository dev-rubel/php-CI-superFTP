<?php 
class User_model extends CI_Model {

    protected $t1 = 'ftp_users';

    public function addUserAccount($post) 
    {
        $post['userPassword'] = $this->encryption->encrypt($post['userPassword']);
        $this->db->insert($this->t1,$post);
        if($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function getUserPassword() 
    {        
        $this->db->where('id',$_SESSION['userInfo']['id']);
        $result = $this->db->get($this->t1)->row()->userPassword;
        return $this->encryption->decrypt($result);
    }

    public function getUserAccounts($id='') 
    {
        $this->db->from($this->t1);
        $this->db->where('userDesignation',2); // only user
        if(!empty($id)) {
            $this->db->where('id',$id);            
            $result = $this->db->get()->result_array();
            return $result;    
        }
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function updateUserAccount($post,$id) 
    {
        $post['userPassword'] = $this->encryption->encrypt($post['userPassword']);
        $this->db->where('id',$id);
        $this->db->update($this->t1,$post); 
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUserAccounts($id) 
    {
        $this->db->where('id',$id);
        $result = $this->db->delete($this->t1);
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    public function loginWithEmailUser($post,$niddle) 
    {
        $user = $niddle=='email'?'userEmail':'userName';
        $data[$user] = $post['user'];
        $userPassword = $this->db->get_where($this->t1,$data)->result_array();
        /* If email found */
        if(count($userPassword) > 0) {
            $storePassword = $this->encryption->decrypt($userPassword[0]['userPassword']);
            /* If password match */
            if($post['password'] == $storePassword) {
                unset($userPassword[0]['userPassword']);
                return $userPassword;
            } else {
                return false;
            }
        } else {
            return false;
        }            
    }

    public function updateUserInfo($post,$id, $niddle) 
    {        
        /* true for change password else only change user full name */
        if($niddle) {
            $post['userPassword'] = $this->encryption->encrypt($post['userPassword']);                    
        }
        $this->db->where('id',$id);
        $result = $this->db->update($this->t1,$post);
        /* update session user information */
        $_SESSION['userInfo']['userFullName'] = $post['userFullName'];
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    public function checkOldPassword($id,$oldpassword) 
    {
        $this->db->where('id',$id);
        $result = $this->db->get($this->t1)->result_array();
        if(count($result) > 0) {
            $storePassword = $this->encryption->decrypt($result[0]['userPassword']);
            if($oldpassword == $storePassword) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
}


?>