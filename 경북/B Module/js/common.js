const data =  {url: null, drawType: null}

const formatTime = t => [~~(t/3600), ~~(t/60)%60, ~~t%60, ~~(t*100)%100].map(v => `0${v}`.substr(-2)).join(':')

const selectVideo = function () {
  data.url = this.dataset.url
  $(".none").hide()
  $("video").show()
  $("svg").show()
  const video = $("video")[0]
  video.setAttribute('src', `./movie/${data.url}.mp4`)
  video.load()
  video.oncanplay = _ => {
    $("#video-time > .duration").text(formatTime(video.duration))
  }
}
const editStart = function (e) {
  if (!data.url) {
    alert('비디오를 선택하세요')
    e.preventDefault()
  }

  const id = this.children[0].id
  switch (id) {
    case 'play':
    case 'pause': $('video')[0][id](); break;
  }
}
const selectType = function () {
  data.drawType = this.children[0].id
}

const loadOn = _ => {
  setInterval(_ => {
    $("#video-time > .current").text(formatTime($("video")[0].currentTime))
  }, 1000/60)
}

$(loadOn)
.on('click', 'a[href="#"]', e => e.preventDefault())
.on('click', '#edit-tools > [name="edit"]', selectType)
.on('mousedown', 'svg', selectType)
.on('click', '#poster-list > a', selectVideo)
.on('click', '#edit-tools > label', editStart)