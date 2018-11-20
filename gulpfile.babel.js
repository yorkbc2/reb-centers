'use strict';

const themeName = 'brainworks';

import gulp from 'gulp';
import zip from 'gulp-zip';
import sass from 'gulp-sass';
import babel from 'gulp-babel';
import uglify from 'gulp-uglify';
import svgmin from 'gulp-svgmin';
import rename from 'gulp-rename';
import plumber from 'gulp-plumber';
import svgstore from 'gulp-svgstore';
import cleancss from 'gulp-clean-css';
import browser_sync from 'browser-sync';
//import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'gulp-autoprefixer';

const browserSync = browser_sync.create();

const getFullDate = () => {
    const d = new Date(),
        year = d.getFullYear(),
        month = d.getMonth() < 10 ? '0' + (d.getMonth() + 1) : d.getMonth() + 1,
        date = d.getDate() < 10 ? '0' + d.getDate() : d.getDate(),
        hours = d.getHours() < 10 ? '0' + d.getHours() : d.getHours(),
        minutes = d.getMinutes() < 10 ? '0' + d.getMinutes() : d.getMinutes();
    return `${date}.${month}.${year}_${hours}.${minutes}`;
};

gulp.task('svg', () => {
    return gulp.src('assets/img/svg/*.svg')
        .pipe(plumber())
        .pipe(svgmin({
            plugins: [
                {removeViewBox: false},
                {removeUselessDefs: true},
            ],
            js2svg: {pretty: false}
        }))
        .pipe(svgstore({inlineSvg: true}))
        .pipe(rename({basename: 'sprite', extname: '.svg'}))
        .pipe(gulp.dest('assets/img'));
});

gulp.task('sass', () => {
    return gulp.src('assets/sass/**/*.scss')
        .pipe(plumber())
        // .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'nested', // nested, expanded, compact, compressed
            precision: 5,
            includePaths: ['assets/sass'],
            indentType: 'space',
            indentWidth: 2,
            linefeed: 'crlf',
            sourceComments: false,
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 4 versions'],
            cascade: false
        }))
        // .pipe(sourcemaps.write('/'))
        .pipe(gulp.dest('./'));
});

gulp.task('css', () => {
    return gulp.src('style.css')
        .pipe(plumber())
        //.pipe(sourcemaps.init())
        .pipe(cleancss({compatibility: 'ie7', debug: true}))
        .pipe(rename({suffix: '.min'}))
        //.pipe(sourcemaps.write('/'))
        .pipe(gulp.dest('./'));
});

gulp.task('babel', () => {
    return gulp.src('assets/js/es6/**/*.js')
        .pipe(plumber())
        .pipe(babel())
        .pipe(uglify({
            mangle: false,
            compress: false,
            output: {
                beautify: true,
            },
        }))
        .pipe(gulp.dest('assets/js'));
});

gulp.task('js', () => {
    return gulp.src('assets/js/brainworks.js')
        .pipe(plumber())
        .pipe(uglify({
            mangle: false,
            compress: false,
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('./assets/js'));
});

gulp.task('zip', () => {
    return gulp.src('**/{*,}.*', {base: '.'})
        .pipe(plumber())
        .pipe(zip(`${themeName}_(${getFullDate()}).zip`, {compress: true}))
        .pipe(gulp.dest('./'));
});

gulp.task('min', gulp.parallel('css', 'js'));

gulp.task('watch', () => {
    gulp.watch('assets/img/svg/*.svg', gulp.series('svg'));
    gulp.watch('assets/sass/**/*.scss', gulp.series('sass'));
    gulp.watch('assets/js/es6/**/*.js', gulp.series('babel'));
});

gulp.task('default', () => {
    browserSync.init({
        baseDir: './',
        ghostMode: false,
        //proxy: 'http://yourlocal.dev',
    });
    gulp.watch('**/*.php').on('change', browserSync.reload);
    gulp.watch('style.css').on('change', browserSync.reload);
    gulp.watch('assets/js/*.js').on('change', browserSync.reload);
    gulp.watch('assets/img/svg/*.svg', gulp.series('svg'));
    //gulp.watch('assets/sass/**/*.scss', gulp.series('sass'));
    //gulp.watch('assets/js/brainworks.js', gulp.series('js'));
});
