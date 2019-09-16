const Model = new class {
	init () {
		this.db = openDatabase("Builder", "1.0", "teaser builder", 2*1024*1024)
		// const sql = `DROP TABLE pagelist`
		const sql = `CREATE TABLE IF NOT EXISTS pagelist (idx integer primary key, code, name, title, description, keyword)`
		return new Promise(async res => {
			Model.query(sql)
			res()
		})
	}

	query (sql, arr = []) {
		return new Promise (reso => {
			this.db.transaction(tx => { tx.executeSql(sql, arr, (tx, res) => { reso(res) }, (tx,error) => { console.log(error) }) })
		})
	}

	async fetch (column, table, option = {arr:[], condition: false}) {
		const sql = `SELECT ${column} FROM ${table}`
		if (option.condition !== false) sql += option.condition
		const list = await Model.query(sql, option.arr)
		return list.rows
	}

	async rowCount (table, condition) {
		const list = await Model.fetch("*", table, {arr:[], condition: condition})
		return list.length
	}
}

const Page = new class {

	get pagelist () {
		return Model.fetch("*", "pagelist")
	}

	async setList () {
		const target = $("#page-list > ul")
		$("li", target).remove()
		const pagelist = await Page.pagelist
		for (const v of pagelist) target.append(`<li><span class="name">${v.name}</span><button type="button" class="page-update modal-btn" data-idx="${v.idx}" data-target="update">페이지수정</button></li>`)
	}

	async newPage (e) {
		if (e.keyCode === 13) {
			await Model.query(`INSERT INTO pagelist (name) values(?)`, [e.target.value])
			Page.setList()
		}
	}

	async infoUpdate (e) {
		e.preventDefault()
		const idx = e.target.idx.value
		const code = e.target.code.value
		const name = e.target.name.value
		const title = e.target.title.value
		const description = e.target.description.value
		const keyword = e.target.keyword.value

		const reg = new RegExp(/^[0-9]+$/)
		if (reg.test(~~code) === false) {
			alert('고유코드는 숫자만 가능합니다.')
			return false
		}

		await Model.query(`UPDATE pagelist SET code = ?, name = ?, title = ?, description = ?, keyword = ? where idx = ?`, [code, name, title, description, keyword, idx])
		e.target.reset()
		modalClose(`update`)
		Page.setList()
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
		$(`#update [name="idx"]`).val(this.dataset.idx)
		$(`#update [name="name"]`).val(pagelist[(~~this.dataset.idx) - 1].name)
	}
}

const modalClose = function (id) {
	const target = typeof id !== 'string' ? $(this).parents('.modal') : $(`#${id}`)
	target.fadeOut(300, function () { $(this).css({'opacity': '0'}) })
}

$(loadOn)
.on("click", ".modal-btn", modalOpen)
.on("click", ".modal-close", modalClose)
.on("click", "#page-insert", _ => $("#page-list > ul").append(`<li><span class="name"><input type="text" name="name" id="new-page-name" /></span></li>`))
.on("keydown", "#new-page-name", Page.newPage)
.on("submit", "#update form", Page.infoUpdate)

