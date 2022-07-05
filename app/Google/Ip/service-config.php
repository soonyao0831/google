<?php

use App\Google\Ip\Service\AddIpService;
use App\Google\Ip\Service\GetIpListService;

return [
	"/get/ip/list" => [
		"service" => GetIpListService::class,
	],
	"/add/ip" => [
		"service" => AddIpService::class,
	],
];