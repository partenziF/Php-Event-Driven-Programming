<?

require_once('GenericEventObject.php');

class CustomEventClass extends GenericEventClass {


	private $FOnCustomBeginShow = '';
	private $FOnCustomShowValue = '';
	private $FOnCustomEndShow = '';
	private $Value;

	function __construct($aValue) { 
		$this->Value = $aValue;
	}
	
	function __destruct() { }

	function setOnCustomBeginShow($aValue) {

		if (is_string($aValue)) {
			$this->FOnCustomBeginShow = $aValue;
		}
	
	}

	function setOnCustomEndShow($aValue) {

		if (is_string($aValue)) {
			$this->FOnCustomEndShow = $aValue;
		}
	
	}


	function setOnCustomShowValue($aValue) {

		if (is_string($aValue)) {
			$this->FOnCustomShowValue = $aValue;
		}
		
	}

	function Show() {

		$this->DispachEvent($this->FOnCustomBeginShow);

		$this->DispachEvent($this->FOnCustomShowValue,$this->Value);

		$this->DispachEvent($this->FOnCustomEndShow);

	}


}


class MyCustomClass extends CustomEventClass {


	function __construct($aValue) { 

		parent::__construct($aValue);
		$this->setOnCustomBeginShow('CustomBeginShow');
		$this->setOnCustomShowValue('CustomShowValue');
		$this->setOnCustomEndShow('CustomEndShow');
	}


	function CustomBeginShow() {
		echo 'Il valore della proprietà è: <b><i>';
	}

	function CustomShowValue($aValue) {
		echo $aValue;
	}

	function CustomEndShow() {
		echo '</b></i><br>Fine della visualizzazione';
	}

}

function MyBeginShow() {
	echo 'Il valore della proprietà è: <b>';
}


function MyShowValue($self,$aValue) {
	echo $aValue;
}

function MyEndShow() {
	echo '</b><br>Fine della visualizzazione<br/>';

}


echo '<html>';
echo '<body>';


$MyCustomEventObject = new CustomEventClass(123);
$MyCustomEventObject->setOnCustomBeginShow('MyBeginShow');
$MyCustomEventObject->setOnCustomEndShow('MyEndShow');
$MyCustomEventObject->setOnCustomShowValue('MyShowValue');


$MyCustomEventObject->Show();


$MyCustomObject = new MyCustomClass(456);
$MyCustomObject->Show();

echo '</body>';
echo '</html>';

?>