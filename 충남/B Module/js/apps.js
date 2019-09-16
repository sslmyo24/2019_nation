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

let selected = null
const Page = new class {

	get pagelist () {
		return Model.fetch("*", "pagelist")
	}

	async setList (list = false) {
		const target = $("#page-list > ul")
		$("li", target).remove()
		if (list === false) list = await Page.pagelist
		for (const v of list) target.append(`<li data-idx="${v.idx}"><span class="name">${v.name}</span><button type="button" class="page-update modal-btn" data-target="update">페이지수정</button></li>`)
	}

	async newPage (e) {
		if (e.keyCode === 13) {
			await Model.query(`INSERT INTO pagelist (name) values(?)`, [e.target.value])
			Page.setList()
			const lastIdx = await Model.rowCount(`pagelist`)
			let text = ``
			await Page.getHTML('./Header.HTML').then(doc => text += `<div class="template" data-type="header">${doc}</div>`)
			await Page.getHTML('./Footer.HTML').then(doc => text += `<div class="template" data-type="footer">${doc}</div>`)
			Model.query(`INSERT INTO layout (pidx, html) values(?, ?)`, [lastIdx, text])
		}
	}

	infoUpdate (e) {
		e.preventDefault()

		const reg = new RegExp(/^[0-9]+$/)
		if (reg.test(~~e.target.code.value) === false) {
			alert('고유코드는 숫자만 가능합니다.')
			return false
		}

		Model.query(`UPDATE pagelist SET code = ?, name = ?, title = ?, description = ?, keyword = ? where idx = ?`, [...(new FormData(e.target)).values()])
		modalClose(`update`)
		e.target.reset()
		Page.setList()
	}

	async getHTML (url) {
		const doc = await fetch(url).then(res => res.text()).then(html => {
			const parser = new DOMParser()
			return parser.parseFromString(html, 'text/html')
		})
		return new Promise(res => {
			res($(doc.documentElement).find('body')[0].innerHTML)
		})
	}

	async preview () {
		if ($(this).hasClass('active')) return
		$('#page-list .active').removeClass('active')
		$(this).addClass('active')
		selected = ~~this.dataset.idx
		const target = $("#preview > div")
		$("*", target).remove()
		const html = await Model.fetch("html", "layout", {arr: [selected], condition: " where pidx = ?"} )
		target.append(html[0].html)
	}

	updateHTML () {
		const html = $("#preview > div")[0].innerHTML
		Model.query(`UPDATE layout SET html = ? where pidx = ?`, [html, selected])
	}
}

const loadOn = _ => {
	Model.init()
	.then(Page.setList)
}

const modalOpen = async function () {
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

$(loadOn)
.on("click", ".modal-btn", modalOpen)
.on("click", ".modal-close", modalClose)
.on("click", "#page-insert", _ => $("#page-list ul").append(`<li class="new"><input type="text" name="name" id="new-page-name" value="신규 페이지" /></li>`))
.on("keydown", "#new-page-name", Page.newPage)
.on("submit", "#update form", Page.infoUpdate)
.on("click", "#page-list li:not(.new)", Page.preview)
.on("click", "#layout-insert", _ => $("#template-list").fadeIn())
.on("click", "#template-list li", function () {
	const type = this.innerHTML
	Page.getHTML(`./${type}.HTML`.replace(`&amp;`, '&'))
	.then(doc => $("footer").before(`<div class="template" data-type="${type}">${doc}</div>`))
	Page.updateHTML()
})

