<?php

return [
	"/web/user/list" => [
		"layout" => "layout-main.php",
		"view" => "User/index.php",
	],
	"/web/modal/user/add" => [
		"layout" => "layout-modal.php",
		"view" => "User/modal-add-user.php",
	],
	"/web/modal/user/edit" => [
		"layout" => "layout-modal.php",
		"view" => "User/modal-edit-user.php",
	],
	"/web/user/password" => [
		"layout" => "layout-main.php",
		"view" => "User/change-password.php",
	],
];