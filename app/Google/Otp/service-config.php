<?php

use App\Google\Otp\Service\AddOtpService;
use App\Google\Otp\Service\EditOtpService;
use App\Google\Otp\Service\GetOtpByIdService;
use App\Google\Otp\Service\GetOtpListJsonService;
use App\Google\Otp\Service\GetOtpListService;
use App\Google\Otp\Service\GetOtpRefreshStatusService;
use App\Google\Otp\Service\ListOtpService;
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
	"/list/otp" => [
		"service" => ListOtpService::class,
	],
	"/add/otp" => [
		"service" => AddOtpService::class,
	],
	"/edit/otp" => [
		"service" => EditOtpService::class,
	],
	"/get/otp/by/id" => [
		"service" => GetOtpByIdService::class,
	],
];