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
    'summernote' : bower_path + 'summernote/dist/'
};

// Minify JS
elixir.extend('minify_js', function()
{
    gulp.task('minify_js', function()
    {
        gulp.src([
                paths.jquery_ui + 'jquery-ui.min.js',
                paths.bootstrap + 'javascripts/bootstrap.js',
                paths.snap + 'snap.svg.js',
                paths.tinycolor + 'tinycolor.js',
                paths.summernote + 'summernote.js',
                paths.js+ '**',
            ],
            {
                base: './'
            })
            .pipe(concat('all.js'))
            .pipe(sourcemaps.init())
            .pipe(uglify())
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(paths.js_public));
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
                    paths.fontawesome+'scss',
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
        return this.queueTask('minify_css');
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
        .copy(paths.summernote + 'summernote.css', paths.sass_partials+'_summernote.scss')
        .minify_js(command)
        .minify_css(command)
        .minify_img(command);
});