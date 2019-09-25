	<section id="site-admin">
		<h2>사이트관리자</h2>
		<article>
			<h3>Save</h3>
			<div id="saved"></div>
		</article>
		<article>
			<h3>Layout</h3>
			<div id="layout"></div>
		</article>
		<article>
			<h3>Type</h3>
			<div id="type"></div>
		</article>
		<article class="action-form">
			<form method="post">
				<input type="hidden" name="action" value="setPlan">
				<input type="hidden" name="layout">
				<div class="form-date">
					<label for="start"><span>행사시작일</span><input type="date" name="start_date" id="start" min="now" required></label>
					<label for="end"><span>행사종료일</span><input type="date" name="end_date" id="end" required></label>
				</div>
				<label for="max"><input type="number" name="max" step="1" min="1" value="1"></label>
				<button type="submit">등록하기</button>
			</form>
		</article>
	</section>

	<script>

		$(_ => {
			let date = new Date()
			date = `${date.getFullYear()}-${`0${date.getMonth() + 1}`.substring(-2)}-${date.getDate()}`
			start.min = date
			end.min = date
		})
		.on('submit', 'form', e => {
			e.target.layout.value = layout.querySelector('svg').outerHTML
		})
		.on('change', '#start', e => {
			$(end).attr('min', e.target.value)
		})

	</script>

	<!-- js -->
	<script src="<?php echo HOME ?>/public/js/app.js"></script>
