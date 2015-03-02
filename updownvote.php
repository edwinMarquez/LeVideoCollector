<?php
	session_start();
	include './dataAcces/dataAcces.php';

	if(!isset($_SESSION['usrid'])){
		echo 'nolog';
	}else if(isset($_POST['video']) && isset($_POST['action'])){
		$checkok = false;
		$check = checkvote($_POST['video'],$_SESSION['usrid']);
		if($row = pg_fetch_array($check)){
			$checkok = true;
			$prevvote = ($row['vote'] == 't')?true:false;
			$idprevvote = $row['idvotexuser'];
		}

		if($_POST['action'] == "up"){
			if($checkok){
				if($prevvote){
					echo 'nothing'; //if he already voted for good
				}else{
					changevote($_POST['video'], $_SESSION['usrid']);
					echo 'changedu';
				}			
			}else if(upvote($_POST['video'])){
				newvote($_POST['video'], $_SESSION['usrid'], "true");
				echo 'yes';
			}else{
				echo 'no';
			}
		}else if($_POST['action'] == "down"){
			if($checkok){
				if(!$prevvote){
					echo 'nothing'; //if he already voted for bad
 				}else{
 					changevote($_POST['video'],$_SESSION['usrid']);
					echo 'changedd';
 				}
				
			}else if(downvote($_POST['video'])){
				newvote($_POST['video'], $_SESSION['usrid'], "false");
				echo 'yes';
			}else{
				echo 'no';
			}
		}else{
			echo 'no';
		}

	}else{
		echo 'no';
	}


?>