window.seconds = 60
window.items = 7

CELEBRATION_TIMEOUT = 3000

const contentElement = document.querySelector('#content')
const mapElement = document.querySelector('#location-map')
const mapSkeleton = mapElement.querySelector('.skeleton')

const prayingText = document.querySelector('.praying__text')
const locationName = document.querySelector('#location-name')
const prayingButton = document.querySelector('#praying-button')
const prayingPauseButton = document.querySelector('#praying__pause_button')
const prayingContinueButton = document.querySelector('#praying__continue_button')
const prayingProgress = document.querySelector('.praying__progress')
const tutorial = document.querySelector('#tutorial-location')

const prayerNavbar = document.querySelector('.prayer-navbar')
const prayingPanel = document.querySelector('#praying-panel')
const decisionPanel = document.querySelector('#decision-panel')
const questionPanel = document.querySelector('#question-panel')
const decisionLeaveModal = document.querySelector('#decision_leave_modal')

const leaveHomeButton = decisionPanel.querySelector('#decision__home')
const leaveModalButton = decisionLeaveModal.querySelector('#decision__leave')
const stayModalButton = decisionLeaveModal.querySelector('#decision__keep_praying')
const closeModalButton = decisionLeaveModal.querySelector('#decision__close')
const doneButton = questionPanel.querySelector('#question__yes_done')
const nextButton = questionPanel.querySelector('#question__yes_next')

const populationInfoNo = document.querySelector('.population-info .no')
const populationInfoNeutral = document.querySelector('.population-info .neutral')
const populationInfoYes = document.querySelector('.population-info .yes')

const morePrayerFuelButton = document.querySelector('#more_prayer_fuel')
const celebratePanel = document.querySelector('#celebrate-panel')

checkForLocationAndLoad(init)

function init(location) {
    window.paused = false
    window.finishedPraying = false
    window.alreadyLogged = false
    window.time = 0
    window.randomLogSeconds = 30 + 30 * Math.random()

    console.log(window.randomLogSeconds)

    renderContent(location)
    renderMap(location)

    toggleTimer(false)

    setupListeners()
}

function setupListeners() {
    prayingButton.addEventListener('click', () => toggleTimer())
    prayingPauseButton.addEventListener('click', () => toggleTimer(true))
    prayingContinueButton.addEventListener('click', () => toggleTimer(false))
    morePrayerFuelButton.addEventListener('click', showMorePrayerFuel)

    leaveHomeButton.addEventListener('click', openLeaveModal)

    stayModalButton.addEventListener('click', keepPraying)
    closeModalButton.addEventListener('click', keepPraying)
    leaveModalButton.addEventListener('click', leavePraying)

    doneButton.addEventListener('click', celebrateAndDone)
    nextButton.addEventListener('click', celebrateAndNext)
}

function celebrateAndNext() {
    const url = new URL(jsObject.api_url)
    const siteOrigin = (new URL(location.href)).host
    url.searchParams.append('relay', jsObject.parts.public_key)
    url.searchParams.append('domain', siteOrigin)

    celebrateAndNavigateTo(url.href)
}
function celebrateAndDone() {
    celebrateAndNavigateTo(getHomeUrl())
}

function celebrateAndNavigateTo(href) {
    /* Fire off the celebrations and open the celebrate panel */
    window.celebrationFireworks()
    show(celebratePanel)

    setTimeout(() => {
        location.href = href
    }, CELEBRATION_TIMEOUT)
}

function openLeaveModal() {
    decisionLeaveModal.classList.add('show')
}

function keepPraying() {
    decisionLeaveModal.classList.remove('show')
    toggleTimer()
}
function leavePraying() {
    window.location = getHomeUrl()
}

function getHomeUrl() {
    return '/congratulations'
}
function getMapUrl() {
    if (jsObject.is_cta_feature_on === true) {
        return jsObject.map_url + '?show_cta'
    } else {
        return jsObject.map_url
    }
}

function showMorePrayerFuel() {
    const hiddenBlocks = contentElement.querySelectorAll('.block.hidden')
    hiddenBlocks.forEach((block) => {
        block.classList.remove('hidden')
        hide(morePrayerFuelButton)
    })
}

