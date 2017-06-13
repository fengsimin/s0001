var
gulp = require('gulp'),
uglify = require('gulp-uglify'),
minifycss = require('gulp-minify-css'),
autoprefixer = require('gulp-autoprefixer'),
rename = require('gulp-rename');

gulp.task('css', function() {
	return gulp.src(['asset/css/main.css','asset/css/iview.css','asset/css/iview-skin.css'])
		.pipe(autoprefixer({browsers:'last 10 versions'}))
		.pipe(minifycss())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('asset/css'));
});

gulp.task('js', function() {
	return gulp.src(['asset/js/main.js','asset/js/iview.js','asset/js/velocity.js'])
		.pipe(uglify({mangle:false,compress:false}))
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('asset/js'));
});

gulp.task('default', function () {  
    gulp.run(['js', 'css']); 
});  