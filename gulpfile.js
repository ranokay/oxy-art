import gulp from 'gulp'
const { src, dest, watch, series, parallel } = gulp
import del from 'del'
import dartSass from 'sass'
import gulpSass from 'gulp-sass'
const sass = gulpSass(dartSass)
import cleanCSS from 'gulp-clean-css'
import rename from 'gulp-rename'
import babel from 'gulp-babel'
import uglify from 'gulp-uglify'
import concat from 'gulp-concat'
import sourcemaps from 'gulp-sourcemaps'
const { init, write } = sourcemaps
import autoprefixer from 'gulp-autoprefixer'
import imagemin from 'gulp-imagemin'
import htmlmin from 'gulp-htmlmin'
import newer from 'gulp-newer'
import browserSync from 'browser-sync'

const paths = {
	html: {
		src: 'src/**/*.html',
		dest: ['dist'],
	},
	styles: {
		src: ['src/sass/**/*.sass', 'src/sass/**/*.scss'],
		dest: 'dist/css',
	},
	scripts: {
		src: 'src/js/**/*.js',
		dest: 'dist/js',
	},
	images: {
		src: 'src/images/**/*',
		dest: 'dist/images',
	},
}

//clean task
function cleanTask() {
	return del(['dist/*', '!dist/images'])
}

//htmlmin task
function htmlminTask() {
	return src(paths.html.src)
		.pipe(htmlmin({ collapseWhitespace: true }))
		.pipe(dest(paths.html.dest))
		.pipe(browserSync.stream())
}

//style task
function styleTask() {
	return src(paths.styles.src)
		.pipe(init())
		.pipe(sass().on('error', sass.logError))
		.pipe(
			autoprefixer({
				cascade: false,
			})
		)
		.pipe(
			cleanCSS({
				level: 2,
			})
		)
		.pipe(
			rename({
				basename: 'style',
				suffix: '.min',
			})
		)
		.pipe(write('.'))
		.pipe(dest(paths.styles.dest))
		.pipe(browserSync.stream())
}

//js task
function jsTask() {
	return src(paths.scripts.src)
		.pipe(init())
		.pipe(
			babel({
				presets: ['@babel/preset-env'],
			})
		)
		.pipe(uglify())
		.pipe(concat('main.min.js'))
		.pipe(write('.'))
		.pipe(dest(paths.scripts.dest))
		.pipe(browserSync.stream())
}

//imagemin task
function imgminTask() {
	return src(paths.images.src)
		.pipe(newer(paths.images.dest))
		.pipe(
			imagemin({
				quality: 80,
				progressive: true,
				optimizationLevel: 2,
			})
		)
		.pipe(dest(paths.images.dest))
}

//Webp images
// function imagesWebp() {
// 	return src('dist/images/*.{jpg,jpeg,png,gif}').pipe(imagewebp({})).pipe(dest('dist/images'))
// }

//watch task
function watchTask() {
	browserSync.init({
		proxy: {
			target: 'http://localhost/Oxy-Project/dist/',
		},
		tunnel: true,
	})
	watch(paths.html.dest).on('change', browserSync.reload)
	watch(paths.html.src, htmlminTask)
	watch(paths.styles.src, styleTask)
	watch(paths.scripts.src, jsTask)
	watch(paths.images.src, imgminTask)
}

//gulp tasks
export const _clean = cleanTask
export const _htmlmin = htmlminTask
export const _style = styleTask
export const _js = jsTask
export const _imgmin = imgminTask
export const _watch = watchTask

//default gulp task
const _default = series(cleanTask, htmlminTask, parallel(styleTask, jsTask, imgminTask), watchTask)
export { _default as default }
