<?php
namespace OCA\User_Quota\Controller;

use OCP\AppFramework\Controller;
use OCP\IRequest;
use OCP\User;
use OCP\AppFramework\Http\DataResponse;

class Quota extends Controller{
    
    private $usersquota;

    public function __construct($AppName, IRequest $request, $usersquota) {
        parent::__construct($AppName, $request);
        $this->usersquota = $usersquota;
    }
    
    /*
     * if quota is -1,it is mean space not computed
     * if quota is -2,it is mean space unknown
     * if quota is -3,it is mean space unlimited
     * see lib/public/files/fileinfo.php
     * @NoAdminRequired
     */
    public function getQuota($user = '') {
        $user = $user !== '' ? $user : User::getUser();
        $data = $this->usersquota->getQuota($user); 
        return new DataResponse(array('data' => $data , 'status' => 'success'));
    }

    /**
     * @NoAdminRequired
     */
    public function getUsedFromFilecache($uids = NULL){
        $usedspace = $this->usersquota->getUsedFromFilecache($uids); 
        
        return new DataResponse(array('data' => $usedspace, 'status' => 'success'));
    }
}
?>
