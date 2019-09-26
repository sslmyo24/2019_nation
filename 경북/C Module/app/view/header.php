<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>부산국제영화제</title>

	<!-- css -->
	<link rel="stylesheet" href="<?php echo HOME ?>/public/fontawesome-free-5.1.0-web/css/all.css">
	<link rel="stylesheet" href="<?php echo HOME ?>/public/style.css">

	<!-- js -->
	<script src="<?php echo HOME ?>/public/js/jquery-latset.min.js"></script>
	<script src="<?php echo HOME ?>/public/js/jquery-ui.min.js"></script>
	<script src="<?php echo HOME ?>/public/js/common.js"></script>
</head>
<body>

	<!-- header  -->
	<header>

		<div class="contact">
			<div class="admin-info">
				<span><i class="fas fa-phone"></i><span>02-3675-5097</span></span>
				<span><i class="fas fa-fax"></i><span>02-3675-5098</span></span>
			</div>
			<div class="member-btns">
			<?php if ($this->member()): ?>
				<button type="button" onclick="location.replace('<?php echo HOME ?>/member/logout')">로그아웃</button>
			<?php else: ?>
				<button type="button" onclick="location.replace('<?php echo HOME ?>/member/join')">회원가입</button>
				<button type="button" onclick="location.replace('<?php echo HOME ?>/member/login')">로그인</button>
			<?php endif; ?>
			</div>
		</div>


		<div class="navigation">

			<!-- logo -->
			<div id="site-logo"><a href="<?php echo HOME ?>/home">부산국제영화제</a></div>
			
			<input type="checkbox" id="menu">
			<label for="menu" id="menu-open"><i class="fas fa-bars"></i></label>

			<!-- navigation -->
			<nav id="gnb">
				<ul>
					<li class="main-menu">
						<a href="<?php echo HOME ?>/home">부산국제영화제</a>
						<ul class="sub-menu">
							<li><a href="<?php echo HOME ?>/home/summary">개최개요</a></li>
							<li><a href="<?php echo HOME ?>/home/guide">행사안내</a></li>
						</ul>
					</li>
					<li class="main-menu">
						<a href="<?php echo HOME ?>/movie/request">출품신청</a>
					</li>
					<li class="main-menu">
						<a href="<?php echo HOME ?>/schedule/calendar">상영일정</a>
					</li>
					<li class="main-menu">
						<a href="<?php echo HOME ?>">상영작검색</a>
					</li>
					<li class="main-menu">
						<a href="<?php echo HOME ?>/movie/contest">이벤트</a>
						<ul class="sub-menu">
							<li><a href="<?php echo HOME ?>/movie/contest">영화티저 콘테스트</a></li>
							<li><a href="<?php echo HOME ?>/movie/edit">콘테스트 참여하기</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>

	</header>

	<!-- visual -->
	<section id="<?php if ($this->url->type == 'home'): ?>main<?php else: ?>sub<?php endif; ?>-visual" class="visual">

		<div class="slide"></div>
		<div class="slide"></div>
		<div class="slide"></div>

		<h1 id="visual-text">부산국제영화제</h1>

	</section>