<section>
	<h2>영화티저 콘테스트</h2>
	<div class="teaser-list">
	<?php foreach ($this->teaserList as $data): ?>
		<article onclick="location.href = '<?php echo HOME ?>/movie/view?idx=<?php echo $data->idx ?>'">
			<img src="<?php echo $data->cover ?>" alt="cover<?php echo $data->idx ?>">
			<div>이름 : <?php echo $data->name ?></div>
			<div>평가점수 : <?php echo $this->sum[$data->idx] ?></div>
		</article>
	<?php endforeach; ?>
	</div>
</section>