<?php 
include 'db.php';
//R::freeze( TRUE );

if(isset($_POST['butreg'])){

$data = $_POST;
			
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

 			//Код на очередь
			function codequeue(){
				
				for($i=0;$i<5;$i++){
          		$gen = mt_rand(0,9);
          		$code[] =  $gen;
        		}
       	 		$codequeue =  implode('', $code);

       	 		//Проверка на повторения кода
       	 		$coderepeat = R::find('busy', 'codequeue = ?', array($codequeue));
       	 		 if($coderepeat)
       	 			{
       	 				for($i=0;$i<5;$i++){
          					$gen = mt_rand(0,9);
          					$code[] =  $gen;
        					}
       	 					$codequeue =  implode('', $code);
       	 			}

       	 		return $codequeue;
			}

			//Получаем код для сравнения с кодом письма 
			 $codereg = $_POST['codereg'];
			 $codereg = htmlspecialchars($codereg);
			 $codereg = trim($codereg);

         	 $code_mail_bd = R::findOne('people', 'email = ? AND access = ?', array($email, 0));
          	
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
			exit();
		}

          	if($code_mail_bd->accessmail == $codereg){

          	R::exec("UPDATE people SET access= ? WHERE email = ?" , array(1,$email));

          	$iduser = R::findOne('people' , 'access = ? AND email = ?', array(1,$email));
          	$iduser = $iduser->id;	

						$head_mail = 'УПРАВЛІННЯ ПРАЦІ ТА СОЦІАЛЬНОГО ЗАХИСТУ НАСЕЛЕННЯ <br/> РАЙОННОЇ РАДИ';
						$address_mail = 'вул.Шевченка';
						$workplacethree = ['12:00', '12:30'];
						$onetwoworkplace = ['13:00', '13:30'];
						$resultWorkTime = array_merge ($workplacethree, $onetwoworkplace);
						$Worker = ['Робоче місце № 1', 'Робоче місце № 2', 'Робоче місце № 3'];


							$countTime = R::count('busy', 'timequeue = ? AND dataqueue = ? AND services_type_slug = ?', array($time, $date, 'subs'));

// Установка времени на основное время

							foreach($resultWorkTime as &$val){
								if($time == $val){
									$checkTime = '';
								}
							}
							
							if(!isset($checkTime)){

								if( $countTime != 0 ){
									$checkCol = R::find('busy', 'timequeue = ? AND dataqueue = ?', array($time, $date));
								
								foreach( $checkCol as $key => $value){
										if($value->workplace == $Worker[0]){
											$WorkPlace = $Worker[1];
										}
										if($value->workplace == $Worker[1]){
											$WorkPlace = $Worker[2];
										}
										if($value->workplace == $Worker[2]){
											$WorkPlace = $Worker[0];
										}
									}
								}

					$Place1 = array('08:30','10:00','11:30','15:00');
					$Place2 = array('09:00','10:30','14:00','15:30');
					$Place3 = array('09:30','11:00','14:30');

								if( $countTime == 0){

									foreach($Place1 as $value){
										if($time == $value){
											$WorkPlace = $Worker[0];
										}
									}
									foreach ($Place2 as $value) {
										if($time == $value){
											$WorkPlace = $Worker[1];
										}
									}
									foreach ($Place3 as $value) {
										if($time == $value){
											$WorkPlace = $Worker[2];
										}
									}
								}

							}

//Установка очереди на время 13:00 и 13:30
//
//
//
							foreach($onetwoworkplace as &$val){
								if($time == $val){
									$checkTimeonetwo = '';
								}
							}

				if(isset($checkTimeonetwo)){		
						
						if( $countTime == 0 ){

							if($time == '13:00'){
								$WorkPlace = $Worker[0];
							}
							if($time == '13:30'){
								$WorkPlace = $Worker[1];
							}
							
						}else if( $countTime != 0 ){
							$checkCol = R::find('busy', 'timequeue = ? AND dataqueue = ?', array($time, $date));
							foreach( $checkCol as $key => $value){
										if($value->workplace == $Worker[0]){
											$WorkPlace = $Worker[1];
										}
										if($value->workplace == $Worker[1]){
											$WorkPlace = $Worker[0];
										}
									}
								}
						}


//Установка 3-й очереди для времени 12:00, 12:30
//
								foreach($workplacethree as $tval){
									if($time == $tval){
										$WorkPlace = $Worker[2];
									}
								}


			//Дата регистрации
							$tz = 'Europe/Kiev';
							$timestamp = time();
							$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
							$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
							$datetimereg = $dt->format('Y-m-d H:i:s');
          					
          					$busy = R::dispense('busy');
          					$busy->services_type = "Запис на оформлення субсидії";
          					$busy->services_type_slug = "subs";
							$busy->type = $zvern;
							$busy->prymitka = $prymitka;
							$busy->workplace = $WorkPlace;
							$busy->timequeue = $time;
							$busy->dataqueue = $date;
							$busy->date_unix = $date_unix;
							$busy->codequeue = codequeue();
							$busy->clientid = $iduser;
							R::store($busy);

							$history = R::dispense('history');
							$history->h_fname = $fname;
							$history->h_telephone = $telephone;
							$history->h_email = $email;
							$history->h_address = $address;
							$history->h_datetimereg = $datetimereg;
							$history->h_codequeue = $busy->codequeue;
							$history->h_type = $busy->type;
							$history->h_prymitka = $busy->prymitka;
							$history->h_workplace = $WorkPlace;
							$history->h_services_type = $busy->services_type;
							$history->h_timequeue = $busy->timequeue;
							$history->h_dataqueue = $busy->dataqueue;
							$history->h_clientid = $busy->clientid;
							$history->h_notes = Null;
							R::store($history);

							
							require 'libs/create_pdf.php';

							$msg_mail_form = '<h1 class="accept_queue" style="color:green;text-align:center;">Вас успішно зареєстровано в електронній черзі!</h1><hr>
								<div style="display: flex;justify-content: center;align-items: center;">
								<div style="width: 700px;background: #E8E9E3;padding: 10px 5px;">
								<p style="text-align: center; color: #000;margin: 0;">' .$head_mail. '</p>
								<p style="text-align:center; color: #000;margin: 0;">' .$address_mail. '</p>
									<p ><h1 style="text-align: center; font-size: 60px;margin: 0;">' . $busy->codequeue . '</h1></p>
									<div style="display: flex;margin-bottom: 20px;">
										<table style="width: 100%;font-size: 18px;">
								  			<tr>
								   				<td>Тип прийому</td>
								   				<td style="text-align: center;">' . $busy->services_type . '</td>
								  			</tr>
								  			<tr>
								   				<td>Дата прийому</td>
								   				<td style="text-align: center;">' . $busy->dataqueue . '</td>
								  			</tr>
								  			<tr>
								   				<td>Час прийому</td>
								   				<td style="text-align: center;">' . $busy->timequeue . '</td>
								  			</tr>
								  			<tr>
								   				<td>Прізвище ім’я по батькові</td>
								   				<td style="text-align: center;">' .  $fname . '</td>
								  			</tr>
								  			<tr>
								   				<td>Адреса реєстрації</td>
								   				<td style="text-align: center;">' .  $address . '</td>
								  			</tr>
								  			<tr>
								   				<td>Примітки</td>
								   				<td style="text-align: center;">' .  $prymitka . '</td>
								  			</tr>
								  			<tr>
								   				<td>Телефон</td>
								   				<td style="text-align: center;">' . $telephone . '</td>
								  			</tr>
								  			<tr>
								   				<td>Зареєстровано</td>
								   				<td style="text-align: center;">' . $datetimereg . '</td>
								  			</tr>
								  			<tr>
								   				<td style="text-align:center; margin-top: 15px;" colspan="2">'. $WorkPlace .'</span>
								  			</tr>
								  			<tr>
								   				<td style="text-align:center" colspan="2"><a download href="'.$road_file.'">Завантажити талон</a></td>
								  			</tr>
										</table>
									</div>
								</div>
								</div>';

							echo $msg_mail_form;
							require 'send.php';


          	$user_check_reg = R::findOne('people', 'email = ? AND access = ?', array($email, 1));

          }elseif($user_check_reg){

          	echo "Ви вже підтвердили email";

          }elseif($code_mail_bd->accessmail !== $codereg){

          	//R::trash($code_mail_bd);
          	echo "<h1 style='text-align:center;color:red;' id='errorcode' >Неправильний код</h1><hr>";
          
          }
}

?>