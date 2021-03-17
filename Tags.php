<?

	function implode_params($aSeparator,$aParams) {
	
		$result = array();

		foreach ($aParams as $Key => $Value) {

			if (is_null($Value)) { $result[] = $Key; } 
			else { $result[] = $Key.'="'.$Value.'"'; }

		}

		return implode($aSeparator,$result);

	}

	function implode_css_style($aStyles) {

		$result = array();

		foreach ($aStyles as $Key => $Value) {

			if (is_null($Value)) { $result[] = $Key; } 
			else { $result[] = $Key.':'.$Value; }

		}

		return implode(';',$result);

	}

	function implode_url_params($aParams) {

		$result = array();

		foreach ($aParams as $Key => $Value) {

			if ($Key == '#') {

				$anchor= $Key.$Value;

			} else {

				if (is_null($Value)) { $result[] = $Key; } 
				else { $result[] = $Key.'='.urlencode($Value); }

			}

		}

		return implode('&',$result).$anchor;
	}


function openTag($aTagName,$aParamList=null,$aInnerText=null,$haveChild=true,$isClosed=false) {

	return echoTag($aTagName,$aParamList,$aInnerText,true,$haveChild,$isClosed);
}

function closeTag($aTagName,$aInnerText = null) {

	return echoTag($aTagName,null,$aInnerText,false,false,false);
}

function echoTag($aTagName,$aParamList,$aInnerText,$isOpen,$haveChild,$isClosed) {

	$result = '';

	$aInnerText = (htmlentities($aInnerText));
	$aInnerText = str_replace(array('\r\n',"\r\n", "\n", "\r"), '<br/>', $aInnerText);


	if (!empty($aParamList)) {

		if (is_array($aParamList)) {
			$StringParams = implode_params(' ',$aParamList);
		} else {
			$StringParams = $aParamList;
		}

	}

	if ($haveChild) {
		if ($isOpen) {

			if (!empty($StringParams)) { $result .= "<{$aTagName} {$StringParams}>{$aInnerText}"; }
			else { $result .= "<{$aTagName}>{$aInnerText}"; }
		} else {
			$result .= "{$aInnerText}</{$aTagName}>\r\n";
		}
		
		if ($isClosed) { $result .= "</{$aTagName}>\r\n";	}

	} else {

		if ($isOpen) {

			if (empty($aInnerText)) {
				if (!empty($StringParams)) { $result .= "<{$aTagName} {$StringParams}/>\r\n"; }
				else { $result .= "<{$aTagName}/>\r\n";}
			} else {
				if (!empty($StringParams)) { $result .= "<{$aTagName} {$StringParams}/>{$aInnerText}\r\n"; }
				else {$result .= "<{$aTagName}/>{$aInnerText}\r\n";}
			}
			
			if ($isClosed) { $result .= "</{$aTagName}>\r\n";	}

		} else {

			$result .= "</{$aTagName}>\r\n";

		}
	}

	

	return $result;

}

?>