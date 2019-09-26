	<section>
		<div class="action-form">
			<h2>상영일정등록</h2>
			<form method="post">
				<input type="hidden" name="action" value="add">
				<label for="date">
					<span>상영일정[년/월/일]</span>
					<input type="date" name="date" id="date" required>
				</label>
				<label for="time">
					<span>상영일정[시/분]</span>
					<input type="time" name="time" id="time" required>
				</label>
				<div class="radios">
					<span>출품작선택</span>
					<div>
					<?php foreach ($this->movieList as $k => $data): ?>
						<label for="movie<?php echo $k ?>">
							<input type="radio" name="midx" id="movie<?php echo $k ?>" value="<?php echo $data->idx ?>" <?php if ($k === 0): ?> checked <?php endif; ?>>
							<span><?php echo $data->name ?></span>
						</label>
					<?php endforeach; ?>
					</div>
				</div>
				<button type="submit">출품하기</button>
			</form>
		</div>
	</section>