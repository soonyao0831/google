<?php
declare (strict_types = 1);

namespace App\Core\Service;

abstract class AbstractReadFileService {

	protected function readFile($fileName = "") {
		if ($fileName == "") {
			$fileName = $this->fileName();
		}
		return json_decode(file_get_contents(getcwd() . "/database/" . $fileName . ".json"), true);
	}

	protected function writeFile($data, $fileName = "") {
		if ($fileName == "") {
			$fileName = $this->fileName();
		}
		file_put_contents(getcwd() . "/database/" . $fileName . ".json", json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}

	protected function setCommonAddColumn($data) {
		$data["create_time"] = time();
		$data["create_by"] = getCurrentUserId();
		$data["create_ip"] = getRealIp();
		$data["update_time"] = null;
		$data["update_by"] = null;
		$data["update_ip"] = null;
		$data["is_deleted"] = 0;
		return $data;
	}

	protected function setCommonEditColumn($data) {
		$data["update_time"] = time();
		$data["update_by"] = getCurrentUserId();
		$data["update_ip"] = getRealIp();
		return $data;
	}

	protected function isDataExist($column_name, $id, $fileName = "") {
		if ($fileName == "") {
			$fileName = $this->fileName();
		}
		$data = $this->readFile($fileName);
		$isExist = false;
		foreach ($data as $key => $value) {
			if ($value[$column_name] == $id) {
				$isExist = true;
				break;
			}
		}
		return $isExist;
	}

	protected function findUniqueData($column_name, $id, $fileName = "") {
		if ($fileName == "") {
			$fileName = $this->fileName();
		}
		$data = $this->readFile($fileName);
		$response = false;
		foreach ($data as $key => $value) {
			if ($value[$column_name] == $id) {
				$response[] = $data[$key];
				break;
			}
		}
		return $this->filterIsDeleted($response);
	}

	protected function filterIsDeleted($data) {
		if (is_array($data) && count($data) > 1) {
			$response = [];
			foreach ($data as $key => $value) {
				if ($value['is_deleted'] == 0) {
					$response[$key] = $data[$key];
				}
			}
		} else {
			$response = null;
			if ($data[0]['is_deleted'] == 0) {
				$response = $data[0];
			}
		}
		return $response;
	}

	protected function resetId($data) {
		$count = 0;
		foreach ($data as $key => $value) {
			$count++;
			$data[$key]['id'] = $count;
		}
		return $data;
	}

	protected function getNextId($data = array()) {
		return $data[count($data) - 1]['id'] + 1;
	}

	abstract protected function fileName();
}
