<?php 

require 'libs/rb-mysql.php';

$connect = R::setup('mysql:host=;dbname=','','');

if(!R::testConnection()){
	exit ("Немає з'єднання з базою данних");
}

 R::close();

 ?>

