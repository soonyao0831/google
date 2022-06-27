<?php
declare (strict_types = 1);

namespace App\Google\Menu\Manager;

use App\Core\Service\AbstractReadFileService;
use App\Core\Service\AesEncryptorService;
use App\Google\Menu\Manager\MenuManager;

class MenuPermissionManager extends AbstractReadFileService {

	public function __construct() {

	}

	public function getMenuPermissionListByUsername($username) {
		$dataList = $this->readFile();
		$response = null;
		foreach ($dataList as $key => $value) {
			if ($username == $value['user_id']) {
				$response = $dataList[$key];
				break;
			}
		}
		return $response;
	}

	public function addMenuPermission($data) {
		$aes = new AesEncryptorService();
		$menuManager = new MenuManager(new MenuPermissionManager());
		$menuIdList = $menuManager->getAllMenuId();
		$ids = [];
		$data['menu_permission'] = json_decode($data['menu_permission'], true);
		foreach ($data['menu_permission'] as $key => $value) {
			$id = $aes->decrypt($value['value']);
			if (in_array($id, $menuIdList)) {
				$ids[] = intval($id);
			}
		}

		$menuPermissionList = $this->readFile();
		$getNextId = $this->getNextId($menuPermissionList);
		$menuPermissionInsert = [
			'id' => $getNextId,
			'menu_id' => $ids,
			'user_id' => $data['username'],
		];
		$menuPermissionList[] = $menuPermissionInsert;
		$this->writeFile($menuPermissionList);
	}

	public function editMenuPermission($data) {
		$aes = new AesEncryptorService();
		$menuManager = new MenuManager(new MenuPermissionManager());
		$menuIdList = $menuManager->getAllMenuId();
		$ids = [];
		$data['menu_permission'] = json_decode($data['menu_permission'], true);
		foreach ($data['menu_permission'] as $key => $value) {
			$id = $aes->decrypt($value['value']);
			if (in_array($id, $menuIdList)) {
				$ids[] = intval($id);
			}
		}

		$menuPermissionList = $this->readFile();
		foreach ($menuPermissionList as $key => $value) {
			if ($value['user_id'] == $data['username']) {
				$menuPermissionList[$key]['menu_id'] = $ids;
				break;
			}
		}
		$this->writeFile($menuPermissionList);
	}

	protected function fileName() {
		return "menu_permission";
	}
}
