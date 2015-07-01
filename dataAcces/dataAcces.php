<?php
	
	//file containing the configurations parameters
	include 'configs.php';	

	/*
	  since im using md5 encription for the passwords which is not very secure ,im using and extra string
	  that is contained in this variable, i put it here instead of the configs files 
	  because if you already have data and you change it it wont be funny.
	*/
	$salt = "thisismystring";

	/**
	* this function creates a conection to the database
	* @param none
	* @return pg_conection
	*
	* @global string $db_host this variable has the name of the database host comes from configs.php
	* @global string $db_usr contains the user name for the database comes from configs.php
	* @global string $db_pwd contains the password for the database user comes form configs.php
	* @global string $db_name contains the name of the databasem comer from configs.php
	*/ 
	function createConection(){

		global $db_host;
		global $db_usr;
		global $db_pwd;
		global $db_name;
		global $db_port;

		return pg_connect('user='.$db_usr.' password='.$db_pwd.' host= '.$db_host.' dbname = '.$db_name.' port = '.$db_port);
	}

    /**
    *  this function closes an created conection
    *  @param $link an postgre conection to be closed
    *
    **/
	function closeConection($link){
      pg_close($link);
	}

	/**
	* this function checks for an user in the database
	*
	* @param $usremail the email of the user in the database
	* @param $pass the password of the user
	* @return pg_result or false in failure
	*
	* @var realusemail the scaped string for the username
	* @var realpass  the scaped string for the password
	* @var thepassword the md5 version of the password plus the salt
	* @global salt the string added as salt for the md5
	*	
	**/
	function sign_in($usemail, $pass){
		//in case a distracted user happens to visit
		$realusemail = pg_escape_string($usemail);
		$realpass = pg_escape_string($pass);
		global $salt;
		$thepassword = md5($realpass.$salt);
		$query = "SELECT idUsuario, UserName FROM Usuario WHERE UserEmail = '".$realusemail."' and pass = '".$thepassword."';";
		$link = createConection();
		$result = pg_exec($link, $query);
		closeConection($link);
		return $result;
	}

	/**
	*This fuctions adds a new user
	* @param $username the name of the user
	* @param $usermail the email of the user
	* @param $pass the password of the user
	*
	* @return pg_result
	**/
	function sign_up($username, $usermail, $pass){
		$realname = pg_escape_string($username);
		$realmail = pg_escape_string($usermail);
		$realpass = pg_escape_string($pass);
		global $salt;
		$thepassword = md5($realpass.$salt);
		$idUsuario = lastid_user()+1;
		$query = "INSERT INTO Usuario (idUsuario,UserName,UserEmail,pass) values ('".$idUsuario."', '".$realname."', '".$realmail."', '".$thepassword."');"; 
		$link = createConection();
		$result = pg_exec($link, $query);
		closeConection($link);
		return $result;
	}

	/**
	* this fuction is used to get the information about an specific video
	*	
	* @param $videoid recives the id of the video to look for
	*
	* @return pg_result or false in failure
	*
	**/
	function getdatavideo($videoid){
		$id = pg_escape_string($videoid);
        $query = "SELECT u.username, v.location, v.videoname, v.upvotes, v.downvotes, v.description, v.idusuario, v.videotype  
                  FROM video v inner join usuario u on u.idusuario = v.idusuario WHERE v.idVideo = '".$id."';";
		$link = createConection();
		$result = pg_exec($link, $query);
		closeConection($link);
		return $result;
	}

	/**
	* this functin gets the last id used for the video , to know the id of the next video
	*	
	* @param none
	*
	* @return the lastidused
	*
	**/
	function lastid(){
		$query = 'SELECT idVideo FROM video Order By idVideo Desc Limit 1';
		$link = createConection();
		if($row = pg_fetch_array(pg_exec($link,$query))){
			closeConection($link);
			return $row['idvideo'];
		}else{
			closeConection($link);
			return 0;
		}
	}

	function lastid_user(){
		$query = 'SELECT idUsuario FROM Usuario Order By idUsuario Desc Limit 1';
		$link = createConection();
		if($row = pg_fetch_array(pg_exec($link,$query))){
			closeConection($link);
			return $row['idusuario'];
		}else{
			closeConection($link);
			return 0;
		}
	}

	/**
	* returns the number of total videos in the database
	* @param none
	*
	* @return the number of videos
	*
	**/
	function countallvideos(){
		$query = 'SELECT COUNT(*) as cuenta FROM video';
		$link = createConection();
		if($row = pg_fetch_array(pg_exec($link,$query))){
			closeConection($link);
			return $row['cuenta'];
		}else{
			closeConection($link);
			return 0;
		}
	}

	/**
	* this fuction returns a list of videos
	*
	* @param $pagenum the number of page to show, pagination
	* @param $order boolean to know it the ordes is ascending or descending, true descending false asending
	* 
	* @global $numofVideos comes from configs.php this is the number of videos to show in every page
	*
	* @return pg_result 
	* 
	**/
    /**  not in use, in this implementation of the site
	function allvideos($pagenum){
		global $numofVideos;
		$realpagenum = pg_escape_string($pagenum);
		$link = createConection();
		$query = 'SELECT idVideo, VideoName, upvotes, downvotes FROM video Order By VideoName Asc Limit '.$numofVideos.' OFFSET '.$realpagenum * $numofVideos.';';
		$result = pg_exec($link,$query);
        closeConection($link);
		return $result;
	}
    **/ 

	//inserting information in the database

	/**
	* this function inserts informatin for a video entry
	* 
	* @param $idVideo the id that the video is gonna have in the table
	* @param $VideoName the name of the video
	* @param $Description a description of the video
	* @param idUsuario the user that uploaded the file
	* @param VideoType the format of the video uploaded
	* @param UpDate the date that the video was uploaded
	*
	* @return true or false
	*
	**/
	function insertvideo($idVideo,$VideoName,$Description,$idUsuario,$VideoType,$UpDate, $videolocation){
		$link = createConection();
		$realVideoName = pg_escape_string($VideoName);
		$realDescription = pg_escape_string($Description);
        $realLocation = pg_escape_string($videolocation);
		$query = 'INSERT into video (idVideo, VideoName,upvotes, downvotes, Description,idUsuario,VideoType,UpDate,location) values (\''.$idVideo.'\',\''.$realVideoName.'\',0,0,\''.$realDescription.'\',\''.$idUsuario.'\',\''.$VideoType.'\',\''.$UpDate.'\',\''.$realLocation.'\')';
		$result = pg_exec($link,$query);
        closeConection($link);
		return $result;
	}

    /**
    *This function search for the most recent videos
    *
    *@param $page the page to show based on the param numofVideos
    *
    *@return pg_result
    *
    **/
    function searchMoreRecent($page){
    	global $numofVideos;
    	$realpage = pg_escape_string($page);
    	$link = createConection();
        $query = 'SELECT * FROM video ORDER BY UpDate Desc Limit '.$numofVideos.' OFFSET '.$realpage * $numofVideos;
        $query = 'SELECT u.username, v.idvideo, v.videoname, v.upvotes, v.downvotes, v.description, v.idusuario, v.videotype  
                  FROM video v inner join usuario u on u.idusuario = v.idusuario ORDER BY UpDate Desc Limit '.$numofVideos.' 
                  OFFSET '.$realpage*$numofVideos;
        $result = pg_exec($link,$query);
        closeConection($link);
        return $result;
    }

    /**
    *This function search for the best videos
    *
    *@param $page the page to show based on the param numofVideos
    *
    *@return mysqli_result
    *
    **/
    function searchBestRated($page, $numofVideos){
    	//global $numofVideos;
    	$realpage = pg_escape_string($page);
    	$link = createConection();
        $query = 'SELECT u.username, v.idvideo, v.videoname, v.upvotes, v.downvotes, v.description, v.idusuario, v.videotype  
                  FROM video v inner join usuario u on u.idusuario = v.idusuario ORDER BY upvotes Desc Limit '.$numofVideos.' 
                  OFFSET '.$realpage*$numofVideos;
        $result = pg_exec($link,$query);
        closeConection($link);
        return $result;

    }

    /**
    *This function return the number of "pages"
    *
    *@return integer number of pages
    *
    **/
    function totalpages(){
    	global $numofVideos;
    	return ceil(countallvideos() / $numofVideos);
    }


    /**
    *Searches by an string
    *@param $string the string to search by
    *@param $page The page to display
    *
    *@return pg_result
    **/
    function searchString($string, $page){
    	global $numofVideos;
    	$realstring = pg_escape_string($string);
    	$realpage = pg_escape_string($page);
    	$link = createConection();
    	$query = "SELECT * FROM video where VideoName ilike '%".$realstring."%' ORDER BY VideoName Limit ".$numofVideos." OFFSET ".$realpage*$numofVideos.";";
    	$result = pg_exec($link,$query);
    	closeConection($link);
    	return $result;
    }
    /**
    * Counts the videos for a string search
    *
    * @return integer
    **/
    function countallvideos_searchstring($string){
    	$realstring = pg_escape_string($string);
    	$query = "SELECT COUNT(*) as cuenta FROM video where VideoName like '".$realstring."';";
		$link = createConection();
		if($row = pg_fetch_array(pg_exec($link,$query))){
			closeConection($link);
			return $row['cuenta'];
		}else{
			closeConection($link);
			return 0;
		}
    }

    /**
    *Return the number of pages found in a string search
    *
    *@return integer
    ***/
    function totalpages_searchstring($string){
    	global $numofVideos;
    	return ceil(countallvideos_searchstring($string) / $numofVideos);
    }

    /**
    *
    * Adds one to the upvote count
    *
    * @return true or false on success or not
    **/
    function upvote($videoid){
    	$realid = pg_escape_string($videoid);
    	$query1 = "SELECT upvotes FROM video where idvideo = ".$realid;
    	$link = createConection();
    	if($row = pg_fetch_array(pg_exec($link,$query1))){
    		$total = $row['upvotes'] + 1;
    		$query2 = "UPDATE video set upvotes = ".$total." where idvideo = ".$realid.";";
    		pg_exec($link, $query2);
    		closeConection($link);
    		return true;
    	}else{
    		closeConection($link);
    		return false;
    	}
    }

    /**
    *
    * Adds one to the downvote count
    *
    *@return true or false on succes or not
    *
    **/
    function downvote($idvideo){
    	$realid = pg_escape_string($idvideo);
    	$query1 = "SELECT downvotes FROM video where idvideo = ".$realid;
    	$link = createConection();
    	if($row = pg_fetch_array(pg_exec($link,$query1))){
    		$total = $row['downvotes'] + 1;
    		$query2 = "UPDATE video set downvotes = ".$total." where idvideo = ".$realid.";";
    		pg_exec($link, $query2);
    		closeConection($link);
    		return true;
    	}else{
    		closeConection($link);
    		return false;
    	}
    }

    /**
    *
    *Checks if an user has alredy voted for a video by looking if the registry exists in the database
    *
    *@return pg_result
    *
    **/
    function checkvote($idvideo, $iduser){
    	$realid = pg_escape_string($idvideo);
    	$realusr = pg_escape_string($iduser);
    	$query = "SELECT idvotexuser, vote FROM votexuser where idvideo = ".$realid." and idusuario = ".$realusr.";";
    	$link = createConection();
    	$result = pg_exec($link, $query);
    	closeConection($link);
    	return $result;
    }

    /**
    *
    * Changes the vote of a user that has alredy voted, good to bad, and bad to good
    *
    *
    *	@return true or false
    *
    **/
    //I'm not  using transactions but if it was more serious stuff i should. 
    // and improve would be to create functions on the database. maybe later
    function changevote($idvideo, $iduser){
    	$realid  = pg_escape_string($idvideo);
    	$realusr = pg_escape_string($iduser);
    	$query1 = "SELECT vote from votexuser where idvideo =".$realid."and idusuario = ".$realusr;
    	$link = createConection();
        if($row = pg_fetch_array(pg_exec($link, $query1))){
        	$currentvote = ($row['vote'] == "t")?true:false;
        	$query2 = "UPDATE votexuser set vote = ".(($currentvote)?"false":"true")." where idvideo = ".$realid." and idusuario = ".$realusr;
        	if(pg_exec($link, $query2)){
        		//now update the vote on the videos table
        		$query3 = "SELECT upvotes, downvotes from video where idvideo = ".$realid;
        		if($row2 = pg_fetch_array(pg_exec($link, $query3))){
        			$upvotes = $row2['upvotes'];
        			$downvotes = $row2['downvotes'];
        			if($currentvote){
        				$query4 = "UPDATE video SET upvotes = ".($upvotes - 1)." ,downvotes = ".($downvotes + 1). " where idvideo = ".$realid.";";
        				if(pg_exec($link, $query4)){
        					closeConection($link);
        					return true;
        				}else{
        					closeConection($link);
        					return false;
        				}
        			}else{ //current vote id downvote
        				$query4 = "UPDATE video SET upvotes = ".($upvotes + 1)." ,downvotes = ".($downvotes - 1). " where idvideo = ".$realid.";";
        				if(pg_exec($link, $query4)){
        					closeConection($link);
        					return true;
        				}else{
        					closeConection($link);
        					return false;
        				}
        			}
        		}else{  //the search for the up and down votes did not work 
        			closeConection($link);
        			return false;
        		}
        	}else{  //the table votexuser was not updated
        		closeConection($link);
        		return false;
        	}
        }else{  //the search for the vote value did not work
        	closeConection($link);
        	return false;
        }

    }

    /**
    *
    * Creates a new entry in the votes table (votexuser)
    *
    *@return true or false, true on success
    *
    **/
    function newvote($idvideo, $iduser, $vote){
    	$realid = pg_escape_string($idvideo);
    	$realuser = pg_escape_string($iduser);
    	$realvote = pg_escape_string($vote);
    	$query = "INSERT into votexuser (idusuario, idvideo, vote) values (".$realuser.", ".$realid.", ".$realvote.");";
    	$link = createConection();
    	if(pg_exec($link, $query)){
    		closeConection($link);
    		return true;
    	}else{
    		closeConection($link);
    		return false;
    	}
    }

    /**
    *
    *Inserts a comment in the database
    *
    *@param $idusr the id of the user making the comment
    *@param $idvideo the id of the video being commented
    *@param $date the date of the comment, (not scaped since it is not asked to the user)
    *
    *@return true on success false on failure
    **/
    function insertcomment($idusr,$idvideo,$comment,$date){
    	$realidusr = pg_escape_string($idusr);
    	$realidvideo = pg_escape_string($idvideo);
    	$realcomment = pg_escape_string($comment);
    	$query = "INSERT into coments(coment, idusuario, idvideo,codate) values('".$realcomment."', '".$realidusr."', '".$realidvideo."', '".$date."' );";
    	$link = createConection();
    	if(pg_exec($link,$query)){
    		return true;
    	}else{
    		return false;
    	}

    }

    /**
    *
    * Looks for the last comments,
    * 
    *@return pg_result
    *
    **/
    function getcomments($num,$idvideo){
    	$realnum = pg_escape_string($num);
    	$realidvideo = pg_escape_string($idvideo);
     	$query = "SELECT u.username, c.coment, c.codate from usuario u inner join coments c on u.idusuario = c.idusuario where c.idvideo = ".$realidvideo." ORDER BY c.codate DESC LIMIT ".$realnum.";";
    	$link = createConection();
    	$result = pg_exec($link, $query);
    	closeConection($link);
    	return $result;
    }

?>