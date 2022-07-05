<?php
declare (strict_types = 1);

namespace App\Google\Ip\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\Ip\Manager\IpManager;
use Psr\Http\Message\ResponseInterface as Response;

class GetIpListService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new IpManager();
		$ip = $manager->getAllIpList();
		return $this->respond($ip);
	}

	protected function validateData($data) {
		return [];
	}
}