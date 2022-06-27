<?php
declare (strict_types = 1);

namespace App\Google\Otp\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\Otp\Manager\OtpManager;
use App\Google\Otp\Manager\OtpPermissionManager;
use Psr\Http\Message\ResponseInterface as Response;

class GetOtpListJsonService extends HttpAbstractService {

	protected function action($data): Response{
		$otpManager = new OtpManager(new OtpPermissionManager());
		$otpList = $otpManager->getAllOtpList()[1]['data'];
		$response = [];
		foreach ($otpList as $key => $value) {
			$response[$key]['value'] = $value['id'];
			$response[$key]['title'] = $value['account'];
		}
		return $this->respond($response, "获取成功。");
	}

	protected function validateData($data) {

		return [];
	}
}