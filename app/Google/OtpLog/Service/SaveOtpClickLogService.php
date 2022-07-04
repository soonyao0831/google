<?php
declare (strict_types = 1);

namespace App\Google\OtpLog\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\OtpLog\Manager\OtpLogManager;
use Psr\Http\Message\ResponseInterface as Response;

class SaveOtpClickLogService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new OtpLogManager();
		$manager->addOtpLog($data);
		return $this->respond($data, "成功");
	}

	protected function validateData($data) {
		return [
			"otp_name" => "账号不能空",
		];
	}
}