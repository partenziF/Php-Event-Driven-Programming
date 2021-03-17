<?

require_once('GenericDbViewer.php');
require_once('GenericDataViewer.php');




class  CustomTableViewer extends GenericDataViewer {

	function __construct() { 
		
		parent::__construct('localhost','test','test','TEST');
		$this->setOnPrepareData('CustomOnPrepareData');
		$this->setOnBeginData('CustomOnBeginData');
		$this->setOnShowData('CustomOnShowData');
		$this->setOnEndData('CustomOnEndData');
		$this->setOnEmptyData('CustomOnEmptyData');
	}

	function CustomOnPrepareData() {	
		return $this->db->sqlSelect("SELECT * FROM utenti");
	}

	function CustomOnBeginData() {	
		echo '<table border="1" cellpadding="4" cellspacing="2">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Nome</th>';
		echo '<th>Cognome</th>';
		echo '<th>Valore</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	}

	function CustomOnShowData($P_Utente,$Nome,$Cognome,$Valore,$Cancellato) {	

		echo '<tr>';
		echo '<td>';echo $Nome;echo '</td>';
		echo '<td>';echo $Cognome;echo '</td>';
		echo '<td>';echo $Valore;echo '</td>';
		echo '</tr>';
	}

	function CustomOnEndData() {	

		echo '</tbody>';
		echo '</table>';

	}

	function CustomOnEmptyData() {

		echo '<p>Non ci sono dati</p>';

	}

	function __destruct() { 

	}

}


class  CustomListViewer extends GenericDataViewer {

	function __construct() { 
		
		parent::__construct('localhost','test','test','TEST');
		$this->setOnPrepareData('CustomOnPrepareData');
		$this->setOnBeginData('CustomOnBeginData');
		$this->setOnShowData('CustomOnShowData');
		$this->setOnEndData('CustomOnEndData');
		$this->setOnEmptyData('CustomOnEmptyData');
	}

	function CustomOnPrepareData() {	
		return $this->db->sqlSelect("SELECT * FROM utenti");
	}

	function CustomOnBeginData() {	

		echo '<ul>';

	}

	function CustomOnShowData($P_Utente,$Nome,$Cognome,$Valore,$Cancellato) {	

		echo '<li>';
		echo '<p>';echo $Nome;echo '</p>';
		echo '<p>';echo $Cognome;echo '</p>';
		echo '<p>';echo $Valore;echo '</p>';
		echo '</li>';
	}

	function CustomOnEndData() {	

		echo '</ul>';

	}

	function CustomOnEmptyData() {

		echo '<p>Non ci sono dati</p>';

	}

	function __destruct() { 

	}

}


$MyCustomTableViewer = new CustomTableViewer();
$MyCustomTableViewer->Show();

$MyCustomListViewer = new CustomListViewer();
$MyCustomListViewer->Show();


/*

$db = new GenericDbViewer('localhost','test','test','TEST');

$rs = $db->sqlSelect("SELECT * FROM utenti");

if ($rs) {

		echo '<table border="1" cellpadding="4" cellspacing="2">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Nome</th>';
		echo '<th>Cognome</th>';
		echo '<th>Valore</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	do {
		echo '<tr>';
		echo '<td>';echo $rs['Nome'];echo '</td>';
		echo '<td>';echo $rs['Cognome'];echo '</td>';
		echo '<td>';echo $rs['Valore'];echo '</td>';
		echo '</tr>';

	} while ($rs = $db->sqlFetch());

	echo '</tbody>';
	echo '</table>';


} else {
	echo '<p>Non ci sono dati</p>';
}

*/

?>