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
	  echo '<div class="col-xs-8 col-sm-6 col-md-3 col-lg-3">';  //  col-sm-6 col-md-4
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
<!DOCTYPE html>
<html>
<head>

	<!--jquerry-->
	<script type="text/javascript" src="./jquery/jquery-1.11.1.min.js"> </script>
	<!--Your good friend bootstrap-->
	<script type="text/javascript" src="./bootstrap-3.3.2-dist/js/bootstrap.min.js"> </script>
	<link rel="stylesheet" type="text/css" href="./bootstrap-3.3.2-dist/css/bootstrap.min.css">


    <link rel="stylesheet" type="text/css" href="./css/principal.css">
    <script type="text/javascript" src="./javascript/principal.js"> </script>


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

	<div id="principal" class="panel panel-default">
		<?php
			write_title(); //from ./commonhtml/htmlwritter.php
		?>

		<div id= "content" class="panel-body">
			<div id="videoscontainer">
			  <div class = "row">
			  <?php
			    //if you havent clicked the left panel
			    $page = isset($_GET['page'])?$_GET['page']:0;
			    if(isset($_GET['search'])){
			          //getting the page to show
			          if($bystring = searchString($_GET['search'], $page)){
			  	         while($row = pg_fetch_array($bystring)){ 
			  	 	       writelist($row['idvideo'],$row['videoname'],$row['upvotes']);
			  	 	      }
			  	 	  
			  	       }

			    }elseif(isset($_GET['sort'])){
			    	//its been sorted by most recent
			    	if($_GET['sort'] == 'recent'){
			    		if($moreRecent = searchMoreRecent($page)){
			    		  while($row = pg_fetch_array($moreRecent)){
			    		   writelist($row['idvideo'],$row['videoname'],$row['upvotes']);
			    		  }
			    		}
			    	}elseif($_GET['sort']=='bestq'){
			    		//showing the best rated
			    		if($bestRated = searchBestRated($page)){
			    		  while($row = pg_fetch_array($bestRated)){
			    		   writelist($row['idvideo'],$row['videoname'],$row['upvotes']);
			    		  }
			    		}

			    	}

			    }else{

			    	if($allvideos = allvideos($page)){
			    	                        
			  	        while($row = pg_fetch_array($allvideos)){
			  	           writelist($row['idvideo'],$row['videoname'],$row['upvotes']);
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