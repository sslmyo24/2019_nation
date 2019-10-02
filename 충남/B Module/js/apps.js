const model = new class {
  init () {
    const res = indexedDB.open('20191002')
    res.onupgradeneeded = e => {
      const idb = e.target.result
      idb.createObjectStore('pages', {keyPath: 'idx', autoIncrement: true})
      idb.createObjectStore('images', {keyPath: 'idx', autoIncrement: true})
      this.idb = idb
    }
    return new Promise(resolve => {
      res.onsuccess = e => {
        this.idb = e.target.result
        resolve(this)
      }
    })
  }
  getTable (table) {
    return this.idb.transaction([table], 'readwrite').objectStore(table)
  }
  query (type, {table, column, idx}) {
    const tbl = this.getTable(table)
    const insert = () => tbl.add(column)
    const update = () => tbl.put(column)
    const del = () => tbl.delete(idx)
    const fetch = () => tbl.get(idx)
    const fetchAll = () => tbl.getAll();
    const res = {insert, update, delete: del, fetch, fetchAll}[type]()
    return new Promise(resolve => { res.onsuccess = e => {
      resolve(e.target.result)
    } })
  }
  async getPage () {
    let pages = await model.query('fetch', {table: 'pages', idx: 1})
    if (pages === undefined) {
      await model.query('insert', {table: 'pages', column: { json: '[]' }})
      pages = {json: '[]'}
    }
    return JSON.parse(pages.json)
  }
  async getImages () {
    let pages = await model.query('fetchAll', {table: 'images'})
    return pages
  }
  setPage (pages) {
    model.query('update', {table: 'pages', column: {idx: 1, json: JSON.stringify(pages)}})
  }
  postImage (src) {
    model.query('insert', {table: 'images', column: { src }})
  }
}

