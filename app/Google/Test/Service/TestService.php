<?php
declare (strict_types = 1);

namespace App\Google\Test\Service;

use App\Core\Service\HttpAbstractService;
use Psr\Http\Message\ResponseInterface as Response;

class TestService extends HttpAbstractService {

	protected function action($data): Response {

		return $this->respond([], "ok");
	}

	protected function validateData($data) {

		return [];
	}
}