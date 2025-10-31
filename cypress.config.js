const path = require('path')
const { defineConfig } = require('cypress')

const projectRoot = __dirname // racine du dépôt

module.exports = defineConfig({
    projectId: 'um1shd',
    chromeWebSecurity: false,
    retries: 2,
    defaultCommandTimeout: 5000,
    watchForFileChanges: false,
    downloadsFolder: path.join(projectRoot, 'tests/cypress/downloads'),
    videosFolder: path.join(projectRoot, 'tests/cypress/videos'),
    screenshotsFolder: path.join(projectRoot, 'tests/cypress/screenshots'),
    fixturesFolder: path.join(projectRoot, 'tests/cypress/fixtures'),
    e2e: {
        setupNodeEvents(on, config) {
        return require(path.join(projectRoot, 'tests/cypress/plugins/index.js'))(on, config)
        },
        baseUrl: 'http://localhost:8000',
        specPattern: path.join(projectRoot, 'tests/cypress/integration/**/*.cy.{js,jsx,ts,tsx}'),
        supportFile: path.join(projectRoot, 'tests/cypress/support/e2e.js'),
    },
})