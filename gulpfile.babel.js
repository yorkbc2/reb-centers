'use strict';

import gulp from 'gulp';
import sass from 'gulp-sass';
import rename from 'gulp-rename';
import plumber from 'gulp-plumber';
import cleancss from 'gulp-clean-css';
import sourcemaps from 'gulp-sourcemaps';
import uglify from 'gulp-uglify';

gulp.task('sass', () => {
  return gulp.src('sass/**/*.scss')
    .pipe(plumber())
    //.pipe(sourcemaps.init())
    .pipe(sass({
      outputStyle: 'expanded', // nested, expanded, compact, compressed
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

gulp.task('minify', gulp.parallel('css', 'js'));

gulp.task('default', () => {
  gulp.watch('sass/**/*.scss', gulp.series('sass'));
  //gulp.watch('style.css', gulp.series('css'));
  //gulp.watch('js/brainworks.js', gulp.series('js'));
});
