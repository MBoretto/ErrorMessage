<?php
#ErrorMessage.class.php
#
#v0.01		2014-07-14 Minor Fix
#v0.10		2014-11-08 Added return to printmessage functoin
#v0.11		2014-11-15 Added Function SetMessage
#v0.12		2015-04-26 Translated funcions name to english
class ErrorMessage {
	
	var $SFSG;
	var $msg_ok;
	var $msg_ko;
	var $Errori;
	var $IndiceErrori;

	//Costruttore
	function ErrorMessage(){
	}

	function NewForm($ok,$ko,$DatiForm){
		$this->StartSession();
		$this->SFSG = 1;	
		$this->msg_ok = $ok;
		$this->msg_ko = $ko;
		$this->IndiceErrori = 0;
		$this->ResetSessionData();
		$this->SetMessage($ok,$ko);
		$_SESSION['ErrorMessage']['formVar'] = $DatiForm;
	}

	function SetMessage($ok,$ko){
		$_SESSION['ErrorMessage']['MessaggioKo'] = $ko;
		$_SESSION['ErrorMessage']['MessaggioOk'] = $ok;
 	}


	function ResetSessionData(){
		unset($_SESSION['ErrorMessage']);
	}

	function SoFarSoGood(){
		if($this->SFSG){
			return 1;	
		}else{
			return 0;	
		}
	}

	function StartSession(){
		session_start();
	}

	function Error($msg_errore){
		$this->SFSG = 0;
		//print'Errore';
		$Errori[$this->IndiceErrori] = $msg_errore;
		$_SESSION['ErrorMessage']['MessaggiErrore'][$this->IndiceErrori] = $msg_errore;
		$this->IndiceErrori++;
	}

	function PrintMessagges( &$value, $sali){
		//////////////////
		//Stampa eventuali messaggi Da modificare con il tema del sito
		////////////

		//return 1 nessun errore, return 0 errore
		if(isset($_SESSION['ErrorMessage']['MessaggiErrore'])){
			//Ci sono stati degli errori

			echo'<div class="msg_red_container"> <br/>';
			echo $_SESSION['ErrorMessage']['MessaggioKo'];
			echo '<ul>';		
					
			//stampa lista di errori
			for($i=0; $i<count($_SESSION['ErrorMessage']['MessaggiErrore']); $i++) 
					echo '<li>'.$_SESSION['ErrorMessage']['MessaggiErrore'][$i].'</li>';
			
			echo'</ul></div>';
			$value = $_SESSION['ErrorMessage']['formVar'];
			
			$this->ResetSessionData();
			return 0;
	
		}elseif(isset($_SESSION['ErrorMessage'])){
			//Non ci sono stati errori
			echo'<div class="msg_green_container">				';
			echo $_SESSION['ErrorMessage']['MessaggioOk'];
			echo'</div>';
	
			$this->ResetSessionData();

			return 1;
		}else{//Modalità modifica
			return 1;
		}
	}
}
?>
