	<section>
		<h2>상영작검색</h2>
		<div class="search-header">
			<h3>검색</h3>
			<form method="get">
				<div class="radios">
					<span>분류</span>
					<div>
						<label for="all">
							<input type="radio" name="category" value="전체" id="all" <?php if (!isset($_GET['category']) || $_GET['category'] == '전체'): ?> checked <?php endif; ?>>
							<span>전체</span>
						</label>
						<label for="category1">
							<input type="radio" name="category" value="극영화" id="category1" <?php if (isset($_GET['category']) && $_GET['category'] == '극영화'): ?> checked <?php endif; ?>>
							<span>극영화</span>
						</label>
						<label for="category2">
							<input type="radio" name="category" value="다큐멘터리" id="category2" <?php if (isset($_GET['category']) && $_GET['category'] == '다큐멘터리'): ?> checked <?php endif; ?>>
							<span>다큐멘터리</span>
						</label>
						<label for="category3">
							<input type="radio" name="category" value="애니메이션" id="category3" <?php if (isset($_GET['category']) && $_GET['category'] == '애니메이션'): ?> checked <?php endif; ?>>
							<span>애니메이션</span>
						</label>
						<label for="category4">
							<input type="radio" name="category" value="기타" id="category4" <?php if (isset($_GET['category']) && $_GET['category'] == '기타'): ?> checked <?php endif; ?>>
							<span>기타</span>
						</label>
					</div>
				</div>
				<label for="key">
					<span>검색어</span>
					<input type="text" name="key" id="key" placeholder="검색어를 입력해주세요">
				</label>
				<button type="submit">검색</button>
			</form>
			<div class="search-info">
				<span>전체 <span class="num"><?php echo $this->all ?>개</span></span>
				<span>검색 결과 <span class="num"><?php echo count($this->schList) ?>개</span></span>
			</div>
		</div>
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