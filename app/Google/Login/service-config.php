<?php

use App\Google\Login\Service\CheckLoginSessionService;
use App\Google\Login\Service\LoginService;
use App\Google\Login\Service\LogoutService;

return [
	"/auth/login" => [
		"service" => LoginService::class,
	],
	"/auth/logout" => [
		"service" => LogoutService::class,
	],
	"/check/session/expire" => [
		"service" => CheckLoginSessionService::class,
	],
];