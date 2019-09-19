let selectIdx = null,
	selectType = null,
	setting = false,
	mouseDown = [],
	selectElement = null

const Model = new class {
	init () {
		this.db = openDatabase("Builder", "1.0", "teaser builder", 2*1024*1024)
		const sql = [
			// `DROP TABLE pagelist`,
			// `DROP TABLE layout`
			`CREATE TABLE IF NOT EXISTS pagelist (idx integer primary key, code, name, title, description, keyword)`,
			`CREATE TABLE IF NOT EXISTS layout (idx integer primary key, pidx, html)`
		]
		return new Promise(res => {
			sql.forEach(async v => await Model.query(v))
			res(Model.fetch("*", "pagelist"))
		})
	}

	query (sql, arr = []) {
		return new Promise (reso => {
			this.db.transaction(tx => { tx.executeSql(sql, arr, (tx, res) => { reso(res) }, (tx,error) => { console.log(sql, arr); console.log(error) }) })
		})
	}

	async fetch (column, table, option = {arr:[], condition: false}) {
		let sql = `SELECT ${column} FROM ${table} `
		if (option.condition !== false) sql += option.condition
		return Array.from((await Model.query(sql, option.arr)).rows)
	}

	async rowCount (table, condition = false) {
		return (await Model.fetch("*", table, {arr:[], condition: condition})).length
	}
}

const Page = class {

	constructor () {
		this.getHTML('./Header.HTML').then(doc => new Promise(res => res(`<div class="template" data-type="header">${doc}</div>`)))
		.then(text => this.getHTML('./Footer.HTML').then(doc => new Promise(res => res(text + `<div class="template" data-type="footer">${doc}</div>`))))
		.then(text => this.default = text)
	}

	get pagelist () {
		return Model.fetch("*", "pagelist")
	}

	get defaultLayout () {
		return this.default
	}

	async setList (list = false) {
		const target = $("#page-list > ul")
		$("li", target).remove()
		if (list === false) list = await this.pagelist
		for (const v of list) target.append(`<li data-idx="${v.idx}"><span class="name">${v.name}</span><button type="button" class="mini-btn page-update modal-btn" data-target="update">페이지수정</button></li>`)
	}

	async getHTML (url) {
		const doc = await fetch(url, {cache: "no-cache"}).then(res => res.text()).then(html => {
			const parser = new DOMParser()
			return parser.parseFromString(html, 'text/html')
		})
		return new Promise(res => {
			res($(doc.documentElement).find('body').html())
		})
	}

	updateHTML () {
		const reg1 = new RegExp('changeable', 'g'), reg2 = new RegExp('template', 'g')
		const html = $("#preview > div").html().replace(reg1, "").replace(reg2, "")
		Model.query(`UPDATE layout SET html = ? where pidx = ?`, [html.replace('template active', 'template'), selectIdx])
	}

	imgChange (target, loadAction)  {
		const file = Array.from(target.files)

		let imgURI = false
		const before = url => {
			const c = document.createElement('canvas')
			const ctx = c.getContext('2d')
			const img = new Image()
			img.src = url
			img.onload = function () {

				const w = this.width, h = this.height
				let newWidth, newHeight
				if (w > 250 || h > 250) {
					const ratio = w/h;
					if (ratio == 1) {
						newWidth = 250;
						newHeight = 250;
					}
					else if (w > h) {
						newWidth = 250
						newHeight = 250/ratio;
					}
					else {
						newWidth = 250*ratio
						newHeight = 250;
					}
				}
				else {
					newWidth = w;
					newHeight = h;
				}

				c.width = newWidth
				c.height = newHeight
				ctx.drawImage(this, 0, 0, newWidth, newHeight)
				imgURI = c.toDataURL()
			}
		}

		file.forEach((v, k) => {


			if (['jpeg', 'png'].indexOf(v.type.substring(6)) === -1) {
				alert('jpg, png 파일만 가능합니다.')
				target.value = null
				return
			}

			if (v.size/1024/1024 > 2) {
				alert('2MB 이내의 이미지만 가능합니다.')
				target.value = null
				return
			}

			const reader = new FileReader()
			reader.readAsDataURL(v)
			reader.onload = _ => {
				const url = reader.result
				before(url)

				const timer = setInterval(_ => {
					if (imgURI !== false) {
						clearInterval(timer)

						fetch(imgURI)
						.then(res => res.blob())
						.then(blob => {
							let type = v.type.substring(6)
							if (type == 'jpeg') type = 'jpg'

							const formData = new FormData()
							formData.append('action', 'imgUpload')
							formData.append('img', blob)
							formData.append('type', type)

							fetch('/builder', {
								body: formData,
								method: 'POST'
							})
						})


						loadAction(imgURI, k)
						.then(this.updateHTML)
					}
				})
			}
		})
	}
}

