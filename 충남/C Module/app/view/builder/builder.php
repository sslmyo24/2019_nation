	<div id="admin">
		<div id="header">
			<a href="/admin/logout">로그아웃</a>
			<a href="/builder/statistic">접속통계</a>
			<span id="session-time">남은 시간 <span class="hour"></span>:<span class="min"></span>:<span class="sec"></span></span>
		</div>

		<div id="page-manager">
			<h2>페이지 관리</h2>
		
			<button id="page-insert" type="button" class="btn">페이지추가</button>
			<button id="page-delete" type="button" class="btn">페이지삭제</button>
			<button id="page-upload" type="button" class="btn">페이지 적용하기</button>
		
			<div id="page-list" class="list">
				<h3>페이지목록</h3>
				<ul>
					<li class="active"><span class="name">Page1</span><button type="button" class="mini-btn page-update modal-btn"data-target="update">페이지수정</button></li>
					<li><span class="name">Page2</span><button type="button" class="mini-btn page-update modal-btn" data-target="update">페이지수정</button></li>
					<li><span class="name">Page3</span><button type="button" class="mini-btn page-update modal-btn" data-target="update">페이지수정</button></li>
				</ul>
			</div>
		</div>
				
		<div id="preview">
			<div></div>
		</div>

		<div id="page-edit">
			<h2>페이지 제작</h2>

			<button id="layout-insert" type="button" class="btn">레이아웃추가</button>
			<button id="layout-reset" type="button" class="btn">레이아웃초기화</button>
			<button id="layout-setting" type="button" class="btn modal-btn">설정</button>

			<div id="template-list" class="list">
				<h3>템플릿목록</h3>
				<ul>
					<li>Visual_1</li>
					<li>Visual_2</li>
					<li>Features_1</li>
					<li>Features_2</li>
					<li>Gallery&Slider_1</li>
					<li>Gallery&Slider_2</li>
					<li>Contacts_1</li>
					<li>Contacts_2</li>
				</ul>
			</div>

			<div id="header-edit" class="edit">
				<button class="btn modal-btn" data-target="logo" type="button">로고수정</button>
				<div id="menu-list" class="list">
					<h3>메뉴</h3>
					<ul>
						<li><a href="#">MENU1</a><button type="btn" class="remove-btn">x</button></li>
						<li><a href="#">MENU2</a><button type="btn" class="remove-btn">x</button></li>
						<li><a href="#">MENU3</a><button type="btn" class="remove-btn">x</button></li>
						<li class="input"><input type="text" id="new-menu"></li>
					</ul>
				</div>
			</div>

			<div id="Visual-edit" class="edit">
				<button class="btn modal-btn" data-target="visual" type="button">비주얼이미지수정</button>
				<div class="list">
					<ul>
						<li><span>타이틀</span><button class="hide-btn mini-btn" data-target="h1">감추기</button><button class="show-btn mini-btn" data-target="h1">보이기</button></li>
						<li><span>요약설명</span><button class="hide-btn mini-btn" data-target="p">감추기</button><button class="show-btn mini-btn" data-target="p">보이기</button></li>
						<li><span>바로가기링크</span><button class="hide-btn mini-btn" data-target="button">감추기</button><button class="show-btn mini-btn" data-target="button">보이기</button></li>
					</ul>
				</div>
			</div>

			<div id="Features-edit" class="edit">
				<label for="feature-title" class="titleChange"><span>문단타이틀</span><input type="text" id="feature-title"></label>
				<div class="list">
					<ul>
						<li><span>타이틀</span><button class="hide-btn mini-btn" data-target="h3">감추기</button><button class="show-btn mini-btn" data-target="h3">보이기</button></li>
						<li><span>아이콘</span><button class="hide-btn mini-btn" data-target="img">감추기</button><button class="show-btn mini-btn" data-target="img">보이기</button></li>
						<li><span>텍스트</span><button class="hide-btn mini-btn" data-target="p">감추기</button><button class="show-btn mini-btn" data-target="p">보이기</button></li>
						<li><span>링크버튼</span><button class="hide-btn mini-btn" data-target="button">감추기</button><button class="show-btn mini-btn" data-target="button">보이기</button></li>
					</ul>
				</div>
			</div>

			<div id="GallerySlider-edit" class="edit">
				<label for="gallery-title" class="titleChange"><span>문단타이틀</span><input type="text" id="gallery-title"></label>
				<div class="list">
					<ul>
						<li><span>타이틀</span><button class="hide-btn mini-btn" data-target="h3">감추기</button><button class="show-btn mini-btn" data-target="h3">보이기</button></li>
						<li><span>서브타이틀</span><button class="hide-btn mini-btn" data-target=".sub">감추기</button><button class="show-btn mini-btn" data-target=".sub">보이기</button></li>
						<li><span>텍스트</span><button class="hide-btn mini-btn" data-target=".desc">감추기</button><button class="show-btn mini-btn" data-target=".desc">보이기</button></li>
					</ul>
				</div>
			</div>

			<div id="Contacts-edit" class="edit">
				<label for="contact-title" class="titleChange"><span>문단타이틀</span><input type="text" id="contact-title"></label>
				<div class="list">
					<ul>
						<li><span>주소</span><button class="hide-btn mini-btn" data-target=".address">감추기</button><button class="show-btn mini-btn" data-target=".address">보이기</button></li>
						<li><span>전화번호</span><button class="hide-btn mini-btn" data-target=".tel">감추기</button><button class="show-btn mini-btn" data-target=".tel">보이기</button></li>
						<li><span>이메일</span><button class="hide-btn mini-btn" data-target=".email">감추기</button><button class="show-btn mini-btn" data-target=".email">보이기</button></li>
					</ul>
				</div>
				<button class="btn modal-btn" data-target="background" type="button">배경색변경</button>
			</div>

			<div id="footer-edit" class="edit">
				<button class="btn modal-btn" data-target="background" type="button">배경색변경</button>
			</div>

		</div>
	
	</div>

	<div class="modal" id="update">
		<div class="wrap">
			<button type="button" class="modal-close">X</button>
			<form method="post">
				<div><input type="text" name="code" placeholder="고유코드"></div>
				<div><input type="text" name="name" placeholder="페이지 이름"></div>
				<div><input type="text" name="title" placeholder="title"></div>
				<div><input type="text" name="description" placeholder="description"></div>
				<div><input type="text" name="keyword" placeholder="keyword"></div>
				<input type="hidden" name="idx">
				<button type="submit" class="btn">전송</button>
			</form>
		</div>
	</div>

	<div class="modal" id="logo">
		<div class="wrap">
			<button type="button" class="modal-close">X</button>
			<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="upload">
				<label for="logoSelect">
					<span>로고선택</span>
					<input type="file" name="img" id="logoSelect">
				</label>
			</form>
		</div>
	</div>

	<div class="modal" id="visual">
		<div class="wrap">
			<button type="button" class="modal-close">X</button>
			<form method="post" enctype="multipart/form-data">
				<label for="visualSelect">
					<span>비주얼이미지선택</span>
					<input type="file" name="img" id="visualSelect" multiple>
				</label>
			</form>
		</div>
	</div>

	<div class="modal" id="context" style="background: none; opacity: 1">
		<div class="wrap" style="position: fixed;">
			<form method="post" enctype="multipart/form-data">
				<div class="url style">
					<label for="context1">
						<span>텍스트변경</span>
						<input type="text" name="text" id="context1">
					</label>
				</div>
				<div class="style">
					<label for="context2">
						<span>텍스트색상</span>
						#<input type="text" name="textColor" size="9" id="context2">
					</label>
				</div>
				<div class="style">
					<label for="context3">
						<span>폰트크기</span>
						<input type="number" step="1" min="1" name="fontSize" style="width: 70px" id="context3">px
					</label>
				</div>
				<div class="url">
					<label for="context4">
						<span>URL</span>
						<input type="text" name="url" id="context4">
					</label>
				</div>
				<div class="img">
					<label for="context5">
						<span>IMG</span>
						<input type="file" name="img" id="context5">
					</label>
				</div>
				<div class="icon" style="width: auto">
					<label for="context6">
						<span>ICON</span>
						<input type="file" name="icon" id="context6">
					</label>
					<div id="icon-list" style="display: flex; flex-wrap: wrap;"></div>
				</div>
				<button class="btn" type="submit" style="height: 30px; margin: 0 auto; margin-top: 20px;">변경</button>
			</form>
		</div>
	</div>

	<div class="modal" id="background">
		<div class="wrap">
			<button type="button" class="modal-close">X</button>
			<ul>
				<li data-color="white"></li>
				<li data-color="blue"></li>
				<li data-color="green"></li>
				<li data-color="yellow"></li>
				<li data-color="orange"></li>
				<li data-color="red"></li>
				<li data-color="#333"></li>
			</ul>
		</div>
	</div>