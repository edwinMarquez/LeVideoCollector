<?php
  session_start();
  if(!isset($_GET['watch'])){  //if the user did not specify a video to watch go to home screen
    header('Location:index.php');
  }
  $row;

  //functions to use the database
  include './dataAcces/dataAcces.php';
  //functions to log in or log out verification
  include './commonphp/checklogin.php';

  if($datavideo = getdatavideo($_GET['watch'])){
    $row = pg_fetch_array($datavideo);
  }
  


?>

<DOCTYPE html>

	<!-- template for videocollector -->

<html>
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
    <script type="text/javascript" src="./javascript/watchvideo.js"> </script>

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

                              <form action = "watchvideo.php"  method = "post"> <!-- Login form -->
                          
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

      <main role="main">
        <div class="jumbotron"> 
          <div class="container">
            <div class="row"> 

              <div class="col-md-9">
                <div class="video_port"> <!-- title, author and video -->

                  <div class="video_name"> <!-- name of the video -->
                  <h1><?php echo $row['videoname']; ?></h1>
                  </div>

                  <div class="video_author"> <!-- author of the video -->
                  <p><?php echo $row['username']; ?></p>
                  </div>

                  <div id= "video_watch" class="video_watch" value = <?php echo '"'.$_GET['watch'].'"'; ?> > <!-- principal video, value is for the javascript-->
                    <div class="embed-responsive embed-responsive-16by9">
                    <video class="embed-responsive-item" class="video" controls="controls" preload="none" 
                           poster=<?php echo '"./thumbnail/large/'.$_GET['watch'].'.png"'; ?> > 
                           <?php
                           $put_original = false; #to know if every video was loaded
                           if(file_exists('./video/mp4/'.$_GET['watch'].'.mp4'))echo '<source type="video/mp4" src="./video/mp4/'.$_GET['watch'].'.mp4"/>';
                           else $put_original = true;
                           if(file_exists('./video/webm/'.$_GET['watch'].'.webm')) echo '<source type="video/webm" src="./video/webm/'.$_GET['watch'].'.webm"/>';
                           else $put_original = true;
                           if(file_exists('./video/ogv/'.$_GET['watch'].'.ogv')) echo '<source type="video/ogg" src="./video/ogv/'.$_GET['watch'].'.ogv"/>';
                           else $put_original = true;
                           if($put_original)echo '<source src="./video/'.$_GET['watch'].'.'.$row['videotype'].'" type="video/'.$row['videotype'].'"/>';
                          ?>
                    </video>
                    </div>
                  </div>

                </div>


              </div>
              <div class="col-md-3">

                <div class="related"> <!-- dark section for likes, description-->
                  
                  <div class = "toolbar" role="toolbar">
                  How was the video? <br>
                  <!-- like-->
                  <button id = "upvote" type="button" class="btn btn-success">
                  Good <span class="glyphicon glyphicon-thumbs-up"> </span>
                  </button>
                  <span id="upnumber"><?php echo $row['upvotes']; ?></span>
                  <!--No like-->
                  <button id = "downvote" type="button" class="btn btn-danger">
                     Bad <span class="glyphicon glyphicon-thumbs-down"> </span>
                  </button>
                  <span id = "downnumber"><?php echo $row['downvotes']; ?></span>

                  </div>

                   <!-- alert -->
                  <p id="alert" class="bg-danger" style = "display:none;"><br>You need to Sign in before you vote<br><br></p>
                  </div>

                  <div class="description">  
                  <h3>Description</h3> <!-- description of the video -->
                  <p> <?php echo htmlspecialchars($row['description']);?><p>
                  </div>

                   <div class="description">
                    <h3>Where?</h3> <!-- place of the video -->
                   <p><?php echo htmlspecialchars($row['location']) ?></p>
                  </div>                   
              </div>
            </div>
          </div>
        </main>
       


        <div class="container">
          <div class="row">         
            <div class="col-xs-12 col-sm-12 col-md-9"> 
              <div class="upload  hidden-md hidden-lg"> 
              <!-- bottom appears only for small devices --> 
              <a class="btn btn-primary btn-lg customise"></h2>Explore more videos!</h2></a>
              </div>


              <!-- comment section --> 
              <div id = "commentlist"> 
                <!-- area to write comments--> 
                <div id = "postcomment">
                  <p> What do you think? Write a commment</p>
                  <textarea class="input-lg col-xs-12 col-sm-12 col-md-12" id="commenttext" type="text" name="search" rows="2" > </textarea>
                  <button id="post" type="button" class="btn btn-info">Post Comment <span class="glyphicon glyphicon-comment"></span>
                  </button>
                  <p id="alert-comment" class="bg-danger" style = "display:none;"><br>you need to Sign in before you post a comment<br><br></p>
                </div>

                <div id = "commentpart">
                  <?php $comments = getcomments(20, $_GET['watch']);
                    while($commentrow = pg_fetch_array($comments)){?>
                      <div class="comment">
                        <h5><b><?php echo htmlspecialchars($commentrow['username']); ?> Says:</b></h5>
                        <p style="text-indent:40px;text-align:justify"><?php echo htmlspecialchars($commentrow['coment']); ?></p>
                      </div>
                    <?php } //end of while?>

                </div>
              </div> 
            </div>

            <div class="col-md-3">
              <!-- more videos related maybe--> 
              <div class="aside_description hidden-xs hidden-sm "> 
                <h3>More cool videos</h3>
              </div> 
              <div class="aside_description hidden-xs hidden-sm"> 
                <div class="row">

                 <?php $bestv = searchBestRated(0, 4);
                 while($rowBest = pg_fetch_array($bestv)){ ?>
                  <div class="video_thumbnail">
                    <a href=./watchvideo.php?watch=<?php echo $rowBest['idvideo']; ?> > <!--url of video-->
                    <img src= <?php echo '"./thumbnail/little/'.$rowBest['idvideo'].'.png"'; ?> /> <!--thumbnail of video-->
                        <div class="description_video"> <!--description of video-->
                          <p><?php echo htmlspecialchars($rowBest['videoname']); ?></p>
                          <div class="video_author"> <!--author of video-->
                          <p>by <?php echo htmlspecialchars($rowBest['username']); ?><p/>
                          </div>
                       <!--description of video-->
                        </div>
                    </a>
                  </div>
                  <?php  } //end of while?>

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