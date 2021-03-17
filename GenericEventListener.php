<?

require_once('GenericEventObject.php');

class GenericEventListener extends GenericEventClass {

	private $MesssageQueue;


	function __construct() { 
		$this->MesssageQueue = array();
	}

	function __destruct() { }


	function SendMessage($aMessage,$aHandler,$aMessageParams) { // Elabora il messaggio immediatamente e scavalca i precedenti in lista

		$theMessage = array();
		$theMessage[$aMessage] = array(	'MessageParams' => $aMessageParams,
										'Handler' => $aHandler);
		array_unshift($this->MesssageQueue,$theMessage);

	}

	function PostMessage($aMessage,$aHandler,$aMessageParams) { //PostMessage aggiunge un messaggio in coda ed aspetta che vengano elaborati i precedenti
		$theMessage = array();
		$theMessage[$aMessage] = array(	'MessageParams' => $aMessageParams,
										'Handler' => $aHandler);
		array_push($this->MesssageQueue,$theMessage);
	}

	
	function getMessage() {
		return array_shift($this->MesssageQueue);
	}

	function ProcessMessages() {

		while (!empty($this->MesssageQueue)) {

			$theMessage = $this->getMessage();

			$theMessageID = key($theMessage);

			if (!is_null($theMessage)) {

				$this->DispachEvent($theMessage[$theMessageID]['Handler'],$theMessage[$theMessageID]['MessageParams']);

			}

		}

	}

}


?>