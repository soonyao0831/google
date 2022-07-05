<?php
declare (strict_types = 1);

namespace App\Google\Ip\Manager;

use App\Core\Service\AbstractReadFileService;

class IpManager extends AbstractReadFileService {

	public function __construct() {

	}

	public function addIp($ip) {
		$this->writeFile(explode(",", $ip));
	}

	public function getAllIpList() {
		$ipList = $this->readFile();
		return $ipList;
	}

	protected function fileName() {
		return "ip_table";
	}
}
