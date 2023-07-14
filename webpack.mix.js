let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*
 |--------------------------------------------------------------------------
 | Backend
 |--------------------------------------------------------------------------
 |
 */

mix.scripts([
    'resources/assets/metronic/global/plugins/jquery.min.js',
  	'resources/assets/metronic/global/plugins/bootstrap/js/bootstrap.min.js',
  	'resources/assets/metronic/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.min.js',
  	'resources/assets/metronic/global/scripts/app.min.js',
  	'resources/assets/metronic/pages/scripts/components-date-time-pickers.min.js',
  	'resources/assets/metronic/layouts/layout/scripts/layout.min.js',
    'resources/assets/backend/js/labelError.js',
    'node_modules/bootstrap-fileinput/js/fileinput.js',
    'resources/assets/backend/js/ui-sweetalert.min.js',
    'resources/assets/metronic/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker3.min.js',
    'resources/assets/metronic/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
    'resources/assets/metronic/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
    'resources/assets/nepali.datepicker/nepali.datepicker.v2.2.min.js',
    'resources/assets/metronic/global/plugins/bootstrap-sweetalert/sweetalert.min.js',
    'resources/assets/metronic/global/plugins/select2/js/select2.min.js',
    'resources/assets/metronic/global/plugins/amcharts/amcharts/amcharts.js',
    'resources/assets/metronic/global/plugins/amcharts/amcharts/serial.js',
    'resources/assets/metronic/global/plugins/amcharts/amcharts/pie.js',
    'resources/assets/metronic/global/plugins/amcharts/amcharts/themes/light.js',
    'resources/assets/backend/js/xlsx.core.min.js',
    'node_modules/file-saverjs/FileSaver.min.js',
    'node_modules/tableexport/dist/js/tableexport.min.js',
    'node_modules/lightbox2/src/js/lightbox.js',
    'resources/assets/backend/js/script.js',
    'resources/assets/backend/js/custom.js',
], 'public/js/backend.js');

mix.scripts([
    'resources/assets/backend/js/ckeditor.config.js',
], 'public/js/ckeditor.config.js');

mix.styles([
    'resources/assets/metronic/global/plugins/bootstrap/css/bootstrap.min.css',
    'node_modules/@jorgeinv/font-awesome-5.7.2/css/all.css',
    'resources/assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css',
    'resources/assets/metronic/global/plugins/simple-line-icons/simple-line-icons.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css',
    'resources/assets/metronic/global/css/components.min.css',
    'resources/assets/metronic/global/css/search.min.css',
    'resources/assets/metronic/global/css/plugins.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css',
    'node_modules/bootstrap-fileinput/css/fileinput.css',
    'resources/assets/metronic/layouts/layout/css/layout.min.css',
    'resources/assets/metronic/layouts/layout/css/themes/darkblue.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
    'resources/assets/nepali.datepicker/nepali.datepicker.v2.2.min.css',
    'resources/assets/metronic/layouts/layout/css/custom.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-sweetalert/sweetalert.css',
    'resources/assets/metronic/global/plugins/select2/css/select2.min.css',
    'resources/assets/metronic/global/plugins/select2/css/select2-bootstrap.min.css',
    'resources/assets/metronic/global/css/plugins.min.css',
    'resources/assets/metronic/global/css/plugins.min.css',
    'node_modules/tableexport/dist/css/tableexport.min.css',
    'node_modules/lightbox2/src/css/lightbox.css',
    'resources/assets/toggleSwitch/toggle-switch.css',
    'resources/assets/backend/css/semantic-label.css',
    'resources/assets/backend/css/abs.css',
    'resources/assets/backend/css/custom.css',
], 'public/css/backend.css');


mix.copyDirectory('resources/assets/backend/images', 'public/images');
mix.copyDirectory('resources/assets/backend/fonts', 'public/fonts');
mix.copyDirectory('node_modules/@jorgeinv/font-awesome-5.7.2/webfonts', 'public/webfonts');
mix.copyDirectory('resources/assets/metronic/global/plugins/font-awesome/fonts', 'public/fonts');
mix.copyDirectory('resources/assets/metronic/global/plugins/simple-line-icons/fonts', 'public/css/fonts');
mix.copyDirectory('resources/assets/metronic/global/plugins/bootstrap/fonts/bootstrap', 'public/fonts/bootstrap');
mix.copyDirectory('resources/assets/metronic/global/plugins/ckeditor', 'public/plugins/ckeditor');
mix.copyDirectory('node_modules/lightbox2/src/images', 'public/images');
mix.copyDirectory('resources/assets/nepali.datepicker/images', 'public/css/images');
mix.copyDirectory('node_modules/tableexport/dist/img', 'public/img');
mix.copyDirectory('node_modules/bootstrap-fileinput/img', 'public/img');
mix.copyDirectory('resources/assets/backend/img', 'public/img');


/*
 |--------------------------------------------------------------------------
 | Backend Auth
 |--------------------------------------------------------------------------
 |
 */
mix.styles([
    'resources/assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css',
    'resources/assets/metronic/global/plugins/simple-line-icons/simple-line-icons.min.css',
    'resources/assets/metronic/global/plugins/bootstrap/css/bootstrap.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
    'resources/assets/metronic/global/plugins/select2/css/select2.min.css',
    'resources/assets/metronic/global/plugins/select2/css/select2-bootstrap.min.css',
    'resources/assets/metronic/global/css/components.min.css',
    'resources/assets/metronic/global/css/plugins.min.css',
    'resources/assets/metronic/global/css/login.min.css'
], 'public/css/auth.css');

/*
 |--------------------------------------------------------------------------
 | Frontend
 |--------------------------------------------------------------------------
 |
 */
mix.scripts([
    'resources/assets/metronic/global/plugins/jquery.min.js',
    'resources/assets/metronic/global/plugins/bootstrap/js/bootstrap.min.js',
    'node_modules/jquery-validation/dist/jquery.validate.js',
    'node_modules/toastr/toastr.js',
    'node_modules/lightgallery/dist/js/lightgallery-all.min.js',
    'node_modules/slick-carousel/slick/slick.min.js',
    'resources/assets/frontend/js/custom.js',
], 'public/js/frontend.js');

mix.styles([
    'resources/assets/metronic/global/plugins/bootstrap/css/bootstrap.min.css',
    'node_modules/@jorgeinv/font-awesome-5.7.2/css/all.css',
    'resources/assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css',
    'node_modules/toastr/build/toastr.css',
    'node_modules/lightgallery/dist/css/lightgallery.css',
    'node_modules/slick-carousel/slick/slick.css',
    'node_modules/slick-carousel/slick/slick-theme.css',
    'resources/assets/frontend/css/style.css',
    'resources/assets/frontend/css/custom.css',
], 'public/css/frontend.css');

mix.copyDirectory('resources/assets/frontend/images', 'public/images');
mix.copyDirectory('resources/assets/frontend/fonts', 'public/fonts');
mix.copyDirectory('node_modules/lightgallery/dist/img', 'public/img');
mix.copyDirectory('node_modules/lightgallery/dist/fonts', 'public/fonts');
mix.copyDirectory('node_modules/slick-carousel/slick/fonts', 'public/css/fonts');
mix.copy('node_modules/slick-carousel/slick/ajax-loader.gif', 'public/css/ajax-loader.gif');

/*
 |--------------------------------------------------------------------------
 | Error Page
 |--------------------------------------------------------------------------
 |
 */

mix.styles([
    'resources/assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css',
    'resources/assets/error/css/style.css',
], 'public/css/error.css');

mix.copyDirectory('resources/assets/error/images', 'public/images');