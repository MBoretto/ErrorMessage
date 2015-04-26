<?php
include('ErrorMessage.class.php');

session_start();
$CheckPoint = new ErrorMessage();
#echo '<pre>';	
#print_r($_POST);
#print_r($_SESSION);
#echo '</pre>';	
		if(isset($_POST['AggiungiAlbum'])){

			$CheckPoint->NewForm('Evento creato!','Impossibile creare l\'evento..',$_POST);

			//controllo checkbox 0 o 1
			if(!isset($_POST['LC']))	$_POST['LC'] = 0;
			if(!isset($_POST['EG']))	$_POST['EG'] = 0;
			if(!isset($_POST['RS']))	$_POST['RS'] = 0;
			if(!isset($_POST['COCA']))	$_POST['COCA'] = 0;
	
			//Trim() di tutti i campi per togliere gli spazi
			foreach($_POST as $key => $value){ 
				if(is_array($value)){
					foreach($value as $key2 => $value2) 
						$_POST[$key][$key2] = trim($value2);
				}else{
					$_POST[$key] = trim($value);
				}
			}

			//Nessuna branca spuntata
			if($_POST['LC'] == 0 & $_POST['EG'] == 0 & $_POST['RS'] == 0 & $_POST['COCA'] == 0){
				$CheckPoint->Error("Non hai spuntato nessuna branca!");	
			}
			
			//Controllo non nullo uno per ogni campo Verifico che non siano nulli
			if($_POST['anno'] == ''){ $CheckPoint->Error("Non ci sono infomazioni sull'anno dell evento! Contatta il web master."); }
			if($_POST['tipo'] == ''){  $CheckPoint->Error("Il campo 'Tipo di evento' non può essere vuoto!");  }
			if($_POST['luogo'] == ''){  $CheckPoint->Error("Il campo luogo non può essere vuoto!");  }
		
			if( $_POST['dataInizio']['gg'] == ''){  $CheckPoint->Error("Il campo Giorno di inizio non è stato settato!");}
			if( $_POST['dataInizio']['mm'] == ''){  $CheckPoint->Error("Il campo Mese di inizio non è stato settato!");  }
			if( $_POST['dataInizio']['aaaa'] == ''){  $CheckPoint->Error("Il campo Anno di inizio non è stato settato!");  }
	
			if( $_POST['dataFine']['gg'] == ''){  $CheckPoint->Error("Il campo Giorno di fine non è stato settato!");}  
			if( $_POST['dataFine']['mm'] == ''){  $CheckPoint->Error("Il campo Mese di fine non è stato settato!");  }
			if( $_POST['dataFine']['aaaa'] == ''){  $CheckPoint->Error("Il campo Anno di fine non è stato settato!");  }

			//Controllo che siano numeri
			if(!is_numeric($_POST['dataInizio']['gg'])){ $CheckPoint->Error("Il campo Giorno di inizio deve essere un numero!"); }
			if(!is_numeric($_POST['dataInizio']['mm'])){ $CheckPoint->Error("Il campo Mese di inizio deve essere un numero!"); }
			if(!is_numeric($_POST['dataInizio']['aaaa'])){ $CheckPoint->Error("Il campo Anno di inizio deve essere un numero!"); }
			if(!is_numeric($_POST['dataFine']['gg'])){ $CheckPoint->Error("Il campo Giorno di fine deve essere un numero!"); }
			if(!is_numeric($_POST['dataFine']['mm'])){ $CheckPoint->Error("Il campo Mese di fine deve essere un numero!"); }
			if(!is_numeric($_POST['dataFine']['aaaa'])){ $CheckPoint->Error("Il campo Anno di fine deve essere un numero!"); }

	
			if($CheckPoint->SoFarSoGood()){ //Invio della mail per il log\

				header("location: index.php?anno=".$_POST['anno']);
				exit;

			}else{
				//C'è almeno un errore	
				$link_send_back = basename($_SERVER['PHP_SELF']);
				header("location: ".$link_send_back);
				exit;	
			}
		
		}else{	//stampa il form
	
		

			$sali = '.';		
			if($CheckPoint->PrintMessagges($value, $sali)){//$value si riempie
			}
			if(isset($value['LC'])){
				if($value['LC'] == 1)	$value['LC'] = 'checked';
			}else{
				$value['LC'] = '';
			}

			if(isset($value['EG'])){
				if( $value['EG'] == 1)	$value['EG'] = 'checked';
			}else{
				$value['EG'] = '';
			}
		
			if(isset($value['RS'])){
				if($value['RS'] == 1)	$value['RS'] = 'checked';
			}else{
				$value['RS'] = '';
			}

			if(isset($value['COCA'])){
				if($value['COCA'] == 1)	$value['COCA'] = 'checked';
			}else{
				$value['COCA'] = '';
			}


			if(!isset($value['tipo'])) $value['tipo']='';
			if(!isset($value['luogo'])) $value['luogo']='';

				//Stampo la form

				echo '<div class="std_container">';

				echo '<h1>Inserisci un nuovo Evento:</h1>';
				echo '<br/>

					<form action="index.php" method="post">

						<input type="hidden" name="anno" value="3">
					';



				echo '
						<table border="0" width="780">

						<tr valign="top">
							<td>
							<h2>Tipo:</h2>
							</td>
	
							<td>
							<input name="tipo" class="Login_input" type="text" value="'.$value['tipo'].'">
							</td>
							<td>
							<h3>Uscita, caccia, route, impresa..</h3>
							</td>
						</tr>

						<tr valign="top">
							<td>
							<h2>Luogo:&nbsp</h2>
							</td>
	
							<td>
							<input name="luogo" class="Login_input" type="text" value="'.$value['luogo'].'">
							</td>
							<td>
							<h3>Posto in cui &egrave; avvenuto l\'evento</h3>
							</td>
						</tr>




						<tr valign="top">
							<td>
							<h2>Brache:</h2>
							</td>
	
							<td>
								Branco:<input type="checkbox" name="LC" value="1" '.$value['LC'].'> 
								Reparto:<input type="checkbox" name="EG" value="1" '.$value['EG'].'> 
								Clan:<input type="checkbox" name="RS" value="1"  '.$value['RS'].'>
								Coca:<input type="checkbox" name="COCA" value="1"  '.$value['COCA'].'>
					

							</td>
							<td>
							<h3>Spunta le branche presenti</h3>
							</td>
						</tr>




						<tr valign="top">
							<td>
							<h2>Giorno Inizio:</h2>
							</td>
	
							<td>';
			
							echo '<select name="dataInizio[gg]" >';
							for($i = 1; $i <= 31; $i++){
								$selected = '';
								if(isset($value['dataInizio']['gg'])){
									if($value['dataInizio']['gg'] == $i){
										$selected = 'selected="selected"';
									}
								}
								echo '<option value='.$i.' '.$selected.'>'.$i.'</option>'."\n";
							}
							echo '</select>';

							$mesi[1] = 'Gennaio';
							$mesi[2] = 'Febbraio';
							$mesi[3] = 'Marzo';
							$mesi[4] = 'Aprile';
							$mesi[5] = 'Maggio';
							$mesi[6] = 'Giugno';
							$mesi[7] = 'Luglio';
							$mesi[8] = 'Agosto';
							$mesi[9] = 'Settembre';
							$mesi[10] = 'Ottobre';
							$mesi[11] = 'Novembre';
							$mesi[12] = 'Dicembre';


							echo '<select name="dataInizio[mm]" >';
							for($i = 1; $i <= 12; $i++){
								$selected = '';
								
								if(isset($value['dataInizio']['mm'])){
									if($value['dataInizio']['mm'] == $i){
										$selected = 'selected="selected"';
									}
								}
								echo '<option value='.$i.' '.$selected.'>'.$mesi[$i].'</option>'."\n";
							}
							echo '</select>';






						echo '<select name="dataInizio[aaaa]" >'."\n";
							for($i = $anno; $i <= ($anno+1); $i++){
								$selected = '';

								if(isset($value['dataInizio']['aaaa'])){
									if($value['dataInizio']['aaaa'] == ($i+1970)){
										$selected = 'selected="selected"';
									}
								}
								echo '<option value='.(1970 + $i).' '.$selected.'>'.(1970 + $i).'</option>'."\n";
							}
						echo '</select>'."\n";




				echo'		</td>
						<td>
						<h3>Giorno in cui &egrave; iniziato l\'evento</h3>
						</td>
					</tr>

					<tr valign="top">
						<td>
						<h2>Giorno Fine:&nbsp</h2>
						</td>
	
						<td>';
						

				echo '<select name="dataFine[gg]" >';
				for($i = 1; $i <= 31; $i++){
					$selected = '';
					
					if(isset($value['dataFine']['gg'])){
						if($value['dataFine']['gg'] == $i){
							$selected = 'selected="selected"';
						}
					}
					echo '<option value='.$i.' '.$selected.'>'.$i.'</option>'."\n";
				}
				echo '</select>';


				echo '<select name="dataFine[mm]" >';
				for($i = 1; $i <= 12; $i++){
					$selected = '';
					
					if(isset($value['dataFine']['mm'])){
						if($value['dataFine']['mm'] == $i){
							$selected = 'selected="selected"';
						}
					}
					echo '<option value='.$i.' '.$selected.'>'.$mesi[$i].'</option>'."\n";
				}
				echo '</select>';
	
		
				echo '<select name="dataFine[aaaa]" >'."\n";
					for($i = $anno; $i <= ($anno+1); $i++){
						$selected = '';

						if(isset($value['dataFine']['aaaa']) ){
							if($value['dataFine']['aaaa'] == ($i+1970)){
								$selected = 'selected="selected"';
							}
						}
						echo '<option value='.(1970 + $i).' '.$selected.'>'.(1970 + $i).'</option>'."\n";
					}
				echo '</select>'."\n";

				echo '
						</td>
						<td>
						<h3>Giorno in cui &egrave; finito l\'evento</h3>
						</td>
					</tr>';



				echo '
					<tr valign="top">
						<td>
						
						</td>
	
						<td>
				
						</td>
						<td><br/><br/>
						<input name="AggiungiAlbum" type="submit" class="Login_submit" value="Invia">
						</td>
					</tr>



					</table>


				<br/>
		
				</form>

				';


				echo '</div><br/><br/><br/><br/><br/>';



			//include('foot.php');
		}


?>
