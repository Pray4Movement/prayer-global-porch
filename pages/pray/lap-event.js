/* We need to check and keep checking that the location object is ready to use */
function checkForLocationAndLoad(callback) {
    let interval

    if (jsObject.current_content && jsObject.current_content.location) {
        callback(jsObject.current_content.location)
    }

    interval = setInterval(() => {
        if (jsObject.current_content && jsObject.current_content.location) {
            callback(jsObject.current_content.location)
            clearInterval(interval)
        }
    }, 50)
}

const contentElement = jQuery('#content')

const praying_panel = jQuery('#praying-panel')
const decision_panel = jQuery('#decision-panel')
const question_panel = jQuery('#question-panel')
const celebrate_panel = jQuery('#celebrate-panel')
const location_name = jQuery('#location-name')
const footer = jQuery('.pg-footer')

const praying_button = jQuery('#praying_button')
const praying_progress = jQuery('.praying__progress')
const praying_text = jQuery('.praying__text')
const praying_close_button = jQuery('#praying__close_button')
const praying_continue_button = jQuery('#praying__continue_button')

const decision_home = jQuery('#decision__home')
const decision_map = jQuery('#decision__map')
const decision_next = jQuery('#decision__next')

const decision_leave = jQuery('#decision__leave')
const decision_keep_praying = jQuery('#decision__keep_praying')

// const question_no = jQuery('#question__no')
const question_yes_done = jQuery('#question__yes_done')
const question_yes_next = jQuery('#question__yes_next')

setupUI()
checkForLocationAndLoad(renderContent)

function setupUI() {

}



function renderContent(content) {
    if (!content) {
        return
    }

    const { location, list, parts } = content

    /* Render the content */
}