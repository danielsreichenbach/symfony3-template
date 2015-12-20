var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

config.publicPath = 'web';
config.appPath = 'src';
config.assetsPath = 'app/Resources/assets';
config.testing.phpUnit.options.debug = false;
config.testing.phpUnit.options.configurationFile = 'phpunit.xml.dist';
config.testing.phpSpec.path = 'src/Acme/*/*/spec'

elixir(function(mix) {
    mix.phpSpec();
    mix.sass('app.sass');
    mix.browserify('app.js');
});
