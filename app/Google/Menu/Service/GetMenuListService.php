<?php
declare (strict_types = 1);

namespace App\Google\Menu\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\Menu\Manager\MenuManager;
use App\Google\Menu\Manager\MenuPermissionManager;
use Psr\Http\Message\ResponseInterface as Response;

class GetMenuListService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new MenuManager(new MenuPermissionManager());
		$menu = $manager->getMenuList($data);
		return $this->respond($menu, "获取成功。");
	}

	protected function validateData($data) {
		return [
			'username' => "账号不能为空",
		];
	}
}