#video collector
Sergio Armando Márquez Hernández. *( Front End)*  @SergioMrqUz <br>
Edwin Samuel Márquez Hernández. *( Back End)*  @EdwinMrqz <br>

Video Collector.  site: http://104.236.230.191/levideocolector/index.php <br>

------
<br>

Requirements:<br> 

1. php (and all it requires to work with, the project is fully written in php). <br> <br>
2. postgres <br><br>
3. ffmpeg library installed and working. (This library is used to take the thumbnails of the videos uploaded and convert them to other formats: mp4, ogv, webm. I'm taking two of different sizes by now, xampp user beware you may have to update some libraries manually to make it work).<br><br>
4. mediaelement as an html5 player<br> <br>

![bloqBreaker 1](/screenshots/levideocollector.png)<br>
-----
Inner working: <br>

When a video is uploaded, it is converted to mp4, ogg and webm formats at a standard resolution using a bash script and the ffmpeg library, so that every video can be seen on different browsers. Two images are algo taken for display.<br>

This website uses a database to store information about the users, videos comments and likes. 
the script is included in the folder “databasecreation”.<br>

In the folder “dataAcces” you can find a file called: “configs.php” that contains configuration values like the password of your database, user name of the database, etc. there are comments included in the file. <br>

Everything related to interacting directly with the database is included in the other file called “dataAcces.php”.<br>

![bloqBreaker 2](/screenshots/levideocollector_explore.png)<br>
![bloqBreaker 3](/screenshots/levideocollector_upload.png)<br>

 
