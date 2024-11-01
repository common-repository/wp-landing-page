var gulp = require('gulp');

var sass = require('gulp-sass');
var please = require('gulp-pleeease');
var rename = require("gulp-rename");
var browserSync = require('browser-sync').create();
var reload = browserSync.reload();

/* Style Color */
gulp.task('sass', function () {
	return gulp.src('sass/*.scss')
		.pipe(sass().on('error', sass.logError))
        .pipe(please())
		.pipe(gulp.dest('./css'));
});

/* Style Templates */
gulp.task('themes', function () {
	return gulp.src('templates/sass/*.scss')
		.pipe(sass().on('error', sass.logError))
        .pipe(please())
		.pipe(gulp.dest('./templates/css'));
});

gulp.task('watch', ['sass','themes'],function() {
	browserSync.init({
		proxy: "localhost/wp-landingpage"
	});

	gulp.watch([ "sass/*.scss" ], ['sass']);
	gulp.watch([ "templates/sass/*.scss" ], ['themes']);

	gulp.watch([
		"js/**/*.js",
		"**/*.php",
		"**/*.css"
	]).on( "change", function( file ) {
		console.log( file.path );
		browserSync.reload();
	});
});


gulp.task('default', function() {
  // place code for your default task here
});
