	<section id="history">
		<h2>모터쇼 연혁</h2>
		<div class="wrap">
		<?php foreach ($this->history as $data): ?>
			<article>
				<img src="<?php echo $data[0] ?>" alt="<?php echo $data[2] ?>">
				<div class="text">
					<p class="desc"><?php echo $data[1] ?></p>
					<p class="term"><?php echo $data[3] ?></p>
					<p class="place"><?php echo $data[4] ?></p>
					<p class="country"><?php echo $data[5] ?></p>
					<p class="popluar"><?php echo $data[6] ?></p>
					<p class="popluar"><?php echo $data[7] ?></p>
					<p class="booth"><?php echo $data[8] ?></p>
				</div>
			</article>
		<?php endforeach ?>
		</div>
	</section>