<?php
declare (strict_types = 1);

namespace App\Google\User\Service;

use App\Constant\AppConstant;
use App\Core\Service\HttpAbstractService;
use Psr\Http\Message\ResponseInterface as Response;

class UploadUserImageService extends HttpAbstractService {

	protected function action($data): Response{

		$filename = $this->moveUploadedFile();
		return $this->respond(["filename" => $filename], "获取成功。");
	}

	protected function validateData($data) {
		if ($_FILES["file"]["size"] > 500000) {
			return ["message" => "文件太大了"];
		}
		$target_dir = AppConstant::$IMAGE_UPLOAD_DIR;
		$target_file = $target_dir . basename($_FILES["file"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
			return ["message" => "只能上传图片"];
		}
		return [];
	}

	protected function moveUploadedFile() {
		$target_dir = AppConstant::$IMAGE_UPLOAD_DIR;
		$target_file = $target_dir . basename($_FILES["file"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		$target_file = $target_dir . time() . '.' . $imageFileType;
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			return '/' . $target_file;
		}
		return false;
	}
}