<?php
	session_start();
	//functions to use the database
	include './dataAcces/dataAcces.php';
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
      				<a class="navbar-brand" href="#"><img class="logo"src="images/logo-nav.png"/></a>
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
   </header> <!-- header section end -->

   

   <div class="jumbotron" id="jumbotron-home">

   	<div class ="container">
   		<div class="xs "></div>
   		<div class="look-lg"></div>
   		<div class="col-md-6 col-md-offset-3">
   	<div id="explore-title">
   	<h2>The best videos of
   		<br> <h1>The Bay Area</h1></h2>
   	</div>
   	<div class="upload"> <!-- Open login Modal -->
	<a class="btn btn-primary btn-lg customise" id="blue" href="upload.php"></h2>Upload Video!</h2></a>
	</div>
   </div>
   </div>
   </div>


   <!-- the trend section for popular videos, in home page -->
		<div class="trend">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
			  </ol>

			<div class="carousel-inner" role="listbox">
			    <div class="item active">
				   <div class="container">	
			  		 <div class = "row">

			  		<?php 
                            $page = isset($_GET['page'])?$_GET['page']:0;
                            $page2 = isset($_GET['page2'])?$_GET['page2']:0;
                            
                            if(isset($_GET['search'])){
                            	$look = searchString($_GET['search'], $page);
                            }else $look = searchBestRated($page, 12);

			  		        if($look){ //showing 12 videos
			  				$separator = 0;
			  					while($row = pg_fetch_array($look)){ 
			  					    $separator += 1;?>
			  						<div class = "col-xs-8 col-sm-6 col-md-3 col-lg-3">
			  						<div class = "video_thumbnail">
			  						<a href = <?php echo '"./watchvideo.php?watch='.$row['idvideo'].'"'; ?> >
			  						<img src = <?php echo '"./thumbnail/little/'.$row['idvideo'].'.png"'; ?> >
			  						<div class = "description_video">
			  						<p><?php echo htmlspecialchars($row['videoname']); ?></p>
			  						<div class="video_author">
			  						<p><?php echo htmlspecialchars($row['username']); ?></p>
			  					    </div>
			  						</div>
			  						</a>
			  					    </div>
			  						</div>
			  					<?php if($separator % 4 == 0){ ?>
			  				      </div>
			  		              </div>
			  			          </div>
                                <div class="item">
							      <div class="container">	
			  					    <div class = "row">          	
                                          <?php  } //end if
			  						      }   //end while
			  						    }
			  					        ?>

			  	     </div>
			       </div>
			    </div>
			</div>

			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

				</div>
			
			</div>
							
		</div> 
		<!--******  trend end **************-->

		<div class="container">

			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="explore">
						<h2>Explore more Videos!</h2>

                    <?php $totalvid = (isset($_GET['search']))?totalpages_searchstring($_GET['search']):totalpages();
			        $totalvid = ($totalvid == 0)?1:$totalvid;
			        $totalvid2 = totalpages();
			        $totalvid = ($totalvid2 == 0)?1:$totalvid2;?>

					<nav>
					  <ul class="pagination pagination-lg ">
					    <li>
					      <?php if($page == 0){ $prevstring = '#'; 
					            }else{ $prevstring = "./explore.php?page=".($page - 1)."&page2=".$page2; } ?>

					      <a href=<?php echo '"'.$prevstring.'"' ?>  aria-label="Previous">
					        <span aria-hidden="true">&laquo;</span>
					      </a>
					    </li>
					    <li class="active"><a href="#"><?php echo $page + 1; ?></a></li>
					    

					    <li>
					      <?php if($page >= ($totalvid - 1)){ $nextstring = "#"; }
					            else{ $nextstring = "./explore.php?page=".($page + 1)."&page2=".$page2;  } ?>

					      <a href=<?php echo '"'.$nextstring.'"' ?> aria-label="Next">
					        <span aria-hidden="true">&raquo;</span>
					      </a>
					    </li>
					  </ul>
					</nav>
					</div>
					</div>
					</div>

				<div class = "row">

				<?php
                            
                    $look2 = searchMoreRecent($page2);
			  		    if($look2){ //showing 12 videos
			  			    $separator = 4;
			  				while($row2 = pg_fetch_array($look2)){ ?>
			  					<div class = "col-xs-8 col-sm-6 col-md-3 col-lg-3">
			  					<div class = "video_thumbnail">
			  					<a href = <?php echo '"./watchvideo.php?watch='.$row2['idvideo'].'"'; ?> >
			  					<img src = <?php echo '"./thumbnail/little/'.$row2['idvideo'].'.png"'; ?> >
			  					<div class = "description_video">
			  					<p><?php echo htmlspecialchars($row2['videoname']); ?></p>
			  					<div class="video_author">
			  					<p><?php echo htmlspecialchars($row2['username']); ?></p>
			  				    </div>
			  				    </div>
			  				    </a>
			  					</div>
			  				    </div>
			  					<?php if($separator % 4 == 0 and $separator != 4){ ?>
			  				    </div>
			  		            </div>
			  			        </div>
                                <div class="item">
							      <div class="container">	
			  					    <div class = "row">          	
                                          <?php  } //end if
			  						      }   //end while
			  						    }
			  	?>


			  	</div>


			  			<div class="explore">



					<nav>
					  <ul class="pagination pagination-lg ">
					    <li>
					      <?php if($page2 == 0){ $prevstring = '#'; 
					            }else{ $prevstring = "./explore.php?page=".$page."&page2=".($page2 - 1); } ?>

					      <a href=<?php echo '"'.$prevstring.'"' ?>  aria-label="Previous">
					        <span aria-hidden="true">&laquo;</span>
					      </a>
					    </li>
					    <li class="active"><a href="#"><?php echo $page2 + 1; ?></a></li>
					    

					    <li>
					      <?php if($page2 >= ($totalvid2 - 1)){ $nextstring = "#"; }
					            else{ $nextstring = "./explore.php?page=".$page."&page2=".($page2 + 1);  } ?>

					      <a href=<?php echo '"'.$nextstring.'"' ?> aria-label="Next">
					        <span aria-hidden="true">&raquo;</span>
					      </a>
					    </li>
					  </ul>
					</nav>
			


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
			</body>
			</html>
