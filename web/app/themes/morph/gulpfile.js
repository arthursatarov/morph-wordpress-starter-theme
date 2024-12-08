/**
 * Gulp file for automating project tasks.
 *
 * This file includes configurations and tasks for Gulp
 * to build and optimize styles, scripts, fonts, and images.
 */

/**
 * Table of Contents:
 *
 * 1. Gulp modules
 * 2. Settings
 * 3. Task functions
 * 4. Export tasks
 */

// =========================================================
// 1. Gulp modules
// =========================================================

const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const cssnano = require('cssnano');
const del = require('del');
const esbuild = require('gulp-esbuild');
const newer = require('gulp-newer');
const notify = require('gulp-notify');
const plumber = require('gulp-plumber');
const postcss = require('gulp-postcss');
const gulpSass = require('gulp-sass')(require('sass'));
const postcssSortMediaQueries = require('postcss-sort-media-queries');

const { src, dest, watch, series, parallel } = gulp;

// =========================================================
// 2. Settings
// =========================================================

const isProd =
	process.env.NODE_ENV === 'prod' || process.env.NODE_ENV === 'production';

/**
 * Specifies paths for source files and compiled files.
 */
const srcFolder = './src/';
const buildFolder = './assets/';

const path = {
	src: {
		styles: srcFolder + 'styles/index.scss',
		scripts: srcFolder + 'scripts/*.js',
		fonts: srcFolder + 'fonts/**/*.{ttf,eof,woff,woff2}',
		images: srcFolder + 'images/**/*.{jpg,png,svg,gif,webp}',
	},
	build: {
		styles: buildFolder + 'styles/',
		scripts: buildFolder + 'scripts/',
		fonts: buildFolder + 'fonts/',
		images: buildFolder + 'images/',
	},
	watch: {
		php: '**/*.php',
		styles: srcFolder + 'styles/**/*.scss',
		scripts: srcFolder + 'scripts/**/*.js',
		images: srcFolder + 'images/**/*.{jpg,png,svg,gif,webp}',
		fonts: srcFolder + 'fonts/**/*.{ttf,eof,woff,woff2}',
	},
};

// Notify config
const onError = function (err) {
	notify.onError({
		title: 'Gulp',
		subtitle: 'Failure!',
		message: 'Error: <%= error.message %>',
		sound: 'Beep',
	})(err);

	this.emit('end');
};

// ESBuild configuration
const esbuildConfig = {
	target: 'es2020',
	minify: isProd,
	bundle: true,
	write: false,
};

// PostCSS configuration
const postcssConfig = [
	postcssSortMediaQueries,
	...(isProd ? [cssnano({ preset: 'default' })] : []),
];

// =========================================================
// 3. Task functions
// =========================================================

/**
 * Task to bundle JavaScript files using ESBuild.
 */
function bundleScripts() {
	return src(path.src.scripts)
		.pipe(esbuild(esbuildConfig))
		.pipe(dest(path.build.scripts))
		.pipe(browserSync.stream());
}

/**
 * Task to compile and process Sass files.
 */
function buildStyles() {
	return src(path.src.styles)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(gulpSass())
		.pipe(postcss(postcssConfig))
		.pipe(dest(path.build.styles))
		.pipe(browserSync.stream());
}

/**
 * Task to copy font files.
 */
function copyFonts() {
	return src(path.src.fonts)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(newer(path.build.fonts))
		.pipe(dest(path.build.fonts))
		.pipe(browserSync.stream());
}

/**
 * Task to copy and optimize image files.
 */
function copyImages() {
	return src(path.src.images)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(newer(path.build.images))
		.pipe(dest(path.build.images))
		.pipe(browserSync.stream());
}

/**
 * Task to start a development server with BrowserSync.
 */
function serve() {
	browserSync.init({
		ui: false,
		proxy: 'localhost:8000',
		port: 3000,
		open: false,
	});

	watch(path.watch.php, series(buildStyles));
	watch(path.watch.scripts, series(bundleScripts));
	watch(path.watch.styles, series(buildStyles));
	watch(path.watch.fonts, series(copyFonts));
	watch(path.watch.images, series(copyImages));
}

/**
 * Task to clean the 'assets/' folder.
 */
function cleanAssets(cb) {
	del(['assets/']).then(() => cb());
}

/**
 * Task to clean the 'node_modules/' folder.
 */
function cleanNodeModules(cb) {
	del(['node_modules/']).then(() => cb());
}

// =========================================================
// 4. Export tasks
// =========================================================

/**
 * Default task: Clean, build, and optionally serve the project.
 */
const defaultTask = isProd
	? series(
			cleanAssets,
			parallel(bundleScripts, buildStyles, copyFonts, copyImages),
			cleanNodeModules
	  )
	: series(
			cleanAssets,
			parallel(bundleScripts, buildStyles, copyFonts, copyImages),
			serve
	  );

// Export the default task
exports.default = defaultTask;
