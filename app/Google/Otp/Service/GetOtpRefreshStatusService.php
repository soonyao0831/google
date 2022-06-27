<?php
declare (strict_types = 1);

namespace App\Google\Otp\Service;

use App\Constant\AppConstant;
use App\Core\Service\HttpAbstractService;
use Psr\Http\Message\ResponseInterface as Response;

class GetOtpRefreshStatusService extends HttpAbstractService {

	protected function action($data): Response{
		$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
		$session_secret = AppConstant::$OTP_SESSION_KEY;
		$response = ['isRefresh' => false];
		if (isset($_SESSION['otp_session'])) {
			if ($_SESSION['otp_session'] != $g->getCode($session_secret)) {
				$response['isRefresh'] = true;
				$_SESSION['otp_session'] = $g->getCode($session_secret);
			}
		}

		return $this->respond($response, "获取成功。");
	}

	protected function validateData($data) {

		return [];
	}
}