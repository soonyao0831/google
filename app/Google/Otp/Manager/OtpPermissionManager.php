<?php
declare (strict_types = 1);

namespace App\Google\Otp\Manager;

use App\Core\Service\AbstractReadFileService;
use App\Core\Service\AesEncryptorService;
use App\Google\Otp\Manager\OtpManager;

class OtpPermissionManager extends AbstractReadFileService {

	public function __construct() {

	}

	public function getOtpPermissionListByUsername($username) {
		$dataList = $this->readFile();
		$response = null;
		foreach ($dataList as $key => $value) {
			if ($username == $value['user_id']) {
				$response = $dataList[$key];
				break;
			}
		}
		return $response;
	}

	public function addOtpPermission($data) {
		$aes = new AesEncryptorService();
		$otpManager = new OtpManager(new OtpPermissionManager());
		$otpList = $otpManager->getAllOtpId();
		$ids = [];
		$data['otp_permission'] = json_decode($data['otp_permission'], true);
		foreach ($data['otp_permission'] as $key => $value) {
			$id = $aes->decrypt($value['value']);
			if (in_array($id, $otpList)) {
				$ids[] = intval($id);
			}
		}

		$otpPermissionList = $this->readFile();
		$getNextId = $this->getNextId($otpPermissionList);
		$otpPermissionInsert = [
			'id' => $getNextId,
			'user_id' => $data['username'],
			'otp_id' => $ids,
		];
		$otpPermissionInsert = $this->setCommonAddColumn($otpPermissionInsert);
		$otpPermissionList[] = $otpPermissionInsert;
		$this->writeFile($otpPermissionList);
	}

	public function editOtpPermission($data) {
		$aes = new AesEncryptorService();
		$otpManager = new OtpManager(new OtpPermissionManager());
		$otpList = $otpManager->getAllOtpId();
		$ids = [];
		$data['otp_permission'] = json_decode($data['otp_permission'], true);
		foreach ($data['otp_permission'] as $key => $value) {
			$id = $aes->decrypt($value['value']);
			if (in_array($id, $otpList)) {
				$ids[] = intval($id);
			}
		}

		$otpPermissionList = $this->readFile();
		foreach ($otpPermissionList as $key => $value) {
			if ($value['user_id'] == $data['username']) {
				$otpPermissionList[$key]['otp_id'] = $ids;
				$otpPermissionList[$key] = $this->setCommonEditColumn($otpPermissionList[$key]);
				break;
			}
		}
		$this->writeFile($otpPermissionList);
	}

	protected function fileName() {
		return "otp_permission";
	}
}
