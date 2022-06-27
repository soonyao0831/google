<?php
declare (strict_types = 1);

namespace App\Google\User\Service;

use App\Core\Service\AesEncryptorService;
use App\Core\Service\HttpAbstractService;
use App\Google\Login\Manager\LoginManager;
use Psr\Http\Message\ResponseInterface as Response;

class GetUserProfileService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new LoginManager();
		$isUserExist = $manager->checkUserExist($data);
		if ($isUserExist) {
			$userData = $manager->getUserByUsername($data);
			if (empty($userData)) {
				return $this->failRespond(null, "账号不存在。");
			}
			$encrytor = new AesEncryptorService();
			$userData['id'] = $encrytor->encrypt(strval($userData['id']));
			ksort($userData);
			return $this->respond($userData, "获取成功。");
		} else {
			return $this->failRespond(null, "账号/密码不正确。");
		}
	}

	protected function validateData($data) {
		return [
			'username' => "账号不能为空",
		];
	}
}