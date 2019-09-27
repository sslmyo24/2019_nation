const data = {loaded: false, video: null, selected: null, weight: 3, size: 16, color: '#999', clips: []}

const Drawing = class {
	constructor (target) { this._target = document.createElementNS('http://www.w3.org/2000/svg', target) }
	get () { return this._target }
	set ({x, y}, target = this._target) {
		setAttr(target, { 'stroke': data.color, 'stroke-width': data.weight, 'fill': 'none' })
		this._x = x, this._y = y
	}
	drawing () {}
	end () { drawEnd(this._target) }
}
const Line = class extends Drawing {
	constructor ({x, y}) { super('path'); this.set({x, y}) }
	set ({x, y}) { super.set({x, y}); setAttr(this._target, {'d': `M${x} ${y}`}) }
	drawing ({x, y}) { this._target.attributes.d.value += `L${x} ${y}` }
}
const Rect = class extends Drawing {
	constructor ({x, y}) { super('rect'); this.set({x, y}) }
	set ({x, y}, target = this._target) { super.set({x, y}); setAttr(target, {x, y}) }
	drawing ({x, y}, target = this._target) {
		const width = x - this._x, height =  y - this._y
		const attr = {}
		if (width < 0) attr.x = x
		if (height < 0) attr.y = y
		setAttr(target, {...attr, width: Math.abs(width), height: Math.abs(height)})
	}
	end() { super.end(); setAttr(this._target, { 'fill': data.color }) }
}
const Text = class {
	constructor ({x, y}) {
		this.x = x, this.y = y
		const target = document.createElement('div')
		setAttr(target, {
			contentEditable: true,
			style: `position: absolute;left:${x}px;top:${y}px;font-size:${data.size}px;color:${data.color};z-index:50`
		})
		$(target)
			.on('keydown', e => { if (e.keyCode === 13) e.target.blur() })
			.on('blur', _ => { target.remove(); this.end(target.innerHTML) })
			.prependTo('#video-edit')
		setTimeout(_ => target.focus())
	}
	end (text) {
		if (text.length === 0) return
		const target = document.createElementNS('http://www.w3.org/2000/svg', 'text')
		setAttr(target, { 'dominant-baseline': 'hanging', 'x': this.x, 'y': this.y+3, 'fill': data.color, 'font-size': data.size })
		target.innerHTML = text
		$('#video-edit > svg').append(target)
		drawEnd(target)
	}
}

const setAttr = (target, attr) => { for (const key in attr) target.setAttribute(key, attr[key]) }
const timeFormat = t => [~~(t/3600), ~~(t/60)%60, ~~t%60, ~~(t*100)%100].map(v => `0${v}`.substr(-2)).join(':')
const timelineRange = ({start, end, duration}) => `left:${(start/duration) * 100}%;width:${((end - start)/duration) *100}%`
const timelineRender = arr => {
	$('#timeline ul').html(arr.map((v, k) => `
		<li data-key="${k}">
			<div data-start="${v.start}" data-end="${v.end}" data-duration="${v.duration}" style="${timelineRange(v)}"></div>
		</li>
	`).join(''))
}

const selectVideo = (_ => {
	let timer = null
	return function () {
		clearTimeout(timer)
		const video = data.video = $('video')[0]
		setAttr(video, {'src': this.dataset.url})
		video.load()
		video.oncanplay = _ => {
			$('#video-edit > .none').hide()
			data.loaded = true
			$('#video-time > .duration').html(timeFormat(video.duration))
		}
		timer = setInterval(_ => {
			$("#video-time > .current").html(timeFormat(video.currentTime))
			$('.timeline-current').css({ left: (video.currentTime / video.duration) * 800 + 'px' })
			showClip()
		})
	}
})();
const showClip = _ => {
	const { clips } = data
	const { currentTime: t } = data.video
	clips.forEach(({ el, end, start }) => {
		el.style.cssText = start <= t && t <= end ? '' : 'opacity:0;z-index:-1'
	})
}
const selectTool = e => {
	e.preventDefault()
	if (data.loaded === false) {
		alert('비디오를 선택해주세요')
		return false
	}

	const $this = $(e.target)
	if ($this.hasClass('active')) return

	const id = $this[0].id
	switch (true) {
		case id === 'one':
			const clip = $('#timeline li.active'), idx = clip.index()
			if (idx === -1) {
				alert('선택된게 없습니다.')
				return
			}
			clip.remove()
			data.clips[idx].el.remove()
			data.clips.splice(idx, 1)
			if (data.clips.length === 0) $('#timeline ul').empty()
			break
		case id === 'all':
			data.clips.forEach(v => v.el.remove())
			data.clips = []
			$('#timeline > ul').empty()
			break
		case id === 'down': downloadVideo(); break
		case $this.hasClass('state'): data.video[id]()
		default:
			$(`.${$this[0].classList[0]}.active`).removeClass('active')
			$this.addClass('active')
			if ($this.hasClass('draw')) {
				$('#video-edit > svg > .active').attr('class', '')
				$('#timeline li.active').removeClass('active')
				data.selected = id
			}
			break
	}
}
const selectStyle = (e, {name, value} = e.target) => data[name] = value
const selectShape = e => {
	const shape = $(e.currentTarget)
	const clip = $('#timeline li').eq(shape.index())
	selectWrapper(clip, shape)
}
const selectClip = e => {
	const clip = $(e.currentTarget)
	const shape = $(data.clips[clip.index()].el)
	selectWrapper(clip, shape)
}
const selectWrapper = (clip, shape) => {
	const clipChk = clip.hasClass('active')
	const clipRange = $('#clipRange')
	$('#select.draw').click()
	$('#video-edit > svg > .active').attr('class','')
	$('#timeline li.active').removeClass('active')
	clipRange.removeClass('active')
	if (!clipChk) {
		clipRange.addClass('active')
		shape.attr('class', 'active')
		clip.addClass('active')
		const {start, end} = clip.find('div')[0].dataset
		$('#clip-time > .current').html(timeFormat(start))
		$('#clip-time > .duration').html(timeFormat(end))
	}
}

