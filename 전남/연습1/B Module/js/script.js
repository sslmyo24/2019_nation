const loadOn = _ => {
	if (!sessionStorage.getItem('loadFirst')) loadAnimation();
}

const loadAnimation = _ => {
	$("head").append(`
		<style>
			#loading {background: #fff; position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; z-index: 1000000;}
			#loading > div {width: 300px; height: 168.75px; position: relative;}
			#loading img {max-width: 100%; position: absolute;}
			#loading img:first-child {animation: 1.5s slate infinite;}
			@keyframes slate {
				0% {transform: rotate(0) translateY(0);}
				20% {transform: rotate(20deg) translateY(22px);}
				100% {transform: rotate(0) translateY(0);}
			}
		</style>
	`);

	$("body").append(`
		<div id="loading">
			<div>
				<img src="./load/top.png" alt="load" />
				<img src="./load/bottom.png" alt="load" />
			</div>
		</div>
	`);

	$("html").css({overflow: 'hidden'});

	setTimeout(_ => {
		$("#loading").fadeOut('slow');
		$("html").removeAttr('style');
	}, 3000);

	sessionStorage.setItem('loadFirst', true);
}

$(loadOn)