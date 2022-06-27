<?php
declare (strict_types = 1);

namespace Middleware;

use App\Google\Menu\Manager\MenuManager;
use App\Google\Menu\Manager\MenuPermissionManager;
use App\Google\User\Manager\UserManager;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthorizationMiddleware {

	public function __invoke(Request $request, RequestHandler $handler): Response{
		session_start();
		$path = $request->getUri()->getPath();

		if ($path != "/web/login" && $path != "/auth/login") {
			if (!isset($_SESSION['expire'])) {
				header("Location: /web/login");
				exit();
			}
			$expire = $_SESSION['expire'];
			if (time() >= $expire) {
				header("Location: /web/login");
				exit();
			}

			$this->isUserDeleted();
			$this->authMenuPermission($path);
		} else {
			if (isset($_SESSION['expire'])) {
				$expire = $_SESSION['expire'];
				if (time() <= $expire) {
					header("Location: /web/home");
					exit();
				}
			}
		}
		return $handler->handle($request);
	}

	private function authMenuPermission($path) {

		$data['username'] = $_SESSION['username'];
		$manager = new MenuManager(new MenuPermissionManager());
		$allMenu = $manager->getAllMenuList([]);
		$ok = false;
		foreach ($allMenu as $key => $value) {
			if ($value['menu_path'] == $path) {
				$ok = true;
				break;
			}
		}
		if ($ok) {
			$ok = false;
			$menu = $manager->getMenuList($data);
			foreach ($menu as $key => $value) {
				if ($value['menu_path'] == $path) {
					$ok = true;
				}
			}
			if (!$ok) {
				if (!strpos($path, 'modal')) {
					header("Location: " . $menu[0]['menu_path']);
					exit();
				}
			}
		}
	}

	private function isUserDeleted() {
		$data['username'] = $_SESSION['username'];
		$manager = new UserManager();
		$ok = $manager->checkUserExist($data);
		if (!$ok) {
			session_unset();
			session_destroy();
			header("Location: /web/login");
			exit();
		}
	}
}