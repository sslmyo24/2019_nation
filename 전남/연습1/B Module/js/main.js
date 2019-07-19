
const visualSilde = _ => {
	const parent = $("#main-visual");
	const target = $(".slide", parent);

	let idx = 0;

	setInterval(_ => {
		idx++;
		if (idx > 2) idx = 0;
		let backIdx = idx == 0 ? 2 : idx - 1;
		target.eq(backIdx).fadeOut(400, function() {
			target.eq(idx).fadeIn(400);
			parent.find('.slide-btn').eq(backIdx).toggleClass('chk');
			parent.find('.slide-btn').eq(idx).toggleClass('chk');
		});
	}, 4000);
}

$(document).ready(function() {
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
		</style>
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

	visualSilde();
});
