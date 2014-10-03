<?php
  //session related stuff
    session_start();


	//file containing all functions related with the database
	include './dataAcces/dataAcces.php';
	//file that contains the common code to pages, menu.
	include './commonhtml/htmlwritter.php';
	//check if the user logs in
	include './commonphp/checklogin.php';


?>

<html>
<head>

	<!--jquerry-->
	<script type="text/javascript" src="./jquery/jquery-1.11.1.min.js"> </script>
	<!--Your good friend bootstrap-->
    <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="./bootstrap/js/bootstrap.js"> </script>
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
			  <div id="list">
			  <?php
			    //if you havent clicked the left panel
			    $page = isset($_GET['page'])?$_GET['page']:0;
			    if(isset($_GET['search'])){
			          //getting the page to show
			          if($bystring = searchString($_GET['search'], $page)){
			  	         while($row = mysqli_fetch_array($bystring)){
			  	 	       echo '<a href=./watchvideo.php?watch='.$row['idVideo'].'>';
			  	 	       echo '<div id = "'.$row['idVideo'].'" class="video-prev">';
			  	 	       echo '<img src="./thumbnail/little/'.$row['idVideo'].'.png" >';
			  	 	       echo '<p>'.$row['VideoName'].'</p>';
			  	 	       echo '</div>';
			  	 	       echo '</a>';
			  	 	      }
			  	 	  
			  	       }

			    }elseif(isset($_GET['sort'])){
			    	//its been sorted by most recent
			    	if($_GET['sort'] == 'recent'){
			    		if($moreRecent = searchMoreRecent($page)){
			    		  while($row = mysqli_fetch_array($moreRecent)){
			    		  	echo '<a href=./watchvideo.php?watch='.$row['idVideo'].'>';
			  	 	        echo '<div id = "'.$row['idVideo'].'" class="video-prev">';
			  	 	        echo '<img src="./thumbnail/little/'.$row['idVideo'].'.png" >';
			  	 	        echo '<p>'.$row['VideoName'].'</p>';
			  	 	        echo '</div>';
			  	 	        echo '</a>';
			    		  }
			    		}
			    	}elseif($_GET['sort']=='bestq'){
			    		//showing the best rated
			    		if($bestRated = searchBestRated($page)){
			    		  while($row = mysqli_fetch_array($bestRated)){
			    		  	echo '<a href=./watchvideo.php?watch='.$row['idVideo'].'>';
			  	 	        echo '<div id = "'.$row['idVideo'].'" class="video-prev">';
			  	 	        echo '<img src="./thumbnail/little/'.$row['idVideo'].'.png" >';
			  	 	        echo '<p>'.$row['VideoName'].'</p>';
			  	 	        echo '</div>';
			  	 	        echo '</a>';
			    		  }
			    		}

			    	}

			    }else{

			    	if($allvideos = allvideos($page)){
			  	        while($row = mysqli_fetch_array($allvideos)){
			  	 	       echo '<a href=./watchvideo.php?watch='.$row['idVideo'].'>';
			  	 	       echo '<div id = "'.$row['idVideo'].'" class="video-prev">';
			  	 	       echo '<img src="./thumbnail/little/'.$row['idVideo'].'.png" >';
			  	 	       echo '<p>'.$row['VideoName'].'</p>';
			  	 	       echo '</div>';
			  	 	       echo '</a>';
			  	 	    }
			  	 	  
			  	    }else{
			  	 	   echo "We have no videos yet , to show.. stay tuned";
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
			   	  echo '<div id="txtpag"> Page '.($page + 1).' of '.$totalvid;
			   	  echo '<br>';
			   	  if($page != 0) echo '<a href="index.php?search='.$_GET['search'].'&page='.($page - 1).'"> Previous </a>';
			      if($page < ($totalvid - 1)) echo '<a href="index.php?search='.$_GET['search'].'&page='.($page + 1).'"> Next </a>';
			   }elseif(isset($_GET['sort'])){
			   	  echo '<div id="txtpag"> Page '.($page + 1).' of '.$totalvid;
			   	  echo '<br>';
                  if($page != 0) echo '<a href="index.php?sort='.$_GET['sort'].'&page='.($page - 1).'"> Previous </a>';
			      if($page < ($totalvid - 1)) echo '<a href="index.php?sort='.$_GET['sort'].'&page='.($page + 1).'"> Next </a>';
			   }else{
			   	  echo '<div id="txtpag"> Page '.($page + 1).' of '.$totalvid;
			   	  echo '<br>';
			   	  if($page != 0) echo '<a href="index.php?page='.($page - 1).'"> Previous </a>';
			      if($page < ($totalvid - 1)) echo '<a href="index.php?page='.($page + 1).'"> Next </a>';
			   }
			   
			   echo '</div>';
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