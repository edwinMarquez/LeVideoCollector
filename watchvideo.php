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
    	write_loged_user_msg();
    }else{
    	write_login_sigin();	
    }
    ?>


	<div id="principal" class="panel panel-default">	
		<?php
			write_title();
		?>
		<div id="log_sign_search">
			<div id="search">
				<form action="index.php" method="get">
					<INPUT class = "btn-custom" TYPE=SUBMIT VALUE=" Search ">
					<INPUT id = "txtinput-custom" type="search" name="search" size=70>
				</form>
			</div>
		</div>

		<div id= "content" class="panel-body">
			<?php
				write_menu();
			?>
			<div id="videoscontainer">


				<?php
					$data_video = getdatavideo($_GET['watch']);

					if($row = mysqli_fetch_array($data_video)){
						echo '<div id="bestvideo">
							<video id="thebestvideo" class="video-js vjs-default-skin vjs-big-play-centered"
								controls preload="auto" width="640" height="364"
								poster="./thumbnail/large/'.$_GET['watch'].'.png"
								data-setup="{}"
							>

							<source src="./video/'.$_GET['watch'].'.'.$row['VideoType'].'" type="video/'.$row['VideoType'].'"/>
							<p class="vjs-no-js">To view this video please enable javaScript</p>
							</video>
						</div>
						<h2>'.$row['videoName'].'</h2>';
						echo '<br>';
						echo '<div id= descripcion width="640">
                                '.$row['Description'].'
						      </div>';
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