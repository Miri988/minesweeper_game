let timer = 0
let interval = null
let isCompleted = false

const processUrl = 'service/process.php?type='

const setTimer = (val = 0) => {
  timer = val
  interval = setInterval(() => {
    timer++
    updateTime()
  }, 1000)
}

const updateTime = () => {
  document.querySelector('span.timer > .text').innerText = secondsToTime(timer) 
}

const clearTimer = () => {
  clearInterval(interval)
}

const processGame = async (type, ...params) => {
  if (isCompleted) return
  let query = null
  if (type === 'start') {
    query = `&difficulty=${params[0]}`
  } else if (['reveal', 'mark'].includes(type)) {
    const [x, y] = params
    query = `&x=${x}&y=${y}`
  }
  const data = await fetch(processUrl + type + query)
  document.querySelector('#main').innerHTML = await data.text()
  updateTime()
  const message = document.querySelector('.message')
  if (type === 'start') {
    setTimer()
  } else if (message) {
    clearTimer()
    isCompleted = true
  }
}

document.querySelector('button[name=start]')?.addEventListener('click', () => {
  const difficulty = document.querySelector('select[name=difficulty]')?.value ?? 1
  processGame('start', difficulty)
})

document.querySelector('button[name=resume]')?.addEventListener('click', () => {
  processGame('resume');
})

document.addEventListener('click', (e) => {
  const target = e.target
  if (target.classList.contains('cell')) {
    const x = target.getAttribute('x')
    const y = target.getAttribute('y')
    processGame('reveal', x, y)
  }
})

document.addEventListener('contextmenu', (e) => {
  const target = e.target
  if (target.classList.contains('cell')) {
    e.preventDefault()
    const x = target.getAttribute('x')
    const y = target.getAttribute('y')
    processGame('mark', x, y)
  }
})

const secondsToTime = (s) => {
  const seconds = s % 60
  const minutes = Math.floor(s % 3600 / 60)
  const hours = Math.floor(s / 3600)
  return `${String(hours).padStart(2, '0')}:` +
         `${String(minutes).padStart(2, '0')}:` +
         `${String(seconds).padStart(2, '0')}`
}
