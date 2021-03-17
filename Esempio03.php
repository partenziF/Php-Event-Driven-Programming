<?

require_once('GenericEventListener.php');

class CustomEventListener extends GenericEventListener {


	function handler_MSG_CUSTOM($aString,$aNumber) {
		echo "<p>";
		echo "function ".__FUNCTION__." handled with params: ";
		var_dump(func_get_args());
		echo "<br>";
		$this->PostMessage('MSG_DEFAULT','handler_MSG_DEFAULT',array('stringa2',321));
		echo "</p>";
	}


	function handler_MSG_DEFAULT($aString,$aNumber) {
		echo "<p>";
		echo "function ".__FUNCTION__." handled with params: ";
		var_dump(func_get_args());
		echo "<br>";
		echo "</p>";
	}

}


$CustomEventListener = new CustomEventListener();

$CustomEventListener->PostMessage('MSG_CUSTOM','handler_MSG_CUSTOM',array('stringa',1));


$CustomEventListener->ProcessMessages();

?>