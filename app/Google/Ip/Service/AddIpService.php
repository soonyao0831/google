<?php
declare (strict_types = 1);

namespace App\Google\Ip\Service;

use App\Core\Service\HttpAbstractService;
use App\Google\Ip\Manager\IpManager;
use Psr\Http\Message\ResponseInterface as Response;

class AddIpService extends HttpAbstractService {

	protected function action($data): Response{
		$manager = new IpManager();
		$manager->addIp($data['ip_list']);
		return $this->respond();
	}

	protected function validateData($data) {
		return [];
	}
}