<?php
declare (strict_types = 1);

namespace App\Google\Test\Service;

use App\Core\Service\HttpAbstractService;
use Psr\Http\Message\ResponseInterface as Response;

class TestService extends HttpAbstractService {

	protected function action($data): Response{
		$size = $_FILES['audio_data']['size']; //the size in bytes
		$input = $_FILES['audio_data']['tmp_name']; //temporary name that PHP gave to the uploaded file
		$output = time() . ".wav"; //letting the client control the filename is a rather bad idea

		//move the file from temp name to local folder using $output name
		if (move_uploaded_file($_FILES["audio_data"]["tmp_name"], 'public/' . $output)) {
			return $this->respond(["recorder_name" => '/public/' . $output], "ok");
		}
		return $this->respond($data, $_FILES);
	}

	protected function validateData($data) {

		return [];
	}
}