<form method="get" id="set-date">
	<span>시작일</span><input type="date" name="start_date">
	<span>종료일</span><input type="date" name="end_date">
	<button type="submit" class="mini-btn">검색</button>
</form>
<?php if (isset($_GET['start_date'])): ?>
	<?php for ($i = 1; $i <= 4; $i++): ?>
		<img src="/img/graph/bar<?php echo $i ?>.php" alt="bar<?php echo $i ?>" style="margin: 10px 20px;">
		<img src="/img/graph/pie<?php echo $i ?>.php" alt="pie<?php echo $i ?>" style="margin: 10px 20px;">
	<?php endfor; ?>
<?php endif; ?>