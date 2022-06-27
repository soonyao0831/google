<?php
declare (strict_types = 1);

namespace App\Google\User\Service;

use App\Core\Service\AesEncryptorService;
use App\Core\Service\HttpAbstractService;
use App\Google\User\Manager\UserManager;
use Psr\Http\Message\ResponseInterface as Response;

class GetUserWithAllPermissionService extends HttpAbstractService {

	protected function action($data): Response{
		$encrytor = new AesEncryptorService();
		$data['id'] = $encrytor->decrypt($data['id']);

		$manager = new UserManager();
		$isUserExist = $manager->checkUserExistById($data);
		if ($isUserExist) {
			$response = $manager->getAllDataWithPermission($data);
			return $this->respond($response, "获取成功。");
		} else {
			return $this->failRespond($data, "账号不存在");
		}
	}

	protected function validateData($data) {
		return [
			'id' => "序号不能为空",
		];
	}
}