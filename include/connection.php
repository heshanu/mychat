<?php

$con=mysqli_connect("localhost","root","root","mychat");

if($con->connect_error){
	die();
} 
else{
	echo "connection sucessfull";
}





?>