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

namespace OCA\User_Quota\AppInfo;

use OCP\AppFramework\App;

$app = new App('user_quota');
$container = $app->getContainer();

\OCP\Util::addScript( 'user_quota', "usage");
\OCP\Util::addStyle( 'user_quota', "style");
