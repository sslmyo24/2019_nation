	<section id="site-admin">
		<h2>참가업체 부스 배치도</h2>
		<div class="action-form">
			<form>
				<select name="pidx">
				<?php foreach ($this->plan_list as $data): ?>
					<option value="<?php echo $data->idx ?>" <?php if (isset($_GET['pidx']) && $_GET['pidx'] == $data->idx): ?> selected <?php endif; ?>><?php echo $data->start_date ?> ~ <?php echo $data->end_date ?></option>
				<?php endforeach; ?>
				</select>
			</form>
		</div>
		<div id="svgImg"></div>
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
					<th>참가업체명</th>
					<th>부스번호</th>
					<th>전시품목</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($this->company_list as $k => $data): ?>
				<tr>
					<td><?php echo $k + 1?></td>
					<td><?php echo $data->name ?></td>
					<td><?php echo $data->booth ?></td>
					<td>-</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</section>

	<script>
		const svg = `<?php echo $this->select_plan->layout ?>`
		const svgHTML = svg.replace(/foreignobject/g, 'foreignObject').replace(/1px/g, '2px')
		const blob = new Blob([svgHTML], {type: "image/svg+xml"})
		const img = document.createElement('img')
		img.src = URL.createObjectURL(blob)
		$(svgImg).append(img)

		$('form > select').change(e => location.replace(`<?php echo HOME ?>/booth/plan?pidx=${e.target.value}`))
	</script>