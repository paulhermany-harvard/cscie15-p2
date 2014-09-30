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

	$(function() {

		$('#chbs input[type=checkbox]').change(function(e) {
			$('#chbs input[type=checkbox]:checked').each(function() {
				var absMax = $('#chbs input[name=minLength]').attr('min');
				var relMax = $(this).data('rel-max');
				if(relMax > absMax) absMax = relMax;
				$('#chbs input[name=maxLength]').attr('max', absMax);

				var absMin = $('#chbs input[name=maxLength]').attr('max');
				var relMin = $(this).data('rel-min');
				if(relMin < absMin) absMin = relMin;
				$('#chbs input[name=minLength]').attr('min', absMin);
			});

			$('#chbs').bootstrapValidator('removeField', 'maxLength');
			$('#chbs').bootstrapValidator('addField', 'maxLength');
			
			$('#chbs').bootstrapValidator('removeField', 'minLength');
			$('#chbs').bootstrapValidator('addField', 'minLength');			
		});
		
		$('#chbs').bootstrapValidator({})
		.on('success.field.bv', function(e, data) {
			// remove success class
			data.element.parents('.form-group').removeClass('has-success');
		})
		.on('success.form.bv', function(e) {
            e.preventDefault();

            var form = $(e.target);
			var _url = form.attr('action');
			var _type = form.attr('method');
			var _data = form.serializeArray();
		
			$.ajax({
				url: _url,
				type: _type,
				data : _data,
				success:function(data, status, xhr) {
					$('#password').text(data.data);
					$('#chbs').data('bootstrapValidator').disableSubmitButtons(false);
				},
				error: function(xhr, status, error) {
					$response = $.parseJSON(xhr.responseText);
					$('#chbs').data('bootstrapValidator').disableSubmitButtons(false);
				}
			});
        });
	});
	
});