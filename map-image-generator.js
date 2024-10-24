const fs = require("fs")
const puppeteer = require("puppeteer")

const locationIds = require('./support/build/location_ids.json')
const baseUrl = 'http://localhost:8000/prayer_app/global/49ba4c/location-map'

const startFromIndex = 0
const endAtIndex = locationIds.length

init()

async function init() {

    // Launch the browser and open a new blank page
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.setViewport({ width: 1700, height: 950 })

    let i = 0
    const startTime = Date.now()
    for (const locationId of locationIds) {
        i++
        if (i >= startFromIndex && i <= endAtIndex) {
            console.log(i, 'screenshotting', locationId, Math.round((Date.now() - startTime) / 10) / 100)
            await mapScreenshot(page, locationId)
        }
    }
    console.log('done')

    return
}

async function mapScreenshot(page, locationId) {

    await page.goto(baseUrl + `?grid_id=${locationId}`)
    await page.waitForNetworkIdle()

    const mapBox = await page.$('#location-map');

    if (mapBox === null) {
        console.log('#location-map not found')

        return
    }

    const { width, height, x, y } = await mapBox.boundingBox()

    let image = ''
    image = await page.screenshot({
        clip: {
            x,
            y,
            width,
            height
        },
        type: 'png',
    });

    await mapBox.dispose()

    fs.writeFileSync(`./maps/${locationId}.png`, image)

    return 'done';
}
