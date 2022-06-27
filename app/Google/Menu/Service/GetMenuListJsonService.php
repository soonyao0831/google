<?php
declare (strict_types = 1);

namespace App\Google\Menu\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\Menu\Manager\MenuManager;
use App\Google\Menu\Manager\MenuPermissionManager;
use Psr\Http\Message\ResponseInterface as Response;

class GetMenuListJsonService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new MenuManager(new MenuPermissionManager());
		$menu = $manager->getAllMenuList($data);
		$response = [];
		foreach ($menu as $key => $value) {
			$response[$key]['value'] = $value['id'];
			$response[$key]['title'] = $value['menu_name'];
		}
		return $this->respond($response, "获取成功。");
	}

	protected function validateData($data) {
		return [];
	}
}