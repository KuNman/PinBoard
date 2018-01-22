require('../css/app.scss');
require('../css/select2.min.css');
require('./select2.min');

var $ = require('jquery');

$(document).ready(function() {

    $('#start:first-child').on('select2:select', function (e) {
        var type = $('.select2-selection__rendered').text();
        $('#type option').val(type);
    });

    $('#start').select2({
        dropdownAutoWidth : true,
        placeholder: 'Please select kind',
        width: '100%'
    });

 });