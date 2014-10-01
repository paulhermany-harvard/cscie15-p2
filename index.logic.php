<?php

    require 'index.config.php';

    // PARSE GRADE LEVEL
    $gradeLevel = $gradeLevel_Constraints['default'];
    if(isset($_REQUEST[$gradeLevel_ParamName])) {
        $usr_gradeLevelArr = $_REQUEST[$gradeLevel_ParamName];
        if(is_array($usr_gradeLevelArr)) {
            foreach($usr_gradeLevelArr as $usr_gradeLevel) {                
                if(preg_match($gradeLevel_Constraints['pattern'], $usr_gradeLevel)) {
                    $gradeLevel[$usr_gradeLevel] = true;
                }
            }
        }
    }
    
    // find the relative minimum/maximum length based on selected grade level
    if(count($gradeLevel) == 0) {
        $relMin = $minLength_Constraints['min'];
        $relMax = $maxLength_Constraints['max'];
    } else {
        $relMin = $minLength_Constraints['max'];
        $relMax = $minLength_Constraints['min'];
            
        foreach($gradeLevel as $key => $value) {
            $min = $gradeLevel_Constraints['values'][$key][1];
            $max = $gradeLevel_Constraints['values'][$key][2];
        
            if($min < $relMin) { $relMin = $min; }
            if($max > $relMax) { $relMax = $max; }
        }
    }
    
    // PARSE WORD COUNT
    $wordCount = $wordCount_Constraints['default'];
    if(isset($_REQUEST[$wordCount_ParamName])) {
        $usr_wordCount = $_REQUEST[$wordCount_ParamName];
        $ival = intval($usr_wordCount);
        if($ival >= $wordCount_Constraints['min'] && $ival <= $wordCount_Constraints['max']) {
            $wordCount = $ival;
        }
    }
    
    // PARSE MINIMUM WORD LENGTH
    $minLength = $relMin;
    if(isset($_REQUEST[$minLength_ParamName])) {
        $usr_minLength = $_REQUEST[$minLength_ParamName];
        $ival = intval($usr_minLength);
        if($ival >= $relMin && $ival <= $relMax) {
            $minLength = $ival;
        }
    }

    // PARSE MAXIMUM WORD LENGTH
    $maxLength = $relMax;
    if(isset($_REQUEST[$maxLength_ParamName])) {
        $usr_maxLength = $_REQUEST[$maxLength_ParamName];
        $ival = intval($usr_maxLength);
        if($ival >= $relMin && $ival <= $relMax && $ival >= $minLength) {
            $maxLength = $ival;
        }
    }
    
    // PARSE SEPARATOR CHARACTER(S)
    $separator = $separator_Constraints['default'];
    if(isset($_REQUEST[$separator_ParamName])) {
        $usr_separator = $_REQUEST[$separator_ParamName];
        if(preg_match($separator_Constraints['pattern'], $usr_separator)) {
            $separator = $usr_separator;
        }
    }
    
    // PARSE COMPLEXITY
	
	// .. parse "add"
    $complexity_add = $complexity_add_Constraints['default'];
    if(isset($_REQUEST[$complexity_add_ParamName])) {
        $complexity_add = true;
    }
    
	// .. parse "a random"
    $complexity_a_random = $complexity_a_random_Constraints['default'];
    if(isset($_REQUEST[$complexity_a_random_ParamName])) {
        $usr_complexity_a_random = $_REQUEST[$complexity_a_random_ParamName];
        foreach($complexity_a_random_Constraints['values'] as $value) {
            if($usr_complexity_a_random == $value) {
                $complexity_a_random = $value;
                break;
            }
        }
    }

	// .. parse "to the"
    $complexity_to_the = $complexity_to_the_Constraints['default'];
    if(isset($_REQUEST[$complexity_to_the_ParamName])) {
        $usr_complexity_to_the = $_REQUEST[$complexity_to_the_ParamName];
        foreach($complexity_to_the_Constraints['values'] as $value) {
            if($usr_complexity_to_the == $value) {
                $complexity_to_the = $value;
                break;
            }
        }
    }

	// .. parse "of"
    $complexity_of = $complexity_of_Constraints['default'];
    if(isset($_REQUEST[$complexity_of_ParamName])) {
        $usr_complexity_of = $_REQUEST[$complexity_of_ParamName];
        foreach($complexity_of_Constraints['values'] as $value) {
            if($usr_complexity_of == $value) {
                $complexity_of = $value;
                break;
            }
        }
    }   
    
    // SQL injection for grade level
	// the injected values have already been validated via regular expression
    $gradeLevelInjection = '';
    if(count($gradeLevel) > 0) {
        $csv = [];
        foreach($gradeLevel as $key => $value) {
            array_push($csv, "'".$key."'");
        }
        $gradeLevelInjection = ' and level in (' . implode(',', $csv) . ')';
    }
        
    // SQL injection for length range
	// the injected values have already been validated via intval
    $lengthRangeInjection = ($minLength == $relMin && $maxLength == $relMax) ? "" : 
        " and (length(word) >= " . $minLength . " and length(word) <= " . $maxLength . ")";
        
    // connect to mysql database
    $mysqli = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_INSTANCE);

    // handle connection errors
    if ($mysqli->connect_errno) {
        // Unable to connect to database
    }
    
    // get the maximum id which is used to choose a random id
    $sql = "select max(id) from words where 1=1" . $gradeLevelInjection . $lengthRangeInjection . ";";
    
    $stmt = $mysqli->prepare($sql);

	// bind and execute
    $stmt->execute();
    $stmt->bind_result($maxid);
    if(!$stmt->fetch()) {
        // unable to query database
    }
    $stmt->close();
    
	// store the generated words in an array for later processing
    $words = [];
    
    // get a "random" word with the desired grade level
    // (pick the first word on or after the randomly chosen id)
    $sql = "select word from words where id >= ?" . $gradeLevelInjection . $lengthRangeInjection . " limit 1;";
    $stmt = $mysqli->prepare($sql);
    for ($i = 0; $i < $wordCount; $i++) {
    
        // choose the random id
        $id = mt_rand(0, $maxid - 1);

		// bind and execute
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($word);
        
        $stmt->fetch();
        
		// add the word to the array
        array_push($words, $word);
    }
    $stmt->close();
    $mysqli->close();

	// generate a plain password (no complexity)
    $password = implode($separator, $words);
    
	// add password complexity based on selected options
    if($complexity_add == true) {
		// choose character based on ASCII code
        switch($complexity_a_random) {
            case 'symbol':
                $r = mt_rand(0, 3);
                switch($r) {
                    case 0: $i = mt_rand(33, 47); break;
                    case 1: $i = mt_rand(58, 64); break;
                    case 2: $i = mt_rand(91, 96); break;
                    case 3: $i = mt_rand(123, 126); break;
                }
                $c = chr($i);
                break;
            case 'number': $c = chr(mt_rand(48, 57)); break;
        }
		// choose whether to prepend or append the character
        switch($complexity_to_the) {
            case 'beginning': $prepend = true; break;
            case 'end': $prepend = false; break;
        }
		// choose the location at which to prepend/append the character
        switch($complexity_of) {
            case 'each word':       
                for($i = 0; $i < count($words); $i++) {
                    $words[$i] = $prepend ? ($c.$words[$i]) : ($words[$i].$c);
                    $password = implode($separator, $words);
                }
                break;
            case 'the password':
                $password = $prepend ? ($c.$password) : ($password.$c);
                break;
        }
    }

	// $password contains the generated password	
	$password = htmlentities($password);
