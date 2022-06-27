<?php
declare (strict_types = 1);

namespace App\Google\Otp\Manager;

use App\Core\Service\AbstractReadFileService;
use App\Core\Service\AesEncryptorService;
use App\Google\Otp\Manager\OtpPermissionManager;

class OtpManager extends AbstractReadFileService {

	private $otpPermission;

	public function __construct(OtpPermissionManager $otpPermission) {
		$this->otpPermission = $otpPermission;
	}

	public function getOtpList($data) {

		$otpList = $this->readFile();
		$permissionList = $this->otpPermission->getOtpPermissionListByUsername($data['username']);
		$response = [];
		if ($permissionList['otp_id'][0] === "*") {
			$response = $otpList[1]['data'];
		} else {
			foreach ($otpList[1]['data'] as $key => $value) {
				foreach ($permissionList['otp_id'] as $k => $v) {
					if ($value['id'] == $v) {
						$response[] = $otpList[1]['data'][$key];
					}
				}
			}
		}

		$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
		foreach ($response as $key => $value) {
			unset($response[$key]['id']);
			$response[$key]['secret'] = $g->getCode($value['secret']);
		}
		return $response;
	}

	public function getAllOtpList() {

		$otpList = $this->readFile();
		$aes = new AesEncryptorService();
		foreach ($otpList[1]['data'] as $key => $value) {
			$otpList[1]['data'][$key]['id'] = $aes->encrypt(strval($value['id']));
			unset($otpList[1]['data'][$key]['secret']);
		}
		return $otpList;
	}

	public function resetFile() {
		$otpList = $this->readFile();
		$otpList[1]['data'] = $this->resetId($otpList[1]['data']);

		$totalList = count($otpList[1]['data']);
		$otpList[0]['last_id'] = $totalList;

		$this->writeFile($otpList);
	}

	public function getAllOtpId() {
		$otpList = $this->readFile();
		$response = [];
		foreach ($otpList[1]['data'] as $key => $value) {
			$response[] = $value['id'];
		}
		return $response;
	}

	protected function fileName() {
		return "otp";
	}
}
