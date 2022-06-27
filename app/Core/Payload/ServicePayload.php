<?php
declare (strict_types = 1);

namespace App\Core\Payload;

use JsonSerializable;

class ServicePayload implements JsonSerializable {

	private $statusCode;

	private $data;

	private $error;

	private $message;

	private $success;

	public function __construct(
		int $statusCode = 200,
		$message = null,
		$data = null,
		$success = true,
		? ActionError $error = null
	) {
		$this->message = $message;
		$this->statusCode = $statusCode;
		$this->data = $data;
		$this->error = $error;
		$this->success = $success;
	}

	public function getStatusCode() : int {
		return $this->statusCode;
	}

	public function getData() {
		return $this->data;
	}

	public function getError():  ? ActionError {
		return $this->error;
	}

	public function jsonSerialize() {
		$payload = [
			'statusCode' => $this->statusCode,
		];

		if ($this->data !== null) {
			$payload['data'] = $this->data;
		} elseif ($this->error !== null) {
			$payload['error'] = $this->error;
		}

		if ($this->message !== null) {
			$payload['message'] = $this->message;
		}
		if ($this->success !== null) {
			$payload['success'] = $this->success;
		}

		return $payload;
	}
}
