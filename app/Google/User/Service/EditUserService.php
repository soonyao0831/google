<?php
declare (strict_types = 1);

namespace App\Google\User\Service;

use App\Core\Service\AesEncryptorService;
use App\Core\Service\HttpAbstractService;
use App\Google\User\Manager\UserManager;
use Psr\Http\Message\ResponseInterface as Response;

class EditUserService extends HttpAbstractService {

	protected function action($data): Response{
		$encrytor = new AesEncryptorService();
		$data['id'] = $encrytor->decrypt($data['id']);

		$manager = new UserManager();

		$isExist = $manager->checkUserExistById($data);
		if ($isExist) {
			$manager->editUser($data);
		} else {
			return $this->failRespond(null, "账号不存在");
		}
		return $this->respond($data, "编辑成功");
	}

	protected function validateData($data) {
		return [];
	}
}