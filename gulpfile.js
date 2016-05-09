require('dotenv').config({
    path: __dirname + '/.env'
});

var env = process.env;

var gulp = require('gulp'),
    imagemin = require('gulp-imagemin'),
    elixir = require('laravel-elixir'),
    bower_path = './bower_components/',
    resources_path = './resources/';

paths = {
    'css_public': './public/css/',
    'js_public': './public/js/',
    'img_public': './public/build/img/',
    'fonts_public': './public/build/fonts/',
    'sass': resources_path + 'assets/sass/',
    'sass_partials': resources_path + 'assets/sass/partials/',
    'js': resources_path + 'assets/js/',

    'jquery': bower_path + 'jquery/dist/',
    'jquery_ui': bower_path + 'jquery-ui/',
    'bootstrap': bower_path + 'bootstrap-sass/assets/',
    'fontawesome': bower_path + 'fontawesome/',
    'snap': bower_path + 'snap.svg/dist/',
    'tinycolor': bower_path + 'tinycolor/',
    'summernote': bower_path + 'summernote/dist/',
    'datepicker': bower_path + 'eonasdan-bootstrap-datetimepicker/build/',
    'moment': bower_path + 'moment/min/',
    'select2': bower_path + 'select2/dist/',
    'visible': bower_path + 'jquery-visible/',
    'bootbox': bower_path + 'bootbox/',
    'chartjs': bower_path + 'Chart.js/',
    'timeago': bower_path + 'jquery-timeago/',
    'owl': bower_path + 'owl.carousel/dist/',
    'sisyphus': bower_path + 'sisyphus/',
    'lazyload': bower_path + 'jquery.lazyload/',
    'fastclick': bower_path + 'fastclick/lib/',
    'dropzone' : bower_path + 'dropzone/dist/'
};

elixir(function (mix) {
    mix
        .copy(paths.jquery_ui + 'themes/base/jquery-ui.min.css', paths.sass_partials + '_jquery-ui-min.scss')
        .copy(paths.jquery_ui + 'themes/base/images', paths.img_public + 'jquery-ui')
        .copy(paths.fontawesome + 'fonts', paths.fonts_public)
        .copy(paths.bootstrap + 'fonts', paths.fonts_public)
        .copy(paths.summernote + 'summernote.css', paths.sass_partials + '_summernote.scss')
        .copy(paths.select2 + 'css/select2.css', paths.sass_partials + '_select2.scss')
        .copy(paths.owl + 'assets/owl.carousel.css', paths.sass_partials + '_owl.scss')
        .copy(paths.owl + 'assets/owl.theme.default.min.css', paths.sass_partials + '_owl_theme.scss')
        .copy(paths.owl + 'assets/ajax-loader.gif', paths.img_public)
        .copy(paths.owl + 'assets/owl.video.play.png', paths.img_public)
        .copy(paths.datepicker + 'css/bootstrap-datetimepicker.css', paths.sass_partials + '_bootstrap-datetimepicker.scss')
        .copy(paths.dropzone + 'dropzone.css' , paths.sass_partials + '_dropzone.scss')
        .sass('app.scss')
        .scripts([
            paths.jquery + 'jquery.js',
            paths.bootstrap + 'javascripts/bootstrap.js',
            paths.snap + 'snap.svg.js',
            paths.tinycolor + 'tinycolor.js',
            paths.visible + 'jquery.visible.js',
            paths.timeago + 'jquery.timeago.js',
            paths.select2 + 'js/select2.js',
            paths.owl + 'owl.carousel.js',
            paths.lazyload + 'jquery.lazyload.js',
            paths.fastclick + 'fastclick.js',
            paths.js + 'git_lines.js',
            paths.js + 'projects.js',
            paths.js + 'search.js',
            paths.js + 'select2.js'
        ], paths.js_public + 'all.js')
        .scripts([
            paths.jquery + 'jquery.js',
            paths.bootstrap + 'javascripts/bootstrap.js',
            paths.snap + 'snap.svg.js',
            paths.tinycolor + 'tinycolor.js',
            paths.summernote + 'summernote.js',
            paths.moment + 'moment.min.js',
            paths.datepicker + 'js/bootstrap-datetimepicker.min.js',
            paths.select2 + 'js/select2.js',
            paths.visible + 'jquery.visible.js',
            paths.bootbox + 'bootbox.js',
            paths.chartjs + 'Chart.js',
            paths.owl + 'owl.carousel.js',
            paths.sisyphus + 'sisyphus.js',
            paths.fastclick + 'fastclick.js',
            paths.dropzone + 'dropzone.js',
            paths.js + 'panel_links.js',
            paths.js + 'select2.js',
            paths.js + 'plugins.js',
            paths.js + 'confirm.js',
            paths.lazyload + 'jquery.lazyload.js'
        ], paths.js_public + 'admin.js')
        .version(['public/css/app.css', 'public/js/all.js', 'public/js/admin.js'])
        .browserSync({
            proxy: env.SITE_URL
        });
});
