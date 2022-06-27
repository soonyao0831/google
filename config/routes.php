<?php
declare (strict_types = 1);

use Slim\App;
use Slim\Views\PhpRenderer;

return function (App $app, $url) {
	if ($url === "/" or $url === "") {
		header("Location: /web/login");
		exit();
	}
	if (str_starts_with($url, "/web")) {
		if ($url == "/web/login") {
			session_unset();
		}
		$a = ucfirst(preg_split("/\//", $url)[2]);
		$n = getcwd() . "/app/Google/view-config.php";

		$vc = file_exists($n) ? require $n : false;

		if (!empty($vc) and isset($vc[$url])) {
			global $view_config;
			$view_config = $vc[$url];
			$app->get($url, function ($request, $response) {
				global $view_config;
				$renderer = new PhpRenderer("app/Views");
				if (isset($view_config['layout'])) {
					$renderer->setLayout($view_config['layout']);
				}
				unset($GLOBALS['view_config']);
				if (isset($_SESSION['username'])) {
					$return["username"] = $_SESSION['username'];
					if (isset($_GET['id'])) {
						$return['id'] = $_GET['id'];
					}
					return $renderer->render($response, $view_config["view"], $return);
				} else {
					return $renderer->render($response, $view_config["view"]);
				}
			});
		}
	} else {
		$a = ucfirst(preg_split("/\//", $url)[1]);
		$n = getcwd() . "/app/Google/service-config.php";

		$sc = file_exists($n) ? require $n : false;
		if (!empty($sc) and isset($sc[$url])) {
			$app->post($url, $sc[$url]['service']);
		}
	}
};