function toggleTimer(pause) {
    let pauseTimer = false

    if (typeof pause === 'undefined') {
        pauseTimer = !window.paused
    } else {
        pauseTimer = pause
    }
    window.paused = pauseTimer

    if (pauseTimer) {
        prayingText.innerHTML = escapeHTML(jsObject.translations.praying_paused)

        /* Show and hide the neccessary UI */
        hide(prayingPauseButton)
        show(prayingContinueButton)

        show(decisionPanel)

        /* clear the interval */
        clearInterval(window.pgInterval)
    } else {
        prayingText.innerHTML = escapeHTML(jsObject.translations.keep_praying)

        /* Show and hide the necessary UI */
        show(prayingPauseButton)
        hide(prayingContinueButton)

        hide(decisionPanel)

        /* Restart the interval */
        startTimer(window.time)
    }
}

function startTimer(time) {
    if (!time) {
        window.time = 0
    }

    window.pgInterval = setInterval(() => {
        window.time = window.time + 0.1

        if (window.time > window.randomLogSeconds && !window.alreadyLogged) {
            /* send log */
            const url = `${jsObject.api_url}update?location=${jsObject.current_content.location.location.grid_id}&relay=${jsObject.parts.public_key}`
            fetch(url, {
                method: 'POST',
            })
                .then((res) => {
                    if (!res.ok) {
                        throw Error(res.status + ': ' + res.statusText)
                    }
                })
                .catch((error) => {
                    console.log(error)
                })

            window.alreadyLogged = true
        }

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
    if (!element.dataset.display) {
        element.dataset.display = element.style.display !== 'none' ? element.style.display : 'block'
    }
    element.style.display = 'none'
}
function show(element) {
    element.style.display = element.dataset.display || 'block'
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
console.log(window.scrollY)
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

    locationName.innerHTML = escapeHTML(jsObject.translations.state_of_location.replace('%1$s', location.admin_level_name_cap).replace('%2$s', location.full_name))

    /* Render the content */
    const arrayList = Array.isArray(list) ? list : Object.values(list)
    const blockTemplates = arrayList.map((block) => getBlockTemplate(block))

    contentElement.innerHTML = `
    <div id="content-anchor"></div>
    <hr />

    ${blockTemplates.join('<hr>')}

    <hr />
    `

    const blocks = contentElement.querySelectorAll('.block')
    blocks.forEach((block, i) => {
        if (i > window.items) {
            block.classList.add('hidden')
        }
    })

    clearTutorial()
    populationInfoNo.innerHTML = location.non_christians
    populationInfoNeutral.innerHTML = location.christian_adherents
    populationInfoYes.innerHTML = location.believers
}
function renderMap(content) {
    const { location } = content

    const imageSrc = jsObject.cache_url + 'maps/' + location.grid_id + '.jpg'
    const bgImg = new Image()
    bgImg.onload = function(){
        mapSkeleton.style.display = 'none'
        mapElement.style.backgroundImage = 'url(' + bgImg.src + ')'

        setTimeout(() => {
            mapElement.classList.add('zoom')
        }, 500)
    }
    bgImg.src = imageSrc
}

function getBlockTemplate(block) {
    switch (block.type) {
        case '4_fact_blocks':
            return _template_4_fact_blocks(block.data)
        case 'percent_3_circles':
            return _template_percent_3_circles(block.data)
        case '100_bodies_chart':
            return _template_100_bodies_chart(block.data)
        case '100_bodies_3_chart':
            return _template_100_bodies_3_chart(block.data)
        case 'population_change_icon_block':
            return _template_population_change_icon_block(block.data)
        case 'people_groups_list':
            return _template_people_groups_list(block.data)
        case 'least_reached_block':
            return _template_least_reached_block(block.data)
        case 'content_block':
            return _template_content_block(block.data)
        case 'photo_block':
            return _template_photo_block(block.data)
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
    let icon_color = 'dark'
    if ('christian_adherents' === data.group) {
        icon_color = 'light'
    }
    if ('believers' === data.group) {
        icon_color = 'orange'
    }

    // icon size
    let font_size = 'f-xlg'
    if (2 === data.size) {
        font_size = 'f-lg'
    }

    if (data.count > 1000) {
        font_size = 'f-lg'
    } else if (data.count < 20) {
        font_size = 'f-xxlg'
    }

    // build icon list
    let icon_list = ''
    i = 0
    while (i < data.count) {
        icon_list += `
            <svg height="1em" width="1em" viewBox="0 0 512 512" class="${icon_color} ${font_size}">
                <use href="#${icon}"></use>
            </svg>
        `
        i++;
    }
    return `
        <div class="block population-change-block">
            <h5>${data.section_label}</h5>
            <div class="content flow f-xlg">
                <p>${data.section_summary}</p>
                <div class="${font_size} icon-block">
                    ${icon_list} <span style="font-size:.5em;vertical-align:middle;">(${data.count})</span>
                </div>
                <p>${data.prayer}</p>
            </div>
        </div>
    `
}
function _template_4_fact_blocks(data) {
    return `
        <div class="block four-facts-block">
            <h5>${data.section_label}</h5>
            <p class="f-xlg">${data.focus_label}</p>
            <div class="switcher">
                <div class="flow sm">
                    <p class="bold">${data.label_1}</p>
                    <p class="f-xlg">${data.value_1}</p>
                </div>
                <div class="flow sm">
                    <p class="bold">${data.label_2}</p>
                    <p class="f-xlg">${data.value_2}</p>
                </div>
                <div class="flow sm">
                    <p class="bold">${data.label_3}</p>
                    <p class="f-xlg">${data.value_3}</p>
                </div>
                <div class="flow sm">
                    <p class="bold">${data.label_4}</p>
                    <p class="f-xlg">${data.value_4}</p>
                </div>
            </div>
        </div>
    `
}
function _template_people_groups_list(data) {
    let values_list = ''
    let image = ''
    Object.values(data.values).forEach(function (v) {
        if (v.image_url) {
            image = `<div style="background-image:url(${v.image_url}); " class="bg-img img-fluid"></div>`
        } else {
            image = `
                <div style=" height:200px;">
                    <img class="img-fluid" src="${jsObject.nope}" alt="" />
                </div>`
        }
        values_list += `
            <div class="flow grow0">
                <p class="mb-2 text-center">${image}</p>
                <div>
                    <img src="${v.progress_image_url}" class="img-fluid" alt="" />
                </div>
                <p>${v.description}</p>
            </div>
        `
    })
    return `
        <div class="block people-groups-list-block">
            <h5>${data.section_label}</h5>
            <div class="content switcher">
                ${values_list}
            </div>
        </div>
    `
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
function _template_content_block(data) {
    let icon = ''
    if (typeof data.icon !== 'undefined') {
        let iclass = 'ion-android-warning'
        if (data.icon) {
            iclass = data.icon
        }
        let icolor = 'dark'
        if (data.color === 'brand-lighter') {
            icolor = 'light'
        } else {
            icolor = data.color
        }
        icon = `
            <svg class="icon-xlg ${icolor}" width="1em" height="1em" viewBox="0 0 512 512">
                <use href="#${iclass}" ></use>
            </svg>
        `
    }
    return `
        <div class="block flow content-block">
            <h5>${data.section_label}</h5>
            <p class="f-xlg">${data.focus_label}</p>
            ${icon}
            <div class="w-75 center">
                <p class="f-lg">${data.section_summary}</p>
                <p class="f-xlg">${data.prayer}</p>
            </div>
    </div>`
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
            <button type="button" class="btn simple id-${data.id} with-icon" onclick="document.querySelector('#id-${data.id}').style.display = 'block';document.querySelector('.id-${data.id}').style.display = 'none';" >
                <span>${data.reference} </span> <svg width="1em" height="1em" viewBox="0 0 33 33"><use href="#pg-chevron-down"></use></svg>
            </button>
            <div class="flow sm" id="id-${data.id}" style="display: none" >
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
            <div class="content f-xlg flow">
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

    return `
        <svg class="${iconColor}" width="1em" height="1em" viewBox="0 0 512 512">
            <use href="#ion-ios-body"></use>
        </svg>
    `
}
