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
