<?php

if(!file_exists("./inc/config.php")) {
	die("Missing config file!");
}

include("./inc/config.php");
include("./inc/functions.php");

if(!file_exists("./inc/cache.txt")) {
	file_put_contents("./inc/cache.txt", "");
	@chmod(0777, "./inc/cache.txt");
}

if(file_get_contents("./inc/cache.txt") == "") {
	refresh();
}

?>