Vue.component('layer-popup', {
	template: `
		<div class="layer">
			<span class="middle"></span><div class="layer__box" :style="{width: bus.layerWidth + 'px'}">
				<a href="#" class="layer__close" @click="close">X</a>
				<h3 class="layer__title">{{bus.layerTitle}}</h3>
				<component :is="bus.layerBody"></component>
			</div>
		</div>
	`,
	methods: {
		close () {
			bus.isLayer = false
		}
	}
})
Vue.component('page-admin', {
	template: `
		<div>
			<table>
				<colgroup>
					<col width="10%" />
					<col width="25%" />
					<col width="25%" />
					<col width="20%" />
					<col width="20%" />
				</colgroup>
				<thead>
					<tr>
						<th>고유번호</th>
						<th>Title</th>
						<th>Description</th>
						<th>Keyword</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(v, k) in bus.pages" :key="k" @click="select(v)">
						<td>
							<template v-if="v.state">
								{{v.id}}
							</template>
							<template v-else>
								<input type="text" v-model="v.id" autofocus />
							</template>
						</td>
						<td>
							<template v-if="v.state">
								{{v.title}}
							</template>
							<template v-else>
								<input type="text" v-model="v.title" />
							</template>
						</td>
						<td>
							<template v-if="v.state">
								{{v.description}}
							</template>
							<template v-else>
								<input type="text" v-model="v.description" />
							</template>
						</td>
						<td>
							<template v-if="v.state">
								{{v.keyword}}
							</template>
							<template v-else>
								<input type="text" v-model="v.keyword" />
							</template>
						</td>
						<td>
							<template v-if="v.state">
								<a href="#" class="btn mini" @click="update(v)">수정</a>
							</template>
							<template v-else>
								<a href="#" class="btn mini" @click="complete(v)">완료</a>
							</template>
						</td>
					</tr>
				</tbody>
			</table>
			<div style="margin-top:20px;text-align:right;">
				<a href="#" class="btn" @click="insert">추가</a>
			</div>
		</div>
	`,
	methods: {
		insert () {
			bus.pages.push({
				id: '',
				title: 'Title',
				description: 'Description',
				keyword: 'Keyword',
				state: false,
				selected: false,
				template: [
					{compo:'template-header', data: {
						logo: './img/logo/logo.png',
						menu: [
							{name: 'MENU1', url: '#'},
							{name: 'MENU2', url: '#'},
							{name: 'MENU3', url: '#'}
						]
					}},
					{compo:'template-footer', data: {}}
				]
			})
			this.$nextTick(() => {
				$('[autofocus]:last-child').focus()
			})
			bus.model.setPage(bus.pages)
		},
		update (v) {
			v.state = false
			bus.model.setPage(bus.pages)
		},
		complete (v) {
			if (v.id.length === 0) {
				alert('고유번호를 입력해주세요')
				return false
			}
			if (/^[a-zA-Z0-9]+$/.test(v.id) === false) {
				alert('영문 및 숫자로만 구성되어야 합니다.')
				return false
			}
			const finded = bus.pages.find(v2 => v !== v2 && v2.id == v.id)
			if (finded !== undefined) {
				alert('중복된 고유번호가 있습니다.')
				return false
			}
			v.state = true
			bus.model.setPage(bus.pages)
		},
		select (v) {
			bus.pages.forEach(v => v.selected = false)
			v.selected = true
			bus.model.setPage(bus.pages)
		}
	}
})
Vue.component('template-adder', {
	template: `
		<table>
			<colgroup>
				<col width="100%" />
			</colgroup>
			<thead>
				<tr>
					<th>템플릿 선택</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="text-align:left;">
						<a href="#" class="btn" @click="append('visual1')">Visual 1</a>
						<a href="#" class="btn" @click="append('visual2')">Visual 2</a>
					</td>
				</tr>
				<tr>
					<td style="text-align:left;">
						<a href="#" class="btn" @click="append('feature1')">Feature 1</a>
						<a href="#" class="btn" @click="append('feature2')">Feature 2</a>
					</td>
				</tr>
				<tr>
					<td style="text-align:left;">
						<a href="#" class="btn" @click="append('gallery1')">Gallery 1</a>
						<a href="#" class="btn" @click="append('gallery2')">Gallery 2</a>
					</td>
				</tr>
				<tr>
					<td style="text-align:left;">
						<a href="#" class="btn" @click="append('contact1')">Contact 1</a>
						<a href="#" class="btn" @click="append('contact2')">Contact 2</a>
					</td>
				</tr>
			</tbody>
		</table>
	`,
	methods: {
		append (templateName) {
			const footer = bus.selectedPage.template.pop()
			const appended = {
				compo: 'template-'+templateName,
				data: (() => {
					const type = templateName.replace(/^([a-z]+)[0-9]*$/, '$1')
					const data = {}
					switch (type) {
						case 'visual' :
							data.title = {
								text: '부산국제매직페스티벌',
								color: null, size: null, show: true
							}
							data.description = {
								text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque maxime error fugiat, non, accusantium atque. Dolores velit, reiciendis repellendus odit illo unde. Qui error labore perferendis quos veritatis, voluptatibus itaque. Learn more',
								color: null, size: null, show: true
							}
							data.link = {
								text: '바로가기',
								url: '#', show: true
							}
							data.images = [
								'./img/visual/1.jpg',
								'./img/visual/2.jpg',
								'./img/visual/3.jpg',
							]
						break;
					}
					return data
				})()
			}
			bus.selectedPage.template.push(appended, footer)
			bus.model.setPage(bus.pages)
		}
	}
})
Vue.component('template-preview', {
	template: `
		<div id="templatePreview">
			<component v-for="(v, k) in tmpl" :is="v.compo" :custom="v.data" />
		</div>
	`,
	computed: {
		tmpl () {
			const list = []
			bus.selectedPage.template.forEach(v => {
				list.push(v)
			})
			return list
		}
	}
})
Vue.component('template-header', {
	template: `
		<header>
			<div class="contact">
				<div class="info">
					<div>
						<img src="./img/icon/location.png" alt="location" title="location"><span>부산시 해운대구 123</span>
					</div>
					<div>
						<img src="./img/icon/phone.png" alt="phone" title="phone"><span>123-456-7890</span>
					</div>
					<div>
						<img src="./img/icon/email.png" alt="email" title="email"><span>webskills@skills.com</span>
					</div>
				</div>
				<div class="social">
					<a href="#"><img src="./img/icon/social1.png" alt="social1" title="social1"></a>
					<a href="#"><img src="./img/icon/social2.png" alt="social2" title="social2"></a>
					<a href="#"><img src="./img/icon/social3.png" alt="social3" title="social3"></a>
					<a href="#"><img src="./img/icon/social4.png" alt="social4" title="social4"></a>
				</div>
			</div>
			<div class="navi">
				<!-- symbol logo -->
				<div id="site-logo" @contextmenu.prevent="bus.contextmenu($event, 'logo')">
					<a href="#">
						<img :src="custom.logo" alt="logo" title="logo">
					</a>
				</div>
				
				<!-- navigation -->
				<nav id="gnb" @contextmenu.prevent="bus.contextmenu($event, 'menu')">
					<ul>
						<li v-for="(v, k) in custom.menu"><a :href="v.url">{{v.name}}</a></li>
					</ul>
				</nav>
			</div>
		</header>
	`,
	props: ['custom']
})
Vue.component('template-footer', {
	template: `
		<footer>
			<div id="admin-info">부산국제매직페스티벌 | Busan International Magic Festival<br>부산시 해운대구 123<br>TEL : 123-456-7890 | FAX : 098-765-4321 | E-mail : webskills@skills.com</div>
			<ul id="social">
				<li><a href="#"><img src="./img/icon/social1.png" alt="social1" title="social1"></a></li>
				<li><a href="#"><img src="./img/icon/social2.png" alt="social2" title="social2"></a></li>
				<li><a href="#"><img src="./img/icon/social3.png" alt="social3" title="social3"></a></li>
			</ul>
			<div id="copyright">Copyrightⓒ 2019, webskills all right reserved</div>
		</footer>
	`,
	props: ['custom'],
	created () {
	}
})
Vue.component('template-visual1', {
	template: `
		<section id="visual1" class="visual" ref="wrap">
			<!-- slide -->
			<div class="slide"
				 v-for="(image, k) in custom.images"
				 :key="k" @contextmenu.prevent="bus.contextmenu($event, 'image')"
				 :style="{backgroundImage: 'url('+image+')'}" />
			<div class="visual-text">
				<!-- visual.txt -->
				<h1 v-if="custom.title.show !== 'false'"
				    @contextmenu.prevent="bus.contextmenu($event, 'title')"
				    :style="{
				    	fontSize: custom.title.size + 'px',
				    	color: custom.title.color,
				    }">
				    {{custom.title.text}}
				</h1>
				<p @contextmenu.prevent="bus.contextmenu($event, 'description')"
				   v-if="custom.description.show !== 'false'"
				    :style="{
				    	fontSize: custom.description.size + 'px',
				    	color: custom.description.color,
				    }">{{custom.description.text}}</p>
				<a :href="custom.link.url" @contextmenu.prevent="bus.contextmenu($event, 'link')" class="btn" v-if="custom.link.show !== 'false'">{{custom.link.text}}</a>
			</div>
		</section>
	`,
	props: ['custom'],
	data () {
		return {
			timer: null
		}
	},
	methods: {
		slide () {
			const wrap = $(this.$refs.wrap)
			const len = wrap.find('.slide').length
			let pos = 0
			wrap.find('.slide.active').removeClass('active')
			wrap.find('.slide').eq(pos).addClass('active')
			const play = () => {
				clearTimeout(this.timer)
				wrap.find('.slide').eq(pos).removeClass('active')
				pos = (pos + 1) % len
				wrap.find('.slide').eq(pos).addClass('active')
				this.timer = setTimeout(play, 2000)
			}
			clearTimeout(this.timer)
			this.timer = setTimeout(play, 2000)
		}
	},
	mounted () {
		this.slide()
	},
	updated () {
		this.slide()
	},
})
Vue.component('template-visual2', {
	template: `
		<section id="visual2" class="visual" ref="wrap">

			<div class="visual-text">
				<!-- visual.txt -->
				<h1 v-if="custom.title.show !== 'false'"
				    @contextmenu.prevent="bus.contextmenu($event, 'title')"
				    :style="{
				    	fontSize: custom.title.size + 'px',
				    	color: custom.title.color,
				    }">
				    {{custom.title.text}}
				</h1>
				<p @contextmenu.prevent="bus.contextmenu($event, 'description')"
				   v-if="custom.description.show !== 'false'"
				    :style="{
				    	fontSize: custom.description.size + 'px',
				    	color: custom.description.color,
				    }">{{custom.description.text}}</p>
				<a :href="custom.link.url" @contextmenu.prevent="bus.contextmenu($event, 'link')" class="btn" v-if="custom.link.show !== 'false'">{{custom.link.text}}</a>
			</div>

			<div class="slide-section">
				<div class="slide"
					 v-for="(image, k) in custom.images"
					 :key="k" @contextmenu.prevent="bus.contextmenu($event, 'image')"
					 :style="{backgroundImage: 'url('+image+')'}" />
			</div>

			<div class="slide-btn prev">&lt;</div>
			<div class="slide-btn next">&gt;</div>

		</section>
	`,
	props: ['custom'],
	data () {
		return {
			timer: null,
			slider: null
		}
	},
	methods: {
		slide () {
			const wrap = $(this.$refs.wrap)
			let pos = 0, len = this.custom.images.length
			wrap.on('click', '.slide-btn', e => {
				const target = $(e.currentTarget)
				if (target.hasClass('none')) return false
				if (target.hasClass('prev')) pos -= 2
				play()
			})
			const play = () => {
				wrap.find('.slide-btn.none').removeClass('none')
				pos = (pos + 1) % len
				if (pos === 0) wrap.find('.slide-btn.prev').addClass('none')
				if (pos === len - 1) wrap.find('.slide-btn.next').addClass('none')
				wrap.find('.slide-section').css('left', -pos * 100 + '%')
			}
			return function () {
				len = this.custom.images.length
				wrap
				.find('.slide-section').css({
					'left': 0,
					'width': len * 100 + '%'
				})
				.find('.slide').css({
					'width': 100 / len + '%'
				})
				wrap.find('.slide-btn.none').removeClass('none')
				wrap.find('.slide-btn.prev').addClass('none')
				pos = 0
			}
		}
	},
	mounted () {
		this.slider = this.slide()
		this.slider()
	},
	updated () {
		this.slider()
	},
})
Vue.component('template-feature1', {
	template: `
		<section id="feature1" class="content">
			<h2>Features</h2>
			<div class="wrap">
				<article>
					<img src="./img/icon/1.png" alt="icon1" title="icon1" class="img-body">
					<h3>Lorem ipsum1</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam officia aspernatur nisi ut eligendi consectetur voluptate, fuga magni quasi. Nisi ratione veniam id illum, facere reiciendis assumenda quis quod maxime!</p>
					<button class="btn">Read More</button>
				</article>
				<article>
					<img src="./img/icon/2.png" alt="icon2" title="icon2" class="img-body">
					<h3>Lorem ipsum2</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam officia aspernatur nisi ut eligendi consectetur voluptate, fuga magni quasi. Nisi ratione veniam id illum, facere reiciendis assumenda quis quod maxime!</p>
					<button class="btn">Read More</button>
				</article>
				<article>
					<img src="./img/icon/3.png" alt="icon3" title="icon3" class="img-body">
					<h3>Lorem ipsum3</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam officia aspernatur nisi ut eligendi consectetur voluptate, fuga magni quasi. Nisi ratione veniam id illum, facere reiciendis assumenda quis quod maxime!</p>
					<button class="btn">Read More</button>
				</article>
			</div>
		</section>
	`,
	props: ['custom'],
	created () {
	}
})
Vue.component('template-feature2', {
	template: `
		<section id="feature2" class="content">
			<h2>Features</h2>
			<div class="wrap">
				<article>
					<div class="img">
						<img src="./img/icon/4.png" alt="icon1" title="icon1" class="img-body">
					</div>
					<h3>Lorem ipsum1</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam officia aspernatur nisi ut eligendi consectetur voluptate, fuga magni quasi. Nisi ratione veniam id illum, facere reiciendis assumenda quis quod maxime!</p>
					<button type="button">Read More</button>
				</article>
				<article>
					<div class="img">
						<img src="./img/icon/5.png" alt="icon2" title="icon2" class="img-body">
					</div>
					<h3>Lorem ipsum2</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam officia aspernatur nisi ut eligendi consectetur voluptate, fuga magni quasi. Nisi ratione veniam id illum, facere reiciendis assumenda quis quod maxime!</p>
					<button type="button">Read More</button>
				</article>
				<article>
					<div class="img">
						<img src="./img/icon/6.png" alt="icon3" title="icon3" class="img-body">
					</div>
					<h3>Lorem ipsum3</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam officia aspernatur nisi ut eligendi consectetur voluptate, fuga magni quasi. Nisi ratione veniam id illum, facere reiciendis assumenda quis quod maxime!</p>
					<button type="button">Read More</button>
				</article>
			</div>
		</section>
	`,
	props: ['custom'],
	created () {
	}
})
Vue.component('template-gallery1', {
	template: `
		<section id="gallery1" class="content">
			<h2>Gallery</h2>
			<input type="radio" name="pos" id="pos1" checked>
			<input type="radio" name="pos" id="pos2">
			<input type="radio" name="modal" id="modal1">
			<input type="radio" name="modal" id="modal2">
			<input type="radio" name="modal" id="modal3">
			<input type="radio" name="modal" id="modal4">
			<input type="radio" name="modal" id="modal5">
			<input type="radio" name="modal" id="modal6">
			<input type="radio" name="modal" id="close">
			<div id="modal">
				<div class="wrap">
					<img src="./img/gallery/19.jpg" alt="19.jpg" title="19.jpg">
					<img src="./img/gallery/24.jpg" alt="24.jpg" title="24.jpg">
					<img src="./img/gallery/11.jpg" alt="11.jpg" title="11.jpg">
					<img src="./img/gallery/20.jpg" alt="20.jpg" title="20.jpg">
					<img src="./img/gallery/27.jpg" alt="27.jpg" title="27.jpg">
					<img src="./img/gallery/25.jpg" alt="25.jpg" title="25.jpg">
					<label for="close">X</label>
				</div>
			</div>
			<div class="wrap">
				<div>
					<article>
						<label for="modal1"></label>
						<div class="img"></div>
						<div class="text">
							<h3>Lorem ipsum1</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
					<article>
						<label for="modal2"></label>
						<div class="img"></div>
						<div class="text">
							<h3>Lorem ipsum2</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
					<article>
						<label for="modal3"></label>
						<div class="img"></div>
						<div class="text">
							<h3>Lorem ipsum3</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
					<article>
						<label for="modal4"></label>
						<div class="img"></div>
						<div class="text">
							<h3>Lorem ipsum4</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
					<article>
						<label for="modal5"></label>
						<div class="img"></div>
						<div class="text">
							<h3>Lorem ipsum5</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
					<article>
						<label for="modal6"></label>
						<div class="img"></div>
						<div class="text">
							<h3>Lorem ipsum6</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
				</div>
			</div>
			<div class="btns">
				<label for="pos1"></label>
				<label for="pos2"></label>
			</div>
		</section>
	`,
	props: ['custom'],
	created () {
	}
})
Vue.component('template-gallery2', {
	template: `
		<section id="gallery2" class="content">
			<h2>Gallery</h2>
			<input type="radio" name="modal" id="modal1">
			<input type="radio" name="modal" id="modal2">
			<input type="radio" name="modal" id="modal3">
			<input type="radio" name="modal" id="modal4">
			<input type="radio" name="modal" id="modal5">
			<input type="radio" name="modal" id="modal6">
			<input type="radio" name="modal" id="modal7">
			<input type="radio" name="modal" id="close">
			<div id="modal">
				<div class="wrap">
					<img src="./img/gallery/19.jpg" alt="19.jpg" title="19.jpg">
					<img src="./img/gallery/24.jpg" alt="24.jpg" title="24.jpg">
					<img src="./img/gallery/11.jpg" alt="11.jpg" title="11.jpg">
					<img src="./img/gallery/20.jpg" alt="20.jpg" title="20.jpg">
					<img src="./img/gallery/27.jpg" alt="27.jpg" title="27.jpg">
					<img src="./img/gallery/25.jpg" alt="25.jpg" title="25.jpg">
					<img src="./img/gallery/26.jpg" alt="26.jpg" title="26.jpg">
					<label for="close">X</label>
				</div>
			</div>
			<div class="wrap">
				<div class="left side">
					<article>
						<label for="modal1"></label>
						<div class="text">
							<h3>Lorem ipsum1</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
					<article>
						<label for="modal2"></label>
						<div class="text">
							<h3>Lorem ipsum2</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
				</div>
				<div class="middle">
					<article>
						<label for="modal3"></label>
						<div class="text">
							<h3>Lorem ipsum3</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
					<article>
						<label for="modal4"></label>
						<div class="text">
							<h3>Lorem ipsum4</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
					<article>
						<label for="modal5"></label>
						<div class="text">
							<h3>Lorem ipsum5</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
				</div>
				<div class="right side">
					<article>
						<label for="modal6"></label>
						<div class="text">
							<h3>Lorem ipsum6</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
					<article>
						<label for="modal7"></label>
						<div class="text">
							<h3>Lorem ipsum7</h3>
							<p class="sub">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="desc">Tempore harum laborum eos nisi rerum ad aspernatur explicabo. Obcaecati commodi ipsa, corporis, dolores saepe exercitationem perspiciatis esse quos totam autem iure.</p>
						</div>
					</article>
				</div>
			</div>
		</section>
	`,
	props: ['custom'],
	created () {
	}
})
Vue.component('template-contact1', {
	template: `
		<section id="contacts1">
			<div class="wrap">
				<form class="contact-form">
					<h2>Contact Us</h2>
					<label for="name"><input type="text" name="name" id="name" placeholder="이름을 입력하세요."></label>
					<label for="email"><input type="email" name="email" id="email" placeholder="이메일을 입력하세요."></label>
					<label for="message">
						<textarea name="message" id="message" placeholder="메시지를 입력하세요."></textarea>
					</label>
					<button type="submit" class="btn">전송</button>
				</form>
				<div class="contact-info">
					<h3>Contact information</h3>
					<div>
						<div class="address">
							<div class="icon"><img src="./img/icon/location.png" alt="location" title="location"></div>
							<p>주소 : 부산시 해운대구 123</p>
						</div>
						<div class="tel">
							<div class="icon"><img src="./img/icon/phone.png" alt="phone" title="phone"></div>
							<p>전화번호 : 123-456-7890</p>
						</div>
						<div class="email">
							<div class="icon"><img src="./img/icon/email.png" alt="email" title="email"></div>
							<p>이메일 : webskills@skills.com</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	`,
	props: ['custom'],
	created () {
	}
})
Vue.component('template-contact2', {
	template: `
		<section id="contacts2">
			<div class="contact-info">
				<div>
					<article class="address">
						<div class="icon"><img src="./img/icon/location.png" alt="location" title="location"></div>
						<p>주소 : 부산시 해운대구 123</p>
					</article>
					<article class="tel">
						<div class="icon"><img src="./img/icon/phone.png" alt="phone" title="phone"></div>
						<p>전화번호 : 123-456-7890</p>
					</article>
					<article class="email">
						<div class="icon"><img src="./img/icon/email.png" alt="email" title="email"></div>
						<p>이메일 : webskills@skills.com</p>
					</article>
				</div>
			</div>
			<form class="contact-form">
				<h2>Contact Us</h2>
				<label for="name"><input type="text" name="name" id="name" placeholder="이름을 입력하세요."></label>
				<label for="email"><input type="email" name="email" id="email" placeholder="이메일을 입력하세요."></label>
				<label for="message">
					<textarea name="message" id="message" placeholder="메시지를 입력하세요."></textarea>
				</label>
				<button type="submit" class="btn">전송</button>
			</form>
		</section>
	`,
	props: ['custom'],
	created () {
	}
})
Vue.component('option-header', {
	template: `
		<form class="fields" @submit.prevent="update">
			<fieldset><legend class="legend">헤더 옵션 설정</legend>
				<ul>
					<li v-if="[null, 'logo'].indexOf(filter) !== -1">
						<label>
							<span class="fields__list">로고 파일 업로드</span>
							<input type="file" class="fields__input full" />
						</label>
					</li>
					<li v-if="[null, 'logo'].indexOf(filter) !== -1">
						<span class="fields__list">로고 목록</span>
						<div>
							<label class="fields__custom-radio" v-for="(logo, k) in logos" :key="k">
								<input type="radio" name="img" :value="logo" />
								<img :src="logo" :alt="'logo' + k" height="30" />
							</label>
						</div>
					</li>
					<li v-if="[null, 'menu'].indexOf(filter) !== -1">
						<span class="field__list">메뉴설정</span>
						<div class="fields__input-list" v-for="(n, k) in 5" :key="k">
							<label>
								<span>메뉴 {{n}} 이름</span>
								<input type="text" name="menu_name" class="fields__input full" :value="custom.menu[k] ? custom.menu[k].name : ''" />
							</label>
							<label>
								<span>메뉴 {{n}} URL</span>
								<select name="menu_url">
									<option value="#">#</option>
									<option v-for="url in bus.urls" :key="url" :value="url" v-html="url" />
								</select>
							</label>
						</div>
					</li>
					<li class="fields__buttons">
						<button type="submit" class="btn">작성완료</button>
					</li>
				</ul>
			</fieldset>
		</form>
	`,
	data () {
		return {
			logos: [
				'./img/logo/logo1.png',
				'./img/logo/logo2.png',
				'./img/logo/logo3.png'
			],
			filter: null,
			custom: bus.selectedPage.template[bus.selectedTemplate].data,
		}
	},
	methods: {
		update (e) {
			const frm = e.target
			const obj = this.custom
			if ([null, 'logo'].indexOf(this.filter) !== -1) {
				obj.logo = frm.img.value
			}
			if ([null, 'menu'].indexOf(this.filter) !== -1) {
				const menus = []
				frm.menu_name.forEach((v, k) => {
					if (v.value.length === 0) return
					menus.push({
						name: frm.menu_name[k].value,
						url: frm.menu_url[k].value,
					})
				})
				if (menus.length < 3) {
					alert('메뉴는 최소 3개이상 필요합니다.')
					return false
				}
				this.custom.menu = menus
			}
			bus.model.setPage(bus.pages)
		}
	},
	created () {
		this.filter = bus.filter
		bus.filter = null
	}
})
Vue.component('option-visual', {
	template: `
		<form class="fields" @submit.prevent="update">
			<fieldset><legend class="legend">Visual 옵션 설정</legend>
				<ul>
					<li v-if="filter === 'image'">
						<span class="fields__list">비주얼이미지</span>
						<button type="button" class="btn" @click="visualImageList">비주얼이미지수정</button>
					</li>
					<li v-if="filter === null">
						<span class="fields__list">타이틀</span>
						<div>
							<label class="fields__custom-radio">
								<input type="radio" name="show_title" v-model="custom.title.show" value="true" />
								<span>보이기</span>
							</label>
							<label class="fields__custom-radio">
								<input type="radio" name="show_title" v-model="custom.title.show" value="false" />
								<span>감추기</span>
							</label>
						</div>
					</li>
					<li v-if="filter === null">
						<span class="fields__list">요약설명</span>
						<div>
							<label class="fields__custom-radio">
								<input type="radio" name="show_description" v-model="custom.description.show" value="true" />
								<span>보이기</span>
							</label>
							<label class="fields__custom-radio">
								<input type="radio" name="show_description" v-model="custom.description.show" value="false" />
								<span>감추기</span>
							</label>
						</div>
					</li>
					<li v-if="filter === null">
						<span class="fields__list">바로가기링크</span>
						<div>
							<label class="fields__custom-radio">
								<input type="radio" name="show_link" v-model="custom.link.show" value="true" />
								<span>보이기</span>
							</label>
							<label class="fields__custom-radio">
								<input type="radio" name="show_link" v-model="custom.link.show" value="false" />
								<span>감추기</span>
							</label>
						</div>
					</li>
					<li v-if="filter === 'title'">
						<label>
							<span class="fields__list">타이틀 텍스트</span>
							<input v-model="custom.title.text" class="fields__input full" />
						</label>
					</li>
					<li v-if="filter === 'title'">
						<label>
							<span class="fields__list">타이틀 색상</span>
							<input v-model="custom.title.color" class="fields__input full" />
						</label>
					</li>
					<li v-if="filter === 'title'">
						<label>
							<span class="fields__list">타이틀 사이즈</span>
							<input v-model="custom.title.size" class="fields__input full" />
						</label>
					</li>
					<li v-if="filter === 'description'">
						<label>
							<span class="fields__list">요약설명 텍스트</span>
							<input v-model="custom.description.text" class="fields__input full" />
						</label>
					</li>
					<li v-if="filter === 'description'">
						<label>
							<span class="fields__list">요약설명 색상</span>
							<input v-model="custom.description.color" class="fields__input full" />
						</label>
					</li>
					<li v-if="filter === 'description'">
						<label>
							<span class="fields__list">요약설명 사이즈</span>
							<input v-model="custom.description.size" class="fields__input full" />
						</label>
					</li>
					<li v-if="filter === 'link'">
						<label>
							<span class="fields__list">요약설명 텍스트</span>
							<input v-model="custom.link.text" class="fields__input full" />
						</label>
					</li>
					<li v-if="filter === 'link'">
						<label>
							<span class="fields__list">요약설명 색상</span>
							<select v-model="custom.link.url">
								<option value="#">#</option>
								<option v-for="url in bus.urls" :key="url" :value="url" v-html="url" />
							</select>
						</label>
					</li>
				</ul>
			</fieldset>
		</form>
	`,
	data () {
		return {
			filter: null,
			custom: bus.selectedPage.template[bus.selectedTemplate].data,
		}
	},
	methods: {
		update (e) {
			const frm = e.target
			const obj = this.custom
			bus.model.setPage(bus.pages)
		},
		visualImageList () {
			bus.layerOpen('비주얼이미지 수정', 'option-visual-image', '600')
		}
	},
	created () {
		this.filter = bus.filter
		bus.filter = null
	}
})
Vue.component('option-visual-image', {
	template: `
		<form class="fields">
			<fieldset><legend class="legend">헤더 옵션 설정</legend>
				<ul>
					<li>
						<label>
							<span class="fields__list">비주얼 이미지 업로드</span>
							<input type="file" class="fields__input full" @change="imageUpload" />
						</label>
					</li>
					<li>
						<span class="fields__list">비주얼 이미지 목록</span>
						<div>
							<label class="fields__custom-radio" v-for="(img, k) in list" :key="k">
								<input type="checkbox" name="img"
										:value="img"
										v-model="custom.images"
										@click="lengthCheck" />
								<img :src="img" :alt="'img' + k" height="60" />
							</label>
						</div>
					</li>
				</ul>
			</fieldset>
		</form>
	`,
	data () {
		return {
			custom: bus.selectedPage.template[bus.selectedTemplate].data,
			list: [
				'./img/visual/1.jpg',
				'./img/visual/2.jpg',
				'./img/visual/3.jpg',
				'./img/visual/4.jpg',
				'./img/visual/5.jpg',
				'./img/visual/6.jpg',
				'./img/visual/7.jpg',
			]
		}
	},
	methods: {
		imageUpload (e) {
			const files = e.target.files
			if (files.length) {
				const reader = new FileReader()
				reader.onload = () => {
					this.list.push(reader.result)
				}
				reader.readAsDataURL(files[0])
			}
		},
		lengthCheck (e) {
			if (this.custom.images.length === 0)
			this.custom.images.push(e.target.value)
		}
	},
	created () {
		
	}
})
const bus = new Vue({
	data: {
		isLayer: false,
		layerWidth: 800,
		layerTitle: '레이어 팝업',
		layerBody: null,
		pages: [],
		model: null,
		selectedTemplate: null,
		filter: null
	},
	computed: {
		urls () {
			return bus.pages.map(v => v.id)
		},
		selectedPage () {
			return bus.pages.find(v => v.selected === true)
		}
	},
	methods: {
		layerOpen (title, body, width = 800) {
			this.isLayer = true
			this.layerTitle = title
			this.layerBody = body
			this.layerWidth = width
		},
		contextmenu (e, filter) {
			const parent = $(e.currentTarget).closest('#templatePreview>*')
			$('#templatePreview>*.active').removeClass('active')
			parent.addClass('active')
			bus.selectedTemplate = parent.index()
			bus.filter = filter
			this.templateOptionOpen()
		},
		templateOptionOpen () {
			const type = bus.selectedPage.template[bus.selectedTemplate].compo.replace(/template\-([a-z]+)[0-9]*/, '$1')
			bus.layerOpen('옵션 설정', 'option-'+type, 700)
		}
	}
})

