<?php
namespace OCA\User_Quota;

use OCP\IUser;
use OCP\IUserSession;
use OCP\IDBConnection;


class FileCount {

    /** @var IDBConnection */
	protected $connection;

	/** @var IUserSession */
	protected $userSession;
    
    protected $mimetypes;

	/**
	 * @param IDBConnection $connection
	 * @param IUserSession $userSession
	 */
	public function __construct(IDBConnection $connection, IUserSession $userSession) {
		$this->connection = $connection;
		$this->userSession = $userSession;
        $this->mimetypes = $this->getmimetypes();
        
	}

    /**
     * this function get all mimetypes id and mimetype
     * @return array
     */
    private function getmimetypes() {
        $query = $this->connection->prepare('SELECT * FROM *PREFIX*mimetypes');
        $query->execute();
        
        $mimetypes = array();
        while($row = $query->fetch()) {
            $mimetypes[$row['mimetype']] = $row['id'];
        }
        
        return $mimetypes;
    }

    /**
     * this function count the user's file quantity
     * @return integer
	 */
    public function getFolderCount() {
	    $user = $this->userSession->getUser();

		if ($user instanceof IUser) {
			$user = $user->getUID();
		} else {
            return;
        }
        
        $storage_id = 'home::'.$user;

        $query = $this->connection->prepare('SELECT COUNT(*) FROM *PREFIX*filecache JOIN *PREFIX*storages ON *PREFIX*filecache.storage = *PREFIX*storages.numeric_id WHERE *PREFIX*filecache.path LIKE "files\/%" AND *PREFIX*filecache.mimetype = ? AND *PREFIX*storages.id = ?');
        
		$query->execute(array($this->mimetypes['httpd/unix-directory'],$storage_id));

        $row = $query->fetch();

        return $row['COUNT(*)'];

    }

    /**
     * this function count the user's file quantity
     * @return integer an integer is 
	 */
    public function getFileCount() {
	    $user = $this->userSession->getUser();

		if ($user instanceof IUser) {
			$user = $user->getUID();
		} else {
            return;
        }
        
        $storage_id = 'home::'.$user;

        $query = $this->connection->prepare('SELECT COUNT(*) FROM *PREFIX*filecache JOIN *PREFIX*storages ON *PREFIX*filecache.storage = *PREFIX*storages.numeric_id WHERE *PREFIX*filecache.path LIKE "files\/%" AND *PREFIX*filecache.mimetype != ? AND *PREFIX*filecache.mimetype != ? AND *PREFIX*storages.id = ?');
        
        $query->execute(array($this->mimetypes['httpd/unix-directory'], $this->mimetypes['application/octet-stream'], $storage_id));

        $row = $query->fetch();

        return $row['COUNT(*)'];

    }



}



?>
