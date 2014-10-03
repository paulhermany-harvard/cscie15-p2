requirejs.config({
    paths: {
        jquery : [
            '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min',
            'lib/jquery-1.11.1.min'
        ],
        bootstrap : [
            '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min',
            'lib/bootstrap-3.2.0.min'
        ],
        bootstrapValidator : [
            '//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min',
            'lib/bootstrapValidator-0.5.2.min'
        ]
    },
    shim: {
        bootstrap : {
            deps: ['jquery']
        },
        bootstrapValidator : {
            deps: ['bootstrap']
        }
    }
});

require(['jquery', 'bootstrapValidator'], function ($) {

    // when the grade level changes, recalculate the min/max length and reset the validators
    $('#gradeLevel').change(function(e) {
        var absMax = $('#minLength').attr('min');
        var absMin = $('#maxLength').attr('max');
        
        // iterate through the selected grade level options to determine the new min/max length
        $('#gradeLevel option:selected').each(function() {
            var relMax = $(this).data('rel-max');
            if(relMax > absMax) absMax = relMax;
            
            var relMin = $(this).data('rel-min');
            if(relMin < absMin) absMin = relMin;
        });

        // set the min/max length to the new absolute min/max
        if($('#maxLength').val() > absMax) { $('#maxLength').val(absMax); }
        if($('#minLength').val() < absMin) { $('#minLength').val(absMin); }

        // set the html5 mim/max attributes for validation
        $('#maxLength').attr('max', absMax);
        $('#minLength').attr('min', absMin);

        // reset the max length validator
        $('#chbs').bootstrapValidator('removeField', 'maxLength');
        $('#chbs').bootstrapValidator('addField', 'maxLength');

        // reset the min length validator
        $('#chbs').bootstrapValidator('removeField', 'minLength');
        $('#chbs').bootstrapValidator('addField', 'minLength');     
    });

    // when the minimum length changes, revalidate the max length field
    $('#minLength').change(function(e) {
        $('#chbs').bootstrapValidator('revalidateField', 'maxLength');
    });

    // when the maximum length changes, revalidate the min length field
    $('#maxLength').change(function(e) {
        $('#chbs').bootstrapValidator('revalidateField', 'minLength');
    });

    // setup the bootstrap validator
    $('#chbs').bootstrapValidator({
    })
    .on('success.field.bv', function(e, data) {
        // remove success class
        data.element.parents('.form-group').removeClass('has-success');
    });
});