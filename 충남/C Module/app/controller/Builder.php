<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Builder extends App {

		function upload ($file, $type) {
			$save_name = time()."_".rand(0,99999).".{$type}";
			if (!move_uploaded_file($file['tmp_name'], "./data/{$save_name}")) {
				print_r($file);
			}
		}

		function action () {
			extract($_POST);

			switch ($action) {
				case 'upload':
					access(is_uploaded_file($_FILES['img']['tmp_name']), "이미지가 누락되었습니다.");

					$this->upload($_FILES['img'], $type);
					break;
			}
		}

	}