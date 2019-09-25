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
			<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="setBooth">
				<input type="hidden" name="img">
				<div class="form-date">
					<label for="start"><span>행사시작일</span><input type="date" name="start_date" id="start" required></label>
					<label for="end"><span>행사종료일</span><input type="date" name="end_date" id="end" required></label>
				</div>
				<label for="max"><input type="number" name="max_personnel" step="1" min="1" value="1"></label>
				<button type="submit">등록하기</button>
			</form>
		</article>
	</section>

	<script>

		$(".action-form > form").submit(e => {
			e.preventDefault()
			const blob = new Blob([$("#svgCanvas")[0].outerHTML.replace(/1px/g, '2px')], {type: "image/svg+xml"})
			const src = URL.createObjectURL(blob)
			e.target.img.value = src
			// $('.action-form [name="img"]').val(blob)
			// $('.action-form > form')[0].submit()
			e.target.submit()
		})

		$('[name="start_date"]').change(e => {
			$('[name="end_date"]').attr('min', e.target.value)
		})
	</script>