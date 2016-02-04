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

	/**
	 * @param IDBConnection $connection
	 * @param IUserSession $userSession
	 */
	public function __construct(IDBConnection $connection, IUserSession $userSession) {
		$this->connection = $connection;
		$this->userSession = $userSession;
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

        $query = $this->connection->prepare('SELECT COUNT(*) FROM *PREFIX*filecache JOIN *PREFIX*storages ON *PREFIX*filecache.storage = *PREFIX*storages.numeric_id WHERE *PREFIX*filecache.path LIKE "files\/%" AND *PREFIX*filecache.mimetype = 2 AND *PREFIX*storages.id = ?');
        
		$query->execute(array($storage_id));

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

        $query = $this->connection->prepare('SELECT COUNT(*) FROM *PREFIX*filecache JOIN *PREFIX*storages ON *PREFIX*filecache.storage = *PREFIX*storages.numeric_id WHERE *PREFIX*filecache.path LIKE "files\/%" AND *PREFIX*filecache.mimetype != 2 AND *PREFIX*filecache.mimetype != 6 AND *PREFIX*filecache.mimetype != 12 AND *PREFIX*storages.id = ?');
        
        $query->execute(array($storage_id));

        $row = $query->fetch();

        return $row['COUNT(*)'];

    }



}



?>
