<?php

	function alert ($msg) {
		echo "<script>alert('{$msg}')</script>";
	}

	function move ($url = false) {
		echo "<script>";
		echo $url ? "location.replace('{$url}')" : "history.back();";
		echo "</script>";
		exit;
	}

	function access ($bol, $msg, $url = false) {
		if (!$bol) {
			alert($msg);
			move($url);
		}
	}