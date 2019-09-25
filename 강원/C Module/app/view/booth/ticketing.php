<section>
	<h2>예매하기</h2>
	<div class="action-form">
		<div>
			<span>행사일정 선택</span>
			<select name="pidx">
				<option value="">행사일정을 선택해주세요</option>
			<?php foreach ($this->plan_list as $data): ?>
				<option value="<?php echo $data->idx ?>" <?php if (isset($_GET['pidx']) && $_GET['pidx'] == $data->idx): ?> selected <?php endif; ?>><?php echo $data->start_date ?> ~ <?php echo $data->end_date ?></option>
			<?php endforeach; ?>
			</select>
		</div>
		<div>
			<span>예매율 정보</span>
		<?php if (isset($_GET['pidx'])): ?>
			<div id="ticketing-graph">
				<img src="<?php echo HOME ?>/booth/graph?pidx=<?php echo $_GET['pidx'] ?>" alt="graph">
				<ul>
					<li><span>참관가능인원</span><?php echo $this->max ?> 명</li>
					<li><span>예매인원</span><?php echo $this->cnt ?> 명</li>
					<li><span>예매율</span><?php echo floor($this->cnt/$this->max*100) ?> %</li>
				</ul>
			</div>
		<?php else: ?>
			<input type="text" disabled placeholder="행사일정을 선택해주세요">
		<?php endif; ?>
		</div>
		<form method="post"> 
			<input type="hidden" name="action" value="ticketing">
		<?php if (isset($_GET['pidx'])): ?>
			<input type="hidden" name="pidx" value="<?php echo $_GET['pidx'] ?>">
		<?php endif; ?>
			<button type="submit">예매하기</button>
		</form>
	</div>
	<table id="company-list" cellspacing="0">
		<colgroup>
			<col width="15%">
			<col width="35%">
			<col width="25%">
			<col width="25%">
		</colgroup>
		<thead>
			<tr>
				<th>번호</th>
				<th>행사일정</th>
				<th>예매일</th>
				<th>예매취소</th>
			</tr>
		</thead>
		<tbody>
	<?php if (isset($_GET['pidx'])): ?>
		<?php foreach ($this->ticketing_list as $k => $data): ?>
			<tr>
				<td><?php echo $k + 1 ?></td>
				<td><?php echo $data->start_date ?> ~ <?php echo $data->start_date ?></td>
				<td><?php echo $data->date ?></td>
				<td><button type="button" onclick="location.replace('<?php echo HOME ?>/booth/ticketing_cancel?idx=<?php echo $data->idx ?>')">취소</button></td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
		</tbody>
	</table>
</section>

<script>
	$('[name="pidx"]').change(e => e.target.value && location.replace(`<?php echo HOME ?>/booth/ticketing?pidx=${e.target.value}`))
</script>