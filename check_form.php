<?php 

require 'db.php';
//R::freeze( TRUE );

	$data = $_POST;

//если кликнули на button
	if ( isset($data['submit']) )
	{
		$errors = array();

		require 'delete_row.php';
			
			$services_type_slug = "subs";
			$services_type = "Запис на оформлення субсидії";
			

			 $fname = stripslashes($data['fname']);
			 $fname = htmlspecialchars($fname);

			 $telephone = stripslashes($data['telephone']);
			 $telephone = htmlspecialchars($telephone);

			 $email = stripslashes($data['email']);
			 $email = htmlspecialchars($email);
			 
			 $zvern = stripslashes($data['zvern']);
			 $zvern = htmlspecialchars($zvern);

			 $prymitka = stripslashes($data['prymitka']);
			 $prymitka = htmlspecialchars($prymitka);

			 $address = stripslashes($data['address']);
			 $address = htmlspecialchars($address);

			 $date = stripslashes($data['date']);
			 $date = htmlspecialchars($date);

			 $time = stripslashes($data['time']);
			 $time = htmlspecialchars($time);

			 //удаляем лишние пробелы
		   	$fname = trim($fname);
		    $telephone = trim($telephone);
		    $address = trim($address);
 			$zvern = trim($zvern);
 			$prymitka = trim($prymitka);

 			$date = trim($date);
 			$date = strtotime($date); // переводит из строки в дату
			$date = date("Y-m-d", $date); // переводит в новый формат

 			$time = trim($time);
 			$email = trim($email);

 			$date_unix = strtotime($date);


// проверка формы на пустоту полей
		if ($date == '')
		{
			$errors[] = 'Введіть дату прийому';
		}

		if ($time == '')
		{
			$errors[] = 'Введіть час прийому';
		}

		if ($fname == '')
		{
			$errors[] = "Введіть повне ім'я";
		}

		if ($zvern == '')
		{
			$errors[] = 'Введіть тип зверенення';
		}

		if ($address == '')
		{
			$errors[] = 'Введіть адресу проживання';
		}

		if ($telephone == '')
		{
			$errors[] = 'Введіть номер телефону';
		}
		if ($data['checkbox'] !== 'on')
		{
			$errors[] = 'Підтвердіть обробку данних';
		}
		if ($email == '')
		{
			$errors[] = 'Введіть email';
		}
    

//Проверка на длинну полей 
  //
 	if(strlen($date) > 10){
 		$errors[] = 'Неправильний формат дати';
 	}
 	if(strlen($time) > 5){
 		$errors[] = 'Неправильний формат часу';
 	}
 	if(mb_strlen($fname) > 50){
 		$errors[] = 'Перевищена допустима кількість символів в ПІБ';
 	}
	if(strlen($zvern) > 30){
 		$errors[] = 'Неправильний формат типу звернення';
 	}
	if(mb_strlen($prymitka) > 100){
 		$errors[] = 'Перевищена допустима кількість символів в зверненні';
 	}
	if(mb_strlen($address) > 100){
 		$errors[] = 'Перевищена допустима кількість символів в адресі';
 	}
	if(strlen($telephone) > 17){
 		$errors[] = 'Перевищена допустима кількість символів в телефоні';
 	}
	if(strlen($email) > 100){
 		$errors[] = 'Перевищена допустима кількість символів в email';
 	}


	
//Проверка на запрещенные символы
//
		if(!preg_match("/[a-zA-Zа-яА-ЯїЇіІєЄ]/u", $fname))
		{
			$errors[] = "Введені недопустимі символи в імені";
		}
		if(!preg_match("/[0-9\+]/", $telephone))
		{
			$errors[] = "Введені недопустимі символи телефону";
		}
		if(!preg_match("/[a-zA-Za-яА-ЯЇїІієЄ0-9-_,\.]/", $address))
		{
			$errors[] = "Введені недопустимі символи в адресі";
		}
		if(!preg_match("/[\pL]/", $zvern))
		{
			$errors[] = "Неправильно введено тип звернення";
		}
		if(!empty($prymitka_main)){
			if(!preg_match("/[a-zA-Za-яА-ЯЇїІієЄ0-9-_,\.]/", $prymitka))
			{
				$errors[] = "Недопустимі символи в примітці";
			}
		}
		if(!preg_match("/\d[:]/", $time))
		{
			$errors[] = "Неправильно введено час";
		}
		if(!preg_match("/\d[-]/", $date))
		{
			$errors[] = "Неправильно введено дату";
		}
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email))
		{	
			$errors[] = "Введені недопустимі символи в email";
		}

//проверка на время
		if($time < "08:00" || $time > "17:00"){
			$errors[] = "Помилка в виборі часу";
		}
//проверка на дату
		$datefuture = strtotime("+2 month", $datenow_unix );

		if($date_unix  < $datenow_unix or $date_unix > $datefuture){
			$errors[] = "Помилка в виборі дати";
		}

//перевірка на занятість в зазначений час
		$timequeue =  R::find('busy', ' timequeue = ? AND dataqueue = ? AND services_type_slug = ?', array($time, $date, "subs"));
		$count = 0;
		foreach ($timequeue as $key => $counttime) {
			if($counttime->timequeue == $time){
				$count++;
			}
		}

		if($count >= 3){
			$errors[] = 'На цей час занято';
		}

	
   	$access_email = array("test1@ukr.net", "test2@ukr.net", "test3@ukr.net");

   foreach ($access_email as &$count_email) {

   		 	if($email !== $count_email){
   		 		$not_allow_email = "";
   		 		
   		 }else{
   		 	$allow_email = "";
   		 	break;
   		 }
   	}

	if(!isset($allow_email)){
				$iduser = R::findOne('people' , 'access = ? AND email = ?', array(1,$email));
   		 		$iduser = $iduser->id;	
   				$count_people = R::count('busy', 'clientid = ? AND services_type_slug = ?', array($iduser, "subs"));

   			if($count_people >= 3){
			$errors[] = "Помилка: 'Ви використали максимальну кількість реєстрацій в черзі'";
			}
	}

if (empty($errors)){
			//Дата регистрации
				$tz = 'Europe/Kiev';
				$timestamp = time();
				$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
				$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
				$datetimereg = $dt->format('Y-m-d H:i:s');
			 
			//Подтверждение по email
				for($i=0;$i<5;$i++){
          		$gen = mt_rand(0,9);
          		$code[] =  $gen;
        		}
       	 		$code_mail = implode('', $code);
       	 		
  $check_user = R::findOne('people', 'email = ?', array($email));
	
if(!$check_user){
			$people = R::dispense('people');
			$people->fname = $fname;
			$people->telephone = $telephone;
			$people->email = $email;
			$people->address = $address;
			$people->datetimereg = $datetimereg;
			$people->accessmail = $code_mail;
			$people->access = 0;
			R::store($people);
}else{

	 R::exec( 'UPDATE people SET access = 0, accessmail = ? WHERE email = ?', array($code_mail, $email));
}
		
			require 'send_access_mail.php';


		}else
		{
			echo '<h1 style="text-align:center;color:red;" id="errors" >' .array_shift($errors). '</h1><hr>';
		}

	}//isset(submit)
	

 ?>