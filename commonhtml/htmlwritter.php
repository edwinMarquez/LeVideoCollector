<?php

	/**
	* this function echo the html code for the title (or banner)
	* @return none
	*
	**/
	function write_title(){
		echo '<div id="title">
				<h1><a href="index.php">Le Video</a></h1>
		      </div>';
	}

	/**
	* this function echo the panel at the bottom
	*
	* @return none
	*
	**/

	function write_bottompanel(){
		echo '<div id="bottompanel" class="panel-footer">
				we keep the right to delete any video<br>
				all content uploaded is responsability of the uploader<br>
			  </div>';
	}

	/**
	* this function echo the sign in , and log in options with its var (uses bootstrap)
	* @return none
	*
	**/
	function write_login_sigin(){
		echo '<nav id="top-bar" class="navbar navbar-default navbar-fixed-top" >
        		<div class="container-fluid">
                  <div class="navbar-header">

                  	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-video-colector-responsive">
        			 <span class="sr-only">Toggle navigation</span>
        			 <span class="icon-bar"></span>
       				 <span class="icon-bar"></span>
        			 <span class="icon-bar"></span>
      				</button>

      				<a class="navbar-brand" href="./index.php">
        				<img alt="Lvc" src="./images/logo_li.png">
      				</a>

                  </div>';
                  echo '<div class="collapse navbar-collapse" id="menu-video-colector-responsive">';
                  write_menu_part();
                  write_search_part();
            echo '<ul class = "nav navbar-nav navbar-right"> 
                      
                        <ul class="nav navbar-nav">
          			      <li class="dropdown">
          				    <a class="dropdown-toggle" href="#" data-toggle="dropdown" >Sign Up<b class="caret"></b></a>
          				    <ul class="dropdown-menu" style="padding: 10px; padding-bottom: 0px;">                          
                              <form action="'.htmlentities($_SERVER['PHP_SELF']).'" method="post" accept-charset="UTF-8">
                                Name: <br><input id="user_username" style="margin-bottom: 15px;" type="text" name="unusername" size="30" />
                                <br>Email: <br><input id="user_useremail" style="margin-bottom: 15px;" type="email" name="unuseremail" size="30" />
                                <br>Password: <br><input id="user_userpass" style="margin-bottom: 15px;" type="password" name="unpassword" size="30" />
                                <br><input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" name="commit" value="Sign Up" />
                                <br>
                              </form>
            			    </ul>
          			      </li>
                     
         			   <li class="dropdown">
            			 <a class="dropdown-toggle" href="#" data-toggle="dropdown" >Sign In <b class="caret"></b></a>
            			 <ul class="dropdown-menu" style="padding: 10px; padding-bottom: 0px;">
              				<form action="'.htmlentities($_SERVER['PHP_SELF']).'" method="post" accept-charset="UTF-8">
  								Email:<br><input id="user_username" style="margin-bottom: 15px;" type="text" name="acuseremail" size="30" />
  								<br>Password:<br><input id="user_password" style="margin-bottom: 15px;" type="password" name="acpassword" size="30" />
  								<br><input id="user_remember_me" style="float: left; margin-right: 10px;" type="checkbox" name="user[remember_me]" value="1" />
  								<br><label class="string optional" for="user_remember_me"> Remember me</label>
  				  				<input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" name="commit" value="Sign In" />
  				  				<br>
			  				</form>
            			 </ul>
          			   </li>
          		     <ul>
          		    

          		   </ul>

                 </div>
        	  </div> 
			</nav>';
	}

	/**
	* in case the user is loged in this function echo a welcome mesage
	*
	* @return none
	*
	**/
	function write_loged_user_msg(){
		echo '<nav id="top-bar" class="navbar navbar-default navbar-fixed-top">
				
				<div class="container-fluid">
                  <div class="navbar-header">
                  	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-video-colector-responsive">
        			 <span class="sr-only">Toggle navigation</span>
        			 <span class="icon-bar"></span>
       				 <span class="icon-bar"></span>
        			 <span class="icon-bar"></span>
      				</button>
      				<a class="navbar-brand" href="#">
        				<img alt="Lvc" src="./images/logo_li.png">
      				</a>
                  </div>';
                echo '<div class="collapse navbar-collapse" id="menu-video-colector-responsive">';
                  write_menu_part();
                  write_search_part();
				echo '<ul class = "nav navbar-nav navbar-right"> 

				<ul class = "nav navbar-nav">

					<li><p class="navbar-text" style="color:black">Welcome '.$_SESSION['name'].'</p></li>

					<li >
						<a href="upload.php">Upload</a>                  
					</li>
					<li >
						<a href="'.htmlentities($_SERVER['PHP_SELF']).'?logout=true" >Log Out</a>
					</li>
				</ul>

			   </ul>

              </div> <!-- menu video colector responsive-->
			  </div> <!--container fluid -->
			</nav>';

	}  


/**
*
* writes the menu as part of the bootstrap nav bar
*
* @return none
*
**/
function write_menu_part(){
	echo   '<ul class="nav navbar-nav">
				<li><a href="index.php?sort=recent">Most recent</a></li>
				<li><a href="index.php?sort=bestq">Best qualified</a></li>
				<li><a href="#" onClick="alert(\'We put(you put) videos here :D\')";>About</a></li>
			</ul>';
}


/**
*
* writes the search form in the bootstrap nav bar
* 
* @return none
*
**/
function write_search_part(){
	echo '<form class="navbar-form navbar-left" role="search" action="index.php" method="get">
	       <div class="form-group">
			 <INPUT type="search" name="search">
		   </div>
		   <button class = "btn btn-default" TYPE="SUBMIT">Search</button>
	     </form>';
}



?>