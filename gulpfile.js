var elixir = require('laravel-elixir');
var gulp = require('gulp');
var exec = require('child_process').exec;
var notify = require("gulp-notify");
var gutil = require('gulp-util');

elixir(function(mix) {
    mix.sass('app.scss', 'public/css/custom.css');
    mix.less('app.less', 'public/css/template.css');
});

gulp.task('styles', function() {
    elixir(function(mix) {
        mix.sass('app.scss', 'public/css/custom.css');
        mix.less('app.less', 'public/css/template.css');
    });
});

// Test function
var phpunit_bin = /^win/.test(process.platform) ? 'vendor\\bin\\phpunit.bat' : './vendor/bin/phpunit';

function phpunit(unit_test_path, options) {
    unit_test_path = typeof unit_test_path !== 'undefined' ? unit_test_path : '';
    options = typeof options !== 'undefined' ? options : '';

    console.log('\n$ phpunit ' + unit_test_path + ' ' + options + '\n');

    exec(phpunit_bin + ' ' + unit_test_path + ' ' + options, function(error, stdout, stderr) {
        console.log('\n' + stdout);
        if (! error) {
            console.log(gutil.colors.bgGreen( Array(108).join(' ')) );
        } else {
            // console.log('\nERROR: ' + error);
            console.log(gutil.colors.bgRed( Array(108).join(' ')) );
        }
        console.log(Array(108).join('=') + '\n');
    });
}

// Single test
gulp.task('phpunit', function() {
    phpunit();
});

gulp.task('phpunit_cov', function() {
    phpunit('', '--coverage-html ./build_files/coverage_html');
});

// Continuous testing
gulp.task('tdd', function() {
    var test_watcher = gulp.watch('tests/**/*.php', { debounceDelay: 1000 });
    test_watcher.on('change', function(event){
        phpunit(event.path.replace(/\\/g, '/'));
    });

    var app_watcher = gulp.watch('app/**/*.php', { debounceDelay: 1000 });
    app_watcher.on('change', function(event){
        phpunit(event.path.replace(/\\/g, '/').replace('/app/', '/tests/').replace(/.php$/, 'Test.php'));
    });
});

gulp.task('tdd_cov', function() {
    var test_watcher = gulp.watch('tests/**/*.php', { debounceDelay: 1000 });
    test_watcher.on('change', function(event){
        phpunit(event.path.replace(/\\/g, '/'), '--coverage-html ./build_files/coverage_html');
    });

    var app_watcher = gulp.watch('app/**/*.php', { debounceDelay: 1000 });
    app_watcher.on('change', function(event){
        phpunit(event.path.replace(/\\/g, '/').replace('/app/', '/tests/').replace(/.php$/, 'Test.php'), '--coverage-html ./build_files/coverage_html');
    });
});

