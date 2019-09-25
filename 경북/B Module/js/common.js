const data = { video: null, drawType: null, weight: 3, size: 16, color: '#999', clips: [] }

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
    const width = x - this._x, height = y - this._y
    const attr = {}
    if (width < 0) attr.x = x
    if (height < 0) attr.y = y
    setAttr(target, {...attr, width: Math.abs(width), height: Math.abs(height)})
  }
  end () { super.end(); setAttr(this._target, {'fill': data.color}) }
}
const Text = class {
  constructor ({x, y}) {
    this.x = x, this.y = y
    const target = document.createElement('div')
    setAttr(target, {
      contentEditable: true,
      style: `position: absolute;left:${x}px;top:${y}px;font-size:${data.size};color:${data.color}};z-index:50`
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
    $('#video-edit svg').append(text)
    drawEnd(target)
  }
}

const setAttr = (target, attr) => { for (const key in attr) { target.setAttribute(key, attr[key]) } }
const timeFormat = t => [~~(t/3600), ~~(t/60)%60, ~~t%60, ~~(t*100)%100].map(v => `0${v}`.substr(-2)).join(':')

const selectVideo = function () {
  data.video = this.dataset.url
  $(".none").hide()
  $("video").show()
  $("svg").show()
  const video = $("video")[0]
  video.setAttribute('src', `./movie/${data.video}.mp4`)
  video.load()
  video.oncanplay = _ => {
    $("#video-time > .duration").text(timeFormat(video.duration))
  }
}
const editStart = function (e) {
  if (!data.video) {
    alert('비디오를 선택하세요')
    e.preventDefault()
  }

  const id = this.children[0].id
  switch (id) {
    case 'play':
    case 'pause': $('video')[0][id](); break;
  }
}
const selectType = function () { data.drawType = this.children[0].id; console.log(this.children[0]) }

const drawEnd = (el, { duration } = data.video, start = 0, end = duration) => {
  data.clips.push({ start, end, duration, el })
  // timelineRender(data.clips)
}
const draw = (_ => {
  let nowTarget = null
  return e => {
    if ($('[name="edit"]:checked').length  === 0) return
    alert('asdf')
  }
})();


$( _ => setInterval( _ => $("#video-time > .current").text(timeFormat( $("video")[0].currentTime) ), 1000/60 ) )
.on('click', 'a[href="#"]', e => e.preventDefault())
.on('click', '#edit-tools > [name="edit"]', selectType)
.on('mousedown', 'svg', selectType)
.on('click', '#poster-list > a', selectVideo)
.on('click', '#edit-tools > label', editStart)
.on('mousedown', '#video-edit > svg', draw)