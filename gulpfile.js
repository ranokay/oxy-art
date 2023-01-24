import gulp from 'gulp'
import { deleteAsync } from 'del'
import dartSass from 'sass'
import gulpSass from 'gulp-sass'
import cleanCSS from 'gulp-clean-css'
import rename from 'gulp-rename'
import babel from 'gulp-babel'
import terser from 'gulp-terser'
import concat from 'gulp-concat'
import sourcemaps from 'gulp-sourcemaps'
import autoprefixer from 'gulp-autoprefixer'
import imagemin from 'gulp-imagemin'
import htmlmin from 'gulp-htmlmin'
import fileinclude from 'gulp-file-include'

const prj_folder = 'oxyproject',
	src_folder = 'src'

const { src, dest, watch, series, parallel } = gulp,
	sass = gulpSass(dartSass),
	{ init, write } = sourcemaps

const path = {
	src: {
		php: src_folder + '/*.php',
		phpServer: [src_folder + '/php/*.php', '!' + src_folder + '/**/_*.php'],
		css: src_folder + '/sass/style.scss',
		js: src_folder + '/js/index.js',
		assets: src_folder + '/assets/**/*',
		collection: src_folder + '/collection/**/*',
	},
	watch: {
		php: src_folder + '/**/*.php',
		css: src_folder + '/sass/**/*.scss',
		js: src_folder + '/js/**/*.js',
		assets: src_folder + '/assets/**/*',
		collection: src_folder + '/collection/**/*',
	},
	build: {
		php: prj_folder + '/',
		phpServer: prj_folder + '/php/',
		css: prj_folder + '/css/',
		js: prj_folder + '/js/',
		assets: prj_folder + '/assets/',
		collection: prj_folder + '/collection/',
	},
	clean: {
		all: [
			prj_folder + '/css/',
			prj_folder + '/js/',
			prj_folder + '/php/',
			prj_folder + '/*.php',
			prj_folder + '/assets/',
			prj_folder + '/collection/',
		],
	},
}

//clean task
function cleanTask() {
	return deleteAsync(path.clean.all)
}

//php task
function phpTask() {
	return src(path.src.php)
		.pipe(fileinclude())
		.pipe(htmlmin({ collapseWhitespace: true }))
		.pipe(dest(path.build.php))
}

//php server task
function phpServerTask() {
	return src(path.src.phpServer).pipe(fileinclude()).pipe(dest(path.build.phpServer))
}

//style task
function styleTask() {
	return src(path.src.css)
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
		.pipe(dest(path.build.css))
}

//js task
function jsTask() {
	return src(path.src.js)
		.pipe(init())
		.pipe(
			babel({
				presets: ['@babel/preset-env'],
			})
		)
		.pipe(terser())
		.pipe(concat('main.min.js'))
		.pipe(write('.'))
		.pipe(dest(path.build.js))
}

//images task
function imagesTask() {
	return src(path.src.assets)
		.pipe(dest(path.build.assets))
		.pipe(src(path.src.assets))
		.pipe(
			imagemin({
				progressive: true,
				svgoPlugins: [{ removeViewBox: false }],
				interlaced: true,
				optimizationLevel: 2,
			})
		)
		.pipe(dest(path.build.assets))
}

//collection task
function collectionTask() {
	return src(path.src.collection)
		.pipe(dest(path.build.collection))
		.pipe(src(path.src.collection))
		.pipe(
			imagemin({
				progressive: true,
				svgoPlugins: [{ removeViewBox: false }],
				interlaced: true,
				optimizationLevel: 2,
			})
		)
		.pipe(dest(path.build.collection))
}

//watch task
function watchTask() {
	watch(path.watch.php, phpTask)
	watch(path.watch.php, phpServerTask)
	watch(path.watch.css, styleTask)
	watch(path.watch.js, jsTask)
	watch(path.watch.assets, imagesTask)
	watch(path.watch.collection, collectionTask)
}

//build
const _build = series(
	cleanTask,
	parallel(phpTask, phpServerTask, styleTask, jsTask, imagesTask, collectionTask)
)

//watch
const _watch = parallel(_build, watchTask)

//gulp tasks
export const _clean = cleanTask
export const _php = phpTask
export const _phpServer = phpServerTask
export const _style = styleTask
export const _js = jsTask
export const _assets = imagesTask
export const _collection = collectionTask
export const __build = _build
export const __watch = _watch

//default gulp task
const _default = _watch
export { _default as default }
