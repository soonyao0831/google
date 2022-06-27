<?php
declare (strict_types = 1);

namespace App\Google\Login\Service;

use App\Core\Service\AesEncryptorService;
use App\Core\Service\HttpAbstractService;
use App\Google\Login\Manager\LoginManager;
use Psr\Http\Message\ResponseInterface as Response;

class LoginService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new LoginManager();
		$isUserExist = $manager->checkUserExist($data);
		if ($isUserExist) {
			$userData = $manager->getUserByUsername($data);
			if (empty($userData)) {
				return $this->failRespond(null, "账号不存在。");
			}
			$encrytor = new AesEncryptorService();

			if ($encrytor->encrypt($data['password']) != $encrytor->encrypt($userData['password'])) {
				return $this->failRespond(null, "账号/密码不正确。");
			}

			$manager->loginSuccess($data);
			return $this->respond([], "登录成功。");
		} else {
			return $this->failRespond(null, "账号/密码不正确。");
		}
	}

	protected function validateData($data) {
		return [
			'username' => "账号不能为空",
			'password' => "密码不能为空",
		];
	}
}