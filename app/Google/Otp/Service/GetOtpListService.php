<?php
declare (strict_types = 1);

namespace App\Google\Otp\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\Otp\Manager\OtpManager;
use App\Google\Otp\Manager\OtpPermissionManager;
use Psr\Http\Message\ResponseInterface as Response;

class GetOtpListService extends HttpAbstractService {

	protected function action($data): Response{
		$otpManager = new OtpManager(new OtpPermissionManager());
		$response = $otpManager->getOtpList($data);

		return $this->respond($response, "获取成功。");
	}

	protected function validateData($data) {

		return [];
	}
}