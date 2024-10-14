const puppeteer = require('puppeteer')
const locationIds = require('./support/build/location_ids.json')

init()

const baseUrl = 'localhost:8000/prayer_app/global/49ba4c/location_map'

async function init() {

    // Launch the browser and open a new blank page
    const browser = await puppeteer.launch();
    const page = await browser.newPage();

    await page.goto(baseUrl + '?grid_id=100050803')

    return
}