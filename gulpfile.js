const gulp = require('gulp');
const del = require('del');
const flatten = require('gulp-flatten');

gulp.task('compile', require('./gulp-tasks/compile'));
gulp.task('sass', require('./gulp-tasks/sass'));
gulp.task('copy-img', require('./gulp-tasks/copy-img'));

// TODO - add js building and testing to this task
gulp.task('ci', gulp.parallel('sass', 'copy-img'));

gulp.task('watch', function(){
  gulp.watch(['./apps/**/assets/sass/**/*.scss', './core/assets/sass/**/*.scss'], gulp.parallel('sass'));
});
