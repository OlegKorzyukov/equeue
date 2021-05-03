<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>УПРАВЛІННЯ ПРАЦІ ТА СОЦІАЛЬНОГО ЗАХИСТУ НАСЕЛЕННЯ ВИКОНАВЧОГО КОМІТЕТУ РАЙОННОЇ РАДИ</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="libs/js/jquery-3.3.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="libs/css/jquery.datetimepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="libs/css/style.css"/>
<link rel="stylesheet" type="text/css" href="libs/css/responsive.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<script src="libs/js/jquery.datetimepicker.full.min.js"></script>
<script src="libs/js/jquery.maskedinput.js"></script>
<script src="libs/js/notify.min.js"></script>
<script src="libs/js/main.js"></script>

</head>

<body>
<div class="main">


<header id="header">
  <div class="icon">
    <img src="26711553251274.gif" alt="">
  </div>
  <div class="title-page">
    <h1>УПРАВЛІННЯ ПРАЦІ ТА СОЦІАЛЬНОГО ЗАХИСТУ <br/> НАСЕЛЕННЯ ВИКОНАВЧОГО КОМІТЕТУ<br/> РАЙОННОЇ РАДИ</h1>
  </div>
  <div class="contact">
    <div class="icon-contact">
      <a href="mailto:test@gmail.com"><i class="fas fa-envelope-open"></i></a>
      <a href="tel:(0999) 99-99-99"><i class="fas fa-phone"></i></a>
    </div>
  </div>
</header>
			
<section>
    <div class="form">
        <div class="main-form"> 
            <form id="form" class="main_form" name="main_form">
                <div class="main-input-date">
                	<h2>Запис на оформлення субсидії</h2>
                    <div class="main-date">
	                    <div class="date_input">
	                            <div class="title"><h3>1. Крок. Виберіть дату прийому</h3></div>
	                            <input type="text" name="date" id="datetimepicker" required />
                              <input type="button" name="button_date" id="accept_date" value="Підтвердити дату прийому">
	                    </div>
	                    <div class="time_input">
	                            <div class="title"><h3>2. Крок. Виберіть час прийому</h3></div>
	                            <input type="time" name="time" id="timetimepicker" required/>
                              <input type="button" name="button_time" id="accept_time" value="Підтвердити час прийому">
	                    </div>
					</div>

                    <div class="main-input">
                      <div class="title"><h3>3. Крок. Заповніть контактну форму </h3><span>(Всі поля обов'язкові для заповнення)</span></div>
                        
                        <div>
                            <label for="full_name">Прізвище ім’я по батькові</label>
                            <input type="text" name="fname" class="full_name" id="full_name" maxlength="50" required>
                        </div>

                        <div>
                            <label for="zvern_type">Звернення</label>
                            <select name="zvern" class="zvern_type" id="zvern_type" required>
                              <option>Первинне</option>
                              <option>Вторинне</option>
                            </select>
                        </div>
                        <div class="prymitka_main">
                          <label for='prymitka'>Примітки</label>
              <textarea type="text" name='prymitka' class="prymitka" id='prymitka' maxlength="100" required></textarea>
                        </div>
                        <div>
                            <label for="address">Адреса реєстрації</label>
                            <input type="text" name="address" class="address" id="address" maxlength="100" required>
                        </div>

                        <div>
                            <label for="telephone">Телефон</label>
                            <input type="tel" name="telephone" class="telephone" id="telephone" placeholder="+38( )" required>
                        </div>

                        <div>
                            <label for="email">Електронна пошта</label>
                            <input type="email" name="email" class="email" id="email" maxlength="100">
                        </div>
                    
                    
                    <div class="license">
                        <input type="checkbox" name="checkbox" id="checkbox" checked="checked" required>
                        <label for="checkbox">Даю згоду на обробку, використання та зберігання моїх персональних даних</label>
                    </div>
                    
                   <!-- <div class="capcha">
                        <input data-validation="recaptcha" data-validation-recaptcha-sitekey="[RECAPTCHA_SITEKEY]">
                    </div>-->
                    <!-- Ответ на регистрацию   -->
                      <div id="result"></div>


                    <div class="button_submit">
                         <input id = "formsubmit" type="button" name="submit" value="ЗАПИСАТИСЬ НА ПРИЙОМ">
                    </div>
                </div>
                </div>
            </form> 
  
      <div class="main_history">
        <a href="#show_history" id="show_history">Показати ваші попередні записи на прийом</a>
      </div>
        </div>
    </div>
    
</section> 
<footer>
  <div class="main-footer">
  	<div class="my-row">
 	<div class="col-6">

 	</div>
 	<div class="col-6">
		<div class="creator">
			<div class="main-creator">
			<a href=""><img src="" alt="">Розробка та підтримка сервісу, <?php echo date("Y") . " р"; ?>
				</div>
		</div>
 	</div>
 </div>
  </div>
</footer>

</div>


<script type="text/javascript">
    $(function() {
        $("#telephone").mask("+38(999) 999-9999");
    });
  
</script>

</body>
</html>
