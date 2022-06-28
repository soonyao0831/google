<?php
declare (strict_types = 1);

namespace App\Google\Otp\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\Otp\Manager\OtpManager;
use App\Google\Otp\Manager\OtpPermissionManager;
use Psr\Http\Message\ResponseInterface as Response;

class ListOtpService extends HttpAbstractService {

	protected function action($data): Response{
		$otpManager = new OtpManager(new OtpPermissionManager());
		$otpList = $otpManager->getOtpListWithTable($data);
		return $this->respondTable($otpList['data'], $data, $otpList['total']);
	}

	protected function validateData($data) {

		return [];
	}
}