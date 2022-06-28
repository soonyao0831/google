<?php
declare (strict_types = 1);

namespace App\Google\Otp\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\Otp\Manager\OtpManager;
use App\Google\Otp\Manager\OtpPermissionManager;
use Psr\Http\Message\ResponseInterface as Response;

class AddOtpService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new OtpManager(new OtpPermissionManager());
		$isExist = $manager->checkOtpExist("account", $data['account']);
		if ($isExist) {
			return $this->failRespond(null, "账号已存在");
		} else {
			$manager->addOtp($data);
		}
		return $this->respond($data, "添加成功");
	}

	protected function validateData($data) {
		return [
			"account" => "账号不能空",
			"display_name" => "名称不能空",
			"secret" => "密钥不能空",
		];
	}
}