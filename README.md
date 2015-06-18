Sergio Armando Márquez Hernánde. *( Front End)*  @SergioMrqUz
Edwin Samuel Márquez Hernández. *( Back End)*  @EdwinMrqz

Video Colector.  site: http://104.236.230.191/levideocolector/index.php <br>

------
<br>

Requirements:<br> 

1. php (and all it requires to work with, the project is fully written in php). <br> <br>
2. postgres <br><br>
3. ffmpeg library installed and working. (This library is used to take the thumbnails of the videos uploaded and convert them to other formats: mp4, ogv, webm. I'm taking two of different sizes by now, xampp user beware you may have to update some libraries manually to make it work).<br><br>
4. mediaelement as an html5 player<br> <br>


-----
Inner working: <br>

This website uses a database to store information about the users, videos and comments(still not in use) 
the script and an image of the structure is included in the folder “databasecreation”.

In the folder “dataAcces” you can find a file called: “configs.php” that contains configuration values like the password of your database, user name of the database, etc. there are comments included in the file. 

Everything related to interacting directly with the database is included in the other file called “dataAcces.php”.

 
