<?php
namespace OCA\User_Quota\API;

use OCA\User_Quota\UsersQuota;

class Quota {

    public static function getQuota() {
        $user = $_SERVER['PHP_AUTH_USER'];
        $usersquota = new UsersQuota();

        $data = $usersquota->getQuota($user);

        return new \OC_OCS_Result($data);
    }

    public static function getUsed() {
        $data = [];
        $usersquota = new UsersQuota();
        
        $uids = isset($_GET['uids']) ? $_GET['uids'] : $_SERVER['PHP_AUTH_USER'];

        foreach($usersquota->getUsedFromFilecache($uids) as $name => $used) {
            $data['users'][] = array('name' => $name, 'used' => $used);    
        }

        return new \OC_OCS_Result($data);
    }

    public static function getItemsCount () {
        $app = new \OCA\User_Quota\Appinfo\Application();
        $filecount = $app->getContainer()->query('FileCount');
        $data = [];
        $data['folders'] = $filecount->getFolderCount();
        $data['files'] = $filecount->getFileCount();
        
        return new \OC_OCS_Result($data);
    }

}


?>
