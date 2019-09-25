<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>부산국제모터쇼</title>

	<!-- css -->
	<link rel="stylesheet" href="/public/fontawesome-free-5.1.0-web/css/all.css">
	<link rel="stylesheet" href="/public/style.css">

	<!-- js -->
	<script src="/public/js/jquery-latest.min.js"></script>
</head>
<body>
	
	<header>
		<div class="contact">
			<div class="admin-info">
				<span><i class="fas fa-phone"></i><span>(051)740-3520, 3516</span></span>
				<span><i class="fas fa-fax"></i><span>(051)740-3404</span></span>
				<span><i class="fas fa-envelope"></i><span>bimos@bexco.co.kr</span></span>
			</div>
			<div class="social">
				<a href="#"><img src="/public/img/social/icon1.png" alt="social1"></a>
				<a href="#"><img src="/public/img/social/icon2.png" alt="social2"></a>
				<a href="#"><img src="/public/img/social/icon3.png" alt="social3"></a>
				<a href="#"><img src="/public/img/social/icon4.png" alt="social4"></a>
			</div>
		</div>

		<div class="navigation">
			<div id="site-logo">
				<img src="/public/img/logo.png" alt="부산국제모터쇼">
			</div>

			<nav id="gnb">
				<ul>
					<li class="main-menu">
						<a href="/home">부산국제모터쇼</a>
						<ul>
							<li><a href="/home/summary">행사소개</a></li>
							<li><a href="/home/history">모터쇼 연혁</a></li>
						</ul>
					</li>
				<?php if ($this->member()): ?>
					<li><a href="/member/logout">로그아웃</a></li>
				<?php else: ?>
					<li><a href="/member/login">로그인</a></li>
					<li><a href="/member/join">회원가입</a></li>
				<?php endif; ?>
					<li><a href="#">예매하기</a></li>
					<li class="main-menu">
						<a href="#">관람안내</a>
						<ul>
							<li><a href="#">참가업체부스배치도</a></li>
						</ul>
					</li>
					<li class="main-menu">
						<a href="/admin">관리자</a>
						<ul>
							<li><a href="/admin">사이트관리자</a></li>
							<li><a href="#">참가업체 부스신청</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</header>

	<section id="<?php if ($this->url->type == 'home'): ?>main<?php else:  ?>sub<?php endif; ?>-visual" class="visual">
	<?php if ($this->url->type == 'home'): ?>
		<div class="slide">
			<div></div>
			<div></div>
			<div></div>
		</div>

		<div class="visual-text"></div>
	<?php else: ?>
		<h1>부산국제모터쇼</h1>
	<?php endif; ?>
	</section>