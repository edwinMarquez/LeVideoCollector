<?php
	session_start();
    date_default_timezone_set("America/New_York");
    

	include './dataAcces/dataAcces.php';
	include './dataAcces/configs.php';
	include './commonhtml/htmlwritter.php';
	include './commonphp/checklogin.php';

	global $max_file_size_bytes;
	$dirffmpeg = './extras/ffmpeg';
	$dirscript = './extras/convertvid_scripts.sh';

	if(isset($_SESSION['usrid'])){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		  if(isset($_FILES['upvideo']) && isset($_POST['videotitle']) && isset($_POST['videodescription']) && $_POST['videotitle'] != ''){
		  	
		  	$tname = $_POST['videotitle']; 
		  	$tname = (strlen($tname)>50)?substr($tname,0,47)."...":$tname;//truncate the name

			if($_FILES['upvideo']['size'] > $max_file_size_bytes){
		      $alert = 'file to big';
		      $type = 'alert-danger';
			}else{
			  $ext = pathinfo($_FILES['upvideo']['name'], PATHINFO_EXTENSION);
			  $valid_formats = array('ogv','mp4','webm');
			  $dir = "./video/";
			  if(in_array($ext, $valid_formats)){ //better check mime type
				$uniq = lastid() + 1;//other options sha1_file($_FILES['upvideo']['tmp_name']) or uniqid('',true) for a 23 char long
				$uniq_file_name = $uniq.".".$ext;
			    if(move_uploaded_file($_FILES['upvideo']['tmp_name'], $dir.$uniq_file_name)){
					shell_exec($dirffmpeg.' -i "./video/'.$uniq_file_name.'" -ss 00:00:01 "./thumbnail/large/'.$uniq.'.png" -y 2>&1'); //if you got an error try echo(ing) this
					shell_exec($dirffmpeg.' -i ./thumbnail/large/'.$uniq.'.png -s 160x120 ./thumbnail/little/'.$uniq.'.png -y 2>&1');  //on server ffmpeg is in the /usr
					insertvideo($uniq,$tname,$_POST['videodescription'],$_SESSION['usrid'],$ext,date('Y/m/d'));
					shell_exec('sh '.$dirscript.' '.$uniq.' '.$ext.' > /dev/null 2>/dev/null &');  //call bash script independently
					$alert = "Your file has been uploaded";
					$type = 'alert-success';
				}

			  }else{
				$alert = 'no compatible format';
				$type = 'alert-danger';
			  }
	        }
	      }else{
	      	$alert = 'The video was not uploaded';
	      	$type = 'alert-danger';
	      	if($_POST['videotitle'] = ''){
	      		$alert = " you have to specify a title";
	      		$type = 'alert-danger';
	      	}
	      }
		}
	}else{
		$alert = 'Wait!, you need to Sigin just before you upload a video, we\'ll wait';
		$type = 'alert-danger';
	}
?>
<html>
<head>
	<title>Video colector, Upload your video</title>
	<script type="text/javascript" src="./jquery/jquery-1.11.1.min.js"> </script>
	<script type="text/javascript" src="./bootstrap-3.3.2-dist/js/bootstrap.min.js"> </script>
	<link rel="stylesheet" type="text/css" href="./bootstrap-3.3.2-dist/css/bootstrap.min.css">
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
    <div id="principal" class="panel panel-default">

    	<?php
			write_title(); //from ./commonhtml/htmlwritter.php
		?>

        <div id= "content" class="panel-body">
        
	        <div id="uploadcontrols">
	            <form id="tform" method="post" action="" enctype="multipart/form-data" onsubmit="startPbar()">
	              <br>
	              <div id="left_upcontrols">
	                <div id="video_prev"></div>
	                <div id="bar" style="display:none">
	                 <div class="progress" style="margin-bottom:0px;">
                       <div class = "progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                         0%
                       </div>
                     </div>
	                </div>

                    

	                <br>
	                <?php
	            	  if(isset($alert)){
			            echo '<div id="alert" class="alert '.$type.'">'.$alert.'</div>';
			          }else{
                        echo '<div id="alert"></div>';
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