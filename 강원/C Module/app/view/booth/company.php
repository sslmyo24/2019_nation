	<section id="site-admin">
		<h2>참가업체 부스신청</h2>
		<div class="action-form">
			<form method="get">
				<select name="pidx">
				<?php foreach ($this->plan_list as $data): ?>
					<option value="<?php echo $data->idx ?>" <?php if (isset($_GET['pidx']) && $_GET['pidx'] == $data->idx): ?> selected <?php endif; ?>><?php echo $data->start_date ?> ~ <?php echo $data->end_date ?></option>
				<?php endforeach; ?>
				</select>
			</form>
		</div>
		<div id="svgImg"></div>
		<div class="action-form">
			<form method="post">
				<input type="hidden" name="action" value="setBooth">
				<input type="hidden" name="pidx" value="<?php echo $this->select_plan->idx ?>">
				<div>
					<span>부스 선택</span>
					<select name="booth" id="booth">
						<option value="">부스를 선택하세요.</option>
					</select>
				</div>
				<button type="submit">등록하기</button>
			</form>
		</div>
		<table id="company-list" cellspacing="0">
			<colgroup>
				<col width="10%">
				<col width="35%">
				<col width="20%">
				<col width="15%">
				<col width="20%">
			</colgroup>
			<thead>
				<tr>
					<th>번호</th>
					<th>행사일정</th>
					<th>부스신청일</th>
					<th>부스번호</th>
					<th>부스크기 ㎡</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($this->company_list as $k => $data): ?>
				<tr>
					<td><?php echo $k + 1?></td>
					<td><?php echo $data->start_date ?> ~ <?php echo $data->start_date ?></td>
					<td><?php echo $data->date ?></td>
					<td><?php echo $data->booth ?></td>
					<td><?php echo $data->area ?></td>
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

		const div = document.createElement('div')
		div.innerHTML = svg
		const boothList = [...div.querySelectorAll('.draw > div')].map(v => ({...v.dataset, name: v.innerHTML}))
		const connected = <?php echo $this->connected; ?>;
		boothList.sort((a,b) => a.booth - b.booth)
		booth.innerHTML += `
			${boothList.map(({area, name}) => 
				`<option value="${name},${area}" ${connected.indexOf(name) !== -1 ? 'disabled' : ''}>${name} (${area} ㎡)</option>`
			).join('')}
		`


		$('form > select').change(e => location.replace(`<?php echo HOME ?>/admin/booth?pidx=${e.target.value}`))
	</script>