const page = new Page()
const loadOn = _ => {
	Model.init()
	.then(page.setList)
}

const modalOpen = async function (e) {
	const target = this.dataset.target
	$(`#${target}`).css({'display':'flex'}).animate({opacity: 1}, 500)
	if (target === 'update') {
		const pagelist = await Model.fetch("*", "pagelist")
		const idx = $(this).parents('li')[0].dataset.idx
		const data = pagelist[(~~idx) - 1]
		$(`#update [name="idx"]`).val(idx)
		$(`#update [name="code"]`).val(data.code)
		$(`#update [name="name"]`).val(data.name)
		$(`#update [name="title"]`).val(data.title)
		$(`#update [name="description"]`).val(data.description)
		$(`#update [name="keyword"]`).val(data.keyword)
	}
}

const modalClose = function (id) {
	const target = typeof id !== 'string' ? $(this).parents('.modal') : $(`#${id}`)
	target.fadeOut(300, function () { $(this).css({'opacity': '0'}) })
}

const addPage = e => {
	if (e.keyCode === 13) {
		Model.query(`INSERT INTO pagelist (name) values(?)`, [e.target.value])
		.then(_ => page.setList())
		.then(async _ => {
			const lastIdx = await Model.rowCount(`pagelist`)
			Model.query(`INSERT INTO layout (pidx, html) values(?, ?)`, [lastIdx, page.default])
		})
	}
}

const infoUpdate = async e => {
	e.preventDefault()

	const code = e.target.code.value

	const reg = new RegExp(/^[0-9]+$/)
	if (reg.test(~~code) === false) {
		alert('고유코드는 숫자만 가능합니다.')
		return false
	}

	const cnt = await Model.rowCount("pagelist", `where code = '${code}'`)
	console.log(cnt)
	if (cnt >= 1) {
		alert('이미 존재하는 고유코드입니다')
		return false
	}

	Model.query(`UPDATE pagelist SET code = ?, name = ?, title = ?, description = ?, keyword = ? where idx = ?`, [...(new FormData(e.target)).values()])
	modalClose(`update`)
	e.target.reset()
	page.setList()
}

const removePage = _ => {
	if (selectIdx === null) return
	Model.query(`DELETE FROM pagelist where idx = ?`, [selectIdx])
	Model.query(`DELETE FROM layout where pidx = ?`, [selectIdx])
	.then(_ => page.setList())
	$("#preview .template").remove()
}

const preview = async function () {
	const parent = $(this).parent()
	if (parent.hasClass('active')) return
	setting = false
	selectType = null

	$('.edit').hide()
	$('#page-list .active').removeClass('active')

	parent.addClass('active')
	selectIdx = ~~parent[0].dataset.idx

	const target = $("#preview > div")
	$("*", target).remove()

	const html = await Model.fetch("html", "layout", {arr: [selectIdx], condition: " where pidx = ?"} )
	target.append(html[0].html)
}

const newTemplate = async function () {
	const type = this.innerHTML
	page.getHTML(`./${type}.HTML`.replace(`&amp;`, '&'))
	.then(doc => $(`[data-type="footer"]`).before(`<div class="template" data-type="${type.substring(0, type.length - 2)}">${doc}</div>`))
	.then(page.updateHTML)
}

const selectTemplate = function (e) {
	e.stopPropagation()

	$(".edit").hide()

	if ($(this).hasClass('active')) selectType = null
	else {
		selectType = this.dataset.type.replace('&',"")
		$('.template.active').removeClass('active')
	}

	$(this).toggleClass('active')
}

const layoutReset = function () {
	if (selectIdx === null) return
	$("#preview > div").html(page.default)
	$(".edit").hide()
	page.updateHTML()
}

