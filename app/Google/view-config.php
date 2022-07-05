<?php

$route_type = [
	"Login",
	"Home",
	"User",
	"Menu",
	"Otp",
	"OtpLog",
	"Ip",
	"Test",
];

$service_config = [];

foreach ($route_type as $type) {
	$sc = require __DIR__ . '/' . $type . '/view-config.php';
	foreach ($sc as $u => $c) {
		$service_config[$u] = $c;
	}
}

return $service_config;