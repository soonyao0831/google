<?php

use App\Google\User\Service\AddUserService;
use App\Google\User\Service\EditUserService;
use App\Google\User\Service\GetUserListService;
use App\Google\User\Service\GetUserProfileService;
use App\Google\User\Service\GetUserWithAllPermissionService;
use App\Google\User\Service\UploadUserImageService;

return [
	"/get/user/profile" => [
		"service" => GetUserProfileService::class,
	],
	"/get/user/list" => [
		"service" => GetUserListService::class,
	],
	"/add/user" => [
		"service" => AddUserService::class,
	],
	"/edit/user" => [
		"service" => EditUserService::class,
	],
	"/upload/user/profile/img" => [
		"service" => UploadUserImageService::class,
	],
	"/get/user/with/all/permission/data" => [
		"service" => GetUserWithAllPermissionService::class,
	],
];