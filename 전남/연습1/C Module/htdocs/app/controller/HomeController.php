<?php
	namespace app\controller;

	use app\core\Controller;

	class HomeController extends Controller {
		// 로그아웃
		function logout () {
			session_destroy();
			alert("로그아웃 되었습니다.");
			move(HOME."/home");
		}
	}