<?php
	session_start();



	include './dataAcces/dataAcces.php';
	include './dataAcces/configs.php';
	include './commonhtml/htmlwritter.php';
	include './commonphp/checklogin.php';

	global $max_file_size_bytes;

	if(isset($_SESSION['usrid'])){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		  if(isset($_FILES['upvideo']) && isset($_POST['videotitle']) && isset($_POST['videodescription']) && $_POST['videotitle'] != ''){
			if($_FILES['upvideo']['size'] > $max_file_size_bytes){
		      $alert = 'file to big';
			}else{
			  $ext = pathinfo($_FILES['upvideo']['name'], PATHINFO_EXTENSION);
			  $valid_formats = array('ogg','mp4','webm');
			  $dir = "./video/";
			  if(in_array($ext, $valid_formats)){ //better check mime type
				$uniq = lastid() + 1;//other options sha1_file($_FILES['upvideo']['tmp_name']) or uniqid('',true) for a 23 char long
				$uniq_file_name = $uniq.".".$ext;
			    if(move_uploaded_file($_FILES['upvideo']['tmp_name'], $dir.$uniq_file_name)){
					shell_exec('ffmpeg -i "./video/'.$uniq_file_name.'" -ss 00:00:10 "./thumbnail/large/'.$uniq.'.png" -y 2>&1'); //if you got an error try echo(ing) this
					shell_exec('ffmpeg -i ./thumbnail/large/'.$uniq.'.png -s 160x120 ./thumbnail/little/'.$uniq.'.png -y 2>&1');
					insertvideo($uniq,$_POST['videotitle'],$_POST['videodescription'],$_SESSION['usrid'],$ext,date('Y/m/d'));
					$alert = "Your file has been uploaded";
				} 

			  }else{
				$alert = 'no compatible format';
			  }
	        }
	      }else{
	      	$alert = 'The video was not uploaded';
	      	if($_POST['videotitle'] = ''){
	      		$alert = " you have to specify a title";
	      	}
	      }
		}
	}else{
		$alert = 'Wait!, you need to Sigin just before you upload a video, we\'ll wait';
	}
?>
<html>
<head>
	<title>Video colector, Upload your video</title>
	<script type="text/javascript" src="./jquery/jquery-1.11.1.min.js"> </script>
	<link rel="stylesheet" type="text/css" href="./bootstrap-3.2.0-dist/css/bootstrap.css">
    <script type="text/javascript" src="./bootstrap-3.2.0-dist/js/bootstrap.js"> </script>
	<link rel="stylesheet" type="text/css" href="./css/upload.css">
	<?php if(isset($_SESSION['usrid'])) echo '<script type="text/javascript" src="javascript/upload.js"></script>'; ?>

	<link rel="stylesheet" type="text/css" href="./css/principal.css">

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
				<form action="index.php" method="get">
					<INPUT class = "btn-custom" TYPE=SUBMIT VALUE=" Search ">
					<INPUT id = "txtinput-custom" type="search" name="search" size=70>
				</form>
			</div>
		</div>

        <div id= "content">
			<?php
				write_menu(); //from ./commonhtml/htmlwritter.php
		     
	         ?>
	        <div id="uploadcontrols">
	            <form id="tform" method="post" action="" enctype="multipart/form-data" onsubmit="startPbar()">
	              <br>
	              <div id="left_upcontrols">
	                <div id="video_prev"></div>
	                <div id="bar" style="display:none">
	                <div id="bar_color"></div>
                    <div id="status">0%</div ></div>

	                <br>
	                <?php
	            	  if(isset($alert)){
			            echo '<p id="alert" style="color:red">'.$alert.'</p>';
			          }else{
                        echo '<p id="alert" style="color:red"></p>';
			          }

	                  if(isset($_SESSION['usrid'])){
		                echo '<input type="hidden" value = "tform"
		                name= "'.ini_get("session.upload_progress.name").'">';
		                echo '<input class="btn-custom" id="file" name="upvideo" type="file" accept="video/mp4|video/ogg|video/webm" onchange="processfile();"/>';
		                echo '<br><br>';
		                echo '<input class="btn-custom" type="submit" name="submit" value="Submit"/>';
    	              
    	              }
    	            ?>
    	           </div>
    	           <div id="right_upcontrols"> 
    	              <br>
    	           	  <?php
    	           	    if(isset($_SESSION['usrid'])){
    	           	    	echo '*Title: <input type="text" name="videotitle" />';
    	           	    	echo '<br><br>';
    	           	    	echo 'Description: <textarea type="text" name="videodescription" cols="40" rows="7"></textarea>';
    	           	    	echo '<br><br>';
    	           	    	echo '* you need to specify a title';
    	           	    }
    	           	  ?>
    	           </div>

                </form>
    	        
 
    	    </div>
    	    
    	</div>
    </div>
        <?php
	      write_bottompanel(); //from ./commonhtml/htmlwritter.php
	    ?>
</body>
</html>