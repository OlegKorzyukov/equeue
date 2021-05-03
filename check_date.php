<?php 
include 'db.php';

			$tz = 'Europe/Kiev';
			$timestamp = time();
			$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
			$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
			$time_past = $dt->format('H:i');
			$date_now = $dt->format('Y-m-d');

		
$date = json_decode($_POST['date']);
$date = stripslashes($date);
$date = htmlspecialchars($date);
$date = trim($date);
$date = strtotime($date); // переводит из строки в дату
$date = date("Y-m-d", $date); // переводит в новый формат


$dateObject = new DateTime($date);
$dateFridayCheck = $dateObject->format('l');//Изменение формата времени поступающего со скрипта

$timequeue = R::find('busy', ' dataqueue = ? AND services_type_slug = ?', array($date, "subs"));//поиск времени по выбраной дате

	if($dateFridayCheck == "Friday"){//Проверка на Пятницу и изменение времени
		$date_main = array('08:30','09:00','09:30','10:00','10:30','11:00','11:30', '12:00', '12:30', '13:00','13:30','14:00','14:30','15:00');
	}else{
		$date_main = array('08:30','09:00','09:30','10:00','10:30','11:00','11:30', '12:00', '12:30', '13:00','13:30','14:00','14:30','15:00','15:30');
	}

	
//Проверка, если выбрали текущую дату то вычитаем время которое уже прошло
if($date == $date_now){

foreach ($date_main as $hours) {
		if($hours < $time_past){
			$old_time[] = $hours;
		}
	}
	
$date_main = array_diff ($date_main, $old_time);//вычисление свободного времени
$date_main = array_values($date_main);//пересчет ключей массива после вычисления

}
	

foreach ($timequeue as $key => $value) {
	$date_bd[] = $value->timequeue;
}


if(!empty($date_bd)){
	$uarr = array_count_values ($date_bd); //подсчет количества записей на одно время

	foreach($uarr as $key => $value){ // если запись на одно время будет больше 3 добавляем это значение в новый массив temp

	if( ($value >= 3) or ($key == "12:00" and $value >= 1) or ($key == "12:30" and $value >= 1) or ($key == "13:00" and $value >= 2) or ($key == "13:30" and $value >= 2) ){
		$temp[] = $key;
		unset($uarr[$key]);
		}
	}
	}


if($temp){
	
	$free_time = array_diff($date_main, $temp);//вычисление свободного времени
	
	if(empty($free_time)){
		echo("На цю дату весь час занятий");
	}else{
		$free_time = array_values($free_time);//пересчет ключей массива после вычисления
		$free_time = json_encode($free_time);//кодирование в формат json
		print_r($free_time);//передача данных свободного времени в main.js
	}
}else{
	$date_main = json_encode($date_main);//кодирование в формат json
	print_r($date_main);
}

 ?>