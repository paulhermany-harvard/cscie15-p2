<?php
	// set word count
    $m_wordCount = $DEFAULT_WORDCOUNT;
	if(isset($_GET[$FORM_GET_Key_wordCount])) {
		$usr_wordCount = $_GET[$FORM_GET_Key_wordCount];
        $m_wordCount = intval($usr_wordCount);
        if($m_wordCount < 1 || $m_wordCount > $MAX_WORDCOUNT) {
			$m_wordCount = $DEFAULT_WORDCOUNT;
        }
    }
	
    // set minimum length
    $m_minLength = $DEFAULT_MINLENGTH;
    if(isset($_GET[$FORM_GET_Key_minLength])) {
    $usr_minLength = $_GET[$FORM_GET_Key_minLength];
		$m_minLength = intval($usr_minLength);
        if($m_minLength < 1 || $m_minLength > $MAX_LENGTH) {
			$m_minLength = $DEFAULT_MINLENGTH;
        }
    }
	
    // set maximum length
    $m_maxLength = $DEFAULT_MAXLENGTH;
    if(isset($_GET[$FORM_GET_Key_maxLength])) {
		$usr_maxLength = $_GET[$FORM_GET_Key_maxLength];
		$m_maxLength = intval($usr_maxLength);
        if($m_maxLength < $m_minLength || $m_maxLength > $MAX_LENGTH) {
			$m_maxLength = $DEFAULT_MAXLENGTH;
        }
    }

	// set length range filter flag
	$m_lengthRangeFilter = ($m_minLength != $DEFAULT_MINLENGTH || $m_maxLength != $DEFAULT_MAXLENGTH);
	
    // set grade level
    $m_gradeLevel = $DEFAULT_GRADELEVEL;
	$m_gradeLevelArr = [];
    if(isset($_GET[$FORM_GET_Key_gradeLevel])) {
		$usr_gradeLevelArr = $_GET[$FORM_GET_Key_gradeLevel];
		foreach($usr_gradeLevelArr as $usr_gradeLevel) {
			if(preg_match("/^([G][1-8]{1}$)|(SAT$)/", $usr_gradeLevel)) {
				$m_gradeLevelArr[$usr_gradeLevel] = "'".$usr_gradeLevel."'";
			}	
		}
	}
	
	if(count($m_gradeLevelArr) > 0) {
		$m_gradeLevel = implode(',', $m_gradeLevelArr);
	} else {
		$m_gradeLevel = $DEFAULT_GRADELEVEL;
	}
	
	// set separator
    $m_separator = $DEFAULT_SEPARATOR;
	if(isset($_GET[$FORM_GET_Key_separator])) {
		$m_separator = $_GET[$FORM_GET_Key_separator];
    }
	
	// connect to mysql database
    $mysqli = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_INSTANCE);

    // handle connection errors
    if ($mysqli->connect_errno) {
        // TODO: handle "unable to connect to database" error
    }
	
    // get the maximum id which is used to choose a random id
    $sql = "select max(id) from words where 1=1" . ($m_gradeLevel != "*" ? " and level in (" . $m_gradeLevel . ")" : "") . ($m_lengthRangeFilter ? " and (length(word) >= ? and length(word) <= ?)" : "") . ";";
	
	$stmt = $mysqli->prepare($sql);
    if($m_lengthRangeFilter) {
        $stmt->bind_param("ii", $m_minLength, $m_maxLength);
    }
    $stmt->execute();
    $stmt->bind_result($m_maxid);
    if(!$stmt->fetch()) {
		// unable to query database
    }
    $stmt->close();
	
    $words = [];
	
    // get a "random" word with the desired grade level
    // (pick the first word on or after the randomly chosen id)
    $sql = "select word from words where id >= ?" . ($m_gradeLevel != "*" ? " and level in (" . $m_gradeLevel . ")" : "") . ($m_lengthRangeFilter ? " and (length(word) >= ? and length(word) <= ?)" : "") . " limit 1;";
	$stmt = $mysqli->prepare($sql);
    for ($i = 0; $i < $m_wordCount; $i++) {
    
        // choose the random id
        $id = mt_rand(0, $m_maxid - 1);

        if($m_lengthRangeFilter) {
            $stmt->bind_param("iii", $id, $m_minLength, $m_maxLength);
        } else {
            $stmt->bind_param("i", $id);
        }
        $stmt->execute();
        $stmt->bind_result($word);
        
        $stmt->fetch();
        
        array_push($words, $word);
    }
    $stmt->close();
    $mysqli->close();

	$password = implode($m_separator, $words);