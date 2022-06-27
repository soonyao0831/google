<?php
declare (strict_types = 1);

namespace App\Google\Login\Manager;

use App\Constant\AppConstant;
use App\Core\Service\AbstractReadFileService;

class LoginManager extends AbstractReadFileService {

	public function __construct() {

	}

	public function checkUserExist($data) {
		return $this->isDataExist("username", $data['username']);
	}

	public function getUserByUsername($data) {

		$list = $this->findUniqueData("username", $data['username']);
		return $list;
	}

	public function loginSuccess($data) {
		$_SESSION['username'] = $data['username'];
		$_SESSION['expire'] = time() + AppConstant::$SESSION_EXPIRE_TIME;
		$list = $this->findUniqueData("username", $_SESSION['username']);
		$list['login_time'] = date("Y-m-d H:i:s", time());
		$list['is_login'] = 1;
		$readUser = $this->readFile();
		foreach ($readUser as $key => $value) {
			if ($value['username'] == $_SESSION['username']) {
				$readUser[$key] = $list;
				break;
			}
		}
		$this->writeFile($readUser);
	}

	public function logoutSuccess() {
		$list = $this->findUniqueData("username", $_SESSION['username']);
		$list['logout_time'] = date("Y-m-d H:i:s", time());
		$list['is_login'] = 0;
		$readUser = $this->readFile();
		foreach ($readUser as $key => $value) {
			if ($value['username'] == $_SESSION['username']) {
				$readUser[$key] = $list;
				break;
			}
		}
		$this->writeFile($readUser);
	}

	protected function fileName() {
		return "user_account";
	}
}
