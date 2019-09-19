<form method="get" id="set-date">
	<span>시작일</span><input type="date" name="start_date">
	<span>종료일</span><input type="date" name="end_date">
	<button type="submit" class="mini-btn">검색</button>
</form>
<?php if (isset($_GET['start_date'])): ?>
	<?php for ($i = 1; $i <= 4; $i++): ?>
		<img src="/img/graph/stick<?php echo $i ?>.php" alt="stick<?php echo $i ?>">
	<?php endfor; ?>
<?php endif; ?>