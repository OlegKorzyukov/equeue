<?php
// Файлы phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'composer/vendor/autoload.php';

$mail = new PHPMailer(true); // Создаем экземпляр класса PHPMailer


$__smtp = array(
    "host" => '', // SMTP сервер
    "debug" => 0, // Уровень логирования
    "auth" => true, // Авторизация на сервере SMTP. Если ее нет - false
    "port" => '', // Порт SMTP сервера
    "username" => '', // Логин запрашиваемый при авторизации на SMTP сервере
    "password" => '', // Пароль
    "addreply" => '', // Почта для ответа
    "secure" => 'ssl', // Тип шифрования. Например ssl или tls
    "mail_title" => 'Запис на прийом', // Заголовок письма
    "mail_name" => 'УПРАВЛІННЯ ПРАЦІ ТА СОЦІАЛЬНОГО ЗАХИСТУ НАСЕЛЕННЯ ВИКОНАВЧОГО КОМІТЕТУ РАЙОННОЇ РАДИ', // Имя отправителя
    "add_address" => $email,
    "msg_mail_form" => $msg_mail_form
); 


try{
    $mail = new PHPMailer(true); // Создаем экземпляр класса PHPMailer

    $mail->IsSMTP(); // Указываем режим работы с SMTP сервером
    $mail->Host       = $__smtp['host'];  // Host SMTP сервера: ip или доменное имя
    $mail->SMTPDebug  = $__smtp['debug'];  // Уровень журнализации работы SMTP клиента PHPMailer
    $mail->SMTPAuth   = $__smtp['auth'];  // Наличие авторизации на SMTP сервере
    $mail->Port       = $__smtp['port'];  // Порт SMTP сервера
    $mail->SMTPSecure = $__smtp['secure'];  // Тип шифрования. Например ssl или tls
    $mail->CharSet="UTF-8";  // Кодировка обмена сообщениями с SMTP сервером
    $mail->Username   = $__smtp['username'];  // Имя пользователя на SMTP сервере
    $mail->Password   = $__smtp['password'];  // Пароль от учетной записи на SMTP сервере

    $mail->SetFrom($__smtp['username'], 'УПРАВЛІННЯ ПРАЦІ ТА СОЦІАЛЬНОГО ЗАХИСТУ НАСЕЛЕННЯ ВИКОНАВЧОГО КОМІТЕТУ РАЙОННОЇ РАДИ');  // Адресант почтового сообщения
    $mail->AddAddress($__smtp['add_address']);  // Адресат почтового сообщения

   //  $mail->AddReplyTo($__smtp['addreply'], 'First Last');  Альтернативный адрес для ответа


    // Attachments
    $mail->addAttachment($road_file, '');    // Optional name

    
    $mail->Subject = htmlspecialchars($__smtp['mail_title']);  // Тема письма
    $mail->MsgHTML($__smtp['msg_mail_form']); // Текст сообщения
    $mail->Send();

    return 1;
  } catch (Exception $e) {
    return $e->errorMessage();
}
?>
