<?php extract($this->info); ?>
<section>
	<h2>상영일정</h2>
	<div class="calendar">
		<div class="calendar-header">
			<h3>
				<?php echo $y ?>년
				<?php echo $m ?>년
			</h3>
			<ul class="calendar-btns">
				<li class="year"><a href="<?php echo HOME ?>/schedule/calendar?y=<?php echo $y - 1 ?>&m=<?php echo $m*1 ?>">이전년</a></li>
				<li><a href="<?php echo HOME ?>/schedule/calendar?y=<?php echo $py ?>&m=<?php echo $pm ?>">이전달</a></li>
				<li><a href="<?php echo HOME ?>/schedule/calendar?y=<?php echo $ny ?>&m=<?php echo $nm ?>">다음달</a></li>
				<li class="year"><a href="<?php echo HOME ?>/schedule/calendar?y=<?php echo $y + 1 ?>&m=<?php echo $m*1 ?>">다음년</a></li>
			</ul>
		</div>
		<table class="calendar-body" cellspacing="0">
			<thead>
				<tr>
					<th><span class="sun">일</span></th>
					<th>월</th>
					<th>화</th>
					<th>수</th>
					<th>목</th>
					<th>금</th>
					<th><span class="sat">토</span></th>
				</tr>
			</thead>
			<tbody>
			<?php for ($i = 1, $day = 1; $i <= $line; $i++): ?>
				<tr>
				<?php for ($j = 0; $j < 7; $j++): ?>
					<?php if (($i == 1 && $start > $j) || ($line == $i && $last < $j)): ?>
					<td class="none"></td>
					<?php else: ?>
					<?php $fullDate = $y.$m.substr("0{$day}", -2); ?>
					<td onclick="location.href = '<?php echo HOME ?>/schedule/view?date=<?php echo $fullDate ?>'" <?php if (date("Ymd") === $fullDate): ?> class="now" <?php endif; ?>>
						<h4 <?php if ($j === 0): ?>class="sun"<?php elseif ($j === 6): ?>class="sat"<?php endif; ?>><?php echo $day++ ?></h4>
						<ul>
						<?php
							$movieList = app\core\DB::fetchAll("SELECT m.* FROM schedule s JOIN movie m ON m.idx = s.midx where s.date = ? order by s.start", [$fullDate]);
							foreach ($movieList as $data) {
								echo "<li>{$data->name}</li>";
							}
						?>
						</ul>
					</td>
					<?php endif; ?>
				<?php endfor; ?>
				</tr>
			<?php endfor; ?>
			</tbody>
		</table>
		<button type="button" onclick="location.replace('<?php echo HOME ?>/schedule/add')">상영일정등록</button>
	</div>
</section>