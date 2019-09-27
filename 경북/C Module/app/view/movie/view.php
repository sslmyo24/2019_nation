<style>
	.wrap {position: relative;width: 800px;height: 450px; margin: 30px auto;}
	.wrap > svg {position: absolute;left: 0;top: 0;}
	#player {position: absolute; left: 50%; top: 50%; margin-left: -25px; margin-top: -25px; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; z-index: 100; border: 2px solid #fff; border-radius: 50%;}
</style>

<section>
	<div class="wrap">
		<div id="player">
			<svg width="20" height="20">
				<path stroke="#fff" stroke-width="1" d="M0 0 L0 20 L20 10" fill="#fff"></path>
			</svg>
		</div>
		<video src="<?php echo $this->data->video ?>" width="800" height="450"></video>
		<?php echo $this->data->svg ?>
	</div>
	<div class="video-info">
		<div><span>이름</span><?php echo $this->data->name ?></div>
		<div><span>점수</span><?php echo $this->sum ?></div>
	</div>
	<div id="rating-form">
		<form method="post">
			<input type="hidden" name="action" value="rating">
			<div class="radios">
				<h3>점수</h3>
				<div>
					<label for="point1">
						<input type="radio" name="point" id="point1" value="1" checked>
						<span>1점</span>
					</label>
					<label for="point2">
						<input type="radio" name="point" id="point2" value="2">
						<span>2점</span>
					</label>
					<label for="point3">
						<input type="radio" name="point" id="point3" value="3">
						<span>3점</span>
					</label>
					<label for="point4">
						<input type="radio" name="point" id="point4" value="4">
						<span>4점</span>
					</label>
					<label for="point5">
						<input type="radio" name="point" id="point5" value="5">
						<span>5점</span>
					</label>
					<label for="point6">
						<input type="radio" name="point" id="point6" value="6">
						<span>6점</span>
					</label>
					<label for="point7">
						<input type="radio" name="point" id="point7" value="7">
						<span>7점</span>
					</label>
					<label for="point8">
						<input type="radio" name="point" id="point8" value="8">
						<span>8점</span>
					</label>
					<label for="point9">
						<input type="radio" name="point" id="point9" value="9">
						<span>9점</span>
					</label>
					<label for="point10">
						<input type="radio" name="point" id="point10" value="10">
						<span>10점</span>
					</label>
				</div>
			</div>
			<button type="submit">입력완료</button>
			<button type="button" onclick="location.href = '<?php echo HOME ?>/movie/contest'">목록으로</button>
		</form>
	</div>
</section>

<script>
	const video = document.querySelector('video')
	const svg = document.querySelector('.wrap > svg')
	player.onclick = _ => {
		video.play()
		player.style.display = 'none'
		return false
	}
	video.ontimeupdate = _ => {
		const { currentTime: t } = video
		Array.from(svg.children).forEach(v => {
			const {start, end} = v.dataset
			v.style.cssText = start <= t && t <= end ? '' : 'opacity:0;z-index:-1'
		})
	}
</script>
