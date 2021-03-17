<?
class GenericDataViewer extends GenericEventClass {

	protected $db;

	private $FOnPrepareData = '';
	private $FOnBeginData = '';
	private $FOnShowData = '';
	private $FOnEndData = '';
	private $FOnEmptyData = '';

	function __construct($aHost,$aDatabase,$aUsername,$aPassword) { 
		
		$this->db = new GenericDbViewer($aHost,$aDatabase,$aUsername,$aPassword);
	}

	function __destruct() { 

	}

	function setOnPrepareData($aValue) {

		if (is_string($aValue)) {
			$this->FOnPrepareData = $aValue;
		}
	
	}

	function setOnBeginData($aValue) {

		if (is_string($aValue)) {
			$this->FOnBeginData = $aValue;
		}
	
	}

	function setOnShowData($aValue) {

		if (is_string($aValue)) {
			$this->FOnShowData = $aValue;
		}
	
	}

	function setOnEndData($aValue) {

		if (is_string($aValue)) {
			$this->FOnEndData = $aValue;
		}
	
	}

	function setOnEmptyData($aValue) {

		if (is_string($aValue)) {
			$this->FOnEmptyData = $aValue;
		}
	
	}

	function Show() {

		$rs = $this->DispachEvent($this->FOnPrepareData);

		if ($rs ) {

			$this->DispachEvent($this->FOnBeginData);

			do {

				$this->DispachEvent($this->FOnShowData,$rs);
				
			} while ($rs = $this->db->sqlFetch());

			$this->DispachEvent($this->FOnEndData);

		} else {

			$this->DispachEvent($this->FOnEmptyData);

		}


	}

}

?>