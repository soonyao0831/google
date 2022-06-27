<?php
declare (strict_types = 1);

namespace App\Google\User\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\User\Manager\UserManager;
use Psr\Http\Message\ResponseInterface as Response;

class AddUserService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new UserManager();
		$isExist = $manager->checkUserExist($data);
		if ($isExist) {
			return $this->failRespond(null, "账号已存在");
		} else {
			$manager->addUser($data);
		}
		return $this->respond($data, "添加成功");
	}

	protected function validateData($data) {
		return [];
	}
}