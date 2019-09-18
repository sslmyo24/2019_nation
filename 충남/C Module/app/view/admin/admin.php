<div id="member-form">
	<div class="wrap">
		<h1>로그인</h1>
		<form method="post">
			<input type="hidden" name="action" value="login">
			<label for="id"><span>ID</span><input type="text" name="id" id="id" required></label>
			<label for="pw"><span>password</span><input type="password" name="pw" id="pw" required></label>
			<button type="submit" class="btn">로그인</button>
			<button type="button" class="btn" onclick="location.replace('/admin/join')">회원 가입</button>
		</form>
	</div>
</div>