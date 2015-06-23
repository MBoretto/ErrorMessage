<?php
#ErrorMessage.class.php
#
#v0.01		2014-07-14 Minor Fix
#v0.10		2014-11-08 Added return to printmessage functoin
#v0.11		2014-11-15 Added Function SetMessage
#v0.12		2015-04-26 Translated funcions name to english
#v0.2		2015-06-23 No HTML output, same thing less code, 
class ErrorMessage 
{
	
	protected $SFSG;
	protected $msg_ok;
	protected $msg_ko;
	protected $error_index;

	function newForm($ok,$ko,$DatiForm){

		session_start();
		$this->SFSG = 1;	
		$this->msg_ok = $ok;
		$this->msg_ko = $ko;
		$this->error_index = 0;
		$this->resetSessionData();
		$this->setMessage($ok,$ko);
		$_SESSION['ErrorMessage']['formVar'] = $DatiForm;
	}

	function resetSessionData(){
		unset($_SESSION['ErrorMessage']);
	}

	function setMessage($ok,$ko){
		$_SESSION['ErrorMessage']['MessaggioKo'] = $ko;
		$_SESSION['ErrorMessage']['MessaggioOk'] = $ok;
 	}

	function soFarSoGood(){
		if($this->SFSG){
			return 1;	
		}else{
			return 0;	
		}
	}

	function error($msg_errore){
		$this->SFSG = 0;
		$_SESSION['ErrorMessage']['MessaggiErrore'][] = $msg_errore;
		++$this->error_index;
	}

	function getMessagges( &$value){
		//////////////////
		//Get messagges to print 

		session_start();

		$output = array();
		if(isset($_SESSION['ErrorMessage']['MessaggiErrore'])){
			$output[] = $_SESSION['ErrorMessage']['MessaggioKo'];
			$value = $_SESSION['ErrorMessage']['formVar'];
			$output = array_merge($output,$_SESSION['ErrorMessage']['MessaggiErrore']);
		}elseif(isset($_SESSION['ErrorMessage'])){
			 $output[] = $_SESSION['ErrorMessage']['MessaggioOk'];
		}
		
		$this->resetSessionData();

		if(!empty($output)) {
			return $output;
		}
	}
}
?>
