const { src, dest, watch, series } = require('gulp'),
	sass = require('gulp-sass')(require('sass')),
	// const prefixer = require('gulp-autoprefixer')
	// const minify = require('gulp-clean-css')
	terser = require('gulp-terser'),
	// const imagemin = require('gulp-imagemin')
	// const imagewebp = require('gulp-webp')
	browserSync = require('browser-sync').create()

//sass task
function sassTask() {
	return (
		src('src/sass/**/*.sass')
			.pipe(sass())
			// .pipe(prefixer())
			// .pipe(minify())
			.pipe(dest('dist/css'))
	)
}

//js task
function jsTask() {
	return src('src/js/**/*.js').pipe(terser()).pipe(dest('dist/js'))
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

//browserSync serve
function browserSyncServe(cb) {
	browserSync.init({
		server: {
			baseDir: './dist',
		},
	})
	cb()
}
//browserSync reload
function browserSyncReload(cb) {
	browserSync.reload()
	cb()
}

//watchtask
function watchTask() {
	watch('src/**/*.php', browserSyncReload)
	watch('src/sass/**/*.sass', sassTask, browserSyncReload)
	watch('src/js/**/*.js', jsTask, browserSyncReload)
	// watch('src/images/**/*.{jpg,jpeg,png,gif}', imagesCompress, browsersyncReload)
	// watch('dist/images/*.{jpg,jpeg,png,gif}', imagesWebp)
}

//default gulp
exports.default = series(sassTask, jsTask, watchTask, browserSyncServe)
