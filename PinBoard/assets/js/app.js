require('../css/app.scss');
require('../css/select2.min.css');
require('./select2.min');

var $ = require('jquery');

$(document).ready(function() {
    $('.js-example-basic-single').select2();
});