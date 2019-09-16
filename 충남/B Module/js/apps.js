const Model = new class {
	init () {
		this.db = openDatabase("Builder", "1.0", "teaser builder", 2*1024*1024)
		const sql = `CREATE TABLE IF NOT EXISTS pagelist (code primary key, name, title, description, keyword)`
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
}

const Page = new class {

	get pagelist () {
		return Model.query(`SELECT * FROM pagelist`)
	}

	async setList () {
		const pagelist = await Page.pagelist
	}

	pageInsert (e) {
		$("#page-list > ul").append(`<li><span class="name"><input type="text" name="name" id="new-page-name" /></span></li>`)
		if ($("#new-page-name")) {
			$("#new-page-name").keywdown(async function (e) {
			if (e.keyCode === 13) {
					await Model.query(`INSERT INTO pagelist (name) values(?)`, [e.target.value])
					this.setList()
				}
			})
		}
	}
}

const loadOn = _ => {
	Model.init()
	.then(Page.setList)
}

const modalOpen = function () {
	const target = this.dataset.target
	$(`#${target}`).css({'display':'flex'}).animate({opacity: 1}, 500)
}

const modalClose = function (id) {
	const target = typeof id !== 'string' ? $(this).parents('.modal') : $(`#${id}`)
	target.fadeOut(300, function () { $(this).css({'opacity': '0'}) })
}

$(loadOn)
.on("click", ".modal-btn", modalOpen)
.on("click", ".modal-close", modalClose)
.on("click", "#page-insert", Page.pageInsert)
.on("submit", "#update form", Page.pageUpdate)

