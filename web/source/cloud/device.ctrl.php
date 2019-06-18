<?php
/**
 * [jv76授权系统 System] Copyright (c) 2018 JV76.CN
 * jv76授权系统 is NOT a free software, it under the license terms, visited http://www.jv76.cn/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
if ($do == 'online') {
	header('Location: //www.sq.com/app/api.php?referrer='.$_W['setting']['site']['key']);
	exit;
} elseif ($do == 'offline') {
	header('Location: //www.sq.com/app/api.php?referrer='.$_W['setting']['site']['key'].'&standalone=1');
	exit;
} else {
}
template('cloud/device');
