require('../css/app.scss');
require('../css/select2.min.css');
require('./select2.min');

var $ = require('jquery');

$(document).ready(function() {

    $('#start').on("select2:selecting", function(e) {
        $('.search-bar-city').fadeIn(500).toggleClass('visible');

        $('#city').select2({
            dropdownAutoWidth : true,
            placeholder: 'Please select kind',
            width: '100%'
        });
    });

    $('#start').select2({
        dropdownAutoWidth : true,
        placeholder: 'Please select kind',
        width: '100%'
    });

});