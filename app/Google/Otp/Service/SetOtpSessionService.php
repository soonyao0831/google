<?php
declare (strict_types = 1);

namespace App\Google\Otp\Service;

use App\Constant\AppConstant;
use App\Core\Service\HttpAbstractService;
use Psr\Http\Message\ResponseInterface as Response;

class SetOtpSessionService extends HttpAbstractService {

	protected function action($data): Response{
		$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
		$session_secret = AppConstant::$OTP_SESSION_KEY;
		$_SESSION['otp_session'] = $g->getCode($session_secret);
		return $this->respond(null, "获取成功。");
	}

	protected function validateData($data) {

		return [];
	}
}