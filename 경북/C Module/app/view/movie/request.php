	<section>
		<div class="action-form">
			<h2>출품신청</h2>
			<form method="post">
				<input type="hidden" name="action" value="request">
				<label>
					<span>출품자이름/아이디</span>
					<input type="text" placeholder="<?php echo $this->member()->name ?>/<?php echo $this->member()->id ?>" disabled>
				</label>
				<label for="name">
					<span>영화제목</span>
					<input type="text" name="name" id="name" placeholder="영화제목을 입력하세요" required>
				</label>
				<label for="duration">
					<span>러닝타임</span>
					<input type="number" step="1" min="1" value="1" name="duration" id="duration" required>
				</label>
				<label for="year">
					<span>제작년도</span>
					<input type="number" step="1" name="year" id="year" required>
				</label>
				<div class="radios">
					<span>분류</span>
					<div>
						<label for="category1">
							<input type="radio" name="category" id="category1" value="극영화" checked>
							<span>극영화</span>
						</label>
						<label for="category2">
							<input type="radio" name="category" id="category2" value="다큐멘터리">
							<span>다큐멘터리</span>
						</label>
						<label for="category3">
							<input type="radio" name="category" id="category3" value="애니메이션">
							<span>애니메이션</span>
						</label>
						<label for="category4">
							<input type="radio" name="category" id="category4" value="기타">
							<span>기타</span>
						</label>
					</div>
				</div>
				<button type="submit">출품하기</button>
			</form>
		</div>
	</section>

	<script>
		const min = (new Date()).getFullYear()
		year.setAttribute('min', min)
		year.setAttribute('value', min)
	</script>