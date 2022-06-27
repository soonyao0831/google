<?php
declare (strict_types = 1);

namespace App\Google\User\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\User\Manager\UserManager;
use Psr\Http\Message\ResponseInterface as Response;

class GetUserListService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new UserManager();
		$userList = $manager->getUserList($data);

		return $this->respondTable($userList['data'], $data, $userList['total']);
	}

	protected function validateData($data) {
		return [];
	}
}