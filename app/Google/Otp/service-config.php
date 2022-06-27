<?php

use App\Google\Otp\Service\GetOtpListJsonService;
use App\Google\Otp\Service\GetOtpListService;
use App\Google\Otp\Service\GetOtpRefreshStatusService;
use App\Google\Otp\Service\SetOtpSessionService;

return [
	"/get/otp/list" => [
		"service" => GetOtpListService::class,
	],
	"/set/otp/session" => [
		"service" => SetOtpSessionService::class,
	],
	"/otp/refresh/status" => [
		"service" => GetOtpRefreshStatusService::class,
	],
	"/get/json/otp/list" => [
		"service" => GetOtpListJsonService::class,
	],
];