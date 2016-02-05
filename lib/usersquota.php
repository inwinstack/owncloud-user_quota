<?php
namespace OCA\User_Quota;

class UsersQuota {
    
    public function getQuota($user) {
        $data = [];
        $data['quota'] = \OC_Util::getUserQuota($user);
        return $data;
    }

    public function getUsedFromFilecache($uids) {
        $users = [];
        $users = explode(",",$uids);
        
        if($users == "") {
            array_push($users, $uids);
        }
        return \OCP\Util::getUserUsedSpace($users);
    }

}

?>
