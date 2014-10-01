<?php
    
    // DATABASE CONFIG
    $DB_SERVER   = 'localhost';
    $DB_USERNAME = 'p2user';
    $DB_PASSWORD = 'p2user-pwd-dev';
    $DB_INSTANCE = 'cscie15_p2';
    
    // GRADE LEVEL CONFIG
    $gradeLevel_ParamName = 'gradeLevel';
    $gradeLevel_Text = 'Grade Level';
    $gradeLevel_Constraints = Array(
        'default' => ['G1' => true],
        'pattern' => '/^([G][1-8]$)|(SAT)$/',
        'values' => Array(
            'SAT' => [4298, 3, 17, 'SAT'],
            'G8'  => [638,  3, 16, '8<sup>th</sup>'],
            'G7'  => [524,  3, 16, '7<sup>th</sup>'],
            'G6'  => [1001, 3, 17, '6<sup>th</sup>'],
            'G5'  => [555,  4, 15, '5<sup>th</sup>'],
            'G4'  => [626,  3, 14, '4<sup>th</sup>'],
            'G3'  => [448,  3, 12, '3<sup>rd</sup>'],
            'G2'  => [372,  2, 11, '2<sup>nd</sup>'],
            'G1'  => [335,  1, 9 , '1<sup>st</sup>']
        )
    );
    
    // WORD COUNT CONFIG
    $wordCount_ParamName = 'wordCount';
    $wordCount_Text = 'Word Count';
    $wordCount_Constraints = Array(
        'default' => 4,
        'min' => 1,
        'max' => 10
    );
    
    // MIN LENGTH CONFIG
    $minLength_ParamName = 'minLength';
    $minLength_Text = 'Minimum Word Length';
    $minLength_Constraints = Array(
        'default' => 3,
        'min' => 1,
        'max' => 17
    );
    
    // MAX LENGTH CONFIG
    $maxLength_ParamName = 'maxLength';
    $maxLength_Text = 'Maximum Word Length';
    $maxLength_Constraints = Array(
        'default' => 17,
        'min' => 1,
        'max' => 17
    );
    
    // SEPARATOR CONFIG
    $separator_ParamName = 'separator';
    $separator_Text = 'Word Separator Character(s)';
    $separator_Constraints = Array(
        'default' => ' ',
        'pattern' => '/^.{0,10}$/',
        'maxLength' => 10
    );
    
    // COMPLEXITY CONFIG
    $complexity_Text = 'Complexity';
    
    // .. complexity "add"
    $complexity_add_ParamName = 'add';
    $complexity_add_Text = 'Add';
    $complexity_add_Constraints = Array(
        'default' => false
    );
    
    // .. complexity "a random"
    $complexity_a_random_ParamName = 'a_random';
    $complexity_a_random_Text = ' a random ';
    $complexity_a_random_Constraints = Array(
        'default' => 'symbol',
        'values' => Array(
            'symbol',
            'number'
        )
    );

    // .. complexity "to the"
    $complexity_to_the_ParamName = 'to_the';
    $complexity_to_the_Text = ' to the ';
    $complexity_to_the_Constraints = Array(
        'default' => 'beginning',
        'values' => Array(
            'beginning',
            'end'
        )
    );

    // .. complexity "of"
    $complexity_of_ParamName = 'of';
    $complexity_of_Text = ' of ';
    $complexity_of_Constraints = Array(
        'default' => 'the password',
        'values' => Array(
            'each word',
            'the password'
        )
    );
    