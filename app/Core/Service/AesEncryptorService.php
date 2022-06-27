<?php
declare (strict_types = 1);

namespace App\Core\Service;

class AesEncryptorService {

	private $key = "8733c9c8fad6e9f05df32865fb9cc652";

	public function __construct() {

	}

	public function encrypt($contents) {
		return base64_encode(openssl_encrypt($contents, 'AES-256-ECB', $this->key, 0));
	}

	public function decrypt($contents) {
		return openssl_decrypt(base64_decode($contents), 'AES-256-ECB', $this->key, 0);
	}
}
