const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader() // Activation de Sass
    .addEntry('app', './assets/app.js')
    .enableSingleRuntimeChunk(); // 👉 Ajouté ici pour corriger l'erreur

module.exports = Encore.getWebpackConfig();