	<section>
		<h2>[<?php echo date("Y-m-d", strtotime($_GET['date'])) ?>] 상영일정 상세조회</h2>
		<div class="list">
			<ul>
			<?php foreach ($this->schList as $data): ?>
				<li>
					<div class="time">
						<strong>상영시간</strong>
						<div><?php echo date("H:i", $data->start) ?> ~ <?php echo date("H:i", $data->end) ?></div>
					</div>
					<div class="info">
						<div><span>영화제목</span><?php echo $data->title ?></div>
						<div><span>출품자이름/아이디</span><?php echo $data->name ?>/<?php echo $data->id ?></div>
						<div><span>러닝타임</span><?php echo $data->duration ?></div>
						<div><span>제작년도</span><?php echo $data->year ?></div>
						<div><span>분류</span><?php echo $data->category ?></div>
					</div>
				</li>
			<?php endforeach; ?>
			</ul>
			<button type="button" onclick="location.href = '<?php echo HOME ?>/schedule/calendar'">목록으로</button>
		</div>
	</section>