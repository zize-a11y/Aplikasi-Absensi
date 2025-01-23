<?php
$host = "localhost" ;
$user = "root" ;
$pass = "" ;
$name = "sistem" ;

$link = new mysqli($host,$user,$pass,$name) ;


if(!$link){
	echo "Database tidak terhubung" ;
}

?>
