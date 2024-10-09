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

const contentElement = document.querySelector('#content')

checkForLocationAndLoad(renderContent)

function renderContent(content) {
    if (!content) {
        return
    }

    const { location, list, parts } = content

    /* Render the content */

}