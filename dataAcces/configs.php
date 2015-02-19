<?php

//$url = parse_url(getenv('DATABASE_URL'));
//database parameters
$db_host = 'localhost';  //$url["host"];
$db_usr = 'postgres'; //$url["user"];
$db_pwd =  'root';  //$url["pass"];
$db_name = 'videocolector';  //ltrim($url["path"],'/');
$db_port = '5432';//$url["port"];

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