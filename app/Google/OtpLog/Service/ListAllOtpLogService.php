<?php
declare (strict_types = 1);

namespace App\Google\OtpLog\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\OtpLog\Manager\OtpLogManager;
use Psr\Http\Message\ResponseInterface as Response;

class ListAllOtpLogService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new OtpLogManager();
		$log = $manager->getAllOtpLogList();

		return $this->respond($log);
	}

	protected function validateData($data) {
		return [];
	}
}