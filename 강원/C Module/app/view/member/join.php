<div id="member-form">
	<h2>회원가입</h2>
	<form method="post">
		<input type="hidden" name="action" value="join">
		<label for="id"><input type="text" name="id" id="id" placeholder="아이디"></label>
		<label for="pw"><input type="password" name="pw" id="pw" placeholder="비밀번호"></label>
		<label for="pw_chk"><input type="password" name="pw_chk" id="pw_chk" placeholder="비밀번호 확인"></label>
		<label for="name"><input type="text" name="name" id="name" placeholder="이름/업체명"></label>
		<select name="level">
			<option value="A">일반회원</option>
			<option value="B">기업회원</option>
		</select>
		<button type="submit">회원가입</button>
	</form>
</div>