window.paused = false
window.seconds = 60
window.finishedPraying = false

const contentElement = document.querySelector('#content')
const prayingText = document.querySelector('.praying__text')
const locationName = document.querySelector('#location-name')
const prayingButton = document.querySelector('#praying-button')
const prayingCloseButton = document.querySelector('#praying__close_button')
const prayingContinueButton = document.querySelector('#praying__continue_button')
const prayingProgress = document.querySelector('.praying__progress')
const tutorial = document.querySelector('#tutorial-location')

const prayingPanel = document.querySelector('#praying-panel')
const decisionPanel = document.querySelector('#decision-panel')
const questionPanel = document.querySelector('#question-panel')

const populationInfoNo = document.querySelector('.population-info .no')
const populationInfoNeutral = document.querySelector('.population-info .neutral')
const populationInfoYes = document.querySelector('.population-info .yes')

checkForLocationAndLoad(init)

function init(location) {

  renderContent(location)

  toggleTimer( false )

  setupListeners()
}

function setupListeners() {
  prayingButton.addEventListener('click', () => toggleTimer())
  prayingCloseButton.addEventListener('click', () => toggleTimer(true))
  prayingContinueButton.addEventListener('click', () => toggleTimer(false))
}

function toggleTimer( pause ) {
  let pauseTimer = false

  if ( typeof pause === 'undefined' ) {
    pauseTimer = !window.paused
  } else {
    pauseTimer = pause
  }
  window.paused = pauseTimer

  if (pauseTimer) {
    prayingText.innerHTML = escapeHTML(jsObject.translations.praying_paused)

    /* Show and hide the neccessary UI */
    hide(prayingCloseButton)
    show(prayingContinueButton)

    show(decisionPanel)

    /* clear the interval */
    clearInterval(window.pgInterval)
  } else {
    prayingText.innerHTML = escapeHTML(jsObject.translations.keep_praying)

    /* Show and hide the necessary UI */
    show(prayingCloseButton)
    hide(prayingContinueButton)

    hide(decisionPanel)

    /* Restart the interval */
    startTimer( window.time )
  }
}

function startTimer(time) {
  if (!time) {
    window.time = 0
  }

  window.pgInterval = setInterval(() => {
    window.time = window.time + 0.1

    if (window.time < window.seconds) {

      let percentage = window.time / window.seconds * 100

      if (percentage > 100) {
        percentage = 100
      }

      prayingProgress.style.width = `${percentage}%`

    }
    else if (!window.finishedPraying) {
      window.finishedPraying = true

      show(questionPanel)
      hide(prayingPanel)

      prayingProgress.style.width = 0
    }

  }, 100)

}

function hide(element) {
  element.dataset.oldDisplay = element.style.display !== 'none' ? element.style.display : 'block'
  element.style.display = 'none'
}
function show(element) {
  element.style.display = element.dataset.oldDisplay || 'block'
}

