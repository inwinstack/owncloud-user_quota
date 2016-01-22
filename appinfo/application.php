<?php 
namespace OCA\User_Quota\Appinfo;

use \OCP\AppFramework\App;
use OCP\IContainer;
use \OCA\User_Quota\Controller\Quota;

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
    }
}
