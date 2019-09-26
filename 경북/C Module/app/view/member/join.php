	<section>
		<div class="action-form">
			<h2>회원가입</h2>
			<form method="post">
				<input type="hidden" name="action" value="join">
				<label for="id">
					<span>ID</span>
					<input type="text" name="id" id="id" placeholder="영문, 영문숫자조합" required>
				</label>
				<label for="pw">
					<span>PASSWORD</span>
					<input type="password" name="pw" id="pw" placeholder="8자리 이상" required>
				</label>
				<label for="name">
					<span>이름</span>
					<input type="text" name="name" id="name" placeholder="한글 4글자 이하" required>
				</label>
				<button type="submit">가입하기</button>
			</form>
		</div>
	</section>
