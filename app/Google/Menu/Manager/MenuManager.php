<?php
declare (strict_types = 1);

namespace App\Google\Menu\Manager;

use App\Core\Service\AbstractReadFileService;
use App\Core\Service\AesEncryptorService;
use App\Google\Menu\Manager\MenuPermissionManager;

class MenuManager extends AbstractReadFileService {

	private $menuPermission;

	public function __construct(MenuPermissionManager $menuPermission) {
		$this->menuPermission = $menuPermission;
	}

	public function getMenuList($data) {
		$menuList = $this->readFile();

		$permissionList = $this->menuPermission->getMenuPermissionListByUsername($data['username']);

		$response = [];
		if ($permissionList['menu_id'][0] === "*") {
			$response = $menuList;
		} else {
			foreach ($menuList as $key => $value) {
				foreach ($permissionList['menu_id'] as $k => $v) {
					if ($value['id'] == $v) {
						$response[] = $menuList[$key];
					}
				}
			}
		}
		foreach ($response as $key => $value) {
			unset($response[$key]['id']);
		}
		return $response;
	}

	public function getAllMenuList($data) {
		$menuList = $this->readFile();
		$aes = new AesEncryptorService();
		foreach ($menuList as $key => $value) {
			$menuList[$key]['id'] = $aes->encrypt(strval($value['id']));
		}
		return $menuList;
	}

	public function authMenuPermission($username) {

	}

	public function getAllMenuId() {
		$menuList = $this->readFile();
		$response = [];
		foreach ($menuList as $key => $value) {
			$response[] = $value['id'];
		}
		return $response;
	}

	protected function fileName() {
		return "menu";
	}
}
