/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
let mix = require('laravel-mix');
let fs = require('fs');
const util = require('util');
mix
    .copy(
        'node_modules/angular-toastr/dist/angular-toastr.min.css',
        'public/css/angular-toastr.min.css'
    )
    .copy(
        'node_modules/angular-material/angular-material.min.css',
        'public/css/angular-material.min.css'
    )
    .copy(
        'node_modules/moment-weekdaysin/moment-weekdaysin.js', 
        'public/js/moment-weekdaysin.js'
    )

class Rules {
    webpackRules() {
    }
    babelConfig() {
        return {
            presets: ['es2015', 'stage-2'],
            plugins: ['transform-runtime'],
        }
    }
}

mix.extend('babel', new Rules());

const walkSync = (dir) => {
    files = fs.readdirSync(dir);
    let filelist = [];
    files.forEach(function(file) {
        if (fs.statSync(path.join(dir, file)).isDirectory()) {
            let temp = walkSync(path.join(dir, file))
            filelist.push(...temp)
        }
        else {
            filelist.push(path.join(dir, file));
        }
    });
    return filelist;
}
const javascriptFiles = [];
const foldersCore = [
    'resources/assets/js/components',
    'resources/assets/js/directives',
    'resources/assets/js/services',
    'resources/assets/js/controllers'
];

foldersCore.forEach((folder) => {
    walkSync(folder).map(file => file).forEach(item => {
        javascriptFiles.push(item)
    });
});

mix.js(
    [
        'resources/assets/js/app.js',
        ...javascriptFiles
    ], 'public/js/app.js'
);

mix.copyDirectory('node_modules/angular-ui-grid/fonts', 'public/css/fonts');
mix.copy('node_modules/angular-ui-grid/ui-grid.min.css', 'public/css/ui-grid.min.css');
mix.js('resources/assets/js/bootstrap.js', 'public/js/bootstrap.js');
mix.js('resources/assets/js/angular.js', 'public/js/angular.js')
    .sass('resources/assets/sass/app.scss', 'public/css');
