<?php
declare (strict_types = 1);

namespace App\Google\Otp\Service;

use App\Core\Service\AesEncryptorService;
use App\Core\Service\HttpAbstractService;
use App\Google\Otp\Manager\OtpManager;
use App\Google\Otp\Manager\OtpPermissionManager;
use Psr\Http\Message\ResponseInterface as Response;

class EditOtpService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new OtpManager(new OtpPermissionManager());
		$aes = new AesEncryptorService();
		$isExist = $manager->checkOtpExist("id", $aes->decrypt(strval($data['id'])));
		if ($isExist) {
			$manager->editOtp($data);
		} else {
			return $this->failRespond(null, "Otp不存在");
		}
		return $this->respond($data, "编辑成功");
	}

	protected function validateData($data) {
		return [
			"account" => "账号不能空",
			"display_name" => "名称不能空",
			"secret" => "密钥不能空",
		];
	}
}