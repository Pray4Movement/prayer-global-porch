const fs = require("fs")
const puppeteer = require("puppeteer")

const locationIds = require('./support/build/location_ids.json')

init()

async function init() {
    const baseUrl = 'http://localhost:8000/prayer_app/global/49ba4c/location-map'

    // Launch the browser and open a new blank page
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.setViewport({ width: 1700, height: 950 })

    await page.goto(baseUrl + '?grid_id=100050803')

    await mapScreenshot(page)

    return
}

async function mapScreenshot(page) {
    console.log('screenshotting')

    await page.waitForNetworkIdle()

    const mapBox = await page.$('#location-map');

    if (mapBox === null) {
        console.log('#location-map not found')

        return
    }
    console.log(mapBox)

    const { width, height, x, y } = await mapBox.boundingBox()

    const image = await page.screenshot({
        clip: {
            x,
            y,
            width,
            height
        },
        type: 'png',
    });

    await mapBox.dispose()

    fs.writeFileSync('./image.png', image)

    return 'done';
}
