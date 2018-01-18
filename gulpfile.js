var gulp = require('gulp');
var minify = require('gulp-minifier');
var concat = require('gulp-concat');

gulp.task('css', function () {
  return gulp.src([
      'bower_components/jquery-ui/themes/base/jquery-ui.min.css',
      'bower_components/bootstrap/dist/css/bootstrap.min.css',
      'bower_components/components-font-awesome/css/font-awesome.min.css',
      'bower_components/PACE/themes/blue/pace-theme-minimal.css',
      'bower_components/sweetalert/dist/sweetalert.css',
      'bower_components/sweetalert/themes/google/google.css',
      'bower_components/datetimepicker/build/jquery.datetimepicker.min.css',
      'bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css',
      'bower_components/bootstrap-fileinput/css/fileinput.min.css',
      'bower_components/AdminLTE/dist/css/skins/_all-skins.min.css',
      'bower_components/AdminLTE/dist/css/AdminLTE.min.css',
      'build/css/**/*.css'
    ])
    .pipe(minify({
      minify: true,
      collapseWhitespace: true,
      conservativeCollapse: true,
      minifyJS: true,
      minifyCSS: true,
      getKeptComment: function (content, filePath) {
        var m = content.match(/\/\*![\s\S]*?\*\//img);
        return m && m.join('\n') + '\n' || '';
      }
    }))
    .pipe(concat('bjTKDTjDRVbgy6nQ.css'))
    .pipe(gulp.dest('public/css'))
});

gulp.task('css-img', function () {
  return gulp.src([
      'bower_components/jquery-ui/themes/base/images/*.*',
    ])
    .pipe(gulp.dest('public/css/images'))
});


gulp.task('js', function () {
  return gulp.src([
      'bower_components/jquery/dist/jquery.min.js',
      'bower_components/jquery-ui/jquery-ui.min.js',
      'bower_components/bootstrap/dist/js/bootstrap.min.js',
      'bower_components/PACE/pace.min.js',
      'bower_components/urijs/src/URI.min.js',
      'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
      'bower_components/fastclick/lib/fastclick.js',
      'bower_components/jquery.kinetic/jquery.kinetic.min.js',
      'bower_components/sweetalert/dist/sweetalert.min.js',
      'bower_components/datetimepicker/build/jquery.datetimepicker.full.min.js',
      'bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
      'bower_components/bootstrap-fileinput/js/fileinput.min.js',
      'bower_components/push.js/push.min.js',
      'bower_components/AdminLTE/dist/js/app.min.js',	
	  'bower_components/uFCoder/js/deployJava.js',
      'build/js/**/*.js',
      'build/js/*.js'
    ])
    .pipe(minify({
      minify: true,
      collapseWhitespace: true,
      conservativeCollapse: true,
      minifyJS: true,
      minifyCSS: true,
      getKeptComment: function (content, filePath) {
        var m = content.match(/\/\*![\s\S]*?\*\//img);
        return m && m.join('\n') + '\n' || '';
      }
    }))
    .pipe(concat('3EeG8zeF69hbJNUL.js'))
    .pipe(gulp.dest('public/js'))
});

gulp.task('legacy-js', function () {
  return gulp.src([
      'bower_components/html5shiv/dist/html5shiv-printshiv.min.js',
      'bower_components/respond/dest/respond.min.js'
    ])
    .pipe(minify({
      minify: true,
      collapseWhitespace: true,
      conservativeCollapse: true,
      minifyJS: true,
      minifyCSS: true,
      getKeptComment: function (content, filePath) {
        var m = content.match(/\/\*![\s\S]*?\*\//img);
        return m && m.join('\n') + '\n' || '';
      }
    }))
    .pipe(concat('U7VuDNHHWzU8x6FX.js'))
    .pipe(gulp.dest('public/js'))
});

gulp.task('fonts', function () {
  return gulp.src([
      'bower_components/bootstrap/dist/fonts/*.*',
      'bower_components/components-font-awesome/fonts/*.*',
      'build/fonts/*.*',
    ])
    .pipe(gulp.dest('public/fonts'))
});

gulp.task('img', function () {
  return gulp.src([
      'build/img/**/*.*',
      '!build/img/**/*.psd*',
    ])
    .pipe(gulp.dest('public/img/'))
});

gulp.task('default', ['css', 'css-img', 'js', 'legacy-js', 'fonts', 'img']);
