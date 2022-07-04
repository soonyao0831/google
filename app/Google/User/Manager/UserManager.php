<?php
declare (strict_types = 1);

namespace App\Google\User\Manager;

use App\Constant\AppConstant;
use App\Core\Service\AbstractReadFileService;
use App\Core\Service\AesEncryptorService;
use App\Google\Menu\Manager\MenuManager;
use App\Google\Menu\Manager\MenuPermissionManager;
use App\Google\Otp\Manager\OtpManager;
use App\Google\Otp\Manager\OtpPermissionManager;

class UserManager extends AbstractReadFileService {

	private $menuManager;
	private $menuPermissionManager;
	private $otpManager;
	private $otpPermissionManager;

	public function __construct() {
		$this->menuPermissionManager = new MenuPermissionManager();
		$this->otpPermissionManager = new OtpPermissionManager();
		$this->menuManager = new MenuManager(new MenuPermissionManager());
		$this->otpManager = new OtpManager(new OtpPermissionManager());
	}

	public function getUserList($data) {
		$userList = $this->readFile();

		$aes = new AesEncryptorService();
		foreach ($userList as $key => $value) {
			$userList[$key]['id'] = $aes->encrypt(strval($value['id']));
			unset($userList[$key]['password']);
		}
		$offset = ($data['page'] - 1) * $data['limit'];
		$response['data'] = array_slice($userList, $offset, $data['limit']);
		$response['total'] = count($userList);
		return $response;
	}

	public function addUser($data) {
		$userList = $this->readFile();

		$getNextId = $this->getNextId($userList);
		$newUser = [
			"id" => $getNextId,
			"username" => $data['username'],
			"password" => $data['password'],
			"display_name" => $data['display_name'],
			"profile_pic" => empty($data['profile_pic']) ? AppConstant::$DEFAULT_PROFILE_IMAGE : $data['profile_pic'],
			"login_time" => 0,
			"logout_time" => 0,
			"is_login" => 0,
		];
		$newUser = $this->setCommonAddColumn($newUser);
		$userList[] = $newUser;

		$this->writeFile($userList);

		$this->menuPermissionManager->addMenuPermission($data);
		$this->otpPermissionManager->addOtpPermission($data);
	}

	public function editUser($data) {
		$userList = $this->readFile();

		foreach ($userList as $key => $value) {
			if ($value['id'] == $data['id']) {
				$userList[$key]['display_name'] = $data['display_name'];
				$userList[$key]['profile_pic'] = empty($data['profile_pic']) ? $userList[$key]['profile_pic'] : $data['profile_pic'];
				$userList[$key] = $this->setCommonEditColumn($userList[$key]);
				break;
			}
		}

		$this->writeFile($userList);

		$this->menuPermissionManager->editMenuPermission($data);
		$this->otpPermissionManager->editOtpPermission($data);
	}

	public function getAllDataWithPermission($data) {
		$user = $this->getUserById($data);

		$menuPer = $this->menuPermissionManager->getMenuPermissionListByUsername($user['username'])['menu_id'];
		$otpPer = $this->otpPermissionManager->getOtpPermissionListByUsername($user['username'])['otp_id'];

		$menu = $this->menuManager->getAllMenuList($data);
		$aes = new AesEncryptorService();
		$new_menu = [];
		foreach ($menu as $key => $value) {
			if (in_array($aes->decrypt($value['id']), $menuPer)) {
				$new_menu[$key] = $value['id'];
			}
		}

		$otpList = $this->otpManager->getAllOtpList()[1]['data'];
		$new_otp = [];
		foreach ($otpList as $key => $value) {
			if (in_array($aes->decrypt($value['id']), $otpPer)) {
				$new_otp[$key] = $value['id'];
			}
		}

		$user['menu_permission'] = $new_menu;
		$user['otp_permission'] = $new_otp;
		unset($user['password']);

		return $user;
	}

	public function updateLogoutStatus($username) {
		$userList = $this->readFile();

		foreach ($userList as $key => $value) {
			if ($value['username'] == $username) {
				$userList[$key]['is_login'] = 0;
				$userList[$key]['logout_time'] = date('Y-m-d H:i:s', time());
				break;
			}
		}

		$this->writeFile($userList);
	}

	public function updatePassword($username, $data) {
		$userList = $this->readFile();

		$ok = false;
		foreach ($userList as $key => $value) {
			if ($value['username'] == $username && $value['password'] == $data['current_password']) {
				$userList[$key]['password'] = $data['new_password'];
				$userList[$key] = $this->setCommonEditColumn($userList[$key]);
				$ok = true;
				break;
			}
		}
		$this->writeFile($userList);
		return $ok;
	}

	public function getUserByUsername($data) {
		$list = $this->findUniqueData("username", $data['username']);
		return $list;
	}

	public function getUserById($data) {
		$list = $this->findUniqueData("id", $data['id']);
		return $list;
	}

	public function checkUserExist($data) {
		return $this->isDataExist("username", $data['username']);
	}

	public function checkUserExistById($data) {
		return $this->isDataExist("id", $data['id']);
	}

	protected function fileName() {
		return "user_account";
	}
}
