<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> 부산국제영화제 </title>
	<link rel="stylesheet" href="<?php echo SRC ?>/style.css">
	<link rel="stylesheet" href="<?php echo SRC ?>/fontAwesome/css/font-awesome.min.css">
	<script src="<?php echo SRC ?>/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?php echo SRC ?>/js/script.js"></script>
<?php if ($this->param->type == 'home'): ?>
	<script src="<?php echo SRC ?>/js/main.js"></script>
<?php endif; ?>
</head>
<body>
	<header>

		<!-- logo -->
		<div id="site-logo"><a href="<?php echo HOME ?>/home"><img src="<?php echo SRC ?>/logo/logo.png" alt="logo">부산국제영화제</a></div>

		<!-- navigation -->
		<nav id="gnb">
			<ul>
				<li class="main-menu"><a href="<?php echo HOME ?>/home">메인</a></li>
				<li class="main-menu"><a href="#">영화제</a>
					<ul>
						<li><a href="<?php echo HOME ?>/festival/contest">영화제소개</a></li>
						<li><a href="<?php echo HOME ?>/festival/place">행사장소개</a></li>
					</ul>
				</li>
				<li class="main-menu"><a href="#">예매</a>
					<ul>
						<li><a href="<?php echo HOME ?>/movie/timetable">상영시간표</a></li>
						<li><a href="<?php echo HOME ?>/movie/ticketing">영화예매</a></li>
						<li><a href="<?php echo HOME ?>/movie/history">예매내역</a></li>
					</ul>
				</li>
				<li class="main-menu"><a href="#">영화</a>
					<ul>
						<li><a href="#">영화안내</a></li>
					</ul>
				</li>
				<li class="main-menu"><a href="#">이벤트</a>
					<ul>
						<li><a href="#">이벤트안내</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	
		<!-- 로그인, 회원가입 -->
		<input type="radio" name="member" id="login">
		<input type="radio" name="member" id="join">
		<input type="radio" name="member" id="close-member">

		<div id="member-btns">
		<?php if ($this->param->isMember): ?>
			<a href="<?php echo HOME ?>/home/logout">로그아웃</a>
		<?php else: ?>
			<label for="login">로그인</label>
			<label for="join">회원가입</label>
		<?php endif; ?>
		</div>

		<div id="member-layer">
			<label for="close-member"></label>
			<div id="member-wrap">
				<div id="member-img"></div>
				<div id="member-forms">
					<form id="login-layer" method="post">
						<input type="hidden" name="type" value="member">
						<input type="hidden" name="action" value="login">
						<h2>로그인</h2>
						<input type="text" name="id" class="form-control" placeholder="아이디">
						<input type="password" name="pw" class="form-control" placeholder="비밀번호">
						<button type="submit">로그인</button>
					</form>
					<form id="join-layer" method="post">
						<input type="hidden" name="type" value="member">
						<input type="hidden" name="action" value="join">
						<h2>회원가입</h2>
						<input type="text" name="id" class="form-control" placeholder="아이디">
						<input type="password" name="pw" class="form-control" placeholder="비밀번호">
						<input type="password" name="pw_chk" class="form-control" placeholder="비밀번호 확인">
						<input type="text" name="name" class="form-control" placeholder="이름">
						<button type="submit">회원가입</button>
					</form>
				</div>
			</div>
		</div>

	</header>