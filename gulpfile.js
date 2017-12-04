var gulp = require('gulp');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var livereload = require('gulp-livereload');


// LiveReload
gulp.task('reload', function(){
    livereload.listen();
    gulp.watch('src/**', function(){
        gulp.src('src/**').pipe(livereload());
    });
    gulp.watch('web/**', function(){
        gulp.src('web/**').pipe(livereload());
    });
    gulp.watch('app/**', function(){
        gulp.src('app/**').pipe(livereload());
    });
});


// Js
gulp.task('js', function(){
    gulp.watch('src/AppBundle/Resources/js/form/*.js', function(){
        gulp.src('src/AppBundle/Resources/js/form/*.js')
            .pipe(sourcemaps.init())
            .pipe(concat('main.js'))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('web/js'));
    });
});


//Css
gulp.task('css', function(){
    gulp.watch('src/AppBundle/Resources/css/*.css', function(){
        gulp.src('src/AppBundle/Resources/css/*.css')
            .pipe(sourcemaps.init())
            .pipe(autoprefixer({
                browsers: ['last 4 versions'],
                cascade: false
            }))
            .pipe(concat('main.css'))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('web/css'));
    });
});


// Img
gulp.task('img', function(){
    gulp.watch('src/AppBundle/Resources/img/**', function(){
        gulp.src('src/AppBundle/Resources/img/**').pipe(gulp.dest('web/img/'))
    });
});

// Appel
gulp.task('default', ['img', 'css', 'js', 'reload']);