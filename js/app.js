requirejs.config({
    paths: {
		jquery : [
			'//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min',
			'lib/jquery-1.11.1.min'
		],
		bootstrap : [
			'//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min',
			'lib/bootstrap-3.2.0.min'
		]
    },
    shim: {
        bootstrap : {
            deps: ['jquery']
        }
    }
});

require(['jquery', 'bootstrap'], function ($) {
    
});