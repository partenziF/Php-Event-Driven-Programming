<?

require_once('GenericEventListener.php');
require_once('GenericDbViewer.php');
require_once('GenericDataViewer.php');
require_once('Tags.php');


class  CustomFormViewer extends GenericDataViewer {

	private $P_Utente;

	function __construct($aP_Utente = NULL) { 

		settype($aP_Utente,'integer');

		$this->P_Utente = $aP_Utente;
		
		parent::__construct('localhost','test','test','TEST');

		$this->setOnPrepareData('CustomOnPrepareData');
		$this->setOnBeginData('CustomOnBeginData');
		$this->setOnShowData('CustomOnShowData');
		$this->setOnEndData('CustomOnEndData');
		$this->setOnEmptyData('CustomOnEmptyData');

	}

	function CustomOnPrepareData() {	

		if (!is_null($this->P_Utente)) {
			
			$sql = "SELECT * FROM utenti WHERE P_Utente = ?";
			$this->db->sqlSetParam($this->P_Utente,$sql);
			return $this->db->sqlSelect($sql);

		} else {

			$this->db->sqlSelect("SELECT * FROM utenti WHERE P_Utente IS NULL");

		}
		
	}

	function CustomOnBeginData() {

		echo openTag('form',array('method'=>'POST','action'=>$_SERVER['PHP_SELF']));
		
	}

	function CustomOnEndData() {

		echo closeTag('form');

	}

	function CustomOnShowData($aP_Utente,$aNome,$aCognome,$aEta,$aCancellato) {

		$css_form = array('float'=>'left','clear'=>'both');
		$css_div = array('margin'=>'5px 0px','display'=>'block','float'=>'left','clear'=>'left');
		$css_label = array('width'=>'100px','display'=>'block','float'=>'left','text-align'=>'right','margin-right'=>'8px');
		
		echo openTag('form',array('method'=>'POST','action'=>$_SERVER['PHP_SELF'],'style'=>implode_css_style($css_div)));

		echo openTag('div',array('style'=>implode_css_style($css_div)));
			echo openTag('label',array('style'=>implode_css_style($css_label)),'Nome',true,true);
			
			$Nome = ((isset($_REQUEST['Nome']))?$_REQUEST['Nome']:$aNome);
			echo openTag('input',array('type'=>'input','name'=>'Nome','value'=>$Nome),null,false,true);

		echo closeTag('div');

		echo openTag('div',array('style'=>implode_css_style($css_div)));
			echo openTag('label',array('style'=>implode_css_style($css_label)),'Cognome',true,true);
			$Cognome = ((isset($_REQUEST['Cognome']))?$_REQUEST['Cognome']:$aCognome);
			echo openTag('input',array('type'=>'input','name'=>'Cognome','value'=>$Cognome) );
		echo closeTag('div');

		echo openTag('div',array('style'=>implode_css_style($css_div)));
			echo openTag('label',array('style'=>implode_css_style($css_label)),'Età',true,true);
			$Eta = ((isset($_REQUEST['Eta']))?$_REQUEST['Eta']:$aEta);
			echo openTag('input',array('type'=>'input','name'=>'Eta','value'=>$Eta));
		echo closeTag('div');

		echo openTag('div',array('style'=>implode_css_style($css_div)));
			echo openTag('input',array('type'=>'submit','name'=>'MSG_UPDATE','value'=>'Salvare'));
			echo openTag('input',array('type'=>'hidden','name'=>'id','value'=>$aP_Utente));
		echo closeTag('div');

		echo closeTag('form');

	}


	function CustomOnEmptyData() {

		$css_form = array('float'=>'left','clear'=>'both');
		$css_div = array('margin'=>'5px 0px','display'=>'block','float'=>'left','clear'=>'left');
		$css_label = array('width'=>'100px','display'=>'block','float'=>'left','text-align'=>'right','margin-right'=>'8px');
		
		echo openTag('form',array('method'=>'POST','action'=>$_SERVER['PHP_SELF'],'style'=>implode_css_style($css_div)));

		echo openTag('div',array('style'=>implode_css_style($css_div)));
			echo openTag('label',array('style'=>implode_css_style($css_label)),'Nome',true,true);
			echo openTag('input',array('type'=>'input','name'=>'Nome','value'=>$_REQUEST['Nome']),null,false,true);
		echo closeTag('div');

		echo openTag('div',array('style'=>implode_css_style($css_div)));
			echo openTag('label',array('style'=>implode_css_style($css_label)),'Cognome',true,true);
			echo openTag('input',array('type'=>'input','name'=>'Cognome','value'=>$_REQUEST['Cognome']));
		echo closeTag('div');

		echo openTag('div',array('style'=>implode_css_style($css_div)));
			echo openTag('label',array('style'=>implode_css_style($css_label)),'Età',true,true);
			echo openTag('input',array('type'=>'input','name'=>'Eta','value'=>$_REQUEST['Eta']));
		echo closeTag('div');

		echo openTag('div',array('style'=>implode_css_style($css_div)));
			echo openTag('input',array('type'=>'submit','name'=>'MSG_INSERT','value'=>'Salvare'));
		echo closeTag('div');

		echo closeTag('form');

	}


}


class CustomWebEventListener extends GenericEventListener {

	private $CustomFormViewer;

