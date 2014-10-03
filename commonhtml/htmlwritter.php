<?php
	/**
	* This function echo the html code for the menu
	* @return none
	*
	*/
	function write_menu(){

		echo '<div id="menu">
				<h3>Some more</h3>
				<hr>
				<ul>
					<a href="index.php"><li>Home</li></a>
					<a href="index.php?sort=recent"><li>Most recent</li></a>
					<a href="index.php?sort=bestq"><li>Best qualified</li></a>
					<a href="#" onClick="alert(\'We put(you put) videos here :D\')";><li>About</li></a>
				
				</ul>
			  </div>';
	}

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
		echo '<div id="bottompanel">
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
		echo '<header class="navbar navbar-static-top bs-docs-nav" role="banner">
        		<div class="container">
                  <div class="navbar-header"></div>
                  <div class="navbar-collapse collapse">
                  <div class = "navbar-form navbar-right"> 
                   <div class= "form-group">
                   <ul class="nav navbar-nav">
          			<li class="dropdown">
          				<a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign Up<b class="caret"></b></a>
          				<div class="dropdown-menu" style="padding: 10px; padding-bottom: 0px;">
                          
                          <form action="'.htmlentities($_SERVER['PHP_SELF']).'" method="post" accept-charset="UTF-8">
                              Name: <input id="user_username" style="margin-bottom: 15px;" type="text" name="unusername" size="30" />
                              Email: <input id="user_useremail" style="margin-bottom: 15px;" type="email" name="unuseremail" size="30" />
                              Password: <input id="user_userpass" style="margin-bottom: 15px;" type="password" name="unpassword" size="30" />
                              <input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" name="commit" value="Sign Up" />
                          </form>


            			</div>
          			</li>
          			</ul>

          		   </div>


                   <div class="form-group">
                   <ul class="nav navbar-nav">
         			<li class="dropdown">
            			<a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign In <b class="caret"></b></a>
            			<div class="dropdown-menu" style="padding: 10px; padding-bottom: 0px;">
              				<form action="'.htmlentities($_SERVER['PHP_SELF']).'" method="post" accept-charset="UTF-8">
  								Email:<input id="user_username" style="margin-bottom: 15px;" type="text" name="acuseremail" size="30" />
  								Password:<input id="user_password" style="margin-bottom: 15px;" type="password" name="acpassword" size="30" />
  								<input id="user_remember_me" style="float: left; margin-right: 10px;" type="checkbox" name="user[remember_me]" value="1" />
  								<label class="string optional" for="user_remember_me"> Remember me</label>
  				  				<input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" name="commit" value="Sign In" />
			  				</form>
            			</div>
          			</li>
          		   <ul>
          		  </div>

                 </div>
                </div>
        	  </div>
			</header>';
	}

	/**
	* in case the user is loged in this function echo a welcome mesage
	*
	* @return none
	*
	**/
	function write_loged_user_msg(){
		echo '<header class="navbar navbar-static-top bs-docs-nav" role="banner">
				
				<div class="navbar-collapse collapse">
                 <div class = "navbar-form navbar-right"> 

				<ul class = "nav navbar-nav">

					<li style="padding-top:15px;padding-bottom:0px;padding-right:10px">Welcome '.$_SESSION['name'].'</li>
					<li >
						<a href="upload.php" style="padding-top:5px;padding-bottom:0px"><input class="btn btn-primary" style="clear: left; width: 100%; font-size: 13px; margin-top:0px" type="submit" name="upload" value="Upload" /></a>
					</li>
					<li >
						<a href="'.htmlentities($_SERVER['PHP_SELF']).'?logout=true" style="margin-right:10px;padding-top:5;padding-bottom:0px" ><input class="btn btn-primary" style="clear: left; width: 100%; font-size: 13px; margin-top:0px" type="submit" name="logout" value="Log Out" /></a>
					</li>
				</ul>
			   </div>
			  </div>
			</header>';

	}  



?>