model.init().then(model => {
	bus.model = model
	new Vue({
		el: '#builder-app',
		template: `
			<div id="site-wrap">
				<div class="builder-header">
					<button type="button" class="btn" @click="pageAdminOpen">페이지 관리</button>
					<div>
						<button type="button" class="btn" @click="pageTemplateOpen">템플릿 추가</button>
						<button v-if="bus.selectedTemplate !== null" type="button" class="btn" @click="bus.templateOptionOpen">설정</button>
					</div>
				</div>
				<template-preview v-if="bus.selectedPage"></template-preview>
				<layer-popup v-if="bus.isLayer"></layer-popup>
			</div>
		`,
		methods: {
			pageAdminOpen () {
				bus.layerOpen('페이지 관리', 'page-admin')
			},
			pageTemplateOpen () {
				bus.layerOpen('템플릿 추가', 'template-adder', 500)
			}
		},
		async created () {
			bus.pages = await bus.model.getPage()
		}
	})
})

$(document)
	.on('click', '[href="#"]', () => false)
	.on('click', '#templatePreview>*', function () {
		$('#templatePreview>*.active').removeClass('active')
		$(this).addClass('active')
		bus.selectedTemplate = $(this).index()
	})

$(window)
	.on('keydown', e => {
		if (e.keyCode === 27) {
			bus.isLayer = false
		}
	})