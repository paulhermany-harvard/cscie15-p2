<?php

    require 'index.config.php';

    // PARSE GRADE LEVEL
    // - valid values for grade level include G1, G2, G3, ..., G8, SAT
    // - these values are validated via a regular expression
    // - if the grade level cannot be validated, the default value is used
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
    
    // Find the relative minimum/maximum length based on selected grade level.
    // Ex: the minimum length of the set of SAT words is 3,
    //       while the minimum length for G1 words is 1.
    if(count($gradeLevel) == 0) {
        $relMin = $minLength_Constraints['min'];
        $relMax = $maxLength_Constraints['max'];
    } else {
        // start from the opposite min/max value
        //   and work towards the relative min/max value
        $relMin = $minLength_Constraints['max'];
        $relMax = $minLength_Constraints['min'];
        
        // iterate through the grade level array,
        //   get the constraints for each level,
        //   and adjust relative min/max
        foreach($gradeLevel as $key => $value) {
            $min = $gradeLevel_Constraints['values'][$key][1];
            $max = $gradeLevel_Constraints['values'][$key][2];
        
            if($min < $relMin) { $relMin = $min; }
            if($max > $relMax) { $relMax = $max; }
        }
    }
    
    // PARSE WORD COUNT
    // - valid values include integers between 1 and 10 inclusive
    // - if the word count cannot be validated, the default value is used
    $wordCount = $wordCount_Constraints['default'];
    if(isset($_REQUEST[$wordCount_ParamName])) {
        $usr_wordCount = $_REQUEST[$wordCount_ParamName];
        $ival = intval($usr_wordCount);
        if($ival >= $wordCount_Constraints['min'] && $ival <= $wordCount_Constraints['max']) {
            $wordCount = $ival;
        }
    }
    
    // PARSE MINIMUM WORD LENGTH
    // - valid values include integers within the relative min/max based on grade level
    // - if the minimum length cannot be validated, the default relative min is used
    $minLength = $relMin;
    if(isset($_REQUEST[$minLength_ParamName])) {
        $usr_minLength = $_REQUEST[$minLength_ParamName];
        $ival = intval($usr_minLength);
        if($ival >= $relMin && $ival <= $relMax) {
            $minLength = $ival;
        }
    }

    // PARSE MAXIMUM WORD LENGTH
    // - valid values include integers greater than or equal to the minimum length
    //     and within the relative min/max based on grade level
    // - if the maximum length cannot be validated, the default relative max is used
    //     (this should be greater than or equal to the minimum length)
    $maxLength = $relMax;
    if(isset($_REQUEST[$maxLength_ParamName])) {
        $usr_maxLength = $_REQUEST[$maxLength_ParamName];
        $ival = intval($usr_maxLength);
        if($ival >= $relMin && $ival <= $relMax && $ival >= $minLength) {
            $maxLength = $ival;
        }
    }
    
    // PARSE SEPARATOR CHARACTER(S)
    // - valid values include any string of 10 characters or less
    //     (validated via regular expression)
    // - if the separator cannot be validated, the default separator is used
    $separator = $separator_Constraints['default'];
    if(isset($_REQUEST[$separator_ParamName])) {
        $usr_separator = $_REQUEST[$separator_ParamName];
        if(preg_match($separator_Constraints['pattern'], $usr_separator)) {
            $separator = $usr_separator;
        }
    }
    
    // PARSE COMPLEXITY
    
    // .. parse "add"
    // - a boolean value indicating that complexity characters should be used
    $complexity_add = $complexity_add_Constraints['default'];
    if(isset($_REQUEST[$complexity_add_ParamName])) {
        $complexity_add = true;
    }
    
    // .. parse "a random"
    // - "symbol" or "number"
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
    // - "beginning" or "end"
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
    // - "each word" or "the password"
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
    //   so this type of SQL injection should be safe
    $gradeLevelInjection = '';
    if(count($gradeLevel) > 0) {
        $csv = [];
        // iterate through the grade levels and add the single-quoted value to the csv array
        foreach($gradeLevel as $key => $value) {
            array_push($csv, "'".$key."'");
        }
        // implode the csv array and create the injection statement
        $gradeLevelInjection = ' and level in (' . implode(',', $csv) . ')';
    }
        
    // SQL injection for length range
    // the injected values have already been validated via intval
    //   so this type of SQL injection should be safe
    $lengthRangeInjection = ($minLength == $relMin && $maxLength == $relMax) ? "" : 
        " and (length(word) >= " . $minLength . " and length(word) <= " . $maxLength . ")";
        
    // connect to mysql database
    $mysqli = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_INSTANCE);

    // handle connection errors
    if ($mysqli->connect_errno) {
        // Unable to connect to database
        // - no error handling here, just fail miserably
    }
    
    // get the maximum id which is used to choose a random id
    $sql = "select max(id) from words where 1=1" . $gradeLevelInjection . $lengthRangeInjection . ";";
    
    $stmt = $mysqli->prepare($sql);

    // bind and execute
    // no parameters to bind
    $stmt->execute();
    $stmt->bind_result($maxid);
    $stmt->fetch();
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
    
    // function to generate a random character of the specified type ("symbol" or "number")
    // calls the following functions:
    //   generateRandomNumber
    //   generateRandomSymbol
    function generateRandomCharacter($type) {
        switch($type) {
            case 'symbol': return generateRandomSymbol(); break;
            case 'number': return generateRandomNumber(); break;
        }
    }

    // function to generate a random number based on ASCII code
    function generateRandomNumber() {
        return chr(mt_rand(48, 57));
    }   

    // function to generate a random symbol based on ASCII code
    function generateRandomSymbol() {
        $r = mt_rand(0, 3);
        switch($r) {
            case 0: $i = mt_rand(33, 47); break;
            case 1: $i = mt_rand(58, 64); break;
            case 2: $i = mt_rand(91, 96); break;
            case 3: $i = mt_rand(123, 126); break;
        }
        return chr($i);
    }
    
    // add password complexity based on selected options
    if($complexity_add == true) {
        // choose whether to prepend or append the character
        switch($complexity_to_the) {
            case 'beginning': $prepend = true; break;
            case 'end': $prepend = false; break;
        }
        // choose the location at which to prepend/append the character
        switch($complexity_of) {
            case 'each word':       
                for($i = 0; $i < count($words); $i++) {
                    $c = generateRandomCharacter($complexity_a_random);
                    $words[$i] = $prepend ? ($c.$words[$i]) : ($words[$i].$c);
                    $password = implode($separator, $words);
                }
                break;
            case 'the password':
                $c = generateRandomCharacter($complexity_a_random);
                $password = $prepend ? ($c.$password) : ($password.$c);
                break;
        }
    }

    // $password contains the generated password    
    $password = htmlentities($password);