const startSetting = _ => {
	if (selectType === null) return
	setting = true

	$('.changeable').removeClass('changeable')
	$(`.edit`).hide()
	$(`#${selectType}-edit`).show()

	switch (selectType) {
		case 'header':
			const html = $("#gnb > ul").html() + `<li class="input"><input type="text" id="new-menu"></li>`
			const reg = new RegExp('</a></li>', 'g')
			$("#menu-list > ul").html(html.replace(reg, `</a><button type="btn" class="remove-btn">x</button></li>`))
			if ($("#menu-list li").length >= 6) $("#menu-list li:last-child").remove()
			break;
		case 'Visual':
			if ($(".visual-text > h1").hasClass('hide')) $(`.show-btn[data-target="h1"]`).show()
			else $(`.hide-btn[data-target="h1"]`).show()
			if ($(".visual-text > p").hasClass('hide')) $(`.show-btn[data-target="p"]`).show()
			else $(`.hide-btn[data-target="p"]`).show()
			if ($(".visual-text > button").hasClass('hide')) $(`.show-btn[data-target="button"]`).show()
			else $(`.hide-btn[data-target="button"]`).show()
			$(".visual-text > *").addClass('changeable')
			$(".visual-text > *:not(button)").addClass('styleChange')
			$(".visual-text > button").addClass('urlChange')
			break;
		case 'Features':
			if ($(".template.active h3").hasClass('hide')) $(`.show-btn[data-target="h3"]`).show()
			else $(`.hide-btn[data-target="h3"]`).show()
			if ($(".template.active img").hasClass('hide')) $(`.show-btn[data-target=".img-body"]`).show()
			else $(`.hide-btn[data-target=".img-body"]`).show()
			if ($(".template.active p").hasClass('hide')) $(`.show-btn[data-target="p"]`).show()
			else $(`.hide-btn[data-target="p"]`).show()
			if ($(".template.active button").hasClass('hide')) $(`.show-btn[data-target="button"]`).show()
			else $(`.hide-btn[data-target="button"]`).show()
			$(".template.active article > *:not(.img), .template.active .img-body").addClass('changeable')
			$(".template.active h3, .template.active p").addClass('styleChange')
			$(".template.active button").addClass('urlChange')
			$(".template.active .img-body").addClass('iconChange')
			break;
		case 'GallerySlider':
			if ($(".template.active h3").hasClass('hide')) $(`.show-btn[data-target="h3"]`).show()
			else $(`.hide-btn[data-target="h3"]`).show()
			if ($(".template.active .sub").hasClass('hide')) $(`.show-btn[data-target=".sub"]`).show()
			else $(`.hide-btn[data-target=".sub"]`).show()
			if ($(".template.active .desc").hasClass('hide')) $(`.show-btn[data-target=".desc"]`).show()
			else $(`.hide-btn[data-target=".desc"]`).show()
			$(".template.active #gallery2 .text").css("z-index", 10)
			$(".template.active article").css({"position": "relative", "z-index": 1000})
			$(".template.active .text > *, .template.active .img").addClass('changeable')
			$(".template.active .text > *").addClass('styleChange')
			$(".template.active > #gallery2 article, .template.active > #gallery1 .img").addClass('imgChange')
			break;
		case 'Contacts':
			if ($(".template.active .address").hasClass('hide')) $(`.show-btn[data-target=".address"]`).show()
			else $(`.hide-btn[data-target=".address"]`).show()
			if ($(".template.active .tel").hasClass('hide')) $(`.show-btn[data-target=".tel"]`).show()
			else $(`.hide-btn[data-target=".tel"]`).show()
			if ($(".template.active .email").hasClass('hide')) $(`.show-btn[data-target=".email"]`).show()
			else $(`.hide-btn[data-target=".email"]`).show()
			$(".template.active .contact-info").css({"position": "relative", "z-index": 1000})
			$(".template.active .contact-info > div > *").addClass('changeable styleChange')
			break;
	}

	$(".titleChange > input").val($(".template.active h2").text())
}

const logoChange = e => {
	const loadAction = (url, idx) => {
		$("#site-logo img").attr('src', url)
		modalClose('logo')
		return new Promise(res => res())
	}

	page.imgChange(e.target, loadAction)
}

const addMenu = function (e) {
	if (e.keyCode === 13) {
		const len = $("#menu-list li:not(.input)").length, parent = $(this).parent()
		if (len >= 5) {
			alert('메뉴는 5개 이내여야 합니다.')
			return false
		}
		parent.before(`<li><a href="#">${e.target.value}</a><button type="btn" class="remove-btn">x</button></li>`)
		$("#gnb > ul").append(`<li><a href="#">${e.target.value}</a></li>`)
		if (len === 4) parent.remove()
		page.updateHTML()
	}
}

