<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class XzappAccount extends WeAccount {
	public function __construct($account = array()) {
		$this->menuFrame = 'xzapp';
		$this->type = ACCOUNT_TYPE_XZAPP_NORMAL;
		$this->typeName = 'XZAPP';
		$this->typeTempalte = '-xzapp';
	}

	public function checkIntoManage() {
		if (empty($this->account) || (!empty($this->uniaccount['account']) && $this->uniaccount['type'] != ACCOUNT_TYPE_XZAPP_NORMAL && !defined('IN_MODULE'))) {
			return false;
		}
		return true;
	}

	public function fetchAccountInfo() {
		$account_table = table('account');
		$account = $account_table->getXzappAccount($this->uniaccount['acid']);
		return $account;
	}

	public function accountDisplayUrl() {
		return url('account/display', array('type' => XZAPP_TYPE_SIGN));
	}
}