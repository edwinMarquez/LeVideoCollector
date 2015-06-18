<?php
	session_start();
	//functions to log in or log out verification
	include './commonphp/checklogin.php';
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
                              <form action = "index.php" method="get" class="logOut">
                              <input type="hidden" name="logout" value="true" />
                              <button class = "btn btn-info navSignUp href="explore.php"" role="button" type="submit">Log Out</button>
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
										 			<img src="images/egg.png"/>
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

				

       

			
				<div class="col-md-10 col-md-offset-1">
					<!-- right makes images goes to right and text alig left  -->
					<div class="info image_right"> 
						<img class="image_right" src="images/look.png"/>
						<h1>What's Video Collector?</h1>
						<p>Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an</p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<!-- right makes images goes to right and text alig left  -->
					<div class="info image_left"> 
						<img class="image_left" src="images/sf-house.png"/>
						<h1>Live in the bay area? Upload your video!</h1>
						<p>Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an</p>
					</div>
				</div>
			</div>

			

				


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

