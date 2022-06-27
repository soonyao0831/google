<?php

use App\Google\Menu\Service\GetMenuListJsonService;
use App\Google\Menu\Service\GetMenuListService;

return [
	"/get/menu/list" => [
		"service" => GetMenuListService::class,
	],
	"/get/json/menu/list" => [
		"service" => GetMenuListJsonService::class,
	],
];