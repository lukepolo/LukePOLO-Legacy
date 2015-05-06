require('dotenv').config();

var gulp = require('gulp'),
sass = require('gulp-sass');
autoprefixer = require('gulp-autoprefixer'),
gutil = require('gulp-util'),
concat = require('gulp-concat'),
uglify = require('gulp-uglify'),
sourcemaps = require('gulp-sourcemaps'),
imagemin = require('gulp-imagemin'),
chalk = require('chalk'),
pngquant = require('imagemin-pngquant'),
elixir = require('laravel-elixir'),

bower_path = './bower_components/',
resources_path = './resources/';

paths = {
    // App Paths
    'css_public': './public/css/',
    'js_public' : './public/js/',
    'fonts_public' : './public/fonts/',
    'sass': resources_path+'/assets/sass/',
    'sass_partials': resources_path+'assets/sass/partials/',
    'js' : resources_path+'/assets/js/',
    'img': resources_path+'assets/img/',
    // Vendor Paths
    'jquery' : bower_path + 'jquery/dist/',
    'jquery_ui' : bower_path + 'jquery-ui/',
    'bootstrap' : bower_path + 'bootstrap-sass/assets/',
    'fontawesome' : bower_path + 'fontawesome/',
    'snap' : bower_path + 'snap.svg/dist/',
    'tinycolor' : bower_path + 'tinycolor/',
    'summernote' : bower_path + 'summernote/dist/',
    'datepicker' : bower_path + 'eonasdan-bootstrap-datetimepicker/build/',
    'moment' : bower_path + 'moment/min/',
    'select2' : bower_path + 'select2/dist/',
    'visible' : bower_path + 'jquery-visible/',
    'bootbox' : bower_path + 'bootbox/',
    'chartjs' : bower_path + 'Chart.js/',
    'timeago' : bower_path + 'jquery-timeago/',
    'owl' : bower_path + 'owl.carousel/dist/'
 };

// Minify JS
elixir.extend('minify_js', function()
{
    gulp.task('minify_js', function()
    {
        js_minify(
            gulp.src([
                paths.bootstrap + 'javascripts/bootstrap.js',
                paths.snap + 'snap.svg.js',
                paths.tinycolor + 'tinycolor.js',
                paths.visible + 'jquery.visible.js',
                paths.timeago + 'jquery.timeago.js',
                paths.select2 + 'js/select2.js',
                paths.owl + 'owl.carousel.js',
                paths.js+ '**',
            ],
            {
                base: './'
            })
            .pipe(concat('all.js'))
        );

        js_minify(
            gulp.src([
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
                    paths.js+ '**',
                ],
                {
                    base: './'
                })
                .pipe(concat('admin.js'))
        );
    });

    if(command == 'watch')
    {
        gutil.log('Starting', '\'' + chalk.cyan('watch-js') + '\'...');
        return this.registerWatcher('minify_js', resources_path+'**/*.js');
    }
    else
    {
        return this.queueTask('minify_js');
    }
});

// Minify CSS
elixir.extend('minify_css', function()
{
    gulp.task('minify_css', function()
    {
        gulp.src([paths.sass+'*'])
            .pipe(
                sass({
                    outputStyle: 'compressed',
                    includePaths: [
                        paths.bootstrap+'stylesheets',
                        paths.fontawesome+'scss'
                    ],
                    errLogToConsole: true
                })
            )
            .pipe(sourcemaps.init())
            .pipe(
                autoprefixer({
                    browsers: [
                        'last 2 version'
                    ]
                })
            )
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('public/css'))
    });

    if(command == 'watch')
    {
        gutil.log('Starting', '\'' + chalk.cyan('watch-sass') + '\'...');
        return this.registerWatcher('minify_css', resources_path+'**/*.scss');
    }
    else
    {
        return this.queueTask('minify_css')
    }
});

// Minify Images
elixir.extend('minify_img', function(command)
{
    gulp.task('minify_img', function()
    {
        gulp.src(paths.img+'**')
            .pipe(imagemin({
                progressive: true,
                svgoPlugins: [{removeViewBox: false}],
                use: [pngquant()]
            }))
            .pipe(gulp.dest('public/img'));
    });

    if(command == 'watch')
    {
        gutil.log('Starting', '\'' + chalk.cyan('watch-images') + '\'...');
        return this.registerWatcher('minify_img', paths.img+'*');
    }
    else
    {
        return this.queueTask('minify_img');
    }
});

elixir(function (mix)
{
    command = process.argv.slice(2)[0];
    gutil.log('Command:', '\'' + chalk.cyan(command) + '\'...');

    // Copy Assets from Vendors
    mix.copy(paths.jquery + 'jquery.min.js', paths.js_public+'jquery.min.js')
        .copy(paths.jquery + 'jquery.min.map', paths.js_public+'jquery.min.map')
        .copy(paths.jquery_ui + 'themes/base/jquery-ui.min.css', paths.sass_partials+'_jquery-ui-min.scss')
        .copy(paths.jquery_ui + 'themes/base/images', paths.img+'jquery-ui')
        .copy(paths.fontawesome + 'fonts', paths.fonts_public)
        .copy(paths.bootstrap + 'fonts', paths.fonts_public)
        .copy(paths.summernote + 'summernote.css', paths.sass_partials+'_summernote.scss')
        .copy(paths.select2 + 'css/select2.css', paths.sass_partials+'_select2.scss')
        .copy(paths.owl + 'assets/owl.carousel.css', paths.sass_partials+'_owl.scss')
        .copy(paths.owl + 'assets/owl.theme.default.css', paths.sass_partials+'_owl_theme.scss')
        .copy(paths.owl + 'assets/ajax-loader.gif', paths.img)
        .copy(paths.owl + 'assets/owl.video.play.png', paths.img)
        .copy(paths.datepicker + 'css/bootstrap-datetimepicker.css', paths.sass_partials+'_bootstrap-datetimepicker.scss')
        .minify_js(command)
        .minify_css(command)
        .minify_img(command);
});

function js_minify(src)
{
    if(process.env.MINIFY == 'true')
    {
        src.pipe(sourcemaps.init())
            .pipe(uglify())
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(paths.js_public));
    }
    else
    {
        src.pipe(gulp.dest(paths.js_public));
    }
}