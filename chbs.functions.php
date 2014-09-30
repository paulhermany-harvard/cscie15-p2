<?php

    /**
     *  This function will set the http response code to a non-success code (400 or 500)
     *    and write a json response with a detailed error message.
    **/ 
    function SetError($httpStatusCode, $message, $paramName) {
        http_response_code($httpStatusCode);
        $response = array("status" => "error", "message" => "$message", "paramName" => "$paramName");
		header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
	
    /**
     *  This function will set the http response code to 200
     *    and write a json response with a data payload.
    **/
    function SetSuccess($data) {
        http_response_code(200);
        $response = array("status" => "success", "data" => $data);
		header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

	/**
	 *  This function gets the value of the specified parameter
	**/
	function getParameterValue($contextKey) {
		if(isset($_REQUEST[$contextKey])) {
			return $_REQUEST[$contextKey];
		}
		return null;
	}

	/**
	 *  This function gets the integer value of the specified parameter
	 *    and validates the value with the specified min/max constraints.
	 *  If no value is present, the default value is used.
	**/
	function parseParameterValueAsInt($paramName, $default, $min, $max) {
		$usrVal = getParameterValue($paramName);
		if(isset($usrVal)) {
			$iVal = intval($usrVal);
			if((isset($min) && $iVal < $min) || (isset($max) && $iVal > $max)) {
				SetError(400, "Invalid value specified for '$paramName' parameter. Value must be an integer greater than or equal to $min and less than or equal to $max.", $paramName);
			}
			return $iVal;
		}
		return $default;
	}
	
	/**
	 *  This function gets the string value(s) of the specified parameter
	 *    and validates the value with the specified regex pattern constraint.
	 *  If no value is present, the default value is used.
	**/
	function parseParameterValueAsString($paramName, $default, $pattern, $patternDescription) {
		$usrVal = getParameterValue($paramName);
		if(isset($usrVal)) {
			
			if(is_array($usrVal)) {
				$usrArr = $usrVal;
			} else {
				$usrArr = [$usrVal];
			}
			
			foreach($usrArr as $usrArrItem) {
				if(isset($pattern) && !preg_match($pattern, $usrArrItem)) {
					SetError(400, "Invalid value specified for '$paramName' parameter. $patternDescription", $paramName);
				}
			}
			
			return $usrVal;
		}
		return $default;
	}
	
	/**
	 *  This function converts an array to a comma-separated, single-quoted string
	 *    for use in the "in clause" of a SQL statement.
	**/
	function getCsvInClause($items) {
		$csvArr = [];
		foreach($items as $item) {
			array_push($csvArr, "'".$item."'");
		}
		return implode(',', $csvArr);
	}
	