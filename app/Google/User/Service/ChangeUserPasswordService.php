<?php
declare (strict_types = 1);

namespace App\Google\User\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\User\Manager\UserManager;
use Psr\Http\Message\ResponseInterface as Response;

class ChangeUserPasswordService extends HttpAbstractService {

	protected function action($data): Response{

		$manager = new UserManager();
		$ok = $manager->updatePassword($_SESSION['username'], $data);
		if ($ok) {
			return $this->respond();
		}
		return $this->failRespond();
	}

	protected function validateData($data) {
		return [];
	}
}