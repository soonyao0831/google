<?php
declare (strict_types = 1);

namespace App\Google\OtpLog\Manager;

use App\Core\Service\AbstractReadFileService;
use App\Core\Service\AesEncryptorService;

class OtpLogManager extends AbstractReadFileService {

	public function __construct() {

	}

	public function getAllOtpLogList() {

		$otpLogList = $this->readFile();
		$aes = new AesEncryptorService();
		foreach ($otpLogList as $key => $value) {
			$otpLogList[$key]['log_time'] = date('Y-m-d H:i:s', $value['log_time']);
		}
		$otpLogList = array_reverse($otpLogList, false);
		return $otpLogList;
	}

	public function addOtpLog($data) {
		$otpList = $this->readfile();

		$currentTime = time();
		$insert = array(
			"username" => $_SESSION['username'],
			"otp_name" => $data['otp_name'],
			"log" => 'Use ' . $data['otp_name'],
			"log_time" => $currentTime,
			"log_ip" => getRealIp(),
		);
		$otpList[] = $insert;
		$this->writeFile($otpList);
	}

	protected function fileName() {
		return "otp_log";
	}
}
