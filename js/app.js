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

    $('#gradeLevel').change(function(e) {
        var absMax = $('#minLength').attr('min');
        var absMin = $('#maxLength').attr('max');
        
        $('#gradeLevel option:selected').each(function() {
            var relMax = $(this).data('rel-max');
            if(relMax > absMax) absMax = relMax;
            
            var relMin = $(this).data('rel-min');
            if(relMin < absMin) absMin = relMin;
        });
        
        if($('#maxLength').val() > absMax) { $('#maxLength').val(absMax); }
        if($('#minLength').val() < absMin) { $('#minLength').val(absMin); }
        
        $('#maxLength').attr('max', absMax);
        $('#minLength').attr('min', absMin);
        
        $('#chbs').bootstrapValidator('removeField', 'maxLength');
        $('#chbs').bootstrapValidator('addField', 'maxLength');
        
        $('#chbs').bootstrapValidator('removeField', 'minLength');
        $('#chbs').bootstrapValidator('addField', 'minLength');
    });

	$('#minLength').change(function(e) {
		$('#chbs').bootstrapValidator('revalidateField', 'maxLength');
	});

	$('#maxLength').change(function(e) {
		$('#chbs').bootstrapValidator('revalidateField', 'minLength');
	});
	
    $('#chbs').bootstrapValidator({
        fields: {
            minLength: {
                validators: {
                    between: {
                        inclusive: true,
                        min: 'minLength',
                        max: 'maxLength',
                        message: 'The minimum length must be less than or equal to the maximum length'
                    }
                }
            },
            maxLength: {
                validators: {
                    between: {
                        inclusive: true,
                        min: 'minLength',
                        max: 'maxLength',
                        message: 'The maximum length must be greater than or equal to the minimum length'
                    }
                }
            }
        }
    })
    .on('success.field.bv', function(e, data) {
        // remove success class
        data.element.parents('.form-group').removeClass('has-success');
    });
});