<?php
  //session related stuff
    session_start();


	//file containing all functions related with the database
	include './dataAcces/dataAcces.php';
	//file that contains the common code to pages, menu.
	include './commonhtml/htmlwritter.php';
	//check if the user logs in
	include './commonphp/checklogin.php';

    /**
    *This function writes an element in the list of videos
    *that is displayed
    * @param $id the id of the video
    * @param $name the name of the video
    * @param $puntuacion the puntuation of the video
    *
    **/
	function writelist($id,$name,$puntuacion){
	  //puntuation still not in use
	  $name = (strlen($name)>32)?substr($name,0,29)."...":$name;
      echo '<a href=./watchvideo.php?watch='.$id.'>';
	  echo '<div class="col-sm-6 col-md-4">';
      echo '<div class="Thumbnail">'; 
	  echo '<img src="./thumbnail/little/'.$id.'.png" >';
      echo '<div class="caption">';
	  echo '<p>'.$name.'</p>';
      echo '</div>';
      echo '</div>';
	  echo '</div>';
	  echo '</a>';
	}


?>

<html>
<head>

	<!--jquerry-->
	<script type="text/javascript" src="./jquery/jquery-1.11.1.min.js"> </script>
	<!--Your good friend bootstrap-->
    <link rel="stylesheet" type="text/css" href="./bootstrap-3.2.0-dist/css/bootstrap.css">
    <script type="text/javascript" src="./bootstrap-3.2.0-dist/js/bootstrap.js"> </script>
    <link rel="stylesheet" type="text/css" href="./css/principal.css">
    <script type="text/javascript" src="./javascript/principal.js"> </script>

	<!-- this is the video-js player from http://www.videojs.com/-->
	<link rel="stylesheet" type="text/css" href="./video-js/video-js.css">
	<script type="text/javascript" src="./video-js/video.js"></script>
	<!-- -->
	
	<!-- need for the video.js-->
	<script>
		videojs.options.flash.swf="./video-js/video-js.swf";
	</script>

	<title>"Video Colector"</title>
</head>
<body>

	<?php
    if(isset($_SESSION['name'])){
    	write_loged_user_msg(); //from ./commonhtml/htmlwritter.php
    }else{
    	write_login_sigin(); //from ./commonhtml/htmlwritter.php	
    }
    ?>

	<div id="principal">
		<?php
			write_title(); //from ./commonhtml/htmlwritter.php
		?>
		<div id="log_sign_search">
			<div id="search">
				<form >
					<INPUT class = "btn-custom" TYPE=SUBMIT VALUE=" Search ">
					<INPUT id = "txtinput-custom" type="search" name="search" size=70>
				</form>
			</div>
		</div>

		<div id= "content">
			<?php
				write_menu(); //from ./commonhtml/htmlwritter.php
			?>
			<div id="videoscontainer">
			  <div class = "row">
			  <?php
			    //if you havent clicked the left panel
			    $page = isset($_GET['page'])?$_GET['page']:0;
			    if(isset($_GET['search'])){
			          //getting the page to show
			          if($bystring = searchString($_GET['search'], $page)){
			  	         while($row = mysqli_fetch_array($bystring)){ 
			  	 	       writelist($row['idVideo'],$row['VideoName'],$row['Puntuacion']);
			  	 	      }
			  	 	  
			  	       }

			    }elseif(isset($_GET['sort'])){
			    	//its been sorted by most recent
			    	if($_GET['sort'] == 'recent'){
			    		if($moreRecent = searchMoreRecent($page)){
			    		  while($row = mysqli_fetch_array($moreRecent)){
			    		   writelist($row['idVideo'],$row['VideoName'],$row['Puntuacion']);
			    		  }
			    		}
			    	}elseif($_GET['sort']=='bestq'){
			    		//showing the best rated
			    		if($bestRated = searchBestRated($page)){
			    		  while($row = mysqli_fetch_array($bestRated)){
			    		   writelist($row['idVideo'],$row['VideoName'],$row['Puntuacion']);
			    		  }
			    		}

			    	}

			    }else{

			    	if($allvideos = allvideos($page)){
			  	        while($row = mysqli_fetch_array($allvideos)){
			  	           writelist($row['idVideo'],$row['VideoName'],$row['Puntuacion']);
			  	 	    }
			  	 	  
			  	    }

			    }
			   ?>
			   </div>

			   <?php
			   //pagination
			   $totalvid = (isset($_GET['search']))?totalpages_searchstring($_GET['search']):totalpages();
			   $totalvid = ($totalvid == 0)?1:$totalvid;
			   echo '<div id="paginacion">';
			   if(isset($_GET['search'])){
			   	  echo '<ul class="pager">';
			   	  if($page != 0) echo '<li class="previous"><a href="index.php?search='.$_GET['search'].'&page='.($page - 1).'">&larr; Previous </a></li>';
			   	  else echo '<li class="previous disabled"><a href="#">&larr; Previous </a></li>';
			      echo 'Page '.($page + 1).' of '.$totalvid;
			      if($page < ($totalvid - 1)) echo '<li class="next"><a href="index.php?search='.$_GET['search'].'&page='.($page + 1).'"> Next &rarr;</a></li>';
			      else echo '<li class="next disabled"><a href="#">Next &rarr;</a></li>';
			   }elseif(isset($_GET['sort'])){
			   	  echo '<ul class="pager">';
                  if($page != 0) echo '<li class="previous"><a href="index.php?sort='.$_GET['sort'].'&page='.($page - 1).'">&larr; Previous </a></li>';
                  else echo '<li class="previous disabled"><a href="#">&larr; Previous </a></li>';
			      echo 'Page '.($page + 1).' of '.$totalvid;
			      if($page < ($totalvid - 1)) echo '<li class="next"><a href="index.php?sort='.$_GET['sort'].'&page='.($page + 1).'"> Next &rarr;</a></li>';
			      else echo '<li class="next disabled"><a href="#">Next &rarr;</a></li>';
			   }else{
			   	  echo '<ul class="pager">';
			   	  if($page != 0) echo '<li class="previous"><a href="index.php?page='.($page - 1).'">&larr; Previous </a></li>';
			   	  else echo '<li class="previous disabled"><a href="#">&larr; Previous </a></li>';
			   	  echo 'Page '.($page + 1).' of '.$totalvid;
			      if($page < ($totalvid - 1)) echo '<li class="next"><a href="index.php?page='.($page + 1).'"> Next &rarr;</a></li>';
			      else echo '<li class="next disabled"><a href="#">Next &rarr;</a></li>';
			   }
			   echo '</ul>';
			   echo '</div>';
			  ?>
			</div>

		</div>
	</div>

	<?php
	  write_bottompanel(); //from ./commonhtml/htmlwritter.php
	?>
</body>
</html>