const drawEnd = (el, { duration } = data.video, start = 0, end = duration) => {
	data.clips.push({ start, end, duration, el })
	timelineRender(data.clips)
}
const draw = (_ => {
	let nowTarget = null
	return e => {
		if ($('.draw.active').length === 0) return
		const { selected } = data
		const topWrap = $('#video-edit > .top')
		if (selected !== 'Text' && nowTarget && nowTarget.end && ['mouseout', 'mouseup'].indexOf(e.type) !== -1) {
			nowTarget.end()
			nowTarget = null
			topWrap.removeClass('active')
		}
		const {pageX, pageY} = e
		const {top, left} = $(e.currentTarget).offset()
		const [x, y] = [pageX - left, pageY - top]
		switch (e.type) {
			case 'mousedown':
				if (selected === 'select') return
				nowTarget = new ({Line, Rect, Text}[selected])({x, y})
				if (selected === 'Text') return
				e.target.appendChild(nowTarget.get())
				topWrap.addClass('active')
				break
			case 'mousemove': if (nowTarget && nowTarget.drawing) nowTarget.drawing({x, y}); break
		}
	}
})();
const moveShape = (_ => {
	let moving = false, x, y, target, moveChk = 0
	return e => {
		const moveWrap = $('#video-edit > .move')
		const {pageX, pageY} = e
		switch (e.type) {
			case 'mousedown':
				moveWrap.addClass('active')
				target = e.currentTarget
				const {beforeX, beforeY} = target.dataset
				moving = true, x = pageX - (beforeX || 0), y = pageY - (beforeY || 0),
				moveChk = target.getAttribute('transform')
				break
			case 'mousemove':
				if (!moving) return
				const moveX = pageX- x, moveY = pageY - y
				setAttr(target, { 'transform': `translate(${moveX}, ${moveY})`, 'data-before-x': moveX, 'data-before-y': moveY })
				break
			case 'mouseup':
				moving = false
				moveWrap.removeClass('active')
				if (moveChk === target.getAttribute('transform')) $(target).click()
				break
		}
	}
})();
const sortClip = e => {
	const childrens = Array.from(e.target.children)
	const svg = $('#video-edit > svg').empty()
	const keys = childrens.map((v, k) => {
		const now = v.dataset.key
		v.setAttribute('data-key', k)
		return now
	})
	const temp = keys.map(v => data.clips[v])
	data.clips = temp
	temp.forEach(({ el }) => svg.append(el))
}
const resizeClip = (_ => {
	let resizing = false, beforeX
	return e => {
		const wrap = e.currentTarget
		const target = wrap.children[0]
		switch (e.type) {
			case 'mousemove':
				let x = e.offsetX + target.offsetLeft
				if (beforeX < e.offsetX) x = e.offsetX
				beforeX = x
				const {end, duration} = target.dataset
				const w = (end / duration) * 800
				if (!resizing) {
					wrap.classList[w-20 < x && x < w ? 'add' : 'remove']('resizing')
				} else {
					const end = (x / 800) * duration
					target.setAttribute('data-end', end)
					target.style.cssText = timelineRange(target.dataset)
					data.clips[$(wrap).index()].end = end
					$('#clip-time > .duration').html(timeFormat(end))
				}
				break
			case 'mousedown': if (wrap.classList.contains('resizing')) resizing = true; break;
			case 'mouseup':
			case 'click':
				if (!resizing) return
				resizing = false
				wrap.click()
		}
	}
})();
const moveClip = (_ => {
	let moving = false, beforeX = 0, timeline = null, moved = 0
	return e => {
		const target = e.currentTarget
		const clip = data.clips[$(target).parent().index()]
		let {start, end, duration} = target.dataset
		start *= 1, end *= 1
		const {offsetX: ox} = e
		timeline = timeline || $('#timeline > ul')
		switch (e.type) {
			case 'mouseenter':
			case 'mouseleave': timeline.sortable('option', 'disabled', e.type=== 'mouseenter'); break
			case 'mousedown':
				if (ox > target.clientWidth - 20) return
				moving = true
				moved = clip.start
				beforeX = ox
			break
			case 'mousemove':
				if (moving) {
					let moveX = ((ox - beforeX)/800) * duration
					if (start + moveX <= 0) {
						moveX -= start + moveX
					} else if (end + moveX >= duration) {
						moveX -= (end + moveX) - duration
					}
					setAttr(target, { 'data-start': (clip.start = start + moveX), 'data-end': (clip.end = end + moveX) })
					$("#clip-time > .current").html(timeFormat(clip.start))
					$("#clip-time > .duration").html(timeFormat(clip.end))
					target.style.cssText = timelineRange(clip)
				}
				break
			case 'mouseup': moving = false; break
			case 'click': if (moved !== clip.start) e.stopPropagation(); break;
		}
	}
})();
const moveCurrent = (_ => {
	let moving = false, beforeX, beforeLeft
	return e => {
		switch (e.type) {
			case 'mousedown':
				moving = true
				beforeX = e.clientX
				beforeLeft = parseInt(e.currentTarget.style.left || 0)
				$('head').append(`
					<style>
						#timeline > .timeline-current:after {width: 40px !important;}
					</style>
				`)
				break
			case 'mousemove':
				if (!moving) return
				let moved = beforeLeft + (e.clientX - beforeX)
				if (moved < 0) moved = 0
				else if (moved > 800) moved = 800
				data.video.currentTime = (moved / 800) * data.video.duration
				break
			case 'mouseup':
			case 'mouseleave': 
				if (moving) {
					moving = false;
					$('head > style').remove()
				}
				break
		}
	}
})();

