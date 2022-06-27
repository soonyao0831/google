<?php
declare (strict_types = 1);

use Middleware\AuthorizationMiddleware;
use Slim\App;

return function (App $app) {
	$app->add(AuthorizationMiddleware::class);
};