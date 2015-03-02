<?php
  //session related stuff
    session_start();

    if(!isset($_GET['watch'])){
    	header('Location:index.php');
    }

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
    <script type="text/javascript" src="./bootstrap-3.3.2-dist/js/bootstrap.min.js"> </script>
	<link rel="stylesheet" type="text/css" href="./bootstrap-3.3.2-dist/css/bootstrap.min.css">


    <link rel="stylesheet" type="text/css" href="./css/principal.css">
    <link rel="stylesheet" type="text/css" href="./css/watchvideo.css">
    <script type="text/javascript" src="./javascript/principal.js"> </script>
    <script type="text/javascript" src="./javascript/watchvideo.js"> </script>
    


	<!-- need for the mediaelementjs-->
	<code>
    <script src="./mediaelement/build/mediaelement-and-player.min.js"></script>
    <link rel="stylesheet" href="./mediaelement/build/mediaelementplayer.css" /></code>

	<title>"Video Colector"</title>
</head>
<body>

	<?php
    if(isset($_SESSION['name'])){
    	write_loged_user_msg();
    }else{
    	write_login_sigin();	
    }
    ?>


	<div id="principal" class="panel panel-default">	
		<?php
			write_title(); //this puts the top navbar
		?>

		<div id= "content" class="panel-body">
		
			<div id="videoscontainer">


				<?php
					$data_video = getdatavideo($_GET['watch']);

					if($row = pg_fetch_array($data_video)){
						echo '<div id="bestvideo" value = "'.$_GET['watch'].'">
							<video id="thebestvideo" 
								poster="./thumbnail/large/'.$_GET['watch'].'.png"
								controls="controls" preload="none"
								"
							>';
							$put_original = false;
							if(file_exists('./video/mp4/'.$_GET['watch'].'.mp4'))echo '<source type="video/mp4" src="./video/mp4/'.$_GET['watch'].'.mp4"/>';
							else $put_original = true;
							if(file_exists('./video/webm/'.$_GET['watch'].'.webm')) echo '<source type="video/webm" src="./video/webm/'.$_GET['watch'].'.webm"/>';
							else $put_original = true;
							if(file_exists('./video/ogv/'.$_GET['watch'].'.ogv')) echo '<source type="video/ogg" src="./video/ogv/'.$_GET['watch'].'.ogv"/>';
							else $put_original = true;
							if($put_original)echo '<source src="./video/'.$_GET['watch'].'.'.$row['videotype'].'" type="video/'.$row['videotype'].'"/>';

							echo '<object type="application/x-shockwave-flash" data="./mediaelement/build/flashmediaelement.swf">
                                    <param name="movie" value="./mediaelement/build/flashmediaelement.swf" />
                                    <param name="flashvars" value="controls=true&file=';
                                   if(file_exists('./video/mp4/'.$_GET['watch'].'.mp4'))echo '/video/mp4/'.$_GET['watch'].'.mp4';
                                   else if($_GET['videotype'] == mp4) echo './video/'.$_GET['watch'].'.mp4';
                                   else echo 'none'; 
                                    echo '" />
                                    <img src="./thumbnail/large/'.$_GET['watch'].'.png" title="No video playback capabilities" />
                                  </object>';

							echo'</video>';
							if($put_original){
								echo '<div id="alert" class="alert alert-danger">This video is still been converted to other formats, so you may 
								      have some problems watching it</div>';
							}else{
								$cbtnup = "btn btn-default";
								$cbtndown = "btn btn-default";
								$checkok = false;
								if(isset($_SESSION['usrid'])){
									$check = checkvote($_GET['watch'],$_SESSION['usrid']);
									if($row2 = pg_fetch_array($check)){
										$checkok = true;
										$prevvote = ($row2['vote'] == 't')?true:false;
									}
									if($checkok && $prevvote){
										$cbtnup = "btn btn-success"; //button up bootstrap class
									}else if($checkok && !$prevvote){
										$cbtndown = "btn btn-danger"; //button down bootstrap class
									}
								}
								
								echo '<div id = appreciation class="well">

								   <div class = "btn-toolbar" role="toolbar">
								   How was the video?
								   <button id = "upvote" type="button" class="'.$cbtnup.'">
								    Good <span class="glyphicon glyphicon-thumbs-up"> </span>
								   </button>
								   <span id="upnumber">'.$row['upvotes'].'</span>
									 
								   <button id = "downvote" type="button" class="'.$cbtndown.'">
								     Bad <span class="glyphicon glyphicon-thumbs-down"> </span>
								   </button>
								   <span id = "downnumber">'.$row['downvotes'].'</span>
								   </div>
								   <br>
								   <p id="alert" class="bg-primary"></p>
								</div>';


							}

						echo '</div>'; //end of best video

						echo '<div class="panel panel-default">';
						echo '<div class="panel-heading">';
						echo '<h3>'.$row['videoname'].'</h3>';
						echo '</div>'; //end of panel heading
						echo '<div id= descripcion class = "panel-body">
                                '.$row['description'].'
						      </div>';


						echo '</div>'; //end of panel panel-default
					}

					

				?>
				
				

			</div>
		</div>
	</div>

	<?php
	write_bottompanel();
	?>

</body>


</html>