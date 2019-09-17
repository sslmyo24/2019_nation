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
			this.db.transaction(tx => { tx.executeSql(sql, arr, (tx, res) => { reso(res) }, (tx,error) => { console.log(error) }) })
		})
	}

	async fetch (column, table, option = {arr:[], condition: false}) {
		let sql = `SELECT ${column} FROM ${table}`
		if (option.condition !== false) sql += option.condition
		return Array.from((await Model.query(sql, option.arr)).rows)
	}

	async rowCount (table, condition = false) {
		return (await Model.fetch("*", table, {arr:[], condition: condition})).length
	}
}

let selectIdx = null, selectType = null
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
		for (const v of list) target.append(`<li data-idx="${v.idx}"><span class="name">${v.name}</span><button type="button" class="page-update modal-btn" data-target="update">페이지수정</button></li>`)
	}

	async getHTML (url) {
		const doc = await fetch(url).then(res => res.text()).then(html => {
			const parser = new DOMParser()
			return parser.parseFromString(html, 'text/html')
		})
		return new Promise(res => {
			res($(doc.documentElement).find('body').html())
		})
	}

	updateHTML () {
		const html = $("#preview > div").html()
		Model.query(`UPDATE layout SET html = ? where pidx = ?`, [html.replace('template active', 'template'), selectIdx])
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

const infoUpdate = e => {
	e.preventDefault()

	const reg = new RegExp(/^[0-9]+$/)
	if (reg.test(~~e.target.code.value) === false) {
		alert('고유코드는 숫자만 가능합니다.')
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

const selectTemplate = function () {
	$(".edit").hide()
	if ($(this).hasClass('active')) selectType = null
	else {
		selectType = this.dataset.type
		$('.template.active').removeClass('active')
	}
	$(this).toggleClass('active')
}

const layoutReset = function () {
	if (selectIdx === null) return
	$("#preview > div").html(page.default)
	page.updateHTML()
}

const startSetting = _ => {
	if (selectType === null) return
	$(`.edit`).hide()
	$(`#${selectType}-edit`).show()
	switch (selectType) {
		case 'header':
			const html = $("#gnb > ul").html() + `<li><input type="text" id="new-menu"></li>`
			const reg = new RegExp('</a></li>', 'g')
			$("#menu-list > ul").html(html.replace(reg, `</a><button type="btn" class="remove-btn">x</button></li>`))
			if ($("#menu-list li").length >= 6) $("#menu-list li:last-child").remove()
			break;
	}
}

const logoChange = e => {
	modalClose('logo')
	const file = e.target.files[0]
	const reader = new FileReader()
	reader.readAsDataURL(file)
	reader.onload = _ => {
		e.target.value = null
		$("#site-logo img").attr('src', reader.result)
		page.updateHTML()
	}
}

const addMenu = function (e) {
	if (e.keyCode === 13) {
		const len = $("#menu-list li:not(.input)").length, parent = $(this).parent()
		if (len >= 5) {
			alert('메뉴는 5개 이내여야 합니다.')
			return false
		}
		parent.before(`<li><a href="#">${e.target.value}</a><button type="btn" class="remove-btn"></button></li>`)
		$("#gnb > ul").append(`<li><a href="#">${e.target.value}</a></li>`)
		if (len === 4) parent.remove()
		page.updateHTML()
	}
}

const removeMenu = function () {
	const len = $("#menu-list li:not(.input)").length
	if (len <= 3) {
		alert('메뉴는 3개 이상이어야합니다.')
		return false
	}
	if (len === 5) $(this).parents('ul').append(`<li><input type="text" id="new-menu"></li>`)
	$(this).parent().remove()
}

$(loadOn)
.on("click", ".modal-btn", modalOpen)
.on("click", ".modal-close", modalClose)
.on("click", "#page-insert", _ => $("#page-list ul").append(`<li class="new"><input type="text" name="name" id="new-page-name" value="신규 페이지" /></li>`))
.on("keydown", "#new-page-name", addPage)
.on("submit", "#update form", infoUpdate)
.on("click", "#page-delete", removePage)
.on("click", "#page-list li:not(.new) > .name", preview)
.on("click", "#layout-insert", _ => $("#template-list").fadeIn())
.on("click", "#template-list li", newTemplate)
.on("click", "#preview .template", selectTemplate)
.on("click", "#layout-reset", layoutReset)
.on("click", "#layout-setting", startSetting)
.on("change", "#logo input", logoChange)
.on("keydown", "#new-menu", addMenu)
.on("click", ".remove-btn", removeMenu)

