const gulp = require('gulp'),
	del = require('del'),
	sass = require('gulp-sass')(require('sass')),
	cleanCSS = require('gulp-clean-css'),
	rename = require('gulp-rename'),
	babel = require('gulp-babel'),
	uglify = require('gulp-uglify'),
	concat = require('gulp-concat'),
	browserSync = require('browser-sync').create()

const paths = {
	styles: {
		src: 'src/sass/**/*.sass',
		dest: 'dist/css',
	},
	scripts: {
		src: 'src/js/**/*.js',
		dest: 'dist/js',
	},
}

//clean task
function cleanTask() {
	return del(['dist'])
}

//sass task
function sassTask() {
	return gulp
		.src(paths.styles.src)
		.pipe(sass())
		.pipe(cleanCSS())
		.pipe(
			rename({
				basename: 'main',
				suffix: '.min',
			})
		)
		.pipe(gulp.dest(paths.styles.dest))
}

//js task
function jsTask() {
	return gulp
		.src(paths.scripts.src, { sourcemaps: true })
		.pipe(babel())
		.pipe(uglify())
		.pipe(concat('main.min.js'))
		.pipe(gulp.dest(paths.scripts.dest))
}

//browserSync serve
function browserSyncServe(cb) {
	browserSync.init({
		proxy: 'http://localhost/Oxy-Project/src',
	})
	cb()
}
//browserSync reload
function browserSyncReload(cb) {
	browserSync.reload()
	cb()
}

//Images
// function imagesCompress() {
// 	return src('src/images/*.{jpg,jpeg,png,gif}')
// 		.pipe(
// 			imagemin([
// 				imagemin.mozjpeg({ quality: 80, progressive: true }),
// 				imagemin.optipng({ optimizationLevel: 2 }),
// 			])
// 		)
// 		.pipe(dest('dist/images'))
// }

//Webp images
// function imagesWebp() {
// 	return src('dist/images/*.{jpg,jpeg,png,gif}').pipe(imagewebp({})).pipe(dest('dist/images'))
// }

//watch task
function watchTask() {
	gulp.watch(paths.styles.src, sassTask)
	gulp.watch(paths.scripts.src, jsTask)
}

//build task
const build = gulp.series(cleanTask, gulp.parallel(sassTask, jsTask), watchTask)

//default gulp task
exports.default = build
exports.build = build

exports.cleanTask = cleanTask
exports.sassTask = sassTask
exports.jsTask = jsTask
exports.watchTask = watchTask
