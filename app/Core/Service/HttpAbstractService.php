<?php
declare (strict_types = 1);

namespace App\Core\Service;

use App\Core\Payload\ServicePayload;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class HttpAbstractService {

	protected $request;
	protected $response;

	public function __construct() {

	}

	public function __invoke(Request $request, Response $response, $args): Response{
		$this->request = $request;
		$this->response = $response;
		$this->args = $args;

		$data = $this->getFormData();
		$requiredParams = $this->validateData($data);

		$is_required = true;
		$requiredParamsCheck = [];
		foreach ($requiredParams as $key => $value) {
			if (!isset($data[$key])) {
				$requiredParamsCheck[$key] = $value;
				$is_required = false;
			} else if (isset($data[$key]) && empty($data[$key])) {
				if (strval($data[$key]) != 0 || strval($data[$key]) == "") {
					$requiredParamsCheck[$key] = $value;
					$is_required = false;
				}
			}
		}
		if (!$is_required) {
			return $this->failRespond(null, $requiredParamsCheck);
		} else {
			return $this->action($this->getFormData());
		}
	}

	protected function respond($data = null, $message = null, $success = true, int $statusCode = 200): Response{
		$payload = new ServicePayload($statusCode, $message, $data, $success);
		$json = json_encode($payload, JSON_PRETTY_PRINT);
		$this->response->getBody()->write($json);
		return $this->response
			->withHeader('Content-Type', 'application/json')
			->withStatus($payload->getStatusCode());
	}

	protected function respondTable($data = [], $message = "操作成功", $count, $code = 0): Response{
		$json = json_encode(['data' => $data, 'code' => $code, 'msg' => $message, 'count' => $count]);
		$this->response->getBody()->write($json);
		return $this->response->withHeader('Content-Type', 'application/json')->withStatus(200);
	}

	protected function failRespond($data = null, $message = null, $success = false, int $statusCode = 200): Response{
		$payload = new ServicePayload($statusCode, $message, $data, $success);
		$json = json_encode($payload, JSON_PRETTY_PRINT);
		$this->response->getBody()->write($json);
		return $this->response
			->withHeader('Content-Type', 'application/json')
			->withStatus($payload->getStatusCode());
	}

	protected function isLocalIp($ip) {
		return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
	}

	protected function getFormData() {
		$input = json_decode(file_get_contents('php://input'), true);
		if (empty($input)) {
			$input = $this->request->getParsedBody();
		}
		return $input;
	}

	protected function getRequestedHeaders() {
		return $this->request->getHeaders();
	}

	abstract protected function action($data): Response;

	abstract protected function validateData($data);
}
