<?php
	session_start();
    date_default_timezone_set("America/New_York");
    

	include './dataAcces/dataAcces.php';
	include './dataAcces/configs.php';
	include './commonphp/checklogin.php';

	global $max_file_size_bytes;
	$dirffmpeg = './extras/ffmpeg';
	$dirscript = './extras/convertvid_scripts.sh';

	if(isset($_SESSION['usrid'])){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		  if(isset($_FILES['upvideo']) && isset($_POST['videotitle']) && isset($_POST['videodescription']) &&  isset($_POST['videolocation']) && $_POST['videotitle'] != ''){
		  	
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
					insertvideo($uniq,$tname,$_POST['videodescription'],$_SESSION['usrid'],$ext,date('Y/m/d'), $_POST['videolocation']);
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


<DOCTYPE html>

	<!-- template for videocollector -->

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Video Collector</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->


		<!--jquerry-->
	<script type="text/javascript" src="jquery/jquery-1.11.1.min.js"> </script>
	<!--Your good friend bootstrap-->
	<script type="text/javascript" src="bootstrap-3.3.4-dist/js/bootstrap.min.js"> </script>
		<link rel="stylesheet" type="text/css" href="bootstrap-3.3.4-dist/css/bootstrap.css">
    <script type="text/javascript" src="javascript/principal.js"> </script>
    <?php if(isset($_SESSION['usrid'])) echo '<script type="text/javascript" src="javascript/upload.js"></script>'; ?>


    <!-- new stylesheet -->
		<link rel="stylesheet" href="css/style.css">
		<!--[if it IE 9]>
		<script src="js/html5shim.js"></script>
		<![endif] -->
	</head>

	<body>

		<header>

	<!-- Menu bar, brand, search and links log in sign up -->
			<nav class="navbar navbar-default">
  				<div class="container-fluid">
       				<div class="navbar-header">
      				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
        			<span class="sr-only">Toggle navigation</span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
      				</button>
      				<a class="navbar-brand" href="index.php"><img class="logo"src="images/logo-nav.png"/></a>
    				</div>

    				<!-- /.navbar-collapse -->
    				<div class="collapse navbar-collapse" id="menu">
      					<ul class="nav navbar-nav">
        				<li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
        				<li><a href="about.php">About</a></li>
        				<!-- <li><a href="#">Contact</a></li> -->
      					</ul>
      						<form class="navbar-form navbar-left" role="search" action = "explore.php" method = "get">
        					<div class="form-group">
          					<input type="text" class="form-control" placeholder="Search" name="search">
        					</div>
        					<button type="submit" class="btn btn-info">Submit</button>
      						</form>

          					<div class="nav navbar-nav navbar-right">

          					<ul class="nav navbar-nav navLogIn">

                            <?php if(isset($_SESSION['name'])){ ?>  <!-- if its logged in  -->
                            <li><a>Welcome <?php echo $_SESSION['name']; ?></a></li> <!-- ser -->
                            <li>
                              <form action = "index.php" method="get">
                              <input type="hidden" name="logout" value="true" />
                              <button class = "btn btn-info navSignUp" role="button" type="submit">Log Out</button>
                              </form>
                            </li> <!-- ser -->
                            <?php }else{ ?>                           <!-- if its not logged -->
          					<li><a href="#" data-target="#logIn" data-toggle="modal">Log In</a></li> <!-- Opens log in modal -->
          						<!-- Opens sign up modal-->
							<li><button class="btn btn-info navSignUp" role="button" data-target="#signUp" data-toggle="modal">Sign Up
							</button> </li>
							<?php } ?>

							</ul>
					
							</div>
     						
     				</div><!-- /.navbar-collapse -->
  				</div><!-- /.container-fluid -->
			</nav>
	<!-- End of menu bar, brand, search and links log in sign up -->


			<!--***************** Modal Log In****************** -->
								<div class="modal fade" id="logIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								      	
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								       <h2>Welcome!</h2>
								      </div>

								      <div class="modal-body">
								      	<div class="container-fluid">
								      		<div class="row">
								      			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

											        <form action = "index.php"  method = "post"> <!-- Login form -->
													
													  	<div class="form-group">
													    <label for="input_email">Email address</label>
													    <input type="email" class="form-control" id="input_email" placeholder="Enter email" name="acuseremail">
													  </div>
													  <div class="form-group">
													    <label for="InputPassword">Password</label>
													    <input type="password" class="form-control" id="InputPassword" placeholder="Password" name="acpassword">
													  </div>
													  
													  <button type="submit" class="btn btn-default">Submit</button>
													  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
													</form>

										 		</div>

										 		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										 			...
										 		</div>

											</div>
										</div>

								      </div>
								      <div class="modal-footer">
								      </div>
								    </div>
								  </div>
								</div> 
				<!--************************ Ends Modal ****************-->

				<!--***************** Modal sign up****************** -->
								
								<div class="modal fade" id="signUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								      	
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								       <h2>Sign Up, its free and easy</h2>
								      </div>

								      <div class="modal-body">
								      	<div class="container-fluid">
								      		<div class="row">
								      			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

											        <form action = "index.php" method = "post"> <!-- sign Up form -->
													  <div class="form-group">
													  	<label for="user_name">User name</label>
													    <input type="text" class="form-control" id="user_name" placeholder="Enter user name" name = "unusername">
													  	</div>
													  	<div class="form-group">
													    <label for="input_email">Email address</label>
													    <input type="email" class="form-control" id="input_email" placeholder="Enter email" name = "unuseremail">
													  </div>
													  <div class="form-group">
													    <label for="InputPassword">Password</label>
													    <input type="password" class="form-control" id="InputPassword" placeholder="Password" name = "unpassword">
													  </div>
													  
													  <button type="submit" class="btn btn-default">Submit</button>
													  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
													</form>

										 		</div>

										 		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										 			...
										 		</div>

											</div>
										</div>

								      </div>
								      <div class="modal-footer">
								      </div>
								    </div>
								  </div>
								</div> 
			<!--********************** Ends Modal *******************-->



		</header> 
		<!-- header section end -->

		<div class="jumbotron" id="jumbotron-home">	
			<div class="ola">
				<div class="top_ola">
				</div>
			</div>
		

		<div class="container">
			<div class=row>	

				<div class="col-md-6 col-md-offset-3">


					<form id="tform" method="post" action="" enctype="multipart/form-data" onsubmit="startPbar()"> <!-- this is the upload form -->


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
		                  echo '<input class="btn btn-large btn-info" id="file" name="upvideo" type="file" accept="video/mp4|video/ogg|video/webm" onchange="processfile();"/>';
		                  echo '<br><br>';
    	                }
    	              ?>

						<div class="form-group">
						<label for="video_title">Title</label>
						<input type="text" class="form-control" id="video_title" placeholder="Enter video title" name="videotitle">
						</div>
						<div class="form-group">
						<label for="place">Where do you take it?</label>
						<input type="text" class="form-control" id="place" placeholder="Enter video location" name = "videolocation">
						</div>
						<div class="form-group">
						<label >What's about?</label>
						<textarea class="input-lg col-xs-12 col-sm-12 col-md-12" id="commenttext" type="text" rows="2" name ="videodescription" > </textarea>
						</div>
						<div class="upload">								  
						<button type="submit" class="btn btn-primary btn-lg customise" id="blue" >Submit</button>
						 </div>
						</form>


			</div>
		</div>
		</div>
	</div>



		<footer>

			<div class="container">
				<div class="row">

					<div class="col-xs-12 col-sm-8 col-md-8">
						 
						<div class="logo-foot"></div>
						<h1 style = "color: #999">Video Colector</h1>


						<p style = "color: #999">Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an</p>
					

					</div>

					<div class="col-xs-12 col-sm-4 col-md-4">
						<a href="https://www.facebook.com/videocollector" ><img src="images/facebook.png"/></a>
						<a href="https://www.twitter.com/videocollector" ><img src="images/twitter.png"/></a>
					<h1>You like it?</h1>
					<p>We need some feedback</p>

					</div>
					</div>


					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<p style="font-size:10px; text-align:center;  margin-bottom:-20px">The site is not responsible for the content that the users upload</p> 
						</div>
					</div>

				

			</div>


		</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</body>




</html>

