const gulp = require('gulp');
const flatten = require('gulp-flatten');

// Copies images from apps/* to web/assets/img
module.exports = (done) => {
	gulp
		.src('apps/*/assets/img/*')
		.pipe(flatten())
		.pipe( gulp.dest('web/assets/img') );
	gulp
		.src('core/assets/img/*')
		.pipe(flatten())
		.pipe( gulp.dest('web/assets/img') );
	done();
};
