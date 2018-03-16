'use strict';

const themeName = 'brainworks';

import gulp from 'gulp';
import zip from 'gulp-zip';
import sass from 'gulp-sass';
import uglify from 'gulp-uglify';
import svgmin from 'gulp-svgmin';
import rename from 'gulp-rename';
import plumber from 'gulp-plumber';
import svgstore from 'gulp-svgstore';
import cleancss from 'gulp-clean-css';
import browser_sync from 'browser-sync';
import sourcemaps from 'gulp-sourcemaps';

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
    return gulp.src(`${themeName}/img/svg/*.svg`)
        .pipe(plumber())
        .pipe(svgmin({js2svg: {pretty: false}}))
        .pipe(svgstore({inlineSvg: true}))
        .pipe(rename({basename: 'svg', prefix: '', suffix: '-sprite', extname: '.svg'}))
        .pipe(gulp.dest(`${themeName}/img/`));
});

gulp.task('sass', () => {
    return gulp.src('sass/**/*.scss')
        .pipe(plumber())
        //.pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'nested', // nested, expanded, compact, compressed
            precision: 5,
            sourceComments: false
        }).on('error', sass.logError))
        //.pipe(sourcemaps.write('/'))
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

gulp.task('js', () => {
    return gulp.src('js/brainworks.js')
        .pipe(plumber())
        .pipe(uglify({
            mangle: false,
            compress: false,
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('./js'));
});

gulp.task('zip', () => {
    return gulp.src(`**/{*,}.*`, {base: '.'})
        .pipe(plumber())
        .pipe(zip(`${themeName}_(${getFullDate()}).zip`, {compress: true}))
        .pipe(gulp.dest('./'));
});

gulp.task('min', gulp.parallel('css', 'js'));

gulp.task('watch', () => {
    gulp.watch('sass/**/*.scss', gulp.series('sass'));
    gulp.watch('img/svg/*.svg', gulp.series('svg'));
});

gulp.task('default', () => {
    browserSync.init({
        proxy: "sites.local/brainworks",
    });
    //gulp.watch('sass/**/*.scss', gulp.series('sass'));
    gulp.watch('img/svg/*.svg', gulp.series('svg'));
    gulp.watch('style.css').on('change', browserSync.reload);
    //gulp.watch('js/brainworks.js', gulp.series('js'));
    gulp.watch('**/*.php').on('change', browserSync.reload);
});
