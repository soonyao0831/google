<?php
declare (strict_types = 1);

namespace App\Google\Otp\Service;

use App\Core\Service\AesEncryptorService;
use App\Core\Service\HttpAbstractService;
use App\Google\Otp\Manager\OtpManager;
use App\Google\Otp\Manager\OtpPermissionManager;
use Psr\Http\Message\ResponseInterface as Response;

class GetOtpByIdService extends HttpAbstractService {

	protected function action($data): Response{
		$otpManager = new OtpManager(new OtpPermissionManager());

		$aes = new AesEncryptorService();
		$isExist = $otpManager->checkOtpExist("id", $aes->decrypt(strval($data['id'])));
		if (!$isExist) {
			return $this->failRespond(null, "账号不存在");
		} else {
			$otpList = $otpManager->getOtp('id', $aes->decrypt(strval($data['id'])));
			return $this->respond($otpList, "获取成功。");
		}
	}

	protected function validateData($data) {

		return ["id" => "出错"];
	}
}