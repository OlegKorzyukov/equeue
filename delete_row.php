<?php 


$datenow = date("Y-m-d");
$datenow_unix = strtotime($datenow);

R::exec(" DELETE busy, people FROM busy INNER JOIN people WHERE busy.clientid = people.id AND busy.dataqueue < ? ", array($datenow));

 ?>