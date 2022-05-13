// fichier qui va gérer toutes mes tâches
'use strict';

const 	bs 				= require('browser-sync'),
		// gulp css
		gulp 			= require('gulp'),
		sass 			= require('gulp-sass')(require('node-sass')),
		wait 			= require('gulp-wait'),
		rename 			= require('gulp-rename'),
		notify 			= require('gulp-notify'),
		sourcemaps 		= require('gulp-sourcemaps'),
		postcss 		= require('gulp-postcss'),
		// postcss
		autoprefixer 	= require('autoprefixer'),
		cssnano 		= require('cssnano'),
		mqpacker 		= require('mqpacker'),
		sortmq 			= require('sort-css-media-queries'),
		// gulp js
		concat 			= require('gulp-concat'),
		uglify 			= require('gulp-uglify'),
		babel 			= require('gulp-babel'),
		// gulp image
		imagemin 		= require('gulp-imagemin'),
		gifsicle 		= require('gifsicle'),
	    mozjpeg 		= require('mozjpeg'),
	    optipng 		= require('optipng'),
	    svgo 			= require('svgo');

// plugins pour postcss
var plugins = [
    autoprefixer({overrideBrowserslist: ['last 5 versions']}),
    cssnano({preset:['default',{cssDeclarationSorter: false}]}),
    mqpacker({sort: sortmq})
];

var img = [
    imagemin.gifsicle({interlaced: true}),
    imagemin.mozjpeg({quality: 75, progressive: true}),
    imagemin.optipng({optimizationLevel: 5}),
    imagemin.svgo({
        plugins: [
            {removeViewBox: true},
            {cleanupIDs: false}
        ]
    })
];

gulp.task('style', function() {
	// on lui indique les fichiers sources
	return gulp.src([
		// './assets/libs/fontawesome/css/all.min.css',
		'./assets/css/src/**/*.scss'
	])
	.pipe(wait(1000)) // si votre projet est sur le disque D
	.pipe(sourcemaps.init())
	.pipe(sass().on('error', notify.onError()))
	// .pipe(concat('main.min.css'))
	.pipe(rename({suffix: '.min'}))
	.pipe(postcss(plugins))
	.pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./assets/css/dist'))
    .pipe(notify({message: 'CSS bien compilé !!!', onLast: true}))
    .pipe(bs.stream());
});

gulp.task('scripts', function() {
	return gulp.src([
		'./assets/libs/jquery/jquery-3.6.0.min.js',
		// './assets/libs/fontawesome/js/all.min.js',
		'./assets/js/src/**/*.js'
	])
	.pipe(sourcemaps.init())
	.pipe(babel({
        presets: ['@babel/env']
    }))
	.pipe(concat('scripts.min.js'))
	.pipe(uglify())
	.pipe(sourcemaps.write('.'))
	.pipe(gulp.dest('./assets/js/dist'))
	.pipe(notify({message: 'JS bien compilé !!!', onLast: true}))
});

gulp.task('image', function() {
	return gulp.src('assets/img/src/**/*') // jpeg, jpg, png, svg
	.pipe(imagemin(img))
	.pipe(gulp.dest('./assets/img/dist'))
});

gulp.task('dom', function() {
	return gulp.src('./**/*.php')
	.pipe(notify({message: 'PHP mis à jour !!!', onLast: true}))
    .pipe(bs.stream());
});

gulp.task('bs', function() {
	bs.init({
		// server: {
		// 	baseDir: "./" // à utiliser en cas de site statique (html)
		// }
		proxy: "http://buffyproject/", // au cas où vous êtes sur un serveur local type wamp, mamp ou xamp
	});
});

// on met en écoute les fichiers qui seront modifiés et qui relanceront les différentes tâches
gulp.task('watch', function() {
	gulp.watch('./assets/css/src/**/*.scss', gulp.parallel('style'));
	gulp.watch('./assets/js/src/**/*.js', gulp.parallel('scripts'));
	gulp.watch('./assets/img/src/**/*', gulp.parallel('image'));
	gulp.watch('./**/*.php', gulp.parallel('dom'));
});

gulp.task('default', gulp.parallel('style', 'bs', 'dom', 'scripts', 'image', 'watch'));