function escapeHTML(str) {
  if (typeof str === 'undefined') return '';
  if (typeof str !== 'string') return str;
  return str
  .replace(/&/g, '&amp;')
  .replace(/</g, '&lt;')
  .replace(/>/g, '&gt;')
  .replace(/"/g, '&quot;')
  .replace(/'/g, '&apos;');
}

/* Fly away the see more button after a little bit of scroll */
const seeMoreButton = document.querySelector('#see-more-button')
if (window.scrollY < 100) {
    seeMoreButton.style.display = ''
    window.addEventListener('scroll', removeSeeMoreButton)
}
function removeSeeMoreButton() {
    const scrollTop = window.scrollY

    if (scrollTop > 100) {
        seeMoreButton.style.opacity = `${(250 - scrollTop) / 150}`
    }

    if (scrollTop > 250) {
        seeMoreButton.style.display = 'none'
        window.removeEventListener('scroll', removeSeeMoreButton)
    }
}


/* We need to check and keep checking that the location object is ready to use */
function checkForLocationAndLoad(callback) {
    let checkingInterval

    if (jsObject.current_content && jsObject.current_content.location) {
        callback(jsObject.current_content.location)
        return
    }

    checkingInterval = setInterval(() => {
        if (jsObject.current_content && jsObject.current_content.location) {
            clearInterval(checkingInterval)

            callback(jsObject.current_content.location)
        }
    }, 50)
}

function clearTutorial() {
  setTimeout(() => {
    tutorial.style.display = 'none'
  }, 3000)
}

function renderContent(content) {
    if (!content) {
        return
    }

    const { location, list, parts } = content

    locationName.innerHTML = escapeHTML( jsObject.translations.state_of_location.replace('%1$s', location.admin_level_name_cap).replace('%2$s', location.full_name) )

    /* Render the content */
    const arrayList = Array.isArray(list) ? list : Object.values(list)
    const blockTemplates = arrayList.map((block) => getBlockTemplate(block))

    contentElement.innerHTML = `
    <hr />

    ${blockTemplates.join('<hr>')}

    <hr />
    `

    clearTutorial()
    populationInfoNo.innerHTML = location.non_christians
    populationInfoNeutral.innerHTML = location.christian_adherents
    populationInfoYes.innerHTML = location.believers
}

function getBlockTemplate(block) {
    switch (block.type) {
        case '4_fact_blocks':
            return _template_4_fact_blocks(block.data)
        case 'percent_3_circles':
            return _template_percent_3_circles(block.data)
        case 'percent_3_bar':
            return _template_percent_3_bar(block.data)
        case '100_bodies_chart':
            return _template_100_bodies_chart(block.data)
        case '100_bodies_3_chart':
            return _template_100_bodies_3_chart(block.data)
        case 'population_change_icon_block':
            return _template_population_change_icon_block(block.data)
        case 'bullet_list_2_column':
            return _template_bullet_list_2_column(block.data)
        case 'people_groups_list':
            return _template_people_groups_list(block.data)
        case 'least_reached_block':
            return _template_least_reached_block(block.data)
        case 'fact_block':
            return _template_fact_block(block.data)
        case 'content_block':
            return _template_content_block(block.data)
        case 'photo_block':
            return _template_photo_block(block.data)
        case 'verse_block':
            return _template_verse_block(block.data)
        case 'prayer_block':
            return _template_prayer_block(block.data)
        case 'basic_block':
            return _template_basic_block(block.data)
        case 'lost_per_believer':
            return _template_lost_per_believer_block(block.data)
        default:
            return ''
    }
}
function _template_percent_3_circles(data) {
  return `
    <div class="block percent-3-circles-block">
        <h5>${data.section_label}</h5>
        <div class="switcher">
            <div class="flow sm">
                <p class="bold f-md">${data.label_1}</p>
                <div class="pie" style="--p:${data.percent_1};--b:10px;--c:var(--pg-dark);">${data.percent_1}%</div>
                <p class="f-lg">${data.population_1}</p>
            </div>
            <div class="flow sm">
                <p class="bold f-md">${data.label_2}</p>
                <div class="pie" style="--p:${data.percent_2};--b:10px;--c:var(--pg-light);">${data.percent_2}%</div>
                <p class="f-lg">${data.population_2}</p>
            </div>
            <div class="flow sm">
                <p class="bold f-md">${data.label_3}</p>
                <div class="pie" style="--p:${data.percent_3};--b:10px;--c:var(--pg-orange);">${data.percent_3}%</div>
                <p class="f-lg">${data.population_3}</p>
            </div>
        </div>
    </div>`

}
function _template_percent_3_bar(data) {
    return (
        `<div class="block percent-3-bar-block">
          <div class="row">
          <div class="col text-center ">
             <h5 class="mb-0 uc">${data.section_label}</h5>
          </div>
      </div>
      <div class="row text-center">
          <div class="col-md-12">
            <p class="mt-0 mb-3 font-weight-normal">
              <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" style="width:${data.percent_1}%">
                  ${data.label_1}
                </div>
                <div class="progress-bar progress-bar-warning" role="progressbar" style="width:${data.percent_2}%">
                  ${data.label_2}
                </div>
                <div class="progress-bar progress-bar-danger" role="progressbar" style="width:${data.percent_3}%">
                 ${data.label_3}
                </div>
              </div>
            </p>
          </div>
      </div>
      <div class="row text-center">
        <div class="col">
           <p class="font-weight-normal">${data.section_summary}</p>
        </div>
      </div>
      <div class="row text-center justify-content-center">
        <div class="col-md-8">
           <p class="mt-3 mb-3 font-weight-normal one-em">${data.prayer}</p>
        </div>
      </div>
    </div>`
    )
}
function _template_100_bodies_chart(data) {
    let bodies = ''
    let i = 0
    i = 0
    while (i < data.percent_1) {
        bodies += BodyIcon('bad');
        i++;
    }
    i = 0
    while (i < data.percent_2) {
        bodies += BodyIcon('neutral');
        i++;
    }
    i = 0
    while (i < data.percent_3) {
        bodies += BodyIcon('good');
        i++;
    }
    return `
        <div class="block 100-bodies-chart-block">
            <h5>${data.section_label}</h5>
            <div class="content">
                <p class="f-xlg">
                    ${bodies}
                </p>
            </div>
            <p>${data.section_summary}</p>
        </div>
    `
}
function _template_100_bodies_3_chart(data) {
    let bodies_1 = ''
    let bodies_2 = ''
    let bodies_3 = ''
    i = 0
    while (i < data.percent_1) {
        bodies_1 += BodyIcon('bad');
        i++;
    }
    i = 0
    while (i < data.percent_2) {
        bodies_2 += BodyIcon('neutral');
        i++;
    }
    i = 0
    while (i < data.percent_3) {
        bodies_3 += BodyIcon('good');
        i++;
    }
    return `
        <div class="block 100-bodies-3-chart-block">
            <h5>${data.section_label}</h5>
            <div class="switcher">
                <div class="flow sm">
                  <p class="bold">${data.label_1}</p>
                  <p class="f-xlg">
                    ${bodies_1}
                  </p>
                  <p class="f-lg">${data.population_1}</p>
                </div>
                <div class="flow sm">
                  <p class="bold">${data.label_2}</p>
                  <p class="f-xlg">
                    ${bodies_2}
                  </p>
                  <p class="f-lg">${data.population_2}</p>
                </div>
                <div class="flow sm">
                  <p class="bold">${data.label_3}</p>
                  <p class="f-xlg">
                    ${bodies_3}
                  </p>
                  <p class="f-lg">${data.population_3}</p>
                </div>
            </div>
        </div>
    `
}
function _template_population_change_icon_block(data) {
    if (data.count === '0' || data.count.length > 3) {
        return
    }

    // icon types
    let icons = ''
    if ('deaths' === data.type) {
        icons = ['ion-sad']
    } else {
        icons = ['ion-happy']
    }
    let icon = icons[Math.floor(Math.random() * icons.length)]

    // icon color
    let icon_color = 'bad'
    if ('christian_adherents' === data.group) {
        icon_color = 'neutral'
    }
    if ('believers' === data.group) {
        icon_color = 'good'
    }

    // icon size
    let icon_size = 'three-em'
    if (2 === data.size) {
        icon_size = 'two-em'
    }

    let font_size = 'f-xlg'
    if (data.count > 1000) {
        font_size = 'f-lg'
    } else if (data.count < 20) {
        font_size = 'f-xxlg'
    }

    // build icon list
    let icon_list = ''
    i = 0
    while (i < data.count) {
        icon_list += '<i class="' + icon + ' ' + icon_color + '"></i>';
        i++;
    }
    return `
        <div class="block population-change-block">
            <h5>${data.section_label}</h5>
            <div class="content flow f-xlg">
                <p>${data.section_summary}</p>
                <p class="${font_size} icon-block">
                    ${icon_list} <span style="font-size:.5em;vertical-align:middle;">(${data.count})</span>
                </p>
                <p>${data.prayer}</p>
            </div>
        </div>
    `
}
function _template_4_fact_blocks(data) {
    return (
        `<div class="block four-facts-block">
          <div class="row">
          <div class="col text-center ">
             <h5 class="mb-0 uc">${data.section_label}</h5>
             <p class="mt-3 mb-3 two-em">${data.focus_label}</p>
          </div>
      </div>
      <div class="row">
          <div class="col-md-6">
            <div class="row text-center">
              <div class="col-6">
                <p class="mt-3 mb-0 font-weight-bold">${data.label_1}</p>
                <p class="mt-0 mb-3 font-weight-normal ${data.size_1}">${data.value_1}</p>
              </div>
              <div class="col-6">
                <p class="mt-3 mb-0 font-weight-bold">${data.label_2}</p>
                <p class="mt-0 mb-3 font-weight-normal ${data.size_2}">${data.value_2}</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row text-center">
                <div class="col-6">
                  <p class="mt-3 mb-0 font-weight-bold">${data.label_3}</p>
                  <p class="mt-0 mb-3 font-weight-normal ${data.size_3}">${data.value_3}</p>
                </div>
                <div class="col-6">
                  <p class="mt-3 mb-0 font-weight-bold">${data.label_4}</p>
                  <p class="mt-0 mb-3 font-weight-normal ${data.size_4}">${data.value_4}</p>
                </div>
            </div>
          </div>
      </div>

      <div class="row text-center">
        <div class="col">
           <p class="font-weight-normal">${data.section_summary}</p>
        </div>
      </div>
      <div class="row text-center justify-content-center">
        <div class="col-md-8">
           <p class="mt-3 mb-3 font-weight-normal one-em">${data.prayer}</p>
        </div>
      </div>
    </div>`
    )
}
function _template_bullet_list_2_column(data) {
    if (data.values.length > 0) {
        let values_list = ''
        jQuery.each(data.values, function (i, v) {
            values_list += '<p>' + v + '</p>'
        })
        return (
            `<div class="block bullet-list-block">
          <div class="row">
          <div class="col text-center ">
             <h5 class="mb-0 uc">${data.section_label}</h5>
          </div>
        </div>
        <div class="row text-center">
          <div class="col">
             ${values_list}
          </div>
        </div>
        <div class="row text-center">
          <div class="col">
             <p class="font-weight-normal">${data.section_summary}</p>
          </div>
        </div>
        <div class="row text-center justify-content-center">
          <div class="col-md-8">
             <p class="mt-3 mb-3 font-weight-normal one-em">${data.prayer}</p>
          </div>
      </div>
    </div>`)
    }
}
function _template_people_groups_list(data) {
    let values_list = ''
    let image = ''
    jQuery.each(data.values, function (i, v) {
        if (v.image_url) {
            image = '<div style="background-image:url(' + v.image_url + '); width:200px; height:200px;background-size: cover;background-repeat: no-repeat;" class="img-fluid rounded-3"></div>'
        } else {
            image = '<div style=" height:200px;"><img class="img-fluid" src="' + jsObject.nope + '" alt="" /></div>'
        }
        values_list += '<div class="col-6 col-md-4 col-lg-2 mb-1"><p class="mb-2 text-center">' + image + '</p><p class="text-center"><img src="' + v.progress_image_url + '" class="img-fluid" alt="" /></p><p class="text-center">' + v.description + '</p></div>'
    })
    return (
        `<div class="block people-groups-list-block">
          <div class="row">
          <div class="col text-center ">
             <h5 class="mb-0 uc">${data.section_label}</h5>
          </div>
        </div>
        <div class="row text-center justify-content-center">
          ${values_list}
        </div>
        <div class="row text-center">
          <div class="col">
             <p class="font-weight-normal">${data.section_summary}</p>
          </div>
        </div>
        <div class="row text-center justify-content-center">
          <div class="col-md-8">
             <p class="mt-3 mb-3 font-weight-normal one-em">${data.prayer}</p>
          </div>
      </div>
    </div>`)
}
function _template_least_reached_block(data) {
    let image
    if (data.image_url) {
        image = `<div><img src="${data.image_url}" class="img-fluid rounded-3" alt="" /></div>`
    } else {
        image = `<div><img class="img-fluid" src="${jsObject.nope}" alt="" /></div>`
    }
    return `
        <div class="block least-reached-block">
            <div class="flow sm">
                <h5>${data.section_label}</h5>
                <p class="f-xlg">${data.focus_label}</p>
                ${data.diaspora_label !== '' ? `<p class="f-sm">(${data.diaspora_label})</p>` : ''}
            </div>
            ${image}
            <div class="content f-xlg">
                ${data.prayer}
            </div>
    </div>`
}
function _template_fact_block(data) {
    let icon = ''
    if (typeof data.icon !== 'undefined') {
        let iclass = 'ion-android-warning'
        if (data.icon) {
            iclass = data.icon
        }
        let icolor = 'brand'
        if (data.color) {
            icolor = data.color
        }
        icon = '<p class="mt-3 mb-3 font-weight-bold six-em"><i class="' + iclass + ' ' + icolor + '"></i></p>'
    }
    return (
        `<div class="block fact-block">
          <div class="row">
            <div class="col text-center ">
               <h5 class="mb-0 uc">${data.section_label}</h5>
               <p class="mt-3 mb-3 two-em">${data.focus_label}</p>
              ${icon}
            </div>
          </div>
          <div class="row text-center justify-content-center">
            <div class="col-md-8">
                <p class="mt-3 mb-3 font-weight-normal one-em">${data.section_summary}</p>
            </div>
          </div>
          <div class="row text-center justify-content-center">
            <div class="col-md-8">
               <p class="mt-3 mb-3 font-weight-normal one-em">${data.prayer}</p>
            </div>
        </div>
    </div>
    `)
}
function _template_content_block(data) {
    let icon = ''
    if (typeof data.icon !== 'undefined') {
        let iclass = 'ion-android-warning'
        if (data.icon) {
            iclass = data.icon
        }
        let icolor = 'brand'
        if (data.color) {
            icolor = data.color
        }
        icon = '<p class="mt-3 mb-3 font-weight-bold six-em"><i class="' + iclass + ' ' + icolor + '"></i></p>'
    }
    return (
        `<div class="block content-block">
          <div class="row">
          <div class="col text-center ">
            <h5 class="mb-0 uc">${data.section_label}</h5>
             <p class="mt-3 mb-3 two-em">${data.focus_label}</p>
            ${icon}
          </div>
      </div>
      <div class="row text-center justify-content-center">
        <div class="col-md-8">
           <p class="mt-3 mb-3 font-weight-normal one-em">${data.section_summary}</p>
        </div>
      </div>
      <div class="row text-center justify-content-center">
        <div class="col-md-8">
           <p class="mt-3 mb-3 lh-sm two-em">${data.prayer}</p>
        </div>
      </div>
    </div>`)
}
function _template_prayer_block(data) {
    return (
        `<div class="block prayer-block">
          <div class="row">
          <div class="col text-center ">
            <h5 class="mt-3 mb-3 font-weight-normal one-em uc">${data.section_label}</h5>
            <p class="mt-3 mb-3"><i class="ion-android-people ${data.icon_color} six-em" /> <i class="ion-android-people ${data.icon_color} six-em" /> <i class="ion-android-people ${data.icon_color} six-em" /></p>
          </div>
      </div>
      <div class="row text-center justify-content-center">
        <div class="col-md-8">
           <p class="mt-3 mb-3 lh-sm two-em">${data.prayer}</p>
        </div>
      </div>
    </div>`)
}
function _template_verse_block(data) {
    let icons = ['ion-android-sync']
    let icon_name = icons[Math.floor(Math.random() * icons.length)]
    return (
        `<div class="block verse-block">
          <div class="row">
          <div class="col text-center ">
            <h5 class="mt-3 mb-3 font-weight-normal one-em uc">${data.section_label}</h5>
            <p class="mt-3 mb-3"><img src="${jsObject.image_folder}bible-${data.icon_color}.svg" alt="icon" /></p>
          </div>
      </div>
      <div class="row text-center justify-content-center">
        <div class="col-md-8">
           <p class="mt-3 mb-0 lh-sm two-em font-italic">${data.verse}</p>
           <p class="mt-0 mb-3 font-italic">${data.reference}</p>
        </div>
      </div>
      <div class="row text-center justify-content-center">
        <div class="col-md-8">
           <p class="mt-3 mb-3 font-weight-normal one-em">${data.prayer}</p>
        </div>
    </div>
    </div>`)
}
function _template_lost_per_believer_block(data) {
    let bodies_1 = ''
    i = 0
    while (i < data.lost_per_believer) {
        bodies_1 += BodyIcon('bad');
        i++;
    }
    let font_size = 'f-xlg'
    if (data.lost_per_believer > 1000) {
        font_size = 'f-lg'
    } else if (data.lost_per_believer < 20) {
        font_size = 'f-xxlg'
    }
    return `
        <div class="block lost-per-believer-block">
            <h5>${data.section_label}</h5>
            <div class="content flow">
                <p class="bold f-xlg">${data.label_1}</p>
                <p class="f-xxlg">
                    ${BodyIcon('good')}
                </p>
                <p class="${font_size}">
                  ${bodies_1}
                </p>
            </div>
            <div class="content">
                ${data.prayer}
            </div>
        </div>
    `
}
function _template_photo_block(data) {
  return `
    <div class="block photo-block">
      <h5>${data.section_label}</h5>
      <div>
        <img src="${data.url}" class="img-fluid rounded-3" alt="prayer photo" style="max-height:700px" />
      </div>
      <div class="content flow">
        <p class="f-md">${data.section_summary}</p>
        ${data.prayer ? `<p class="mt-3 mb-3 font-weight-normal one-em">${data.prayer}</p>` : ''}
      </div>
    </div>
      `
}
function _template_basic_block(data) {
    const reference = data.reference ? `
            <button type="button" class="btn simple id-${data.id}" onclick="document.querySelector('#id-${data.id}').style.display = 'block';document.querySelector('.id-${data.id}').style.display = 'none';" >
                <span>${data.reference} </span> <i class="icon pg-chevron-down"></i>
            </button>
            <div class="flow sm" style="display:none;" id="id-${data.id}" >
                <p class="block__verse">${data.verse}</p>
                <p class="f-normal">${data.reference}</p>
            </div>
        ` : ''
    const icon = data.icon ? `
            <p>
                <i class="${data.icon} six-em"></i>
            </p>
        ` : ''
    return `
        <div class="block basic-block">
            <h5>${data.section_label}</h5>
            ${icon}
            <div class="content f-xlg">
                <p>${data.prayer}</p>
                ${reference}
            </div>
        </div>
        `
}


function BodyIcon(color) {
    const iconColors = {
        bad: 'dark',
        neutral: 'light',
        good: 'orange',
    }
    const defaultColor = iconColors.orange

    const iconColor = color && iconColors.hasOwnProperty(color) ? iconColors[color] : defaultColor

    return `<i class="ion-ios-body ${iconColor}"></i>`
}
