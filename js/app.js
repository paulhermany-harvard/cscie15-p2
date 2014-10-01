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

    /* when a grade level is selected, we need to:
        1. recalculate the new absolute min/max based on selected grade levels
        2. adjust the min/max length
        3. recreate the validator to accomodate the changed value
    */
    $('#gradeLevel').change(function(e) {
        // set the absolute min/max to the opposite values
        var absMax = $('#minLength').attr('min');
        var absMin = $('#maxLength').attr('max');
        
        // search through the selected grade levels for the absolute min/max
        $('#gradeLevel option:selected').each(function() {
            var relMax = $(this).data('rel-max');
            if(relMax > absMax) absMax = relMax;
            
            var relMin = $(this).data('rel-min');
            if(relMin < absMin) absMin = relMin;
        });

        // make sure the min and max length are within the absolute limits
        if($('#maxLength').val() > absMax) { $('#maxLength').val(absMax); }
        if($('#minLength').val() < absMin) { $('#minLength').val(absMin); }

        // set the min/max attribute on the length inputs
        $('#maxLength').attr('max', absMax);
        $('#minLength').attr('min', absMin);

        // recreate the max length validator
        $('#chbs').bootstrapValidator('removeField', 'maxLength');
        $('#chbs').bootstrapValidator('addField', 'maxLength');

        // recreate the min length validator
        $('#chbs').bootstrapValidator('removeField', 'minLength');
        $('#chbs').bootstrapValidator('addField', 'minLength');
    });

    // instantiate the bootstrap validator with default settings
    $('#chbs').bootstrapValidator({})
    .on('success.field.bv', function(e, data) {
        // remove success class (too much styling)
        data.element.parents('.form-group').removeClass('has-success');
    });
});