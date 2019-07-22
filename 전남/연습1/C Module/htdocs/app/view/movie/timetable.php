	<style>
		.select-box {border: 1px solid #000; padding: 20px 0 20px 30px;}
		.select-box button {border: none; font-size: 17px; background: transparent; margin-right: 10px; cursor: pointer; outline: none;}
		.select-box button:hover {text-decoration: underline;}
		.select-box button.chk {color: #09f; text-decoration: underline;}
		#select-kind, #select-kind > div, #select-theater, .theater-list {display: none;}
		#timetable > table {width: 100%; display: none;}
		#timetable thead {background: #000; color: #fff;}
		#timetable td {border: 1px solid #aaa; padding: 5px;}
		#timetable .movie-code {font-weight: bold;}
		#timetable .movie-time {padding-left: 15px; color: #09f;}
		#timetable a {color: #000;}
		#timetable a:hover {text-decoration: underline;}
	</style>

	<section class="visual" id="sub-visual">
		<h1>상영시간표</h1>
	</section>

	<section id="content">
		<div id="sub-nav">
			<div id="main-menu-title"><a href="#">예매</a></div>
			<div class="sub-menu-title checked"><a href="<?php echo HOME ?>/movie/timetable">상영시간표</a></div>
			<div class="sub-menu-title"><a href="<?php echo HOME ?>/movie/ticketing">영화예매</a></div>
			<div class="sub-menu-title"><a href="./history.html">예매내역</a></div>
		</div>
		<div class="main-content">
			<div class="select-box" id="select-standard">
				<button <?php if (isset($_GET['day'])): ?> class="chk" <?php endif; ?>>날짜별</button>
				<button <?php if (isset($_GET['code'])): ?> class="chk" <?php endif; ?>>극장별</button>
				<button <?php if (isset($_GET['section'])): ?> class="chk" <?php endif; ?>>섹션별</button>
			</div>
			<div class="select-box" id="select-kind" <?php if (isset($_GET['standard'])): ?> style="display: block;" <?php endif; ?>>
				<div id="standard-date" <?php if (isset($_GET['day'])): ?> style="display: block;" <?php endif; ?>>
					<button <?php if (isset($_GET['day']) && $_GET['day'] == '3'): ?> class="chk" <?php endif; ?>>3</button>
					<button <?php if (isset($_GET['day']) && $_GET['day'] == '4'): ?> class="chk" <?php endif; ?>>4</button>
					<button <?php if (isset($_GET['day']) && $_GET['day'] == '5'): ?> class="chk" <?php endif; ?>>5</button>
					<button <?php if (isset($_GET['day']) && $_GET['day'] == '6'): ?> class="chk" <?php endif; ?>>6</button>
					<button <?php if (isset($_GET['day']) && $_GET['day'] == '7'): ?> class="chk" <?php endif; ?>>7</button>
					<button <?php if (isset($_GET['day']) && $_GET['day'] == '8'): ?> class="chk" <?php endif; ?>>8</button>
					<button <?php if (isset($_GET['day']) && $_GET['day'] == '9'): ?> class="chk" <?php endif; ?>>9</button>
					<button <?php if (isset($_GET['day']) && $_GET['day'] == '10'): ?> class="chk" <?php endif; ?>>10</button>
					<button <?php if (isset($_GET['day']) && $_GET['day'] == '11'): ?> class="chk" <?php endif; ?>>11</button>
					<button <?php if (isset($_GET['day']) && $_GET['day'] == '12'): ?> class="chk" <?php endif; ?>>12</button>
				</div>
				<div id="standard-theater" <?php if (isset($_GET['code'])): ?> style="display: block;" <?php endif; ?>>
					<button <?php if (isset($_GET['code']) && $_GET['name'] == '영화의전당'): ?> class="chk" <?php endif; ?> data-name="영화의전당">영화의전당</button>
					<button <?php if (isset($_GET['code']) && $_GET['name'] == 'CGV'): ?> class="chk" <?php endif; ?> data-name="CGV">CGV</button>
					<button <?php if (isset($_GET['code']) && $_GET['name'] == '롯데시네마'): ?> class="chk" <?php endif; ?> data-name="롯데시네마">롯데시네마</button>
					<button <?php if (isset($_GET['code']) && $_GET['name'] == '소향씨어터'): ?> class="chk" <?php endif; ?> data-name="소향씨어터">소향씨어터</button>
					<button <?php if (isset($_GET['code']) && $_GET['name'] == '메가박스'): ?> class="chk" <?php endif; ?> data-name="메가박스">메가박스</button>
				</div>
				<div id="standard-section" <?php if (isset($_GET['section'])): ?> style="display: block;" <?php endif; ?>>
					<button <?php if (isset($_GET['section']) && $_GET['section'] == '개폐막작'): ?> class="chk" <?php endif; ?>>개폐막작</button>
					<button <?php if (isset($_GET['section']) && $_GET['section'] == '월드 시네마'): ?> class="chk" <?php endif; ?>>월드 시네마</button>
					<button <?php if (isset($_GET['section']) && $_GET['section'] == '와이드 앵글'): ?> class="chk" <?php endif; ?>>와이드 앵글</button>
					<button <?php if (isset($_GET['section']) && $_GET['section'] == '갈라 프레젠테이션'): ?> class="chk" <?php endif; ?>>갈라 프레젠테이션</button>
					<button <?php if (isset($_GET['section']) && $_GET['section'] == '아시아 영화의 창'): ?> class="chk" <?php endif; ?>>아시아 영화의 창</button>
					<button <?php if (isset($_GET['section']) && $_GET['section'] == '뉴 커런츠'): ?> class="chk" <?php endif; ?>>뉴 커런츠</button>
					<button <?php if (isset($_GET['section']) && $_GET['section'] == '미드나잇 패션'): ?> class="chk" <?php endif; ?>>미드나잇 패션</button>
					<button <?php if (isset($_GET['section']) && $_GET['section'] == '플래시 포워드'): ?> class="chk" <?php endif; ?>>플래시 포워드</button>
					<button <?php if (isset($_GET['section']) && $_GET['section'] == '오픈 시네마'): ?> class="chk" <?php endif; ?>>오픈 시네마</button>
				</div>
			</div>
			<div class="select-box" id="select-theater" <?php if (isset($_GET['code'])): ?> style="display: block;" <?php endif; ?>>
				<div class="theater-list" data-name="영화의전당" <?php if (isset($_GET['code']) && $_GET['name'] == '영화의전당'): ?> style="display: block;" <?php endif; ?>>
					<button data-code="01" <?php if (isset($_GET['code']) && $_GET['code'] == '01'): ?> class="chk" <?php endif; ?>>영화의전당 야외극장</button>
					<button data-code="02" <?php if (isset($_GET['code']) && $_GET['code'] == '02'): ?> class="chk" <?php endif; ?>>영화의전당 하늘연극장</button>
					<button data-code="03" <?php if (isset($_GET['code']) && $_GET['code'] == '03'): ?> class="chk" <?php endif; ?>>영화의전당 중극장</button>
					<button data-code="04" <?php if (isset($_GET['code']) && $_GET['code'] == '04'): ?> class="chk" <?php endif; ?>>영화의전당 소극장</button>
					<button data-code="05" <?php if (isset($_GET['code']) && $_GET['code'] == '05'): ?> class="chk" <?php endif; ?>>영화의전당 시네마테크</button>
				</div>
				<div class="theater-list" data-name="CGV" <?php if (isset($_GET['code']) && $_GET['name'] == 'CGV'): ?> style="display: block;" <?php endif; ?>>
					<button data-code="06" <?php if (isset($_GET['code']) && $_GET['code'] == '06'): ?> class="chk" <?php endif; ?>>CGV 1관</button>
					<button data-code="07" <?php if (isset($_GET['code']) && $_GET['code'] == '07'): ?> class="chk" <?php endif; ?>>CGV 2관</button>
					<button data-code="08" <?php if (isset($_GET['code']) && $_GET['code'] == '08'): ?> class="chk" <?php endif; ?>>CGV 3관</button>
					<button data-code="09" <?php if (isset($_GET['code']) && $_GET['code'] == '09'): ?> class="chk" <?php endif; ?>>CGV 4관</button>
					<button data-code="10" <?php if (isset($_GET['code']) && $_GET['code'] == '10'): ?> class="chk" <?php endif; ?>>CGV 5관</button>
				</div>
				<div class="theater-list" data-name="롯데시네마" <?php if (isset($_GET['code']) && $_GET['name'] == '롯데시네마'): ?> style="display: block;" <?php endif; ?>>
					<button data-code="11" <?php if (isset($_GET['code']) && $_GET['code'] == '11'): ?> class="chk" <?php endif; ?>>롯데시네마 1관</button>
					<button data-code="12" <?php if (isset($_GET['code']) && $_GET['code'] == '12'): ?> class="chk" <?php endif; ?>>롯데시네마 2관</button>
					<button data-code="13" <?php if (isset($_GET['code']) && $_GET['code'] == '13'): ?> class="chk" <?php endif; ?>>롯데시네마 3관</button>
					<button data-code="14" <?php if (isset($_GET['code']) && $_GET['code'] == '14'): ?> class="chk" <?php endif; ?>>롯데시네마 4관</button>
				</div>
				<div class="theater-list" data-name="소향씨어터" <?php if (isset($_GET['code']) && $_GET['name'] == '소향씨어터'): ?> style="display: block;" <?php endif; ?>>
					<button data-code="15" <?php if (isset($_GET['code']) && $_GET['code'] == '15'): ?> class="chk" <?php endif; ?>>소향씨어터 신한카드홀</button>
				</div>
				<div class="theater-list" data-name="메가박스" <?php if (isset($_GET['code']) && $_GET['name'] == '메가박스'): ?> style="display: block;" <?php endif; ?>>
					<button data-code="16" <?php if (isset($_GET['code']) && $_GET['code'] == '16'): ?> class="chk" <?php endif; ?>>메가박스 1관</button>
					<button data-code="17" <?php if (isset($_GET['code']) && $_GET['code'] == '17'): ?> class="chk" <?php endif; ?>>메가박스 2관</button>
					<button data-code="18" <?php if (isset($_GET['code']) && $_GET['code'] == '18'): ?> class="chk" <?php endif; ?>>메가박스 3관</button>
					<button data-code="19" <?php if (isset($_GET['code']) && $_GET['code'] == '19'): ?> class="chk" <?php endif; ?>>메가박스 4관</button>
					<button data-code="20" <?php if (isset($_GET['code']) && $_GET['code'] == '20'): ?> class="chk" <?php endif; ?>>메가박스 5관</button>
				</div>
			</div>
			<div id="timetable">
				<table id="date-timetable" cellspacing="0" <?php if (isset($_GET['day'])): ?> style="display: table" <?php endif; ?>>
					<colgroup>
						<col width="20%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
					</colgroup>
					<thead>
						<tr>
							<th>극장 / 회차</th>
							<th>01</th>
							<th>02</th>
							<th>03</th>
							<th>04</th>
						</tr>
					</thead>
					<tbody>
				<?php if (isset($_GET['day'])): ?>
					<?php foreach ($this->theater_list as $key => $theater):?>
						<?php $time_list = "time_list".$key; ?>
						<tr>
							<td><?php echo $theater->name ?></td>
						<?php foreach ($this->$time_list as $data): ?>
							<?php $title = explode("/", $data->title); ?>
							<td>
								<p><span class="movie-code"><?php echo $data->movieCode ?></span><span class="movie-time"><?php echo $data->time ?></span></p>
								<p class="movie-name"><a href="<?php echo HOME ?>/movie/info?code=<?php echo $data->movieCode ?>"><?php echo $title[0] ?></a></p>
								<p class="movie-en-name"><a href="<?php echo HOME ?>/movie/info?code=<?php echo $data->movieCode ?>"><?php echo $title[1] ?></a></p>
							</td>
						<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
					</tbody>
				</table>
				<table id="theater-timetable" cellspacing="0" <?php if (isset($_GET['code'])): ?> style="display: table" <?php endif; ?>>
					<colgroup>
						<col width="20%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
					</colgroup>
					<thead>
						<tr>
							<th>날짜 / 회차</th>
							<th>01</th>
							<th>02</th>
							<th>03</th>
							<th>04</th>
						</tr>
					</thead>
					<tbody>
				<?php if (isset($_GET['code'])): ?>
					<?php foreach ($this->day_list as $key => $day):?>
						<?php $time_list = "time_list".$key; ?>
						<tr>
							<td><?php echo $day->day ?></td>
						<?php foreach ($this->$time_list as $data): ?>
							<?php $title = explode("/", $data->title); ?>
							<td>
								<p><span class="movie-code"><?php echo $data->movieCode ?></span><span class="movie-time"><?php echo $data->time ?></span></p>
								<p class="movie-name"><a href="<?php echo HOME ?>/movie/info?code=<?php echo $data->movieCode ?>"><?php echo $title[0] ?></a></p>
								<p class="movie-en-name"><a href="<?php echo HOME ?>/movie/info?code=<?php echo $data->movieCode ?>"><?php echo $title[1] ?></a></p>
							</td>
						<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
					</tbody>
				</table>
				<table id="section-timetable" cellspacing="0" <?php if (isset($_GET['section'])): ?> style="display: table;" <?php endif; ?>>
					<colgroup>
						<col width="20%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
					</colgroup>
					<thead>
						<tr>
							<th>영화명</th>
							<th>상영관</th>
							<th>상영시간</th>
							<th>상영일</th>
							<th>예매코드</th>
						</tr>
					</thead>
					<tbody>
				<?php if (isset($_GET['section'])): ?>
					<?php foreach ($this->movie_list as $key => $movie): ?>
						<?php $time_list = "time_list".$key; ?>
						<?php $title = explode("/", $movie->title); ?>
						<tr>
							<td>
								<p class="movie-name"><a href="<?php echo HOME ?>/movie/info?code=<?php echo $data->movieCode ?>"><?php echo $title[0] ?></a></p>
								<p class="movie-en-name"><a href="<?php echo HOME ?>/movie/info?code=<?php echo $data->movieCode ?>"><?php echo $title[1] ?></a></p>
							</td>
							<td>
							<?php foreach ($this->$time_list as $data): ?>
								<p><?php echo $data->name ?></p>
							<?php endforeach; ?>
							</td>
							<td>
							<?php foreach ($this->$time_list as $data): ?>
								<p><?php echo $data->time ?></p>
							<?php endforeach; ?>
							</td>
							<td>
							<?php foreach ($this->$time_list as $data): ?>
								<p><?php echo $data->day ?></p>
							<?php endforeach; ?>
							</td>
							<td>
							<?php foreach ($this->$time_list as $data): ?>
								<p><?php echo $data->code ?></p>
							<?php endforeach; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				<?php endif; ?>
				</table>
			</div>
		</div>
	</section>

	<script>
		$(".select-box button").click(function(event) {
			$(this).parent().find('button.chk').removeClass('chk');
			$(this).addClass('chk');
		});
		$("#select-standard > button:not(.chk)").click(function(event) {
			$("#select-kind").show();
			$("#select-kind > div").hide();
			$("#select-theater").hide();
			$("table").hide();
			if ($(this).index() == 0) {
				$("#select-kind > #standard-date").show();
			} else if ($(this).index() == 1) {
				$("#select-kind > #standard-theater").show();
			} else {
				$("#select-kind > #standard-section").show();
			}
		});
		$("#standard-theater > button").click(function(event) {
			const name = $(this).data('name');
			$(".theater-list").hide();
			$(".theater-list").each(function(index, el) {
				if (name === $(el).data('name')) {
					$("#select-theater").show();
					$(el).show();
					return;
				}
			});
		});
		$("#select-kind > div:not(#standard-theater) > button").click(function(event) {
			$("table").hide();
			if ($(this).parent().index() == 0) {
				$("#date-timetable").show();
			} else if ($(this).parent().index() == 2) {
				$("#section-timetable").show();
			}
		});
		$("#select-theater button").click(function(event) {
			$("table").hide();
			$("#theater-timetable").show();
		});
		$("#standard-date > button").click(function(event) {
			const val = $(this).text();
			location.replace("/movie/timetable?standard=date&day="+val);
		});
		$(".theater-list > button").click(function(event) {
			const name = $(this).parent().data('name');
			const code = $(this).data('code');
			location.replace("/movie/timetable?standard=theater&name="+name+"&code="+code);
		});
		$("#standard-section > button").click(function(event) {
			const name = $(this).text();
			location.replace("/movie/timetable?standard=section&section="+name);
		});
	</script>