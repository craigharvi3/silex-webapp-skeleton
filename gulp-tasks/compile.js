const gulp = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const gutil = require('gulp-util');
const path = require('path');

module.exports = (done) => {

  // gulp.src([__dirname+'/../web/js/polyfills.js', __dirname+'/../web/js/lib.js'])
  //   .pipe(concat('lib.js'))
  //   //only uglify if gulp is ran with '--type production'
  //   .pipe(gutil.env.type === 'production' ? uglify() : gutil.noop())
  //   .pipe(gulp.dest(path.resolve('web')));

  // done();
};
