<?php
    // database config
    $DB_SERVER   = 'localhost';
    $DB_USERNAME = 'p2user';
    $DB_PASSWORD = 'p2user-pwd-dev';
    $DB_INSTANCE = 'cscie15_p2';
	
	// set the parameter names for the form vars
	$FORM_GET_Key_wordCount = 'iwc';
	$FORM_GET_Key_minLength = 'inl';
	$FORM_GET_Key_maxLength = 'ixl';
	$FORM_GET_Key_gradeLevel = 'sgl';
	$FORM_GET_Key_separator = 'sss';
	
    // parameter defaults
    $DEFAULT_WORDCOUNT = 4;
	$DEFAULT_MAXLENGTH = 17;
    $DEFAULT_MINLENGTH = 1;
    $DEFAULT_GRADELEVEL = '*';
	$DEFAULT_SEPARATOR = ' ';
    
    // parameter constraints
    $MAX_WORDCOUNT = 10;
    $MAX_LENGTH = 17;
	
	$UI_gradeLevels = Array(
		'SAT' => 'SAT',
		'G8' => '8<sup>th</sup>',
		'G7' => '7<sup>th</sup>',
		'G6' => '6<sup>th</sup>',
		'G5' => '5<sup>th</sup>',
		'G4' => '4<sup>th</sup>',
		'G3' => '3<sup>rd</sup>',
		'G2' => '2<sup>nd</sup>',
		'G1' => '1<sup>st</sup>'
	);
	
	//
	/*

	*/
	
	/**
	 *	set grade level statistics
	 *  these stats are used in the UI layer to limit numeric values as grade levels are selected
	 *  SQL: select level, count(word) count, min(length(word)) minLength, max(length(word)) maxLength from words group by level;
	 *       +-------+-------+-----------+-----------+
	 *       | level | count | minLength | maxLength |
	 *       +-------+-------+-----------+-----------+
	 *       | G1    |   335 |         1 |         9 |
	 *       | G2    |   372 |         2 |        11 |
	 *       | G3    |   448 |         3 |        12 |
	 *       | G4    |   626 |         3 |        14 |
	 *       | G5    |   555 |         4 |        15 |
	 *       | G6    |  1001 |         3 |        17 |
	 *       | G7    |   524 |         3 |        16 |
	 *       | G8    |   638 |         3 |        16 |
	 *       | SAT   |  4298 |         3 |        17 |
	 *       +-------+-------+-----------+-----------+
	**/
	$UI_gradeLevelStats = Array(
		'SAT' => [4298, 3, 17],
		'G8'  => [638,  3, 16],
		'G7'  => [524,  3, 16],
		'G6'  => [1001, 3, 17],
		'G5'  => [555,  4, 15],
		'G4'  => [626,  3, 14],
		'G3'  => [448,  3, 12],
		'G2'  => [372,  2, 11],
		'G1'  => [335,  1, 9 ]
	);