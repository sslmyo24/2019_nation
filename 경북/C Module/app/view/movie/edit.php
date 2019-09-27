	<section id="teaser-edit">
		<div id="video-edit">
			<div class="none">동영상을 선택하세요</div>
			<div class="top wrap"></div>
			<div class="move wrap"></div>
			<video width="800" height="450"></video>
			<svg width="800" height="450"></svg>
		</div>
		<div id="times">
			<div id="video-time"><span class="current">00:00:00:00</span>/<span class="duration">00:00:00:00</span></div>
			<div id="clip-time"><span class="current">00:00:00:00</span>/<span class="duration">00:00:00:00</span></div>
		</div>
		<div id="timeline">
			<ul></ul>
			<div class="timeline-current"></div>
		</div>
		<div id="edit-tools">
			<a href="#" class="draw" id="Line">자유곡선</a>
			<a href="#" class="draw" id="Rect">사각형</a>
			<a href="#" class="draw" id="Text">텍스트</a>
			<a href="#" class="draw" id="select">선택</a>
			<a href="#" class="state" id="play">재생</a>
			<a href="#" class="state" id="pause">정지</a>
			<a href="#" id="all">전체 삭제</a>
			<a href="#" id="one">선택 삭제</a>
			<a href="#" id="down">다운로드</a>
		</div>
		<div id="edit-styles">
			<div>
				<span>색상</span>
				<label for="color1">
					<input type="radio" name="color" id="color1" value="#999" checked>
					<span>gray</span>
				</label>
				<label for="color2">
					<input type="radio" name="color" id="color2" value="#09f">
					<span>blue</span>
				</label>
				<label for="color3">
					<input type="radio" name="color" id="color3" value="#0f9">
					<span>green</span>
				</label>
				<label for="color4">
					<input type="radio" name="color" id="color4" value="#ed0">
					<span>yellow</span>
				</label>
			</div>
			<div>
				<span>선 두께</span>
				<label for="weight1">
					<input type="radio" name="weight" id="weight1" value="3" checked>
					<span>3px</span>
				</label>
				<label for="weight2">
					<input type="radio" name="weight" id="weight2" value="5">
					<span>5px</span>
				</label>
				<label for="weight3">
					<input type="radio" name="weight" id="weight3" value="10">
					<span>10px</span>
				</label>
			</div>
			<div>
				<span>글자크기</span>
				<label for="size1">
					<input type="radio" name="size" id="size1" value="16" checked>
					<span>16px</span>
				</label>
				<label for="size2">
					<input type="radio" name="size" id="size2" value="18">
					<span>18px</span>
				</label>
				<label for="size3">
					<input type="radio" name="size" id="size3" value="24">
					<span>24px</span>
				</label>
				<label for="size4">
					<input type="radio" name="size" id="size4" value="32">
					<span>32px</span>
				</label>
			</div>
		</div>
		<form method="post" name="editFrm">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="svg">
			<input type="hidden" name="cover">
			<input type="hidden" name="video">
			<button type="subimt">콘테스트 참여하기</button>
		</form>
		<div id="poster-list">
			<a href="#" data-url="<?php echo HOME ?>/public/movie/movie1.mp4">
				<img src="<?php echo HOME ?>/public/movie/movie1-cover.jpg" alt="movie1">
			</a>
			<a href="#" data-url="<?php echo HOME ?>/public/movie/movie2.mp4">
				<img src="<?php echo HOME ?>/public/movie/movie2-cover.jpg" alt="movie2">
			</a>
			<a href="#" data-url="<?php echo HOME ?>/public/movie/movie3.mp4">
				<img src="<?php echo HOME ?>/public/movie/movie3-cover.jpg" alt="movie3">
			</a>
			<a href="#" data-url="<?php echo HOME ?>/public/movie/movie4.mp4">
				<img src="<?php echo HOME ?>/public/movie/movie4-cover.jpg" alt="movie4">
			</a>
			<a href="#" data-url="<?php echo HOME ?>/public/movie/movie5.mp4">
				<img src="<?php echo HOME ?>/public/movie/movie5-cover.jpg" alt="movie5">
			</a>
		</div>
	</section>

	<script>
		$("#poster-list > a").click(e => {
			_this = e.currentTarget
			editFrm.video.value = _this.dataset.url;
			editFrm.cover.value = $(_this).find('img').attr('src')
		})

		$(editFrm).submit(e => {
			e.preventDefault()
			if (!e.target.video.value) {
				alert('비디오를 선택해주세요')
				return false
			}

			const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg')
			data.clips.forEach(({el, start, end}) => {
				const clone = el.cloneNode(true)
				setAttr(clone, { 'data-start': start, 'data-end': end })
				svg.appendChild(clone)
			})
			setAttr(svg, { width: 800, height: 450 })

			e.target.svg.value = svg.outerHTML

			e.target.submit()
		})
	</script>