	function __construct() { 

		parent::__construct();

		if (isset($_REQUEST['MSG_INSERT'])) {


			$this->PostMessage('MSG_INSERT','OnInsert',array($_REQUEST['Nome'],$_REQUEST['Cognome'],$_REQUEST['Eta']));

		} else if ( (isset($_REQUEST['MSG_UPDATE'])) && (!empty($_REQUEST['id'])) ) {

			$this->PostMessage('MSG_UPDATE','OnUpdate',array($_REQUEST['id'],$_REQUEST['Nome'],$_REQUEST['Cognome'],$_REQUEST['Eta']));

		} else if ( (isset($_REQUEST['MSG_DELETE'])) && (!empty($_REQUEST['id'])) ) {

			$this->PostMessage('MSG_DELETE','OnDelete',array($_REQUEST['id']));

		} else if (!empty($_REQUEST['id'])) {
			
			$this->PostMessage('MSG_SHOW','OnShowForm',array($_REQUEST['id']));

		} else {

			$this->PostMessage('MSG_SHOW_EMPTY','OnShowEmptyForm',null);
		}


	}


	function OnShowForm($aId) {

		echo __FUNCTION__."<br/>\r\n";
		
		$this->CustomFormViewer = new CustomFormViewer($aId);
		$this->CustomFormViewer->Show();

	}

	function OnShowEmptyForm() {

		echo __FUNCTION__."<br/>\r\n";

		$this->CustomFormViewer = new CustomFormViewer();
		$this->CustomFormViewer->Show();

	}

	function ValidateInput($aNome,$aCognome,$aEta) {
		$result = true;

		$result = ($result && (!empty($aNome)));
		$result = ($result && (!empty($aCognome)));
		$result = ($result && (!empty($aEta)));

		return $result;
	}

	function OnShowErrorForm($aMessage) {

		echo __FUNCTION__."<br/>\r\n";

		$css_div = array('background-color'=>'#EFEFEF','font-size'=>'12px','padding'=>'4px','border'=>'1px #C40000 solid','clear'=>'both');
		echo openTag('div',array('style'=>implode_css_style($css_div)),$aMessage,true,true);

	}

	function OnInsert($aNome,$aCognome,$aEta) {

		echo __FUNCTION__."<br/>\r\n";

		settype($aNome,'string');
		settype($aCognome,'string');
		settype($aEta,'integer');

		if ($this->ValidateInput($aNome,$aCognome,$aEta)) {

			$db = new GenericDbViewer('localhost','test','test','TEST');
			$db->connect();
			$sql = "INSERT INTO Utenti(Nome,Cognome,Eta,Cancellato) VALUES (?,?,?,?)";
			$db->sqlSetParam($aNome,$sql);
			$db->sqlSetParam($aCognome,$sql);
			$db->sqlSetParam($aEta,$sql);
			$db->sqlSetParam(false,$sql);
			if ($db->sqlEsegui($sql)) {		
				
				$aId = $db->sqlLastInsertID();

				$this->PostMessage('MSG_SHOW','OnShowForm',$aId);

			} else {

				$this->SendMessage('MSG_INTERNAL_ERROR','OnInternalError',"Errore durante salvataggio:".$db->getLastError());

			}

		} else {

			$this->PostMessage('MSG_SHOW_EMPTY','OnShowEmptyForm',null);
			// In questo caso volutamente è stata messo dopo 
			// per far vedere come send message precede post message
			$this->SendMessage('MSG_SHOW','OnShowErrorForm',"Errore validazione dati");

		}


	}

	function OnUpdate($aId,$aNome,$aCognome,$aEta) {

		echo __FUNCTION__."<br/>\r\n";

		settype($aId,'integer');
		settype($aNome,'string');
		settype($aCognome,'string');
		settype($aEta,'integer');
		if ($this->ValidateInput($aNome,$aCognome,$aEta)) {

			
			$db = new GenericDbViewer('localhost','test','test','TEST');
			$db->connect();
			$sql = "UPDATE Utenti SET Nome = ?,Cognome = ? ,Eta = ?,Cancellato = ? WHERE P_Utente = ?";
			$db->sqlSetParam($aNome,$sql);
			$db->sqlSetParam($aCognome,$sql);
			$db->sqlSetParam($aEta,$sql);
			$db->sqlSetParam(false,$sql);
			$db->sqlSetParam($aId,$sql);
			if ($db->sqlEsegui($sql)) {						

				$this->PostMessage('MSG_SHOW','OnShowForm',$aId);

			} else {

				$this->SendMessage('MSG_INTERNAL_ERROR','OnInternalError',"Errore durante salvataggio:".$db->getLastError());

			}


		} else {

			$this->PostMessage('MSG_SHOW_EMPTY','OnShowEmptyForm',null);
			// In questo caso volutamente è stata messo dopo 
			// per far vedere come send message precede post message
			$this->SendMessage('MSG_SHOW','OnShowErrorForm',"Errore validazione dati");

		}
	}

	function OnDelete($aId) {

		echo __FUNCTION__."<br/>\r\n";

		settype($aId,'integer');
		settype($aNome,'string');
		settype($aCognome,'string');
		settype($aEta,'integer');
	}

	function OnInternalError($aMessage) {

		echo __FUNCTION__."<br/>\r\n";

		$css_div = array('background-color'=>'#EFEFEF','font-size'=>'12px','padding'=>'4px','border'=>'1px #C40000 solid','clear'=>'both');
		echo openTag('div',array('style'=>implode_css_style($css_div)),$aMessage,true,true);

	}


}

$CustomWebEventListener = new CustomWebEventListener();
$CustomWebEventListener->ProcessMessages();

?>