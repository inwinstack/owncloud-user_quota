<?php 
namespace OCA\User_Quota\Appinfo;

use \OCP\AppFramework\App;
use OCP\IContainer;
use \OCA\User_Quota\Controller\Quota;
use \OCA\User_Quota\Controller\FileQuantity;
use \OCA\User_Quota\FileCount;
class Application extends App {

    public function __construct(array $urlParms = array()){
        parent::__construct('user_quota', $urlParms);
    
        $container = $this->getContainer();
        
        $container->registerService('L10n', function($c){
            return $c->getServer()->getL10N('user_quota');
        });

        $container->registerService('QuotaController', function($c){
            return new Quota(
                
                $c->query('AppName'),
                $c->query('Request')
            );
        });

        $container->registerService('FileQuantityController', function($c){
            return new FileQuantity(
                
                $c->query('AppName'),
                $c->query('Request'),
                $c->query('FileCount')
            );
        });

        $container->registerService('FileCount', function($c) {
            /** @var \OC\Server $server */
			$server = $c->query('ServerContainer');

            return new FileCount(
                $server->getDatabaseConnection(),
				$server->getUserSession()
            );
        });

    }
}