const removeMenu = function () {
	const len = $("#menu-list li:not(.input)").length,
		  parent = $(this).parent(),
		  idx = parent.index()

	if (len <= 3) {
		alert('메뉴는 3개 이상이어야합니다.')
		return false
	}
	if (len === 5) $(this).parents('ul').append(`<li class="input"><input type="text" id="new-menu"></li>`)

	parent.remove()
	$("#gnb li").eq(idx).remove()
	page.updateHTML()
}

const toggleElement = back => {
	return function () {
		if (back === 'hide') $(`.template.active ${this.dataset.target}`).removeClass('hide')
		else if (back === 'show') $(`.template.active ${this.dataset.target}`).addClass('hide')

		$(this).parent().find(`.${back}-btn`).show()
		$(this).hide()

		page.updateHTML()
	}
}

const changeVisual = e => {
	const loadAction = (url, idx) => {
		$(`.slide:nth-child(${idx+1})`).attr('style', `background:url(${url}) no-repeat center / cover !important`)
		modalClose('visual')
		return new Promise(res => res())
	}

	page.imgChange(e.target, loadAction)
}

const showContextBox = function (e) {
	if (selectType === null || setting === false) return

	if (e.which === 3 && mouseDown.indexOf(this) !== -1) {

		selectElement = this

		let x = e.clientX, y = e.clientY
		$("#context.modal > .wrap").css({"top": `${y}px`, "left": `${x}px`})

		if ($(this).hasClass('styleChange')) $("#context.modal .style").show()
		if ($(this).hasClass('urlChange')) $("#context.modal .url").show()
		if ($(this).hasClass('imgChange')) $("#context.modal .img").show()
		if ($(this).hasClass('iconChange')) $("#context.modal .icon").show()

		$("#context.modal").show()

	}

	mouseDown = []
}

const hideContextBox = function () {
	$(this).find('form > div').hide()
	$(this).hide()
}

const changeStyle = e => {
	e.preventDefault()

	const text = e.target.text.value
	const textColor = e.target.textColor.value
	const fontSize = e.target.fontSize.value
	const url = e.target.url.value
	const img = e.target.img

	if (text != '') $(selectElement).text(text)
	if (textColor != '') selectElement.style.color = '#'+textColor
	if (fontSize != '') selectElement.style.fontSize = fontSize+"px"
	if (url != '') $(selectElement).attr('onclick', `location.replace('${url}')`)
	if (img.value != '') {
		const loadAction = (url, idx) => {
			$(selectElement).attr('style', `background:url(${url}) no-repeat center / cover !important`)
			selectElement = null
			// e.target.reset()
			$("#context.modal").hide()
			return new Promise(res => res())
		}

		page.imgChange(img, loadAction)
		return
	}

	e.target.reset()
	selectElement = null
	$("#context.modal").hide()

	page.updateHTML()
}

const titleChange = function () {
	$(".template.active h2").text(this.value)
	page.updateHTML()
}

const bgChange = function () {
	if (selectType == 'Contacts') $(".template.active form").attr('style', `background: ${this.dataset.color}`)
	if (selectType == 'footer') $("footer").attr('style', `background: ${this.dataset.color}`)

	page.updateHTML()
}

