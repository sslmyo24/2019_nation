let slideNum = 0;
let slideTimer;

const setSlideTimer = _ => {
	slideTimer = setInterval(_ => {
		++slideNum;
		slideAnimation();
	}, 4000);
}

const slideAnimation = _ => {
	const parent = $("#main-visual");
	const target = $(".slide", parent);
	if (slideNum > 2) slideNum = 0;
	let backIdx = $(".slide-btn.chk").index();
	target.eq(backIdx).fadeOut(400, function() {
		target.eq(slideNum).fadeIn(400);
		parent.find('.slide-btn').eq(backIdx).toggleClass('chk');
		parent.find('.slide-btn').eq(slideNum).toggleClass('chk');
	});
}

const changeSlide = function () {
	const idx = $(this).index();
	clearInterval(slideTimer);
	slideNum = idx;
	slideAnimation();
	setSlideTimer();
}

const slidePaging = function () {
	clearInterval(slideTimer);
	if ($(this).index() == 0) slideNum--;
	else slideNum++;
	slideAnimation();
	setSlideTimer();
}

const scrollAnimation = _ => {
	const st = $(window).scrollTop();
	const sb = st + $(window).height();
	$.each($(".animation"), (i, v) => {
		const ot = $(v).offset().top;
		const ob = ot + $(v).outerHeight();
		if (st <= ot && sb >= ob) {
			if ($(v).hasClass('animationBefore')) $(v).removeClass('animationBefore');
		}
		else {
			if (!$(v).hasClass('animationBefore')) $(v).addClass('animationBefore');
		}
	});
}

const cursorAnimation = e => {
	const x = e.clientX;
	const y = e.clientY;
	const px = x/$(window).width()*50 - 25;
	const py = y/$(window).height()*50 - 25;
	$(".animation").css("transform", `translate(${px}px, ${py}px)`);
}

const listSlide = function () {
	const target = $(this).parent('section').find('.list-wrap');
	let eleWidth = target.find('article').width();
	if ($(this).hasClass('prev-btn')) {
		const lastEle = target.find('article:last-child');
		target.prepend(lastEle);
		target.css("margin-left", (-eleWidth)+"px");
		target.animate({
			marginLeft: "0"
		});
	} else if ($(this).hasClass('next-btn')) {
		const firstEle = target.find('article:first-child');
		if (target.parent('.list').is("#history-list")) eleWidth += 30;
		else eleWidth += 75;
		target.animate({
			marginLeft: (-eleWidth)+"px"
		}, _ => {
			target.append(firstEle);
			target.css("margin-left", "0");
		});
	} else return;
}

const partnerAnimation = _ => {
	const target = $("#partner-list");
	setInterval(_ => {
		target.animate({
			marginLeft: (-target.width()/6)+"px"
		}, _ => {
			const firstEle = target.find('div:first-child');
			target.append(firstEle);
			target.css("margin-left", "0");
		});
	}, 2000);
}

$(document)
.ready(function() {
	$("head").append(`
		<style>
			.slide-controls {position: absolute; left: 0; width: 100%; display: flex; justify-content: center;}
			.slide-controls > div {height: 100%; display: flex; justify-content: space-between;}
			#slide-btn-wrap {height: 20px; bottom: 30px;}
			#slide-btn-wrap > div {width: 80px;}
			#slide-btn-wrap .slide-btn {width: 20px; height: 100%; background: #fff; border-radius: 50%;  cursor: pointer;}
			#slide-btn-wrap .slide-btn.chk {background: #09f;}
			#slide-move {bottom: 45%;}
			#slide-move > div {width: 80%;}
			#slide-move .slide-move-btn {font-size: 60px; color: #fff; cursor: pointer;}
			.animation {transition: .5s; opacity: 1;}
			.animation.animationBefore {opacity: 0;}
			#scrolling-btn {position: fixed; top: 20%; right: 0; width: 70px; height: 70px; background: #aaa; display: flex; justify-content: center; align-items: center; transition: .5s;}
			#scrolling-btn > a {color: #fff; font-size: 17px; transition: .5s;}
			#scrolling-btn:hover {background: #fff;}
			#scrolling-btn:hover > a {color: #aaa;}
		</style>
	`);

	$("body").append(`
		<div id="scrolling-btn"><a href="/movie/ticketing">영화<br>예매</a></div>
	`);

	$("#main-visual").append(`
		<div id="slide-move" class="slide-controls">
			<div>
				<div id="slide-prev" class="slide-move-btn"><i class="fa fa-angle-left"></i></div>
				<div id="slide-next" class="slide-move-btn"><i class="fa fa-angle-right"></i></div>
			</div>
		</div>
		<div id="slide-btn-wrap" class="slide-controls">
			<div>
				<div class="slide-btn chk"></div>
				<div class="slide-btn"></div>
				<div class="slide-btn"></div>
			</div>
		</div>
	`);

	$(".list").addClass('animation animationBefore');

	scrollAnimation();
	setSlideTimer();
	partnerAnimation();
})
.on("click", ".slide-btn", changeSlide)
.on("click", ".slide-move-btn", slidePaging)
.on("click", ".slide-btn", listSlide)

$(window)
.on("scroll", scrollAnimation)
.on("mousemove", cursorAnimation)