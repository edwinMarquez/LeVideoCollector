<?php

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
//database parameters
$db_host = $url["host"];
$db_usr = $url["user"]
$db_pwd = $url["pass"]
$db_name = substr($url["path"],1);

//$url = '';
//database parameters
//$db_host = 'localhost';
//$db_usr = 'postgres';
//$db_pwd = 'root';
//$db_name = 'videocolector';

//display parameters
$numofVideos = 9; //the number of video thumbnails to show on every page
 
//file upload parameters
$max_file_size_bytes = 943718400;

?>