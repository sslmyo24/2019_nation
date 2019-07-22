
	<style>
		h2 {line-height: 100px; border-bottom: 3px solid #000;}
		#movie-info {display: flex; justify-content: space-between; margin: 50px 0;}
		#movie-img {width: 55%;}
		#movie-img > img {max-width: 100%;}
		#movie-dec {width: 40%;}
		#timetable > table {width: 100%; border: 1px solid #000;}
		#timetable thead {background: #000; color: #fff;}
		#timetable caption {font-size: 25px; margin-bottom: 10px; font-weight: bold; text-align: left;}
		h3 {margin-top: 50px; font-size: 20px; margin-bottom: 5px;}
		#comment-form {width: 100%; display: flex;}
		#comment-form > textarea {width: 95%; height: 60px; padding: 5px; box-sizing: border-box;}
		#comment-form > button {width: 60px; height: 60px; padding: 5px; border: none; background: #000; color: #fff;}
		#comment-list {margin-top: 30px; width: 100%;}
		#comment-list > li {width: 100%;}
		#comment-list p:first-child {font-size: 17px; padding-left: 10px; margin-bottom: 5px;}
		#comment-list span:first-child {margin-right: 30px;}
		#comment-list .delete-btn {background: transparent; border: none; margin-left: 30px; color: #09f; font-size: 13px;}
		#comment-list .comment-content {background: #eee; border-radius: 10px; line-height: 50px; font-size: 15px; padding-left: 10px;}
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
			<h2><?php echo $this->movie_info->title ?></h2>
			<div id="movie-info">
				<div id="movie-img"><img src="<?php echo SRC ?>/data/posterImage/<?php echo $this->movie_info->posterImage ?>" alt="<?php echo $this->movie_info->title ?>"></div>
				<table id="movie-dec">
					<tr>
						<td>영화명</td>
						<td><?php echo $this->movie_info->title ?></td>
					</tr>
					<tr>
						<td>감독</td>
						<td><?php echo $this->movie_info->director ?></td>
					</tr>
					<tr>
						<td>제작국가</td>
						<td><?php echo $this->movie_info->country ?></td>
					</tr>
					<tr>
						<td>섹션</td>
						<td><?php echo $this->movie_info->section ?></td>
					</tr>
					<tr>
						<td>러닝타임</td>
						<td><?php echo $this->movie_info->runningTime ?>분</td>
					</tr>
				</table>
			</div>
			<div id="timetable">
				<table cellspacing="0">
					<caption>상영정보</caption>
					<colgroup>
						<col width="25%">
						<col width="25%">
						<col width="25%">
						<col width="25%">
					</colgroup>
					<thead>
						<tr>
							<th>예매코드</th>
							<th>상영관</th>
							<th>상영일</th>
							<th>상영시간</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($this->time_list as $data): ?>
						<tr>
							<td><?php echo $data->code ?></td>
							<td><?php echo $data->name ?></td>
							<td><?php echo $data->day ?></td>
							<td><?php echo $data->time ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<h3>댓글</h3>
		<?php if ($this->param->isMember): ?>
			<form id="comment-form" method="post">
				<input type="hidden" name="action" value="comment">
				<textarea name="content" placeholder="댓글 작성"></textarea>
				<button type="submit">작성</button>
			</form>
		<?php endif; ?>
			<ul id="comment-list">
			<?php foreach ($this->comment_list as $data): ?>
				<li>
					<p><span class="writer">작성자 : <?php echo $data->name ?></span><span>작성일 : <?php echo $data->date ?></span><?php if ($this->param->isMember && $this->param->member->idx == $data->midx): ?><button class="delete-btn" onclick="location.replace('<?php echo HOME ?>/movie/comment_delete?idx=<?php echo $data->idx ?>')">삭제</button><?php endif; ?></p>
					<p class="comment-content"><?php echo $data->content ?></p>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</section>