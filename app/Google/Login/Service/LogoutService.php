<?php
declare (strict_types = 1);

namespace App\Google\Login\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\Login\Manager\LoginManager;
use Psr\Http\Message\ResponseInterface as Response;

class LogoutService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new LoginManager();
		$manager->logoutSuccess();
		session_unset();
		session_destroy();
		return $this->respond([], "退出成功。");
	}

	protected function validateData($data) {
		return [];
	}
}