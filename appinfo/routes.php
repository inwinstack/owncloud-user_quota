<?php
/**
 * ownCloud - user_quota
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author simon <simon.l@inwinstack.com>
 * @copyright simon 2015
 */

/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\User_Quota\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */

namespace OCA\User_Quota\Appinfo;

use OCP\API;

$application = new Application();
$application->registerRoutes($this,[
    'routes' => [
       ['name' => 'Quota#getQuota', 'url' => '/getQuota', 'verb' => 'POST'],
       ['name' => 'Quota#getUsedFromFilecache', 'url' => '/getUsed', 'verb' => 'POST'],
       ['name' => 'FileQuantity#getItemsCount', 'url' => '/getItemsCount', 'verb' => 'GET']
    ]
]);

API::register('get',
       '/apps/user_quota/api/v1/getQuota',
       array('\OCA\User_Quota\API\Quota', 'getQuota'),
       'user_quota');

API::register('get',
       '/apps/user_quota/api/v1/getUsed',
       array('\OCA\User_Quota\API\Quota', 'getUsed'),
       'user_quota');

API::register('get',
       '/apps/user_quota/api/v1/getItemsCount',
       array('\OCA\User_Quota\API\Quota', 'getItemsCount'),
       'user_quota');

