<?php
declare (strict_types = 1);

namespace App\Google\Login\Service;

use App\Core\Service\HttpAbstractService;
use Psr\Http\Message\ResponseInterface as Response;

class CheckLoginSessionService extends HttpAbstractService {

	protected function action($data): Response {
		if (!isset($_SESSION['expire'])) {
			return $this->failRespond(null, "SESSION 过期");
		}
		return $this->respond(null, "SESSION 正常运行");
	}

	protected function validateData($data) {
		return [];
	}
}