const readIcons = e => {
	let text, w, h
	const file = e.target.files[0],
		  reader = new FileReader(),
		  target  = $("#icon-list")

	reader.readAsDataURL(file)
	reader.onload = _ => {

		const img = new Image()
		img.src = reader.result

		e.target.value = null
		img.onload = function () {

			const width = this.width, height = this.height
			w = width/10, h = height/7

			text = `<div style="cursor: pointer; width: ${w}px; height: ${h}px; background-image: url(${this.src}); background-position: {{x}}px {{y}}px; background-size: ${width}px ${height}px;" class="img-body changeable iconChange"></div>`
			target.css({"width": `${width}px`, "height": `${height}px`})

			for (let i = 0; i < 7; i++) {
				for (let j = 0; j < 10; j++) {
					target.append(text.replace(/{{x}}/, w*j).replace(/{{y}}/, h*i))
				}
			}

			const modal = $("#context.modal > .wrap")
			const t = modal.offset().top, l = modal.offset().left
			const oh = t + modal.height(), ow = l + modal.width()
			if ($(window).height() < oh) {
				modal.css({"top": `${t-t/2}px`})
				if ($(window).height() < (oh-t/2)) modal.css({"bottom": `${t}px`})
			}
			if ($(window).width() < ow) {
				modal.css({"left": `${l-l/2}px`})
				if ($(window).width() < (ow-l/2)) modal.css({"right": `${l}px`})
			}

			$("#icon-list > div").click(function () {

				const idx = $(this).index(),
					  row = idx%10, col = ~~(idx/10)

				$(selectElement).parent().prepend(text.replace(/{{x}}/, `${w*row}`).replace(/{{y}}/, `${h*col}`))
				$(selectElement).remove()
				selectElement = null
				$("#context.modal").hide()

				$("#icon-list > div").remove()
				$("#icon-list").css({"width":"auto", "height":"auto"})


				page.updateHTML()
			})
		}
	}

}

const timeCheck = _ => {
	const timer = setInterval(_ => {
		const term = Date.now() - sessionStorage.getItem('start')*1
		const remain = 2*60*60*1000 - term

		const sec = remain/1000,
			  min = sec/60,
			  hour = min/60

		$("#session-time > .hour").text(~~hour)
		$("#session-time > .min").text((~~min)%60 < 10 ? "0"+((~~min)%60) : (~~min)%60)
		$("#session-time > .sec").text((~~sec)%60 < 10 ? "0"+((~~sec)%60) : (~~sec)%60)

		if (remain < 0) {
			sessionStorage.clear()
			clearInterval(timer)
			const back = window.location.href.replace('http://localhost/',"")
			location.replace(`/admin/logout?back=${back}`)
		}
	})
}

const pageUpload = async function () {
	if (selectIdx === null) {
		alert('선택된 페이지가 없습니다.')
		return
	}

	const data = (await Model.fetch("pagelist.*, layout.html", "pagelist  JOIN layout ON pagelist.idx = layout.pidx", {arr: [selectIdx], condition: "where pagelist.idx = ?"}))[0]
	if (data.code === null) {
		alert('고유코드가 누락되었습니다.')
		return
	}

	const formData = new FormData()
	formData.append('action', 'pageUpload')
	for (const key in data) formData.append(key, data[key])
	fetch('/builder', {
		body: formData,
		method: 'POST'
	})
}


$(loadOn)
.on("contextmenu", e => e.preventDefault())
.on("click", ".modal-btn", modalOpen)
.on("click", ".modal-close", modalClose)
.on("click", "#page-insert", _ => $("#page-list ul").append(`<li class="new"><input type="text" name="name" id="new-page-name" value="신규 페이지" /></li>`))
.on("keydown", "#new-page-name", addPage)
.on("submit", "#update form", infoUpdate)
.on("click", "#page-delete", removePage)
.on("click", "#page-list li:not(.new) > .name", preview)
.on("click", "#layout-insert", _ => $("#template-list").toggleClass('active'))
.on("click", "#template-list li", newTemplate)
.on("click", "#preview .template", selectTemplate)
.on("click", "#layout-reset", layoutReset)
.on("click", "#layout-setting", startSetting)
.on("change", "#logo.modal input", logoChange)
.on("keydown", "#new-menu", function (e) { if (e.keyCode === 13) $(this).blur() })
.on("blur", "#new-menu", addMenu)
.on("click", ".remove-btn", removeMenu)
.on("click", ".show-btn", toggleElement('hide'))
.on("click", ".hide-btn", toggleElement('show'))
.on("change", "#visual.modal input", changeVisual)
.on("mousedown", ".changeable", function () {mouseDown.push(this)})
.on("mouseup", ".changeable", showContextBox)
.on("click", "#context.modal", hideContextBox)
.on("mousedown", "#context.modal", function (e) {
	if (e.which === 3) {
		$(this).hide()
		selectElement = null
	}
})
.on("click", "#context.modal, .wrap", e => e.stopPropagation())
.on("submit", "#context.modal form", changeStyle)
.on("keydown", ".titleChange > input", function (e) { if (e.keyCode === 13) $(this).blur() })
.on("blur", ".titleChange > input", titleChange)
.on("click", "#background li", bgChange)
.on("change", "#context6", readIcons)
.on("click", "#page-upload", pageUpload)