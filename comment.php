<?php
	session_start();
	date_default_timezone_set("America/New_York");

	include './dataAcces/dataAcces.php';

	/**
	*
	* This functios write the coments in the selected format, it exist in watchvideo.php
	*
	*@return echoes the coments
	*
	**/
	function writecomment($user,$coment){
		echo '<div class="comment">
		  <h5><b>'.htmlspecialchars($user).' Says:</b></h5>
		  <p style="text-indent:40px;text-align:justify">'.htmlspecialchars($coment).'</p>
		</div>';
	}


	if(isset($_SESSION['usrid'])){
		if(isset($_POST['comment']) && isset($_POST['idvideo'])){
			if($_POST['comment'] != ""){
				if(insertcomment($_SESSION['usrid'],$_POST['idvideo'],$_POST['comment'],date('Y/m/d'))){
					if($lastcomments = getcomments(20,$_POST['idvideo'])){
						echo 'posted ';
			    		while($row=pg_fetch_array($lastcomments)){
							writecomment($row['username'],$row['coment']);
				    	}
					}else{
						echo 'noposted';
					}
			        
				}else{
					echo 'noposted';
				}
			    

			}else{
				echo 'nocomment';
			}
		}else{
			echo 'notdata';
		}

	}else{
		echo 'nolog';
	}



?>