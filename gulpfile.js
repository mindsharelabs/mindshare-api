const gulp = require('gulp');
const sass = require('gulp-sass');
const del = require('del');

gulp.task('styles', () => {
    return gulp.src('scss/front.scss')
        .pipe(sass({
          outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(gulp.dest('inc/css/'))
});

gulp.task('block-styles', () => {
    return gulp.src('scss/block-styles.scss')
        .pipe(sass({
          outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(gulp.dest('inc/css/'))
});


gulp.task('clean', () => {
    return del([
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
