	<style>
		#ticketing-basic-info {border: 1px solid #000; display: flex; justify-content: space-around; height: 80px; align-items: center;}
		#day-list {width: 50%; display: flex; justify-content: space-between;}
		form button {background: #000; color: #fff; border: none; width: 50px; height: 50px;}
		#bench-select > input {width: 100px; height: 40px; margin-left: 20px;}
		#timetable > table {width: 100%; border: 1px solid #000; margin-top: 20px;}
		#timetable thead th {background: #000; color: #fff; height: 40px;}
		#day-list label {cursor: pointer; font-size: 19px;}
		#day-list input:checked ~ label {color: #09f; text-decoration: underline;}
	</style>
	<section class="visual" id="sub-visual">
		<h1>영화예매</h1>
	</section>

	<section id="content">
		<div id="sub-nav">
			<div id="main-menu-title"><a href="#">예매</a></div>
			<div class="sub-menu-title"><a href="<?php echo HOME ?>/movie/timetable">상영시간표</a></div>
			<div class="sub-menu-title checked"><a href="<?php echo HOME ?>/movie/ticketing">영화예매</a></div>
			<div class="sub-menu-title"><a href="./history.html">예매내역</a></div>
		</div>
		<div class="main-content">
			<form method="post" id="ticketing-form">
				<div id="ticketing-basic-info">
					<ul id="day-list">
						<li><input type="radio" name="day" id="day3" value="3" <?php if (isset($_GET['day']) && $_GET['day'] == '3'): ?> checked <?php endif; ?>><label for="day3">3</label></li>
						<li><input type="radio" name="day" id="day4" value="4" <?php if (isset($_GET['day']) && $_GET['day'] == '4'): ?> checked <?php endif; ?>><label for="day4">4</label></li>
						<li><input type="radio" name="day" id="day5" value="5" <?php if (isset($_GET['day']) && $_GET['day'] == '5'): ?> checked <?php endif; ?>><label for="day5">5</label></li>
						<li><input type="radio" name="day" id="day6" value="6" <?php if (isset($_GET['day']) && $_GET['day'] == '6'): ?> checked <?php endif; ?>><label for="day6">6</label></li>
						<li><input type="radio" name="day" id="day7" value="7" <?php if (isset($_GET['day']) && $_GET['day'] == '7'): ?> checked <?php endif; ?>><label for="day7">7</label></li>
						<li><input type="radio" name="day" id="day8" value="8" <?php if (isset($_GET['day']) && $_GET['day'] == '8'): ?> checked <?php endif; ?>><label for="day8">8</label></li>
						<li><input type="radio" name="day" id="day9" value="9" <?php if (isset($_GET['day']) && $_GET['day'] == '9'): ?> checked <?php endif; ?>><label for="day9">9</label></li>
						<li><input type="radio" name="day" id="day10" value="10" <?php if (isset($_GET['day']) && $_GET['day'] == '10'): ?> checked <?php endif; ?>><label for="day10">10</label></li>
						<li><input type="radio" name="day" id="day11" value="11" <?php if (isset($_GET['day']) && $_GET['day'] == '11'): ?> checked <?php endif; ?>><label for="day11">11</label></li>
						<li><input type="radio" name="day" id="day12" value="12" <?php if (isset($_GET['day']) && $_GET['day'] == '12'): ?> checked <?php endif; ?>><label for="day12">12</label></li>
					</ul>
					<div id="bench-select">좌석수<input type="number" name="bench"></div>
					<button type="submit">다음</button>
				</div>
				<div id="timetable">
					<table id="timetable" cellspacing="0">
						<colgroup>
							<col width="16.67%">
							<col width="16.67%">
							<col width="16.67%">
							<col width="16.67%">
							<col width="16.67%">
							<col width="16.67%">
						</colgroup>
						<thead>
							<tr>
								<th>예매코드</th>
								<th>영화명</th>
								<th>상영관</th>
								<th>상영일</th>
								<th>상영시간</th>
								<th>좌석수</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($this->time_list as $data): ?>
							<tr>
								<td><?php echo $data->code ?></td>
								<td><?php echo $data->title ?></td>
								<td><?php echo $data->name ?></td>
								<td><?php echo $data->day ?></td>
								<td><?php echo $data->time ?></td>
								<td>164 / 164</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</section>

	<script>
		$("#day-list label").click(function(event) {
			const day = $(this).parent().find('input').val();
			location.replace('<?php echo HOME ?>/movie/ticketing?day='+day);
		});
		$("#ticketing-form").submit(function(event) {
			if ($(`input[name="day"]`).val() == null )
		});
	</script>
