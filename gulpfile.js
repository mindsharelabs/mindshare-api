import gulp from "gulp";

import dartSass from 'sass'
import gulpSass from 'gulp-sass'
const sass = gulpSass(dartSass);

import sourcemaps from 'gulp-sourcemaps';
import {deleteAsync} from 'del';


gulp.task('styles', () => {
    return gulp.src('scss/front.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({
        outputStyle: 'compressed'//nested, expanded, compact, compressed
      }).on('error', sass.logError))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./css/'))
});

gulp.task('block-styles', () => {
    return gulp.src('scss/block-styles.scss')
        .pipe(sass({
          outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(gulp.dest('inc/css/'))
});


gulp.task('clean', () => {
    return  deleteAsync([
        'inc/css/front.css',
        'inc/css/block-styles.css',
    ]);
});

gulp.task('watch', () => {
    gulp.watch('scss/*.scss', (done) => {
        gulp.series(['clean', 'styles', 'block-styles'])(done);
    });
});

gulp.task('default', gulp.series(['clean', 'styles', 'block-styles', 'watch']));