const downloadVideo = _ => {
	const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg')
	data.clips.forEach(({ el, start, end }) => {
		const clone = el.cloneNode(true)
		setAttr(clone, { 'data-start': start, 'data-end': end })
		svg.appendChild(clone)
	})
	setAttr(svg, { width: 800, height: 450, id: 'shape' })
	fetch(data.video.attributes.src.value).then(res => res.blob()).then(blob => {
		const reader = new FileReader()
		reader.readAsDataURL(blob)
		reader.onload = function () {
			let template = `
			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<title>Document</title>
				<style>
					.wrap {position: relative;width: 800px;height: 450px; margin: 30px auto;}
					.wrap > svg {position: absolute;left: 0;top: 0;}
					#player {position: absolute; left: 50%; top: 50%; margin-left: -25px; margin-top: -25px; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; z-index: 100; border: 2px solid #fff; border-radius: 50%;}
				</style>
			</head>
			<body>
				<div class="wrap">
					<div id="player">
						<svg width="20" height="20">
							<path stroke="#fff" stroke-width="1" d="M0 0 L0 20 L20 10" fill="#fff"></path>
						</svg>
					</div>
					<video src="${reader.result}" width="800" height="450"></video>
					${svg.outerHTML}
				</div>
				<script>
					const video = document.querySelector('video')
					const svg = document.querySelector('#shape')
					player.onclick = _ => {
						video.play()
						player.style.display = 'none'
						return false
					}
					video.ontimeupdate = _ => {
						const { currentTime: t } = video
						Array.from(svg.children).forEach(v => {
							const {start, end} = v.dataset
							v.style.cssText = start <= t && t <= end ? '' : 'opacity:0;z-index:-1'
						})
					}
				</script>
			</body>
			</html>
			`
			const htmlBlob = new Blob([template], {type: 'text/html'})
			const date = new Date()
			const formatDate = [date.getFullYear(), date.getMonth() + 1, date.getDate()].map(v => `0${v}`.substr(-2)).join('')
			const target = $(`<a href="${URL.createObjectURL(htmlBlob)}" id="videoDown" download="movie-${formatDate}.html"></a>`)
			$('body').append(target)
			target[0].click()
			target.remove()
		}
	})
}

$(_ => { if ($('#timeline').length) $('#timeline ul').sortable() })
	.on('click', 'a[href="#"]', _ => false)
	.on('click', '#poster-list > a', selectVideo)
	.on('click', '#edit-tools > a', selectTool)
	.on('change', '#edit-styles input', selectStyle)
	.on('mousedown', '#video-edit > svg', draw)
	.on('mouseup mousemove mouseout', '#video-edit > .top', draw)
	.on('click', '#video-edit > svg > *', selectShape)
	.on('click', '#timeline li', selectClip)
	.on('mousedown', '#video-edit > svg > .active', moveShape)
	.on('mousemove mouseup mouseout', '#video-edit > .move', moveShape)
	.on('sortstop', '#timeline > ul', sortClip)
	.on('click mouseup mousedown mousemove', '#timeline li', resizeClip)
	.on('click mouseup mouseenter mouseleave mousedown mousemove', '#timeline li > div', moveClip)
	.on('mousedown mousemove mouseleave mouseup', '.timeline-current', moveCurrent)
