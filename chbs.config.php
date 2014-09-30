<?php

    // database config
    $DB_SERVER   = 'localhost';
    $DB_USERNAME = 'p2user';
    $DB_PASSWORD = 'p2user-pwd-dev';
    $DB_INSTANCE = 'cscie15_p2';

	// gradeLevel config
	$m_gradeLevel_ParamName = 'gradeLevel';
	$m_gradeLevel_Constraints = Array(
		'default' => null,
		'pattern' => '/^([G][1-8]$)|(SAT)$/',
		'patternDescription' => 'Valid values: G1, G2, ..., G8, SAT'
	);
	$m_gradeLevel_Stats = Array(
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
	
	// maxLength config
	$m_maxLength_ParamName = 'maxLength';
	$m_maxLength_AbsoluteMax = 17;
	
	// minLength config
	$m_minLength_ParamName = 'minLength';
	$m_minLength_AbsoluteMin = 1;
	
	// separator config
	$m_separator_ParamName = 'separator';
	$m_separator_Constraints = Array(
		'default' => ' ',
		'pattern' => '/^[^$]{0,10}$/',
		'patternDescription' => 'Maximum of 10 characters. Restricted chars: [$]'
	);
	
	// wordCount config
	$m_wordCount_ParamName = 'wordCount';
	$m_wordCount_Constraints = Array(
		'default' => 4,
		'min' => 1,
		'max' => 10
	);