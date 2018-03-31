var Encore = require('@symfony/webpack-encore');


Encore

    //.enableSassLoader(function(sassOptions) {}, {
    //    resolveUrlLoader: false
    //})
    // the project directory where all compiled assets will be stored
    .setOutputPath('web/assets/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/assets')

    // will create web/build/app.js and web/build/app.css
    .addEntry('app', './assets/js/app.js')
    .addEntry('twitchpannel', './assets/js/twitchpannel.js')

    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()
    .autoProvideVariables({ Popper: ['popper.js', 'default'] })

    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

    // create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning()
    
module.exports = Encore.getWebpackConfig();