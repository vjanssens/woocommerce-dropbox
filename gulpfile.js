var gulp 			= require('gulp');
var gulpUtil 		= require('gulp-util');
var uglify 			= require('gulp-uglify');
var jshint 			= require('gulp-jshint');
var sass 			= require('gulp-sass');
var browserSync 	= require('browser-sync').create();

/**
* Javascript tasks
*/
gulp.task('js', function() {
	return gulp.src('src/js/*.js')
	.pipe(uglify().on('error', gulpUtil.log))
	.pipe(gulp.dest('assets/js'))
});

gulp.task('js-watch', ['js'], function() {
	browserSync.reload();
});

gulp.task('lint', function() {
	return gulp.src('src/js/*.js')
	.pipe(jshint())
	.pipe(jshint.reporter('jshint-stylish'));
});

/**
* CSS tasks
*/
gulp.task('sass', function() {
	return gulp.src('src/scss/*.scss')
	.pipe(sass().on('error', sass.logError))
	.pipe(gulp.dest('assets/css'))
	.pipe(browserSync.stream());
});

/**
* Watch task
*/
gulp.task('watch', ['js', 'sass'], function() {
	browserSync.init({
		proxy: 'http://local.wordpress.dev/',
		snippetOptions: {
			whitelist: ['/wp-admin/admin-ajax.php'],
		}
	});

	gulp.watch(['src/scss/**/*'], ['sass']);
	gulp.watch(['src/js/**/*'], ['lint', 'js-watch']);
	gulp.watch(['./**/*.php']).on('change', browserSync.reload);
});
