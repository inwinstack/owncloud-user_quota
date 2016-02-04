<?php

namespace OCA\User_Quota\Controller;

use OCP\AppFramework\Controller;
use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;

class FileQuantity extends Controller {
    /* @var OCA\User_Quota\FileCount */
    private $filecount;

    public function __construct($AppName, IRequest $request, $filecount) {
        parent::__construct($AppName, $request);
        $this->filecount = $filecount;
    }


    /**
     * @NoAdminRequired
     *
     */

    public function getItemsCount() {
        $file = $this->filecount->getFileCount();
        $folder = $this->filecount->getFolderCount();

        return new DataResponse(array('files' => $file, 'folders' => $folder));
    }

}




?>
