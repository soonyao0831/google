<?php

use App\Google\OtpLog\Service\ListAllOtpLogService;
use App\Google\OtpLog\Service\SaveOtpClickLogService;

return [
	"/save/otp/click/log" => [
		"service" => SaveOtpClickLogService::class,
	],
	"/list/all/otp/log" => [
		"service" => ListAllOtpLogService::class,
	],
];