<?
//CREATE TABLE `Utenti` (`P_Utente` INT (11) UNSIGNED NOT NULL AUTO_INCREMENT, `Nome` VARCHAR (250), `Cognome` VARCHAR (250), `Valore` INT (11) UNSIGNED, `Cancellato` TINYINT (1) UNSIGNED DEFAULT '0' NOT NULL, PRIMARY KEY(`P_Utente`))
require_once('GenericEventObject.php');

class GenericDbViewer {

	private $FETCH_TYPE = MYSQL_ASSOC;

	public $LastError;	
	public $LastErrorCode;
	private $ResultSet;
	public $isConnected;

	private $Host;
	private $Database;
	private $Username;
	private $Password;
	private $pDatabase;


	function __construct($aHost,$aDatabase,$aUsername,$aPassword) { 

		$this->Host = $aHost;
		$this->Database = $aDatabase;
		$this->Username = $aUsername;
		$this->Password = $aPassword;	

		$this->pDatabase = NULL;
		$this->ResultSet = NULL;
		$this->isCollegato = false;

	}
	
	function setLastError($aError) {

		$this->LastErrorCode = mysql_errno($this->pDatabase);
		$ErrorMsg = mysql_error($this->pDatabase);
		$this->LastError="[$aError] ( {$this->LastErrorCode} : $ErrorMsg )<BR>\n";

	}

	function getLastError() {
		return $this->LastError;
	}


	function connect() { 

		if (!($this->isConnected)){	

			$this->pDatabase = mysql_connect($this->Host,$this->Username,$this->Password,true);

			if ($this->pDatabase) {

				if(mysql_select_db($this->Database,$this->pDatabase)) {
					
					$this->isCollegato = true;

				}else{
					
					$this->setLastError("Errore selezione database");
					$this->isCollegato = false;
				}

			} else {

				$this->setLastError("Errore connessione al database");
				$this->isCollegato = false;

			}

		}

		return $this->isCollegato;

	}

	function setDatabase($aDatabase) {

		if (($this->isCollegato)){

			$this->Database = $aDatabase;

			if(!mysql_select_db($this->Database,$this->pDatabase)) {
				$this->setLastError("Errore selezione database");
				$this->isCollegato = false;
				return false;
			}else{
				$this->isCollegato = true;;
				return true;
			}

		} else {
			return false;
		}

	}

	function sqlSelect($sql,$UsaBuffer=true){

		if (!($this->pDatabase)){ $this->connect(); }

		$this->ResultSet=NULL;
		if (empty($this->pDatabase)) return NULL; // Precauzione
		
		if ($UsaBuffer) {
			$this->ResultSet = mysql_query($sql,$this->pDatabase);
		} else {
			$this->ResultSet = mysql_unbuffered_query($sql,$this->pDatabase);
		}

		if( (!$this->ResultSet) || (empty($this->ResultSet)) ) {
			$this->setLastError("Errore Select");
			$this->ResultSet = NULL;
			return NULL;

		} else {

			return mysql_fetch_array($this->ResultSet,$this->FETCH_TYPE);
			
		}

	}

	function sqlFetch(){
		if ($this->ResultSet) {
			return mysql_fetch_array($this->ResultSet,$this->FETCH_TYPE);
		} else {
			return NULL;
		}
	}

	function sqlEsegui($sql){

		if (!($this->pDatabase)){ $this->connect(); }

		$insert = mysql_query($sql, $this->pDatabase);
		
		if (!$insert) {
			$this->setLastError("Errore sqlEsegui");
			return false;
		}else{
			$this->setLastError(mysql_info($this->pDatabase));
			$insert =  ((mysql_affected_rows($this->pDatabase)>=0) ? true : false );
			return $insert;
		}		
	}

	function sqlLastInsertID(){
		# Quando vengono aperte due connessioni allo stesso database non funziona correttamente
		if ($this->pDatabase){
		  $ID = mysql_insert_id($this->pDatabase);
		  #echo "<br><b>ID:$ID</b><br>";
		  return $ID;
		}else{
		  return FALSE;
		}
	}	


	function sqlSetParam($aValore,&$sql){

		// Trova tutti i punti interrogativi non preceduti dal carattere escape \
		$pattern = "/(?<!\\\\)\?/";

		switch (gettype($aValore)){

			case "string":
				$aValore = '"'.(mysql_real_escape_string($aValore,$this->pDatabase)).'"';
				$aValore = str_replace("?","\?",$aValore);
				$sostituisci = $aValore;

			break;
			case "NULL":
				$sostituisci = "NULL"; 
			break;
			case "boolean":
				($aValore) ? $sostituisci=1 : $sostituisci=0; 
			break;
			default:
				$sostituisci = ($aValore);
		}		

		$prec = '';
		$pos = false;
		for($i = 0; $i < strlen($sql); $i++){
			if ($i>0){ $prec = $sql{$i-1}; }
			if ( ($prec!='\\') && ($sql{$i}=='?') ){
				$pos = $i;
				break;
			}
		}

		if ($pos !== false){
			$sql = substr_replace($sql,$sostituisci,$pos,1);
		}


	}


	function __destruct() { 
		
		if (!is_null($this->ResultSet)) {

			mysql_free_result($this->ResultSet);

		}
		
	}

}


?>