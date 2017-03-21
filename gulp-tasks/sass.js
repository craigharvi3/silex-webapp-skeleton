const gulp = require('gulp');
const sass = require('gulp-sass');
const gutil = require('gulp-util');
const flatten = require('gulp-flatten');

module.exports = (done) => {

	gulp.src([__dirname+'/../apps/**/assets/sass/**/*.scss', __dirname+'/../core/assets/sass/**/*.scss'])
		.pipe(flatten())
		.pipe(sass({outputStyle: (gutil.env.type === 'production' ? 'compressed' : 'expanded')}))
		.pipe(gulp.dest(__dirname + '/../web/assets/css'));
	done();
};
