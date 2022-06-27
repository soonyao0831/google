<?php
declare (strict_types = 1);

use Slim\Exception\HttpException;

return function ($app) {
	$connection_exception = null;
	try {
		$app->run();
	} catch (HttpException $e) {
		echo $e->getDescription();
	} catch (
		\RedisException |
		\PDOException $e
	) {
		echo $e->getMessage();
	}
};