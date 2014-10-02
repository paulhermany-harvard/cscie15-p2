<?php
	
    // database config
    $DB_SERVER   = 'localhost';
    $DB_USERNAME = 'p2user';
    $DB_PASSWORD = 'p2user-pwd-dev';
    $DB_INSTANCE = 'cscie15_p2';
	
	$gradeLevel_ParamName = 'gradeLevel';
	$gradeLevel_Text = 'Grade Level';
	$gradeLevel_Constraints = Array(
		'default' => ['G1' => true],
		'pattern' => '/^([G][1-8]$)|(SAT)$/',
		'values' => Array(
			'SAT' => [4298, 3, 17, 'SAT'],
			'G8'  => [638,  3, 16, '8th Grade'],
			'G7'  => [524,  3, 16, '7th Grade'],
			'G6'  => [1001, 3, 17, '6th Grade'],
			'G5'  => [555,  4, 15, '5th Grade'],
			'G4'  => [626,  3, 14, '4th Grade'],
			'G3'  => [448,  3, 12, '3rd Grade'],
			'G2'  => [372,  2, 11, '2nd Grade'],
			'G1'  => [335,  1, 9 , '1st Grade']
		)
	);
	
	$wordCount_ParamName = 'wordCount';
	$wordCount_Text = 'Word Count';
	$wordCount_Constraints = Array(
		'default' => 4,
		'min' => 1,
		'max' => 10
	);
	
	$minLength_ParamName = 'minLength';
	$minLength_Text = 'Minimum Word Length';
	$minLength_Constraints = Array(
		'default' => 3,
		'min' => 1,
		'max' => 17
	);
	
	$maxLength_ParamName = 'maxLength';
	$maxLength_Text = 'Maximum Word Length';
	$maxLength_Constraints = Array(
		'default' => 17,
		'min' => 1,
		'max' => 17
	);
	
	$separator_ParamName = 'separator';
	$separator_Text = 'Word Separator Character(s)';
	$separator_Constraints = Array(
		'default' => ' ',
		'pattern' => '/^.{0,10}$/',
		'maxLength' => 10
	);
	
	$complexity_add_ParamName = 'add';
	$complexity_add_Text = 'Add';
	$complexity_add_Constraints = Array(
		'default' => false
	);
	
	$complexity_a_random_ParamName = 'a_random';
	$complexity_a_random_Text = ' a random ';
	$complexity_a_random_Constraints = Array(
		'default' => 'symbol',
		'values' => Array(
			'symbol',
			'number'
		)
	);
	
	$complexity_to_the_ParamName = 'to_the';
	$complexity_to_the_Text = ' to the ';
	$complexity_to_the_Constraints = Array(
		'default' => 'beginning',
		'values' => Array(
			'beginning',
			'end'
		)
	);
	
	$complexity_of_ParamName = 'of';
	$complexity_of_Text = ' of ';
	$complexity_of_Constraints = Array(
		'default' => 'the password',
		'values' => Array(
			'each word',
			'the password'
		)
	);