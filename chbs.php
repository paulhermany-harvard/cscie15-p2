<?php

	require 'chbs.config.php';
	require 'chbs.functions.php';
	
	// parse gradeLevel value
	$m_gradeLevel = parseParameterValueAsString(
		$m_gradeLevel_ParamName,
		$m_gradeLevel_Constraints['default'],
		$m_gradeLevel_Constraints['pattern'],
		$m_gradeLevel_Constraints['patternDescription']
	);
	
	$relMinLength = $m_minLength_AbsoluteMin;
	$relMaxLength = $m_maxLength_AbsoluteMax;
	
	if(isset($m_gradeLevel)) {
	
		if(!is_array($m_gradeLevel)) {
			$m_gradeLevel = [$m_gradeLevel];
		}
	
		$relMinLength = $m_maxLength_AbsoluteMax;
		$relMaxLength = $m_minLength_AbsoluteMin;
	
		foreach($m_gradeLevel as $key) {
			$values = $m_gradeLevel_Stats[$key];
			if($values[1] < $relMinLength) { $relMinLength = $values[1]; }
			if($values[2] > $relMaxLength) { $relMaxLength = $values[2]; }
		}
	}
	
	// parse maxLength value
	$m_maxLength = parseParameterValueAsInt(
		$m_maxLength_ParamName,
		$relMaxLength,
		$relMinLength, 
		$relMaxLength
	);
	
	// parse minLength value
	$m_minLength = parseParameterValueAsInt(
		$m_minLength_ParamName,
		$relMinLength,
		$relMinLength, 
		$relMaxLength
	);
	
	// validate min/max length to make sure the maximum is not less than then minimum
	if($m_maxLength < $m_minLength) {
		SetError(400, "Invalid values specified for minimum and maximum word length. Maximum length must be greater than or equal to minimum length.");
	}
	
	// parse separator value
	$m_separator = parseParameterValueAsString(
		$m_separator_ParamName,
		$m_separator_Constraints['default'],
		$m_separator_Constraints['pattern'],
		$m_separator_Constraints['patternDescription']
	);
	
	// parse wordCount value
	$m_wordCount = parseParameterValueAsInt(
		$m_wordCount_ParamName, 
		$m_wordCount_Constraints['default'],
		$m_wordCount_Constraints['min'], 
		$m_wordCount_Constraints['max']
	);
	
	// SQL injection
	$gradeLevelInjection = !isset($m_gradeLevel) ? "" : 
		" and level in (" . getCsvInClause($m_gradeLevel) . ")";
		
	// SQL injection
	$lengthRangeInjection = ($m_minLength == $relMinLength && $m_maxLength == $relMaxLength) ? "" : 
		" and (length(word) >= " . $m_minLength . " and length(word) <= " . $m_maxLength . ")";

		
	// connect to mysql database
    $mysqli = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_INSTANCE);

    // handle connection errors
    if ($mysqli->connect_errno) {
        SetError(500, "Unable to connect to database.");
    }
	
    // get the maximum id which is used to choose a random id
    $sql = "select max(id) from words where 1=1" . $gradeLevelInjection . $lengthRangeInjection . ";";
	
	$stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($m_maxid);
    if(!$stmt->fetch()) {
		// unable to query database
    }
    $stmt->close();
	
    $words = [];
	
    // get a "random" word with the desired grade level
    // (pick the first word on or after the randomly chosen id)
    $sql = "select word from words where id >= ?" . $gradeLevelInjection . $lengthRangeInjection . " limit 1;";
	$stmt = $mysqli->prepare($sql);
    for ($i = 0; $i < $m_wordCount; $i++) {
    
        // choose the random id
        $id = mt_rand(0, $m_maxid - 1);

		$stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($word);
        
        $stmt->fetch();
        
        array_push($words, $word);
    }
    $stmt->close();
    $mysqli->close();

	$password = implode($m_separator, $words);
	
	SetSuccess($password);
