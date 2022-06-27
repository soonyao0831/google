<?php

$route_type = [
	"Login",
	"Home",
	"User",
	"Menu",
	"Otp",
	"Test",
];

$service_config = [];

foreach ($route_type as $type) {
	$sc = require __DIR__ . '/' . $type . '/service-config.php';
	foreach ($sc as $u => $c) {
		$service_config[$u] = $c;
	}
}

return $service_config;