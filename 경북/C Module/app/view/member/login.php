	<section>
		<div class="action-form">
			<h2>로그인</h2>
			<form method="post">
				<input type="hidden" name="action" value="login">
				<label for="id">
					<span>ID</span>
					<input type="text" name="id" id="id" placeholder="영문, 영문숫자조합" required>
				</label>
				<label for="pw">
					<span>PASSWORD</span>
					<input type="password" name="pw" id="pw" placeholder="8자리 이상" required>
				</label>
				<button type="submit">로그인</button>
			</form>
		</div>
	</section>
