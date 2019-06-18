<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$account_api = WeAccount::createByUniacid($_W['uniacid']);
if ($action == 'manage' && $do == 'create') {
	define('FRAME', 'system');
} else {
	$account_type = $account_api->menuFrame;
	define('FRAME', $account_type);
}