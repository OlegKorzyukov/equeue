$(document).ready(function(){
 

//Параметры выводы ошибок в notify.js
$.notify.defaults({
	arrowSize: 8,
	autoHideDelay: 2500,
	globalPosition: 'top'
});

function CheckDate(){

//Вычисление ограничения на максимально возможную дату записи
var now = new Date();
//var formated_date = now.format("dd.mm.yyyy");
var nowYearUp = now.getFullYear()+1;
var nowMonthUp = now.getMonth()+2;
var nowDay = ("0" + now.getDate()).slice(-2);

if((now.getMonth()+1) == 12){
	nowMonthUp = 01; //first month new year
	var maxdate =  nowYearUp + '-' + nowMonthUp + '-31';	
}else{
	if(nowDay >= "10"){
		var maxdate =  now.getFullYear() + '-' + ("0" + nowMonthUp).slice(-2) + '-31';
	}else{
		var maxdate =  now.getFullYear() + '-' + ("0" + (now.getMonth()+1)).slice(-2) + '-31';     
	}	
}

var mindate = "0";
var nowTime =  now.getFullYear() + "-" + ("0" + (now.getMonth()+1)).slice(-2) + '-' + nowDay;

var disDays = [0, 6];

	return {maxdate: maxdate,mindate: mindate,disdays:disDays,disdates:disDates};
}

var values = CheckDate();
var maxdate = values.maxdate;
var mindate = values.mindate;
var disDays = values.disdays;
var disDates = values.disdates;

//Datapicker plugin
 $.datetimepicker.setLocale('uk');
    jQuery('#datetimepicker').datetimepicker({
  format:'Y-m-d',
  formatDate:'Y-m-d',
  minDate: mindate,
  maxDate: maxdate, // maxdate,
  inline: true,
  timepicker: false,
  lang:'uk',
  dayOfWeekStart: 1,
  disabledWeekDays: disDays,
  scrollMonth: false,
  disabledDates: ['2021-05-03', '2021-05-04', '2021-05-10']
});

//Вывод времени в зависимости от занятости
function datatimepickerl(){

  jQuery('#timetimepicker').datetimepicker({
  format:'H:i',
  inline: true,
  datepicker: false,
  minTime: '8:00',
  maxTime: '17:00',
  allowTimes: window.freetime //time from main.js
});
}


//Присвоение выбраной даты в календаре и типа обращения
$('#accept_date').click(function freeTime(){
	var datetimepicker = $('#datetimepicker').val().trim();
	
//Скрытие кнопки и показ следующих блоков, проверка на символы
if(datetimepicker !== ""){
		function validateData(datetimepicker) {
		var dt = /[\d-]{1,20}$/;
 		 return dt.test(datetimepicker);
	}

	if(!validateData(datetimepicker)){
		$(".date_input").notify("Помилка в даті прийому",{position:"right middle"});
}else{	
//Вывод свободного времени с check_date.php
	$.ajax({
  method: "POST",
  url: "check_date.php",
  dataType: "json",
  data: { date: JSON.stringify(datetimepicker)}
}).done(function ( msg ) {
		var msg_new = [];
		for(var i=0; i<msg.length; i++){
			msg_new.push(msg[i]);
		}
		window.freetime = msg_new;
		datatimepickerl(window.freetime);
  });
	$('.time_input').css("display", "block");
	$('#accept_date').css("display", "none");

}
}else {
	$(".date_input").notify("Виберіть дату",{position:"right middle"});
}
});


//Скрытие блоков при смене даты
$(datetimepicker).change(function(){
	$('#accept_date').css("display", "block");
	$('.time_input').css("display", "none");
	$('#accept_time').css("display", "block");
	$('.main-input').css("display", "none");
});

//Проверка времени 
$('#accept_time').click(function (){
	 var timetimepicker = $('#timetimepicker').val().trim();

	if(timetimepicker !== ""){
		
		function validateTime(timetimepicker) {
		var tm = /[\d:]{2,8}$/;
 		 return tm.test(timetimepicker);
		}
		if(!validateTime(timetimepicker)){
			
			$(".time_input").notify("Помилка в часі прийому",{position:"right middle"});
		}else{
			$('.main-input').css("display", "block");
			$('.license').css("display", "block");
			$('.button_submit').css("display", "block");
			$('#accept_time').css("display", "none");
		}
}else {
	$(".time_input").notify("Введіть час прийому",{position:"right middle"});
}
});


// При клике на кнопку *Записатись на прийом*
$('#formsubmit').click(function (){
		var errors = [];
		var datetimepicker = $('#datetimepicker').val().trim();
		var timetimepicker = $('#timetimepicker').val().trim();
		var full_name = $('#full_name').val().trim();
		var zvern_type = $('#zvern_type').val().trim();
		var prymitka = $('#prymitka').val().trim();
		var address = $('#address').val().trim();
		var telephone =  $('#telephone').val().trim();
		var email = $('#email').val().trim();
		var checkbox = $('#checkbox').val();
		var formsubmit = $('#formsubmit').val().trim();


if(full_name !== ""){
		function validateName(full_name) {
		var nam = /[a-zA-Zа-яА-ЯїЇіІєЄ\s]{2,200}$/;
 		 return nam.test(full_name);
		}
		if(!validateName(full_name)){
			errors = "Недопустимі символи в імені";
			$("#full_name").notify("Недопустимі символи в імені",{position:"right top"});
		}
}else {
	errors = "Введіть ПІБ";
	$("#full_name").notify("Введіть ПІБ",{position:"right top"});
}


if(zvern_type !== ""){
		function validateZvern(zvern_type) {
		var zvr = /[a-яА-Я]{8}$/;
 		return zvr.test(zvern_type);
		}
			if(!validateZvern(zvern_type)){
				errors = "Помилка в виборі звернення";
				$("#zvern_type").notify("Помилка в виборі звернення",{position:"right top"});
			}
}else {
	errors = "Помилка в виборі звернення";
	$("#zvern_type").notify("Помилка в виборі звернення",{position:"right top"});
}

if(prymitka !== ""){
	function validateZmist(prymitka){
		var pry = /[a-яА-Я0-9їЇіІєЄ_\-\s\.\,]{4,400}$/;
		return pry.test(prymitka);
	}
	if(!validateZmist(prymitka)){
		errors = "Недопустимі символи в примітці";
		$("#prymitka").notify("Недопустимі символи в примітці", {position: "right top"});
	}
}

if(address !== ""){
		function validateAddress(address) {
		var zvr = /[a-яА-Я0-9їЇієЄІ_\-\s\.\,]{4,200}$/;
 		 return zvr.test(address);
	}
	if(!validateAddress(address)){
		errors = "Недопустимі символи в адресі";
		$("#address").notify("Недопустимі символи в адресі",{position:"right top"});
	 }
}else {
	errors = "Введіть адресу";
	$("#address").notify("Введіть адресу",{position:"right top"});
}


if(telephone !== ""){
		
		function validateTelephone(telephone) {
		var tl = /[\d(\)\s+]{4,12}$/;
 		 return tl.test(telephone);
	}
	if(!validateTelephone(telephone)){
		errors = "Недопустимі символи в телефоні";
		$("#telephone").notify("Недопустимі символи в телефоні",{position:"right top"});
	}
}else {
	errors = "Введіть номер телефону";
	$("#telephone").notify("Введіть номер телефону",{position:"right top"});
}


if(email !== ""){
		
		function validateEmail(email) {
		var em = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
 		 return em.test(email);
	}
	if(!validateEmail(email)){
		errors = "Недопустимі символи Email";
		$("#email").notify("Недопустимі символи Email",{position:"right top"});
	}
}else{
	errors = "Введіть email";
	$("#email").notify("Введіть email",{position:"right top"});
}


 if($('#checkbox').prop('checked') == false){
 	errors = "Підтвердіть обробку даних";
 	$(".license").notify("Підтвердіть обробку даних",{position:"left top"});
 }



if(errors.length !== 0){
	alert("Введіть всі дані");
}
else{
	$("#formsubmit").remove();
			$.post("check_form.php", 
			{
			 date: datetimepicker,
			 time: timetimepicker,
			 fname: full_name,
			 zvern: zvern_type,
			 prymitka: prymitka,
			 address: address,
			 telephone: telephone,
			 email: email,
			 checkbox: checkbox,
			 submit : formsubmit,
			}, 
				function (data){
				$('#result').html(data);
					if(!$("h1").is("#errors")){
						$(".license").append("<div class='check_reg'><p>Код підтвердження відправлено на пошту "+email+", введіть його в полі нижче, та натисніть кнопку 'Підтвердити пошту'</p><input  type='text' name='code_reg' class='code_reg' id='code_reg' maxlength='5' minlength ='5' required><input  type='button' name='button_reg' class='button_reg' id='button_reg' value='Підтвердити пошту'></div>");
					}
					var checkreg = $('#code_reg');
					var button_reg = $('#button_reg');
					
					Reg(checkreg, button_reg);
			});


function Reg(){
	$('#button_reg').click(function (){
				
				var checkreg = $('#code_reg').val().trim();
				var button_reg = $('#button_reg').val();

				if(checkreg !== ''){
				$.post("check_access.php", 
				{	
					 date: datetimepicker,
					 time: timetimepicker,
					 fname: full_name,
					 zvern: zvern_type,
					 prymitka: prymitka,
					 address: address,
					 telephone: telephone,
					 email: email,
			 		 codereg : checkreg,
			 		 butreg : button_reg
				}, 
				function(data){
					//$('#result').html(data);
					$('#result').html(data);

					if(!$("h1").is("#errorcode")){
						$('.check_reg').remove();
						localStorage.setItem('history', data);
					}

					
				});

			}else{
				$(".code_reg").notify("Введіть код підтвердження",{position:"left top"});
			}
	});

};	

}
	});//click

//История прошлых записей, сохранение в localstorage
$('#show_history').click(function(){
	var he = localStorage.getItem('history');

	if(he){
		$("#form").append(`<div id='history_block'>${he}</div>`);
		$(".accept_queue").css("display","none");
		if ($('#history_block').css('display') == 'none') 
        { 
            $('#history_block').css('display','block');
            $("#form").append(`<div id='history_block'>${he}</div>`);
            $("#show_history").html('<a href="#show_history" id="show_history">Сховати ваші попередні записи на прийом</a>');
        }
        else{
        	$('#history_block').css('display','none');
        	$("#show_history").html('<a href="#show_history" id="show_history">Показати ваші попередні записи на прийом</a>');
        }

	}else{
		
		if(!$("div").is("#none_history")){
			$("#form").append(`<div id='none_history'>Немає попередніх записів</div>`);
		}
	}


});

});