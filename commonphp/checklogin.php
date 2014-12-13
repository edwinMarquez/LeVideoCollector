<?php
    //chicking if the user logs out
    if(isset($_GET['logout'])){
            session_regenerate_id(); //preventing session fixation attack
            unset($_SESSION['usrid']);
            unset($_SESSION['usravatar']);
            unset($_SESSION['name']);
    }

	//checking if the user logs in
	if(!isset($_SESSION['name'])){
    	if(isset($_POST['acuseremail']) && isset($_POST['acpassword'])){

    		$usr_info = sign_in($_POST['acuseremail'], $_POST['acpassword']);

    		if($row = pg_fetch_array($usr_info)){
                session_regenerate_id(); //preventing session fixation attack
    			$_SESSION['usrid'] = $row['idusuario'];
    			$_SESSION['usravatar'] = $row['avatar']; //not yet usefull 
    			$_SESSION['name'] = $row['username'];
    		}

    	}
    	
    

         //cheking if the user sign up
        else if(!isset($_SESSION['name'])){
          if(isset($_POST['unusername']) && isset($_POST['unuseremail']) && isset($_POST['unpassword'])){
            
            //sign_up($_POST['unusername'], $_POST['unuseremail'], $_POST['unpassword']);

            $usr_info = sign_in($_POST['unuseremail'], $_POST['unpassword']);
            if($row = pg_fetch_array($usr_info)){
                session_regenerate_id(); //preventing session fixation attack
                $_SESSION['usrid'] = $row['idusuario'];
                $_SESSION['usravatar'] = $row['avatar']; //not yet usefull 
                $_SESSION['name'] = $row['username'];
            }


          }
        }
    }


?>